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

	public function login($username = null, $password = null)
	{
		if (is_null($username)) {
			throw new \InvalidArgumentException("username not specified");
		}
		if (is_null($password)) {
			throw new \InvalidArgumentException("password not specified");
		}

		$broker = new Broker($this->url, $this->broker, $this->secret);
		$broker->attach(true);

		$user = $broker->login($username, $password);
		return $user;
	}

	public function logout()
	{
		$broker = new Broker($this->url, $this->broker, $this->secret);
		$broker->attach(true);

		$broker->logout();
	}

	public function getUserInfo()
	{
		$broker = new Broker($this->url, $this->broker, $this->secret);
		$broker->attach(true);

		$user = $broker->getUserInfo();
		return $user;
	}
}




?>
