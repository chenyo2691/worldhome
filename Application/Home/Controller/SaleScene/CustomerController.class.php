<?php

namespace Home\Controller\SaleScene;

use Home\Controller\BaseController;

class CustomerController extends BaseController
{
    public function index()
    {
        $this->display();
    }

    public function updateTable()
    {
        $data = M("customer")->select();
        $this->ajaxReturn($data);
    }

    public function add()
    {
//        $this->assign("CustomerOptions", C("CustomerOptions"));
        $this->assign("action", "add");
        $this->display("detail");
    }

    public function edit()
    {
        $customerId = I("id");
        $this->assign("id", $customerId);

        $this->assign("action", "edit");
        $this->display("detail");
    }

    public function getCustomerDataById()
    {
        $result["status"] = 0;
        $customerId = I("id");
        $data = M("customer")->where(array("id" => $customerId))->find();
        if ($data) {
            $data["investmentintention"] = json_decode($data["investmentintention"], true);
            $data["experience"] = json_decode($data["experience"], true);
            $data["concernfactor"] = json_decode($data["concernfactor"], true);
            $data["drivingfactors"] = json_decode($data["drivingfactors"], true);
            $result["data"] = $data;
            $result["status"] = 1;
        }
        $this->ajaxReturn($result);
    }

    public function addAction()
    {
        $result["status"] = 0;

        $data = I("data");
        $data["investmentintention"] = json_encode($data["investmentintention"]);
        $data["experience"] = json_encode($data["experience"]);
        $data["concernfactor"] = json_encode($data["concernfactor"]);
        $data["drivingfactors"] = json_encode($data["drivingfactors"]);
        $flag = M("customer")->add($data);
        if ($flag) {
            D("SystemRecord")->AddOperateRecord("添加客户【id=" . $flag . "】。");//Log
            $result["status"] = 1;
        }

        $this->ajaxReturn($result);
    }

    public function editAction()
    {
        $result["status"] = 0;

        $data = I("data");
        $data["investmentintention"] = json_encode($data["investmentintention"]);
        $data["experience"] = json_encode($data["experience"]);
        $data["concernfactor"] = json_encode($data["concernfactor"]);
        $data["drivingfactors"] = json_encode($data["drivingfactors"]);
        $data["lastfollow"] = date("Y-m-d");
        $flag = M("customer")->save($data);
        if ($flag) {
            D("SystemRecord")->AddOperateRecord("修改客户【id=" . $flag . "】。");//Log
            $result["status"] = 1;
        }

        $this->ajaxReturn($result);
    }
}