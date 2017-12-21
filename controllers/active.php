<?php
class ActiveController extends CControl{
	 public function __construct() {
        parent::__construct();
		$user = Ebh::app()->user->getloginuser();
		$check = TRUE;
		if(empty($user['uid']) || empty($_COOKIE['jz_dm'])) {
		//if(empty($user['uid'])) {
			$check = Ebh::app()->room->checkstudent(TRUE);
			if (empty($_COOKIE['jz_dm'])) {
				$url = '/';
				header("Location: $url");
				exit();
			}
		} else {
			Ebh::app()->room->checkstudent();
		}
		$this->assign('check',$check);
    }
	//活跃指数
    public function index() {
		$chart = Ebh::app()->lib('ChartLib');
		$user = Ebh::app()->user->getloginuser();
		$roominfo = Ebh::app()->room->getcurroom();
		$classmodel = $this->model('Classes');
		$myclass = $classmodel->getClassByUid($roominfo['crid'],$user['uid']);
		$analysismodel = $this->model('analysis');
		$daystate = $this->input->get('daystate')==NULL?1:intval($this->input->get('daystate'));
		if($daystate>4){
			$daystate = 5;
			$param['dayfrom'] = strtotime($this->input->get('dayfrom'));
			$param['dayto'] = strtotime($this->input->get('dayto')) + 86400;
			$this->assign('dayfrom',$this->input->get('dayfrom'));
			$this->assign('dayto',$this->input->get('dayto'));
		}else{
			$param = $this->getDayPeriod($daystate);
		}
		$param['uid'] = $user['uid'];
		$param['crid'] = $roominfo['crid'];
		$myaskcount = intval($analysismodel->getAskCount($param));
		$myanswercount = intval($analysismodel->getAnswerCount($param));
		$myreviewcount = intval($analysismodel->getReviewCount($param));
		
		
		$param['needall'] = 1;
		$allaskcount = intval($analysismodel->getAskCount($param));
		$allanswercount = intval($analysismodel->getAnswerCount($param));
		$allreviewcount = intval($analysismodel->getReviewCount($param));
		
		
		
		$classstunum = intval($analysismodel->getclassmatecount($user['uid'],$roominfo['crid']));
		$classroom = $this->model('classroom');
		$roomdetail = $classroom->getdetailclassroom($roominfo['crid']);
		
		$datamy = $myaskcount+$myanswercount+$myreviewcount;
		$dataall = $allaskcount+$allanswercount+$allreviewcount;;
		
		if(!empty($myclass)){
			$param['needclass'] = 1;
			$classaskcount = intval($analysismodel->getAskCount($param));
			$classanswercount = intval($analysismodel->getAnswerCount($param));
			$classreviewcount = intval($analysismodel->getReviewCount($param));
			$dataclass = $classaskcount+$classanswercount+$classreviewcount;
			$datas['同班同学的'] = ceil($dataclass/$classstunum);
			$datasask['同班同学的'] = ceil($classaskcount/$classstunum);
			$datasanswer['同班同学的'] = ceil($classanswercount/$classstunum);
			$datasreview['同班同学的'] = ceil($classreviewcount/$classstunum);
			$comparedata['class'] = $dataclass;
		}
		
		
		$datas['我的'] = $datamy;
		$datas['全校同学的'] = ceil($dataall/$roomdetail['stunum']);
		
		$dataarr = array(
			'caption'=>'活跃指数表',
			'datas'=>$datas
		);
		
		$datasask['我的'] = $myaskcount;
		$datasask['全校同学的'] = ceil($allaskcount/$roomdetail['stunum']);
		$dataarrask = array(
			'caption'=>'提问数',
			'datas'=>$datasask
		);
		
		$datasanswer['我的'] = $myanswercount;
		
		$datasanswer['全校同学的'] = ceil($allanswercount/$roomdetail['stunum']);
		$dataarranswer = array(
			'caption'=>'解答数',
			'datas'=>$datasanswer
		);
		
		$datasreview['我的'] = $myreviewcount;
		$datasreview['全校同学的'] = ceil($allreviewcount/$roomdetail['stunum']);
		$dataarrreview = array(
			'caption'=>'评论数',
			'datas'=>$datasreview
		);
		
		if(!empty($myclass)){
			$this->assign('classaskcount',$classaskcount);
			$this->assign('classanswercount',$classanswercount);
			$this->assign('classreviewcount',$classreviewcount);
			
			$comparedata['my'] = $datamy;
			$judgement = $this->getJudgement($comparedata,$classstunum);
			$this->assign('judgement',$judgement);
		}
		$this->assign('myclass',$myclass);
		$this->assign('daystate',$daystate);
		$this->assign('chart',$chart);
		$this->assign('myaskcount',$myaskcount);
		$this->assign('myanswercount',$myanswercount);
		$this->assign('myreviewcount',$myreviewcount);
		$this->assign('allaskcount',$allaskcount);
		$this->assign('allanswercount',$allanswercount);
		$this->assign('allreviewcount',$allreviewcount);
		
		$this->assign('dataarr',$dataarr);
		$this->assign('dataarrask',$dataarrask);
		$this->assign('dataarranswer',$dataarranswer);
		$this->assign('dataarrreview',$dataarrreview);
		$this->display('active');
    }
	private function getDayPeriod($daystate){
		switch($daystate){
			case 1://今天
				$param['dayfrom'] = strtotime('today');
				$param['dayto'] = $param['dayfrom'] + 86400;
				$param['prefix'] = '';
				$param['suffix'] = '';
				$param['xData'] = '';
			break;
			case 2://昨天
				$param['dayto'] = strtotime('today');
				$param['dayfrom'] = $param['dayto'] - 86400;
				$param['prefix'] = '';
				$param['suffix'] = '';
			break;
			case 3://本周
				$param['dayfrom'] = strtotime('last monday');
				$param['dayto'] = strtotime('next sunday');
				$param['prefix'] = '周';
				$param['suffix'] = '';
			break;
			case 4://本月
				$param['dayfrom'] = strtotime(Date("Y-m-01"));
				$param['dayto'] = strtotime('+1 month',$param['dayfrom']);
				$param['prefix'] = '';
				$param['suffix'] = '';
			break;
			
			default:
				$param['dayfrom'] = 0;
				$param['dayto'] = 9999999999;
				$param['prefix'] = '';
				$param['suffix'] = '';
			break;
		}
		return $param;
	}
	private function getJudgement($comparedata,$stunum){
		$judgearr = array(
		'0'=>array('img'=>'buhao','des'=>'不给力哦','level'=>'下游'),
		'1'=>array('img'=>'yiban','des'=>'一般','level'=>'中等'),
		'2'=>array('img'=>'henhao','des'=>'非常好','level'=>'上游')
		);
		$avg = $comparedata['class']/$stunum;
		if(($comparedata['my']-$avg)>3)
			return $judgearr[2];
		elseif(($comparedata['my']-$avg)>=0)
			return $judgearr[1];
		else
			return $judgearr[0];
	}
}
?>