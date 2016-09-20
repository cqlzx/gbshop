<?php
use yii\helpers\Html;
use Yii\helpers\Url;

use backend\models\Shop;
/*使用到的数据库*/
use backend\models\ClassA;


/* @var $this \yii\web\View */
/* @var $content string */
use backend\assets\AppAsset;
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
<body class="page-header-fixed">

<?php $this->beginBody() ?>
<div class="header navbar navbar-inverse navbar-fixed-top">

	<!-- BEGIN TOP NAVIGATION BAR -->

	<div class="navbar-inner">

		<div class="container-fluid">

			<!-- BEGIN LOGO -->

			<a class="brand" href="index.html">
			&nbsp;聚股宝
			</a>
			<!-- END LOGO -->    
			<!-- BEGIN RESPONSIVE MENU TOGGLER -->

				<a href="javascript:;" class="btn-navbar collapsed" data-toggle="collapse" data-target=".nav-collapse">

				<img src="statics/image/menu-toggler.png" alt="" />

				</a>          

				<!-- END RESPONSIVE MENU TOGGLER -->   
			<!-- BEGIN TOP NAVIGATION MENU -->              

			<ul class="nav pull-right">

				<!-- BEGIN USER LOGIN DROPDOWN -->

				<li class="dropdown user">

					<a href="#" class="" data-toggle="dropdown">
					<span class="username">你好，管理员</span>
					<i class="icon-angle-down"></i>
					</a>
					<ul class="dropdown-menu">
						<li><a href="login.html"><i class="icon-key"></i> Log Out</a></li>

					</ul>

				</li>

				<!-- END USER LOGIN DROPDOWN -->

			</ul>

			<!-- END TOP NAVIGATION MENU --> 

		</div>

	</div>

	<!-- END TOP NAVIGATION BAR -->
</div>

<!-- BEGIN CONTAINER -->   

<div class="page-container row-fluid">

	<!-- BEGIN SIDEBAR -->

	<div class="page-sidebar nav-collapse collapse">

		<!-- BEGIN SIDEBAR MENU -->        

		<ul class="page-sidebar-menu">
			<li>

				<!-- BEGIN SIDEBAR TOGGLER BUTTON -->

				<div class="sidebar-toggler hidden-phone"></div>

				<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
			</li>
			<li class="">
				<a href="javascript:;">
				<span class="title">分类管理</span>
				<span class="arrow "></span>
				</a>
				<ul class="sub-menu"><!--二级菜单-->
					<?php
					foreach(ClassA::find()->asArray()->all() as $item){
						$id = $item['ID'];
						$name = $item['name'];
						$url = Url::to(['class/index', 'classA'=>$id]);
						echo "<li ><a href='$url'>$name</a></li>";
					}
					?>
					<li >
						<a href="#"></a>
					</li>
				</ul>
			</li>
			<li class="">
				<a href="<?php echo Url::to(['class/icon']);?>">
				<span class="title">首页图标管理</span>
				</a>
			</li>
			<li class="">
				<a href="<?=Url::to(['business/index'])?>">
				<span class="title">商家管理</span>
				</a>
			</li>
			<li class="">
				<a href="<?php echo Url::to(['advertise/index']);?>">
				<span class="title">广告位管理</span>
				</a>
			</li>
			
			<li class="">
				<a href="javascript:;">
				<span class="title">产品管理</span>
				<span class="arrow "></span>
				</a>
				<ul class="sub-menu"><!--二级菜单-->
					<li >
						<a href="<?php echo Url::to(['product/index']);?>">全部</a>
					</li>
					<li >
						<a href="<?php echo Url::to(['product/index', 'gbBuy'=>'checked']);?>">股币惠购</a>
					</li>
					<li >
						<a href="<?php echo Url::to(['product/index', 'zeroBuy'=>'checked']);?>">0元换购</a>
					</li>
					<li >
						<a href="<?php echo Url::to(['product/index', 'todayBuy'=>'checked']);?>">今日特惠</a>
					</li>
				</ul>
			</li>
			<li class="">
				<a href="javascript:;">
				<span class="title">股币管理</span>
				<span class="arrow "></span>
				</a>
				<ul class="sub-menu"><!--二级菜单-->
					<li >
						<a href="<?php echo Url::to(['gb/index', 'honour'=> Shop::HONOURED])?>">贵宾商家</a>
					</li>
					<li >
						<a href="<?php echo Url::to(['gb/index', 'honour'=> Shop::UNHONOURED])?>">普通商家</a>
					</li>
					<li >
						<a href="<?=Url::to(['gb/user-gb']);?>">用户股币管理</a>
					</li>
					<li >
						<a href="<?=Url::to(['finance/index']);?>">财务分析</a>
					</li>
				</ul>
			</li>
			<li class="">
				<a href="javascript:;">
				<span class="title">管理员管理</span>
				<span class="arrow "></span>
				</a>
				<ul class="sub-menu"><!--二级菜单-->
					<li >
						<a href="<?=Url::to(['admin/index']);?>">管理员授权</a>
					</li>
					<li >
						<a href="#">超级管理员</a>
					</li>
				</ul>
			</li>
		</ul>

		<!-- END SIDEBAR MENU -->

	</div>

	<!-- END SIDEBAR -->
	<!-- BEGIN PAGE -->

	<div class="page-content">
		<div class="container-fluid">
			<div class="row-fluid">
			
				<?=$content?>
			</div>
		</div>
	</div>

	<!-- END PAGE CONTAINER--> 
	
</div>

<!-- END CONTAINER -->




<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
