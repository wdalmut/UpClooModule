<?php
namespace UpClooModule\Service;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;

class UpClooManagerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceManager)
    {
        $upcloo = new \UpCloo_Manager();
        $upcloo->setClient(new \UpCloo_Client_UpCloo);

        return $upcloo;
    }

}
