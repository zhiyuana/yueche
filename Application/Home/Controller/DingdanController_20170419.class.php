<?php

namespace Home\Controller;
use Think\Model;
/**
 * 素材管理控制器
 */
class DingdanController extends HomeController {
	function _initialize() {
		parent::_initialize ();
		
		$act = strtolower ( ACTION_NAME );
		$param = array (
				'mdm' => I ( 'mdm' ) 
		);
		$res ['title'] = '未消费订单列表';
		$res ['url'] = U ( 'ding_list', $param );
		$res ['class'] = strpos ( $act, 'ding_list' ) !== false ? 'current' : '';
		$nav [] = $res;

		$res ['title'] = '已消费订单列表';
		$res ['url'] = U ( 'xiao_list', $param );
		$res ['class'] = strpos ( $act, 'xiao_list' ) !== false ? 'current' : '';
		$nav [] = $res;

		$res ['title'] = '未支付订单列表';
		$res ['url'] = U ( 'wei_list', $param );
		$res ['class'] = strpos ( $act, 'wei_list' ) !== false ? 'current' : '';
		$nav [] = $res;

		$res ['title'] = '已退款订单列表';
		$res ['url'] = U ( 'tui_list', $param );
		$res ['class'] = strpos ( $act, 'tui_list' ) !== false ? 'current' : '';
		$nav [] = $res;

		$res ['title'] = '退款审核列表';
		$res ['url'] = U ( 'shen_list', $param );
		$res ['class'] = strpos ( $act, 'shen_list' ) !== false ? 'current' : '';
		$nav [] = $res;

		
		
		$this->assign ( 'nav', $nav );
	}
	

	//未消费订单列表页面
	public function ding_list(){
    	// header("Content-type:text/html;charset=utf-8");
		$dingdan= M('dingdan');
		$datetimepicker = I('datetimepicker');
		$datetimepicker1 = I('datetimepicker1');
		$where['d.status'] = 0;
		
		if($datetimepicker !="" && $datetimepicker1 !="" && $datetimepicker !="null" && $datetimepicker1 !="null"){
			$where['d.daddtime'] = array('between',array($datetimepicker,$datetimepicker1));
			$dingdan_list = $dingdan->table('wp_dingdan d')
			// ->join('wp_jiaolian j on d.jid=j.id')
			->join('wp_xueyuan x on d.xid=x.id')
			->join('wp_paiban p on d.pid=p.id')
			->field('*,d.id as id,d.status as status')
			->where($where)
			->order('d.id desc')
			->select();
			$json = json_encode($dingdan_list);
			echo $json;die;
		}else{
			$dingdan_list = $dingdan->table('wp_dingdan d')
			// ->join('wp_jiaolian j on d.jid=j.id')
			->join('wp_xueyuan x on d.xid=x.id')
			->join('wp_paiban p on d.pid=p.id')
			->field('*,d.id as id,d.status as status')
			->where($where)
			->order('d.id desc')
			->select();
			$this->assign('dingdan_list',$dingdan_list);
			$this->display();
		}
	}
	
	//未支付订单列表页面
	public function wei_list(){
    	// header("Content-type:text/html;charset=utf-8");
		$weizhifu= M('weizhifu');
		$datetimepicker = I('datetimepicker');
		$datetimepicker1 = I('datetimepicker1');
		$where['w.status'] = 1;
		if($datetimepicker !="" && $datetimepicker1 !="" && $datetimepicker !="null" && $datetimepicker1 !="null"){
			$where['w.addtime'] = array('between',array($datetimepicker,$datetimepicker1));
			$wei_list = $weizhifu->table('wp_weizhifu w')
			// ->join('wp_jiaolian j on d.jid=j.id')
			->join('wp_xueyuan x on w.xid=x.id')
			->join('wp_paiban p on w.pid=p.id')
			->field('*,w.id as id')
			->where($where)
			->order('w.id desc')
			->select();
			$json = json_encode($wei_list);
			echo $json;die;
		}else{
			$wei_list = $weizhifu->table('wp_weizhifu w')
			// ->join('wp_jiaolian j on d.jid=j.id')
			->join('wp_xueyuan x on w.xid=x.id')
			->join('wp_paiban p on w.pid=p.id')
			->field('*,w.id as id')
			->where($where)
			->order('w.id desc')
			->select();			
			$this->assign('wei_list',$wei_list);
			$this->display();
		}

	}

