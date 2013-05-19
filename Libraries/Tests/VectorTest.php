<?php

namespace Libraries\Tests;

/**
 * VectorTest class.
 *
 * @author  David Stutz
 * @license http://www.gnu.org/licenses/gpl-3.0
 */
class VectorTest extends \PHPUnit_Framework_TestCase {
    
    /**
     * Provides data for testing constructor.
     * 
     * @return  array   data
     */
    public function providerConstruct() {
        return array(
            array(
                10,
            ),
            array(
                20,
            ),
            array(
                1000,
            ),
        );
    }
    
    /**
     * Tests the constructor.
     * 
     * @test
     * @dataProvider providerConstruct
     * @param   int size
     */
    public function testConstruct($size) {
        $vector = new \Libraries\Vector($size);
        
        $this->assertSame($size, $vector->size());
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
            ),
            array(
                -10,
            ),
            array(
                0.999
            ),
            array(
                0.111,
            ),
            array(
                NULL,
            ),
            array(
                FALSE,
            ),
        );
    }
    
    /**
     * Tests the constructor exceptions.
     * 
     * @test
     * @dataProvider providerConstructExceptions
     * @expectedException InvalidArgumentException
     * @param   mixed   size
     */
    public function testConstructExceptions($size) {
        $vector = new \Libraries\Vector($size);
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
            ),
            array(
                100,
            ),
            array(
                1000,
            ),
        );
    }
    
    /**
     * Tests resize.
     * 
     * @test
     * @dataProvider providerResize
     * @param   int size
     */
    public function testResize($size) {
        $vector = new \Libraries\Vector(1);
        
        $vector->resize($size);
        
        $this->assertSame($size, $vector->size());
    }
    
    /**
     * Provides data for testing fromArray.
     * 
     * @return  array   data
     */
    public function providerFromArray() {
        return array(
            array(
                array(1, 2, 3, 4),
            ),
            array(
                array(1, 2, 3, 4, 5, 6, 7, 8, 9),
            ),
            array(
                array(0.999, 1.111, 2.222, 3.979),
            ),
        );
    }
    
    /**
     * Tests fromArray.
     * 
     * @test
     * @dataProvider providerFromArray
     * @param   array   array
     */
    public function testFromArray($array) {
        $vector = new \Libraries\Vector(sizeof($array));
        
        $vector->fromArray($array);
        
        for ($i = 0; $i < $vector->size(); $i++) {
            $this->assertSame($vector->get($i), $array[$i]);
        }
    }
    
    /**
     * Provides data for testing asArray.
     * 
     * @return  array   data
     */
    public function providerAsArray() {
        return array(
            array(
                array(1, 2, 3, 4),
            ),
            array(
                array(1, 2, 3, 4, 5, 6, 7, 8, 9),
            ),
            array(
                array(0.999, 1.111, 2.222, 3.979),
            ),
        );
    }
    
    /**
     * Tests asArray.
     * 
     * @test
     * @dataProvider providerAsArray
     * @param   array   array
     */
    public function testAsArray($array) {
        $vector = new \Libraries\Vector(sizeof($array));
        
        $vector->fromArray($array);
        
        $asArray = $vector->asArray();
        
        $this->assertSame(sizeof($array), sizeof($asArray));
        for ($i = 0; $i < $vector->size(); $i++) {
            $this->assertSame($array[$i], $asArray[$i]);
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
                array(1, 2, 3, 4),
                array(1, 2, 3, 4),
                TRUE,
            ),
            array(
                array(1, 2, 3, 4),
                array(1.001, 2, 3, 4),
                FALSE,
            ),
        );
    }
    
    /**
     * Tests equals.
     * 
     * @test
     * @dataProvider providerEquals
     * @param   array   first vector
     * @param   array   second vector
     * @param   boolean expected
     */
    public function testEquals($first, $second, $expected) {
        $firstVector = new \Libraries\Vector(sizeof($first));
        $secondVector = new \Libraries\Vector(sizeof($second));
        
        $firstVector->fromArray($first);
        $secondVector->fromArray($second);
        
        $this->assertSame($expected, $firstVector->equals($secondVector));
        $this->assertSame($expected, $secondVector->equals($firstVector));
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
        $vector = new \Libraries\Vector(10);
        
        $vector->setAll($value);
        
        for ($i = 0; $i < $vector->size(); $i++) {
            $this->assertSame($value, $vector->get($i));
        }
    }
    
    /**
     * Provides data for testing swapEntries.
     * 
     * @return  array   data
     */
    public function providerSwapEntries() {
        return array(
            array(
                array(1, 2, 3),
                1,
                2,
                array(1, 3, 2),
            ),
            array(
                array(1, 2, 3, 4, 5, 6, 7, 8, 9),
                0,
                8,
                array(9, 2, 3, 4, 5, 6, 7, 8, 1),
            ),
        );
    }
    
    /**
     * Tests swapEntries.
     * 
     * @test
     * @dataProvider providerSwapEntries
     * @param   array   vector
     * @param   int     column
     * @param   int     columns
     * @param   array   expected
     */
    public function testSwapEntries($array, $i, $j, $expected) {
        $vector = new \Libraries\Vector(sizeof($array));
        
        $vector->fromArray($array);
        
        $vector->swapEntries($i, $j);
        
        for ($i = 0; $i < $vector->size(); $i++) {
            $this->assertSame($expected[$i], $vector->get($i));
        }
    }
}