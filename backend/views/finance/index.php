<?php
/* @var $this yii\web\View */

use yii\helpers\Url;
use backend\models\ClassA;
$this->title="财务分析";
$this->registerJs("
		jQuery(document).ready(function() {    
		   App.init();
		})
");
?>
<h1>财务分析</h1>
<div class="portlet box red">
	<div class="portlet-title">
		<div class="caption"><i class="icon-cogs"></i>商家信息</div>
	</div>

	<div class="portlet-body">
		<form action="<?=Url::to(['finance/index']) ?>" id="shopAdd" class="form-horizontal" method="post">
			<!-- 商家名称 -->
			<div class="control-group">

				<label class="control-label">类别</label>

				<div class="controls">

					<select name="classA" id="classAselect" class="small m-wrap" tabindex="1">
						<option value="all" >全部</option>
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
				<label class="control-label">时间段</label>
				<div class="controls">
					<input name="begintime" type="datetime-local" value="<?=$begintime;?>">&nbsp;——
					<input name="endtime" type="datetime-local" value="<?=$endtime;?>">
				</div>
			</div>
				<div class="form-actions">
					<button type="submit" id="shopAddSubmit" class="btn blue">查询</button>
					<a href="<?=Url::to(['finance/index', 'today'=>'1'])?>" class="btn blue">今日统计</a>
					<a href="<?=Url::to(['finance/index', 'month'=>'1'])?>" class="btn blue">本月统计</a>
				</div>
		</form>
	</div>
</div>

<table class="table table-hover table-bordered center" style="table-layout:fixed">

	<thead>

		<tr>
			<th colspan="3">收入</th>
			<th colspan="3">支出</th>
			<th colspan="3">潜在支出</th>
		</tr>

	</thead>

	<tbody id="shoptable">
	<tr>
		<td>充值金额</td>
		<td>广告收入</td>
		<td>收入合计</td>
		<td>商家提现</td>
		<td>用户提现</td>
		<td>支出合计</td>
		<td>商家余额</td>
		<td>用户余额</td>
		<td>余额合计</td>
	</tr>
	<tr>
		<td><?=$chargeInput?></td>
		<td><?=$ADInput?></td>
		<td><?=$chargeInput + $ADInput?></td>
		<td><?=$shopWithdraw?></td>
		<td><?=$userWithdraw?></td>
		<td><?=$shopWithdraw + $userWithdraw?></td>
		<td><?=$shopMoneyLeft?></td>
		<td><?=$userMoneyLeft?></td>
		<td><?=$shopMoneyLeft+$userMoneyLeft?></td>
	</tr>
	</tbody>
</table>
<style>
th,td{text-align:center !important;}
</style>