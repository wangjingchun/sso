# sso login

## composer

composer require wangjingchun/sso

## composer.json

"require": {
	"wangjingchun/sso": "^0.1.0"
}

## 参数

1. $server_url，server同步登陆的请求地址
2. $broker_id，调用方站点的id
3. $broker_secret，调用方站点的secret

## 方法

1. getUserInfo()，获取用户登陆信息
2. login($username, $password)，用户登陆，参数为用户名和密码
3. logout()，退出登陆

## 例子程序

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use wangjingchun\sso\MySso;

class TestController extends Controller
{
	public $server_url = 'http://homestead.app/web/wjc/ssoserver';
	public $broker_id = 'Alice';
	public $broker_secret = '8iwzik1bwd';

	public function index()
	{
		$mySso = new MySso($this->server_url, $this->broker_id, $this->broker_secret);

		try {
		    $user = $mySso->getUserInfo();
		} catch (NotAttachedException $e) {
		    header('Location: ' . $_SERVER['REQUEST_URI']);
		    exit;
		} catch (SsoException $e) {
		    header("Location: " . url('sso/error') . "?sso_error=" . $e->getMessage(), true, 307);
		}

		if (!$user) {
		    header("Location: " . url('test/login'), true, 307);
		    exit;
		} else {
			echo 'username->' . $user['username'] . '<br>';
			echo 'fullname->' . $user['fullname'] . '<br>';
			echo 'email->' . $user['email'] . '<br><br>';

			echo '<a href="' . url('test/logout') . '">logout</a>';
		}
	}

	public function login()
	{
		return view('test.login');
	}

	public function postlogin(Request $request)
	{
		$username = $request->input('username');
		$password = $request->input('password');

		$mySso = new MySso($this->server_url, $this->broker_id, $this->broker_secret);

		if ($mySso->getUserInfo() || $mySso->login($username, $password)) {
			header("Location: " . URL('test/index'), true, 303);
        	exit;
		}
	}

	public function logout()
	{
		$mySso = new MySso($this->server_url, $this->broker_id, $this->broker_secret);

		$mySso->logout();
		header("Location: " . URL('test/index'), true, 303);
        	exit;
	}

	public function error(Request $request)
	{
		$sso_error = $request->input('sso_error');

		echo $sso_error;
	}
}


?>
```




