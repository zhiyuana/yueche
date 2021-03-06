<?php

namespace Addons\Forms\Controller;

use Home\Controller\AddonsController;

class WapController extends AddonsController {
	var $model;
	var $forms_id;
	function index() {
		$this->model = $this->getModel ( 'forms_value' );
		$this->forms_id = I ( 'forms_id', 0 );
		//$this->forms_id = 2;
		$id = I ( 'id' );
		
		$forms = M ( 'forms' )->find ( $this->forms_id );
		$forms ['cover'] = ! empty ( $forms ['cover'] ) ? get_cover_url ( $forms ['cover'] ) : ADDON_PUBLIC_PATH . '/background.png';
		$forms ['intro'] = str_replace ( chr ( 10 ), '<br/>', $forms ['intro'] );
		$this->assign ( 'forms', $forms );
		
		if (! empty ( $id )) {
			$act = 'save';
			
			$data = M ( get_table_name ( $this->model ['id'] ) )->find ( $id );
			$data || $this->error ( '数据不存在！' );
			
			// dump($data);
			$value = unserialize ( htmlspecialchars_decode ( $data ['value'] ) );
			// dump ( $value );
			unset ( $data ['value'] );
			$data = array_merge ( $data, $value );
			$this->assign ( 'data', $data );
			// dump($data);
		} else {
			$act = 'add';
			if ($this->mid != 0 && $this->mid != '-1') {
				$map ['uid'] = $this->mid;
				$map ['forms_id'] = $this->forms_id;
				
				$data = M ( get_table_name ( $this->model ['id'] ) )->where ( $map )->find ();
				if ($data ) {
					$id = $data['id'];
					redirect (U('index',array('forms_id'=>$this->forms_id,'id'=>$id)));
				}
			}
		}
		
		//dump ( $forms );exit;
		$map ['forms_id'] = $this->forms_id;
		$map ['token'] = get_token ();
		$fields = M ( 'forms_attribute' )->where ( $map )->order ( 'sort asc, id asc' )->select ();
		
		if (IS_POST) {
			//dump($fields);
			dump($_POST);exit;
			foreach ( $fields as $vo ) {
				$error_tip = ! empty ( $vo ['error_info'] ) ? $vo ['error_info'] : '请正确输入' . $vo ['title'] . '的值';
				$value = $_POST [$vo ['name']];
				if ($vo['type'] == 'radio' || $vo['type'] == 'checkbox'){
					if (($vo ['is_must'] &&  is_null ( $value )) || (! empty ( $vo ['validate_rule'] ) && ! M ()->regex ( $value, $vo ['validate_rule'] ))) {
						$this->error ( $error_tip );
						exit ();
					}
				}else {
					if (($vo ['is_must'] &&  empty ( $value )) || (! empty ( $vo ['validate_rule'] ) && ! M ()->regex ( $value, $vo ['validate_rule'] ))) {
						$this->error ( $error_tip );
						exit ();
					}
				}
				
				
				$post [$vo ['name']] = $vo ['type'] == 'datetime' ? strtotime ( $_POST [$vo ['name']] ) : $_POST [$vo ['name']];
				unset ( $_POST [$vo ['name']] );
				
			}
			//dump($post);exit;
			$_POST ['value'] = serialize ( $post );
			$act == 'add' && $_POST ['uid'] = $this->mid;
			//dump($_POST);exit;
			$Model = D ( parse_name ( get_table_name ( $this->model ['id'] ), 1 ) );
			
			// 获取模型的字段信息
			$Model = $this->checkAttr ( $Model, $this->model ['id'], $fields );
			
			if ($Model->create () && $res = $Model->$act ()) {
				// 增加积分
				add_credit ( 'forms' );
				
				$param ['forms_id'] = $this->forms_id;
				$param ['id'] = $act == 'add' ? $res : $id;
				$param ['model'] = $this->model ['id'];
				$url = empty ( $forms ['jump_url'] ) ? U ( 'index', $param ) : $forms ['jump_url'];
				
				$tip = ! empty ( $forms ['finish_tip'] ) ? $forms ['finish_tip'] : '提交成功，谢谢参与';
				$this->success ( $tip, $url, 5 );
			} else {
				$this->error ( $Model->getError () );
			}
			exit ();
		}
		
		$fields [] = array (
				'is_show' => 4,
				'name' => 'forms_id',
				'value' => $this->forms_id 
		);
		$this->assign ( 'fields', $fields );
		
		if($this->forms_id == 10){
			header("Content-type:text/html;charset=utf-8");
			$mid = $_SESSION['juye_home']['mid'];
			$jiaxiao = M('jiaxiao');
			$list = $jiaxiao -> field(' id,jxname ') -> select();
			foreach ($list as $k => $v) {
				 $list[$k]['jxname'] = urlencode ( $v['jxname'] );  
			}
			$json = urldecode ( json_encode ( $list ) );
			$this->assign('json',$json);
			$this->assign('mid',$mid);
			$this->display ('xueyuan');
		}else if($this->forms_id == 11){
			//获取教练列表
			// $mid = $_SESSION['juye_home']['mid'];
			// $xueyuan = M('xueyuan');
			// $jiaolian = M('jiaolian');
			// $where['uid'] = $mid;
			// $list = $xueyuan->where($where)->find();
			// $jx = $list['jx'];
			// $where1['jxid'] = $jx;
			// $jiaolian_list = $jiaolian->where($where1)->select();
			// $this->assign('jiaolian_list',$jiaolian_list);
			$this->display ('yueche');
		}else if($this->forms_id == 12){
			//待支付订单
			$wid = $_SESSION['juye_home']['wid'];
			$weizhifu = M('weizhifu');
			$paiban = M('paiban');
			$xueyuan = M('xueyuan');
			$where1['w.id'] = $wid;
			$w_list = $weizhifu->table('wp_weizhifu w')
					->join('wp_xueyuan x on w.xid = x.id')
					// ->join('wp_jiaolian j on w.jid = j.id')
					->field('*,w.id as id')
					->where($where1)
					->select();
			$tuan = $w_list[0]['tuan'];
			$tuan_arr = explode(',',$tuan);
			if($tuan_arr[0] != ""){
				for ($i=0; $i < count($tuan_arr); $i++) { 
					$peop_list[] = $xueyuan->field('id,xname,xphone,xcard')->where('id = '.$tuan_arr[$i])->select();
				}
			}
			
			for ($j=0; $j < count($peop_list); $j++) { 
				if($peop_list[$j][0]['xcard'] == $w_list[0]['xcard']){
					unset($peop_list[$j]);
				}
			}
			$datatime = strtotime($w_list[0]['addtime']);
			$pid = $w_list[0]['pid'];
			$pid_arr = explode(",", $pid);
			for ($i=0; $i < count($pid_arr); $i++) { 
				$where['id'] = $pid_arr[$i];
				$p_list[] = $paiban->where($where)->select();
			}
			//支付总金额
			$money = $w_list[0]['money'] * 100;
			if($money == '' || $money == 0){
				$money = 1;
			}

			$jsApi = new \Org\Util\JsApi_pub();
			// var_dump($jsApi);die;
			 // var_dump($money);die;

			//=========步骤1：网页授权获取用户openid============
			//通过code获得openid
			if (!isset($_GET['code']))
			{
				// 触发微信返回code码
				$url = $jsApi->createOauthUrlForCode();
				// $url = $jsApi->createOauthUrlForCode(\Org\Util\WxPayConf_pub::JS_API_CALL_URL);
				// var_dump($url);die;
				Header("Location: $url");
			}else
			{
				//获取code码，以获取openid
				$code = $_GET['code'];
				$jsApi->setCode($code);
				$openid = $jsApi->getOpenId();
			}

			// var_dump($code);die;
			//=========步骤2：使用统一支付接口，获取prepay_id============
			//使用统一支付接口
			$unifiedOrder = new \Org\Util\UnifiedOrder_pub();
			//设置统一支付接口参数
			//设置必填参数
			//appid已填,商户无需重复填写
			//mch_id已填,商户无需重复填写
			//noncestr已填,商户无需重复填写
			//spbill_create_ip已填,商户无需重复填写
			//sign已填,商户无需重复填写
			$unifiedOrder->setParameter("openid",$openid);//商品描述
			$unifiedOrder->setParameter("body","驾驶人考试中心预约缴费");//商品描述
			//自定义订单号，此处仅作举例
			$timeStamp = time();
			// $out_trade_no = \Org\Util\WxPayConf_pub::APPID.$timeStamp;date('Ymd') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT)
			// $out_trade_no = date('Ymd') . time() . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
			$out_trade_no = $w_list[0]['out_trade_no'];
			if($out_trade_no == ""){
				$out_trade_no = date('Ymd') . time() . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
			}
			$unifiedOrder->setParameter("out_trade_no",$out_trade_no);//商户订单号
			$unifiedOrder->setParameter("total_fee",$money);//总金额
			$unifiedOrder->setParameter("notify_url",\Org\Util\WxPayConf_pub::NOTIFY_URL);//通知地址
			$unifiedOrder->setParameter("trade_type","JSAPI");//交易类型

			$prepay_id = $unifiedOrder->getPrepayId();
			//=========步骤3：使用jsapi调起支付============
			// var_dump($prepay_id);die;
			$jsApi->setPrepayId($prepay_id);
			
			$jsApiParameters = $jsApi->getParameters();
			//微信支付参数
			$this->assign('jsApiParameters',$jsApiParameters);

			$this->assign('datatime',$datatime);
			$this->assign('w_list',$w_list);
			$this->assign('peop_list',$peop_list);
			$this->assign('p_list',$p_list);
			$this->display ('zhifu');
		}else if($this->forms_id == 13){
			$dingdan = M('dingdan');
			$mid = $_SESSION['juye_home']['mid'];
			$paiban = M('paiban');
			$d_list = $dingdan->where(array('uid'=>$mid))->order(' id desc')->select();
			// var_dump($d_list);die;
			$this->assign('d_list',$d_list);
			$this->display ('dingdan');
		}else if($this->forms_id == 14){
			$this->display('wode');
		}else{
			$this->display('index');
		}
	}


