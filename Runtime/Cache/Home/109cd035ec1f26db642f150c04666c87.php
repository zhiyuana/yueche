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
    
	<link rel="stylesheet" type="text/css" href="/Public/static/dingdan/css/jquery.datetimepicker.css" />
  <script type="text/javascript" src="/Public/static/dingdan/js/jquery.min.js"></script>
  <script type="text/javascript" src="/Public/static/dingdan/js/jquery.datetimepicker.js"></script>
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

      <!-- 数据列表 -->
      <div class="data-table" style="margin-top:20px;">
      
        <div class="table-striped">
        <div style="padding-bottom: 20px;">
		<form action="<?php echo U('ding_Download',array('mdm'=>I('mdm'),'status'=>0));?>" method="post">
        	<input id="data_riqi" type="hidden" value=""/>
			<input type="text" value="<?php echo ($datetimepicker); ?>" id="datetimepicker" name="datetimepicker" placeholder="开始时间段搜索" style="width: 145px;margin-bottom: 0;"/>&nbsp;-
        	<input id="data_riqi1" type="hidden" value=""/>
			<input type="text" id="datetimepicker1" value="<?php echo ($datetimepicker1); ?>" name="datetimepicker1" placeholder="结束时间段搜索" style="width: 145px;margin-bottom: 0;"/>
			<input type="text" name="keywords" value="<?php echo ($keywords); ?>" placeholder="身份证号或手机号搜索" style="width: 235;margin: 0 10px;" id="keywords">
			<a class="btn" id="sousuo" style="">搜 索</a>
			<!-- <input type="submit" value="下 载" class="btn" style="margin-right: 40px;"> -->
			<input type="submit" value="下 载" class="btn" style="margin-left:10px;">
			<!--  <a class="btn" href="<?php echo U('ding_Download',array('mdm'=>I('mdm')));?>">下 载</a> -->
		</form>
        </div>  
        </div>
        </div>
    <div id="ajax_search">
    <div class="data-table">
        <div class="table-striped">
          <table cellspacing="1">
            <!-- 表头 -->
            <thead>
              <tr>
                <th>编号</th>
                <th>学员姓名</th>
                <th>预约日期</th>
                <th>预约时间段</th>
                <!-- <th>订单号</th> -->
                <th>预约车号</th>
                <th>下单时间</th>
                <th>金额</th>
                <th>状态</th>
                <th>操作</th>
              </tr>
            </thead>

            <!-- 列表 -->
            <tbody id="list">
        				<?php if(is_array($dingdan_list)): $i = 0; $__LIST__ = $dingdan_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
        				  <td type="headimgurl" ><?php echo ($vo["id"]); ?></td>
        				  <td type="content"><?php echo ($vo["xname"]); ?></td>
                  <td ><?php echo ($vo["pdata"]); ?></td>
                  <td ><?php echo ($vo["ptime"]); ?></td>
        				  <td ><?php echo ($vo["pch"]); ?></td>
        				  <!-- <td ><?php echo ($vo["transaction_id"]); ?></td> -->
        				  <!-- <td ><?php echo ($vo['transaction_id'] ? $vo['transaction_id'] : $vo['dbh']); ?></td> -->
        				  <td ><?php echo ($vo["daddtime"]); ?></td>
        				  <td ><?php echo ($vo["money"]); ?> 元</td>
                  <td ><?php echo ($vo["status"]); ?></td>
        				  <td><?php if($vo["status"] == '未消费'): ?><a href="<?php echo U('tuikuan',array('id'=>$vo[id],'mdm'=>$_GET['mdm']));?>">申请退款</a>&nbsp;&nbsp;|&nbsp;&nbsp;<?php endif; ?>
        					<a href="<?php echo U('ding_xq',array('id'=>$vo[id],'mdm'=>$_GET['mdm']));?>">查看详情</a><!--  |
        					<a href="<?php echo U('dingdan_del',array('id'=>$vo[id],'mdm'=>$_GET['mdm']));?>" class="del">删除</a> -->
        				  </td>
        				</tr><?php endforeach; endif; else: echo "" ;endif; ?>
            </tbody>
          </table>
        </div>
      </div>
      </if>
      <div class="page" id="page"> <?php echo ($_page); ?> </div>
	  <!-- <?php echo ((isset($_page) && ($_page !== ""))?($_page):''); ?> -->
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

