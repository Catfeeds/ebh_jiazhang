<?php
class StudyrecordsController extends CControl{
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
	//学习记录
    public function index() {
		$user = Ebh::app()->user->getloginuser();
		$roominfo = Ebh::app()->room->getcurroom();
		$playmodel = $this->model('Playlog');
		$queryarr = parsequery();
		$q = $this->input->get('q');
		$d = $this->input->get('d');
		if(!empty($d)) {
			$startDate = strtotime($d);
			if($startDate !== FALSE) {
				$endDate = $startDate + 86400;
				$queryarr['startDate'] = $startDate;
				$queryarr['endDate'] = $endDate;
			}
		}
		$queryarr['crid'] = $roominfo['crid'];
		$queryarr['uid'] = $user['uid'];
		$queryarr['totalflag'] = 0;
		$pagesize = 2000;
		$queryarr['pagesize'] = $pagesize;
		$playlogs = $playmodel->getList($queryarr);
//		foreach($playlogs as &$arr){
//			$playmodel = $this->model('Playlog');
//			$param = array('cwid'=>$arr['cwid'],'totalflag'=>0);
//			$arr['count'] = $playmodel->getCwidCount($param);
//		}

//		$count = $playmodel->getListCount($queryarr);
//		$pagestr = show_page($count,$pagesize);
		$pagestr = '';
		$this->assign('roominfo',$roominfo);
		$this->assign('q',$q);
		$this->assign('d',$d);
		$this->assign('playlogs',$playlogs);
		$this->assign('pagestr',$pagestr);
		$this->display('studyrecords');
    }
	/**
	*时长秒转换成字符显示
	*/
	function getltimestr($ltime) {
		if(empty($ltime))
			return '';
		$h = intval($ltime / 3600); 
		$m = intval(($ltime - $h * 3600)/60);
		$s = $ltime -$h * 3600 - $m*60;
		$str = $h.':'.str_pad($m,2,'0',STR_PAD_LEFT).':'.str_pad($s,2,'0',STR_PAD_LEFT);

		return $str;
	}

}
?>