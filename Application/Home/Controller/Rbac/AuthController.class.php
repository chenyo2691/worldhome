<?php

namespace Home\Controller\Rbac;

use Home\Controller\BaseController;

class AuthController extends BaseController
{
    //region 权限管理
    /**
     * 权限管理
     */
    function index()
    {
        $data = D('AuthRule')->getTreeData('tree', 'id', 'title');
        $assign = array('data' => $data);
        $this->assign($assign);
        $this->display();
    }

    /**
     * 添加权限
     */
    public function add()
    {
        $data = I('post.');
        unset($data['id']);
        $result = D('AuthRule')->addData($data);
        if ($result) {
            D("SystemRecord")->AddOperateRecord("添加权限【id=" . $result . "】");//Log
            $this->success('添加成功', U('Home/Rbac/Auth/index'));
        } else {
            $this->error('添加失败');
        }
    }

    /**
     * 修改权限
     */
    public function edit()
    {
        $data = I('post.');
        $map = array(
            'id' => $data['id']
        );
        $result = D('AuthRule')->editData($map, $data);
        if ($result) {
            D("SystemRecord")->AddOperateRecord("修改权限【id=" . $result . "】");//Log
            $this->success('修改成功', U('Home/Rbac/Auth/index'));
        } else {
            $this->error('修改失败');
        }
    }

    /**
     * 删除权限
     */
    public function delete()
    {
        $id = I('get.id');
        $map = array('id' => $id);
        $result = D('AuthRule')->deleteData($map);
        if ($result) {
            D("SystemRecord")->AddOperateRecord("删除权限【id=" . $result . "】");//Log
            $this->success('删除成功', U('Home/Rbac/Auth/index'));
        } else {
            $this->error('请先删除子权限');
        }

    }
    //endregion

    //region 用户组管理
    /**
     * 用户组列表
     */
    public function group()
    {
        $data = D('AuthGroup')->select();
        $assign = array('data' => $data);
        $this->assign($assign);
        $this->display();
    }

    /**
     * 添加用户组
     */
    public function add_group()
    {
        $data = I('post.');
        unset($data['id']);
        $result = D('AuthGroup')->addData($data);
        if ($result) {
            D("SystemRecord")->AddOperateRecord("添加用户组【id=" . $result . "】");//Log
            $this->success('添加成功', U('Home/Rbac/Auth/group'));
        } else {
            $this->error('添加失败');
        }
    }

    /**
     * 修改用户组
     */
    public function edit_group()
    {
        $data = I('post.');
        $map = array(
            'id' => $data['id']
        );
        $result = D('AuthGroup')->editData($map, $data);
        if ($result) {
            D("SystemRecord")->AddOperateRecord("修改用户组【id=" . $result . "】");//Log
            $this->success('修改成功', U('Home/Rbac/Auth/group'));
        } else {
            $this->error('修改失败');
        }
    }

    /**
     * 删除用户组
     */
    public function delete_group()
    {
        $id = I('get.id');
        $map = array(
            'id' => $id
        );
        $result = D('AuthGroup')->deleteData($map);
        if ($result) {
            D("SystemRecord")->AddOperateRecord("删除用户组【id=" . $result . "】");//Log
            $this->success('删除成功', U('Home/Rbac/Auth/group'));
        } else {
            $this->error('删除失败');
        }
    }

    /**
     * 分配权限
     */
    public function rule_group()
    {
        if (IS_POST) {
            $data = I('post.');
            $map = array(
                'id' => $data['id']
            );
            $data['rules'] = implode(',', $data['rule_ids']);
            $result = D('AuthGroup')->editData($map, $data);
            if ($result) {
                D("SystemRecord")->AddOperateRecord("分配权限【id=" . $result . "】");//Log
                $this->success('操作成功', U('Home/Rbac/Auth/group'));
            } else {
                $this->error('操作失败');
            }
        } else {
            $id = I('get.id');
            // 获取用户组数据
            $group_data = M('Auth_group')->where(array('id' => $id))->find();
            $group_data['rules'] = explode(',', $group_data['rules']);
            // 获取规则数据
            $rule_data = D('AuthRule')->getTreeData('level', 'id', 'title');
            $assign = array(
                'group_data' => $group_data,
                'rule_data' => $rule_data
            );
            $this->assign($assign);
            $this->display();
        }

    }
    //endregion

    //region 管理员列表

    /**
     * 管理员列表
     */
    public function admin_user_list()
    {
        $data = D('AuthGroupAccess')->getAllData();
        $assign = array(
            'data' => $data
        );
        $this->assign($assign);
        $this->display();
    }

    /**
     * 添加管理员
     */
    public function add_admin()
    {
        if (IS_POST) {
            $data = I('post.');

            //判定英文用户名是否存在
            if (D('User')->is_exist($data) == true) {
                $this->error("用户已存在,无法重复添加");
            } else {
                $data['password'] = $data['email'] . $data['password'];
                $result = D('User')->addData($data);
                if ($result) {
                    if (!empty($data['group_ids'])) {
                        foreach ($data['group_ids'] as $k => $v) {
                            $group = array(
                                'uid' => $result,
                                'group_id' => $v
                            );
                            D('AuthGroupAccess')->addData($group);
                        }
                    }
                    D("SystemRecord")->AddOperateRecord("添加管理员【id=" . $result . "】");//Log
                    // 操作成功
                    $this->success('添加成功', U('Home/Rbac/Auth/admin_user_list'));
                } else {
                    $error_word = D('User')->getError();
                    // 操作失败
                    $this->error($error_word);
                }
            }


        } else {
            $data = D('AuthGroup')->select();
            $assign = array(
                'data' => $data
            );
            $this->assign($assign);
            $this->display();
        }
    }

    /**
     * 修改管理员
     */
    public function edit_admin()
    {
        if (IS_POST) {
            $data = I('post.');
            $newpassword = $data['email'] . $data['password'];
            // 组合where数组条件
            $uid = $data['id'];
            $map = array(
                'id' => $uid
            );
            // 修改权限
            D('AuthGroupAccess')->deleteData(array('uid' => $uid));
            foreach ($data['group_ids'] as $k => $v) {
                $group = array(
                    'uid' => $uid,
                    'group_id' => $v
                );
                D('AuthGroupAccess')->addData($group);
            }
            $data = array_filter($data);
            // 如果修改密码
            if (!empty($data['password'])) {
                $data['password'] = $newpassword;
            }
            // p($data);die;
            $result = D('User')->editData($map, $data);
            if ($result) {
                // 操作成功
                D("SystemRecord")->AddOperateRecord("修改管理员【id=" . $result . "】");//Log
                $this->success('编辑成功', U('Home/Rbac/Auth/edit_admin', array('id' => $uid)));
            } else {
                $error_word = D('User')->getError();
                if (empty($error_word)) {
                    $this->success('编辑成功', U('Home/Rbac/Auth/edit_admin', array('id' => $uid)));
                } else {
                    // 操作失败
                    $this->error($error_word);
                }

            }
        } else {
            $id = I('get.id', 0, 'intval');
            // 获取用户数据
            $user_data = M('User')->find($id);
            // 获取已加入用户组
            $group_data = M('AuthGroupAccess')
                ->where(array('uid' => $id))
                ->getField('group_id', true);
            // 全部用户组
            $data = D('AuthGroup')->select();
            $assign = array(
                'data' => $data,
                'user_data' => $user_data,
                'group_data' => $group_data
            );
            $this->assign($assign);
            $this->display();
        }
    }
    //endregion

}