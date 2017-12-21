<?php
/**
 * 学校通知控制器类 NoticeController
 */
class NoticeController extends CControl{
    public function __construct() {
        parent::__construct();
		$roominfo = Ebh::app()->room->getcurroom();
        $check = TRUE;
		if($roominfo['isschool'] == 6 || $roominfo['isschool'] == 7) {
			$check = Ebh::app()->room->checkstudent(TRUE);
		} else {
			Ebh::app()->room->checkstudent();
		}
		$this->assign('check',$check);
    }
	/**
	* 我接收的通知列表
	*/
    public function index() {
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		$classmodel = $this->model('Classes');
		$myclass = $classmodel->getClassByUid($roominfo['crid'],$user['uid']);
		if(empty($myclass)) {
			$notices = array();
			$pagestr = '';
		} else {
			$noticemodel = $this->model('Notice');
			$param = parsequery();
			$param['crid'] = $roominfo['crid'];
			$param['ntype'] = '1,3,4,5';
			$param['classid'] = $myclass['classid'];
			$param['needgrade'] = true;
			$param['needdistrict'] = true;
			$notices = $noticemodel->getnoticelist($param);
			$count = $noticemodel->getnoticelistcount($param);
			$pagestr = show_page($count);
		}
		
		$this->assign('notices',$notices);
		$this->assign('pagestr',$pagestr);
		$this->display('notice');
    }
	/*通知详情*
	*
	*/
	public function view() {
		$roominfo = Ebh::app()->room->getcurroom();
		$noticeid = $this->uri->itemid;
		$noticemodel = $this->model('Notice');
		$param = array('crid'=>$roominfo['crid'],'noticeid'=>$noticeid);
		$notice = $noticemodel->getNoticeDetail($param);
		if(!empty($notice)) {
			$noticemodel->addviewnum($noticeid);
			if(!empty($notice['attid'])){
				$attmodel = $this->model('attachment');
				$attfile = $attmodel->getAttachByIdForNotice($notice['attid']);
				$this->assign('attfile',$attfile);
			}
			$this->assign('notice',$notice);
			$this->display('notice_view');
		}
	}
}
