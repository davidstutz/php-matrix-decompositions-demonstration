<?php

namespace Libraries\Decompositions;

/**
 * Helper class to provide methods concerning the lu decomposition.
 *
 * @author  David Stutz
 * @license http://www.gnu.org/licenses/gpl-3.0
 */
class LU {
    
    /**
     * @var matrix
     */
    protected $_matrix;
    
    /**
     * @var vector
     */
    protected $_permutation;
    
    /**
     * Constructor: Generate LU decomposition of the matrix.
     *
     * @param   matrix  matrix to get the lu decomposition of
     * @return  vector  permutation
     */
    public function __construct(&$matrix) {
        new \Libraries\Assertion($matrix instanceof \Libraries\Matrix, 'Given matrix not of class Matrix.');
        new \Libraries\Assertion($matrix->isSquare(), 'Matrix is not quadratic.');

        $this->_permutation = new \Libraries\Vector($matrix->rows());
        $this->_matrix = $matrix->copy();
        
        for ($j = 0; $j < $this->_matrix->rows(); $j++) {

            $pivot = $j;
            for ($i = $j + 1; $i < $this->_matrix->rows(); $i++) {
                if (abs($this->_matrix->get($i, $j)) > abs($this->_matrix->get($pivot, $j))) {
                    $pivot = $i;
                }
            }

            $this->_permutation->set($j, $pivot);

            $this->_matrix->swapRows($j, $pivot);
            
            for ($i = $j + 1; $i < $this->_matrix->columns(); $i++) {
                $this->_matrix->set($i, $j, $this->_matrix->get($i, $j) / $this->_matrix->get($j, $j));

                for ($k = $j + 1; $k < $this->_matrix->columns(); $k++) {
                    $this->_matrix->set($i, $k, $this->_matrix->get($i, $k) - $this->_matrix->get($i, $j) * $this->_matrix->get($j, $k));
                }
            }
        }
    }

    /**
     * Solve system of linear equation using a right hand vector, the lu decomposition and the permutation vector of the lu decomposition.
     *
     * @param   vector  right hand
     */
    public function solve($b) {
        new \Libraries\Assertion($this->_matrix->rows() == $b->size(), 'Right hand vector does not have correct size.');
        
        $x = $b->copy();
        
        for ($i = 0; $i < $x->size(); $i++) {
            $x->swapEntries($i, $this->_permutation->get($i));
        }

        // First solve L*y = b.
        for ($i = 0; $i < $this->_matrix->rows(); $i++) {
            for ($j = $i - 1; $j >= 0; $j--) {
                $x->set($i, $x->get($i) - $x->get($j) * $this->_matrix->get($i, $j));
            }
        }

        // Now solve R*x =y.
        for ($i = $this->_matrix->rows() - 1; $i >= 0; $i--) {
            for ($j = $this->_matrix->columns() - 1; $j > $i; $j--) {
                $x->set($i, $x->get($i) - $x->get($j) * $this->_matrix->get($i, $j));
            }
            $x->set($i, $x->get($i) / $this->_matrix->get($i, $i));
        }

        return $x;
    }

    /**
     * Calculate the determinant of the matrix with the given lu decomposition.
     *
     * @param   matrix  lu decomposition
     * @param   vector  permutation vector of the lu decomposition
     */
    public function getDeterminant() {

        // Calculate number of swapped rows.
        $swapped = 0;
        for ($i = 0; $i < $this->_permutation->size(); $i++) {
            if ($this->_permutation->get($i) != $i) {
                $swapped++;
            }
        }

        $determinant = pow(-1, $swapped);

        for ($i = 0; $i < $this->_matrix->rows(); $i++) {
            $determinant *= $this->_matrix->get($i, $i);
        }

        return $determinant;
    }
    
    /**
     * Get the L of the decomposition.
     * 
     * @return  matrix  L
     */
    public function getL() {
        $L = $this->_matrix->copy();
        
        for ($i = 0; $i < $L->rows(); $i++) {
            for ($j = $i; $j < $L->columns(); $j++) {
                if ($i == $j) {
                    $L->set($i, $j, 1);
                }
                else {
                    $L->set($i, $j, 0);
                }
            }
        }
        
        return $L;
    }
    
    /**
     * Get the U of the decomposition.
     * 
     * @return  matrix  U
     */
    public function getU() {
        $U = $this->_matrix->copy();
        
        for ($i = 0; $i < $U->rows(); $i++) {
            for ($j = 0; $j < $i; $j++) {
                $U->set($i, $j, 0);
            }
        }
        
        return $U;
    }
    
    /**
     * Gets the row permutation.
     * 
     * @return  vector  permutation
     */
    public function getPermutation() {
        return $this->_permutation->copy();
    }
}
