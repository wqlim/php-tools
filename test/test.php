<?php

use wqlim\tools\db\Table;
use wqlim\tools\wechat\Api;

require "../vendor/autoload.php";

$tel = '12344445555';
is_mobile($tel);

//查看数据结构
// Table::index('127.0.0.1','test','root','123456');


// 测试send_http_request
$url = 'http://wsxb.wqlim.com/api/wsxb/index/return_type';
$data = send_http_request($url);
var_dump($data);
dump($data);