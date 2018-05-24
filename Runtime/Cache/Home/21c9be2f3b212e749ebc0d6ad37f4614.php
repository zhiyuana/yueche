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
  <script type="text/javascript" src="/Public/static/dingdan/js/bootstrap.min.js"></script>
  <style>
   	.MsoNormal{mso-style-name: 正文;mso-style-parent: "";margin: 0pt;margin-bottom: .0001pt;mso-pagination: none;
    text-align: justify;text-justify: inter-ideograph;font-family: 'Times New Roman';font-size: 10.5000pt;mso-font-kerning: 1.0000pt;}
  </style>
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
        
        	<div class="call" style="border: 1px solid #ddd;overflow: hidden;padding: 20px;margin: 20px;display: none;">
		       <form  id="form" method="post"  onsubmit="return checkForm();" style="display: inline-block;float: left;width: 600px;">
		       	<div  style="padding: 10px 20px;">
		       <table class="s1" >
		          <tr>
		            <td>
		            	 <input type="hidden" name="jx" id="jx" value="<?php echo ($jx); ?>">
		            	<input type="hidden" name="jl" id="jl" value="<?php echo ($jl); ?>">
		                <table width="400" border="1" style="color:#0011CC;"  >
		                  <tr>
		                    <td align="right">提示信息</td>
		                    <td><input name="tResult" type="text" size="40" /></td>
		                    
		                  </tr>
		                  <tr>		                  
		                    <td align="right">姓名</td>
		                    <td><input name="tNameL" id="tName"  type="text" size="40" /></td>
		                  </tr>
		                  <tr>		                   
		                    <td align="right">性别</td>
		                    <td><input name="tSexL"  type="text" size="40" /></td>
		                  </tr>		 
		                  <tr>
		                    <td align="right">公民身份号码</td>
		                    <td><input name="tcardID" id="tcardID" type="text" size="40" /></td>		                    
		                  </tr>
		                  <tr>		                  
		                    <td align="right">手机号</td>
		                    <td><input name="phone" id="phone" value="" type="text" size="40" /></td>
		                  </tr>		                 
		                </table>
		             </td>
		       </tr>
		     </table>
		    </div>
		    </form>
		    <div style="float: left;margin-top: 10px;margin-left: 50px;">
			<OBJECT
				  classid="clsid:F1317711-6BDE-4658-ABAA-39E31D3704D3"                  
				  codebase="SDRdCard.cab#version=1,3,6,4"
				  width=330
				  height=210
				  align=center
				  hspace=0
				  vspace=0
				  id=idcard
				  name=rdcard	
			>
			</OBJECT>
    	  	 </div>
    	  	 <!--</div>-->
    	  </div> 
    	 
        <div class="table-striped">
        <div style="padding-bottom: 20px;">
		    <div style="float:left;width: 50%;margin-right: 20px;">
        <a href="<?php echo U('Dayin/dayin_list');?>" style="margin:0 10px;color: #333;padding:6px 12px;">学员预约</a>
        <a href="<?php echo U('Dayin/jxdayin_list');?>" style="margin:0 10px;color: #333;padding:6px 12px;background:#ddd;">驾校预约</a>
        
		    	<label>教练身份证:</label>
		    	<input type="text" id="xcard" name="xcard" value="" style="margin-bottom: 0;"/>
		    </div>
        <input type="submit" onclick="chaxun_jxdingdan()"  value="搜 索" class="btn" >
        
		    
        <p id="xueyuan_name"></p>	

        </div>
       
        </div>
        </div>
    <div id="div_print" style="display:none"> 
    	<p style="display: inline-block;float: right;">NO:<span class="bianhao"></span></p>
    	<div style="clear: both;"></div>
      <h3 style="text-align:center;font-size: 24px;line-height: 28.0000pt;letter-spacing:  2px;margin-top: 0;">数字化考试车使用协议</h4>
      <p class="MsoNormal" style="text-align: left;line-height: 30px;"></p>
      <p class="MsoNormal" style="text-align: left;line-height: 30px;letter-spacing:  2px;font-size: 16px;">甲方:济南市机动车驾驶员考试服务中心</p>
      <!-- <p class="MsoNormal" style="text-align: left;line-height: 30px;letter-spacing:  2px;font-size: 16px;">乙方:学员：<span id="xycard" style="display: inline-block;" ></span></p> -->
      <p class="MsoNormal" style="text-align: left;line-height: 30px;letter-spacing:  2px;font-size: 16px;">乙方:教练员：<span id="jlcard" style="display: inline-block;" ></span></p>
      <p style="text-indent: 32.0000pt;text-align: left;line-height: 30px;letter-spacing:  2px;font-size: 16px;" class="MsoNormal" >甲方提供数字化考试车给乙方使用,为明确甲、乙双方的权利和义务,经双方协商,按照平等互利的自愿原则,就车辆、场地的使用相关事宜签订本协议</p>
        <p style="text-indent: 32.0000pt;text-align: left;line-height: 30px;letter-spacing:  2px;font-size: 16px;" class="MsoNormal" >1、甲方提供的车辆应设备完好齐全、车况干净整洁。</p>
        <p style="text-indent: 32.0000pt;text-align: left;line-height: 30px;letter-spacing:  2px;font-size: 16px;" class="MsoNormal" >2、甲方应保证训练场地完好,环境舒适。</p>
        <p style="text-indent: 32.0000pt;text-align: left;line-height: 30px;letter-spacing:  2px;font-size: 16px;" class="MsoNormal" >3、对乙方在使用甲方提供的车辆过程中应接受甲方的监督和管理。</p>
        <p style="text-indent: 32.0000pt;text-align: left;line-height: 30px;letter-spacing:  2px;font-size: 16px;" class="MsoNormal" >4、乙方凭有效教练证网上预约成功后应提前到窗口办理租车手续。超过预约时间到租车点租车,按实际到达时间登记租车。超过时间不予补足,租车时间结束准时收车。</p>
        <p style="text-indent: 32.0000pt;text-align: left;line-height: 30px;letter-spacing:  2px;font-size: 16px;" class="MsoNormal" >5、为保障训练人员安全,乙方在施教过程中应随车施教,无教练员随车施教的,一经查实甲方有权取消乙方租车资格。</p>
        <p style="text-indent: 32.0000pt;text-align: left;line-height: 30px;letter-spacing:  2px;font-size: 16px;" class="MsoNormal" >6、乙方应确保施训过程中的安全和车辆设备的完好,不按规定施教发生车辆设备损坏或事故的由乙方教练员承担全部责任,造成损失的照价赔偿。</p>
        <p style="text-indent: 32.0000pt;text-align: left;line-height: 30px;letter-spacing:  2px;font-size: 16px;" class="MsoNormal" >7、乙方应服从场地管理人员管理，遵守场地管理规定。严重违规违纪，恶意延迟交车时间，以及上车教练员、学员信息与本协议书不一致的的情况，一经查实甲方有权取消乙方及其所在驾校租车资格。</p>
        <p id="pdata" style="text-indent: 32.0000pt;text-align: left;line-height: 30px;letter-spacing:  2px;font-size: 15px;" class="MsoNormal" ></p>
        <p style="text-indent: 32.0000pt;text-align: left;line-height: 30px;letter-spacing:  2px;font-size: 16px;" class="MsoNormal" >9、本协议履行过程中发生争议。由双方协商解决</p>
        <p style="text-indent: 32.0000pt;text-align: left;line-height: 30px;letter-spacing:  2px;font-size: 16px;" class="MsoNormal" >10、本协议当天车辆使用结束自动失效。</p>  
        <p class="MsoNormal" style="text-align: left;float:left;display:inline-block;margin-top:60px;line-height: 30px;letter-spacing:  2px;font-size: 16px;">甲方:济南市机动车驾驶员考试服务中心</p>
        <p class="MsoNormal" style="text-align: left;margin-left:150px;display:inline-block;margin-top:20px;line-height: 30px;letter-spacing:  2px;font-size: 16px;"><span style="width: 200px;"><br>乙方：教练员</span><!-- <br><span style="width: 200px;">乙方：学员</span> --></p>
    </div>
    <div class="data-table">
        <div class="table-striped">
          <table cellspacing="1">
            <!-- 表头 -->
            <thead>
              <tr>
                <th>编号</th>
                <th>教练姓名</th>
                <th>预约日期</th>
                <th>订单号</th>
                <th>下单时间</th>
                <th>缴费金额</th>
                <th>操作</th>
              </tr>
            </thead>
            <!-- 列表 -->
            <input type='hidden' name='pdata' id='pdata' value="">
            <input type="hidden" id="date_id"  value="" name=""/>
            <tbody class="list">
             
            </tbody>
          </table>
          <script type="text/javascript">
           $("#xcard").click(function(){
			     document.onkeydown=function(event){
             var e = event || window.event || arguments.callee.caller.arguments[0];          
             	if(e && e.keyCode==13){
              	var xcard = $('#xcard').val();
              if(xcard){
                $.ajax({
                      type:"post",
                      url:"<?php echo U('Dayin/chaxun');?>",
                      data:{xcard:xcard},
                      dataType:"json",
                      success:function(data){
                        $('.list').html('');
                        if(data == 0){
                          alert('没有查询到订单！');
                          return false;
                        }else{
                            var list = eval(data);
                             $.each(list, function (index, item) {
                               //循环获取数据    
                               var id = list[index].id;
                               $("#date_id").val(id);                               
                               var xname = list[index].xname;
                               var pdata = list[index].pdata;
                               var ptime = list[index].ptime;
                               var data = pdata + ' ' + ptime;
                               var transaction_id = list[index].transaction_id;
                               if(transaction_id == null){
                                transaction_id = list[index].dbh;
                               }
                               var out_trade_no = list[index].out_trade_no;
                               var daddtime = list[index].daddtime;
                               var money = list[index].money;
                               var pdata = list[index].pdata;
                               $('#pdata').val(pdata);
                               var skip_url =   "http://" + window.location.hostname + window.location.pathname;
                               // alert(pdata)
                               var item = "<tr><td>"+id+"</td><td>"+xname+"</td><td>"+data+"</td><td>"+transaction_id+"</td><td>"+daddtime+"</td><td>"+money+"</td><td><a href="+skip_url+"?s=/Home/Dayin/dayin_xq/id/"+id+">查看</a> | <a onclick='dayin(this)' style='cursor:pointer'>打印</a> | <a href="+skip_url+"?s=/Home/Dayin/down_pdf/id/"+id+" style='cursor:pointer'>下载补打</a></td></tr>"; 
                              $('.list').append(item);  
                            });  
                        }  
                      } 
                    });
              }else{
                alert('请输入学员身份证号');
                return false;
              }
              }
             	}
			 })

