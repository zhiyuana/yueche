<?php

namespace Home\Controller;
use Think\Model;
/**
 * 素材管理控制器
 */
class JxyuecheController extends HomeController {

	//二级列表
	function _initialize() {
		parent::_initialize ();
		
		$act = strtolower ( ACTION_NAME );
		$param = array (
				'mdm' => I ( 'mdm' ) 
		);
		
		$res ['title'] = '驾校约车';
		$res ['url'] = U ( 'jxyc_index', $param );
		$res ['class'] = strpos ( $act, 'jxyc_index' ) !== false ? 'current' : '';
		$nav [] = $res;
		
		$res ['title'] = '学员管理';
		$res ['url'] = U ( 'jxueyuan_list', $param );
		$res ['class'] = strpos ( $act, 'jxueyuan_list' ) !== false ? 'current' : '';
		$nav [] = $res;
		
		$res ['title'] = '已完成订单';
		$res ['url'] = U ( 'ding_list', $param );
		$res ['class'] = strpos ( $act, 'ding_list' ) !== false ? 'current' : '';
		$nav [] = $res;

		$res ['title'] = '未支付订单';
		$res ['url'] = U ( 'wei_list', $param );
		$res ['class'] = strpos ( $act, 'wei_list' ) !== false ? 'current' : '';
		$nav [] = $res;

		//判断用户	caiwu与tuikuan
		$server_dir = substr(strrchr($_SERVER['DOCUMENT_ROOT'],'/'),1)."_home";
		if (trim($_SESSION[$server_dir]['user_auth']['username'],'"') == 'caiwu') 
		{
			unset($nav['4']);
		}

		if(trim($_SESSION[$server_dir]['user_auth']['username'],'"') == 'tuikuan')
		{
			unset($nav['0']);
			unset($nav['1']);
			unset($nav['2']);
			unset($nav['3']);
			unset($nav['5']);
			unset($nav['6']);
			unset($nav['7']);
			//unset($nav['8']);
			$nav['4']['class'] = 'current';
		}
		// dump($_SESSION);die;
		// dump($nav);
		$this->assign ( 'nav', $nav );
	}

	//驾校约车首页
	public function jxyc_index(){
		header("Content-type:text/html;charset=utf-8");
		// dump($_SESSION["juye_home"]["user_auth"]["uid"]);die;
		$User = M('user');
		$jiaxiao = M('jiaxiao');
		$uid = $_SESSION["juye_home"]["user_auth"]["uid"];
		$map['u.uid'] = $uid;
		$map1['uid'] = $uid;
		$list = $User->field('nickname')->where($map1)->find();
		$nickname = $list['nickname'];
		if('admin' == $nickname){
			$jiaxiao_list = $jiaxiao -> field(' id,jxname ') -> select();
			foreach ($jiaxiao_list as $k => $v) {
				$jiaxiao_list[$k]['jxname'] = urlencode ( $v['jxname'] );  
			}
			$json = urldecode ( json_encode ( $jiaxiao_list ) );
		}else{
			$jiaxiao_list = $jiaxiao->table('wp_user u')
				->join('wp_jiaxiao jx on u.jxid = jx.id')
				->field(' id,jxname ')
				->where($map)
				->find();
			// echo "<pre>";
			// var_dump($jiaxiao_list);die;
			$jiaolian_list = $jiaxiao->table('wp_user u')
				->join('wp_jiaolian jl on u.jxid = jl.jxid')
				->field('id,jname')
				->where($map)
				->select();
			// echo "<pre>";
			// var_dump($jiaolian_list);die;
			foreach ($jiaolian_list as $k => $v) {
				 $jiaolian_list[$k]['jname'] = urlencode ( $v['jname'] );  
			}
			$json = urldecode ( json_encode ( $jiaolian_list ) );
			// var_dump($json);die;
			$this->assign('jiaxiao_list',$jiaxiao_list);
		}
		//dump($json);
		$data = date('Y-m-d',time());
		$paiban = M('paiban');
		$where["type"] = 1;
		$where["data"] = $data;
		$where["ch"] = 1;
		$list= $paiban->where($where)->order("time asc")->select();
		$fabu_list = $this->groupArrray($list,6);
		$this->assign('json',$json);
		$this->assign('nickname',$nickname);
		$this->assign('fabu_list',$fabu_list);
		$this->display();
	}

	//学员列表
	public function jxueyuan_list(){
		header("content-type:text/html;charset=utf-8");
		// echo "<pre>";
		// var_dump($_SESSION["juye_home"]["user_auth"]["uid"]);die;
		$xy_name = I('xy_name');
		$xy_name = trim($xy_name);
		if(is_numeric($xy_name) == true){
			$where1['xcard'] = array('like',"%$xy_name%");
		}else{
			$where1['xname'] = array('like',"%$xy_name%");
		}
		$User = M('user');
		$uid = $_SESSION["juye_home"]["user_auth"]["uid"];
		$where['u.uid'] = $uid;
		$map['uid'] = $uid;
		$list = $User->field('nickname')->where($map)->find();
		$nickname = $list['nickname'];
		// var_dump($nickname);die;
		if('admin' == $nickname){
			$xueyuan = M('xueyuan');
			$totalCount = $xueyuan->where($where1)->count();
			$Page = new \Think\Page($totalCount,20);
			// echo "<pre>";
			// var_dump($page);die;
			$Page->setConfig ( 'theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%' );
			$xueyuan_list = $xueyuan
				->field('id,xname,xsex,xphone,xcard')
				->where($where1)
				->limit($Page->firstRow.','.$Page->listRows)
				->order('id desc')
				->select();
			// echo "<pre>";
			// var_dump($xueyuan_list);die;
		}else{
			$totalCount = $User->table('wp_user u')
				->join('wp_xueyuan xy on u.jxid = xy.jx')
				->field('id,xname,xsex,xphone,xcard')
				->where($where)
				->where($where1)
				->count();
			$Page = new \Think\Page($totalCount,20);
			// echo "<pre>";
			// var_dump($page);die;
			$Page->setConfig ( 'theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%' );
			$xueyuan_list = $User->table('wp_user u')
				->join('wp_xueyuan xy on u.jxid = xy.jx')
				->field('id,xname,xsex,xphone,xcard')
				->where($where)
				->where($where1)
				->limit($Page->firstRow.','.$Page->listRows)
				->order('id desc')
				->select();
			// echo "<pre>";
			// var_dump($xueyuan_list);die;
		}
		foreach($xueyuan_list as $k=>$v){
			if($v['xsex'] == 1){
				$xueyuan_list[$k]['xsex'] = '男';
			}else{
				$xueyuan_list[$k]['xsex'] = '女';
			}
		}
		$page  = $Page->show();// 分页显示输出
		$this->assign('_page', $page);
		$this->assign('xueyuan_list',$xueyuan_list);
		$this->assign('xy_name',$xy_name);
		$this->display();
	}
	
