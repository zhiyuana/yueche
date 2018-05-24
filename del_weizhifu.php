<?php
header("content-type:text/html;charset=utf-8");
//$conn = new mysqli('localhost','root','siwoalidb','yueche');
$conn = new mysqli('localhost','root','20170811siwoinfo!@#','yueche');
if($conn -> connect_errno){
	printf("Connect failed: %s\n",$conn ->connect_error);
	die();
}

//删除未支付订单+更改未支付的排班状态
$sql = "SELECT xid,pid,addtime FROM wp_weizhifu";//删除订单
$query = $conn -> query($sql);
while($res = $query -> fetch_assoc()){
	$xid = $res['xid'];
	$pid = $res['pid'];
	$add_time = $res['addtime'];
	$later_time = strtotime($add_time)+900;//15分钟后
	$now_time = time();//当前时间
	if($now_time >= $later_time){
		$sql_del = "DELETE FROM wp_weizhifu WHERE xid=".$xid;
		$query_del = $conn ->query($sql_del);
		///var_dump($query_del);
		if($query_del){
			$sql_upd = "UPDATE wp_paiban SET status=0 WHERE id in(".$pid.")";
			$query_upd = $conn ->query($sql_upd);
		}
		// var_dump($query_del);
	}
}
$conn -> close();
// var_dump($time1 = strtotime('2017-11-27 11:30:00'));//int(1511753400)
// var_dump($time2 = strtotime('2017-11-27 11:45:00'));//int(1511754300)
// var_dump($time2-$time1);//int(900)