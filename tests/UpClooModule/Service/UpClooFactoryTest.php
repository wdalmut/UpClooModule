<?php
namespace UpClooModule\Service;

use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\Config as ServiceManagerConfig;

class UpClooFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->object = new UpClooFactory();
    }

    public function testObjectIsValid()
    {
        $conf = include UPCLOO_MODULE_ROOT . '/configs/module.config.php';
        $conf = array_replace_recursive($conf, ["upcloo" => ["sitekey" => "test"]]);

        $serviceManager = new ServiceManager();

        $config = new ServiceManagerConfig($conf["service_manager"]);
        $config->configureServiceManager($serviceManager);

        $serviceManager->setService("Config", $conf);

        $upcloo =  $this->object->createService($serviceManager);

        $this->assertInstanceOf("UpCloo_Manager", $upcloo);
        $this->assertEquals("test", $upcloo->getSitekey());
    }
}

