<?php

namespace Libraries;

/**
 * Vector class.
 *
 * @author  David Stutz
 * @license http://www.gnu.org/licenses/gpl-3.0
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
        Vector::assert($size > 0, 'Invalid size given.');

        $this->_size = (int)$size;
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
        Vector::assert($vector instanceof Vector, 'Given vector not of class Vector.');
        Vector::assert($this->_rows == $vector->size(), 'The dimensions do not match.');

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

        Vector::assert($position >= 0 AND $position < $this->size(), 'Tried to access invalid position.');

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

        Vector::assert($position >= 0 AND $position < $this->size(), 'Tried to access invalid position.');

        $this->_data[$position] = $value;

        return $this;
    }

    /**
     * Sets all entries of the matrix to the given value.
     *
     * @param	mixed	value
     * @return	matrix	this
     */
    public function setAll($value) {
        for ($i = 0; $i < $this->size(); $i++) {
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
    public function swapEntries($i, $j) {
        Vector::assert($i >= 0 AND $i < $this->size(), 'Tried to access invalid position.');
        Vector::assert($j >= 0 AND $j < $this->size(), 'Tried to access invalid position.');

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
    public static function inner($a, $b) {
        Vector::assert($a instanceof Vector, 'Given first vector not of class Vector.');
        Vector::assert($b instanceof Vector, 'Given second vector not of class Vector.');
        Vector::assert($a->size() == $b->size(), 'Dimensions do not match.');

        $size = $a->size();
        $result = 0;

        for ($i = 0; $i < $size; $i++) {
            $result += $a->get($i) * $b->get($i);
        }

        return $result;
    }

    /**
     * Asserts the given expression.
     *
     * @throws	Exception
     */
    public static function assert($boolean, $message = '') {
        if (!$boolean) {
            throw new \Libraries\Exception\VectorException($message);
        }
    }

}
