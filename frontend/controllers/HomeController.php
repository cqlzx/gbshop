<?php

namespace frontend\controllers;
use Yii;
use backend\models\Advertise;
use backend\models\ClassA;
use backend\models\ClassB;
use backend\models\Shop;
use backend\models\Product;
use backend\models\Circle;
use yii\helpers\Url;


class HomeController extends \yii\web\Controller
{
	public $layout = 'footer_nav';
	const PAGESIZE = 10;
	public $enableCsrfValidation = false;
    public function actionIndex()
    {
        return $this->render('index');
    }
	public function actionShoplist(){
		$request = \Yii::$app->request;
		$params = array();
		$wheres = array();
		$arrs = array('classB', 'circle');
		//获取参数
		if($request->get("classB") != null && $request->get("classB")!= 'all'){
			$classB = intval($request->get("classB"));
		}else{
			$classB = null;
		}
		
		$circle = intval($request->get("circle"));
		$classA = intval($request->get('classA'));
		$advertise = intval($request->get("advertise", 0));
		//股价和涨幅 排序 
		//股价
		$gjNow = intval($request->get("gjNow", 0));
		//涨幅
		$increaseRate = intval($request->get('increaseRate', 0));
		$orderSql = null;
		
		if($gjNow == 1) $orderSql = "gjNow ASC";
		if($gjNow == 2) $orderSql = "gjNow DESC";
		if($increaseRate == 1) $orderSql = "increaseRateOld ASC";
		if($increaseRate == 2) $orderSql = "increaseRateOld DESC";
		
		
		//商圈、二级分类 条件
		//商圈
		$circles = Circle::find()->asArray()->all();
		$modelCircle = Circle::findOne($circle);
		$circlename = ($modelCircle) ? $modelCircle->name : '商圈';
		
		//二级分类项目
		if($circle) $wheres['circle'] = $circle; //商圈
		if($classA) $wheres['classA'] = $classA; //一级分类
		if($classB) $wheres['classB'] = $classB; //二级分类
		$andWhere = ($advertise) ?  'ID in (select ID from product where adBuy = 1 and adLeft > 0)' : "";  //点点赚币
		$classBs = ClassB::find()->where(['classA' => $classA])->asArray()->orderBy("sequence")->all();
		
		//商家查询语句
		$page = intval($request->get("page", 0));
		$query = Shop::find()->where($wheres)->andWhere($andWhere)->orderBy($orderSql)->createCommand()->getRawSql();
		$shops = Yii::$app->db->createCommand($query . " LIMIT :offset, :limit")
		->bindValues([':offset'=> self::PAGESIZE * $page, ':limit' => self::PAGESIZE])
		->queryAll();
		//项目列表
		if($request->get("ajax")){
			if(count($shops) == 0){
				echo '-1';
			}else{
				echo $this->renderPartial('shopitem', ['shops'=>$shops]);
			}
			
		}else{
			//广告
			$pics  = Advertise::find()->where(['classA' => $classA])->asArray()->all();
			$picnnum = count($pics);
			$modelClassA = ClassA::findOne($classA);
			$params['classA'] = $classA;
			$params['advertise'] = $advertise;
			$params['pics'] = $pics;
			$params['picnnum'] = $picnnum;
			$params['modelClassA'] = $modelClassA;
			$params['classB'] = $classB;
			$params['circle'] = $circle;
			$params['increaseRate'] = $increaseRate;
			$params['gjNow'] = $gjNow;
			$params['circles'] = $circles;
			$params['circlename'] = $circlename;
			$params['classBs'] = $classBs;
			$params['shops'] = $shops;
			// var_dump($params);
			return $this->render('shoplist', $params);
		}
	}
	public function actionShop(){
		return $this->render('shop');
	}
	public function actionAlbum(){
		return $this->render('album');
	}
	public function actionBuy(){
		return $this->render('buy');
	}
	public function actionAllclassification(){
		return $this->render('allclassification');
	}
	
