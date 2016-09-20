<?php 
	$info = Yii::$app->user->identity->attributes;
	use yii\helpers\Url;
?>
<div style="padding:5px;">
<form method="post" action = "<?=Url::to(['user-save']);?>">
  <div class="form-group">
    <label for="exampleInputEmail1">昵称</label>
    <input type="text" name="nickname" class="form-control" id="exampleInputEmail1" placeholder="Email" value="<?=$info['nickname'];?>">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">生日</label>
    <input type="date" name ="birthday" class="form-control" id="exampleInputPassword1" placeholder="Password" value="<?=$info['birthday']?>">
  </div>
  <div class="form-group">
    <label for="exampleInputEmail1">收获地址</label>
    <input type="text" name="address" class="form-control" id="exampleInputEmail1" placeholder="请填写收货地址" value="<?=$info['address'];?>">
  </div>
  <div class="form-group">
    <label for="exampleInputFile">手机号</label>
    <input type="text" class="form-control" id="phone" name="phone" value="<?=$info['phone'];?>">
    <p class="help-block"><?=Yii::$app->request->get('error');?></p>
  </div>
  <button type="submit" class="btn btn-block btn-primary btn-form-control">保存</button>
</form>
</div>