<?php

namespace Libraries;

/**
 * Matrix class.
 *
 * @author  David Stutz
 * @license http://www.gnu.org/licenses/gpl-3.0
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
     * @var boolean transposed
     */
    private $_transposed = FALSE;
    
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
        Matrix::assert($rows > 0, 'Invalid number of rows given.');

        $columns = (int)$columns;
        Matrix::assert($columns > 0, 'Invalid number of columns given.');

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
        if (TRUE === $this->_transposed) {
            $this->rows = (int)$columns;
            $this->_columns = (int)$rows;
        }
        else {
            $this->rows = (int)$rows;
            $this->_columns = (int)$columns;
        }
        
        return $this;
    }

    /**
     * Compares the matrix with the given matrix for equality.
     *
     * @param	matrix	matrix
     * @return	boolean	equals
     */
    public function equals($matrix) {
        Matrix::assert($matrix instanceof Matrix, 'Given matrix not of class Matrix.');
        Matrix::assert($this->rows() == $matrix->rows(), 'Matrices do not have same dimensions.');
        Matrix::assert($this->columns() == $matrix->columns(), 'Matrices do not have same dimensions.');

        for ($i = 0; $i < $this->rows(); $i++) {
            for ($j = 0; $j < $this->columns(); $j++) {
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
        if (TRUE === $this->_transposed) {
            return $this->_columns;
        }
        else {
            return $this->_rows;
        }
    }

    /**
     * Get number of columns.
     *
     * @return	int	columns
     */
    public function columns() {
        if (TRUE === $this->_transposed) {
            return $this->_rows;
        }
        else {
            return $this->_columns;
        }
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
        
        Matrix::assert($row >= 0 AND $row < $this->rows(), 'Tried to access invalid column number.');
        Matrix::assert($column >= 0 AND $column < $this->columns(), 'Tried to access invalid row number.');
        
        $value = NULL;
        
        // Check whether matrix has been transposed.
        if (TRUE === $this->_transposed) {
            if (isset($this->_data[$column])) {
                if (isset($this->_data[$column][$row])) {
                    $value = $this->_data[$column][$row];
                }
            }
        }
        else {
            if (isset($this->_data[$row])) {
                if (isset($this->_data[$row][$column])) {
                    $value = $this->_data[$row][$column];
                }
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
        
        Matrix::assert($row >= 0 AND $row < $this->rows(), 'Tried to access invalid column number.');
        Matrix::assert($column >= 0 AND $column < $this->columns(), 'Tried to access invalid row number.');
        
        // Check whether matrix has been transposed.
        if (TRUE === $this->_transposed) {
            if (!isset($this->_data[$column])) {
                $this->_data[$column] = array();
            }
            
            $this->_data[$column][$row] = $value;
        }
        else {
            if (!isset($this->_data[$row])) {
                $this->_data[$row] = array();
            }
            
            $this->_data[$row][$column] = $value;
        }
        
        return $this;
    }

    /**
     * Sets all entries of the matrix to the given value.
     *
     * @param	mixed	value
     * @return	matrix	this
     */
    public function setAll($value) {
        for ($i = 0; $i < $this->rows(); $i++) {
            for ($j = 0; $j < $this->columns(); $j++) {
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

        for ($i = 0; $i < $this->rows(); $i++) {
            for ($j = 0; $j < $this->columns(); $j++) {
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

        Matrix::assert($column >= 0 AND $column < $this->columns(), 'Tried to access invalid column number.');

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
        Matrix::assert(is_array($array), 'No array given.');

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
        Matrix::assert($i >= 0 AND $i < $this->rows(), 'Tried to access invalid column number.');
        Matrix::assert($j >= 0 AND $j < $this->rows(), 'Tried to access invalid column number.');

        for ($k = 0; $k < $this->columns(); $k++) {
            $tmp = $this->get($i, $k);
            $this->set($i, $k, $this->get($j, $k));
            $this->set($j, $k, $tmp);
        }

        return $this;
    }
    
    /**
     * Swap the given rows.
     *
     * @param   int row
     * @param   int row
     * @return  matrix  this
     */
    public function swapRows($i, $j) {
        Matrix::assert($i >= 0 AND $i < $this->rows(), 'Tried to access invalid column number.');
        Matrix::assert($j >= 0 AND $j < $this->rows(), 'Tried to access invalid column number.');

        for ($k = 0; $k < $this->columns(); $k++) {
            $tmp = $this->get($i, $k);
            $this->set($i, $k, $this->get($j, $k));
            $this->set($j, $k, $tmp);
        }

        return $this;
    }

    /**
     * Transposes the matrix.
     *
     * @return  matrix  transposed matrix
     */
    public function transpose() {
        // Transpose is done by toggling the _transposed attribute.
        $this->_transposed = !$this->_transposed;
        
        return $this;
    }
    
    /**
     * Check whether the matrix is square.
     * 
     * @return  boolean true iff square
     */
    public function isSquare() {
        return $this->rows() == $this->columns();
    }
    
    /**
     * Add to matrices.
     *
     * @param   matrix  $a
     * @param   matrix  $b
     * @return  matrix  $a + $b
     */
    public static function add($a, $b) {
        Matrix::assert($a instanceof Matrix, 'Given first matrix not of class Matrix.');
        Matrix::assert($b instanceof Matrix, 'Given second matrix not of class Matrix.');
        Matrix::assert($a->rows() == $b->rows(), 'Given matrices do not have same dimensions.');
        Matrix::assert($a->columns() == $b->columns(), 'Given matrices do not have same dimensions.');

        $rows = $a->rows();
        $columns = $a->columns();

        $matrix = $a . copy();

        for ($i = 0; $i < $rows; $i++) {
            for ($j = 0; $j < $columns; $j++) {
                $matrix->set($i, $j, $matrix->get($i, $j) + $b->get($i, $j));
            }
        }

        return $matrix;
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
        Matrix::assert($a instanceof Matrix, 'Given first matrix not of class Matrix.');
        Matrix::assert($b instanceof Matrix, 'Given second matrix not of class Matrix.');
        Matrix::assert($a->rows() == $b->rows(), 'Given dimensions are not compatible.');
        Matrix::assert($a->columns() == $b->columns(), 'Given dimensions are not compatible.');

        $c = new Matrix($a->rows(), $b->columns());
        $c->setAll(0.);

        for ($i = 0; $i < $a->rows(); $i++) {
            for ($j = 0; $j < $a->columns(); $j++) {
                for ($k = 0; $k < $b->rows(); $k++) {
                    $c->set($i, $j, $c->get($i, $j) + $a->get($i, $k) * $b->get($k, $j));
                }
            }
        }

        return $c;
    }

    /**
     * Asserts the given expression.
     *
     * @throws	Exception
     */
    public static function assert($boolean, $message = '') {
        if (!$boolean) {
            throw new \Libraries\Exception\MatrixException($message);
        }
    }

}
