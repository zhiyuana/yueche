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
      
        <!-- <div class="table-striped">
        <div style="padding-bottom: 20px;padding-left: 15px;">
        <a class="btn" href="<?php echo U('jiaolian_add',array('mdm'=>I('mdm')));?>">新 增</a>
        </div>  
        </div> -->
          <input type="text" value="<?php echo ($data); ?>" id="datetimepicker9" style="width: 140px;"/>
          <a class="btn" style="margin-bottom: 8px;" id="search_btn">搜索</a>
          <a class="btn" style="margin-bottom: 8px;" id="s_delete">删除</a>
          <span style="margin:0px 0px 0px 200px;font-size:30px;color:blue;">学员排班列表</span>
       </div>
       <script type="text/javascript">
         $('#search_btn').click(function(){
            var data = $('#datetimepicker9').val();
            if(data == ''){
              alert('请选择要搜索的日期')
            }else{
              //var url = "http://yueche.siwoinfo.com/index.php?s=/Home/Paiban/paiban_list/data/"+data;
              var skip_url =   "http://" + window.location.hostname + window.location.pathname;
              var url = skip_url + "?s=/Home/Paiban/paiban_list/data/"+data;

              $('#search_btn').attr('href',url);
            }
         });

       </script>

       
		<div class="data-table">
        <div class="table-striped">
          <table cellspacing="1">
            <!-- 表头 -->
            <thead>
              <tr>
                <th>
                  <input id="CheckAll" name='CheckAll' type='checkbox'>
                  <span class="copy_span">全选</span>
                </th>
                <th>编号</th>
                <th>车辆编号</th>
      				  <th>日期</th>
                <th>时间段</th>
                <th>备注</th>
                <th>操作</th>
              </tr>
            </thead>

            <!-- 列表 -->
            <tbody>
              <?php if(is_array($paiban_list)): $i = 0; $__LIST__ = $paiban_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                  <td type="headimgurl">
                    <input id='Check[]' name='Check[]' type='checkbox'  value="<?php echo ($vo["id"]); ?>">
                  </td>
                  <td type="headimgurl"><?php echo ($vo["id"]); ?></td>
                  <td type="content"><?php echo ($vo["ch"]); ?></td>
                  <td ><?php echo ($vo["data"]); ?></td>
                  <td ><?php echo ($vo["time"]); ?></td>
                  <!-- <td ><?php echo ($vo["mark"]); ?></td> -->
                  <td >学员预约</td>
      				    <td>
                    <a href="<?php echo U('paiban_edit',array('id'=>$vo[id],'mdm'=>$_GET['mdm']));?>">编辑</a> |
                    <!-- <a href="<?php echo U('paiban_del',array('id'=>$vo[id],'mdm'=>$_GET['mdm']));?>" class="del">删除</a> -->
                    <a href="javascript:void(0)" class="del">删除</a>
                    
                  </td>
                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
            </tbody>
          </table>
        </div>
      </div>
      </if>
      <div class="page"> <?php echo ((isset($_page) && ($_page !== ""))?($_page):''); ?> </div>
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


    //多选删除
    $("#CheckAll").bind("click",function(){           
        $("input[name='Check[]']").prop("checked",this.checked);
            
    });

    //获取被选中checkbox值
    var checked = function(){
      var checks = $("input[name='Check[]']:checked");
      if(checks.length == 0){ alert('未选中任何项！');return false;}
          
      var checkData = new Array();
      checks.each(function(){ 
         checkData.push($(this).val()); 
      });
      return checkData;
    };

    //批量删除 
    $("#s_delete").click(function(){
      
      if(val = checked()){    
          if(confirm('确定要删除所选吗?'))
          {    
           // $.get("<{spUrl c=order a=delete}>",{Check:val.toString()},function(result){ if(result = true){ window.location.reload();}});
           
              $.ajax({

                  type     :  "POST",
                  url      :  "<?php echo U('paiban_select_del');?>",
                  data     :  {del_id:val},
                  dataType :  "json",
                  success  :  function(data){
                               if(data == 2){
                                    alert('删除成功!');
                                    window.location.reload();
                                }else if(data == 1){
                                    alert('所选时间段已被预约或在退款审核中禁止删除!');
                                    return false;
                                }else{
                                    alert('删除失败!');
                                    return false;
                                }
                  }
              });
         }
      } 
    }); 

//单选删除
$('.del').on('click',function(){
  if(confirm('确定要删除所选吗?')){ 
      var delete_id = $(this).parent().parent().children('td').eq(1).html();   
      $.ajax({

          type     :  "POST",
          url      :  "<?php echo U('paiban_del');?>",
          data     :  {id:delete_id},
          dataType :  "json",
          success  :  function(data){
                          if(data == 2){
                              alert('删除成功!');
                              window.location.reload();
                          }else if(data == 1){
                              alert('该时间段已被预约或在退款审核中禁止删除!');
                              return false;
                          }else{
                              alert('删除失败!');
                              return false;
                          }

          }
      });
   }
})
  

  function playSound(id,obj){
  	var audio = document.getElementById(id);
  	if(audio.paused){
  		audio.play();
  		$(obj).find('img').attr('src',IMG_PATH+'/icon_sound_play.gif');
  		audio.addEventListener('ended', function () {  
  // 			alert('over');
  			$(obj).find('img').attr('src',IMG_PATH+'/icon_sound.png');
  		}, false);
  		return;
  	}
  	audio.pause();
  	$(obj).find('img').attr('src',IMG_PATH+'/icon_sound.png');
  	
  }
$('#datetimepicker9').datetimepicker({
		 lang:"ch", //语言选择中文 注：旧版本 新版方法：$.datetimepicker.setLocale('ch');
      format:"Y-m-d",      //格式化日期
      timepicker:false,    //关闭时间选项
});
</script> 
<script type="text/javascript">
    $('.tab-nav li').css('position', 'relative');
    function mh (ele,txt1,txt2,hr1,hr2){
    ele.hover(function() {
        $("<div style='position: absolute;left: 0;top:40px;width: 130px; height: 80px;' class='box'>" +
            "<a href="+hr1+" style='width:100%;height:40px;line-height:40px;color:#fff;text-align:center;cursor:pointer;border-bottom:1px solid #fff;display:block;background: rgba(138,138,138,.5)'>"+txt1+"</a>" + "" +
            "<a href="+hr2+" style='width:100%;height:40px;line-height:40px;color:#fff;text-align:center;cursor:pointer;display:block;background: rgba(138,138,138,.5)'>"+txt2+"</a>" +
            "</div>").appendTo($(this));
        $('.box a').hover(function(){
                                        $(this).css({'background':'rgba(0,0,0,.7)','color':'#eee'})
                                    },function(){
                                        $(this).css({'background':'rgba(138,138,138,.5)','color':'#fff'})
                                    })
    }, function() {
        $('div').remove('.box')
    }) 
    }
    mh($('.tab-nav li').eq(0),"学员排班发布","驾校排班发布","<?php echo U('paiban_index');?>","<?php echo U('paiban_jiaxiao');?>");
    mh($('.tab-nav li').eq(1),"学员排班列表","驾校排班列表","<?php echo U('paiban_list');?>","<?php echo U('paiban_jiaxiao_list');?>");
    mh($('.tab-nav li').eq(2),"学员排班统计表","驾校排班统计表","<?php echo U('tongji_list');?>","<?php echo U('tongji_jiaxiao_list');?>");
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