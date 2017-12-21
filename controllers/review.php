<?php
class ReviewController extends CControl{
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
	//
    public function index() {
    
	}
	public function student(){
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		$crid = $roominfo['crid'];
		$reviewmodel = $this->model('review');
		$q = $this->input->get('q');
		$params = parsequery();
		$params['crid'] = $crid;
		$params['uid'] = $user['uid'];
		$params['displayorder'] = 'r.logid desc';
		$params['pagesize'] = 10;
		$params['q'] = $q;
		$params['status'] = 1;
		$reviews = $reviewmodel->getReviewListByUid($params);
		$params['rcrid'] = 1;
		$count = $reviewmodel->getreviewcount($params);
		$reviews = parseEmotion($reviews);
		$this->assign('emotionarr',getEmotionarr());
		$pagestr = show_page($count,10);

		$this->assign('reviews', $reviews);
		$this->assign('pagestr', $pagestr);
		$this->assign('count', $count);
		$this->assign('roominfo', $roominfo);
		$this->assign('user', $user);
		$this->display('review_student');
	}
	/*
	*老师回复
	*/
	public function teacher(){
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		$crid = $roominfo['crid'];
		$reviewmodel = $this->model('review');
		$q = $this->input->get('q');
		$params = parsequery();
		$params['crid'] = $crid;
		$params['uid'] = $user['uid'];
		$params['displayorder'] = 'r.logid desc';
		$params['pagesize'] = 10;
		$params['q'] = $q;
		$params['rev'] = 1;
		$params['status'] = 1;
		$params['replysubject'] = 1;
		//$params['upid'] = 0;
		$reviews = $reviewmodel->getReviewListByUid($params);
		$count = $reviewmodel->getreviewcount($params);
		$reviews = parseEmotion($reviews);
		$this->assign('emotionarr',getEmotionarr());
		$pagestr = show_page($count,10);
		$this->assign('pagestr', $pagestr);
		$this->assign('reviews', $reviews);
		$this->assign('count', $count);
		$this->assign('roominfo', $roominfo);
		$this->assign('user', $user);
		$this->display('review_teacher');
	}
}
?>