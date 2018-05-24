<?php

namespace Home\Controller;
use Think\Model;
/**
 * 素材管理控制器
 */
class ShouFeiController extends HomeController {
	function _initialize() {
		parent::_initialize ();
		
		$act = strtolower ( ACTION_NAME );
		$param = array (
				'mdm' => I ( 'mdm' ) 
		);

		$res ['title'] = '存款报表';
		$res ['url'] = U ( 'cunkuan_list', $param );
		$res ['class'] = strpos ( $act, 'cunkuan_list' ) !== false ? 'current' : '';
		$nav [] = $res;
		
		$res ['title'] = '收费报表';
		$res ['url'] = U ( 'shoufei_list', $param );
		$res ['class'] = strpos ( $act, 'shoufei_list' ) !== false ? 'current' : '';
		$nav [] = $res;
		
		
		$this->assign ( 'nav', $nav );
	}
	
	public function cunkuan_list(){
    	// header("Content-type:text/html;charset=utf-8");
		$dingdan= M('dingdan');
		
		$day[0] = date("Y-m-d");
		$day[1] = date("Y-m-d",strtotime("-1 day"));
		$day[2] = date("Y-m-d",strtotime("-2 day"));
		$day[3]	= date("Y-m-d",strtotime("-3 day"));
		$day[4] = date("Y-m-d",strtotime("-4 day"));
		
		for($i=0;$i<count($day);$i++){
			$sql[$i] = "select sum(money) as count from wp_dingdan where pdata = '$day[$i]' ";
			$res[$i] = $dingdan->query($sql[$i]);
			if($res[$i][0]['count'] == null){
				$res[$i][0]['count'] = 0;
			}
			$res[$i]['newcount'] = (float)$res[$i][0]['count'];
		}
		
		$sum = 0;
		for($i=0;$i<count($res);$i++){
			$sum += $res[$i]['newcount'];
			$res[$i]['day'] = $day[$i];
		}
		//var_dump($res);die;
		$this->assign('cunkuan_list',$res);
		$this->assign('sum',$sum);
		$this->display();
	}
	
	public function shoufei_list(){
    	// header("Content-type:text/html;charset=utf-8");
		$dingdan= M('dingdan');
	 	 $shoufei_list = $dingdan->table('wp_dingdan d')
        // ->join('wp_jiaolian j on d.jid=j.id')
        ->join('wp_xueyuan x on d.xid=x.id')
        ->join('wp_paiban p on d.pid=p.id')
 		->field('*,d.id as id')
        ->where($where)
 		->order('d.id desc')
 		->select();	
		$this->assign('shoufei_list',$shoufei_list);
		$this->display();
	}
	
	
	public function search(){
		$datetimepicker = I('datetimepicker');
		$datetimepicker1 = I('datetimepicker1');
		$dingdan=M('dingdan');
		if($datetimepicker !="" && $datetimepicker1 !=""){
			$ding_list=$dingdan->table('wp_dingdan d')
			->join('wp_jiaolian j on d.jid=j.id')
			->join('wp_xueyuan x on d.xid=x.id')
			->join('wp_paiban p on d.pid=p.id')
			->field('*,d.id as id')
			->where("d.daddtime >= '$datetimepicker' and d.daddtime <= '$datetimepicker1' ")
			->order('d.id desc')
			->select();
		}else{
			$ding_list=$dingdan->table('wp_dingdan d')
			->join('wp_jiaolian j on d.jid=j.id')
			->join('wp_xueyuan x on d.xid=x.id')
			->join('wp_paiban p on d.pid=p.id')
			->field('*,d.id as id')
			//->where("d.status ='$status' ")
			->order('d.id desc')
			->select();
		}
		
		if($ding_list){			
				$this->assign('shoufei_list',$ding_list);
				$this->display('shoufei_list');
		}else{
			$this->error('没有要查询的订单！');
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
    
}