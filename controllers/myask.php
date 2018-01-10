<?php

/**
 * 学生我的答疑控制器类 MyaskController
 */
class MyaskController extends CControl {
	private $check = NULL;
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

    public function index() {
		$roominfo = Ebh::app()->room->getcurroom();
		$key = $this->_getplaykey();
		$this->assign('crid', $roominfo['crid']);
        $this->assign('key', $key);
        $this->display('myask');
    }
	public function all(){
		$roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();
        //log_message(json_encode($user));die;
        $q = $this->input->get('q');
		$askdate = $this->input->get('d');
		$aq = $this->input->get('aq');
        $folderid = $this->input->get('fid');
		$requireFolderid = $this->input->get('folderid');
		if(!empty($requireFolderid)){
			$folderid = $requireFolderid;
			$foldermodel = $this->model('folder');
			$folder = $foldermodel->getfolderbyid($requireFolderid);
			$this->assign('folder',$folder);
		}
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
        $this->display('myask_all');
		$this->_updateuserstate();
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
            if(empty($ask)){
                $url = getenv("HTTP_REFERER");
                header("Content-type:text/html;charset=utf-8");
                echo "问题不存在或已删除";
                echo '<a href="'. $url.'">返回</a>';
                exit;
            }
            elseif(!empty($ask) && $ask['shield']==1){
                $url = getenv("HTTP_REFERER");
                header("Content-type:text/html;charset=utf-8");
                echo "问题被屏蔽，无法查看";
                echo '<a href="'. $url.'">返回</a>'; 
                exit;
            }
            $answers = $askmodel->getdetailanswersbyqid($param);
            $count = $askmodel->getdetailanswerscountbyqid($qid);
            $pagestr = show_page($count,$param['pagesize']);
			
			//悬赏奖励者名单
			$rewardlist = array();
			if ($ask['isrewarded'] == 1)
			{
				$rewardlist = $this->model('credit')->getRewardList($qid);
			}
            $this->assign('rewardlist', $rewardlist);

			$answerers =  $askmodel->getanswerer(array('qid'=>$qid));
			$this->assign('answerers',$answerers);
            $this->assign('ask', $ask);
            $this->assign('answers', $answers);
            $this->assign('pagestr', $pagestr);
            $this->assign('user', $user);
            $this->assign('qid', $qid);
            $this->assign('editor', $editor);
            $this->display('myask_view');
        }
    }

    /**
     * 教师我的问题
     */
    public function myquestion() {
        $roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();
        $q = $this->input->get('q');
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
        $this->display('myask_myquestion');
		
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
        $this->display('myask_myanswer');
    }

    /**
     * 我的关注
     */
    public function myfavorit() {
        $roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();
        $q = $this->input->get('q');
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
        $this->display('myask_myfavorit');
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
	
	/*
	获取全部问题，我的问题，我的回答，我的关注数量
	*/
	public function getcountinfo(){
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		$askmodel = $this->model('askquestion');
		$param['crid'] = $roominfo['crid'];
		$param['shield'] = 0;
		$count['all'] = $askmodel->getallaskcount($param);
		// $param['uid'] = $user['uid'];
		// $count['myquestion'] = $askmodel->getallaskcount($param);
		// $count['myanswer'] = $askmodel->getaskcountbyanswers($param);
		// $count['myfavorite'] = $askmodel->getaskcountbyfavorit($param);
		echo json_encode($count);
	}
	/**
	 * 获取课程关联的教师头像
	 *
	 */
	protected function _getfaceurl($face='',$sex){
		$defaulturl = $sex == 1 ? 'm_woman.jpg' : 'm_man.jpg';
		$defaulturl = 'http://static.ebanhui.com/ebh/tpl/default/images/'.$defaulturl;
		$face =  empty($face) ? $defaulturl:$face;
		return $face = getthumb($face,'40_40');
	}

    //已解决(已经有最佳答案的)
    public function settled(){
        $roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();
        $q = $this->input->get('q');
        $askdate = $this->input->get('d');
        $aq = $this->input->get('aq');
        $folderid = $this->input->get('fid');
        $requireFolderid = $this->input->get('folderid');
        if(!empty($requireFolderid)){
            $folderid = $requireFolderid;
            $foldermodel = $this->model('folder');
            $folder = $foldermodel->getfolderbyid($requireFolderid);
            $this->assign('folder',$folder);
        }
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
        if(!empty($askdate)) {  //过滤提问时间
            $asktime = strtotime($askdate);
            if($asktime !== FALSE) {
                $queryarr['abegindate'] = $asktime;
                $queryarr['aenddate'] = $asktime + 86400;
            } else {
                $askdate = '';
            }
        }
        $queryarr['status'] = 1;
        $queryarr['hasbest']=1;
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
        $this->display('myask_settled');
    }
    
	//热门(回答最多倒叙,却没有最佳答案的)
	public function hot(){
		$roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();
        $q = $this->input->get('q');
		$askdate = $this->input->get('d');
		$aq = $this->input->get('aq');
        $folderid = $this->input->get('fid');
		$requireFolderid = $this->input->get('folderid');
		if(!empty($requireFolderid)){
			$folderid = $requireFolderid;
			$foldermodel = $this->model('folder');
			$folder = $foldermodel->getfolderbyid($requireFolderid);
			$this->assign('folder',$folder);
		}
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
		}$queryarr['status'] = 0;
		$queryarr['hasbest'] = 0;
		$queryarr['order'] = 'q.answercount desc';
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
		$this->display('myask_hot');
		$this->_updateuserstate();
	}

	//推荐(回答数最多倒叙)
	public function recommend(){
		$roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();
        $q = $this->input->get('q');
		$askdate = $this->input->get('d');
		$aq = $this->input->get('aq');
        $folderid = $this->input->get('fid');
		$requireFolderid = $this->input->get('folderid');
		if(!empty($requireFolderid)){
			$folderid = $requireFolderid;
			$foldermodel = $this->model('folder');
			$folder = $foldermodel->getfolderbyid($requireFolderid);
			$this->assign('folder',$folder);
		}
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
		$queryarr['order'] = 'q.answercount desc';
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
		$this->display('myask_recommend');
		$this->_updateuserstate();
	}

	//等待回复(我没有回复过的)
	public function wait(){
		$roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();
		$aq = $this->input->get('aq');
        $q = $this->input->get('q');
		$folderid = $this->input->get('fid');
		$requireFolderid = $this->input->get('folderid');
		if(!empty($requireFolderid)){
			$folderid = $requireFolderid;
			$foldermodel = $this->model('folder');
			$folder = $foldermodel->getfolderbyid($requireFolderid);
			$this->assign('folder',$folder);
		}
		$cwid = $this->input->get('cwid');
        $queryarr = parsequery();
		$queryarr['aq'] = $aq;
        $queryarr['crid'] = $roominfo['crid'];
        $queryarr['uid'] = $user['uid'];
		$queryarr['qshield'] = 0;
		$queryarr['ashield'] = 0;
		$queryarr['cwid'] = intval($cwid);
        $folderid = intval($folderid);
		if(!empty($folderid)){
            $queryarr['folderid'] = $folderid;
        }
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
        $asks = $askmodel->getasklistbynoanswers($queryarr);
        $count = $askmodel->getaskcountbynoanswers($queryarr);
        $pagestr = show_page($count);

        $key = $this->_getplaykey();
		
		$this->assign('aq', $aq);
        $this->assign('asks', $asks);
        $this->assign('pagestr', $pagestr);
        $this->assign('user', $user);
        $this->assign('crid', $roominfo['crid']);
        $this->assign('q', $q);
		$this->assign('d',$d);
        $this->assign('key', $key);
        $this->display('myask_wait');
	}
	
}
