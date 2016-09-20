<?php

namespace backend\controllers;

use Yii;
use backend\models\AdvertiseClickBuy;

class FinanceController extends \yii\web\Controller
{
	public $layout = "jf-main";
	public $enableCsrfValidation = false;
    public function actionIndex()
    {
		
		$thisDay = date('Y-m-d') . " 00:00:00";
		$thisMonth = date('Y-m-'). "01 00:00:00";
		$now = date('Y-m-d H:i:s');
		
		//取数据
		$request = Yii::$app->request;
		$begintime = $request->post('begintime');
		$endtime = $request->post('endtime');
		if($begintime == '' or $begintime==null){
			$begintime = '2016-01-01 00:00:00';
		}
		if($endtime == '' or $endtime == null){
			$endtime = $now;
		}
		$classA = $request->post('classA', 'all');
		if($request->get('today')){
			//今日统计
			$begintime = $thisDay;
			$endtime = $now;
		}
		if($request->get('month')){
			//本月统计
			$begintime = $thisMonth;
			$endtime = $now;
		}
		
		$params = array();
		$where = 'time between :begintime and :endtime';
		$params[':begintime'] = $begintime;
		$params[':endtime'] = $endtime;
		if($classA != 'all'){
			$params[':classA'] = intval($classA);
			$where = $where . " and classA=:classA";
		}
		$connection = Yii::$app->db;
		$ADInput = $connection->createCommand("select sum(cash) as sum from advertiseClickBuy where $where")
				->bindValues($params)
				->queryOne()['sum'];
		$chargeInput = $connection->createCommand("select sum(money) as sum from shopRecharge where $where")
				->bindValues($params)
				->queryOne()['sum'];
		//商家提现
		$shopWithdraw = 0;
		//用户提现
		$userWithdraw = $connection->createCommand("select sum(money) as sum from userWithdraw where $where")
				->bindValues($params)
				->queryOne()['sum'];
		//商家余额
		$shopMoneyLeft = 0;
		//用户余额
		$userMoneyLeft = $connection->createCommand("select sum(cashLeft) as sum from user")
				->bindValues($params)
				->queryOne()['sum'];
		$data = array(
			'ADInput' => $ADInput,
			'chargeInput' => $chargeInput,
			'shopWithdraw' => $shopWithdraw,
			'userWithdraw' => $userWithdraw,
			'shopMoneyLeft' => $shopMoneyLeft,
			'userMoneyLeft' => $userMoneyLeft,
			'classA' => $classA,
			'begintime' => str_replace(' ', 'T', $begintime),
			'endtime' => str_replace(' ', 'T', $endtime),
		'ad');
        return $this->render('index', $data);
    }

}
