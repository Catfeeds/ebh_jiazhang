<?php
/*
页面内获取模块名称
*/
class Modulename{
	public function getmodulename($t,$param){
		$ammodel = Ebh::app()->model('appmodule');
		$module = $ammodel->getmodulenamebycode($param);
		$modulename = $module['nickname']?$module['nickname']:($param['tors']?$module['modulename_t']:$module['modulename']);
		$t->assign('pagemodulename',$modulename);
	}
}
?>