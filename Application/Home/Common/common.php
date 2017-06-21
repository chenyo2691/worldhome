<?php

function guid()
{
    if (function_exists('com_create_guid')) {
        return com_create_guid();
    } else {
        mt_srand((double)microtime() * 10000);//optional for php 4.2.0 and up.
        $charid = strtoupper(md5(uniqid(rand(), true)));
        $uuid =
            substr($charid, 0, 8)
            . substr($charid, 8, 4)
            . substr($charid, 12, 4)
            . substr($charid, 16, 4)
            . substr($charid, 20, 12);
        return $uuid;
    }
}

/**
 * 获取左侧菜单
 */
function GetLeftMenu()
{
    $Menu = [
//        主页
        array(
            "title" => "主页",
            "url" => U("Home/Common/Index/index"),
            "icon" => "fa fa-dashboard",
            "children" => [],
        ),
//        客户管理
        array(
            "title" => "客户管理",
            "url" => U("Home/SaleScene/Customer/index"),
            "icon" => "fa fa-users",
            "children" => [],
        ),
//        房源管理
        array(
            "title" => "房源管理",
            "url" => U("Home/SaleScene/HouseResource/index"),
            "icon" => "fa fa-home",
            "children" => [],
        ),
//        系统权限管理
        array(
            "title" => "系统权限管理",
            "url" => "#",
            "icon" => "fa fa-dashboard",
            "children" => [
                array(
                    "parent" => "系统权限管理",
                    "title" => "权限管理",
                    "url" => U("Home/Rbac/Auth/index"),
                    "icon" => "fa fa-tags"
                ),
                array(
                    "parent" => "系统权限管理",
                    "title" => "用户组管理",
                    "url" => U("Home/Rbac/Auth/group"),
                    "icon" => "fa fa-user-md"
                ),
                array(
                    "parent" => "系统权限管理",
                    "title" => "管理员列表",
                    "url" => U("Home/Rbac/Auth/admin_user_list"),
                    "icon" => "fa fa-user-plus"
                ),
            ],
        ),
    ];

    $rule_name = MODULE_NAME . '/' . CONTROLLER_NAME . '/' . ACTION_NAME;

    foreach ($Menu as $key => $item) {
        $Menu[$key]["active"] = false;
        if ($item["url"] == U($rule_name)) {
            $Menu[$key]["active"] = true;
        }
        if (count($item["children"]) > 0) {
            foreach ($item["children"] as $key_child => $item_child) {
                $Menu[$key]["children"][$key_child]["active"] = false;
                if ($item_child["url"] == U($rule_name)) {
                    $Menu[$key]["children"][$key_child]["active"] = true;
                    $Menu[$key]["active"] = true;
                }
            }
        }
    }

    return $Menu;
}
