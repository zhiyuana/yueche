<?php

namespace Addons\Qwechart;
use Common\Controller\Addon;

/**
 * 应用列表插件
 * @author 聆雨听风
 */

    class QwechartAddon extends Addon{

        public $info = array(
            'name'=>'Qwechart',
            'title'=>'应用列表',
            'description'=>'应用列表',
            'status'=>1,
            'author'=>'聆雨听风',
            'version'=>'0.1',
            'has_adminlist'=>0
        );

	public function install() {
		$install_sql = './Addons/Qwechart/install.sql';
		if (file_exists ( $install_sql )) {
			execute_sql_file ( $install_sql );
		}
		return true;
	}
	public function uninstall() {
		$uninstall_sql = './Addons/Qwechart/uninstall.sql';
		if (file_exists ( $uninstall_sql )) {
			execute_sql_file ( $uninstall_sql );
		}
		return true;
	}

        //实现的weixin钩子方法
        public function weixin($param){

        }

    }