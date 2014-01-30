<?php
namespace UpClooModule\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class UpClooFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceManager)
    {
        $config = $serviceManager->get("Config");
        $sitekey = $config["upcloo"]["sitekey"];

        $upcloo = $serviceManager->get("upcloo.manager");
        $upcloo->setSitekey($sitekey);

        return $upcloo;

    }
}
