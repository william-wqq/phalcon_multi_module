<?php

namespace App\Home;

use Phalcon\DiInterface;
use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\Mvc\View\Engine\Php as PhpEngine;
use Phalcon\Mvc\ModuleDefinitionInterface;
use Phalcon\Config;


class Module implements ModuleDefinitionInterface
{
    /**
     * Registers an autoloader related to the module
     *
     * @param DiInterface $di
     */
    public function registerAutoloaders(DiInterface $di = null)
    {
        $loader = new Loader();

        $loader->registerNamespaces([
            'App\Home\Controllers' => __DIR__ . '/controllers/',
            //'App\Home\Models'      => __DIR__ . '/models/'
        ]);

        $loader->register();
    }

    /**
     * Registers services related to the module
     *
     * @param DiInterface $di
     */
    public function registerServices(DiInterface $di)
    {
        /**
         * Try to load local configuration
         */
        if (file_exists(__DIR__ . '/config/config.php')) {
            
            $config = $di['config'];
            
            $override = new Config(include __DIR__ . '/config/config.php');

            $currentEnv = $config->environment->toArray()[ENV];

            if ($config instanceof Config) {
                $config->merge($override);

                // 合并当前运行环境的配置
                if($currentEnv && file_exists(__DIR__ . '/config/config_' .$currentEnv. '.php')) {
                    $envConfig = new Config(include __DIR__ . '/config/config_' .$currentEnv. '.php');
                    $config->merge($envConfig);
                }
                //print_r($config);
            } else {
                $config = $override;
            }
        }

        /**
         * Setting up the view component
         */
        $di['view'] = function () {
            $config = $this->getConfig();
            $view = new View();
            $view->setViewsDir($config->get('application')->viewsDir);

            $view->registerEngines([
                //'.volt'  => 'voltShared',
                '.phtml' => PhpEngine::class
            ]);

            return $view;
        };

        /**
         * Database connection is created based in the parameters defined in the configuration file
         */
        $di['db'] = function () {
            $config = $this->getConfig();

            $dbConfig = $config->database->toArray();

            $dbAdapter = '\Phalcon\Db\Adapter\Pdo\\' . $dbConfig['adapter'];
            unset($config['adapter']);

            return new $dbAdapter($dbConfig);
        };
    }
}
