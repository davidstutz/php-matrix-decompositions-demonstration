<?php

namespace Libraries\Decompositions;

/**
 * Helper class to provide methods concerning the lu decomposition.
 *
 * @author  David Stutz
 * @license http://www.gnu.org/licenses/gpl-3.0
 */
class QRGivens {

    /**
     * @var matrix
     */
    protected $_matrix;
     
    /**
     * Constructor: Get the qr decomposition of the given matrix using givens rotations.
     * The single givens rotations are stored within the matrix.
     *
     * @param   matrix  matrix to get the qr decomposition of
     */
    public function __construct(&$matrix) {
        new \Libraries\Assertion($matrix instanceof \Libraries\Matrix, 'Given matrix not of class Matrix.');

        // Check in all columns except the n-th one for entries to eliminate.
        for ($j = 0; $j < $matrix->columns() - 1; $j++) {
            for ($i = $j + 1; $i < $matrix->rows(); $i++) {
                // If the entry is zero it can be skipped.
                if ($matrix->get($i, $j) != 0) {
                    $r = sqrt(pow($matrix->get($j, $j), 2) + pow($matrix->get($i, $j), 2));

                    if ($matrix->get($i, $j) < 0) {
                        $r = -$r;
                    }

                    $s = $matrix->get($i, $j) / $r;
                    $c = $matrix->get($j, $j) / $r;

                    // Apply the givens rotation:
                    for ($k = $j; $k < $matrix->columns(); $k++) {
                        $jk = $matrix->get($j, $k);
                        $ik = $matrix->get($i, $k);
                        $matrix->set($j, $k, $c * $jk + $s * $ik);
                        $matrix->set($i, $k, -$s * $jk + $c * $ik);
                    }

                    // c and s can be stored in one matrix entry:
                    if ($c == 0) {
                        $matrix->set($i, $j, 1);
                    }
                    else if (abs($s) < abs($c)) {
                        if ($c < 0) {
                            $matrix->set($i, $j, -.5 * $s);
                        }
                        else {
                            $matrix->set($i, $j, .5 * $s);
                        }
                    }
                    else {
                        $matrix->set($i, $j, 2. / $c);
                    }
                }
            }
        }
    }

    /**
     * Assembles Q using the single givens rotations.
     * 
     * @return  matrix  Q
     */
    public function getQ() {
        // Q is an mxm matrix if m is the maximum of the number of rows and thenumber of columns.
        $m = max($this->_matrix->columns(), $this->_matrix->rows());
        $Q = new Matrix($m, $m);
        
        // TODO: Assemble Q.
        
        return $Q;
    }
    
    /**
     * Gets the upper triangular matrix R.
     */
    public function getR() {
        $R = $this->_matrix->copy();
        
        for ($i = 0; $i < $R->rows(); $i++) {
            for ($j = 0; $j < $i; $j++) {
                $R->set($i, $j, 0);
            }
        }
        
        // Resize R to a square matrix.
        $n = min($R->rows(), $R->columns());
        return $R->resize($n, $n);
    }
}
