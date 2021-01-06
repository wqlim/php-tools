<?php
// 函数库

if (!function_exists('config')) {
    /**
     * 读取配置文件
     * @param string $name 配置项
     * @return string
     */
    function config($name)
    {
        $config = require("config.php");
        return $config[$name];
    }
}

if (!function_exists('randString')) {
    /**
     * 产生随机字串，可用来自动生成密码，默认长度6位 字母和数字混合
     * @param string $len 长度
     * @param string $type 字串类型 0字母数字 1数字 2小写字母 3大写字母 4字母
     * @param string $addChars 额外字符
     * @return string
     */
    function randString($len = 6, $type = '', $addChars = '')
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