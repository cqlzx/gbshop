<?php
/* @var $this yii\web\View */
use backend\models\ClassA;
use backend\models\Advertise;
use yii\helpers\Url;
use Yii\web\View;


$url = Url::to(['advertise/add']);
$urlDelete = Url::to(['advertise/delete']);
$urlChange = Url::to(['advertise/index']);
$this->registerJs("
		jQuery(document).ready(function() {    
		   App.init();
		   $('#submitIndex').click(function(){
			    $('#advertiseIndex').ajaxSubmit({
                    url: '$url',   // 提交的页面
                    type: 'POST',                   // 设置请求类型为'POST'，默认为'GET'
                    success: function(data) {
						data = JSON.parse(data);
						if(data.status == '200'){
							var src = data.data.pic;
							var id  = data.data.id;
							var div = '<span class=\"span2\"><img src=\"' + src + '\" width=\"100px\" height=\"100px\"><label class = \"delete\" data-id = \"' + id + '\">删除</label></span>';
							alert('添加成功');
							$('.picIndex').append(div);
						}else{
							alert('添加失败:');
							console.log(data.errors);
						}
                    }
                });
				return false;
		   });
		   $('#submitClass').click(function(){
			    $('#advertiseClass').ajaxSubmit({
                    url: '$url',   // 提交的页面
                    type: 'POST',                   // 设置请求类型为'POST'，默认为'GET'
                    success: function(data) {
						data = JSON.parse(data);
						if(data.status == '200'){
							var src = data.data.pic;
							var id  = data.data.id;
							var div = '<span class=\"span2\"><img src=\"' + src + '\" width=\"100px\" height=\"100px\"><label class = \"delete\" data-id = \"' + id + '\">删除</label></span>';
							alert('添加成功');
							$('.picClass').append(div);
						}else{
							alert('添加失败:');
							console.log(data.errors);
						}
                    }
                });
				return false;
		   });
		$('.delete').click(function(){
			var div = $(this);
			if(confirm('确认删除这个广告？')){
				$.post('$urlDelete', {id: div.attr('data-id')}, function(data){
					data = JSON.parse(data);
					if(data.status == 200){
						alert('删除成功');
						div.parent().remove();
					}else{
						alert('删除失败');
						console.log(data);
					}
				});
			}
		})
		$('#classAselect').change(function(){
			var url = '$urlChange' + '&classA='+$(this).val(); 
			window.location.href=url;
		})
		
		});
	",View::POS_END);
	
	$advertise = new Advertise();
	$advertiseIndex = $advertise->advertiseIndex();
	$request = Yii::$app->request;
	$classA  = $request->get("classA", 1); //默认分类为1
	$advertiseClass = $advertise->advertiseClass($classA);
	
?>

<h2>广告位管理</h2>

<!--首页广告-->
<div class="portlet box red">
	<div class="portlet-title">
		<div class="caption"><i class="icon-cogs"></i>主页广告</div>
	</div>
	<div class="portlet-body form">
	<form enctype="multipart/form-data" method="post" id = "advertiseIndex" class = "form-horizontal">
	<div class="control-group">
		<label class="control-label">上传图片</label>
		<div class="controls">
			<input type="file" name="pic">
		</div>
	</div>

	<div class="control-group">
		<label class="control-label">图片列表</label>
		<div class="controls picIndex">
			<?php foreach($advertiseIndex as $item):?>
			<span class="span2" style="margin-left:0px !important;">
				<img src="<?php echo $item['pic'];?>" width="100px" height="100px">
				<label class = 'delete' data-id = '<?php echo $item['ID'];?>'>删除</label>
			</span>
			<?php endforeach;?>
		</div>
	</div>
	<div class="form-actions">
		<button id="submitIndex" class="btn blue">保存</button>                       
	</div>
	</form>
	</div>
</div>

<!--分类页广告-->
<div class="portlet box red">
	<div class="portlet-title">
		<div class="caption"><i class="icon-cogs"></i>分类页广告</div>
	</div>
	<div class="portlet-body form">
	<form method="post" id = "advertiseClass" class = "form-horizontal">
	<div class="control-group">
		<label class="control-label">上传图片</label>
		<div class="controls">
			<input type="file" name="pic">
		</div>
	</div>
	<div class="control-group">
		<label class="control-label">所属分类</label>
		<div class="controls ">
			<select id="classAselect" class="small m-wrap" name ="classA" tabindex="1">
				<?php 
					foreach(ClassA::find()->asArray()->all() as $class){
						$name = $class['name'];
						$id = $class['ID'];
						$selected = ($id == $classA) ? "selected" : "";
						echo "<option value='$id' $selected>$name</option>";
					}
				?>
			</select>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label">图片列表</label>
		<div class="controls picClass ">
			<?php foreach($advertiseClass as $item):?>
			<span class="span2">
				<img src="<?php echo $item['pic'];?>" width="100px" height="100px">
				<label class = 'delete' data-id = '<?php echo $item['ID'];?>'>删除</label>
			</span>
			<?php endforeach;?>
		</div>
	</div>
	<div class="form-actions">
		<button id="submitClass" class="btn blue">保存</button>                       
	</div>
	</form>
	</div>
</div>