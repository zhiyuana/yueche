<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <title><?php echo empty($page_title) ? C('WEB_SITE_TITLE') : $page_title; ?></title>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
	<meta content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport">
    <meta content="application/xhtml+xml;charset=UTF-8" http-equiv="Content-Type">
    <meta content="no-cache,must-revalidate" http-equiv="Cache-Control">
    <meta content="no-cache" http-equiv="pragma">
    <meta content="0" http-equiv="expires">
    <meta content="telephone=no, address=no" name="format-detection">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <link rel="stylesheet" type="text/css" href="/Public/Home/css/mobile_module.css?v=<?php echo SITE_VERSION;?>" media="all">
    <script type="text/javascript">
		//静态变量
		var SITE_URL = "<?php echo SITE_URL;?>";
		var IMG_PATH = "/Public/Home/images";
		var STATIC_PATH = "/Public/static";
		var WX_APPID = "<?php echo ($jsapiParams["appId"]); ?>";
		var	WXJS_TIMESTAMP='<?php echo ($jsapiParams["timestamp"]); ?>'; 
		var NONCESTR= '<?php echo ($jsapiParams["nonceStr"]); ?>'; 
		var SIGNATURE= '<?php echo ($jsapiParams["signature"]); ?>';
	</script>
    <script type="text/javascript" src="/Public/static/jquery-2.0.3.min.js"></script>
	<script type="text/javascript" src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
	<script type="text/javascript" src="minify.php?f=/Public/Home/js/prefixfree.min.js,/Public/Home/js/m/dialog.js,/Public/Home/js/m/flipsnap.min.js,/Public/Home/js/m/mobile_module.js&v=<?php echo SITE_VERSION;?>"></script>
</head>	
<body style="background:#fff">
<div class="container">
	<div class="appmsg_container">
    	<h6 class="appmsg_title"><?php echo ($info["title"]); ?></h6>
        <p class="appmsg_info"><span class="time"><?php echo (day_format($info["cTime"])); ?></span> <span class="author"><?php echo ($info["author"]); ?></span></p>
        <section class="appmsg_content">
                <?php if(!empty($info[cover_id])): ?><p><img src="<?php echo (get_cover_url($info["cover_id"])); ?>"/></p><?php endif; ?>
                <?php echo (htmlspecialchars_decode($info["content"])); ?>
        </section>
        <?php if(!empty($info[link])): ?><p class="appmsg_foot"><a href="<?php echo ($info["link"]); ?>">阅读原文</a></p><?php endif; ?>
    </div>
</div>
</html>
<script type="text/javascript">
$(function(){
	var imgArray = new Array();
	var img_base = "<?php echo SITE_URL;?>";
	$(".detail img").each(function(){	
	     var src = $(this).attr("src");
	     var key1 = src.indexOf('http') ;
		 var key2 = src.indexOf('Uploads/') ;
		 
		 if(key1=='-1' && key2>0){
			 src = img_base + src;
			 $(this).attr("src", src);
		 }
		 
		 imgArray.push( src );//数组,网页里面所有要查看大图的图片地址列表
	})
	console.log(imgArray);
	$(".detail img").bind("click",function(){
		var currentImg = $(this).attr("src");//当前图片的地址

		  if(typeof WeixinJSBridge !=="undefined"){
			WeixinJSBridge.invoke("imagePreview", {
			  current: currentImg,//查看的当前图片的地址
			  urls:imgArray,//数组,网页里面所有要查看大图的图片地址列表
			});
		   } 
	})	
	$.WeiPHP.initWxShare({
		title:"<?php echo ($info["title"]); ?>",
		desc:'<?php echo ($info["intro"]); ?>',
		imgUrl:'<?php echo (get_cover_url($info["cover_id"])); ?>',
		link:window.location.href
	})
});
</script>