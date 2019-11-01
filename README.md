# 面向Yii2框架的小白接口SDK包

## 安装
进行composer安装：
```
$ composer require "yesapicn/yesapi-yii2-api-sdk"
```

## 使用
参考以下示例，先初始化配置，再请求小白接口，最后处理接口结果。

```php
<?php

require_once '/vendor/autoload.php';

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

// 输出结果
var_dump($apiRs);
```

结果输出类似：
```php
array(3) {
  ["ret"]=>
  int(200)
  ["data"]=>
  array(3) {
    ["err_code"]=>
    int(0)
    ["err_msg"]=>
    string(0) ""
    ["title"]=>
    string(42) "Hi 小白君，欢迎使用小白接口！"
  }
  ["msg"]=>
  string(36) "当前小白接口：App.Hello.World"
}
```

## 帮助信息
 + 免费开通小白接口：http://open.yesapi.cn/
 + 查看我的小白接口应用信息：http://open.yesapi.cn/?r=App/Mine
 + 查看全部小白接口：http://api.yesapi.cn/docs.php

QQ交流群：897815708




