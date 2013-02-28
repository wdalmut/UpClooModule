<?php
namespace UpClooModule\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\View\Model\ViewModel;
use Zend\View\Renderer\PhpRenderer;

class UpClooSdk extends AbstractHelper
{
    protected $count = 0;

    public function __invoke($url, $vsitekey = false)
    {
        $vsitekeyData = ($vsitekey) ? array('vsitekey' => $vsitekey) : array();

        return $this->view->partial(
            "upcloo_sdk_view",
            array_merge(
                array(
                    "sitekey" => $this->sitekey,
                    'url' => $url
                ),
                $vsitekeyData
            )
        );
    }
}

