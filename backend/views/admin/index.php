<?php
/* @var $this yii\web\View */
use backend\models\Admin;
use backend\models\ClassA;
use yii\helpers\Url;
use Yii\web\View;
$url1 = Url::to(['admin/add']);
$url2 = Url::to(['admin/update']);
$url3 = Url::to(['admin/delete']);
$categories = ClassA::find()->asArray()->all();
	$this->registerJs("
		jQuery(document).ready(function() {    
		   App.init();
		   $('#submit1').click(function(){
			   $('#form1').ajaxSubmit({
                    url: '$url1',   // 提交的页面
                    type: 'POST',                   // 设置请求类型为'POST'，默认为'GET'
                    success: function(data) {
						data = JSON.parse(data);
						if(data.status == 200){
							if(alert('添加成功！')){
								window.location.reload(); 
							}
						}else{
							alert('添加失败:');
						}
                    }
                });
		   });
		   $('.save').click(function(){
			   var arr = new Array();
			   var ID = $(this).attr('data-id');
			   var password = $(this).parent().find('input[type=\"text\"]').val();
			   $(this).parent().find('input[type=\"checkbox\"]').each(function(){
				   if($(this).attr('checked')){
				   arr.push($(this).val());
				   }
			   });
			   categories = '['+arr.toString()+']';
			   
			   console.log(categories);
			   $.post('$url2'+'&id='+ID,{'password':password, 'categories': categories}, function(data){
				   var obj = JSON.parse(data);
				   if(obj.status = 200){
					   alert('修改成功！');
				   }else{
					   alert('修改失败！');
					   console.log(obj);
				   }
			   })
		   });
		   $('.delete').click(function(){
			   var ID = $(this).attr('data-id');
			   var div = $(this);
			   if(confirm('慎重操作：确定删除？')){
					$.post('$url3'+'&id='+ID,{},function(data){
					   var obj = JSON.parse(data);
					   if(obj.status == 200){
						   alert('删除成功！');
						   div.parent().remove();
					   }else{
						   alert('删除失败！');
						   console.log(obj);
					   }
				   });   
			   }
			   
		   })
		})
	",View::POS_END);	   
?>
<h1>管理员授权</h1>
<div id="myModal1" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true" style="display: none;">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
		<h3 id="myModalLabel1">Modal Header</h3>
	</div>
	<div class="modal-body">
	<form method = "post" id="form1">
		<div class="control-group">
			<label class="control-label">用户名</label>
			<div class="controls"><input name="username" type="text" class="m-wrap middle"></div>
		</div>
		<div class="control-group">
			<label class="control-label">密码</label>
			<div class="controls"><input name="password" type="text" class="m-wrap middle"></div>
		</div>
	</div>
	<div class="modal-footer">
		<button class="btn"  data-dismiss="modal" aria-hidden="true">Close</button>
		<button id="submit1" class="btn yellow">Save</button>
	</div>
	</form>
</div>
<a  href="#myModal1" class="btn add red" data-toggle="modal">添加管理员</a>
<table class="table table-hover table-bordered center" style="table-layout:fixed">
	<thead>
		<tr>
			<th>管理员账号</th>
			<th style="width:132px">密码</th>
			<?php
			foreach($categories as $item){
					$name = $item['name'];
					echo "<th style='width:30px'>$name</th>";
			}
			?>
			<th colspan="2">操作</th>
		</tr>
	</thead>
	<tbody id="shoptable">
	<?php $admins =  Admin::find()->where(["level" => Admin::NORMAL])->asArray()->all();
		foreach($admins as $admin):
		$cates = json_decode($admin['categories']);//专家的可查看分类
	?>
	<tr>
		<td><?=$admin['username'];?></td>
		<td><input type="text" name="password" class="m-wrap small" value='<?=$admin['password'];?>'></td>
		<?php foreach($categories as $item){
			$id = $item['ID'];
			$checked = '';
			if(in_array($id, $cates)){
				$checked = 'checked';
			}
			echo "<td><input type='checkbox' value='$id' $checked/></td>";
		}?>
		<td data-id="<?=$admin['ID'];?>" class = "pointer save">保存</td>
		<td data-id="<?=$admin['ID'];?>" class = "pointer delete">删除</td>
	</tr>
	<?php endforeach;?>
	</tbody>
	<style>
	td, th{
		text-align:center !important;
		vertical-align:middle !important;
	}
	.pointer:hover{
		color:blue;
		cursor:pointer;
	}
	</style>
</table>