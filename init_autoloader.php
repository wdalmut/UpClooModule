<?php
$loader = include 'vendor/autoload.php';

if (!class_exists('Zend\Loader\AutoloaderFactory')) {
    throw new RuntimeException('Unable to load ZF2. Run `php composer.phar install --dev`');
}

