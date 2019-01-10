<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/9 0009
 * Time: 14:28
 */

namespace App\Home\Controllers;
use Common\BaseController;

class IndexController extends BaseController
{

    public function indexAction()
    {
        $productList = \Products::find();
        //print_r($productList);die;

        //$this->assets->addJs('js/jquery-3.3.1.js');

        $this->view->setVars([
            'module' => 'this is home',
            'productList' => $productList
        ]);


    }
}