	//获取教练
	public function jiaolian(){
		$jxid = $_POST['id'];
		$jiaolian = M('jiaolian');
		$where['jxid'] = $jxid;
		$list = $jiaolian->field(' id,jname ')->where($where)->select();
		if($list){
			foreach ($list as $k => $v) {
				 $list[$k]['jname'] = urlencode ( $v['jname'] );  
			}
			$json = urldecode ( json_encode ( $list ) );
			echo $json;die;
		}else{
			echo '没有教练';die;
		}
	}

	//退款页面
	public function tuikuan(){
		$id = I('id');
		$dingdan = M('dingdan');
		$where['d.id'] = $id;
		$list = $dingdan->table('wp_dingdan d')
				->join('wp_xueyuan x on d.uid = x.uid')
				->where($where)
				->field('*,d.id as id')
				->find();
		$this->assign('list',$list);
		$this->display();
	}

	//个人信息
	public function xueyuan(){
		$jxid = I('jxid');
		$jid = I('jid');
		$jiaxiao = M('jiaxiao');
		$jiaolian = M('jiaolian');
		$where['id'] = $jxid;
		$jiaxiao_list = $jiaxiao->field('id,jxname')->where($where)->select();
		// var_dump($jiaxiao_list);die;
		$map['id'] = $jid;
		$jiaolian_list = $jiaolian->field('id,jname')->where($map)->select();
		$this->assign('jiaxiao_list',$jiaxiao_list);
		$this->assign('jiaolian_list',$jiaolian_list);
		$this->display();
	}

	//驾校列表
	public function jiaxiao_list(){
		header("Content-type:text/html;charset=utf-8");
		$jiaxiao = M('jiaxiao');
		$list = $jiaxiao -> field(' id,jxname ') -> select();
		foreach ($list as $k => $v) {
			 $list[$k]['jxname'] = urlencode ( $v['jxname'] );  
		}
		$json = urldecode ( json_encode ( $list ) );
		// var_dump($json);die;
		$this->assign('json',$json);
		$this->display();
	}

	//教练列表
	public function jiaolian_list(){
		$jxid = I('jxid');
		$jiaolian = M('jiaolian');
		$where['jxid'] = $jxid;
		$list = $jiaolian->field(' id,jname ')->where($where)->select();
		if($list){
			foreach ($list as $k => $v) {
				 $list[$k]['jname'] = urlencode ( $v['jname'] );  
			}
			$json = urldecode ( json_encode ( $list ) );
		}
		// var_dump($jxid);die;
		$this->assign('jxid',$jxid);
		$this->assign('json',$json);
		$this->display();
	}

	//退款提交
	public function addtuikuan(){
		$id = I('id');
		$twark = I('twark');
		$refund_fee = I('refund_fee');
		$koufei = I('koufei');
		// echo $twark;die;
		$dingdan = M('dingdan');
		$paiban = M('paiban');
		$data['status'] = 3;
		$data['shuoming'] = $twark;
		$data['refund_fee'] = $refund_fee;
		$data['koufei'] = $koufei;
		$where['id'] = $id;
		$list = $dingdan->where($where)->find();
		$pid = $list['pid'];
		$pid_arr = explode(',', $pid);
		for ($i=0; $i < count($pid_arr); $i++) { 
			$map['id'] = $pid_arr[$i];
			$paiban_list = $paiban->where($map)->find();
			if($paiban_list['status'] == 1){
				$date['status'] = 0;
				$paiban_id = $paiban->where($map)->save($date);
			}
		}
		//修改订单表状态
		$updingdan = $dingdan->where($where)->save($data);
		// echo $dingdan->getlastsql();die;
		//查询订单表
		// $list = $dingdan->where($where)->find();
		// $date['uid'] = $list['uid'];
		// $date['xid'] = $list['xid'];
		// $date['jid'] = $list['jid'];
		// $date['pch'] = $list['pch'];
		// $date['pdata'] = $list['pdata'];
		// $date['ptime'] = $list['ptime'];
		// $date['pid'] = $list['pid'];
		// $date['dbh'] = $list['dbh'];
		// $date['km'] = $list['km'];
		// $date['money'] = $list['money'];
		// $date['fs'] = $list['fs'];
		// $date['status'] = $list['status'];
		// $date['fs'] = $list['fs'];
		// $date['mch_id'] = $list['mch_id'];
		// $date['transaction_id'] = $list['transaction_id'];
		// $date['out_trade_no'] = $list['out_trade_no'];
		// $date['time_end'] = $list['time_end'];
		// $date['twark'] = $twark;
		// $date['taddtime'] = date('Y-m-d H:i:s',time());
		// $tuikuan = M('tuikuan');
		// $add = $tuikuan->data($date)->add();
		if($updingdan == 1){
			$result['url'] = "http://yueche.siwoinfo.com/index.php?s=/addon/Forms/Wap/index/forms_id/13/publicid/1.html";
		}else{
			$result['status'] = 0;
			$result['msg'] = '退款申请提交失败';
		}
		$this->ajaxReturn($result);
	}

