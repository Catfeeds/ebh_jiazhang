<?php

/**
 * 作业类model
 */
class ExamModel extends CModel {

	/**
     * 根据时间返回以日期为单位的学生作业记录列表
     * @param array $parame
     * @return listarray
     */
    public function getExamCountByDate($param) {
		if(empty($param['uid']))
			return FALSE;
		$sql = "select count(*) as e,DATE_FORMAT(FROM_UNIXTIME(s.dateline) ,'%Y-%m-%d') as d from ebh_schexamanswers s ".
                "left join ebh_schexams sc on (sc.eid = s.eid) ";
		if(!empty($param['crid']))
			$wherearr[] = 'sc.crid='.$param['crid'];
		$wherearr[] = 's.uid='.$param['uid'];
		if(!empty($param['tid']))
			$wherearr[] = 'sc.uid='.$param['tid'];
		if(empty($param['startDate']))
			$wherearr[] = 's.dateline>='.$param['startDate'];
		if(empty($param['endDate']))
			$wherearr[] = 's.dateline<'.$param['endDate'];
		$sql .= ' WHERE '.implode(' AND ',$wherearr);
		$sql .= ' group by d';
		return $this->db->query($sql)->list_array();
    }
    /**
     * 根据时间返回以日期为单位的学生听课笔记列表
     * @param array $param
     * @return listarray
     */
    public function getNoteCount($param) {
		if(empty($param['uid']))
			return FALSE;
		$sql = "select count(*) as e,DATE_FORMAT(FROM_UNIXTIME(n.dateline) ,'%Y-%m-%d') as d from ebh_notes n ".
                "join ebh_coursewares c on (n.cwid=c.cwid) ";
		$wherearr[] = 'n.uid='.$param['uid'];
		if(!empty($param['tid']))
			$wherearr[] = 'c.uid='.$param['tid'];
		if(!empty($param['crid']))
			$wherearr[] = 'n.crid='.$param['crid'];
		if(empty($param['startDate']))
			$wherearr[] = 'n.dateline>='.$param['startDate'];
		if(empty($param['endDate']))
			$wherearr[] = 'n.dateline<'.$param['endDate'];
		$sql .= ' WHERE '.implode(' AND ',$wherearr);
		$sql .= ' group by d';
        return $this->db->query($sql)->list_array();
    }
    /**
     * 根据时间返回以日期为单位的学生学习记录列表
     * @param array $param
     * @return listarray
     */
    public function getStudyCount($param) {
		if(empty($param['uid']))
			return FALSE;
		$sql = "select count(*) as e,DATE_FORMAT(FROM_UNIXTIME(p.lastdate) ,'%Y-%m-%d') as d from ebh_playlogs p ".
				"join ebh_roomcourses rc on (rc.cwid = p.cwid) ";
		$wherearr[] = 'p.uid='.$param['uid'];
		if(!empty($param['crid']))
			$wherearr[] = 'rc.crid='.$param['crid'];
		if(empty($param['startDate']))
			$wherearr[] = 'p.lastdate>='.$param['startDate'];
		if(empty($param['endDate']))
			$wherearr[] = 'p.lastdate<'.$param['endDate'];
		if(isset($param['totalflag'])){
			$wherearr[] = 'p.totalflag in ('.$param['totalflag'].')';
		}else{
			$wherearr[] = 'p.totalflag=1';
		}
        $sql .= ' WHERE '.implode(' AND ',$wherearr);
		$sql .= ' group by d';
        return $this->db->query($sql)->list_array();
    }
    /**
     * 根据时间返回以日期为单位的学生错题记录列表
     * @param array $param
     * @return listarray
     */
    public function getErrorCount($param) {
		if(empty($param['uid']))
			return FALSE;
		$sql = "select count(*) as e,DATE_FORMAT(FROM_UNIXTIME(er.dateline) ,'%Y-%m-%d') as d from ebh_schquestions q ".
                "join ebh_errorbook er on (FIND_IN_SET(er.exid,q.eid) and er.qid=q.qnumber) ";
		$wherearr[] = 'er.uid='.$param['uid'];
		if(!empty($param['crid']))
			$wherearr[] = 'q.crid='.$param['crid'];
		if(empty($param['startDate']))
			$wherearr[] = 'er.dateline>='.$param['startDate'];
		if(empty($param['endDate']))
			$wherearr[] = 'er.dateline<'.$param['endDate'];
		$sql .= ' WHERE '.implode(' AND ',$wherearr);
		$sql .= ' group by d';
        return $this->db->query($sql)->list_array();
    }
	/**
	* 根据时间返回以日期为单位的学生答疑答题记录列表
    * @param array $param
    * @return listarray
	*/
	public function getAskCount($param){//答疑
		if(empty($param['uid']))
			return FALSE;
		$sql = "select count(*) as e,DATE_FORMAT(FROM_UNIXTIME(a.dateline) ,'%Y-%m-%d') as d from ebh_askanswers a ".
				"join ebh_askquestions aq on(a.qid=aq.qid)";
		$wherearr[] = 'a.uid='.$param['uid'];
		if(!empty($param['crid']))
			$wherearr[] = 'aq.crid='.$param['crid'];
		if(empty($param['startDate']))
			$wherearr[] = 'a.dateline>='.$param['startDate'];
		if(empty($param['endDate']))
			$wherearr[] = 'a.dateline<'.$param['endDate'];
		$sql .= ' WHERE '.implode(' AND ',$wherearr);
		$sql .= ' group by d';
        return $this->db->query($sql)->list_array();
	}
    /**
     * 获取平台下此教师的最新需批阅的作业
     * @param type $param
     * @return type
     */
    public function getnewexamlist($param) {
        $sql = 'SELECT e.eid,e.title,cl.classname,cl.classid,e.answercount,e.dateline,cl.stunum FROM ebh_schexams e ' .
                'left join ebh_classes cl on (cl.classid = e.classid) ';
        $wherearr = array();
        if (!empty($param['crid']))
            $wherearr[] = ' e.crid=' . $param['crid'];
        if (!empty($param['uid']))
            $wherearr[] = ' e.uid=' . $param['uid'];
        $wherearr[] = 'e.status = 1';
		if(empty($param['getall'])){
			$wherearr[] = 'e.answercount != cl.stunum';
			$wherearr[] = 'e.answercount != 0';
		}
        $sql .= ' WHERE ' . implode(' AND ', $wherearr);
        if (!empty($param['order']))
            $sql .= ' ORDER BY ' . $param['order'];
        else
            $sql .= ' ORDER BY e.eid DESC ';
        if (!empty($param['limit']))
            $sql .= ' LIMIT ' . $param['limit'];
        else
            $sql .= ' LIMIT 0,10';
        return $this->db->query($sql)->list_array();
    }

    /**
     * 根据时间获取需要教师批阅的学生作业数(适用于教师网校)
     * @param type $crid
     * @param type $uid
     * @param type $time
     * @return type
     */
    public function getnewexamcountbytime($crid, $uid, $time) {
        $count = 0;
        $sql = "SELECT COUNT(*) count FROM ebh_exams e LEFT JOIN ebh_examanswers a ON (e.eid = a.eid) " .
                "WHERE e.crid=$crid AND e.uid=$uid AND e.status = 1 AND a.status = 1 AND (a.dateline+a.completetime) > $time";
        $row = $this->db->query($sql)->row_array();
        if (!empty($row))
            $count = $row['count'];
        return $count;
    }

