<?php
$this->title="商家相册";
use Yii\web\View;
use yii\helpers\Url;
use backend\models\Photo;
use backend\models\Album;

$request = Yii::$app->request;
$shopID = $request->get("ID");
$albums = Album::find()->where(['shopID'=>$shopID])->asArray()->all();
$albumID = $request->get("albumID", $albums[0]['ID']);
$photos = Photo::find()->where(['albumID'=>$albumID])->asArray()->all();
$count = count($albums);
?>
<style>
.headnav li{
	width: calc(100% / <?=$count;?>) !important;
	width: -webkit-calc(100% / <?=$count;?>) !important;
}
</style>
<div class="headnav">
	<ul>
		<?php foreach($albums as $item){
				$class = ($item['ID'] == $albumID) ? "strip" : '';
				$url = Url::to(['home/album', 'albumID'=>$item['ID'], 'ID'=>$shopID]);
				$name = $item['name'];
				echo "<li class='$class'><a href='$url'>$name</a></li>";
			  }
		?>
	</ul>
</div>
<div class="pic-list">
	<ul>
	<?php foreach($photos as $item){
		$src = 'http://img.appgoods.net/'.$item['path'];
		$description = $item['description'];
		echo "<li>";
		echo "<img src='$src' width='100%' height='100px' />";
		echo "<div class='opacity'>&nbsp;</div>";
		echo "<div class='pic-description'>$description</div>";
		echo "</li>";
	}
	?>
	</ul>
</div>