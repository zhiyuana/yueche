<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
	<meta charset="UTF-8">
<meta content="<?php echo C('WEB_SITE_KEYWORD');?>" name="keywords"/>
<meta content="<?php echo C('WEB_SITE_DESCRIPTION');?>" name="description"/>
<link rel="shortcut icon" href="<?php echo SITE_URL;?>/favicon.ico">
<title><?php echo empty($page_title) ? C('WEB_SITE_TITLE') : $page_title; ?></title>
<link href="/Public/static/font-awesome/css/font-awesome.min.css?v=<?php echo SITE_VERSION;?>" rel="stylesheet">
<link href="/Public/Home/css/base.css?v=<?php echo SITE_VERSION;?>" rel="stylesheet">
<link href="/Public/Home/css/module.css?v=<?php echo SITE_VERSION;?>" rel="stylesheet">
<link href="/Public/Home/css/weiphp.css?v=<?php echo SITE_VERSION;?>" rel="stylesheet">
<link href="/Public/static/emoji.css?v=<?php echo SITE_VERSION;?>" rel="stylesheet">
<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
<script src="/Public/static/bootstrap/js/html5shiv.js?v=<?php echo SITE_VERSION;?>"></script>
<![endif]-->

<!--[if lt IE 9]>
<script type="text/javascript" src="/Public/static/jquery-1.10.2.min.js"></script>
<![endif]-->
<!--[if gte IE 9]><!-->
<script type="text/javascript" src="/Public/static/jquery-2.0.3.min.js"></script>
<!--<![endif]-->
<script type="text/javascript" src="/Public/static/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/Public/static/uploadify/jquery.uploadify.min.js"></script>
<script type="text/javascript" src="/Public/static/zclip/ZeroClipboard.min.js?v=<?php echo SITE_VERSION;?>"></script>
<script type="text/javascript" src="/Public/Home/js/dialog.js?v=<?php echo SITE_VERSION;?>"></script>
<script type="text/javascript" src="/Public/Home/js/admin_common.js?v=<?php echo SITE_VERSION;?>"></script>
<script type="text/javascript" src="/Public/Home/js/admin_image.js?v=<?php echo SITE_VERSION;?>"></script>
<script type="text/javascript" src="/Public/static/masonry/masonry.pkgd.min.js"></script>
<script type="text/javascript" src="/Public/static/jquery.dragsort-0.5.2.min.js"></script> 
<script type="text/javascript">
var  IMG_PATH = "/Public/Home/images";
var  STATIC = "/Public/static";
var  ROOT = "";
var  UPLOAD_PICTURE = "<?php echo U('home/File/uploadPicture',array('session_id'=>session_id()));?>";
var  UPLOAD_FILE = "<?php echo U('File/upload',array('session_id'=>session_id()));?>";
var  UPLOAD_DIALOG_URL = "<?php echo U('home/File/uploadDialog',array('session_id'=>session_id()));?>";
</script>
<!-- 页面header钩子，一般用于加载插件CSS文件和代码 -->
<?php echo hook('pageHeader');?>

</head>
<body>
	<!-- 头部 -->
	<!-- 提示 -->
<div id="top-alert" class="top-alert-tips alert-error" style="display: none;">
  <a class="close" href="javascript:;"><b class="fa fa-times-circle"></b></a>
  <div class="alert-content"></div>