	public function actionShoplistorder(){
		$request = \Yii::$app->request;
		$params = array();
		$wheres = array();
		//获取参数
		
		$circle = intval($request->get("circle"));
		$classA = intval($request->get('classA'));
		$advertise = intval($request->get("advertise", 0));
		//股价和涨幅 排序 
		//股价
		$gjNow = intval($request->get("gjNow", 0));
		//涨幅
		$increaseRate = intval($request->get('increaseRate', 0));
		$orderSql = null;
		
		if($gjNow == 1) $orderSql = "gjNow ASC";
		if($gjNow == 2) $orderSql = "gjNow DESC";
		if($increaseRate == 1) $orderSql = "increaseRateOld ASC";
		if($increaseRate == 2) $orderSql = "increaseRateOld DESC";
		
		
		//商圈、二级分类 条件
		//商圈
		$circles = Circle::find()->asArray()->all();
		$modelCircle = Circle::findOne($circle);
		$circlename = ($modelCircle) ? $modelCircle->name : '商圈';
		
		//二级分类项目
		if($circle) $wheres['circle'] = $circle; //商圈
		if($classA) $wheres['classA'] = $classA; //一级分类
		$andWhere = ($advertise) ?  'ID in (select ID from product where adBuy = 1 and adLeft > 0)' : "";  //点点赚币
		
		//商家查询语句
		$page = intval($request->get("page", 0));
		$query = Shop::find()->where($wheres)->andWhere($andWhere)->andWhere("classA>0")->orderBy($orderSql)->createCommand()->getRawSql();
		$shops = Yii::$app->db->createCommand($query . " LIMIT :offset, :limit")
		->bindValues([':offset'=> self::PAGESIZE * $page, ':limit' => self::PAGESIZE])
		->queryAll();
		//项目列表
		if($request->get("ajax")){
			if(count($shops) == 0){
				echo '-1';
			}else{
				echo $this->renderPartial('shopitem', ['shops'=>$shops]);
			}
		}else{
			//广告
			$pics  = Advertise::find()->where(['classA' => $classA])->asArray()->all();
			$picnnum = count($pics);
			$modelClassA = ClassA::findOne($classA);
			$params['classA'] = $classA;
			$params['classAs'] = ClassA::find()->asArray()->all();
			$params['advertise'] = $advertise;
			$params['pics'] = $pics;
			$params['picnnum'] = $picnnum;
			$params['modelClassA'] = $modelClassA;
			$params['circle'] = $circle;
			$params['increaseRate'] = $increaseRate;
			$params['gjNow'] = $gjNow;
			$params['circles'] = $circles;
			$params['circlename'] = $circlename;
			$params['shops'] = $shops;
			// var_dump($params);
			return $this->render('shoplistorder', $params);
		}
	}
	
	public function actionProductlist(){
		$request = \Yii::$app->request;
		$params = array();   //传递到view层的参数
		$wheres = array();	 //筛选条件
		//获取参数
		$andWheres = array();
		//一级分类 商圈 点点赚币
		$circle = intval($request->get("circle"));
		$classA = intval($request->get('classA'));
		$advertise = intval($request->get("advertise", 0));
		$urlThis = '';
		$type = $request->get("type");
		switch($type){
			case '1':
				$urlThis = Url::to(['home/productlist', 'type'=>'1']);
				$wheres['zeroBuy'] = 1;
				$andwheres[] = ' '. date("Y-m-d H:i:s") . ' between beginTime and endTime';
				break;
			case '2':
				$urlThis = Url::to(['home/productlist', 'type'=>'2']);
				$wheres['gbBuy'] = 1;
				$andwheres[] = ' '. date("Y-m-d H:i:s") . ' between beginTime and endTime';
				break;
			case '3':
				$urlThis = Url::to(['home/productlist', 'type'=>'3']);
				$wheres['todayBuy'] = 1;
				break;
			default:
				$this->redirect(['home/index']);
		}
		//
		if($classA) $wheres['classA'] = $classA; //一级分类 
		
		//股价和涨幅 排序 
		//股价
		$gjNow = intval($request->get("gjNow", 0));
		//涨幅
		$orderSql = null;
		if($gjNow == 1) $orderSql = "gbPrice ASC";
		if($gjNow == 2) $orderSql = "gbPrice DESC";
		
		//商圈 条件
		//商圈
		$circles = Circle::find()->asArray()->all();
		$modelCircle = Circle::findOne($circle);
		$circlename = ($modelCircle) ? $modelCircle->name : '商圈';
		
		//二级分类项目
		if($circle) $andwheres[] = ' shopID in (select ID from Product where circle = $circle) '; //商圈
		if($advertise) $andWheres[] = " adBuy = 1 and adLeft > 0 ";//点点赚币
		
		//商家查询语句
		$andWhere = implode(' and ', $andWheres);
		$page = intval($request->get("page", 0));
		$query = Product::find()->where($wheres)->andWhere($andWhere)->orderBy($orderSql)->createCommand()->getRawSql();
		$products = Yii::$app->db->createCommand($query . " LIMIT :offset, :limit")
		->bindValues([':offset'=> self::PAGESIZE * $page, ':limit' => self::PAGESIZE])
		->queryAll();
		//项目列表
		if($request->get("ajax")){
			if(count($products) == 0){
				echo '-1';
			}else{
				echo $this->renderPartial('shopitem', ['products'=>$products]);
			}
		}else{
			
			//广告
			$pics  = Advertise::find()->where(['classA' => $classA])->asArray()->all();
			$picnnum = count($pics);
			$modelClassA = ClassA::findOne($classA);
			$params['classA'] = $classA;
			$params['classAs'] = ClassA::find()->asArray()->all();
			$params['urlThis'] = $urlThis;
			$params['advertise'] = $advertise;
			$params['pics'] = $pics;
			$params['picnnum'] = $picnnum;
			$params['modelClassA'] = $modelClassA;
			$params['circle'] = $circle;
			$params['gjNow'] = $gjNow;
			$params['circles'] = $circles;
			$params['circlename'] = $circlename;
			$params['products'] = $products;
			// var_dump($params);
			return $this->render('productlist', $params);
		}
	}
	public function actionTest(){
		$products = Product::find()->andWhere(['classA'=>1])->andWhere('ID between 1 and 5')->asArray()->all();
		var_dump($products);
	}

}

