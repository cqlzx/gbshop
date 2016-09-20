<?php
/* @var $this yii\web\View */
$this->title = "用户提现明细";
use yii\grid\GridView;
use Yii\web\View;

$gridView = GridView::widget([
			'dataProvider' => $dataProvider,
			'layout'=>"<div class='pagination pagination-large'>{pager}</div>\n{items}",
			'tableOptions'=>['class' => "table table-striped table-bordered table-hover"],
			'columns' => ['phone', 'time', 'money']
		]);
$this->registerJs("
		jQuery(document).ready(function() {    
		   App.init();
		})
	",View::POS_END);
?>

<h1>用户提现明细</h1>
<div class="control-group">
	
	<span style="margin-left:300px">
		<input type="text" class="m-wrap middle" />
		<button class="btn red">搜索</button>
	</span>

</div> 
<?php echo $gridView;?>