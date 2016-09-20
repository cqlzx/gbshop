<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;
use frontend\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<?=$content;?>

<!--底部导航开始-->
<div class="footernav">
	<ul>
		<li><a  href="<?=Url::to(['home/index'])?>"><i class="glyphicon glyphicon-home"></i><br/>首页</a></li>
		<li><a onclick="developing()"><i class="glyphicon glyphicon-tags"></i><br/>商家扫</a></li>
		<li><a onclick="developing()"><i class="glyphicon glyphicon-usd"></i><br/>赚钱码</a></li>
		<li><a href="<?=Url::to(['account/index'])?>"><i class="glyphicon glyphicon-user"></i><br/>我的</a></li>
	</ul>
</div>
<!--底部导航结束-->

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
