<?php
namespace UpClooModule\Listener;

use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch;
use Zend\View\Renderer\PhpRenderer;

class SdkListenerTest extends \PHPUnit_Framework_TestCase
{
    public function testSdkNotInjectable()
    {
        $listener = $this->getMockBuilder("UpClooModule\\Listener\\SdkListener")
            ->disableOriginalConstructor()
            ->setMethods(["isSdkNotInjectable"])
            ->getMock();

        $listener->expects($this->once())
            ->method("isSdkNotInjectable")
            ->will($this->returnValue(true));
        $listener->expects($this->never())
            ->method("injectSdk");

        $event = new MvcEvent();
        $listener->onExecuted($event);
    }

    public function testInjectSdkIsCalled()
    {
        $listener = $this->getMock(
            "UpClooModule\\Listener\\SdkListener",
            ["isSdkNotInjectable", "injectSdk"],
            [new PhpRenderer(), ["route" => ["route/match"]]]
        );

        $listener->expects($this->once())
            ->method("isSdkNotInjectable")
            ->will($this->returnValue(false));
        $listener->expects($this->once())
            ->method("injectSdk")
            ->will($this->returnValue(null));

        $routeMatch = new RouteMatch([]);
        $routeMatch->setMatchedRouteName("route/match");
        $event = new MvcEvent();
        $event->setRouteMatch($routeMatch);

        $listener->onExecuted($event);
    }

    public function testNotInjectSdkOnInvalidRoutes()
    {
        $listener = $this->getMock(
            "UpClooModule\\Listener\\SdkListener",
            ["isSdkNotInjectable", "injectSdk"],
            [new PhpRenderer(), ["route" => ["application"]]]
        );

        $listener->expects($this->once())
            ->method("isSdkNotInjectable")
            ->will($this->returnValue(false));
        $listener->expects($this->never())
            ->method("injectSdk")
            ->will($this->returnValue(null));

        $routeMatch = new RouteMatch([]);
        $routeMatch->setMatchedRouteName("route/match");
        $event = new MvcEvent();
        $event->setRouteMatch($routeMatch);

        $listener->onExecuted($event);
    }
}
