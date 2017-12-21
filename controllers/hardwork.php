<?php
class HardworkController extends CControl{
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
	//勤奋度
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
		
		$myexamcount = intval($analysismodel->getExamCount($param));
		$mystudycount = intval($analysismodel->getStudyCount($param));
		
		$param['needall'] = 1;
		$allexamcount = intval($analysismodel->getExamCount($param));
		$allstudycount = intval($analysismodel->getStudyCount($param));
		$classstunum = intval($analysismodel->getclassmatecount($user['uid'],$roominfo['crid']));
		$datamy = $myexamcount + $mystudycount;
		$dataall = $allexamcount + $allstudycount;
		if(!empty($myclass)){
			$param['needclass'] = 1;
			$classexamcount = intval($analysismodel->getExamCount($param));
			$classstudycount = intval($analysismodel->getStudyCount($param));
			$dataclass = $classexamcount + $classstudycount;
			$datas['同班同学的'] = ceil($dataclass/$classstunum);
			$datasexam['同班同学的'] = ceil($classexamcount/$classstunum);
			$datasstudy['同班同学的'] = ceil($classstudycount/$classstunum);
			$comparedata['class'] = $dataclass;
			$comparedata['my'] = $datamy;
		}
		
		
		
		
		
		$classroom = $this->model('classroom');
		$roomdetail = $classroom->getdetailclassroom($roominfo['crid']);
		
		$datas['我的'] = $datamy;
		$datas['全校同学的'] = ceil($dataall/$roomdetail['stunum']);
		$dataarr = array(
			'caption'=>'勤奋指数表',
			'datas'=>$datas
		);
		
		
		$datasexam['我的'] = $myexamcount;
		$datasexam['全校同学的'] = ceil($allexamcount/$roomdetail['stunum']);
		$dataarrexam = array(
			'caption'=>'作业数',
			'datas'=>$datasexam
		);
		
		$datasstudy['我的'] = $mystudycount;
		
		$datasstudy['全校同学的'] = ceil($allstudycount/$roomdetail['stunum']);
		$dataarrstudy = array(
			'caption'=>'听课数',
			'datas'=>$datasstudy
		);
		
		if(!empty($myclass)){
			$judgement = $this->getJudgement($comparedata,$classstunum);
			$this->assign('judgement',$judgement);
			$this->assign('classexamcount',$classexamcount);
			$this->assign('classstudycount',$classstudycount);
		}
		$this->assign('myclass',$myclass);
		$this->assign('daystate',$daystate);
		$this->assign('chart',$chart);
		$this->assign('myexamcount',$myexamcount);
		$this->assign('allexamcount',$allexamcount);
		$this->assign('mystudycount',$mystudycount);
		$this->assign('allstudycount',$allstudycount);
		$this->assign('dataarr',$dataarr);
		$this->assign('dataarrexam',$dataarrexam);
		$this->assign('dataarrstudy',$dataarrstudy);
		$this->display('hardwork');
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