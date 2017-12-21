<?php
/**
 *成长记录
 */
class GhrecordController extends CControl{
	private $myclass = array();
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
	public function index(){
		$user = Ebh::app()->user->getloginuser();
		$roominfo = Ebh::app()->room->getcurroom();
		
		//个人积分明细
		$credit = $this->model('credit');
		$param['pagesize'] = 5;
		$param['toid'] = $user['uid'];
		$mycreditlist = $credit->getcreditlist($param);
				
		//获得所在班级
		$classmodel = $this->model('Classes');
		$myclass = $classmodel->getClassByUid($roominfo['crid'],$user['uid']);
		$this->myclass = $myclass;

		//随机取得5个同学积分明细，先获得6个学生积分信息，然后再去掉一个。
		//先从缓存读取同学成长记录
		$redis = Ebh::app()->getCache('cache_redis');
		$redis_key = 'class_creditlist_' . $myclass['classid'];
		$myclasscreditlist = $redis->get($redis_key);
		//没有缓存则从数据库读取
		if($myclasscreditlist === false)
		{
			$myclasscreditlist = $this->getmyclasscreditlist();
			$redis->set($redis_key, serialize($myclasscreditlist), 300);//300秒过期
			
		}
		else
		{
			$myclasscreditlist = unserialize($myclasscreditlist);
		}
		//排除当前用户，只取前5条记录
		$newcreditcount = 0;
		foreach($myclasscreditlist as $value)
		{
			if ($value['uid'] != $user['uid'] && $newcreditcount < 5)
			{
				$newcreditlist[] = $value;
				$newcreditcount++;
			}
		}
		
		$uri = Ebh::app()->getUri();
		$param['page'] = $uri->page;
		$param['pagesize'] = 56;
			
		$count = $credit->getRankListCount(array('crid'=>$roominfo['crid']));
		$conditon['limit'] = max(0, ($param['page'] - 1) * $param['pagesize']).','.$param['pagesize'];
		$pagestr = ajaxpage($count,$param['pagesize']);
		
		$rankinfo =  $this->getRank($roominfo,$user,$conditon);
		//格式化获取科举名称
		foreach ($rankinfo['ranklist'] as $key=> $item){
			$rankinfo['ranklist'][$key]['ranktit'] = $this->getlvltit($item['credit']);
		}
		$baseinfo = $this->getbaseinfo();
		$this->assign('baseinfo',$baseinfo);
		$this->assign('clinfo', $rankinfo['clinfo']);
		$this->assign('ranklist', $rankinfo['ranklist']);
		$this->assign('mycreditlist',$mycreditlist);
		$this->assign('othercreditlist',$newcreditlist);
		$this->assign('roominfo',$roominfo);
		$this->assign('user',$user);
		$this->assign('pagestr', $pagestr);
		$this->init();
		$this->display('ghrecord');
	}
	/**
	 * 获取同学成长记录
	 */
	public function getmyclasscreditlist() {
		$roominfo = Ebh::app()->room->getcurroom();
		$credit = $this->model('credit');
		$classmodel = $this->model('classes');

		if(!empty($this->myclass)){
			$queryarr['classid'] = $this->myclass['classid'];
			$queryarr['limit'] = '1000'; 
			$students = $classmodel->getClassStudentList($queryarr);//取班级学生列表，不排除自己
			//获取该班级6个学生。因为有可能取到自己，所以多取一个。
			if($students){
				$students_count = count($students);
				if($students_count>6){
					$keys = array_rand($students, 6);
					foreach ($keys as $key)
					{
						$uids[] = $students[$key]['uid'];
					}
				}elseif ($students_count>1){
					foreach ($students as $stu)
					{
						$uids[] = $stu['uid'];
					}
				}

				if (!empty($uids)) {
					$othercreditlist = $credit->getCreditByUids(array('uids'=>$uids));
				}
				else {
					$othercreditlist = array();
				}
			}
		}

		if(empty($othercreditlist)){
			$othercreditlist = array();
		}
		
		//不足5条记录获取全校的积分记录
		if(count($othercreditlist)<6){
			$param['limit'] = ' 0,'.(6-count($othercreditlist));
			$param['crid'] = $roominfo['crid'];
			if(isset($uids)){
				$param['nuids'] = $uids;
			}
			$tmpclist = $credit->getCreditByCrid($param);
		}
		
		$othercreditlist = empty($othercreditlist) ? array() : $othercreditlist;
		$tmpclist = empty($tmpclist) ? array() : $tmpclist;
		$newcreditlist = array_merge($othercreditlist,$tmpclist);
		return $newcreditlist;
	}
	
