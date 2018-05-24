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

    .poy_left{float: left;margin-left: 10%;margin-top: 7%;}
    .poy_left span{display: inline-block}
 </style>
 <input type="hidden" id="code_url" value="">
 <input type="hidden" id="out_trade_no" value="">
  <div class="span9 page_message">  
    <section id="contents">
        <ul class="tab-nav nav">
            <li class="current"><a href="javascript:void(0)">订单信息</a></li>
        </ul>
       <div class="tab-content" style="padding: 20px 40px;"> 

     <li class="line" style="border-bottom: none;"> 
        <div style="width:48%;margin-right: 20px;float: left;">
            <label>驾校名称：</label>            
            <span style="width: 344px;float: right;"><?php echo ($dingdaninfo['jxname']); ?></span> 
        </div>
        <div style="width:48%;float: left;">
            <label>教练姓名：</label>
            <span style="width: 344px;float: right;"><?php echo ($dingdaninfo['jlname']); ?></span> 
        </div>
    </li>
    
    <li class="line">                     
        <div style="width:48%;margin-right: 20px;float: left;">
            <label>预约车号：   </label>
             <span style="width: 344px;float: right;"><?php echo ($dingdaninfo['ch']); ?></span>
        </div>
         <div style="width:48%;margin-right: 20px;float: left;">
            <label>预约日期：  </label>
            <span style="width: 344px;float: right;"><?php echo ($dingdaninfo['data']); ?></span>
        </div>
     </li>
     
    <li class="line">               
        <div style="width:48%;margin-right: 20px;float: left;">
            <label>预约时间段：   </label>
            <span style="width: 344px;float: right;"><?php echo ($dingdaninfo['ptime']); ?></span>
         </div>
         <div style="width:48%;margin-right: 20px;float: left;">
            <label>支付金额：  </label>
            <span style="width: 344px;float: right;"><?php echo ($dingdaninfo['pay_money']); ?></span>
            <input type="hidden" name="pay_money" id="pay_money" value="<?php echo ($dingdaninfo['pay_money']); ?>">
            <input type="hidden" id="paying" name="paying" value="<?php echo ($paying); ?>">
            <input type="hidden" id="pid" name="pid" value="<?php echo ($pid); ?>">
            <input type="hidden" id="datatime" name="datatime" value="<?php echo ($addtime); ?>">
        </div>
         
     </li>
    <?php if(is_array($xueyuan_list)): $i = 0; $__LIST__ = $xueyuan_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li class="line">                     
        <div style="width:48%;margin-right: 20px;float: left;">
            <label>组团人员：   </label>
            <span style="width: 344px;float: right;"><?php echo ($vo["xname"]); ?></span>
        </div>
        <div style="width:48%;margin-right: 20px;float: left;">
            <label>身份证号：   </label>
            <span style="width: 344px;float: right;"><?php echo ($vo["xcard"]); ?></span>
        </div>
    </li><?php endforeach; endif; else: echo "" ;endif; ?>
                 
      <div class="form-item form_bh">
        <div class="poy_left" style="margin-top:0;">
            <span style="font-size: 16px;">等待付款</span>
            <div class="time-item1">剩
            <span id="minute_show1">00分</span>
            <span id="second_show1">00秒</span>自动关闭
          </div>
        </div>
           <!-- <div style="float: left"><span id="m" style="color:red;margin-right:10px;"></span>:<span id="s" style="color:red;margin:0 10px"></span>后自动取消订单</div> -->
            <!-- <a href="<?php echo U('Jxyueche/native_pays',array('paying_id'=>$paying));?>" class="btn" style="float: right;margin-right:10px">去付款</a> -->
            <input type="button" onclick="go_paying()" value="去付款"  class="btn" style="float: right;margin-right:10px">
            <input type="button" onclick="not_pay()" value="取消订单" class="btn" style="float: right;margin-right: 10px;background-color:orange">

        </div> 
        <div align="center" id="qrcode" style="display: none;margin-top:30px;">
          <div id = "over">
            <!-- <input type="button" onclick="finish()" value="完成付款"  class="btn" style="float: right;margin-right:10px"> -->
          </div>
              
       </div>   
    </div>
    </div>
    </section>
    
  </div>

    
    
    <!--<div align="center">
        <p>订单号：<?php echo $out_trade_no; ?></p>
    </div>-->
<!--     <div align="right" style="float:right">
        <form  action="./refund.php" method="post">
            <input name="out_trade_no" type='hidden' value="<?php echo $out_trade_no; ?>">
            <input name="refund_fee" type='hidden' value="1">
            <button type="submit" >未完成付款</button>
        </form>
    </div>
     <div align="right" style="float:right">
        <form  action="./order_query.php" method="post">
            <input name="out_trade_no" type='hidden' value="<?php echo $out_trade_no; ?>">
            <button type="submit" >已完成付款</button>
        </form>
    </div> -->

    <br>

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
    <script src="/Public/static/qrcode.js"></script>

