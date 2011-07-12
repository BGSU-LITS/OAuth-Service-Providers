<?php

/**
 * The test suite for the Service providers.
 *
 * @package	Service Providers (OAuth)
 * @author	Dave Widmer (dwidmer@bgsu.edu)
 */
class TestSuite
{
    /**
     * Returns the whole test suite for the Service classes
     *
     * @return PHPUnit_Framework_TestSuite
     */
    public static function suite()
    {   
        $suite = new PHPUnit_Framework_TestSuite();
        $suite->addTestSuite('ServiceFlickrTest');

        return $suite;
    }
}