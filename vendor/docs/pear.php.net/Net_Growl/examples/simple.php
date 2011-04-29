<?php
/**
 * Example that send notifications to Growl using the old UDP protocol
 *
 * PHP version 5
 *
 * @category Networking
 * @package  Net_Growl
 * @author   Laurent Laville <pear@laurent-laville.org>
 * @author   Bertrand Mansion <bmansion@mamasam.com>
 * @license  http://www.opensource.org/licenses/bsd-license.php  BSD
 * @version  SVN: Release: @package_version@
 * @link     http://growl.laurent-laville.org/
 * @since    File available since Release 0.9.0
 */
set_include_path(__DIR__ . '/../src');
ini_set('display_errors', true);


class DogGrowl
{
	protected $growl;

	function __construct(Net_Growl $growl = null)
	{
		if (!isset($growl)) {
			$growl = $this->getDefaultGrowler();
		}

		$this->setNetGrowl($growl);
		set_error_handler(array($this, 'notify'));
	}

	function getDefaultGrowler()
	{
		require_once 'Net/Growl.php';

        // Notification Type definitions
        define('GROWL_NOTIFY_STATUS', 'GROWL_NOTIFY_STATUS');
        
        // define a PHP application that sends notifications to Growl
        $notifications = array(
            GROWL_NOTIFY_STATUS => array(
                'display' => 'Status',
            )
        );
        $appName  = 'DogGrowl';
        $password = 'fishstick';
        $growl = Net_Growl::singleton($appName, $notifications, $password, array('host'=>'localhost'));
        $growl->register();
        return $growl;
	}

	function setNetGrowl(Net_Growl $growl)
	{
		$this->growl = $growl;
	}

	function notify($errno, $errstr, $errfile, $errline)
	{
		if (!(error_reporting() & $errno)) {
	        // This error code is not included in error_reporting
	        return;
	    }
	    $name        = GROWL_NOTIFY_STATUS;
		$title       = 'PHP Error';
		$description = $errstr.' in '.$errfile.' line '.$errline.' ';

		$this->growl->notify($name, $title, $description);

	    return true;
	}
}

$growler = new DogGrowl();


echo $unknown;
