<?php
namespace frontend\models;
use frontend\models\Token;
use frontend\models\Config;

/*所有文件的基类*/

class Common{
	
	
	/**
	 * 	作用：产生随机字符串，不长于32位
	 */
	public function createNoncestr( $length = 32 ) 
	{
		$chars = "abcdefghijklmnopqrstuvwxyz0123456789";  
		$str ="";
		for ( $i = 0; $i < $length; $i++ )  {  
			$str.= substr($chars, mt_rand(0, strlen($chars)-1), 1);  
		}  
		return $str;
	}
	
	
	/*通过post方式获取数据*/
	function http_post($url, $data){
		$ch = curl_init();
		$token = $this->get_identified_token();
		curl_setopt($ch, CURLOPT_URL, $url . $token);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		//将返回数据以文件流的方式输出，而不是直接输出
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec($ch);
		curl_close($ch);
		return $result;
	}
	/**
	 *通过get方式获取数据
	 *参数url，必须；$need_token, true默认自动添加， false不加token
	 */
	public function http_get($url, $need_token = true){
		$ch = curl_init();
		if($need_token){
			$url .= $this->get_identified_token();
		}
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		$result = curl_exec($ch);
		return $result;
	}
	
	/**
	 *通过APPID和ACCESS获取token
	 */
	function get_token()
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=". Config::APPID . "&secret=".Config::APPSECRET);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		$result = json_decode(curl_exec($ch), true);
		//var_dump($result);
		return $result["access_token"];
	}
	
	/*
	 *token有两小时的有效期，先从数据库中读取，超时在用get_token
	 */
	function get_identified_token()
	{
		$model = Token::find()->one();
		if(!$model){
			//第一次使用token表是空
			$model = new Token();
			$model->token = $this->get_token();
			$model->save();
			return $model->token;
		}
		$time_old = $model->createTime;
		$time_new = date("Y-m-d H:i:s");
		$time_diff = strtotime($time_new) - strtotime($time_old);
		if ($time_diff < 7200 && $model->token != ""){
			return $model->token;
		}else{
			$model->token = $this->get_token();
			$model->save();
			return $token;
		}
	}
	
	/**
	 *授权第一步，获取code
	 */
	function createOauthUrlForCode($redirectUrl, $state='1'){
		return "https://open.weixin.qq.com/connect/oauth2/authorize?appid=" . Config::APPID . "&redirect_uri=$redirectUrl&response_type=code&scope=snsapi_userinfo&state=$state#wechat_redirect";
	}

	function get_media($filename, $url){
		$fileinfo = $this->downloadmedia($url);
		$this->savemedia($filename, $fileinfo["body"]);
	}



	/*下载媒体文件
	 *return array: header body
	 */
	function downloadmedia($url){
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_NOBODY, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$package = curl_exec($ch);
		$httpinfo = curl_getinfo($ch);
		curl_close($ch);
		$imgAll = Array_merge(array("header" => $httpinfo), array("body" => $package));
		return $imgAll;
	}


	function savemedia($filename, $filecontent){
		$localFile = fopen($filename , "w");
		if(false !== $localFile){
			if(false !== fwrite($localFile, $filecontent)){
				fclose($localFile);
			}
		}
	}
	
	
	
}