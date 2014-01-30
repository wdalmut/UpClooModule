<?php
chdir(dirname(__DIR__));

$loader = include __DIR__ . '/../vendor/autoload.php';

$loader->add("UpClooModule", __DIR__);

define("UPCLOO_MODULE_ROOT", realpath(__DIR__ . '/../'));

