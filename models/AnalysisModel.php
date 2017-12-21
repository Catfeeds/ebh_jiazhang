<?php
//学习分析
class AnalysisModel extends CModel{
	/*
	做作业数
	*/
	public function getExamCount($param){
		$wherearr = array();
		$sql = 'select count(*) count from ebh_schexamanswers a 
			join ebh_schexams e on a.eid = e.eid 
		';
		
		if(empty($param['needall']) && empty($param['needclass'])){
			$wherearr[] = 'a.uid='.$param['uid'];
		}
		elseif(!empty($param['needclass'])){
			$sql2 = 'select c.classid from ebh_classes c join ebh_classstudents cs on c.classid=cs.classid where uid='.$param['uid'].' AND crid='.$param['crid'];
			$res = $this->db->query($sql2)->row_array();
			if(empty($res))
				return 0;
			$classid = $res['classid'];
			$sql.=' join ebh_classstudents cs on cs.uid=a.uid';
			$wherearr[]= 'cs.classid='.$classid;
		}
			
		if(!empty($param['crid'])){
			$wherearr[] = 'crid='.$param['crid'];
		}
		if(!empty($param['dayfrom']) && !empty($param['dayto']))
			$wherearr[] = 'a.dateline between '.$param['dayfrom'].' and '.$param['dayto'];
		if(!empty($wherearr))
			$sql.= ' where '.implode(' AND ',$wherearr);
		// echo $sql;
		$count = $this->db->query($sql)->row_array();
		return $count['count'];
	}
	
	
	public function getExamList($param){
		$wherearr = array();
		$sql = 'select a.aid,a.answers,a.dateline from ebh_schexamanswers a ';
		
		if(!empty($param['needall']))
			;
		elseif(!empty($param['uid']))
			$wherearr[] = 'a.uid='.$param['uid'];
		if(!empty($param['crid'])){
			$sql.= ' left join ebh_schexams e on a.eid = e.eid';
			$wherearr[] = 'crid='.$param['crid'];
		}
		if(!empty($param['dayfrom']) && !empty($param['dayto']))
			$wherearr[] = 'a.dateline between '.$param['dayfrom'].' and '.$param['dayto'];
		if(!empty($wherearr))
			$sql.= ' where '.implode(' AND ',$wherearr);
		// echo $sql;
// $sql.=' order by aid limit 40,50';
		return $this->db->query($sql)->list_array();
	}
	