    /**
     * 根据时间获取需要教师批阅的学生作业数(适用于学校网校)
     * @param type $crid
     * @param type $uid
     * @param type $time
     * @return type
     */
    public function getnewschexamcountbytime($crid, $uid, $time) {
        $count = 0;
        $sql = "SELECT COUNT(*) count FROM ebh_schexams e LEFT JOIN ebh_schexamanswers a ON (e.eid = a.eid) " .
                "WHERE e.crid=$crid AND e.uid=$uid AND e.status = 1 AND a.status = 1 AND (a.dateline+a.completetime) > $time";
        $row = $this->db->query($sql)->row_array();
        if (!empty($row))
            $count = $row['count'];
        return $count;
    }
	/**
	*教室下的作业数
	* @param int $crid 教室编号
	*/
	public function getexamcount($crid){
		$count = 0;
		$sql = 'SELECT COUNT(*) as count FROM ebh_exams e WHERE e.crid = '.$crid;
		$row = $this->db->query($sql)->row_array();
        if (!empty($row))
            $count = $row['count'];
        return $count;
	}

    /**
     * 根据crid获取网校下的作业列表(在网校教师在线测评，录入的作业中)
     * @param type $param
     */
    public function getexamlist($param) {
        if (empty($param['crid']))
            return FALSE;
        if (empty($param['page']) || $param['page'] < 1)
            $page = 1;
        else
            $page = $param['page'];
        $pagesize = empty($param['pagesize']) ? 10 : $param['pagesize'];
        $start = ($page - 1) * $pagesize;
        $sql = 'SELECT e.eid,e.cwid,e.title,e.dateline,e.score,e.answercount,c.uid,c.title ctitle FROM ebh_exams e ' .
                'JOIN ebh_coursewares c ON e.cwid=c.cwid ';
        $wherearr = array();
        $wherearr[] = 'e.crid=' . $param['crid'];
        if (isset($param['status']))
            $wherearr[] = 'e.status in (' . $param['crid'] . ')';
        else
            $wherearr[] = 'e.status in (0,1)';
        $sql .= ' WHERE ' . implode(' AND ', $wherearr);
        if (!empty($param['order']))
            $sql .= ' ORDER BY ' . $param['order'];
        else
            $sql .= ' ORDER BY e.eid DESC ';
        $sql .= ' limit ' . $start . ',' . $pagesize;
        return $this->db->query($sql)->list_array();
    }