	//已消费订单列表页面
	public function xiao_list(){
    	// header("Content-type:text/html;charset=utf-8");
		$dingdan= M('dingdan');
		$datetimepicker = I('datetimepicker');
		$datetimepicker1 = I('datetimepicker1');
		$where['d.status'] = 2;
		if($datetimepicker !="" && $datetimepicker1 !="" && $datetimepicker !="null" && $datetimepicker1 !="null"){
			$where['d.daddtime'] = array('between',array($datetimepicker,$datetimepicker1));
			$xiao_list = $dingdan->table('wp_dingdan d')
			// ->join('wp_jiaolian j on d.jid=j.id')
			->join('wp_xueyuan x on d.xid=x.id')
			->join('wp_paiban p on d.pid=p.id')
			->field('*,d.id as id,d.status as status')
			->where($where)
			->order('d.id desc')
			->select();
			$json = json_encode($xiao_list);
			echo $json;die;
		}else{
			$xiao_list = $dingdan->table('wp_dingdan d')
			// ->join('wp_jiaolian j on d.jid=j.id')
			->join('wp_xueyuan x on d.xid=x.id')
			->join('wp_paiban p on d.pid=p.id')
			->field('*,d.id as id,d.status as status')
			->where($where)
			->order('d.id desc')
			->select();		
			$this->assign('xiao_list',$xiao_list);
			$this->display();
		}	

	}

	//已退款订单列表页面
	public function tui_list(){
    	header("Content-type:text/html;charset=utf-8");
		$tuikuan= M('tuikuan');
		$datetimepicker = I('datetimepicker');
		$datetimepicker1 = I('datetimepicker1');
	 	$where['t.status'] = 1;
		if($datetimepicker !="" && $datetimepicker1 !="" && $datetimepicker !="null" && $datetimepicker1 !="null"){
			$where['t.taddtime'] = array('between',array($datetimepicker,$datetimepicker1));
			$tui_list = $tuikuan->table('wp_tuikuan t')
			// ->join('wp_jiaolian j on d.jid=j.id')
			->join('wp_xueyuan x on t.xid=x.id')
			->join('wp_paiban p on t.pid=p.id')
			->field('*,t.id as id,t.status as status,t.pdata as pdata')
			->where($where)
			->order('t.id desc')
			->select();
			$json = json_encode($tui_list);
			echo $json;die;
		}else{
			$tui_list = $tuikuan->table('wp_tuikuan t')
			// ->join('wp_jiaolian j on d.jid=j.id')
			->join('wp_xueyuan x on t.xid=x.id')
			->join('wp_paiban p on t.pid=p.id')
			->field('*,t.id as id,t.status as status,t.pdata as pdata')
			->where($where)
			->order('t.id desc')
			->select();	
			$this->assign('tui_list',$tui_list);
			$this->display();
		}	 	
	}

