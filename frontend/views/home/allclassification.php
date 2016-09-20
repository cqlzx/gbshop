<?php
$this->title = "全部分类";
use Yii\web\View;
use yii\helpers\Url;
use backend\models\ClassA;
use backend\models\ClassB;

$classAs = ClassA::find()->where([])->asArray()->all();

?>
<!-- 顶部 -->
<div class="top">
	<div class="title">全部分类</div>
	<span class="back3"><a href="<?=Url::to(['home/index'])?>"><i class="glyphicon glyphicon-chevron-left"></i></a></span>
</div>

<?php foreach($classAs as $classA):
		$classBs = ClassB::find()->where(['classA'=>$classA['ID']])->asArray()->all();
		$height = ceil(count($classBs) / 3) * 40;
?>
<div class="container1">
	<div class="bodyhead">
		<img src="<?='http://img.appgoods.net/'.$classA['pic'];?>" width="25px" height="25px">
		<span><a href="<?=Url::to(['home/shoplist','classA'=>$classA['ID']]);?>"><?=$classA['name']?></a></span>
	</div>
	<div class="bodynav">
		<ul style="height:<?=$height;?>px">
		<?php foreach($classBs as $classB):?>
			<li>
				<a href="<?=Url::to(['home/shoplist', 'classA'=>$classA['ID'], 'classB'=>$classB['ID']]);?>"><?=$classB['name'];?></a>
			</li>
		<?php endforeach;?>
		<ul>
	</div>
</div>
<?php endforeach;?>