	/*
	 * ajax方式获取学霸排名
	 */
	public function getrankajax(){
		$user = Ebh::app()->user->getloginuser();
		$roominfo = Ebh::app()->room->getcurroom();
		
		$page = intval($this->input->post('page'));
		$param['page'] = $page > 0 ? $page : 1;
		$param['pagesize'] = 56;
		
		$credit = $this->model('credit');
		$count = $credit->getRankListCount(array('crid'=>$roominfo['crid']));
		$conditon['limit'] = max(0, ($param['page'] - 1) * $param['pagesize']).','.$param['pagesize'];
		$pagestr = ajaxpage($count,$param['pagesize'],$param['page']);
		$rankinfo =  $this->getRank($roominfo,$user,$conditon);
		//格式化获取科举名称
		foreach ($rankinfo['ranklist'] as $key=> $item){
			$rankinfo['ranklist'][$key]['ranktit'] = $this->getlvltit($item['credit']);
		}
		$data['pagestr'] = $pagestr;
		$data['rankliststr'] = $this->getranklisthtml($rankinfo['ranklist']);
		echo json_encode($data);
	}
	
	/*
	 积分统计图表
	*/
	public function creditStat(){
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		$datefrom = strtotime($this->input->get('dayfrom'));
		$dateto = strtotime($this->input->get('dayto'));
		$creditmodel = $this->model('credit');
		$rulelist = $creditmodel->getCreditRuleList(array('action'=>'+'));
		$ruleids = '';
		foreach($rulelist as $rule){
			if($rule['ruleid'] != 29)
			$ruleids.= empty($ruleids)?$rule['ruleid']:','.$rule['ruleid'];
		}
		$param['ruleids'] = $ruleids;
		$param['uids'] = $user['uid'];
		$param['group'] = ' d ';
		$param['datefrom'] = $datefrom;
		$param['dateto'] = $dateto+86400;
		// var_dump($param);
		$mycclist = $creditmodel->getCreditComingList($param);//我的积分记录
		
		$redis = Ebh::app()->getCache('cache_redis');
		$crcclist = $redis->hget('credit',$roominfo['crid']);
		$crcclist = unserialize($crcclist);
		// var_dump($crcclist);
		$fromcache = true;
		$rumodel = $this->model('roomuser');
		$usercount = $rumodel->getUserCountWhoLoged($roominfo['crid']);
		if(empty($crcclist)){
			// if($roominfo['domain'] == 'jx')
			$rulist = $rumodel->getUserListWhoLoged($roominfo['crid']);
			// else
				// $rulist = $rumodel->getroomuserlist(array('crid'=>$roominfo['crid'],'pagesize'=>1000));//学校学生列表
			$uids = '';
			foreach($rulist as $ru){
				$uids.= $ru['uid'].',';
			}
			
			$param['uids'] = rtrim($uids,',');
			$crcclist = $creditmodel->getCreditComingList($param);//全校积分记录
			
			foreach($crcclist as $crcredit){
				$creditcache[Date('Y/m/d',$crcredit['dateline'])] = $crcredit['sumcredit'];
			}
			// var_dump($creditcache);
			$redis->hset('credit',$roominfo['crid'],$creditcache);
			$fromcache = false;
		}
		// var_dump($rulist);
		$str = '"day,我的积分,全校平均积分,全校最高\n';
		// var_dump($crcclist);
		$dayarr = array();

		foreach($mycclist as $k=>$mycredit){
			$dayarr[Date('Y/m/d',$mycredit['dateline'])] = Date('Y/m/d',$mycredit['dateline']).','.$mycredit['sumcredit'].',';
		}
		//var_dump($dayarr);
		$maxcredit = 0;
		foreach($crcclist as $k=>$crcredit){
			if($crcredit>$maxcredit){
				$maxcredit = $crcredit;
			}
			if(empty($fromcache)){
				$day = Date('Y/m/d',$crcredit['dateline']);
				$avg = ceil($crcredit['sumcredit']/$usercount);
			}else{
				$day = $k;
				$avg = ceil($crcredit/$usercount);
			}
			if($day >= Date('Y/m/d',$param['datefrom']) && $day < Date('Y/m/d',$param['dateto'])){
				if(empty($dayarr[$day]))
					$dayarr[$day]= $day.',0,'.$avg.'\n';
				else
					$dayarr[$day].= $avg.'\n';
			}
		}//var_dump($dayarr);
		for($i=$param['datefrom'];$i<$param['dateto'];$i=$i+86400){
			$day = Date('Y/m/d',$i);
			if(empty($dayarr[$day]))
				$dayarr[$day] = $day.',0,0\n';
			elseif(substr($dayarr[$day],-2,2)!='\n')
				$dayarr[$day].= '0\n';
		}
		$maxcreditday = array_search($maxcredit, $crcclist);
		ksort($dayarr);
		
		foreach($dayarr as $k=>$day){
			if($k == $maxcreditday){
				$str .= substr($day,0,strlen($day)-2).','.$maxcredit.'\n';
			}else{
				$str .= substr($day,0,strlen($day)-2).',0'.'\n';
			}
		}
		$str.= '"';
		echo $str;
	}
	
