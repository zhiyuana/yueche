<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
 <head> 
  <meta charset="utf-8" /> 
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta content="width=device-width,height=device-height,initial-scale=1.0,maximum-scale=1.0,user-scalable=no" name="viewport" />
  <title>首页</title>
<!--   <link rel="stylesheet" type="text/css" href="css/style.css">
  <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" >
  <script type="text/javascript" src="js/jquery.min.js"></script>
  <script type="text/javascript" src="js/bootstrap.min.js"></script> -->
  <link rel="stylesheet" type="text/css" href="<?php echo CUSTOM_TEMPLATE_PATH;?>Index/ColorV5/css/styleche.css">
  <!-- <link rel="stylesheet" type="text/css" href="<?php echo CUSTOM_TEMPLATE_PATH;?>Index/ColorV5/css/bootstrap.min.css" > -->
  <script type="text/javascript" src="<?php echo CUSTOM_TEMPLATE_PATH;?>Index/ColorV5/js/jquery-1.9.1.min.js"></script>
  <script type="text/javascript" src="<?php echo CUSTOM_TEMPLATE_PATH;?>Index/ColorV5/js/jquery.bxslider.js"></script>
  <!-- <script type="text/javascript" src="<?php echo CUSTOM_TEMPLATE_PATH;?>Index/ColorV5/js/bootstrap.min.js"></script> -->
  <link href="<?php echo CUSTOM_TEMPLATE_PATH;?>Index/ColorV5/css/jquery.bxslider.css" rel="stylesheet" type="text/css">
  <style>
  	.b_left{background: #eee;width: 47%;float: left;text-align: center;margin-bottom: 15px;}
  	.b_left:nth-of-type(1),.b_left:nth-of-type(3){margin-right: 6%;}
  	.b_left:nth-of-type(3),.b_left:nth-of-type(4){margin-bottom: 0;}
  	.b_left img{width: 60px;height: 60px;margin-top: 12px;}
  	.b_left span{margin: 10px 0;}
  	.b_left a{display:block;color: #000;}
  	.b_right{float: right;}
  	.more{display: inline-block;float: left;color: #fff;margin-bottom: 0;margin-top: 10px;font-weight: 700;font-size: 16px;}
  	.connect img{height: 40px;width: 40px;float: left;margin-left: 25%;margin-top: 5px;}
  	.connect{background: #feca14;height: 50px;}
  	.gongge{padding: 20px;background: #fff;clear: both;height: 250px;}
  	.contain{padding: 20px;background: #eee;}
  </style>
 </head> 
 <body style="font-family: '微软雅黑';background: #eee;"> 
  <div class="header">
  	<div class="carousel slide" id="myCarousel">
		<!--标示符也就是小圆点-->
<!-- 		<ul class="carousel-indicators" style="position: absolute;left: 76%;bottom: 0px;">
			<li class="active" data-target="#myCarousel" data-slide-to="0"></li>
			<li data-target="#myCarousel" data-slide-to="1"></li>
			<li data-target="#myCarousel" data-slide-to="2"></li>
		</ul> -->
		<div class="carousel-inner clearfix">
      <ul class="clearfix slider2">
        <?php if(is_array($slideshow)): $i = 0; $__LIST__ = $slideshow;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li class="slide">
              <a href="javascript:;"><img src="<?php echo ($vo["img"]); ?>" />
                 <!-- <p class="p_text" style="  padding: 0.4em 0em; padding-left: 4%; position: absolute;  bottom: 0px;  color: #fff;  font-size: 15px;  line-height: 25px; background: rgba(97, 96, 96, 0.54); overflow: hidden; width: 95%;"><?php echo ($vo["title"]); ?></p> -->
              </a>
            </li><?php endforeach; endif; else: echo "" ;endif; ?>  
      </ul> 
<!-- 			<div class="item active">
				<img src="images/jiakao1.png" id="img_jiakao"/>
			</div> -->

<!-- 			<div class="item">
				<img src="images/jiakao1.png" id="img_jiakao"/>
			</div>
			<div class="item">
				<img src="images/jiakao1.png" id="img_jiakao"/>
			</div> -->
		</div>
  </div> 
  </div>
  <div class="connect">
	 <a href="javascript:void(0)" style="display:block;color: #000;">
	 	<img src="<?php echo CUSTOM_TEMPLATE_PATH;?>Index/ColorV5/img/contact.png" alt="联系我们" />
	  	<p class="more">联系我们  了解更多</p>
	 </a> 	
  </div>
  <div class="contain">
  	<div class="gongge">
     <?php if(is_array($category)): $k = 0; $__LIST__ = $category;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?><div class="b_left">
          <a href="<?php echo ($vo["url"]); ?>">
            <img src="<?php echo ($vo["icon"]); ?>" /><br>
            <span><?php echo ($vo["title"]); ?></span>
          </a>
        </div><?php endforeach; endif; else: echo "" ;endif; ?>
  		<!-- <div class="b_left b_right"><a href=""><img src="img/cdgg.png" /><br><span>场地公告</span></a></div>
  		<div class="b_left" style="margin-bottom: 0;"><a href=""><img src="img/yyyc.png" /><br><span>预约用车</span></a></div>
  		<div class="b_left b_right" style="margin-bottom: 0;"><a href=""><img src="img/grxx.png" /><br><span>个人中心</span></a></div> -->
  	</div>
  </div>
  <!--<div class="list_index">
  	<div style="width: 100%;height: 100px;background: #333;" class="lianxi">
  		<a href="场地公告.html" style="width: 100%;height: 100%;"><img src="img/dal/lianxi.png" style="float: left;margin-left: 16%;
    "><p style="float: left;font-size: 24px;
    margin-top: 11px;color: #49c8f7;">联系我们  了解更多</p></a>
  	</div>
    <ul class="clearfix">
        <li><a href="场地公告.html"><img src="img/dal/fagui.png"><p>政策法规</p></a></li>
        <li class="right_li"><a href=""><img src="img/dal/gonggao.png"><p>场地公告</p></a></li>
        <li style="border-bottom: none;"><a href=""><img src="img/dal/yongche.png"><p>预约用车</p></a></li>      
        <li class="right_li" style="border-bottom: none;"><a href=""><img src="img/dal/wode.png"><p>个人中心</p></a></li>
    </ul>
  </div>-->
 </body>
<!--   <script type="text/javascript">
        $(document).ready(function(){
        	$("#myCarousel").carousel({
				interval:3000//每隔2秒切换一次
			})
        });
    </script> -->

    <script type="text/javascript">
        $(document).ready(function(){
          $('.slider2').bxSlider({
            slideWidth: 1200, 
      auto: true,
        autoControls: true,
            minSlides: 1,
            maxSlides: 1,
            slideMargin: 0
          });
        });
    </script>
</html>