<?php
	use yii\helpers\Url;
	foreach($shops as $item):?>
	<li>
		<a href="<?=Url::to(['home/shop', 'ID'=>$item['ID']]);?>">
			<img src="<?='http://img.appgoods.net/'.$item['pic'];?>" height="65px" width="55px">
			<span class="title"><?=$item['name'];?></span><br />
			<span class="brief"><?=$item['description'];?></span><br />
			<span class="money-num">股价 <?=$item['gjNow'];?></span><span class="money-change"><?=Yii::$app->formatter->asPercent($item['increaseRateOld'], 2);?></span>
		</a>
	</li>
<?php endforeach;?>