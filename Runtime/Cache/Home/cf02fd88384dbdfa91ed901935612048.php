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
    <script type="text/javascript" src="/Public/static/dingdan/js/jquery-1.7.1.js"></script>
    <script type="text/javascript" src="/Public/static/dingdan/js/jquery.datetimepicker.js"></script>
    <script type="text/javascript" src="/Public/static/dingdan/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/Public/static/dingdan/js/jiao_select.js"></script>
    <style>
        ul,
        li {
            list-style: none;
        }
        
        a {
            text-decoration: none;
        }
        /*.car {height:40px;}*/
        
        .sub {
            padding: 15px;
            color: #000;
        }
        
        .car_date,
        .car_all {
            display: inline-block;
        }
        
        .car_date {
            margin-right: 30px;
            color: #000;
        }
        
        .car_date label {
            font-weight: normal;
        }
        
        .car_date input {
            color: #000;
        }
        
        label {
            float: left;
            margin-right: 20px;
            line-height: 34px;
        }
        
        .form-control {
            float: left;
            width: 8%;
            margin-right: 50px;
        }
        
        #data {
            height: 17px;
            width: 150px;
        }
        
        select {
            width: 167px;
            height: 34px;
        }
        
        .car_data {
            margin-top: 60px;
        }
        
        .day i {
            background: url(/Public/static/dingdan/item_sel.gif) no-repeat;
            display: none;
            bottom: 0;
            height: 12px;
            overflow: hidden;
            position: absolute;
            right: 0;
            text-indent: -9999em;
            width: 12px;
        }
        
        .data-table table tr>th:first-child {
            width: 30px;
        }
        
        .data-table table tr>td:first-child {
            width: 30px;
            text-align: center;
        }
        
        .day1 {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 2px 4px;
            text-align: center;
            position: relative
        }
        
        .day {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 2px 4px;
            text-align: center;
            position: relative
        }
        .day_dis {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 2px 4px;
            text-align: center;
            position: relative
        }
        
        .fenduan {
            height: 220px;
            overflow-y: auto;
            padding: 15px;
            overflow-x: auto;
            width: 1162px;
        }
        
        .fenduan table {
            border: 1px solid #ddd;
            width: 100%;
            border-spacing: 0;
            border-collapse: collapse;
            background-color: transparent;
            margin-bottom: 20px;
            border: 1px solid #ddd;
        }
        
        .fenduan tr {
            display: table-row;
            vertical-align: inherit;
            border-color: inherit;
        }
        
        .fenduan table th {
            text-align: center;
            border: 1px solid #ddd;
            padding: 8px;
            line-height: 1.42857143;
            vertical-align: top;
        }
        
        .fenduan td {
            border: 1px solid #ddd;
            padding: 6px;
            line-height: 1.42857143;
            vertical-align: top;
        }
        
        .fenduan td .day {
            cursor: pointer;
        }
        /*.fenduan .table{
			width: 100%;
            max-width: 100%;
		}*/
        
        .select {
            width: 100px;
            height: 37px;
        }
    </style>
    <div class="span9 page_message">
        <section id="contents"><ul class="tab-nav nav">
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
            <!-- <ul class="tab-nav nav">
            <li class="current"><a href="<?php echo U('Jxyueche/jxyc_index');?>">驾校约车</a></li>
            <li class=""><a href="<?php echo U('Jxyueche/jxueyuan_list');?>">学员管理</a></li>
            </ul> -->

            <!-- 数据列表 -->
            <div class="data-table" style="margin-top:0px;">
                <div class="table-striped">
                    <div class="sub">
                        <div class="car_date" style="margin-right: 10px;">
                            <label style="margin:0">车号：</label>
                            <select name="" id="selected" onchange = "select_request()">
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5">5</option>
								<option value="6">6</option>
								<option value="7">7</option>
								<option value="8">8</option>
								<option value="9">9</option>
								<option value="10">10</option>
								<option value="11">11</option>
								<option value="12">12</option>
								<option value="13">13</option>
								<option value="14">14</option>
								<option value="15">15</option>
								<option value="16">16</option>
								<option value="17">17</option>
								<option value="18">18</option>
								<option value="19">19</option>
								<option value="20">20</option>
								<option value="21">21</option>
								<option value="22">22</option>
								<option value="23">23</option>
								<option value="24">24</option>
								<option value="25">25</option>
								<option value="26">26</option>
								<option value="27">27</option>
								<option value="28">28</option>
								<option value="29">29</option>
								<option value="30">30</option>
								<option value="31">31</option>
								<option value="32">32</option>
								<option value="33">33</option>
								<option value="34">34</option>
								<option value="35">35</option>
								<option value="36">36</option>
								<option value="37">37</option>
								<option value="38">38</option>
								<option value="39">39</option>
								<option value="40">40</option>
								</select>
                        </div>
                        <div class="car_date" style="margin-right: 10px;">
                            <label style="margin:0">日期：</label>
                            <input type="text" id="data" value="<?php echo ($data); ?>" />
                        </div>
                    <?php if($nickname == 'admin'): ?><script type="text/javascript" src="/Public/static/dingdan/js/select.js"></script>
                        <div class="car_date" style="margin-right: 10px;">
                            <label style="margin:0">驾校：</label>
                            <input type="text" id="jiaxiao" name="jiaxiao" value="" style="width: 275px;" />
                            <input type="hidden" id="date2" value="" name="jxid" />
                        </div>
                        <p id="list" style="display:none"><?php echo ($json); ?></p>
                        <script>
                            var list = $("#list").text();
                            var datas = eval(list);
                            $.selectSuggest('jiaxiao', datas);
                            $("#jiaxiao").bind("change", function() {
                                var id = $("#date2").val();
                                $.ajax({
                                    type: "post",
                                    url: "<?php echo U('Dayin/jiaolian');?>",
                                    data: {
                                        id: id
                                    },
                                    dataType: "json",
                                    success: function(result) {
                                        var arr = eval(result);
                                        $.select('testInput', arr);
                                    }
                                });
                            });
                        </script>
                        <div class="car_date" style="margin-right: 10px;">
                            <label style="margin:0">教练：</label>
                            <input type="text" id="testInput" name="testInput" value="" />
                            <input type="hidden" id="date1" value="" name="jid" />
                        </div>
                    <?php else: ?>
                    <script type="text/javascript" src="/Public/static/dingdan/js/select_jname.js"></script>
                    <div class="car_date" style="margin-right: 10px;">
                            <label style="margin:0">驾校：</label>
                            <input type="text" id="jiaxiao" name="jiaxiao" value="<?php echo ($jiaxiao_list['jxname']); ?>" style="width: 275px;" readonly="readonly"/>
                            <input type="hidden" id="date2" value="<?php echo ($jiaxiao_list['id']); ?>" name="jxid" />
                        </div>
                        <p id="list" style="display:none"><?php echo ($json); ?></p>
                        <div class="car_date" style="margin-right: 10px;">
                            <label style="margin:0">教练：</label>
                            <input type="text" id="jiaolian" name="jiaolian" value="" />
                            <input type="hidden" id="date1" value="" name="jid" />
                        </div>
                        
                        <script>
                            var list = $("#list").text();
                            var datas = eval(list);
                            $.selectSuggest('jiaolian', datas);
                            $("#jiaolian").bind("change", function() {
                                var id = $("#date1").val();
                                // $.ajax({
                                //     type: "post",
                                //     url: "<?php echo U('Dayin/jiaolian');?>",
                                //     data: {
                                //         id: id
                                //     },
                                //     dataType: "json",
                                //     success: function(result) {
                                //         var arr = eval(result);
                                //         $.select('testInput', arr);
                                //     }
                                // });
                            });
                        </script><?php endif; ?>
                    </div>
                </div>
            </div>
            <input type="hidden" name="id" value="">
            <div style="margin-bottom: 20px;" class="fenduan">
                <table class="table table-bordered">
                    <thead>
                        <th colspan="6">
                            <div style="width: 56px;display: inline-block; ">发布时长</div>
                        </th>
                    </thead>
                    <tbody>
                            <?php
 if($fabu_list == false){ echo "<tr><td style='text-align:center;margin-top:10%;font-size:16px;'>当前没有可以选择的时间段！</td><tr>"; } foreach ($fabu_list as $k => $v) { ?>
                                <tr>
                                    <?php
 foreach ($v as $g => $h) { ?>
                                        <td style="width:190px;">
                                            <?php  if($h == null){ echo ' '; }else{ ?>
                                            
                                                <?php
 if($h['status'] == 1){ ?>

                                                <div class='day_dis' value="<?php echo $h['id']; ?>" style="background:gray;">

                                                <?php echo $h['time'];?><i></i>
                                                <?php
 }else{ $yue_hour = substr($h['time'],0,2); $dangqian_hour = date('H',time()); if($yue_hour <= $dangqian_hour ){ ?>
												<div class='day_dis' value="<?php echo $h['id']; ?>" style="background:gray;">
												<?php
 echo $h['time']; }else{ ?>
                                                <div class='day' value="<?php echo $h['id']; ?>">
                                                <?php  echo $h['time']; } ?><i></i>

                                                <?php
 } ?>
                                                
                                                </div>
                                            <?php
 } ?>
                                        </td>
                                    <?php
 } ?>
                                 <tr>
                            <?php
 } ?>


                    </tbody>
                </table>

            </div>
            <div style="margin-bottom: 20px;">
                <input type="submit" class="btn" onClick="checkForm()" value="下一步" style="width: 10%;margin-left: 43%;font-size:18px;background: #feca14;color: #fff;" />
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
        $(function() {
            $('#data').datetimepicker({
                lang: "ch", //语言选择中文 注：旧版本 新版方法：$.datetimepicker.setLocale('ch');
                format: "Y-m-d", //格式化日期
                timepicker: false, //关闭时间选项		    
                onSelectDate: function(ct, $i) {

                        var data = $("#data").val();
                        var ch = $('#selected').val();
                        $.ajax({
                            type: "post",
                            url: "<?php echo U('Dayin/huoqu');?>",
                            data: {data: data,ch:ch},
                            dataType: "json",
                            success: function(result) {
                                if(result == '过期时间！'){
                                    $("tbody").html('');
                                    var htmls = "<tr><td style='text-align:center;margin-top:10%;font-size:16px;'>当前时间已过期，不能预约！</td><tr>";
                                    $("tbody").append(htmls);
                                }else if (result == '没有查询到数据！') {
                                    $("tbody").html('');
                                    var htmls = "<tr><td style='text-align:center;margin-top:10%;font-size:16px;'>当前没有可以选择的时间段！</td><tr>";
                                    $("tbody").append(htmls);
                                } else {
                                    $("tbody").html('');
                                    var data = eval(result);
                                    $.each(data, function(index, item) {
                                        // var html = "<tr><td>" + index + "</td>";
                                        var html = "<tr>";
                                        var htmls = "";
                                        var i = 0;
                                        var j = 0;
                                        $.each(item, function(res, arr) {
                                            var id = item[res].id;
                                            var time = item[res].time;
                                            var status = item[res].status;
                                            if(time == undefined){
                                                htmls += "<td> </td>";
                                            }else{
                                                if (status == 1) {
                                                    j++;
                                                    htmls += "<td style='width:190px;'><div class='day_dis' value=" + id + " style='background: gray;'>" + time + "<i></i></div></td>";
                                                } else {

                                                    htmls += "<td style='width:190px;'><div class='day' value=" + id + ">" + time + "<i></i></div></td>";
                                                }
                                            }
                                            
                                            i++;
                                        })

                                        // var hy = "<td style='text-align: center;vertical-align: middle;'>" + i + "</td><td style='text-align: center;vertical-align: middle;color:red;'>" + j + "</td>";
                                        // var hm = html + htmls + hy + '</tr>';

                                        var hm = html + htmls + '</tr>';
                                        $('tbody').append(hm);
                                        //$("#fen_duan").attr("colspan", i);

                                    })
                                    $(".day").toggle(function() {
                                        this.style.borderColor = "#f90";
                                        this.style.borderWidth = "2px";
                                        this.style.padding = "1px 3px";
                                        var text = $(this).text();
                                        $(this).find("i").css("display", "block");
                                        var value = this.getAttribute("value") + ',';
                                        var data = $("input[name='id']").val();
                                        var id = data + value;
                                        $("input[name='id']").val(id);
                                        $(this).find("i").css("display", "block");
                                    }, function() {
                                        this.style.borderColor = "#ddd";
                                        this.style.borderWidth = "1px";
                                        this.style.padding = "2px 4px";
                                        var value = this.getAttribute("value");
                                        var strs = new Array(); //定义一数组 
                                        var data = $("input[name='id']").val();
                                        var str = data.substring(0, data.length - 1);
                                        var strs = str.split(",");
                                        var array = new Array();
                                        for (i = 0; i < strs.length; i++) {
                                            if (value != strs[i]) {
                                                array += strs[i] + ',';
                                            }
                                        }
                                        $("input[name='id']").val(array);
                                        $(this).find("i").css("display", "none");
                                    });
                                }
                            }
                        });
                    
                    

                }
            })
            var myDate = new Date();
            var ch = $("#ch").val();
            var year = myDate.getFullYear();
            var month = myDate.getMonth() + 1;
            var strDate = myDate.getDate();
            if (month >= 1 && month <= 9) {
                month = "0" + month;
            }
            if (strDate >= 0 && strDate <= 9) {
                strDate = "0" + strDate;
            }
            var datatime = year + '-' + month + '-' + strDate;
            $("#data").val(datatime)
        })
        //select option 请求
        function select_request(){
            
            var data = $("#data").val();
            var ch = $('#selected').val();
            $.ajax({
                type: "post",
                url: "<?php echo U('Dayin/huoqu');?>",
                data: {data: data,ch:ch},
                dataType: "json",
                success: function(result) {
                    if(result == '过期时间！'){
                        $("tbody").html('');
                        var htmls = "<tr><td style='text-align:center;margin-top:10%;font-size:16px;'>当前时间已过期，不能预约！</td><tr>";
                        $("tbody").append(htmls);
                    }else if (result == '没有查询到数据！') {
                        $("tbody").html('');
                        var htmls = "<tr><td style='text-align:center;margin-top:10%;font-size:16px;'>当前没有可以选择的时间段！</td><tr>";
                        $("tbody").append(htmls);
                    } else {
                        $("tbody").html('');
                        var data = eval(result);
                        $.each(data, function(index, item) {
                            // var html = "<tr><td>" + index + "</td>";
                            var html = "<tr>";
                            var htmls = "";
                            var i = 0;
                            var j = 0;
                            $.each(item, function(res, arr) {
                                var id = item[res].id;
                                var time = item[res].time;
                                var status = item[res].status;
                                if(time == undefined){
                                    htmls += "<td> </td>";
                                }else{
                                    if (status == 1) {
                                        j++;
                                        htmls += "<td style='width:190px;'><div class='day_dis' value=" + id + " style='background: gray;'>" + time + "<i></i></div></td>";
                                    } else {
                                        htmls += "<td style='width:190px;'><div class='day' value=" + id + ">" + time + "<i></i></div></td>";
                                    }
                                }
                                
                                i++;
                            })

                            // var hy = "<td style='text-align: center;vertical-align: middle;'>" + i + "</td><td style='text-align: center;vertical-align: middle;color:red;'>" + j + "</td>";
                            // var hm = html + htmls + hy + '</tr>';

                            var hm = html + htmls + '</tr>';
                            $('tbody').append(hm);
                            //$("#fen_duan").attr("colspan", i);

                        })
                        $(".day").toggle(function() {
                            this.style.borderColor = "#f90";
                            this.style.borderWidth = "2px";
                            this.style.padding = "1px 3px";
                            var text = $(this).text();
                            $(this).find("i").css("display", "block");
                            var value = this.getAttribute("value") + ',';
                            var data = $("input[name='id']").val();
                            var id = data + value;
                            $("input[name='id']").val(id);
                            $(this).find("i").css("display", "block");
                        }, function() {
                            this.style.borderColor = "#ddd";
                            this.style.borderWidth = "1px";
                            this.style.padding = "2px 4px";
                            var value = this.getAttribute("value");
                            var strs = new Array(); //定义一数组 
                            var data = $("input[name='id']").val();
                            var str = data.substring(0, data.length - 1);
                            var strs = str.split(",");
                            var array = new Array();
                            for (i = 0; i < strs.length; i++) {
                                if (value != strs[i]) {
                                    array += strs[i] + ',';
                                }
                            }
                            $("input[name='id']").val(array);
                            $(this).find("i").css("display", "none");
                        });
                    }
                }
            });
        }

       
        function checkForm() {
            var valarr = [];//时间段id（排班id），
            for(var i = 0; i < $('.day').length;i++){
                if($('.day')[i].style.borderWidth == "2px"){
                    valarr.push($('.day')[i].getAttribute('value'));
                }
            }

            var data_date = $("#data").val();//预约日期
            var ch = $('#selected').val();//预约车号
            
            var id = $("input[name='id']").val();
            var str = id.substring(0, id.length - 1);
            var time = str.split(",");
            var jx = $('#date2').val();//驾校id
            var jl = $('#date1').val();//教练id
            
            if(valarr == ''){
            	alert('请选择时间段！');
            	return false;
            }
            if(valarr.length > 3){
                alert('单次预约最多选择3个小时！');
                return false;
            }
            if(data_date == ''){
            	alert('请选择预约日期！');
            	return false;
            }
            if(ch == ''){
            	alert('请选择车号！');
            	return false;
            }
            if (jx == '') {
                alert('请选择驾校！');
                return false
            }
            if (jl == '') {
                alert('请选择教练！');
                return false
            }
            $.ajax({
                type: "post",
                url: "<?php echo U('Jxyueche/xz_xueyuan');?>",
                data: {
                    data: data_date,
                    ch: ch,
                    jx: jx,
                    jl: jl,
                    time_pid:valarr
                },
                dataType: "json",
                success: function(result) {
                    if (result.status == 0) {
                        // alert(result.msg);
                        window.location.href = result.url;
                    } else {
                        alert(result.msg);
                        return false;
                    }
                }
            });
        }
    </script>
    <script>
        $(".day").toggle(function() {
            //alert(11)
            this.style.borderColor = "#f90";
            this.style.borderWidth = "2px";
            this.style.padding = "1px 3px";
            var text = $(this).text();
            $(this).find("i").css("display", "block");
            var value = this.getAttribute("value") + ',';
            //alert(value)
            var data = $("input[name='id']").val();
            var id = data + value;
            $("input[name='id']").val(id);
            //var text = $(this).text();
            $(this).find("i").css("display", "block");
        }, function() {
            this.style.borderColor = "#ddd";
            this.style.borderWidth = "1px";
            this.style.padding = "2px 4px";
            var value = this.getAttribute("value");
            var strs = new Array(); //定义一数组 
            var data = $("input[name='id']").val();
            var str = data.substring(0, data.length - 1);
            var strs = str.split(",");
            var array = new Array();
            for (i = 0; i < strs.length; i++) {
                if (value != strs[i]) {
                    array += strs[i] + ',';
                }
            }
            $("input[name='id']").val(array);
            $(this).find("i").css("display", "none");
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