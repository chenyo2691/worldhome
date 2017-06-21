<?php
/**
 * Created by PhpStorm.
 * User: liweihao
 * Date: 2016-10-6
 * Time: 13:02
 */

namespace Home\Controller\Common;

use Home\Controller\BaseController;

class UserInfoController extends BaseController
{
    public function index()
    {
        $this->assign("userinfo", $_SESSION["userinfo"]);
        $this->display();
    }

    //region 头像

    /**
     * 修改头像页面
     */
    public function ModifyHeader()
    {
        $this->display();
    }

    /**
     * 上传头像
     */
    public function uploadImg()
    {
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize = 1 * 1024 * 1024;                    //设置上传图片的大小
        $upload->allowExts = array('jpg', 'gif', 'png', 'gif');    //设置上传图片的后缀
        $upload->uploadReplace = true;//同名则替换
        $upload->rootPath = './Data/Header/temp/'; // 设置附件上传根目录
        $upload->savePath = ''; // 设置附件上传（子）目录

        //完整的头像路径
//        $time = time();
//        $path = "./Data/Header/temp/" . $time . "/";
//        $upload->savePath = $path;
        $info = $upload->upload();
        if (!$info) {
            // 上传错误提示错误信息
            $result = array(
                "filename" => '',
                "info" => $upload->getError(),
                "status" => 0
            );
            $this->ajaxReturn($result);
        } else {
            // 上传成功 获取上传文件信息
            //$filename = ($this->IsWindowsServer())? iconv('utf-8', 'gbk//TRANSLIT', $info[0]["savename"]) : $info[0]["savename"];
//            $filename = iconv('utf-8', 'gbk//TRANSLIT', $info[0]["savename"]);
            $filePath = "./Data/Header/temp/" . $info["Filedata"]["savepath"] . $info["Filedata"]["savename"];
            $temp_size = getimagesize($filePath);
            if ($temp_size[0] < 100 || $temp_size[1] < 100) {
                //判断宽和高是否符合头像要求
                $result = array(
                    "filename" => '',
                    "info" => "图片宽或高不得小于100px！",
                    "status" => 0
                );
                $this->ajaxReturn($result);
            }

            $result = array(
                "filename" => $info["Filedata"]["savepath"] . $info["Filedata"]["savename"],
                "info" => $info,
                "status" => 1
            );
            $this->ajaxReturn($result);
        }
    }

    /**
     * 剪切图片
     */
    public function cropImg()
    {
        //图片裁剪数据
        $params = $_POST;                        //裁剪参数
        if (!isset($params) && empty($params)) {
            return;
        }

        $path = "./Data/Header/";                          //头像目录地址
        $filename = time() . ".jpg";                        //要保存的图片名称

        $real_path = $path . "crop/" . $filename;         //要保存的图片地址
        $pic_path = $path . "temp/" . $params['src'];       //临时图片地址
//        if ($this->IsWindowsServer())
//        {
        $real_path = iconv('utf-8', 'gbk//TRANSLIT', $real_path);
        $pic_path = iconv('utf-8', 'gbk//TRANSLIT', $pic_path);
//        }

        //裁剪
        $image = new \Think\Image();
        $image->open($pic_path);
        //将图片裁剪为400x400并保存为corp.jpg
        $image->crop($params['w'], $params['h'], $params['x'], $params['y'], 160, 160)->save($real_path);

        //裁剪原图
//        import('Common/Org/ThinkImage/ThinkImage');
//        $Think_img = new \ThinkImage(THINKIMAGE_GD);
//        $Think_img->open($pic_path)->crop($params['w'], $params['h'], $params['x'], $params['y'], 160, 160)->save($real_path);

        //修改数据库
        $data["id"] = $_SESSION["userinfo"]["id"];
        $data["head_img"] = $filename;
        M("user")->save($data);

        //修改SESSION
        $current_img = $_SESSION["userinfo"]["head_img"];
        if ($current_img != null && $current_img != "") {
            $current_file = "./Data/Header/header/" . $_SESSION["userinfo"]["head_img"];
            unlink($current_file);
        }
        //修改SESSION
        $this->SetSession("userinfo", array("head_img" => $filename));


        D("SystemRecord")->AddOperateRecord("切换头像。");//Log

        $this->success('上传头像成功', U('Home/Common/UserInfo/index'), 2);
//        $this->success("Home/Common/UserInfo", 0, 0, "");
    }

    //endregion

    //region 密码
    /**
     * 修改密码页面
     */
    public function ModifyPassword()
    {
        $this->display();
    }

    /**
     * 保存修改密码
     */
    public function SavePassword()
    {
        $result["status"] = false;
        $id = $_SESSION["userinfo"]["id"];
        $old_password = $_POST["old_password"];
        $new_password = $_POST["new_password"];

        $userData = M("user")->where(array("id" => $id))->find();
        if ($userData["password"] !== $old_password) {
            $result["msg"] = "原密码错误，请重新输入！";
        } else {
            $saveData["password"] = $new_password;
            $flag = M("user")->where(array("id" => $id))->save($saveData);
            if ($flag) {
                $result["status"] = true;
            } else {
                $result["msg"] = "保存失败，请重新再试";
            }
        }
        if ($result["status"]) {
            D("SystemRecord")->AddOperateRecord("修改密码。");//Log
            $this->success("密码修改成功！", U("Home/Common/UserInfo"), 2);
        } else {
            $this->error($result["msg"]);
        }
    }

    //endregion

    private function SetSession($field, $array)
    {
        $info = $_SESSION[$field];
        foreach ($array AS $key => $value) {
            $info[$key] = $value;
        }

        session($field, null);
        cookie($field, null);
        session($field, $info);
        cookie($field, $info, 7 * 24 * 3600);
    }

}