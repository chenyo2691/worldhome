<?php
namespace Home\Model;

use Home\Model\BaseModel;

/**
 * 权限规则model
 */
class AuthGroupAccessModel extends BaseModel
{

    /**
     * 根据group_id获取全部用户id
     * @param  int $group_id 用户组id
     * @return array         用户数组
     */
    public function getUidsByGroupId($group_id)
    {
        $user_ids = $this
            ->where(array('group_id' => $group_id))
            ->getField('uid', true);
        return $user_ids;
    }

    /**
     * 根据uid获取角色(多角色用都好分割)
     * @param $uid
     * @return mixed
     */
    public function getTitleByUid($uid)
    {
        $data = $this
            ->field('GROUP_CONCAT(ag.title) AS title')
            ->alias('aga')
            ->join('__AUTH_GROUP__ ag ON aga.group_id = ag.id', 'LEFT')
            ->where(array("aga.uid" => $uid))
            ->find();
        return $data;
    }

    /**
     * 获取管理员权限列表
     */
    public function getAllData()
    {
//        ->where(array('u.username' => array('neq', 'admin')))
        $subQuery = $this
            ->field('u.id,u.email,u.name,aga.group_id,ag.title')
            ->alias('aga')
            ->join('__USER__ u ON aga.uid=u.id', 'RIGHT')
            ->join('__AUTH_GROUP__ ag ON aga.group_id=ag.id', 'LEFT')
            ->select(false);
        $data = M()->field('tmp.id,tmp.email,tmp.name,GROUP_CONCAT(tmp.title) AS `title`')->table('( ' . $subQuery . ') tmp')->group('tmp.id')->select();
        return $data;

        //----------------------------------------数据处理

        $data = $this
            ->field('u.id,u.username,u.email,aga.group_id,ag.title')
            ->alias('aga')
            ->join('__USER__ u ON aga.uid=u.id', 'RIGHT')
            ->join('__AUTH_GROUP__ ag ON aga.group_id=ag.id', 'LEFT')
            ->select();
        // 获取第一条数据
        $first = $data[0];
        $first['title'] = array();
        $user_data[$first['id']] = $first;
        // 组合数组
        foreach ($data as $k => $v) {
            foreach ($user_data as $m => $n) {
                $uids = array_map(function ($a) {
                    return $a['id'];
                }, $user_data);
                if (!in_array($v['id'], $uids)) {
                    $v['title'] = array();
                    $user_data[$v['id']] = $v;
                }
            }
        }
        // 组合管理员title数组
        foreach ($user_data as $k => $v) {
            foreach ($data as $m => $n) {
                if ($n['id'] == $k) {
                    $user_data[$k]['title'][] = $n['title'];
                }
            }
            $user_data[$k]['title'] = implode('、', $user_data[$k]['title']);
        }
        // 管理组title数组用顿号连接
        return $user_data;

    }

    /**
     * 根据角色名获取全部用户id
     * @param  string $title 角色名
     * @return array         用户数组
     */
    public function getUidsByTitle($title)
    {
        $user_ids = $this
            ->field('u.id,u.chinaname,u.username')
            ->alias('aga')
            ->join('__AUTH_GROUP__ ag ON aga.group_id=ag.id', 'LEFT')
            ->join('__USER__ u ON aga.uid=u.id', 'LEFT')
            ->where(array('title' => $title))
            ->select();
        return $user_ids;
    }
}
