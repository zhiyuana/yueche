<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

/**
 * 前台公共库文件
 * 主要定义前台公共函数库
 */

/**
 * 获取列表总行数
 *
 * @param string $category
 *        	分类ID
 * @param integer $status
 *        	数据状态
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function get_list_count($category, $status = 1) {
	static $count;
	if (! isset ( $count [$category] )) {
		$count [$category] = D ( 'Document' )->listCount ( $category, $status );
	}
	return $count [$category];
}

/**
 * 获取段落总数
 *
 * @param string $id
 *        	文档ID
 * @return integer 段落总数
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function get_part_count($id) {
	static $count;
	if (! isset ( $count [$id] )) {
		$count [$id] = D ( 'Document' )->partCount ( $id );
	}
	return $count [$id];
}

/**
 * 获取导航URL
 *
 * @param string $url
 *        	导航URL
 * @return string 解析或的url
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function get_nav_url($url) {
	switch ($url) {
		case 'http://' === substr ( $url, 0, 7 ) :
		case 'https://' === substr ( $url, 0, 8 ) :
		case '#' === substr ( $url, 0, 1 ) :
			break;
		default :
			$url = U ( $url );
			break;
	}
	return $url;
}
// 运营统计
function tongji($addon) {
	return false;
	if (empty ( $addon ) || $addon == 'Tongji')
		return false;
	
	$data ['token'] = get_token ();
	$data ['day'] = date ( 'Ymd' );
	$info = M ( 'tongji' )->where ( $data )->find ();
	
	if ($info) {
		$content = unserialize ( $info ['content'] );
		$content [$addon] += 1;
		
		$save ['content'] = serialize ( $content );
		M ( 'tongji' )->where ( $data )->save ( $save );
	} else {
		$content [$addon] = 1;
		$data ['content'] = serialize ( $content );
		$data ['month'] = date ( 'Ym' );
		M ( 'tongji' )->add ( $data );
	}
}
// 获取数据的状态操作
function show_status_op($status) {
	switch ($status){
		case 0  : return    '启用';     break;
		case 1  : return    '禁用';     break;
		case 2  : return    '审核';		break;
		default : return    false;      break;
	}
}

/**
 * 生成pdf
 * @param  string $html      		需要生成的内容
 * @param  string $pdf_name      	保存pdf文件的文件名
 */
function pdf($html='<h1 style="color:red">这是一个测试文件，生成pdf文件！</h1>',$pdf_name='example_001'){
    vendor('tcpdf.tcpdf');
    $pdf = new \tcpdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    // 设置打印模式
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Nicola Asuni');
    $pdf->SetTitle('TCPDF Example 001');
    $pdf->SetSubject('TCPDF Tutorial');
    $pdf->SetKeywords('TCPDF, PDF, example, test, guide');
    // 是否显示页眉
    $pdf->setPrintHeader(false);
    // 设置页眉显示的内容
    $pdf->SetHeaderData('logo.png', 60, 'baijunyao.com', '白俊遥博客', array(0,64,255), array(0,64,128));
    // 设置页眉字体
    $pdf->setHeaderFont(Array('dejavusans', '', '12'));
    // 页眉距离顶部的距离
    $pdf->SetHeaderMargin('5');
    // 是否显示页脚
    $pdf->setPrintFooter(true);
    // 设置页脚显示的内容
    $pdf->setFooterData(array(0,64,0), array(0,64,128));
    // 设置页脚的字体
    $pdf->setFooterFont(Array('dejavusans', '', '10'));
    // 设置页脚距离底部的距离
    $pdf->SetFooterMargin('10');
    // 设置默认等宽字体
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
    // 设置行高
    $pdf->setCellHeightRatio(1);
    // 设置左、上、右的间距
    $pdf->SetMargins('10', '10', '10');
    // 设置是否自动分页  距离底部多少距离时分页
    $pdf->SetAutoPageBreak(TRUE, '15');
    // 设置图像比例因子
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
    if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
        require_once(dirname(__FILE__).'/lang/eng.php');
        $pdf->setLanguageArray($l);
    }
    $pdf->setFontSubsetting(true);
    $pdf->AddPage();
    // 设置字体
    $pdf->SetFont('stsongstdlight', '', 14, '', true);
    $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
    //判断IE浏览器,处理保存文件名中文乱码
    $userBrowser = $_SERVER['HTTP_USER_AGENT'];
    $fileName = $pdf_name.".pdf";
    if ( preg_match( '/MSIE/i', $userBrowser ) )
    {   
      	$fileName = urlencode($fileName);
    }
    $fileName = iconv('UTF-8', 'GBK//IGNORE', $fileName);
    $pdf->Output($fileName, 'I');//保存的文件名
}