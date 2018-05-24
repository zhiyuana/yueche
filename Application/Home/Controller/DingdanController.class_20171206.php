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
		
		$res ['title'] = '收费报表';
		$res ['url'] = U ( 'shoufei_list', $param );
		$res ['class'] = strpos ( $act, 'shoufei_list' ) !== false ? 'current' : '';
		$nav [] = $res;

		$res ['title'] = '存款报表';
		$res ['url'] = U ( 'cunkuan_list', $param );
		$res ['class'] = strpos ( $act, 'cunkuan_list' ) !== false ? 'current' : '';
		$nav [] = $res;

		// $res ['title'] = '退款列表';
		// $res ['url'] = U ( 'tuikuan_list', $param );
		// $res ['class'] = strpos ( $act, 'tuikuan_list' ) !== false ? 'current' : '';
		// $nav [] = $res;

		$res ['title'] = '存款报表明细';
		$res ['url'] = U ( 'mingxi_list', $param );
		$res ['class'] = strpos ( $act, 'mingxi_list' ) !== false ? 'current' : '';
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
	

	//未消费订单列表页面
	public function ding_list(){
    	header("Content-type:text/html;charset=utf-8");
    	$datetimepicker = I('datetimepicker');
    	$datetimepicker1 = I('datetimepicker1');
		$keywords = I('keywords');
    	//if($datetimepicker != '' && $datetimepicker1 != ''){
    		//$where['d.daddtime'] =  array('between',array($datetimepicker,$datetimepicker1));
    	//}
		
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
		$where['d.status'] = 0;
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
		$page  = $Page->show();// 分页显示输出
		$this->assign ( 'dingdan_list', $dingdan_list );
		$this->assign('_page', $page);
		$this->assign('datetimepicker', $datetimepicker);
		$this->assign('datetimepicker1', $datetimepicker1);
		$this->assign('keywords', $keywords);
		$this->display();
	}
	
	//未支付订单列表页面
	public function wei_list(){
    	// header("Content-type:text/html;charset=utf-8");
		$weizhifu= M('weizhifu');
		$datetimepicker = I('datetimepicker');
		$datetimepicker1 = I('datetimepicker1');
		$keywords = I('keywords');
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

	//已消费订单列表页面
	public function xiao_list(){
    	// header("Content-type:text/html;charset=utf-8");
		$dingdan= M('dingdan');
		$datetimepicker = I('datetimepicker');
    	$datetimepicker1 = I('datetimepicker1');
    	$keywords = I('keywords');
    	// if($datetimepicker != '' && $datetimepicker1 != ''){
    	// 	$where['d.daddtime'] =  array('between',array($datetimepicker,$datetimepicker1));
    	// }
    	//手机号或身份证为空,时间段不为空
    	if($datetimepicker != '' && $datetimepicker1 != '' && $keywords == ""){
    		// if($datetimepicker == $datetimepicker1){
    		// 	$where['d.daddtime'] =  array('like',"%$datetimepicker%");
    		// }else{
    			$where['d.daddtime'] =  array('between',array($datetimepicker.' 00:00:00',$datetimepicker1.' 23:59:59'));
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
    		// 	$where['d.daddtime'] =  array('like',"%$datetimepicker%");
    		// }else{
    			$where['d.daddtime'] =  array('between',array($datetimepicker.' 00:00:00',$datetimepicker1.' 23:59:59'));
    		// }
    		if(strlen($keywords) > 11){
    			//echo '身份证';die;
    			$where['x.xcard'] = array('like',"%$keywords%");
    		}else{
    			//echo '手机号';die;
    			$where['x.xphone'] = array('like',"%$keywords%");
    		}
    	}
		$where['d.status'] = 2;
			// $where['d.daddtime'] = array('between',array($datetimepicker,$datetimepicker1));
			// $xiao_list = $dingdan->table('wp_dingdan d')
			// // ->join('wp_jiaolian j on d.jid=j.id')
			// ->join('wp_xueyuan x on d.xid=x.id')
			// ->join('wp_paiban p on d.pid=p.id')
			// ->field('*,d.id as id,d.status as status')
			// ->where($where)
			// ->order('d.id desc')
			// ->select();
			// $json = json_encode($xiao_list);
			// echo $json;die;	
		$totalCount = $dingdan->table('wp_dingdan d')
		// ->join('wp_jiaolian j on d.jid=j.id')
		->join('wp_xueyuan x on d.xid=x.id')
		->join('wp_paiban p on d.pid=p.id')
		->field('*,d.id as id,d.status as status')
		->where($where)
		->count();	
		$Page = new \Think\Page ( $totalCount,10 );
		$Page->setConfig ( 'theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%' );
		$xiao_list = $dingdan->table('wp_dingdan d')
		// ->join('wp_jiaolian j on d.jid=j.id')
		->join('wp_xueyuan x on d.xid=x.id')
		->join('wp_paiban p on d.pid=p.id')
		->field('*,d.id as id,d.status as status')
		->where($where)
		->limit($Page->firstRow.','.$Page->listRows)
		->order('d.id desc')
		->select();		
		
		// $request = ( array ) I ( 'request.' );
		// $total = $xiao_list ? count ( $xiao_list ) : 1;
		// $listRows = C('LIST_ROWS') > 0 ? C('LIST_ROWS') : 20;
		// $page = new \Think\Page ( $total, $listRows, $request['p'] );
		// $voList = array_slice ( $xiao_list, $page->firstRow, $page->listRows );
		// $this->assign ( 'xiao_list', $voList );
		// $this->assign ( '_page', $p ? $p : '' );
		// $p = $page->show();
		$page  = $Page->show();// 分页显示输出
		$this->assign ( 'xiao_list', $xiao_list );
		$this->assign('_page', $page);
		$this->assign('datetimepicker', $datetimepicker);
		$this->assign('datetimepicker1', $datetimepicker1);
		$this->assign('keywords', $keywords);
		$this->display();

	}

	//已退款订单列表页面
	public function tui_list(){
    	header("Content-type:text/html;charset=utf-8");
		$tuikuan= M('tuikuan');
		$datetimepicker = I('datetimepicker');
		$datetimepicker1 = I('datetimepicker1');
		$keywords = I("keywords");
	    //if($datetimepicker != '' && $datetimepicker1 != ''){
			//$where['t.taddtime'] = array('between',array($datetimepicker,$datetimepicker1));
    	//}
		
		//手机号或身份证为空,时间段不为空
    	if($datetimepicker != '' && $datetimepicker1 != '' && $keywords == ""){
    		$where['t.taddtime'] =  array('between',array($datetimepicker.' 00:00;00',$datetimepicker1.' 23:59:59'));
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
    		$where['t.taddtime'] =  array('between',array($datetimepicker.' 00:00;00',$datetimepicker1.' 23:59:59'));
    		if(strlen($keywords) > 11){
    			//echo '身份证';die;
    			$where['x.xcard'] = array('like',"%$keywords%");
    		}else{
    			//echo '手机号';die;
    			$where['x.xphone'] = array('like',"%$keywords%");
    		}
    	}
		
	 	$where['t.status'] = 1;
		// if($datetimepicker !="" && $datetimepicker1 !="" && $datetimepicker !="null" && $datetimepicker1 !="null"){
		// 	$where['t.taddtime'] = array('between',array($datetimepicker,$datetimepicker1));
		// 	$tui_list = $tuikuan->table('wp_tuikuan t')
		// 	// ->join('wp_jiaolian j on d.jid=j.id')
		// 	->join('wp_xueyuan x on t.xid=x.id')
		// 	->join('wp_paiban p on t.pid=p.id')
		// 	->field('*,t.id as id,t.status as status,t.pdata as pdata')
		// 	->where($where)
		// 	->order('t.id desc')
		// 	->select();
		// 	$json = json_encode($tui_list);
		// 	echo $json;die;
		// }else{
		 	$totalCount = $tuikuan->table('wp_tuikuan t')
				// ->join('wp_jiaolian j on d.jid=j.id')
				->join('wp_xueyuan x on t.xid=x.id')
				->join('wp_paiban p on t.pid=p.id')
				->field('*,t.id as id,t.status as status,t.pdata as pdata')
				->where($where)
				->count();
				// var_dump($totalCount);die;
			$Page = new \Think\Page ( $totalCount,15 );
			$Page->setConfig ( 'theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%' );
			$tui_list = $tuikuan->table('wp_tuikuan t')
			// ->join('wp_jiaolian j on d.jid=j.id')
			->join('wp_xueyuan x on t.xid=x.id')
			->join('wp_paiban p on t.pid=p.id')
			->field('*,t.id as id,t.status as status,t.pdata as pdata')
			->where($where)
			->limit($Page->firstRow.','.$Page->listRows)
			->order('t.id desc')
			->select();	
			
			// $request = ( array ) I ( 'request.' );
			// $total = $tui_list ? count ( $tui_list ) : 1;
			// $listRows = C('LIST_ROWS') > 0 ? C('LIST_ROWS') : 20;
			// $page = new \Think\Page ( $total, $listRows, $request['p'] );
			// $voList = array_slice ( $tui_list, $page->firstRow, $page->listRows );
			// $p = $page->show ();
			// $this->assign ( 'tui_list', $voList );
			// $this->assign ( '_page', $p ? $p : '' );
			// dump($tui_list);
			
			foreach ($tui_list as $key => $value) {
				// dump($value)."<br>";
				$pid[] = $value['pid'];
				$sql = "select `time` from `wp_paiban` where `id` in (".$pid[$key].")";
				$res = M('paiban')->query($sql);
				// dump($res);
				
 				$ress = array_column($res, 'time');
 				//dump($ress);
				// dump(implode(',',$ress));
				$tui_list[$key]['time'] = implode(',',$ress);
				
			}
			// dump($tui_list);

			$page  = $Page->show();// 分页显示输出
			$this->assign ( 'tui_list', $tui_list );
			$this->assign('_page', $page);
			$this->assign('datetimepicker1', substr($datetimepicker1,0,10));
			$this->assign('datetimepicker', substr($datetimepicker,0,10));
			$this->assign('keywords', $keywords);
			$this->display();
		// }	 	
	}

	//退款审核列表页面
	public function shen_list(){
    	header("Content-type:text/html;charset=utf-8");
		$dingdan= M('dingdan');
		$datetimepicker = I('datetimepicker');
		$datetimepicker1 = I('datetimepicker1');
		$keywords = I('keywords');
		//if($datetimepicker != '' && $datetimepicker1 != ''){
			//$where['d.daddtime'] =  array('between',array($datetimepicker,$datetimepicker1));
		//}
		
		//手机号或身份证为空,时间段不为空
    	if($datetimepicker != '' && $datetimepicker1 != '' && $keywords == ""){
    		// if($datetimepicker == $datetimepicker1){
    		// 	$where['d.daddtime'] =  array('like',"%$datetimepicker%");
    		// }else{
    			$where['d.daddtime'] =  array('between',array($datetimepicker.' 00:00:00',$datetimepicker1.' 23:59:59'));
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
    		// 	$where['d.daddtime'] =  array('like',"%$datetimepicker%");
    		// }else{
    			$where['d.daddtime'] =  array('between',array($datetimepicker.' 00:00:00',$datetimepicker1.' 23:59:59'));
    		// }
    		if(strlen($keywords) > 11){
    			//echo '身份证';die;
    			$where['x.xcard'] = array('like',"%$keywords%");
    		}else{
    			//echo '手机号';die;
    			$where['x.xphone'] = array('like',"%$keywords%");
    		}
    	}
		
		$where['d.status'] = 3;
		// if($datetimepicker !="" && $datetimepicker1 !="" && $datetimepicker !="null" && $datetimepicker1 !="null"){
		// 	$where['d.daddtime'] = array('between',array($datetimepicker,$datetimepicker1));
		// 	$shen_list = $dingdan->table('wp_dingdan d')
	 //        // ->join('wp_jiaolian j on d.jid=j.id')
	 //        ->join('wp_xueyuan x on d.xid=x.id')
	 //        ->join('wp_paiban p on d.pid=p.id')
	 // 		->field('*,d.id as id,d.status as status')
	 //        ->where($where)
	 // 		->order('d.id desc')
	 // 		->select();
		// 	$json = json_encode($shen_list);
		// 	echo $json;die;			
		// }else{
			$totalCount = $dingdan->table('wp_dingdan d')
	        // ->join('wp_jiaolian j on d.jid=j.id')
	        ->join('wp_xueyuan x on d.xid=x.id')
	        ->join('wp_paiban p on d.pid=p.id')
	 		->field('*,d.id as id,d.status as status')
	        ->where($where)
	 		->count();	
			$Page = new \Think\Page ( $totalCount,15 );
			$Page->setConfig ( 'theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%' );
			$shen_list = $dingdan->table('wp_dingdan d')
	        // ->join('wp_jiaolian j on d.jid=j.id')
	        ->join('wp_xueyuan x on d.xid=x.id')
	        ->join('wp_paiban p on d.pid=p.id')
	 		->field('*,d.id as id,d.status as status')
	        ->where($where)
			->limit($Page->firstRow.','.$Page->listRows)
	 		->order('d.id desc')
	 		->select();	
			// dump($shen_list);
			// $request = ( array ) I ( 'request.' );
			// $total = $shen_list ? count ( $shen_list ) : 1;
			// $listRows = C('LIST_ROWS') > 0 ? C('LIST_ROWS') : 20;
			// $page = new \Think\Page ( $total, $listRows, $request['p'] );
			// $voList = array_slice ( $shen_list, $page->firstRow, $page->listRows );
			// $p = $page->show ();
			// $this->assign ( 'shen_list', $voList );
			// $this->assign ( '_page', $p ? $p : '' );
			$page  = $Page->show();// 分页显示输出
			$this->assign ( 'shen_list', $shen_list );
			$this->assign('_page', $page);
			$this->assign('datetimepicker1', $datetimepicker1);
			$this->assign('datetimepicker', $datetimepicker);
			$this->assign('keywords', $keywords);
			$this->display();
		// }

	}

	//退款详情页面
	public function shen_xq(){
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
	
	public function xiao_xq(){
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
	
	
	public function tui_xq(){
    	header("Content-type:text/html;charset=utf-8");
		$id = I('id');
		$tuikuan = M('tuikuan');
		$where['t.id'] = $id;
		$list = $tuikuan->table('wp_tuikuan t')
				->join('wp_xueyuan x on t.xid = x.id')
				->join('wp_jiaxiao jx on jx.id = x.jx')
				->join('wp_jiaolian jl on jl.id = x.jl_id')
				->where($where)
				->field('*,t.id as id')
				->select();

		$dbh = $list[0]['dbh'];
		$where_dbh['dbh'] = $dbh;
		//dump($dbh);die;
		$dingdan = M('dingdan');
		
		$tuan_res = $dingdan->table('wp_dingdan d')->where($where_dbh)->field('tuan')->select();
		// dump($tuan_res[0]['tuan']);die;
		$tuan_id = $tuan_res[0]['tuan'];
		//查询组团人员
		$sql = "SELECT `xname` FROM `wp_xueyuan` WHERE `id` IN ( ".$tuan_id." )";
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


	//退款申请微信接口
	public function refund(){
		$id = I('id');
		$dingdan = M('dingdan');
		$paiban = M('paiban');
		$where['d.id'] = $id;
		$list = $dingdan->table('wp_dingdan d')
				->join('wp_xueyuan x on d.uid = x.uid')
				->field('*,d.id as id')
				->where($where)
				->find();
		$pid = $list['pid'];
		// var_dump($list);die;
		$transaction_id = $list['transaction_id'];//微信订单号
		$total_fee = $list['money'] * 100;//订单金额
		//$refund_fee = $list['money'] * 100; //退款金额
		$refund_fee = $list['refund_fee'] * 100; //退款金额
		//$refund_fee = 1; //退款金额
		// var_dump($refund_fee);die;
		$refund_no = date('Ymd') . time() . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);//退款单号 唯一
		$op_user_id = $list['xname'];
		
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
			//$data['tuan'] = $list['tuan'];
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
			$map1['id'] = $pid;
			$date1['status'] = 0;
			//$preturn = $paiban->where($map1)->save($date1);
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
/**
*   这个不用了！！！
*	为了区分dingdan、weizhifu、tuikuan表，dingdan=> 0:未消费 2:已消费 3:退款中
*	weizhifu =>未支付(weizhifu中是1，现在为 11)
*	tuikuan =>已退款(tuikuan中是1，现在为 12)
*/
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


	public function ding_Download(){
    	header("Content-type:text/html;charset=utf-8");
     	 $objPHPExcel = new \Org\Util\PHPExcel();
     	 $dingdan= M('dingdan');
	 	 $jiaolian= M('jiaolian');
	 	 $xueyuan= M('xueyuan');
	 	 $yuyue= M('yuyue');
	 	 $where['d.status'] = 0;
		 // $datetimepicker = I('datetimepicker');
		 // $datetimepicker1 = I('datetimepicker1');
		 // if($datetimepicker !="" && $datetimepicker1 !="" && $datetimepicker !="null" && $datetimepicker1 !="null"){
			//  $list = $dingdan->table('wp_dingdan d')
	 	//     // ->join('wp_jiaolian j on d.jid=j.id')
	 	//     ->join('wp_xueyuan x on d.xid=x.id')
	 	//     ->join('wp_paiban p on d.pid=p.id')
	 	//  	->field('*,d.id as id')
	 	//     ->where("d.status = 0 and (d.daddtime >= '$datetimepicker' and d.daddtime <= '$datetimepicker1')")
	 	//     ->order('d.id desc')
	 	//     ->select();
		 // }else{
			//  $list = $dingdan->table('wp_dingdan d')
	 	//     // ->join('wp_jiaolian j on d.jid=j.id')
	 	//     ->join('wp_xueyuan x on d.xid=x.id')
	 	//     ->join('wp_paiban p on d.pid=p.id')
	 	//  	->field('*,d.id as id')
	 	//     ->where("d.status = 0")
	 	//     ->order('d.id desc')
	 	//     ->select();
		 // }
	    
        $datetimepicker = I('datetimepicker');
    	$datetimepicker1 = I('datetimepicker1');
		$keywords = I('keywords');
		$where['d.status'] = 0;
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
	 	 	->field('*,d.id as id')
	 	    ->where($where)
	 	    ->order('d.id desc')
	 	    ->select();
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
		 	$objPHPExcel -> setActiveSheetIndex(0) -> setCellValue('H'.$c,'未消费');
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
	 	$filename = $filelName.$data.'.xls';
	 	ob_end_clean();//清除缓存以免乱码出现
	 	header('Content-Type: application/vnd.ms-excel');
	 	header('Content-Type: application/octet-stream');
	 	header('Content-Disposition: attachment; filename="' . $filename . '"');
	 	header('Cache-Control: max-age=0');
	 	$objWriter -> save('php://output');die;	
	 }
	 
	public function shen_Download(){
    	header("Content-type:text/html;charset=utf-8");
     	 $objPHPExcel = new \Org\Util\PHPExcel();
     	 $dingdan= M('dingdan');
	 	 $jiaolian= M('jiaolian');
	 	 $xueyuan= M('xueyuan');
	 	 $yuyue= M('yuyue');
		 
	 	$datetimepicker = I('datetimepicker');
		$datetimepicker1 = I('datetimepicker1');
		$keywords = I('keywords');
		
		
		//手机号或身份证为空,时间段不为空
    	if($datetimepicker != '' && $datetimepicker1 != '' && $keywords == ""){
    		// if($datetimepicker == $datetimepicker1){
    		// 	$where['d.daddtime'] =  array('like',"%$datetimepicker%");
    		// }else{
    			$where['d.daddtime'] =  array('between',array($datetimepicker.' 00:00:00',$datetimepicker1.' 23:59:59'));
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
    		// 	$where['d.daddtime'] =  array('like',"%$datetimepicker%");
    		// }else{
    			$where['d.daddtime'] =  array('between',array($datetimepicker.' 00:00:00',$datetimepicker1.' 23:59:59'));
    		// }
    		if(strlen($keywords) > 11){
    			//echo '身份证';die;
    			$where['x.xcard'] = array('like',"%$keywords%");
    		}else{
    			//echo '手机号';die;
    			$where['x.xphone'] = array('like',"%$keywords%");
    		}
    	}
		
		$where['d.status'] = 3;
		$list = $dingdan->table('wp_dingdan d')
	 	    ->join('wp_xueyuan x on d.xid=x.id')
	 	    ->join('wp_paiban p on d.pid=p.id')
	 	 	->field('*,d.id as id')
	 	    ->where($where)
	 	    ->order('d.id desc')
	 	    ->select();
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
	 	-> setCellValue('C1','预约日期')
	 	-> setCellValue('D1','预约时间段')
	 	-> setCellValue('E1','车号')
	 	// -> setCellValue('D1','订单编号')
	 	-> setCellValue('F1','下单时间')
	 	-> setCellValue('G1','金额')
	 	-> setCellValue('H1','状态');
	 	//设置宽度
	 	$objPHPExcel -> getActiveSheet() -> getColumnDimension('A') -> setWidth(7);
	 	$objPHPExcel -> getActiveSheet() -> getColumnDimension('B') -> setWidth(10);
	 	$objPHPExcel -> getActiveSheet() -> getColumnDimension('C') -> setWidth(15);
	 	$objPHPExcel -> getActiveSheet() -> getColumnDimension('D') -> setWidth(25);
	 	$objPHPExcel -> getActiveSheet() -> getColumnDimension('E') -> setWidth(10);
	 	$objPHPExcel -> getActiveSheet() -> getColumnDimension('F') -> setWidth(20);
	 	$objPHPExcel -> getActiveSheet() -> getColumnDimension('G') -> setWidth(10);
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



		 	$objPHPExcel -> setActiveSheetIndex(0) -> setCellValue('A'.$c,$value['id']);//序号
		 	$objPHPExcel -> setActiveSheetIndex(0) -> setCellValue('B'.$c,$value['xname']);
		 	$objPHPExcel -> setActiveSheetIndex(0) -> setCellValue('C'.$c,$value['pdata']);
		 	$objPHPExcel -> setActiveSheetIndex(0) -> setCellValue('D'.$c,$value['ptime']);
		 	$objPHPExcel -> setActiveSheetIndex(0) -> setCellValue('E'.$c,$value['pch']);
		 	$objPHPExcel -> setActiveSheetIndex(0) -> setCellValue('F'.$c,$value['daddtime']);
		 	$objPHPExcel -> setActiveSheetIndex(0) -> setCellValue('G'.$c,$value['money']);
		 	$objPHPExcel -> setActiveSheetIndex(0) -> setCellValue('H'.$c,'退款中');
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
	 	$filename = $filelName.$data.'.xls';
	 	ob_end_clean();//清除缓存以免乱码出现
	 	header('Content-Type: application/vnd.ms-excel');
	 	header('Content-Type: application/octet-stream');
	 	header('Content-Disposition: attachment; filename="' . $filename . '"');
	 	header('Cache-Control: max-age=0');
	 	$objWriter -> save('php://output');die;	
	 }
	 
	public function xiao_Download(){
    	header("Content-type:text/html;charset=utf-8");
     	 $objPHPExcel = new \Org\Util\PHPExcel();
     	 $dingdan= M('dingdan');
	 	 $jiaolian= M('jiaolian');
	 	 $xueyuan= M('xueyuan');
	 	 $yuyue= M('yuyue');
	 	 $where['d.status'] = 2;
	 	 
	 	$datetimepicker = I('datetimepicker');
    	$datetimepicker1 = I('datetimepicker1');
    	$keywords = I('keywords');
    	// if($datetimepicker != '' && $datetimepicker1 != ''){
    	// 	$where['d.daddtime'] =  array('between',array($datetimepicker,$datetimepicker1));
    	// }
    	//手机号或身份证为空,时间段不为空
    	if($datetimepicker != '' && $datetimepicker1 != '' && $keywords == ""){
    		// if($datetimepicker == $datetimepicker1){
    		// 	$where['d.daddtime'] =  array('like',"%$datetimepicker%");
    		// }else{
    			$where['d.daddtime'] =  array('between',array($datetimepicker.' 00:00:00',$datetimepicker1.' 23:59:59'));
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
    		// 	$where['d.daddtime'] =  array('like',"%$datetimepicker%");
    		// }else{
    			$where['d.daddtime'] =  array('between',array($datetimepicker.' 00:00:00',$datetimepicker1.' 23:59:59'));
    		// }
    		if(strlen($keywords) > 11){
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
	 	 	->field('*,d.id as id')
	 	    ->where($where)
	 	    ->order('d.id desc')
	 	    ->select();

	 	    // var_dump($list);die;
	 	// 设置excel属性
	 	$objPHPExcel -> getProperties() -> setCreator("JAMES")
	 	-> setlastModifiedBy("JAMES")
	 	-> setTitle("已消费报表")
	 	-> setSubject("已消费报表")
	 	-> setDescription("已消费报表")
	 	-> setKeywords("已消费报表")
	 	-> setCategory("已消费报表");
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
	 	$objPHPExcel -> getActiveSheet() -> getColumnDimension('G') -> setWidth(10);
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
	 	// dump($list);die;
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



		 	$objPHPExcel -> setActiveSheetIndex(0) -> setCellValue('A'.$c,$value['id']);//序号
		 	$objPHPExcel -> setActiveSheetIndex(0) -> setCellValue('B'.$c,$value['xname']);
		 	$objPHPExcel -> setActiveSheetIndex(0) -> setCellValue('C'.$c,$value['pdata']);
		 	//$objPHPExcel -> setActiveSheetIndex(0) -> setCellValue('D'.$c,!empty($value['transaction_id']) ? $value['transaction_id'] : $value['dbh']);
		 	$objPHPExcel -> setActiveSheetIndex(0) -> setCellValue('D'.$c,$value['ptime']);
		 	$objPHPExcel -> setActiveSheetIndex(0) -> setCellValue('E'.$c,$value['pch']);
		 	$objPHPExcel -> setActiveSheetIndex(0) -> setCellValue('F'.$c,$value['daddtime']);
		 	$objPHPExcel -> setActiveSheetIndex(0) -> setCellValue('G'.$c,$value['money'].' 元');
		 	$objPHPExcel -> setActiveSheetIndex(0) -> setCellValue('H'.$c,'已消费');
		 	$excelName = '已消费';

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
	 	$filename = $filelName.$data.'.xls';
	 	ob_end_clean();//清除缓存以免乱码出现
	 	header('Content-Type: application/vnd.ms-excel');
	 	header('Content-Type: application/octet-stream');
	 	header('Content-Disposition: attachment; filename="' . $filename . '"');
	 	header('Cache-Control: max-age=0');
	 	$objWriter -> save('php://output');die;	
	 }
	 
	public function wei_Download(){
    	header("Content-type:text/html;charset=utf-8");
     	 $objPHPExcel = new \Org\Util\PHPExcel();
     	 $dingdan= M('dingdan');
	 	 $jiaolian= M('jiaolian');
	 	 $xueyuan= M('xueyuan');
	 	 $yuyue= M('yuyue');
	 	 $weizhifu= M('weizhifu');
	 	 $where['w.status'] = 1;
		 // $datetimepicker = I('datetimepicker');
		 // $datetimepicker1 = I('datetimepicker1');
		 // if($datetimepicker !="" && $datetimepicker1 !="" && $datetimepicker !="null" && $datetimepicker1 !="null"){
			// $list = $weizhifu->table('wp_weizhifu w')
			// // ->join('wp_jiaolian j on d.jid=j.id')
			// ->join('wp_xueyuan x on w.xid=x.id')
			// ->join('wp_paiban p on w.pid=p.id')
			// ->field('*,w.id as id')
			// ->where("w.status = 1 and (w.addtime >= '$datetimepicker' and w.addtime <= '$datetimepicker1')")
			// ->order('w.id desc')
			// ->select();
		 // }else{
			// $list = $weizhifu->table('wp_weizhifu w')
			// // ->join('wp_jiaolian j on d.jid=j.id')
			// ->join('wp_xueyuan x on w.xid=x.id')
			// ->join('wp_paiban p on w.pid=p.id')
			// ->field('*,w.id as id')
			// ->where($where)
			// ->order('w.id desc')
			// ->select();	
		 // }

	 	 $datetimepicker = I('datetimepicker');
		$datetimepicker1 = I('datetimepicker1');
		$keywords = I('keywords');
		//var_dump($_GET);
		$where['w.status'] = 1;
		// if($datetimepicker != '' && $datetimepicker1 != ''){
  //   		$where['w.addtime'] =  array('between',array($datetimepicker,$datetimepicker1));
  //   	}

		//手机号或身份证为空,时间段不为空
    	if($datetimepicker != '' && $datetimepicker1 != '' && $keywords == ""){
    		// if($datetimepicker == $datetimepicker1){
    		// 	$where['w.addtime'] =  array('like',"%$datetimepicker%");
    		// }else{
    			$where['w.addtime'] =  array('between',array($datetimepicker.' 00:00:00',$datetimepicker1.' 23:59:59'));
    		//}
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
    		//}
    		if(strlen($keywords) > 11){
    			//echo '身份证';die;
    			$where['x.xcard'] = array('like',"%$keywords%");
    		}else{
    			//echo '手机号';die;
    			$where['x.xphone'] = array('like',"%$keywords%");
    		}
    	}

        $list = $weizhifu->table('wp_weizhifu w')
			// ->join('wp_jiaolian j on d.jid=j.id')
			->join('wp_xueyuan x on w.xid=x.id')
			->join('wp_paiban p on w.pid=p.id')
			->field('*,w.id as id')
			->where($where)
			->order('w.id desc')
			->select();
	 	foreach ($list as $key => $value) {
				// dump($value)."<br>";
				$pid[] = $value['pid'];
				$sql = "select `time` from `wp_paiban` where `id` in (".$pid[$key].")";
				$res = M('paiban')->query($sql);
				// dump($res);
				
 				$ress = array_column($res, 'time');
 				//dump($ress);
				// dump(implode(',',$ress));
				$list[$key]['time'] = implode(',',$ress);
				
			}
	 	// 设置excel属性
	 	$objPHPExcel -> getProperties() -> setCreator("JAMES")
	 	-> setlastModifiedBy("JAMES")
	 	-> setTitle("未支付报表")
	 	-> setSubject("未支付报表")
	 	-> setDescription("未支付报表")
	 	-> setKeywords("未支付报表")
	 	-> setCategory("未支付报表");
		$objPHPExcel->getDefaultStyle()->getFont()->setName("微软雅黑")->setSize(12);//设置默认字体大小
		//设置第一行行高 
		$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(31.5);
	 	if($list){
	 	$objPHPExcel -> setActiveSheetIndex(0)
	 	-> setCellValue('A1','序号')
	 	-> setCellValue('B1','学员名字')
	 	-> setCellValue('C1','预约日期')
	 	-> setCellValue('D1','预约时间段')
	 	//-> setCellValue('D1','订单编号')
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
	 	$objPHPExcel -> getActiveSheet() -> getColumnDimension('G') -> setWidth(10);
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



		 	$objPHPExcel -> setActiveSheetIndex(0) -> setCellValue('A'.$c,$value['id']);//序号
		 	$objPHPExcel -> setActiveSheetIndex(0) -> setCellValue('B'.$c,$value['xname']);
		 	// $objPHPExcel -> setActiveSheetIndex(0) -> setCellValue('C'.$c,$value['jname']);
		 	$objPHPExcel -> setActiveSheetIndex(0) -> setCellValue('C'.$c,$value['data']);
		 	$objPHPExcel -> setActiveSheetIndex(0) -> setCellValue('D'.$c,$value['time']);
		 	$objPHPExcel -> setActiveSheetIndex(0) -> setCellValue('E'.$c,$value['ch']);
		 	$objPHPExcel -> setActiveSheetIndex(0) -> setCellValue('F'.$c,$value['addtime']);
		 	$objPHPExcel -> setActiveSheetIndex(0) -> setCellValue('G'.$c,$value['money'].' 元');
		 	$objPHPExcel -> setActiveSheetIndex(0) -> setCellValue('H'.$c,'未支付');
		 	$excelName = '未支付';

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
	 	$filename = $filelName.$data.'.xls';
	 	ob_end_clean();//清除缓存以免乱码出现
	 	header('Content-Type: application/vnd.ms-excel');
	 	header('Content-Type: application/octet-stream');
	 	header('Content-Disposition: attachment; filename="' . $filename . '"');
	 	header('Cache-Control: max-age=0');
	 	$objWriter -> save('php://output');die;	
	 }
	 
	public function tui_Download(){
    	header("Content-type:text/html;charset=utf-8");
     	 $objPHPExcel = new \Org\Util\PHPExcel();
     	 $dingdan= M('dingdan');
	 	 $jiaolian= M('jiaolian');
	 	 $xueyuan= M('xueyuan');
	 	 $yuyue= M('yuyue');
	 	 $tuikuan= M('tuikuan');
		 // $datetimepicker = I('datetimepicker');
		 // $datetimepicker1 = I('datetimepicker1');
		 // if($datetimepicker !="" && $datetimepicker1 !="" && $datetimepicker !="null" && $datetimepicker1 !="null"){
			// $list = $tuikuan->table('wp_tuikuan t')
			// // ->join('wp_jiaolian j on d.jid=j.id')
			// ->join('wp_xueyuan x on t.xid=x.id')
			// ->join('wp_paiban p on t.pid=p.id')
			// ->field('*,t.id as id,t.status as status,t.pdata as pdata')
			// ->where("t.status = 1 and (t.taddtime >= '$datetimepicker' and t.taddtime <= '$datetimepicker1')")
			// ->order('t.id desc')
			// ->select();
		 // }else{
			// $list = $tuikuan->table('wp_tuikuan t')
			// // ->join('wp_jiaolian j on d.jid=j.id')
			// ->join('wp_xueyuan x on t.xid=x.id')
			// ->join('wp_paiban p on t.pid=p.id')
			// ->field('*,t.id as id,t.status as status,t.pdata as pdata')
			// ->where("t.status = 1")
			// ->order('t.id desc')
			// ->select();
		 // }

	 	$datetimepicker = I('datetimepicker');
		$datetimepicker1 = I('datetimepicker1');
		$keywords = I("keywords");
		//手机号或身份证为空,时间段不为空
    	if($datetimepicker != '' && $datetimepicker1 != '' && $keywords == ""){
    		$where['t.taddtime'] =  array('between',array($datetimepicker.' 00:00:00',$datetimepicker1.' 23:59:59'));
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
    		$where['t.taddtime'] =  array('between',array($datetimepicker.' 00:00:00',$datetimepicker1.' 23:59:59'));
    		if(strlen($keywords) > 11){
    			//echo '身份证';die;
    			$where['x.xcard'] = array('like',"%$keywords%");
    		}else{
    			//echo '手机号';die;
    			$where['x.xphone'] = array('like',"%$keywords%");
    		}
    	}
		
	 	$where['t.status'] = 1;
		$list = $tuikuan->table('wp_tuikuan t')
			// ->join('wp_jiaolian j on d.jid=j.id')
			->join('wp_xueyuan x on t.xid=x.id')
			->join('wp_paiban p on t.pid=p.id')
			->field('*,t.id as id,t.status as status,t.pdata as pdata')
			->where($where)
			->order('t.id desc')
			->select();

	 	// 设置excel属性
	 	$objPHPExcel -> getProperties() -> setCreator("JAMES")
	 	-> setlastModifiedBy("JAMES")
	 	-> setTitle("已退款报表")
	 	-> setSubject("已退款报表")
	 	-> setDescription("已退款报表")
	 	-> setKeywords("已退款报表")
	 	-> setCategory("已退款报表");
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
	 	-> setCellValue('F1','微信退款单号')
	 	-> setCellValue('G1','退款金额')
	 	-> setCellValue('H1','退款时间')
	 	-> setCellValue('I1','状态');
	 	//设置宽度
	 	$objPHPExcel -> getActiveSheet() -> getColumnDimension('A') -> setWidth(7);
	 	$objPHPExcel -> getActiveSheet() -> getColumnDimension('B') -> setWidth(10);
	 	$objPHPExcel -> getActiveSheet() -> getColumnDimension('C') -> setWidth(15);
	 	$objPHPExcel -> getActiveSheet() -> getColumnDimension('D') -> setWidth(15);
	 	$objPHPExcel -> getActiveSheet() -> getColumnDimension('E') -> setWidth(10);
	 	$objPHPExcel -> getActiveSheet() -> getColumnDimension('F') -> setWidth(30);
	 	$objPHPExcel -> getActiveSheet() -> getColumnDimension('G') -> setWidth(10);
	 	$objPHPExcel -> getActiveSheet() -> getColumnDimension('H') -> setWidth(20);
	 	$objPHPExcel -> getActiveSheet() -> getColumnDimension('I') -> setWidth(10);
	 	 $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);  
	 	 $objPHPExcel->getActiveSheet()->getStyle('B1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);  
	 	 $objPHPExcel->getActiveSheet()->getStyle('C1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);  
	 	 $objPHPExcel->getActiveSheet()->getStyle('D1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);  
	 	 $objPHPExcel->getActiveSheet()->getStyle('E1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);  
	 	 $objPHPExcel->getActiveSheet()->getStyle('F1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);  
	 	 $objPHPExcel->getActiveSheet()->getStyle('G1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	 	 $objPHPExcel->getActiveSheet()->getStyle('H1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	 	 $objPHPExcel->getActiveSheet()->getStyle('I1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	 	$styleThinBlackBorderOutline = array(
	 	       'borders' => array (
	 	             'outline' => array (
	 	                   'style' => \PHPExcel_Style_Border::BORDER_THIN,   //设置border样式
	 	                   //'style' => PHPExcel_Style_Border::BORDER_THICK,  另一种样式
	 	                   'color' => array ('argb' => 'FF000000'),          //设置border颜色
	 	            ),
	 	      ),
	 	);
	 	$objPHPExcel->getActiveSheet()->getStyle( 'A1:I1')->applyFromArray($styleThinBlackBorderOutline);
	 	$objPHPExcel->getActiveSheet()->getStyle('A1:I1')->getBorders()->getAllBorders()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);
	 	 
	 	      
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
	 		$objPHPExcel->getActiveSheet()->getStyle('I')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	 	    $objPHPExcel->getActiveSheet()->getStyle( 'A'.$c.':I'.$c)->applyFromArray($styleThinBlackBorderOutline);
	 	$objPHPExcel->getActiveSheet()->getStyle( 'A'.$c.':I'.$c)->getBorders()->getAllBorders()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);



		 	$objPHPExcel -> setActiveSheetIndex(0) -> setCellValue('A'.$c,$value['id']);//序号
		 	$objPHPExcel -> setActiveSheetIndex(0) -> setCellValue('B'.$c,$value['xname']);
		 	// $objPHPExcel -> setActiveSheetIndex(0) -> setCellValue('C'.$c,$value['jname']);
		 	$objPHPExcel -> setActiveSheetIndex(0) -> setCellValue('C'.$c,$value['pdata']);
		 	$objPHPExcel -> setActiveSheetIndex(0) -> setCellValue('D'.$c,$value['ptime']);
		 	$objPHPExcel -> setActiveSheetIndex(0) -> setCellValue('E'.$c,$value['pch']);
		 	$objPHPExcel -> setActiveSheetIndex(0) -> setCellValue('F'.$c,$value['refund_id']);
		 	$objPHPExcel -> setActiveSheetIndex(0) -> setCellValue('G'.$c,$value['refund_fee']);
		 	$objPHPExcel -> setActiveSheetIndex(0) -> setCellValue('H'.$c,$value['taddtime']);
		 	$objPHPExcel -> setActiveSheetIndex(0) -> setCellValue('I'.$c,'已退款');
		 	$excelName = '已退款';

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
	 	$filename = $filelName.$data.'.xls';
	 	ob_end_clean();//清除缓存以免乱码出现
	 	header('Content-Type: application/vnd.ms-excel');
	 	header('Content-Type: application/octet-stream');
	 	header('Content-Disposition: attachment; filename="' . $filename . '"');
	 	header('Cache-Control: max-age=0');
	 	$objWriter -> save('php://output');die;	
	 }
	 
	 
	 
	public function cunkuan_list(){
    	// header("Content-type:text/html;charset=utf-8");
		$dingdan= M('dingdan');
		// $datetimepicker = substr(I('datetimepicker'),0,10);
		// $datetimepicker1 = substr(I('datetimepicker1'),0,10);
		
		$datetimepicker = I('datetimepicker');
		$datetimepicker1 = I('datetimepicker1');
		if($datetimepicker != '' && $datetimepicker1 != ''){
   //  		if($datetimepicker == $datetimepicker1){
			// 	$where['daddtime'] = array('like',"%$datetimepicker%");
			// }else{
				$where['daddtime'] =  array('between',array($datetimepicker.' 00:00:00',$datetimepicker1.' 23:59:59'));	
			// }
    	}
		//$data=$dingdan->field("count(*) as count,pdata,sum(money) as subtotal")->where($where)->group("pdata")->select();
		$data=$dingdan->field("count(*) as count,pdata,daddtime,DATE_FORMAT(daddtime,'%Y-%m-%d') as dadd,sum(money) as subtotal")->where($where)->group("dadd")->select();
		//dump($data);die;
		$totalCount = count($data);
		$Page = new \Think\Page ( $totalCount,10 );
		$ck_list = $dingdan->field("count(*) as count,pdata,daddtime,DATE_FORMAT(daddtime,'%Y-%m-%d') as dadd,sum(money) as subtotal")
					->where($where)
					->group("dadd")
					->limit($Page->firstRow.','.$Page->listRows)
					->order('daddtime desc')
					->select();
		//echo $dingdan->getlastsql();
		//存款总金额
		$total = 0;
		foreach ($ck_list as $key => $value) {
			$value['subtotal'] = (float)$value['subtotal'];
			$total += $value['subtotal'];
			$cunkuan_list[] = $value;
		}

		foreach ($cunkuan_list as $key => $value) {
			$dadd = $cunkuan_list[$key]['dadd'];
			$condtion['taddtime']=array("like","%$dadd%");
			$data11=M('tuikuan')->field("sum(refund_fee) as subtotal_tui")->where($condtion)->select();
			if($data11[0]['subtotal_tui'] == null){
				$data11[0]['subtotal_tui'] = 0;
			}
			//退费金额
			$cunkuan_list[$key]['subtotal_tui'] = $data11[0]['subtotal_tui'];
			$cunkuan_list[$key]['subtotal_tui'] = sprintf("%.2f", $cunkuan_list[$key]['subtotal_tui']);
			//手续费金额
			$cunkuan_list[$key]['subtotal_sx'] = ($cunkuan_list[$key]['subtotal'] - $cunkuan_list[$key]['subtotal_tui']) * 0.006;
			$cunkuan_list[$key]['subtotal_sx'] = sprintf("%.2f", $cunkuan_list[$key]['subtotal_sx']);
			//入账金额
			$cunkuan_list[$key]['subtotal_rz'] = ($cunkuan_list[$key]['subtotal'] - $cunkuan_list[$key]['subtotal_tui'] - $cunkuan_list[$key]['subtotal_sx']);
			$cunkuan_list[$key]['subtotal_rz'] = sprintf("%.2f", $cunkuan_list[$key]['subtotal_rz']);
			
		}
		//退款金额
		$total_tui = 0;
		foreach ($cunkuan_list as $key => $value) {
			$value['subtotal_tui'] = (float)$value['subtotal_tui'];
			$total_tui += $value['subtotal_tui'];
		}
		//手续费金额
		$total_sx = 0;
		foreach ($cunkuan_list as $key => $value) {
			$value['subtotal_sx'] = (float)$value['subtotal_sx'];
			$total_sx += $value['subtotal_sx'];
		}
		//入账金额
		$total_rz = 0;
		foreach ($cunkuan_list as $key => $value) {
			$value['subtotal_rz'] = (float)$value['subtotal_rz'];
			$total_rz += $value['subtotal_rz'];
		}
		// dump($ck_list);
		// dump($cunkuan_list);
		$page = $Page -> show();
		$this->assign('cunkuan_list',$cunkuan_list);
		$this->assign('sum',$total);
		//$this->assign('sum_tui',$total_tui);
		//$this->assign('sum_sx',$total_sx);
		//$this->assign('sum_rz',$total_rz);
		$this->assign('sum_tui',sprintf("%.2f", $total_tui));
		$this->assign('sum_sx',sprintf("%.2f", $total_sx));
		$this->assign('sum_rz',sprintf("%.2f", $total_rz));
		$this->assign('_page', $page);
		$this->assign('datetimepicker', $datetimepicker);
		$this->assign('datetimepicker1', $datetimepicker1);
		$this->display();
	}
	
	public function shoufei_list(){
		header("Content-type:text/html;charset=utf-8");
		$dingdan= M('dingdan');
		$datetimepicker = I('datetimepicker');
		$datetimepicker1 = I('datetimepicker1');
		$keywords = I('keywords');
		/* if($datetimepicker !="" && $datetimepicker1 !="" && $datetimepicker !="null" && $datetimepicker1 !="null"){
			$where['d.daddtime'] = array('between',array($datetimepicker,$datetimepicker1));
			$shoufei_list = $dingdan->table('wp_dingdan d')
			->join('wp_xueyuan x on d.xid=x.id')
			->join('wp_paiban p on d.pid=p.id')
			->field('*,d.id as id')
			->where($where)
			->order('d.id desc')
			->select();
			$json = json_encode($shoufei_list);
			echo $json;die;
		}else{
			$shoufei_list = $dingdan->table('wp_dingdan d')
			->join('wp_xueyuan x on d.xid=x.id')
			->join('wp_paiban p on d.pid=p.id')
			->field('*,d.id as id')
			->where($where)
			->order('d.id desc')
			->select();	
			// var_dump($shoufei_list);die;
			$this->assign('shoufei_list',$shoufei_list);
			$this->display();
		} */
		
		if($datetimepicker !="" && $datetimepicker1 !="" && $keywords != "")
		{
			// if($datetimepicker == $datetimepicker1){
   //  			$where['d.daddtime'] =  array('like',"%$datetimepicker%");
   //  		}else{
    			$where['d.daddtime'] =  array('between',array($datetimepicker.' 00:00:00',$datetimepicker1.' 23:59:59'));
    		// }
			if(strlen($keywords) > 11){
    			$where['x.xcard'] = array('like',"%$keywords%");
    		}else{
    			$where['x.xphone'] = array('like',"%$keywords%");
    		}
			// $shoufei_list = $dingdan->table('wp_dingdan d')
			// ->join('wp_xueyuan x on d.xid=x.id')
			// ->join('wp_paiban p on d.pid=p.id')
			// ->field('*,d.id as id')
			// ->where($where)
			// ->order('d.id desc')
			// ->select();
			// $json = json_encode($shoufei_list);
			// echo $json;die;
		}
		 if($datetimepicker != '' && $datetimepicker1 != '' && $keywords == "")
		{
			// if($datetimepicker == $datetimepicker1){
   //  			$where['d.daddtime'] =  array('like',"%$datetimepicker%");
   //  		}else{
    			$where['d.daddtime'] =  array('between',array($datetimepicker.' 00:00:00',$datetimepicker1.' 23:59:59'));
    		// }
		}
		 if($datetimepicker == '' && $datetimepicker1 == '' && $keywords !== "")
		{
			if(strlen($keywords) > 11){
    			$where['x.xcard'] = array('like',"%$keywords%");
    		}else{
    			$where['x.xphone'] = array('like',"%$keywords%");
    		}
		}

		$totalCount = $dingdan->table('wp_dingdan d')
		->join('wp_xueyuan x on d.xid=x.id')
		->join('wp_paiban p on d.pid=p.id')
		->field('*,d.id as id')
		->where($where)
		->count();

		$Page = new \Think\Page ($totalCount,10);
		$Page->setConfig ( 'theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%' );

		$shoufei_list = $dingdan->table('wp_dingdan d')
		->join('wp_xueyuan x on d.xid=x.id')
		->join('wp_paiban p on d.pid=p.id')
		->field('*,d.id as id')
		->where($where)
		->limit($Page->firstRow.','.$Page->listRows)
		->order('d.id desc')
		->select();
		$sum_money = 0;
		$sum_money2 = 0;
		$sum_money3 = 0;
		foreach ($shoufei_list as $key => $value) {
			$sum_money += $value['money'];
			$shoufei_list[$key]['money2'] = $value['money'] * 0.006;
			$shoufei_list[$key]['money3'] = $value['money'] - ($value['money'] * 0.006);
			$sum_money2 += $shoufei_list[$key]['money2'];
			$sum_money3 += $shoufei_list[$key]['money3'];
		}
		$page = $Page->show();// 分页显示输出
		// dump($shoufei_list);die;
		//$percent = '0.006';
		$this->assign('shoufei_list',$shoufei_list);
		$this->assign('sum_money',$sum_money);
		$this->assign('sum_money2',$sum_money2);
		$this->assign('sum_money3',$sum_money3);
		$this->assign('_page',$page);
		$this->assign('datetimepicker',$datetimepicker);
		$this->assign('datetimepicker1',$datetimepicker1);
		$this->assign('keywords',$keywords);
		$this->display();
		
	}
	
	public function shoufei_Download(){
    	header("Content-type:text/html;charset=utf-8");
     	 $objPHPExcel = new \Org\Util\PHPExcel();

     	 $dingdan= M('dingdan');
	 	 $jiaolian= M('jiaolian');
	 	 $xueyuan= M('xueyuan');
	 	 $yuyue= M('yuyue');
		 // $datetimepicker = I('datetimepicker');
		 // $datetimepicker1 = I('datetimepicker1');
		 // if($datetimepicker !="" && $datetimepicker1 !="" && $datetimepicker !="null" && $datetimepicker1 !="null"){
			//  $list = $dingdan->table('wp_dingdan d')
	 	//     ->join('wp_xueyuan x on d.xid=x.id')
	 	//     ->join('wp_paiban p on d.pid=p.id')
	 	//  	->field('*,d.id as id')
	 	//     ->where("d.daddtime >= '$datetimepicker' and d.daddtime <= '$datetimepicker1' ")
	 	//     ->order('d.id desc')
	 	//     ->select();
		 // }else{
			//  $list = $dingdan->table('wp_dingdan d')
	 	//     ->join('wp_xueyuan x on d.xid=x.id')
	 	//     ->join('wp_paiban p on d.pid=p.id')
	 	//  	->field('*,d.id as id')
	 	//     ->order('d.id desc')
	 	//     ->select();
		 // }

	 	$datetimepicker = I('datetimepicker');
		$datetimepicker1 = I('datetimepicker1');
		$keywords = I('keywords');

		if($datetimepicker !="" && $datetimepicker1 !="" && $keywords != ""){
			// if($datetimepicker == $datetimepicker1){
   //  			$where['d.daddtime'] =  array('like',"%$datetimepicker%");
   //  		}else{
    			$where['d.daddtime'] =  array('between',array($datetimepicker.' 00:00:00',$datetimepicker1.' 23:59:59'));
    		// }
			if(strlen($keywords) > 11){
    			//echo '身份证';die;
    			$where['x.xcard'] = array('like',"%$keywords%");
    		}else{
    			//echo '手机号';die;
    			$where['x.xphone'] = array('like',"%$keywords%");
    		}
			
			$list = $dingdan->table('wp_dingdan d')
		 	    ->join('wp_xueyuan x on d.xid=x.id')
		 	    ->join('wp_paiban p on d.pid=p.id')
		 	 	->field('*,d.id as id')
		 	    ->where($where)
		 	    ->order('d.id desc')
		 	    ->select();
		}
		else if($datetimepicker != '' && $datetimepicker1 != '' && $keywords == "")
		{
			// if($datetimepicker == $datetimepicker1){
   //  			$where['d.daddtime'] =  array('like',"%$datetimepicker%");
   //  		}else{
    			$where['d.daddtime'] =  array('between',array($datetimepicker.' 00:00:00',$datetimepicker1.' 23:59:59'));
    		// }
			$list = $dingdan->table('wp_dingdan d')
		 	    ->join('wp_xueyuan x on d.xid=x.id')
		 	    ->join('wp_paiban p on d.pid=p.id')
		 	 	->field('*,d.id as id')
		 	    ->where($where)
		 	    ->order('d.id desc')
		 	    ->select();
		}
		else if($datetimepicker == '' && $datetimepicker1 == '' && $keywords !== "")
		{
			if(strlen($keywords) > 11){
    			$where['x.xcard'] = array('like',"%$keywords%");
    		}else{
    			$where['x.xphone'] = array('like',"%$keywords%");
    		}
    		$list = $dingdan->table('wp_dingdan d')
		 	    ->join('wp_xueyuan x on d.xid=x.id')
		 	    ->join('wp_paiban p on d.pid=p.id')
		 	 	->field('*,d.id as id')
		 	    ->where($where)
		 	    ->order('d.id desc')
		 	    ->select();
		}
		else
		{
			$list = $dingdan->table('wp_dingdan d')
		 	    ->join('wp_xueyuan x on d.xid=x.id')
		 	    ->join('wp_paiban p on d.pid=p.id')
		 	 	->field('*,d.id as id')
		 	    ->order('d.id desc')
		 	    ->select();
		}
		$sum_money = 0;
		$sum_money2 = 0;
		$sum_money3 = 0;
		foreach ($list as $key => $value) {
			$sum_money += $value['money'];
			$list[$key]['money2'] = $value['money'] * 0.006;
			$list[$key]['money3'] = $value['money'] - ($value['money'] * 0.006);
			$sum_money2 += $list[$key]['money2'];
			$sum_money3 += $list[$key]['money3'];
		}
	 	// 设置excel属性
	 	$objPHPExcel -> getProperties() -> setCreator("JAMES")
	 	-> setlastModifiedBy("JAMES")
	 	-> setTitle("收费报表")
	 	-> setSubject("收费报表")
	 	-> setDescription("收费报表")
	 	-> setKeywords("收费报表")
	 	-> setCategory("收费报表");
		$objPHPExcel->getDefaultStyle()->getFont()->setName("微软雅黑")->setSize(12);//设置默认字体大小
		//设置第一行行高 
		$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(31.5);
	 	if($list){
	 	$objPHPExcel -> setActiveSheetIndex(0)
	 	-> setCellValue('A1','编号')
	 	-> setCellValue('B1','姓名')
	 	-> setCellValue('C1','预约日期')
	 	-> setCellValue('D1','用车时间')
	 	-> setCellValue('E1','车号')
	 	-> setCellValue('F1','收费日期')
	 	-> setCellValue('G1','收费')
	 	-> setCellValue('H1','收费1')
	 	-> setCellValue('I1','收费2');
	 	
	 	//设置宽度
	 	$objPHPExcel -> getActiveSheet() -> getColumnDimension('A') -> setWidth(7);
	 	$objPHPExcel -> getActiveSheet() -> getColumnDimension('B') -> setWidth(15);
	 	$objPHPExcel -> getActiveSheet() -> getColumnDimension('C') -> setWidth(20);
	 	$objPHPExcel -> getActiveSheet() -> getColumnDimension('D') -> setWidth(20);
	 	$objPHPExcel -> getActiveSheet() -> getColumnDimension('E') -> setWidth(10);
	 	$objPHPExcel -> getActiveSheet() -> getColumnDimension('F') -> setWidth(20);
	 	$objPHPExcel -> getActiveSheet() -> getColumnDimension('G') -> setWidth(15);
	 	$objPHPExcel -> getActiveSheet() -> getColumnDimension('H') -> setWidth(15);
	 	$objPHPExcel -> getActiveSheet() -> getColumnDimension('I') -> setWidth(15);
	 	 $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);  
	 	 $objPHPExcel->getActiveSheet()->getStyle('B1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);  
	 	 $objPHPExcel->getActiveSheet()->getStyle('C1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);  
	 	 $objPHPExcel->getActiveSheet()->getStyle('D1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);  
	 	 $objPHPExcel->getActiveSheet()->getStyle('E1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);  
	 	 $objPHPExcel->getActiveSheet()->getStyle('F1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
	 	 $objPHPExcel->getActiveSheet()->getStyle('G1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
	 	 $objPHPExcel->getActiveSheet()->getStyle('H1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
	 	 $objPHPExcel->getActiveSheet()->getStyle('I1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
	 	$styleThinBlackBorderOutline = array(
	 	       'borders' => array (
	 	             'outline' => array (
	 	                   'style' => \PHPExcel_Style_Border::BORDER_THIN,   //设置border样式
	 	                   //'style' => PHPExcel_Style_Border::BORDER_THICK,  另一种样式
	 	                   'color' => array ('argb' => 'FF000000'),          //设置border颜色
	 	            ),
	 	      ),
	 	);
	 	$objPHPExcel->getActiveSheet()->getStyle( 'A1:I1')->applyFromArray($styleThinBlackBorderOutline);
	 	$objPHPExcel->getActiveSheet()->getStyle('A1:I1')->getBorders()->getAllBorders()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);
	 	 
	 	      
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
	 		$objPHPExcel->getActiveSheet()->getStyle('I')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	 	    $objPHPExcel->getActiveSheet()->getStyle( 'A'.$c.':I'.$c)->applyFromArray($styleThinBlackBorderOutline);
	 	$objPHPExcel->getActiveSheet()->getStyle( 'A'.$c.':I'.$c)->getBorders()->getAllBorders()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);



		 	$objPHPExcel -> setActiveSheetIndex(0) -> setCellValue('A'.$c,$value['id']);
		 	$objPHPExcel -> setActiveSheetIndex(0) -> setCellValue('B'.$c,$value['xname']);
		 	$objPHPExcel -> setActiveSheetIndex(0) -> setCellValue('C'.$c,$value['pdata']);
		 	$objPHPExcel -> setActiveSheetIndex(0) -> setCellValue('D'.$c,$value['ptime']);
		 	$objPHPExcel -> setActiveSheetIndex(0) -> setCellValue('E'.$c,$value['pch']);
		 	$objPHPExcel -> setActiveSheetIndex(0) -> setCellValue('F'.$c,substr($value['daddtime'],0,10));
		 	$objPHPExcel -> setActiveSheetIndex(0) -> setCellValue('G'.$c,$value['money'].' 元');
		 	$objPHPExcel -> setActiveSheetIndex(0) -> setCellValue('H'.$c,$value['money2'].' 元');
		 	$objPHPExcel -> setActiveSheetIndex(0) -> setCellValue('I'.$c,$value['money3'].' 元');
		 	$excelName = '收费报表';

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
	 	$filename = $filelName.$data.'.xls';
	 	ob_end_clean();//清除缓存以免乱码出现
	 	header('Content-Type: application/vnd.ms-excel');
	 	header('Content-Type: application/octet-stream');
	 	header('Content-Disposition: attachment; filename="' . $filename . '"');
	 	header('Cache-Control: max-age=0');
	 	$objWriter -> save('php://output');die;	
	 }
	 
	public function cunkuan_Download(){
    	header("Content-type:text/html;charset=utf-8");
     	$objPHPExcel = new \Org\Util\PHPExcel();
		$dingdan= M('dingdan');		
		// $day[0] = date("Y-m-d");
		// $day[1] = date("Y-m-d",strtotime("-1 day"));
		// $day[2] = date("Y-m-d",strtotime("-2 day"));
		// $day[3]	= date("Y-m-d",strtotime("-3 day"));
		// $day[4] = date("Y-m-d",strtotime("-4 day"));		
		// for($i=0;$i<count($day);$i++){
		// 	$sql[$i] = "select sum(money) as count from wp_dingdan where pdata = '$day[$i]' ";
		// 	$res[$i] = $dingdan->query($sql[$i]);
		// 	if($res[$i][0]['count'] == null){
		// 		$res[$i][0]['count'] = 0;
		// 	}
		// 	$res[$i]['newcount'] = (float)$res[$i][0]['count'];
		// }		
		// $sum = 0;
		// for($i=0;$i<count($res);$i++){
		// 	$sum += $res[$i]['newcount'];
		// 	$res[$i]['day'] = $day[$i];
		// }

		//dump($res);

		$datetimepicker = I('datetimepicker');
		$datetimepicker1 = I('datetimepicker1');
		if($datetimepicker != '' && $datetimepicker1 != ''){
			// if($datetimepicker == $datetimepicker1){
			// 	$where['daddtime'] = array('like',"%$datetimepicker%");
			// }else{
				$where['daddtime'] =  array('between',array($datetimepicker.' 00:00:00',$datetimepicker1.' 23:59:59'));	
			// }
    		
    	}
		 

		$ck_list = $dingdan->field("count(*) as count,pdata,daddtime,DATE_FORMAT(daddtime,'%Y-%m-%d') as dadd,sum(money) as subtotal")
					->where($where)
					->group("dadd")
					//->limit($Page->firstRow.','.$Page->listRows)
					->order('daddtime desc')
					->select();
		$total = 0;
		foreach ($ck_list as $key => $value) {
			$value['subtotal'] = (float)$value['subtotal'];
			$total += $value['subtotal'];
			$cunkuan_list[] = $value;
		}

        foreach ($cunkuan_list as $key => $value) {
			$dadd = $cunkuan_list[$key]['dadd'];
			$condtion['taddtime']=array("like","%$dadd%");
			$data11=M('tuikuan')->field("sum(refund_fee) as subtotal_tui")->where($condtion)->select();
			if($data11[0]['subtotal_tui'] == null){
				$data11[0]['subtotal_tui'] = 0;
			}
			//退费金额
			$cunkuan_list[$key]['subtotal_tui'] = $data11[0]['subtotal_tui'];
			$cunkuan_list[$key]['subtotal_tui'] = sprintf("%.2f", $cunkuan_list[$key]['subtotal_tui']);
			//手续费金额
			$cunkuan_list[$key]['subtotal_sx'] = ($cunkuan_list[$key]['subtotal'] - $cunkuan_list[$key]['subtotal_tui']) * 0.006;
			$cunkuan_list[$key]['subtotal_sx'] = sprintf("%.2f", $cunkuan_list[$key]['subtotal_sx']);
			//入账金额
			$cunkuan_list[$key]['subtotal_rz'] = ($cunkuan_list[$key]['subtotal'] - $cunkuan_list[$key]['subtotal_tui'] - $cunkuan_list[$key]['subtotal_sx']);
			$cunkuan_list[$key]['subtotal_rz'] = sprintf("%.2f", $cunkuan_list[$key]['subtotal_rz']);
			
		}
		
		//退款金额
		$total_tui = 0;
		foreach ($cunkuan_list as $key => $value) {
			$value['subtotal_tui'] = (float)$value['subtotal_tui'];
			$total_tui += $value['subtotal_tui'];
		}
		$total_tui = sprintf("%.2f", $total_tui);
		//手续费金额
		$total_sx = 0;
		foreach ($cunkuan_list as $key => $value) {
			$value['subtotal_sx'] = (float)$value['subtotal_sx'];
			$total_sx += $value['subtotal_sx'];
		}
		$total_sx = sprintf("%.2f", $total_sx);
		//入账金额
		$total_rz = 0;
		foreach ($cunkuan_list as $key => $value) {
			$value['subtotal_rz'] = (float)$value['subtotal_rz'];
			$total_rz += $value['subtotal_rz'];
		}
		$total_rz = sprintf("%.2f", $total_rz);
		//dump($total_rz);
		//die;
	 	// 设置excel属性
	 	$objPHPExcel -> getProperties() -> setCreator("JAMES")
	 	-> setlastModifiedBy("JAMES")
	 	-> setTitle("存款报表")
	 	-> setSubject("存款报表")
	 	-> setDescription("存款报表")
	 	-> setKeywords("存款报表")
	 	-> setCategory("存款报表");
		$objPHPExcel->getDefaultStyle()->getFont()->setName("微软雅黑")->setSize(12);//设置默认字体大小
		//设置第一行行高 
		$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(31.5);
	 	//if($res){
	 	if($cunkuan_list){
	 	$objPHPExcel -> setActiveSheetIndex(0)
	 	-> setCellValue('A1','存款日期')
	 	-> setCellValue('B1','存款金额(元)')
	 	-> setCellValue('C1','退款金额(元)')
	 	-> setCellValue('D1','手续费(元)')
	 	-> setCellValue('E1','入账金额(元)');
	 	//设置宽度
	 	$objPHPExcel -> getActiveSheet() -> getColumnDimension('A') -> setWidth(15);
	 	$objPHPExcel -> getActiveSheet() -> getColumnDimension('B') -> setWidth(15);
	 	$objPHPExcel -> getActiveSheet() -> getColumnDimension('C') -> setWidth(15);
	 	$objPHPExcel -> getActiveSheet() -> getColumnDimension('D') -> setWidth(15);
	 	$objPHPExcel -> getActiveSheet() -> getColumnDimension('E') -> setWidth(15);
	 	 $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);  
	 	 $objPHPExcel->getActiveSheet()->getStyle('B1')->getAlignment()->setHorizontal(\ PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
	 	 $objPHPExcel->getActiveSheet()->getStyle('C1')->getAlignment()->setHorizontal(\ PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
	 	 $objPHPExcel->getActiveSheet()->getStyle('D1')->getAlignment()->setHorizontal(\ PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
	 	 $objPHPExcel->getActiveSheet()->getStyle('E1')->getAlignment()->setHorizontal(\ PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 

	 	$styleThinBlackBorderOutline = array(
	 	       'borders' => array (
	 	             'outline' => array (
	 	                   'style' => \PHPExcel_Style_Border::BORDER_THIN,   //设置border样式
	 	                   //'style' => PHPExcel_Style_Border::BORDER_THICK,  另一种样式
	 	                   'color' => array ('argb' => 'FF000000'),          //设置border颜色
	 	            ),
	 	      ),
	 	);
	 	$objPHPExcel->getActiveSheet()->getStyle( 'A1:E1')->applyFromArray($styleThinBlackBorderOutline);
	 	$objPHPExcel->getActiveSheet()->getStyle('A1:E1')->getBorders()->getAllBorders()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);
	 	 
	 	      
	 	$c = 1;
	 	$sort = 0;
	 	$excelName = '';
	 	// foreach ($res as $key => $value) {
		 // 	$c++;
		 // 	$sort++;
			// $objPHPExcel->getActiveSheet()->getRowDimension($c)->setRowHeight(25.5);
	 	// 	$objPHPExcel->getActiveSheet()->getStyle('A')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);  
	 	// 	$objPHPExcel->getActiveSheet()->getStyle('B')->getAlignment()->setHorizontal(\ PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	 	//     $objPHPExcel->getActiveSheet()->getStyle( 'A'.$c.':B'.$c)->applyFromArray($styleThinBlackBorderOutline);
	 	// $objPHPExcel->getActiveSheet()->getStyle( 'A'.$c.':B'.$c)->getBorders()->getAllBorders()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);



		 // 	$objPHPExcel -> setActiveSheetIndex(0) -> setCellValue('A'.$c,$value['day']);
		 // 	$objPHPExcel -> setActiveSheetIndex(0) -> setCellValue('B'.$c,$value['newcount']);
		 // 	$excelName = '存款报表';

	 	// }
	 	//dump($cunkuan_list);die;
	 	foreach ($cunkuan_list as $key => $value) {
		 	$c++;
		 	$sort++;
			$objPHPExcel->getActiveSheet()->getRowDimension($c)->setRowHeight(25.5);
	 		$objPHPExcel->getActiveSheet()->getStyle('A')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);  
	 		$objPHPExcel->getActiveSheet()->getStyle('B')->getAlignment()->setHorizontal(\ PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	 		$objPHPExcel->getActiveSheet()->getStyle('C')->getAlignment()->setHorizontal(\ PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	 		$objPHPExcel->getActiveSheet()->getStyle('D')->getAlignment()->setHorizontal(\ PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	 		$objPHPExcel->getActiveSheet()->getStyle('E')->getAlignment()->setHorizontal(\ PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	 	    $objPHPExcel->getActiveSheet()->getStyle( 'A'.$c.':E'.$c)->applyFromArray($styleThinBlackBorderOutline);
	 	$objPHPExcel->getActiveSheet()->getStyle( 'A'.$c.':E'.$c)->getBorders()->getAllBorders()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);



		 	$objPHPExcel -> setActiveSheetIndex(0) -> setCellValue('A'.$c,$value['dadd']);
		 	$objPHPExcel -> setActiveSheetIndex(0) -> setCellValue('B'.$c,$value['subtotal']);
		 	$objPHPExcel -> setActiveSheetIndex(0) -> setCellValue('C'.$c,$value['subtotal_tui']);
		 	$objPHPExcel -> setActiveSheetIndex(0) -> setCellValue('D'.$c,$value['subtotal_sx']);
		 	$objPHPExcel -> setActiveSheetIndex(0) -> setCellValue('E'.$c,$value['subtotal_rz']);
		 	$excelName = '存款报表';

	 	}


		//$objPHPExcel -> setActiveSheetIndex(0) -> setCellValue('A7','5天总计金额：'.$sum.'元');
		$last_num = $key+3;
		$objPHPExcel -> setActiveSheetIndex(0) -> setCellValue('A'.$last_num,'合计');
		$objPHPExcel -> setActiveSheetIndex(0) -> setCellValue('B'.$last_num,$total);
		$objPHPExcel -> setActiveSheetIndex(0) -> setCellValue('C'.$last_num,$total_tui);
		$objPHPExcel -> setActiveSheetIndex(0) -> setCellValue('D'.$last_num,$total_sx);
		$objPHPExcel -> setActiveSheetIndex(0) -> setCellValue('E'.$last_num,$total_rz);
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
	 	$filename = $filelName.$data.'.xls';
	 	ob_end_clean();//清除缓存以免乱码出现
	 	header('Content-Type: application/vnd.ms-excel');
	 	header('Content-Type: application/octet-stream');
	 	header('Content-Disposition: attachment; filename="' . $filename . '"');
	 	header('Cache-Control: max-age=0');
	 	$objWriter -> save('php://output');die;
	 }
	
	 //打印
	 public function dayin(){
	 	// var_dump($_POST);die;
	 	$id = $_POST['id'];
	 	$dingdan = M('dingdan');
	 	$where['d.id'] = $id;
	 	$list = $dingdan->table('wp_dingdan d')
	 			->join('wp_xueyuan x on d.xid = x.id')
	 			->join('wp_jiaxiao jx on x.jx = jx.id')
	 			->join('wp_jiaolian jl on x.jl_id = jl.id')
	 			->field('*,d.id as id')
	 			->where($where)
	 			->select();
	 	echo json_encode($list);die;
	 }
	 // //打印退款
	 // public function dayin_tuikuan(){
	 // 	$id = isset($_POST['id']) ? $_POST['id'] : 0;
	 // 	$dingdan = M('dingdan');
		// $where['d.id'] = $id;
		// $list = $dingdan->table('wp_dingdan d')
		// 		->join('wp_xueyuan x on d.xid = x.id')
		// 		->where($where)
		// 		->field('*,d.id as id')
		// 		->select();

		// echo json_encode($list);die;

	 // }

	//存款明细列表
	public function mingxi_list(){
		$mingxi = M('dingdan');
		$datetimepicker = I('datetimepicker');
		$data = !empty($datetimepicker) ? $datetimepicker : date('Y-m-d',time());
		// $where['d.pdata'] = $data;
		$where['d.daddtime'] = array('like',"%$data%");

		$totalCount = $mingxi->table('wp_dingdan d')
		->join('wp_xueyuan x on d.xid=x.id')
		->field('*,d.id as id')
		->where($where)
		->count();
		$Page = new \Think\Page ( $totalCount,10 );
		$Page->setConfig ( 'theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%' );

		$mingxi_list = $mingxi->table('wp_dingdan d')
			->join('wp_xueyuan x on d.xid=x.id')
			//->join('wp_paiban p on d.pid=p.id')
			->field('*,d.id as id')
			->where($where)
			->limit($Page->firstRow.','.$Page->listRows)
			->order('d.id desc')
			->select();	
		$sum_money = 0;
		$sum_money_shiji = 0;
		$sum_money_shouxu = 0;
		foreach ($mingxi_list as $key => $value) {
			$value['money'] = (float)$value['money'];
			//$mingxi_list[] = $value;
			$sum_money += $value['money'];
			$mingxi_list[$key]['tuan_num'] = count(explode(',', $value['tuan']));
			$mingxi_list[$key]['money_shiji'] = $value['money'] - ($value['money'] * 0.006);
			$mingxi_list[$key]['money_shouxu'] = $value['money'] * 0.006;
			$sum_money_shiji += $mingxi_list[$key]['money_shiji'];
			$sum_money_shouxu += $mingxi_list[$key]['money_shouxu'];
		}	
		//$percent = '0.006';//折现百分比
		$sum_money += $mingxi_list['money'];

		$page  = $Page->show();// 分页显示输出
		$this->assign('_page', $page);
		//$this->assign('percent',$percent);
		$this->assign('datetimepicker',$data);
		$this->assign('mingxi_list',$mingxi_list);
		$this->assign('sum_money',$sum_money);
		$this->assign('sum_money_shiji',$sum_money_shiji);
		$this->assign('sum_money_shouxu',$sum_money_shouxu);
		$this->display();
	}
	 
	//已消费订单修改状态
	public function mod_xiao(){
		$mod_id = I('mod_id');
		$mod_status = I('mod_status');

		if(isset($mod_id) && isset($mod_status)){
			$mod_dingdan = M('dingdan');
			$where['id'] = $mod_id;
			$data['status'] = $mod_status;
			$res = $mod_dingdan->table('wp_dingdan')->where($where)->save($data);
			if($res){
				echo 1;die;//更新成功
			}else{
				echo 0;die;//更新失败
			}

		}else{
			echo 4;die;//修改失败
		}
		
		
	}

	//退款列表
	public function tuikuan_list(){
		$dingdan= M('tuikuan');
		// $datetimepicker = substr(I('datetimepicker'),0,10);
		// $datetimepicker1 = substr(I('datetimepicker1'),0,10);
		
		$datetimepicker = I('datetimepicker');
		$datetimepicker1 = I('datetimepicker1');
		if($datetimepicker != '' && $datetimepicker1 != ''){
			if($datetimepicker == $datetimepicker1){
				$where['taddtime'] = array('like',"%$datetimepicker%");
			}else{
				$where['taddtime'] =  array('between',array($datetimepicker,$datetimepicker1));	
			}
    	}
    	//$where['taddtime'] = array('EGT','2017-05-15');
		//$data=$dingdan->field("count(*) as count,pdata,sum(money) as subtotal")->where($where)->group("pdata")->select();
		$data=$dingdan->field("count(*) as count,taddtime,DATE_FORMAT(taddtime,'%Y-%m-%d') as dadd,sum(money) as subtotal_tui")->where($where)->group("dadd")->select();
		//dump($data);die;
		$totalCount = count($data);
		$Page = new \Think\Page ( $totalCount,10 );
		$tuikuan_list = $dingdan->field("count(*) as count,taddtime,DATE_FORMAT(taddtime,'%Y-%m-%d') as dadd,sum(money) as subtotal_tui")
					->where($where)
					->group("dadd")
					->limit($Page->firstRow.','.$Page->listRows)
					->order('taddtime desc')
					->select();
		$total = 0;
		foreach ($tuikuan_list as $key => $value) {
			$value['subtotal_tui'] = (float)$value['subtotal_tui'];
			$total += $value['subtotal_tui'];
			$cunkuan_list[] = $value;
		}

		$page = $Page -> show();
		$this->assign('tuikuan_list',$tuikuan_list);
		$this->assign('sum',$total);
		$this->assign('_page', $page);
		$this->assign('datetimepicker', $datetimepicker);
		$this->assign('datetimepicker1', $datetimepicker1);
		$this->display();
	}
    
}