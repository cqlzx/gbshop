<?php

namespace frontend\controllers;

use backend\models\User;
use frontend\models\Favor;
use backend\models\UserWithdraw;
use Yii;
class AccountController extends BaseController
{
	public $layout = 'footer_nav';
	public $enableCsrfValidation = false;
    public function actionIndex()
    {
        return $this->render('index');
    }
	public function actionUserInfo(){
		return $this->render('userInfo');	
	}
	public function actionUserSave(){
		$user = User::findOne(Yii::$app->user->id);
		$user->attributes = Yii::$app->request->post();
		$userfind = User::find()->where(['phone'=>Yii::$app->request->post("phone")])->andWhere(" ID != " . $user->ID)->one();
		if(!$userfind){
			$user->save();
			$this->redirect(['index']);
		}else{
			$this->redirect(['user-info', 'error'=>'手机号已被注册！']);
		}
	}
	public function actionUserFavor(){
		$params = array();
		$params['title'] = "我的收藏";
		$params['products'] = Favor::find()->select('product.*')->where(['userID' => Yii::$app->user->id])->join('LEFT JOIN', 'product', 'favor.productID = product.ID')->asArray()->all();
		// var_dump($params);
		return $this->render('productItem', $params);
	}
	public function actionCashWithdraw(){
		$params['records'] = UserWithdraw::find()->where(['userID' => Yii::$app->user->id]);
		return $this->render("cashWithdraw", $params);
	}
	public function actionOrder(){
		if(Yii::$app->user->identity->attributes['role'] == User::USER){
			$this->render('userOder');
		}else{
			$this->render('shopOrder');
		}
	}

}
