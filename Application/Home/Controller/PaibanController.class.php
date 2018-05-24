<?php

namespace Home\Controller;
use Think\Model;
/**
 * 素材管理控制器
 */
class PaibanController extends HomeController {
	function _initialize() {
		parent::_initialize ();
		
		$act = strtolower ( ACTION_NAME );
		$param = array (
				'mdm' => I ( 'mdm' ) 
		);
		$res ['title'] = '排班发布';
		$res ['url'] = U ( 'paiban_index', $param );
		$res ['class'] = strpos ( $act, 'paiban_index' ) !== false ? 'current' : '';
		$nav [] = $res;

		$res ['title'] = '排班列表';
		$res ['url'] = U ( 'paiban_list', $param );
		$res ['class'] = strpos ( $act, 'paiban_list' ) !== false ? 'current' : '';
		$nav [] = $res;

		$res ['title'] = '统计表';
		$res ['url'] = U ( 'tongji_list', $param );
		$res ['class'] = strpos ( $act, 'tongji_list' ) !== false ? 'current' : '';
		$nav [] = $res;
		
		$this->assign ( 'nav', $nav );
	}
	//加载学员排班发布页面
	public function paiban_index(){
		$this->display();
	}
	//加载驾校排班发布页面
	public function paiban_jiaxiao(){
		$this->display();
	}
	//执行学员排班添加
	public function paiban_add(){
		$paiban = M('paiban');
		// $arr = $_POST;
		$data['data']  = $_POST['control_date'];
		if(!$data['data']){
			$this->error('请先选择时间！');
		}
		$arr = array_splice($_POST,1);
		unset($arr['allChecked']);

		foreach ($arr as $k => $v) {
			foreach ($v as $h => $g) {
				$num = strlen($k);
				if($num == 4){
					$ch = substr($k, -1);
				}else if($num == 5){
					$ch = substr($k, -2);
				}
				$time = $g;
				$list = $paiban->where(array('data'=>$data['data'],'time'=>$time,'ch'=>$ch))->select();
				if($list){
					$this->error('存在已发布过的时间段,请重新选择！');
				}
			}

		}

		foreach ($arr as $k => $v) {
			foreach ($v as $h => $g) {
				$num = strlen($k);
				if($num == 4){
					$ch = substr($k, -1);
				}else if($num == 5){
					$ch = substr($k, -2);
				}
				$data['ch'] = $ch;
				$data['time'] = $g;
				$data['status'] = 0;//0正常，1锁住
				$data['type'] = 0;//0学员预约，1驾校预约
				$list = $paiban->data($data)->add();
			}

		}
		$this->success('发布成功!',U('Paiban/paiban_index',array('mdm'=>$_GET['mdm'])));
	}
	//执行驾校排班添加
	public function paiban_jiaxiao_add(){
		$paiban = M('paiban');
		$data['data']  = $_POST['control_date'];
		if(!$data['data']){
			$this->error('请先选择时间！');
		}
		$arr = array_splice($_POST,1);
		unset($arr['allChecked']);

		foreach ($arr as $k => $v) {
			foreach ($v as $h => $g) {
				$num = strlen($k);
				if($num == 4){
					$ch = substr($k, -1);
				}else if($num == 5){
					$ch = substr($k, -2);
				}
				$time = $g;
				$list = $paiban->where(array('data'=>$data['data'],'time'=>$time,'ch'=>$ch))->select();
				if($list){
					$this->error('存在已发布过的时间段,请重新选择！');
				}
			}

		}
		
		foreach ($arr as $k => $v) {
			foreach ($v as $h => $g) {
				$num = strlen($k);
				if($num == 4){
					$ch = substr($k, -1);
				}else if($num == 5){
					$ch = substr($k, -2);
				}
				$data['ch'] = $ch;
				$data['time'] = $g;
				$data['status'] = 0;//0正常，1锁住
				$data['type'] = 1;//0学员预约，1驾校预约
				$list = $paiban->data($data)->add();
			}

		}
		$this->success('发布成功!',U('Paiban/paiban_jiaxiao',array('mdm'=>$_GET['mdm'])));
	}
	//学员约车排班列表
	public function paiban_list(){
    	header("Content-type:text/html;charset=utf-8");
		$data = I('data');
		$paiban= M('paiban');
		if($data == "+data+"){
			$data = '';
		}
		if($data != ''){
			$where['data'] = $data;
			$where['type'] = 0;
	        $totalCount = $paiban->where($where)->count();
     	 	//$Page = new \Org\Util\Page($totalCount,15);// 导入分页类 
     	 	$Page = new \Think\Page($totalCount,15);
			$paiban_list = $paiban->where($where)->order('id desc')->limit($Page->firstRow.','.$Page->listRows)->select();
		}else{
			$date = date('Y-m-d');
			$where['data'] = array('EGT',"$date");
			$where['type'] = 0;
	        $totalCount = $paiban->where($where)->count();
     	 	//$Page = new \Org\Util\Page($totalCount,15);// 导入分页类 
     	 	$Page = new \Think\Page($totalCount,15);
			$paiban_list = $paiban->order('id desc')->where($where)->limit($Page->firstRow.','.$Page->listRows)->select();
		}
		$page  = $Page->show();// 分页显示输出
		// var_dump($show);die;
		$this->assign('data',$data);
		$this->assign('_page', $page);
		$this->assign('paiban_list',$paiban_list);
		$this->display();
	}

