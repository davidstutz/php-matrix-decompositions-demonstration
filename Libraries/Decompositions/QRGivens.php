<?php
/**
 *  Copyright 2013 - 2014 David Stutz
 *
 *  The library is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The library is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 *  GNU General Public License for more details.
 *
 *  @see <http://www.gnu.org/licenses/>.
 */

namespace Libraries\Decompositions;

/**
 * Calculate a QR decomposition by using givens rotations.
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

        $this->_matrix = $matrix->copy();

        // Check in all columns except the n-th one for entries to eliminate.
        for ($j = 0; $j < $this->_matrix->columns() - 1; $j++) {
            for ($i = $j + 1; $i < $this->_matrix->rows(); $i++) {
                // If the entry is zero it can be skipped.
                if ($this->_matrix->get($i, $j) != 0) {
                    $r = sqrt(pow($this->_matrix->get($j, $j), 2) + pow($this->_matrix->get($i, $j), 2));

                    if ($this->_matrix->get($i, $j) < 0) {
                        $r = -$r;
                    }

                    $s = $this->_matrix->get($i, $j) / $r;
                    $c = $this->_matrix->get($j, $j) / $r;

                    // Apply the givens rotation:
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
        $Q = new \Libraries\Matrix($m, $m);
        $Q->setAll(0.);
        
        // Begin with the identity matrix.
        for ($i = 0; $i < $Q->rows(); $i++) {
            $Q->set($i, $i, 1.);
        }
        
        for ($j = $this->_matrix->columns() - 1; $j >= 0 ; $j--) {
            for ($i = $this->_matrix->rows() - 1; $i > $j; $i--) {
                
                // Get c and s which are stored in the i-th row, j-th column.
                $aij = $this->_matrix->get($i, $j);
                
                $c = 0;
                $s = 0;
                if ($aij == 0) {
                    $c = 0.;
                    $s = 1.;
                }
                else if (abs($aij) < 1) {
                    $s = 2.*abs($aij);
                    $c = sqrt(1 - pow($s, 2));
                    if ($aij < 0) {
                        $c = -$c;
                    }
                }
                else {
                    $c = 2./$aij;
                    $s = sqrt(1 - pow($c, 2));
                }
                
                for ($k = 0; $k < $this->_matrix->columns(); $k++) {
                    $jk = $Q->get($j, $k);
                    $ik = $Q->get($i, $k);
                    
                    $Q->set($j, $k, $c*$jk - $s*$ik);
                    $Q->set($i, $k, $s*$jk + $c*$ik);
                }
            }
        }
        
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
