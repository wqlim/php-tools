<?php
// 函数库

if (!function_exists('get_config')) {
    /**
     * 读取配置文件
     * @param string $name 配置项
     * @return string
     */
    function get_config($name)
    {
        $config = require("config.php");
        return $config[$name];
    }
}

/**
 * 浏览器友好的变量输出,便于调试时候使用
 *
 * @param     mixed   $var       要输出查看的内容
 * @param     bool    $echo      是否直接输出
 * @param     string  $label     加上说明标签,如果有,这显示"标签名:"这种形式
 * @param     bool    $strict    是否严格过滤
 * @return    string
 */
if (!function_exists('dump')){
    function dump($var, $echo=true, $label=null, $strict=true)
    {
        $label = ($label===null) ? '' : rtrim($label) . ' ';
        if(!$strict) {
            if (ini_get('html_errors')) {
                $output = print_r($var, true);
                $output = "<pre>".$label.htmlspecialchars($output,ENT_QUOTES)."</pre>";
            } else {
                $output = $label . " : " . print_r($var, true);
            }
        }else {
            ob_start();
            var_dump($var);
            $output = ob_get_clean();
            if(!extension_loaded('xdebug')) {
                $output = preg_replace("/\]\=\>\n(\s+)/m", "] => ", $output);
                $output = '<pre>'. $label. htmlspecialchars($output, ENT_QUOTES). '</pre>';
            }
        }
        if ($echo) {
            echo($output);
            return null;
        }else
            return $output;
    }
}

if (!function_exists('rand_string')) {
    /**
     * 产生随机字串，可用来自动生成密码，默认长度6位 字母和数字混合
     * @param string $len 长度
     * @param string $type 字串类型 0字母数字 1数字 2小写字母 3大写字母 4字母
     * @param string $addChars 额外字符
     * @return string
     */
    function rand_string($len = 6, $type = '', $addChars = '')
    {
        $str = '';
        switch ($type) {
            case 1:
                $chars = str_repeat('0123456789', 3);
                break;
            case 2:
                $chars = 'abcdefghijklmnopqrstuvwxyz' . $addChars;
                break;
            case 3:
                $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ' . $addChars;
                break;
            case 4:
                $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz' . $addChars;
                break;
            default:
                // 默认去掉了容易混淆的字符oOLl和数字01，要添加请使用addChars参数
                $chars = 'ABCDEFGHIJKMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz23456789' . $addChars;
                break;
        }
        if ($len > 10) { //位数过长重复字符串一定次数
            $chars = ($type == 2 || $type == 3) ? str_repeat($chars, $len) : str_repeat($chars, 5);
        }
        if ($type != 5) {
            $chars = str_shuffle($chars);
            $str = substr($chars, 0, $len);
        }
        return $str;
    }
}


if (!function_exists('is_mobile')) {
    /**
     * 手机号码验证
     * @param $mobile 手机号
     */
    function is_mobile($mobile)
    {
        if (!is_numeric($mobile)) {
            return false;
        }
        return preg_match('#^13[\d]{9}$|^14[5,7]{1}\d{8}$|^15[^4]{1}\d{8}$|^17[0,3,6,7,8]{1}\d{8}$|^18[\d]{9}$#', $mobile) ? true : false;
    }
}

if (!function_exists('is_email')) {
    /**
     * 邮箱码验证
     * @param $email 邮箱
     */
    function is_email($email)
    {
        $regex= '/\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/';
        return preg_match($regex, $email) ? true : false;
    }
}

if (!function_exists('send_http_request')) {
    /**
     * 发送HTTP请求
     * @param $url 请求链接
     * @param $method 请求类型GET/POST
     * @param $data 请求数据
     * @return array
     */
    function send_http_request($url, $method = 'GET', $data='')
    {
        if (empty($url)) {
            return false;
        }
        $curl = curl_init();
        if (strtolower($method) == 'post') {
            curl_setopt($curl, CURLOPT_POST, 1);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        $result = curl_exec($curl);
        if ($result == false) {
            curl_close($curl);
            return false;
        } else {
            curl_close($curl);
            //var_dump(json_decode($result));exit;  
            return json_decode($result,true);
        }
    }
}

if (!function_exists('get_password')) {
    /**
     * 获取加密后的密码
     * @param $pw 明文密码
     * @param $code 加密字符串
     * @return string
     */
    function get_password($pw, $code='wqlim')
    {
        return md5($pw.$code.$pw);
    }
}
