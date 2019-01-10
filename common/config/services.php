<?php

use Phalcon\Mvc\View;
use Phalcon\Mvc\View\Engine\Php as PhpEngine;
use Phalcon\Mvc\Url as UrlResolver;
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;
use Phalcon\Mvc\Model\Metadata\Memory as MetaDataAdapter;
use Phalcon\Session\Adapter\Files as SessionAdapter;
use Phalcon\Flash\Direct as Flash;

/**
 * Shared configuration service
 */
$di->setShared('config', function () {
    return include BASE_PATH . "/common/config/config.php";
});
/**
 * The URL component is used to generate all kind of urls in the application
 */
$di->setShared('url', function () {
    $config = $this->getConfig();

    $url = new UrlResolver();
    $url->setBaseUri($config->application->baseUri);

    return $url;
});

/**
 * Setting up the view component
 */
$di->setShared('view', function () {
    $config = $this->getConfig();

    $view = new View();
    $view->setDI($this);
    $view->setViewsDir($config->application->viewsDir);

    $view->registerEngines([
        '.volt' => function ($view) {
            $config = $this->getConfig();

            $volt = new VoltEngine($view, $this);

            $volt->setOptions([
                'compiledPath' => $config->application->cacheDir,
                'compiledSeparator' => '_'
            ]);

            return $volt;
        },
        '.phtml' => PhpEngine::class

    ]);

    return $view;
});

/**
 * Database connection is created based in the parameters defined in the configuration file
 */
$di->setShared('db', function () {
    $config = $this->getConfig();

    $class = 'Phalcon\Db\Adapter\Pdo\\' . $config->database->adapter;
    $params = [
        'host'     => $config->database->host,
        'username' => $config->database->username,
        'password' => $config->database->password,
        'dbname'   => $config->database->dbname,
        'charset'  => $config->database->charset
    ];

    if ($config->database->adapter == 'Postgresql') {
        unset($params['charset']);
    }

    $connection = new $class($params);

    return $connection;
});


/**
 * If the configuration specify the use of metadata adapter use it or use memory otherwise
 */
$di->setShared('modelsMetadata', function () {
    return new MetaDataAdapter();
});

/**
 * Register the session flash service with the Twitter Bootstrap classes
 */
$di->set('flash', function () {
    return new Flash([
        'error'   => 'alert alert-danger',
        'success' => 'alert alert-success',
        'notice'  => 'alert alert-info',
        'warning' => 'alert alert-warning'
    ]);
});

/**
 * Start the session the first time some component request the session service
 */
$di->setShared('session', function () {
    $session = new SessionAdapter();
    $session->start();

    return $session;
});

/**
 * add by wqq
 * Registering a router
 */
$di->setShared('router', function () {
    $router = new \Phalcon\Mvc\Router();

    $router->setDefaultModule(MODULE_NAME ?? DEFAULT_MODULE);
    $router->setDefaultNamespace(MODULE_NAMESPACE ?? DEFAULT_MODULE_NAMESPACE);

    return $router;
});

/**
 * Register log service
 */
/*$di->set('logger', function (string $file = null, array $line = null) {
    $config = $this->getConfig()->services->logger;
    $linConfig = $config->line;
    if(!is_null($line)){
        $lineObj = new Config($line);
        $linConfig = $linConfig->merge($lineObj);
    }
    $loggerFormatterLine = new LoggerFormatterLine($linConfig->format, $linConfig->date_format);
    $fileConfig = $config->file;
    if(empty($file)){
        $file = $fileConfig->info;
    }else if(array_key_exists($file, $fileConfig->toArray())){
        $file = $fileConfig->$file;
    }
    $file = Common::dirFormat($file);
    $dir = dirname($file);
    $mkdirRes = Common::mkdir($dir);
    if (!$mkdirRes) {
        throw new \Exception('创建目录 ' . $dir . ' 失败');
    }
    $loggerAdapterFile = new LoggerAdapterFile($file);
    $loggerAdapterFile->setFormatter($loggerFormatterLine);
    return $loggerAdapterFile;
});*/
