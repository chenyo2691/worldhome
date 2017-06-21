<?php

namespace Home\Controller\Common;

use Think\Controller;

class LoginController extends Controller
{
    public function index()
    {
        $this->display();
    }

    /**
     * 退出系统
     */
    public function logout()
    {
        D("SystemRecord")->AddOperateRecord("退出系统。");//Log

        session("userinfo", null);
        cookie("userinfo", null);
        $this->success('退出平台成功...', U('Home/Common/Login/index'), 1);
//        $this->redirect('Home/Common/Login/index', 0, 0, '...');
    }

    /**
     * 登录
     */
    public function login()
    {
        if (!IS_POST) {
            E("页面不存在");
        }

        $data = M('user')->where(array('email' => I('email')))->find();
        if ($data != null) {
            if ($data["status"] == 1) {
                if ($data["password"] == md5(I('email') . I('password'))) {
                    session("userinfo", $data);
                    cookie("userinfo", $data, 7 * 24 * 3600);

                    D("SystemRecord")->AddOperateRecord("登录系统。");//Log

                    $this->success('页面跳转中...', U('Home/Common/Index/index'), 0);
                } else {
                    $this->error("密码错误", U('Home/Common/Login/index'), 1);
                }
            } else {
                $this->error('该用户被冻结，请联系管理员开通！', U('Home/Common/Login/index'), 2);
            }
        } else {
            $this->error('该用户未注册', U('Home/Common/Login/index'), 2);
        }
    }

    //region 注册

    /**
     * 注册页面
     */
    public function register()
    {
        $this->display();
    }

    /**
     * 注册
     */
    public function registerAction()
    {
        $result["status"] = 0;

        $name = I("name");
        $email = I("email");
        $password = I("password1");

        $userInfo = M("user")->where(array("email" => $email))->find();
        if ($userInfo) {
            $result["msg"] = "已存在此邮箱，若忘记密码，请找管理员重置。";
        } else {
            $saveData["name"] = $name;
            $saveData["email"] = $email;
            $saveData["password"] = md5($email . $password);
            $flag = M("user")->add($saveData);
            if ($flag) {
                D("SystemRecord")->AddAPIRecord($email, $name, "注册用户");//Log
                $result["status"] = 1;
            } else {
                $result["msg"] = "网络原因请重试";
            }
        }
        $this->ajaxReturn($result);
    }
    //endregion

    //region 维护页
    public function Maintain()
    {
        if (C("MAINTENANCE_STATUS")) {
            $this->display();
        } else {
            $this->redirect('Home/Common/Index', 0, 0, "页面跳转中...");
        }
    }
    //endregion
}