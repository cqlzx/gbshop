<?php
	use Yii\web\View;
	use Yii\helpers\Url;
	use backend\models\ClassB; 
	use backend\models\ClassA; 
	use backend\models\Circle;
	use yii\helpers\Html;
	$this->title = "商家管理";
	/*当前页面js*/
	$this->registerJsFile('@web/statics/js/jquery.nestable.js',['depends'=>['backend\assets\AppAsset']]);
	$this->registerJsFile('@web/statics/js/ui-nestable.js',['depends'=>['backend\assets\AppAsset']]);
	$this->registerCssFile('@web/statics/js/bootstrap-fileupload.js',['depends'=>['backend\assets\AppAsset']]);/*文件上传*/
	$url1 = Url::to(['class/class-b-sequence']); //二级分类顺序
	$url2 = Url::to(['class/circle-sequence']);  //商圈顺序
	$url_modal1 = Url::to(['class/class-b-add']);   //增加二级分类
	$url_modal2 = Url::to(['class/circle-add']);   //增加商圈分类
	$url_update = Url::to(['class/class-a-update']); //修改一级分类的名称
	$this->registerJs("
		jQuery(document).ready(function() {    
		   App.init();
		   UINestable.init();
		   $('#savesequence1').click(function(){
			   $('#form_sequence1').submit();
		   });
		   $('#savesequence2').click(function(){
			   $('#form_sequence2').submit();
		   });
		   $('a').mousedown(function(){event.stopPropagation()})
		});
	",View::POS_END);
	/*当前页面css*/
	$this->registerCssFile('@web/statics/css/jquery.nestable.css',['depends'=>['backend\assets\AppAsset']]);/*移动条*/
	$this->registerCssFile('@web/statics/css/bootstrap-fileupload.css',['depends'=>['backend\assets\AppAsset']]);/*文件上传*/

	$request = Yii::$app->request;
	$id = $request->get('classA', 1);
	$classA = ClassA::find('name')->where(['id' => $id])->asArray()->one();
	$name = $classA['name'];
	$src = Yii::getAlias('@web/' . $classA['pic']);
	
?>
<div class="row-fluid">

	<div id="modal1" class="modal hide">

		<div class="modal-header">

			<button data-dismiss="modal" class="close" type="button"></button>
			
			<h3>添加二级分类</h3>

		</div>

		<div class="modal-body">
			<form action="<?=$url_modal1;?>" method="post" id="modal1">
			<?php
			$request = Yii::$app->request;
			echo Html::hiddenInput($request->csrfParam, $request->getCsrfToken());
			?>
				<input type="hidden" name="classA" value="<?=$id;?>" class="m-wrap small">
				<input type="text" name="name" class="m-wrap small">
				<input type="submit" value = "添加" class="btn pull-right blue"/>
			</form>
		</div>

	</div>
	
	
	<div id="modal2" class="modal hide">

		<div class="modal-header">

			<button data-dismiss="modal" class="close" type="button"></button>
			
			<h3>添加商圈分类</h3>

		</div>

		<div class="modal-body">
			<form action="<?=$url_modal2;?>" method="post" id="modal2" >
				<input type="text" name="name" class="m-wrap small" >
				<input type="submit" value = "添加" class="btn pull-right blue"/>
			</form>
		</div>

	</div>
	
</div>
<div class="row-fluid">
	<h1>分类管理</h1>
	<!--存放顺序值-->
	<!--二级分类的顺序-->
	<form action = "<?=$url1?>" name="action" id="form_sequence1" method="post" >
		<input type="hidden" value="<?=$id;?>" name="classA" >
		<input type="hidden" id="nestable_list_1_output" name ='sequence' class="m-wrap span12"/>
	</form>
	<!--商圈的顺序-->
	<form action = "<?=$url2?>" name="action" id="form_sequence2" method="post">
		<input type="hidden" id="nestable_list_2_output" name ='sequence' class="m-wrap span12"/>
	</form>
	<br/>
	
	<div class="span6">

		<form action = "<?=$url_update;?>" method="post" name="classA" enctype="multipart/form-data" >
		
			<input type="text" value="<?=$name;?>" name="name" class="m-wrap small"/>&nbsp;
			
			<input type="hidden" value="<?=$id;?>" name="id" class="m-wrap small"/>&nbsp;
		
			<img src="<?=$src;?>" width="20px" height ="30px"/>&nbsp;
		
			<input type="file" name="icon" class="span4"/>
			
			<button type="submit" class="btn blue pull-right">修改</button>
			
		</form>

	</div>
	
	<!-- BEGIN SAMPLE TABLE PORTLET-->

	<div class="portlet box blue span6">

		<div class="portlet-title">

			<div class="caption"></i>二级分类</div>

			<div class="tools">

				<a href="#modal1" data-toggle="modal" style="color:black">添加分类</a>
				
				<a href="#" id="savesequence1" style="color:black">保存顺序</a>

			</div>

		</div>

		<div class="portlet-body">

			<div class="dd" id="nestable_list_1">

				<ol class="dd-list">
					<?php 
					foreach(ClassB::find()->where(['classA'=>$id])->orderBy("sequence")->asArray()->all() as $item){
						$id = $item['ID'];
						$name = $item['name'];
						$sequence = $item['sequence'];
						$url = Url::to(['class/class-b-delete',"id"=>$id]);
						echo "<li class='dd-item' data-id='$id'><div class='dd-handle'>$name<a href='$url' id='ok' class='pull-right' method='post'>删除</a></div></li>";
					}
					?>
				</ol>

			</div>

		</div>

	</div>

	<!-- END SAMPLE TABLE PORTLET-->

	
	

</div>
<br/>	
<br/>
<div class="row-fluid">
	<h1>商圈管理</h1>
	<div class="portlet box blue span6">

		<div class="portlet-title">

			<div class="caption"></i>商圈分类</div>

			<div class="tools">

				<a href="#modal2" data-toggle="modal" style="color:black">添加分类</a>
				
				<a href="#" id="savesequence2" style="color:black">保存顺序</a>

			</div>

		</div>

		<div class="portlet-body">

			<div class="dd" id="nestable_list_2">

				<ol class="dd-list">
					<?php 
					foreach(Circle::find()->orderBy("sequence")->asArray()->all() as $item){
						$id = $item['ID'];
						$name = $item['name'];
						$url = Url::to(['class/circle-delete',"id"=>$id]);
						echo "<li class='dd-item' data-id='$id'><div class='dd-handle'>$name<a href='$url' id='ok' class='pull-right' method='post'>删除</a></div></li>";
					}
					?>

				</ol>

			</div>

		</div>

	</div>

	
</div>