	//编辑学员信息
	public function jxueyuan_edit(){
		// header("content-type:text/html;charset=utf-8");
		$xueyuan= M('xueyuan');
		$id = I('id');
		$mdm = I('mdm');
		$list = $xueyuan->where(array('id'=>$id))->select();
		// echo "<pre>";
		// var_dump($list);die;
        $this->assign('list',$list);
		$this->display();
	}
	//执行编辑
	public function jxueyuan_update(){
		$xueyuan= M('xueyuan');
		$id = I('id');
		$data['xname'] = I('xname');
		$data['xsex'] = I('xsex');
		//$data['xage'] = I('xage');
		$data['xaddr'] = I('xaddr');
		$data['xnow_addr'] = I('xnow_addr');
		$data['xphone'] = I('xphone');
		$data['xcard'] = I('xcard');
		//$data['xbh'] = I('xbh');
		$data['xweixin'] = I('xweixin');
		$data['xmark'] = I('xmark');
        $list_edit = $xueyuan->where(array('id'=>$id))->save($data);
        if($list_edit){
        	$this->success('修改成功!',U('Jxyueche/jxueyuan_list'));
        }
	}
	//执行删除
	public function jxueyuan_del(){
		$xueyuan= M('xueyuan');
		$id = I('id');
		if($id){
			$xueyuan_del = $xueyuan->where(array('id'=>$id))->delete();
			if($xueyuan_del){
	    		$this->success('删除成功!',U('Jxyueche/jxueyuan_list',array('mdm'=>$_GET['mdm'])));

			}
		}else{
			$this->error('删除失败,缺少id值!');
		}
	}
	//导入学员excel
	public function daoru_excel(){
		import('ORG.Net.UploadFile',APP_PATH);
		$upload = new \Think\Upload();//UploadFile();// 实例化上传类
		$upload->maxSize  = 3145728 ;// 设置附件上传大小
		$upload->allowExts  = array('xls', 'xlsx');// 设置附件上传类型
		$savePath = $upload->savePath = './Upload/Excel/';// 设置附件上传目录
		if(!$info = $upload->upload()) {// 上传错误提示错误信息
			$this->error($upload->getError());
		}
		$savename = $info[0]['savename'];
		$up_url = 'Uploads/'.$info[0]['savepath'].$info[0]['savename'];
		// $savename = $info['photo']['savename'];
		// $up_url = 'Uploads/'.$info['photo']['savepath'].$info['photo']['savename'];
		
		$data = importExcel($up_url);
 		// dump($data);die;
		$result = $data['data'][0]['Content'];
		unset($result[1]);
		foreach ($result as $key=>$val){
	  		// dump($val);
	  		$where['jxname'] = $val[6];
	  		$jiaxiao_info = M('jiaxiao')->where($where)->select();
			if(empty($jiaxiao_info)){
				echo 2;die;
			}
	  		$where2['jxid'] = $jiaxiao_info[0]['id'];
	  		$where2['jname'] = $val[7];
	  		$jiaolian_info = M('jiaolian')->where($where2)->select();
			if(empty($jiaolian_info)){
				echo 3;die;
			}
	  		$data_info['jx'] = $jiaxiao_info[0]['id'];
	  		$data_info['jl_id'] = $jiaolian_info[0]['id'];
	  		$data_info['xaddr'] = $val[4];
	  		$data_info['xnow_addr'] = $val[5];
	  		$data_info['xphone'] = $val[2];
			$xcard = $val[1];
			$card_len = strlen($xcard);
			if($card_len != 18 && $card_len != 15){
				echo 4;die;
			}
	  		$data_info['xcard'] = $xcard;
	  		$data_info['xname'] = $val[0];
	  		$data_info['uid'] = 0;
	  		$data_info['xbirth'] = substr($val[1],6,8);
	  		$data_info['xy'] = 1;
	  		$data_info['xaddtime'] = date('Y-m-d H:i:s',time());
			if(empty($data_info['xname']) || empty($data_info['xaddr']) || empty($data_info['xphone'])){
				echo 5;die;
			}
	  		if($val[3] == '男'){
	  			$data_info['xsex'] = 1;
	  		}else{
	  			$data_info['xsex'] = 2;
	  		}
			$map['xcard'] = $val[1];
			$check_card = M('xueyuan')->where($map)->find();
			if (!$check_card){
				$excel_res = M('xueyuan')->add($data_info);
			}
	    }
	    if($excel_res){
			// $this->success('导入成功！', U('Jxyueche/jxueyuan_list'));
			echo 1;die;
		}else{
			// $this->error('导入失败!');
			echo 0;die;
		}

	}
	
	//选择学员+锁定时间段
	public function xz_xueyuan(){
		$data = base64_encode(serialize($_POST));
		$pid = $_POST['time_pid'];
		$jl = $_POST['jl'];
		$paiban = M('paiban');
		$student = M('xueyuan');
		$map['jl_id'] = $jl;
		$list = $student->field('xname')->where($map)->select();
		if(empty($list)){
			$result['status'] = 1;
			$result['msg'] = '该教练下无学员，请重新选择教练';
		}else{
			// 更新排班表时间段状态
			foreach($pid as $v){
				$where['id'] = $v;
				$paiban->status = 1;
				$res = $paiban->where($where)->save();
			}
			if(false !== $res){
				$server_name = $_SERVER['HTTP_HOST'];
				$result['status'] = 0;
				$result['msg'] = '请完善学员信息!';
				$result['url'] = "http://".$server_name."/index.php?s=/Home/Jxyueche/add_xueyuan/datainfo/".$data;
			}else{
				$result['status'] = 4;
				$result['msg'] = '选择时间段有误请重新选择!';
			}
		}
		$this->ajaxReturn($result);
	}
	
	//添加学员
	public function add_xueyuan(){
		$datainfo = isset($_GET['datainfo']) ? base64_decode($_GET['datainfo']) : null;
		$data_info = unserialize($datainfo);
		$where['x.jx'] = $data_info['jx'];
		$where['x.jl_id'] = $data_info['jl'];
		// $xueyuan_list = M('xueyuan')->where($where)->select();
		$xueyuan = M('xueyuan');
		$xueyuan_list = $xueyuan->table('wp_xueyuan x')
	 			->join('wp_jiaxiao jx on x.jx = jx.id')
	 			->join('wp_jiaolian jl on x.jl_id = jl.id')  
	 			->field('x.xname,jx.jxname,jl.jname,x.id as xid,jx.id as jxid')
	 			->where($where)
	 			->select();
	 	$jx_name = $xueyuan_list[0]['jxname'];//驾校名
	 	$jl_name = $xueyuan_list[0]['jname'];//教练名
	 	$jxid = $xueyuan_list[0]['jxid'];//驾校id
		// var_dump($jxid);
	 	// dump($data_info);
		//禁止重复提交订单
		// session_start();
		//根据当前SESSION生成随机数
		// $code = mt_rand(0,1000000);
		// $_SESSION['code'] = $code;
		//禁止重复提交订单
		// $this->assign('code',$code);
		$time_count = count($data_info['time_pid']);//选择小时数
		
		$this->assign('datainfo',$datainfo);
		$this->assign('time_count',$time_count);
		$this->assign('xueyuan_list',$xueyuan_list);
		$this->assign('jxname',$jx_name);
		$this->assign('jname',$jl_name);
		$this->assign('jxid',$jxid);
		$this->display();

	}

