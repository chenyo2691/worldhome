<?php
/**
 * Created by PhpStorm.
 * User: CYS
 * Date: 2016/4/21
 * Time: 15:57
 */

namespace Home\Controller;

use Think\Controller;

class BaseController extends Controller
{
    protected function _initialize()
    {
        if (C("MAINTENANCE_STATUS") && $_SESSION["userinfo"]["name"] != "admin") {
            $this->redirect('Home/Common/Login/Maintain', 0, 0, "页面跳转中...");
        }

        $this->checkLoginState();//检查登录情况

        $this->checkAuth();// 检查用户权限

        $this->assign('MENU', GetLeftMenu());//菜单In Common
    }

    /**
     * 检查登录情况
     */
    protected function checkLoginState()
    {
        if (!isset($_SESSION['userinfo"]["email']) && cookie("userinfo")["email"] == "") {
            $this->error('用户未登陆', U('Home/Common/Login/index'), 1);
        }
        if (!isset($_SESSION['userinfo"]["email']) && cookie("userinfo")["email"] != "") {
            session('userinfo', cookie('userinfo'));
        }
        if (isset($_SESSION['userinfo"]["email']) && cookie("userinfo")["email"] != "" && $_SESSION['userinfo"]["email'] != cookie("userinfo")["email"]) {
            cookie('userinfo', null);
        }
    }

    /**
     * 检查用户权限
     */
    protected function checkAuth()
    {
        $auth = new \Think\Auth();
        $rule_name = MODULE_NAME . '/' . CONTROLLER_NAME . '/' . ACTION_NAME;
        if (!in_array($rule_name, C('NOT_AUTH_ACTION'))) {
            $result = $auth->check($rule_name, $_SESSION['u_id']);
            if (!$result) {
                $this->error('您没有权限访问', 'Home/Common/Index/index');
            }
        }
    }
}