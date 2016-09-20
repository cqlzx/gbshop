<?php

use backend\models\User;
use backend\models\Shop;
use yii\helpers\Url;
$this->title = "会员中心";
/* @var $this yii\web\View */
$info = Yii::$app->user->identity->attributes;

$disabled = '';
switch($info['role']){
	case User::USER:
		$role = "注册用户";
		$gbLeft = $info['gbLeft'];
		break;
	case User::CLERK:
		$role = "店员";
		$disabled = 'disabled';
		break;
	case User::SHOPKEEPER:
		$role = "店主";
		break;
}
if($info['role'] != User::USER){
	//店员和店长共有的东西
	$shop = Shop::find()->where(['ID'=>$info['shopID']])->asArray()->one();
	$gbLeft = $shop['gbLeft'];
}
?>
<!-- 顶部 -->
<div class="account-top">
	<div class="title">会员中心</div>
	<span class="back4"><i class="glyphicon glyphicon-chevron-left"></i></span>
</div>

<!-- 电话 -->
<div class="account-phone">
	<img src="<?=$info['portrait'];?>" width="60px" height="60px">
	<span>
		<?=$info['phone'];?><br />
		您的等级是 <?=$role;?>
	</span>
</div>
<!-- 余额 -->
<div class="account-cash">
	<div class="rest">
		<span><i class="glyphicon glyphicon-heart"></i><br />股币余额</span>
		<span><?=$gbLeft;?></span>
	</div>
	<div class="rest">
		<span <?=$disabled?>><i class="glyphicon glyphicon-credit-card"></i><br />提现</span>
		<span><?=$info['cashLeft']?></span>
	</div>
</div>
<!-- 信息栏 -->
<div class="container-info">
	<ul>
		<li>
			<a href="<?=Url::to(['user-info'])?>">
				<span class="user-info">用户信息</span>
				<span class="user-info-icon right"><i class="glyphicon glyphicon-chevron-right"></i><span>
			</a>
		</li>
		<li>
			<a href="<?=Url::to(['cash-withdraw'])?>">
				<span class="user-info">提现记录</span>
				<span class="user-info-icon right"><i class="glyphicon glyphicon-chevron-right"></i><span>
			</a>
		</li>
		<li>
			<a href="<?=Url::to(['order'])?>">
				<span class="user-info">我的订单</span>
				<span class="user-info-icon right"><i class="glyphicon glyphicon-chevron-right"></i><span>
			</a>
		</li>
		<li>
			<a href="<?=Url::to(['user-favor'])?>">
				<span class="user-info">我的收藏</span>
				<span class="user-info-icon right"><i class="glyphicon glyphicon-chevron-right"></i><span>
			</a>
		</li>
	</ul>
</div>