//根据教练身份证搜索驾校预约订单信息
function chaxun_jxdingdan(){
  var jl_card = $('#xcard').val();//教练身份证号
  if(jl_card){
    $.ajax({
          type:"post",
          url:"<?php echo U('Dayin/chaxun_jxdingdan');?>",
          data:{jl_card:jl_card},
          dataType:"json",
          success:function(data){
            $('.list').html('');
            if(data == 0){
              alert('没有查询到订单！');
              return false;
            }else{
                var list = eval(data);
                 $.each(list, function (index, item) {
                   //循环获取数据    
                   var id = list[index].id;
                   $("#date_id").val(id);
                   var xname = list[index].jname;
                   var pdata = list[index].pdata;
                   var ptime = list[index].ptime;
                   var data = pdata + ' ' + ptime;
                   var transaction_id = list[index].transaction_id;
                   if(transaction_id == null){
                    transaction_id = list[index].dbh;
                   }
                   var out_trade_no = list[index].out_trade_no;
                   var daddtime = list[index].daddtime;
                   var money = list[index].money;
                   var pdata = list[index].pdata;
                   $('#pdata').val(pdata);
                   var skip_url =   "http://" + window.location.hostname + window.location.pathname;
                   
                   var item = "<tr><td>"+id+"</td><td>"+xname+"</td><td>"+data+"</td><td>"+transaction_id+"</td><td>"+daddtime+"</td><td>"+money+"</td><td><a href="+skip_url+"?s=/Home/Dayin/dayin_xq/id/"+id+">查看</a> | <a onclick='dayin(this)' style='cursor:pointer'>打印</a> | <a href="+skip_url+"?s=/Home/Dayin/down_pdf/id/"+id+" style='cursor:pointer'>下载补打</a></td></tr>"; 
                  $('.list').append(item);  
                });  
            }  
          } 
        });
  }else{
    alert('请输入教练身份证号');
    return false;
  }
}
</script>
<script type="text/javascript">
          function dayin(obj){
          	var idd = $("#date_id").val()
            var pdata = $('#pdata').val();
            var myDate = new Date();  
            var year = myDate.getFullYear();
              var month = myDate.getMonth()+1;   
              var strDate = myDate.getDate(); 
              if (month >= 1 && month <= 9) {
                  month = "0" + month;
              }
              if (strDate >= 0 && strDate <= 9) {
                  strDate = "0" + strDate;
              }
              var datatime = year+'-'+month+'-'+strDate;
              var data_time = year+month+strDate;
              
              var bianhao=data_time+idd;
           	$(".bianhao").html(bianhao)
            if(pdata < datatime){
               alert('当前时间段已过期');
               return false;
            }
             var id = $(obj).parent().parent().children().eq(0).html();
              if(id){
                $.ajax({
                  url:"<?php echo U('Dayin/dayin');?>",
                  type:"POST",
                  data:{id:id},
                  dataType:"json",
                  success:function(result){
                    var list = eval(result[0][0]);
                    var xueyuan_list = eval(result[1]);
                    var changdu = xueyuan_list.length;
                    if(list){
                      var xname = list.xname;
                      var jname = list.jname;
                      //var xycard = list.xcard;
                      var jlcard = list.jcard;
                      var pdata = list.pdata;
                      var ptime = list.ptime;
                      var data = pdata + ' ' + ptime;
                      var ch = list.pch;
                      //$('#xycard').text(xname+' '+xycard);
                      $('#jlcard').text(jname+' '+jlcard);
                      $('#chehao').text(ch);
                      var item = "8、您预约的车号为 "+ch+"号车，预约的时间段为 "+data+",";
                      var item2="";
                      var xueyuan = '';
                      var xue_xcard='';
                        $.each(xueyuan_list,function(i,v){
                          xue_xcard=xueyuan_list[i].xcard;
                          xueyuan = xueyuan_list[i].xname;
                            item2+="学员姓名："+xueyuan+",身份证号："+xue_xcard+"。";
                        });
                      $('#pdata').append(item+item2);
                      var div_print = document.getElementById("div_print");
                      var status = printdiv(div_print);
                       $.ajax({
                          url:"<?php echo U('Dayin/dayin_list');?>",
                          type:"POST",
                          data:{id:id},
                          dataType:"json",
                          success:function(result){
                            var status = result.status;
                            if(status == 0){
                              alert(result.msg);
                              return false;
                            }else{
                              window.location.href = result.url;
                            } 
                          }
                        });
                    }else{
                      alert(result);
                      return false;
                    } 
                }
              });
        }
      }
      function printdiv(printpage) 
      { 
          var newstr = printpage.innerHTML; 
          var oldstr = document.body.innerHTML; 
          document.body.innerHTML =newstr;  
          window.print();
          document.body.innerHTML=oldstr; 
      } 
