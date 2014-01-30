<?php

namespace UpClooModule;

use Zend\Mvc\MvcEvent;

/**
 *
 */
class Module
{
    /**
     * @param MvcEvent $event
     */
    public function onBootstrap($event)
    {
        $application    = $event->getApplication();
        $eventManager   = $application->getEventManager();
        $serviceManager = $application->getServiceManager();
        $renderer       = $serviceManager->get('viewRenderer');
        $config         = $application->getConfig();

        $upclooSdk = $renderer->getHelperPluginManager()->get("upclooSdk");
        $upclooSdk->sitekey = $serviceManager->get("upcloo")->getSitekey();

        $upclooForSpiders = $renderer->getHelperPluginManager()->get("upclooForSpiders");
        $upclooForSpiders->upclooInstance = $serviceManager->get("upcloo");

        if ($config["upcloo"]["auto_apply"]) {
            $eventManager->attach($serviceManager->get("UpClooModule\SdkListener"));
        }
    }

    /**
     * return array
     */
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    /**
     * @return array
     */
    public function getConfig()
    {
        return include __DIR__ . '/configs/module.config.php';
    }
}
