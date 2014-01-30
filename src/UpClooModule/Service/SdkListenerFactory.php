<?php
namespace UpClooModule\Service;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;

class SdkListenerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceManager)
    {
        $config = $serviceManager->get("Config");
        return new \UpClooModule\Listener\SdkListener($serviceManager->get('ViewRenderer'), $config["upcloo"]);
    }
}
