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
    <script type="text/javascript" src="/Public/static/dingdan/js/bootstrap.min.js"></script>
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

        .select {
            width: 100px;
            height: 37px;
        }
        .day_dis{
            height: 26px;
        }
    </style>
    <div class="span9 page_message">
        <form name="tijiao" action='<?php echo U("Jxyueche/add_dingdan");?>' method="post" id="myform">
        <section id="contents">
            <ul class="tab-nav nav">
            <li class="current"><a href="javascript:void(0)">学员信息</a></li>
            </ul>
            <!-- 数据列表 -->
            <div class="data-table" style="margin-top:0px;">
                <div class="table-striped">
                    <div class="sub">
                        <div class="car_date" style="margin-right: 10px;">
                            <label style="margin:0">驾校：</label>
                            <input type="text" id="jx_name" value="<?php echo ($jxname); ?>" readonly="readonly" />
                            <input type="hidden" name="jxid" id="jxid" value="<?php echo ($jxid); ?>">
                        </div>
                        <div class="car_date" style="margin-right: 10px;">
                            <label style="margin:0">教练：</label>
                            <input type="text" id="jl_name" value="<?php echo ($jname); ?>" readonly="readonly" />
                        </div>
                        <div class="car_date" style="margin-right: 10px;">
                            <label style="margin:0">学员信息：</label>
                            <select name="" id="selected">
                                    <option value="">请选择学员</option>
                                <?php if(is_array($xueyuan_list)): $i = 0; $__LIST__ = $xueyuan_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["xname"]); ?>" xid="<?php echo ($vo["xid"]); ?>" class='myop'><?php echo ($vo["xname"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div style="margin-bottom: 20px;" class="fenduan">
                <table class="table table-bordered">
                    <thead>
                        <th colspan="6">
                            <div style="width: 56px;display: inline-block; ">学员信息</div>
                        </th>
                    </thead>
                    <tbody>
                        <tr class='mytr'>
                            <td style="width:15%;"><div class='day_dis'></div></td>
                            <td style="width:15%;"><div class='day_dis'></div></td>
                            <td style="width:15%;"><div class='day_dis'></div></td>
                            <td style="width:15%;"><div class='day_dis'></div></td>
                            <td style="width:15%;"><div class='day_dis'></div></td>
                            <td style="width:15%;"><div class='day_dis'></div></td>
                        <tr>
                    </tbody>
                </table>

            </div>
            <input type="hidden" name="datainfo" value='<?php echo ($datainfo); ?>' id="datainfo">
            <input type="hidden" name="time_count" value="<?php echo ($time_count); ?>" id="time_count">
            <input type="hidden" name="xid_str" value='' id="xid_str">
            <!-- <input type="hidden" name="originator" value="<?php echo ($code); ?>"> -->
            <div style="margin-bottom: 20px;">
                <input type="button" class="btn" value="下一步" style="width: 10%;margin-left: 43%;font-size:18px;background: #feca14;color: #fff;" />
            </div>
        </section>
        </form>
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

<script>
    //选择学员
    $('#selected').on('change',function(){
        var str = $(this).val();
        var obj = {};
        for(var i = 0; i<$('.myop').length; i++){
            if($('.myop')[i].value==str){
                obj.xid = $($('.myop')[i]).attr('xid');
            }
        }
        for(var i=0;i<$('.day_dis').length;i++){
            if($('.day_dis').eq(i).html()==str){
                return false;
            }else if($('.day_dis').eq(i).html()==''){
                $('.day_dis').eq(i).html(str); 
                $('.day_dis').eq(i).attr('xid',obj.xid)
                return false;
            }
        }
    });
    //删除选择学员
    $('.mytr td').on('click','div',function(e){
       $(e.target).html('');
    })
    //提交选择学员信息
    $('.btn').click(function(){
        var xid_str = '';
        for(var i=0;i<$('.day_dis').length;i++){
            if($('.day_dis').eq(i).html() != ''){
                xid_str += $('.day_dis').eq(i).attr('xid') + ',';
            }
        }
        xid_str = xid_str.substring(0,xid_str.length - 1);
        var strarr = xid_str.split(',');
        var xid_count = strarr.length;//选择学员个数
        var time_count = $('#time_count').val();//预约的小时数
        $("#xid_str").val(xid_str);//给学员input框xid_str赋值

        if($("#xid_str").val() == ''){
            alert('请选择学员！');
            return false;
        }else{
            var time_count2 = time_count*2;
            if(xid_count > time_count2){
                alert('所选学员数量不能超过'+time_count2+'个！');
                return false;
            }else if(xid_count < time_count){
                alert('所选学员数量不能少于'+time_count+'个!');
                return false;
            }else{
                if($("#xid_str").val() != '' &&  $('#datainfo').val() != ''){
                    // $("#myform").submit();
                    var xid_str = $("#xid_str").val();
                    var jxid = $("#jxid").val();
                    var datainfo = $("#datainfo").val();
                    $.ajax({
                        url:"<?php echo U('Jxyueche/add_dingdan');?>",
                        data:{'xid_str':xid_str,'jxid':jxid,'datainfo':datainfo},
                        type:'post',
                        dataType:'json',
                        success:function(res){
                            var status =  res.status;
                            if(status == 0){
                                window.location.href = res.url;
                            }else if(status == 1){
                                alert('订单添加失败，请重新约车！');
                                window.location.href = res.url;
                            }
                        }
                    })
                }else{
                    alert('学员或预约时间信息有误！');
                    return false;
                }
            }
        }
        

        // alert($('#time_count').val());
        // alert($("#xid_str").val());return false;

        
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