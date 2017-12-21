<?php
class PassController extends CControl{
	 public function __construct() {
       	parent::__construct();
		$user = Ebh::app()->user->getloginuser();
		$check = TRUE;
        $dm = $this->input->cookie('dm');
		if(empty($user['uid']) || empty($dm)) {
			$check = Ebh::app()->room->checkstudent(TRUE);
			if (empty($dm)) {
				$url = '/';
				header("Location: $url");
				exit();
			}
		} else {
			Ebh::app()->room->checkstudent();
		}
		$this->assign('check',$check);
    }
	//家长密码
    public function index() {
		$this->display('pass');
    }
	/*
	旧密码确认
	*/
	public function checkoldpassword(){
		//$member = $this->model('member');
		$this->user = Ebh::app()->user->getloginuser();
		
		if((empty($this->user['ppassword'])?$this->user['password']:$this->user['ppassword'])==md5($this->input->post('oldpassword'))){
			echo 1;
		}else{ 
			echo 0;
		}
			
	}
	/*
	修改密码操作
	*/
	public function updatepass(){
		$member = $this->model('member');
		if($this->user['password']==md5($this->input->post('oldpassword'))){
			$param['password'] = $this->input->post('password');
			$param['uid'] = $this->user['uid'];
			$member->editmember($param);
			header('location:/pass.html');
		}
	}
	/*
	 修改密码操作(ajax返回)
	*/
	public function updatepassAjax(){
		$this->user = Ebh::app()->user->getloginuser();
		$member = $this->model('member');
		if((empty($this->user['ppassword'])?$this->user['password']:$this->user['ppassword'])==md5($this->input->post('oldpassword'))){
			$param['ppassword'] = $this->input->post('password');
			$param['uid'] = $this->user['uid'];
			echo $member->editmember($param);
		}
	}
	
}
?>