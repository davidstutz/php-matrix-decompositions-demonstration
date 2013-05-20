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
        new \Libraries\Assertion($rows > 0, 'Invalid dimensions given.');

        $columns = (int)$columns;
        new \Libraries\Assertion($columns > 0, 'Invalid dimensions given.');

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
        $rows = (int)$rows;
        new \Libraries\Assertion($rows > 0, 'Invalid dimensions given.');

        $columns = (int)$columns;
        new \Libraries\Assertion($columns > 0, 'Invalid dimensions given.');
        
        
        if (TRUE === $this->_transposed) {
            $this->_rows = $columns;
            $this->_columns = $rows;
        }
        else {
            $this->_rows = $rows;
            $this->_columns = $columns;
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
        new \Libraries\Assertion($matrix instanceof Matrix, 'Given matrix not of class Matrix.');
        new \Libraries\Assertion($this->rows() == $matrix->rows(), 'Matrices do not have same dimensions.');
        new \Libraries\Assertion($this->columns() == $matrix->columns(), 'Matrices do not have same dimensions.');

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
        
        new \Libraries\Assertion($row >= 0 AND $row < $this->rows(), 'Tried to access invalid entry.');
        new \Libraries\Assertion($column >= 0 AND $column < $this->columns(), 'Tried to access invalid entry.');
        
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
        
        new \Libraries\Assertion($row >= 0 AND $row < $this->rows(), 'Tried to access invalid entry.');
        new \Libraries\Assertion($column >= 0 AND $column < $this->columns(), 'Tried to access invalid entry.');
        
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
        
        return $this;
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

        new \Libraries\Assertion($column >= 0 AND $column < $this->columns(), 'Tried to access invalid column number.');

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
        new \Libraries\Assertion(is_array($array), 'No array given.');

        // TODO: assert that all values within the array are defined?

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
        new \Libraries\Assertion($i >= 0 AND $i < $this->rows(), 'Tried to access invalid entry.');
        new \Libraries\Assertion($j >= 0 AND $j < $this->rows(), 'Tried to access invalid entry.');

        for ($k = 0; $k < $this->rows(); $k++) {
            $tmp = $this->get($k, $i);
            $this->set($k, $i, $this->get($k, $j));
            $this->set($k, $j, $tmp);
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
        new \Libraries\Assertion($i >= 0 AND $i < $this->rows(), 'Tried to access invalid entry.');
        new \Libraries\Assertion($j >= 0 AND $j < $this->rows(), 'Tried to access invalid entry.');

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
        new \Libraries\Assertion($a instanceof Matrix, 'Given first matrix not of class Matrix.');
        new \Libraries\Assertion($b instanceof Matrix, 'Given second matrix not of class Matrix.');
        new \Libraries\Assertion($a->rows() == $b->rows(), 'Given dimensions are not compatible.');
        new \Libraries\Assertion($a->columns() == $b->columns(), 'Given dimensions are not compatible.');

        $rows = $a->rows();
        $columns = $a->columns();

        $matrix = $a->copy();

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
        new \Libraries\Assertion($a instanceof Matrix, 'Given first matrix not of class Matrix.');
        new \Libraries\Assertion($b instanceof Matrix, 'Given second matrix not of class Matrix.');
        new \Libraries\Assertion($a->columns() == $b->rows(), 'Given dimensions are not compatible.');

        $c = new Matrix($a->rows(), $b->columns());
        $c->setAll(0.);

        for ($i = 0; $i < $a->rows(); $i++) {
            for ($j = 0; $j < $b->columns(); $j++) {
                for ($k = 0; $k < $a->columns(); $k++) {
                    $c->set($i, $j, $c->get($i, $j) + $a->get($i, $k) * $b->get($k, $j));
                }
            }
        }

        return $c;
    }

}
