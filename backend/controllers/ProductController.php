<?php

namespace backend\controllers;
use Yii;
use backend\models\Product;
use backend\models\AdvertiseClickBuy;
use backend\models\UploadIcon;
use yii\web\UploadedFile;

class ProductController extends \yii\web\Controller
{
	public $enableCsrfValidation = false;
	public $layout = "jf-main"; //布局文件
    public function actionIndex()   //产品页面
    {
        return $this->render('index');
    }
	public function actionAdd(){     //添加产品页面
		return $this->render('add');
	}
	public function actionUpdate(){     //更新产品页面
		$request = Yii::$app->request;
		$id = $request->get('id');
		$model = Product::findOne($id);
		return $this->render('update', ['data' => $model->attributes]);
	}
	public function actionSave(){
		$request = Yii::$app->request;
		$id = $request->post('productID');
		$beginTime = $request->post('beginTime');
		$beginTime = str_replace("T", " ", $beginTime);
		$gbBuy = $request->post("gbBuy");
		$todayBuy = $request->post("todayBuy");
		$zeroBuy = $request->post("zeroBuy");
		$adBuy = $request->post("adBuy");
		$model = Product::findOne($id);
		// var_dump($model);
		$model->beginTime = $beginTime;
		$model->gbBuy = $gbBuy;
		$model->todayBuy = $todayBuy;
		$model->zeroBuy = $zeroBuy;
		$model->adBuy = $adBuy;
		$model->numLeft = $model->numLeft + $request->post("numAll") - $model->numAll;
		$model->numAll = $request->post("numAll");
		if($model->save()){
			echo json_encode(array('status'=>200, 'data'=>array('numLeft'=>$model->numLeft)));
		}else{
			echo json_encode(array('status'=>400, 'errors'=>$model->getErrors()));
		}
		
	}
	public function actionBuy(){
		//购买广告点击次数
		$request = Yii::$app->request;
		$id = $request->post('productID');
		$productName = $request->post("productName");
		$shopID = $request->post("shopID");
		$shopName = $request->post("shopName");
		$model = Product::findOne($id);
		$cash = $request->post("cash");
		$adNew = $cash/0.1/Product::COEFFICIENT*0.5;
		$model->adLeft = $adNew + $model->adLeft;
		
		// 点点赚币记录
		$AdvertiseClickBuy = new AdvertiseClickBuy();
		$AdvertiseClickBuy->productID = $id;
		$AdvertiseClickBuy->productName = $productName;
		$AdvertiseClickBuy->shopID = $shopID;
		$AdvertiseClickBuy->shopName = $shopName;
		$AdvertiseClickBuy->cash = $cash;
		$AdvertiseClickBuy->clickTimes = $adNew;
		$AdvertiseClickBuy->classA = $model->classA;
		// 事务保持一致性
		$connection = $model->getDb();
		$transaction = $connection->beginTransaction();
		if($model->save() && $AdvertiseClickBuy->save()){
			$transaction->commit();
			echo json_encode(array('status'=>200, 'adLeft'=>$model->adLeft));
		}else{
			$transaction->rollBack();
			echo json_encode(array('status'=>400, 'errors'=>array('product'=>$model->getErrors(), 'ad'=>$AdvertiseClickBuy->getErrors())));
		}
	}
	public function actionSubmit(){  //处理提交产品页面和修改页面的数据
		$request = Yii::$app->request;
		$id = $request->post("ID");
		if($id){
			$product = Product::findOne($id);
		}else{
			$product = new Product();
		}
		$product->attributes = $request->post();
		$uploadIcon = new UploadIcon();
		$uploadIcon->path = "product";
		$uploadIcon->image = UploadedFile::getInstanceByName('pic');
		if ($uploadIcon->image != null && $uploadIcon->upload()) {
			if($product->photo != ""){
					unlink($product->photo);
			}
			$product->photo = $uploadIcon->newname;
		}
		if($product->save()){
			echo json_encode(array('status' => 200));
		}else{
			echo json_encode(array('status' => 400, 'errors' => $product->getErrors()));
		}
	}
	public function actionDelete(){
		$request = Yii::$app->request;
		$id = $request->post("ID");
		$model = Product::findOne($id);
		if($model){
			if($model->photo){
				unlink($model->photo);
			}
			if($model->delete()){
				echo json_encode(array('status' => 200));
			}else{
				echo json_encode(array('status' => 400, 'errors' => $model->getErrors()));
			}
		}else{
			echo json_encode(array('status' => 400, 'errors' => '参数错误'));
		}
		
	}
}