	//驾校约车排班列表
	public function paiban_jiaxiao_list(){
		header("Content-type:text/html;charset=utf-8");
		$data = I('data');
		$paiban= M('paiban');
		if($data == "+data+"){
			$data = '';
		}
		if($data != ''){
			$where['data'] = $data;
			$where['type'] = 1;
	        $totalCount = $paiban->where($where)->count();
     	 	//$Page = new \Org\Util\Page($totalCount,15);// 导入分页类 
     	 	$Page = new \Think\Page($totalCount,15);
			$paiban_list = $paiban->where($where)->order('id desc')->limit($Page->firstRow.','.$Page->listRows)->select();
		}else{
			$date = date('Y-m-d');
			$where['data'] = array('EGT',"$date");
			$where['type'] = 1;
	        $totalCount = $paiban->where($where)->count();
     	 	//$Page = new \Org\Util\Page($totalCount,15);// 导入分页类 
     	 	$Page = new \Think\Page($totalCount,15);
			$paiban_list = $paiban->order('id desc')->where($where)->limit($Page->firstRow.','.$Page->listRows)->select();
		}
		$page  = $Page->show();// 分页显示输出
		// var_dump($show);die;
		$this->assign('data',$data);
		$this->assign('_page', $page);
		$this->assign('paiban_list',$paiban_list);
		$this->display();
	}

	public function paiban_edit(){
		$paiban= M('paiban');
		$id = I('id');
		$mdm = I('mdm');
		$list = $paiban->where(array('id'=>$id))->select();
        $this->assign('list',$list);
		$this->display();
	}
	public function paiban_update(){
		$paiban= M('paiban');
		$id = I('id');
		$data['ch'] = I('ch');
		$data['data'] = I('data');
		$data['time'] = I('time');
		$data['mark'] = I('mark');
        $list = $paiban->where(array('data'=>$data['data'],'time'=>$data['time'],'ch'=>$data['ch']))->select();
        if($list){
        	$this->error('您修改的数据已存在！');
        }
        $list_edit = $paiban->where(array('id'=>$id))->save($data);
        if($list_edit){
        	$this->success('修改成功!',U('Paiban/Paiban_list',array('mdm'=>$_GET['mdm'])));
        }
	}

