<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta content="width=device-width,height=device-height,initial-scale=1.0,maximum-scale=1.0,user-scalable=no" name="viewport" />
		<title>login</title>
		<link rel="stylesheet" type="text/css" href="/Public/static/denglu/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="/Public/static/denglu/css/style.css">
		<script type="text/javascript" src="/Public/static/denglu/js/jquery.min.js"></script>
		<script src="/Public/static/denglu/js/style.js"></script>
		<style>
			.padd{color: red;visibility: hidden;}
		</style>
	</head>
	<body>	
		<div class="bg_img">
			<div class="form_post" style="height: 320px;">
				<div id="bg_img" >
					 <div id="anitOut">
					 	<h1 style="font-size: 23px;left: 5%;transform: translate(0%);">
					 		济南城西考场网上约车系统
					 		<span style="font-size: 18px;margin-left: 5px;">V2017</span>
					 		<p style="margin-top: 30px;font-size: 14px;text-align: center;">请用ie11.0及其以上版本浏览器访问本系统</p>
					 	</h1>
					 	
					 </div>
				</div>
				<!--<header>
					<div id="switch" class="switch">
						<a id="switch_login" class="switch_btn" href="javascript:void(0);" >服务号登录</a>
						<div id="switch_bottom" class="switch_bottom" style="position: absolute; width: 84px; left: 0px; text-align: center;"></div>
					</div>
				</header>-->
				<div id="qlogin" class="qlogin" >
					<form action="" id="regUser" method="post" role="form" class="form_fuqu">
						<div class="form-group">
							<div class="col-lg-12">
								<input type="text" id="user1" name="username" placeholder="请输入账号" class="form-control"/>
							</div>
						</div>
						<div class="form-group" style="margin-bottom: 0;">
							<div class="col-lg-12" style="margin-bottom: 10px;">
								<input type="password" id="passwd1" name="password" placeholder="请输入密码" class="form-control"/>
							</div>
						</div>
						<span class="padd">抱歉,密码错误,请重新输入密码</span>
						<!-- <input type="submit" class="btn btn-primary btn_sub1" value="登录" /> -->
						<!-- ajax登录 -->
						<input type="button" class="btn btn-primary btn_sub1" value="登录" style="margin-top: 5px;"/>
					</form>				
				</div>			
			</div>
			<ul class="bg-bubbles">
				<li></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
			</ul>
		</div>		
		?
		<script src="/Public/static/denglu/js/bootstrap.min.js"></script>
	<!--	<script src="js/style.js"></script>-->
		<script>
		$(function(){
			$(".btn_sub").click(function(){
				var user=$("#user").val();	
				var pad=$("#passwd").val();
				if(user==""||pad==""){
					alert("请输入账号和密码");
				}
			})
			//$(".btn_sub1").click(function(){
				//var user=$("#user1").val();	
				//var pad=$("#passwd1").val();
				//if(user==""||pad==""){
					//alert("请输入账号和密码");
				//}
			//})
				$(document).keydown(function(event){ 
				    if(event.keyCode==13){
	              	   var user = $("#user1").val();	
						var pad = $("#passwd1").val();
						if(user !== "" && pad == ""){
							alert('请输入密码！');
							return false;
						}
						if(user == "" && pad !== ""){
							alert('请输入账号！');
							return false;
						}
						if(user == "" && pad == ""){
							alert("请输入账号和密码");
							return false;
						}else{
							//alert('sss');
							$.ajax({
								url      : "<?php echo U('User/login');?>",
								type     : "POST",
								data     : {username:user,password:pad},
								datatype : "text",
								success  : function (data) {
									
									// if(data == 0){
									// 	alert('登录失败!');
									// 	return false;
									// }
									if(data == 1){
										$(".padd").css("visibility","hidden");
										//alert('登录成功!');
										window.location.href = "index.php?s=/Home/Index/index.html";
									}else{
										$(".padd").css("visibility","visible");
										//alert(data.info);
										return false;
									}
								}
							});
						}
			        }     
//			    }
			})
			$(".btn_sub1").click(function(){

				var user = $("#user1").val();	
				var pad = $("#passwd1").val();

				if(user !== "" && pad == ""){
					alert('请输入密码！');
					return false;
				}
				if(user == "" && pad !== ""){
					alert('请输入账号！');
					return false;
				}
				if(user == "" && pad == ""){
					alert("请输入账号和密码");
					return false;
				}else{
					//alert('sss');
					$.ajax({
						url      : "<?php echo U('User/login');?>",
						type     : "POST",
						data     : {username:user,password:pad},
						datatype : "text",
						success  : function (data) {
							
							// if(data == 0){
							// 	alert('登录失败!');
							// 	return false;
							// }
							if(data == 1){
								$(".padd").css("visibility","hidden");
								//alert('登录成功!');
								window.location.href = "index.php?s=/Home/Index/index.html";
							}else{
								$(".padd").css("visibility","visible");
								//alert(data.info);
								return false;
							}
						}
					});
				}
			})
		})			
		</script>
	</body>
</html>