	//添加驾校学员
	public function add_student(){
		header("content-type:text/html;charset=utf-8");
		$User = M('user');
		$jiaxiao = M('jiaxiao');
		$uid = $_SESSION["juye_home"]["user_auth"]["uid"];
		$map['u.uid'] = $uid;
		$map1['uid'] = $uid;
		$list = $User->field('nickname')->where($map1)->find();
		$nickname = $list['nickname'];
		// var_dump($nickname);die;
		if('admin' == $nickname){
			$jiaxiao_list = $jiaxiao -> field(' id,jxname ') -> select();
			foreach ($jiaxiao_list as $k => $v) {
				$jiaxiao_list[$k]['jxname'] = urlencode ( $v['jxname'] );  
			}
			$json = urldecode ( json_encode ( $jiaxiao_list ) );
		}else{
			$jiaxiao_list = $jiaxiao->table('wp_user u')
				->join('wp_jiaxiao jx on u.jxid = jx.id')
				->field(' id,jxname ')
				->where($map)
				->find();
			// echo "<pre>";
			// var_dump($jiaxiao_list);die;
			$jiaolian_list = $jiaxiao->table('wp_user u')
				->join('wp_jiaolian jl on u.jxid = jl.jxid')
				->field('id,jname')
				->where($map)
				->select();
			// echo "<pre>";
			// var_dump($jiaolian_list);die;
			foreach ($jiaolian_list as $k => $v) {
				 $jiaolian_list[$k]['jname'] = urlencode ( $v['jname'] );  
			}
			$json = urldecode ( json_encode ( $jiaolian_list ) );
			$this->assign('jiaxiao_list',$jiaxiao_list);
		}
		$this->assign('json',$json);
		$this->assign('nickname',$nickname);
		$this->display();
	}

	//提交订单
	public function add_dingdan(){
		header("content-type:text/html;charset=utf-8");
		// dump($_SESSION);
		// session_start();
		// 处理该表单的语句，省略
		$xid_str = $_POST['xid_str'];
		$jxid = $_POST['jxid'];//驾校id
		// var_dump($jxid);
		$dingdaninfo = unserialize($_POST['datainfo']);
		$pid_str = implode(',',$dingdaninfo['time_pid']);
		$where['id'] = $dingdaninfo['jx'];
		$where2['id'] = $dingdaninfo['jl'];
		$where3['id'] = array('in',$xid_str);
		$where4['id'] = array('in',$pid_str);
		$jxname = M('jiaxiao')->where($where)->find();
		$jlname = M('jiaolian')->where($where2)->find();
		$xueyuan_list = M('xueyuan')->where($where3)->select();
		$paiban_list = M('paiban')->where($where4)->select();
		foreach($paiban_list as $k=>$v){
			$ptime_arr[] = $v['time'];
		}
		$ptime = implode(',',$ptime_arr);
		$pay_money = count($ptime_arr) * 150;
		$dingdaninfo['jxname'] = $jxname['jxname'];
		$dingdaninfo['jlname'] = $jlname['jname'];
		$dingdaninfo['ptime'] = $ptime;
		$dingdaninfo['pay_money'] = $pay_money;
		$no_pay = M('weizhifu');
		$out_trade_no = getOut_trade_no();
		$data['out_trade_no'] = $out_trade_no;
		$data['dbh'] = date('Ymd') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
		$pid = implode(",",$dingdaninfo['time_pid']);
		$data['xid'] = $xueyuan_list[0]['id'];//学员id
		$data['jid'] = $dingdaninfo['jl'];//教练id
		$data['jxid'] = intval($jxid);//驾校id
		// var_dump($data['jxid']);die;
		$data['pid'] = $pid;//排班编号
		$data['tuan'] = $xid_str;//团购学员所有id
		$data['money'] = $pay_money;//支付金额
		$data['num'] = count($ptime_arr);//排班数量
		$data['addtime'] = date('Y-m-d H:i:s',time());
		$data['status'] = 1;//锁定排班时间段
		$data['fs'] = 2;//付款方式：1线上，2线下
		
		//判断是否重复提交
		$map['jxid'] = $data['jxid'];//驾校id
		$map['jid'] = $data['jid'];//教练id
		$map['pid'] = $data['pid'];//排班编号
		$map['tuan'] = $data['tuan'];//团购学员所有id
		$map['money'] = $data['money'];//支付金额
		$check = $no_pay->where($map)->find();
		// var_dump($check);
		if(!$check){
			$paying = $no_pay->data($data)->add();
			if($paying){
				$result['status'] = 0;
				$result['url'] = U('Jxyueche/dingdan',array('id'=>$paying));
				$this->ajaxReturn($result);
			}else{
				$result['status'] = 1;
				$result['url'] = U('Jxyueche/jxye_index');
				$this->ajaxReturn($result);
			}
		}else{
			$this->display(T('Home@Jxyueche/field'));die;
		}
		$where1['id'] = $paying;
		$list = $no_pay->field('addtime')->where($where1)->find();
		$addtime = strtotime($list['addtime']);
		// var_dump($addtime);die;
		$this->assign('addtime',$addtime);
		$this->assign('pid',$pid);
		$this->assign('paying',$paying);
		$this->assign('dingdaninfo',$dingdaninfo);
		$this->assign('xueyuan_list',$xueyuan_list);
		$this->display();
	}
	
	//订单支付页
	public function dingdan(){
		header("content-type:text/html;charset=utf-8");
		$paying = I('id');
		$where['id'] = $paying;
		$where2['wzf.id'] = $paying;
		$weizhifu = M('weizhifu');
		$xueyuan = M('xueyuan');
		$paiban = M('paiban');
		$list = $weizhifu->where($where)->find();
		$addtime = $list['addtime'];
		$pid = $list['pid'];
		$where1['id'] = array('in',$list['tuan']);
		$xueyuan_list = $xueyuan->field('xname,xcard')->where($where1)->select();
		$dingdaninfo = $weizhifu->table('wp_weizhifu wzf')
			->join('wp_jiaxiao jx on wzf.jxid=jx.id')
			->join('wp_jiaolian jl on wzf.jid=jl.id')
			->field('jx.jxname,jl.jname as jlname,wzf.money as pay_money,pid')
			->where($where2)
			->find();
		$where3['id'] = array('in',explode(',',$pid));
		$yuyue = $paiban->where($where3)->select();
		foreach($yuyue as $k=>$v){
			$ptime_arr[] = $v['time'];
		}
		$ptime = implode(',',$ptime_arr);
		$dingdaninfo['ptime'] = $ptime;//预约时间段
		$dingdaninfo['data'] = $yuyue[0]['data'];//预约日期
		$dingdaninfo['ch'] = $yuyue[0]['ch'];//预约车号
		// echo "<pre>";
		// var_dump($dingdaninfo);die;
		$addtime = strtotime($addtime);
		$this->assign('addtime',$addtime);
		$this->assign('pid',$pid);
		$this->assign('paying',$paying);
		$this->assign('dingdaninfo',$dingdaninfo);
		$this->assign('xueyuan_list',$xueyuan_list);
		$this->display(T('Application://Home@Jxyueche/add_dingdan'));
	}
	
