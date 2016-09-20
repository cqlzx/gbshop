<?php 
use yii\helpers\Url;
?>
<form method="post" action = "<?=Url::to(['base/phone-save'])?>" >
	<br/>
	<input type="text" class="form-control" name="phone" placeholder="手机号" >

	<!--div class="input-group" style="margin-top:5px" >
		<input type="text" class="form-control" placeholder="输入验证码"> 
		<div class="input-group-btn">
			<button type="button" class="btn btn-default">获取验证码</button> 
		</div> 
	</div-->
	
	<!--div class="input-group" style="margin-top:5px" >
		<label class="block" style="margin-right:5px">注册类型</label>
		<label class="radio-inline">
		  <input type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1">用户
		</label>
		<label class="radio-inline">
		  <input type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2">商家
		</label>
		<label class="radio-inline">
		  <input type="radio" name="inlineRadioOptions" id="inlineRadio3" value="option3">店员
		</label>
	</div-->
	<input class="btn btn-primary btn-block" type="submit" id="submit" style="margin-top:5px" value="注册" >
</form>

