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
        $application = $event->getApplication();
        $routeMatch = $event->getRouteMatch();

        if ($routeMatch !== null) {
            $routeMatch = $routeMatch->getMatchedRouteName();
        } else {
            return;
        }

        $request = $application->getRequest();

        if ($request->isXmlHttpRequest()) {
            return;
        }

        $response = $application->getResponse();
        $headers = $response->getHeaders();
        if ($headers->has('Content-Type')
            && false !== strpos($headers->get('Content-Type')->getFieldValue(), 'html')
        ) {
            return;
        }

        // Limit on particular routes if is in auto apply
        if (in_array($routeMatch, $this->options["route"])) {
            $this->injectSdk($event);
        }
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
