<?php

namespace Home\Model;

use Think\Model;

class SystemRecordModel extends Model
{
    /*
     * 添加访问记录
     */
    public function AddVisitRecord($operation)
    {
        $this->AddRecord($_SESSION["userinfo"]["email"], $_SESSION["userinfo"]["name"], $operation, 1);
    }

    /*
     * 添加操作记录
     */
    public function AddOperateRecord($operation)
    {
        $this->AddRecord($_SESSION["userinfo"]["email"], $_SESSION["userinfo"]["name"], $operation, 2);
    }

    /*
     * 添加系统访问记录
     */
    public function AddAPIRecord($worknum, $name, $operation)
    {
        $this->AddRecord($worknum, $name, $operation, 0);
    }

    /*
     * 添加访问记录
     */
    private function AddRecord($worknum, $name, $operation, $visit)
    {
        $time = time();
        $data = array
        (
            "email" => $worknum,
            "name" => $name,
            "op_date" => date("y-m-d", $time),
            "op_time" => date("H:i:s", $time),
            "operation" => $operation,
            "controller" => CONTROLLER_NAME . "/" . ACTION_NAME,
            "visit" => $visit
        );
        $this->add($data);
    }
}