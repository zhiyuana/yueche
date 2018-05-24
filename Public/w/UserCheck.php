<?php
		//这里两句话很重要,第一讲话告诉浏览器返回的数据是xml格式
	header("Content-Type: text/xml;charset=utf-8");
	//告诉浏览器不要缓存数据
	header("Cache-Control: no-cache");
	header("Access-Control-Allow-Origin: *");
 header("Access-Control-Allow-Methods", "POST,OPTIONS,GET");
	$username=$_REQUEST['username'];
	if($username=="shunping"){
		echo "err";
	}else{
		echo "ok";
	}
?>