<script type="text/javascript">
$('#sousuo').click(function(){
  var datetimepicker = $("#datetimepicker").val();
  var datetimepicker1 =  $("#datetimepicker1").val();
  var keywords = $("#keywords").val();
  if(datetimepicker == "" && datetimepicker1 == "" && keywords == "")
  {
    alert("搜索条件不能为空!");
    return false;
  }
  else if((datetimepicker == '' || datetimepicker1 == '') && keywords == "")
  {
    alert("请选择时间段");
    return false;
  }
  else{
    //var url = "http://yueche.siwoinfo.com/index.php?s=/Home/Dingdan/ding_list/datetimepicker/"+datetimepicker+"/datetimepicker1/"+datetimepicker1;
      var skip_url =   "http://" + window.location.hostname + window.location.pathname;
  	  var url = skip_url + "?s=/Home/Dingdan/ding_list/datetimepicker/"+datetimepicker+"/datetimepicker1/"+datetimepicker1+"/keywords/"+keywords;
      $('#sousuo').attr('href',url);
  }
})
// function search(){	
// 	var datetimepicker = $("#datetimepicker").val();
// 	var datetimepicker1 =  $("#datetimepicker1").val();
//   if(datetimepicker == '' || datetimepicker1 == ''){
//     alert("请选择时间段");
//     return false;
//   }
//   var url = "http://yueche.siwoinfo.com/index.php?s=/Home/Dingdan/ding_list/datetimepicker/"+datetimepicker+"datetimepicker1/"+datetimepicker1;
//   $('.btn').attr('href',url);
// 	$.ajax({
// 		url:"<?php echo U('Dingdan/ding_list');?>",
// 		type:"POST",
// 		data:dataStr,
// 		dataType:"json",
// 		success:function(json){
// 		//alert(json[0]._page);return false;
// 			htmlstr ="";
// 			if(json == 'null' || json == null || json.count=='0'){
// 				htmlstr += "<tr><td colspan='8'  style='text-align:center'>未检索到相关信息</td></tr>";	
// 			}else{
// 				$.each(json,function(i,n){		
// 					htmlstr += "<tr><td>"+n.id+"</td>";
// 					htmlstr += "<td>"+n.xname+"</td>";
// 					htmlstr += "<td>"+n.data+"</td>";
// 					htmlstr += "<td>"+n.transaction_id+"</td>";
// 					htmlstr += "<td>"+n.daddtime+"</td>";
// 					htmlstr += "<td>"+n.money+"</td>";
// 					htmlstr += "<td>未消费</td>";
// 					htmlstr += "<td><a href='<?php echo U("ding_xq",array("id"=>"+n.id+","mdm"=>$_GET["mdm"]));?>' class='del'>查看详情</a></td></tr>";
// 				});				
// 			}
// 			$("#list").html(htmlstr);
// 			$("#page").html(json[0]._page);
// 		}	
// 	});
// }


$(function(){
  
})
$('#datetimepicker').datetimepicker({
	lang:'ch',
  format:"Y-m-d",      //格式化日期
  timepicker:false,    //关闭时间选项
});
$('#datetimepicker1').datetimepicker({
	lang:'ch',
  format:"Y-m-d",      //格式化日期
  timepicker:false,    //关闭时间选项
});
$( '.del' ).click( function () {
        return confirm('确认要执行删除操作吗？');
    });
function playSound(id,obj){
  var audio = document.getElementById(id);
  if(audio.paused){
    audio.play();
    $(obj).find('img').attr('src',IMG_PATH+'/icon_sound_play.gif');
    audio.addEventListener('ended', function () {  
//      alert('over');
      $(obj).find('img').attr('src',IMG_PATH+'/icon_sound.png');
    }, false);
    return;
  }
  audio.pause();
  $(obj).find('img').attr('src',IMG_PATH+'/icon_sound.png');
  
}
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