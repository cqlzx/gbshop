<?php
$this->title = "分类页";
use Yii\web\View;
use yii\helpers\Url;


$urlThis = Url::to(['home/shoplist', 'classA' => $classA]);
//css he js
$this->registerJsFile("statics/js/swipestart.js",['depends'=>['frontend\assets\AppAsset']]);
$this->registerJs("
/**一级：classA
   二级：classB, circle
   三级：advertise
   四级：price, increaseRate
   一级最高，点击高级不会读取低级的条件，点击低级条件会筛选高级条件
**/
	var classB = null;
	var gjNow = null;
	var increaseRate = null;
	var advertise = null;
	var circle = null;
	var page=1;
	function getStatus(){
		classB = $('.leftnav').find('.strip2').attr('data-id');
		gjNow = $('#sort2').attr('data-value');
		increaseRate = $('#sort3').attr('data-value');
		advertise  = $('#sort4').attr('data-value');
		circle = $('#circle').val();
		if(advertise == 0) advertise = null;
		if(circle == 'all') circle = null;
	}
	/*一级*/
	$('#sort1').click(function(){
		window.location.href = '$urlThis';
	})
	/*二级*/
	$('.leftnav li').click(function(){
		window.location.href = '$urlThis' + '&classB=' + $(this).attr('data-id');
	});
	$('#circle').change(function(){
		window.location.href = '$urlThis' + '&circle=' + $('#circle').val();
	});
	/*三级 advertise*/
	$('#sort4').click(function(){
		$(this).attr('data-value', (parseInt($(this).attr('data-value')) + 1) % 2);
		getStatus();
		var url = '$urlThis';
		if(classB != null && classB != undefined) url += '&classB=' + classB;
		if(advertise != null && advertise != undefined)
			url += '&advertise=' + advertise;
		if(circle != null && circle != undefined)
			url += '&circle=' + circle;
		window.location.href = url;
	})
	/*四级*/
	$('#sort2, #sort3').click(function(){
		$(this).attr('data-value', (parseInt($(this).attr('data-value')) + 1) % 3);
		getStatus();
		var url = '$urlThis';
		if($(this).attr('id') == 'sort2' && $(this).attr('data-value') !=0 ) 
			url += '&gjNow=' + $(this).attr('data-value');
		if($(this).attr('id') == 'sort3' && $(this).attr('data-value') !=0 ) 
			url += '&increaseRate=' + $(this).attr('data-value');
		if(classB != null && classB != undefined) url += '&classB=' + classB;
		if(advertise != null && advertise != undefined)
			url += '&advertise=' + advertise;
		if(circle != null && circle != undefined)
			url += '&circle=' + circle;
		window.location.href = url;
	});
	//点击加载更多
	$('#clickmore').click(function(){
		getStatus();
		var url = '$urlThis';
		if( $('#sort2').attr('data-value') !=0 ) 
			url += '&gjNow=' + $('#sort2').attr('data-value');
		if( $('#sort3').attr('data-value') !=0 ) 
			url += '&increaseRate=' + $('#sort3').attr('data-value');
		if(classB != null && classB != undefined) url += '&classB=' + classB;
		if(advertise != null && advertise != undefined)
			url += '&advertise=' + advertise;
		if(circle != null && circle != undefined)
			url += '&circle=' + circle;
		url+='&page='+page;
		$.post(url + '&ajax=1',{},function(data){
			if(data == '-1'){
				$('#clickmore').html('已加载完毕');
			}else{
				$('.shopitems ul').append(data);
				page+=1;
			}
			
		})
	});
	
	$(window).scroll(function(){
		if($(document).scrollTop() > 165){
			$('.sortnav').addClass('topfixed');
			$('.leftnav').addClass('leftfixed');
			$('.second-class').css('margin-top', '15px');
		}else{
			$('.sortnav').removeClass('topfixed');
			$('.leftnav').removeClass('leftfixed');
			$('.second-class').css('margin-top', '5px');
		}
	});
",View::POS_END);
?>
<style>
.topfixed{
	position:fixed;
	right:0;
	left:0;
	top:0;
	z-index:1000;
}
.leftfixed{
	position:fixed;
	top:50px;
}
</style>
<!-- 搜索 -->
<div class="itemsearch">
	<input type="text" class="input1" placeholder="    请输入商家名称" />
	<span class="back4"><a href="<?=Url::to(['home/index']);?>"><i class="glyphicon glyphicon-chevron-left"></i></a></span>
	<span class="searchicon1"><i class="glyphicon glyphicon-search"></i></span>
</div>

<!--分类页广告-->

<div class="addWrap">
	<div class="swipe" id="mySwipe">
        <div class="swipe-wrap">
			<?php foreach($pics as $item):?>
            <div><a href="javascript:;"><img src="<?='http://img.appgoods.net/'.$item['pic'];?>" width="100%" height="160px" alt="" /></a></div>
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
<!-- 排序导航栏 -->
<div class="sortnav">
	<ul>
		<li class="strip" id="sort1">&nbsp;<?=$modelClassA->name;?></li>
		<li id="sort2" data-value="<?=$gjNow;?>">&nbsp;价格&nbsp;
			<i class="glyphicon <?php if($gjNow == 1) echo "glyphicon-arrow-up"; if($gjNow == 2) echo "glyphicon-arrow-down";
			?>"></i>
		</li>
		<li id="sort3" data-value="<?=$increaseRate;?>">涨跌幅
			<i class="glyphicon <?php 
			if($increaseRate == 1) echo "glyphicon-arrow-up"; if($increaseRate == 2) echo "glyphicon-arrow-down";?>">
			</i>
		</li>
		<li id="sort4" data-value="<?=$advertise;?>" class="<?php if($advertise) echo "strip";?>">点点赚币</li>
		<li id="sort5"><span><?=$circlename;?></span>
			<select id="circle" style="opacity:0 ;position:absolute; left:0;right:0;">
				<option value="all">全部</option>
				<?php foreach($circles as $item):?>
					<option value="<?=$item['ID'];?>"<?php if($item['ID'] == $circle) echo 'selected';?>><?=$item['name'];?></option>
				<?php endforeach;?>
			</select>
		</li> 
	</ul>
</div>
<!-- 二级分类商家 -->
<div class="second-class">
	<div class="leftnav">
		<ul>
			<?php foreach($classBs as $item): ?>
				<li data-id="<?=$item['ID'];?>" class="<?=($classB == $item['ID']) ? 'strip2' : '';?>"><?=$item['name']?></li>
			<?php endforeach;?>
		</ul>
	</div>
	
	<div class="shopitems">
		<ul>
		<?php echo $this->render('shopitem', ['shops'=>$shops]);?>
		</ul>
		<div id="clickmore">点击加载更多</div>
	</div>
	<div>&nbsp;</div>
	<div>&nbsp;</div>
	<div>&nbsp;</div>
</div>