    /**
     * 根据crid获取网校下的作业列表记录总数(在网校教师在线测评，录入的作业中)
     * @param type $param
     */
    public function getexamlistcount($param) {
        $count = 0;
        if (empty($param['crid']))
            return $count;
        $sql = 'SELECT count(*) count FROM ebh_exams e ' .
                'JOIN ebh_coursewares c ON e.cwid=c.cwid ';
        $wherearr = array();
        $wherearr[] = 'e.crid=' . $param['crid'];
        if (isset($param['status']))
            $wherearr[] = 'e.status in (' . $param['crid'] . ')';
        else
            $wherearr[] = 'e.status in (0,1)';
        $sql .= ' WHERE ' . implode(' AND ', $wherearr);
        $row = $this->db->query($sql)->row_array();
        if (!empty($row))
            $count = $row['count'];
        return $count;
    }
	/**
	*根据教室和班级编号获取班级下的作业列表(学校版本)
	*/
	public function getschexamlist($param) {
		if(empty($param['crid']))
			return FALSE;
		$sql = 'SELECT e.eid,e.title,e.uid,e.grade,e.limitedtime,e.score,e.dateline,e.status,e.answercount,e.quescount,e.cwid,e.classid,e.district FROM ebh_schexams e ';
		$wherearr = array();
		$wherearr[] = 'e.crid='.$param['crid'];
		$isgrade = FALSE;
		if(!empty($param['classid'])) {
			if(!empty($param['grade']) && !empty($param['uid'])) {	//按照年级和科目获取作业
				$district = empty($param['district']) ? 0 : $param['district'];
				$myfolder = $this->getFolderByGrade($param['crid'],$param['grade'],$param['uid'],$district);
				if(empty($myfolder)) {
					$wherearr[] = 'e.classid='.$param['classid'];
				} else {
					$isgrade = TRUE;
					$wherearr[] = '((e.classid='.$param['classid'].' and e.grade = 0) or (e.folderid='.$myfolder['folderid'].' and e.grade='.$param['grade'].' and e.district='.$param['district'].'))';
				}
			} else {
				$wherearr[] = 'e.classid='.$param['classid'];
			}
		}
		if(!empty($param['uid']) && !$isgrade)	//过滤某个教师布置的班级作业
			$wherearr[] = 'e.uid='.$param['uid'];
		if(!empty($param['tid'])){
			$wherearr[] = 'e.uid='.$param['tid'];
		}
		if(isset($param['status']))
			$wherearr[] = 'e.status = '.$param['status'];
		else
			$wherearr[] = 'e.status in (0,1)';
		if(!empty($param['starttime'])){
			$wherearr[] = 'e.dateline >= '.$param['starttime'];
		}
		if(!empty($param['endtime'])){
			$wherearr[] = 'e.dateline <= '.$param['endtime'];
		}
		$sql .= ' WHERE '.implode(' AND ',$wherearr);
		if(!empty($param['order']))
			$sql .= ' order by '.$param['order'];
		else
			$sql .= ' order by e.eid desc ';
		if(!empty($param['limit']))
			$sql .= ' limit '.$param['limit'];
		else {
			if (empty($param['page']) || $param['page'] < 1)
				$page = 1;
			else
				$page = $param['page'];
			$pagesize = empty($param['pagesize']) ? 10 : $param['pagesize'];
			$start = ($page - 1) * $pagesize;
			$sql .= ' limit ' . $start . ',' . $pagesize;
		}
		$examlist = $this->db->query($sql)->list_array();
		$myexamlist = array();
		$eidlist = array();
		foreach($examlist as $myexam) {
			if(!empty($param['classid'])&& !empty($myexam['grade']))
				$myexam['answercount'] = 0;
			$myexamlist[$myexam['eid']] = $myexam;
			if(!empty($myexam['grade'])) {
				$eidlist[] = $myexam['eid'];
			}
		}
		if(!empty($eidlist) && !empty($param['classid'])) {	//年级作业的答题数需要调整
			$usql = 'select uid from ebh_classstudents where classid='.$param['classid'];
			$ulist = $this->db->query($usql)->list_array();
			$uids = '';
			foreach($ulist as $urow) {
				if(empty($uids)) {
					$uids = $urow['uid'];
				} else {
					$uids .= ','.$urow['uid'];
				}
			}
			if(!empty($uids)) {
				$csql = 'select eid,count(*) count from ebh_schexamanswers where eid in ('.implode(',',$eidlist).') and uid in ('.$uids.') group by eid';
				$countlist = $this->db->query($csql)->list_array();
				if(!empty($countlist)) {
					foreach($countlist as $mycount) {
						if(isset($myexamlist[$mycount['eid']])) {
							$myexamlist[$mycount['eid']]['answercount'] = $mycount['count'];
						}
					}
				}
			}
		}
		return $myexamlist;
			
	}
	/**
	*根据教室和班级编号获取班级下的作业列表记录总数(学校版本)
	*/
	public function getschexamlistcount($param) {
		$count = 0;
		if(empty($param['crid']))
			return $count;
		$sql = 'SELECT count(*) count FROM ebh_schexams e ';
		$wherearr = array();
		$wherearr[] = 'e.crid='.$param['crid'];
		$isgrade = FALSE;
		if(!empty($param['classid'])) {
			if(!empty($param['grade']) && !empty($param['uid'])) {	//按照年级和科目获取作业
				$district = empty($param['district']) ? 0 : $param['district'];
				$myfolder = $this->getFolderByGrade($param['crid'],$param['grade'],$param['uid'],$district);
				if(empty($myfolder)) {
					$wherearr[] = 'e.classid='.$param['classid'];
				} else {
					$isgrade = TRUE;
					$wherearr[] = '(e.classid='.$param['classid'].' or (e.folderid='.$myfolder['folderid'].' and e.grade='.$param['grade'].' and e.district='.$param['district'].'))';
				}
			} else {
				$wherearr[] = 'e.classid='.$param['classid'];
			}
		}
		if(!empty($param['uid']) && !$isgrade)	//过滤某个教师布置的班级作业
			$wherearr[] = 'e.uid='.$param['uid'];
		if(!empty($param['tid'])){
			$wherearr[] = 'e.uid='.$param['tid'];
		}
		if(isset($param['status']))
			$wherearr[] = 'e.status = '.$param['status'];
		else
			$wherearr[] = 'e.status in (0,1)';
		if(!empty($param['starttime'])){
			$wherearr[] = 'e.dateline >= '.$param['starttime'];
		}
		if(!empty($param['endtime'])){
			$wherearr[] = 'e.dateline <= '.$param['endtime'];
		}
		$sql .= ' WHERE '.implode(' AND ',$wherearr);
		$row = $this->db->query($sql)->row_array();
		if(!empty($row))
			$count = $row['count'];
		return $count;
			
	}
	/**
	*根据年级等信息获取教师对应的科目编号
	*/
	public function getFolderByGrade($crid,$grade,$uid,$district) {
		$sql = "select f.folderid,f.foldername from ebh_teacherfolders tf join ebh_folders f ".
				"ON(tf.folderid = f.folderid) ".
				"where f.crid=$crid and tf.tid=$uid and f.grade=$grade and f.district=$district";
		return $this->db->query($sql)->row_array();
	}
	/**
	*根据作业编号和班级编号获取作业的答题情况记录
	*/
	public function getschexamanswerlistbyeid($param) {
		if(empty($param['eid']) || empty($param['classid']))	//作业编号和班级编号不能为空
			return FALSE;
		$sql = 'SELECT ea.aid,ea.eid,ea.dateline,ea.completetime,ea.totalscore,ea.remark,ea.tid,ea.status,ea.uid,u.username,u.realname,u.sex FROM ebh_classstudents ct '.
			'JOIN ebh_schexams e on (e.classid=ct.classid) '.
			'LEFT JOIN ebh_schexamanswers ea on (ea.eid=e.eid and ea.uid=ct.uid) '.
			'LEFT JOIN ebh_users u on (u.uid = ct.uid) ';
		$wherearr = array();
		$wherearr[] = 'e.eid='.$param['eid'];
		$wherearr[] = 'ct.classid='.$param['classid'];
		$wherearr[] = 'e.status = 1';
		$sql .= ' WHERE '.implode(' AND ',$wherearr);
		
		if(!empty($param['order']))
			$sql .= ' order by '.$param['order'];
		else
			$sql .= ' order by ea.aid desc ';
		if(!empty($param['limit']))
			$sql .= ' limit '.$param['limit'];
		else
			$sql .= ' limit 0,100';
		return $this->db->query($sql)->list_array();
	}
	/**
	*根据作业编号和年级编号获取作业的答题情况记录
	*/
	public function getschexamanswerlistbygrade($param) {
		if(empty($param['eid']) || empty($param['classid']))	//作业编号和班级编号不能为空
			return FALSE;
		$sql = 'SELECT ea.aid,ea.eid,ea.dateline,ea.completetime,ea.totalscore,ea.remark,ea.tid,ea.status,ea.uid,u.username,u.realname,u.sex FROM ebh_classstudents ct '.
			'LEFT JOIN ebh_schexamanswers ea on (ea.uid=ct.uid) '.
			'LEFT JOIN ebh_schexams e on (e.eid=ea.eid) '.
			'LEFT JOIN ebh_users u on (u.uid = ct.uid) ';
		$wherearr = array();
		$wherearr[] = 'e.eid='.$param['eid'];
		if(!empty($param['grade'])) {
			$crid = empty($param['crid']) ? 0 : $param['crid'];
			$district = empty($param['district']) ? 0 : $param['district'];
			$grade = $param['grade'];
			$uid = empty($param['uid']) ? 0 : $param['uid'];
			$myfolder = $this->getFolderByGrade($crid,$grade,$uid,$district);
			if(!empty($myfolder)) {
				$wherearr[] = 'e.folderid = '.$myfolder['folderid'];
			}
		}
		$wherearr[] = 'ct.classid='.$param['classid'];
		$wherearr[] = 'e.status = 1';
		$sql .= ' WHERE '.implode(' AND ',$wherearr);
		
		if(!empty($param['order']))
			$sql .= ' order by '.$param['order'];
		else
			$sql .= ' order by ea.aid desc ';
		if(!empty($param['limit']))
			$sql .= ' limit '.$param['limit'];
		else
			$sql .= ' limit 0,100';
		return $this->db->query($sql)->list_array();
	}

