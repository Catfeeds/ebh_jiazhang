<?php
/*
后台权限
*/
class AdminControl extends CControl{
	public function __construct(){
		error_reporting(E_ERROR | E_WARNING | E_PARSE);
		parent::__construct();
		$user = Ebh::app()->user->getloginuser();
		if(empty($user)){
			$this->widget('note_widget',array('note'=>'权限不足','returnurl'=>'javascript:void()'));
			exit;
		}
		$cparr = explode('/',$this->uri->codepath);
		$permission = $this->model('permission');
		$param['groupid'] = $user['groupid'];
		$param['controller'] = $cparr[1];
		$res = $permission->haspermission($param);
		if(!$res){
			$this->widget('note_widget',array('note'=>'权限不足','returnurl'=>'javascript:void()'));
			exit;
		}
	}
}
?>