	// public function paiban_del(){
	// 	$paiban= M('paiban');
	// 	$id = I('id');
	// 	if($id){
	// 		$paiban_del = $paiban->where(array('id'=>$id))->delete();
	// 		if($paiban_del){
	//     		$this->success('删除成功!',U('Paiban/paiban_list',array('mdm'=>$_GET['mdm'])));
	// 		}
	// 	}else{
	// 		$this->error('删除失败,缺少id值!');
	// 	}
	// 	//$this->display();
	// }

	public function paiban_del(){
		$paiban = M('paiban');
		$id = I('id');
		if($id){
			$where1['id']  = $id;
			$where2['pid']  = array('like',"%$id%");
			$paiban_res = $paiban->where($where1)->find();
			$dingdan_res = M('dingdan')->where($where2)->select();

			if(!$dingdan_res && $paiban_res['status'] != 1){
				$paiban_del = $paiban->where(array('id'=>$id))->delete();
				if($paiban_del){
		    		// $this->success('删除成功!',U('Paiban/paiban_list',array('mdm'=>$_GET['mdm'])));
		    		echo 2;die;//删除成功
				}else{
					echo 4;die;//删除失败
				}
			}else{
				echo 1;die;//该时间段已被预约或在退款审核中禁止删除
			}
			
		}else{
			echo 0;die;//删除失败，缺少id值
		}
		//$this->display();
	}


