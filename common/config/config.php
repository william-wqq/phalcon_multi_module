<?php
/*
 * Modified: prepend directory path of current file, because of this file own different ENV under between Apache and command line.
 * NOTE: please remove this comment.
 */
defined('BASE_PATH') || define('BASE_PATH', getenv('BASE_PATH') ?: realpath(dirname(__FILE__) . '/../..'));
defined('APP_PATH') || define('APP_PATH', BASE_PATH . '/app');

return new \Phalcon\Config([
    'database' => [
        'adapter'     => 'Mysql',
        'host'        => 'localhost',
        'username'    => 'root',
        'password'    => '',
        'dbname'      => 'my_phalcon',
        'charset'     => 'utf8',
    ],
    'application' => [
        'appDir'         => APP_PATH . '/',
        'controllersDir' => APP_PATH . '/controllers/',
        'modelsDir'      => BASE_PATH . '/models/',
        'migrationsDir'  => BASE_PATH . '/migrations/',
        'viewsDir'       => APP_PATH . '/views/',
        'pluginsDir'     => BASE_PATH . '/plugins/',
        'libraryDir'     => BASE_PATH . '/library/',
        'cacheDir'       => BASE_PATH . '/cache/',
        'commonDir'      => BASE_PATH . '/common/',

        // This allows the baseUri to be understand project paths that are not in the root directory
        // of the webpspace.  This will break if the public/index.php entry point is moved or
        // possibly if the web server rewrite rules are changed. This can also be set to a static path.
        //'baseUri'        => preg_replace('/public([\/\\\\])index.php$/', '', $_SERVER["PHP_SELF"]),
        'baseUri'        => preg_replace('/index.php$/', '', $_SERVER["PHP_SELF"]),
    ],
    /*add by wqq 2019-1-10 15:15:16*/
    //TODO 根据运行环境加载相应配置文件
    'environment' => [
        'development' => 'dev',
        'testing' => 'test',
        'production' => 'pro'
    ],
    /*add by wqq 2019-1-9 11:26:07*/
    'log' => [
        'line' => [
            'format' => '[%date%][%type%] %message%',
            'dateFormat' => 'Y-m-d H:i:s'
        ],
//        'file' => [
//            'alert' => BASE_PATH . 'runtime/' . MODULE_NAME . '/logs/alert/{Y/m/d}/{YmdH}.log',
//            'critical' => BASE_PATH . 'runtime/' . MODULE_NAME . '/logs/critical/{Y/m/d}/{YmdH}.log',
//            'debug' => BASE_PATH . 'runtime/' . MODULE_NAME . '/logs/debug/{Y/m/d}/{YmdH}.log',
//            'error' => BASE_PATH . 'runtime/' . MODULE_NAME . '/logs/error/{Y/m/d}/{YmdH}.log',
//            'emergency' => BASE_PATH . 'runtime/' . MODULE_NAME . '/logs/emergency/{Y/m/d}/{YmdH}.log',
//            'info' => BASE_PATH . 'runtime/' . MODULE_NAME . '/logs/info/{Y/m/d}/{YmdH}.log',
//            'notice' => BASE_PATH . 'runtime/' . MODULE_NAME . '/logs/notice/{Y/m/d}/{YmdH}.log',
//            'warning' => BASE_PATH . 'runtime/' . MODULE_NAME . '/logs/warning/{Y/m/d}/{YmdH}.log'
//        ]
    ],
]);
