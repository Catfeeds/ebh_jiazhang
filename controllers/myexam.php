<?php
/**
 * 学校学生我的作业相关控制器 MycourseController
 */
class MyexamController extends CControl {
    public function __construct() {
        parent::__construct();
        $check = TRUE;
        $dm = $this->input->cookie('dm');
        $user = Ebh::app()->user->getloginuser();
        if(empty($user['uid']) || empty($dm)) {
			$check = Ebh::app()->room->checkstudent(TRUE);
			if (empty($dm)) {
				$url = '/';
				header("Location: $url");
				exit();
			}
		}
		$roominfo = Ebh::app()->room->getcurroom();
        
		$this->assign('check',$check);
		if($roominfo['isschool'] == 6 || $roominfo['isschool'] == 7) {
			$check = Ebh::app()->room->checkstudent(TRUE);
			if($roominfo['isschool'] == 7 && $check != 1) {
				$perparam = array('crid'=>$roominfo['crid']);
				$payitem = Ebh::app()->room->getUserPayItem($perparam);
				$this->assign('payitem',$payitem);
				if(!empty($payitem)) {
					$checkurl = 'http://'.$roominfo['domain'].'.'.$this->uri->curdomain.'/ibuy.html?itemid='.$payitem['itemid'];	//购买url
					if($roominfo['domain'] == 'yxwl') {	//易学网络 专门处理，直接跳转到转账
						$checkurl = '/classactive/bank.html';
					}
					$this->assign('checkurl',$checkurl);
				}

			}
			$this->assign('check',$check);
		} else {
			Ebh::app()->room->checkstudent();
		}
		$this->_assignCheckUrl();
    }
	public function index(){
		$this->display('myexam');
		$this->_updateuserstate();
	}
	/**
	*我的作业(所有作业)
	*/
	public function all() {
		$exammodel = $this->model('Exam');
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		//获取班级信息
		$classesmodel = $this->model('Classes');
		$myclass = $classesmodel->getClassByUid($roominfo['crid'],$user['uid']);	
		//获取作业列表
		$q = $this->input->get('q');
		$answerdate = $this->input->get('d');
		$examdate = $this->input->get('ed');
		$queryarr = parsequery();
		$requireFolderid = $this->input->get('folderid');
		if(!empty($requireFolderid)){
			$folderid = $requireFolderid;
			$foldermodel = $this->model('folder');
			$folder = $foldermodel->getfolderbyid($requireFolderid);
			$this->assign('folder',$folder);
		}
		if(!empty($folderid)){
			$queryarr['folderid'] = $folderid;
		}
		$queryarr['uid'] = $user['uid'];
		$queryarr['crid'] = $roominfo['crid'];
		$queryarr['classid'] = $myclass['classid'];
		$tid = $this->uri->uri_attr(0);
		if(!empty($tid)){
			$queryarr['tid'] = intval($tid);
		}
		if(!empty($myclass['grade'])) {	//班级有年级信息，则显示此年级下的所有作业
			$queryarr['grade'] = $myclass['grade'];
			$queryarr['district'] = $myclass['district'];
		}
		$queryarr['filteranswer'] = 1;
		if(!empty($answerdate)) {	//过滤答题时间
			$answertime = strtotime($answerdate);
			if($answertime !== FALSE) {
				$queryarr['abegindate'] = $answertime;
				$queryarr['aenddate'] = $answertime + 86400;
			} else {
				$answerdate = '';
			}
		}
		if(!empty($examdate)) {	//过滤答题时间
			unset($queryarr['filteranswer']);
			$examtime = strtotime($examdate);
			if($examtime !== FALSE) {
				$queryarr['ebegindate'] = $examtime;
				$queryarr['eenddate'] = $examtime + 86400;
			} else {
				$examdate = '';
			}
		}
		$queryarr['type'] = 0;
		$exams = $exammodel->getExamListByMemberid($queryarr);
		//注入权限信息(注入之后itemid大于0的就表示没有权限)
		$exams = $this->_premissionInsert($exams);
		$count = $exammodel->getExamListCountByMemberid($queryarr);
		$pagestr = show_page($count,$queryarr['pagesize']);
		$this->assign('q',$q);
		$this->assign('d',$answerdate);
		$this->assign('exams',$exams);
		$this->assign('roominfo',$roominfo);
		$this->assign('pagestr',$pagestr);
        $this->display('myexam_all');
		$this->_updateuserstate();
	}
	/**
	* 我做过的作业
	*/
	public function my() {
		$exammodel = $this->model('Exam');
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		//获取班级信息
		$classesmodel = $this->model('Classes');
		$myclass = $classesmodel->getClassByUid($roominfo['crid'],$user['uid']);	
		//获取作业列表
		$q = $this->input->get('q');
		$answerdate = $this->input->get('d');
		$queryarr = parsequery();
		$requireFolderid = $this->input->get('folderid');
		if(!empty($requireFolderid)){
			$folderid = $requireFolderid;
			$foldermodel = $this->model('folder');
			$folder = $foldermodel->getfolderbyid($requireFolderid);
			$this->assign('folder',$folder);
		}
		if(!empty($folderid)){
			$queryarr['folderid'] = $folderid;
		}
		$queryarr['uid'] = $user['uid'];
		$queryarr['crid'] = $roominfo['crid'];
		$queryarr['classid'] = $myclass['classid'];
		if(!empty($myclass['grade'])) {	//班级有年级信息，则显示此年级下的所有作业
			$queryarr['grade'] = $myclass['grade'];
			$queryarr['district'] = $myclass['district'];
		}
		$queryarr['hasanswer'] = 1;
		if(!empty($answerdate)) {	//过滤答题时间
			$answertime = strtotime($answerdate);
			if($answertime !== FALSE) {
				$queryarr['abegindate'] = $answertime;
				$queryarr['aenddate'] = $answertime + 86400;
			} else {
				$answerdate = '';
			}
		}
		$queryarr['type'] = 0;
		$exams = $exammodel->getExamListByMemberid($queryarr);
		$count = $exammodel->getExamListCountByMemberid($queryarr);
		$pagestr = show_page($count);
		$this->assign('q',$q);
		$this->assign('d',$answerdate);
		$this->assign('exams',$exams);
		$this->assign('roominfo',$roominfo);
		$this->assign('pagestr',$pagestr);
        $this->display('myexam_my');
	}
	/**
	* 我的作业草稿箱
	*/
	public function box() {
		$exammodel = $this->model('Exam');
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		//获取班级信息
		$classesmodel = $this->model('Classes');
		$myclass = $classesmodel->getClassByUid($roominfo['crid'],$user['uid']);	
		//获取作业列表
		$q = $this->input->get('q');
		$answerdate = $this->input->get('d');
		$queryarr = parsequery();
		$requireFolderid = $this->input->get('folderid');
		if(!empty($requireFolderid)){
			$folderid = $requireFolderid;
			$foldermodel = $this->model('folder');
			$folder = $foldermodel->getfolderbyid($requireFolderid);
			$this->assign('folder',$folder);
		}
		if(!empty($folderid)){
			$queryarr['folderid'] = $folderid;
		}
		$queryarr['uid'] = $user['uid'];
		$queryarr['crid'] = $roominfo['crid'];
		$queryarr['classid'] = $myclass['classid'];
		if(!empty($myclass['grade'])) {	//班级有年级信息，则显示此年级下的所有作业
			$queryarr['grade'] = $myclass['grade'];
			$queryarr['district'] = $myclass['district'];
		}
		$queryarr['astatus'] = 0;
		$queryarr['hasanswer'] = 1;
		if(!empty($answerdate)) {	//过滤答题时间
			$answertime = strtotime($answerdate);
			if($answertime !== FALSE) {
				$queryarr['abegindate'] = $answertime;
				$queryarr['aenddate'] = $answertime + 86400;
			} else {
				$answerdate = '';
			}
		}
		$queryarr['type'] = 0;
		$exams = $exammodel->getExamListByMemberid($queryarr);
		$count = $exammodel->getExamListCountByMemberid($queryarr);
		$pagestr = show_page($count);
		$this->assign('q',$q);
		$this->assign('d',$answerdate);
		$this->assign('exams',$exams);
		$this->assign('roominfo',$roominfo);
		$this->assign('pagestr',$pagestr);
        $this->display('myexam_box');
	}
	/**
	*更新新作业用户状态时间
	*/
	private function _updateuserstate() {
		 //更新评论用户状态时间
		$roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();
        $statemodel = $this->model('Userstate');
        $typeid = 1;
        $statemodel->insert($roominfo['crid'],$user['uid'],$typeid,SYSTIME);
	}
	/*
	获取做作业，已做作业，草稿箱，错题本数量
	*/
	public function getcountinfo(){
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		$classesmodel = $this->model('Classes');
		$myclass = $classesmodel->getClassByUid($roominfo['crid'],$user['uid']);
		$param['uid'] = $user['uid'];
		$param['crid'] = $roominfo['crid'];
		$errormodel = $this->model('Errorbook');
		$count['myerrorbook'] = $errormodel->myscherrorbooklistcount($param);
		$param['classid'] = $myclass['classid'];
		$exammodel = $this->model('exam');
		$param['filteranswer'] = 1;
		$count['all'] = $exammodel->getExamListCountByMemberid($param);
		unset($param['filteranswer']);
		$param['hasanswer'] = 1;
		$count['my'] = $exammodel->getExamListCountByMemberid($param);
		$param['astatus'] = 0;
		$count['box'] = $exammodel->getExamListCountByMemberid($param);
		
		echo json_encode($count);
	}



