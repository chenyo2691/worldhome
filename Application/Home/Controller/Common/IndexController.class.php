<?php

namespace Home\Controller\Common;

use Home\Controller\BaseController;

class IndexController extends BaseController
{
    /**
     * 首页
     */
    public function index()
    {
        $this->display();
    }
}