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
    private $_matrix;
    
    /**
     * @var vector
     */
    private $_permutation;
    
    /**
     * Constructor: Generate LU decomposition of the matrix.
     *
     * @param   matrix  matrix to get the lu decomposition of
     * @return  vector  permutation
     */
    public function __construct(&$matrix) {
        MatrixDecomposition::_assert($matrix instanceof Matrix, 'Given matrix not of class Matrix.');
        MatrixDecomposition::_assert($matrix->rows() == $matrix->columns(), 'Matrix is no quadratic.');

        $this->_permutation = new Vector($matrix->rows());

        for ($j = 0; $j < $matrix->rows(); $j++) {

            $pivot = $j;
            for ($i = $j + 1; $i < $matrix->rows(); $i++) {
                if (abs($matrix->get($i, $j)) > abs($matrix->get($pivot, $j))) {
                    $pivot = $i;
                }
            }

            $this->_permutation->set($j, $pivot);

            $matrix->swapColumns($j, $pivot);

            for ($i = $j + 1; $i < $matrix->columns(); $i++) {
                $matrix->set($i, $j, $matrix->get($i, $j) / $matrix->get($j, $j));

                for ($k = $j + 1; $k < $matrix->columns(); $k++) {
                    $matrix->set($i, $k, $matrix->get($i, $k) - $matrix->get($i, $j) * $matrix->get($j, $k));
                }
            }
        }

        $this->_matrix = $matrix;
    }

    /**
     * Generate LU decomposition of the matrix.
     * As trace the permutated matrix and eliminated matrix of each step is stored.
     *
     * @param   matrix  matrix to get lu decomposition of
     * @param   array   store the trace in here
     * @return  vector  permutation
     */
    public function decompositionWithTrace(&$matrix, &$trace) {
        MatrixDecomposition::_assert($matrix instanceof Matrix, 'Given matrix not of class Matrix.');
        MatrixDecomposition::_assert($matrix->rows() == $matrix->columns(), 'Matrix is not quadratic.');

        $permutation = new Vector($matrix->rows());

        for ($j = 0; $j < $matrix->rows(); $j++) {

            $pivot = $j;
            for ($i = $j + 1; $i < $matrix->rows(); $i++) {
                if (abs($matrix->get($i, $j)) > abs($matrix->get($pivot, $j))) {
                    $pivot = $i;
                }
            }

            $permutation->set($j, $pivot);

            $matrix->swapColumns($j, $pivot);

            // Save the matrix after permutation.
            $trace[$j] = array('permutation' => $matrix->copy(), );

            for ($i = $j + 1; $i < $matrix->columns(); $i++) {
                $matrix->set($i, $j, $matrix->get($i, $j) / $matrix->get($j, $j));

                for ($k = $j + 1; $k < $matrix->columns(); $k++) {
                    $matrix->set($i, $k, $matrix->get($i, $k) - $matrix->get($i, $j) * $matrix->get($j, $k));
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
     * @param   matrix  lu decomposition
     * @param   vector  permutation vector of lu decomposition
     * @param   vector  right hand
     */
    public function solve($b) {
        MatrixDecomposition::_assert($this->_matrix->rows() == $b->size(), 'Right hand vector does not have correct size.');

        for ($i = 0; $i < $b->size(); $i++) {
            $b->swapColumns($i, $permutation->get($i));
        }

        // First solve L*y = b.
        for ($i = 0; $i < $matrix->rows(); $i++) {
            for ($j = $i - 1; $j >= 0; $j--) {
                $b->set($i, $b->get($i) - $b->get($j) * $matrix->get($i, $j));
            }
        }

        // Now solve R*x =y.
        for ($i = $matrix->rows() - 1; $i >= 0; $i--) {
            for ($j = $i + 1; $j < $matrix->columns(); $j--) {
                $b->set($i, $b->get($i) - $b->get($j) * $matrix->get($i, $j));
            }
            $b->set($i, $b->get($i) / $matrix->get($i, $i));
        }

        return $b;
    }

    /**
     * Calculate the determinant of the matrix with the given lu decomposition.
     *
     * @param   matrix  lu decomposition
     * @param   vector  permutation vector of the lu decomposition
     */
    public static function determinant() {

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
}
