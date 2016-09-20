$(function(){
	$("#head1").click(function(){
		$(".pic-list").load("albumload.php #dishes");
		$(".strip").removeClass("strip");
		$("#head1").parent().addClass("strip");
	});
	$("#head2").click(function(){
		$(".pic-list").load("albumload.php #environment");
		$(".strip").removeClass("strip");
		$("#head2").parent().addClass("strip");
	});
	$("#head3").click(function(){
		$(".pic-list").load("albumload.php #other");
		$(".strip").removeClass("strip");
		$("#head3").parent().addClass("strip");
	});
	$("#head4").click(function(){
		$(".pic-list").load("albumload.php #all");
		$(".strip").removeClass("strip");
		$("#head4").parent().addClass("strip");
	});
	
	$("#second-class1").click(function(){
		$(".shopitems").load("shoplistload.php #hot-pot");
		$(".strip2").removeClass("strip2");
		$("#second-class1").addClass("strip2");
	});
	$("#second-class2").click(function(){
		$(".shopitems").load("shoplistload.php #sichuan");
		$(".strip2").removeClass("strip2");
		$("#second-class2").addClass("strip2");
	});
	$("#second-class3").click(function(){
		$(".shopitems").load("shoplistload.php #Japan");
		$(".strip2").removeClass("strip2");
		$("#second-class3").addClass("strip2");
	});
	$(".back").click(function(){
		window.history.back(-1);
	});
	$(".back2").click(function(){
		window.history.back(-1);
	});
	$(".back3").click(function(){
		window.history.back(-1);
	});
	$(".back4").click(function(){
		window.history.back(-1);
	});
	
	$("#sub").click(function(){
		var num = $("#quantity").val();
		num = parseInt(num);
		if((num - 1) == 0){alert("不能为0！");}
		else{num = num - 1;}
		$("#quantity").val(num);
	});
	$("#add").click(function(){
		var num = $("#quantity").val();
		num = parseInt(num);
		num = num + 1;
		$("#quantity").val(num);
	});
})
