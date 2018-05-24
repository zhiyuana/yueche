<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<meta content="width=device-width,height=device-height,initial-scale=1.0,maximum-scale=1.0,user-scalable=no" name="viewport" />
		<link rel="stylesheet" type="text/css" href="<?php echo ADDON_PUBLIC_PATH;?>/style.css">
		<style>
			header{height: 180px;width: 100%;margin-bottom: 20px;}
			img{width: 100%;height: 100%;}
			a{display: block;}
			/*.ul{background: #fff;padding: 15px;padding-top: 0;padding-bottom: 0;}*/
			ul{background: #fff;padding:0 15px;margin-bottom: 10px;}
			li{height: 45px;line-height: 45px;}
			a{color: #000;text-decoration: none;}
			a:hover{text-decoration: none;}
			i{margin-right: 10px;}
			.right_icon{float: right;margin-right: 0;}
			@font-face {
			  font-family: 'iconfont';
			  src: url('iconfont.eot');
			  src: url('iconfont.eot?#iefix') format('embedded-opentype'),
			  url('<?php echo ADDON_PUBLIC_PATH;?>/iconfont.woff') format('woff'),
			  url('iconfont.ttf') format('truetype'),
			  url('iconfont.svg#iconfont') format('svg');
			}
			.iconfont{
			  font-family:"iconfont" !important;
			  font-size:20px;font-style:normal;
			  color: #ff7e00;
			  -webkit-font-smoothing: antialiased;
			  -webkit-text-stroke-width: 0.2px;
			  -moz-osx-font-smoothing: grayscale;
			}
		</style>
	</head>
	<body style="background: #ddd;">
		<header>
			<img src="<?php echo ADDON_PUBLIC_PATH;?>/jiakao1.png" alt="图片正在加载" style="position: relative;"/>
			<img src="<?php echo ADDON_PUBLIC_PATH;?>/head.png" style="width: 80px;height: 80px;position: absolute;left: 40%;top: 24%;" />
			<!--<span style="width: 60px;height: 60px;background: #ff7e00;border-radius: 100%;">个人中心</span>-->
		</header>
		<div class="ul" style="margin-top: 41px;">
			<ul>
				<a href="http://yueche.siwoinfo.com/index.php?s=/addon/Forms/Wap/index/forms_id/13/publicid/1.html"><li><i class="iconfont">&#xe637;</i>已完成订单<i class="iconfont right_icon">&#xe65f;</i></li></a>
			</ul>
			<ul>
				<a href="http://yueche.siwoinfo.com/index.php?s=/addon/Forms/Wap/index/forms_id/12/publicid/1.html"><li><i class="iconfont">&#xe84b;</i>待支付订单<i class="iconfont right_icon">&#xe65f;</i></li></a>
			</ul>
			<ul>
				<a href="<?php echo addons_url('Forms://Wap/lianxiren');?>"><li style="border:none"><i class="iconfont">&#xe63b;</i>常用约车人<i class="iconfont right_icon">&#xe65f;</i></li></a>
			</ul>
			<ul>
				<a href="<?php echo addons_url('Forms://Wap/editxueyuan');?>"><li style="border:none"><i class="iconfont">&#xe66f;</i>个人信息的修改<i class="iconfont right_icon">&#xe65f;</i></li></a>
			</ul>
			<ul>
				<a href="<?php echo addons_url('Forms://Wap/tuifeixuzhi');?>"><li style="border:none"><i class="iconfont">&#xe6de;</i>退费须知<i class="iconfont right_icon">&#xe65f;</i></li></a>
			</ul>			
		</div>
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