	//取消订单
	public function cancel_dingdan(){
		$weifu = M('weizhifu');
		$paiban = M('paiban');
		$paying = I('paying');
		$pid = I('pid');
		if($paying && $pid){
			// file_put_contents('./wangdi.txt',$pid);
			$where['pid'] = $pid;
			$where['id'] = $paying;
			$pid = explode(',',$pid);
			$map['id'] = array('in',$pid);
			$data['status'] = 0;
			$del = $weifu->where($where)->delete();
			$upd = $paiban->where($map)->save($data);
			$res = $del.'+'.$upd;
			if($del && $upd){
				$result['status'] = 1;
				$result['url'] = U('Jxyueche/jxyc_index');
			}else{
				$result['status'] = 0;
			}
			$this->ajaxReturn($result);
		}else{
			$result['status'] = 0;
			$this->ajaxReturn($result);
		}
	}
	
	//微信扫码支付 模式2
	public function native_pays(){
		$weizhifu = M('weizhifu');
		$paying_id = I('paying_id');
		$where['id'] = $paying_id;
		$list = $weizhifu->where($where)->find();
		$out_trade_no = $list['out_trade_no'];//商户订单号
		$money = $list['money'];//约车费用
		$money = intval($money)*100;
		//使用统一支付接口
		$JsApi_pub = new \Org\Util\JsApi_pub();
		$unifiedOrder = new \Org\Util\UnifiedOrder_pub();
		
		//设置统一支付接口参数
		//设置必填参数
		$unifiedOrder->setParameter("body","济南市公安局机动车驾驶人考试服务中心");//商品描述
		$unifiedOrder->setParameter("out_trade_no","$out_trade_no");//商户订单号 
		$unifiedOrder->setParameter("total_fee",$money);//总金额
		//$unifiedOrder->setParameter("total_fee",1);//总金额
		//$unifiedOrder->setParameter("notify_url", \Org\Util\WxPayConf_pub::NOTIFY_URL);//通知地址 
		$unifiedOrder->setParameter("notify_url", \Org\Util\WxPayConf_pub::NOTIFY_NATIVE_URL);//通知地址 
		$unifiedOrder->setParameter("trade_type","NATIVE");//交易类型

		//获取统一支付接口结果
		$unifiedOrderResult = $unifiedOrder->getResult();
		
		//商户根据实际情况设置相应的处理流程
		if ($unifiedOrderResult["return_code"] == "FAIL") 
		{
			//商户自行增加处理流程
			echo "通信出错：".$unifiedOrderResult['return_msg']."<br>";
		}
		elseif($unifiedOrderResult["result_code"] == "FAIL")
		{
			//商户自行增加处理流程
			echo "错误代码：".$unifiedOrderResult['err_code']."<br>";
			echo "错误代码描述：".$unifiedOrderResult['err_code_des']."<br>";
		}
		elseif($unifiedOrderResult["code_url"] != NULL)
		{
			//从统一支付接口获取到code_url
			$code_url = $unifiedOrderResult["code_url"];
			//商户自行增加处理流程
			//......
		}
		if($code_url){
			$result['status'] = 0;
			$result['code_url'] = $code_url;
			$result['out_trade_no'] = $out_trade_no;
		}else{
			$result['status'] = 1;
			$result['msg'] = "获取二维码失败,请重试!";
		}
		$this->ajaxReturn($result);
	}

	//JSAPI支付通知
	public function notify_url(){
        //存储微信的回调
        $JsApi_pub = new \Org\Util\JsApi_pub();
        $notify = new \Org\Util\Wxpay_server_pub();
        $xml = $GLOBALS['HTTP_RAW_POST_DATA'];
        $data = $notify->saveData($xml);
        //验证签名，并回应微信。
        //对后台通知交互时，如果微信收到商户的应答不是成功或超时，微信认为通知失败，
        //微信会通过一定的策略（如30分钟共8次）定期重新发起通知，
        //尽可能提高通知的成功率，但微信不保证通知最终能成功。
        if($notify->checkSign() == FALSE){
        	$notify->setReturnParameter("return_code","FAIL");//返回状态码
        	$notify->setReturnParameter("return_msg","签名失败");//返回信息
        }else{
        	$notify->setReturnParameter("return_code","SUCCESS");//设置返回码
        }
        $returnXml = $notify->returnXml();

        $log_name= "./Public/notify_url.log";//log文件路径
        
        log_result($log_name,"【接收到的notify通知】:\n".$xml."\n");
        
        if($notify->checkSign() == TRUE)
        {
        	if ($notify->data["return_code"] == "FAIL") {
        		//此处应该更新一下订单状态，商户自行增删操作
        		log_result($log_name,"【通信出错】:\n".$xml."\n");
        	}
        	elseif($notify->data["result_code"] == "FAIL"){
        		//此处应该更新一下订单状态，商户自行增删操作
        		log_result($log_name,"【业务出错】:\n".$xml."\n");
        	}
        	else{
        		//此处应该更新一下订单状态，商户自行增删操作
        		log_result($log_name,"【支付成功】:\n".$xml."\n");
        		// if($data['return_code'] == "SUCCESS" && $data['result_code'] == "SUCCESS"){}
        		//根据商户号查询未支付，插入到订单表，删除未支付
        		if($data['out_trade_no'] != ''){

	        		$weizhifu = M('weizhifu');
	        		$wp_dingdan = M('dingdan');

					$out_trade_no = $data['out_trade_no'];
					$where['out_trade_no'] = $out_trade_no;
					$list = $weizhifu->where($where)->find();

					$data['xid'] = $list['xid'];//学员id
					$data['jxid'] = $list['jxid'];//驾校id
					$data['jid'] = $list['jid'];//教练id
					
					$where_paiban['id'] = array(in,$list['pid']);
					$paiban_list = M('paiban')->where($where_paiban)->select();
					$data['pch'] = $paiban_list[0]['ch'];//车号
					$data['pdata'] = $paiban_list[0]['data'];//日期
					foreach($paiban_list as $v){
						$time_arr[] = $v['time'];
					}

					$data['ptime'] = implode(',',$time_arr);//时间段
					$data['pid'] = $list['pid'];//时间段的id
					$data['tuan'] = $list['tuan'];//团购成员
					$data['dbh'] = $list['dbh'];//订单编号
					$data['num'] = $list['num'];//时长
					$data['money'] = $data['total_fee'] / 100;//车钱
					$data['fs'] = '2';//约车方式1微信、2线下
					$data['status'] = 0;//订单状态 0:交易成功1:已退款 2:已消费3:退款中
					$data['mch_id'] = $data['mch_id'];//商户号
					$data['transaction_id'] = $data['transaction_id'];//微信支付订单号
					$data['out_trade_no'] = $data['out_trade_no'];//商户系统的订单号
					$data['time_end'] = $data['time_end'];//支付完成时间
					$data['daddtime'] = date('Y-m-d H:i:s',time());//添加时间
					
					//添加订单到订单表
					$suc = $wp_dingdan->data($data)->add();
					$map['out_trade_no'] = $data['out_trade_no'];
					$del = $weizhifu -> where($map) ->delete();
        		}
        		
        	}
        }else{
        	log_result($log_name,"【支付失败】:\n".$xml."\n");
        }
        echo $returnXml;

	}