	/*
	 积分排名
	*/
	private function getRank($roominfo,$user,$conditon){
		$crid = $roominfo['crid'];
		$creditmodel = $this->model('credit');
		$param['crid'] = $crid;
		$param['limit'] = $conditon['limit'];
		$ranklist = $creditmodel->getRankList($param);
		
		$clconfig = Ebh::app()->getConfig()->load('creditlevel');
		foreach($clconfig as $clevel){
			if($user['credit']>=$clevel['min'] && $user['credit']<=$clevel['max']){
				$clinfo['title'] = $clevel['title'];
				if($user['credit']<=500){
					$clinfo['percent'] = 50*intval($user['credit'])/500;
				}elseif($user['credit']<=3000){
					$clinfo['percent'] = 50+30*(intval($user['credit'])-500)/2500;
				}elseif($user['credit']<=10000){
					$clinfo['percent'] = 80+20*(intval($user['credit'])-3000)/7000;
				}else{
					$clinfo['percent'] = 100;
				}
				break;
			}
		}
		return array('ranklist'=>$ranklist,'clinfo'=>$clinfo);
	}
	
	/**
	 * 根据积分获取科举名称
	 */
	private function getlvltit($credit){
		$clconfig = Ebh::app()->getConfig()->load('creditlevel');
		foreach($clconfig as $clevel){
			if($credit>=$clevel['min'] && $credit<=$clevel['max']){
				$lvltit = $clevel['title'];
				break;
			}
		}
		return $lvltit;
	}
	
	/**
	 * 获取学霸排名html 
	 */
	private function getranklisthtml($ranklist){
		$html = '';
		foreach($ranklist as $item){
			$name = !empty($item['realname']) ? $item['realname'] : $item['username'];
			$imgtit = $name.'的个人空间';
			$html .= '<li class="dtuwrs"><a href="http://sns.ebh.net/'.$item['uid'].'/main.html" class="destgy" target="_blank"><span class="egirey">'.$name;
			$html .= '</span><img src="'.getavater($item,'50_50').'" title = "'.$imgtit.'" /></a><span class="srusdyt">'.$item['credit'].'</span>';
			$html .= '<span class="srusdyt">'.$item['ranktit'].'</span></li>';
		}
		return $html;
	}
	
