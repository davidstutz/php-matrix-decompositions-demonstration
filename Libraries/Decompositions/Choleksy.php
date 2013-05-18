<?php

namespace Libraries\Decompositions;

/**
 * Helper class to provide methods concerning the cholesky decomposition.
 *
 * @author  David Stutz
 * @license http://www.gnu.org/licenses/gpl-3.0
 */
class Cholesky {
    
    const TOLERANCE = 0.00001;
    
    /**
     * @var matrix
     */
    private $_matrix;
    
    /**
     * Constructor: Generate cholesky deocmposition of given matrix.
     * 
     * @param   matrix
     */
    public function __construct(&$matrix) {
        Matrix::assert($matrix instanceof Matrix, 'Given matrix not of class Matrix.');
        Matrix::assert($matrix->rows() == $matrix->columns(), 'Given matrix is not square.');

        for ($j = 0; $j < $matrix->columns(); $j++) {
            $d = $matrix->get($j, $j);
            for ($k = 0; $k < $j; $k++) {
                $d -= pow($matrix->get($j, $k), 2) * $matrix->get($k, $k);
            }

            // Test if symmetric, positive definit can be guaranteed.
            Matrix::assert($d > Cholesky::TOLERANCE * (double)$matrix->get($j, $j), 'Symmetric, positive definit can not be guaranteed: ' . $d . ' > ' . Cholesky::TOLERANCE * (double)$matrix->get($j, $j));

            $matrix->set($j, $j, $d);

            for ($i = $j + 1; $i < $matrix->rows(); $i++) {
                $matrix->set($i, $j, $matrix->get($i, $j));
                for ($k = 0; $k < $j; $k++) {
                    $matrix->set($i, $j, $matrix->get($i, $j) - $matrix->get($i, $k) * $matrix->get($k, $k) * $matrix->get($j, $k));
                }
                $matrix->set($i, $j, $matrix->get($i, $j) / ((double)$matrix->get($j, $j)));
            }
        }
        
        $this->_matrix = $matrix;
    }
    
    /**
     * Get the L of the composition L^T*D*L.
     * 
     * @return  matrix  L
     */
    public function getL() {
        $L = $matrix->copy();
        
        // L is the lower triangular matrix.
        for ($i = 0; $i < $L->rows(); $i++) {
            for ($j = $i; $j < $L->columns(); $j++) {
                if ($j == $i) {
                    $L->set($i, $j, 1);
                }
                else {
                    $L->set($i, $j, 0);
                }
            }
        }
    }
    
    /**
     * Get D - the diagonal matrix.
     * 
     * @return  matrix  D
     */
    public function getD() {
        
    }
}
