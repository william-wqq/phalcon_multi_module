<?php

$loader = new \Phalcon\Loader();

/**
 * We're a registering a set of directories taken from the configuration file
 */
$loader->registerDirs(
    [
        $config->application->controllersDir,
        $config->application->modelsDir
    ]
)->register();

/*add by wqq 2019-1-10 14:29:04*/
$loader->registerNamespaces(
    [
        'Common' => BASE_PATH . '/common/',
        'Library' => BASE_PATH . '/library/',
        'Library\\Tool' => BASE_PATH . '/library/tool/',
    ]
)->register();
