<?php

class Curl
{

	private
		$ch,
		$headers = array(),
		$cookies = array(),
		$cookieFile = 'tmp/cookiefile.txt'
	;

	public function __construct($url)
	{
		$this->ch = curl_init($url);
	}

	private function initCookie()
	{
		if(!empty($this->cookies))
		{
			$this->setOption(CURLOPT_COOKIE,http_build_cookie($this->cookies));
		}
		//CURLOPT_COOKIEFILE
		//CURLOPT_COOKIEJAR
		return $this;
	}

	private function initHeader()
	{
		if(!empty($this->headers))
		{
			foreach($this->headers as $header)
			{
				$this->setOption(CURLOPT_HTTPHEADER,$header);
			}
		}
		return $this;
	}

	public function setOption($option,$value)
	{
		curl_setopt($this->ch,$option,$value);
		return $this;
	}

	public function setOptions($options)
	{
		curl_setopt_array($this->ch,$options);
		return $this;
	}

	public function exec()
	{
		$this
			->initCookie()
			->initHeader()
		;
		return curl_exec($this->ch);
	}

	public function setHeader($header)
	{
		$this->headers[] = $header;
		return $this;
	}

	public function setHeaders($headers)
	{
		foreach($headers as $header)
		{
			$this->setHeader($header);
		}
		return $this;
	}

	public function setCookie($cookie)
	{
		$this->cookies[] = $cookie;
		return $this;
	}

	public function setCookies($cookies)
	{
		foreach($cookies as $cookie)
		{
			$this->cookies[] = $cookie;
		}
		return $this;
	}

	public function setPost($post)
	{
		$this
			->setOption(CURLOPT_POST,1)
			->setOption(CURLOPT_POSTFIELDS,http_build_query($post))
		;
		return $this;
	}
}