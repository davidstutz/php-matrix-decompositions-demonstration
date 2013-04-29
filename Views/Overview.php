<!DOCTYPE html>
<html>
	<head>
		<title><?php echo __('Matrix Decompositions - Overview'); ?></title>
		<script type="text/javascript" src="Assets/jquery.min.js"></script>
		<script type="text/javascript" src="Assets/bootstrap.min.js"></script>
		<script type="text/javascript" src="https://c328740.ssl.cf1.rackcdn.com/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML"></script>
		<script type="text/javascript" src="Assets/prettify.js"></script>
		<script type="text/x-mathjax-config">
			MathJax.Hub.Config({
			  tex2jax: {inlineMath: [['$','$'], ['\\(','\\)']]}
			});
		</script>
		<script type="text/javascript">
			$(document).ready(function() {
				window.prettyPrint() && prettyPrint();
			});
		</script>
		<link rel="stylesheet" type="text/css" href="Assets/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="Assets/prettify.css">
	</head>
	<body>
		<div class="container">
			<div class="page-header">
				<h1><?php echo __('Matrix Decompositions'); ?></h1>
			</div>
			
		    <ul class="nav nav-pills">
			    <li class="active"><a href="#"><?php echo __('Problem Overview'); ?></a></li>
          <li><a href="/matrix-decompositions<?php echo $app->router()->urlFor('basics'); ?>"><?php echo __('Basics'); ?></a></li>
			    <li><a href="/matrix-decompositions<?php echo $app->router()->urlFor('lu'); ?>"><?php echo __('LU Decomposition'); ?></a></li>
			    <li><a href="/matrix-decompositions<?php echo $app->router()->urlFor('qr'); ?>"><?php echo __('QR Decomposition'); ?></a></li>
			    <li><a href="/matrix-decompositions<?php echo $app->router()->urlFor('credits'); ?>"><?php echo __('Credits'); ?></a></li>
		    </ul>
			
			<p>
				<?php echo __('In computer science a lot of applications lead to the problem of solving systems of linear equations. In linear algebra the problem is specified as follows:'); ?>
			</p>
			
			<p>
				<b><?php echo __('Problem.'); ?></b> <?php echo __('Given $A \in \mathbb{R}^{n \times n}$ and $b \in \mathbb{R}^n$. Find $x \in \mathbb{R}^n$ such that $Ax = b$.'); ?>
			</p>
			
			<p>
				<?php echo __('In this experiment we want to examine some numerical methods to solve this problem implemented in PHP.'); ?>
			</p>
			
			<p>
				<?php echo __('If $A$ is regular following statements hold:'); ?>
				<ul>
					<li><?php echo __('$det(A) \neq 0$'); ?></li>
					<li><?php echo __('The system $Ax = b$ has a single unique solution for each $b \in \mathbb{R}^n$.'); ?></li>
					<li><?php echo __('The matrix $A$ has full rank: $rank(A) = n$.'); ?></li>
				</ul>
			</p>
			
			<p>
				<b><?php echo __('Code.'); ?></b>
				<?php echo __('For working with matrices and vectors using PHP the following classes will be used. I know there are already many solutions of data structures for matrices and vectors, and they will most likely be more efficient or more flexible then these, but for demonstrating common used matrix deocmpositions the given classes will most likely do their jobs.'); ?>
			</p>
			
			<div class="tabbable">
				<ul class="nav nav-tabs">
					<li class="active"><a href="#matrix" data-toggle="tab"><?php echo __('Matrix Class'); ?></a></li>
					<li><a href="#vector" data-toggle="tab"><?php echo __('Vector Class'); ?></a></li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="matrix">
						<pre class="prettyprint linenums">
/**
 * Matrix class.
 *
 * @author  David Stutz
 */
class Matrix {
   	
	/**
	 * @var	array 	data
	 */
	private $_data;
	
	/**
	 * @var	int	rows
	 */
	private $_rows;
	
	/**
	 * @var	int	columns
	 */
	private $_columns;
	
	/**
	 * Constructor.
	 * 
	 * @param	int		rows
	 * @param	int		columns
	 * @return	matrix	matrix
	 */
	public function __construct($rows, $columns) {
		$this->_data = array();
		
		$rows = (int)$rows;
		Matrix::_assert($rows > 0);
		
		$columns = (int)$columns;
		Matrix::_assert($columns > 0);
		
		$this->_rows = (int)$rows;
		$this->_columns = (int)$columns;
	}
	
	/**
	 * Resizes the dimensions of the matrix.
	 * 
	 * @param	int		rows
	 * @param	int		columns
	 * @return	matrix	this
	 */
	public function resize($rows, $columns) {
		$this->rows = (int)$rows;
		$this->_columns = (int)$columns;
		
		return $this;
	}
	
