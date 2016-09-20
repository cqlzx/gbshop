<?php
	use backend\models\Album;
	use yii\helpers\Url;
	use Yii\web\View;
	use yii\helpers\Html;
	use backend\models\Photo;
	use backend\models\Shop;
	$this->title = "商家图片";

	$urlIndex = Url::to(['business/index']);
	$url_modal1 = Url::to(['business/album-add']);
	$urlPhotoAdd = Url::to(['business/photo-add']);
	$urlPhotoDelete = Url::to(['business/photo-delete']);
	$urlAlbumChange = Url::to(['business/photo-change']);
	$urlAlbumDelete = Url::to(['business/album-delete']);

	$shop1 = Shop::findOne(['ID'=>$shopid]);
	$classA = $shop1['classA'];

	$this->registerCssFile('@web/statics/js/bootstrap-fileupload.js',['depends'=>['backend\assets\AppAsset']]);/*文件上传*/
	$this->registerJs("
		jQuery(document).ready(function() {    
		   App.init();
		   $('#submitPhoto').click(function(){
			    $('#shopPhoto').ajaxSubmit({
                    url: '$urlPhotoAdd',   // 提交的页面
                    type: 'POST',                   // 设置请求类型为'POST'，默认为'GET'
                    success: function(data) {
						data = JSON.parse(data);
						if(data.status == '200'){
							alert('添加成功');
							history.go(0);
						}else{
							alert('添加失败:');
							console.log(data.errors);
						}
                    }
                });
				return false;
		   });

			$('.delete').on('click', function(){
				var div = $(this);
				if(confirm('确认删除这张图片？')){
					$.post('$urlPhotoDelete', {id: div.attr('data-id')}, function(data){
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
			});

			$('#backToShop').click(function(){
				var url1 = '$urlIndex' + '&classA=' + '$classA';
				window.location.href=url1;
				return false;
			});

			$('#albumSelect').change(function(){
				var url2 = '$urlAlbumChange' + '&shopid=' + $('#shopid').val() + '&albumid=' + $(this).val(); 
				window.location.href=url2;
				return false;
			});
			$('#deleteAlbum').on('click', function(){
				if(confirm('确认删除相册？')){
					var url3 = '$urlAlbumDelete' + '&shopid=' + $('#shopid').val() + '&albumid=' + $('#albumSelect').val(); 
					window.location.href=url3;
					return false;
				}
			});
		});
	",View::POS_END);
	/*当前页面css*/

	$album1 = Album::findOne(['shopID'=>$shopid]);
	$albumid = Yii::$app->request->get('albumid', $album1['ID']);
	$photos = Photo::find()->where(['albumID'=>$albumid, 'shopID'=>$shopid])->asArray()->all();

?>
<div class="row-fluid">

	<div id="modal1" class="modal hide">

		<div class="modal-header">

			<button data-dismiss="modal" class="close" type="button"></button>
			
			<h3>添加相册</h3>

		</div>

		<div class="modal-body">
			<form action="<?=$url_modal1?>" method="post">
			<?php
			$request = Yii::$app->request;
			echo Html::hiddenInput($request->csrfParam, $request->getCsrfToken());
			?>
				<input type="hidden" id="shopid" name="shopid" value="<?=$shopid?>" class="m-wrap small">
				<input type="text" name="name" class="m-wrap small">
				<input type="submit" value ="添加" class="btn pull-right blue"/>
			</form>
		</div>

	</div>
</div>

<br />
<h1>商家图片</h1>
<br />	

<div class="portlet box red">
	<div class="portlet-title">
		<div class="caption"><i class="icon-cogs"></i>商家上传</div>
	</div>
	<div class="portlet-body form">
	<form method="post" id = "shopPhoto" class = "form-horizontal" enctype="multipart/form-data">
	<div class="control-group">
		<label class="control-label">上传图片</label>
		<div class="controls">
			<input type="hidden" name="shopid" value="<?=$shopid?>" class="m-wrap small">
			<input type="file" name="pic">
		</div>
	</div>
	<div class="control-group">
		<label class="control-label">描&nbsp;&nbsp;&nbsp;&nbsp;述</label>
		<div class="controls">
			<input type="text" name="description" />
		</div>
	</div>
	<div class="control-group">
		<label class="control-label">所属分类</label>
		<div class="controls ">
			<select id="albumSelect" class="small m-wrap" name ="albumid" tabindex="1">
				<?php 
					foreach(Album::find()->where(['shopID'=>$shopid])->asArray()->all() as $album){
						$name = $album['name'];
						$id = $album['ID'];
						$select = ($id == Yii::$app->request->get('albumid', $albumid)) ? "selected" : "";
						echo "<option value='$id' $select>$name</option>";
					}
				?>
			</select>
			<button id="addAlbum" class="btn red" data-toggle="modal" data-target="#modal1">新建相册</button>        
			<button id="deleteAlbum" class="btn blue">删除相册</button> 
		</div>
	</div>
	<div class="control-group">
		<label class="control-label">图片列表</label>
		<div class="controls shopPhoto ">
		<?php 
			foreach($photos as $photo):?>
			<span class="span2">
				<label class = 'delete' data-id = '<?php echo $photo['ID'];?>'><i class="icon-remove"></i></label>
				<img src="<?php echo $photo['path'];?>" width="100px" height="100px">
				<div><?php echo $photo['description'];?></div>
			</span>
		<?php endforeach;?>
		</div>
	</div>
	<div class="form-actions">
		<button id="backToShop" class="btn red">返回</button>        
		<button id="submitPhoto" class="btn blue">保存</button>                       
	</div>
	</form>
	</div>
</div>
