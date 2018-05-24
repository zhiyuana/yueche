<?php

namespace Home\Controller;
use Think\Model;
/**
 * 素材管理控制器
 */
class JiaolianController extends HomeController {
	function _initialize() {
		parent::_initialize ();
		
		$act = strtolower ( ACTION_NAME );
		$param = array (
				'mdm' => I ( 'mdm' ) 
		);
		$res ['title'] = '教练列表';
		$res ['url'] = U ( 'jiaolian_list', $param );
		$res ['class'] = strpos ( $act, 'jiaolian_list' ) !== false ? 'current' : '';
		$nav [] = $res;
		
		$this->assign ( 'nav', $nav );
	}
	

	//教练列表页面
	public function jiaolian_list(){
		$jl_name = I('jl_name');
		if($jl_name){
			$where['jname'] = array('like',"%$jl_name%");
		}
		$jiaolian= M('jiaolian');
		$totalCount = $jiaolian->table('wp_jiaolian jl')
						->join('wp_jiaxiao jx on jl.jxid = jx.id')
						->field('*,jl.id as id')
						->where($where)
						->count();
		$Page = new \Think\Page ( $totalCount,15 );
		$Page->setConfig ( 'theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%' );
		$jiaolian_list = $jiaolian->table('wp_jiaolian jl')
						->join('wp_jiaxiao jx on jl.jxid = jx.id')
						->field('*,jl.id as id')
						->where($where)
						->limit($Page->firstRow.','.$Page->listRows)
						->order('jl.id desc')
						->select();
		for($i = 0;$i < count($jiaolian_list);$i++){
		    if($jiaolian_list[$i]['jsex'] == 1){
		        $jiaolian_list[$i]['jsex'] = '男';
		    }
		    if($jiaolian_list[$i]['jsex'] == 2){
		        $jiaolian_list[$i]['jsex'] = '女';
		    }
		}
		$page  = $Page->show();// 分页显示输出
		$this->assign('_page', $page);
		$this->assign('jiaolian_list',$jiaolian_list);
		$this->assign('jl_name',$jl_name);
		$this->display();
	}


	public function jiaolian_edit(){
		$jiaolian= M('jiaolian');
		$id = I('id');
		$mdm = I('mdm');
		$where['jl.id'] = $id;
		$list = $jiaolian->table('wp_jiaolian jl')
		->join('wp_jiaxiao jx on jx.id = jl.jxid')
		->field('*,jl.id as id')
		->where($where)
		->select();
        $this->assign('list',$list);
		$this->display();
	}
	
	public function jiaolian_look(){
		$jiaolian= M('jiaolian');
		$id = I('id');
		$mdm = I('mdm');
		$where['jl.id'] = $id;
		$list = $jiaolian->table('wp_jiaolian jl')
		->join('wp_jiaxiao jx on jx.id = jl.jxid')
		->field('*,jl.id as id')
		->where($where)
		->select();
		$jimage=json_decode($list[0]['jimage'],true);
        $this->assign('list',$list);
        $this->assign('jimage',$jimage);
		$this->display();
	}



	public function jiaolian_add(){
		$jiaxiao = M('jiaxiao');
		$list = $jiaxiao->select();
		$this->assign('list',$list);
		$this->display();
	}
	/**
		  * 图片上传
		  */
	public function jiaolian_insert(){
		// dump($_POST);
		// dump($_FILES);
		// die;
		$img['card'] = I('card_path');
		$img['jiashi'] = I('jiashi_path');
		$img['jiaolian'] = I('jiaolian_path');
		$images =  json_encode($img);
		$jiaolian = M('jiaolian');
		$data['jname'] = I('jname');
		$data['jxid'] = I('jxid');
		$data['jsex'] = I('jsex');
		$data['jage'] = I('jage');
		$data['jphone'] = I('jphone');
		$data['jcard'] = I('jcard');
		$data['tbh'] = I('tbh');
		$data['jbh'] = I('jbh');
		$data['jl'] = I('jl');
		$data['jimage'] = $images;
		$data['jmark'] = I('jmark');
	    $list_add = $jiaolian->add($data);
	    if($list_add){
	    	$this->success('添加成功!',U('Jiaolian/jiaolian_list',array('mdm'=>$_GET['mdm'])));
	    }else{
	    	$this->error('添加失败!');
	    }
	}

	public function jiaolian_update(){
		$jiaolian= M('jiaolian');
		$img['card'] = I('card_path');
		$img['jiashi'] = I('jiashi_path');
		$img['jiaolian'] = I('jiaolian_path');
		$id = I('id');
		$images =  json_encode($img);
		$jiaolian = M('jiaolian');
		$data['jname'] = I('jname');
		$data['jxid'] = I('jxid');
		$data['jsex'] = I('jsex');
		$data['jage'] = I('jage');
		$data['jphone'] = I('jphone');
		$data['jcard'] = I('jcard');
		$data['tbh'] = I('tbh');
		$data['jbh'] = I('jbh');
		$data['jl'] = I('jl');
		$data['jimage'] = $images;
		$data['jmark'] = I('jmark');
		$where['id'] = $id;
        $list_edit = $jiaolian->where($where)->save($data);
        if($list_edit){
        	$this->success('修改成功！',U('Jiaolian/jiaolian_list',array('mdm'=>$_GET['mdm'])));
        }else{
        	$this->error('修改失败！');
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

	public function jiaolian_del(){
		$jiaolian= M('jiaolian');
		$id = I('id');
		if($id){
			$jiaolian_del = $jiaolian->where(array('id'=>$id))->delete();
			if($jiaolian_del){
	    		$this->success('删除成功!',U('Jiaolian/jiaolian_list',array('mdm'=>$_GET['mdm'])));

			}
		}else{
			$this->error('删除失败,缺少id值!');
		}
	}

    
}