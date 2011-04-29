<?php
class GrowlError
{
	public $options = array();

	public $hosts = 'localhost';

	public $app_name = 'DogGrowl';

	public $password = 'fishstick';
	
	protected $growl;

    /**
     * Error name data
     *
     * @static array
     */
    static $phpError = array(
    E_ERROR             => 'E_ERROR',
    E_WARNING           => 'E_WARNING',
    E_PARSE             => 'E_PARSE',
    E_NOTICE            => 'E_NOTICE',
    E_CORE_ERROR        => 'E_CORE_ERROR',
    E_CORE_WARNING      => 'E_CORE_WARNING',
    E_COMPILE_ERROR     => 'E_COMPILE_ERROR',
    E_COMPILE_WARNING   => 'E_COMPILE_WARNING',
    E_USER_ERROR        => 'E_USER_ERROR',
    E_USER_WARNING      => 'E_USER_WARNING',
    E_USER_NOTICE       => 'E_USER_NOTICE',
    E_STRICT            => 'E_STRICT',
    E_RECOVERABLE_ERROR => 'E_RECOVERABLE_ERROR',
    E_DEPRECATED        => 'E_DEPRECATED',
    E_USER_DEPRECATED   => 'E_USER_DEPRECATED'
    );

	function __construct($options = array())
	{
		if (!isset($options['growl'])) {
            $options['growl'] = $this->getDefaultGrowler();
        }

        $this->setNetGrowl($options['growl']);
		$this->register();
	}

	protected function getDefaultGrowler()
	{

        $growl = Net_Growl::singleton($this->app_name, self::$phpError, $this->password, array('host'=>$this->hosts));
        $growl->register();
        return $growl;
	}

    function setNetGrowl(Net_Growl $growl)
    {
        $this->growl = $growl;
    }

	public function register()
	{
		$this->error_chain = set_error_handler(array($this, 'handleError'));
	}

	public function handleError($errno, $errstr, $errfile, $errline)
	{

	    switch ($errno) {
	    case E_USER_ERROR:
	        echo "ERROR [$errno] $errstr\n";
	        echo "  Fatal error on line $errline in file $errfile";
	        echo ", PHP " . PHP_VERSION . " (" . PHP_OS . ")\n";
	        echo "Aborting...";
	        exit(1);
	        break;
	
	    case E_USER_WARNING:
	        $message = "WARNING [$errno] $errstr in $errfile line $errline";
	        break;
	
	    case E_USER_NOTICE:
	    case E_NOTICE:
	        $message = "NOTICE [$errno] $errstr in $errfile line $errline";
	        break;

	    default:
	        $message = "Unknown error type: [$errno] $errstr in $errfile line $errline";
	        break;
	    }

	    $this->growl->notify(self::$phpError[$errno], self::$phpError[$errno], $message);

	    /* Don't execute PHP internal error handler */
	    return true;
	}
}