<?php
use Yii\web\View;
use yii\helpers\Url;
use backend\models\Shop;
use backend\models\Product;
use backend\models\Photo;
		
$request = Yii::$app->request;
$product = Product::findOne(intval($request->get('productID')));
$this->registerJsFile("statics/js/myfunc.js",['depends'=>['frontend\assets\AppAsset']]);
?>
<!-- 顶部图片 -->
<div class="pic">
	<img src="<?='http://img.appgoods.net/' . $product->photo;?>" width="100%" height="160px" />
</div>

<!-- 名称价格 -->
<div class="content">
	<div class="title"><?=$product->name?></div>
	<div class="price">
		<span class="gray1 margin-left">本店售价：</span><span class="pricenum1"><?=(($product->cashPrice > 0) ? $product->cashPrice . "元 + " : "") . $product->gbPrice?></span>
		<div class="gray1 margin-top margin-left">总销量：<?=$product->numAll - $product->numLeft?>件</div>
	</div>
</div>
<!-- 立即购买 -->
<div class="content">
	<div class="container">
		<span class="gray1 margin-left">请选择</span>
		<span class="gray1 right"><i class="glyphicon glyphicon-chevron-down"></i></span>
	</div>
	<!--div class="container">
		<span class="gray1 margin-left">商品总价：</span><span class="">50股宝</span>
	</div-->
	<div class="container">
		<span class="gray1 margin-left">数量：</span>
	</div>
	<div class="container">
		<input type="button" class="clear margin-left" id="sub" value="-" />
		<input type="text" class="clear text" id="quantity" value="1" />
		<input type="button" class="clear" id="add" value="+" />
	</div>
	<div class="container">
		<button class="btn1 margin-top margin-left1">立即购买</button>
		<button class="btn2" ><i class="glyphicon glyphicon-shopping-cart"></i>&nbsp;加入购物车</button>
	</div>
</div>