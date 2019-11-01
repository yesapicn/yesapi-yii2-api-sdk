<?php

require_once dirname(__FILE__) . '/../src/YesApiClient.php';

use YesApiCn\Yii2ApiSDK\YesApiClient;

// 初始化配置
// 小白相关配置，可以登录后进入个人中心页面查看：http://open.yesapi.cn/?r=App/Mine
YesApiClient::initConfig(array(
    'api_host' => 'http://api.okayapi.com', // 小白接口域名
    'app_key' => '16BD4337FB1D355902E0502AFCBFD4DF', // 小白接口应用key
    'app_secrect' => 'LKJ63BzVrhX9SPhWcjl392kFqPTdzlUVK6ixnUrCYSbwuDyfxVubA8Fc4q67arT8qTpCtY5', // 小白接口应用密钥
    'debug' => false, // 是否调试
));

// 请求小白接口
// 小白接口在线文档：http://api.yesapi.cn/docs.php
$apiRs = YesApiClient::request('App.Hello.World', array('name' => '小白君'));

var_dump($apiRs);

