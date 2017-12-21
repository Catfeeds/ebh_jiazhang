<?php
/*
云教育网校
*/
class SchoolController extends CControl{
	 public function __construct() {
        parent::__construct();
		$user = Ebh::app()->user->getloginuser();
		$check = TRUE;
		if(empty($user['uid'])) {
			$check = Ebh::app()->room->checkstudent(TRUE);
		} else {
			Ebh::app()->room->checkstudent();
		}
		$this->assign('check',$check);
    }
	public function index(){
		$user = Ebh::app()->user->getloginuser();
		$roomuser = $this->model('roomuser');
		$roomlist = $roomuser->getroomlist($user['uid']);
		$this->assign('roomlist',$roomlist);
		$this->assign('user',$user);
		$this->display('school');
	}
}
?>