	/**
	 * Compares the matrix with the given matrix for equality.
	 * 
	 * @param	matrix	matrix
	 * @return	boolean	equals
	 */
	public function equals($matrix) {
		Matrix::_assert($matrix instanceof Matrix);
		Matrix::_assert($this->_rows == $matrix->rows());
		Matrix::_assert($this->_columns = $matrix->columns());
		
		for ($i = 0; $i < $this->_rows; $i++) {
			for ($j = 0; $j < $this->_columns; $j++) {
				if ($matrix->get($i, $j) != $this->get($i, $j)) {
					return FALSE;
				}
			}
		}
		
		return TRUE;
	}
	
	/**
	 * Get number of rows.
	 * 
	 * @return	int	rows
	 */
	public function rows() {
		return $this->_rows;
	}
	
	/**
	 * Get number of columns.
	 * 
	 * @return	int	columns
	 */
	public function columns() {
		return $this->_columns;
	}
	
	/**
	 * Get the matrix entry on the position specified by $row and $column.
	 * 
	 * @param	int		row
	 * @param	int		column
	 * @param	mixed	value
	 */
	public function get($row, $column) {
		$row = (int)$row;
		$column = (int)$column;
		
		Matrix::_assert($row >= 0 AND $row < $this->_rows);
		Matrix::_assert($column >= 0 AND $column < $this->_columns);
		
		$value = 0;
		if (isset($this->_data[$row])) {
			if (isset($this->_data[$column])) {
				$value = $this->_data[$row][$column];
			}
		}
		
		return $value;
	}
	
	/**
	 * Set the matrix entry on the position specified by $row and $column.
	 * 
	 * @param	int	 	row
	 * @param	int	 	column
	 * @param	mixed	value
	 * @return	matrix	this
	 */
	public function set($row, $column, $value) {
		$row = (int)$row;
		$column = (int)$column;
		
		Matrix::_assert($row >= 0 AND $row < $this->_rows);
		Matrix::_assert($column >= 0 AND $column < $this->_columns);
		
		if (!isset($this->_date[$row])) {
			$this->_data[$row] = array();
		}
		
		$this->_data[$row][$column] = $value;
		
		return $this;
	}
	
	/**
	 * Sets all entries of the matrix to the given value.
	 * 
	 * @param	mixed	value
	 * @return	matrix	this
	 */
	public function setAll($value) {
		for ($i = 0; $i < $this->_rows; $i++) {
			for ($j = 0; $j < $this->_columns; $j++) {
				$this->set($i, $j, $value);
			}
		}
	}
	
	/**
	 * Copy this matrix.
	 * 
	 * @return	matrix	copy
	 */
	public function copy() {
		$matrix = new Matrix($this->rows(), $this->columns());
		
		for ($i = 0; $i < $this->_rows; $i++) {
			for ($j = 0; $j < $this->_columns; $j++) {
				$matrix->set($i, $j, $this->get($i, $j));
			}
		}
		
		return $matrix;
	}
	
	/**
	 * Return the i-th column as vector.
	 * 
	 * @return vector	i-th column
	 */
	public function asVector($column) {
		$vector = new Matrix($this->rows(), $this->columns());
		
		for ($i = 0; $i < $this->_rows; $i++) {
			$vector->set($i, $this->get($i, $column));
		}
		
		return $vector;
	}
	
	/**
	 * Add to matrices.
	 * 
	 * @param	matrix	$a
	 * @param	matrix	$b
	 * @return	matrix	$a + $b
	 */
	public static function add($a, $b) {
		Matrix::_assert($a instanceof Matrix);
		Matrix::_assert($b instanceof Matrix);
		Matrix::_assert($a->rows() == $b->rows());
		Matrix::_assert($a->columns() == $b->columns());
		
		$rows = $a->rows();
		$columns = $a->columns();
		
		$matrix = $a.copy();
		
		for ($i = 0; $i < $rows; $i++) {
			for ($j = 0; $j < $columns; $j++) {
				$matrix->set($i, $j, $matrix->get($i, $j) + $b->get($i, $j));
			}
		}
		
		return $matrix;
	}
	
	/**
	 * Swap the given columns.
	 * 
	 * @param	int	column
	 * @param 	int column
	 * @return	matrix	this
	 */
	public function swapColumns($i, $j) {
		Matrix::_assert($i >= 0 AND $i < $this->rows());
		Matrix::_assert($j >= 0 AND $j < $this->rows());
		
		for ($k = 0; $k < $this->columns(); $k++) {
			$tmp = $this->get($i, $k);
			$this->set($i, $k, $this->get($j, $k));
			$this->set($j, $k, $tmp);
		}
		
		return $this;
	}
	