	//退款申请接口
	// public function refund(){
	// 	$id = I('id');
	// 	$dingdan = M('dingdan');
	// 	$where['d.id'] = $id;
	// 	$list = $dingdan->table('wp_dingdan d')
	// 			->join('wp_xueyuan x on d.uid = x.uid')
	// 			->where($where)
	// 			->find();
	// 	$transaction_id = $list['transaction_id'];//微信订单号
	// 	$total_fee = $list['money'] * 100;//订单金额
	// 	$refund_fee = $list['money'] * 100; //退款金额
	// 	// var_dump($refund_fee);die;
	// 	$refund_no = date('Ymd') . time() . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);//退款单号 唯一
	// 	$op_user_id = $list['xname'];
	// 	// var_dump($list);die;
	// 	$jsApi = new \Org\Util\JsApi_pub();
	// 	$Refund_pub = new \Org\Util\Refund_pub();
	// 	$Refund_pub->setParameter('transaction_id',$transaction_id);
	// 	$Refund_pub->setParameter('total_fee',$total_fee);
	// 	$Refund_pub->setParameter('refund_fee',$refund_fee);
	//     $Refund_pub->setParameter('out_refund_no',$refund_no);
	//     $Refund_pub->setParameter('op_user_id',$op_user_id);
	//     $arr = $Refund_pub->getResult();
	// 	if($arr['result_code'] == 'SUCCESS'){
	// 		$time = date('Y-m-d H:i:s',time());
	// 		$data['uid'] = $list['uid'];
	// 		$data['xid'] = $list['xid'];
	// 		$data['jid'] = $list['jid'];
	// 		$data['pch'] = $list['pch'];
	// 		$data['pdata'] = $list['pdata'];
	// 		$data['ptime'] = $list['ptime'];
	// 		$data['pid'] = $list['pid'];
	// 		$data['dbh'] = $list['dbh'];
	// 		$data['km'] = $list['km'];
	// 		$data['fs'] = $list['fs'];
	// 		$data['status'] = 1;
	// 		$data['mch_id'] = $arr['mch_id'];
	// 		$data['transaction_id'] = $arr['transaction_id'];
	// 		$data['out_trade_no'] = $arr['out_trade_no'];
	// 		$data['out_refund_no'] = $arr['out_refund_no'];
	// 		$data['refund_id'] = $arr['refund_id'];
	// 		$data['refund_fee'] = $arr['refund_fee'] / 100;
	// 		$data['taddtime'] = $time;
	// 		$tuikuan = M('tuikuan');
	// 		$result = $tuikuan->data($data)->add();
	// 		if($result){
	// 			$map['id'] = $id;
	// 			$date['status'] = 1;
	// 			$return = $dingdan->where($map)->save($date);
	// 			if($return){
	// 				$this->success('退款成功');
	// 			}
	// 		}
	// 	}else{
	// 		if($arr['err_code_des'] != ''){
	// 			$error = $arr['err_code_des'];
	// 		}else{
	// 			$error = '提交业务失败';
	// 		}
	// 		$this->error($error);
	// 	}
		

	// }

