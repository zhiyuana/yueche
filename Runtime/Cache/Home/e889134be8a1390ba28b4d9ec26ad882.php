<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta content="width=device-width,height=device-height,initial-scale=1.0,maximum-scale=1.0,user-scalable=no" name="viewport" />
		<title>订单查询</title>
		<link rel="stylesheet" type="text/css" href="<?php echo ADDON_PUBLIC_PATH;?>/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="<?php echo ADDON_PUBLIC_PATH;?>/style3.css">
		<script src="<?php echo ADDON_PUBLIC_PATH;?>/jquery.min.js" type="text/javascript"></script>
	    <style>
	        .yuyue_name{height: 40px;padding:10px;background: #fff;}	  
		    .yuyue_name span{display: inline-block;margin-right: 20px;}
		    .kaoshi{height: 40px;padding:10px;background: #fff;}
		    .jia_name{float: left;}
		    .red {color:#ff7e00;float: right;font-size: 16px;}
		    .name{float: left;}  
		    .phone{float: right;}
			.data_time i{float: left;}
			.data_dian{float: left;}
			.data_dian span{width: 80px;margin-right: 20px;} 
			.zuihou{height: 75px;background: #fff;margin-top: 10px;margin-bottom: 10px;}
			.zuihou p{margin-bottom: 5px;margin-top:0;text-align: center;padding-left:0;width:100%;margin-right: 0;padding-right: 0;margin-left: 0;}
			.zuihou div{border: 1px solid #ddd;float: right;margin-right: 15px;}
			.pay_detail span{margin-bottom: 0px;}
			@font-face {
			  font-family: 'iconfont';
			  src: url('iconfont.eot');
			  src: url('iconfont.eot?#iefix') format('embedded-opentype'),
			  url('<?php echo ADDON_PUBLIC_PATH;?>/iconfont.woff') format('woff'),
			  url('iconfont.ttf') format('truetype'),
			  url('iconfont.svg#iconfont') format('svg');
			}
			.iconfont{
			  margin-left: 10px;
			  font-family:"iconfont" !important;
			  font-size:16px;font-style:normal;
			  /*color: #ff7e00;*/
			  -webkit-font-smoothing: antialiased;
			  -webkit-text-stroke-width: 0.2px;
			  -moz-osx-font-smoothing: grayscale;
			}
	    </style>
	</head>
	<body style="background: #eee;">
		<?php
 if($d_list){ ?>
			
		<!--<header>
			<h1 class="bg-primary">已完成订单</h1></header>-->
	<?php if(is_array($d_list)): foreach($d_list as $key=>$v): ?><form action="<?php echo addons_url('Forms://Wap/tuikuan');?>" method="post">
		<input type="hidden" name="id" value="<?php echo ($v["id"]); ?>">
		    <div class="pay" style="margin-top: 10px;">
				<div class="kaoshi">
					<div class="jia_name"><img src="<?php echo ADDON_PUBLIC_PATH;?>/jiakao.jpg" alt="正在加载中" style="width: 20px;height: 20px;float: left;margin-right: 10px;"><span>考试中心</span><i class="iconfont">&#xe65f;</i></div>
					<?php if($v["status"] == 0): ?><span class="red">交易完成</span><?php endif; ?>
					<?php if($v["status"] == 1): ?><span class="red">退款成功</span><?php endif; ?>
					<?php if($v["status"] == 2): ?><span class="red">已消费</span><?php endif; ?>
					<?php if($v["status"] == 3): ?><span class="red">退款中</span><?php endif; ?>
					<!-- <span class="red">交易完成</span> -->
				</div>
			</div>	
			<!-- <p class="detail">订单详情</p> -->
			<a href="<?php echo addons_url('Forms://Wap/dingdan_xq',array('id'=>$v['id']));?>" style="color: #000;">
				<div class="pay_row" style="background: #eee;margin-bottom: 0;overflow-x: hidden;">
					<div class="pay_detail row"  style="background: #eee;margin-bottom: 0;padding-bottom: 0;overflow-x: hidden;">
						<img src="<?php echo ADDON_PUBLIC_PATH;?>/jiakao.jpg" alt="正在加载中" class="col-sm-3" style="width: 20%;height: 60px;float: left;padding: 0;"/>
						<div class="col-sm-9 car_number" style="width: 80%;float: left;">
							<!--<span>订单编号：<?php echo ($v["transaction_id"]); ?></span>-->							
							<div>
								<span style="width: 80px;float: left;">车号：<?php echo ($v["pch"]); ?></span>
								<span style="color: #ff7e00;margin-bottom: 0;float: right;width: 87px;">单价：￥<?php echo ($v["money"]); ?></span>
							</div>
							<span style="clear: both;">日期：<?php echo ($v["pdata"]); ?></span>
							<span>下单时间：<?php echo ($v["daddtime"]); ?></span>					
						</div>
					</div>
					<!--<img src="<?php echo ADDON_PUBLIC_PATH;?>/img_pass.png" alt="颜色" class="animate"/>-->
				</div>
			</a>
			<div class="zuihou">
				<!-- <input type="hidden" name="" id="xiaoshi" value="<?php echo ($v["money"]); ?>"> -->
				<p style="border-bottom: 1px dashed #ddd;font-size: 13px;" id="shouxu">共<?php echo ($v["num"]); ?>个小时 合计：￥<?php echo ($v["money"]); ?></p>
				<!--<a href="<?php echo addons_url('Forms://Wap/Query_pub');?>" class="btn"  style="border-radius: 20px;padding: 4px 6px;background:#ff7e00;color: #fff;margin-right: 5px;">查询</a>-->
				<?php if($v["status"] == 0): ?><button class="btn  btn_blank" style="border-radius: 20px;padding: 4px 6px;background:#ff7e00;color: #fff;">申请退款</button><?php endif; ?>
			</div>
	   </form><?php endforeach; endif; ?>
	<?php  }else{ ?>
		<div style="width: 100%;height: 100%;background: #eee;">
			<p style="font-size: 16px;margin-top: 50%;margin-left: 30%;">您还没有订单哦!</p>
		</div>
		<?php
 } ?>
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