	/**
	 * Asserts the given expression.
	 * 
	 * @throws	Exception
	 */
	private static function _assert($boolean, $message = '') {
		if (!$boolean) {
			throw new Exception($message);
		}
	}
}
						</pre>
					</div>
					<div class="tab-pane" id="vector">
						<pre class="prettyprint linenums">
/**
 * Vector class.
 *
 * @author  David Stutz
 */
class Vector {
   	
	/**
	 * @var	array 	data
	 */
	private $_data;
	
	/**
	 * @var	int	size
	 */
	private $_size;
	
	/**
	 * Constructor.
	 * 
	 * @param	int		size
	 * @return	vector	vector
	 */
	public function __construct($size) {
		$this->_data = array();
		
		$size = (int)$size;
		$this->_assert($size > 0);
		
		$this->_rows = (int)$size;
	}
	
	/**
	 * Resizes the dimensions of the matrix.
	 * 
	 * @param	int		rows
	 * @param	int		columns
	 * @return	matrix	this
	 */
	public function resize($rows) {
		$this->rows = (int)$rows;
		
		return $this;
	}
	
	/**
	 * Compares the matrix with the given matrix for equality.
	 * 
	 * @param	matrix	matrix
	 * @return	boolean	equals
	 */
	public function equals($vector) {
		$this->_assert($vector instanceof Vector);
		$this->_assert($this->_rows == $vector->size());
		
		for ($i = 0; $i < $this->_rows; $i++) {
			for ($j = 0; $j < $this->_columns; $j++) {
				if ($matrix->get($i, $j) != $this->get($i, $j)) {
					return FALSE;
				}
			}
		}
		
		return TRUE;
	}
	
	/**
	 * Get number of rows.
	 * 
	 * @return	int	rows
	 */
	public function size() {
		return $this->_size;
	}
	
	/**
	 * Get the matrix entry on the position specified by $position.
	 * 
	 * @param	int		position
	 * @param	mixed	value
	 */
	public function get($position) {
		$position = (int)$position;
		
		$this->_assert($position >= 0 AND $position < $this->_size);
		
		$value = 0;
		if (isset($this->_data[$position])) {
			$value = $this->_data[$position];
		}
		
		return $value;
	}
	
	/**
	 * Set the vector entry on the specified $position.
	 * 
	 * @param	int	 	position
	 * @param	mixed	value
	 * @return	matrix	this
	 */
	public function set($position, $value) {
		$position = (int)$position;
		
		$this->_assert($position >= 0 AND $position < $this->_size);
		
		$this->_data[$position]= $value;
		
		return $this;
	}
	
	/**
	 * Sets all entries of the matrix to the given value.
	 * 
	 * @param	mixed	value
	 * @return	matrix	this
	 */
	public function setAll($value) {
		for ($i = 0; $i < $this->_size; $i++) {
			$this->set($i, $value);
		}
	}
	
	/**
	 * Copy this matrix.
	 * 
	 * @return	matrix	copy
	 */
	public function copy() {
		$vector = new Vector($this->size());
		
		for ($i = 0; $i < $this->_rows; $i++) {
			$vector->set($i, $this->get($i));
		}
		
		return $vector;
	}
	
	/**
	 * Swap the given columns.
	 * 
	 * @param	int	column
	 * @param 	int column
	 * @return	matrix	this
	 */
	public function swapColumns($i, $j) {
		Matrix::_assert($i >= 0 AND $i < $this->size());
		Matrix::_assert($j >= 0 AND $j < $this->size());
		
		$tmp = $this->get($i);
		$this->set($i, $this->get($j));
		$this->set($j, $tmp);
		
		return $this;
	}
	
	/**
	 * Build the inner product of two vectors.
	 * 
	 * @param	vector	$a
	 * @param	vector	$b
	 * @return	vector	inner product
	 */
	public static function innerProduct($a, $b) {
		$this->_assert($a instanceof Vector);
		$this->_assert($b instanceof Vector);
		$this->_assert($a->size() == $b->size());
		
		$size = $a->size();
		$result = 0;
		
		for ($i = 0; $i < $size; $i++) {
			$result += $a->get($i)*$b->get($i);
		}
		
		return $result;
	}
	
	/**
	 * Asserts the given expression.
	 * 
	 * @throws	Exception
	 */
	private function _assert($boolean, $message = '') {
		if (!$boolean) {
			throw new Exception($message);
		}
	}
}
						</pre>
					</div>
				</div>
			</div>
			<hr>
			<p>
				<a href="/matrix-decompositions<?php echo $app->router()->urlFor('credits'); ?>"><?php echo __('Credits'); ?></a>
			</p>
		</div>
	</body>
</html>
</html>


