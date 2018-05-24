<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta content="width=device-width,height=device-height,initial-scale=1.0,maximum-scale=1.0,user-scalable=no" name="viewport" />
		<title>学员信息登记</title>
		<link rel="stylesheet" type="text/css" href="<?php echo ADDON_PUBLIC_PATH;?>/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="<?php echo ADDON_PUBLIC_PATH;?>/font-awesome.min.css">
		<link rel="stylesheet" type="text/css" href="<?php echo ADDON_PUBLIC_PATH;?>/style.css">
		<script src="<?php echo ADDON_PUBLIC_PATH;?>/jquery.min.js"></script>
		<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
		<script src="<?php echo ADDON_PUBLIC_PATH;?>/select.js"></script>
	    <script src="<?php echo ADDON_PUBLIC_PATH;?>/jiao_select.js"></script>	    
	    <style>
	    	/*@font-face {
			  font-family: 'iconfont';
			  src: url('iconfont.eot');
			  src: url('iconfont.eot?#iefix') format('embedded-opentype'),
			  url('<?php echo ADDON_PUBLIC_PATH;?>/iconfont2.woff') format('woff'),
			  url('iconfont.ttf') format('truetype'),
			  url('iconfont.svg#iconfont') format('svg');
			}
			.iconfont{
			  font-family:"iconfont" !important;
			  font-size:20px;font-style:normal;
			  /*color: #ff7e00;*/
			  /*-webkit-font-smoothing: antialiased;
			  -webkit-text-stroke-width: 0.2px;
			  -moz-osx-font-smoothing: grayscale;
			}*/
			@font-face {
	           font-family:'FontAwesome';
	           src:url('<?php echo ADDON_PUBLIC_PATH;?>/font/fontawesome-webfont.eot?v=4.7.0');
	           src:url('<?php echo ADDON_PUBLIC_PATH;?>/font/fontawesome-webfont.eot?#iefix&v=4.7.0') format('embedded-opentype'),url('<?php echo ADDON_PUBLIC_PATH;?>/font/fontawesome-webfont.woff2?v=4.7.0') format('woff2'),url('<?php echo ADDON_PUBLIC_PATH;?>/font/fontawesome-webfont.woff?v=4.7.0') format('woff'),url('<?php echo ADDON_PUBLIC_PATH;?>/font/fontawesome-webfont.ttf?v=4.7.0') format('truetype'),url('<?php echo ADDON_PUBLIC_PATH;?>/font/fontawesome-webfont.svg?v=4.7.0#fontawesomeregular') format('svg');
	           font-weight:normal;
	           font-style:normal
            }
			.right_icon{float: right;margin-right: 0;color: #ddd;}
			 #loading{			 	
				height: 60px;
		   	    width:200px;
		   	    line-height: 60px;
				display:none;
			    position: fixed;			    
			    left: 20%;
			    top: 40%;
			    border-radius: 5px;
			    /*transform: translate(-50%,0);    */
			    background: rgba(0, 0, 0, 0.6);  
			    z-index: 1600;
			    font-size: 18px;
			    color: rgb(255, 255, 255)
		    }
	    </style>
		<script type="text/javascript">
		function checkForm()
        {   

        	// alert($("#card").val());
        	// return false;
        	if($('#mid').val() == ""){
        		alert('对不起,没有获取到您的微信ID,请尝试重新关注公众号！');
        		return false;
        	}
          //if($("#cardUpload").val() == ""){
        	  //alert('请先上传身份证照片！');
        	  //return false;
          //}
          if($("#name").val() == ""){
            alert('姓名不能为空！');
            return false;
          }
          if($("#card").val() == ""){
            alert('请填写身份证号码！');
            return false;
			}   
          if($("#phone").val() == ""){
            alert('请填写手机号码！');
            return false;
          }
          //if($("#addr").val() == ""){
            //alert('请重新上传身份证照片！');
            //return false;
          //}
          //if($("#now_addr").val() == ""){
            //alert('请重新上传身份证照片！');
            //return false;
          //}
          //if($("#birth").val() == ""){
            //alert('请重新上传身份证照片！');
            //return false;
          //}
          if (!isMobile($("#phone").val()))
          {
              alert("电话格式不正确!");
              return false;
          }
//        if($("#jiaxiao").val() == ""){
//        	  alert("请选择驾校!");
//            return false;
//        }
          if($("input[name='jxid']").val() == 0 || $("input[name='jxid']").val() == "0"){
          	 alert("请务必选择搜索出来的驾校!");
             return false;
          }
          if($("input[name='jxid']").val() == ""){
          	  alert("请务必选择搜索出来的驾校!");
              return false;
          }
          if($("input[name='jid']").val() == 0 || $("input[name='jid']").val() == "0"){
          	  alert("请务必选择搜索出来的教练!");
              return false;
          }

          if($("input[name='jid']").val() ==""){
          	  alert("请务必选择搜索出来的教练!");
              return false;
          }
//        if($("#testInput").val() == ""){
//        	  alert("请选择教练!");
//            return false;
//        }
          var data = $("#form").serialize();
          
           // document.write(data)
           // return false;
          $.ajax({
          	url:"<?php echo addons_url('Forms://Wap/xueyuan_add');?>",
          	type:"post",
          	data:data,
          	dataType:"json",
          	success: function(result){
          		// document.write(result)
          		if(result.status == 0){
          			alert(result.msg);
          		}else{
          			alert("信息添加成功！");
          			window.location.href = result.url;
          		}
          	}
          });
//         
        }
        //校验电话：必须以数字开头
        function isMobile(s) 
        {
            var patrn1= /^(([0\+]\d{2,3}-)?(0\d{2,3})-)(\d{7,8})(-(\d{3,}))?$/;
            var patrn=/^(?:13\d|15\d|17\d|18\d|14\d|16\d|19\d|11\d)-?\d{5}(\d{3}|\*{3})$/;
            if(!patrn.exec(s) && !patrn1.exec(s))
            {
                return false;
            }
            return true;
        } 
								
		</script>
		<script type="text/javascript">
			$(function(){
				var regBtn = $("#regBtn");
				$("#regText").change(function(){
					var that = $(this);
					that.prop("checked",that.prop("checked"));
					if(that.prop("checked")){
						regBtn.prop("disabled",false)
					}else{
						regBtn.prop("disabled",true)
					}
				});
			});
		</script>
	</head>
	<body>
		<header><h1 class="bg-primary" style="background: #feca14;">学员信息登记</h1></header>		
		<form action="" id="form" method="post" onsubmit="return checkForm();">			
		<div class="message">
			<span style="color: red;text-align: center;display: block;">温馨提示：请上传正确的身份证信息</span>
			<ul>	
				<li class="row" style="margin-top: 0;">
					<label class="col-sm-2 control-label lab">身份证号<span class="Required">*</span>：</label><br />
					<div class="col-sm-10 ">
						<span class="glyphicon glyphicon-camera camera" id="chooseImage" ></span>
				      	<input type="text" value="" name="card" id="card" style="border: 0;border-radius:0;border-bottom:1px solid #ddd;outline:medium;width: 100%;padding: 5px 0;" >
				      	<!-- <input type="text" value="" name="card" id="card" readonly="readonly" style="border: 0;border-radius:0;border-bottom:1px solid #ddd;outline:medium;width: 100%;padding: 5px 0;" > -->
				      	<input type="hidden" id="fileupload" name="image" value="">
				    </div>
				</li>
			
				<li class="row" style="margin-top: 0;">
					<label class="col-sm-2 control-label lab">姓名<span class="Required">*</span>：</label><br />
					<div class="col-sm-10  ">
				      <input type="text"  id="name" name="name" value="" style="border: 0;border-radius:0;border-bottom:1px solid #ddd;outline:medium;width: 100%;padding: 5px 0;" >
				      <!-- <input type="text"  id="name" name="name" value="" readonly="readonly"  style="border: 0;border-radius:0;border-bottom:1px solid #ddd;outline:medium;width: 100%;padding: 5px 0;" > -->
					  <input type="hidden" id="addr" name="addr" value="">
					  <input type="hidden" id="now_addr" name="now_addr" value="">
				      <input type="hidden" id="birth" name="birth" value="">
				      <input type="hidden" id="mid" name="mid" value="<?php echo ($mid); ?>">
				    </div>
				</li>
				
				<li class="row" style="margin-top: 0;">				
					<label class="col-sm-2 control-label lab">性别<span class="Required">*</span>：</label><br />
					<div class="col-sm-10 clear " id="sex" style="width: 92%;margin-left: 13px;border-bottom: 1px solid #ddd;">
				      <input class="sex" type="radio" name="sex" checked="checked" value="1">男&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				      <input class="sex" type="radio" name="sex" value="2">女
				    </div>
				</li>
				<li class="row" style="margin-top: 0;">
					<label class="col-sm-2 control-label lab">电话<span class="Required">*</span>：</label><br />
					<div class="col-sm-10  ">
				      <input type="number" id="phone" value="phone" name="phone" style="border: 0;border-radius:0;border-bottom:1px solid #ddd;outline:medium;width: 100%;padding:5px 0 ;">
				    </div>
				</li>
				<li class="row" style="margin-top: 0;">
					<label class="col-sm-2 control-label lab">驾校<span class="Required">*</span>：</label><br />				
					<div class="col-sm-10 " style="position: relative;">
				        <input id="jiaxiao"  type="text" name="jiaxiao" style="border-radius:0;position: relative;height: 34px;border: 0;border-bottom:1px solid #ddd;outline:medium;width:100%;outline:medium;padding: 5px 0;">
				        <i class="fa fa-automobile" style="position: absolute;right: 15px;top: 10px;font-size: 28px;"><!--&#xe62c;--></i>
				       <!-- <input id="jia_xiao1"  type="hidden" value="" />-->
						<input type="hidden" id="date2" value="" name="jxid"/>
						<!--<input type="hidden" name="jxid" id="jxid" value="<?php echo ($jxid); ?>">	-->
						<p id="list" style="display:none"><?php echo ($json); ?></p>
					</div>					
				</li>
				<script type="text/javascript">
			        var list = $("#list").text();
			        var datas = eval(list);
					$.selectSuggest('jiaxiao',datas);  
					$("#jiaxiao").bind("change", function(){ 
			 			var id =$("#date2").val();   
			 			//window.location.href = "http://yueche.siwoinfo.com/index.php?s=/addon/Forms/Wap/xueyuan/id/"+id+"";
						$.ajax({
				            type:"post",
				            url:"<?php echo addons_url('Forms://Wap/jiaolian');?>",
				            data:{id:id},
				            dataType:"json",
				            success:function(result){
			//				    document.write(result)
				            	var arr = eval(result);
				            	$.select('testInput',arr); 
				            }
				        });
				  });
 	   			</script>
				<li class="row" style="margin-top: 0;">
					<label class="col-sm-2 control-label lab">教练<span class="Required">*</span>：</label><br />				
					<div class="col-sm-10 " style="position: relative;">
						<input  id="testInput"  name="testInput" type="text" style="border-radius:0;position: relative;height: 34px;border: 0;border-bottom:1px solid #ddd;outline:medium;width:100%;float:left;padding: 5px 0;">						  
					     <i class="fa  fa-user" style="position: absolute;right: 20px;top: 10px;font-size: 28px;"><!--&#xe606;--></i>
					</div>
					<!--<input type="hidden" name="jid" id="jid" value="">		-->		
				</li>
				<input id="date1" type="hidden" value="" name="jid">			
			</ul>
			<div class="agree_submit">
				<input type="checkbox" value="1" name="agree" id="regText" class="agree"/>
				我已阅读并同意<a href="<?php echo addons_url('Forms://Wap/xieyi');?>">《驾校练习协议》</a>
			</div>
			<div class="btn_submit">
				<input type="button" onClick="if(!checkForm())return false;" disabled id="regBtn" class="btn" value="确定" style="width: 53%;margin-left: 23%;font-size:18px;background: #feca14;color: #fff;"/>
			</div>
		</div>
		<div id="loading">
		   <i class="fa fa-spinner fa-pulse" style="margin-right:10px;margin-left:10px;margin-top:10px;color: rgb(255, 255, 255);font-size: 24px;"></i><span>正在识别</span>
	    </div>
		<input type="hidden" name="serverId" value="" id="cardUpload">	
		</form>
		    <script type="text/javascript">
		   		 $(".camera").on("touchstart",function(ev){
		    		$(".camera").css("fontSize","28px");
		    	})
				$(".camera").on('touchend',function(ev){
					$(".camera").css("fontSize","34px");
				})
		    </script>
		    <!-- <script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=5c4733c75d1e10f3053cb384c2569c5c"></script> -->
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
				    	 
					//打开相册列表
					document.querySelector('#chooseImage').onclick = function () {  
						 //
					      wx.chooseImage({  
					      		count: 1, // 默认9
					      		sizeType: ['original', 'compressed'], // 可以指定是原图还是压缩图，默认二者都有
					      		sourceType: ['album', 'camera'], // 可以指定来源是相册还是相机，默认二者都有
						        success: function (res) {  
						         
						          var localId = res.localIds;//返回相册列表  
						          // alert(localId)
								  wx.uploadImage({
								     localId: localId[0], // 需要上传的图片的本地ID，由chooseImage接口获得
								     isShowProgressTips: 1,// 默认为1，显示进度提示
								     success: function (res) {
								     	 $("#loading").css("display","block");
								     	//$("#loading").css("display","none");
								        var serverId = res.serverId; //返回图片的服务器端ID
								         //alert(serverId)
				        				if(serverId){
								    		$.ajax({
									            type:"post",
									            url:"<?php echo addons_url('Forms://Wap/readCard');?>",
									            data:{serverId:serverId},
									            dataType:"json",
									            success:function(data){
									            	//
									            	//alert(data);
									            	// document.write(data)
													var name = data.name;
													var card = data.num;
													var sex = data.sex;
													var addr = data.address;
													var birth = data.birth;
													var status = data.success;
													// alert(status)
													if(status == true){
														$("#cardUpload").val(serverId);
														$("#name").val(name);
														$("#card").val(card);
														$("#addr").val(addr);
														$("#now_addr").val(addr);
														$("#birth").val(birth);
														
														var sexhtml = "";
														if(sex == '男'){
															sexhtml += '<input class="sex" type="radio" name="sex" checked="checked" value="1">男&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
											      			sexhtml += '<input class="sex" type="radio" name="sex" value="2">女';
														}else if(sex == '女'){
															sexhtml += '<input class="sex" type="radio" name="sex" value="1">男&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
											      			sexhtml += '<input class="sex" type="radio" name="sex" checked="checked" value="2">女';
														}
														$("#loading").css("display","none");
														$("#sex").html(sexhtml);
														
													}else{
														$("#cardUpload").val('');
														alert("获取不到身份证信息！");
														$("#loading").css("display","none");
													}
									            }
									        });
				        				}else{
				        					alert('请重新上传身份证照片！');
				        				}
								     }

								 }); 
						        }  
					      });
					    }; 
					wx.error(function(res){
					  	alert("请在微信客户端打开");
					});
				 }); 
				  
			</script>
	</body>

</html>