	//退款审核列表页面
	public function shen_list(){
    	header("Content-type:text/html;charset=utf-8");
		$dingdan= M('dingdan');
		$datetimepicker = I('datetimepicker');
		$datetimepicker1 = I('datetimepicker1');
		$where['d.status'] = 3;
		if($datetimepicker !="" && $datetimepicker1 !="" && $datetimepicker !="null" && $datetimepicker1 !="null"){
			$where['d.daddtime'] = array('between',array($datetimepicker,$datetimepicker1));
			$shen_list = $dingdan->table('wp_dingdan d')
	        // ->join('wp_jiaolian j on d.jid=j.id')
	        ->join('wp_xueyuan x on d.xid=x.id')
	        ->join('wp_paiban p on d.pid=p.id')
	 		->field('*,d.id as id,d.status as status')
	        ->where($where)
	 		->order('d.id desc')
	 		->select();
			$json = json_encode($shen_list);
			echo $json;die;			
		}else{
			$shen_list = $dingdan->table('wp_dingdan d')
	        // ->join('wp_jiaolian j on d.jid=j.id')
	        ->join('wp_xueyuan x on d.xid=x.id')
	        ->join('wp_paiban p on d.pid=p.id')
	 		->field('*,d.id as id,d.status as status')
	        ->where($where)
	 		->order('d.id desc')
	 		->select();	
			$this->assign('shen_list',$shen_list);
			$this->display();
		}

	}

	//退款详情页面
	public function shen_xq(){
    	header("Content-type:text/html;charset=utf-8");
		$id = I('id');
		$dingdan = M('dingdan');
		$where['d.id'] = $id;
		$list = $dingdan->table('wp_dingdan d')
				->join('wp_xueyuan x on d.xid = x.id')
				->where($where)
				->field('*,d.id as id')
				->select();
		$this->assign('list',$list);
		$this->display();
	}

	//退款申请微信接口
	public function refund(){
		$id = I('id');
		$dingdan = M('dingdan');
		$where['d.id'] = $id;
		$list = $dingdan->table('wp_dingdan d')
				->join('wp_xueyuan x on d.uid = x.uid')
				->field('*,d.id as id')
				->where($where)
				->find();
		// var_dump($list);die;
		$transaction_id = $list['transaction_id'];//微信订单号
		$total_fee = $list['money'] * 100;//订单金额
		//$refund_fee = $list['money'] * 100; //退款金额
		$refund_fee = 1; //退款金额
		// var_dump($refund_fee);die;
		$refund_no = date('Ymd') . time() . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);//退款单号 唯一
		$op_user_id = $list['xname'];
		// var_dump($list);die;
		$jsApi = new \Org\Util\JsApi_pub();
		$Refund_pub = new \Org\Util\Refund_pub();
		$Refund_pub->setParameter('transaction_id',$transaction_id);
		$Refund_pub->setParameter('total_fee',$total_fee);
		$Refund_pub->setParameter('refund_fee',$refund_fee);
	    $Refund_pub->setParameter('out_refund_no',$refund_no);
	    $Refund_pub->setParameter('op_user_id',$op_user_id);
	    $arr = $Refund_pub->getResult();
		if($arr['result_code'] == 'SUCCESS'){
			$time = date('Y-m-d H:i:s',time());
			$data['uid'] = $list['uid'];
			$data['xid'] = $list['xid'];
			$data['jid'] = $list['jid'];
			$data['pch'] = $list['pch'];
			$data['pdata'] = $list['pdata'];
			$data['ptime'] = $list['ptime'];
			$data['pid'] = $list['pid'];
			$data['dbh'] = $list['dbh'];
			$data['km'] = $list['km'];
			$data['fs'] = $list['fs'];
			$data['shouxu'] = $list['shouxu'];
			$data['num'] = $list['num'];
			$data['status'] = 1;
			$data['mch_id'] = $arr['mch_id'];
			$data['transaction_id'] = $arr['transaction_id'];
			$data['out_trade_no'] = $arr['out_trade_no'];
			$data['out_refund_no'] = $arr['out_refund_no'];
			$data['refund_id'] = $arr['refund_id'];
			$data['refund_fee'] = $arr['refund_fee'] / 100;
			$data['money'] = $list['money'];
			$data['taddtime'] = $time;
			$data['twark'] = $list['shuoming'];
			$tuikuan = M('tuikuan');
			$result = $tuikuan->data($data)->add();
			$map['id'] = $id;
			$date['status'] = 1;
			$return = $dingdan->where($map)->save($date);
			$result['status'] = 1;
			// $result['url'] = "http://yueche.siwoinfo.com/index.php?s=/Home/Dingdan/shen_list/mdm/1832.html";
			// $this->ajaxReturn($result);
		}else{
			if($arr['err_code_des'] != ''){
				$result['status'] = 0;
				$result['msg'] = $arr['err_code_des'];
			}else{
				$result['status'] = 0;
				$result['msg'] = '提交业务失败,请重试';
			}
		}
			$this->ajaxReturn($result);
	}
