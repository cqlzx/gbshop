<?php
use Yii\web\View;
use yii\helpers\Url;
use backend\models\Shop;
use backend\models\Product;
use backend\models\Photo;
		
$request = Yii::$app->request;
$id = intval($request->get('ID'));
$shop = Shop::findOne($id);
$photo = Photo::find()->where(['shopID'=>$id])->asArray()->one();
$count = Photo::find()->where(['shopID'=>$id])->count();
$products = Product::find()->where(['shopID'=>$id])->asArray()->all();
//点点赚币 当用户登录需要在这里加入内容
?>
<!-- 顶部图片 -->
<div class="pic">
	<a href="<?=Url::to(['home/album', 'ID'=>$id]);?>"><img src="<?='http://img.appgoods.net/' . $photo['path'];?>" width="100%" height="160px" /></a>
	<div class="opacity2">&nbsp;</div>
	<div class="picnums"><?=$count;?>张</div>
</div>
<!-- 商家信息 -->
<div class="content">
	<div class="title"><?=$shop->name;?></div>
	<div class="price">
		<span class="price-head">股宝价：</span>
		<span class="price-num"><?=$shop->gjNow;?> </span>
		<span class="price-change">&nbsp;<?=Yii::$app->formatter->asPercent($shop->increaseRateOld, 2);?></span>
	</div>
	<div class="location">
		<span class="location-icon"><i class="glyphicon glyphicon-map-marker"></i></span>
		<span class="location-detail"><?=$shop->address;?></span>
	</div>
	<div class="contact-num">
		<span class="contact-icon"><i class="glyphicon glyphicon-earphone"></i></span>
		<span><?=$shop->phone?></span>
	</div>
	<div class="shop-info">
		<div class="shop-info-head">商家信息</div>
		<div class="shop-info-detail"><?=$shop->information;?>
		</div>
	</div>
	<div class="show-detail">
		<a href="<?=Url::to(['home/album', 'ID'=>$id]);?>">
			<span class="show-detail-head">查看图文详情</span>
			<span class="show-detail-icon right"><i class="glyphicon glyphicon-chevron-right"></i><span>
		</a>
	</div>
</div>
<!-- 产品列表 -->
<div>
	<div class="product">
		<div class="product-title">产品列表</div>
		<div class="product-list">
			<ul>
			<?php echo $this->render('productitem',['products'=>$products]);?>
			</ul>
		</div>
	</div>
</div>