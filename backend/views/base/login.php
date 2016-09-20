<?php 
use yii\helpers\Url;
$error = "请输入用户名和密码登录系统";
if(isset($_GET['error'])){
	$error = $_GET['error'];
}
?>

<!DOCTYPE HTML>
<html en="lang">
  <head>
    <title>登录</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

  </head>
<body>
<br/>
<br/>
<div class="login-container">
	<h2>聚股宝后台登录</h2>
	<div class ="input-container">
	<form action="<?=Url::to(['base/valid']);?>" method="post">
		<input type="hidden" name="form_name" value="login">
		<div class="hint"><?php echo $error;?></div>
		<div class="line"><span>用户名</span>
			<input type="text" name="username">
		</div>
		<div class="line"><span>密&nbsp;码</span>
			<input type="password" name="password">
		</div>
		<input type="submit" class="submit btn">
	</form>
	</div>

</div>
	<style>
		body{
			margin:0;
			padding:0;
			text-align:center;
			text-shadow: 0 -1px 1px rgba(0, 0, 0, 0.2);
			font-size:20px;
		}

		input[type="text"], input[type="password"], input[type="datetime"], input[type="datetime-local"], input[type="date"], input[type="month"], input[type="time"], input[type="week"], input[type="number"], input[type="email"], input[type="url"], input[type="search"], input[type="tel"], input[type="color"],select{
		  height:21px;
		  width:200px;
		  font-size:16px;	
		  background-color: #ffffff;
		  border: 1px solid #cccccc;
		  -webkit-border-radius: 3px;
		  -moz-border-radius: 3px;
		  border-radius: 3px;
		  -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
		  -moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
		  box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
		  -webkit-transition: border linear 0.2s, box-shadow linear 0.2s;
		  -moz-transition: border linear 0.2s, box-shadow linear 0.2s;
		  -ms-transition: border linear 0.2s, box-shadow linear 0.2s;
		  -o-transition: border linear 0.2s, box-shadow linear 0.2s;
		  transition: border linear 0.2s, box-shadow linear 0.2s;
		}

		textarea:focus,input[type="text"]:focus,input[type="password"]:focus,input[type="datetime"]:focus,input[type="datetime-local"]:focus,input[type="date"]:focus,input[type="month"]:focus,input[type="time"]:focus,input[type="week"]:focus,input[type="number"]:focus,input[type="email"]:focus,input[type="url"]:focus,input[type="search"]:focus,input[type="tel"]:focus,input[type="color"]:focus{
			border-color:rgba(82,168,236,0.8);
			outline:0;
			outline:thin dotted \9;
			-webkit-box-shadow:inset 0 1px 1px rgba(0,0,0,0.075),0 0 8px rgba(82,168,236,0.6);
			-moz-box-shadow:inset 0 1px 1px rgba(0,0,0,0.075),0 0 8px rgba(82,168,236,0.6);
			box-shadow:inset 0 1px 1px rgba(0,0,0,0.075),0 0 8px rgba(82,168,236,0.6)
		}

		h1, h2, h3, h4, h5, h6 {
		  font-family: 'Karla', sans-serif;
		  font-weight: bold;
		  color: #317eac;
		  text-rendering: optimizelegibility;
		}
		h2{
			font-size:37px;
			margin:50px;
		}

		.link{
			color:#167DD8;
			cursor:pointer;
		}

		.login-container{
			text-align:center;
			width:100%;
			position:relative;
		}
		.input-container{
			position:absolute;
			left:50%;
			margin-left:-260px;
			padding:20px;
			width:500px;
			max-width:500px;
			background-color: #f5f5f5;
			border: 1px solid rgba(0, 0, 0, 0.05);
			-webkit-border-radius:3px;
					 border-radius:3px;
		}
		.hint {
		  width:100%;
		  background-color: #EDEBE1;
		  border: 1px solid #DDE3E4;
		  text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);
		  color: #817b58;
		  height:30px;
		  line-height:30px;
		  font-size:20px;
		  -webkit-border-radius:3px;
					 border-radius:3px;
		}
		.line{
			margin:10px 0; 
			height:30px;
			line-height:30px;
		}

		.line>input{
			width: 200px;
			height:21px;
			font-size:16px;
			border: 1px solid #cccccc;
		}
		.submit{
			margin:10px 0 0 0;
			width:70px;
			height:30px;
			line-height:30px;
			cursor:pointer;
		}

		.btn{
			color:white;
			border:0;
			background-color:#43a1da;
			-webkit-border-radius:3px;
					 border-radius:3px;
		}
</style>
</body>
</html>
