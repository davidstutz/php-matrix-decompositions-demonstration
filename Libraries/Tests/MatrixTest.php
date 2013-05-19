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
    
    /**
     * Provides data for testing constructor exceptions.
     * 
     * @return  array   data
     */
    public function providerConstructExceptions() {
        return array(
            array(
                0,
                0,
            ),
            array(
                10,
                -10,
            ),
            array(
                -10,
                10,
            ),
            array(
                0.999,
                10,
            ),
            array(
                10,
                0.999
            ),
            array(
                0.111,
                10,
            ),
            array(
                10,
                0.111,
            ),
            array(
                NULL,
                10,
            ),
            array(
                10,
                NULL,
            ),
            array(
                10,
                FALSE,
            ),
            array(
                FALSE,
                10,
            ),
        );
    }
    
    /**
     * Tests the constructor exceptions.
     * 
     * @test
     * @dataProvider providerConstructExceptions
     * @expectedException InvalidArgumentException
     * @param   mixed   rows
     * @param   mixed   columns
     */
    public function testConstructExceptions($rows, $columns) {
        $matrix = new \Libraries\Matrix($rows, $columns);
    }
    
    /**
     * Provides data for testing resize.
     * 
     * @return  array   data
     */
    public function providerResize() {
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
     * Tests resize.
     * 
     * @test
     * @dataProvider providerResize
     * @param   mixed   rows
     * @param   mixed   columns
     */
    public function testResize($rows, $columns) {
        $matrix = new \Libraries\Matrix(1, 1);
        
        $matrix->resize($rows, $columns);
        
        $this->assertSame($rows, $matrix->rows());
        $this->assertSame($columns, $matrix->columns());
    }
    
    /**
     * Provides data for testing resize exceptions
     * 
     * @return  array   data
     */
    public function providerResizeExceptions() {
        return array(
            array(
                0,
                0,
            ),
            array(
                10,
                -10,
            ),
            array(
                -10,
                10,
            ),
            array(
                0.999,
                10,
            ),
            array(
                10,
                0.999
            ),
            array(
                0.111,
                10,
            ),
            array(
                10,
                0.111,
            ),
            array(
                NULL,
                10,
            ),
            array(
                10,
                NULL,
            ),
            array(
                10,
                FALSE,
            ),
            array(
                FALSE,
                10,
            ),
        );
    }
    
    /**
     * Tests the constructor exceptions.
     * 
     * @test
     * @dataProvider providerConstructExceptions
     * @expectedException InvalidArgumentException
     * @param   mixed   rows
     * @param   mixed   columns
     */
    public function testResizeExceptions($rows, $columns) {
        $matrix = new \Libraries\Matrix(10, 10);
        
        $matrix->resize($rows, $columns);
    }
    
    /**
     * Provides data for testing fromArray.
     * 
     * @return  array   data
     */
    public function providerFromArray() {
        return array(
            array(
                array(
                    array(1, 2, 3),
                    array(4, 5, 6),
                    array(7, 8, 9),
                ),
            ),
            array(
                array(
                    array(1, 2, 3, 4, 5, 6, 7, 8, 9),
                    array(10, 11, 12, 13, 14, 15, 16, 17, 18),
                    array(19, 20, 21, 22, 23, 24, 25, 26, 27),
                    array(28, 29, 30, 31, 32, 33, 34, 35, 36),
                    array(37, 38, 39, 40, 41, 42, 43, 44, 45),
                    array(46, 47, 48, 49, 50, 51, 52, 53, 54),
                    array(55, 56, 57, 58, 59, 60, 61, 62, 63),
                    array(64, 65, 66, 67, 68, 69, 70, 71, 72),
                    array(73, 74, 75, 76, 77, 78, 79, 80, 81),
                ),
            ),
            array(
                array(
                    array(0.1, 0.2, 0.3),
                    array(0.4, 0.5, 0.6),
                    array(0.7, 0.8, 0.9),
                ),
            ),
        );
    }

    /**
     * Tests fromArray.
     * 
     * @test
     * @dataProvider providerFromArray
     * @param   array   matrix
     */
    public function testFromArray($array) {
        $matrix = new \Libraries\Matrix(sizeof($array), sizeof($array[0]));
        
        $matrix->fromArray($array);
        
        for ($i = 0; $i < $matrix->rows(); $i++) {
            for ($j = 0; $j < $matrix->columns(); $j++) {
                $this->assertSame($array[$i][$j], $matrix->get($i, $j));
            }
        }
    }
    
    /**
     * Provides data for testing isSquare.
     * 
     * @return  array   data
     */
    public function providerIsSquare() {
        return array(
            array(
                10,
                10,
                TRUE,
            ),
            array(
                10,
                9,
                FALSE,
            ),
            array(
                9.999,
                10,
                FALSE,
            ),
        );
    }
    
    /**
     * Tests isSquare.
     * 
     * @test
     * @dataProvider providerIsSquare
     * @param   mixed   rows
     * @param   mixed   columns
     * @param   boolean square
     */
    public function testIsSquare($rows, $columns, $expected) {
        $matrix = new \Libraries\Matrix($rows, $columns);
        
        $this->assertSame($expected, $matrix->isSquare());
    }
    
    /**
     * Provides data for testing asArray.
     * 
     * @return  array   data
     */
    public function providerAsArray() {
        return array(
            array(
                array(
                    array(1, 2, 3),
                    array(4, 5, 6),
                    array(7, 8, 9),
                ),
            ),
            array(
                array(
                    array(1, 2, 3, 4, 5, 6, 7, 8, 9),
                    array(10, 11, 12, 13, 14, 15, 16, 17, 18),
                    array(19, 20, 21, 22, 23, 24, 25, 26, 27),
                    array(28, 29, 30, 31, 32, 33, 34, 35, 36),
                    array(37, 38, 39, 40, 41, 42, 43, 44, 45),
                    array(46, 47, 48, 49, 50, 51, 52, 53, 54),
                    array(55, 56, 57, 58, 59, 60, 61, 62, 63),
                    array(64, 65, 66, 67, 68, 69, 70, 71, 72),
                    array(73, 74, 75, 76, 77, 78, 79, 80, 81),
                ),
            ),
            array(
                array(
                    array(0.1, 0.2, 0.3),
                    array(0.4, 0.5, 0.6),
                    array(0.7, 0.8, 0.9),
                ),
            ),
        );
    }

    /**
     * Tests asArray.
     * 
     * @test
     * @dataProvider providerAsArray
     * @param   array   matrix
     */
    public function testAsArray($array) {
        $matrix = new \Libraries\Matrix(sizeof($array), sizeof($array[0]));
        
        $matrix->fromArray($array);
        
        $asArray = $matrix->asArray();
        
        for ($i = 0; $i < $matrix->rows(); $i++) {
            for ($j = 0; $j < $matrix->columns(); $j++) {
                $this->assertSame($array[$i][$j], $asArray[$i][$j]);
            }
        }
    }
    
    /**
     * Provides data for testing equals.
     * 
     * @return  array   data
     */
    public function providerEquals() {
        return array(
            array(
                array(
                    array(1, 2, 3),
                    array(4, 5, 6),
                    array(7, 8, 9),
                ),
                array(
                    array(1, 2, 3),
                    array(4, 5, 6),
                    array(7, 8, 9),
                ),
                TRUE,
            ),
            array(
                array(
                    array(1, 2, 3, 4, 5, 6, 7, 8, 9),
                    array(10, 11, 12, 13, 14, 15, 16, 17, 18),
                    array(19, 20, 21, 22, 23, 24, 25, 26, 27),
                    array(28, 29, 30, 31, 32, 33, 34, 35, 36),
                    array(37, 38, 39, 40, 41, 42, 43, 44, 45),
                    array(46, 47, 48, 49, 50, 51, 52, 53, 54),
                    array(55, 56, 57, 58, 59, 60, 61, 62, 63),
                    array(64, 65, 66, 67, 68, 69, 70, 71, 72),
                    array(73, 74, 75, 76, 77, 78, 79, 80, 81),
                ),
                array(
                    array(1, 2, 3, 4, 5, 6, 7, 8, 9),
                    array(10, 11, 12, 13, 14, 15, 16, 17, 18),
                    array(19, 20, 21, 22, 23, 24, 25, 26, 27),
                    array(28, 29, 30, 31, 32, 33, 34, 35, 36),
                    array(37, 38, 39, 40, 40.9, 42, 43, 44, 45), // <-- incorrect entry.
                    array(46, 47, 48, 49, 50, 51, 52, 53, 54),
                    array(55, 56, 57, 58, 59, 60, 61, 62, 63),
                    array(64, 65, 66, 67, 68, 69, 70, 71, 72),
                    array(73, 74, 75, 76, 77, 78, 79, 80, 81),
                ),
                FALSE,
            ),
            array(
                array(
                    array(0.1, 0.2, 0.3),
                    array(0.4, 0.5, 0.6),
                    array(0.7, 0.8, 0.9),
                ),
                array(
                    array(1, 2, 3),
                    array(4, 5, 6),
                    array(7, 8, 9),
                ),
                FALSE,
            ),
        );
    }

    /**
     * Tests equals.
     * 
     * @test
     * @dataProvider providerEquals
     * @param   array   first matrix
     * @param   array   second matrix
     * @param   boolean expected
     */
    public function testEquals($first, $second, $expected) {
        $firstMatrix = new \Libraries\Matrix(sizeof($first), sizeof($first[0]));
        $secondMatrix = new \Libraries\Matrix(sizeof($second), sizeof($second[0]));
        
        $firstMatrix->fromArray($first);
        $secondMatrix->fromArray($second);
        
        $this->assertSame($expected, $firstMatrix->equals($secondMatrix));
        $this->assertSame($expected, $secondMatrix->equals($firstMatrix));
    }
    
    /**
     * Provides data for testing equals exceptions.
     * 
     * @return  array   data
     */
    public function providerEqualsExceptions() {
        return array(
            array(
                array(
                    array(1, 2, 3),
                    array(4, 5, 6),
                    array(7, 8, 9),
                ),
                array(
                    array(1, 2),
                    array(4, 5),
                    array(7, 8),
                ),
            ),
            array(
                array(
                    array(1, 2, 3),
                    array(4, 5, 6),
                ),
                array(
                    array(1, 2, 3),
                    array(4, 5, 6),
                    array(7, 8, 9),
                ),
            ),
        );
    }
    
    /**
     * Tests equals exceptions.
     * 
     * @test
     * @dataProvider providerEqualsExceptions
     * @param   array   first matrix
     * @param   array   second matrix
     */
    public function testEqualsExceptions($first, $second) {
        $firstMatrix = new \Libraries\Matrix(sizeof($first), sizeof($first[0]));
        $secondMatrix = new \Libraries\Matrix(sizeof($second), sizeof($second[0]));
        
        $firstMatrix->fromArray($first);
        $secondMatrix->fromArray($second);
        
        try {
            $firstMatrix->equals($secondMatrix);
            
            // IF not catched exception here we failed.
            $this->fail('InvalidArgumentException expected.');
        }
        catch (\InvalidArgumentException $e) {
            
        }
        
        try {
            $secondMatrix->equals($firstMatrix);
            
            // IF not catched exception here we failed.
            $this->fail('InvalidArgumentException expected.');
        }
        catch (\InvalidArgumentException $e) {
            
        }
    }
    
    /**
     * Provides data for testing get expcetions.
     * 
     * @return  array   data
     */
    public function providerGetExceptions() {
        return array(
            array(
                array(
                    array(1, 2, 3),
                    array(4, 5, 6),
                    array(7, 8, 9),
                ),
                1,
                4,
            ),
            array(
                array(
                    array(1, 2, 3),
                    array(4, 5, 6),
                    array(7, 8, 9),
                ),
                4,
                1,
            ),
            array(
                array(
                    array(1, 2, 3),
                    array(4, 5, 6),
                    array(7, 8, 9),
                ),
                1,
                -1,
            ),
            array(
                array(
                    array(1, 2, 3),
                    array(4, 5, 6),
                    array(7, 8, 9),
                ),
                -1,
                1,
            ),
        );
    }

    /**
     * Tests get exceptions.
     * 
     * @test
     * @dataProvider providerGetExceptions
     * @expectedException InvalidArgumentException
     * @param   array   matrix
     * @param   mixed   row
     * @param   mixed   columns
     */
    public function testGetExceptions($array, $row, $column) {
        $matrix = new \Libraries\Matrix(sizeof($array), sizeof($array[0]));
        
        $matrix->fromArray($array);
        
        $matrix->get($row, $column);
    }
    
    /**
     * Provides data for testing set expcetions.
     * 
     * @return  array   data
     */
    public function providerSetExceptions() {
        return array(
            array(
                array(
                    array(1, 2, 3),
                    array(4, 5, 6),
                    array(7, 8, 9),
                ),
                1,
                4,
            ),
            array(
                array(
                    array(1, 2, 3),
                    array(4, 5, 6),
                    array(7, 8, 9),
                ),
                4,
                1,
            ),
            array(
                array(
                    array(1, 2, 3),
                    array(4, 5, 6),
                    array(7, 8, 9),
                ),
                1,
                -1,
            ),
            array(
                array(
                    array(1, 2, 3),
                    array(4, 5, 6),
                    array(7, 8, 9),
                ),
                -1,
                1,
            ),
        );
    }

    /**
     * Tests set exceptions.
     * 
     * @test
     * @dataProvider providerSetExceptions
     * @expectedException InvalidArgumentException
     * @param   array   matrix
     * @param   mixed   row
     * @param   mixed   columns
     */
    public function testSetExceptions($array, $row, $column) {
        $matrix = new \Libraries\Matrix(sizeof($array), sizeof($array[0]));
        
        $matrix->fromArray($array);
        
        $matrix->set($row, $column, 1);
    }
    
    /**
     * Provides data for testing setAll.
     * 
     * @return  array   data
     */
    public function providerSetAll() {
        return array(
            array(
                1,
            ),
            array(
                0.001
            ),
            array(
                10000000,
            ),
            array(
                NULL,
            ),
            array(
                FALSE,
            ),
            array(
                -0.001,
            ),
        );
    }
    
    /**
     * Tests setAll.
     * 
     * @test
     * @dataProvider providerSetAll
     * @param   mixed   value
     */
    public function testSetAll($value) {
        $matrix = new \Libraries\Matrix(10, 10);
        
        $matrix->setAll($value);
        
        for ($i = 0; $i < $matrix->rows(); $i++) {
            for ($j = 0; $j < $matrix->columns(); $j++) {
                $this->assertSame($value, $matrix->get($i, $j));
            }
        }
    }
    
    /**
     * Provides data for testing copy.
     * 
     * @return  array   data
     */
    public function providerCopy() {
        return array(
            array(
                array(
                    array(1, 2, 3),
                    array(4, 5, 6),
                    array(7, 8, 9),
                ),
            ),
            array(
                array(
                    array(1, 2, 3, 4, 5, 6, 7, 8, 9),
                    array(10, 11, 12, 13, 14, 15, 16, 17, 18),
                    array(19, 20, 21, 22, 23, 24, 25, 26, 27),
                    array(28, 29, 30, 31, 32, 33, 34, 35, 36),
                    array(37, 38, 39, 40, 41, 42, 43, 44, 45),
                    array(46, 47, 48, 49, 50, 51, 52, 53, 54),
                    array(55, 56, 57, 58, 59, 60, 61, 62, 63),
                    array(64, 65, 66, 67, 68, 69, 70, 71, 72),
                    array(73, 74, 75, 76, 77, 78, 79, 80, 81),
                ),
            ),
            array(
                array(
                    array(0.1, 0.2, 0.3),
                    array(0.4, 0.5, 0.6),
                    array(0.7, 0.8, 0.9),
                ),
            ),     
        );
    }

    /**
     * Tests copy.
     * 
     * @test
     * @dataProvider providerCopy
     * @param   array   matrix
     */
    public function testCopy($array) {
        $matrix = new \Libraries\Matrix(sizeof($array), sizeof($array[0]));
        
        $copy = $matrix->copy();
        
        $this->assertSame($matrix->rows(), $copy->rows());
        $this->assertSame($matrix->columns(), $copy->columns());
        
        for ($i = 0; $i < $copy->rows(); $i++) {
            for ($j = 0; $j < $copy->columns(); $j++) {
                $this->assertSame($matrix->get($i, $j), $copy->get($i, $j));
            }
        }
    }
    
    /**
     * Provides data for testing swapColumns.
     * 
     * @return  array   data
     */
    public function providerSwapColumns() {
        return array(
            array(
                array(
                    array(1, 2, 3),
                    array(4, 5, 6),
                    array(7, 8, 9),
                ),
                1,
                2,
                array(
                    array(1, 3, 2),
                    array(4, 6, 5),
                    array(7, 9, 8),
                ),
            ),
            array(
                array(
                    array(1, 2, 3, 4, 5, 6, 7, 8, 9),
                    array(10, 11, 12, 13, 14, 15, 16, 17, 18),
                    array(19, 20, 21, 22, 23, 24, 25, 26, 27),
                    array(28, 29, 30, 31, 32, 33, 34, 35, 36),
                    array(37, 38, 39, 40, 41, 42, 43, 44, 45),
                    array(46, 47, 48, 49, 50, 51, 52, 53, 54),
                    array(55, 56, 57, 58, 59, 60, 61, 62, 63),
                    array(64, 65, 66, 67, 68, 69, 70, 71, 72),
                    array(73, 74, 75, 76, 77, 78, 79, 80, 81),
                ),
                0,
                8,
                array(
                    array(9, 2, 3, 4, 5, 6, 7, 8, 1),
                    array(18, 11, 12, 13, 14, 15, 16, 17, 10),
                    array(27, 20, 21, 22, 23, 24, 25, 26, 19),
                    array(36, 29, 30, 31, 32, 33, 34, 35, 28),
                    array(45, 38, 39, 40, 41, 42, 43, 44, 37),
                    array(54, 47, 48, 49, 50, 51, 52, 53, 46),
                    array(63, 56, 57, 58, 59, 60, 61, 62, 55),
                    array(72, 65, 66, 67, 68, 69, 70, 71, 64),
                    array(81, 74, 75, 76, 77, 78, 79, 80, 73),
                ),
            ),
        );
    }

    /**
     * Tests swapColumns.
     * 
     * @test
     * @dataProvider providerSwapColumns
     * @param   array   matrix
     * @param   int     column
     * @param   int     column
     * @param   array   expected
     */
    public function testSwapColumns($array, $i, $j, $expected) {
        $matrix = new \Libraries\Matrix(sizeof($array), sizeof($array[0]));
        
        $matrix->fromArray($array);
        
        $matrix->swapColumns($i, $j);
        
        for ($i = 0; $i < $matrix->rows(); $i++) {
            for ($j = 0; $j < $matrix->columns(); $j++) {
                $this->assertSame($expected[$i][$j], $matrix->get($i, $j));
            }
        }
    }
    
    /**
     * Provides data for testing swapRows.
     * 
     * @return  array   data
     */
    public function providerSwapRows() {
        return array(
            array(
                array(
                    array(1, 2, 3),
                    array(4, 5, 6),
                    array(7, 8, 9),
                ),
                1,
                2,
                array(
                    array(1, 2, 3),
                    array(7, 8, 9),
                    array(4, 5, 6),
                ),
            ),
            array(
                array(
                    array(1, 2, 3, 4, 5, 6, 7, 8, 9),
                    array(10, 11, 12, 13, 14, 15, 16, 17, 18),
                    array(19, 20, 21, 22, 23, 24, 25, 26, 27),
                    array(28, 29, 30, 31, 32, 33, 34, 35, 36),
                    array(37, 38, 39, 40, 41, 42, 43, 44, 45),
                    array(46, 47, 48, 49, 50, 51, 52, 53, 54),
                    array(55, 56, 57, 58, 59, 60, 61, 62, 63),
                    array(64, 65, 66, 67, 68, 69, 70, 71, 72),
                    array(73, 74, 75, 76, 77, 78, 79, 80, 81),
                ),
                0,
                8,
                array(
                    array(73, 74, 75, 76, 77, 78, 79, 80, 81),
                    array(10, 11, 12, 13, 14, 15, 16, 17, 18),
                    array(19, 20, 21, 22, 23, 24, 25, 26, 27),
                    array(28, 29, 30, 31, 32, 33, 34, 35, 36),
                    array(37, 38, 39, 40, 41, 42, 43, 44, 45),
                    array(46, 47, 48, 49, 50, 51, 52, 53, 54),
                    array(55, 56, 57, 58, 59, 60, 61, 62, 63),
                    array(64, 65, 66, 67, 68, 69, 70, 71, 72),
                    array(1, 2, 3, 4, 5, 6, 7, 8, 9),
                ),
            ),
        );
    }

    /**
     * Tests swapRows.
     * 
     * @test
     * @dataProvider providerSwapRows
     * @param   array   matrix
     * @param   int     column
     * @param   int     column
     * @param   array   expected
     */
    public function testSwapRows($array, $i, $j, $expected) {
        $matrix = new \Libraries\Matrix(sizeof($array), sizeof($array[0]));
        
        $matrix->fromArray($array);
        
        $matrix->swapRows($i, $j);
        
        for ($i = 0; $i < $matrix->rows(); $i++) {
            for ($j = 0; $j < $matrix->columns(); $j++) {
                $this->assertSame($expected[$i][$j], $matrix->get($i, $j));
            }
        }
    }
}
    