	//回调页面  根据session的wid查询订单拿到订单信息  存到订单表(money,dbh,uid,status) 添加成功之后删除未支付表订单 
	public function notify_url(){
		$xml = file_get_contents('php://input', 'r');
		$array_data = json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA));
		// file_put_contents('./Public/1.php', $array_data);
		$array = json_decode($array_data,true);
		if($array != ""){
			if($array['result_code'] == "SUCCESS"){
				$weizhifu = M('weizhifu');
				$out_trade_no = $array['out_trade_no'];
				$where['out_trade_no'] = $out_trade_no;
				$weizhifu_list = $weizhifu->where($where)->find();
				$xue_info = json_encode($weizhifu_list);
				$user_openid = $array['openid'];
				$where_public_follow['openid'] = $user_openid;
				$public_follow_list = M('public_follow')->where($where_public_follow)->find();
				$public_follow_info = json_encode($public_follow_list);
				file_put_contents('./Public/log.txt', $array_data.'-'.$xue_info.'-'.$public_follow_info.' & ', FILE_APPEND);
				// $session_uid = $_SESSION['juye_home']['mid'];
				// file_put_contents('./Public/test.txt', $array_data.'-'.$xue_info.'->'.$session_uid.' & ', FILE_APPEND);
				if($weizhifu_list){
					$wout_trade_no = $weizhifu_list['out_trade_no'];
					if($out_trade_no == $wout_trade_no){
						$dingdan = M('dingdan');
						$paiban = M('paiban');
						$data['uid'] = $weizhifu_list['uid'];
						$data['xid'] = $weizhifu_list['xid'];
						$data['jid'] = $weizhifu_list['jid'];
						$data['pid'] = $weizhifu_list['pid'];
						$data['tuan'] = $weizhifu_list['tuan'];
						$data['dbh'] = $weizhifu_list['dbh'];
						$data['num'] = $weizhifu_list['num'];
						$data['shouxu'] = $weizhifu_list['shouxu'];
						$data['fs'] = 1;
						$pid = explode(',',$weizhifu_list['pid']);
						for ($i=0; $i < count($pid); $i++) { 
							$list[] = $paiban->field('time')->where(array('id'=>$pid[$i]))->find();
						}
						for ($j=0; $j < count($list); $j++) { 
							$time .= $list[$j]['time'].',';
						}
						$ch = $paiban->field('ch,data')->where(array('id'=>$pid[0]))->find();
						$data['status'] = 0;
						$data['pch'] = $ch['ch'];
						$data['pdata'] = $ch['data'];
						$data['ptime'] = substr($time, 0, -1);
						$data['money'] = $array['total_fee'] * 0.01;
						$data['mch_id'] = $array['mch_id'];
						$data['transaction_id'] = $array['transaction_id'];
						$data['out_trade_no'] = $array['out_trade_no'];
						$data['time_end'] = $array['time_end'];
						$data['daddtime'] = date('Y-m-d H:i:s',time());
						$dingdan_id = $dingdan->data($data)->add();
						if($dingdan_id && $dingdan_id != 0){
							$map['out_trade_no'] = $out_trade_no;
							$weizhifu_id = $weizhifu->where($map)->delete();
							if($weizhifu_id){
								echo 'SUCCESS';
							}else{
								$map1['id'] = $dingdan_id;
								$d_id = $dingdan->where($map1)->delete();
							}
							
						}else{
							echo 'FAIL';
						}
					}else{
						echo 'FAIL';
					}
				}else{
					echo 'FAIL';
				}

				
			}else{
				echo 'FAIL';
			}
			
		}else{
			echo 'FAIL';
		}
		
	}

	//支付完成之后插入订单表
	public function Dingdan(){
		// $json = file_get_contents("./Public/1.php");
		// $dingdan = json_decode($json,true);

		$mid = $_SESSION['juye_home']['mid'];
		// echo $mid;die;
		$weizhifu = M('weizhifu');
		$wid = $_SESSION['juye_home']['wid'];
		$where['id'] = $wid;
		$weizhifu_list = $weizhifu->where($where)->find();
		$jsApi = new \Org\Util\JsApi_pub();
		$Query_pub = new \Org\Util\OrderQuery_pub();
		$out_trade_no = $weizhifu_list['out_trade_no'];
		$Query_pub->setParameter('out_trade_no',$out_trade_no);
	    $dingdan = $Query_pub->getResult();
		$data['uid'] = $mid;
		$data['xid'] = $weizhifu_list['xid'];
		$data['jid'] = $weizhifu_list['jid'];
		$data['pid'] = $weizhifu_list['pid'];
		$data['tuan'] = $weizhifu_list['tuan'];
		$data['dbh'] = $weizhifu_list['dbh'];
		$data['num'] = $weizhifu_list['num'];
		$data['shouxu'] = $weizhifu_list['shouxu'];
		$data['fs'] = 1;
		$pid = explode(',',$weizhifu_list['pid']);
		$paiban = M('paiban');
		for ($i=0; $i < count($pid); $i++) { 
			$list[] = $paiban->field('time')->where(array('id'=>$pid[$i]))->find();
		}
		for ($j=0; $j < count($list); $j++) { 
			$time .= $list[$j]['time'].',';
		}
		$ch = $paiban->field('ch,data')->where(array('id'=>$pid[0]))->find();
		if($dingdan['result_code'] == 'SUCCESS'){
			$data['status'] = 0;
		}else{
			$data['status'] = $dingdan['return_msg'];
		}
		$data['pch'] = $ch['ch'];
		$data['pdata'] = $ch['data'];
		$data['ptime'] = substr($time, 0, -1);
		$data['money'] = $dingdan['total_fee'] * 0.01;
		$data['mch_id'] = $dingdan['mch_id'];
		$data['transaction_id'] = $dingdan['transaction_id'];
		$data['out_trade_no'] = $dingdan['out_trade_no'];
		$data['time_end'] = $dingdan['time_end'];
		$data['daddtime'] = date('Y-m-d H:i:s',time());
		// var_dump($data);die;
		$dingdan = M('dingdan1');
		$dingdan_id = $dingdan->data($data)->add();
		if($dingdan_id){
			$map['id'] = $wid;
			$weizhifu_id = $weizhifu->where($map)->delete();
			if($weizhifu_id){
				$_SESSION['juye_home']['wid'] = '';
				$result['status'] = 1;
				$result['url'] = "http://yueche.siwoinfo.com/index.php?s=/addon/Forms/Wap/index/forms_id/13/publicid/1.html";
			}else{
				$result['status'] = 0;
				$result['msg'] = "请重新取消订单！";
			}
			$this->ajaxReturn($result);
		}else{
			$result['status'] = 0;
			$result['msg'] = "订单添加失败,请去考试中心联系管理员";
			$this->ajaxReturn($result);
		}
	}


	//详情页
	public function zhifu_xq(){
		$this->display();
	}

	//订单详情
	public function dingdan_xq(){
		$id = I('id');
		$xiangqing = M('dingdan');
		$where['d.id'] = $id;
		$xq_list = $xiangqing->table('wp_dingdan d')
					->join('wp_xueyuan x on d.uid = x.uid')
					->where($where)
					->select();

		$xueyuan = M('xueyuan');			
		$tuan = $xq_list[0]['tuan'];
		$tuan_arr = explode(',',$tuan);
		if($tuan_arr[0] != ""){
			for ($i=0; $i < count($tuan_arr); $i++) { 
				$peop_list[] = $xueyuan->field('id,xname,xphone,xcard')->where('id = '.$tuan_arr[$i])->select();
			}
		}
		
		for ($j=0; $j < count($peop_list); $j++) { 
			if($peop_list[$j][0]['xcard'] == $xq_list[0]['xcard']){
				unset($peop_list[$j]);
			}
		}

		$this->assign('xq_list',$xq_list);
		$this->assign('peop_list',$peop_list);
		$this->display();
	}

	 public function readCard(){
		 $serverId = $_POST['serverId'];
		 $access_token = get_access_token ();
		 if($serverId && $access_token){
		 $path = './Uploads/card/';//定义保存路径
		 $url= "https://api.weixin.qq.com/cgi-bin/media/get?access_token=".$access_token."&media_id=".$serverId."";
		  //获取微信“获取临时素材”接口返回来的内容
		  $str = file_get_contents($url);  
		  $timeImg = time().rand().".jpg";
		  $resource = fopen($path.$timeImg , 'w+');
		  //将图片内容写入上述新建的文件  
		  fwrite($resource, $str);  
		  //关闭资源  
		  fclose($resource);
		  $img_url = 'http://'.$_SERVER['HTTP_HOST'].__ROOT__.'/'.$path.$timeImg;
		  $arr = readIdCard($img_url);
		  echo $arr;
		  die;
		}else{
			echo json_encode('请重新上传身份证照片！');die;
		}
	}

	//排班显示
	public function Paiban(){
		$ch = $_POST['ch'];
		$data = $_POST['data'];
		$paiban = M('paiban');
		$list = $paiban->where(array('ch'=>$ch,'data'=>$data))->select();
		if($list){
			echo json_encode($list);die;
		}else{
		   $result['status'] = 0;
		   $result['msg'] = "当前没有可以选择的车辆！";
		   $this->ajaxReturn($result);
		}
	}

	//提交订单  选择联系人
	public function xuanze(){
		$mid = $_SESSION['juye_home']['mid'];
		$wid = $_SESSION['juye_home']['wid'];
		$xueyuan = M('xueyuan');
		$where['uid'] = $mid;
		$list = $xueyuan->where($where)->select();
		if(!$list){
			$result['status'] = 0;
			$result['msg'] = '请您先完善个人资料！';
			$result['url'] = "http://yueche.siwoinfo.com/index.php?s=/addon/Forms/Wap/index/forms_id/10/publicid/1.html";
			$this->ajaxReturn($result);
		}
		if($wid != ''){
			$result['status'] = 0;
			$result['msg'] = "您还有未完成的订单！";
			$result['url'] = "http://yueche.siwoinfo.com/index.php?s=/addon/Forms/Wap/index/forms_id/12/publicid/1.html";
			$this->ajaxReturn($result);
		}
		$id = $_POST['id'];
		$_SESSION['juye_home']['pid'] = $id;
		$result['url'] = "http://yueche.siwoinfo.com/index.php?s=/addon/Forms/Wap/lianxiren/";
		$this->ajaxReturn($result);
	}

	//提交订单
	public function addDingdan(){
		$wid = $_SESSION['juye_home']['wid'];
		$mid = $_SESSION['juye_home']['mid'];
		if($wid != ""){
			$result['status'] = 0;
			$result['msg'] = "您还有未完成的订单！";
			$this->ajaxReturn($result);
		}
		if($mid == "" || $mid == 0){
			$result['status'] = 0;
			$result['msg'] = "对不起,获取不到您的微信ID,请尝试重新关注公众号！";
			$this->ajaxReturn($result);
		}
		$xueyuan = M('xueyuan');
		$paiban = M('paiban');
		$weizhifu = M('weizhifu');
		$dingdan = M('dingdan');
		$id = $_POST['id'];
		//选择的人
		$str_peop = $_POST['str_peop'];
		if($str_peop == ''){
			$result['status'] = 0;
			$result['msg'] = "对不起,网络不佳,请重新刷新页面！";
			$this->ajaxReturn($result);
		}

		//时间段
		$str = $_POST['str'];
		$id_arr = explode(",", $str);
		// $str = substr($id,0,strlen($id_arr)-1);
		for($h=0;$h < 5;$h++){
			for ($i=0; $i < count($id_arr); $i++) { 
				$map1['uid'] = $mid;
				// $map1['pdata'] = date('Y-m-d',time());
				// $map1['status'] = 0;
				$chongfu = $dingdan->where($map1)->where("status = 0 || status = 3")->find();
				// echo json_encode($chongfu);die;
				//判断有没有重复下单
				if(count($chongfu) > 0){
					$result['status'] = 0;
					$result['msg'] = "对不起,您今天的订单已达上限！";
					$this->ajaxReturn($result);
				}
				$pdata = date('Y-m-d',time());
				$chongfu = $dingdan->where($map1)->where("pdata = ".$pdata)->find();
				if(count($chongfu) > 0){
					$result['status'] = 0;
					$result['msg'] = "对不起,您今天的订单已达上限！";
					$this->ajaxReturn($result);
				}
				//判断当前时间段的状态
				$map['id'] = $id_arr[$i];
				$map['status'] = 1;
				$status = $paiban->where($map)->find();
				if($status){
					$result['status'] = 0;
					$result['msg'] = "当前时间段已经被预约,请重新刷新！";
					$this->ajaxReturn($result);
				}
				//查询未支付订单列表 有没有人已经预约了
				$weizhifu_list = $weizhifu->select();
				foreach ($weizhifu_list as $k => $v) {
					$parr = explode(',',$v['pid']);
					if(in_array($id_arr[$i], $parr)){
						$result['status'] = 0;
						$result['msg'] = "当前时间段已经被预约,请重新刷新！";
						$this->ajaxReturn($result);
					}				
				}

			}
		}
		//学员id
		$list = $xueyuan->where(array('uid'=>$mid))->select();
		if($list[0]['jl_id'] == 0 || $list[0]['jl_id'] == ""){
			$result['status'] = 0;
			$result['msg'] = "对不起,没有获取到您的教练员信息,请去个人信息修改页面进行修改！";
			$this->ajaxReturn($result);
		}
		if($list){
			$out_trade_no = getOut_trade_no();
			$num = count($id_arr);
			$money = $num * 150;
			// $shouxu = $money * 0.006;
			// $zongjia = $money + $shouxu;
			$data['xid'] = $list[0]['id'];
			$data['uid'] = $mid;
			$data['jid'] = $list[0]['jl_id'];
			// $data['jxid'] = $list[0]['jx'];
			// $data['pid'] = $id;
			$data['pid'] = $str;
			$data['tuan'] = $str_peop;
			$data['addtime'] = date('Y-m-d H:i:s',time());
			$data['dbh'] = date('Ymd') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
			$data['out_trade_no'] = $out_trade_no;
			// $data['money'] = $zongjia;
			$data['money'] = $money;
			// $data['shouxu'] = $shouxu;
			$data['num'] = $num;
			$data['status'] = 1;
			// $data['jid'] = $jiaolian;
			$wid = $weizhifu->data($data)->add();
			if($wid){
				$_SESSION['juye_home']['wid'] = $wid;
				for ($i=0; $i < count($id_arr); $i++) { 
					 $date['status'] = 1;
					 $where['id'] = $id_arr[$i];
					$status = $paiban->where($where)->save($date);
				}
				$result['status'] = 1;
				// $result['url'] = addons_url('Forms://Wap/Dingdan?wid='.$wid);
				$result['url'] = "http://yueche.siwoinfo.com/index.php?s=/addon/Forms/Wap/index/forms_id/12/publicid/1.html";
			}else{
				$result['status'] = 0;
				$result['msg'] = "提交订单失败！";
			}
			$this->ajaxReturn($result);
		}else{
			$result['status'] = 2;
			$result['url'] = "http://yueche.siwoinfo.com/index.php?s=/addon/Forms/Wap/index/forms_id/10/publicid/1.html";
			$this->ajaxReturn($result);
		}
	}


	//确认付款之前最后一次查询订单
	public function chaxun(){
		$weizhifu = M('weizhifu');
		$dingdan = M('dingdan');
		$paiban = M('paiban');
		$wid = $_SESSION['juye_home']['wid'];
		$where['id'] = $wid;
		$list = $weizhifu->where($where)->find();
		$pid = $list['pid'];
		$pid_arr = explode(',', $pid);
		//查询未支付订单列表 有没有人已经预约了
		$weizhifu_list = $weizhifu->select();
		for ($i=0; $i < count($pid_arr); $i++) { 
			foreach ($weizhifu_list as $k => $v) {
				$parr = explode(',',$v['pid']);
				if(in_array($pid_arr[$i], $parr)){
					$result['status'] = 0;
					$result['msg'] = "当前时间段已经被预约,请重新刷新！";
					$this->ajaxReturn($result);
				}				
			}
			$map['id'] = $pid_arr[$i];
			$paiban_list = $paiban->where($map)->find();
			$pdata = $paiban_list['data'];
			$ptime = $paiban_list['time'];
			$where1['pdata'] = $pdata;
			$dingdan_list = $dingdan->where($where1)->select();
			foreach ($dingdan_list as $k => $v) {
				$time = explode(',', $v['ptime']);
				if(in_array($ptime, $time)){
					$result['status'] = 0;
					$result['msg'] = "下手慢啦,当前时间段已经被别人抢走啦！";
					$this->ajaxReturn($result);
				}
			}

		}
		$result['status'] = 1;
		$this->ajaxReturn($result);
		
		
	}


	// //订单详情页
	// public function Dingdan(){
	// 	$wid = $_GET['wid'];
	// 	$weizhifu = M('weizhifu');
	// 	$paiban = M('paiban');
	// 	$w_list = $weizhifu->where(array('id'=>$wid))->select();
	// 	$datatime = strtotime($w_list[0]['addtime']);
	// 	$pid = $w_list[0]['pid'];
	// 	$pid_arr = explode(",", $pid);
	// 	for ($i=0; $i < count($pid_arr); $i++) { 
	// 		$where['id'] = $pid_arr[$i];
	// 		$p_list[] = $paiban->where($where)->select();
	// 	}

	// 	$this->assign('datatime',$datatime);
	// 	$this->assign('w_list',$w_list);
	// 	$this->assign('p_list',$p_list);
	// 	$this->display ('zhifu');
	// }
	

	//取消订单
	public function Qxdingdan(){
		$wid = $_POST['wid'];
		$weizhifu = M('weizhifu');
		$paiban = M('paiban');
		$w_list = $weizhifu->where(array('id'=>$wid))->select();
		$pid = $w_list[0]['pid'];
		$pid_arr = explode(",", $pid);
		for ($i=0; $i < count($pid_arr); $i++) { 
			$data['status'] = 0;
			 $where['id'] = $pid_arr[$i];
			$status = $paiban->where($where)->save($data);
		}

		$date['status'] = 2;
		$w_list = $weizhifu->where('id = '.$wid)->delete();
		if($w_list == 1){
			$_SESSION['juye_home']['wid'] = '';
			$result['status'] = 1;
			$result['url'] = "http://yueche.siwoinfo.com/index.php?s=/addon/WeiSite/WeiSite/index/publicid/1.html";
		}else{
			$result['status'] = 0;
			$result['msg'] = "请重新取消订单！";
		}
		$this->ajaxReturn($result);
	}


	//添加联系人
	public function lianxiren(){
		$mid = $_SESSION['juye_home']['mid'];
		// var_dump($mid);die;
		$lianxiren = M('lianxiren');
		$xueyuan = M('xueyuan');
		$where['l.uid'] = $mid;
		$list = $lianxiren->table('wp_lianxiren l')
					->join('wp_xueyuan x on l.xid = x.id')
					->field('*,x.id as id')
					->where($where)
					->select();
		$map['uid'] = $mid;
		$user = $xueyuan->where($map)->select();
		$pid = $_SESSION['juye_home']['pid'];
		// var_dump($pid);die;
		$this->assign('user',$user);
		$this->assign('list',$list);
		$this->assign('pid',$pid);
		$this->display();
	}


	//添加常用联系人
	public function addXueyuan(){
		if(IS_POST){
			 $xueyuan = M('xueyuan');
			 $lianxiren = M('lianxiren');
			 $mid = $_SESSION['juye_home']['mid'];
			 $where['uid'] = $mid;
			 $user = $xueyuan->where($where)->select();
			 if(!$user){
			 	$result['status'] = 0;
			 	$result['msg'] = "请您先完善自己的个人资料！";
			 	$this->ajaxReturn($result);
			 }
			 $card = I('card');

			//非主约人不能同天继续约车
			$where_xcard['xcard'] = $card;
			$where_data['pdata'] = date('Y-m-d');
			$xueyuan_res = M('xueyuan')->where($where_xcard)->select();
			if($xueyuan_res){
			 	$dingdan_res = M('dingdan')->where($where_data)->select();
			 	 // $xueyuan_res['id']
			 	 foreach($dingdan_res as $k=>$v){
			 	 	
			 	 	if(strpos($v['tuan'],$xueyuan_res[0]['id']) !== false){
			 	 		$result['status'] = 0;
			 	 		$result['msg'] = '非主约人不能同天继续约车!';
			 	 		$this->ajaxReturn($result);
			 	 	}
			 	}
			 }

			 $map['xcard'] = $card;
			 $xue = $xueyuan->where($map)->select();
			 if($xue){
			 	$where1['xcard'] = $card;
			 	$where1['uid'] = $mid;
			 	$yuan = $xueyuan->where($where1)->select();
			 	if($yuan){
			 		$result['status'] = 0;
			 		$result['msg'] = "对不起,不能添加本人为常用联系人！";
			 	 	$this->ajaxReturn($result);
			 	}
			 	$where2['uid'] = $mid;
			 	$where2['xid'] = $xue[0]['id'];
			 	$yuan1 = $lianxiren->where($where2)->select();
			 	if($yuan1){
			 		$result['status'] = 0;
			 		$result['msg'] = "对不起,此用户已经存在您的常用联系人列表当中,不能重复添加！";
			 	 	$this->ajaxReturn($result);
			 	}
			 	//存在获取学员id
			 	$date['xid'] = $xue[0]['id'];
			 	$date['uid'] = $mid;
			 	$lxr_id = $lianxiren->data($date)->add();
			 	if($lxr_id && $lxr_id != 0){
			 	 	$result['msg'] = "添加成功！";
			 	 	$result['url'] = "http://yueche.siwoinfo.com/index.php?s=/addon/Forms/Wap/lianxiren/";
			 	 	$this->ajaxReturn($result);
			 	}else{
			 		$result['status'] = 0;
			 		$result['msg'] = "添加失败！";
			 	 	$this->ajaxReturn($result);
			 	}
			 }else{
			 	//不存在插入
			 	 $jxid = $user[0]['jx'];
			 	 $jid = $user[0]['jl_id'];
				 $name = I('name');
				 $sex = I('sex');
				 $phone = I('phone');
				 $addr = I('addr');
				 $now_addr = I('now_addr');
				 $birth = I('birth');
				 $xy = 1;
				 $server = I('serverId');	
		         $serverId = $server;
			 	 $access_token = get_access_token ();
			 	 /* if(!$serverId){
			 	 	$result['status'] = 0;
			 	 	$result['msg'] = "请上传身份证照片！";
			 	 	$this->ajaxReturn($result);
			 	 }
			 	 if(!$access_token){
			 		$result['status'] = 0;
			 		$result['msg'] = "身份证上传失败，缺少token值！";
			 		$this->ajaxReturn($result);
			 	 }
			 	 if($serverId && $access_token){
				 	 $path = './Uploads/card/';//定义保存路径
				 	 $url= "https://api.weixin.qq.com/cgi-bin/media/get?access_token=".$access_token."&media_id=".$serverId."";
				 	  //获取微信“获取临时素材”接口返回来的内容
				 	  $str = file_get_contents($url);  
				 	  $timeImg = time().rand().".jpg";
				 	  $resource = fopen($path.$timeImg , 'w+');  
				 	  //将图片内容写入上述新建的文件  
				 	  fwrite($resource, $str);  
				 	  //关闭资源  
				 	  fclose($resource);
				 	  $imgurl = $path.$timeImg;
				 	  $data['ximage'] = $imgurl;
				}else{
					$result['status'] = 0;
					$result['msg'] = "请重新上传图片！";
					$this->ajaxReturn($result);
				} */
				$data['uid'] = 0;
				$data['xcard'] = $card;
				$data['xname'] = $name;
				$data['xsex'] = $sex;
				$data['xphone'] = $phone;
				$data['xaddr'] = $addr;
				$data['xbirth'] = $birth;
				$data['xnow_addr'] = $now_addr;
				$data['xy'] = $xy;
				$data['jx'] = $jxid;
				$data['jl_id'] = $jid;
				$data['xaddtime'] = date('Y-m-d H:i:s',time());
				$list = $xueyuan->data($data)->add();
				if($list){
					$date['xid'] = $list;
				 	$date['uid'] = $mid;
				 	$lianxiren_id = $lianxiren->data($date)->add();
				 	if($lianxiren_id){
				 	 	$result['msg'] = "添加成功！";
				 	 	$result['url'] = "http://yueche.siwoinfo.com/index.php?s=/addon/Forms/Wap/lianxiren/";
				 	 	$this->ajaxReturn($result);
				 	}else{
				 		$result['status'] = 0;
				 		$result['msg'] = "添加联系人失败！";
				 	 	$this->ajaxReturn($result);
				 	}
				}else{
					$result['status'] = 0;
					$result['msg'] = "添加联系人失败！";
				 	$this->ajaxReturn($result);
				}
			 }
	 	}else{
			$this->display();
		}
	}

	//学员个人信息添加
	public function xueyuan_add(){
		 $xueyuan = M('xueyuan');
		 $mid = $_SESSION['juye_home']['mid'];
		 if($mid == ""){
		 	$result['status'] = 0;
		 	$result['msg'] = "对不起,没有获取到您的微信ID,请尝试重新关注公众号！";
		 	$this->ajaxReturn($result);
		 }
		 $where['uid'] = $mid;
		 $user = $xueyuan->where($where)->select();
		 if($user){
		 	$result['status'] = 0;
		 	$result['msg'] = "您的信息已经存在！";
		 	$this->ajaxReturn($result);
		 }
		 $card = I('card');
		 
		 //判断是否是教练员
		 $where_jl['jcard'] = $card;
		 $is_jiaolian = M('jiaolian');
		 $jiaolian_res = $is_jiaolian ->where($where_jl)->select();
		 if($jiaolian_res){
		 	$result['status'] = 0;
		 	$result['msg'] = "教练员不能约车!";
		 	$this->ajaxReturn($result);
		 }
		 //非主约人不能同天继续约车
		 // $where_tuan['xcard'] = $card;
		 // $where_data['pdata'] = date('Y-m-d');
		
		 // $xueyuan_res = M('xueyuan')->where($where_xcard)->select();
		 // if($xueyuan_res){
		 // 	 $dingdan_res = M('dingdan')->where($where_data)->select();
		 // 	 // $xueyuan_res['id']
		 // 	 foreach($dingdan_res['tuan'] as $k=>$v){
		 // 	 	if(strpos($v,$xueyuan_res['id']) !== false){
		 // 	 		$result['status'] = 0;
		 // 	 		$result['msg'] = '非主约人不能同天继续约车!';
		 // 	 		$this->ajaxReturn($result);
		 // 	 	}
		 // 	 }
		 // }
		 
		 $map['xcard'] = $card;
		 $user = $xueyuan->where($map)->find();
		 if($user){
		 	if($user['uid'] == 0 || $user['uid'] == ""){
		 		$id = $user['id'];
		 		$date['uid'] = $_SESSION['juye_home']['mid'];
		 		$map1['id'] = $id;
		 		$xueyuan_id = $xueyuan->where($map1)->save($date);
		 		if($xueyuan_id){
		 			$result['status'] = 1;
		 			$result['url'] = "http://yueche.siwoinfo.com/index.php?s=/addon/WeiSite/WeiSite/index/publicid/1.html";
		 		}else{
		 			$result['status'] = 0;
		 			$result['msg'] = "信息提交失败！";
		 		}
		 		$this->ajaxReturn($result);

		 	}else{
		 		$result['status'] = 0;
		 		$result['msg'] = "您的信息已经存在！";
		 		$this->ajaxReturn($result);
		 	}
		 }

		 $name = I('name');
		 $sex = I('sex');
		 $phone = I('phone');
		 $addr = I('addr');
		 $now_addr = I('now_addr');
		 $birth = I('birth');
		 $jxid = I('jxid');
		 $jid = I('jid');
		 if($jxid == ""){
		 	$result['status'] = 0;
		 	$result['msg'] = "对不起,没有获取到您的驾校信息，请重新刷新页面！";
		 	$this->ajaxReturn($result);
		 }
		 if($jid == ""){
		 	$result['status'] = 0;
		 	$result['msg'] = "对不起,没有获取到您的教练员信息，请重新刷新页面！";
		 	$this->ajaxReturn($result);
		 }
		 $xy = 1;
		 $server = I('serverId');	
         $serverId = $server;
	 	 $access_token = get_access_token ();
	 	 /* if(!$serverId){
	 	 	$result['status'] = 0;
	 	 	$result['msg'] = "请上传身份证照片！";
	 	 	$this->ajaxReturn($result);
	 	 }
	 	 if(!$access_token){
	 		$result['status'] = 0;
	 		$result['msg'] = "身份证上传失败，缺少token值！";
	 		$this->ajaxReturn($result);
	 	 }
	 	 if($serverId && $access_token){
		 	 $path = './Uploads/card/';//定义保存路径
		 	 $url= "https://api.weixin.qq.com/cgi-bin/media/get?access_token=".$access_token."&media_id=".$serverId."";
		 	  //获取微信“获取临时素材”接口返回来的内容
		 	  $str = file_get_contents($url);  
		 	  $timeImg = time().rand().".jpg";
		 	  $resource = fopen($path.$timeImg , 'w+');  
		 	  //将图片内容写入上述新建的文件  
		 	  fwrite($resource, $str);  
		 	  //关闭资源  
		 	  fclose($resource);
		 	  $imgurl = $path.$timeImg;
		 	  $data['ximage'] = $imgurl;
		}else{
			$result['status'] = 0;
			$result['msg'] = "请重新上传图片！";
			$this->ajaxReturn($result);
		} */
		$data['uid'] = $_SESSION['juye_home']['mid'];
		$data['xcard'] = $card;
		$data['xname'] = $name;
		$data['xsex'] = $sex;
		$data['xphone'] = $phone;
		$data['xaddr'] = $addr;
		$data['xbirth'] = $birth;
		$data['xnow_addr'] = $now_addr;
		$data['xy'] = $xy;
		$data['jx'] = $jxid;
		$data['jl_id'] = $jid;
		$data['xaddtime'] = date('Y-m-d H:i:s',time());
		$list = $xueyuan->data($data)->add();
		if($list){
			$result['status'] = 1;
			$result['url'] = "http://yueche.siwoinfo.com/index.php?s=/addon/WeiSite/WeiSite/index/publicid/1.html";
		}else{
			$result['status'] = 0;
			$result['msg'] = "请重新提交个人信息！";
		}
		$this->ajaxReturn($result);
	}

	//学员信息修改
	public function editxueyuan(){
		// var_dump($_SESSION);die;
		$xueyuan = M('xueyuan');
		$jiaolian = M('jiaolian');
		$jiaxiao = M('jiaxiao');
		if(IS_POST){
			$id = I('id');
			if(!$id){
				$result['status'] = 0;
				$result['msg'] = "对不起,没有获取到您的ID,请重新刷新页面！";
				$this->ajaxReturn($result);
			}
			$phone = I('phone');
			$jl_id = I('jl_id');
			$mid = $_SESSION['juye_home']['mid'];
			if($jl_id == '' || $jl_id == 0 || $jl_id == "0"){
				$result['status'] = 0;
				$result['msg'] = "对不起,获取不到您的教练信息,请重新刷新页面！";
				$this->ajaxReturn($result);
			}
			$data['xphone'] = $phone;
			$data['jl_id'] = $jl_id;
			$data['mid'] = $mid;
			$where['id'] = $id;
			$list = $xueyuan->where($where)->save($data);
			if($list == 1){
				$result['status'] = 1;
				$result['url'] = "http://yueche.siwoinfo.com/index.php?s=/addon/Forms/Wap/index/forms_id/14/publicid/1.html";
			}else{
				$result['status'] = 0;
				$result['msg'] = "信息修改失败";
			}
			$this->ajaxReturn($result);
		}
		 $mid = $_SESSION['juye_home']['mid'];
		 $where['uid'] = $mid;
		 $list = $xueyuan->table('wp_xueyuan x')
		 				 ->join('wp_jiaxiao jx on x.jx = jx.id')
		 				 ->join('wp_jiaolian jl on x.jl_id = jl.id')
		 				 ->field('*,x.id as id')
		                 ->where($where)
		                 ->find();
		 if(!$list){
		 	$list = $xueyuan->table('wp_xueyuan x')
	 					 ->join('wp_jiaxiao jx on x.jx = jx.id')
	 					 ->field('*,x.id as id')
	 	                ->where($where)
	 	                ->find();
		 }
		 $jx = $list['jx'];
		 $map['jxid'] = $jx;
		 $map1['id'] = $jx;
		 //教练列表
		 $jiaolian_list = $jiaolian->field('id,jname')->where($map)->select();
		 foreach ($jiaolian_list as $k => $v) {
			 $jiaolian_list[$k]['jname'] = urlencode ( $v['jname'] );  
		 }
		 $json = urldecode ( json_encode ( $jiaolian_list ) );

		 $this->assign('list',$list);
		 $this->assign('json',$json);
		 $this->display();
	}

	//退费须知
	public function tuifeixuzhi(){
		$this->display();
	}

	//协议
	public function xieyi(){
		$this->display();
	}


	
	
	function http_get_data($url) {    

		$ch = curl_init ();    
		curl_setopt ( $ch, CURLOPT_CUSTOMREQUEST, 'GET' );    
		curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, false );    
		curl_setopt ( $ch, CURLOPT_URL, $url );    
		ob_start ();    
		curl_exec ( $ch );    
		$return_content = ob_get_contents ();    
		ob_end_clean ();    
			
		$return_code = curl_getinfo ( $ch, CURLINFO_HTTP_CODE );    
		return $return_content; 
						
	} 
		
	function upload(){
	  $url = "http://file.api.weixin.qq.com/cgi-bin/media/get?access_token=".$token."&media_id=".$media_id."";
	  $return_content = http_get_data($url);
	  $file_url="Uploads/yueche/jiaolian/card/";
	  file_put_contents($file_url,$return_content);
		
	}
			 
	
	function yijianHandle(){
		/*
		   意见提交页
		*/
		 $fields = M ( 'forms_value' );
		 //$attribute = M('forms_attribute');
		 $data['uid'] = $this->mid;
		 $data['forms_id'] = 1;
		 //$lists_select =$attribute->where(array('forms_id'=>$data['forms_id']))->select();
		 //dump($lists_select);exit;
		 $data['token']=get_token ();
		 $time=time();
		 $data['cTime']=$time;
		 $data1['attr_1_1'] = I('attr_1_1');
		 $data1['attr_1_0'] = I('attr_1_0');
		 $data1['attr_1_2'] = I('select_content');
		 //echo $data1['attr_1_2']; exit;
		 $data1['attr_1_3'] = I('attr_1_3');

		 $data1['attr_1_4'] = I('attr_1_4');
		 $data['value'] =  serialize($data1);
		  //dump($data1['attr_1_3']);exit;
		 $result=$fields->data($data)->add();
		 //$this->assign('lists_select',$lists_select);
		  if($result){
			 echo 1;
		 }else{
			 echo 0;
		 }
		
	}
	
	function yueche(){
			$attribute = M('forms_attribute');
			$lists_select =$attribute->where(array('id'=>8))->select();
			//dump($list_select);exit;
			$this->assign('lists_select',$lists_select);
			$this->display ();
		
	}
	
	function jubaoHandle(){
		/*
		   举报提交页
		*/
		//dump($_POST);exit;
		$this->forms_id = 2;
		$forms  = M ( 'forms' )->find ( $this->forms_id );
		$forms ['cover'] = ! empty ( $forms ['cover'] ) ? get_cover_url ( $forms ['cover'] ) : ADDON_PUBLIC_PATH . '/background.png';
		$forms ['intro'] = str_replace ( chr ( 10 ), '<br/>', $forms ['intro'] );
		$this->assign ( 'forms', $forms );
		 $fields = M ( 'forms_value' );
		 //$attribute = M('forms_attribute');
		 $data['uid'] = $this->mid;
		 $data['forms_id'] = 2;
		 
		 $data['token']=get_token ();
		 $time=time();
		 $data['cTime']=$time;
		 $jubao_addr = I('jubao_addr');
		 $data['addr'] = $jubao_addr;
		 
		 $data['zuobiao']	= I('jubao_zuobiao');	 
		 //dump($data);die;
		 $data1['attr_2_0'] = I('attr_2_0');
		 
		 $data1['attr_2_1'] = I('attr_2_1');
		 
		 $data1['attr_2_2'] = I('attr_2_2');
		 $data1['attr_2_3'] = I('select_content');
		 $data1['attr_2_4'] =I('attr_2_4') ;
		 //dump($data1['attr_2_4']);exit;
		 $data1['attr_2_5'] = I('attr_2_5');
		 $data['value'] =  serialize($data1);
		  
		 $result=$fields->data($data)->add();
		 
		 if($result){
			 echo 1;
		 }else{
			 echo 0;
		 }
	}
	


	
	
	 //获取经纬度
	// public function jubaozb(){
	// 	$jing = I('jing','116.313082');
	// 	$wei = I('wei','40.047669');
	// 	if ($jing && $wei){
	// 		$jingwei = getAddr($jing,$wei);
	// 		//     		echo '<pre>';
	// 		$jingwei = json_decode($jingwei,true);
	// 		$arr['addr'] = $jingwei['result']['formatted_address'];
	// 		$arr['area'] = $jingwei['result']['addressComponent'];
	// 		 //   		print_r($arr);
	// 		echo json_encode($arr);
	// 	}else{
	// 		echo "没有获取到经纬度";die;
	// 	}
	// }
	
	
}