	/**
	*根据教室和班级编号获取教室内作业的平均分等信息统计列表
	*/
	public function getschexamscore($param){
		if(empty($param['crid']) && empty($param['classid']))
			return FALSE;
		$sql = 'SELECT e.eid,e.title,e.crid,e.grade,e.district,e.classid,e.score,e.dateline,e.answercount,e.quescount FROM ebh_schexams e ';
		$wherearr = array();
		if(!empty($param['crid']))
			$wherearr[] = 'e.crid='.$param['crid'];
		$isgrade = FALSE;
		if(!empty($param['classid'])) {
			if(!empty($param['grade']) && !empty($param['uid'])) {	//按照年级和科目获取作业
				$district = empty($param['district']) ? 0 : $param['district'];
				$myfolder = $this->getFolderByGrade($param['crid'],$param['grade'],$param['uid'],$district);
				if(empty($myfolder)) {
					$wherearr[] = 'e.classid='.$param['classid'];
				} else {
					$isgrade = TRUE;
					$wherearr[] = '((e.classid='.$param['classid'].' and e.grade = 0) or (e.folderid='.$myfolder['folderid'].' and e.grade='.$param['grade'].' and e.district='.$param['district'].'))';
				}
			} else {
				$wherearr[] = 'e.classid in ('.$param['classid'].')';
			}
			
		}
		if(!empty($param['eid']))
			$wherearr[] = 'e.eid='.$param['eid'];
		if(!empty($param['uid']) && !$isgrade)	//过滤某个教师布置的班级作业
			$wherearr[] = 'e.uid='.$param['uid'];
		if(!empty($param['q']))
			$wherearr[] = 'e.title like \'%'.$this->db->escape_str($param['q']).'%\'';
		if(!empty($wherearr))
			$sql .= ' WHERE '.implode(' AND ',$wherearr);
		if(!empty($param['order']))
			$sql .= ' order by '.$param['order'];
		else
			$sql .= ' order by e.eid desc';
		if(!empty($param['limit']))
			$sql .= ' limit '.$param['limit'];
		else {
			if (empty($param['page']) || $param['page'] < 1)
				$page = 1;
			else
				$page = $param['page'];
			$pagesize = empty($param['pagesize']) ? 10 : $param['pagesize'];
			$start = ($page - 1) * $pagesize;
			$sql .= ' limit ' . $start . ',' . $pagesize;
		}
		$list = $this->db->query($sql)->list_array();
		$scorelist = array();
		$count = count($list);
		$eidlist = '';
		for($i = 0; $i < $count; $i ++) {
			$list[$i]['avgscore'] = 0;
			$list[$i]['minscore'] = 0;
			$list[$i]['maxscore'] = 0;
			if($isgrade) {
				$list[$i]['answercount'] = 0;
			}
			if(empty($eidlist))
				$eidlist= $list[$i]['eid'];
			else
				$eidlist .= ','.$list[$i]['eid'];
			$scorelist[$list[$i]['eid']] = $list[$i];
		}
		if(!empty($eidlist)) {
			$uids = '';
			if(!empty($param['classid']) && $isgrade) {	//年级作业，则需要根据班级重新算出答题人数
				$usql = 'select uid from ebh_classstudents where classid='.$param['classid'];
				$ulist = $this->db->query($usql)->list_array();
				foreach($ulist as $urow) {
					if(empty($uids)) {
						$uids = $urow['uid'];
					} else {
						$uids .= ','.$urow['uid'];
					}
				}
			}
			if(!empty($uids)) {
				$countsql = 'SELECT ea.eid,count(*) as answercount,avg(ea.totalscore) avgscore,min(ea.totalscore) minscore,max(ea.totalscore) maxscore, ea.eid from ebh_schexamanswers ea WHERE ea.eid in ('.$eidlist.') and uid in ('.$uids.') group by ea.eid';
			} else {
				$countsql = 'SELECT ea.eid,avg(ea.totalscore) avgscore,min(ea.totalscore) minscore,max(ea.totalscore) maxscore, ea.eid from ebh_schexamanswers ea WHERE ea.eid in ('.$eidlist.') group by ea.eid';
			}
			$countlist = $this->db->query($countsql)->list_array();
			if(!empty($countlist)) {
				foreach($countlist as $mycount) {
					if(isset($scorelist[$mycount['eid']])) {
						$scorelist[$mycount['eid']]['avgscore'] = $mycount['avgscore'];
						$scorelist[$mycount['eid']]['minscore'] = $mycount['minscore'];
						$scorelist[$mycount['eid']]['maxscore'] = $mycount['maxscore'];
						if(isset($mycount['answercount'])) {
							$scorelist[$mycount['eid']]['answercount'] = $mycount['answercount'];
						}
					}
				}
			}
		}
		
		return $scorelist;
	}

	/**
	*根据学生账号获取该学生的做作业信息
	*/
	public function getschexams($param){
		if(empty($param['crid']) && empty($param['classid']))
			return FALSE;
		$sql = 'SELECT e.eid,e.title,e.crid,e.grade,e.district,e.classid,e.score,e.dateline,e.answercount,e.quescount,s.dateline sdateline,s.uid,s.totalscore,s.completetime,s.aid FROM ebh_schexams e left join ebh_schexamanswers s on (e.eid=s.eid)';
		$wherearr = array();
		if(!empty($param['crid']))
			$wherearr[] = 'e.crid='.$param['crid'];
		$isgrade = FALSE;
		if(!empty($param['classid'])) {
			if(!empty($param['grade']) && !empty($param['uid'])) {	//按照年级和科目获取作业
				$district = empty($param['district']) ? 0 : $param['district'];
				$myfolder = $this->getFolderByGrade($param['crid'],$param['grade'],$param['uid'],$district);
				if(empty($myfolder)) {
					$wherearr[] = 'e.classid='.$param['classid'];
				} else {
					$isgrade = TRUE;
					$wherearr[] = '((e.classid='.$param['classid'].' and e.grade = 0) or (e.folderid='.$myfolder['folderid'].' and e.grade='.$param['grade'].' and e.district='.$param['district'].'))';
				}
			} else {
				$wherearr[] = 'e.classid in ('.$param['classid'].')';
			}
			
		}
		if(!empty($param['eid']))
			$wherearr[] = 'e.eid='.$param['eid'];
		if(!empty($param['uid']) && !$isgrade)	//过滤某个教师布置的班级作业
			$wherearr[] = 's.uid='.$param['uid'];
		if(!empty($param['q']))
			$wherearr[] = 'e.title like \'%'.$this->db->escape_str($param['q']).'%\'';
		if(!empty($wherearr))
			$sql .= ' WHERE '.implode(' AND ',$wherearr);
		if(!empty($param['order']))
			$sql .= ' order by '.$param['order'];
		else
			$sql .= ' order by e.eid desc';
		if(!empty($param['limit']))
			$sql .= ' limit '.$param['limit'];
		else {
			if (empty($param['page']) || $param['page'] < 1)
				$page = 1;
			else
				$page = $param['page'];
			$pagesize = empty($param['pagesize']) ? 10 : $param['pagesize'];
			$start = ($page - 1) * $pagesize;
			$sql .= ' limit ' . $start . ',' . $pagesize;
		}
		$list = $this->db->query($sql)->list_array();
		$scorelist = array();
		$count = count($list);
		$eidlist = '';
		for($i = 0; $i < $count; $i ++) {
			$list[$i]['avgscore'] = 0;
			$list[$i]['minscore'] = 0;
			$list[$i]['maxscore'] = 0;
			if($isgrade) {
				$list[$i]['answercount'] = 0;
			}
			if(empty($eidlist))
				$eidlist= $list[$i]['eid'];
			else
				$eidlist .= ','.$list[$i]['eid'];
			$scorelist[$list[$i]['eid']] = $list[$i];
		}
		if(!empty($eidlist)) {
			$uids = '';
			if(!empty($param['classid']) && $isgrade) {	//年级作业，则需要根据班级重新算出答题人数
				$usql = 'select uid from ebh_classstudents where classid='.$param['classid'];
				$ulist = $this->db->query($usql)->list_array();
				foreach($ulist as $urow) {
					if(empty($uids)) {
						$uids = $urow['uid'];
					} else {
						$uids .= ','.$urow['uid'];
					}
				}
			}
			if(!empty($uids)) {
				$countsql = 'SELECT ea.eid,count(*) as answercount,avg(ea.totalscore) avgscore,min(ea.totalscore) minscore,max(ea.totalscore) maxscore, ea.eid from ebh_schexamanswers ea WHERE ea.eid in ('.$eidlist.') and uid in ('.$uids.') group by ea.eid';
			} else {
				$countsql = 'SELECT ea.eid,avg(ea.totalscore) avgscore,min(ea.totalscore) minscore,max(ea.totalscore) maxscore, ea.eid from ebh_schexamanswers ea WHERE ea.eid in ('.$eidlist.') group by ea.eid';
			}
			$countlist = $this->db->query($countsql)->list_array();
			if(!empty($countlist)) {
				foreach($countlist as $mycount) {
					if(isset($scorelist[$mycount['eid']])) {
						$scorelist[$mycount['eid']]['avgscore'] = $mycount['avgscore'];
						$scorelist[$mycount['eid']]['minscore'] = $mycount['minscore'];
						$scorelist[$mycount['eid']]['maxscore'] = $mycount['maxscore'];
						if(isset($mycount['answercount'])) {
							$scorelist[$mycount['eid']]['answercount'] = $mycount['answercount'];
						}
					}
				}
			}
		}
		return $scorelist;
	}


