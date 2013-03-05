<?php
namespace UpClooModuleTest\View\Helper;

use UpClooModule\View\Helper\UpClooSdk;
use Zend\View\Model\ViewModel;
use Zend\View\Renderer\PhpRenderer as View;
use Zend\View\Resolver\TemplateMapResolver as Resolver;

class UpClooSdkTest extends \PHPUnit_Framework_TestCase
{
    private $object;
    private $basePath;

    public function setUp()
    {
        $basePath = realpath(__DIR__ . '/../../resources/view_stub.phtml');
        $view = new View();
        $resolver = new Resolver(array("upcloo_sdk_view" => $basePath));
        $view->setResolver($resolver);

        $this->object = new UpClooSdk();
        $this->object->setView($view);
    }

    /**
     * Check that the normal flow is correct
     */
    public function testSitekey()
    {
        $this->object->sitekey = "this-is-the-sitekey";
        $partial = $this->object->__invoke("this-is-the-url");

        $this->assertEquals("this-is-the-sitekey,this-is-the-url,", $partial);
    }

    /**
     * Check that the virtual sitekey is added in the view
     */
    public function testVirtualSitekey()
    {
        $this->object->sitekey = "the-sitekey";
        $partial = $this->object->__invoke("this-is-the-url", "the-virtual-key");

        $this->assertEquals("the-sitekey,this-is-the-url,the-virtual-key", $partial);
    }
}
