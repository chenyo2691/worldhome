<?php

namespace Home\Controller\SaleScene;

use Home\Controller\BaseController;

class HouseResourceController extends BaseController
{
    public function index()
    {
        $this->display();
    }

    public function updateTable()
    {
        $where["status"] = 1;
        $data = M("house")->where($where)->select();
        $this->ajaxReturn($data);
    }

    public function add()
    {
        $this->assign("action", "add");
        $this->display("detail");
    }

    public function isTempDataExist()
    {
        $result["status"] = 0;
        $tempData = M("house")->where(array("status" => 0))->find();
        if ($tempData) {
            $result["status"] = 1;
            $result["data"] = $tempData;
            $imgData = M("houseimg")->where(array("houseid" => $tempData["id"]))->select();
            $result["imgData"] = $imgData;
            session("houseTempId", $tempData["id"]);
        }
        $this->ajaxReturn($result);
    }

    public function newTempData()
    {
        if (isset($_POST["tempid"])) {
            M("house")->where(array("id" => I("tempid")))->delete();
        }

        $data["housecode"] = guid();
        $data["title"] = "";
        $data["location"] = "";
        $data["building"] = "";
        $data["layout"] = "";
        $data["floor"] = "";
        $data["direction"] = "";
        $data["area"] = "";
        $data["decoration"] = "带装修";
        $data["roomnumber"] = "";
        $data["haskey"] = "有";
        $data["twoyears"] = "是";
        $data["price"] = "";
        $data["contact"] = "";
        $data["sex"] = "男";
        $data["phone"] = "";
        $data["description"] = "";
        $data["img"] = "";
        $data["status"] = 0;
        $newTempDataId = M("house")->add($data);
        $data["id"] = $newTempDataId;
        session("houseTempId", $newTempDataId);
        $this->ajaxReturn($data);
    }

    public function addAction()
    {
        $result["status"] = 0;
        $saveData = I("data");
        $saveData["status"] = 1;
        $flag = M("house")->save($saveData);
        if ($flag) {
            D("SystemRecord")->AddOperateRecord("新增房源【id=" . $flag . "】。");//Log
            $result["status"] = 1;
        } else {
            $result["msg"] = "保存错误,请稍后再试";
        }
        $this->ajaxReturn($result);
    }

    public function DeleteImg()
    {
        $result["status"] = 0;
        $id = I("id");
        $where["id"] = $id;
        $flag = M("houseimg")->where($where)->delete();
        if ($flag) {
            D("SystemRecord")->AddOperateRecord("删除房源图片【id=" . $flag . "】。");//Log
            $result["status"] = 1;
            $result["deleteid"] = $id;
        }
        $this->ajaxReturn($result);

    }

    public function upload()
    {
        $result["status"] = 0;
        if (session("houseTempId")) {
            $upload = new \Think\Upload();// 实例化上传类
            $upload->maxSize = 3145728;// 设置附件上传大小
            $upload->exts = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
            $upload->rootPath = './Data/House/'; // 设置附件上传根目录
            $upload->savePath = ''; // 设置附件上传（子）目录
            // 上传文件
            $info = $upload->upload();
            if (!$info) {// 上传错误提示错误信息
                $result["msg"] = $upload->getError();
            } else {// 上传成功
                //region 添加水印
//                $image = new \Think\Image();
//                $BinImg = $upload->rootPath . "$img"; // 获得原图绝对路径
//                $image->open($BinImg); // 打开原图
                // 添加水印
//                $image ->water($upload->rootPath."logo.png")-> save($upload ->rootPath.$img);
                //endregion

                $saveData["houseid"] = session("houseTempId");
                $saveData["url"] = "/Data/House/" . $info["file"]["savepath"] . $info["file"]["savename"];
                $saveData["title"] = $info["file"]["name"];
                $flag = M("houseimg")->add($saveData);
                $saveData["id"] = $flag;
                if ($flag) {
                    D("SystemRecord")->AddOperateRecord("上传房源图片【id=" . $flag . "】。");//Log
                    $result["msg"] = "上传成功！";
                    $result["status"] = 1;
                    $result["data"] = $saveData;
                } else {
                    $result["msg"] = "图片存库失败";
                }
            }
        } else {
            $result["msg"] = "网络原因，请重试[session(houseTempId)]";
        }
        $this->ajaxReturn($result);


    }

    public function exhibition()
    {
        $where["id"] = I("houseid");
        $data = M("house")->where($where)->find();
//        $imgData = M("houseimg")->where(array("houseid" => $data["id"]))->select();
        $this->assign("info", $data);
//        $this->assign("imgData", $imgData);
        $this->display();
    }

    public function getImgByHouseId()
    {
        $imgData = M("houseimg")->where(array("houseid" => I("id")))->select();
        $this->ajaxReturn($imgData);
    }

}