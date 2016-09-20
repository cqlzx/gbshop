<?php
	use yii\web\View;
	use backend\models\ClassA;
	use backend\models\Shop;
	use yii\helpers\Url;

	$saveurl = Url::to(['business/save']);
	$urlchange = Url::to(['business/index']);
	$photochangeurl = Url::to(['business/photo-change']);
	$shopRecharge = Url::to(['business/shop-recharge']);
	$classA = Yii::$app->request->get('classA', 1);
	$this->title = "商家管理";
	// $this->registerJsFile('@web/statics/js/myfunc.js',['depends'=>['backend\assets\AppAsset']]);	
	$this->registerCssFile('@web/statics/css/mystyle.css',['depends'=>['backend\assets\AppAsset']]);
	$this->registerJs("
		jQuery(document).ready(function() {    
		   App.init();

		    $('.savehonor').click(function(){

				var honour = ($(this).parent().find('input[name=\"honour\"]').attr('checked') == 'checked') ? '2' : '1';			
				var shopid = $(this).parent().find('input[name=\"shopid\"]').val();


		       	$.post('$saveurl', {'honour' : honour, 'shopid': shopid}, function(data){
				   obj = JSON.parse(data);
				   if(obj.status == 200){
					   //成功
					   alert('保存成功！');
				   }else{
					   console.log(data);
					   alert('保存失败！');
				   }
			   })
		    });

			$('#classAselect').change(function(){
				var url = '$urlchange' + '&classA='+$(this).val(); 
				window.location.href=url;
	   		});	

			$('.photochange').click(function(){
				var shopid = $(this).parent().parent().find('.shopid').val();
				window.location.href='$photochangeurl' + '&shopid=' + shopid;
	   		});	

			$('.gbBuy').click(function(){
				if(confirm('确认购买？')){
					var id = $(this).parent().find('input[name=\"shopid\"]').val();
					var name = $(this).parent().find('input[name=\"shopName\"]').val();
					var discount = $(this).parent().find('input[name=\"shopDiscount\"]').val();
					var buygb = $(this).parent().find('input[name=\"buygb\"]').val();
					var gbLeft = $(this).parent().parent().find('.gbLeft');
					$.post('$shopRecharge', {'id': id, 'name': name, 'discount': discount, 'buygb': buygb}, function(data){
						obj = JSON.parse(data);
						if(obj.status == 200){
							alert('购买成功！');
							gbLeft.html(obj.data.gbLeft);
						}else{
							console.log(obj.errors);
							alert('购买失败！');
						}
					})
				}
			});

		});
	",View::POS_END);
	$urladd = Url::to(['business/shop-add-form']);
?>

<div class="row-fluid">
	<br />
	<h1>商家管理</h1>
	<br />	

	<input type="hidden" id="urladd" value="<?=$urladd?>">
	<div class="control-group">
		<span class="control-label">&nbsp;&nbsp;&nbsp;&nbsp;类别</span>
		<select id="classAselect" class="small m-wrap" tabindex="1">
			<?php 
				foreach(ClassA::find()->asArray()->all() as $class){
					$name = $class['name'];
					$id = $class['ID'];
					$selected = ($id == $classA) ? "selected" : "";
					echo "<option value='$id' $selected>$name</option>";
				}

			?>
		</select>
		<span>
			<a id="urladdnew" href="<?php echo $urladd . '&classid=' . $classA;?>">添加商家</a>
			<input type="text" class="m-wrap small" name="buygb"/>
			<button class="btn red">搜索</button>
		</span>

	</div> 

	<div class="span10">
		<!-- BEGIN SAMPLE TABLE PORTLET-->
		<div class="portlet box red">
			<div class="portlet-title">
				<div class="caption"><i class="icon-cogs"></i>商家信息</div>
			</div>

			<div class="portlet-body">

				<table class="table table-hover" style="table-layout:fixed">

					<thead>

						<tr>

							<th style="width:3%;">#</th>

							<th style="width:18%;">商家名称</th>

							<th style="width:10%;">商家折扣</th>

							<th >剩余股宝</th>

							<th style="width:15%;">购买股宝金额（元）</th>

							<th style="width:15%;">是否为贵宾商家</th>

							<th>图片操作</th>
							<th>成员管理</th>
						</tr>

					</thead>

					<tbody id="shoptable">
						<?php 
							$i = 1;
							foreach(Shop::find()->where(["classA"=>$classA])->asArray()->all() as $shop):
								$honour = ($shop['honour'] == 2) ? "checked" : "";
						?>
						<tr>

							<td><?=$i?></td>

							<td style="text-overflow: ellipsis; white-space: nowrap; overflow: hidden;">
								<a href="<?php echo $urladd . '&classid=' . $classA . '&shopid=' . $shop['ID'];?>"><?=$shop['name']?></a>
							</td>

							<td><?=$shop['discount']?></td>

							<td class="gbLeft"><?=$shop['gbLeft']?></td>

							<td>
								<input type="hidden" name="shopid" value="<?=$shop['ID']?>" />
								<input type="hidden" name="shopName" value="<?=$shop['name']?>" />
								<input type="hidden" name="shopDiscount" value="<?=$shop['discount']?>" />
								<input type="text" name="buygb" style="width:30%;"/>
								<button class="btn red gbBuy">购买</button>
							</td>

							<td>
								<input type="hidden" name="shopid" class="shopid" value="<?=$shop['ID']?>" />
								<input name='honour' type='checkbox' <?=$honour?> />
								<button class="savehonor btn green">保存</button>
							</td>

							<td>
								<button class="btn blue photochange">修改</button>
							</td>
							<td>
								<a href="<?=Url::to(['business/clerk', 'shopID'=>$shop['ID']]);?>">管理</a>
							</td>
						
						</tr>
						<?php $i++;endforeach; ?>
					</tbody>

				</table>

			</div>

		</div>

		<!-- END SAMPLE TABLE PORTLET-->

	</div>
</div>