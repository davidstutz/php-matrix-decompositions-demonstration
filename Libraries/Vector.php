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
        new \Libraries\Assertion($size > 0, 'Invalid size given.');

        $this->_size = (int)$size;
    }

    /**
     * Resizes the dimensions of the matrix.
     *
     * @param	int		size
     * @return	vector	this
     */
    public function resize($size) {
        $this->_size = (int)$size;

        return $this;
    }

    /**
     * Compares the matrix with the given matrix for equality.
     *
     * @param	matrix	matrix
     * @return	boolean	equals
     */
    public function equals($vector) {
        new \Libraries\Assertion($vector instanceof Vector, 'Given vector not of class Vector.');
        new \Libraries\Assertion($this->size() == $vector->size(), 'The dimensions do not match.');

        for ($i = 0; $i < $this->size(); $i++) {
            if ($vector->get($i) != $this->get($i)) {
                return FALSE;
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

        new \Libraries\Assertion($position >= 0 AND $position < $this->size(), 'Tried to access invalid position.');

        $value = NULL;
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

        new \Libraries\Assertion($position >= 0 AND $position < $this->size(), 'Tried to access invalid position.');

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

        for ($i = 0; $i < $this->size(); $i++) {
            $vector->set($i, $this->get($i));
        }

        return $vector;
    }

    /**
     * Sets the entries form the given array.
     * 
     * @param   array   entries
     * @return  vector  this
     */
    public function fromArray($array) {
        new \Libraries\Assertion(sizeof($array) == $this->size(), 'Array has invalid size.');
        
        for ($i = 0; $i < $this->size(); $i++) {
            $this->set($i, $array[$i]);
        }
        
        return $this;
    }
    
    /**
     * Gets the vector as array.
     * 
     * @return  array   vector
     */
    public function asArray() {
        $array = array();
        
        for ($i = 0; $i < $this->size(); $i++) {
            $array[$i] = $this->get($i);
        }
        
        return $array;
    }
    

    /**
     * Swap the given columns.
     *
     * @param	int	column
     * @param 	int column
     * @return	matrix	this
     */
    public function swapEntries($i, $j) {
        new \Libraries\Assertion($i >= 0 AND $i < $this->size(), 'Tried to access invalid position.');
        new \Libraries\Assertion($j >= 0 AND $j < $this->size(), 'Tried to access invalid position.');

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
        new \Libraries\Assertion($a instanceof Vector, 'Given first vector not of class Vector.');
        new \Libraries\Assertion($b instanceof Vector, 'Given second vector not of class Vector.');
        new \Libraries\Assertion($a->size() == $b->size(), 'Dimensions do not match.');

        $size = $a->size();
        $result = 0;

        for ($i = 0; $i < $size; $i++) {
            $result += $a->get($i) * $b->get($i);
        }

        return $result;
    }
    
    /**
     * Multiply the given matrix and vector.
     *
     * @param matrix  matrix
     * @param vector  vector
     * @return  vector  product matrix*vector
     */
    public static function multiply($a, $x) {
        // First check dimensions.
        new \Libraries\Assertion($a instanceof Matrix, 'Given matrix not of class Matrix.');
        new \Libraries\Assertion($x instanceof Vector, 'Given vector not of class Vector.');
        new \Libraries\Assertion($a->columns() == $x->size(), 'Given dimensions are not compatible.');

        $c = new Vector($a->rows());
        $c->setAll(0.);

        for ($i = 0; $i < $a->rows(); $i++) {
            for ($j = 0; $j < $x->size(); $j++) {
                $c->set($i, $c->get($i) + $a->get($i, $j) * $x->get($j));
            }
        }

        return $c;
    }
    
    /**
     * Add the two vectors.
     * 
     * @param   vector  first vector
     * @param   vector second vector
     * @return vector sum
     */
    public static function add($a, $b) {
        // First check dimensions.
        new \Libraries\Assertion($a instanceof Vector, 'Given first vector not of class Vector.');
        new \Libraries\Assertion($b instanceof Vector, 'Given second vector not of class Vector.');
        new \Libraries\Assertion($a->size() == $b->size(), 'Given dimensions are not compatible.');
        
        $c = $a->copy();
        for ($i = 0; $i < $a->size(); $i++) {
            $c->set($i, $a->get($i) + $b->get($i));
        }
        
        return $c;
    }

    /**
     * Multiply vector by scalar.
     * 
     * @param double scalar
     * @return vector  this
     */
    public function multiplyBy($scalar) {
        for ($i = 0; $i < $this->size(); $i++) {
            $this->set($i, $this->get($i)*$scalar);
        }
        
        return $this;
    }
    
}
