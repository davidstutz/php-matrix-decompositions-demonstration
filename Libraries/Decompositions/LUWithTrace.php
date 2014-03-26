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
 * Calculate a LU decomposition.
 *
 * @author  David Stutz
 * @license http://www.gnu.org/licenses/gpl-3.0
 */
class LUWithTrace extends LU {

    /**
     * @var array
     */
    protected $_trace = array();

    /**
     * Constructor: Generate LU decomposition of the matrix.
     * As trace the permutated matrix and eliminated matrix of each step is stored.
     *
     * @param   matrix  matrix to get lu decomposition of
     * @return  vector  permutation
     */
    public function __construct(&$matrix) {
        new \Libraries\Assertion($matrix instanceof \Libraries\Matrix, 'Given matrix not of class Matrix.');
        new \Libraries\Assertion($matrix->isSquare(), 'Matrix is not square.');

        $this->_matrix = $matrix->copy();
        $this->_permutation = new \Libraries\Vector($this->_matrix->rows());
        
        for ($j = 0; $j < $this->_matrix->rows(); $j++) {

            $pivot = $j;
            for ($i = $j + 1; $i < $this->_matrix->rows(); $i++) {
                if (abs($this->_matrix->get($i, $j)) > abs($this->_matrix->get($pivot, $j))) {
                    $pivot = $i;
                }
            }

            $this->_permutation->set($j, $pivot);

            $this->_matrix->swapRows($j, $pivot);

            // Save the matrix after permutation.
            $this->_trace[$j] = array('permutation' => $this->_matrix->copy(), );

            for ($i = $j + 1; $i < $this->_matrix->columns(); $i++) {
                $this->_matrix->set($i, $j, $this->_matrix->get($i, $j) / $this->_matrix->get($j, $j));

                for ($k = $j + 1; $k < $this->_matrix->columns(); $k++) {
                    $this->_matrix->set($i, $k, $this->_matrix->get($i, $k) - $this->_matrix->get($i, $j) * $this->_matrix->get($j, $k));
                }
            }

            // Save the matrix after elimination.
            $this->_trace[$j]['elimination'] = $this->_matrix->copy();
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
