<?php

use Doctrine\Common\Annotations\AnnotationRegistry;
use Composer\Autoload\ClassLoader;

/**
 * @var ClassLoader $loader
 */
$loader = require __DIR__.'/../vendor/autoload.php';

$loader->add('Aweber', realpath(__DIR__.'/../vendor/aweber/aweber/aweber_api/'));

AnnotationRegistry::registerLoader(array($loader, 'loadClass'));

return $loader;
