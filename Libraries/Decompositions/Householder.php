<?php

namespace Libraries\Decompositions;

/**
 * Helper class to provide methods concerning the lu decomposition.
 *
 * @author  David Stutz
 * @license http://www.gnu.org/licenses/gpl-3.0
 */
class QRHouseholder {
    
    /**
     * @var matrix
     */
    private $_matrix;
    
    /**
     * @var vector
     */
    private $_tau;
    
    /**
     * Constructor: Get the qr decomposition of the given matrix using householder transformations.
     * The single householder matrizes are stores within the matrix.
     *
     * @param matrix  matrix to get the composition of
     */
    public function __construct(&$matrix) {
        Matrix::assert($matrix instanceof Matrix, 'Given matrix not of class Matrix.');

        $this->_tau = new Vector($matrix->columns());

        for ($j = 0; $j < $matrix->columns(); $j++) {

            $norm = 0.;
            for ($i = $j; $i < $matrix->rows(); $i++) {
                $norm += pow($matrix->get($i, $j), 2);
            }
            $norm = sqrt($norm);

            $sign = 1.;
            if ($matrix->get($j, $j) < 0) {
                $sign = -1.;
            }

            $v1 = $matrix->get($j, $j) + $sign * $norm;
            $scalar = 1;

            for ($i = $j + 1; $i < $matrix->rows(); $i++) {
                $matrix->set($i, $j, $matrix->get($i, $j) / $v1);
                $scalar += pow($matrix->get($i, $j), 2);
            }

            $this->_tau->set($j, 2. / $scalar);

            $w = new \Libraries\Vector($matrix->columns());
            $w->setAll(0.);

            // First calculate w = v_j * A.
            for ($i = $j; $i < $matrix->columns(); $i++) {
                $w->set($i, $matrix->get($j, $i));
                for ($k = $j + 1; $k < $matrix->rows(); $k++) {
                    if ($i == $j) {
                        $w->set($i, $matrix->get($k, $j) * $matrix->get($k, $i) * $v1);
                    }
                    else {
                        $w->set($i, $matrix->get($k, $j) * $matrix->get($k, $i));
                    }
                }

                $matrix->set($j, $i, $matrix->get($j, $i) - $this->_tau->get($j) * $w->get($i));
                for ($k = $j + 1; $k < $matrix->rows(); $k++) {
                    if ($i > $j) {
                        $matrix->set($k, $i, $matrix->get($k, $i) - $this->_tau->get($j) * $matrix->get($k, $j) * $w->get($i));
                    }
                }
            }
        }

        $this->_matrix = $matrix;
    }

}