	/**
	*根据教室和班级编号获取教室内作业的平均分等信息统计列表记录总数
	*/
	public function getschexamscorecount($param){
		$count = 0;
		if(empty($param['crid']) || empty($param['classid']))
			return $count;
		$sql = 'SELECT count(*) count FROM ebh_schexams e ';
		$wherearr = array();
		$isgrade = FALSE;
		if(!empty($param['classid'])) {
			if(!empty($param['grade']) && !empty($param['uid'])) {	//按照年级和科目获取作业
				$district = empty($param['district']) ? 0 : $param['district'];
				$myfolder = $this->getFolderByGrade($param['crid'],$param['grade'],$param['uid'],$district);
				if(empty($myfolder)) {
					$wherearr[] = 'e.classid='.$param['classid'];
				} else {
					$isgrade = TRUE;
					$wherearr[] = '((e.classid='.$param['classid'].' and e.grade = 0) or (e.folderid='.$myfolder['folderid'].' and e.grade='.$param['grade'].' and e.district='.$param['district'].'))';
				}
			} else {
				$wherearr[] = 'e.classid in ('.$param['classid'].')';
			}
			
		}
		if(!empty($param['eid']))
			$wherearr[] = 'e.eid='.$param['eid'];
		if(!empty($param['uid']) && !$isgrade)	//过滤某个教师布置的班级作业
			$wherearr[] = 'e.uid='.$param['uid'];
		if(!empty($param['q']))
			$wherearr[] = 'e.title like \'%'.$this->db->escape_str($param['q']).'%\'';
		if(!empty($wherearr))
			$sql .= ' WHERE '.implode(' AND ',$wherearr);
		$row = $this->db->query($sql)->row_array();
		if(!empty($row))
			$count = $row['count'];
		return $count;
	}

    /**
     * 删除教师网校下的作业题目,同时删除作业下的学生答题情况
     * @param int $crid
     * @param int $eid
     */
    public function delexam($crid,$cwid,$eid) {
        $wherearr = array('crid'=>$crid,'cwid'=>$cwid,'eid' => $eid);
        $afrows = $this->db->delete('ebh_exams', $wherearr);
        if($afrows > 0) {
            $wherearr = array('eid' => $eid);
            $this->db->delete('ebh_examanswers', $wherearr);
        }
        return $afrows;
    }

