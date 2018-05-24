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
	
    <link rel="stylesheet" type="text/css" href="/Public/static/fabu/css/bootstrap.min.css" />
    <script type="text/javascript" src="/Public/static/fabu/js/jquery.min.js"></script>
    <script type="text/javascript" src="/Public/static/fabu/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/Public/static/fabu/js/Calendar.js"></script>
    <link rel="stylesheet" type="text/css" href="/Public/static/fabu/css/body.css" />
    <meta charset="UTF-8">
    <meta content="<?php echo C('WEB_SITE_KEYWORD');?>" name="keywords" />
    <meta content="<?php echo C('WEB_SITE_DESCRIPTION');?>" name="description" />
    <link rel="shortcut icon" href="<?php echo SITE_URL;?>/favicon.ico">
    <title>
        <?php echo empty($page_title) ? C('WEB_SITE_TITLE') : $page_title; ?>
    </title>
    <link href="/Public/static/font-awesome/css/font-awesome.min.css?v=<?php echo SITE_VERSION;?>" rel="stylesheet">
    <link href="/Public/Home/css/base.css?v=<?php echo SITE_VERSION;?>" rel="stylesheet">
    <link href="/Public/Home/css/module.css?v=<?php echo SITE_VERSION;?>" rel="stylesheet">
    <link href="/Public/Home/css/weiphp.css?v=<?php echo SITE_VERSION;?>" rel="stylesheet">
    <link href="/Public/static/emoji.css?v=<?php echo SITE_VERSION;?>" rel="stylesheet">


    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
		<script src="/Public/static/bootstrap/js/html5shiv.js?v=<?php echo SITE_VERSION;?>"></script>
		<![endif]-->
    <block name="style">
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
    -->
