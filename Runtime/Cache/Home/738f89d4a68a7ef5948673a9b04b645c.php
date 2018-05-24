<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta content="width=device-width,height=device-height,initial-scale=1.0,maximum-scale=1.0,user-scalable=no" name="viewport" />
		<title>学员信息登记</title>
		<link rel="stylesheet" type="text/css" href="<?php echo ADDON_PUBLIC_PATH;?>/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="<?php echo ADDON_PUBLIC_PATH;?>/style.css">
		<script src="<?php echo ADDON_PUBLIC_PATH;?>/jquery.min.js"></script>
	    <script src="<?php echo ADDON_PUBLIC_PATH;?>/jiao_select.js"></script>
		<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
		<script type="text/javascript">
		function checkForm()
        {      
          if($("#phone").val() == ""){
            alert('请填写手机号码！');
            return false;
          }
          if (!isMobile($("#phone").val()))
          {
              alert("电话格式不正确!");
              return false;
          }
          if($("#jiaolian").val() == ""){
          	  alert("请选择教练!");
              return false;
          }
         if($("#jiaolian").val() == 0 || $("#jiaolian").val() == "0"){
          	  alert("请务必选择搜索出来的教练!");
              return false;
          }
          var id = $("#date1").val();         
          var data = $("#form").serialize();
          //document.write(data)
          $.ajax({
          	url:"<?php echo addons_url('Forms://Wap/editxueyuan');?>",
          	type:"post",
          	dataType:"json",
          	data:data,
          	success: function(result){
          		if(result.status == 0){
          			alert(result.msg);
          		}else{
          			alert("信息修改成功！");
          			window.location.href = result.url;
          		}
          	}
          });
           
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
			<ul>	
				<li class="row" style="margin-top: 0;">
					<label class="col-sm-2 control-label lab">身份证号<span class="Required">*</span>：</label>
					<div class="col-sm-10  ">
						<!-- <span class="glyphicon glyphicon-camera camera" id="chooseImage"></span> -->
				      	<input type="text" value="<?php echo ($list['xcard']); ?>" name="card" id="card" disabled="disabled" style="border: 0;-webkit-appearance:none;border-radius:0;border-bottom:1px solid #ddd;outline:medium;width: 100%;padding: 5px 0;">
				      	<!-- <input type="hidden" id="fileupload" name="image" value=""> -->
				      	<input type="hidden" name="id" id="id" value="<?php echo ($list['id']); ?>">
				    </div>
				</li>
			
				<li class="row" style="margin-top: 0;">
					<label class="col-sm-2 control-label lab">姓名<span class="Required">*</span>：</label>
					<div class="col-sm-10  ">
				      <input type="text"  id="name" name="name" value="<?php echo ($list['xname']); ?>" disabled="disabled" style="border: 0;-webkit-appearance:none;border-radius:0;border-bottom:1px solid #ddd;outline:medium;width: 100%;padding: 5px 0;">
				    </div>
				</li>
				
				<li class="row" style="margin-top: 0;">
					<label class="col-sm-2 control-label lab">性别<span class="Required">*</span>：</label><br />
					<div class="col-sm-10  clear" id="sex" style="width: 92%;margin-left: 13px;border-bottom: 1px solid #ddd;">
					<?php  if($list['xsex'] == 1){ ?>
					<input class="sex" type="radio" name="sex" value="1" checked="checked">男&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<?php
 }else{ ?>
					 <input class="sex" type="radio" name="sex" value="2" checked="checked">女
					<?php
 } ?>
				      
				     
				    </div>
				</li>
				<li class="row" style="margin-top: 0;">
					<label class="col-sm-2 control-label lab">电话<span class="Required">*</span>：</label>
					<div class="col-sm-10  ">
				      <input type="number" id="phone" value="<?php echo ($list['xphone']); ?>" name="phone" style="border: 0;-webkit-appearance:none;border-radius:0;border-bottom:1px solid #ddd;outline:medium;width: 100%;padding: 5px 0;">
				    </div>
				</li>
				<li class="row" style="margin-top: 0;">
					<label class="col-sm-2 control-label lab">驾校：</label>
					<div class="col-sm-10  ">
				     <input type="text" id="jiaxiao" value="<?php echo ($list['jxname']); ?>" name="jiaxiao" disabled="disabled" style="border: 0;-webkit-appearance:none;border-radius:0;border-bottom:1px solid #ddd;outline:medium;width: 100%;padding: 5px 0;">
				    </div>
				</li>
				<li class="row" style="margin-top: 0;">
					<label class="col-sm-2 control-label lab">教练：</label>
					<div class="col-sm-10  ">
				     <input type="text" id="jiaolian" value="<?php echo ($list['jname']); ?>" name="jiaolian" style="border: 0;-webkit-appearance:none;border-radius:0;border-bottom:1px solid #ddd;outline:medium;width: 100%;padding: 5px 0;">
				    </div>
				    <p id="list" style="display:none"><?php echo ($json); ?></p>
				    <input type="hidden" id="date1" value="" name="jl_id"/>
				</li>
				<script type="text/javascript">
			        var list = $("#list").text();
			       // document.write(list)
			        var datas = eval(list);
					$.select('jiaolian',datas);  
 	   			</script>
			</ul>
<!-- 			<div class="agree_submit">
				<input type="checkbox" value="1" name="agree" id="regText" class="agree"/>
				我已阅读并同意<a href="#">《驾校练习协议》</a>
			</div> -->
			<div class="btn_submit" style="margin-bottom: 20px;">
				<input type="button" onClick="if(!checkForm())return false;" class="btn " value="确定" style="width: 53%;margin-left: 23%;font-size:18px;background: #feca14;color: #fff;"/>
			</div>
		</div>
		</form>
		    <script type="text/javascript">
		   		 $(".camera").on("touchstart",function(ev){
		    		$(".camera").css("fontSize","28px");
		    	})
				$(".camera").on('touchend',function(ev){
					$(".camera").css("fontSize","34px");
				})

		    </script>
	</body>

</html>