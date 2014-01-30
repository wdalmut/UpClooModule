<?php
namespace UpClooModule\Service;

use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\Config as ServiceManagerConfig;

use Zend\View\Renderer\PhpRenderer;

class SdkListenerFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->object = new SdkListenerFactory();
    }

    public function testCreateService()
    {
        $serviceManager = new ServiceManager();

        $conf = include UPCLOO_MODULE_ROOT . '/configs/module.config.php';

        $config = new ServiceManagerConfig($conf);
        $config->configureServiceManager($serviceManager);

        $serviceManager->setService("Config", $conf);
        $serviceManager->setService("ViewRenderer", new PhpRenderer());

        $object = $this->object->createService($serviceManager);

        $this->assertInstanceOf("UpClooModule\\Listener\\SdkListener", $object);
    }
}
