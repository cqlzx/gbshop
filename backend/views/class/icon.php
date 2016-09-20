<?php 
$this->title = "图标管理";
use backend\models\Icon;
use yii\helpers\Url;
use yii\web\View;
$icons = Icon::find()->asArray()->all();
$this->registerJs("
		jQuery(document).ready(function() {    
		   App.init();
		   		});
",View::POS_END);
?>
<h1>图标管理</h1>
<table class="table table-hover table-bordered" style="table-layout:fixed">
	<thead>
		<tr>
			<th>名称</th>
			<th>描述</th>
			<th>当前图标</th>
			<th>上传新图标</th>
			<th>保存修改</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($icons as $item):?>
		<tr>
		<form action = "<?=Url::to(['class/icon-update']);?>" method="post" name="icon" enctype="multipart/form-data" >
			<input type="hidden" name="ID" value="<?=$item['ID'];?>">
			<td>
				<input type="text" value="<?=$item['name'];?>" name="name" class="m-wrap small"/>&nbsp;
			</td>
			<td>
				<input type="text" value="<?=$item['description'];?>" name="description" class="m-wrap small"/>&nbsp;
			</td>
			<td>
				<img src="<?=$item['pic'];?>" width="20px" height ="30px"/>&nbsp;
			</td>
			<td>
				<input type="file" name="pic" />
			</td>
			<td>
			<button type="submit" class="btn blue">修改</button>
			</td>
		</form>
		</tr>
		<?php endforeach;?>
	</tbody>
</table>
<style>
td, th{text-align:center !important;}
</style>
