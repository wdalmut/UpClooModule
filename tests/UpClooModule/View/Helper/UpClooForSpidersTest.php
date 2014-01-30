<?php
namespace UpClooModuleTest\View\Helper;

use UpClooModule\View\Helper\UpClooForSpiders;
use Zend\View\Model\ViewModel;
use Zend\View\Renderer\PhpRenderer as View;
use Zend\View\Resolver\TemplateMapResolver as Resolver;

class UpClooForSpidersTest extends \PHPUnit_Framework_TestCase
{
    private $object;
    private $basePath;

    public function setUp()
    {
        $basePath = realpath(__DIR__ . '/../../resources/view_stub.phtml');
        $view = new View();
        $resolver = new Resolver(array("upcloo_sdk_view" => $basePath));
        $view->setResolver($resolver);

        $this->object = new UpClooForSpiders();
        $this->object->setView($view);

        $upclooInstance = $this->getMock("UpCloo_Manager", array("get"));
        $upclooInstance->expects($this->any())
            ->method("get")
            ->will($this->returnValue(
                array(
                    array(
                        "title" => "first",
                        "url" => "http://localhost"
                    ),
                    array(
                        "title" => "second",
                        "url" => "http://localhost:8080"
                    )
                )
            ));

        $this->object->upclooInstance = $upclooInstance;
    }

    /**
     * Check that the normal flow is correct
     */
    public function testNormal()
    {
        $this->object->sitekey = "this-is-the-sitekey";
        $partial = $this->object->__invoke("this-is-the-url");

        $this->assertCount(2, $partial);
        $this->assertContains("first", $partial[0]);
        $this->assertContains("http://localhost", $partial[0]);
        $this->assertContains("second", $partial[1]);
        $this->assertContains("http://localhost:8080", $partial[1]);
    }
}
