# 您好，我是山海

很荣幸您使用本Composer，我的QQ是477633585 欢迎您的联系

# 本composer中涵盖了多种类型的Composer

PHP-Jwt
====

```bash
composer require firebase/php-jwt
```
Elasticsearch安装
====
```bash
composer require elasticsearch/elasticsearch
```
China-Lishuo-Cloud云存储
====

```bash
composer require china-lishuo/oss-utils
```

Yansongda2.0
====

```bash
支付前的配置文件
composer require symfony/psr-http-message-bridge

Composer
composer require yansongda/pay:^2.10 -vvv
```

百度云内容审核
====

```bash
composer require sy-records/baidu-textcensor
````

TP接口频率限制
====

```bash
composer require topthink/think-throttle
```

二维码生成包
====

```bash
composer require simplesoftwareio/simple-qrcode 1.3.*


Laravel配置参数 app文件
SimpleSoftwareIO\QrCode\QrCodeServiceProvider::class

'QrCode' => SimpleSoftwareIO\QrCode\Facades\QrCode::class

方法
try {
QrCode::encoding('UTF-8')->format('png')->generate('https://www.baidu.com/',public_path('image/'.time().'.png'));
return '生成成功';
}catch (\Exception $exception){
return fail($exception->getCode(),$exception->getMessage());
}

```

Excel导出 未使用过
====

```bash
1.安装Excel类
composer require maatwebsite/excel
2.注册服务到容器中
Maatwebsite\Excel\ExcelServiceProvider::class,
3.注册类到门面中
'Excel'=>Maatwebsite\Excel\Facades\Excel::class,
4.创建一个类，去实现这个接口
php artisan make:export UsersExport --model=User （类名自拟，user就是关联到的模型）
5.添加表头
use Maatwebsite\Excel\Concerns\WithHeadings;
6.导出
return Excel::download(new UsersExport(), "信息列表".time().'.xlsx');
php artisan make:export UsersExport --model=User
```

/函数节流/
====

```bash
function throttle(fn, interval) {
var enterTime = 0;//触发的时间
var gapTime = interval || 300 ;//间隔时间，如果interval不传，则默认300ms
return function() {
var context = this;
var backTime = new Date();//第一次函数return即触发的时间
if (backTime - enterTime > gapTime) {
fn.call(context,arguments);
enterTime = backTime;//赋值给第一次触发的时间，这样就保存了第二次触发的时间
}
};
}
```

AB压力测试工具
===
```bash
abs.exe -c 10 -n 10 测试网址
```

