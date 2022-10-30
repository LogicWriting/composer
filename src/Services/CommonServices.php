<?php

namespace Zhangzheng\Composer\Services;
/**
 * 作者：本
 * 创建时间：2022/10/27 19:46
 * 格言：如果你是这个房间中最聪明的，那么你走错房间了
 */
class CommonServices
{
    /**
     * @Desc:
     * @param $msg
     * @param $data
     * @param $code
     * @return false|string
     * 由 PhpStorm 创建
     * @author: 章政
     * @Date Time: 2022/10/27 22:38
     * 描述：统一Json返回成功
     */
    public static function success($msg = '', $data = [], $code = 200)
    {
        return json_encode([
            'msg' => $msg,
            'data' => $data,
            'code' => $code
        ]);
    }

    /**
     * @Desc:
     * @param $msg
     * @param $data
     * @param $code
     * @return false|string
     * 由 PhpStorm 创建
     * @author: 章政
     * @Date Time: 2022/10/27 22:38
     * 描述：统一Json错误返回
     */
    public static function fail($msg = '', $data = [], $code = 10000)
    {
        return json_encode([
            'msg' => $msg,
            'data' => $data,
            'code' => $code
        ]);
    }


    //递归函数 实现无限级分类列表
    function get_cate_list($list, $pid = 0, $level = 0)
    {
        static $tree = array();
        foreach ($list as $row) {
            if ($row['pid'] == $pid) {
                $row['level'] = $level;
                $tree[] = $row;
                $this->get_cate_list($list, $row['id'], $level + 1);
            }
        }
        return $tree;
    }

    //封装父子结构
    //传进数据和父类id
    function father($data, $pid = 0)
    {
        $child = [];
        foreach ($data as $v) {
            if ($v['pid'] == $pid) {
                $child[$v['id']] = $v;
                $child[$v['id']]['son'] = $this->father($data, $v['id']);
                print_r($v);
            }
        }
        return $child;
    }

}