<?php
namespace frontend\controllers;

use backend\models\User;
use backend\models\UploadIcon;
use frontend\models\Common;
use frontend\models\Config;
use yii\helpers\Url;
use yii\helpers\Html;
use Yii;

class BaseController extends \yii\web\Controller{
	public $layout = false;
	public $enableCsrfValidation = false;
	public function beforeAction($action){
		// 正式测试注释掉这三行
		$openID = "oWPqjxMZFNNb3UPgbYC3aSwdxhqg";
		$user = User::findOne(['openID'=>$openID]);
		Yii::$app->user->login($user);
		
		$controller = Yii::$app->controller->id;
		$action = Yii::$app->controller->action->id;
		$url = $controller . '/' . $action;
		if($controller == 'base' || !Yii::$app->user->isGuest){
			//如果请求时这个控制器或者是登录用户，直接进入程序
			return true;
		}
		if(Yii::$app->user->isGuest){
			//未登录，先获取openid
			
			//将action和controller写入到session中，等登录后跳到该页面
			$session = Yii::$app->session;
			$session['controller'] = $controller;
			$session['action'] = $action;
			
			$this->actionAuth();
		}
		return true;
	}
	public function actionAuth(){
		$request = Yii::$app->request;
		$common = new Common();
		if(!$request->get('code')){
			//第一步读取code
			$redirectUrl = urlencode(Url::toRoute('base/auth', 'http'));
			$url = $common->createOauthUrlForCode($redirectUrl);
			// echo $url;
			$this->redirect("$url");
		}else{
			$url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=" . Config::APPID . "&secret=" . Config::APPSECRET . "&code=" . $request->get('code') . "&grant_type=authorization_code";
			$result = json_decode($common->http_get($url, false), true);
			$user = User::findOne(['openID' => $result['openid']]);
			if(!$user){
				//新用户
				//获取用户详细信息
				 $url = "https://api.weixin.qq.com/sns/userinfo?access_token=" . $result['access_token'] . "&openid=" . $result['openid'];
				$userinfo = $common->http_get($url, false);
				$userinfo = json_decode($userinfo, true);
				$nickname = $userinfo['nickname'];
				$sex = (int)$userinfo['sex'];
				$headimgurl = $userinfo['headimgurl'];
				$headimgurl = substr($headimgurl, 0 , -1) . "96";
				$name = date("YmdHis");
				$newname = "image/head/$name" . ".jpg";
				//下载图片
				$common->get_media($newname, $headimgurl);
				
				//保存用户信息
				$user = new User();
				$user->openID = $result['openid'];
				$user->nickname = $nickname;
				$user->portrait = $newname;
				$user->sex = $sex;
				$user->save();
				//注册用户登录信息
				Yii::$app->user->login($user);
				$this->redirect(['base/phone']);
			}else{
				//注册用户登录信息
				Yii::$app->user->login($user);
				if($user->phone == ""){
					$this->redirect(['base/phone']);
				}else{
					//跳转到初始页面
					$session = Yii::$app->session;
					$this->redirect([$session['controller'].'/'.$session['action']]);
				}
				
				
			}
		}
	}
	
	
	public function actionPhone(){
		$this->layout = "blank";
		//注册手机号并且选择角色
		return $this->render('phone');
	}
	
	public function actionPhoneSave(){
		//检验手机号、验证码、确认角色
		$phone = Yii::$app->request->post('phone');
		$user = User::findOne(['phone' => $phone]);
		if($user){
			echo Html::script("手机号已经注册!");
			$this->redirect(['base/phone']);
		}else{
			$session = Yii::$app->session;
			$user = User::findOne(['openID' => Yii::$app->user->identity['openID']]);
			$user->phone = $phone;
			if($user->save()){
				echo Html::script('alert("注册成功！");');
				$this->redirect([$session['controller'].'/'.$session['action']]);
			}else{
				echo Html::script('alert("注册失败！");');
				$this->redirect(['base/phone']);
			}
		}
	}

}