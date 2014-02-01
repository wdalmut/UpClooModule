<?php
namespace UpClooModule\Listener;

use Zend\Version\Version;
use Zend\View\Model\ViewModel;
use Zend\View\Exception\RuntimeException;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Mvc\MvcEvent;

class SdkListener implements ListenerAggregateInterface
{
    protected $renderer;
    protected $listeners = array();
    protected $options;

    public function __construct($viewRenderer, $config)
    {
        $this->options = $config;
        $this->renderer = $viewRenderer;
    }

    public function attach(EventManagerInterface $events)
    {
        $this->listeners[] = $events->attach(
            MvcEvent::EVENT_FINISH,
            array($this, 'onExecuted'),
            -1002
        );
    }

    public function detach(EventManagerInterface $events)
    {
        foreach ($this->listeners as $index => $listener) {
            if ($events->detach($listener)) {
                unset($this->listeners[$index]);
            }
        }
    }

    public function onExecuted(MvcEvent $event)
    {
        if ($this->isSdkNotInjectable($event)) {
            return;
        }

        $routeMatch = $event->getRouteMatch();
        $routeMatch = $routeMatch->getMatchedRouteName();

        // Limit on particular routes if is in auto apply
        if (in_array($routeMatch, $this->options["route"])) {
            $this->injectSdk($event);
        }
    }

    protected function IsSdkNotInjectable($event)
    {
        $routeMatch = $event->getRouteMatch();
        $request = $event->getApplication()->getRequest();
        $headers = $event->getApplication()->getResponse()->getHeaders();

        if (!$routeMatch) {
            return true;
        }

        if ($request->isXmlHttpRequest()) {
            return true;
        }

        if ($headers->has('Content-Type') && strpos($headers->get('Content-Type')->getFieldValue(), 'html') !== false) {
            return true;
        }

        return false;
    }

    public function injectSdk(MvcEvent $event)
    {
        $sdk = $this->renderer->upclooSdk(
            $this->renderer->serverUrl() . $event->getApplication()->getRequest()->getRequestUri()
        );
        $response = $event->getApplication()->getResponse();;

        $injected    = preg_replace('/<\/body>/i', $sdk . "\n</body>", $response->getBody(), 1);

        $response->setContent($injected);
    }
}
