<?php

namespace Home\Controller;
use Think\Model;
/**
 * 素材管理控制器
 */
class JiaxiaoController extends HomeController {
	function _initialize() {
		parent::_initialize ();
		
		$act = strtolower ( ACTION_NAME );
		$param = array (
				'mdm' => I ( 'mdm' ) 
		);
		$res ['title'] = '驾校列表';
		$res ['url'] = U ( 'jiaolian_list', $param );
		$res ['class'] = strpos ( $act, 'jiaxiao_list' ) !== false ? 'current' : '';
		$nav [] = $res;
		
		$this->assign ( 'nav', $nav );
	}
	

	//驾校列表页面
	public function jiaxiao_list(){
		$jx_name = I('jx_name');
		if($jx_name){
			$where['jxname'] = array('like',"%$jx_name%");
		}
		$jiaxiao= M('jiaxiao');
		$totalCount = $jiaxiao->where($where)->count();
		$Page = new \Think\Page ( $totalCount,15 );
		$Page->setConfig ( 'theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%' );
		//$jiaxiao_list = $jiaxiao->where($where)->limit($Page->firstRow.','.$Page->listRows)->order('id desc')->select();
		$jiaxiao_list = $jiaxiao->table('wp_jiaxiao jx')
					  ->join('wp_jiaolian jl on jl.jxid = jx.id')
		              ->where($where)
		              ->field("*,jx.id as id,count('jl.jxid') as num")
		              ->group('jl.jxid')
		              ->limit($Page->firstRow.','.$Page->listRows)
		              ->order('jx.id desc')
		              ->select();
		// dump($jiaxiao_list);die;
		$page  = $Page->show();// 分页显示输出
		$this->assign('_page', $page);
		$this->assign('jiaxiao_list',$jiaxiao_list);
		$this->assign('jx_name',$jx_name);
		$this->display();
	}


	public function jiaxiao_edit(){
		$jiaxiao= M('jiaxiao');
		$id = I('id');
		$mdm = I('mdm');
		$list = $jiaxiao->where(array('id'=>$id))->select();
        $this->assign('list',$list);
		$this->display();
	}
	
	public function jiaolian_look(){
		$jiaolian= M('jiaolian');
		$id = I('id');
		$mdm = I('mdm');
		$list = $jiaolian->where(array('id'=>$id))->select();
		$jimage=json_decode($list[0]['jimage'],true);
        $this->assign('list',$list);
        $this->assign('jimage',$jimage);
		$this->display();
	}

	public function jiaxiao_update(){
		$jiaxiao= M('jiaxiao');
		$id = I('id');
		$data['jxname'] = I('jxname');
		$data['jxfname'] = I('jxfname');
		$data['jxphone'] = I('jxphone');
		if($id){
		  $where['id'] = $id;
   		  $list_edit = $jiaxiao->where($where)->save($data);
		}
        if($list_edit){
        	$this->success('修改成功!',U('Jiaxiao/jiaxiao_list',array('mdm'=>$_GET['mdm'])));
        }
	}

	public function jiaxiao_add(){
		$this->display();
	}

	public function jiaxiao_insert(){
		$data['jxname'] = I('jxname');
		$data['jxfname'] = I('jxfname');
		$data['jxphone'] = I('jxphone');
		$jiaxiao = M('jiaxiao');
	    $list_add = $jiaxiao->add($data);
	    if($list_add){
	    	$this->success('添加成功!',U('Jiaxiao/jiaxiao_list',array('mdm'=>$_GET['mdm'])));
	    }else{
	    	$this->error('添加失败!');
	    }
	
}

	//上传图片
	public function upload(){
		$upload = new \Think\Upload();// 实例化上传类
		$upload->maxSize   =     3145728 ;// 设置附件上传大小
		$upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
		//$upload->rootPath  =     './Uploads/'; // 设置附件上传根目录
		$upload->savePath  =     './Uploads/yueche/jiaolian/'; // 设置附件上传（子）目录
		$info   =   $upload->upload();
		if($info){
			foreach ($info as $k => $v) {
				$path = './Uploads'.ltrim($v['savepath'],'.').$v['savename'];
			}
			$result['status'] = 1;
			$result['url'] = $path;
	        $this->ajaxReturn($result);
		}else{
			// 上传错误提示错误信息
			$result['status'] = 0;
	        $result['msg'] = "请重新上传图片！";
	        $this->ajaxReturn($result);
		}
	}

	public function jiaxiao_del(){
		$jiaxiao= M('jiaxiao');
		$id = I('id');
		if($id){
			$where['id'] = $id;
			$where_jl['jxid'] = $id;
			$jiaolian = M('jiaolian');
			$jx_jiaolian = $jiaolian->where($where_jl)->delete();
			$jiaxiao_del = $jiaxiao->where($where)->delete();
			if($jiaxiao_del && $jx_jiaolian){
	    		$this->success('删除成功!',U('Jiaxiao/jiaxiao_list',array('mdm'=>$_GET['mdm'])));

			}
		}else{
			$this->error('删除失败,缺少id值!');
		}
	}

    
}