</script>
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
$(function(){
  
})
$('#datetimepicker').datetimepicker({
	lang:'ch'
});
$('#datetimepicker1').datetimepicker({
	lang:'ch'
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
      $(obj).find('img').attr('src',IMG_PATH+'/icon_sound.png');
    }, false);
    return;
  }
  audio.pause();
  $(obj).find('img').attr('src',IMG_PATH+'/icon_sound.png');
  
}
</script> 
<script for=idcard event="Readed()">
	  getinfo_onclick();
</script>
<script for=idcard event="Closed()">
</script>
<script for=idcard event="Opened()">
</script>
	
<SCRIPT>


function SaveCard_onclick(){
	var  pp
	pp = rdcard.ExportBMP("D:\\"); 
	if(pp==0)
        {
	    document.getElementsByName("tResult")[0].value="保存成功";
        }
        else
        {	
            document.getElementsByName("tResult")[0].value="保存失败: "+pp;
        }
	}
    myopen_onclick();
	function myopen_onclick(){
	var  pp ;
	pp=rdcard.openport();
        //alert(pp);
	if(pp==0)
        {
	    document.getElementsByName("tResult")[0].value="openport成功";
        }
        else
        {	
            document.getElementsByName("tResult")[0].value="openport失败: "+pp;
        }	
    }	
	    
	function myclose_onclick(){
	var  pp
	pp=rdcard.closeport();
	if(pp==0)
        {
	    document.getElementsByName("tResult")[0].value="closeport成功";
        }
        else
        {	
            document.getElementsByName("tResult")[0].value="closeport失败: "+pp;
        }		
	}
        function Unload(){
		MyClose_onclick();
		//alert("Page is Close");
	}

	function endread_onclick(){
	var  pp
	pp=rdcard.endread();
	if(pp==0)
        {
	    document.getElementsByName("tResult")[0].value="endread成功";
        }
        else
        {	
            document.getElementsByName("tResult")[0].value="endread失败: "+pp;
        }		
	}

	function handread_onclick(){ 
		
	var  pp
	pp=rdcard.readcard();
	if(pp==0)
        {
	    document.getElementsByName("tResult")[0].value="readcard成功";
            //showjpg_onclick();
        }
        else
        {	
            document.getElementsByName("tResult")[0].value="readcard失败: "+pp;
        }
	}
	beginread_onclick();
	function beginread_onclick(){
		
	var  pp
	pp=rdcard.ReadCard2();
	if(pp==0)
        {
	    document.getElementsByName("tResult")[0].value="ReadCard2成功";
        }
        else
        {	
            document.getElementsByName("tResult")[0].value="ReadCard2失败: "+pp;
        }
	}
	function read3_onclick(){
		
	var  pp
	pp=rdcard.ReadCard3();
	if(pp==0)
        {
	    document.getElementsByName("tResult")[0].value="ReadCard3成功";
        }
        else
        {	
            document.getElementsByName("tResult")[0].value="ReadCard3失败: "+pp;
        }
	}
    
	function ReadsNum_onclick(){
	var  pp
	pp = rdcard.ReadSecurityNum();
	if(pp==0)
        {
            document.getElementsByName("tsNum")[0].value=rdcard.SecurityNum;	
            document.getElementsByName("tResult")[0].value=rdcard.sResultMsg;
        }
        else
        {
            document.getElementsByName("tsNum")[0].value="读模块号码失败";	
            document.getElementsByName("tResult")[0].value="读模块号码失败: "+pp;
        }
	}
	

	function showjpgIE6(){
        //alert('读照片成功');
        document.getElementsByName("photo")[0].src = "file:///C|/null.JPEG";

	if(rdcard.PhotoPath == "")  
	  document.getElementsByName("photo")[0].src = "file:///C|/null.JPEG";
	else 	
	  document.getElementsByName("photo")[0].src = rdcard.PhotoPath	;	
    }
	function showjpgIE8(){
        //alert('读照片成功');
        document.all['photo'].src  = 'data:image/jpeg;base64,' + rdcard.JPGBuffer;	
    }


     function getinfo_onclick(){
	var  r1,r2;
	
	document.getElementsByName("tNameL")[0].value=rdcard.NameL;
	
	document.getElementsByName("tSexL")[0].value=rdcard.SexL;
	
	document.getElementsByName("tcardID")[0].value=rdcard.CardNo;
	//alert(rdcard.CardNo)
    document.getElementsByName("xcard")[0].value=rdcard.CardNo;
    //alert($("#xcard").val())
//      document.getElementsByName("Fchar1")[0].value=rdcard.FGchar1;
//      document.getElementsByName("Fchar2")[0].value=rdcard.FGchar2;
        r1 = rdcard.FGNUM1;
        r2 = rdcard.FGNUM2;
	switch(r1)
	{
	case 11:
	  document.getElementsByName("FNUM1")[0].value="右手拇指";
	  break;
	case 12:
	  document.getElementsByName("FNUM1")[0].value="右手食指";
	  break;
	case 13:
	  document.getElementsByName("FNUM1")[0].value="右手中指";
	  break;
	case 14:
	  document.getElementsByName("FNUM1")[0].value="右手环指";
	  break;
	case 15:
	  document.getElementsByName("FNUM1")[0].value="右手小指";
	  break;
	case 16:
	  document.getElementsByName("FNUM1")[0].value="左手拇指";
	  break;
	case 17:
	  document.getElementsByName("FNUM1")[0].value="左手食指";
	  break;
	case 18:
	  document.getElementsByName("FNUM1")[0].value="左手中指";
	  break;
	case 19:
	  document.getElementsByName("FNUM1")[0].value="左手环指";
	  break;
	case 20:
	  document.getElementsByName("FNUM1")[0].value="左手小指";
	  break;
	default:
	  document.getElementsByName("FNUM1")[0].value="";
	}	
	switch(r2)
	{
	case 11:
	  document.getElementsByName("FNUM2")[0].value="右手拇指";
	  break;
	case 12:
	  document.getElementsByName("FNUM2")[0].value="右手食指";
	  break;
	case 13:
	  document.getElementsByName("FNUM2")[0].value="右手中指";
	  break;
	case 14:
	  document.getElementsByName("FNUM2")[0].value="右手环指";
	  break;
	case 15:
	  document.getElementsByName("FNUM2")[0].value="右手小指";
	  break;
	case 16:
	  document.getElementsByName("FNUM2")[0].value="左手拇指";
	  break;
	case 17:
	  document.getElementsByName("FNUM2")[0].value="左手食指";
	  break;
	case 18:
	  document.getElementsByName("FNUM2")[0].value="左手中指";
	  break;
	case 19:
	  document.getElementsByName("FNUM2")[0].value="左手环指";
	  break;
	case 20:
	  document.getElementsByName("FNUM2")[0].value="左手小指";
	  break;
	default:
	  document.getElementsByName("FNUM2")[0].value="";
	}


        r1 = rdcard.FGQualityScore1;
        r2 = rdcard.FGQualityScore2;
	if(r1 == 0)  
	  document.getElementsByName("Fzl1")[0].value="";
	else 	
	  document.getElementsByName("Fzl1")[0].value=rdcard.FGQualityScore1;
	if(r2 == 0)  
	  document.getElementsByName("Fzl2")[0].value="";
	else 	
	  document.getElementsByName("Fzl2")[0].value=rdcard.FGQualityScore2;


        r1 = rdcard.FGRegistry1;
        r2 = rdcard.FGRegistry2;
	switch(r1)
	{
	case 1:
	  document.getElementsByName("Fzhuce1")[0].value="注册成功";
	  break;
	case 2:
	  document.getElementsByName("Fzhuce1")[0].value="注册失败";
	  break;
	case 3:
	  document.getElementsByName("Fzhuce1")[0].value="未注册";
	  break;
	case 9:
	  document.getElementsByName("Fzhuce1")[0].value="未知";
	  break;
	default:
	  document.getElementsByName("Fzhuce1")[0].value="";
	}
	switch(r2)
	{
	case 1:
	  document.getElementsByName("Fzhuce2")[0].value="注册成功";
	  break;
	case 2:
	  document.getElementsByName("Fzhuce2")[0].value="注册失败";
	  break;
	case 3:
	  document.getElementsByName("Fzhuce2")[0].value="未注册";
	  break;
	case 9:
	  document.getElementsByName("Fzhuce2")[0].value="未知";
	  break;
	default:
	  document.getElementsByName("Fzhuce2")[0].value="";
	}
        document.getElementsByName("tResult")[0].value=idcard.sResultMsg;
        document.all['photo'].src  = 'data:image/jpeg;base64,' + rdcard.JPGBuffer;	

     }




	function savepath_onclick(){
	rdcard.strSavePath= "c:\\aa";
	document.getElementsByName("tResult")[0].value="路径设置成功";
	}


	function MyClear_onclick(){
        var  pp		
        pp = rdcard.ClearAll();
        getinfo_onclick();
        document.getElementsByName("tsNum")[0].value="";
	if(pp==0)
        {
	    document.getElementsByName("tResult")[0].value="清空成功";
        }
        else
        {	
            document.getElementsByName("tResult")[0].value="清空失败: "+pp;
        }
	}


	function window_onUnload(){
		  rdcard.DeleteOutputFile();
		  rdcard.DeleteAllPicture();
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