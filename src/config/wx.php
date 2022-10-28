<?php
/**
 * 作者：本
 * 创建时间：2022/10/27 23:06
 * 格言：如果你是这个房间中最聪明的，那么你走错房间了
 */
return [
    "AppID" => "wxe83c9b039d06426b",
    "AppSecret" => "944b073ac0e0bc8e9d3331b1f5dd0be9",
    "get_login_code" => "https://api.weixin.qq.com/sns/jscode2session?appid=%s&secret=%s&js_code=%s&grant_type=authorization_code",
    "get_phone_AccessToken" => "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=%s&secret=%s",
    "post_phone_access" => "https://api.weixin.qq.com/wxa/business/getuserphonenumber?access_token=%s",
];