	/*
	*stores的在线试听作业查询
	*/
	public function getexamonlinelist($param){
		$sql = 'SELECT eid,title,score,dateline,answercount,uid FROM ebh_exams e ';
		$wherearr = array();
        if(isset($param['cwid'])){
            $wherearr[] = 'e.cwid =' . $param['cwid'];
		}
        $sql .= ' WHERE ' . implode(' AND ', $wherearr);
        if (!empty($param['order']))
            $sql .= ' ORDER BY ' . $param['order'];
        else
            $sql .= ' ORDER BY e.eid DESC ';
        if (!empty($param['limit']))
            $sql .= ' LIMIT ' . $param['limit'];
        else
            $sql .= ' LIMIT 0,10';
		return $this->db->query($sql)->list_array();
	}
	/**
	*根据课件编号获取作业记录
	*/
	public function getexamlistbycwid($param) {
		if(empty($param['cwid']))
			return FALSE;
		$sql = 'SELECT  e.eid,e.title,e.cwid,e.dateline,e.score,e.answercount,e.status FROM ebh_exams e ';
		$wherearr = array();
		$wherearr[] = 'e.cwid='.$param['cwid'];
		if(!empty($param['crid']))
			$wherearr[] = 'e.crid='.$param['crid'];
		if(!empty($param['uid']))
			$wherearr[] = 'e.uid='.$param['uid'];
		if(!empty($param['eid']))
			$wherearr[] = 'e.eid='.$param['eid'];
		if(!empty($param['status']))
			$wherearr[] = 'e.status in('.$param['status'].')';
		$sql .= ' WHERE '.implode(' AND ',$wherearr);
		if(!empty($param['order'])) {
			$sql .= ' ORDER BY '.$param['order'];
		} else {
			$sql .= ' ORDER BY e.eid';
		}
		if(!empty($param['limit'])) {
			$sql .= ' limit '.$param['limit'];
		} else
			$sql .= ' limit 0,10 ';
		return $this->db->query($sql)->list_array();
	}
	/**
	*根据作业编号获取作业详情(学校版本)
	*/
	public function getschexambyeid($eid) {
		$sql = "SELECT e.eid,e.title,e.limitedtime,e.score,e.dateline,e.status,e.answercount,e.quescount FROM ebh_schexams e WHERE e.eid=$eid";
		return $this->db->query($sql)->row_array();
	}
	/**
	*根据eid删除网校课件下的作业
	*同时会删除学生答题记录和修改课件的作业数
	*/
	public function delexambyeid($eid) {
		$wherearr = array('eid'=>$eid);
		$afrows = $this->db->delete('ebh_exams',$wherearr);
		if($afrows > 0) {
			$this->db->delete('ebh_examanswers',$wherearr);
		}
		return $afrows;
	}
	/**
	*根据eid删除学校下的作业
	*同时会删除学生答题记录
	*/
	public function delschexambyeid($param) {
		if(empty($param['eid']))
			return FALSE;
		$wherearr = array('eid='.$param['eid']);
		if(!empty($param['crid']))
			$wherearr[] = 'crid='.$param['crid'];
		if(!empty($param['uid']))
			$wherearr[] = 'uid='.$param['uid'];
		$examsql = 'select eid,crid from ebh_schexams where '.implode(' and ',$wherearr);
		$myexam = $this->db->query($examsql)->row_array();
		if(empty($myexam))
			return FALSE;
		//首先删除作业下的解析课件记录
		$aidsql = 'select aid from ebh_schexamanswers where eid='.$param['eid'];
		$aidlist = $this->db->query($aidsql)->list_array();
		$aids = '';
		foreach($aidlist as $aiditem) {
			if(empty($aids))
				$aids = $aiditem['aid'];
			else
				$aids .= ','.$aiditem['aid'];
		}
		$this->db->begin_trans();
		if(!empty($aids)) {
			$awhere = 'aid in ('.$aids.')';
			$this->db->delete('ebh_schnotes',$awhere);
		}
		//删除学生答题记录
		$this->db->delete('ebh_schexamanswers',array('eid'=>$param['eid']));
		//删除作业记录
		$afrows = $this->db->delete('ebh_schexams',array('eid'=>$param['eid']));
        $this->db->update('ebh_classrooms',array(),'crid='.$param['crid'],array('examcount'=>'examcount-1'));
		if ($this->db->trans_status() === FALSE) {
            $this->db->rollback_trans();
            return FALSE;
        } else {
            $this->db->commit_trans();
        }
		return $afrows;
	}
	/**
	*根据学生编号获取学校学生所在班级下的作业
	*/
	public function getExamListByMemberid($param) {      
		if(empty($param['uid']))
			return FALSE;
		$sql = 'SELECT e.eid,e.crid,e.title,e.dateline,e.score,e.answercount,e.limitedtime,e.folderid,u.uid,u.username,u.face,u.sex,u.realname,u.groupid,a.aid,a.status astatus,a.dateline adateline,a.completetime,a.totalscore from ebh_schexams e '.
				'LEFT JOIN ebh_schexamanswers a on (e.eid = a.eid AND a.uid='.$param['uid'].') '.
				'JOIN ebh_users u on (u.uid = e.uid) ';
		$wherearr = array();
		if(!empty($param['crid']))
			$wherearr[] = 'e.crid='.$param['crid'];
		if(!empty($param['classid'])) {	
			if(!empty($param['grade'])) {	// 根据年级过滤，一般在布置作业到年级时有效
				if(isset($param['district'])) {	// 根据校区过滤，一般在布置作业到年级时有效
					$wherearr[] = '(e.classid = '.$param['classid']. ' or e.grade = '.$param['grade'].' and e.district = '.$param['district'].')';
				} else {
					$wherearr[] = '(e.classid = '.$param['classid']. ' or e.grade = '.$param['grade'].')';
				}
			} else {
				$wherearr[] = 'e.classid='.$param['classid'];
			}
		}
		$wherearr[] = 'e.status = 1';
		if(!empty($param['tid'])){
			$wherearr[] = 'e.uid = '.$param['tid'];
		}
		if(isset($param['filteranswer']))	//过滤学生是否已经答题了，此处传值表示只显示学生未答的
			$wherearr[] = 'a.aid IS NULL';
		if(isset($param['hasanswer']))	//过滤学生是否已经答题了，此处传值表示只显示学生已答的
			$wherearr[] = 'a.aid IS NOT NULL';
		if(isset($param['subtime'])) {	// 根据时间获取记录数
			$wherearr[] = 'e.dateline > '.$param['subtime'];
		}
		if(!empty($param['q']))	//按作业标题搜索
			$wherearr[] = 'title like \'%'.$this->db->escape_str($param['q']).'%\'';
		if(!empty($param['abegindate'])) {	//答题开始时间
			$wherearr[] = 'a.dateline>='.$param['abegindate'];
		}
		if(!empty($param['aenddate'])) {	//答题完成时间
			$wherearr[] = 'a.dateline<'.$param['aenddate'];
		}
		if(!empty($param['ebegindate'])) {	//布置时间从
			$wherearr[] = 'e.dateline>='.$param['ebegindate'];
		}
		if(!empty($param['eenddate'])) {	//布置时间到
			$wherearr[] = 'e.dateline<'.$param['eenddate'];
		}
		if(isset($param['astatus'])) {	// 草稿箱状态，0为答题草稿箱 1为已提交
			$wherearr[] = 'a.status = '.$param['astatus'];
		}
		$sql .= ' WHERE '.implode(' AND ',$wherearr);
		if(!empty($param['order']))
			$sql .= ' ORDER BY '.$param['order'];
		else
			$sql .= ' ORDER BY e.eid DESC';
		if(!empty($param['limit']))
			$sql .= ' limit '.$param['limit'];
		else {
			if (empty($param['page']) || $param['page'] < 1)
				$page = 1;
			else
				$page = $param['page'];
			$pagesize = empty($param['pagesize']) ? 10 : $param['pagesize'];
			$start = ($page - 1) * $pagesize;
			$sql .= ' limit ' . $start . ',' . $pagesize;
		}
		return $this->db->query($sql)->list_array();
	}
	/**
	*根据学生编号获取学校学生所在班级下的作业记录总数
	*/
	public function getExamListCountByMemberid($param) {
		$count = 0;
		if(empty($param['uid']))
			return $count;
		$sql = 'SELECT count(*) count from ebh_schexams e '.
				'LEFT JOIN ebh_schexamanswers a on (e.eid = a.eid AND a.uid='.$param['uid'].') '.
				'JOIN ebh_users u on (u.uid = e.uid) ';
		$wherearr = array();
		if(!empty($param['crid']))
			$wherearr[] = 'e.crid='.$param['crid'];
		if(!empty($param['classid'])) {	
			if(!empty($param['grade'])) {	// 根据年级过滤，一般在布置作业到年级时有效
				if(isset($param['district'])) {	// 根据校区过滤，一般在布置作业到年级时有效
					$wherearr[] = '(e.classid = '.$param['classid']. ' or e.grade = '.$param['grade'].' and e.district = '.$param['district'].')';
				} else {
					$wherearr[] = '(e.classid = '.$param['classid']. ' or e.grade = '.$param['grade'].')';
				}
			} else {
				$wherearr[] = 'e.classid='.$param['classid'];
			}
		}
		$wherearr[] = 'e.status = 1';
		if(!empty($param['tid'])){
			$wherearr[] = 'e.uid = '.$param['tid'];
		}
		if(isset($param['filteranswer']))	//过滤学生是否已经答题了，此处传值表示只显示学生未答的
			$wherearr[] = 'a.aid IS NULL';
		if(isset($param['hasanswer']))	//过滤学生是否已经答题了，此处传值表示只显示学生已答的
			$wherearr[] = 'a.aid IS NOT NULL';
		if(isset($param['subtime'])) {	// 根据时间获取记录数
			$wherearr[] = 'e.dateline > '.$param['subtime'];
		}
		// if(!empty($param['grade'])) {	// 根据年级过滤，一般在布置作业到年级时有效
		// 	$wherearr[] = 'e.grade = '.$param['grade'];
		// }
		// if(isset($param['district'])) {	// 根据校区过滤，一般在布置作业到年级时有效
		// 	$wherearr[] = 'e.district = '.$param['district'];
		// }
		if(!empty($param['q']))	//按作业标题搜索
			$wherearr[] = 'title like \'%'.$this->db->escape_str($param['q']).'%\'';
		if(!empty($param['abegindate'])) {	//答题开始时间
			$wherearr[] = 'a.dateline>='.$param['abegindate'];
		}
		if(!empty($param['aenddate'])) {	//答题完成时间
			$wherearr[] = 'a.dateline<'.$param['aenddate'];
		}
		if(!empty($param['ebegindate'])) {	//布置时间从
			$wherearr[] = 'e.dateline>='.$param['ebegindate'];
		}
		if(!empty($param['eenddate'])) {	//布置时间到
			$wherearr[] = 'e.dateline<'.$param['eenddate'];
		}
		if(isset($param['astatus'])) {	// 草稿箱状态，0为答题草稿箱 1为已提交
			$wherearr[] = 'a.status = '.$param['astatus'];
		}
		$sql .= ' WHERE '.implode(' AND ',$wherearr);
		$row = $this->db->query($sql)->row_array();
		if(!empty($row)) 
			$count = $row['count'];
		return $count;
	}
	/**
	*根据学生编号获取网校学生的作业
	*/
	public function getRoomExamListByMemberid($param) {
		if(empty($param['uid']))
			return FALSE;
		$sql = 'SELECT e.eid,e.title,e.dateline,e.score,e.answercount,u.username,u.realname,a.aid,a.status astatus,a.dateline adateline,a.completetime,a.totalscore from ebh_exams e '.
				'LEFT JOIN ebh_examanswers a on (e.eid = a.eid AND a.uid='.$param['uid'].') '.
				'JOIN ebh_users u on (u.uid = e.uid) ';
		$wherearr = array();
		if(!empty($param['crid']))
			$wherearr[] = 'e.crid='.$param['crid'];
		$wherearr[] = 'e.status = 1';
		if(isset($param['filteranswer']))	//过滤学生是否已经答题了，此处传值表示只显示学生未答的
			$wherearr[] = 'a.aid IS NULL';
		if(isset($param['hasanswer']))	//过滤学生是否已经答题了，此处传值表示只显示学生已答的
			$wherearr[] = 'a.aid IS NOT NULL';
		if(isset($param['subtime'])) {	// 根据时间获取记录数
			$wherearr[] = 'e.dateline > '.$param['subtime'];
		}
		if(!empty($param['q']))	//按作业标题搜索
			$wherearr[] = 'title like \'%'.$this->db->escape_str($param['q']).'%\'';
		if(!empty($param['abegindate'])) {	//答题开始时间
			$wherearr[] = 'a.dateline>='.$param['abegindate'];
		}
		if(!empty($param['aenddate'])) {	//答题完成时间
			$wherearr[] = 'a.dateline<'.$param['aenddate'];
		}
		if(isset($param['astatus'])) {	// 草稿箱状态，0为答题草稿箱 1为已提交
			$wherearr[] = 'a.status = '.$param['astatus'];
		}
		$sql .= ' WHERE '.implode(' AND ',$wherearr);
		if(!empty($param['order']))
			$sql .= ' ORDER BY '.$param['order'];
		else
			$sql .= ' ORDER BY e.eid DESC';
		if(!empty($param['limit']))
			$sql .= ' limit '.$param['limit'];
		else {
			if (empty($param['page']) || $param['page'] < 1)
				$page = 1;
			else
				$page = $param['page'];
			$pagesize = empty($param['pagesize']) ? 10 : $param['pagesize'];
			$start = ($page - 1) * $pagesize;
			$sql .= ' limit ' . $start . ',' . $pagesize;
		}
		return $this->db->query($sql)->list_array();
	}
	/**
	*根据学生编号获取学校学生所在班级下的作业记录总数
	*/
	public function getRoomExamListCountByMemberid($param) {
		$count = 0;
		if(empty($param['uid']))
			return $count;
		$sql = 'SELECT count(*) count from ebh_exams e '.
				'LEFT JOIN ebh_examanswers a on (e.eid = a.eid AND a.uid='.$param['uid'].') '.
				'JOIN ebh_users u on (u.uid = e.uid) ';
		$wherearr = array();
		if(!empty($param['crid']))
			$wherearr[] = 'e.crid='.$param['crid'];
		$wherearr[] = 'e.status = 1';
		if(isset($param['filteranswer']))	//过滤学生是否已经答题了，此处传值表示只显示学生未答的
			$wherearr[] = 'a.aid IS NULL';
		if(isset($param['hasanswer']))	//过滤学生是否已经答题了，此处传值表示只显示学生已答的
			$wherearr[] = 'a.aid IS NOT NULL';
		if(isset($param['subtime'])) {	// 根据时间获取记录数
			$wherearr[] = 'e.dateline > '.$param['subtime'];
		}
		if(!empty($param['q']))	//按作业标题搜索
			$wherearr[] = 'title like \'%'.$this->db->escape_str($param['q']).'%\'';
		if(!empty($param['abegindate'])) {	//答题开始时间
			$wherearr[] = 'a.dateline>='.$param['abegindate'];
		}
		if(!empty($param['aenddate'])) {	//答题完成时间
			$wherearr[] = 'a.dateline<'.$param['aenddate'];
		}
		if(isset($param['astatus'])) {	// 草稿箱状态，0为答题草稿箱 1为已提交
			$wherearr[] = 'a.status = '.$param['astatus'];
		}
		$sql .= ' WHERE '.implode(' AND ',$wherearr);
		$row = $this->db->query($sql)->row_array();
		if(!empty($row)) 
			$count = $row['count'];
		return $count;
	}
	
