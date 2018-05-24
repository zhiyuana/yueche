<?php
        	
namespace Addons\Qwechart\Model;
use Home\Model\WeixinModel;
        	
/**
 * Qwechart的微信模型
 */
class WeixinAddonModel extends WeixinModel{
	function reply($dataArr, $keywordArr = array()) {
		$config = getAddonConfig ( 'Qwechart' ); // 获取后台插件的配置参数	
		//dump($config);
	}
}
        	