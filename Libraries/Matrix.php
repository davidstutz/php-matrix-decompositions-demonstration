<?php

namespace Libraries;

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
		Matrix::_assert($rows > 0, 'Invalid number of rows given.');
		
		$columns = (int)$columns;
		Matrix::_assert($columns > 0, 'Invalid number of columns given.');
		
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
		Matrix::_assert($matrix instanceof Matrix, 'Given matrix not of class Matrix.');
		Matrix::_assert($this->_rows == $matrix->rows(), 'Matrices do not have same dimensions.');
		Matrix::_assert($this->_columns = $matrix->columns(), 'Matrices do not have same dimensions.');
		
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
		
		Matrix::_assert($row >= 0 AND $row < $this->_rows, 'Tried to access invalid row number.');
		Matrix::_assert($column >= 0 AND $column < $this->_columns, 'Tried to access invalid column number.');
		
		$value = 0;
		if (isset($this->_data[$row])) {
			if (isset($this->_data[$row][$column])) {
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
		
		Matrix::_assert($row >= 0 AND $row < $this->_rows, 'Tried to access invalid row number.');
		Matrix::_assert($column >= 0 AND $column < $this->_columns, 'Tried to access invalid column number.');
		
		if (!isset($this->_data[$row])) {
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
		$column = (int)$column;
		
		Matrix::_assert($column >= 0 AND $column < $this->_columns, 'Tried to access invalid column number.');
		
		$vector = new Matrix($this->rows(), $this->columns());
		
		for ($i = 0; $i < $this->_rows; $i++) {
			$vector->set($i, $this->get($i, $column));
		}
		
		return $vector;
	}
	
	/**
	 * Get the matrix as array.
	 * 
	 * @return	array 	matrix
	 */
	public function asArray() {
		$array = array();
		
		for ($i = 0; $i < $this->rows(); $i++) {
			$array[$i] = array();
			for ($j = 0; $j < $this->columns(); $j++) {
				$array[$i][$j] = $this->get($i, $j);
			}
		}
		
		return $array;
	}
	
	/**
	 * Copy content form array.
	 * 
	 * @param	array 	data
	 * @return	matrix	this
	 */
	public function fromArray($array) {
		Matrix::_assert(is_array($array), 'No array given.');
		
		for ($i = 0; $i < $this->rows(); $i++) {
			for ($j = 0; $j < $this->columns(); $j++) {
				if (isset($array[$i][$j])) {
					$this->set($i, $j, $array[$i][$j]);
				}
			}
		}
		
		return $this;
	}
	
	/**
	 * Swap the given columns.
	 * 
	 * @param	int	column
	 * @param 	int column
	 * @return	matrix	this
	 */
	public function swapColumns($i, $j) {
		Matrix::_assert($i >= 0 AND $i < $this->rows(), 'Tried to access invalid column number.');
		Matrix::_assert($j >= 0 AND $j < $this->rows(), 'Tried to access invalid column number.');
		
		for ($k = 0; $k < $this->columns(); $k++) {
			$tmp = $this->get($i, $k);
			$this->set($i, $k, $this->get($j, $k));
			$this->set($j, $k, $tmp);
		}
		
		return $this;
	}
	
	/**
	 * Add to matrices.
	 * 
	 * @param	matrix	$a
	 * @param	matrix	$b
	 * @return	matrix	$a + $b
	 */
	public static function add($a, $b) {
		Matrix::_assert($a instanceof Matrix, 'Given first matrix not of class Matrix.');
		Matrix::_assert($b instanceof Matrix, 'Given second matrix not of class Matrix.');
		Matrix::_assert($a->rows() == $b->rows(), 'Given matrices do not have same dimensions.');
		Matrix::_assert($a->columns() == $b->columns(), 'Given matrices do not have same dimensions.');
		
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
   * Transpose the given matrix.
   * 
   * @param matrix  matrx to transpose
   * @return  matrix  transposed matrix
   */
  public static function transpose($a) {
    Matrix::_assert($a instanceof Matrix, 'Given matrix is not of class Matrix.');
    
    $transposed = $a->copy();
    
    for ($i = 0; $i < $a->rows(); $i++) {
      for ($j = 0; $j < $a->columns(); $j++) {
        $transposed->set($j, $i, $a->get($i, $j));
      }
    }
    
    return $transposed;
  }
  
  /**
   * Multiply the given matrices.
   * 
   * @param matrix  left matrix
   * @param matrix  right matrix
   * @return  matrix product matrix $a*$b
   */
  public static function multiply($a, $b) {
    // First check dimensions.
    Matrix::_assert($a instanceof Matrix, 'Given first matrix not of class Matrix.');
    Matrix::_assert($b instanceof Matrix, 'Given second matrix not of class Matrix.');
    Matrix::_assert($a->rows() == $b->rows(), 'Given dimensions are not compatible.');
    Matrix::_assert($a->columns() == $b->columns(), 'Given dimensions are not compatible.');
    
    $c = new Matrix($a->rows(), $b->columns());
    $c->setAll(0.);
    
    for ($i = 0; $i < $a->rows(); $i++) {
      for ($j = 0; $j < $a->columns(); $j++) {
        for ($k = 0; $k < $b->rows(); $k++) {
          $c->set($i, $j, $c->get($i, $j) + $a->get($i, $k)*$b->get($k, $j));
        }
      }
    }
    
    return $c;
  }
  
	/**
	 * Generate LU decomposition of the matrix.
	 * 
	 * @param	matrix	matrix to get the lu decomposition of
	 * @return	vector	permutation
	 */
	public static function luDecomposition(&$matrix) {
		Matrix::_assert($matrix instanceof Matrix, 'Given matrix not of class Matrix.');
		Matrix::_assert($matrix->rows() == $matrix->columns(), 'Matrix is no quadratic.');
		
		$permutation = new Vector($matrix->rows());
		
		for ($j = 0; $j < $matrix->rows(); $j++) {
			
			$pivot = $j;
			for ($i = $j + 1; $i < $matrix->rows(); $i++) {
				if (abs($matrix->get($i,$j)) > abs($matrix->get($pivot, $j))) {
					$pivot = $i;
				}
			}
			
			$permutation->set($j, $pivot);
			
			$matrix->swapColumns($j, $pivot);
			
			for ($i = $j + 1; $i < $matrix->columns(); $i++) {
				$matrix->set($i, $j, $matrix->get($i, $j)/$matrix->get($j, $j));
				
				for ($k = $j + 1; $k < $matrix->columns(); $k++) {
					$matrix->set($i, $k, $matrix->get($i, $k) - $matrix->get($i, $j)*$matrix->get($j,$k));
				}
			}
		}
		
		return $permutation;
	}
	
	/**
	 * Generate LU decomposition of the matrix.
   * As trace the permutated matrix and eliminated matrix of each step is stored.
	 * 
	 * @param	matrix	matrix to get lu decomposition of
	 * @param	array 	store the trace in here
	 * @return	vector	permutation
	 */
	public static function luDecompositionWithTrace(&$matrix, &$trace) {
		Matrix::_assert($matrix instanceof Matrix, 'Given matrix not of class Matrix.');
		Matrix::_assert($matrix->rows() == $matrix->columns(), 'Matrix is not quadratic.');
		
		$permutation = new Vector($matrix->rows());
		
		for ($j = 0; $j < $matrix->rows(); $j++) {
			
			$pivot = $j;
			for ($i = $j + 1; $i < $matrix->rows(); $i++) {
				if (abs($matrix->get($i,$j)) > abs($matrix->get($pivot, $j))) {
					$pivot = $i;
				}
			}
			
			$permutation->set($j, $pivot);
			
			$matrix->swapColumns($j, $pivot);
			
      // Save the matrix after permutation.
			$trace[$j] = array(
        'permutation' => $matrix->copy(),
      );
			
			for ($i = $j + 1; $i < $matrix->columns(); $i++) {
				$matrix->set($i, $j, $matrix->get($i, $j)/$matrix->get($j, $j));
				
				for ($k = $j + 1; $k < $matrix->columns(); $k++) {
					$matrix->set($i, $k, $matrix->get($i, $k) - $matrix->get($i, $j)*$matrix->get($j,$k));
				}
			}
			
      // Save the matrix after elimination.
			$trace[$j]['elimination'] = $matrix->copy();
		}
		
		return $permutation;
	}
	
	/**
	 * Solve system of linear equation using a right hand vector, the lu decomposition and the permutation vector of the lu decomposition.
	 * 
	 * @param	matrix	lu decomposition
	 * @param	vector	permutation vector of lu decomposition
	 * @param	vector	right hand
	 */
	public static function luSolve($matrix, $permutation, $rightHand) {
		Matrix::_assert($matrix instanceof Matrix, 'Given matrix not of class Matrix.');
		Matrix::_assert($permutation instanceof Vector, 'Given permutation vector not of class Vector.');
		Matrix::_assert($b instanceof Vector, 'Given right hand not of class Vector.');
		Matrix::_assert($matrix->rows() == $matrix->columns(), 'Matrix is not quadratic.');
		Matrix::_assert($matrix->rows() == $permutation->size(), 'Permutation vector does not have correct size.');
		Matrix::_assert($matrix->rows() == $rightHand->size(), 'Right hand vector does not have correct size.');
		
		$b = $rightHand.copy();
		
		for ($i = 0; $i < $b->size(); $i++) {
			$b->swapColumns($i, $permutation->get($i));
		}
		
		// First solve L*y = b.
		for ($i = 0; $i < $matrix->rows(); $i++) {
			for ($j = $i - 1; $j >= 0; $j--) {
				$b->set($i, $b->get($i) - $b->get($j)*$matrix->get($i, $j));
			}
		}
		
		// Now solve R*x =y.
		for ($i = $matrix->rows() - 1; $i >= 0; $i--) {
			for ($j = $i + 1; $j < $matrix->columns(); $j--) {
				$b->set($i, $b->get($i) - $b->get($j)*$matrix->get($i, $j));
			}
			$b->set($i, $b->get($i)/$matrix->get($i, $i));
		}
		
		return $b;
	}
	
	/**
	 * Calculate the determinant of the matrix with the given lu decomposition.
	 * 
	 * @param	matrix	lu decomposition
	 * @param	vector	permutation vector of the lu decomposition
	 */
	public static function luDeterminant($matrix, $permutation) {
		Matrix::_assert($matrix instanceof Matrix, 'Given matrix not of class Matrix.');
		Matrix::_assert($permutation instanceof Vector, 'Permutation vector not of class Vector.');
		Matrix::_assert($matrix->rows() == $matrix->columns(), 'Matrix is not quadratic.');
		Matrix::_assert($matrix->rows() == $permutation->size(), 'Permutation vetor does not have correct size.');
		
		// Calculate number of swapped rows.
		$swapped = 0;
		for ($i = 0; $i < $permutation->size(); $i++) {
			if ($permutation->get($i) != $i) {
				$swapped++;
			}
		}
		
		$determinant = pow(-1,$swapped);
		
		for ($i = 0; $i < $matrix->rows(); $i++) {
			$determinant *= $matrix->get($i, $i);
		}
		
		return $determinant;
	}
	
	/**
	 * Get the qr decomposition of the given matrix using givens rotations.
   * The single givens rotations are stored within the matrix.
	 * 
	 * @param	matrix	matrix to get the qr decomposition of
	 */
	public static function qrDecompositionGivens(&$matrix) {
		Matrix::_assert($matrix instanceof Matrix, 'Given matrix not of class Matrix.');
		
		for ($j = 0; $j < $matrix->columns(); $j++) {
			for ($i = $j + 1; $i < $matrix->rows(); $i++) {
        // If the entry is zero it can be skipped.
			  if ($matrix->get($i, $j) != 0) {
  				$r = sqrt(pow($matrix->get($j, $j), 2) + pow($matrix->get($i, $j), 2));
  				
  				if ($matrix->get($i, $j) < 0) {
  					$r = -$r;
  				}
  				
  				$s = $matrix->get($i, $j)/$r;
  				$c = $matrix->get($j, $j)/$r;
  				
          // Apply the givens rotation:
  				for ($k = $j; $k < $matrix->columns(); $k++) {
  					$jk = $matrix->get($j ,$k);
  					$ik = $matrix->get($i, $k);
  					$matrix->set($j, $k, $c*$jk + $s*$ik);
  					$matrix->set($i, $k, -$s*$jk + $c*$ik);
  				}
  				
          // c and s can be stored in one matrix entry:
  				if ($c == 0) {
  					$matrix->set($i, $j, 1);
  				}
  				else if (abs($s) < abs($c)) {
  					if ($c < 0) {
  						$matrix->set($i, $j, -.5*$s);
  					}
  					else {
  						$matrix->set($i, $j, .5*$s);
  					}
  				}
  				else {
  					$matrix->set($i, $j, 2./$c);
  				}
  			}
      }
		}
	}
	
	/**
	 * Get the qr decomposition of the given matrix using givens rotations.
   * The single givens rotations are not stored within the matrix but added to the trace.
	 * 
	 * @param	matrix	matrix to get the qr decomposition of
	 * @param	array 	store the trace in here
	 */
	public static function qrDecompositionGivensWithTrace(&$matrix, &$trace) {
		Matrix::_assert($matrix instanceof Matrix, 'Given matrix not of class Matrix.');
    
		for ($j = 0; $j < $matrix->columns(); $j++) {
		  $trace[$j] = array();
      for ($i = $j + 1; $i < $matrix->rows(); $i++) {
			  // If the entry is zero it can be skipped.
			  if ($matrix->get($i, $j) != 0) {
			    $r = sqrt(pow($matrix->get($j, $j), 2) + pow($matrix->get($i, $j), 2));
				
  				if ($matrix->get($i, $j) < 0) {
  					$r = -$r;
  				}
  				
  				$s = $matrix->get($i, $j)/$r;
  				$c = $matrix->get($j, $j)/$r;
          
          // Apply the givens rotation.
  				for ($k = $j; $k < $matrix->columns(); $k++) {
  					$jk = $matrix->get($j ,$k);
  					$ik = $matrix->get($i, $k);
  					$matrix->set($j, $k, $c*$jk + $s*$ik);
  					$matrix->set($i, $k, -$s*$jk + $c*$ik);
  				}
          
          // This time roh (so c and s) are not stored within the matrix but given using the trace.
          
          $trace[$j][$i] = array(
            'c' => $c,
            's' => $s,
            'matrix' => $matrix->copy(), // Has to be a copy not a reference!
          );
        }
			}
		}
	}
	
  /**
   * Get the cholesky decomposition of the given matrix.
   * 
   * @param matrix  matrix to get the cholesky decomposition of
   */
  public static function choleskyDecomposition(&$matrix, double $tolerance = NULL) {
    Matrix::_assert($matrix instanceof Matrix, 'Given matrix not of class Matrix.');
    
    if ($tolerance === NULL) {
      $tolerance = (double)0.00001;
    }
    
    for ($j = 0; $j < $matrix->columns(); $j++) {
      $d = $matrix->get($j, $j);
      for ($k = 0; $k < $j; $k++) {
        $d -= pow($matrix->get($j, $k), 2)*$matrix->get($k, $k);
      }
      
      // Test if symmetric, positive definit can be guaranteed.
      Matrix::_assert($d > $tolerance*(double)$matrix->get($j, $j), 'Symmetric, positive definit can not be guaranteed: ' . $d . ' > ' . $tolerance*(double)$matrix->get($j, $j));
      
      $matrix->set($j, $j, $d);
      
      for ($i = $j + 1; $i < $matrix->rows(); $i++) {
        $matrix->set($i, $j, $matrix->get($i, $j));
        for ($k = 0; $k < $j; $k++) {
          $matrix->set($i, $j, $matrix->get($i, $j) - $matrix->get($i, $k)*$matrix->get($k, $k)*$matrix->get($j, $k));
        }
        $matrix->set($i, $j, $matrix->get($i, $j)/((double)$matrix->get($j, $j)));
      }
    }
  }
  
	/**
	 * Asserts the given expression.
	 * 
	 * @throws	Exception
	 */
	private static function _assert($boolean, $message = '') {
		if (!$boolean) {
			throw new \Libraries\Exception\MatrixException($message);
		}
	}
}