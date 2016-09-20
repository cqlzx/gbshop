<?php
/* @var $this yii\web\View */
$this->title="首页";
use yii\helpers\Url;
use backend\models\Advertise;
use backend\models\ClassA;
use backend\models\Icon;
//广告
$pics  = Advertise::find()->where(['level' => Advertise::HOMEPAGE])->asArray()->all();
$picnnum = count($pics);
//分类
$cates = ClassA::find([])->asArray()->all();
$img = "http://img.appgoods.net/";
$this->registerJsFile("statics/js/swipestart.js",['depends'=>['frontend\assets\AppAsset']]);
?>
<!--搜索框-->
<div class="search">
	<input name="searchtext" class="input" placeholder="    输入商家、分类或商圈" />
	<span class="searchicon"><i class="glyphicon glyphicon-search"></i></span>
</div>

<!--首页广告-->
<div class="addWrap">
	<div class="swipe" id="mySwipe">
        <div class="swipe-wrap">
			<?php foreach($pics as $item):?>
            <div><a href="javascript:;"><img src="<?=$img.$item['pic'];?>" width="100%" height="160px" alt="" /></a></div>
			<?php endforeach;?>
        </div>
    </div>
    <ul id="position">
      <li class="cur"></li>
      <?php 
	  for($i = 1; $i < $picnnum; $i++){
		  echo "<li></li>";
	  }
	  ?>
    </ul>
</div>

<!--一级分类-->
<div class="addWrap">
	<div class="swipe1" id="navSwipe">
        <div class="swipe-wrap">
            <div class="category">
				<ul>
				<?php for($i = 0; $i < 8; $i++ ){
					$src = $img . $cates[$i]['pic'];
					$name  = $cates[$i]['name'];
					$url = Url::to(['home/shoplist', 'classA' => $cates[$i]['ID']]);
					echo "<li><a href='$url'><img width='50px' height='50px' src='$src'><br/><span>$name</span></a></li>";
				}?>
				</ul>
			</div>
            <div class="category">
				<ul>
					<?php for($i = 8; $i < 15; $i++ ){
					$src = $img . $cates[$i]['pic'];
					$name  = $cates[$i]['name'];
					$url = Url::to(['home/shoplist', 'classA' => $cates[$i]['ID']]);
					echo "<li><a href='$url'><img width='50px' height='50px' src='$src'><br/><span>$name</span></a></li>";
				}?>
					<li><a href="<?=Url::to(['home/allclassification']);?>"><img width="50px" height="50px" src="statics/pic/erstehilfe.png"><br/><span>全部</span></a></li>
				</ul>
			</div>
        </div>
    </div>
    <ul id="position1">
      <li class="cur"></li>
      <li class=""></li>
    </ul>
</div>

<!-- 推荐 -->
<div class="recommend">
	<ul>
	<?php $icons = Icon::find()->asArray()->all();
		foreach($icons as $item):
	?>
		<li>
			<?php 
			if($item['ID'] > 3){
				echo "<a href='" . Url::to(['home/shoplistorder', 'type'=>$item['ID']]) . "'>";
			}else{
				echo "<a href='" . Url::to(['home/productlist', 'type'=>$item['ID']]) . "'>";
			}
			?>
			<div class="content-pic">
				<span class="content">
					<div class="title"><?=$item['name'];?></div>
					<div class="brief"><?=$item['description'];?></div>
				</span>
				<img width="50px" height="50px" src="<?='http://img.appgoods.net/' . $item['pic']?>" />
			</div>
			</a>
		</li>
	<?php endforeach;?>
	</ul>
	<div class="divide-line"></div>
</div>
