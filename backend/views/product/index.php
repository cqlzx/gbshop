<?php
use Yii\web\View;
use yii\helpers\Url;
use backend\models\ClassB; 
use backend\models\ClassA; 
use backend\models\Circle;
use backend\models\Product;
use yii\helpers\Html;

use yii\widgets\LinkPager;

$this->title = "产品管理";
$buyUrl = Url::to(['product/buy']);
$saveUrl = Url::to(['product/save']);
$deleteUrl = Url::to(['product/delete']);
$indexUrl = Url::to(['product/index']);
/* @var $this yii\web\View */
$checked = Product::CHECKED;
$unchecked = Product::UNCHECKED;

//数据
$model = new Product();
$request = Yii::$app->request;
$classA = intval($request->get('classA'));
$shopName = $request->get("shopName");
$gbBuy = $request->get("gbBuy");
$zeroBuy = $request->get("zeroBuy");
$todayBuy = $request->get("todayBuy");
$params = array();
if($classA) $params['classA'] = $classA;
if($shopName) $params['shopName'] = $shopName;
if($gbBuy) $params['gbBuy'] = $model::CHECKED;
if($zeroBuy) $params['zeroBuy'] = $model::CHECKED;
if($todayBuy) $params['todayBuy'] = $model::CHECKED;
$items = $model->getProdectByShop($params);
$data = $items['data'];
$count_data = count($data);
$pages = $items['pages'];