	//定时查询订单状态
	public function OrderQuery(){
		$out_trade_no = $_POST['out_trade_no'];
		$jsApi = new \Org\Util\JsApi_pub();
		$Query_pub = new \Org\Util\OrderQuery_pub();
		$Query_pub->setParameter('out_trade_no',$out_trade_no);
		$dingdan = $Query_pub->getResult();
		
		if($dingdan['return_code'] == 'SUCCESS' && $dingdan['return_msg'] == 'OK' && $dingdan['result_code'] == 'SUCCESS' && $dingdan['trade_state'] == 'SUCCESS' ){
			$result['msg'] = 'OK';
		}else {
			$result['msg'] = 'NO';
		}
		$this->ajaxReturn($result);
	}
	
	//打印列表
	public function dayin_list(){
		// dump($_SESSION);//die;

		$a = strrchr($_SERVER['DOCUMENT_ROOT'],'/');
    	$b = substr($a,1);
    	// if($_SESSION["$b"."_home"]['user_auth']['username'] == 'admin'){
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

		$data = date('Y-m-d',time());
		$paiban = M('paiban');
		$where['data'] = $data;
		// for ($i=1; $i < 41; $i++) { 
		// 	$where['ch'] = $i;
		// 	$list[$i] = $paiban->where($where)->select();
		// }
		$where['ch'] = 1;
		$where['type'] = 1;
		$list= $paiban->where($where)->order('time asc')->select();
		$fabu_list = $this->groupArrray($list,6);
		// dump($list);
		// dump($fabu_list);
		// dump($json);//die;
		// $arr = array_filter($list); 
		// $this->assign('arr',$arr);
		$this->assign('json',$json);
		$this->assign('fabu_list',$fabu_list);
		$this->display();
	}

	//数组分组
	/**
	 * @param $array
	 * @param $int
	 * return array
	 */
	public function groupArrray($array = array(), $int = 0)
	{
	    // if (!($array && $int)) {
	    //     return false;
	    // }
	    // $array2 = array();
	    // foreach ($array as $k => $v) {
	    //     $k1 = intval($k / $int);
	    //     $array2[$k1][] = $v;
	    // }
	    // return $array2;
	    if (!($array && $int)) {
        return false;
	    }
	    $array2 = array();
	    foreach ($array as $k => $v) {
	        $k1 = intval($k / $int);
	        $array2[$k1][] = $v;
	    }
	    $end = array_pop($array2);
	    for ($i = 1; $i <= $int; $i++) {
	        $end[$i - 1] = $end[$i - 1] ? $end[$i - 1] : array();
	    }
	    $array2[] = $end;
	    return $array2;
	}

