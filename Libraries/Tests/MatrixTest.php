<?php

namespace Libraries\Tests;

/**
 * MatrixTest class.
 *
 * @author  David Stutz
 * @license http://www.gnu.org/licenses/gpl-3.0
 */
class MatrixTest extends \PHPUnit_Framework_TestCase {
    
    /**
     * Provides data for testing constructor.
     * 
     * @return  array   data
     */
    public function providerConstruct() {
        return array(
            array(
                10,
                10,
            ),
            array(
                20,
                20,
            ),
            array(
                1000,
                1000,
            ),
        );
    }
    
    /**
     * Tests the constructor.
     * 
     * @test
     * @dataProvider providerConstruct
     * @param   int rows
     * @param   int columns
     */
    public function testConstruct($rows, $columns) {
        $matrix = new \Libraries\Matrix($rows, $columns);
        
        $this->assertSame($rows, $matrix->rows());
        $this->assertSame($columns, $matrix->columns());
    }
}
    