<?php
/* @var $this yii\web\View */
$this->title = "充值明细";
use yii\grid\GridView;
use Yii\web\View;

$gridView = GridView::widget([
			'dataProvider' => $dataProvider,
			'layout'=>"<div class='pagination pagination-large'>{pager}</div>\n{items}",
			'tableOptions'=>['class' => "table table-striped table-bordered table-hover"],
			'columns' => ['shopName', 'time', 'money', 'gb', 'discount']
		]);
$this->registerJs("
		jQuery(document).ready(function() {    
		   App.init();
		})
	",View::POS_END);
?>

<h1>充值明细</h1>
<?php echo $gridView;?>