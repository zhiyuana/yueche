<?php

namespace Home\Controller;
use Think\Model;
/**
 * 素材管理控制器
 */
class DayinController extends HomeController {
	function _initialize() {
		parent::_initialize ();
		
		$act = strtolower ( ACTION_NAME );
		$param = array (
				'mdm' => I ( 'mdm' ) 
		);
		$res ['title'] = '订单打印';
		$res ['url'] = U ( 'dayin_list', $param );
		$res ['class'] = strpos ( $act, 'dayin_list' ) !== false ? 'current' : '';
		$nav [] = $res;

		// $res ['title'] = '线下约车';
		// $res ['url'] = U ( 'yueche', $param );
		// $res ['class'] = strpos ( $act, 'yueche' ) !== false ? 'current' : '';
		// $nav [] = $res;
		$this->assign ( 'nav', $nav );
	}


	//打印列表
	public function dayin_list(){
		$id = I('id');
		// var_dump($id);die;
		if($id){
			$dingdan = M('dingdan');
			$where['id'] = $id;
			$data['status'] = 2;
			$status = $dingdan->where($where)->save($data);
			if($status == 1){
				$result['url'] = "http://yueche.siwoinfo.com/index.php?s=/Home/Dayin/dayin_list/";
			}else{
				$result['status'] = 0;
				$result['msg'] = "此订单状态修改失败，请联系管理员去数据库中修改！";
			}
			$this->ajaxReturn($result);
		}
		$this->display();
	}

	public function dayin(){
	 	$id = $_POST['id'];
	 	$dingdan = M('dingdan');
	 	$where['d.id'] = $id;
	 	$list[] = $dingdan->table('wp_dingdan d')
	 			->join('wp_xueyuan x on d.xid = x.id')
	 			->join('wp_jiaxiao jx on x.jx = jx.id')
	 			->join('wp_jiaolian jl on x.jl_id = jl.id')  
	 			->field('*,d.id as id')
	 			->where($where)
	 			->select();
	 	$xueyuan = M('xueyuan');
	 	$tuan = explode(',',$list[0][0]['tuan']);
	 	for ($i=0; $i < count($tuan); $i++) { 
	 		$map['id'] = $tuan[$i];
	 		$xueyuan_list[] = $xueyuan->where($map)->field('id,xname,xcard')->find();
	 	}


	 	$list[] = $xueyuan_list;

	 	echo json_encode($list);die;
	}


	//根据学员身份证和教练身份证查询订单
	public function chaxun(){
		header("Content-Type: text/html;charset=utf-8"); 
		$xcard = I('xcard');
		$jcard = I('jcard');
		$dingdan = M('dingdan');
		$where['x.xcard'] = $xcard;
		// $where['jl.jcard'] = $jcard;
		$where['d.status'] = 0;
		$list = $dingdan->table('wp_dingdan d')
				->join('wp_xueyuan x on d.xid = x.id')
				->join('wp_jiaolian jl on x.jl_id = jl.id')
				->join('wp_jiaxiao jx on x.jx = jx.id')
				->field('*,d.id as id')
				->where($where)
				->select();
		// var_dump($list);die;
		if($list){
			echo json_encode($list);die;
		}else{
			echo 0;die;
		}

	}

	public function dayin_xq(){
		header("Content-Type: text/html;charset=utf-8"); 
		$dingdan = M('dingdan');
		$id = I('id');
		$where['d.id'] = $id;
		$list = $dingdan->table('wp_dingdan d')
				->join('wp_xueyuan x on d.xid = x.id')
				->join('wp_jiaolian jl on x.jl_id = jl.id')
				->join('wp_jiaxiao jx on x.jx = jx.id')
				->where($where)
				->select();
		//查询组团人员		
		$tuan_id = $list[0]['tuan'];
		$sql = "SELECT `xname` FROM `wp_xueyuan` WHERE `id` IN (".$tuan_id.")";
		$t_xname = M('xueyuan')->query($sql);
		//dump($t_xname);
		foreach($t_xname as $k=>$v){
			$a[$k] = $v['xname'];
		}
		$tuan_name = implode(',',$a);
		$this->assign('tuan_name',$tuan_name);
		$this->assign('list',$list);
		$this->display();
	}

	//线下预约
	public function yueche(){
		header("Content-type:text/html;charset=utf-8");
		$jiaxiao = M('jiaxiao');
		$jiaxiao_list = $jiaxiao -> field(' id,jxname ') -> select();
		foreach ($jiaxiao_list as $k => $v) {
			 $jiaxiao_list[$k]['jxname'] = urlencode ( $v['jxname'] );  
		}
		$json = urldecode ( json_encode ( $jiaxiao_list ) );

		// var_dump($json);die;
		$data = date('Y-m-d',time());
		$paiban = M('paiban');
		$where['data'] = $data;
		for ($i=1; $i < 41; $i++) { 
			$where['ch'] = $i;
			$list[$i] = $paiban->where($where)->select();
		}

		$arr = array_filter($list); 
		$this->assign('arr',$arr);
		$this->assign('json',$json);
		$this->display();
	}

