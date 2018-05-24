<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta content="width=device-width,height=device-height,initial-scale=1.0,maximum-scale=1.0,user-scalable=no" name="viewport" />
		<link rel="stylesheet" type="text/css" href="<?php echo ADDON_PUBLIC_PATH;?>/bootstrap.min.css">
		<title>退款详情</title>
		<script src="<?php echo ADDON_PUBLIC_PATH;?>/jquery.min.js" type="text/javascript"></script>

		<style>
			.tuikuan{background: #fff;padding: 10px 10px 5px;}
			.tuikuan label{margin-bottom:10px ;color: #6c6c6c;}
			.tuikuan p{border-bottom: 1px solid #aeaeae;}
			.tuikuan div{margin-bottom: 15px;}
			.tuikuan div:last-child{margin-bottom: 0;}
			.tuikuan input{border:0;border-bottom: 1px solid #aeaeae;width: 100%;padding: 5px}
			 header h1{margin: 0;font-size: 18px;height: 40px;line-height: 40px;text-align: center;}
			.zuihou{height: 40px;background: #fff;margin-top: 10px;padding:0px 10px 10px;margin-bottom: 10px;line-height: 40px;color:red ;}
			.zuihou p{margin-bottom: 5px;margin-top:0;text-align: right;}
		</style>
	</head>
	<body style="background: #eee;">
		<header>
			<h1 class="bg-primary" style="background: #feda60;">退款详情</h1>
		</header>
		<div class="tuikuan">
			<div>
				<label>预约车辆：</label>
				<p><?php echo ($list['pch']); ?></p>
			</div>
			<div>
				<label>微信订单号：</label>
				<p><?php echo ($list['transaction_id']); ?></p>
			</div>
			<div>
				<label>商户订单号：</label>
				<p><?php echo ($list['out_trade_no']); ?></p>
			</div>
			<div>
				<label>订单总金额：</label>
				<p>￥<?php echo ($list['money']); ?></p>
			</div>
			<div>
				<label>实付款：</label>
				<p>￥<?php echo ($list['money']); ?></p>
			</div>
			<!--<div>
				<label>应退金额：</label>
				<p>￥<span class="tui"></span></p>
			</div>-->
			<div>
				<label>下单时间：</label>
				<p><?php echo ($list['daddtime']); ?></p>
			</div>
			<div>
				<label>预约时间段：</label>
				<?php  $arr = explode(',',$list['ptime']); foreach($arr as $v){ ?>
					<p class="ptime"><?php echo $v; ?></p>
				<?php
 } ?>
			</div>
			<input type="hidden" name="pdata" id="pdata" value="<?php echo ($list['pdata']); ?>"/>
			<input type="hidden" name="id" id="id" value="<?php echo ($list['id']); ?>">
			<div>
				<label>退款说明：</label>
				<input type="text" placeholder="请输入退款说明" name="twark" id="twark" value="" style="border-radius: 0;">
			</div>
		</div>
		<div class="zuihou">
				<!-- <input type="hidden" name="" id="xiaoshi" value="<?php echo ($v["money"]); ?>"> -->
			<p id="shouxu" style="display: inline-block;float: left;">扣除手续费：￥<span class="xu"></span></p>
			<p id="yingtui" style="display: inline-block;float: right;">应退金额 ：￥ <span class="tui"></span></p>
		</div>		
		<button class="btn" style="margin: 20px 0;width: 53%;font-size:18px;color:#fff;margin-left: 23%; background: #feda60;">提交申请</button>
		<script type="text/javascript">
	        var pdata = $('#pdata').val();
	        pdata = pdata.replace(/-/g,'/');// 将-替换成/，因为下面这个构造函数只支持/分隔的日期字符串
	        //alert(pdata)
			var time = $('.ptime').eq(0).text();
			var ptime = time.substring(0, 5);
			var datatime = pdata + ' ' +ptime;
			//alert(datatime)
			//获取预约用车的时间戳(S为单位)
			var timestamp2 = Date.parse(new Date(datatime));  			
            timestamp2 = parseInt(timestamp2 / 1000); 
			// 获取当前时间戳(以s为单位)  
			var timestamp = new Date().getTime(); 			
			timestamp = parseInt(timestamp / 1000); 
			//alert(timestamp)
			var timecha=timestamp2-timestamp;
			//alert(timecha);
			var zongshu =<?php echo ($list['money']); ?>;
			if(timecha>43200){
				$(".tui").text(zongshu);
			  //alert(1);
			    $(".xu").text(0)
			}else if(timecha<43200&&timecha>21600){
				$(".xu").text(zongshu*5/100)
				var tui = zongshu-zongshu*5/100;
				$(".tui").text(tui);
			}else if(timecha>3600&&timecha<21600){
				$(".xu").text(zongshu*20/100)
				var tui = zongshu-zongshu*20/100;
				$(".tui").text(tui);
			}else if(timecha<=3600){
				//alert("半小时之内不予退款!");
				//return false;
				$(".xu").text(zongshu)
				$(".tui").text(0);
			}
			$('.btn').click(function(){
				var id = $('#id').val();
				var twark = $('#twark').val();				
				// alert(twark);
				var koufei=$(".xu").text();
				//alert(refund_fee);
				var refund_fee=$(".tui").text();
				//alert(koufei)
				// return false;
				if(refund_fee==0){
					alert("1小时以内不予退费!");
					return false;
				}
				if(twark == ''){
					alert('退费原因不能为空!');
					return false;
				}
				if(id){
					$.ajax({
			            type:"post",
			            url:"<?php echo addons_url('Forms://Wap/addtuikuan');?>",
			            data:{id:id,twark:twark,refund_fee:refund_fee,koufei:koufei},
			            dataType:"json",
			            success:function(result){
			            	// document.write(result)
    		            	if(result.status == 0){
    		            		alert(result.msg);
    		            	}else{
    		            		alert('退款申请已提交');
    	    					window.location.href = result.url;
    		            	}
			            }
			        });
				}
			});
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