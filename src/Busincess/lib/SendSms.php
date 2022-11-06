<?php
/**
 * 作者：本
 * 创建时间：2022/10/28 23:59
 * 格言：如果你是这个房间中最聪明的，那么你走错房间了
 */

namespace App\Busincess\lib;

class SendSms
{

    public static function SendSms($phone, $content)
    {
        $statusStr = array(
            "0" => "短信发送成功",
            "-1" => "参数不全",
            "-2" => "服务器空间不支持,请确认支持curl或者fsocket,联系您的空间商解决或者更换空间！",
            "30" => "密码错误",
            "40" => "账号不存在",
            "41" => "余额不足",
            "42" => "帐户已过期",
            "43" => "IP地址限制",
            "50" => "内容含有敏感词"
        );
        $smsapi = config('setting.Smsurl');
        $user = config('setting.user'); //短信平台帐号
        $pass = config('setting.pass');; //短信平台密码
        $content = "您的验证码是" . $content;//要发送的短信内容
//        $phone = $phone;//要发送短信的手机号码
        $sendurl = $smsapi . "sms?u=" . $user . "&p=" . $pass . "&m=" . $phone . "&c=" . urlencode($content);
        $result = file_get_contents($sendurl);
        // echo $statusStr[$result];
        if ($statusStr[$result] == "0") {
            return $content;
        } else {
            abort(111, $statusStr[$result]);
        }
}

}
