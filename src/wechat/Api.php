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
    function send($touser, $template_id, $access_token, $data)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/message/subscribe/send?access_token=' . $access_token;
        $send_data = array(
            'touser'        => $touser,
            'template_id'   => $template_id,
            'data'          => $data
        );
        return send_http_request($url,'POST', $send_data);
    }
}
