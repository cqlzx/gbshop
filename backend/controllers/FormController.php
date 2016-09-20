<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;

/*处理表单*/
class JfController extends Controller{
	public $layout = "jf-main"; //布局文件
	public function actionIndex(){
		return $this->render("index",array('data'=>1));
	}
	/*商圈管理*/
	public function actionCircle(){
		return $this->render("circle");
	}
}