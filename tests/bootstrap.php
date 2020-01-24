<?php

use Doctrine\Common\Annotations\AnnotationRegistry;

$autoloader = include __DIR__.'/../vendor/autoload.php';
AnnotationRegistry::registerLoader([$autoloader, 'loadClass']);