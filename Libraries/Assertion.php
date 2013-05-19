<?php

namespace Libraries;

/**
 * Assertion class.
 *
 * @author  David Stutz
 * @license http://www.gnu.org/licenses/gpl-3.0
 */
class Assertion {
    
    /**
     * Constructor: Check the given booealn and throw exception with given message iff not true.
     * 
     * @throws  IllegalArgumentException
     */
    public function __construct($boolean, $message) {
        if (!$boolean) {
            throw new \InvalidArgumentException($message);
        }
    }
}
