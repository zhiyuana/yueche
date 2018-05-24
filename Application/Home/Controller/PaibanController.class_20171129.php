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
	
	public function paiban_index(){
		// $paiban = M('paiban');
		// $data = date('Y-m-d',time());
		// $list = $paiban->where(array('data'=>$data)) -> select();
		// dump($list);
		$this->display();
	}


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
				$data['status'] = 0;
				$list = $paiban->data($data)->add();
			}

		}
		$this->success('发布成功!',U('Paiban/paiban_index',array('mdm'=>$_GET['mdm'])));
	}

	public function paiban_list(){
    	header("Content-type:text/html;charset=utf-8");
		$data = I('data');
		$paiban= M('paiban');
		if($data == "+data+"){
			$data = '';
		}
		if($data != ''){
			$where['data'] = $data;
	        $totalCount = $paiban->where($where)->count();
     	 	//$Page = new \Org\Util\Page($totalCount,15);// 导入分页类 
     	 	$Page = new \Think\Page($totalCount,15);
			$paiban_list = $paiban->where($where)->order('id desc')->limit($Page->firstRow.','.$Page->listRows)->select();
		}else{
			$date = date('Y-m-d');
			$where['data'] = array('EGT',"$date");
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

		public function paiban_del(){
			$paiban= M('paiban');
			$id = I('id');
			if($id){
				$paiban_del = $paiban->where(array('id'=>$id))->delete();
				if($paiban_del){
		    		$this->success('删除成功!',U('Paiban/paiban_list',array('mdm'=>$_GET['mdm'])));
				}
			}else{
				$this->error('删除失败,缺少id值!');
			}
			//$this->display();
		}
		//多选删除
		public function paiban_select_del(){
			$paiban= M('paiban');
			$del_id = I('del_id');
			// $this->ajaxReturn($del_id,'JSON');
			if($del_id){
				//$paiban_del = $paiban->where(array('id'=>$id))->delete();
				$where['id']=array('in',$del_id);  //批量删除的正确方法
				$paiban_del = $paiban->where($where)->delete(); 
				if($paiban_del){
		    		//$this->success('删除成功!',U('Paiban/paiban_list',array('mdm'=>$_GET['mdm'])));
		    		echo 1;die;//删除成功
				}
			}else{
				//$this->error('删除失败,缺少id值!');
				echo 0;die;//删除失败
			}
		}
		//统计表
		public function tongji_list(){
			$tongji  = M('paiban');
			$data = I('data');
			// $sql = "SELECT `data`,`ch`,`times`,GROUP_CONCAT(`time`) as fabushijian from (select `data`, CONCAT(`data`,'_', `ch`) times,ch,`time` from wp_paiban) t where 1 GROUP BY times ORDER BY `data`";
			// $sql = "SELECT `data`,`ch`,`times`,GROUP_CONCAT(`time`) as yuyueshijian from (select `data`, CONCAT(`data`,'_', `ch`) times,ch,`time` from wp_paiban where `status` = 1 ) t where 1 GROUP BY times ORDER BY `data`";
			if($data){
					// $sql = "select fabu.`data`,fabu.`ch`,fabushijian,yuyueshijian from (SELECT `data`,`ch`,`times`,GROUP_CONCAT(`time`) as fabushijian from (select `data`, CONCAT(`data`,'_', `ch`) times,ch,`time` from wp_paiban) fa where `data`='".$data."' GROUP BY times ORDER BY `data` desc) as fabu LEFT JOIN (SELECT `pdata`,`pch`,`ptimes`,GROUP_CONCAT(`ptime`) as yuyueshijian from (select `pdata`, CONCAT(`pdata`,'_', `pch`) ptimes,pch,`ptime` from wp_dingdan) yu where 1 GROUP BY ptimes ORDER BY `pdata` desc) as yuyue on fabu.times=yuyue.ptimes";
					
					$sql = "select fabu.`data`,fabu.`ch`,fabushijian,yuyueshijian from (SELECT `data`,`ch`,`times`,GROUP_CONCAT(`time`) as fabushijian from (select `data`, CONCAT(`data`,'_', `ch`) times,ch,`time` from wp_paiban where `data`='".$data."') fa GROUP BY times ORDER BY `data` desc) as fabu LEFT JOIN (SELECT `data`,`ch`,`times`,GROUP_CONCAT(`time`) as yuyueshijian from (select `data`, CONCAT(`data`,'_', `ch`) times,ch,`time` from wp_paiban where `status` = 1) yu where `data`='".$data."' GROUP BY times ORDER BY `data` desc) as yuyue on fabu.times=yuyue.times";

					$totalCount = $tongji->execute($sql);
		     	 	//$Page = new \Org\Util\Page($totalCount,15);// 导入分页类 
		     	 	$Page = new \Think\Page($totalCount,5);
		     	 	$firstrow = $Page->firstRow;
		     	 	$listrow = $Page->listRows;

		     	 	// $sql = "select fabu.`data`,fabu.`ch`,fabushijian,yuyueshijian from (SELECT `data`,`ch`,`times`,GROUP_CONCAT(`time`) as fabushijian from (select `data`, CONCAT(`data`,'_', `ch`) times,ch,`time` from wp_paiban) fa where `data`='".$data."' GROUP BY times ORDER BY `data` desc) as fabu LEFT JOIN (SELECT `pdata`,`pch`,`ptimes`,GROUP_CONCAT(`ptime`) as yuyueshijian from (select `pdata`, CONCAT(`pdata`,'_', `pch`) ptimes,pch,`ptime` from wp_dingdan) yu where 1 GROUP BY ptimes ORDER BY `pdata` desc) as yuyue on fabu.times=yuyue.ptimes limit ".$firstrow.",".$listrow;

		     	 	$sql = "select fabu.`data`,fabu.`ch`,fabushijian,yuyueshijian from (SELECT `data`,`ch`,`times`,GROUP_CONCAT(`time`) as fabushijian from (select `data`, CONCAT(`data`,'_', `ch`) times,ch,`time` from wp_paiban where `data`='".$data."') fa GROUP BY times ORDER BY `data` desc) as fabu LEFT JOIN (SELECT `data`,`ch`,`times`,GROUP_CONCAT(`time`) as yuyueshijian from (select `data`, CONCAT(`data`,'_', `ch`) times,ch,`time` from wp_paiban where `status` = 1) yu where `data`='".$data."' GROUP BY times ORDER BY `data` desc) as yuyue on fabu.times=yuyue.times limit ".$firstrow.",".$listrow;
			}else{
				$sql = "select fabu.`data`,fabu.`ch`,fabushijian,yuyueshijian from (SELECT `data`,`ch`,`times`,GROUP_CONCAT(`time`) as fabushijian from (select `data`, CONCAT(`data`,'_', `ch`) times,ch,`time` from wp_paiban) fa where 1 GROUP BY times ORDER BY `data` desc) as fabu LEFT JOIN (SELECT `data`,`ch`,`times`,GROUP_CONCAT(`time`) as yuyueshijian from (select `data`, CONCAT(`data`,'_', `ch`) times,ch,`time` from wp_paiban where `status` = 1) yu where 1 GROUP BY times ORDER BY `data` desc) as yuyue on fabu.times=yuyue.times;";


				$totalCount = $tongji->execute($sql);
	     	 	//$Page = new \Org\Util\Page($totalCount,15);// 导入分页类 
	     	 	$Page = new \Think\Page($totalCount,10);
	     	 	$firstrow = $Page->firstRow;
	     	 	$listrow = $Page->listRows;
	     	 	$sql = "select fabu.`data`,fabu.`ch`,fabushijian,yuyueshijian from (SELECT `data`,`ch`,`times`,GROUP_CONCAT(`time`) as fabushijian from (select `data`, CONCAT(`data`,'_', `ch`) times,ch,`time` from wp_paiban) fa where 1 GROUP BY times ORDER BY `data` desc) as fabu LEFT JOIN (SELECT `data`,`ch`,`times`,GROUP_CONCAT(`time`) as yuyueshijian from (select `data`, CONCAT(`data`,'_', `ch`) times,ch,`time` from wp_paiban where `status` = 1) yu where 1 GROUP BY times ORDER BY `data` desc) as yuyue on fabu.times=yuyue.times limit ".$firstrow.",".$listrow;
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