	/**
	 *权限信息注入
	 */
	private function _premissionInsert($examlist = array()){
		
		$user = Ebh::app()->user->getloginuser();
		$roominfo = Ebh::app()->room->getcurroom();
		$crid = $roominfo['crid'];

		$newexamlist = array();
		if($roominfo['isschool'] != 7){
			foreach ($examlist as $cw) {
				$cw['itemid'] = 0;
				$newexamlist[] = $cw;
			}
			return $examlist;
		}
		$userpermodel = $this->model('Userpermission');
		$myperparam = array('uid'=>$user['uid'],'crid'=>$roominfo['crid'],'filterdate'=>1);
		//我已经购买的课程
		$myfolderlist = $userpermodel->getUserPayFolderList($myperparam);
		$myfolderlist = $this->_modifyKeys($myfolderlist);
		//学校的收费课程
		$notFreeFolderList = $this->model('folder')->getNotFreeFolderList($crid);
		$notFreeFolderList = $this->_modifyKeys($notFreeFolderList);

		//学校的收费课程(服务包中)
		$roomfolderlist = $userpermodel->getPayItemByCrid($roominfo['crid']);
		$roomfolderlist = $this->_modifyKeys($roomfolderlist);
		//顺便将包信息分配到页面用于根据folderid获取包名
		$this->assign('iteminfo',$roomfolderlist);

		//没有购买的学校收费课程
		$notBuyFolderList = array();
		foreach ($notFreeFolderList as $nkey => $notFreeFolder) {
			if(!array_key_exists($nkey, $myfolderlist)){
				$notBuyFolderList[$nkey] = $notFreeFolder;
  			}
		}
		foreach ($examlist as $cw) {
			$key = 'f_'.$cw['folderid'];
			if(array_key_exists($key, $notBuyFolderList)){
				if(array_key_exists($key, $roomfolderlist)){
					$cw['itemid'] = intval($roomfolderlist[$key]['itemid']);
				}else{
					$cw['itemid'] = 0; //如果是收费课程但是不在服务包里面的也视为免费
				}
			}else{
				$cw['itemid'] = 0;
			}
			$newexamlist[] = $cw;
		}
		$this->_assignCheckUrl();
		return $newexamlist;
	}
	
	/**
	 *将索引数组变成关联数组
	 */
	private function _modifyKeys($somelist = array()){
		$returnArr = array();
		foreach ($somelist as $some) {
			$key = 'f_'.$some['folderid'];
			$returnArr[$key] = $some;
		}
		return $returnArr;
	}

	/**
	 *分配购买地址
	 */
	private function _assignCheckUrl(){
		$roominfo = Ebh::app()->room->getcurroom();
		$crid = $roominfo['crid'];
		$checkurl = 'http://'.$roominfo['domain'].'.'.$this->uri->curdomain.'/ibuy.html?itemid=';
		$this->assign('_checkurl',$checkurl);
	}
}
