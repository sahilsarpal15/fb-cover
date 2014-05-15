<?php namespace Acme\Services;

class CurlServices{
	public function getPage($id)
	{		
		$url ='https://graph.facebook.com/'.$id;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$a=curl_exec($ch);
		curl_close($ch);
		$b=json_decode($a);

		return $b;
	}

	public function postimage($url,$args)
	{

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $args);
		$data = curl_exec($ch);
		$a=json_decode($data);

		return $a;
	}
}