<?php
/**
 * 班级作业控制器类Examv2Controller
 */

class Examv2Controller extends CControl {
	private $user = NULL;
	private $room = NULL;
	private $k = "";
    public function __construct() {
		parent::__construct();
        EBH::app()->helper('examv2');
        $this->_initSource();
		$roominfo = Ebh::app()->room->getcurroom();
		if($roominfo['isschool'] == 6 || $roominfo['isschool'] == 7) {
			$check = Ebh::app()->room->checkstudent(TRUE);
			if($roominfo['isschool'] == 7 && $check != 1) {
				$folderid = $this->input->get('folderid');
				$perparam = array('crid'=>$roominfo['crid']);
				if(!empty($folderid) && is_numeric($folderid))
					$perparam['folderid'] = $folderid;
				$payitem = Ebh::app()->room->getUserPayItem($perparam);
				$this->assign('payitem',$payitem);
				if(!empty($payitem)) {
					$checkurl = '/ibuy.html?itemid='.$payitem['itemid'];	//购买url
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
		$user = Ebh::app()->user->getloginuser();
		if(empty($user)) {
			echo '用户未登陆';
			exit;
		}
		$this->_assignCheckUrl();
		$this->user = $user;
		$this->room = $roominfo;
		$this->k = authcode(json_encode(array('uid'=>$user['uid'],'crid'=>$roominfo['crid'],'t'=>SYSTIME)),'ENCODE');
		$this->assign('k',$this->k);
		$this->assign('crid',$roominfo['crid']);
		$this->assign('uid',$user['uid']);
		$this->assign('room',$roominfo);
        
    }

    /**
     *定义数据服务器常量
     */
    private function _initSource(){
        //数据服务器地址
        $dataserver = EBH::app()->getConfig('dataserver')->load('dataserver');
        $servers = $dataserver['servers'];
        //随机抽取一台服务器
        $target_server = $servers[array_rand($servers,1)];
        defined('__SURL__') or define('__SURL__', $target_server);
    }

    /*
     **作业列表页面
     */
    public function index() {
        //$this->elistAjax();
        $this->display('examlist');
	}

	 /*
     **课程关联下的作业
     */
    public function myExamAll() {
    	$folderid = intval($this->input->get('folderid'));
    	if ($folderid) {
    		$foldermodel = $this->model('folder');
			$folder = $foldermodel->getfolderbyid($folderid);
			$this->assign('folder',$folder);
    		$this->display('college/myexamv2_all');
    	} else {
    		$this->display('college/examlist');
    	}
	}

	/*
     **ajax获取作业列表 
     */
	public function elistAjax() {
		$param = parsequery();
		$param['k'] = $this->k;
		$estype = $this->input->post('estype');
		if(!empty($estype)) {
			$param['estype'] = $estype;
		}
		$action = $this->input->post('action');
		$param['action'] = !empty($action) ? $action : 'fordo';
		$param['status'] = 1;
		$param['order'] = 'eid desc';

		$ttype = $this->input->post('ttype');
		if(!empty($ttype) && in_array($ttype,array('FOLDER','COURSE','CHAPTER'))) {
			// $param['ttype'] = $ttype;
		}

		// $tids = $this->input->post('tids');
		// if(is_array($tids)) {
			// array_walk($tids,function(&$value,$k){
				// $value = intval($value);
			// });
			// array_unique($tids);
			// if(!empty($tids)) {
				// $param['tids'] = $tids;
			// }
		// }
		// $param['q'] = 'asdasd';
		
		$param['crid'] = $this->room['crid'];
		
		//筛选的课程
		$folderid = $this->input->get('folderid');
		
	
		if(empty($folderid) && $action != 'hasdo'){//待做，免费，全校免费，开通未过期
			$folderids = $this->getfolderids();
			$cwids = $this->getcwids();
			if (empty($folderids))
				$this->renderJson('11111','未开通课程','');
		}elseif(!empty($folderid)){//指定课程
			$folderids = array($folderid);
		}else{//已做，所有课程
			$folderids = array();
		}
		$param['tids'] = $folderids;
		$param['cwids'] = empty($cwids)?array():$cwids;

		//班级获取班级
		$userArray = array($this->user['uid']);
		$classids = $this->model('classes')->getClassInfoByCrid($this->room['crid'],$userArray);
		if ($classids) {
			foreach ($classids as $class) {
				$param['classid'][] = $class['classid'];
			}
		}
		//某个老师布置的作业
		$param['teacherid'] = $this->input->get('teacherid');
		
		$url = "/exam/selist";
		$postRet = $this->do_post($url,$param);
		//作业列表
		$examList = $postRet->examList;
		$uidarr = array();
		$estypeIds = '';//作业类型id
		if (empty($examList)) {
			$this->renderJson(0,'',array('examList'=>array()));
		}
		foreach ($examList as $examinfo) {
			if ($examinfo->exam->estype)
				$estypeIds .= intval($examinfo->exam->estype).',';
			$examinfo->exam->datelineStr = timetostr($examinfo->exam->dateline);
			$uidarr[]= $examinfo->exam->uid;
		}

		//获得个作业对应的分类名称
		if (!empty($estypeIds)) {
			$estypeList = $this->model('schestype')->getEstypeByIds(substr($estypeIds, 0, -1));//类型名字
			if ($estypeList) {
				foreach ($estypeList as $value) {
					$estypeNames[$value['id']] = $value;
				}
			}
		}

		//插入老师数据
		if (!empty($estypeNames)) {
			if(!empty($uidarr)){
				$userarr = $this->model('user')->getUserArray($uidarr);
				foreach ($examList as $examinfo) {
					if (isset($estypeNames[$examinfo->exam->estype])) {
						$examinfo->exam->estype = $estypeNames[$examinfo->exam->estype]['estype'];//作业类型名字赋值
					}
					$examinfo->exam->realname = shortstr($userarr[$examinfo->exam->uid]['realname'],8);
					$examinfo->exam->realnametitle = $userarr[$examinfo->exam->uid]['realname'];
				}
			}
		} else {
			if(!empty($uidarr)){
				$userarr = $this->model('user')->getUserArray($uidarr);
				foreach ($examList as $examinfo) {
					$examinfo->exam->realname = shortstr($userarr[$examinfo->exam->uid]['realname'],8);
					$examinfo->exam->realnametitle = $userarr[$examinfo->exam->uid]['realname'];
				}
			}
		}
		
		$pagestr = ajaxpage($postRet->pageInfo->totalElement,$postRet->pageInfo->size,$postRet->pageInfo->number);

		$datas = array(
			'examList'=>$examList,
			'pagestr'=>$pagestr
		);
		$this->renderJson('0','',$datas);
	}

	/*
     **ajax获取课件作业列表 
     */
	public function getCwidExamsAjax() {
		$param = parsequery();
		$param['k'] = $this->k;
		$param['size'] = 100;
		$cwid = intval($this->input->post('cwid'));
		$param['action'] = !empty($action) ? $action : 'fordo';
		$param['status'] = 1;
		$param['order'] = 'eid desc';
		$param['cwids'] = array($cwid);
		//某个老师布置的作业
		
		$url = "/exam/selist";
		
		$postRet = $this->do_post($url,$param);
		//作业列表
		$examList = $postRet->examList;
		$uidarr = array();
		$estypeIds = '';//作业类型id
		foreach ($examList as $examinfo) {
			if ($examinfo->exam->estype)
				$estypeIds .= intval($examinfo->exam->estype).',';
			$examinfo->exam->datelineStr = timetostr($examinfo->exam->dateline);
			$uidarr[]= $examinfo->exam->uid;
		}

		//获得个作业对应的分类名称
		if (!empty($estypeIds)) {
			$estypeList = $this->model('schestype')->getEstypeByIds(substr($estypeIds, 0, -1));//类型名字
			if ($estypeList) {
				foreach ($estypeList as $value) {
					$estypeNames[$value['id']] = $value;
				}
			}
		}

		//插入老师数据
		if (!empty($estypeNames)) {
			if(!empty($uidarr)){
				$userarr = $this->model('user')->getUserArray($uidarr);
				foreach ($examList as $examinfo) {
					if (isset($estypeNames[$examinfo->exam->estype])) {
						$examinfo->exam->estype = $estypeNames[$examinfo->exam->estype]['estype'];//作业类型名字赋值
					}
					$examinfo->exam->realname = shortstr($userarr[$examinfo->exam->uid]['realname'],8);
					$examinfo->exam->realnametitle = $userarr[$examinfo->exam->uid]['realname'];
				}
			}
		} else {
			if(!empty($uidarr)){
				$userarr = $this->model('user')->getUserArray($uidarr);
				foreach ($examList as $examinfo) {
					$examinfo->exam->realname = shortstr($userarr[$examinfo->exam->uid]['realname'],8);
					$examinfo->exam->realnametitle = $userarr[$examinfo->exam->uid]['realname'];
				}
			}
		}

		$datas = array(
			'examList'=>$examList
		);
		$this->renderJson('0','',$datas);
	}

	//学生做作业页面
	public function doexam_view() {
		$isapp = isApp() ? 1 : 0;
		$this->assign('isapp',$isapp);
		$eid = $this->uri->itemid;
		$this->assign('eid',$eid);
		$this->assign('user',$this->user);
		$config = Ebh::app()->getConfig()->load('upconfig');
		//$subthumb_url = $config['subthumb_url'];
		//$this->assign('subthumb_url',$subthumb_url);
		$this->display('exam_do');
	}

	//已做页面
	public function doneexam_view() {
		$isapp = isApp() ? 1 : 0;
		$this->assign('isapp',$isapp);
		$eid = $this->uri->itemid;
		$this->assign('eid',$eid);
		$this->assign('user',$this->user);
		$this->display('exam_done');
	}

	//ajax获取考试试题
	public function getExamAjax(){
		$eid = $this->input->post('eid');
		$url = "/exam/simpleinfo/".$eid;
		$postRet = $this->do_post($url,array('k'=>$this->k));
		if(empty($postRet->info)) {
			$this->renderJson("2000","作业不存在");
		}
		// if(empty($postRet->info->crid) || $postRet->info->crid != $this->room['crid']){
			// $this->renderJson('10003','这份作业不属于这个学校');
		// }
		if($postRet->info->dtag == 1){
			$this->renderJson('10003','作业已删除');
		}
			
		$etype = $postRet->info->etype;
		if($etype == 'TSMART') {
			$url = '/exam/getsmart/'.$eid;
		}else {
			$url = '/exam/detail/fordo/'.$eid;
			// $url = '/exam/detail/forshow/'.$eid;
		}
		// var_dump($postRet);
		$param = array(
			'k'=>$this->k,
			'uid'=>$postRet->info->uid,
			'forexam'=>'teacher'
		);
		$postRet = $this->do_post($url,$param);
		$exam = $postRet->exam;
		
		$folderids = $this->getfolderids();
		$cwids = $this->getcwids();
		if(!in_array($exam->tid,$folderids) && !in_array($exam->cwid,$cwids) && empty($postRet->userAnswer))
			$this->renderJson('10003','未开通 '.$exam->relationname.',或者已过期',array(),true);
		
		// var_dump($postRet);

		//判断是否显示答案
		if ($exam->ansstarttime) {
			if (SYSTIME < $exam->ansstarttime)
				$exam->noAns = 1;
		}
		////////////////////////////////////////////////////123123123
		// foreach ($postRet->userAnswer->answerQueDetails as $key => $value) {
			// $qids[] = $value->qid;
			// $bids[] = $value->dqid;
		// }
		
		// array_multisort($qids, SORT_ASC, $bids, SORT_ASC, $postRet->userAnswer->answerQueDetails);
		

		$questionList = $postRet->questionList;

		if(!empty($postRet->userAnswer)) {
			$postRet->userAnswer->data = json_decode($postRet->userAnswer->data);
			if(!empty($postRet->userAnswer->answerQueDetails)){
				foreach($postRet->userAnswer->answerQueDetails as $k=>$v){
					$temp = $postRet->userAnswer->answerQueDetails[$k];
					unset($postRet->userAnswer->answerQueDetails[$k]);
					$postRet->userAnswer->answerQueDetails[$temp->qid] = $temp;
				}
			}

			$datas['userAnswer'] = $postRet->userAnswer;
			
		}

		foreach ($questionList as $question) {
			if (isX($question->question->quetype) && !empty($postRet->userAnswer)) {
				if (isset($postRet->userAnswer->answerQueDetails[$question->question->qid])) {
					$tempQue = $postRet->userAnswer->answerQueDetails[$question->question->qid];
					$question->question->extdata = json_decode($question->question->extdata,1);
					$this->parseDeWordQue($question->question->extdata, $tempQue, 1);//解析学生得分
					if (isset($tempQue->data['score'])) {//老师的批阅分覆盖自动批阅分
						insertWordQueScore($question->question->extdata, $tempQue->data);
					}
				}
			}
			foreach ($question->blanks as $blank) {
				unset($blank->isanswer);
				unset($blank->score);
			}
			
			// $question->question->questionid = $question->question->qid;
			// unset($question->question->qid);
			
			if($question->question->quetype == 'H'){//主观题
				$extdata = json_decode($question->question->extdata);
				
				$question->question->schcwid = $extdata->schcwid;
			}
		}
		$datas['exam'] = $exam;
		$datas['questionList'] = $questionList;

		
		
		if($exam->examstarttime>SYSTIME)
			$this->renderJson("1","未到作业开放时间");
			// echo '未到作业时间';
		// var_dump($exam->examstarttime);
		else
			$this->renderJson("0","",$datas);
	}

//获取主观题详情 此接口还需完善
	public function getSubjective() {
		$schcourseware = $this->model('Schcourseware');
		$cwid = $this->input->get('cwid');
		//$aid = $this->input->get('aid');
		$qid = $this->input->get('qid');
		$result = $schcourseware->getcourselist ( array('cwid'=>$cwid));
		if($result){
			$result = $result[0];
			if($result['cwname']){
				list($name,$suffix) = explode('.',$result['cwname']);
				$remark = '';
				$voices = '';
				$images = '';
				$note = null;
				$note = $schcourseware->getcoursenote ( array('cwid'=>$cwid,'uid'=>$this->user['uid'],'qid'=>$qid));
				//$notes = $schnote->block ( array('cwid'=>$cwid,'uid'=>$uid));
				if($note){
					if($note['remark']){
						$remark = $note['remark'];
						
					}
					if($note['images'])
						$images = $note['images'];
					if($note['voices'])
						$voices = $note['voices'];
				}
				$type = $result['type'];

				//获取主观题缩略图需要秘钥
				$clientip = $this->input->getip();
				$skey = $cwid.'\t'.$clientip;
				if (!empty($note['qid']))
					$skey .= '\t'.$note['qid'];
				$key = authcode($skey, 'ENCODE');
				$result = array('suffix'=>strtolower($suffix),'remark'=>$remark,'images'=>$images,'voices'=>$voices,'note'=>$note,'type'=>$type,'key'=>$key);
			}
		}
		$status = empty ( $result ) ? array('result'=>0) : $result;
		echo json_encode ( $status );

	}

	/*
     * 获取作业类型列表
     */
    public function getEstypeList() {
    	$id = intval($this->input->post('id'));
    	$order = intval($this->input->post('order'));
    	$uid = intval($this->input->post('uid'));

    	if ($id)
    		$param['id'] = $id;
    	if ($order)
    		$param['order'] = $order;
    	if ($uid)
    		$param['uid'] = $uid;
    	$param['crid'] = $this->room['crid'];

    	$result = $this->model('schestype')->getEstypeList($param);
    	echo json_encode($result);
    }
	
	public function delupanswer(){
		$schcourseware = $this->model('Schcourseware');
		$cwid = $this->input->post('schcwid');
		$qid = $this->input->post('qid');
		$upanswer = $this->input->post('upanswer');
		$result = $schcourseware->delupanswer(array('cwid'=>intval($cwid),'qid'=>intval($qid),'upanswer'=>$upanswer,'uid'=>$this->user['uid']));
		$status = $result ? array ('status' => 1 ) : array ('status' => 0 );
		echo json_encode($status);
	}
	//获取教师布置的智能作业下学生生成的作业列表
	public function smartexamListAjax() {
		//教师智能作业eid编号
		$eid = $this->input->post('eid');
		if(empty($eid)) {
			$this->renderJson("12000","eid参数无法检测到");
		}
		$url = "/exam/smartexam/list/".$eid;
		$param = array(
			'k'=>$this->k
		);
		echo $this->do_post($url,$param,false);
	}

	//上传答案
	public function upAnswerAjax() {
		$eid = $this->input->post('eid');
		$url = "/exam/simpleinfo/".$eid;
		$simpleinfo = $this->do_post($url,array('k'=>$this->k));
		if(!empty($simpleinfo->info)){
			$info = $simpleinfo->info;
			$starttime = $info->examstarttime;
			$endtime = $info->examendtime;
			$trueendtime = $endtime + $info->limittime*60;
			
			if($starttime > SYSTIME || (!empty($endtime) && $trueendtime < SYSTIME) )
				$this->renderJson("10003","作业未开放或已过期");
		}else{
			$this->renderJson("10003","作业不存在");
		}
		
		
		$userAnswer = array();
		$status = $this->input->post('status');
		if(!is_numeric($status) || !in_array($status,array(0,1))) {
			$this->renderJson('100','status无效');
		}
		$userAnswer['status'] = $status;

		$usedtime = $this->input->post('completetime');

		if(!is_numeric($usedtime)) {
			$this->renderJson('100','usedtime无效');
		}

		$userAnswer['usedtime'] = $usedtime;
		
		$userAnswer['uid'] = $this->user['uid'];
		$data = $this->input->post('ques',false);
		
		if(empty($data)) {
			$this->renderJson('100','data不能为空');
		}
		
		$schcwidlist = array();
		foreach($data as $q){
			// var_dump($q);die;
			$answers = array();
			if(in_array($q['type'],array('A','B'))){//单选多选
				$qOptioncount = isset($q['optioncount'])?$q['optioncount']:0;
				for($i=0;$i<$qOptioncount;$i++){//各选项置0
					$answers[] = 0;
				}
				for($i=0;$i<strlen($q['answers']);$i++){//选择的选项置1
					$answers[ord($q['answers'][$i])-65] = 1;
				}
				$doAlert = 1;//是否有弹窗，对于只有主观题的弹窗不给
			}elseif($q['type'] == 'D'){//判断
				if($q['answers'] == '-1'){
					$answers = array(0,0);
				}else{
					$answers = array(0,0);
					$answer = intval($q['answers']);
					$answers[1-$answer] = 1;
				}
				$doAlert = 1;
			}
			elseif($q['type'] == 'X' || $q['type'] == 'XWX' || $q['type'] == "XYD" || $q['type'] == 'XTL' || $q['type'] == 'XZH'){//完形
				// $answer = json_decode(str_replace('&quot;','"',$q['answers']));
				// foreach($answer as $a){
					
				// }
				
				
				$url = '/question/detail/'.$q['qid'];//查看原题,答案等
				$param = array(
					'k'=>$this->k,
					'qid'=>$q['qid'],
					'userAnswer'=>$userAnswer
				);
				$questionjson = $this->do_post($url,$param,false);
				$question = json_decode($questionjson);
				$extdata = json_decode($question->datas->question->extdata);
				$extdata->status = $question->datas->question->status;
				// var_dump($q['datapackage']);
				// $q['datapackage'] = str_replace('&quot;','"',$q['datapackage']);
				// $q['datapackage'] = str_replace('&lt;','<',$q['datapackage']);
				// $q['datapackage'] = str_replace('&gt','>',$q['datapackage']);
				// var_dump(($extdata));
				checkX($extdata,$q);
				// var_dump($q);
				$dataPackage = json_decode($q['datapackage']);
				//print_r($dataPackage);exit;
				$dataPackage->uscore = round(($dataPackage->uscore/$dataPackage->totalscore)*$question->datas->question->quescore,0);//兼容智能作业的的得分率
				$answers = array($dataPackage);
				$doAlert = 1;
				//print_r($answers);exit;
				// var_dump($answers);
			}elseif($q['type'] == 'H'){
				$url = '/question/detail/'.$q['qid'];
				$param = array(
					'k'=>$this->k,
					'qid'=>$q['qid'],
					'userAnswer'=>$userAnswer
				);
				$questionjson = $this->do_post($url,$param,false);
				$question = json_decode($questionjson);
				$extdata = json_decode($question->datas->question->extdata);

				if (!empty($extdata->schcwid) && !empty($question->datas->question->qid)) {
					$schcwidlist[] = $extdata->schcwid;
					$qidlist[] = $question->datas->question->qid;
				}
				
				$answers = array('');
			}
			elseif(!empty($q['answers']) && !is_array($q['answers']))//文字题等
				$answers = empty($q['answers'])?array():array($q['answers']);
			else
				$answers = empty($q['answers'])?array():$q['answers'];
			// var_dump($schcwidlist);
			
				// exit;
			$answermap[$q['qid']] = $answers;//array(0,1);
		}
		// exit;
		// var_dump($answermap);exit;
		
		//print_r(1221);exit;
		if(!is_scalar($data)) {
			$data = json_encode(array('answermap'=>$answermap));
		}
		$userAnswer['data'] = $data;

		if(!is_numeric($eid)) {
			$this->renderJson('100','eid无效');
		}

		$aid = $this->input->post('aid');
		if(is_numeric($aid) && $aid > 0) {
			$userAnswer['aid'] = $aid;
		}

		$url = "/useranswer/save";
// var_dump($userAnswer);exit;
		$param = array(
			'k'=>$this->k,
			'eid'=>$eid,
			'userAnswer'=>$userAnswer
		);
		//关联班级把学生班级id传过去
		if (!empty($simpleinfo->info->isclass)) {
			$classidArr = $this->model('Classes')->getClassByUid($this->room['crid'], $this->user['uid'],$returnList=true);
			if (!empty($classidArr)) {
				$param['classids'] = array_column($classidArr,'classid');
			}
		}
		$resultjson = $this->do_post($url,$param,false);
		//print_r($resultjson);exit;
		if($simpleinfo->info->canreexam == 1 && $simpleinfo->info->etype == 'SSMART'){
			$temp = json_decode($resultjson);
			$temp->datas->canreexam = 1;
			$resultjson = json_encode($temp);
		}
		if (isset($doAlert)) {
			$temp = json_decode($resultjson);
			if (!empty($temp)) {
				$temp->datas->doAlert = 1;
				$resultjson = json_encode($temp);
			}
		}
		echo $resultjson;
		$answerRet = json_decode($resultjson);
		if (!empty($answerRet->datas->userAnswer->aid)) {
			$aid = $answerRet->datas->userAnswer->aid;
			if(!empty($schcwidlist)){//更新主观题aid
				// var_dump($schcwidlist);
				$schcourseware = $this->model('Schcourseware');
				$schcourseware->updateaid(array('uid'=>$this->user['uid'],
												'cwidlist'=>$schcwidlist,
												'aid'=>$aid,
												'qidlist'=>$qidlist));
				
			}
		}
	}

	//错题集列表页面
	
	public function myerrorbook() {
		$this->display('exam_errorlist');
	}

	public function myexamerrorlist() {
		$folderid = intval($this->input->get('folderid'));
		$foldermodel = $this->model('folder');
		$folder = $foldermodel->getfolderbyid($folderid);
		$this->assign('folder',$folder);
		$this->display('college/myexamv2_errorlist');
	}
	
	//获取错题集列表
	public function errlistAjax(){
		$param = parsequery();
		$param['k'] = $this->k;
		$param['crid'] = $this->room['crid'];
		$quetype = $this->input->post('quetype');
		// $folderid = $this->input->post('folderid');
		$chapterid = $this->input->post('chapterid');
		$topchapterid = $this->input->post('topchapterid');
		$secchapterid = $this->input->post('secchapterid');
		$path = $this->input->post('path');
		$eid = $this->input->post('eid');
		if(!empty($quetype)) {
			$param['quetype'] = $quetype;
		}

		$ttype = $this->input->post('ttype');
		$tid = $this->input->post("tid");
		
		$param['ttype'] = empty($ttype)?'':$ttype;
		
		if(is_numeric($tid)) {
			$param['tid'] = $tid;
		}

		$q = $this->input->post('q');
		if(!empty($q)) {
			$param['q'] = $q;
		}
		// $param['folderid'] = $folderid;
		$param['forwho'] = 'student';
		$param['chapterid'] = $chapterid;
		$param['topchapterid'] = $topchapterid;
		$param['secchapterid'] = $secchapterid;
		$param['path'] = $path;
		$param['eid'] = $eid;
		$param['order'] = 'errorid desc';
		if(!empty($eid))
			$param['style'] = 0;
		$url = "/errorbook/errlist";
		$postRet = $this->do_post($url,$param);
		//作业列表，组装主观题逻辑
		$errList = $postRet->errList;
		$typeHqids = '';
		$typeHcwids = '';
		$clientip = $this->input->getip();
		if (!empty($errList)) {
			foreach ($errList as $value) {
				$value->question->blanks = json_decode($value->question->data);
				if ('H' == $value->question->queType) {
					$extdata = json_decode($value->question->extdata,1);
					$typeHqids .= $value->question->qid.',';
					$typeHcwids .= $extdata['schcwid'].',';
				}
			}
		}

		//获取主观题缩略图需要秘钥
		//前端图片地址  var upimg = 'http://up.ebh.net/exam/getsubthumb.html?uid='+ uid+'&origin=1&key='+encodeURIComponent(result.key);
		//不为空说明有主观题，则组装上传的主观题逻辑主观题的逻辑
		if (!empty($typeHqids)) {
			$pram['cwids'] = substr($typeHcwids, 0, -1);
			$cwModel = $this->model('Schcourseware');
			$pram['limit'] = ' 0,100'; 
			$typeh_origins = $cwModel->getcourselist($pram);//获取原题
			$pram['uid'] = $this->user['uid'];
			$pram['qids'] = substr($typeHqids, 0, -1);
			$typeh_answers = $cwModel->getSchnotes($pram);//获取答题笔记
			foreach ($typeh_origins as $cwid) {
				$queh_map_cwid[$cwid['cwid']] = $cwid['type'];//组装判断是不是导入的主观题
			}
			if (!empty($typeh_answers)) {//有批阅或者学生答题的情况
				foreach ($typeh_answers as $hvalue) {
					$queh_map[$hvalue['qid']] = $hvalue;
				}
				foreach ($errList as $value) {
					if ('H' == $value->question->queType) {
						$extdata = json_decode($value->question->extdata,1);
						//以下组装主要是为了，前端判断是否是有key，key是获取图片的情况，没有前端就不会src='废弃地址'; 
						if (isset($queh_map[$value->question->qid])) {//有答题的情况
							$value->question->blanks->upanswer = empty($queh_map[$value->question->qid]['upanswer'])?'':$queh_map[$value->question->qid]['upanswer'];
							$extdata = json_decode($value->question->extdata,1);
							if (!empty($queh_map[$value->question->qid]['url'])) {//有笔记，笔记不为空，需要key
								$key = $extdata['schcwid'].'\t'.$clientip.'\t'.$value->question->qid;
								$value->question->blanks->key = authcode($key, 'ENCODE');
								$value->question->blanks->type = $queh_map_cwid[$extdata['schcwid']];
							} else {
								if ($queh_map_cwid[$extdata['schcwid']] == 1) {//导入的主观题，无笔记的，不需要原题图片，key为空
									$value->question->blanks->key = '';
									$value->question->blanks->type = 1;
								} else {//普通的需要原题
									$key = $extdata['schcwid'].'\t'.$clientip.'\t'.$value->question->qid;
									$value->question->blanks->key = authcode($key, 'ENCODE');
									$value->question->blanks->type = 0;//普通主观题
								}
							}
							
						} else {
							$value->question->blanks->upanswer = '';
							if ($queh_map_cwid[$extdata['schcwid']] == 1) {
								$value->question->blanks->key = '';
								$value->question->blanks->type = 1;//导入的主观题
							} else {
								$key = $extdata['schcwid'].'\t'.$clientip.'\t'.$value->question->qid;
								$value->question->blanks->key = authcode($key, 'ENCODE');
								$value->question->blanks->type = 0;//普通主观题
							}
						}
					}
				}
			} else {//没有答题笔记的情况
				foreach ($errList as $value) {
					if ('H' == $value->question->queType) {
						$value->question->blanks->upanswer = '';
						$extdata = json_decode($value->question->extdata,1);
						if ($queh_map_cwid[$extdata['schcwid']] == 1) {//导入的则不用key
							$value->question->blanks->type = 1;
							$value->question->blanks->key = '';
							continue;
						}
						$key = $extdata['schcwid'].'\t'.$clientip.'\t'.$value->question->qid;
						$value->question->blanks->key = authcode($key, 'ENCODE');
						$value->question->blanks->type = 0;
					}
				}
			}
		}
		$pagestr = ajaxpage($postRet->pageInfo->totalElement,$postRet->pageInfo->size,$postRet->pageInfo->number);

		$datas = array(
			'errList'=>$errList,
			'pagestr'=>$pagestr,
			'page'=>empty($param['page'])?1:$param['page']
		);
		$this->renderJson('0','',$datas);
	}

	//是否已经加入了错题集
	public function hasaddedAjax(){
		$dqid = $this->input->post('dqid');
		if(!is_numeric($dqid) || $dqid < 0) {
			$this->renderJson('100','dqid不符合规范');
		}
		$param = array(
			'k'=>$this->k,
			'dqid'=>$dqid
		);
		$url = "/errorbook/hasadded";
		echo $this->do_post($url,$param,false);
	}

	//加入到错题集
	public function addtobookAjax(){
		$dqid = $this->input->post('dqid');
		if(!is_numeric($dqid) || $dqid < 0) {
			$this->renderJson('100','dqid不符合规范');
		}

		$param = array(
			'k'=>$this->k
		);
		$url = "/errorbook/addtobook/".$dqid;
		echo $this->do_post($url,$param,false);
	}
	//统计分析页面
	public function efenxi_view(){
		$eid = $this->uri->itemid;
		$this->assign('eid',$eid);
		$this->assign('user',$this->user);
		$this->display('analysis_exam');
	}
	
	//统计分析
	public function efenxiAjax() {
		$url = "/exam/efenxi";
		$eid = $this->input->post('eid');
		$bytype = $this->input->post('bytype'); //que,level,relationship,quetype
		$data = array(
			'k'=>$this->k,
			'eid'=>$eid,
			'bytype'=>$bytype,
			'action'=>'student'
		);
		//班级
		$classid = $this->input->post('classid');
		$classidArr = explode(',', $classid);
		if ($classid) {
			$stUids = $this->model('classes')->getStudentUidByClassid($classidArr);
			if ($stUids) {
				foreach ($stUids as $uid) {
					$data['uids'][] = $uid['uid'];
				}
			}
		}

		//当为优秀率分析的时候，需要算出总人数
		if ($bytype == 'level') {
			$leveldatas = $this->do_post($url,$data,FALSE);
			$leveldatas = json_decode($leveldatas,1);
			if (!empty($leveldatas['datas'])) {
				$totalcount = 0;
				foreach ($leveldatas['datas']['efenxi'] as  $value) {
					$totalcount += $value['count'];
				}
			}
			$leveldatas['datas']['totalcount'] = $totalcount;
			$this->renderJson(0, '', $leveldatas['datas']);
		}
		echo  $this->do_post($url,$data,false);
	}
	
	/**
	 *请求作业分析,错题统计的头部数据
	 */
	public function getExamSummaryAjax(){
		$eid = $this->input->post('eid');
		$k = $this->input->post('k');
		$param = array(
			'k'=>$k,
			'eid'=>$eid,
		);
		$url = '/exam/efenxi/summary';
		$res = $this->do_post($url,$param,false);
		$datas = json_decode($res, 1);
		if (!empty($datas['errCode']))
			exit('服务器数据错误');
		$folderid = $datas['datas']['efenxisummary']['tid'];
		$datas['datas']['efenxisummary']['dateline'] = timetostr($datas['datas']['efenxisummary']['dateline']);
		$alluserscount = count($this->model('userpermission')->getUserIdListByFolder($folderid));//总人数
		$datas['datas']['alluserscount'] = $alluserscount;
		echo json_encode($datas);
	}
	
	/*
	巩固练习
	*/
	public function exercise_view(){
		$param = parsequery();
		$param['size'] = $param['pagesize'];
		unset($param['pagesize']);
		$eid = $this->uri->itemid;
		$url = "/exam/simpleinfo/".$eid;
		$postRet = $this->do_post($url,array('k'=>$this->k));
		if(empty($postRet))
			;
		if(empty($postRet->info->canreexam))
			exit('该作业无法巩固练习');
		$url = '/exam/getexeinfo/'.$eid;
		$param['k'] = $this->k;
		// $param['uid'] = $this->user['uid'];
		
		// var_dump($param);exit;
		$exerinfo = $this->do_post($url,$param);

		$typelist = array();
		foreach($exerinfo->exercise as $qtype=>$exe){
			foreach($exe as $que){
				if(!isset($typelist[$qtype][$que->path]['allcount']))
					$typelist[$qtype][$que->path]['allcount'] = 0;
				$typelist[$qtype][$que->path]['allcount']++;
				
				if(!isset($typelist[$qtype][$que->path]['rightcount']))
					$typelist[$qtype][$que->path]['rightcount'] = 0;
				$typelist[$qtype][$que->path]['rightcount'] += $que->allright;
				
				$typelist[$qtype][$que->path]['relationname'] = $que->relationname;
				$typelist[$qtype][$que->path]['chapterstr'] = $que->chapterstr;
			}
		}
		$this->assign('typelist',$typelist);
		$this->assign('exelist',$exerinfo->exelist);
		
		$this->assign('examinfo',$postRet->info);
		// var_dump($exerinfo);
		
		$this->display('college/exercise_view');
	}
	
	/*
	巩固练习列表
	*/
	public function getExerlist(){
		$eid = $this->input->post('eid');
		// $url = '/exam/getexeinfo/'.$eid;
		$param['k'] = $this->k;
		// $param['uid'] = $this->user['uid'];
		// $postRet = $this->do_post($url,$param);
		
		// echo json_encode($postRet);
		
	}
	/*
	生成巩固练习
	*/
	public function generateExercise(){
		$eid = $this->input->post('eid');
		
		$param['k'] = $this->k;
		$param['eid'] = $eid;
		$param['etype'] = 'EXERCISE';
		$url = '/exam/texamcount/';
		$postRet = $this->do_post($url,$param);
		$curcount = $postRet->count + 1;
		
		
		
		$url = '/exam/getsmart/'.$eid;
		$param['esubject'] = '巩固练习卷（'.$curcount.'）';
		$param['conditionList'] = $this->input->post('conditionlist');
		echo $this->do_post($url,$param,FALSE);
		// var_dump($param);
	}
	/*
	删除巩固练习
	*/
	public function delexe(){
		$eid = $this->input->post('eid');
		$url = '/exam/delexe/'.$eid;
		$param['k'] = $this->k;
		$postRet = $this->do_post($url,$param);
		
		echo json_encode($postRet);
		
	}
	/*
	单卷错题情况
	*/
	public function errsituation_view(){
		// $param['eid'] = $this->uri->itemid;
		// $param['k'] = $this->k;
		// $param['crid'] = $this->room['crid'];
		// $url = "/errorbook/errlist";

		// $postRet = $this->do_post($url,$param);
		// var_dump($postRet);
		$exampower = $this->input->get("exampower");
		$this->assign('exampower', $exampower);
		$this->display('errorSituation');
	}
	
		
	/*
	 * 学生错题头部信息
	 */
	public function stuSummaryAjax() {
		$eid = intval($this->input->post('eid'));
		if (empty($eid))
			$this->renderJson('0','missing eid');
		$url = "/exam/efenxi/stusummary";
		$data = array(
			'k'=>$this->k,
			'eid'=>$eid,
		);
		
		//班级
		$classid = $this->input->post('classid');
		$classidArr = explode(',', $classid);
		if ($classid) {
			$stUids = $this->model('classes')->getStudentUidByClassid($classidArr);
			if ($stUids) {
				foreach ($stUids as $uid) {
					$data['uids'][] = $uid['uid'];
				}
			}
		}
		
		$res = $this->do_post($url,$data,FALSE);
		$datas = json_decode($res, 1);
		if (!empty($datas['errCode']) OR empty($datas))
			exit('服务器数据错误');
		$folderid = $datas['datas']['efenxistu']['tid'];
		$datas['datas']['efenxistu']['dateline'] = date('Y-m-d H:i', $datas['datas']['efenxistu']['ansdateline']);

		//获取班级
		$userArray = array($this->user['uid']);
		$classids = $this->model('classes')->getClassInfoByCrid($this->room['crid'],$userArray);
		if ($classids) {
			foreach ($classids as $class) {
				$datas['myclassid'][] = $class['classid'];
			}
		}

		echo json_encode($datas);
	}
	
	
	

/*
	 **把1000,转成A
	 **param $str string
	 */
 	private function _numtostr($choicestr = '') {
 		if (!isset($choicestr))
 			return;
        $sstr = 'ABCDEFGHIJKLMNOPQ';
        $strArr = str_split($sstr);
        $returnStr = '';
        foreach ($strArr as $key => $value) {
        	if (substr($choicestr, $key, 1) && $value)
        		$returnStr .= $value;
        }
        return $returnStr;
    }
	
    /**
	 *分配购买地址
	 */
	private function _assignCheckUrl(){
		$roominfo = Ebh::app()->room->getcurroom();
		$crid = $roominfo['crid'];
		$checkurl = '/ibuy.html?itemid=';
		$this->assign('_checkurl',$checkurl);
	}

	/*
	 **私有方法，提交数据到java后台返回json数据
	 */
	private function do_post($uri, $data, $check = true){
		$url = 'http://'.__SURL__.$uri;
		$ch = curl_init();
		$datastr = (json_encode($data));
		
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); 
		curl_setopt($ch, CURLOPT_POST, TRUE); 
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_POSTFIELDS,$datastr);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		    'Content-Type: application/json',
		    'Content-Length: ' . strlen($datastr))
		);
		curl_setopt($ch, CURLOPT_URL, $url);
		$ret = curl_exec($ch);
		curl_close($ch);
		if($check == true) {
			$ret = json_decode($ret);
			$this->apiResCheck($ret);
			if (empty($ret->datas)) {
				return array();
			} else {
				return $ret->datas;
			}
		}else {
			return $ret;
		}
	}	

	/*
	 **输出提示的信息
	 */
	private function echoMsg($msg){
	    header("Content-type: text/html; charset=utf-8");
	    echo '<span style="font-size:16px;font-weight:bold;color:#f00;">',$msg,'</span>';
	    echo '<a style="font-size:16px;font-weight:bold;" href="javascript:history.go(-1)">点我返回!</a>';
	    exit;
	}

	/*
	 **检查java服务器返回的数据
	 */
	private function apiResCheck($res,$ajax = false){
	    if(empty($res)) {
	        $this->echoMsg("服务器取数据失败");exit;
	    }
	    if($res->errCode != 0) {
	        log_message("code:".$res->errCode.'--msg:'.$res->errMsg);
	        $this->echoMsg($res->errMsg);exit;
	    }
	}

	/*
	 **按规定向前台传数据
	 */
 	private function renderJson($errCode = 0,$errMsg = "",$datas = array() ,$ifexit = true) {
        echo json_encode(array('errCode'=>$errCode,'errMsg'=>$errMsg,'datas'=>$datas));
        if($ifexit) {
            exit;
        }
    }
	
	
	/*
	 *解析X类型题目
	 *$quevalue 教师原题
	 *$uquevalue 学生答案
	 *$tag 0 隐藏教师答案
	*/
	public function parseDeWordQue(&$quevalue,&$uquevalue,$tag = 0){
		if(empty($quevalue)){
			return;
		}
		$ans = $uquevalue->data;
		$adatapackage = json_decode($ans, 1);
		$uquevalue->data = $adatapackage;
		foreach ($quevalue['datapackage']['data'] as $itemskey=>&$items) {
			foreach ($items['detail'] as $itemkey => &$item) {
				if(empty($tag)){
					$item['t']['r'] = array_pad(array(),count($item['t']['r']),'');
				}
				if(!empty($adatapackage)){
					$item['u'] = $adatapackage['data'][$itemskey]['detail'][$itemkey]['u'];
				}
			}
		}
		$quevalue['datapackage'] = json_encode($quevalue['datapackage']);
	}
	/*
	 *解析X类型题目
	 *$quevalue 教师原题
	 *$uquevalue 学生答案
	 *$tag 0 隐藏教师答案 
	*/
	public function parseWordQue(&$quevalue,&$uquevalue,$tag = 0){
		if(empty($quevalue)){
			return;
		}
		$ans = $uquevalue['data'];
		$adatapackage = json_decode($ans, 1);
		$uquevalue['data'] = $adatapackage;
		foreach ($quevalue['datapackage']['data'] as $itemskey=>&$items) {
			foreach ($items['detail'] as $itemkey => &$item) {
				if(empty($tag)){
					$item['t']['r'] = array_pad(array(),count($item['t']['r']),'');
				}
				if(!empty($ans)){
					$item['u'] = $adatapackage['data'][$itemskey]['detail'][$itemkey]['u'];
				}	
			}
		}
		$quevalue['datapackage'] = json_encode($quevalue['datapackage']);
	}

	/**
	 *整卷批改页面数据
	 */
	public function paperCorrectAjax() {
		$aid = $this->input->post('aid');
		$eid = $this->input->post('eid');
		if(!is_numeric($eid) || $eid < 0 ) {
			$this->renderJson('120','eid不符合要求');
		}
		if(!is_numeric($aid) || $aid < 0 ) {
			$this->renderJson('120','aid不符合要求');
		}
		$param = array(
			'k'=>$this->k,
			'eid'=>$eid
		);

		//试题和答题信息
		$url = '/useranswer/getbyaid/'.$aid;
		$postRet = $this->do_post($url,$param,false);//获取试题信息
		$res = json_decode($postRet,1);
		if($res['datas']['userAnswer']['correctrat'] == 100){//已经批阅
			$this->renderJson('10003','已经批阅过',array('returnurl'=>'/college/examv2/doneexam/'.$eid.'.html'));
		}
		if (empty($res['datas']['questionList']))
			exit('试题列表不存在');
		foreach ($res['datas']['questionList'] as $key => $value) {
			$ques[] = $value['question'];//构建试题信息
			if ($value['question']['quetype'] == 'Z' OR $value['question']['quetype'] == 'G') {//兼容文本行没答题记录,音频题也有答题记录的
				$pushAnswer['qid'] = $value['question']['qid'];
				$pushAnswer['type'] = $value['question']['quetype'];
				$pushAnswer['status'] = 1;
				$pushAnswer['subject'] = $value['question']['qsubject'];
				array_push($res['datas']['userAnswer']['answerQueDetails'], $pushAnswer);
			}
		}
		$examinfo = $res['datas']['exam'];
		if (!$examinfo['stucancorrect']) {
			$this->renderJson('120','学生不能自主批改');
		}
		if (!empty($res['errCode']))
			exit('学生答题信息出错');
		$answeruid = $res['datas']['userAnswer']['uid'];//学生id
		$userinfo = $this->model('user')->getuserbyuid($answeruid);//学生详情

		//构建试题信息，统计总分
		$score = 0;
		foreach ($ques as $key => $value) {
			$score = $score + $value['quescore'];
			if(!empty($value['data'])){
			    $value['data'] = json_decode($value['data'],TRUE);
			}
			if(!empty($value['extdata'])){
			    $value['extdata'] = json_decode($value['extdata'],TRUE);
			}
			$ques[$key] =  $value['extdata'];//总体赋值
			$ques[$key]['chapterid'] = 0;
			foreach ($value['relationSet'] as $rvalue) {
				if ($rvalue['ttype'] == 'COURSE') {
					$ques[$key]['ccwid'] = $rvalue['tid'];
				} elseif ($rvalue['ttype'] == 'CHAPTER') {
					$ques[$key]['chapters'] .= $rvalue['tid'].',';
				} else {
					$ques[$key]['foldername'] = $rvalue['relationname'];
					$ques[$key]['folderid'] = $rvalue['tid'];//关联的课程
				}
			}
			$ques[$key]['subject'] = $value['qsubject'];
			$ques[$key]['questionid'] = $value['qid'];
			$ques[$key]['type'] = $value['quetype'];
			if ($ques[$key]['type'] == 'C') {//兼容填空题的总分
				$ques[$key]['score'] = $value['quescore']/count($ques[$key]['options']);
			} else {
				$ques[$key]['score'] = $value['quescore'];
			}
			$ques[$key]['dif'] = $value['level'];//难度
			$ques[$key]['resolve'] = empty($value['extdata']['jx']) ? '' : $value['extdata']['jx'];
			$ques[$key]['dianpin'] = empty($value['extdata']['dp']) ? '' : $value['extdata']['dp'];
			unset($ques[$key]['dp']);
			unset($ques[$key]['jx']);
			unset($ques[$key]['qid']);
		}

		//答题排序
		foreach ($res['datas']['userAnswer']['answerQueDetails'] as $value) {
			$qids[] = $value['qid'];
			//$bids[] = empty($value['dqid'])? 0 : $value['dqid'];
		}
		array_multisort($qids, SORT_ASC, $res['datas']['userAnswer']['answerQueDetails']);
		//构建用户答案,以及用户的得分
		foreach ($res['datas']['userAnswer']['answerQueDetails'] as $key => $value) {
			$ques[$key]['status'] = $value['status'];//该题批改状态,兼容单题批改
			$scoreArr[$key]['type'] = $ques[$key]['type'];//得分题型
			$ques[$key]['dqid'] = empty($value['dqid']) ? 0 : $value['dqid'];//每题的答题记录id
			$Ztype = array('A', 'B', 'D', 'H');
			if (in_array($ques[$key]['type'], $Ztype)) {
				$ques[$key]['aques'] = $ques[$key]['answers'];
				if ($ques[$key]['type'] == 'D') {//判断题的处理
					if ($value['choicestr'] != '00') {
						$ques[$key]['answers'] = explode(',',$value['data']);
					} else {
						$ques[$key]['answers'] = '00';
					}
				} else {
					$ques[$key]['answers'] = $this->_numtostr($value['choicestr']);
				}
				$scoreArr[$key]['showtype'] = $value['allright'];
				$scoreArr[$key]['score'] = $value['totalscore'];
			} elseif ($ques[$key]['type'] == 'Z' OR $ques[$key]['type'] == 'G') {
				continue;
			} elseif ($ques[$key]['type'] == 'C') {//填空题
				$ques[$key]['aques'] = $ques[$key]['options'];
				//空格排序
				foreach ($value['answerBlankDetails'] as $abvalue) {
					$abids[$key][] = $abvalue['bid'];
				}
				array_multisort($abids[$key], SORT_ASC,$value['answerBlankDetails']);
				if (!empty($value['answerBlankDetails'])) {
					foreach ($value['answerBlankDetails'] as $akey => $avalue) {
						$ques[$key]['answers'][] = $avalue['content'];//用户答题内容
						$ques[$key]['dbid'][] = $avalue['dbid'];//每个空的记录id
						$scoreArr[$key]['info'][$akey]['score'] = $avalue['score'];//构建分数
						$scoreArr[$key]['info'][$akey]['showtype'] = !empty($avalue['score']) ? 1 : 0;//构建showtype
					}
				}
			} elseif (isX($ques[$key]['type'])) {
				$this->parseWordQue($ques[$key], $value, 1);//解析学生得分
				if (isset($value['data']['score'])) {//老师的批阅分覆盖自动批阅分
					insertWordQueScore($ques[$key], $value['data']);
				}
			} else {//对文字题处理，只有一个blanklist
				$ques[$key]['aques'] = $ques[$key]['answers'];
				if (!empty($value['answerBlankDetails'])) {
					foreach ($value['answerBlankDetails'] as $akey => $avalue) {
						$ques[$key]['answers'] = $avalue['content'];//用户答题内容
						$ques[$key]['dbid'][] = $avalue['dbid'];//每个空的记录id
						$scoreArr[$key]['score'] = $avalue['score'];//构建分数
						$scoreArr[$key]['showtype'] = !empty($avalue['score']) ? 1 : 0;//构建showtype
					}
				}
			}
		}
	
		//构建输出数据
		$ajaxdata['aid'] = $aid;
		$ajaxdata['uid'] = $res['datas']['userAnswer']['uid'];
		$ajaxdata['completetime'] = $res['datas']['userAnswer']['usedtime'];
		$ajaxdata['crid'] = $this->room['crid'];
		$ajaxdata['dateline'] = $examinfo['dateline'];//这个作业信息没返回来
		$ajaxdata['eid'] = $examinfo['eid'];
		$ajaxdata['limitedtime'] = $examinfo['limittime'];
		$ajaxdata['remark'] = $res['datas']['userAnswer']['remark'];
		$ajaxdata['sdateline'] = $res['datas']['userAnswer']['ansdateline'];
		$ajaxdata['title'] = $examinfo['esubject'];
		$ajaxdata['totalscore'] = $res['datas']['userAnswer']['anstotalscore'];
		$ajaxdata['trealname'] = $this->user['realname'];
		$ajaxdata['tusername'] = $this->user['username'];
		$ajaxdata['username'] = $userinfo['username'];//学生账号
		$ajaxdata['realname'] = $userinfo['realname'];
		$ajaxdata['score'] = $score;
		$ajaxdata['ques'] = $ques;
		$ajaxdata['scoreArr'] = $scoreArr;

		echo json_encode($ajaxdata);
	}
	
	
	/**
	 *整卷批改上传批阅结果
	 */
	public function upOnePagerAjax() {
		$url = "/correct/all/";
		$param = array(
			'k'=>$this->k,
			'status'=>1
		);
		$uid = intval($this->input->post('uid'));
		$userAnswer = $this->input->post('userAnswer',false);
		$correctList = $userAnswer['data'];
		if (empty($correctList)) {
			$this->renderJson('120','无法检测到correctList');
		}
		$aid = intval($this->input->post('aid'));
		$eid = intval($this->input->post('eid'));
		$checkparam = array(
			'k'=>$this->k,
			'eid'=>$eid
		);

		//试题和答题信息
		$checkurl = '/useranswer/getbyaid/'.$aid;
		$checkpostRet = $this->do_post($checkurl,$checkparam,false);//获取试题信息
		$checkres = json_decode($checkpostRet,1);
		if($checkres['datas']['userAnswer']['correctrat'] == 100){//已经批阅
			$this->renderJson('10003','已经批阅过',array('returnurl'=>'/college/examv2/doneexam/'.$eid.'.html'));
		}
		
		$schcwidlist = '';
		$unsetQuetypes = array('A','B','D','G','Z');//过滤的题型
		foreach ($correctList['answerqueDetailList'] as $key => &$val) {
			if ($val['type'] == 'H') {//主观题得分的cwids
				$schcwidlist .= $val['schcwid'].',';
			} elseif (in_array($val['type'], $unsetQuetypes)) {
				unset($correctList['answerqueDetailList'][$key]);
				continue;
			}
			if (!empty($val['data']))
				$val['data'] = json_encode($val['data']);
		}
		//获取主观题得分
		if (!empty($schcwidlist)) {
			$schcwidlist = substr($schcwidlist, 0, strlen($schcwidlist)-1);
			$noteparam = array(
				'uid'=>$uid,
				//'aid' => $aid,
				'cwids' => $schcwidlist	
			);
			$notelist = $this->model('schcourseware')->getCoursenoteBycwids($noteparam);
		}
		//构建数据符合java端json的解析
		$i = 0;
		foreach ($correctList['answerqueDetailList'] as $value) {
			if ($value['type'] == 'H') {//主观题分数赋值
				unset($value['type']);
				$param['userAnswer']['data']['answerqueDetailList'][$i]['dqid'] = $value['dqid'];
				foreach ($notelist as $nkey => $nvalue) {
					if ($nvalue['cwid'] == $value['schcwid'] && $nvalue['qid'] == $value['qid']) {
						$param['userAnswer']['data']['answerqueDetailList'][$i]['totalscore'] = $nvalue['score'];
						if ($value['score'] <= $nvalue['score']) {
							$param['userAnswer']['data']['answerqueDetailList'][$i]['allright'] = 1;//是否全对
							$param['userAnswer']['data']['answerqueDetailList'][$i]['totalscore'] = $value['score'];
						}
					}
				}
			} else {
				unset($value['type']);
				$param['userAnswer']['data']['answerqueDetailList'][$i] = $value;
				// $param['userAnswer']['data']['answerqueDetailList'][$i]['allright'] = 1;
			}
			$i++;
		}
		$param['eid'] = intval($this->input->post('eid'));
		$param['userAnswer']['aid'] = $aid;
		$param['remark'] = h($this->input->post('remark'));
		$param['userAnswer']['data'] = json_encode($param['userAnswer']['data']);
		$result = $this->do_post($url, $param, 1);

		//$status = !empty($result->nextAid) ? 1 : 0; 
		$status = 1;
		$res = array(
	    	'status'=>$status,
	    	'datapackage'=>array(
	    		'curaid'=>$aid,
	    		'nextaid'=>$result->nextAid
	    	)
    	);
		echo json_encode($res);
	}
		
		
	
	/**
	 * 学生自主批阅接口
	 */
	public function papercorrect_view() {
		$eid = $this->input->get('eid');
		if (empty($eid)) {
			$eid = $this->input->post('eid');
		}
		if(!is_numeric($eid) || $eid < 0 ) {
			$this->renderJson('120','eid不符合要求');
		}

		$aid = $this->uri->itemid;
		if(!is_numeric($aid) || $aid < 0 ) {
			$this->renderJson('120','aid不符合要求');
		}

		$this->assign('eid',$eid);
		$this->assign('aid',$aid);
		$this->assign('username',$this->user['username']);
		$this->display('college/onepaper_correct');
	}
	
	
	
	/*
	 * 获取学生未完成的作业数量
	 * param $tid int 课程id用于其他控制器调用此模块 
	 */
	public function unfishCount($tid=0) {
		//开通的课程
		if ($tid) {
			$folderid = $tid;
		} else {
			$folderid = $this->input->post('folderids');
		}
		if(empty($folderid)){
			$folderids = $this->getfolderids();
		}else{
			$folderids = array($folderid);
		}
		if (empty($folderids)) {
			echo 0;
			exit;
		}
		//班级获取班级
		$userArray = array($this->user['uid']);
		$classids = $this->model('classes')->getClassInfoByCrid($this->room['crid'],$userArray);
		if ($classids) {
			foreach ($classids as $class) {
				$param['classid'][] = $class['classid'];
			}
		}
		$param['tids'] = ($folderids);
		$param['crid'] = $this->room['crid'];
		$param['action'] = 'fordo';

		//学校信息统计
        if($this->room['isschool'] == 3 || $this->room['isschool'] == 6 || $this->room['isschool'] == 7) {
			$param['k'] = $this->k;
			$param['status'] = 1;
			$param['ttype'] = 'FOLDER';
			$url = "/exam/unfinishcount";
			$postRet = $this->do_post($url,$param);
			$count = $postRet->unfinishedcount;
        } else if ($roominfo['isschool'] == 2) {
			$statemodel = $this->model('Userstate');
        	$subtime = $statemodel->getsubtime($roominfo['crid'],$user['uid'],1);
        	$exammodel = $this->model('Exam');
            $count = $exammodel->getnewexamcountbytime($roominfo['crid'],$user['uid'],$subtime);
        }
        if ($tid) {
        	return $count;
        } else {
        	echo $count;
        }
       
	}
	
	/*
	获取有权限的课程：(免费，全校免费，开通未过期忽略),免费的课程也需要开通，所以注释掉了
	*/
	private function getfolderids(){
		$userpermodel = $this->model('Userpermission');
		$myperparam = array('uid'=>$this->user['uid'],'crid'=>$this->room['crid'],'filterdate'=>1);
		$myfolderlist = $userpermodel->getUserPayFolderList($myperparam);
		$folderids = array();
		
		foreach($myfolderlist as $f){
			$folderids[]= $f['folderid'];
		}
		
		$foldermodel = $this->model('Folder');
		if ($this->room['isschool'] == 7) {
			//全校免费课程
			$rumodel = $this->model('roomuser');
			$userin = $rumodel->getroomuserdetail($this->room['crid'],$this->user['uid']);
			if(!empty($userin)){
				$schoolfreelist = $foldermodel->getfolderlist(array('crid'=>$this->room['crid'],'isschoolfree'=>1,'limit'=>1000));
				foreach($schoolfreelist as $f){
					$folderids[]= $f['folderid'];
				}
			}
			
		} else {//其他类型学校的班级关联课程
			//班级-课程关联
			$classmodel = $this->model('Classes');
			$classcoursesmodel = $this->model('Classcourses');
			if($this->room['domain'] == 'lcyhg'){//绿城育华 一个学生可以多个班级
				$needlist = TRUE;
				$myclass = $classmodel->getClassByUid($this->room['crid'],$this->user['uid'],$needlist);
				
				$myclassidarr = array_column($myclass,'classid');
				$myclassid = implode($myclassidarr,',');
				$classfolders = $classcoursesmodel->getfolderidsbyclassid($myclassid);
				
			}else{
				$myclass = $classmodel->getClassByUid($this->room['crid'],$this->user['uid']);
				$myclassid = empty($myclass['classid']) ? 0 : $myclass['classid'];
				$classfolders = $classcoursesmodel->getfolderidsbyclassid($myclassid);
			}
			if(!empty($classfolders)){//获取课程基础信息
				foreach ($classfolders as $fd){
					$folderids[] = $fd['folderid'];
				}
			}
			
			//没有关联的，按老策略，老师的课程
			if(empty($folderids)){
				$queryarr = parsequery();
				$queryarr['crid'] = $this->room['crid'];
				if(!empty($myclassid))
					$queryarr['classid'] = $myclassid;
				else{
					// header('Location:'.geturl('myroom/college/allcourse'));
					// exit;
				}
				if(!empty($queryarr['classid'])){
					/*if(!empty($myclass['grade']))
						$queryarr['grade'] = $myclass['grade'];*/
					$queryarr['pagesize'] = 1000;
					$queryarr['order'] = '  displayorder asc,folderid desc';
					$folders = $foldermodel->getClassFolder($queryarr);
					if (!empty($folders)) {
						foreach ($folders as $key => $value) {
							$folderids[] = $value['folderid'];
						}
					}
				}
			}
		}
		
		//免费课程（课程0，服务项0）//免费的课程也需要开通，所以注释掉了
		/*$freelist = $foldermodel->getPriceZeroList($this->room['crid']);
		foreach($freelist as $f){
			$folderids[]= $f['folderid'];
		}*/
		return $folderids;
	}
	
	/*
	获取已开通的课件id
	*/
	private function getcwids(){
		$userpermodel = $this->model('Userpermission');
		$myperparam = array('uid'=>$this->user['uid'],'crid'=>$this->room['crid'],'filterdate'=>1);
		$cwlist = $userpermodel->getUserPayCwList($myperparam);
		$cwids = array_column($cwlist,'cwid');
		return $cwids;
	}
}
