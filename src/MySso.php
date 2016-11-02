<?php

namespace wangjingchun\sso;

use wangjingchun\sso\Broker;

class MySso
{
	public $url;
	public $broker;
	public $secret;

	public function __construct($server_url = null, $broker = null, $secret = null)
	{
		if (is_null($server_url)) {
			throw new \InvalidArgumentException("server url not specified");
		}
		if (is_null($broker)) {
			throw new \InvalidArgumentException("broker not specified");
		}
		if (is_null($secret)) {
			throw new \InvalidArgumentException("secret not specified");
		}

		$this->url = $server_url;
        $this->broker = $broker;
        $this->secret = $secret;
	}

	public function login($username = null, $password = null, $jump = null, $rememberMe = 0)
	{
		if (is_null($username)) {
			throw new \InvalidArgumentException("username not specified");
		}
		if (is_null($password)) {
			throw new \InvalidArgumentException("password not specified");
		}

		$broker = new Broker($this->url, $this->broker, $this->secret);
		$broker->attach(true);

		$user = $broker->login($username, $password, $jump, $rememberMe);
		return $user;
	}

	public function logout($jump = null)
	{
		$broker = new Broker($this->url, $this->broker, $this->secret);
		$broker->attach(true);

		return $broker->logout($jump);
	}

	public function getUserInfo()
	{
		$broker = new Broker($this->url, $this->broker, $this->secret);
		$broker->attach(true);

		$user = $broker->getUserInfo();
		return $user;
	}

	public function flushUserInfo($uid = null)
	{
		if (is_null($uid)) {
			throw new \InvalidArgumentException("uid not specified");
		}

		$broker = new Broker($this->url, $this->broker, $this->secret);
		$broker->attach(true);

		$user = $broker->flushUserInfo($uid);
		return $user;
	}

}




?>
