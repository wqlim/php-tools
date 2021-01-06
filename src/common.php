<?php
// 函数库

if (!function_exists('config')) {
    /**
     * 读取配置文件
     */
    function config($name)
    {
        $config = require("config.php");
        return $config[$name];
    }
}
