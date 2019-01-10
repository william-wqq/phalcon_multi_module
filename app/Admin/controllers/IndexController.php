<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/9 0009
 * Time: 14:28
 */

namespace App\Admin\Controllers;
use Common\BaseController;

class IndexController extends BaseController
{

    public function indexAction()
    {
        $this->view->setVars([
            'module' => 'this is admin'
        ]);
    }
}