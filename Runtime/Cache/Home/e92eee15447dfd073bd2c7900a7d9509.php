<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta content="width=device-width,height=device-height,initial-scale=1.0,maximum-scale=1.0,user-scalable=no" name="viewport" />
		<title>订单详情</title>
		<link rel="stylesheet" type="text/css" href="<?php echo ADDON_PUBLIC_PATH;?>/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="<?php echo ADDON_PUBLIC_PATH;?>/style3.css">
		<script src="<?php echo ADDON_PUBLIC_PATH;?>/jquery.min.js" type="text/javascript"></script>
		<style>
		    header{width: 100%;height: 100px;background: #ff7e00;color: #fff;}
		    .poy_left{float: left;margin-left: 10%;margin-top: 10%;}
		    .poy_left span{display: inline-block}
		    .poy_right{float: right;width: 80px;height: 60px;margin-top: 7%;margin-right: 10%;}	
		    .yuyue_name{height: 40px;padding:10px;background: #fff;}	  
		    .yuyue_name span{display: inline-block}
		    .kaoshi{height: 40px;padding:10px;background: #fff;}
		    .jia_name{float: left;}
		    .red {color:#ff7e00;float: right;font-size: 16px;}
		    .name{float: left;}  
		    .phone{float: right;}
			.data_time i{float: left;}
			.data_dian{float: left;}
			.data_dian span{width: 80px;margin-right: 20px;} 
			.zuihou{height: 75px;background: #fff;margin-top: 10px;}
			.daoxiao{height: 40px;background: #fff;margin-top: 10px;padding:0px 10px 10px;line-height: 30px;margin-bottom: 10px;}
			.daoxiao p{margin-bottom: 5px;margin-top:0;text-align: right;padding-left:0;width:100%;}
			.zuihou p{padding-left:0;padding-right:0;font-size:13px;margin-right:0;margin-bottom: 5px;margin-top:0;text-align: right;padding-left:0;width:100%;}
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
			.ding_left{width:84px;display: inline-block;}
			.ding_right{display: inline-block;}
		</style>
	</head>
	    <script type="text/javascript">
		//调用微信JS api 支付
		function jsApiCall()
		{
			WeixinJSBridge.invoke(
				'getBrandWCPayRequest',
				<?php echo $jsApiParameters; ?>,
				function(res){
					// WeixinJSBridge.log(res.err_msg);
					// alert(res.err_msg);
					if (res.err_msg == "get_brand_wcpay_request:ok") {
						alert('支付成功'); 
						$.ajax({
				            type:"post",
				            url:"<?php echo addons_url('Forms://Wap/Dingdan');?>",
				            dataType:"json",
				            success:function(result){
				            	// document.write(result)
	    		            	if(result.status == 0){
	    		            		alert(result.msg);
	    		            	}else{
	    	    					window.location.href = result.url;
	    		            	}
				            }
				        });
					}
				}
			);
		}

		function callpay()
		{
			if (typeof WeixinJSBridge == "undefined"){
			    if( document.addEventListener ){
			        document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
			    }else if (document.attachEvent){
			        document.attachEvent('WeixinJSBridgeReady', jsApiCall); 
			        document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
			    }
			}else{
			    jsApiCall();
			}
		}
		</script>
		
	<body style="background: #eee;">
		
		<header>			
			<div class="poy_left">
				<?php
 if($xq_list[0]['status'] == 0){ ?>
			    <span style="font-size: 16px;">交易成功</span>
			    <?php
 }else if($xq_list[0]['status'] == 1){ ?>
				<span style="font-size: 16px;">退款成功</span>
				<?php
 }else if($xq_list[0]['status'] == 2){ ?>
				<span style="font-size: 16px;">已消费</span>
				<?php
 }else if($xq_list[0]['status'] == 3){ ?>
				<span style="font-size: 16px;">退款中</span>
				<?php
 } ?>
			</div>
			<?php
 if($xq_list[0]['status'] == 0){ ?>
			<img src="<?php echo ADDON_PUBLIC_PATH;?>/success.png" alt="正在加载中" class="poy_right"/>
			 <?php
 }else if($xq_list[0]['status'] == 1){ ?>
			<img src="<?php echo ADDON_PUBLIC_PATH;?>/tuikuan.png" alt="正在加载中" class="poy_right"/>
			 <?php
 }else if($xq_list[0]['status'] == 2){ ?>
			<img src="<?php echo ADDON_PUBLIC_PATH;?>/success.png" alt="正在加载中" class="poy_right"/>
			 <?php
 }else if($xq_list[0]['status'] == 3){ ?>
			<img src="<?php echo ADDON_PUBLIC_PATH;?>/tuikuan.png" alt="正在加载中" class="poy_right"/>
			<?php
 } ?>
		</header>
		<div class="yuyue_name">
			<span class="name">预约人：<?php echo ($xq_list[0]['xname']); ?></span>
			<span class="phone"><?php echo ($xq_list[0]['xphone']); ?></span>
		</div>
		
		<?php  foreach($peop_list as $k => $v){ foreach($v as $h => $g){ ?>
			<div class="yuyue_name">
				<span class="name">预约人：<?php echo $g['xname'];?></span>
				<span class="phone"><?php echo $g['xphone'];?></span>
			</div>
		<?php
 } } ?>

		<div class="pay" style="margin-top: 10px;position: relative;">
			<div class="kaoshi">
				<div class="jia_name"><img src="<?php echo ADDON_PUBLIC_PATH;?>/jiakao.jpg" alt="正在加载中" style="width: 20px;height: 20px;float: left;margin-right: 10px;"><span>考试中心</span><i class="iconfont">&#xe65f;</i></div>
				<?php
 if($xq_list[0]['status'] == 0){ ?>
				<span class="red">交易完成</span>
				<?php
 }else if($xq_list[0]['status'] == 1){ ?>
				<span class="red">退款成功</span>
				<?php
 }else if($xq_list[0]['status'] == 2){ ?>
				<span class="red">已消费</span>
				<?php
 }else if($xq_list[0]['status'] == 3){ ?>
				<span class="red">退款中</span>
				<?php
 } ?>
				
			</div>
			<!-- <p class="detail">订单详情</p> -->
			<input type="hidden" name="pdata" id="pdata" value="<?php echo ($xq_list[0]['pdata']); ?>"/>
			<div class="pay_row" style="background: #eee;margin-bottom: 0;">
				<div class="pay_detail row"  style="background: #eee;">
					<img src="<?php echo ADDON_PUBLIC_PATH;?>/jiakao.jpg" alt="正在加载中" class="col-sm-3 show" style="width: 20%;height: 60px;margin-bottom:0;float: left;padding: 0;" />
					<div class="col-sm-9 car_number" style="width: 80%;float: left;">
					<input type="hidden" name="wid" value="<?php echo ($w_list[0]['id']); ?>">
					<input type="hidden" name="datatime" value="<?php echo ($datatime); ?>">						
						<span>车号：<?php echo ($xq_list[0]['pch']); ?></span>
						<span>日期：<?php echo ($xq_list[0]['pdata']); ?></span>
						<span style="color:#ff7e00;margin-bottom: 0;">单价：￥150.00</span>	
						<!--<span>总价：￥<?php echo ($w_list[0]['money']); ?>.00</span>		-->												
					</div>
				</div>
					
			</div>			  
			<div class="order_number" style="background: #fff;padding: 10px;">
				 <div class="data_time" style="float: left;">
					<i style="width: 84px;">预约时间：</i>
					<div class="data_dian">
					<?php  $arr = explode(',',$xq_list[0]['ptime']); foreach($arr as $v){ ?>
						<span style="width:92px;color:#ff7e00;float: left;margin-right: 1px;font-weight: 700;word-wrap:break-word;margin-right: 5px;" class="ptime"><?php echo $v; ?></span><!--background:#ff7e00;padding:3px;-->
					<?php
 } ?>
					</div>
				</div>	<br />
				<span class="ding_left">微信订单号：</span><span class="ding_right"><?php echo ($xq_list[0]['transaction_id']); ?></span>
				<span class="ding_left">商户订单号：</span><span class="ding_right"><?php echo ($xq_list[0]['out_trade_no']); ?></span>
				<span class="ding_left">下单时间：</span><span class="ding_right"><?php echo ($xq_list[0]['daddtime']); ?></span>
			</div>
			<div class="zuihou" style="height: 40px;">
				<p style="border-bottom: 1px dashed #ddd;text-align: center;">共<?php echo ($xq_list[0]['num']); ?>个小时 合计：￥<?php echo ($xq_list[0]['money']); ?></p>
				<!--<a onclick="callpay()" class="btn" style="color: #fff;text-decoration: none;background:#ff7e00 ;border-radius: 20px;padding: 4px 16px;float: right;">付款</a>
				<div class="btn" id="cancle-order" style="border-radius: 20px;padding: 4px 6px;">取消订单</div>				-->
				<!--<?php
 if($xq_list[0]['status'] == 0){ ?>
				<button class="btn  btn_blank" style="border-radius: 20px;padding: 4px 6px;background:#ff7e00;color: #fff;">申请退款</button>
				<?php
 } ?>-->
			</div>	
			<?php
 if($xq_list[0]['status'] == 0){ ?>
			<div class="daoxiao">
				<p style="font-size: 14px;text-align: center;">请于<span class="yanzhen"></span>之前办理手续。</p>
			</div>
			<?php
 } ?>
		<div class="arrow_mask"></div>
		<script>
			var pdata = $('#pdata').val();
			//alert(pdata);
			var time = $('.ptime').eq(0).text();
			var ptime = time.substring(0, 5);
			//alert(ptime);
			var datatime = pdata + ' ' +ptime;
			//alert(datatime);
			//$(".yanzhen").html(datatime);
			var timestamp2 = Date.parse(new Date(datatime));  			
            timestamp2 = parseInt(timestamp2 / 1000);
            //alert(timestamp2)
            timestamp2=timestamp2-3600;
              function getLocalTime(nS) {  
				 return new Date(parseInt(nS) * 1000).toLocaleString().replace(/:\d{1,2}$/,' ');  
			}
			$(".yanzhen").html(getLocalTime(timestamp2))
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