	//多选删除
	public function paiban_select_del(){
		$paiban= M('paiban');
		$del_id = I('del_id');

		foreach ($del_id as $key => $value) {
			$where1['id']  = $value;
			$where2['pid']  = array('like',"%$value%");
			$paiban_res = $paiban->where($where1)->select();
			$dingdan_res = M('dingdan')->where($where2)->select();
			//若排班表状态为1或在订单表有记录禁止删除此时间段
			if($dingdan_res || $paiban_res[0]['status'] == 1){
				$del_res = 1;
			}
		}
		if($del_res == 1){
			echo 1;die;//所选时间段已被预约或在退款审核中禁止删除
		}else{
			if($del_id){
				$where['id']=array('in',$del_id);  //批量删除的正确方法
				$paiban_del = $paiban->where($where)->delete(); 
				if($paiban_del){
		    		echo 2;die;//删除成功
				}else{
					echo 4;die;//删除失败
				}
			}else{
				echo 0;die;//删除失败，缺少id值
			}
		}
		
	}
	//统计表(学员预约)
	public function tongji_list(){
		$tongji  = M('paiban');
		$data = I('data');
		// $sql = "SELECT `data`,`ch`,`times`,GROUP_CONCAT(`time`) as fabushijian from (select `data`, CONCAT(`data`,'_', `ch`) times,ch,`time` from wp_paiban) t where 1 GROUP BY times ORDER BY `data`";
		// $sql = "SELECT `data`,`ch`,`times`,GROUP_CONCAT(`time`) as yuyueshijian from (select `data`, CONCAT(`data`,'_', `ch`) times,ch,`time` from wp_paiban where `status` = 1 ) t where 1 GROUP BY times ORDER BY `data`";
		if($data){
				// $sql = "select fabu.`data`,fabu.`ch`,fabushijian,yuyueshijian from (SELECT `data`,`ch`,`times`,GROUP_CONCAT(`time`) as fabushijian from (select `data`, CONCAT(`data`,'_', `ch`) times,ch,`time` from wp_paiban) fa where `data`='".$data."' GROUP BY times ORDER BY `data` desc) as fabu LEFT JOIN (SELECT `pdata`,`pch`,`ptimes`,GROUP_CONCAT(`ptime`) as yuyueshijian from (select `pdata`, CONCAT(`pdata`,'_', `pch`) ptimes,pch,`ptime` from wp_dingdan) yu where 1 GROUP BY ptimes ORDER BY `pdata` desc) as yuyue on fabu.times=yuyue.ptimes";
				
				$sql = "select fabu.`data`,fabu.`ch`,fabushijian,yuyueshijian from (SELECT `data`,`ch`,`times`,GROUP_CONCAT(`time`) as fabushijian from (select `data`, CONCAT(`data`,'_', `ch`) times,ch,`time` from wp_paiban where `data`='".$data."' and `type` = 0) fa GROUP BY times ORDER BY `data` desc) as fabu LEFT JOIN (SELECT `data`,`ch`,`times`,GROUP_CONCAT(`time`) as yuyueshijian from (select `data`, CONCAT(`data`,'_', `ch`) times,ch,`time` from wp_paiban where `status` = 1 and `type` = 0) yu where `data`='".$data."' GROUP BY times ORDER BY `data` desc) as yuyue on fabu.times=yuyue.times";

				$totalCount = $tongji->execute($sql);
	     	 	//$Page = new \Org\Util\Page($totalCount,15);// 导入分页类 
	     	 	$Page = new \Think\Page($totalCount,10);
	     	 	$firstrow = $Page->firstRow;
	     	 	$listrow = $Page->listRows;

	     	 	// $sql = "select fabu.`data`,fabu.`ch`,fabushijian,yuyueshijian from (SELECT `data`,`ch`,`times`,GROUP_CONCAT(`time`) as fabushijian from (select `data`, CONCAT(`data`,'_', `ch`) times,ch,`time` from wp_paiban) fa where `data`='".$data."' GROUP BY times ORDER BY `data` desc) as fabu LEFT JOIN (SELECT `pdata`,`pch`,`ptimes`,GROUP_CONCAT(`ptime`) as yuyueshijian from (select `pdata`, CONCAT(`pdata`,'_', `pch`) ptimes,pch,`ptime` from wp_dingdan) yu where 1 GROUP BY ptimes ORDER BY `pdata` desc) as yuyue on fabu.times=yuyue.ptimes limit ".$firstrow.",".$listrow;

	     	 	$sql = "select fabu.`data`,fabu.`ch`,fabushijian,yuyueshijian from (SELECT `data`,`ch`,`times`,GROUP_CONCAT(`time`) as fabushijian from (select `data`, CONCAT(`data`,'_', `ch`) times,ch,`time` from wp_paiban where `data`='".$data."' and `type` = 0) fa GROUP BY times ORDER BY `data` desc) as fabu LEFT JOIN (SELECT `data`,`ch`,`times`,GROUP_CONCAT(`time`) as yuyueshijian from (select `data`, CONCAT(`data`,'_', `ch`) times,ch,`time` from wp_paiban where `status` = 1 and `type` = 0) yu where `data`='".$data."' GROUP BY times ORDER BY `data` desc) as yuyue on fabu.times=yuyue.times limit ".$firstrow.",".$listrow;
		}else{
			$sql = "select fabu.`data`,fabu.`ch`,fabushijian,yuyueshijian from (SELECT `data`,`ch`,`times`,GROUP_CONCAT(`time`) as fabushijian from (select `data`, CONCAT(`data`,'_', `ch`) times,ch,`time` from wp_paiban where `type` = 1) fa where 1 GROUP BY times ORDER BY `data` desc) as fabu LEFT JOIN (SELECT `data`,`ch`,`times`,GROUP_CONCAT(`time`) as yuyueshijian from (select `data`, CONCAT(`data`,'_', `ch`) times,ch,`time` from wp_paiban where `status` = 1 and `type` = 0) yu where 1 GROUP BY times ORDER BY `data` desc) as yuyue on fabu.times=yuyue.times;";


			$totalCount = $tongji->execute($sql);
     	 	//$Page = new \Org\Util\Page($totalCount,15);// 导入分页类 
     	 	$Page = new \Think\Page($totalCount,10);
     	 	$firstrow = $Page->firstRow;
     	 	$listrow = $Page->listRows;
     	 	$sql = "select fabu.`data`,fabu.`ch`,fabushijian,yuyueshijian from (SELECT `data`,`ch`,`times`,GROUP_CONCAT(`time`) as fabushijian from (select `data`, CONCAT(`data`,'_', `ch`) times,ch,`time` from wp_paiban where `type` = 0) fa where 1 GROUP BY times ORDER BY `data` desc) as fabu LEFT JOIN (SELECT `data`,`ch`,`times`,GROUP_CONCAT(`time`) as yuyueshijian from (select `data`, CONCAT(`data`,'_', `ch`) times,ch,`time` from wp_paiban where `status` = 1 and `type` = 0) yu where 1 GROUP BY times ORDER BY `data` desc) as yuyue on fabu.times=yuyue.times limit ".$firstrow.",".$listrow;
		}
		
		//$tongji_list = $tongji->query($sql);
		//$tongji_list = $tongji->execute($sql);
		
		$tongji_list = $tongji->query($sql);
		foreach ($tongji_list as $key => $value) {

			$tongji_list[$key]['shichang'] = substr_count($value['yuyueshijian'],',');
			// if($value['yuyueshijian'] == null){
			// 	$tongji_list[$key]['shichang'] = 0;
			// }else{
			// 	$tongji_list[$key]['shichang'] = substr_count($value['yuyueshijian'],',') + 1;
			// }

			$tongji_list[$key]['fabu'] = explode(',',$value['fabushijian']);
			$tongji_list[$key]['yuyue'] = explode(',',$value['yuyueshijian']);

			//删除发布时间段中预约过的时间段
			foreach($tongji_list[$key]['fabu'] as $k=>$v){
		        foreach($tongji_list[$key]['yuyue'] as $kk=>$vv){
		            if($v == $vv){
		               unset($tongji_list[$key]['fabu'][$k]);
		            }
		        }
		    }

		    //发布时长
			if($value['fabushijian'] == null){
				$tongji_list[$key]['fbshichang'] = 0;
			}else{
				$tongji_list[$key]['fbshichang'] = substr_count($value['fabushijian'],',') + 1;
			}

		    //预约时长
			if($value['yuyueshijian'] == null){
				$tongji_list[$key]['shichang'] = 0;
			}else{
				$tongji_list[$key]['shichang'] = substr_count($value['yuyueshijian'],',') + 1;
			}

		}
		// dump($tongji_list);
		$page  = $Page->show();// 分页显示输出
		$this->assign('tongji_list',$tongji_list);
		$this->assign('data',$data);
		$this->assign('_page', $page);
		$this->display();
	}

