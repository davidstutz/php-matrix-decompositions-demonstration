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
 * Calculate a QR decomposition by using householder transformation.
 *
 * @author  David Stutz
 * @license http://www.gnu.org/licenses/gpl-3.0
 */
class QRHouseholder {
    
    /**
     * @var matrix
     */
    protected $_matrix;
    
    /**
     * @var vector
     */
    protected $_tau;
    
    /**
     * Constructor: Get the qr decomposition of the given matrix using householder transformations.
     * The single householder matrizes are stores within the matrix.
     *
     * @param matrix  matrix to get the composition of
     */
    public function __construct(&$matrix) {
        new \Libraries\Assertion($matrix instanceof \Libraries\Matrix, 'Given matrix not of class Matrix.');

        $this->_tau = new \Libraries\Vector($matrix->columns());
        $this->_matrix = $matrix->copy();

        for ($j = 0; $j < $this->_matrix->columns(); $j++) {

            $norm = 0.;
            for ($i = $j; $i < $this->_matrix->rows(); $i++) {
                $norm += pow($this->_matrix->get($i, $j), 2);
            }
            $norm = sqrt($norm);

            $sign = 1.;
            if ($this->_matrix->get($j, $j) < 0) {
                $sign = -1.;
            }

            $v1 = $this->_matrix->get($j, $j) + $sign * $norm;
            $scalar = 1;

            for ($i = $j + 1; $i < $this->_matrix->rows(); $i++) {
                $this->_matrix->set($i, $j, $this->_matrix->get($i, $j) / $v1);
                $scalar += pow($this->_matrix->get($i, $j), 2);
            }

            $this->_tau->set($j, 2. / $scalar);

            $w = new \Libraries\Vector($this->_matrix->columns());
            $w->setAll(0.);

            // First calculate w = v_j^T * A.
            for ($i = $j; $i < $this->_matrix->columns(); $i++) {
                $w->set($i, $this->_matrix->get($j, $i));
                for ($k = $j + 1; $k < $this->_matrix->rows(); $k++) {
                    if ($i == $j) {
                        $w->set($i, $w->get($i) + $this->_matrix->get($k, $j) * $this->_matrix->get($k, $i) * $v1);
                    }
                    else {
                        $w->set($i, $w->get($i) + $this->_matrix->get($k, $j) * $this->_matrix->get($k, $i));
                    }
                }

                $this->_matrix->set($j, $i, $this->_matrix->get($j, $i) - $this->_tau->get($j) * $w->get($i));
                for ($k = $j + 1; $k < $this->_matrix->rows(); $k++) {
                    if ($i > $j) {
                        $this->_matrix->set($k, $i, $this->_matrix->get($k, $i) - $this->_tau->get($j) * $this->_matrix->get($k, $j) * $w->get($i));
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
        // Q is an m x m matrix if m is the maximum of the number of rows and thenumber of columns.
        $m = max($this->_matrix->columns(), $this->_matrix->rows());
        $Q = new \Libraries\Matrix($m, $m);
        $Q->setAll(0.);
        
        // Begin with the identity matrix.
        for ($i = 0; $i < min($Q->rows(), $Q->columns()); $i++) {
            $Q->set($i, $i, 1.);
        }
        
        // Got backwards through all householder transformations and apply them on
        for ($k = $this->_matrix->columns() - 1; $k >= 0; $k--) {
            for ($j = $k; $j < $Q->columns(); $j++) {
                
                // First compute w^T(j) = v^T * Q(j) where Q(j) is the j-th column of Q.
                $w = $Q->get($k, $j)*1.;
                for ($i = $k + 1; $i < $Q->rows(); $i++) {
                    $w += $this->_matrix->get($i, $k)*$Q->get($i, $j);
                }
                
                // Now : Q(i,j) = Q(i,j) - tau(k)*v(i)*w(j).
                $Q->set($k, $j, $Q->get($k, $j) - $this->_tau->get($k)*1.*$w);
                for ($i = $k + 1; $i < $Q->rows(); $i++) {
                    $Q->set($i, $j, $Q->get($i, $j) - $this->_tau->get($k)*$this->_matrix->get($i, $k)*$w);
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
        $n = min($R->rows(), $R->columns());
        
        for ($i = 0; $i < $R->rows(); $i++) {
            for ($j = 0; $j < $i AND $j < $n; $j++) {
                $R->set($i, $j, 0);
            }
        }
        
        return $R;
    }
}