/*
*   这个不用了！！！
*	为了区分dingdan、weizhifu、tuikuan表，dingdan=> 0:未消费 2:已消费 3:退款中
*	weizhifu =>未支付(weizhifu中是1，现在为 11)
*	tuikuan =>已退款(tuikuan中是1，现在为 12)
**/
 	public function search(){
		$datetimepicker = I('datetimepicker');
		$datetimepicker1 = I('datetimepicker1');
		$status = I('get.status');
		$dingdan=M('dingdan');
		$weizhifu=M('weizhifu');
		$tuikuan=M('tuikuan');
		if($status==11){
			if($datetimepicker !="" && $datetimepicker1 !=""){
				$ding_list=$weizhifu->table('wp_weizhifu w')
				->join('wp_jiaolian j on w.jid=j.id')
				->join('wp_xueyuan x on w.xid=x.id')
				->join('wp_paiban p on w.pid=p.id')
				->field('*,w.id as id')
				->where("w.status =1 and (w.addtime >= '$datetimepicker' and w.addtime <= '$datetimepicker1')")
				->order('w.id desc')
				->select();
			}else{
				$ding_list=$weizhifu->table('wp_weizhifu w')
				->join('wp_jiaolian j on w.jid=j.id')
				->join('wp_xueyuan x on w.xid=x.id')
				->join('wp_paiban p on w.pid=p.id')
				->field('*,w.id as id')
				->where("w.status =1 ")
				->order('w.id desc')
				->select();
			}

			if($ding_list){
				$this->assign('wei_list',$ding_list);
				$this->display('wei_list');
			}else{
				$this->error('没有要查询的订单！');
			}
			
		}else if($status==12){
			if($datetimepicker !="" && $datetimepicker1 !=""){
				$ding_list=$tuikuan->table('wp_tuikuan t')
				->join('wp_jiaolian j on t.jid=j.id')
				->join('wp_xueyuan x on t.xid=x.id')
				->join('wp_paiban p on t.pid=p.id')
				->field('*,t.id as id')
				->where("t.status =1 and (t.taddtime >= '$datetimepicker' and t.taddtime <= '$datetimepicker1')")
				->order('t.id desc')
				->select();
			}else{
				$ding_list=$tuikuan->table('wp_tuikuan t')
				->join('wp_jiaolian j on t.jid=j.id')
				->join('wp_xueyuan x on t.xid=x.id')
				->join('wp_paiban p on t.pid=p.id')
				->field('*,t.id as id')
				->where("t.status =1 ")
				->order('t.id desc')
				->select();
			}

			if($ding_list){
				$this->assign('tui_list',$ding_list);
				$this->display('tui_list');
			}else{
				$this->error('没有要查询的订单！');
			}
		}else{
			//var_dump($status);die;
			if($datetimepicker !="" && $datetimepicker1 !=""){
				$ding_list=$dingdan->table('wp_dingdan d')
				->join('wp_jiaolian j on d.jid=j.id')
				->join('wp_xueyuan x on d.xid=x.id')
				->join('wp_paiban p on d.pid=p.id')
				->field('*,d.id as id')
				->where("d.status ='$status' and (d.daddtime >= '$datetimepicker' and d.daddtime <= '$datetimepicker1')")
				->order('d.id desc')
				->select();
			}else{
				$ding_list=$dingdan->table('wp_dingdan d')
				->join('wp_jiaolian j on d.jid=j.id')
				->join('wp_xueyuan x on d.xid=x.id')
				->join('wp_paiban p on d.pid=p.id')
				->field('*,d.id as id')
				->where("d.status ='$status' ")
				->order('d.id desc')
				->select();
			}
			//var_dump( $ding_list);die;
			
			if($ding_list){			
				switch($status){
					case 0:
					$this->assign('dingdan_list',$ding_list);
					$this->display('ding_list');
					break;
/* 					case 1:
					$this->assign('wei_list',$ding_list);
					$this->display('wei_list');
					break; */
					case 2:
					$this->assign('xiao_list',$ding_list);
					$this->display('xiao_list');
					break;
					case 3:
					$this->assign('shen_list',$ding_list);
					$this->display('shen_list');
					break;
/* 					case 4:
					$this->assign('xiao_list',$ding_list);
					$this->display('xiao_list');
					break;	 */		
				}
				
			}else{
				$this->error('没有要查询的订单！');
			}

			
		}


	} 
	 

	public function dingdan_del(){
		$dingdan= M('dingdan');
		$id = I('id');
		if($id){
			$dingdan_del = $dingdan->where(array('id'=>$id))->delete();
			if($dingdan_del){
	    		$this->success('删除成功!',U('Dingdan/dingdan_list',array('mdm'=>$_GET['mdm'])));
			}
		}else{
			$this->error('删除失败,缺少id值!');
		}
	}

	
	public function dingdan_weizhifu_del(){
		$weizhifu= M('weizhifu');
		$id = I('id');
		if($id){
			$dingdan_weizhifu_del = $weizhifu->where(array('id'=>$id))->delete();
			if($dingdan_weizhifu_del){
	    		$this->success('删除成功!',U('Dingdan/wei_list',array('mdm'=>$_GET['mdm'])));
			}
		}else{
			$this->error('删除失败,缺少id值!');
		}
	}
	
	
	public function dingdan_tuikuan_del(){
		$tuikuan= M('tuikuan');
		$id = I('id');
		if($id){
			$dingdan_tuikuan_del = $tuikuan->where(array('id'=>$id))->delete();
			if($dingdan_tuikuan_del){
	    		$this->success('删除成功!',U('Dingdan/tui_list',array('mdm'=>$_GET['mdm'])));
			}
		}else{
			$this->error('删除失败,缺少id值!');
		}
	}


	public function Download(){
    	header("Content-type:text/html;charset=utf-8");
     	 $objPHPExcel = new \Org\Util\PHPExcel();
     	 $dingdan= M('dingdan');
	 	 $jiaolian= M('jiaolian');
	 	 $xueyuan= M('xueyuan');
	 	 $yuyue= M('yuyue');
	 	 $list = $dingdan->table('wp_dingdan d')
	 	    // ->join('wp_jiaolian j on d.jid=j.id')
	 	    ->join('wp_xueyuan x on d.xid=x.id')
	 	    ->join('wp_paiban p on d.pid=p.id')
	 	 	->field('*,d.id as id')
	 	    ->where('d.status = 3')
	 	    ->order('d.id desc')
	 	    ->select();	
	 	    // var_dump($list);die;
	 	// 设置excel属性
	 	$objPHPExcel -> getProperties() -> setCreator("JAMES")
	 	-> setlastModifiedBy("JAMES")
	 	-> setTitle("退款申请报表")
	 	-> setSubject("退款申请报表")
	 	-> setDescription("退款申请报表")
	 	-> setKeywords("退款申请报表")
	 	-> setCategory("退款申请报表");
		$objPHPExcel->getDefaultStyle()->getFont()->setName("微软雅黑")->setSize(12);//设置默认字体大小
		//设置第一行行高 
		$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(31.5);
	 	if($list){
	 	$objPHPExcel -> setActiveSheetIndex(0)
	 	-> setCellValue('A1','序号')
	 	-> setCellValue('B1','学员名字')
	 	// -> setCellValue('C1','教练名字')
	 	-> setCellValue('C1','预约时间段')
	 	-> setCellValue('D1','订单编号')
	 	-> setCellValue('E1','下单时间')
	 	-> setCellValue('F1','金额')
	 	-> setCellValue('G1','状态');
	 	//设置宽度
	 	$objPHPExcel -> getActiveSheet() -> getColumnDimension('A') -> setWidth(7);
	 	$objPHPExcel -> getActiveSheet() -> getColumnDimension('B') -> setWidth(10);
	 	$objPHPExcel -> getActiveSheet() -> getColumnDimension('C') -> setWidth(22);
	 	$objPHPExcel -> getActiveSheet() -> getColumnDimension('D') -> setWidth(13);
	 	$objPHPExcel -> getActiveSheet() -> getColumnDimension('E') -> setWidth(20);
	 	$objPHPExcel -> getActiveSheet() -> getColumnDimension('F') -> setWidth(7);
	 	$objPHPExcel -> getActiveSheet() -> getColumnDimension('G') -> setWidth(10);
	 	 $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);  
	 	 $objPHPExcel->getActiveSheet()->getStyle('B1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);  
	 	 $objPHPExcel->getActiveSheet()->getStyle('C1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);  
	 	 $objPHPExcel->getActiveSheet()->getStyle('D1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);  
	 	 $objPHPExcel->getActiveSheet()->getStyle('E1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);  
	 	 $objPHPExcel->getActiveSheet()->getStyle('F1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);  
	 	 $objPHPExcel->getActiveSheet()->getStyle('G1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	 	$styleThinBlackBorderOutline = array(
	 	       'borders' => array (
	 	             'outline' => array (
	 	                   'style' => \PHPExcel_Style_Border::BORDER_THIN,   //设置border样式
	 	                   //'style' => PHPExcel_Style_Border::BORDER_THICK,  另一种样式
	 	                   'color' => array ('argb' => 'FF000000'),          //设置border颜色
	 	            ),
	 	      ),
	 	);
	 	$objPHPExcel->getActiveSheet()->getStyle( 'A1:G1')->applyFromArray($styleThinBlackBorderOutline);
	 	$objPHPExcel->getActiveSheet()->getStyle('A1:G1')->getBorders()->getAllBorders()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);
	 	 
	 	      
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
	 	    $objPHPExcel->getActiveSheet()->getStyle( 'A'.$c.':G'.$c)->applyFromArray($styleThinBlackBorderOutline);
	 	$objPHPExcel->getActiveSheet()->getStyle( 'A'.$c.':G'.$c)->getBorders()->getAllBorders()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);



		 	$objPHPExcel -> setActiveSheetIndex(0) -> setCellValue('A'.$c,$sort);//序号
		 	$objPHPExcel -> setActiveSheetIndex(0) -> setCellValue('B'.$c,$value['xname']);
		 	// $objPHPExcel -> setActiveSheetIndex(0) -> setCellValue('C'.$c,$value['jname']);
		 	$objPHPExcel -> setActiveSheetIndex(0) -> setCellValue('C'.$c,$value['data'].' '.$value['time']);
		 	$objPHPExcel -> setActiveSheetIndex(0) -> setCellValue('D'.$c,$value['transaction_id']);
		 	$objPHPExcel -> setActiveSheetIndex(0) -> setCellValue('E'.$c,$value['daddtime']);
		 	$objPHPExcel -> setActiveSheetIndex(0) -> setCellValue('F'.$c,$value['money']);
		 	$objPHPExcel -> setActiveSheetIndex(0) -> setCellValue('G'.$c,'退款中');
		 	$excelName = '退款申请';

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
    
}