	//统计表(驾校预约)
	public function tongji_jiaxiao_list(){
		$tongji  = M('paiban');
		$data = I('data');
		// $sql = "SELECT `data`,`ch`,`times`,GROUP_CONCAT(`time`) as fabushijian from (select `data`, CONCAT(`data`,'_', `ch`) times,ch,`time` from wp_paiban) t where 1 GROUP BY times ORDER BY `data`";
		// $sql = "SELECT `data`,`ch`,`times`,GROUP_CONCAT(`time`) as yuyueshijian from (select `data`, CONCAT(`data`,'_', `ch`) times,ch,`time` from wp_paiban where `status` = 1 ) t where 1 GROUP BY times ORDER BY `data`";
		if($data){
				// $sql = "select fabu.`data`,fabu.`ch`,fabushijian,yuyueshijian from (SELECT `data`,`ch`,`times`,GROUP_CONCAT(`time`) as fabushijian from (select `data`, CONCAT(`data`,'_', `ch`) times,ch,`time` from wp_paiban) fa where `data`='".$data."' GROUP BY times ORDER BY `data` desc) as fabu LEFT JOIN (SELECT `pdata`,`pch`,`ptimes`,GROUP_CONCAT(`ptime`) as yuyueshijian from (select `pdata`, CONCAT(`pdata`,'_', `pch`) ptimes,pch,`ptime` from wp_dingdan) yu where 1 GROUP BY ptimes ORDER BY `pdata` desc) as yuyue on fabu.times=yuyue.ptimes";
				
				$sql = "select fabu.`data`,fabu.`ch`,fabushijian,yuyueshijian from (SELECT `data`,`ch`,`times`,GROUP_CONCAT(`time`) as fabushijian from (select `data`, CONCAT(`data`,'_', `ch`) times,ch,`time` from wp_paiban where `data`='".$data."' and `type` = 1) fa GROUP BY times ORDER BY `data` desc) as fabu LEFT JOIN (SELECT `data`,`ch`,`times`,GROUP_CONCAT(`time`) as yuyueshijian from (select `data`, CONCAT(`data`,'_', `ch`) times,ch,`time` from wp_paiban where `status` = 1 and `type` = 1) yu where `data`='".$data."' GROUP BY times ORDER BY `data` desc) as yuyue on fabu.times=yuyue.times";

				$totalCount = $tongji->execute($sql);
	     	 	//$Page = new \Org\Util\Page($totalCount,15);// 导入分页类 
	     	 	$Page = new \Think\Page($totalCount,10);
	     	 	$firstrow = $Page->firstRow;
	     	 	$listrow = $Page->listRows;

	     	 	// $sql = "select fabu.`data`,fabu.`ch`,fabushijian,yuyueshijian from (SELECT `data`,`ch`,`times`,GROUP_CONCAT(`time`) as fabushijian from (select `data`, CONCAT(`data`,'_', `ch`) times,ch,`time` from wp_paiban) fa where `data`='".$data."' GROUP BY times ORDER BY `data` desc) as fabu LEFT JOIN (SELECT `pdata`,`pch`,`ptimes`,GROUP_CONCAT(`ptime`) as yuyueshijian from (select `pdata`, CONCAT(`pdata`,'_', `pch`) ptimes,pch,`ptime` from wp_dingdan) yu where 1 GROUP BY ptimes ORDER BY `pdata` desc) as yuyue on fabu.times=yuyue.ptimes limit ".$firstrow.",".$listrow;

	     	 	$sql = "select fabu.`data`,fabu.`ch`,fabushijian,yuyueshijian from (SELECT `data`,`ch`,`times`,GROUP_CONCAT(`time`) as fabushijian from (select `data`, CONCAT(`data`,'_', `ch`) times,ch,`time` from wp_paiban where `data`='".$data."' and `type` = 1) fa GROUP BY times ORDER BY `data` desc) as fabu LEFT JOIN (SELECT `data`,`ch`,`times`,GROUP_CONCAT(`time`) as yuyueshijian from (select `data`, CONCAT(`data`,'_', `ch`) times,ch,`time` from wp_paiban where `status` = 1 and `type` = 1) yu where `data`='".$data."' GROUP BY times ORDER BY `data` desc) as yuyue on fabu.times=yuyue.times limit ".$firstrow.",".$listrow;
		}else{
			$sql = "select fabu.`data`,fabu.`ch`,fabushijian,yuyueshijian from (SELECT `data`,`ch`,`times`,GROUP_CONCAT(`time`) as fabushijian from (select `data`, CONCAT(`data`,'_', `ch`) times,ch,`time` from wp_paiban where `type` = 1) fa where 1 GROUP BY times ORDER BY `data` desc) as fabu LEFT JOIN (SELECT `data`,`ch`,`times`,GROUP_CONCAT(`time`) as yuyueshijian from (select `data`, CONCAT(`data`,'_', `ch`) times,ch,`time` from wp_paiban where `status` = 1 and `type` = 1) yu where 1 GROUP BY times ORDER BY `data` desc) as yuyue on fabu.times=yuyue.times;";


			$totalCount = $tongji->execute($sql);
     	 	//$Page = new \Org\Util\Page($totalCount,15);// 导入分页类 
     	 	$Page = new \Think\Page($totalCount,10);
     	 	$firstrow = $Page->firstRow;
     	 	$listrow = $Page->listRows;
     	 	$sql = "select fabu.`data`,fabu.`ch`,fabushijian,yuyueshijian from (SELECT `data`,`ch`,`times`,GROUP_CONCAT(`time`) as fabushijian from (select `data`, CONCAT(`data`,'_', `ch`) times,ch,`time` from wp_paiban where `type` = 1) fa where 1 GROUP BY times ORDER BY `data` desc) as fabu LEFT JOIN (SELECT `data`,`ch`,`times`,GROUP_CONCAT(`time`) as yuyueshijian from (select `data`, CONCAT(`data`,'_', `ch`) times,ch,`time` from wp_paiban where `status` = 1 and `type` = 1) yu where 1 GROUP BY times ORDER BY `data` desc) as yuyue on fabu.times=yuyue.times limit ".$firstrow.",".$listrow;
		}
		//echo $sql;
		//$tongji_list = $tongji->query($sql);
		//$tongji_list = $tongji->execute($sql);
		
		$tongji_list = $tongji->query($sql);
		foreach ($tongji_list as $key => $value) {

			$tongji_list[$key]['shichang'] = substr_count($value['yuyueshijian'],',');
			// if($value['yuyueshijian'] == null){
			// 	$tongji_list[$key]['shichang'] = 0;
			// }else{
			// 	$tongji_list[$key]['shichang'] = substr_count($value['yuyueshijian'],',') + 1;
			// }

			$tongji_list[$key]['fabu'] = explode(',',$value['fabushijian']);
			$tongji_list[$key]['yuyue'] = explode(',',$value['yuyueshijian']);

			//删除发布时间段中预约过的时间段
			foreach($tongji_list[$key]['fabu'] as $k=>$v){
		        foreach($tongji_list[$key]['yuyue'] as $kk=>$vv){
		            if($v == $vv){
		               unset($tongji_list[$key]['fabu'][$k]);
		            }
		        }
		    }

		    //发布时长
			if($value['fabushijian'] == null){
				$tongji_list[$key]['fbshichang'] = 0;
			}else{
				$tongji_list[$key]['fbshichang'] = substr_count($value['fabushijian'],',') + 1;
			}

		    //预约时长
			if($value['yuyueshijian'] == null){
				$tongji_list[$key]['shichang'] = 0;
			}else{
				$tongji_list[$key]['shichang'] = substr_count($value['yuyueshijian'],',') + 1;
			}

		}
		// dump($tongji_list);
		$page  = $Page->show();// 分页显示输出
		$this->assign('tongji_list',$tongji_list);
		$this->assign('data',$data);
		$this->assign('_page', $page);
		$this->display();
	}