	/**
	 * 获取成长记录基础数据 
	 */
	private function getbaseinfo(){
		$roominfo = Ebh::app()->room->getcurroom();
		//积分
		$user = Ebh::app()->user->getloginuser();
		$info['credit'] = $user['credit'];
		//签到
		$creditmodel = $this->model('credit');
		$signlogcount = $creditmodel->getSignLogCount(array('uid'=>$user['uid']));
		$info['signlogcount'] = $signlogcount;
		
		$askmodel = $this->model('Askquestion');
		$studymodel = $this->model('Studylog');
		$exammodel = $this->model('Exam');
		$classesmodel = $this->model('Classes');
		
		//作业
		$myclass = $this->myclass;
		$zqarr['uid'] = $user['uid'];
		$zqarr['crid'] = $roominfo['crid'];
		$zqarr['classid'] = $myclass['classid'];
		$zqarr['hasanswer'] = 1;
		if(!empty($myclass['grade'])) {	//班级有年级信息，则显示此年级下的所有作业
			$zqarr['grade'] = $myclass['grade'];
			$zqarr['district'] = $myclass['district'];
		}
		$myexamcount = $exammodel->getExamListCountByMemberid($zqarr);
		$info['myexamcount'] = $myexamcount;
		//学习
		$mystudycount = $studymodel->getStudyCount(array('uid'=>$user['uid'],'totalflag'=>0,'crid'=>$roominfo['crid']));
		$info['mystudycount'] = $mystudycount;
		//提问
		$myaskcount = $askmodel->getmyaskcount(array('uid'=>$user['uid'],'shield'=>0,'crid'=>$roominfo['crid']));
		$info['myaskcount'] = $myaskcount;
			
		//所有作业
		//先从缓存读取所有作业计数
		$redis = Ebh::app()->getCache('cache_redis');
		$redis_key = 'class_allexamcount_' . $myclass['classid'];
		$myallexamcount = $redis->get($redis_key);
		//没有缓存则从数据库读取
		if($myallexamcount === false)
		{
			$qarr['uid'] = $user['uid'];
			$qarr['crid'] = $roominfo['crid'];
			$qarr['classid'] = $myclass['classid'];
			if(!empty($myclass['grade'])) {	//班级有年级信息，则显示此年级下的所有作业
				$qarr['grade'] = $myclass['grade'];
				$qarr['district'] = $myclass['district'];
			}
			$myallexamcount = $exammodel->getExamListCountByMemberid($qarr);
			$redis->set($redis_key, $myallexamcount, 360);//360秒过期
		}
		else
		{
			$myallexamcount = intval($myallexamcount);
		}
		$info['myallexamcount'] = $myallexamcount;
		
		//答疑
		$myanscount = $askmodel->getaskcountbyanswers(array('uid'=>$user['uid'],'crid'=>$roominfo['crid'],'qshield'=>0,'ashield'=>0));
		$info['myanscount'] = $myanscount;
		//评论
		$reviewmodel = $this->model('review');
		$myreviewcount = $reviewmodel->getreviewcount(array('uid'=>$user['uid'],'rcrid'=>1,'status'=>1,'crid'=>$roominfo['crid']));
		$info['myreviewcount'] = $myreviewcount;
		//感谢(我的提问与我的回答)
		$myaskthankcount = $askmodel->getaskcountbythank(array('uid'=>$user['uid'],'crid'=>$roominfo['crid']));
		$myansthankcount = $askmodel->getanscountbythank(array('uid'=>$user['uid'],'crid'=>$roominfo['crid']));
		$info['mythankcount'] = $myaskthankcount + $myansthankcount;
		//日志
		$snsmodel = $this->model('Snsbase');
		$myarticlescount = $snsmodel->getarticlescount(array('uid'=>$user['uid'],'status'=>0));
		$info['myarticlescount'] = $myarticlescount;
		//新鲜事
		$myfeedscount = $snsmodel->getfeedscount(array('uid'=>$user['uid'],'status'=>0));
		$info['myfeedscount'] = $myfeedscount;
		//粉丝
		$mybaseinfo = $snsmodel->getbaseinfo($user['uid']);
		$info['myfanscount'] = $mybaseinfo['fansnum'];
		//关注
		$info['myfavoritcount'] = $mybaseinfo['followsnum'];
		return $info;
	}


