<?php

use wqlim\tools\wechat\Api;

require "../vendor/autoload.php";


echo config('weixin_url');

echo Api::test('最新版');