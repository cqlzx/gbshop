<?php

namespace backend\controllers;

use Yii;
use backend\models\Shop;
use \yii\data\Pagination;
use backend\models\ShopRecharge;
use backend\models\ShopWithdraw;
use backend\models\UserRecharge;
use backend\models\UserWithdraw;
use backend\models\User;
use backend\models\Order;
use yii\data\ActiveDataProvider;


class GbController extends \yii\web\Controller
{
	public $layout = "jf-main";
	public $enableCsrfValidation = false;
    public function actionIndex()
    {
		$request = Yii::$app->request;
		$params['classA'] = $request->get('classA', 1);
		$params['honour'] = $request->get('honour', Shop::UNHONOURED);
		$query = Shop::find()->where($params);
		$phone = $request->post('phone');
		if($phone){
			$query = $query->andWhere("phone like '%$phone%'");
		}
		$dataProvider = new ActiveDataProvider([
			'query' => $query,
			'pagination' => [
				'pageSize' => 10,
			],
		]);
        return $this->render('index', ['dataProvider'=>$dataProvider]);
    }
	public function actionSave(){
		$params = Yii::$app->request->post();
		$id = $params['id'];
		$model = Shop::findOne($id);
		$model->attributes = $params;
		$model->increaseRateNew = ($model->gjNew - $model->gjNow) / $model->gjNow;
		if($model->save()){
			echo json_encode(array('status'=>200, 'data'=>$model->attributes));
		}else{
			echo json_encode(array('status'=>400, 'errors'=>$model->getErrors()));
		}
	}
	public function actionDelete(){
		$request = Yii::$app->request;
		$id = $request->post('id');
		$model = Shop::findOne(0);
		if($model){
			if($model->save()){
				echo json_encode(array('status'=>200, 'data'=>$model->attributes));
			}else{
				echo json_encode(array('status'=>400, 'errors'=>$model->getErrors()));
			}
		}else{
			echo json_encode(array('status'=>400, 'errors'=>'数据错错误'));
		}
		
	}
	public function actionRand(){
		$request = Yii::$app->request;
		$low = $request->post("low");
		$high = $request->post("high");
		$connection = Yii::$app->db;
		$num = $connection->createCommand("update shop set gjNew =  TRUNCATE($low+($high-$low)*RAND(),2)")
				->execute();
		$num1 =  $connection->createCommand("update shop set increaseRateNew = (gjNew - gjNow)/gjNow")
				->execute();
		if($num){
			echo json_encode(array('status'=>200, 'data'=>$num));
		}else{
			echo json_encode(array('status'=>400));
		}
	}
	
	public function actionDistribute(){
		$connection = Yii::$app->db;
		$num = $connection->createCommand("update shop set increaseRateOld = (gjNew - gjNow)/gjNow, gjOld = gjNow, gjNow = gjNew")
				->execute();
		if($num){
			echo json_encode(array('status'=>200, 'data'=>$num));
		}else{
			echo json_encode(array('status'=>400));
		}
	}
	
	public function actionShopRecharge(){
		$request = Yii::$app->request;
		$id = $request->get('shopID');
		$query = ShopRecharge::find()->where(['shopID'=>$id]);
		$dataProvider = new ActiveDataProvider([
			'query' => $query,
			'pagination' => [
				'pageSize' => 10,
			],
		]);
        return $this->render('shopRecharge', ['dataProvider'=>$dataProvider]);
	}
	public function actionShopWithdraw(){
		$request = Yii::$app->request;
		$id = $request->get('shopID');
		$query = ShopWithdraw::find()->where(['shopID'=>$id]);
		$dataProvider = new ActiveDataProvider([
			'query' => $query,
			'pagination' => [
				'pageSize' => 10,
			],
		]);
        return $this->render('shopWithdraw', ['dataProvider'=>$dataProvider]);
	}
	public function actionUserGb(){
		return $this->render('userGb');
	}
	public function actionUserDelete(){
		$request = Yii::$app->request;
		$userid = $request->post('userid');
		$user = User::find()->where(['ID'=>$userid])->One();
		if($user){
			if($user->delete()){
				echo json_encode(array('status'=>200, 'data'=>$userid));
			}else{
				echo json_encode(array('status'=>400, 'errors'=>$user->getErrors()));
			}
		}else{
			echo json_encode(array('status'=>400, 'errors'=>'用户不存在！'));
		}
	}
	public function actionUserRecharge(){
		$request = Yii::$app->request;
		$id = $request->get('userid');
		$query = UserRecharge::find()->where(['userID'=>$id]);
		$dataProvider = new ActiveDataProvider([
			'query' => $query,
			'pagination' => [
				'pageSize' => 10,
			],
		]);
        return $this->render('userRecharge', ['dataProvider'=>$dataProvider]);
	}
	public function actionUserWithdraw(){
		$request = Yii::$app->request;
		$id = $request->get('userid');
		$query = UserWithdraw::find()->where(['userID'=>$id]);
		$dataProvider = new ActiveDataProvider([
			'query' => $query,
			'pagination' => [
				'pageSize' => 10,
			],
		]);
        return $this->render('userWithdraw', ['dataProvider'=>$dataProvider]);
	}
	public function actionUserOrder(){
		$request = Yii::$app->request;
		$id = $request->get('userid');
		$query = Order::find()->where(['userID'=>$id])->joinWith('product');
		$dataProvider = new ActiveDataProvider([
			'query' => $query,
			'pagination' => [
				'pageSize' => 10,
			],
		]);
        return $this->render('userOrder', ['dataProvider'=>$dataProvider]);
	}
	public function actionMoveToMyAccount(){
		$request = Yii::$app->request;
		$userid = json_decode($request->post('userid'));
		$flag = true;
		for($i = 0; $i < count($userid); $i++){
			$user = User::findOne($userid[$i]);
			$user->shopID = 0;
			$user->shopName = "超级管理员";
			if(!$user->save()){
				$flag = false;
				break;
			}
		}
		if($flag){
			echo json_encode(array('status'=>200, 'data'=>$flag));
		}else{
			echo json_encode(array('status'=>400, 'errors'=>'错误！'));
		}
	}
}