<div class="span9 page_message" style="background: #fff;">
    <section id="contents" style="margin-top:8px;margin-left: -90px;">
        <ul class="tab-nav nav">
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
        <div class="sub" style="margin-top:-15px;background: #fff;">
            <form action="<?php echo U('paiban_jiaxiao_add');?>" method='post' name="form">
                <div class="car">
                    <div class="car_date">
                        <label>日期：</label>
                        <input name="control_date" type="text" id="control_date" size="10" maxlength="10" onClick="new Calendar().show(this);" readonly="readonly" style="width: 140px;cursor: pointer;background: #fff;" />
                    </div>
                    <div class="car_all">
                        <input type="checkbox" value="" class="copy_all" name="allChecked" id="allChecked" onclick="DoCheck()" />
                        <span class="copy_span">全选</span>
                        <span style="margin:0px 0px 0px 250px;font-size:30px;color:blue;">驾校排班发布</span>
                    </div>
                    <div style="padding-bottom: 20px;padding-left: 15px;float: right;margin-right: 20px">
                        <button class="btn add_info">发布</button>
                    </div>
                </div>
                <div id="table_date">
                    <table class="table table-bordered" style="border: none;" id="tbn">
                        <thead tyle="display: block;width:100%">
                            <tr>
                                <th style="padding: 4px 18px;">车号</th>
                                <!-- <th style="padding: 4px 18px;">全选</th> -->
                                <th style=" cursor: pointer;">00:00-01:00</th>
                                <th style=" cursor: pointer;">01:00-02:00</th>
                                <th style=" cursor: pointer;">02:00-03:00</th>
                                <th style=" cursor: pointer;">03:00-04:00</th>
                                <th style=" cursor: pointer;">04:00-05:00</th>
                                <th style=" cursor: pointer;">05:00-06:00</th>
                                <th style=" cursor: pointer;">06:00-07:00</th>
                                <th style=" cursor: pointer;">07:00-08:00</th>
                                <th style=" cursor: pointer;">08:00-09:00</th>
                                <th style=" cursor: pointer;">09:00-10:00</th>
                                <th style=" cursor: pointer;">10:00-11:00</th>
                                <th style=" cursor: pointer;">11:00-12:00</th>
                                <th style=" cursor: pointer;">12:00-13:00</th>
                                <th style=" cursor: pointer;">13:00-14:00</th>
                                <th style=" cursor: pointer;">14:00-15:00</th>
                                <th style=" cursor: pointer;">15:00-16:00</th>
                                <th style=" cursor: pointer;">16:00-17:00</th>
                                <th style=" cursor: pointer;">17:00-18:00</th>
                                <th style=" cursor: pointer;">18:00-19:00</th>
                                <th style=" cursor: pointer;">19:00-20:00</th>
                                <th style=" cursor: pointer;">20:00-21:00</th>
                                <th style=" cursor: pointer;">21:00-22:00</th>
                                <th style=" cursor: pointer;">22:00-23:00</th>
                                <th style=" cursor: pointer;">23:00-00:00</th>
                            </tr>
                        </thead>
                        <tbody style="height: 460px;overflow: auto;width: 101.2%;display: block;">
                            <script>
                                // <td><input type='checkbox'  class='allChecked'></td>
                                var html = '';
                                for (var i = 1; i < 41; i++) {
                                    html += "<tr><td>" + i + "</td><td><input type='checkbox' value='00:00-01:00' name='che" + i + "[]'></td><td><input type='checkbox' value='01:00-02:00' name='che" + i + "[]'></td><td><input type='checkbox' value='02:00-03:00' name='che" + i + "[]'></td><td><input type='checkbox' value='03:00-04:00' name='che" + i + "[]'></td><td><input type='checkbox' value='04:00-05:00' name='che" + i + "[]'></td><td><input type='checkbox' value='05:00-06:00' name='che" + i + "[]'></td><td><input type='checkbox' value='06:00-07:00' name='che" + i + "[]'></td><td><input type='checkbox' value='07:00-08:00' name='che" + i + "[]'></td><td><input type='checkbox' value='08:00-09:00' name='che" + i + "[]'></td><td><input type='checkbox' value='09:00-10:00' name='che" + i + "[]'></td><td><input type='checkbox' value='10:00-11:00' name='che" + i + "[]'></td><td><input type='checkbox' value='11:00-12:00' name='che" + i + "[]'></td><td><input type='checkbox' value='12:00-13:00' name='che" + i + "[]'></td><td><input type='checkbox' value='13:00-14:00' name='che" + i + "[]'></td><td><input type='checkbox' value='14:00-15:00' name='che" + i + "[]'></td><td><input type='checkbox' value='15:00-16:00' name='che" + i + "[]'></td><td><input type='checkbox' value='16:00-17:00' name='che" + i + "[]'></td><td><input type='checkbox' value='17:00-18:00' name='che" + i + "[]'></td><td><input type='checkbox' value='18:00-19:00' name='che" + i + "[]'></td><td><input type='checkbox' value='19:00-20:00' name='che" + i + "[]'></td><td><input type='checkbox' value='20:00-21:00' name='che" + i + "[]'></td><td><input type='checkbox' value='21:00-22:00' name='che" + i + "[]'></td><td><input type='checkbox' value='22:00-23:00'  name='che" + i + "[]'></td><td><input type='checkbox' value='23:00-00:00'  name='che" + i + "[]'></td></tr>"
                                    $("tbody").html(html);
                                }
                                //行全选
                                // $(".allChecked").click(function(){					
                                // 	if($(this).is(":checked")){
                                // 		$(this).parent().nextAll().children().prop("checked","true");
                                // 	}else{
                                // 		$(this).parent().nextAll().children().removeAttr("checked");
                                // 	}

                                // })
                                //总全选
                                function DoCheck() {
                                    var ch = document.getElementsByTagName("input")
                                    if (document.getElementsByName("allChecked")[0].checked == true) {
                                        for (var i = 0; i < ch.length; i++) {
                                            ch[i].checked = true;
                                        }
                                    } else {
                                        for (var i = 0; i < ch.length; i++) {
                                            ch[i].checked = false;
                                        }
                                    }
                                }
                            </script>
                            <script type="text/javascript" src="/Public/static/jquery-1.7.1.js"></script>
                            <script type="text/javascript">
                                // 列全选
                                $('thead th').toggle(
                                    function() {
                                        var time = $(this).text();
                                        // alert($(this).text());
                                        // console.log($("input[value='"+time+"']").val());
                                        $("input[value='" + time + "']").attr('checked', 'true');
                                        // return false;
                                    },
                                    function() {
                                        var time = $(this).text();
                                        // alert($(this).text());
                                        // console.log($("input[value='"+time+"']").val());
                                        $("input[value='" + time + "']").removeAttr('checked');
                                        // return false;
                                    }
                                );
                                $('.tab-nav li').css('position', 'relative');
                                function mh (ele,txt1,txt2,hr1,hr2){
                                ele.hover(function() {
                                    $("<div style='position: absolute;left: 0;top:40px;width: 130px; height: 80px;' class='box'>" +
                                        "<a class = 'myhover' href="+hr1+" style='width:100%;height:40px;line-height:40px;color:#fff;text-align:center;cursor:pointer;border-bottom:1px solid #fff;display:block;background: rgba(138,138,138,.5)'>"+txt1+"</a>" + "" +
                                        "<a class = 'myhover' href="+hr2+" style='width:100%;height:40px;line-height:40px;color:#fff;text-align:center;cursor:pointer;display:block;background: rgba(138,138,138,.5)'>"+txt2+"</a>" +
                                        "</div>").appendTo($(this));
                                   
                                    $('.box .myhover').hover(function(){
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
                        </tbody>

                    </table>
                </div>

        </div>
        </form>
</div>
</section>
</div>
<!--
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
        <link href="/Public/static/datetimepicker/css/datetimepicker_blue.css?v=<?php echo SITE_VERSION;?>" rel="stylesheet" type="text/css"> '; ?>
    <link href="/Public/static/datetimepicker/css/dropdown.css?v=<?php echo SITE_VERSION;?>" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="/Public/static/datetimepicker/js/bootstrap-datetimepicker.js"></script>
    <script type="text/javascript" src="/Public/static/datetimepicker/js/locales/bootstrap-datetimepicker.zh-CN.js?v=<?php echo SITE_VERSION;?>" charset="UTF-8"></script>
    <script type="text/javascript">
        $('#submit').click(function() {
            $('#form').submit();
        });

        function curDateTime() {
            var d = new Date();
            var year = d.getFullYear();
            var month = d.getMonth() + 1;
            var date = d.getDate();
            var curDateTime = year;
            if (month > 9)
                curDateTime = curDateTime + "-" + month;
            else
                curDateTime = curDateTime + "-0" + month;
            if (date > 9)
                curDateTime = curDateTime + "-" + date;
            else
                curDateTime = curDateTime + "-0" + date;
            return curDateTime;
        }
        $("#control_date").val(curDateTime())
        $(function() {

            initUploadFile(function(data, name) {
                var old_title = $('#title').val();
                if (old_title == '') {
                    var data = $.parseJSON(data);
                    var title = data.name.replace('.' + data.ext, '');
                    $('#title').val(title);
                }
            });
            showTab();

        });

        //判断发布是否选空值
        $(".add_info").click(function() {
            var add_btn = $("input[type='checkbox']").is(':checked');
            if (add_btn == false) {
                alert('未选中任何项！!');
                return false;
            }
            if (add_btn == true) {
                form.submit();
                return false;
            }
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