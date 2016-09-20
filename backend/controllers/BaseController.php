<?php

namespace backend\controllers;

use Yii;
use backend\models\Admin;
class BaseController extends \yii\web\Controller
{
	public $layout = false;
	public $enableCsrfValidation = false;
	public function beforeAction($action){
		$controller = Yii::$app->controller->id;
		$action = Yii::$app->controller->action->id;
		$url = $controller . '/' . $action;
		if(Yii::$app->user->isGuest && $url != 'base/login' && $url != 'base/valid'){
			//未登录，跳转到登录界面
			$this->redirect(['base/login']);
		}
		if(!Yii::$app->user->isGuest){
			//已登录检测权限
			$request = Yii::$app->request;
			$categories = json_decode(Yii::$app->user->identity->categories);
			if($request->get("classA") && !in_array($request->get("classA"), $categories)){
				throw new \yii\web\UnauthorizedHttpException('你没有查看此分类权限');
			}
		}
		return true;
	}
	
	public function actionLogin(){
		return $this->render('login');
	}
	public function actionValid(){
		$request = Yii::$app->request;
		$username = $request->post("username");
		$password = $request->post("password");
		$identity = Admin::findOne(['username' => $username, 'password'=>$password]);
		if($identity == null){
			$this->redirect(['base/login','error'=>'用户名或密码错误']);
		}
		Yii::$app->user->login($identity);
		$identity = Yii::$app->user->identity->categories;
		var_dump($identity);

	}
	public static function createRole($name)
	{    
		//创建角色
		$auth = Yii::$app->authManager;    
		$role = $auth->createRole($name);    
		$role->description = '创建了 ' . $name. ' 角色';    
		$auth->add($role);
	}
	
	public function createPermission($name)
	{   
		//创建用户 
		$auth = Yii::$app->authManager;    
		$createPost = $auth->createPermission($name);    
		$createPost->description = '创建了 ' . $name. ' 权限';    
		$auth->add($createPost);
	}
	
    public function actionIndex()
    {   var_dump(Yii::$app->user->isGuest);

    }

}
