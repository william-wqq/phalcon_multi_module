<?php
use Phalcon\Di\FactoryDefault;

error_reporting(E_ALL);

define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');

define('ENV', 'development');
error_reporting(0);
//error_reporting(E_ALL);
//define('ENV', 'testing');
//define('ENV', 'production');

/*add by wqq 2019-01-09 14:23:55 重新组建多模块phalcon框架*/
// 允许模块列表
define('MODULE_ALLOW_LIST', ['Home','Admin', 'Api']);
// 应用名
define('APP_NAME', 'app');
// 应用命名空间
define('APP_NAMESPACE', 'App');
// 默认模块
define('DEFAULT_MODULE', 'Home');
// 默认模块命名空间
define('DEFAULT_MODULE_NAMESPACE', APP_NAMESPACE . '\\' . DEFAULT_MODULE . '\\Controllers');
//print_r($_SERVER);
// 访问模块名
if($_SERVER['SERVER_NAME'] == 'my.phalcon') {
    define('MODULE_NAME', 'Home');
}else if($_SERVER['SERVER_NAME'] == 'admin.phalcon') {
    define('MODULE_NAME', 'Admin');
}else if($_SERVER['SERVER_NAME'] == 'api.phalcon') {
    define('MODULE_NAME', 'Api');
}
// 访问模块命名空间
define('MODULE_NAMESPACE', APP_NAMESPACE . '\\' . MODULE_NAME . '\\Controllers');

try {

    /**
     * The FactoryDefault Dependency Injector automatically registers
     * the services that provide a full stack framework.
     */
    $di = new FactoryDefault();

    /**
     * Handle routes
     */
    include BASE_PATH . '/common/config/router.php';

    /**
     * Read services
     */
    include BASE_PATH . '/common/config/services.php';

    /**
     * Get config service for use in inline setup below
     */
    $config = $di->getConfig();

    /**
     * Include Autoloader
     */
    include BASE_PATH . '/common/config/loader.php';

    /**
     * Handle the request
     */
    $application = new \Phalcon\Mvc\Application($di);

    /*add by wqq 2019-01-09 14:44:58*/
    // 组装应用程序模块
    $modules = [];
    foreach (MODULE_ALLOW_LIST as $v) {
        $modules[$v] = [
            'className' => APP_NAMESPACE . '\\' . ucfirst($v) . '\\Module',
            'path' => APP_PATH . '/' . $v . '/Module.php'
        ];
    }

    // 加入模块分组配置
    $application->registerModules($modules);

    echo str_replace(["\n","\r","\t"], '', $application->handle()->getContent());

} catch (\Exception $e) {
    echo $e->getMessage() . '<br>';
    echo '<pre>' . $e->getTraceAsString() . '</pre>';
}
