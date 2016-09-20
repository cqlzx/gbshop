<?php
	use yii\web\View;
	use yii\helpers\Url;
	use backend\models\User;

	$urlUserRecharge = Url::to(['gb/user-recharge']);
	$urlUserWithdraw = Url::to(['gb/user-withdraw']);
	$urlUserOrder = Url::to(['gb/user-order']);
	$urlUserDelete = Url::to(['gb/user-delete']);
	$urlMoveToMyAccount = Url::to(['gb/move-to-my-account']);

	$this->title = "股币管理";
	$this->registerJs("
		jQuery(document).ready(function() {    
		   	App.init();

		   	$('#select1').toggle(function(){
		   		$('.selectAll').attr('checked', true);
		   		$('.selectAll').parent().addClass('checked')},
		   		function(){
		   		$('.selectAll').attr('checked', false);
		   		$('.selectAll').parent().removeClass('checked')}
		   	);

		   	$('.delete1').click(function(){
		   		if(confirm('确认删除？')){
		   			var id = $(this).parent().parent().find('input[name=\"userid\"]').val();
		   			$.post('$urlUserDelete', {'userid' : id}, function(data){
					    obj = JSON.parse(data);
					    if(obj.status == 200){
						    //成功
						    alert('删除成功！');
						    window.location.reload();
					    }else{
						    console.log(data);
						    alert('删除失败！');
					   	}
					})
			    }
		   	});
			$('#moveToMyAccount').click(function(){
				if(confirm('确认移动？')){
					var length = $(':checked').length;
					var id = new Array();
					for(var i = 0; i < length; i++){
						id[i] = $(':checked').eq(i).parent().parent().parent().parent().find('input[name=\"userid\"]').val();
					}

					$.post('$urlMoveToMyAccount', {'userid' : JSON.stringify(id)}, function(data){
					    obj = JSON.parse(data);
					    if(obj.status == 200){
						    //成功
						    alert('成功！');
						    window.location.reload();
					    }else{
						    console.log(data);
						    alert('失败！');
					   	}
					})
				}

			});



		})
	",View::POS_END);
	$this->registerCss("td{text-align:center !important; vertical-align:middle !important}
						th{text-align:center !important; vertical-align:middle !important}");
?>

<div class="row-fluid">
	<br />
	<h1>用户股币管理</h1>
	<br />	

	<div class="control-group">
		<span>
			<button class="btn red" id="moveToMyAccount">移动到我的用户</button>
		</span>

		<span style="margin-left:300px">
			<input type="text" class="m-wrap middle" />
			<button class="btn red">搜索</button>
		</span>

	</div> 

	<table class="table table-hover table-bordered center" style="table-layout:fixed">

	<thead>

		<tr>
			<th rowspan="2" width="5%"><a href="#" id="select1">全选</a></th>
			<th rowspan="2" width="12%">名称（手机号）</th>
			<th rowspan="2" width="5%">剩余股币</th>
			<th rowspan="2" width="8%">广告转股币数</th>
			<th rowspan="2" width="8%">现金余额（元）</th>
			<th rowspan="2" width="9%">累计体现金额（元）</th>
			<th rowspan="2">隶属商家</th>
			<th rowspan="2" width="5%">性别</th>
			<th colspan="3" width="15%">生日</th>
			<th rowspan="2" width="5%">年龄</th>
			<th rowspan="2" width="5%">股币明细</th>
			<th rowspan="2" width="5%">提现明细</th>
			<th rowspan="2" width="5%">订单明细</th>
			<th rowspan="2" width="5%">操作</th>
		</tr>
		<tr>
			<th>年</th>
			<th>月</th>
			<th>日</th>
		</tr>

	</thead>

	<tbody id="shoptable">
	<?php
		$users = User::find()->asArray()->all();
		foreach($users as $user):
			$id = $user['ID'];
			$date = explode("-", $user['birthday']);
			$year = $month = $day = $age = '';
			if($user['birthday']){
				$date = explode("-", $user['birthday']);
				$year = $date[0];
				$month = $date[1];
				$day = $date[2];
				$age = date('Y') - $date[0];
			}
	?>
		<tr>
			<input type="hidden" name="userid" value="<?=$id?>" />
			<td><input type="checkbox" class="selectAll" /></td>
			<td><?=$user['phone']?></td>
			<td><?=$user['gbLeft']?></td>
			<td><?=$user['adEarned']?></td>
			<td><?=$user['cashLeft']?></td>
			<td><?=$user['totalWithdrawCash']?></td>
			<td><?=$user['shopName']?></td>
			<td><?=($user['sex'] == 1) ? "男" : "女" ?></td>
			<td><?=$year?></td>
			<td><?=$month?></td>
			<td><?=$day?></td>
			<td><?=$age?></td>
			<td><a href="<?=$urlUserRecharge . '&userid=' . $id?>">查询</a></td><!-- 股币明细 -->
			<td><a href="<?=$urlUserWithdraw . '&userid=' . $id?>">查询</a></td><!-- 提现明细 -->
			<td><a href="<?=$urlUserOrder . '&userid=' . $id?>">查询</a></td><!-- 订单明细 -->
			<td><a href="#" class="delete1">删除</a></td><!-- 用户删除 -->	
		</tr>
	<?php endforeach;?>
	</tbody>
</table>