$this->registerJs("
		jQuery(document).ready(function() {    
		   App.init();
		   $('.save').click(function(){
			   var tr = $(this).parent().parent();
			   var beginTime = $(this).parent().parent().find('input[name=\"beginTime\"]').val();
			   var numAll = $(this).parent().parent().find('input[name=\"numAll\"]').val();
			   var productID = $(this).parent().parent().find('input[name=\"productID\"]').val();
			   var gbBuy = ($(this).parent().parent().find('input[name=\"gbBuy\"]').attr('checked') == 'checked') ? $checked : $unchecked;
			   var zeroBuy = ($(this).parent().parent().find('input[name=\"zeroBuy\"]').attr('checked') == 'checked') ? $checked : $unchecked;
			   var todayBuy = ($(this).parent().parent().find('input[name=\"todayBuy\"]').attr('checked') == 'checked') ? $checked : $unchecked;
			   var adBuy = ($(this).parent().parent().find('input[name=\"adBuy\"]').attr('checked') == 'checked') ? $checked : $unchecked;
			   
			   console.log($(this).parent().parent().find('input[name=\"zeroBuy\"]').attr('checked'));
			   $.post('$saveUrl', {'productID' : productID, 'beginTime':beginTime, 'gbBuy': gbBuy, 'zeroBuy' : zeroBuy, 'adBuy' : adBuy, 'todayBuy':todayBuy, 'numAll':numAll}, function(data){
				   obj = JSON.parse(data);
				   if(obj.status == 200){
					   //成功
					   alert('保存成功！');
					   console.log(tr);
					   tr.find('.numLeft').html(obj.data.numLeft);
				   }else{
					   console.log(data);
					   alert('保存失败！');
				   }
			   })
		   });
		   $('.delete').click(function(){
			   var span = $(this);
			   if(confirm('谨慎操作：确认删除？')){
				    $.post('$deleteUrl',{'ID': span.attr('data-id')},function(data){
						obj = JSON.parse(data);
						if(obj.status == '200'){
							alert('删除成功');
							span.parent().parent().remove();
						}else{
							alert('删除失败');
						}
				   })
			   }
			  
		   })
		   $('.buy').click(function(){
			   if(confirm('确认购买?')){
				   var th = $(this);
				   var productID = $(this).parent().parent().find('input[name=\"productID\"]').val();
				   var productName = $(this).parent().parent().find('input[name=\"productName\"]').val();
				   var cash = $(this).parent().parent().find('input[name=\"cash\"]').val();
				   var shopID = $(this).parent().parent().find('input[name=\"shopID\"]').val();
				   var shopName = $(this).parent().parent().find('input[name=\"shopName\"]').val();
				   $.post('$buyUrl', {'productID': productID, 'productName': productName, 'cash': cash, 'shopID' : shopID, 'shopName' : shopName}, function(data){
					   data = JSON.parse(data);
					   if(data.status == 200){
						   alert('购买成功!');
						   console.log($(this).parent().parent().find('.adLeft'));
						   th.parent().parent().find('.adLeft').html(data.adLeft);
					   }else{
						   alert('购买失败!');
						   console.log(data.errors);
					   }
				   })
			   }
		   });
		   $('#classAselect').change(function(){
			   var url = '$indexUrl' + '&classA=' + $('#classAselect').val();
			   window.location.href = url;
		   })
		   $('#search').click(function(){
			   var url = '$indexUrl' + '&classA=' + $('#classAselect').val() + '&shopName=' + $('#shopName').val();
			   window.location.href = url;
		   })
		});
		
	",View::POS_END);
$this->registerCss(".save, .add, .delete, .buy{cursor:pointer;color:#0D638F;} th{vertical-align:middle !important}");
?>
<h1>产品管理</h1>

<div class="control-group">
	<span class="control-label">&nbsp;&nbsp;&nbsp;&nbsp;类别</span>
	<select id="classAselect" class="small m-wrap" tabindex="1">
		<option value='all' >全部</option>
		<?php 
			foreach(ClassA::find()->asArray()->all() as $class){
				$name = $class['name'];
				$id = $class['ID'];
				$selected = ($id == $classA) ? "selected" : "";
				echo "<option value='$id' $selected>$name</option>";
			}
		?>
	</select>
	<input type="text" class="m-wrap small" id = "shopName" name="shopName"/>
	<button class="btn red" id="search">搜索</button>
</div> 



<!-- BEGIN SAMPLE TABLE PORTLET-->
<div class="portlet box red">
	<div class="portlet-title">
		<div class="caption"><i class="icon-cogs"></i>商家信息</div>
	</div>
	<div class="portlet-body">
		<table class="table table-hover table-bordered">
			<thead>
				<tr>
					<th>商家名称</th>
					<th>产品名称</th>
					<th>股币价</th>
					<th>现金价</th>
					<th>库存</th>
					<th style="width:30px">剩余库存</th>
					<th>开抢时间</th>
					<th style="width:30px">股币惠购</th>
					<th style="width:30px">0元换购</th>
					<th style="width:30px">今日特惠</th>
					<th style="width:30px">购买广告</th>
					<th style="width:66px">操作</th>
					<th colspan="2">购买广告金额</th>
					<th style="width:44px">剩余点击次数</th>
				</tr>
			</thead>
			<tbody id="shoptable" >
				<?php 
					  //i记录大的分类，j记录一条一条的数据
					  
					   $shopNameOld = "";
					   $j = 0;     //指示输出
					   $limit = 0;
					   $rowspan = 0;
					   for($i = 0, $j = 0; $i <=  $count_data; $i++){
						   if($i == $count_data || $data[$i]['shopName'] != $shopNameOld){
							   //输出信息
							   $limit = $j + $rowspan;
							   $flag = 1;
							   for(; $j < $limit; $j++){
									echo "<tr>";
									$shopID = $data[$j]['shopID'];
									$shopName = $data[$j]['shopName'];
									$productID = $data[$j]['ID'];
									$productName = $data[$j]['name'];
									echo "<input type='hidden' name = 'shopID' value='$shopID'/>";
									echo "<input type='hidden' name = 'shopName' value='$shopName'/>";
									echo "<input type='hidden' name = 'productID' value='$productID'/>";
									echo "<input type='hidden' name = 'productName' value='$productName'/>";
									if($flag){
									  echo "<th rowspan='$rowspan'>$shopNameOld</th>";
									  $flag = 0;
									}
									echo "<th>" . $data[$j]['name'] . '</th>';
									echo "<th>" . $data[$j]['gbPrice'] . '</th>';
									echo "<th>" . $data[$j]['cashPrice'] . '</th>';
									$numAll = $data[$j]['numAll'];
									echo "<th><input type='number' name='numAll' class='m-wrap xsmall' value='$numAll'/></th>";
									echo "<th class='numLeft'>" . $data[$j]['numLeft'] . '</th>';
									$time = $data[$j]['beginTime'];
									$time = str_replace(" ", "T", $time);
									echo "<th><input type='datetime-local' name='beginTime' class='m-wrap small' value='$time'/></th>";
									$gbBuy = ($data[$j]['gbBuy'] == $model::CHECKED) ? "checked" : "";
									$zeroBuy = ($data[$j]['zeroBuy'] == $model::CHECKED) ? "checked" : "";
									$todayBuy = ($data[$j]['todayBuy'] == $model::CHECKED) ? "checked" : "";
									$adBuy = ($data[$j]['adBuy'] == $model::CHECKED) ? "checked" : "";
									echo "<th><input name='gbBuy' type='checkbox' $gbBuy></th>";
									echo "<th><input name='zeroBuy' type='checkbox' $zeroBuy></th>";
									echo "<th><input name='todayBuy' type='checkbox' $todayBuy></th>";
									echo "<th><input name='adBuy' type='checkbox' $adBuy></th>";
									$addUrl = Url::to(['product/add', 'shopID' => $shopID, 'shopName' =>$shopName, 'classA'=>$classA ]);
									$updateUrl = Url::to(['product/update', 'id' => $productID]);
									echo "<th><span class='delete'  data-id='$productID'>删除</span>&nbsp;<span class='save'>保存</span><a href='$addUrl'>增加</a>&nbsp;<a href='$updateUrl'>修改</a></th>";
									echo "<th><input name = 'cash' type='number' class='m-wrap xsmall' value='200'/> </th>";
									echo "<th><span class='buy' >购买</span></th>";
									echo "<th class='adLeft'>" . $data[$j]['adLeft'] . '</th>';
									echo "</tr>";
							   }
							   //清零		
							   if($i != $count_data){
								    $shopNameOld = $data[$i]['shopName'];
							   }
							   $rowspan = 1;
						   }else{
							   // echo $data[$i]['shopName'];
							   $rowspan++;
						   }
					  }
					  
				?>

			</tbody>
			
			<div class="pagination pagination-large">

									<?php echo LinkPager::widget([
												'pagination' => $pages,
									]);?>
			</div>
							
		</table>

	</div>		
		
</div>

<!-- END SAMPLE TABLE PORTLET-->

