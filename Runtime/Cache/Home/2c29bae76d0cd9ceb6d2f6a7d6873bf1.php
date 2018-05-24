<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

	<head>
		<meta charset="UTF-8">
		<meta http-equiv="pragma" content="no-cache">  
		<meta http-equiv="cache-control" content="no-cache">  
		<meta http-equiv="expires" content="0"> 
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta content="width=device-width,height=device-height,initial-scale=1.0,maximum-scale=1.0,user-scalable=no" name="viewport" />
		<title>订单详情</title>
		<link rel="stylesheet" type="text/css" href="<?php echo ADDON_PUBLIC_PATH;?>/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="<?php echo ADDON_PUBLIC_PATH;?>/style3.css">
		<script src="<?php echo ADDON_PUBLIC_PATH;?>/jquery.min.js" type="text/javascript"></script>
		<style>
		    header{width: 100%;height: 100px;background: #ff7e00;color: #fff;}
		    .poy_left{float: left;margin-left: 10%;margin-top: 7%;}
		    .poy_left span{display: inline-block}
		    .poy_right{float: right;width: 80px;height: 60px;margin-top: 7%;margin-right: 10%;}	
		    .yuyue_name{height: 30px;padding:5px 10px;background: #fff;}	  
		    .yuyue_name span{display: inline-block}
		    .kaoshi{height: 40px;padding:10px;background: #fff;}
		    .jia_name{float: left;}
		    .red {color:#ff7e00;float: right;font-size: 16px;}
		    .name{float: left;}  
		    .phone{float: right;}
			.data_time i{float: left;}
			.data_dian{float: left;}
			/*.data_dian span{width: 80px;margin-right: 20px;} */
			.zuihou{height: 80px;background: #fff;margin-top: 10px;/*padding:10px;*/}
			.zuihou p{padding-left:0;padding-right:0;font-size:13px;border-bottom:1px dashed #ddd; margin-right:0;width:100%;margin-bottom: 5px;margin-top:0;text-align: center;margin-left:0}
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
		    .daoxiao{height: 40px;background: #fff;margin-top: 10px;padding:0px 10px 10px;line-height: 30px;margin-bottom: 10px;}
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
						window.location.href = "http://yueche.siwoinfo.com/index.php?s=/addon/Forms/Wap/index/forms_id/13/publicid/1.html"; 
						// $.ajax({
				  //           type:"post",
				  //           url:"<?php echo addons_url('Forms://Wap/Dingdan');?>",
				  //           dataType:"json",
				  //           success:function(result){
				  //           	// document.write(result)
	    	// 	            	if(result.status == 0){
	    	// 	            		alert(result.msg);
	    	// 	            	}else{
	    	//     					window.location.href = result.url;
	    	// 	            	}
				  //           }
				  //       });
					}else{
						// alert(res.err_msg);
						alert('支付失败');
						return false;
					}
				}
			);
		}

		function callpay(){
			
		    // var r=confirm("上车必须要有教练跟随");
		    var r=confirm("请注意:支付完成之后请务必点击完成或点击返回商家,看到支付完成后请点击确定,否则无法正常显示您的订单信息！");
			if (r==true){
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
		    }else{
		    	
		    }
		}    
		</script>
		
	<body style="background: #eee;">
		<?php
 if($datatime){ ?>
		<header>			
			<div class="poy_left">
			    <span style="font-size: 16px;">等待付款</span>
			    <div class="time-item1">剩
					<span id="minute_show1">00分</span>
					<span id="second_show1">00秒</span>自动关闭
				</div>
			</div>
			<img src="<?php echo ADDON_PUBLIC_PATH;?>/zhifu.png" alt="正在加载中" class="poy_right"/>
		</header>
		<div class="yuyue_name">
			<span class="name">预约人：<?php echo ($w_list[0]['xname']); ?></span>
			<span class="phone"><?php echo ($w_list[0]['xphone']); ?></span>
		</div>
		<?php  foreach($peop_list as $k => $v){ foreach($v as $h => $g){ ?>
			<div class="yuyue_name">
				<span class="name">预约人：<?php echo $g['xname'];?></span>
				<span class="phone"><?php echo $g['xphone'];?></span>
			</div>
		<?php
 } } ?>

		
		<div class="pay" style="margin-top: 10px;">
			<div class="kaoshi">
				<div class="jia_name"><img src="<?php echo ADDON_PUBLIC_PATH;?>/jiakao.jpg" alt="正在加载中" style="width: 20px;height: 20px;float: left;margin-right: 10px;"><span>考试中心</span><i class="iconfont">&#xe65f;</i></div>
				<span class="red">等待付款</span>
			</div>
			<!-- <p class="detail">订单详情</p> -->
			<div class="pay_row" style="background: #eee;margin-bottom: 0;">
				<div class="pay_detail row"  style="background: #eee;">
					<img src="<?php echo ADDON_PUBLIC_PATH;?>/jiakao.jpg" alt="正在加载中" class="col-sm-3 show" style="width: 20%;height: 60px;margin-bottom:0;float: left;padding: 0;" />
					<div class="col-sm-9 car_number">
					<input type="hidden" name="wid" value="<?php echo ($w_list[0]['id']); ?>">
					<input type="hidden" name="datatime" value="<?php echo ($datatime); ?>">						
						<span>车号：<?php echo ($p_list[0][0]['ch']); ?></span>
						<span>日期：<?php echo ($p_list[0][0]['data']); ?></span>
						<span style="color:#ff7e00;">单价：￥150.00</span>
						<!--<span>总价：￥<?php echo ($w_list[0]['money']); ?>.00</span>		-->											
					</div>
				</div>
			</div>	
			    <div class="order_number" style="background: #fff;padding: 10px;">
					<div class="data_time" style="float: left;margin-bottom: 0;">
						<i>预约时间：</i>
						<div class="data_dian" style="margin-bottom: 0;">
						<?php  foreach($p_list as $k=>$v){ foreach($v as $h=>$g){ ?>
							<span class='datq' style="width:92px;color:#ff7e00;float: left;margin-right: 1px;font-weight: 700;word-wrap:break-word;margin-right: 5px;"><?php echo $g['time']; ?></span>
						<?php
 } } ?>
						<?php if(is_array($p_list)): foreach($p_list as $k=>$v): ?><span style="margin-bottom: 0;height: 0;display: none;"><?php echo ($v["time"]); ?></span><?php endforeach; endif; ?>
						</div>
					</div><br />
					<span>订单编号：<?php echo ($w_list[0]['dbh']); ?></span>
					<span>下单时间：<?php echo ($w_list[0]['addtime']); ?></span>
				</div>			
				<div class="zuihou">
					<p style="text-align: center;">共<?php echo ($w_list[0]['num']); ?>个小时 合计：￥<?php echo ($w_list[0]['money']); ?>.00</p>
					<a onclick="callpay()" class="btn" style="color: #fff;text-decoration: none;background:#ff7e00 ;float: right;margin-right: 10px;">付款</a>
					<div class="btn" id="cancle-order" onclick="show_confirm()">取消订单</div>				
				</div>
				<div class="daoxiao">
					<p style="font-size: 14px;text-align: center;">请于<span class="yanzhen"></span>之前办理手续。</p>
			   </div>
				<input type="hidden" value="<?php echo ($p_list[0][0]['data']); ?>" id="datw"/>
				 <script>
				     var pdata=$("#datw").val();
			        //alert($("#datw").val());
				   	var time=$(".datq").text();
				   	//alert($(".datq").text());
				   	var ptime = time.substring(0, 5);
			        //alert(ptime);
					var datatime = pdata + ' ' +ptime;
					//alert(datatime)
					var timestamp2 = Date.parse(new Date(datatime));  			
		            timestamp2 = parseInt(timestamp2 / 1000);
		            //alert(timestamp2)
		            timestamp2=timestamp2-3600;
		            //alert(timestamp2);
		              function getLocalTime(nS) {  
						 return new Date(parseInt(nS) * 1000).toLocaleString().replace(/:\d{1,2}$/,' ');  
						} 
					//alert(getLocalTime(timestamp2))
				   	$(".yanzhen").text(getLocalTime(timestamp2));
				   </script>
					<script>
					$(function() {
					  	function time(){					  	
		                    //获取下单时间
						  	var startime = $("input[name='datatime']").val();
						  	//获取5分钟过期时间
						  	var endtime =parseInt(startime)+900;
						  	//获取当前时间
							var dangqiantime = parseInt(new Date().getTime()/1000);	
	                        //当前时间减去过期时间
							var leftTime=endtime-dangqiantime;
							//setInterval(function(){
								if(leftTime>2){							    
									var minute=Math.floor(leftTime/60); 
									//alert(minute);
									var second=Math.floor(leftTime-minute*60); 
									if(minute <= 9) minute = '0' + minute;
									if(second <= 9) second = '0' + second;
									$('#minute_show1').html('<s></s>' + minute + '分');
									$('#second_show1').html('<s></s>' + second + '秒');
									leftTime--;
								}else{
									//$("body").html('');
									clearInterval(te);									
									var wid = $("input[name='wid']").val();
						    		$.ajax({
							            type:"post",
							            url:"<?php echo addons_url('Forms://Wap/Qxdingdan');?>",
							            data:{wid:wid},
							            dataType:"json",
							            success:function(result){
		            		            	if(result.status == 0){
		            		            		alert(result.msg);
		            		            	}else{		            		            		
		            	    					window.location.href = result.url;
		            		            	}
							            }
							          });
								}
							//},1000);
						}
//					  	$(function(){
							time();
							var te=setInterval(time,1000)
//						});
					})					  
					</script>
		<script>
		    function show_confirm(){
				var r=confirm("你确定要取消该订单吗？");
				if (r==true){
				    var wid = $("input[name='wid']").val();
		    		$.ajax({
			            type:"post",
			            url:"<?php echo addons_url('Forms://Wap/Qxdingdan');?>",
			            data:{wid:wid},
			            dataType:"json",
			            success:function(result){
     		            	if(result.status == 0){
     		            		alert(result.msg);
     		            	}else{
     		            		//alert("订单取消成功！");
     	    					window.location.href = result.url;
     		            	}
			            }
			        });
				}
				else{
				    
				}
			}
		</script>
		<?php  }else{ ?>
		<div style="width: 100%;height: 100%;background: #eee;">
			<p style="font-size: 16px;margin-top: 50%;margin-left: 30%;">您还没有订单哦!</p>
		</div>
		<?php
 } ?>
		<div class="arrow_mask"></div>
	</body>

</html>