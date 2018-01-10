<?php
class ApiControl extends CControl {
	public function __construct(){
		parent::__construct();
        EBH::app()->helper('examv2');
		$this->_initSource();
	}

    /**
    *定义数据服务器常量
    */
    private function _initSource(){
    	//数据服务器地址
        $dataserver = EBH::app()->getConfig('dataserver')->load('dataserver');
        $servers = $dataserver['servers'];
        //随机抽取一台服务器
        $target_server = $servers[array_rand($servers,1)];
        defined('__SURL__') or define('__SURL__', $target_server);
    }

}