	/**
	*根据学生编号获取网校学生的作业(包含课件信息和课件搜索)
	*/
	public function getRoomExamListByMemberidWithCourse($param) {
		if(empty($param['uid']))
			return FALSE;
		$sql = 'SELECT e.eid,e.title,e.dateline,e.score,e.answercount,c.title ctitle,a.aid,a.`status` astatus,a.dateline adateline,a.totalscore from ebh_exams e '.
				'LEFT JOIN ebh_examanswers a on (e.eid = a.eid AND a.uid='.$param['uid'].') '.
				'left join ebh_roomcourses rc on (rc.cwid = e.eid) '.
				'join ebh_coursewares c on (e.cwid = c.cwid) ';
		$wherearr = array();
		if(!empty($param['crid']))
			$wherearr[] = 'e.crid='.$param['crid'];
		$wherearr[] = 'e.status = 1';
		if(isset($param['filteranswer']))	//过滤学生是否已经答题了，此处传值表示只显示学生未答的
			$wherearr[] = 'a.aid IS NULL';
		if(isset($param['hasanswer']))	//过滤学生是否已经答题了，此处传值表示只显示学生已答的
			$wherearr[] = 'a.aid IS NOT NULL';
		if(isset($param['subtime'])) {	// 根据时间获取记录数
			$wherearr[] = 'e.dateline > '.$param['subtime'];
		}
		if(!empty($param['folderid']))	//按课程搜索
			$wherearr[] = 'rc.folderid='.$param['folderid'];
		if(!empty($param['q']))	//按作业标题搜索
			$wherearr[] = 'e.title like \'%'.$this->db->escape_str($param['q']).'%\'';
		if(!empty($param['abegindate'])) {	//答题开始时间
			$wherearr[] = 'a.dateline>='.$param['abegindate'];
		}
		if(!empty($param['aenddate'])) {	//答题完成时间
			$wherearr[] = 'a.dateline<'.$param['aenddate'];
		}
		if(isset($param['astatus'])) {	// 草稿箱状态，0为答题草稿箱 1为已提交
			$wherearr[] = 'a.status = '.$param['astatus'];
		}
		$sql .= ' WHERE '.implode(' AND ',$wherearr);
		if(!empty($param['order']))
			$sql .= ' ORDER BY '.$param['order'];
		else
			$sql .= ' ORDER BY e.eid DESC';
		if(!empty($param['limit']))
			$sql .= ' limit '.$param['limit'];
		else {
			if (empty($param['page']) || $param['page'] < 1)
				$page = 1;
			else
				$page = $param['page'];
			$pagesize = empty($param['pagesize']) ? 10 : $param['pagesize'];
			$start = ($page - 1) * $pagesize;
			$sql .= ' limit ' . $start . ',' . $pagesize;
		}
		return $this->db->query($sql)->list_array();
	}
	/**
	*根据学生编号获取学校学生所在班级下的作业记录总数
	*/
	public function getRoomExamListCountByMemberidWithCourse($param) {
		$count = 0;
		if(empty($param['uid']))
			return $count;
		$sql = 'SELECT count(*) count from ebh_exams e '.
				'LEFT JOIN ebh_examanswers a on (e.eid = a.eid AND a.uid='.$param['uid'].') '.
				'left join ebh_roomcourses rc on (rc.cwid = e.eid) '.
				'join ebh_coursewares c on (e.cwid = c.cwid) ';
		$wherearr = array();
		if(!empty($param['crid']))
			$wherearr[] = 'e.crid='.$param['crid'];
		$wherearr[] = 'e.status = 1';
		if(isset($param['filteranswer']))	//过滤学生是否已经答题了，此处传值表示只显示学生未答的
			$wherearr[] = 'a.aid IS NULL';
		if(isset($param['hasanswer']))	//过滤学生是否已经答题了，此处传值表示只显示学生已答的
			$wherearr[] = 'a.aid IS NOT NULL';
		if(isset($param['subtime'])) {	// 根据时间获取记录数
			$wherearr[] = 'e.dateline > '.$param['subtime'];
		}
		if(!empty($param['folderid']))	//按课程搜索
			$wherearr[] = 'rc.folderid='.$param['folderid'];
		if(!empty($param['q']))	//按作业标题搜索
			$wherearr[] = 'e.title like \'%'.$this->db->escape_str($param['q']).'%\'';
		if(!empty($param['abegindate'])) {	//答题开始时间
			$wherearr[] = 'a.dateline>='.$param['abegindate'];
		}
		if(!empty($param['aenddate'])) {	//答题完成时间
			$wherearr[] = 'a.dateline<'.$param['aenddate'];
		}
		if(isset($param['astatus'])) {	// 草稿箱状态，0为答题草稿箱 1为已提交
			$wherearr[] = 'a.status = '.$param['astatus'];
		}
		$sql .= ' WHERE '.implode(' AND ',$wherearr);
		$row = $this->db->query($sql)->row_array();
		if(!empty($row)) 
			$count = $row['count'];
		return $count;
	}
	
