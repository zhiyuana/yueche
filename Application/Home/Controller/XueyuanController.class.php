<?php

namespace Home\Controller;
use Think\Model;
/**
 * 素材管理控制器
 */
class XueyuanController extends HomeController {
	function _initialize() {
		parent::_initialize ();
		
		$act = strtolower ( ACTION_NAME );
		$param = array (
				'mdm' => I ( 'mdm' ) 
		);
		$res ['title'] = '学员管理';
		$res ['url'] = U ( 'xueyuan_list', $param );
		$res ['class'] = strpos ( $act, 'xueyuan_list' ) !== false ? 'current' : '';
		$nav [] = $res;
		
		$this->assign ( 'nav', $nav );
	}
	

	//教练列表页面
	public function xueyuan_list(){
		$xy_name = I('xy_name');
		if($xy_name){
			$where['xname'] = array('like',"%$xy_name%");
		}
		$xueyuan= M('xueyuan');
		$totalCount = $xueyuan->where($where)->count();
		$Page = new \Think\Page ( $totalCount,15 );
		$Page->setConfig ( 'theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%' );
		$xueyuan_list = $xueyuan->where($where)->limit($Page->firstRow.','.$Page->listRows)->order('id desc')->select();
		for($i = 0;$i < count($xueyuan_list);$i++){
		    if($xueyuan_list[$i]['xsex'] == 1){
		        $xueyuan_list[$i]['xsex'] = '男';
		    }
		    if($xueyuan_list[$i]['xsex'] == 2){
		        $xueyuan_list[$i]['xsex'] = '女';
		    }
		}
		$page  = $Page->show();// 分页显示输出
		$this->assign('_page', $page);
		$this->assign('xueyuan_list',$xueyuan_list);
		$this->assign('xy_name',$xy_name);
		$this->display();
	}


	public function xueyuan_edit(){
		$xueyuan= M('xueyuan');
		$id = I('id');
		$mdm = I('mdm');
		$list = $xueyuan->where(array('id'=>$id))->select();
        $this->assign('list',$list);
		$this->display();
	}

	public function xueyuan_update(){
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
        	$this->success('修改成功!',U('xueyuan/xueyuan_list',array('mdm'=>$_GET['mdm'])));
        }
	}

	public function xueyuan_add(){
		$this->display();
	}
	/**
		  * 图片上传
		  */

		 	
		
	public function xueyuan_insert(){

		// $upload = new \Think\UploadFile();// 实例化上传类
		// $upload->maxSize = 3145728 ;// 设置附件上传大小
		// $upload->allowExts = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
		// $upload->savePath = "./Uploads/yueche/xueyuan/";// 设置附件上传目录
		// if(!$upload->upload()){
		//     $this->error($upload->getErrorMsg());die;//输出错误提示
		// }else{
		//     $info = $upload->getUploadFileInfo(); //取得成功上传的文件信息
		// //     foreach($info as $key => $value){
		// //         $data[$key]['path'] = "./Uploads/yueche/xueyuan/";//这里以获取在本地的保存路径为例
		// //     }
		// }
		$upload = new \Think\Upload();// 实例化上传类
		$upload->maxSize   =     3145728 ;// 设置附件上传大小
		$upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
		//$upload->rootPath  =     './Uploads/'; // 设置附件上传根目录
		$upload->savePath  =     './Uploads/yueche/xueyuan/'; // 设置附件上传（子）目录
		$info   =   $upload->upload();
		if(!$info) {// 上传错误提示错误信息
	    	$this->error($upload->getError());
		}
		foreach($info as $k => $v){
			$img[$k] = './Uploads/'.ltrim($v['savepath'].$v['savename'],'.');
		}      
		$images = json_encode($img);
		if(!($_POST['jname']) || !($_POST['jsex']) || !($_POST['jage']) || !($_POST['jphone']) || !($_POST['jcard']) || !($_POST['tbh']) || !($_POST['jbh']) || !($_POST['jl'])){
			$this->error('内容不允许为空！');
		}
		$xueyuan= M('xueyuan');
		$id = I('id');
		$data['xname'] = I('xname');
		$data['xsex'] = I('xsex');
		$data['xage'] = I('xage');
		$data['xaddr'] = I('xaddr');
		$data['xnow_addr'] = I('xnow_addr');
		$data['xphone'] = I('xphone');
		$data['xcard'] = I('xcard');
		$data['xbh'] = I('xbh');
		$data['xweixin'] = I('xweixin');
		$data['xmark'] = I('xmark');
	    $list_add = $xueyuan->add($data);
	    if($list_add){
	    	$this->success('添加成功!',U('Xueyuan/xueyuan_list',array('mdm'=>$_GET['mdm'])));
	    }else{
	    	$this->error('添加失败!');
	    }
	
}

	//上传图片
	public function upload(){
		// $file_infor = var_export($_FILES,true);
		$upload = new \Think\Upload();// 实例化上传类
		$upload->maxSize   =     3145728 ;// 设置附件上传大小
		$upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
		//$upload->rootPath  =     './Uploads/'; // 设置附件上传根目录
		$upload->savePath  =     './Uploads/yueche/xueyuan/'; // 设置附件上传（子）目录
		$info   =   $upload->upload();
		if(!$info) {// 上传错误提示错误信息
	    	$this->error($upload->getError());
		}
		var_dump($info);die;
	}

	public function xueyuan_del(){
		$xueyuan= M('xueyuan');
		$id = I('id');
		if($id){
			$xueyuan_del = $xueyuan->where(array('id'=>$id))->delete();
			if($xueyuan_del){
	    		$this->success('删除成功!',U('Xueyuan/xueyuan_list',array('mdm'=>$_GET['mdm'])));

			}
		}else{
			$this->error('删除失败,缺少id值!');
		}
		$this->display();
	}

    
}