<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/9 0009
 * Time: 14:28
 */

namespace App\Api\Controllers;
use Common\BaseController;

class IndexController extends BaseController
{

    public function indexAction()
    {
        return $this->sendSuccess();
    }
}