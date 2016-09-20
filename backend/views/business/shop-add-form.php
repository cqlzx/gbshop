<?php

	use yii\web\View;
	use backend\models\Circle;
	use backend\models\ClassB;
	use yii\helpers\Url;
	
	$url = Url::to(['business/shop-form-save']);
	$this->title = "添加商家";
	$this->registerJs("
		jQuery(document).ready(function() {    
		   App.init();
		   $('#shopAddSubmit').click(function(){
		   		$('#shopAdd').submit;
		   });
		});
	",View::POS_END);

	$shopid = Yii::$app->request->get('shopid');
?>
<h1>添加商家</h1>
<br />
<form action="<?=$url?>" id="shopAdd" class="form-horizontal" method="post" enctype="multipart/form-data">
	<input type="hidden" name="shopid" value="<?=$shopid?>" />
	<!-- 商家名称 -->
	<div class="control-group">

		<label class="control-label">商家名称</label>

		<div class="controls">

			<input type="text"  class="m-wrap small" name="name" value="<?=$name?>">

		</div>

	</div>
	<!-- 商家折扣 -->
	<div class="control-group">

		<label class="control-label">商家折扣</label>

		<div class="controls">

			<input type="text" class="m-wrap small" name="discount" value="<?=$discount?>">

		</div>

	</div>
	<!-- 所属分类 -->
	<div class="control-group">

		<label class="control-label">所属分类</label>

		<div class="controls">
			<?php
				$classid = Yii::$app->request->get("classid");
				foreach(ClassB::find()->where(['classA'=>$classid])->orderBy("sequence")->asArray()->all() as $item):
					$check = ($classB == $item['ID']) ? "checked" : "";
			?>
			<label class="radio">

			<div class="radio"><span><input type="radio" name="classB" value="<?=$item['ID']?>" <?=$check?> /></span></div>

			<?=$item['name']?>

			</label>
			<?php endforeach;?>
			<input type="hidden" name="classA" value="<?=$classid?>" />
		</div>

	</div>
	<!-- 所属商圈 -->
	<div class="control-group">

		<label class="control-label">所属商圈</label>

		<div class="controls">

			<?php 
				foreach(Circle::find()->orderBy("sequence")->asArray()->all() as $circles):
					$check = ($circle == $circles['ID']) ? "checked" : "";
			?>
			<label class="radio">

			<div class="radio"><span><input type="radio" name="circle" value="<?=$circles['ID']?>" <?=$check?> /></span></div>

			<?=$circles['name']?>

			</label>

			<?php endforeach;?>

		</div>

	</div>
	<!-- 描述 -->
	<div class="control-group">

		<label class="control-label">描述</label>

		<div class="controls">

			<input type="text" class="m-wrap medium" name="description" value="<?=$description?>">

		</div>

	</div>
	<!-- 地址 -->
	<div class="control-group">

		<label class="control-label">地址</label>

		<div class="controls">

			<input type="text" class="m-wrap medium" name="address" value="<?=$address?>">

		</div>

	</div>
	<!-- 电话 -->
	<div class="control-group">

		<label class="control-label">电话</label>

		<div class="controls">

			<input type="text" class="m-wrap medium" name="phone" value="<?=$phone?>">

		</div>

	</div>
	
	<div class="control-group">
		<label class="control-label">上传商家图片</label>
		<div class="controls">
			<img src="<?=$pic;?>" width="30px" height="20px">
			<input type="file" name="pic">（修改时可不上传）
		</div>
	</div>

	<!-- 商家信息 -->
	<div class="control-group">

		<label class="control-label">商家信息</label>

		<div class="controls">

			<textarea class="large m-wrap" name="information" rows="3" style="margin: 0px; width: 321px; height: 60px;"><?=$information?></textarea>

		</div>

	</div>
	<!-- 购买须知 -->
	<div class="control-group">

		<label class="control-label">购买须知</label>

		<div class="controls">

			<textarea class="large m-wrap" name="attention" rows="3" style="margin: 0px; width: 321px; height: 60px;"><?=$attention?></textarea>

		</div>

	</div>


	<div class="form-actions">

		<button type="submit" id="shopAddSubmit" class="btn blue"><i class="icon-ok"></i>保存</button>

		<button type="button" onclick="history.go(-1)"class="btn">取消</button>

	</div>

</form>