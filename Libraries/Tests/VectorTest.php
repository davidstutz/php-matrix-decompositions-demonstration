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
}