	//异步获取
	public function huoqu(){
		header("Content-type:text/html;charset=utf-8");
		$data = I('data');
		$ch = I('ch');
		$today_date = date('Ymd');
		$get_date = str_replace('-','',$data);
		if($get_date < $today_date){
			echo json_encode('过期时间！');die;
		}else{
			$paiban = M('paiban');
			$where['data'] = $data;
			$where['ch'] = $ch;
			$where['type'] = 1;

			$list = $paiban->where($where)->order('time asc')->select();
			$list = $this->groupArrray($list,6);

			if($list){
				echo json_encode( $list );die;
			}else{
				echo json_encode('没有查询到数据！');die;
			}
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
			// file_put_contents('./wd.txt',$json);
			echo $json;die;
		}else{
			echo '没有教练';die;
		}
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
	
	//已完成订单列表
	public function ding_list(){
    	header("Content-type:text/html;charset=utf-8");
    	$datetimepicker = I('datetimepicker');
    	$datetimepicker1 = I('datetimepicker1');
		$keywords = I('keywords');
		$username = $_SESSION['juye_home']['user_auth']['username'];
		if('admin' != $username){
			$user = M('user');
			$where1['nickname'] = $username;
			$list = $user->field('jxid')->where($where1)->find();
			$where['jxid'] = $list['jxid'];
		}
		//手机号或身份证为空,时间段不为空
    	if($datetimepicker != '' && $datetimepicker1 != '' && $keywords == ""){
    		// if($datetimepicker == $datetimepicker1){
    		// 	$where['d.daddtime'] =  array('like',"%$datetimepicker%");
    		// }else{
    			$where['d.daddtime'] =  array('between',array($datetimepicker.' 00:00:00',$datetimepicker1.' 23:59:59'));
    		//}
    	}
    	//手机号或身份证不为空,时间段为空
    	if($datetimepicker == '' && $datetimepicker1 == '' && $keywords !== ""){
    		if(strlen($keywords) > 11 || substr($keywords,0,1) != 1){
    			$where['x.xcard'] = array('like',"%$keywords%");
    		}else{
    			$where['x.xphone'] = array('like',"%$keywords%");
    		}
    	}
    	//手机号或身份证与时间段都不为空
    	if($datetimepicker !== '' && $datetimepicker1 !== '' && $keywords !== ""){
    		// if($datetimepicker == $datetimepicker1){
    		// 	$where['d.daddtime'] =  array('like',"%$datetimepicker%");
    		// }else{
    			$where['d.daddtime'] =  array('between',array($datetimepicker.' 00:00:00',$datetimepicker1.' 23:59:59'));
    		// }

    		if(strlen($keywords) > 11 || substr($keywords,0,1) != 1){
    			//echo '身份证';die;
    			$where['x.xcard'] = array('like',"%$keywords%");
    		}else{
    			//echo '手机号';die;
    			$where['x.xphone'] = array('like',"%$keywords%");
    		}
    	}
		
		$dingdan= M('dingdan');
		$datetimepicker = I('datetimepicker');
		$datetimepicker1 = I('datetimepicker1');
		$where['d.fs'] = 2;
		$totalCount = $dingdan->table('wp_dingdan d')
		// ->join('wp_jiaolian j on d.jid=j.id')
		->join('wp_xueyuan x on d.xid=x.id')
		->join('wp_paiban p on d.pid=p.id')
		->field('*,d.id as id,d.status as status')
		->where($where)
		->count();
		// var_dump($totalCount);die;
		$Page = new \Think\Page ( $totalCount,15 );
		$Page->setConfig ( 'theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%' );
		$dingdan_list = $dingdan->table('wp_dingdan d')
		// ->join('wp_jiaolian j on d.jid=j.id')
			->join('wp_xueyuan x on d.xid=x.id')
			->join('wp_paiban p on d.pid=p.id')
			->field('*,d.id as id,d.status as status')
			->where($where)
			->limit($Page->firstRow.','.$Page->listRows)
			->order('d.id desc')
			->select();	
		foreach($dingdan_list as $k=>$v){
			if($v['status'] == 0 ){
				$dingdan_list[$k]['status'] = '未消费';
			}elseif($v['status'] == 1){
				$dingdan_list[$k]['status'] = '已退款';
			}elseif($v['status'] == 2){
				$dingdan_list[$k]['status'] = '已消费';
			}elseif($v['status'] == 3){
				$dingdan_list[$k]['status'] = '退款中';
			}
		}
		$page  = $Page->show();// 分页显示输出
		$this->assign ( 'dingdan_list', $dingdan_list );
		$this->assign('_page', $page);
		$this->assign('datetimepicker', $datetimepicker);
		$this->assign('datetimepicker1', $datetimepicker1);
		$this->assign('keywords', $keywords);
		$this->display();
	}
	
	//已完成订单详情
	public function ding_xq(){
		header("Content-type:text/html;charset=utf-8");
		$id = I('id');
		$dingdan = M('dingdan');
		$where['d.id'] = $id;
		$list = $dingdan->table('wp_dingdan d')
				->join('wp_xueyuan x on d.xid = x.id')
				->join('wp_jiaxiao jx on x.jx = jx.id')
				->join('wp_jiaolian jl on x.jl_id = jl.id')
				->where($where)
				->field('*,d.id as id')
				->select();
		// dump($list[0]['tuan']);die;
		// dump($list);die;
		$tuan_id = $list[0]['tuan'];
		//查询组团人员
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

	//下载订单列表
	public function ding_Download(){
    	header("Content-type:text/html;charset=utf-8");
		$objPHPExcel = new \Org\Util\PHPExcel();
		$dingdan= M('dingdan');
		$jiaolian= M('jiaolian');
		$xueyuan= M('xueyuan');
		$yuyue= M('yuyue');
		$where['d.fs'] = 2;
	    
        $datetimepicker = I('datetimepicker');
    	$datetimepicker1 = I('datetimepicker1');
		$keywords = I('keywords');
		// $where['d.status'] = 0;
		//手机号或身份证为空,时间段不为空
    	if($datetimepicker != '' && $datetimepicker1 != '' && $keywords == ""){
    		// if($datetimepicker == $datetimepicker1){
    		// 	$where['d.daddtime'] =  array('like',"%$datetimepicker%");
    		// }else{
    			$where['d.daddtime'] =  array('between',array($datetimepicker.' 00:00:00',$datetimepicker1.' 23:59:59'));
    		//}
    	}
    	//手机号或身份证不为空,时间段为空
    	if($datetimepicker == '' && $datetimepicker1 == '' && $keywords !== ""){
    		if(strlen($keywords) > 11 || substr($keywords,0,1) != 1){
    			$where['x.xcard'] = array('like',"%$keywords%");
    		}else{
    			$where['x.xphone'] = array('like',"%$keywords%");
    		}
    	}
    	//手机号或身份证与时间段都不为空
    	if($datetimepicker !== '' && $datetimepicker1 !== '' && $keywords !== ""){
    		// if($datetimepicker == $datetimepicker1){
    		// 	$where['d.daddtime'] =  array('like',"%$datetimepicker%");
    		// }else{
    			$where['d.daddtime'] =  array('between',array($datetimepicker.' 00:00:00',$datetimepicker1.' 23:59:59'));
    		//}
    		if(strlen($keywords) > 11 || substr($keywords,0,1) != 1){
    			//echo '身份证';die;
    			$where['x.xcard'] = array('like',"%$keywords%");
    		}else{
    			//echo '手机号';die;
    			$where['x.xphone'] = array('like',"%$keywords%");
    		}
    	}

    	$list = $dingdan->table('wp_dingdan d')
	 	    // ->join('wp_jiaolian j on d.jid=j.id')
	 	    ->join('wp_xueyuan x on d.xid=x.id')
	 	    ->join('wp_paiban p on d.pid=p.id')
	 	 	->field('*,d.id as id,d.status as status')
	 	    ->where($where)
	 	    ->order('d.id desc')
	 	    ->select();
		foreach($list as $k=>$v){
			if($v['status'] == 0 ){
				$list[$k]['status'] = '未消费';
			}elseif($v['status'] == 1){
				$list[$k]['status'] = '已退款';
			}elseif($v['status'] == 2){
				$list[$k]['status'] = '已消费';
			}elseif($v['status'] == 3){
				$list[$k]['status'] = '退款中';
			}
		}
	 	// var_dump($list);die;
	 	// 设置excel属性
	 	$objPHPExcel -> getProperties() -> setCreator("JAMES")
	 	-> setlastModifiedBy("JAMES")
	 	-> setTitle("未消费报表")
	 	-> setSubject("未消费报表")
	 	-> setDescription("未消费报表")
	 	-> setKeywords("未消费报表")
	 	-> setCategory("未消费报表");
		$objPHPExcel->getDefaultStyle()->getFont()->setName("微软雅黑")->setSize(12);//设置默认字体大小
		//设置第一行行高 
		$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(31.5);
	 	if($list){
	 	$objPHPExcel -> setActiveSheetIndex(0)
	 	-> setCellValue('A1','编号')
	 	-> setCellValue('B1','学员姓名')
	 	-> setCellValue('C1','预约日期')
	 	-> setCellValue('D1','预约时间段')
	 	-> setCellValue('E1','预约车号')
	 	-> setCellValue('F1','下单时间')
	 	-> setCellValue('G1','金额')
	 	-> setCellValue('H1','状态');
	 	//设置宽度
	 	$objPHPExcel -> getActiveSheet() -> getColumnDimension('A') -> setWidth(7);
	 	$objPHPExcel -> getActiveSheet() -> getColumnDimension('B') -> setWidth(10);
	 	$objPHPExcel -> getActiveSheet() -> getColumnDimension('C') -> setWidth(15);
	 	$objPHPExcel -> getActiveSheet() -> getColumnDimension('D') -> setWidth(15);
	 	$objPHPExcel -> getActiveSheet() -> getColumnDimension('E') -> setWidth(10);
	 	$objPHPExcel -> getActiveSheet() -> getColumnDimension('F') -> setWidth(20);
	 	$objPHPExcel -> getActiveSheet() -> getColumnDimension('G') -> setWidth(15);
	 	$objPHPExcel -> getActiveSheet() -> getColumnDimension('H') -> setWidth(10);
	 	 $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);  
	 	 $objPHPExcel->getActiveSheet()->getStyle('B1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);  
	 	 $objPHPExcel->getActiveSheet()->getStyle('C1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);  
	 	 $objPHPExcel->getActiveSheet()->getStyle('D1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);  
	 	 $objPHPExcel->getActiveSheet()->getStyle('E1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);  
	 	 $objPHPExcel->getActiveSheet()->getStyle('F1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);  
	 	 $objPHPExcel->getActiveSheet()->getStyle('G1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	 	 $objPHPExcel->getActiveSheet()->getStyle('H1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	 	$styleThinBlackBorderOutline = array(
	 	       'borders' => array (
	 	             'outline' => array (
	 	                   'style' => \PHPExcel_Style_Border::BORDER_THIN,   //设置border样式
	 	                   //'style' => PHPExcel_Style_Border::BORDER_THICK,  另一种样式
	 	                   'color' => array ('argb' => 'FF000000'),          //设置border颜色
	 	            ),
	 	      ),
	 	);
	 	$objPHPExcel->getActiveSheet()->getStyle( 'A1:H1')->applyFromArray($styleThinBlackBorderOutline);
	 	$objPHPExcel->getActiveSheet()->getStyle('A1:H1')->getBorders()->getAllBorders()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);
	 	 
	 	      
	 	$c = 1;
	 	$sort = 0;
	 	$excelName = '';
	 	foreach ($list as $key => $value) {
		 	$c++;
		 	$sort++;
			$objPHPExcel->getActiveSheet()->getRowDimension($c)->setRowHeight(25.5);
	 		$objPHPExcel->getActiveSheet()->getStyle('A')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);  
	 		$objPHPExcel->getActiveSheet()->getStyle('B')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);  
	 		$objPHPExcel->getActiveSheet()->getStyle('C')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);  
	 		$objPHPExcel->getActiveSheet()->getStyle('D')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);  
	 		$objPHPExcel->getActiveSheet()->getStyle('E')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);  
	 		$objPHPExcel->getActiveSheet()->getStyle('F')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);  
	 		$objPHPExcel->getActiveSheet()->getStyle('G')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	 		$objPHPExcel->getActiveSheet()->getStyle('H')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	 	    $objPHPExcel->getActiveSheet()->getStyle( 'A'.$c.':H'.$c)->applyFromArray($styleThinBlackBorderOutline);
	 	$objPHPExcel->getActiveSheet()->getStyle( 'A'.$c.':H'.$c)->getBorders()->getAllBorders()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);



		 	$objPHPExcel -> setActiveSheetIndex(0) -> setCellValue('A'.$c,$value['id']);
		 	$objPHPExcel -> setActiveSheetIndex(0) -> setCellValue('B'.$c,$value['xname']);
		 	// $objPHPExcel -> setActiveSheetIndex(0) -> setCellValue('C'.$c,$value['jname']);
		 	$objPHPExcel -> setActiveSheetIndex(0) -> setCellValue('C'.$c,$value['pdata']);
		 	// $objPHPExcel -> setActiveSheetIndex(0) -> setCellValue('D'.$c,!empty($value['transaction_id']) ? $value['transaction_id'] : $value['dbh']);
		 	$objPHPExcel -> setActiveSheetIndex(0) -> setCellValue('D'.$c, $value['ptime']);
		 	$objPHPExcel -> setActiveSheetIndex(0) -> setCellValue('E'.$c,$value['pch']);
		 	$objPHPExcel -> setActiveSheetIndex(0) -> setCellValue('F'.$c,$value['daddtime']);
		 	$objPHPExcel -> setActiveSheetIndex(0) -> setCellValue('G'.$c,$value['money'].' 元');
		 	// $objPHPExcel -> setActiveSheetIndex(0) -> setCellValue('H'.$c,'未消费');
		 	$objPHPExcel -> setActiveSheetIndex(0) -> setCellValue('H'.$c,$value['status']);
		 	$excelName = '未消费报表';

	 	}
	 }
	  