	/*
	根据teacherid获取教师对应班级作业列表
	*/
	public function getRoomExamListByTeacherid($param){
		$sql = 'SELECT e.eid,e.title,e.score,e.dateline,e.status,e.answercount,e.quescount 
		FROM ebh_schexams e ';
		$wherearr = array();
		$wherearr[]= 'e.status in(0,1)';
		$wherearr[]= 'e.crid='.$param['crid'];
		$wherearr[]= 'e.classid='.$param['classid'];
		$wherearr[]= 'e.uid='.$param['uid'];
		$sql.=' where '.implode(' AND ',$wherearr);
		$sql.= ' order by e.eid';
		if(!empty($param['limit']))
			$sql.= ' limit '.$param['limit'];
		else{
			if(empty($param['page']) || $param['page'] < 1)
				$page = 1;
			else
				$page = $param['page'];
			
			$pagesize = empty($param['pagesize']) ? 10 : $param['pagesize'];
			$start = ($page - 1) * $pagesize;
			$sql .= ' limit ' . $start . ',' . $pagesize;
		}
		return $this->db->query($sql)->list_array();
	}
	
	public function getRoomExamCountByTeacherid($param){
		$sql = 'select count(*) count FROM ebh_schexams e ';
		$wherearr = array();
		$wherearr[]= 'e.status in(0,1)';
		$wherearr[]= 'e.crid='.$param['crid'];
		$wherearr[]= 'e.classid='.$param['classid'];
		$wherearr[]= 'e.uid='.$param['uid'];
		$sql.=' where '.implode(' AND ',$wherearr);
		$count = $this->db->query($sql)->row_array();
		return $count['count'];
	}
	/**
	 *作业回答数减一
	 */
	public function decAnswerCount($eid){
		if(empty($eid)){
			return false;
		}
		$sql = 'update ebh_schexams e set e.answercount = e.answercount-1 where e.eid='.intval($eid);
		return $this->db->query($sql);
	}
	
	
	/**
	 * 查询已经提交的作业总数
	 * 参数1 班级id
	 * 参数2 作业id
	 * 参数3 类别 0 所有已经提交作业数 1已经批阅 2未批阅
	 * 
	 */
	public function getRoomExamCount($classid,$eid,$type=0){
		$sql = "select  count(*) count from ebh_schexamanswers a left join  ebh_classstudents as t on a.uid = t.uid left join ebh_schexams e on e.eid = a.eid where t.classid = $classid  and e.eid = $eid ";	
		if($type==1){
			$sql.=' and a.tid !=0';
		}elseif($type==2){
			$sql.=' and a.tid=0';
		}
		$count = $this->db->query($sql)->row_array();
		return $count['count'];
	}
	
	/**
	 * 教师批量审阅作业
	 * 
	 */
	public function correctRoomExam($param){
		$sql = "update ebh_schexamanswers set tid = ".$param ['tid'].", scoringtime = ".time().",remark = ".$this->db->escape($param['remark'])." ";
		$sql .=" where aid in( ".$param['aidarr']." ) ";
		$sql .=" and eid = ".$param['eid']." and totalscore between ".$param['startscore']." and ".$param['endscore'];
		//echo $sql;exit;
		$this->db->query($sql);
		return $this->db->affected_rows();
	}
	/**
	*根据课件编号获取作业记录(学校版本)
	*/
	public function getschexamlistbycwid($param) {
		if(empty($param['cwid']))
			return FALSE;
		if(!empty($param['stuid'])){
			$sql = 'SELECT  e.eid,e.title,e.cwid,e.classid,e.grade,e.district,e.dateline,e.score,e.uid,e.answercount,  (select status from ebh_schexamanswers sa where sa.eid = e.eid AND sa.uid='.$param['stuid'].') as status   FROM ebh_schexams e ';
		}else{
			$sql = 'SELECT  e.eid,e.title,e.cwid,e.classid,e.grade,e.district,e.dateline,e.score,e.uid,e.answercount FROM ebh_schexams e ';
		}
		$wherearr = array();
		$wherearr[] = 'e.cwid='.$param['cwid'];
		if(!empty($param['crid']))
			$wherearr[] = 'e.crid='.$param['crid'];
		if(!empty($param['uid']))
			$wherearr[] = 'e.uid='.$param['uid'];
		if(!empty($param['eid']))
			$wherearr[] = 'e.eid='.$param['eid'];
		if(!empty($param['status']))
			$wherearr[] = 'e.status in('.$param['status'].')';
		$sql .= ' WHERE '.implode(' AND ',$wherearr);
		if(!empty($param['order'])) {
			$sql .= ' ORDER BY '.$param['order'];
		} else {
			$sql .= ' ORDER BY e.eid';
		}
		if(!empty($param['limit'])) {
			$sql .= ' limit '.$param['limit'];
		} else
			$sql .= ' limit 0,10 ';
		return $this->db->query($sql)->list_array();
	}
	
	//获取学生针对某个作业的回答情况(学校版本)
	public function getStuExamAnswerInfo($param = array()){
		if(empty($param)){
			return array();
		}
		$sql = 'select se.eid,se.title,se.score,se.folderid,sea.totalscore from ebh_schexams se join ebh_schexamanswers sea on se.eid = sea.eid';
		$wherearr = array();
		if(!empty($param['uid'])){
			$wherearr[] ='sea.uid = '.$param['uid'];
		}
		if(!empty($param['eid'])){
			$wherearr[] ='sea.eid = '.$param['eid'];
		}
		if(isset($param['status'])){
			$wherearr[] ='sea.status = '.$param['status'];
		}
		if(!empty($param['cwid'])){
			$wherearr[] = 'se.cwid = '.$param['cwid'];
		}
		if(!empty($wherearr)){
			$sql.= ' WHERE '.implode(' AND ',$wherearr);
		}

		if(!empty($param['limit'])) {
			$sql .= ' limit '.$param['limit'];
		} else{
			$sql .= ' limit 0,100 ';
		}
		return $this->db->query($sql)->list_array();
	}
}

?>