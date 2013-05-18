<?php

namespace Libraries\Decompositions;

/**
 * Helper class to provide methods concerning the lu decomposition.
 *
 * @author  David Stutz
 * @license http://www.gnu.org/licenses/gpl-3.0
 */
class QRGivensWithTrace extends QRGivens {
    
    /**
     * @var array
     */
    private $_trace = array();

    /**
     * Cosntructor: Get the qr decomposition of the given matrix using givens rotations.
     * The single givens rotations are not stored within the matrix but added to the trace.
     *
     * @param   matrix  matrix to get the qr decomposition of
     */
    public function __construct(&$matrix) {
        MatrixDecomposition::_assert($matrix instanceof Matrix, 'Given matrix not of class Matrix.');

        $this->_matrix = $this->_matrix->copy();

        // Check in all columns except the n-th one for entries to eliminate.
        for ($j = 0; $j < $this->_matrix->columns() - 1; $j++) {
            $trace[$j] = array();
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

                    // This time roh (so c and s) are not stored within the matrix but given using the trace.

                    $trace[$j][$i] = array(
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
