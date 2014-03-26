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

namespace Libraries\Tests;

/**
 * DecompositionsLUTest class.
 *
 * @author  David Stutz
 * @license http://www.gnu.org/licenses/gpl-3.0
 */
class DecompositionsLUTest extends \PHPUnit_Framework_TestCase {
    
    /**
     * Provides data for testing the decomposition.
     * 
     * @return  array   data
     */
    public function provider() {
        return array(
            array(
                array( // Matrix
                    array(1, 0, 0, 0),
                    array(0, 1, 0, 0),
                    array(0, 0, 1, 0),
                    array(0, 0, 0, 1),
                ),
                array(0, 1, 2, 3), // Permutation vector.
                array( // L
                    array(1, 0, 0, 0),
                    array(0, 1, 0, 0),
                    array(0, 0, 1, 0),
                    array(0, 0, 0, 1),
                ),
                array( // R
                    array(1, 0, 0, 0),
                    array(0, 1, 0, 0),
                    array(0, 0, 1, 0),
                    array(0, 0, 0, 1),
                ),
                1, // Determinant
            ),
            array(
                array(
                    array(1, 0, 0, 0),
                    array(0, 0, 0, 1),
                    array(0, 0, 1, 0),
                    array(0, 1, 0, 0),
                ),
                array(0, 3, 2, 3),
                array(
                    array(1, 0, 0, 0),
                    array(0, 1, 0, 0),
                    array(0, 0, 1, 0),
                    array(0, 0, 0, 1),
                ),
                array(
                    array(1, 0, 0, 0),
                    array(0, 1, 0, 0),
                    array(0, 0, 1, 0),
                    array(0, 0, 0, 1),
                ),
                1,
            ),
        );
    }

    /**
     * Tests the LU decomposition.
     * 
     * @test
     * @dataProvider provider
     * @param   array   matrix
     * @param   array   permutation
     * @param   array   L
     * @param   array   U
     * @param   double  determinant
     */
    public function testLUDecomposition($array, $expectedPermutation, $expectedL, $expectedU) {
        $matrix = new \Libraries\Matrix(sizeof($array), sizeof($array[0]));
        $matrix->fromArray($array);
        
        $decomposition = new \Libraries\Decompositions\LU($matrix);
        
        $this->assertSame($expectedL, $decomposition->getL()->asArray());
        $this->assertSame($expectedU, $decomposition->getU()->asArray());
        $this->assertSame($expectedPermutation, $decomposition->getPermutation()->asArray());
    }
}
    