	  $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(\PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
	   $objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(\PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);

	 	// 将Excel文件保存到框架指定目录
	 	import("Org.Util.PHPExcel.IOFactory");
	 	$ObjWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
	 	$filelName = iconv('utf-8','gb2312',$excelName); //利用Iconv函数对文件名进行重新编码
	 	// $ObjWriter -> save('Public/ReportForms/'.$excelName);

	 	$data = date('YmdHis',time());
	 	// 导出到本地
	 	$objWriter= \PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
	 	$filename = $excelName.$data.'.xls';
	 	ob_end_clean();//清除缓存以免乱码出现
	 	header('Content-Type: application/vnd.ms-excel');
	 	header('Content-Type: application/octet-stream');
	 	header('Content-Disposition: attachment; filename="' . $filename . '"');
	 	header('Cache-Control: max-age=0');
	 	$objWriter -> save('php://output');die;	
	 }

	//未支付订单列表页面
	public function wei_list(){
    	// header("Content-type:text/html;charset=utf-8");
		// echo "<pre>";
		// var_dump($_SESSION);die;
		$weizhifu= M('weizhifu');
		$datetimepicker = I('datetimepicker');
		$datetimepicker1 = I('datetimepicker1');
		$keywords = I('keywords');
		$username = $_SESSION['juye_home']['user_auth']['username'];
		if('admin' != $username){
			$user = M('user');
			$where1['nickname'] = $username;
			$list = $user->field('jxid')->where($where1)->find();
			$where['jxid'] = $list['jxid'];
		}
		$where['w.status'] = 1;
		//手机号或身份证为空,时间段不为空
    	if($datetimepicker != '' && $datetimepicker1 != '' && $keywords == ""){
    		// if($datetimepicker == $datetimepicker1){
    		// 	$where['w.addtime'] =  array('like',"%$datetimepicker%");
    		// }else{
    			$where['w.addtime'] =  array('between',array($datetimepicker.' 00:00:00',$datetimepicker1.' 23:59:59'));
    		// }
    	}
    	//手机号或身份证不为空,时间段为空
    	if($datetimepicker == '' && $datetimepicker1 == '' && $keywords !== ""){
    		if(strlen($keywords) > 11){
    			$where['x.xcard'] = array('like',"%$keywords%");
    		}else{
    			$where['x.xphone'] = array('like',"%$keywords%");
    		}
    	}
    	//手机号或身份证与时间段都不为空
    	if($datetimepicker !== '' && $datetimepicker1 !== '' && $keywords !== ""){
    		// if($datetimepicker == $datetimepicker1){
    		// 	$where['w.addtime'] =  array('like',"%$datetimepicker%");
    		// }else{
    			$where['w.addtime'] =  array('between',array($datetimepicker.' 00:00:00',$datetimepicker1.' 23:59:59'));
    		// }
    		if(strlen($keywords) > 11){
    			//echo '身份证';die;
    			$where['x.xcard'] = array('like',"%$keywords%");
    		}else{
    			//echo '手机号';die;
    			$where['x.xphone'] = array('like',"%$keywords%");
    		}
    	}
		// $where['w.addtime'] = array('between',array($datetimepicker,$datetimepicker1));
		// $wei_list = $weizhifu->table('wp_weizhifu w')
		// // ->join('wp_jiaolian j on d.jid=j.id')
		// ->join('wp_xueyuan x on w.xid=x.id')
		// ->join('wp_paiban p on w.pid=p.id')
		// ->field('*,w.id as id')
		// ->where($where)
		// ->order('w.id desc')
		// ->select();
		// $json = json_encode($wei_list);
		// echo $json;die;
		 
		
		$totalCount = $weizhifu->table('wp_weizhifu w')
			// ->join('wp_jiaolian j on d.jid=j.id')
			->join('wp_xueyuan x on w.xid=x.id')
			->join('wp_paiban p on w.pid=p.id')
			->field('*,w.id as id')
			->where($where)
			->count();
			// var_dump($totalCount);die;
		$Page = new \Think\Page ( $totalCount,15 );
		$Page->setConfig ( 'theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%' );
		$wei_list = $weizhifu->table('wp_weizhifu w')
			// ->join('wp_jiaolian j on d.jid=j.id')
			->join('wp_xueyuan x on w.xid=x.id')
			->join('wp_paiban p on w.pid=p.id')
			->field('*,w.id as id')
			->where($where)
			->limit($Page->firstRow.','.$Page->listRows)
			->order('w.id desc')
			->select();
			
			// $request = ( array ) I ( 'request.' );
			// $total = $wei_list ? count ( $wei_list ) : 1;
			// $listRows = C('LIST_ROWS') > 0 ? C('LIST_ROWS') : 20;
			// $page = new \Think\Page ( $total, $listRows, $request['p'] );
			// $voList = array_slice ( $wei_list, $page->firstRow, $page->listRows );
			// $p = $page->show ();
			// $this->assign ( 'wei_list', $voList );
			// $this->assign ( '_page', $p ? $p : '' );
			// dump($wei_list);
			foreach ($wei_list as $key => $value) {
				// dump($value)."<br>";
				$pid[] = $value['pid'];
				$sql = "select `time` from `wp_paiban` where `id` in (".$pid[$key].")";
				$res = M('paiban')->query($sql);
				// dump($res);
				
 				$ress = array_column($res, 'time');
 				//dump($ress);
				// dump(implode(',',$ress));
				$wei_list[$key]['time'] = implode(',',$ress);
				
			}
			
			//dump($res);
			// echo '<hr/>';
			// dump($wei_list);
			$page  = $Page->show();// 分页显示输出
			$this->assign ( 'wei_list', $wei_list );
			$this->assign('_page', $page);
			$this->assign('datetimepicker1', $datetimepicker1);
			$this->assign('datetimepicker', $datetimepicker);
			$this->assign('keywords', $keywords);
			$this->display();
	}

