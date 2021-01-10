<?php

namespace wqlim\tools\wechat;

class Api
{
    public static function test($title)
    {
        return $title;
    }

    /**
     * 发送微信订阅消息
     * 需要用户授权后才可发送成功！
     * @param string        $touser 用户的openid 
     * @param string        $template_id 订阅消息的模板id
     * @param string        $access_token 微信access_token
     * @param array         $data 二维数组  要发送的数据内容
     */
    public static function send($touser, $template_id, $access_token, $data)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/message/subscribe/send?access_token=' . $access_token;
        $send_data = array(
            'touser'        => $touser,
            'template_id'   => $template_id,
            'data'          => $data
        );
        return send_http_request($url,'POST', $send_data);
    }

    /**
     * 小程序登陆，使用code换取openid
     * @param string        $appid 小程序的appid
     * @param string        $secret 小程序的secret
     * @param string        $code 小程序登陆凭证code
     */
    public static function jscode2session($appid, $secret, $code)
    {
        $url = 'https://api.weixin.qq.com/sns/jscode2session?appid=' . $appid . '&secret=' . $secret . '&js_code=' . $code . '&grant_type=authorization_code';
        return send_http_request($url);
    }
}