<script type="text/javascript">
// JiShi(15);
function not_pay(){
  var out_trade_no = $('#out_trade_no').val();
  if(out_trade_no != ""){
    $.ajax({
      url:"<?php echo U('Home/Jxyueche/OrderQuery');?>",
      data:{out_trade_no:out_trade_no},
      type:'post',
      success:function(res){
        var status = res.status;
        var url = res.url;
        var msg = res.msg;
        if(msg == 'OK'){
          alert('对不起，您已经完成付款，不能取消该订单！');
          window.location.href = url;
        }else{
          var r=confirm("你确定要取消该订单吗？");
          var paying = $('#paying').val();
          var pid = $('#pid').val();
          if(r == true){
            $.ajax({
              url:"<?php echo U('Jxyueche/cancel_dingdan');?>",
              type:'post',
              data:{paying:paying,pid:pid},
              success:function(result){
                // alert(res.url);return false;
                var ddstatus = result.status;
                if(ddstatus){
                  alert('取消订单成功！');
                  window.location.href = result.url;
                }else{
                  alert('取消订单失败！请重新下单。');
                  return false;
                }
              }
            });
          }
        }
      }
    });
  }else{
    var r=confirm("你确定要取消该订单吗？");
    var paying = $('#paying').val();
    var pid = $('#pid').val();
    if(r == true){
      $.ajax({
        url:"<?php echo U('Home/Jxyueche/cancel_dingdan');?>",
        type:'post',
        data:{paying:paying,pid:pid},
        success:function(res){
          var status = res.status;
          if(status){
            alert('取消订单成功！');
            window.location.href = res.url;
          }else{
            alert('取消订单失败！请联系管理员。');
          }
        }
      });
    }
  }

    
  // }
}
// function JiShi (num){
//     var time = num*60;
//     var t = setInterval(function(){
//         time--;
//         document.getElementById('m').innerHTML = Math.floor(time/60)<10?'0'+Math.floor(time/60):Math.floor(time/60);
//         document.getElementById('s').innerHTML = time%60<10?'0'+time%60:time%60;
//         if(time==0){
//           clearInterval(t);
//           cancel_pay();
//         }
//     },1000)
//  }
function cancel_pay(){
  var paying = $('#paying').val();
  var pid = $('#pid').val();
  $.ajax({
    url:"<?php echo U('Jxyueche/cancel_dingdan');?>",
    type:'post',
    data:{paying:paying,pid:pid},
    success:function(res){
      var status = res.status;
      if(status){
        // alert('已取消订单！');
        window.location.href = res.url;
      }//else{
        // alert('取消订单失败！请联系管理员。');
      // }
    }
  });
}

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

    function time(){         
      //获取下单时间
      // var startime = $("input[name='datatime']").val();
      var startime = $("#datatime").val();
      // alert(startime);
      // console.log(startime);
      //获取15分钟过期时间
      var endtime =parseInt(startime)+900;
      //获取当前时间
      var dangqiantime = parseInt(new Date().getTime()/1000); 
      //当前时间减去过期时间
      var leftTime=endtime-dangqiantime;
      setInterval(function(){
        if(leftTime>=0){                  
          var minute=Math.floor(leftTime/60); 
          //alert(minute);
          var second=Math.floor(leftTime-minute*60); 
          if(minute <= 9) minute = '0' + minute;
          if(second <= 9) second = '0' + second;
          $('#minute_show1').html('<s></s>' + minute + '分');
          $('#second_show1').html('<s></s>' + second + '秒');
          leftTime--;
        }else{
          clearInterval();
          cancel_pay();
        }
      },1000);
    }
    $(function(){
      time();
    });
});

var gopayflag = true;
function go_paying(){
  var paying_id = $('#paying').val();
  $.ajax({
    url:"<?php echo U('Home/Jxyueche/native_pays');?>",
    data:{paying_id:paying_id},
    type:"post",
    success:function(res){
      var status = res.status;
      if(status == 0){
        var code_url = res.code_url;
        var out_trade_no = res.out_trade_no;
        $('#code_url').val(code_url);
        $('#out_trade_no').val(out_trade_no);
        if(gopayflag){
           qrcode_url();
           gopayflag = false;
        }
      }else{
        alert('获取二维码失败,请重试!');
        return false;
      }
    }
  });
}

function qrcode_url(){
  $('#qrcode').css('display','block')
  var code_url = $('#code_url').val();
  var out_trade_no = $('#out_trade_no').val();
  //参数1表示图像大小，取值范围1-10；参数2表示质量，取值范围'L','M','Q','H'
  var qr = qrcode(10, 'M');
  qr.addData(code_url);
  qr.make();
  // console.log(qr.createImgTag());
  var wording=document.createElement('p');
  wording.className = "myp";
  wording.innerHTML = "请使用微信扫描二维码完成付款";
  var code=document.createElement('DIV');
  code.innerHTML = qr.createImgTag();
  var element=document.getElementById("qrcode");
  // console.log(element);
  element.insertBefore(wording,element.children[0]);
  element.insertBefore(code,element.children[0]);
  // code.prependTo($('#qrcode'));
  // wording.prependTo($('#qrcode'));
  intval();
}
// console.log(skip_url + '/index.php?s=/Home/Jxyueche/ding_lis');

function intval(){
  var t = setInterval(function(){
    var out_trade_no = $('#out_trade_no').val();
    $.ajax({
      url:"<?php echo U('Home/Jxyueche/OrderQuery');?>",
      data:{out_trade_no:out_trade_no},
      type:"post",
      success:function(res){
        var msg = res.msg;
        if(msg == "OK"){
          clearInterval(t);
          $('.myp').html('<img src="/Public/static/pay_pic/fukuan.png" width=20; height=20; style="vertical-align:middle;">已完成付款');
          var skip_url =   "http://" + window.location.hostname;
          setTimeout(function(){
          window.location.href = skip_url + '/index.php?s=/Home/Jxyueche/ding_list';
          },3000);
        }
      }
    });
  }, 5000);
}
// function finish(){
//   var out_trade_no = $('#out_trade_no').val();
//   $.ajax({
//     url:"<?php echo U('Home/Jxyueche/OrderQuery');?>",
//     data:{out_trade_no:out_trade_no},
//     type:'post',
//     success:function(res){
//       var status = res.status;
//       var url = res.url;
//       var msg = res.msg;
//       if(status == 0){
//         alert('支付成功！');
//         // alert(msg);
//         clearInterval();
//         window.location.href = url;
//       }else{
//         alert(msg);
//       }
//     }
//   });
// }
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