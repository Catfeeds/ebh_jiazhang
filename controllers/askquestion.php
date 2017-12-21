<?php
class AskquestionController extends CControl{
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
	//答疑
    public function index() {
		$roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();
        $q = $this->input->get('q');
		$askdate = $this->input->get('d');
		$aq = $this->input->get('aq');
        $folderid = $this->input->get('fid');
		$cwid = $this->input->get('cwid');
        $queryarr = parsequery();
        $queryarr['crid'] = $roominfo['crid'];
        $queryarr['shield'] = 0;
		$queryarr['aq'] = $aq;
		$queryarr['cwid'] = intval($cwid);
        $folderid = intval($folderid);
        if(!empty($folderid)){
            $queryarr['folderid'] = $folderid;
        }
		if(!empty($askdate)) {	//过滤提问时间
			$asktime = strtotime($askdate);
			if($asktime !== FALSE) {
				$queryarr['abegindate'] = $asktime;
				$queryarr['aenddate'] = $asktime + 86400;
			} else {
				$askdate = '';
			}
		}
        $askmodel = $this->model('Askquestion');
        $asks = $askmodel->getallasklist($queryarr);
        $count = $askmodel->getallaskcount($queryarr);
        $pagestr = show_page($count);

        $key = $this->_getplaykey();
        //更新评论用户状态时间
        $statemodel = $this->model('Userstate');
        $typeid = 2;
        $statemodel->insert($roominfo['crid'],$user['uid'],$typeid,SYSTIME);
        
        $this->assign('asks', $asks);
        $this->assign('pagestr', $pagestr);
        $this->assign('user', $user);
        $this->assign('crid', $roominfo['crid']);
        $this->assign('q', $q);
		$this->assign('aq', $aq);
        $this->assign('key', $key);
		$this->display('askquestion');
		$this->_updateuserstate();
    }
   /**
	*获取播放器提问和播放器回答所需的key值
	*/
	private function _getplaykey() {
		$clientip = $this->input->getip();
        $ktime = SYSTIME;
        $auth = $this->input->cookie('auth');
        $sauth = authcode($auth, 'DECODE');
        @list($password, $uid) = explode("\t", $sauth);
        $skey = $ktime . '\t' . $uid . '\t' . $password . '\t' . $clientip;
        $key = authcode($skey, 'ENCODE');
		return $key;
	}
	 /**
	*更新新作业用户状态时间
	*/
	private function _updateuserstate() {
		 //更新评论用户状态时间
		$roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();
        $statemodel = $this->model('Userstate');
        $typeid = 4;
        $statemodel->insert($roominfo['crid'],$user['uid'],$typeid,SYSTIME);
	}
	 /**
     * 我的问题
     */
    public function myquestion() {
        $roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();
        $q = $this->input->get('q');
        $queryarr = parsequery();
        $queryarr['crid'] = $roominfo['crid'];
        $queryarr['uid'] = $user['uid'];
        $queryarr['shield'] = 0;
        $askmodel = $this->model('Askquestion');
        $asks = $askmodel->getallasklist($queryarr);
        $count = $askmodel->getallaskcount($queryarr);
        $pagestr = show_page($count);

        $key = $this->_getplaykey();

        $this->assign('asks', $asks);
        $this->assign('pagestr', $pagestr);
        $this->assign('user', $user);
        $this->assign('crid', $roominfo['crid']);
        $this->assign('q', $q);
        $this->assign('key', $key);
        $this->display('myquestion');
		
		$this->_updateuserstate();
    }
	  /**
     * 我的回答
     */
    public function myanswer() {
        $roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();
        $q = $this->input->get('q');
        $queryarr = parsequery();
        $queryarr['crid'] = $roominfo['crid'];
        $queryarr['uid'] = $user['uid'];
		$queryarr['qshield'] = 0;
		$queryarr['ashield'] = 0;
		$d = $this->input->get('d');
		if(!empty($d)) {
			$thetime = strtotime($d);
			if($thetime !== FALSE) {
				$startdate = $thetime;
				$enddate = $thetime + 86400;
				$queryarr['startDate'] = $startdate;
				$queryarr['endDate'] = $enddate;
			}
		}
        $askmodel = $this->model('Askquestion');
        $asks = $askmodel->getasklistbyanswers($queryarr);
        $count = $askmodel->getaskcountbyanswers($queryarr);
        $pagestr = show_page($count);

        $key = $this->_getplaykey();
	
        $this->assign('asks', $asks);
        $this->assign('pagestr', $pagestr);
        $this->assign('user', $user);
        $this->assign('crid', $roominfo['crid']);
        $this->assign('q', $q);
		$this->assign('d',$d);
        $this->assign('key', $key);
        $this->display('myanswer');
    }
	 /**
     * 我的关注
     */
    public function myfavorit() {
        $roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();
        $q = $this->input->get('q');
        $queryarr = parsequery();
        $queryarr['crid'] = $roominfo['crid'];
        $queryarr['uid'] = $user['uid'];
        $askmodel = $this->model('Askquestion');
        $asks = $askmodel->getasklistbyfavorit($queryarr);
        $count = $askmodel->getaskcountbyfavorit($queryarr);
        $pagestr = show_page($count);

        $key = $this->_getplaykey();

        $this->assign('asks', $asks);
        $this->assign('pagestr', $pagestr);
        $this->assign('user', $user);
        $this->assign('crid', $roominfo['crid']);
        $this->assign('q', $q);
        $this->assign('key', $key);
        $this->display('myfavorit');
    }
	 /**
     * 问题详情
     */
    public function view() {
        $qid = $this->uri->itemid;
        if (is_numeric($qid)) {
            $editor = Ebh::app()->lib('UMEditor');
            $param = parsequery();
			$param['qid'] = $qid;
			$param['pagesize'] = 10;
            $askmodel = $this->model('Askquestion');
            $user = Ebh::app()->user->getloginuser();
            //人气数+1
            $askmodel->addviewnum($qid);
            $ask = $askmodel->getdetailaskbyqid($qid, $user['uid']);
            if(!empty($ask) && $ask['shield']==1){
                $url = getenv("HTTP_REFERER");
                header("Content-type:text/html;charset=utf-8");
                echo "问题被屏蔽，无法查看";
                echo '<a href="'. $url.'">返回</a>'; 
                exit;
            }
            $answers = $askmodel->getdetailanswersbyqid($param);
            $count = $askmodel->getdetailanswerscountbyqid($qid);
            $pagestr = show_page($count);
            $this->assign('ask', $ask);
            $this->assign('answers', $answers);
            $this->assign('pagestr', $pagestr);
            $this->assign('user', $user);
            $this->assign('qid', $qid);
            $this->assign('editor', $editor);
            $this->display('askquestion_view');
        }
    }

}
?>