	public function getQuestionList($param){
		$wherearr = array();
		$sql = 'select answers from ebh_schexamanswers a';
		if(!empty($param['uid']))
			$wherearr[] = 'a.uid = '.$param['uid'];
		if(!empty($param['dayfrom']) && !empty($param['dayto']))
			$wherearr[] = 'a.dateline between '.$param['dayfrom'].' and '.$param['dayto'];
		if(!empty($wherearr))
			$sql.= ' where '.implode(' AND ',$wherearr);
		return $this->db->query($sql)->list_array();
	}
	/*
	分数 未完成
	*/
	public function getScores($param){
		$wherearr = array();
		$sql = 'select scores from ebh_schexamanswers a';
		if(!empty($param['uid']))
			$wherearr[] = 'a.uid = '.$param['uid'];
		if(!empty($wherearr))
			$sql.= ' where '.implode(' AND ',$wherearr);
		return $this->db->query($sql)->list_array();
	}
	/*
	正确答案 未完成
	*/
	public function getCorrectAnswerList($param){
		$sql = 'select q.ques,a.answers from ebh_schexamanswers a left join ebh_schquestions q on q.';
		$this->db->query($sql)->list_array();
		
	}
	/*
	刷新数据 未完成
	*/
	public function refreshdata(){
		$sql = 'select a.answers from ebh_schexamanswers a';
		$myexamlist = $this->db->query($sql)->list_array();
		$mycount= 0;
		foreach($myexamlist as $ml){
			$answersarr = unserialize($ml['answers']);
			if(!empty($answersarr))
			foreach($answersarr as $answers)
			if($answers['answers']!=''){
				$mycount++;
				
			}
			// $answer
		}
		echo $mycount;
	}
	/*
	登录数 未完成
	*/
	public function getlogincount($param){
		$wherearr = array();
		$sql = 'select * from ebh_creditlogs';
		$wherearr[]= '';
	}
	
	
	/*
	提问数
	*/
	public function getAskCount($param){
		$wherearr = array();
		$sql = 'select count(*) count from ebh_askquestions q join ebh_users u on u.uid=q.uid';
		$wherearr[] = 'u.groupid=6';
		
		if(empty($param['needall']) && empty($param['needclass'])){
			$wherearr[]= 'q.uid='.$param['uid'];
		}elseif(!empty($param['needclass'])){
			$sql2 = 'select c.classid from ebh_classes c join ebh_classstudents cs on c.classid=cs.classid where uid='.$param['uid'].' AND crid='.$param['crid'];
			$res = $this->db->query($sql2)->row_array();
			if(empty($res))
				return 0;
			$classid = $res['classid'];
			$sql.=' join ebh_classstudents cs on cs.uid=q.uid';
			$wherearr[]= 'cs.classid='.$classid;
		}
		if(!empty($param['crid']))
			$wherearr[]= 'q.crid='.$param['crid'];
		if(!empty($param['dayfrom']) && !empty($param['dayto']))
			$wherearr[] = 'q.dateline between '.$param['dayfrom'].' and '.$param['dayto'];
		if(!empty($wherearr))
			$sql.= ' where '.implode(' AND ',$wherearr);
		// echo $sql;
		$count = $this->db->query($sql)->row_array();
		return $count['count'];
	}
	/*
	解答数
	*/
	public function getAnswerCount($param){
		$wherearr = array();
		$sql = 'select count(*) count 
		from ebh_askanswers a 
		join ebh_roomusers ru on ru.uid=a.uid
		join ebh_askquestions q on a.qid=q.qid 
		';
		// $wherearr[]= 'cs.uid='.$param['uid'];
		$wherearr[] = 'ru.crid='.$param['crid'];
		if(empty($param['needall']) && empty($param['needclass'])){
			$wherearr[]= 'a.uid='.$param['uid'];
		}elseif(!empty($param['needclass'])){
			$sql2 = 'select c.classid from ebh_classes c join ebh_classstudents cs on c.classid=cs.classid where uid='.$param['uid'].' AND crid='.$param['crid'];
			$res = $this->db->query($sql2)->row_array();
			if(empty($res))
				return 0;
			$classid = $res['classid'];
			$sql.=' join ebh_classstudents cs on cs.uid=a.uid';
			$wherearr[]= 'cs.classid='.$classid;
		}
		if(!empty($param['crid']))
			$wherearr[]= 'q.crid='.$param['crid'];
		if(!empty($param['dayfrom']) && !empty($param['dayto']))
			$wherearr[] = 'a.dateline between '.$param['dayfrom'].' and '.$param['dayto'];
		if(!empty($wherearr))
			$sql.= ' where '.implode(' AND ',$wherearr);
			
		// echo $sql;
		$count = $this->db->query($sql)->row_array();
		return $count['count'];
		
	}
	/*
	班级人数
	*/
	public function getclassmatecount($uid,$crid){
		$sql = 'select stunum from ebh_classes c join ebh_classstudents cs on c.classid=cs.classid where uid='.$uid .' and crid='.$crid;
		// echo $sql;
		$res = $this->db->query($sql)->row_array();
		return $res['stunum'];
	}
	