	//未支付订单详情
	public function wei_xq(){
    	header("Content-type:text/html;charset=utf-8");
		$id = I('id');
		$weizhifu = M('weizhifu');
		$where['w.id'] = $id;
		$list = $weizhifu->table('wp_weizhifu w')
				->join('wp_xueyuan x on w.xid = x.id')
				->join('wp_jiaxiao jx on x.jx = jx.id')
				->join('wp_jiaolian jl on x.jl_id = jl.id')
				->where($where)
				->field('*,w.id as id')
				->select();
		// dump($list);die;
		$tuan_id = $list[0]['tuan'];
		//查询组团人员
		$sql = "SELECT `xname` FROM `wp_xueyuan` WHERE `id` IN ( ".$tuan_id." )";
		$t_xname = M('xueyuan')->query($sql);
		foreach($t_xname as $k=>$v){
			$t_name[$k] = $v['xname'];
		}
		$tuan_name = implode(',',$t_name);
		//查询预约时间段
		$pid = $list[0]['pid'];
		$sql = "SELECT `time` FROM `wp_paiban` WHERE `id` IN ( ".$pid." )";
		$yuyue_time = M('paiban')->query($sql);
		foreach ($yuyue_time as $key => $value) {
			$yuyue_arr[$key] = $value['time'];
		}
		$yuyue_times = implode(',',$yuyue_arr);

		$this->assign('tuan_name',$tuan_name);
		$this->assign('yuyue_times',$yuyue_times);
		$this->assign('list',$list);
		$this->display();
	}

	//退款申请页
	public function tuikuan(){
		$id = I('id');
		$dingdan = M('dingdan');
		$where['d.id'] = $id;
		$list = $dingdan->table('wp_dingdan d')
				->join('wp_xueyuan x on d.jxid = x.jx')
				->where($where)
				->field('*,d.id as id')
				->find();
		//dump($list);
		$this->assign('list',$list);
		$this->display();
	}
	//退款提交
	public function tijiao_tuikuan(){
		$host_url = $_SERVER['HTTP_HOST'];
		$id = I('id');
		$twark = I('twark');
		$refund_fee = I('refund_fee');
		$koufei = I('koufei');
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
		if($updingdan == 1){
			$result['url'] = "http://".$host_url."/index.php?s=/Home/Jxyueche/ding_list";
		}else{
			$result['status'] = 0;
			$result['msg'] = '退款申请提交失败';
		}
		$this->ajaxReturn($result);
	}

	//添加驾校学员
	public function do_add_student(){
		if(IS_POST){
			$xueyuan = M('xueyuan');
			$xcard= I('xcard');//身份证
			$where['xcard'] = $xcard;
			$is_exist = $xueyuan->where($where)->find();
			if($is_exist){
				$result['status'] = 0;
				$result['msg'] = '该学员已存在！';
				$this->ajaxReturn($result);
			}
			// var_dump($_POST);
			$data['xname'] = I('tNameL');//姓名
			$sex = I('tSexL');//性别
			if($sex == '男'){
				$data['xsex'] = 1;//性别：1男
			}else{
				$data['xsex'] = 2;//性别：2女
			}
			$data['xbirth'] = I('tBirth');//出生
			$data['xphone'] = I('xphone');//电话
			$data['xcard'] = $xcard;//身份证
			$data['xaddr'] = I('tAddr');//地址
			$data['xnow_addr'] = I('xnow_addr');//现地址
			$data['xbh'] = I('xbh');//学员编号
			$data['jx'] = I('jxid');//驾校id
			$data['jl_id'] = I('jid');//教练id
			$data['xy'] = 1;//协议 1:同意,2:不同意
			$data['xaddtime'] = date('Y-m-d H:i:s',time());//添加时间
			// file_put_contents('wd.txt',$data);die;
			$suc = $xueyuan->data($data)->add();
			if($suc){
				$result['status'] = 1;
				$result['url'] = U('Jxyueche/jxueyuan_list');
			}else{
				$result['status'] = 0;
				$result['msg'] = '学员信息添加失败';
			}
			$this->ajaxReturn($result);
		}
	}
	
	//弹出错误
	public function field(){
		$this->display();
	}
}
	