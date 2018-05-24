<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" type="text/css" href="<?php echo ADDON_PUBLIC_PATH;?>/bootstrap.min.css">
	<!--	<link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">-->
		<link rel="stylesheet" type="text/css" href="<?php echo ADDON_PUBLIC_PATH;?>/style.css">
		<script type="text/javascript" src="<?php echo ADDON_PUBLIC_PATH;?>/jquery-1.7.1.js"></script>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta content="width=device-width,height=device-height,initial-scale=1.0,maximum-scale=1.0,user-scalable=no" name="viewport" />		
		<title>常用预约人</title>
		<style>
		body{font-size: 16px;}
		     input[type=checkbox]{width: 16px;height: 16px;}
			.add_che{height: 40px;background: #fff;margin-top: 12px;}
			.add_che a{font-size: 16px;display: block;text-align: center;line-height: 40px;text-decoration: none;}
			.add_ren{margin-top: 10px;background: #fff; padding: 10px;}
			.quanxuan{border-bottom: 1px solid #ddd;}
			.detail_ren{height: 40px;line-height: 40px;border-bottom: 1px solid #ddd;}
			.detail_ren input{margin-left: 2%;}
			.quanxuan input{margin-left: 2%;}
			.detail_ren span:nth-of-type(1){margin-left: 3%;}
			.detail_ren span:nth-of-type(2){float: right;}
		</style>
	</head>
	<body style="background: #eee;">
		<header><h1 class="bg-primary" style="background: #feca14;">常用约车人</h1></header>	
		<div class="add_che">
			<a href="<?php echo addons_url('Forms://Wap/addXueyuan');?>">新增约车人</a>
			<script>
			$(".add_che").find("a").click(function(){
				var len=$(".detail_ren").length;
			    //alert(len)
				if(len>5){
					alert("添加的约车人不能超过6个");
					$(".add_che").find('a').attr("href",'#');
					//alert(11)
					return false;
				}
			})			    
			</script>
		</div>
		<p style="color: red;font-size: 14px;margin-top: 8px;">温馨提示：约车人不能超过6人</p>
		<div class="add_ren">
			<div class="quanxuan">
				<input type="checkbox" value="" name="allChecked" id="" onclick="DoCheck()"/><span style="margin-left: 4%;">全选</span>
			</div>
			<div class="add_detail">
			<?php  if($user[0]['xname']){ ?>
			<li class="detail_ren">
				<input type="checkbox" name="id" value="<?php echo ($user[0]['id']); ?>" id="<?php echo ($user[0]['id']); ?>"  />
				<span><?php echo ($user[0]['xname']); ?></span>
				<span><?php echo ($user[0]['xcard']); ?></span>
			</li>
			<?php
 } ?>
			<?php if(is_array($list)): foreach($list as $key=>$v): ?><li class="detail_ren">
					<input type="checkbox" name="id" value="<?php echo ($v["id"]); ?>" id="<?php echo ($v["id"]); ?>"/>
					<span><?php echo ($v["xname"]); ?></span>
					<span><?php echo ($v["xcard"]); ?></span>
				</li><?php endforeach; endif; ?>
			<input type="hidden" name="pid" id="pid" value="<?php echo ($pid); ?>">
			</div>
		</div>
		<div class="btn_submit">
			<input type="button"  id="regBtn" class="btn" value="确定" style="width: 53%;margin-left: 23%;font-size:18px;background: #feca14;color: #fff;"/>
		</div>
		<script type="text/javascript">
			$(".btn").click(function(){
				var len=$(".detail_ren").length;
				//alert(len)
				if(len>6){
					alert("添加的约车人不能超过6个");
					//alert(11)
					return false;
				}
				// var check = $("input[type='checkbox']").is(':checked');
				var chk_value = []; 
				$('input[name="id"]:checked').each(function(){
					chk_value.push($(this).val());
				});
				var str_peop = chk_value.toString();
				//被选中的人数
				var num = chk_value.length;
				var pid = $("#pid").val();
			   	var str = pid.substring(0,pid.length-1);
			   	if(str == ''){
			   		alert('请选择时间段！');
			   		return false
			   	}
			   
			   	//选择的时间段
			    var strs= new Array(); //定义一数组 
				strs = str.split(",");
				var pnum = strs.length;//时间段个数
				var pnum2 = pnum*2;
				//alert(num);
				//alert(pnum);
				
				//if(pnum==1 && num>2){
					//alert("1个小时最多2个人预约!");
					//return false;
				//}
				//if(pnum==2 && num>4){
					//alert("2个小时最多4个人预约!");
					//return false;
				//}
				//if(pnum==3 && num>6){
					//alert("3个小时最多6个人预约!");
					//return false;
				//}
				//if(pnum>=4){
					//alert('每次预约最多3个小时');
					//return false;
				//}
				//if(num==2&&pnum>2){
					//alert("2人最多预约2个小时");
					//return false;
				//}
				//if(num==3&&pnum>3){
					//alert("3人最多预约3个小时");
					//return false;
				//}
				//if(num==4&&pnum>3){
					//alert("4人最多预约3个小时");
					//return false;
				//}
				//if(num==5&&pnum>3){
					//alert("5人最多预约3个小时");
					//return false;
				//}
				//if(num==6&&pnum>3){
					//alert("6人最多预约3个小时");
					//return false;
				//}
				//if(num < pnum){ 
					//alert('对不起,您预约的时间段不能大于您选择的人数')
					//return false;
				//}
				
				if(num > pnum2){
					alert('所选学员数量不能超过'+pnum2+'个！');
					return false;
				}else if(num < pnum){
					alert('所选学员数量不能少于'+pnum+'个!');
					return false;
				}else{
					$.ajax({
			            type:"post",
			            url:"<?php echo addons_url('Forms://Wap/addDingdan');?>",
			            data:{str_peop:str_peop,str:str},
			            dataType:"json",
			            success:function(result){
			            	// document.write(result)
			            	if(result.status == 0){
			            		alert(result.msg);
			            	}else if(result.status == 2){
			            		alert("请先填写个人资料！");
			            		window.location.href = result.url;
			            	}else{
	                       		window.location.href = result.url;
			            	}
			            }
			        });
				}
				

			})
			function DoCheck(){
				var ch=document.getElementsByTagName("input")
				if(document.getElementsByName("allChecked")[0].checked==true){
					for(var i=0;i<ch.length;i++){
						ch[i].checked=true;
					}
				}else{
					for(var i=0;i<ch.length;i++){
						ch[i].checked=false;
					}
				}
			}
		</script>
	</body>
	
		<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>

		<script>
	//静态变量
		 wx.config({
		    debug: false,
		    appId: "<?php echo ($jsapiParams["appId"]); ?>",
		    timestamp: '<?php echo ($jsapiParams["timestamp"]); ?>',
		    nonceStr: '<?php echo ($jsapiParams["nonceStr"]); ?>',
		    signature: '<?php echo ($jsapiParams["signature"]); ?>',
		    jsApiList : [ 'checkJsApi', 'onMenuShareTimeline','onMenuShareAppMessage', 'getLocation', 'openLocation','hideOptionMenu','chooseImage' ,'uploadImage','downloadImage']
		  });

		  wx.ready(function () {
			  // 1 判断当前版本是否支持指定 JS 接口，支持批量判断
		      wx.checkJsApi({
		          jsApiList : [ 'getNetworkType', 'previewImage' ,'uploadImage','downloadImage'],
		          success : function(res) {
		              // 以键值对的形式返回，可用的api值true，不可用为false
		              // 如：{"checkResult":{"chooseImage":true},"errMsg":"checkJsApi:ok"}
					  // alert(res.checkResult.downloadImage);
		          }
		      });
		      // wx.hideOptionMenu();
		    	 
			
			wx.error(function(res){
			  	alert("请在微信客户端打开");
			});
		 }); 
		  
	</script>
</html>