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
    
 <style>
 	label{float: left;width: 100px;}
 	li,ul{list-style: none;}
    .line{margin-bottom: 39px;border-bottom: 1px solid #ddd;line-height: 38px;}
    .bottom{position: absolute;bottom: 0;}
     .tab-nav{margin-bottom: 0;}
     .form_bh {padding: 20px 0 0;margin: 0;}
 </style>
 <script src="/Public/static/jquery-1.10.2.min.js" type="text/javascript"></script>
  <div class="span9 page_message">  
    <section id="contents">
    <ul class="tab-nav nav">
        <li class="current"><a href="javascript:void(0)">退款详情</a></li>
    </ul>
    <div class="tab-content" style="padding: 20px 40px;"> 

     <li class="line" style="border-bottom: none;"> 
        
        <div style="width:48%;float: left;">
            <label>微信订单号：</label>
            <span style="width: 344px;float: right;"><?php echo ($list['transaction_id']); ?></span> 
        </div>
        <div style="width:48%;margin-right: 20px;float: left;">
            <label style="margin-left: 20px;">商户订单号： </label>
            <span style="width: 344px;float: right;"><?php echo ($list['out_trade_no']); ?></span>
        </div>
    </li>
    <li class="line">
        <div style="width:48%;margin-right: 20px;float: left;">
            <label>预约车号：</label>            
            <span style="width: 344px;float: right;"><?php echo ($list['pch']); ?></span> 
        </div>
        <div style="width:48%;margin-right: 20px;float: left;">
            <label>预约日期： </label>
            <span style="width: 344px;float: right;" id="pdata"><?php echo ($list['pdata']); ?></span>
        </div>
    </li>
    <li class="line">       	  
        <div style="width:48%;margin-right: 20px;float: left;">
            <label>预约时间段：  </label>
           	<span style="width: 344px;float: right;">
                <?php  $arr = explode(',',$list['ptime']); foreach($arr as $v){ ?>
                    <p class="ptime"><?php echo $v; ?></p>
                <?php
 } ?>
            </span>
        </div>
         <div style="width:48%;margin-right: 20px;float: left;">
            <label>订单总金额：   </label>
				<span style="width: 344px;float: right;">
					￥<?php echo ($list['money']); ?>
				</span>
        </div>
     </li>
    <li class="line">
        <div style="width:48%;margin-right: 20px;float: left;">
            <label>扣除手续费：  </label>
            <span style="width: 344px;float: right;">￥<span class="xu"></span></span>
        </div>
		<div style="width:48%;margin-right: 20px;float: left;">
            <label>应退金额：   </label>
             <span style="width: 344px;float: right;">￥ <span class="tui"></span></span>
        </div>	
   	 </li>
    <li class="line">                     
        
        <div style="width:48%;margin-right: 20px;float: left;">
            <label>下单时间：  </label>
             <span style="width: 344px;float: right;"><?php echo ($list['daddtime']); ?></span>
        </div>
    </li>
    <li class="line">
        <div style="width:48%;margin-right: 20px;float: left;">
            <label>退款说明：  </label>
             <span style="width: 344px;float: right;line-height: 45px"><input type="text" style="display:block;border:none;width:100%;margin-top:3px;" name="twark" id="twark" placeholder="请填写退款原因（退款必填项！）"></span>
        </div>
    </li>
    <input type="hidden" name="id" id="id" value="<?php echo ($list['id']); ?>">		 
    <div class="form-item form_bh"><a class="btn">提交申请</a></div>     
    </div>
    </div>
    </section>
</div>
<script type="text/javascript">

    var pdata = $('#pdata').html();
    pdata = pdata.replace(/-/g,'/');// 将-替换成/，因为下面这个构造函数只支持/分隔的日期字符串

    var time = $('.ptime').eq(0).text();
    var ptime = time.substring(0, 5);
    var datatime = pdata + ' ' +ptime;

    //获取预约用车的时间戳(S为单位)
    var timestamp2 = Date.parse(new Date(datatime));            
    timestamp2 = parseInt(timestamp2 / 1000); 
    // 获取当前时间戳(以s为单位)  
    var timestamp = new Date().getTime();           
    timestamp = parseInt(timestamp / 1000); 

    var timecha=timestamp2-timestamp;

    var zongshu =<?php echo ($list['money']); ?>;
    if(timecha>43200){
        $(".tui").text(zongshu);
  
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
        var twark = $('#twark').val();//退款说明
        var koufei = $(".xu").text();//扣费
        var refund_fee=$(".tui").text();//应退金额
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
                //url:"<?php echo addons_url('Forms://Wap/addtuikuan');?>",
                url:'<?php echo U("Jxyueche/tijiao_tuikuan");?>',
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
 <!-- 用于加载js代码 -->
<!-- 页面footer钩子，一般用于加载插件JS文件和JS代码 -->
<?php echo hook('pageFooter', 'widget');?>
<div style='display:none'><?php echo ($tongji_code); ?></div>
<div class="hidden"><!-- 用于加载统计代码等隐藏元素 -->
	
</div>

	<!-- /底部 -->
</body>
</html>