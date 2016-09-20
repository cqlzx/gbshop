<?php
/* @var $this yii\web\View */
$this->title = "股币管理";
use yii\grid\GridView;
use Yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;
use backend\models\ClassA;

$request = Yii::$app->request;
$classA = $request->get("classA", 1); //一级分类
$honour = $request->get("honour", 1); //是否为贵宾

$saveUrl = Url::to(['gb/save']);
$deleteUrl = Url::to(['gb/delete']);
$randUrl = Url::to(['gb/rand']);
$distributeUrl = Url::to(['gb/distribute']);


$indexUrl = Url::to(['gb/index', '$honour'=>$honour]);
$this->registerCss(".pointer{cursor:pointer;color:#0D638F;} td{vertical-align:middle !important}");
$this->registerJs("
		jQuery(document).ready(function() {    
		   App.init();
		   $('.save').click(function(){
			   var tr = $(this).parent().parent();
			   var id = tr.attr('data-key');
			   var discount = tr.find('input[name=\"discount\"]').val();
			   var gjNew = tr.find('input[name=\"gjNew\"]').val();
			   var gbChargeRate = tr.find('input[name=\"gbChargeRate\"]').val();
			   var gbExchangeRate = tr.find('input[name=\"gbExchangeRate\"]').val();
			   var cashReturnRate = tr.find('input[name=\"cashReturnRate\"]').val();
			   $.post('$saveUrl', {'id':id,'discount':discount, 'gjNew':gjNew, 'gbChargeRate':gbChargeRate, 'gbExchangeRate':gbExchangeRate, 'cashReturnRate':cashReturnRate}, function(data){
				   obj = JSON.parse(data);
				   if(obj.status == 200){
					   //成功
					   alert('保存成功！'); 
					   window.location.reload();
				   }else{
					   console.log(data);
					   alert('保存失败！');
				   }
			   })
		   });
		   $('.delete').click(function(){
			   var tr = $(this).parent().parent();
			   var id = tr.attr('data-key');
			   if(confirm('谨慎操作：删除后不可恢复！')){
					 $.post('$deleteUrl', {'id':id}, function(data){
						   obj = JSON.parse(data);
						   if(obj.status == 200){
							   //成功
							   alert('删除成功！');  
						   }else{
							   console.log(data);
							   alert('删除失败！');
						   }
					   })   
			   }
			  
		   });
		   $('#classAselect').change(function(){
			   var url = '$indexUrl' + '&classA=' + $('#classAselect').val();
			   window.location.href = url;
		   });
		   $('#randSubmit').click(function(){
			   $('#rand').ajaxSubmit({
					url: '$randUrl',
					type: 'post',
					success: function(data){
						obj = JSON.parse(data);
						if(obj.status == 200){
							alert('更新了' + obj.data + '几条数据');
							window.location.reload();
						}else{
							alert('更新失败');
						}
					}  
			   });
		   });

		   $('#distributeSubmit').click(function(){
			   $.post('$distributeUrl',{}, function(data){
				   obj = JSON.parse(data);
				   if(obj.status == 200){
					   alert('发布成功');
					   window.location.reload();
				   }else{
					   alert('发布失败');
				   }
			   })
		   });
		});
	",View::POS_END);
	$columns = array(
				['attribute' => 'name', 'label' => '名称'],
				['attribute' => 'phone', 'label' => '账号'],
				['attribute' => 'latestCharge', 'label' => '充值金额'],
				['attribute' => 'discount', 'label' => '商家折扣', 'format' => 'raw', 'value' => function($model){ return Html::Input('text', 'discount', $model->discount, ['class' => 'm-wrap xxsmall']);}],
				['attribute' => 'discount', 'label' => '商家股币单价', 'value' => function($model){return $model->discount;}],
				['attribute'=>'latestGb', 'label' => '冲股币数'],
				['attribute' => 'gbLeft', 'label' => '股币余额', 'options'=>['class'=>'dd']],
				['attribute' => 'gjNew', 'label' => '随机股价'],
				['attribute' => 'gjNew', 'label' => '手动股价', 'format' => 'raw', 'value' => function($model,$key){
					return Html::Input('text', 'gjNew', $model->gjNew, ['class' => 'm-wrap xxsmall']);
				}],
				['format' => ['percent', 2], 'attribute' => 'increaseRateOld'],
				['format' => ['percent', 2], 'attribute' => 'increaseRateNew'],
				['attribute' => 'gjNew', 'label' => '冲股币系数', 'format' => 'raw', 'value' => function($model,$key){
					return Html::Input('text', 'gbChargeRate', $model->gbChargeRate, ['class' => 'm-wrap xxsmall']);
				}],
				['attribute' => 'gjNew', 'label' => '股币兑换限额系数', 'format' => 'raw', 'value' => function($model,$key){
					return Html::Input('text', 'gbExchangeRate', $model->gbExchangeRate, ['class' => 'm-wrap xxsmall']);
				}],
				['attribute' => 'moneyAll'],
				
				['label' => '操作', 'format' => 'raw', 'value' => function(){
						return "<span class='delete pointer'>删除</span><span class='save pointer'>保存</span>";
				}],
				['label' => '充值明细', 'format' => 'raw', 'value' => function($model, $key){
					    $viewRechargeUrl = Url::to(['gb/shop-recharge', 'shopID'=>$key]);
						return "<a href='$viewRechargeUrl' class='shopRecharge pointer'>查询</a>";
				}],
				['label' => '提现明细', 'format' => 'raw', 'value' => function($model, $key){
						$viewWithdrawUrl = Url::to(['gb/shop-withdraw', 'shopID'=>$key]);
						return "<a href='$viewWithdrawUrl' class='shopWithdraw pointer'>查询</a>";
				}],
				['attribute' => 'gjNew', 'label' => '返利比例', 'format' => 'raw', 'value' => function($model,$key){
					return Html::Input('text', 'cashReturnRate', $model->cashReturnRate, ['class' => 'm-wrap xxsmall']);
				}],
				'cashReturn','userNum',
	);
		$gridView = GridView::widget([
			'dataProvider' => $dataProvider,
			'layout'=>"<div class='pagination pagination-large'>{pager}</div>\n{items}",
			'tableOptions'=>['class' => "table table-striped table-bordered table-hover"],
			'columns' => $columns,
		]);
?>

<h1>股币管理</h1>
<div class="control-group">
	<form action="<?php echo $indexUrl;?>" method="post">
	<span class="control-label">类别</span>
	<select id="classAselect" class="small m-wrap" name = "classA" tabindex="1">
		<?php 
			foreach(ClassA::find()->asArray()->all() as $class){
				$name = $class['name'];
				$id = $class['ID'];
				$selected = ($id == $classA) ? "selected" : "";
				echo "<option value='$id' $selected>$name</option>";
			}
		?>
	</select>
	<input type="text" name="phone" class="m-wrap middle">
	<input type="submit" value="搜索">
	</form>
	<form id="rand" method ="post" >
	<input type="text" class="m-wrap xxsmall" name="low" value="4">-<input type="text" class="m-wrap xxsmall" name="high" value="6">
	<button id="randSubmit" class="btn red">生成随机股价</button>
	<button id="distributeSubmit" class="btn red">发布随机股价</button>
	</form>
	
</div> 
<?php
echo $gridView;
?>

