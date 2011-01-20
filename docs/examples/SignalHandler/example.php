<?php
declare(ticks=1);

/**
 * Example using annotated SignalHandler.
 *
 * PHP Version 5
 *
 * @category   Ding
 * @package    Examples
 * @subpackage SignalHandler
 * @author     Marcelo Gornstein <marcelog@gmail.com>
 * @license    http://www.noneyet.ar/ Apache License 2.0
 * @link       http://www.noneyet.ar/
 */
require_once 'Ding/Autoloader/Ding_Autoloader.php'; // Include ding autoloader.
Ding_Autoloader::register(); // Call autoloader register for ding autoloader.
use Ding\Container\Impl\ContainerImpl;
use Ding\Bean\Factory\Driver\SignalHandlerDriver;
use Ding\Helpers\SignalHandler\ISignalHandler;

error_reporting(E_ALL);
ini_set('display_errorrs', 1);

/**
 * This is our bean.
 */
class MySignalHandler implements ISignalHandler
{
    public function handleSignal($signal)
    {
        echo "This is your custom signal handler: " . $signal . "\n";
    }

    public function __construct()
    {
    }
}

// Here you configure the container, its subcomponents, drivers, etc.
$properties = array(
    'ding' => array(
        'log4php.properties' => './log4php.properties',
        'factory' => array(
            'bdef' => array( // Both of these drivers are optional. They are both included just for the thrill of it.
                'xml' => array('filename' => 'beans.xml'),
            ),
            // These properties will be used by the container when instantiating the beans, see beans.xml
            'properties' => array(
                'user.name' => 'nobody',
            )
        ),
        // You can configure the cache for the bean definition, the beans, and the proxy definitions.
        // Other available implementations: zend, file, dummy, and memcached.
    	'cache' => array(
            'proxy' => array('impl' => 'dummy'),
            'bdef' => array('impl' => 'dummy'),
            'beans' => array('impl' => 'dummy')
        )
    )
);
$container = ContainerImpl::getInstance($properties);
posix_kill(posix_getpid(), SIGHUP);
sleep(1);