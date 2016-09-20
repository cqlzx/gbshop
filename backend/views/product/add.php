<?php
use Yii\web\View;
use yii\helpers\Url;
$this->title = "添加产品";
$request = Yii::$app->request;
$shopID = $request->get("shopID");
$shopName = $request->get("shopName");
$classA = $request->get("classA");
$urlsubmit = Url::to(['product/submit']);
$urllist = Url::to(['product/index']);
$this->registerJs("
		jQuery(document).ready(function() {    
		   App.init();
		   $('#submit').click(function(){
			    $('#product').ajaxSubmit({
                    url: '$urlsubmit',   // 提交的页面
                    type: 'POST',                   // 设置请求类型为'POST'，默认为'GET'
                    success: function(data) {
						data = JSON.parse(data);
						if(data.status == '200'){
							alert('添加成功');
						}else{
							alert('添加失败:');
							console.log(data.errors);
						}
                    }
                });
				return false;
		   });
		});
	",View::POS_END);
?>
<br/>
<br/>
<div class="portlet box red">
	<div class="portlet-title">
		<div class="caption"><i class="icon-cogs"></i>添加产品</div>
	</div>
	<div class="portlet-body form">
	<form method="post" id = "product" class = "form-horizontal">
	<div class="control-group">
		<label class="control-label">商家名称</label>
		<div class="controls">
			<input name="shopName" class="span6 m-wrap" type="text" value="<?php echo $shopName;?>" disabled>
			<input name="shopName" class="span6 m-wrap" type="hidden" value="<?php echo $shopName;?>" >
			<input name="shopID" class="span6 m-wrap" type="hidden" value="<?php echo $shopID;?>" >
			<input name="classA" class="span6 m-wrap" type="hidden" value="<?php echo $classA;?>" >
		</div>
	</div>
	<div class="control-group">
		<label class="control-label">产品名称</label>
		<div class="controls">
			<input name="name" class="span6 m-wrap" type="text" >
		</div>
	</div>
	<div class="control-group">
		<label class="control-label">股币价</label>
		<div class="controls">
			<input name="gbPrice" class="span6 m-wrap" type="number" >
		</div>
	</div>
	<div class="control-group">
		<label class="control-label">现金价</label>
		<div class="controls">
			<input name="cashPrice" class="span6 m-wrap" type="number" >
		</div>
	</div>
	<div class="control-group">
		<label class="control-label">文字描述</label>
		<div class="controls">
			<textarea class="span6 m-wrap" name="description" rows="3"></textarea>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label">上传图片</label>
		<div class="controls">
			<input type="file" name="pic">
		</div>
	</div>
	<div class="form-actions">
		<button id="submit" class="btn blue">保存</button>                       
	</div>
	</form>
	</div>
</div>