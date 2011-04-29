<?php
/**
 * Unit tests for Net_Growl package
 *
 * PHP version 5
 *
 * @category Networking
 * @package  Net_Growl
 * @author   Laurent Laville <pear@laurent-laville.org>
 * @license  http://www.opensource.org/licenses/bsd-license.php  BSD
 * @version  SVN: $Id: AllTests.php 307450 2011-01-13 21:46:13Z farell $
 * @link     http://pear.php.net/package/Net_Growl
 * @since    File available since Release 2.1.0
 */

if (!defined('PHPUnit_MAIN_METHOD')) {
    define('PHPUnit_MAIN_METHOD', 'Net_Growl_AllTests::main');
}

require_once 'PHPUnit/Framework.php';
require_once 'PHPUnit/TextUI/TestRunner.php';

require_once dirname(__FILE__) . '/Growl/GntpTest.php';
require_once dirname(__FILE__) . '/Growl/GntpMockTest.php';

class Net_Growl_AllTests
{
    public static function main()
    {
        PHPUnit_TextUI_TestRunner::run(
            self::suite(),
            array()
        );
    }

    public static function suite()
    {
        $suite = new PHPUnit_Framework_TestSuite('Net_Growl package');
        $suite->addTestSuite('Net_Growl_GntpTest');
        $suite->addTestSuite('Net_Growl_GntpMockTest');

        return $suite;
    }
}

if (PHPUnit_MAIN_METHOD == 'Net_Growl_AllTests::main') {
    Net_Growl_AllTests::main();
}