	/*
	评论数
	*/
	public function getReviewCount($param){
		$wherearr = array();
		$sql = 'select count(*) count from ebh_reviews r 
			join ebh_logs l on r.logid = l.logid 
			join ebh_roomusers ru on ru.uid = l.uid
			join ebh_roomcourses rc on rc.cwid = l.toid';
		if(empty($param['needall']) && empty($param['needclass'])){
			$wherearr[]= 'ru.uid='.$param['uid'];
		}elseif(!empty($param['needclass'])){
			$sql2 = 'select c.classid from ebh_classes c join ebh_classstudents cs on c.classid=cs.classid where uid='.$param['uid'].' AND crid='.$param['crid'];
			$res = $this->db->query($sql2)->row_array();
			if(empty($res))
				return 0;
			$classid = $res['classid'];
			$sql.=' join ebh_classstudents cs on cs.uid=l.uid';
			$wherearr[]= 'cs.classid='.$classid;
		}
		$wherearr[]= 'rc.crid='.$param['crid'];
		$wherearr[]= 'ru.crid='.$param['crid'];
		if(!empty($param['dayfrom']) && !empty($param['dayto']))
			$wherearr[] = 'l.dateline between '.$param['dayfrom'].' and '.$param['dayto'];
		if(!empty($wherearr))
			$sql.= ' where '.implode(' AND ',$wherearr);
		$count = $this->db->query($sql)->row_array();
		// echo $sql;
		return $count['count'];
	}
	/*
	学习数
	*/
	public function getStudyCount($param){
		$wherearr =array();
		$sql = 'select count(*) count from ebh_playlogs pl join ebh_roomcourses rc on pl.cwid=rc.cwid';
		if(empty($param['needall']) && empty($param['needclass'])){
			$wherearr[]= 'pl.uid='.$param['uid'];
		}elseif(!empty($param['needclass'])){
			$sql2 = 'select c.classid from ebh_classes c join ebh_classstudents cs on c.classid=cs.classid where uid='.$param['uid'].' AND crid='.$param['crid'];
			$res = $this->db->query($sql2)->row_array();
			if(empty($res))
				return 0;
			$classid = $res['classid'];
			$sql.=' join ebh_classstudents cs on cs.uid=pl.uid';
			$wherearr[]= 'cs.classid='.$classid;
		}
		$wherearr[] = ' rc.crid='.$param['crid'];
		if(!empty($param['dayfrom']) && !empty($param['dayto']))
			$wherearr[] = 'pl.lastdate between '.$param['dayfrom'].' and '.$param['dayto'];
		$sql.= ' where '.implode(' AND ',$wherearr);
		// echo $sql;
		$count = $this->db->query($sql)->row_array();
		// echo($count['count']);
		return $count['count'];
		
	}
	/*
	学习时间列表，用于峰值表计算小时
	*/
	public function getStudyTime($param,$uid=null){
		$sql = 'select lastdate from ebh_playlogs';
		$wherearr = array();
		if(!empty($param['my']))
			$wherearr[]= 'uid='.$uid;
		if(!empty($wherearr))
			$sql.= ' where '.implode(' AND ',$wherearr);
		return $this->db->query($sql)->list_array();
	}
	/*
	学校学生的学习峰值表
	*/
	public function getStudyTimeForClassroom($param){
		$sql = 'select lastdate from ebh_playlogs p join ebh_roomcourses rc on p.cwid=rc.cwid';
		$wherearr[] = 'rc.crid='.$param['crid'];
		$sql.= ' where '.implode(' AND ',$wherearr);
		return $this->db->query($sql)->list_array();
	}
	
	/*
	学习数,以学校分组
	*/
	public function getStudyCountForClassroom(){
		$sql = 'select crid,count(*) count from ebh_playlogs pl join ebh_roomcourses rc on pl.cwid=rc.cwid';
		$sql.= ' group by crid';
		$count = $this->db->query($sql)->list_array();
		return $count;
	}
	/*
	作业数,以学校分组
	*/
	public function getExamCountForClassroom(){
		$sql = 'select crid,count(*) count from ebh_schexamanswers a join ebh_schexams e on a.eid = e.eid';
		$sql.= ' group by crid';
		$count = $this->db->query($sql)->list_array();
		return $count;
	}
	
	public function getAnswerCountForClassroom(){
		$sql = 'select crid,count(*) count from ebh_askanswers a join ebh_askquestions q on a.qid=q.qid';
		$sql.= ' group by crid';
		$count = $this->db->query($sql)->list_array();
		return $count;
	}
	/*
	云端图表数据
	*/
	public function getCloudData(){
		$sql = 'select crid,asknum,coursenum,examcount from ebh_classrooms';
		return $this->db->query($sql)->list_array();
	}
}
?>