<?php
/**
 * 作者：本
 * 创建时间：2022/10/27 22:38
 * 格言：如果你是这个房间中最聪明的，那么你走错房间了
 */

namespace Zhangzheng\Composer\Services;

class JwtServices
{
    /**
     * @Desc:
     * 由 PhpStorm 创建
     * @author: 章政
     * @Date Time: 2022/10/27 22:39
     * 描述：设定非对称加密Jwt
     */
    public static function setJwt($uid ,$exp = 7200)
    {
        $payload = [
            'uid' => $uid ,
            'exp' => time() + $exp ,
        ];
        $token = JWT::encode($payload, config('setting.privateKey'), 'RS256');
        return $token;
    }

    /**
     * @Desc:
     * 由 PhpStorm 创建
     * @author: 章政
     * @Date Time: 2022/10/27 22:39
     * 描述：获取非对称解密Jwt
     */
    public static function getJwt($token)
    {
        $decoded = JWT::decode($token, new Key(config('setting.publicKey'), 'RS256'));
        $decoded && $decoded = (array)$decoded;
        return $decoded;
    }



}