</div>
<!-- 导航条
================================================== -->
<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="wrap">
    
       <a class="brand" title="<?php echo C('WEB_SITE_TITLE');?>" href="<?php echo U('index/index');?>">
       <?php if(!empty($userInfo[website_logo])): ?><img height="52" src="<?php echo (get_cover_url($userInfo["website_logo"])); ?>"/>
       	<?php else: ?>
       		<img height="52" src="/Public/Home/images/logo.png"/><?php endif; ?>
       </a>
        <?php if(is_login()): ?><div class="switch_mp">
            	<?php if(!empty($public_info["public_name"])): ?><a href="#"><?php echo ($public_info["public_name"]); ?><b class="pl_5 fa fa-sort-down"></b></a><?php endif; ?>
                <ul>
                <?php if(is_array($myPublics)): $i = 0; $__LIST__ = $myPublics;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li><a href="<?php echo U('home/index/main', array('publicid'=>$vo[mp_id]));?>"><?php echo ($vo["public_name"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
                </ul>
            </div><?php endif; ?>
      <?php $index_2 = strtolower ( MODULE_NAME . '/' . CONTROLLER_NAME . '/*' ); $index_3 = strtolower ( MODULE_NAME . '/' . CONTROLLER_NAME . '/' . ACTION_NAME ); ?>
       
            <div class="top_nav">
                <?php if(is_login()): ?><ul class="nav" style="margin-right:0">
                    	<?php if($myinfo["is_init"] == 0 ): ?><li><p>该账号配置信息尚未完善，功能还不能使用</p></li>
                    		<?php elseif($myinfo["is_audit"] == 0 and !$reg_audit_switch): ?>
                    		<li><p>该账号配置信息已提交，请等待审核</p></li>
                            <?php elseif($index_2 == 'home/public/*' or $index_3 == 'home/user/profile' or $index_2 == 'home/publiclink/*' or $index_3 == 'home/user/bind_login'): ?>
                    		
                    		<?php else: ?> 
                            
                    		<?php if(is_array($core_top_menu)): $i = 0; $__LIST__ = $core_top_menu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ca): $mod = ($i % 2 );++$i;?><li data-id="<?php echo ($ca["id"]); ?>" class="<?php echo ($ca["class"]); ?>"><a href="<?php echo ($ca["url"]); ?>"><?php echo ($ca["title"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; endif; ?>
                    	
                    	
                        
                        <li class="dropdown admin_nav">
                            <a href="#" class="dropdown-toggle login-nav" data-toggle="dropdown" style="">
                                <?php if(!empty($myinfo[headimgurl])): ?><img class="admin_head url" src="<?php echo ($myinfo["headimgurl"]); ?>"/>
                                <?php else: ?>
                                    <img class="admin_head default" src="/Public/Home/images/default.png"/><?php endif; ?>
                                <?php echo (getShort($myinfo["nickname"],4)); ?><b class="pl_5 fa fa-sort-down"></b>
                            </a>
                            <ul class="dropdown-menu" style="display:none">
                               <?php if($mid==C('USER_ADMINISTRATOR')): ?><li><a href="<?php echo U ('Admin/Index/Index');?>" target="_blank">后台管理</a></li><?php endif; ?>
                            	<li><a href="<?php echo U ('Home/Public/lists');?>">公众号列表</a></li>
                                <li><a href="<?php echo U ('Home/Public/add');?>">账号配置</a></li>
                                <li><a href="<?php echo U('User/profile');?>">修改密码</a></li>
                                <li><a href="<?php echo U('User/logout');?>">退出</a></li>
                            </ul>
                        </li>
                    </ul>
                <?php else: ?>
                    <ul class="nav" style="margin-right:0">
                    	<li style="padding-right:20px">你好!欢迎来到<?php echo C('WEB_SITE_TITLE');?></li>
                        <li>
                            <a href="<?php echo U('User/login');?>">登录</a>
                        </li>
                        <li>
                            <a href="<?php echo U('User/register');?>">注册</a>
                        </li>
                        <li>
                            <a href="<?php echo U('admin/index/index');?>" style="padding-right:0">后台入口</a>
                        </li>
                    </ul><?php endif; ?>
            </div>
        </div>
</div>
	<!-- /头部 -->
	
	<!-- 主体 -->
	
<?php  if(!is_login()){ Cookie ( '__forward__', $_SERVER ['REQUEST_URI'] ); redirect(U('home/user/login',array('from'=>4))); } ?>
<div id="main-container" class="admin_container">
  <?php if(!empty($core_side_menu)): ?><div class="sidebar">
      <ul class="sidenav">
        <li>
          <?php if(!empty($now_top_menu_name)): ?><a class="sidenav_parent" href="javascript:;"> 
            <!--<img src="/Public/Home/images/left_icon_<?php echo ($core_side_category["left_icon"]); ?>.png"/>--> 
            <?php echo ($now_top_menu_name); ?></a><?php endif; ?>
          <ul class="sidenav_sub">
            <?php if(is_array($core_side_menu)): $i = 0; $__LIST__ = $core_side_menu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li class="<?php echo ($vo["class"]); ?>" data-id="<?php echo ($vo["id"]); ?>"> <a href="<?php echo ($vo["url"]); ?>"> <?php echo ($vo["title"]); ?> </a><b class="active_arrow"></b></li><?php endforeach; endif; else: echo "" ;endif; ?>
          </ul>
        </li>
        <?php if(!empty($addonList)): ?><li> <a class="sidenav_parent" href="javascript:;"> <img src="/Public/Home/images/ico1.png"/> 其它功能</a>
            <ul class="sidenav_sub" style="display:none">
              <?php if(is_array($addonList)): $i = 0; $__LIST__ = $addonList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li class="<?php echo ($navClass[$vo[name]]); ?>"> <a href="<?php echo ($vo[addons_url]); ?>" title="<?php echo ($vo["description"]); ?>"> <i class="icon-chevron-right">
                  <?php if(!empty($vo['icon'])) { ?>
                  <img src="<?php echo ($vo["icon"]); ?>" />
                  <?php } ?>
                  </i> <?php echo ($vo["title"]); ?> </a> </li><?php endforeach; endif; else: echo "" ;endif; ?>
            </ul>
          </li><?php endif; ?>
      </ul>
    </div><?php endif; ?>
  <div class="main_body">
    
 
  <div class="span9 page_message">
     
    <section id="contents"> <ul class="tab-nav nav">
  <?php if(is_array($nav)): $i = 0; $__LIST__ = $nav;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li class="<?php echo ($vo["class"]); ?>"><a href="<?php echo ($vo["url"]); ?>"><?php echo ($vo["title"]); ?><span class="arrow fa fa-sort-up"></span></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
  
  <?php if (defined ( '_ADDONS' )) { $page = _ADDONS . '_' . _CONTROLLER . '_' . _ACTION; } else { $page = MODULE_NAME . '_' . CONTROLLER_NAME . '_' . ACTION_NAME; } $url = 'http://help.weiphp.cn/index.php?s=/Home/Help/index/page/' . strtolower($page); ?>
  <!-- <span class="fr" style="margin:10px;"><a target="_blank" href="<?php echo ($url); ?>"><b style="font-size:16px;" class="fa fa-question-circle"></b>查看配置教程</a></span> -->
</ul>
<?php if(!empty($sub_nav)): ?><div class="sub-tab-nav">
       <ul class="sub_tab">
       <?php if(is_array($sub_nav)): $i = 0; $__LIST__ = $sub_nav;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li><a class="<?php echo ($vo["class"]); ?>" href="<?php echo ($vo["url"]); ?>"><?php echo ($vo["title"]); ?><span class="arrow fa fa-sort-up"></span></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
      </ul>
</div><?php endif; ?>
<?php if(!empty($normal_tips)): ?><p class="normal_tips"><b class="fa fa-info-circle"></b> <?php echo ($normal_tips); ?></p><?php endif; ?>
       <div class="tab-content"> 
    <!-- <script type="text/javascript" src="/Public/static/fabu/js/jquery-1.10.1.min.js"></script> -->
    <!-- <script src="http://libs.baidu.com/jquery/2.1.1/jquery.min.js"></script> -->
    <script type="text/javascript" src="/Public/static/fabu/js/ajaxfileupload.js"></script>

   <script type="text/javascript">
	  function checkForm()
	{   
	  if($("#name").val() == ""){
		alert('请填写姓名！');
		return false;
	  }
	  if($("#age").val() == ""){
		alert('请填写年龄！');
		return false;
	  }
	  if($("#sex1").is(':checked') == false && $("#sex2").is(':checked') == false){
		alert('请先选择性别！');
		return false;
	  }
	  if($("#card").val() == ""){
		alert('请填写身份证号码！');
		return false;
	  }
	  
	  if($("#jbh").val() == ""){
		alert('请填写驾驶证号码！');
		return false;
	  }
	  if($("#tbh").val() == ""){
		alert('请填写教练证号码！');
		return false;
	  }   
	  if($("#phone").val() == ""){
		alert('请填写手机号码！');
		return false;
	  }
	  if (!isMobile($("#phone").val()))
	  {
		  alert("手机格式不正确!");
		  return false;
	  }
	  if($("#jl").val() == ""){
		alert('请填写驾龄！');
		return false;
	  }
    if($("#jxid").val() == "" || $("#jxid").val() == 0){
      alert('请选择驾校！');
      return false;
    }
	 //  if($("#card_path").val() == 0){
		// alert('请上传身份证照片！');
		//  return false;
	 //  }
	 //  if($("#jiashi_path").val() == 0){
		// alert('请上传驾驶证照片！'); 
		// return false;
	 //  }
	 //  if($("#jiaolian_path").val() == 0){
		// alert('请上教练证照片！');
		//  return false;
	 //  }
	  
	   
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

  <form action="<?php echo U('Jiaolian/jiaolian_insert');?>" method="post" onsubmit="return checkForm();" >
	<!-- <form action="<?php echo U('Jiaolian/jiaolian_insert');?>" method="post" > -->
       <div>
	        <div style="width:47%;margin-right: 20px;float: left;">
	            <label><span class="need_flag">*</span>姓名：</label>               
	            <input type="text" class="text input-large" id="name" name="jname" value=""
	            style="border-radius: 5px;float: right;width: 344px;"><br>
	        </div>
	        <div style="width:47%;margin-right: 20px;float: left;">
	            <label><span class="need_flag">* </span>年龄：</label>               
	            <input type="number" class="text input-large" id="age" name="jage" value="" style="border-radius: 5px;float: right;width: 344px;" > 
	        </div>
      	</div>
       <div >              
	        <div style="width:47%;margin-right: 20px;float: left;">
	            <label style="margin-right: 30px;"><span class="need_flag">* </span>性别： </label>              
	             	<input type="radio" id="sex1" class="text input-large" name="jsex" value="1"
		            <?php if($list[0]['jsex']==1): ?>checked='checked'<?php endif; ?>>&nbsp;男 &nbsp;&nbsp;
		            <input type="radio" id="sex2" class="text input-large" name="jsex" value="2" <?php if($list[0]['jsex']==2): ?>checked='checked'<?php endif; ?>>&nbsp;女              
	        </div>
	        <div style="width:47%;margin-right: 20px;float: left;">
	            <label><span class="need_flag">* </span>身份证号：  </label>              
	            <input type="text" id="card" class="text input-large" name="jcard" value="" style="border-radius: 5px;float: right;width: 344px;"> 
	        </div>
	      </div>
      	<div >       
	        <div style="width:47%;margin-right: 20px;float: left;">
	            <label><span class="need_flag">* </span>驾驶证号 ：  </label>             
	            <input type="text" id="jbh" class="text input-large" name="jbh" value="" style="border-radius: 5px;float: right;width: 344px;" > 
	        </div>
	        <div style="width:47%;margin-right: 20px;float: left;">
	            <label><span class="need_flag">* </span>教练证号：   </label>             
	            <input type="text" id="tbh" class="text input-large" name="tbh" value="" style="border-radius: 5px;float: right;width: 344px;"> 
	        </div>
      	</div>
      	<div >       
	        <div style="width:47%;margin-right: 20px;float: left;">
	            <label><span class="need_flag">* </span>手机号： </label>               
	            <input type="text" id="phone" class="text input-large" name="jphone" value="" style="border-radius: 5px;float: right;width: 344px;" > 
	        </div>
	        <div style="width:47%;margin-right: 20px;float: left;">
	           <label> <span class="need_flag">* </span>驾龄： </label>               
	            <input type="text" id="jl" class="text input-large" name="jl" value="" style="border-radius: 5px;float: right;width: 344px;"> 
	        </div>
      	</div>
       	<div >         
	        <div style="width:47%;margin-right: 20px;float: left;">
	            <label><span class="need_flag">* </span>驾校：  </label>             
	            <select  rows="8" class="text input-large" id="jxid" name="jxid" value="" style="border-radius: 5px;float: right;width: 362px; height:30px" >
                  <option value="0">请选择驾校</option>
                  <?php if(is_array($list)): foreach($list as $key=>$v): ?><option value="<?php echo ($v["id"]); ?>"><?php echo ($v["jxname"]); ?></option><?php endforeach; endif; ?>
              </select>
	        </div>  
           <div style="width:47%;margin-right: 20px;float: left;">
              <label>备注：  </label>             
              <textarea  rows="8" class="text input-large" name="jmark" value="" style="border-radius: 5px;float: right;width: 351px;"></textarea>
          </div>    

      </div>
      <div> 
         <div style="width: 47%;float: left">
           <label style="float: left;"><span class="need_flag"><!-- *  --></span>证件上传：  </label>
           <div style="width:17%;float: left;text-align: right;">
             <div  id="preview" style="background: #ddd; width: 70px;height: 70px;display: inline-block;">
               <img id="imghead" value="0"  name="card"  src="./Uploads/yueche/jiaolian/card/add.png" style="width: 70px;height: 70px;" onclick="$('#previewImg').click();"/>
             </div><br />
             <input type="file" name="card" onchange="previewImage(this)" style="display: none;" id="previewImg">
             <span style="color: red;font-size: 12px;">(身份证上传)</span>              
           </div>            
           <div style="width:19%;float: left;text-align: right;">
             <div id="preview1" style="background: #ddd;width: 70px;height: 70px;display: inline-block;">
               <img id="imghead1" src="./Uploads/yueche/jiaolian/card/add.png" style="width: 70px;height: 70px;"  onclick="$('#previewImg1').click();"/>
             </div><br />
             <input type="file" name="jiashi" onchange="previewImage1(this)" style="display: none;" id="previewImg1">
             <span style="color: red;font-size: 12px">(驾驶证上传)</span>
           </div>
           <div style="width:19%;float: left;text-align: right;">
             <div id="preview2" style="background: #ddd;width: 70px;height: 70px;display: inline-block;">
               <img id="imghead2" src="./Uploads/yueche/jiaolian/card/add.png"  style="width: 70px;height: 70px; "onclick="$('#previewImg2').click();"/>
             </div><br />
             <input type="file" name="jiaolian" onchange="previewImage2(this)" style="display: none;" id="previewImg2">
             <span style="color: red;font-size: 12px">(教练证上传)</span>
           </div>
           <input type="hidden" id="card_path" name="card_path" value="0">
           <input type="hidden" id="jiashi_path" name="jiashi_path" value="0">
           <input type="hidden" id="jiaolian_path" name="jiaolian_path" value="0">
         </div>       
      </div>
      <script>
//      身份证上传
      	 //图片上传预览    IE是用了滤镜。
        function previewImage(file)
        {
          $.ajaxFileUpload({
             url: "<?php echo U('Jiaolian/upload');?>",
             secureurl:false,
             fileElementId:'previewImg',
             dataType:'json',
             success:function(data,status){
              if(data.status == 1){
                var path = data.url;
                $("#imghead").attr("src",path);
                // $("#card_path").val("1");
                $("#card_path").val(path);
              }else{
                alert(data.msg);
              }
             }
          });
          var MAXWIDTH  = 70; 
          var MAXHEIGHT = 70;
          var div = document.getElementById('preview');
          if (file.files && file.files[0])
          {
              div.innerHTML ='<img id=imghead onclick=$("#previewImg").click()>';
              var img = document.getElementById('imghead');
              img.onload = function(){
                var rect = clacImgZoomParam(MAXWIDTH, MAXHEIGHT, img.offsetWidth, img.offsetHeight);
                img.style.width  =  "70px";
                img.style.height =  "70px";
//                 img.style.marginLeft = rect.left+'px';
                img.style.marginTop = rect.top+'px';
              }
              var reader = new FileReader();
              reader.onload = function(evt)
              {
                 img.src = evt.target.result;
                
              }
              reader.readAsDataURL(file.files[0]);
              
          }
          else //兼容IE
          {
            var sFilter='filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod=scale,src="';
            file.select();
            var src = document.selection.createRange().text;
            div.innerHTML = '<img id=imghead>';
            var img = document.getElementById('imghead');
            img.filters.item('DXImageTransform.Microsoft.AlphaImageLoader').src = src;
            var rect = clacImgZoomParam(MAXWIDTH, MAXHEIGHT, img.offsetWidth, img.offsetHeight);
            status =('rect:'+rect.top+','+rect.left+','+rect.width+','+rect.height);
            div.innerHTML = "<div id=divhead style='width:"+rect.width+"px;height:"+rect.height+"px;margin-top:"+rect.top+"px;"+sFilter+src+"\"'></div>";
          }
         
        }
        function clacImgZoomParam( maxWidth, maxHeight, width, height ){
            var param = {top:0, left:0, width:width, height:height};
            if( width>maxWidth || height>maxHeight ){
                rateWidth = width / maxWidth;
                rateHeight = height / maxHeight;
                
                if( rateWidth > rateHeight ){
                    param.width =  maxWidth;
                    param.height = Math.round(height / rateWidth);
                }else{
                    param.width = Math.round(width / rateHeight);
                    param.height = maxHeight;
                }
            }
            param.left = Math.round((maxWidth - param.width) / 2);
            param.top = Math.round((maxHeight - param.height) / 2);
            return param;
        }
      </script>
      <script>
//      驾驶证上传
      	 //图片上传预览    IE是用了滤镜。
        function previewImage1(file)
        {
          $.ajaxFileUpload({
             url: "<?php echo U('Jiaolian/upload');?>",
             secureurl:false,
             fileElementId:'previewImg1',
             dataType:'json',
             success:function(data,status){
              if(data.status == 1){
                var path = data.url;
                $("#imghead1").attr("src",path);
                $("#jiashi_path").val(path);
              }else{
                alert(data.msg);
              }
             }
          });
          var MAXWIDTH  = 70; 
          var MAXHEIGHT = 70;
          var div = document.getElementById('preview1');
          if (file.files && file.files[0])
          {
              div.innerHTML ='<img id=imghead1 onclick=$("#previewImg1").click()>';
              var img = document.getElementById('imghead1');
              img.onload = function(){
                var rect = clacImgZoomParam(MAXWIDTH, MAXHEIGHT, img.offsetWidth, img.offsetHeight);
                img.style.width  =  "70px";
                img.style.height =  "70px";
//                 img.style.marginLeft = rect.left+'px';
                img.style.marginTop = rect.top+'px';
              }
              var reader = new FileReader();
              reader.onload = function(evt){img.src = evt.target.result;}
              reader.readAsDataURL(file.files[0]);
          }
          else //兼容IE
          {
            var sFilter='filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod=scale,src="';
            file.select();
            var src = document.selection.createRange().text;
            div.innerHTML = '<img id=imghead1>';
            var img = document.getElementById('imghead1');
            img.filters.item('DXImageTransform.Microsoft.AlphaImageLoader').src = src;
            var rect = clacImgZoomParam(MAXWIDTH, MAXHEIGHT, img.offsetWidth, img.offsetHeight);
            status =('rect:'+rect.top+','+rect.left+','+rect.width+','+rect.height);
            div.innerHTML = "<div id=divhead style='width:"+rect.width+"px;height:"+rect.height+"px;margin-top:"+rect.top+"px;"+sFilter+src+"\"'></div>";
          }
        }
        function clacImgZoomParam( maxWidth, maxHeight, width, height ){
            var param = {top:0, left:0, width:width, height:height};
            if( width>maxWidth || height>maxHeight ){
                rateWidth = width / maxWidth;
                rateHeight = height / maxHeight;
                
                if( rateWidth > rateHeight ){
                    param.width =  maxWidth;
                    param.height = Math.round(height / rateWidth);
                }else{
                    param.width = Math.round(width / rateHeight);
                    param.height = maxHeight;
                }
            }
            param.left = Math.round((maxWidth - param.width) / 2);
            param.top = Math.round((maxHeight - param.height) / 2);
            return param;
        }
      </script>
      <script>
//     教练证上传
      	 //图片上传预览    IE是用了滤镜。
        function previewImage2(file)
        {
          $.ajaxFileUpload({
             url: "<?php echo U('Jiaolian/upload');?>",
             secureurl:false,
             fileElementId:'previewImg2',
             dataType:'json',
             success:function(data,status){
              if(data.status == 1){
                var path = data.url;
                $("#imghead2").attr("src",path);
                $("#jiaolian_path").val(path);
              }else{
                alert(data.msg);
              }
             }
          });
          var MAXWIDTH  = 70; 
          var MAXHEIGHT = 70;
          var div = document.getElementById('preview2');
          if (file.files && file.files[0])
          {
              div.innerHTML ='<img id=imghead2 onclick=$("#previewImg2").click()>';
              var img = document.getElementById('imghead2');
              img.onload = function(){
                var rect = clacImgZoomParam(MAXWIDTH, MAXHEIGHT, img.offsetWidth, img.offsetHeight);
                img.style.width  =  "70px";
                img.style.height =  "70px";
//                 img.style.marginLeft = rect.left+'px';
                img.style.marginTop = rect.top+'px';
              }
              var reader = new FileReader();
              reader.onload = function(evt){img.src = evt.target.result;}
              reader.readAsDataURL(file.files[0]);
          }
          else //兼容IE
          {
            var sFilter='filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod=scale,src="';
            file.select();
            var src = document.selection.createRange().text;
            div.innerHTML = '<img id=imghead2>';
            var img = document.getElementById('imghead2');
            img.filters.item('DXImageTransform.Microsoft.AlphaImageLoader').src = src;
            var rect = clacImgZoomParam(MAXWIDTH, MAXHEIGHT, img.offsetWidth, img.offsetHeight);
            status =('rect:'+rect.top+','+rect.left+','+rect.width+','+rect.height);
            div.innerHTML = "<div id=divhead style='width:"+rect.width+"px;height:"+rect.height+"px;margin-top:"+rect.top+"px;"+sFilter+src+"\"'></div>";
          }
        }
        function clacImgZoomParam( maxWidth, maxHeight, width, height ){
            var param = {top:0, left:0, width:width, height:height};
            if( width>maxWidth || height>maxHeight ){
                rateWidth = width / maxWidth;
                rateHeight = height / maxHeight;
                
                if( rateWidth > rateHeight ){
                    param.width =  maxWidth;
                    param.height = Math.round(height / rateWidth);
                }else{
                    param.width = Math.round(width / rateHeight);
                    param.height = maxHeight;
                }
            }
            param.left = Math.round((maxWidth - param.width) / 2);
            param.top = Math.round((maxHeight - param.height) / 2);
            return param;
        }
      </script>
     </volist>					 
        <div class="form-item form_bh">
            <!-- <button class="btn">确定</button> -->
            <input type="submit" class="btn"  value="确定"/>
            <a class="btn" id="go_back">返回</a>
        </div>
	     </form>
       
        </div>
        </div>
      </section>
	
  </div>

  </div>
</div>

	<!-- /主体 -->

	<!-- 底部 -->
	<div class="wrap bottom" style="background:#fff; border-top:#ddd;">
    <p class="copyright" style="font-size:16px;">技术支持：<a href="http://www.siwoinfo.com/">山东思沃信息技术有限公司</a></p>
</div>

<script type="text/javascript">
(function(){
	var ThinkPHP = window.Think = {
		"ROOT"   : "", //当前网站地址
		"APP"    : "/index.php?s=", //当前项目地址
		"PUBLIC" : "/Public", //项目公共目录地址
		"DEEP"   : "<?php echo C('URL_PATHINFO_DEPR');?>", //PATHINFO分割符
		"MODEL"  : ["<?php echo C('URL_MODEL');?>", "<?php echo C('URL_CASE_INSENSITIVE');?>", "<?php echo C('URL_HTML_SUFFIX');?>"],
		"VAR"    : ["<?php echo C('VAR_MODULE');?>", "<?php echo C('VAR_CONTROLLER');?>", "<?php echo C('VAR_ACTION');?>"]
	}
})();
</script>

  <link href="/Public/static/datetimepicker/css/datetimepicker.css?v=<?php echo SITE_VERSION;?>" rel="stylesheet" type="text/css">
  <?php if(C('COLOR_STYLE')=='blue_color') echo '
    <link href="/Public/static/datetimepicker/css/datetimepicker_blue.css?v=<?php echo SITE_VERSION;?>" rel="stylesheet" type="text/css">
    '; ?>
  <link href="/Public/static/datetimepicker/css/dropdown.css?v=<?php echo SITE_VERSION;?>" rel="stylesheet" type="text/css">
  <script type="text/javascript" src="/Public/static/datetimepicker/js/bootstrap-datetimepicker.js"></script> 
  <script type="text/javascript" src="/Public/static/datetimepicker/js/locales/bootstrap-datetimepicker.zh-CN.js?v=<?php echo SITE_VERSION;?>" charset="UTF-8"></script> 
  <script type="text/javascript">
$('#submit').click(function(){
    $('#form').submit();
});

$(function(){

	initUploadFile(function(data,name){
		var old_title = $('#title').val();
		if(old_title==''){
			var data = $.parseJSON(data);
			var title = data.name.replace('.'+data.ext, '');
			$('#title').val(title);		
		}
	});
    showTab();
	
});

//返回点击事件
$("#go_back").click(function(){
  window.history.go(-1);
});
</script> 
 <!-- 用于加载js代码 -->
<!-- 页面footer钩子，一般用于加载插件JS文件和JS代码 -->
<?php echo hook('pageFooter', 'widget');?>
<div style='display:none'><?php echo ($tongji_code); ?></div>
<div class="hidden"><!-- 用于加载统计代码等隐藏元素 -->
	
</div>

	<!-- /底部 -->
</body>
</html>