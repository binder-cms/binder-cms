<?php

$file = __DIR__.'/vendor/autoload.php';
if (! file_exists($file)) {
    throw new RuntimeException('Install dependencies to run test suite.');
}

$loader = require_once $file;

use Doctrine\Common\Annotations\AnnotationRegistry;
AnnotationRegistry::registerLoader([$loader, 'loadClass']);
AnnotationRegistry::registerLoader(function($class) {
    $baseNS = 'Binder\\';
    if (strpos($class, $baseNS) === 0) {
        $path = __DIR__.'/'.str_replace('\\', '/', substr($class, strlen($baseNS))) .'.php';
        require_once $path;
    }

    return class_exists($class, false);
});