	//统计详情
	public function tongji_xq(){
		$tongji  = M('paiban');
		$data = I('data');
		$ch = I('ch');
		$sql = "select fabu.`data`,fabu.`ch`,fabushijian,yuyueshijian from (SELECT `data`,`ch`,`times`,GROUP_CONCAT(`time`) as fabushijian from (select `data`, CONCAT(`data`,'_', `ch`) times,ch,`time` from wp_paiban) fa where `data`='".$data."' AND `ch`= '".$ch."' GROUP BY times ORDER BY `data`) as fabu LEFT JOIN (SELECT `data`,`ch`,`times`,GROUP_CONCAT(`time`) as yuyueshijian from (select `data`, CONCAT(`data`,'_', `ch`) times,ch,`time` from wp_paiban where `status` = 1) yu where `data`='".$data."' AND `ch`= '".$ch."' GROUP BY times ORDER BY `data`) as yuyue on fabu.times=yuyue.times";
		//echo $sql;die;

		$tongji_xq = $tongji->query($sql);
		
		//计算预约时长
		if($tongji_xq[0]['yuyueshijian'] == null){
			$tongji_xq[0]['shichang'] = 0;
		}else{
			$tongji_xq[0]['shichang'] = substr_count($tongji_xq[0]['yuyueshijian'],',') + 1;
		}
		// dump($tongji_xq);die;
		$this->assign('list',$tongji_xq);
		$this->display();
	}
	
}