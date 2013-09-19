<?php

namespace Libraries\Decompositions;

/**
 * Calculate a QR decomposition by using givens rotations.
 *
 * @author  David Stutz
 * @license http://www.gnu.org/licenses/gpl-3.0
 */
class QRGivensWithTrace extends QRGivens {
    
    /**
     * @var array
     */
    protected $_trace = array();

    /**
     * Cosntructor: Get the qr decomposition of the given matrix using givens rotations.
     * The single givens rotations are not stored within the matrix but added to the trace.
     *
     * @param   matrix  matrix to get the qr decomposition of
     */
    public function __construct(&$matrix) {
        new \Libraries\Assertion($matrix instanceof \Libraries\Matrix, 'Given matrix not of class Matrix.');

        $this->_matrix = $matrix->copy();

        // Check in all columns except the n-th one for entries to eliminate.
        for ($j = 0; $j < $this->_matrix->columns() - 1; $j++) {
            $this->_trace[$j] = array();
            for ($i = $j + 1; $i < $this->_matrix->rows(); $i++) {
                // If the entry is zero it can be skipped.
                if ($this->_matrix->get($i, $j) != 0) {
                    $r = sqrt(pow($this->_matrix->get($j, $j), 2) + pow($this->_matrix->get($i, $j), 2));

                    if ($this->_matrix->get($i, $j) < 0) {
                        $r = -$r;
                    }

                    $s = $this->_matrix->get($i, $j) / $r;
                    $c = $this->_matrix->get($j, $j) / $r;

                    // Apply the givens rotation.
                    for ($k = $j; $k < $this->_matrix->columns(); $k++) {
                        $jk = $this->_matrix->get($j, $k);
                        $ik = $this->_matrix->get($i, $k);
                        $this->_matrix->set($j, $k, $c * $jk + $s * $ik);
                        $this->_matrix->set($i, $k, -$s * $jk + $c * $ik);
                    }
                    
                    // c and s can be stored in one matrix entry:
                    if ($c == 0) {
                        $this->_matrix->set($i, $j, 1);
                    }
                    else if (abs($s) < abs($c)) {
                        if ($c < 0) {
                            $this->_matrix->set($i, $j, -.5 * $s);
                        }
                        else {
                            $this->_matrix->set($i, $j, .5 * $s);
                        }
                    }
                    else {
                        $this->_matrix->set($i, $j, 2. / $c);
                    }

                    $this->_trace[$j][$i] = array(
                        'c' => $c,
                        's' => $s,
                        'matrix' => $this->_matrix->copy(), // Has to be a copy not a reference!
                    );
                }
            }
        }
    }

    /**
     * Get the assembled trace.
     * 
     * @return  array   trace
     */
    public function getTrace() {
        return $this->_trace;
    }
}
