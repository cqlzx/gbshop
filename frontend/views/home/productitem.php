<?php
  use yii\helpers\Url;
  foreach($products as $item):?>
	<li>
		<a href="<?=Url::to(['home/buy', 'productID'=>$item['ID']]);?>">
			<img src="<?="http://img.appgoods.net/".$item['photo']?>" width="100px" height="70px">
			<span class="product-content">
				<div class="product-name"><?=$item['name'];?></div>
				<div class="product-brief"><?=$item['description'];?></div>
				<div>
					<span class="product-price">￥ <?=$item['cashPrice'];?></span>
					<span class="product-sold right">已售 <?=$item['numAll']-$item['numLeft'];?></span>
				</div>
			</span> 
		</a>
	</li>
<?php endforeach;?>