	//异步获取
	public function huoqu(){
		header("Content-type:text/html;charset=utf-8");
		$data = I('data');
		$paiban = M('paiban');
		$where['data'] = $data;
		for ($i=1; $i < 41; $i++) { 
			$where['ch'] = $i;
			$list[$i] = $paiban->where($where)->select();
		}
		$arr = array_filter($list); 
		if($arr){
			echo json_encode( $arr );die;
		}else{
			echo json_encode('没有查询到数据！');die;
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

	public function reader(){
		var_dump($_POST);die;
	}


	//
	public function xuanze(){
		// var_dump($_SESSION);die;
		// $pid = $_SESSION['juye_home']['pid'];
		// if($pid != ''){
		// 	$result['status'] = 0;
		// 	$result['msg'] = "您还有未完成的订单！";
		// 	$result['url'] = "http://yueche.siwoinfo.com/index.php?s=/Home/Dayin/addlianxiren";
		// 	$this->ajaxReturn($result);
		// }
		// var_dump($_POST);DIE;
		$id = I('id');
		$jx = I('jx');
		$jl = I('jl');
		$_SESSION['juye_home']['pid'] = $id;
		$_SESSION['juye_home']['jx'] = $jx;
		$_SESSION['juye_home']['jl'] = $jl;
		$result['url'] = "http://yueche.siwoinfo.com/index.php?s=/Home/Dayin/lianxiren/";
		$this->ajaxReturn($result);
	}

	public function lianxiren(){
		// var_dump($_POST);die;
		$pid = $_SESSION['juye_home']['pid'];
		$jx = $_SESSION['juye_home']['jx'];
		$jl = $_SESSION['juye_home']['jl'];
		// var_dump($pid);die;
		$this->assign('pid',$pid);
		$this->assign('jx',$jx);
		$this->assign('jl',$jl);
		$this->display();
	}	

	public function addlianxiren(){
		$xcard = I('tcardID');
		$where['xcard'] = $xcard;
		$xueyuan = M('xueyuan');
		$xueyuan_list = $xueyuan->field('id,xname,xcard')->where($where)->find();
		if($xueyuan_list){
			echo json_encode( $xueyuan_list );die;
		}else{
			$xname = I('tName');
			$xsex = I('tSex');
			$jx = I('jx');
			$jl = I('jl');
			// $minzu = I('tFolkL');
			$xbirth = I('tBirth');
			$xaddr = I('tAddr');
			$xnow_addr = I('tAddr');
			$xphone = I('phone');
			$data['xcard'] = $xcard;
			$data['jx'] = $jx;
			$data['jl_id'] = $jl;
			$data['xname'] = $xname;
			$data['xsex'] = $xsex;
			// $data['minzu'] = $minzu;
			$data['xbirth'] = $xbirth;
			$data['xaddr'] = $xaddr;
			$data['xnow_addr'] = $xnow_addr;
			$data['xaddtime'] = date('Y-m-d H:i:s',time());
			$add_id = $xueyuan->data($data)->add();
			if($add_id){
				$map['id'] = $add_id;
				$list = $xueyuan->field('id,xname,xcard')->where($map)->find();
				echo json_encode( $list );die;
			}else{
				$result['status'] = 0;
				$result['msg'] = "添加失败！";
				$this->ajaxReturn($result);
			}
		}
	}

	//提交订单
	public function addDingdan(){
		$xueyuan = M('xueyuan');
		$paiban = M('paiban');
		$weizhifu = M('weizhifu');
		$dingdan = M('dingdan');
		//选择的人
		$str_peop = $_POST['str_peop'];
		$arr = explode(',',$str_peop);
		// $str_list = array_filter($arr);
		// var_dump($arr[0]);die;

		$jx = $_POST['jx'];
		$jl = $_POST['jl'];

		//时间段
		$str = $_POST['str'];
		$id_arr = explode(",", $str);
		$where['id'] = $id_arr[0];
		$ch = $paiban->where($where)->find();
		// $str = substr($id,0,strlen($id_arr)-1);
		// for ($i=0; $i < count($arr); $i++) { 
		// 	$map1['xid'] = $arr[$i];
		// 	$map1['pdata'] = date('Y-m-d',time());
		// 	$map1['status'] = 0;
		// 	$chongfu = $dingdan->where($map1)->select();
		// 	if($chongfu){
		// 		$result['status'] = 0;
		// 		$result['msg'] = "对不起,您今天的订单数已达上限！";
		// 		$this->ajaxReturn($result);
		// 	}
		// }
		for ($j=0; $j < count($id_arr); $j++) { 
			$map['id'] = $id_arr[$j];
			$map['status'] = 1;
			$status = $paiban->where($map)->select();
			if($status){
				$result['status'] = 0;
				$result['msg'] = "当前时间段已经被预约,请重新刷新！";
				$this->ajaxReturn($result);
			}
		}

		for ($i=0; $i < count($id_arr); $i++) { 
			$list[] = $paiban->field('time')->where(array('id'=>$id_arr[$i]))->find();
		}
		for ($j=0; $j < count($list); $j++) { 
			$time .= $list[$j]['time'].',';
		}
			$num = count($id_arr);
			$money = $num * 150;
			$data['xid'] = $arr[0];
			$data['jxid'] = $jx;
			$data['jid'] = $jl;
			$data['fs'] = 2;
			$data['pch'] = $ch['ch'];
			$data['pdata'] = $ch['data'];
			$data['ptime'] = substr($time, 0, -1);
			$data['pid'] = $str;
			$data['tuan'] = $str_peop;
			$data['daddtime'] = date('Y-m-d H:i:s',time());
			$data['dbh'] = date('Ymd') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
			$data['money'] = $money;
			$data['num'] = $num;
			$data['status'] = 0;
			$list_id = $dingdan->data($data)->add();
			if($list_id){
				for ($i=0; $i < count($id_arr); $i++) { 
					 $date['status'] = 1;
					 $where['id'] = $id_arr[$i];
					 $status = $paiban->where($where)->save($date);
				}
				$result['msg'] = '提交订单成功';
				$result['url'] = U('Dayin/yueche');
			}else{
				$result['status'] = 0;
				$result['msg'] = '提交订单失败';
				$result['url'] = U('Dayin/yueche');
			}
			$_SESSION['juye_home']['pid'] = '';
			$_SESSION['juye_home']['jx'] = '';
			$_SESSION['juye_home']['jl'] = '';
			$this->ajaxReturn($result);
	}

	//导出pdf
	public function down_pdf(){
		//<p style="display: inline-block;float: right;">NO:<span class="bianhao"></span></p>
		$dingdan_id = isset($_GET['id']) ? $_GET['id'] : 0;
		// dump($dingdan_id);die;
		$dingdan = M('dingdan');
		$where['d.id'] = $dingdan_id;
		$list = $dingdan->table('wp_dingdan d')
				->join('wp_xueyuan x on d.xid = x.id')
				->join('wp_jiaxiao jx on x.jx = jx.id')
				->join('wp_jiaolian jl on x.jl_id = jl.id')
				->where($where)
				->field('*, d.id as id')
				->select();
		// dump($list);die;
		$tuan_id = $list[0]['tuan'];
		//查询组团人员
		$sql = "SELECT `xname`,`xcard` FROM `wp_xueyuan` WHERE `id` IN (".$tuan_id.")";
		$t_xname = M('xueyuan')->query($sql);
		foreach ($t_xname as $key => $value) {
			$t_xname[$key]['tuan_info'] = $t_xname[$key]['xname'].' '.$t_xname[$key]['xcard'];
			if($t_xname[$key]['xname'] == $list[0]['xname']){
				unset($t_xname[$key]);
			}
			
		}
		foreach ($t_xname as $k => $v) {
				$tuan_xname[] = $t_xname[$k]['tuan_info'];
			}
		// dump($tuan_xname);die;
		// dump(implode(',',$tuan_xname));die;
		// $qita_info = implode('。',$tuan_xname);
		$zhuyueren_info = $list[0]['xname'].' '.$list[0]['xcard'];//主约人姓名与身份证号
		$jiaolian_info = $list[0]['jname'].' '.$list[0]['jcard'];//教练员姓名与身份证号
		$pch = $list[0]['pch'];//预约车号
		$pdata_time = $list[0]['pdata'].' '.$list[0]['ptime'];//预约时间段
		// $tuan_info = $zhuyueren_info.'。 '.$qita_info.'。';
		// dump($tuan_info);die;
		$print_html = '<div id="div_print"> 
      		<h3 style="text-align:center;font-size: 24px;line-height: 25.0000pt;letter-spacing:  2px;margin-top: 0;">数字化考试车使用协议</h4>
      		<p class="MsoNormal" style="text-align: left;line-height: 10px;margin:0px;margin-bottom:10px"></p>
      		<p class="MsoNormal" style="text-align: left;line-height: 10px;letter-spacing:  2px;font-size: 15px;">甲方:济南市机动车驾驶员考试服务中心</p>
      		<p class="MsoNormal" style="text-align: left;line-height: 10px;letter-spacing:  2px;font-size: 15px;">乙方:学员：<span id="xycard" style="display: inline-block;" >'.$zhuyueren_info.'</span></p>
      		<p class="MsoNormal" style="text-align: left;line-height: 10px;letter-spacing:  2px;font-size: 15px;">乙方:教练员：<span id="jlcard" style="display: inline-block;" >'.$jiaolian_info.'</span></p>
      		<p style="text-indent: 20.0000pt;line-height: 18px;letter-spacing:  2px;font-size: 15px;" class="MsoNormal">甲方提供数字化考试车给乙方使用,为明确甲、乙双方的权利和义务,经双方协商,按照平等互利的自愿原则,就车辆、场地的使用相关事宜签订本协议。</p>
	        <p style="text-indent: 0.0000pt;text-align: left;line-height: 18px;letter-spacing:  2px;font-size: 15px;" class="MsoNormal" >1、甲方提供的车辆应设备完好齐全、车况干净整洁。</p>
	        <p style="text-indent: 0.0000pt;text-align: left;line-height: 18px;letter-spacing:  2px;font-size: 15px;" class="MsoNormal" >2、甲方应保证训练场地完好,环境舒适。</p>
	        <p style="text-indent: 0.0000pt;text-align: left;line-height: 18px;letter-spacing:  2px;font-size: 15px;" class="MsoNormal" >3、对乙方在使用甲方提供的车辆过程中应接受甲方的监督和管理。</p>
	        <p style="text-indent: 0.0000pt;text-align: left;line-height: 18px;letter-spacing:  2px;font-size: 15px;" class="MsoNormal" >4、乙方凭有效教练证网上预约成功后应提前到窗口办理租车手续。超过预约时间到租车点租车,按实际到达时间登记租车。超过时间不予补足,租车时间结束准时收车。</p>
	        <p style="text-indent: 0.0000pt;text-align: left;line-height: 18px;letter-spacing:  2px;font-size: 15px;" class="MsoNormal" >5、为保障训练人员安全,乙方在施教过程中应随车施教,无教练员随车施教的,一经查实甲方有权取消乙方租车资格。</p>
	        <p style="text-indent: 0.0000pt;text-align: left;line-height: 18px;letter-spacing:  2px;font-size: 15px;" class="MsoNormal" >6、乙方应确保施训过程中的安全和车辆设备的完好,不按规定施教发生车辆设备损坏或事故的由乙方教练员承担全部责任,造成损失的照价赔偿。</p>
	        <p style="text-indent: 0.0000pt;text-align: left;line-height: 18px;letter-spacing:  2px;font-size: 15px;" class="MsoNormal" >7、乙方应服从场地管理人员管理，遵守场地管理规定。严重违规违纪，恶意延迟交车时间，以及上车教练员、学员信息与本协议书不一致的的情况，一经查实甲方有权取消乙方及其所在驾校租车资格。</p>
	        <p style="text-indent: 0.0000pt;text-align: left;line-height: 18px;letter-spacing:  2px;font-size: 15px;" class="MsoNormal" >8、您预约的车号为 : '.$pch.'号车<br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;预约的时间段为 : '.$pdata_time.'<br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;学员姓名 : '.$zhuyueren_info.'</p>';
    	foreach ($tuan_xname as $key => $value) {
    		$print_html .= '<p style="text-indent: 110px;text-align: left;letter-spacing:  2px;font-size: 15px;" class="MsoNormal" >'.$value.'</p>';
    	}
    	$print_html .= '<p style="text-indent: 0.0000pt;text-align: left;line-height: 18px;letter-spacing:  2px;font-size: 15px;" class="MsoNormal" >9、本协议履行过程中发生争议,由双方协商解决。</p>
	        <p style="text-indent: 0.0000pt;text-align: left;line-height: 18px;letter-spacing:  2px;font-size: 15px;" class="MsoNormal" >10、本协议当天车辆使用结束自动失效。&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;乙方：教练员</p>  
	        <p class="MsoNormal" style="text-align: left;float:left;display:inline-block;margin-top:60px;line-height: 15px;letter-spacing:  2px;font-size: 15px;">甲方:济南市机动车驾驶员考试服务中心&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;乙方：学员</p>
    	</div>';
    	//更新状态
		$data['status'] = 2;
		$dingdan_where['id'] = $dingdan_id;
		$status = $dingdan->where($dingdan_where)->save($data);
		$pdf_name = $list[0]['xname'].'_'.$list[0]['pdata'];
		//更新成功
		if($status !== false){
			pdf($print_html,$pdf_name);
		}else{
			//更新状态失败
			$this->success('下载失败,请重新下载!',U('Dayin/dayin_list'));
		}
    	
	}
	
}
	