	public function init(){
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		$this->assign('room',$roominfo);
		$percent = $this->getpercent($user);
        $this->assign('percent',$percent);


        $continuous = 0;
		$credit = $this->model('credit');
		$signparam['uid'] = $user['uid'];
		$signlog = $credit->getSignLog($signparam);
		if(!empty($signlog)){
			$lastsign = $signlog[0]['dateline'];
			$today = strtotime('today');
			$todayd = Date('z',SYSTIME);
			if($lastsign>$today){//今天已签到
				$this->assign('signed',1);
				$lastday = $todayd+1;
			}else{//今天未签到
				$lastday = $todayd;
			}
			foreach($signlog as $sign){//按天数倒序计算连续性,2,1,0,364,363...
				$day = Date('z',$sign['dateline']);
				$leap = Date('L',$sign['dateline']);
				
				if($day==$todayd || $lastday-$day==1 || ($leap && $lastday-$day==-365) || (!$leap && $lastday-$day==-364)){
					$lastday = $day;
					$continuous ++;
				}else{
					break;
				}
			}
		}
		$this->assign('continuous',$continuous);
		
	}
	public function getpercent($user){
    	$pc = 50;
    	if($user['face'])
    		$pc+=10;
    	$mmodel = $this->model('Member');
    	$info = $mmodel->getfullinfo($user['uid']);
    	unset($info['memberid'],$info['realname'],$info['face']);
    	foreach($info as $value){
    		if(!empty($value))
    			$pc+=2;
    	}
    	if($pc>100){$pc=100;}
    	return $pc;
    }

    public function home(){
    	$user = Ebh::app()->user->getloginuser();
		$roominfo = Ebh::app()->room->getcurroom();
		
		//个人积分明细
		$credit = $this->model('credit');
		$param['pagesize'] = 5;
		$param['toid'] = $user['uid'];
		$mycreditlist = $credit->getcreditlist($param);
				
		//获得所在班级
		$classmodel = $this->model('Classes');
		$myclass = $classmodel->getClassByUid($roominfo['crid'],$user['uid']);
		$this->myclass = $myclass;

		//随机取得5个同学积分明细，先获得6个学生积分信息，然后再去掉一个。
		//先从缓存读取同学成长记录
		$redis = Ebh::app()->getCache('cache_redis');
		$redis_key = 'class_creditlist_' . $myclass['classid'];
		$myclasscreditlist = $redis->get($redis_key);
		//没有缓存则从数据库读取
		if($myclasscreditlist === false)
		{
			$myclasscreditlist = $this->getmyclasscreditlist();
			$redis->set($redis_key, serialize($myclasscreditlist), 300);//300秒过期
			
		}
		else
		{
			$myclasscreditlist = unserialize($myclasscreditlist);
		}
		//排除当前用户，只取前5条记录
		$newcreditcount = 0;
		foreach($myclasscreditlist as $value)
		{
			if ($value['uid'] != $user['uid'] && $newcreditcount < 5)
			{
				$newcreditlist[] = $value;
				$newcreditcount++;
			}
		}
		
		$uri = Ebh::app()->getUri();
		$param['page'] = $uri->page;
		$param['pagesize'] = 56;
			
		$count = $credit->getRankListCount(array('crid'=>$roominfo['crid']));
		$conditon['limit'] = max(0, ($param['page'] - 1) * $param['pagesize']).','.$param['pagesize'];
		$pagestr = ajaxpage($count,$param['pagesize']);
		
		$rankinfo =  $this->getRank($roominfo,$user,$conditon);
		//格式化获取科举名称
		foreach ($rankinfo['ranklist'] as $key=> $item){
			$rankinfo['ranklist'][$key]['ranktit'] = $this->getlvltit($item['credit']);
		}
		$baseinfo = $this->getbaseinfo();
		//我的班级信息
		$cmodel = $this->model('Classes');
		$myclass = $cmodel->getClassByUid($roominfo['crid'],$user['uid']);
		$myclassid = empty($myclass) ? 0 : $myclass['classid'];
		$this->assign('myclass',$myclass);

		//获取通知
		$noticemodel = $this->model('Notice');
        $noticeparam = array('crid'=>$roominfo['crid'],'classid'=>$myclassid,'ntype'=>'1,3,4,5','limit'=>'0,6','needgrade'=>true,'needdistrict'=>true);
        $notices = $noticemodel->getnoticelist($noticeparam);
        $this->assign('notices', $notices);

		$this->assign('baseinfo',$baseinfo);
		$this->assign('clinfo', $rankinfo['clinfo']);
		$this->assign('ranklist', $rankinfo['ranklist']);
		$this->assign('mycreditlist',$mycreditlist);
		if(empty($newcreditlist)){
			$newcreditlist = array();
		}
		$this->assign('othercreditlist',$newcreditlist);
		$this->assign('roominfo',$roominfo);
		$this->assign('user',$user);
		$this->assign('pagestr', $pagestr);
		$this->init();
		$this->display('home');
    }
}