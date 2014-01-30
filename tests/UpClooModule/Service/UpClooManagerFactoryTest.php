<?php
namespace UpClooModule\Service;

use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\Config as ServiceManagerConfig;

class UpClooManagerFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->object = new UpClooManagerFactory();
    }

    public function testObjectIsValid()
    {
        $conf = include UPCLOO_MODULE_ROOT . '/configs/module.config.php';
        $serviceManager = new ServiceManager();

        $config = new ServiceManagerConfig($conf["service_manager"]);
        $config->configureServiceManager($serviceManager);

        $serviceManager->setService("Config", $conf);

        $upcloo =  $this->object->createService($serviceManager);

        $this->assertInstanceOf("UpCloo_Manager", $upcloo);
    }

}
