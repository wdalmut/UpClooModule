<?php
namespace UpClooModule\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\View\Model\ViewModel;
use Zend\View\Renderer\PhpRenderer;

class UpClooForSpiders extends AbstractHelper
{
    protected $count = 0;

    public function __invoke($url, $vsitekey = false)
    {
        $vsitekeyData = ($vsitekey) ? array('vsitekey' => $vsitekey) : array();

        return $this->upclooInstance->get($url, $vsitekey);
    }
}

