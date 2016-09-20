<?php
/* @var $this yii\web\View */
use backend\models\Admin;
use backend\models\User;
use backend\models\ClassA;
use yii\helpers\Url;
use Yii\web\View;
use yii\grid\GridView;

$gridView = GridView::widget([
			'dataProvider' => $dataProvider,
			'layout'=>"<div class='pagination pagination-large'>{pager}</div>\n{items}",
			'tableOptions'=>['class' => "table table-striped table-bordered table-hover"],
			'columns' => ['nickname', 'phone',
				['label' => '角色', 'format' => 'raw', 'value' => function($model, $key){
						if($model->role == User::CLERK){
							return "店员";
						}elseif($model->role == User::SHOPKEEPER){
							return "店长";
						}else{
							return "用户";
						}
				}],
				['label' => '操作', 'format' => 'raw', 'value' => function($model, $key){
						$text = "设为店员";
						if($model->role == User::CLERK){
							$text = "升为店长";
						}else{
							$text = "降为店员";
						}
						return "<span class='pointer delete'>删除</span> <span class='pointer change'>$text</span>";
				}],
			]
		]);

$url1 = Url::to(['business/clerk-search']);//通过手机号查找
$url2 = Url::to(['business/clerk-add']);  //店员增加
$url3 = Url::to(['business/clerk-delete']);   //店员删除
$url4 = Url::to(['business/clerk-change']);   //店员角色改变


$categories = ClassA::find()->asArray()->all();
	$this->registerJs("
		jQuery(document).ready(function() {    
		   App.init();
		   $('.search').click(function(){
			   $.post('$url1', {'phone': $('#phoneSearch').val()}, function(obj){
				   data = JSON.parse(obj);
						if(data.status == 200){
							$('.result').html(data.data.nickname);
							$('#submit1').removeAttr('disabled');
						}else{
							$('.result').html(data.error);
							$('#submit1').attr('disabled','disabled');
						}
			   })
		   });
		   $('#submit1').click(function(){
			   $('#form1').ajaxSubmit({
                    url: '$url2',   // 提交的页面
                    type: 'POST',                   // 设置请求类型为'POST'，默认为'GET'
                    success: function(data) {
						data = JSON.parse(data);
						if(data.status == 200){
							alert('添加成功！');
							window.location.reload(); 
						}else{
							alert('添加失败:');
						}
                    }
                });
		   });
		   $('.change').click(function(){
				   var userID = $(this).parent().parent().attr('data-key');
			   	   $.post('$url4', {'userID': userID}, function(data){
				   var obj = JSON.parse(data);
				   if(obj.status = 200){
					    alert('修改成功!');
						window.location.reload(); 
						
				   }else{
					   alert('修改失败!');
					   console.log(obj);
				   }
			   })
		   });
		   $('.delete').click(function(){
			   var userID = $(this).parent().parent().attr('data-key');
			   var div = $(this);
			   if(confirm('慎重操作：该店员将被删除？')){
					$.post('$url3',{'userID': userID},function(data){
					   var obj = JSON.parse(data);
					   if(obj.status == 200){
						   alert('删除成功！');
						   div.parent().parent().remove();
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
<h1><?=$shop['name']?>成员管理</h1>
<div id="myModal1" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true" style="display: none;">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
		<h3 id="myModalLabel1">Modal Header</h3>
	</div>
	<div class="modal-body">
	<form method = "post" id="form1">
		<div class="control-group">
			<input type="hidden" name="shopID" value="<?=$shop['ID'];?>">
			<label class="control-label">手机号<span class="pointer search" style="margin-left:140px">查找</span></label>
			<div class="controls"><input id="phoneSearch" name="phone" type="text" class="m-wrap middle"></div>
		</div>
		<div class="control-group">
			<label class="control-label">查找结果</label>
			<div class="controls result">无</div>
		</div>
	</div>
	<div class="modal-footer">
		<button class="btn"  data-dismiss="modal" aria-hidden="true">取消</button>
		<button id="submit1" class="btn yellow" disabled>添加</button>
	</div>
	</form>
</div>
<a  href="#myModal1" class="btn add red" data-toggle="modal">添加店员</a>

<?=$gridView?>
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