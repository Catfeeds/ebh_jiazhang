<?php

/**
 * 作业错题集model类 ErrorbookModel
 */
class ErrorbookModel extends CModel {

	
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
	*学校学生我的错题本列表
	*/
	public function myscherrorbooklist($param = array()) {
		if(empty($param['uid']))
			return FALSE;
		$sql = 'SELECT e.exid,e.eid,ex.title as etitle,q.ques,e.qid,e.dateline,q.quetype,q.falsenum,q.score,e.uid,e.erranswers,q.title,e.uid from ebh_schquestions q '.
				'join ebh_errorbook e on (q.qid=e.quesid) '.
				'join ebh_schexams ex on (ex.eid in (q.eid)) '.
				'join ebh_classstudents c on (e.uid=c.uid) '.
				'join ebh_classes cs on (cs.classid=c.classid) ';
		$wherearr = array();
		if(!empty($param['crid'])) {
			$wherearr[] = 'q.crid='.$param['crid']; 
			$wherearr[] = 'cs.crid='.$param['crid'];
		}
		$wherearr[] = 'e.uid='.$param['uid'];
		$wherearr[] = 'q.ques !=\'\'';
		if(!empty($param['quetype'])){
			$wherearr[] = 'q.quetype ="'.$this->db->escape_str($param['quetype']).'"';
		}else{
			$wherearr[] = 'q.quetype !=\'H\'';
		}
		if(!empty($param['folderid'])){
			$wherearr[] = 'q.folderid='.$param['folderid']; 
		}
		if(!empty($param['chapterid'])){
			$wherearr[] = 'q.chapterid='.$param['chapterid']; 
		}
		$wherearr[] = 'ex.title !=\'\'';
		if(!empty($param['q']))
			$wherearr[] = 'q.title like \'%'.$this->db->escape_str($param['q']).'%\'';
		if(!empty($param['startDate']))
			$wherearr[] = 'e.dateline>='.$param['startDate'];
		if(!empty($param['endDate']))
			$wherearr[] = 'e.dateline<'.$param['endDate'];
		
		$sql .= ' WHERE '.implode(' AND ',$wherearr);
		if(!empty($param['order']))
			$sql .= ' order by '.$param['order'];
		else
			$sql .= ' order by  e.eid desc';
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
		$errorbooks = array();
		foreach($list as $l) {
			$l['subject'] = preg_replace('/(<[^>]*>)|(<[^>]*$)/', ' ', $l['title']); 
			$l['ques'] =  base64str(unserialize($l['ques']));				
			$errorbooks [] = $l;
		}
		return $errorbooks;
	}
	/**
	*学校学生我的错题本列表记录总数
	*/
	public function myscherrorbooklistcount($param = array()) {
		$count = 0;
		if(empty($param['uid']))
			return $count;
		$sql = 'SELECT count(*) count from ebh_schquestions q '.
				'join ebh_errorbook e on (q.qid=e.quesid) '.
				'join ebh_schexams ex on (ex.eid in (q.eid)) '.
				'join ebh_classstudents c on (e.uid=c.uid) '.
				'join ebh_classes cs on (cs.classid=c.classid) ';
		$wherearr = array();
		if(!empty($param['crid'])) {
			$wherearr[] = 'q.crid='.$param['crid']; 
			$wherearr[] = 'cs.crid='.$param['crid'];
		}
		$wherearr[] = 'e.uid='.$param['uid'];
		$wherearr[] = 'q.ques !=\'\'';
		if(!empty($param['quetype'])){
			$wherearr[] = 'q.quetype ="'.$this->db->escape_str($param['quetype']).'"';
		}else{
			$wherearr[] = 'q.quetype !=\'H\'';
		}
		if(!empty($param['folderid'])){
			$wherearr[] = 'q.folderid='.$param['folderid']; 
		}
		if(!empty($param['chapterid'])){
			$wherearr[] = 'q.chapterid='.$param['chapterid']; 
		}
		$wherearr[] = 'ex.title !=\'\'';
		if(!empty($param['q']))
			$wherearr[] = 'q.title like \'%'.$this->db->escape_str($param['q']).'%\'';
		if(!empty($param['startDate']))
			$wherearr[] = 'e.dateline>='.$param['startDate'];
		if(!empty($param['endDate']))
			$wherearr[] = 'e.dateline<'.$param['startDate'];
		$sql .= ' WHERE '.implode(' AND ',$wherearr);
		$row = $this->db->query($sql)->row_array();
		if(!empty($row))
			$count = $row['count'];
		return $count;
	}
	/**
	*网校学生我的错题本列表
	*/
	public function myerrorbooklist($param = array()) {
		if(empty($param['uid']))
			return FALSE;
		$sql = 'select e.eid,e.title,er.subject,er.qid,er.`type`,er.erranswers,er.dateline edateline from ebh_errorbook er '.
				'join ebh_exams e on (er.eid = e.eid) ';
		$wherearr = array();
		if(!empty($param['crid'])) {
			$wherearr[] = 'e.crid='.$param['crid']; 
		}
		$wherearr[] = 'er.uid='.$param['uid'];
		$wherearr[] = 'er.errtype=1';
		if(!empty($param['startDate']))
			$wherearr[] = 'er.dateline>='.$param['startDate'];
		if(!empty($param['endDate']))
			$wherearr[] = 'er.dateline<'.$param['startDate'];
		$sql .= ' WHERE '.implode(' AND ',$wherearr);
		if(!empty($param['order']))
			$sql .= ' order by '.$param['order'];
		else
			$sql .= ' order by  er.eid desc';
		if(!empty($param['limit']))
			$sql .= ' limit '.$param['limit'];
		else {
			if (empty($queryarr['page']) || $queryarr['page'] < 1)
				$page = 1;
			else
				$page = $queryarr['page'];
			$pagesize = empty($queryarr['pagesize']) ? 10 : $queryarr['pagesize'];
			$start = ($page - 1) * $pagesize;
			$sql .= ' limit ' . $start . ',' . $pagesize;
		}
		$list = $this->db->query($sql)->list_array();
		return $list;
	}
	/**
	*网校学生我的错题本列表记录总数
	*/
	public function myerrorbooklistcount($param = array()) {
		$count = 0;
		if(empty($param['uid']))
			return $count;
		$sql = 'select count(*) count from ebh_errorbook er '.
				'join ebh_exams e on (er.eid = e.eid) ';
		$wherearr = array();
		if(!empty($param['crid'])) {
			$wherearr[] = 'e.crid='.$param['crid']; 
		}
		$wherearr[] = 'er.uid='.$param['uid'];
		$wherearr[] = 'er.errtype=1';
		if(!empty($param['startDate']))
			$wherearr[] = 'er.dateline>='.$param['startDate'];
		if(!empty($param['endDate']))
			$wherearr[] = 'er.dateline<'.$param['startDate'];
		$sql .= ' WHERE '.implode(' AND ',$wherearr);
		$row = $this->db->query($sql)->row_array();
		if(!empty($row))
			$count = $row['count'];
		return $count;
	}
	/**
	*删除错题本
	*/
	public function delete($param) {
		if(empty($param['eid']))
			return FALSE;
		$wherearr = array('eid'=>$param['eid']);
		if(!empty($param['uid']))
			$wherearr['uid'] = $param['uid'];
		return $this->db->delete('ebh_errorbook',$wherearr);
	}
	
	/*
	学校错题排行列表
	*/
	public function getSchoolErrorBookList($param){
		if(empty($param['crid']))
			return FALSE;
		$sql = 'select distinct ex.title,q.eid,q.qid,ex.dateline,q.ques,q.quetype,q.falsenum,q.score,q.title as qtitle 
		from ebh_schquestions q 
		join ebh_schexams ex on (ex.eid in (q.eid)) ';
		$wherearr = array();
		if(!empty($param['classid'])){
			$sql.= '  join ebh_errorbook eb on(q.qid=eb.quesid)';
			$sql.= '  join ebh_classstudents cs on (cs.uid=eb.uid)';
			$wherearr[]= 'cs.classid in ('.$param['classid'].')';
		}	
		$wherearr[]= 'q.falsenum>0';
		$wherearr[]= 'q.ques!=\'\'';
		$wherearr[]= 'q.quetype!=\'H\'';
		$wherearr[]= 'ex.title!=\'\'';
		$wherearr[]= 'q.crid='.$param['crid'];
		if(!empty($param['uid']))
			$wherearr[] = 'q.uid='.$param['uid'];
		if(!empty($param['q']))
			$wherearr[] = '(ex.title like \'%'.$this->db->escape_str($param['q']).'%\' or '.
						'q.title like \'%'.$this->db->escape_str($param['q']).'%\')';
		$sql.= ' where '.implode(' and ',$wherearr);
		$sql.= ' order by q.falsenum desc ';
		if(!empty($param['limit'])) {
            $sql .= ' limit '.$param['limit'];
        } else {
			if (empty($param['page']) || $param['page'] < 1)
				$page = 1;
			else
				$page = $param['page'];
			$pagesize = empty($param['pagesize']) ? 10 : $param['pagesize'];
			$start = ($page - 1) * $pagesize;
			$sql .= ' limit ' . $start . ',' . $pagesize;
        }
		$errorlist = $this->db->query($sql)->list_array();
		$tempcount = count($errorlist);
		for($i=0;$i<$tempcount;$i++){
			$errorlist[$i]['ques'] = base64str(unserialize($errorlist[$i]['ques']));
		}
		return $errorlist;
	}
	
	/*
	学校错题数
	*/
	public function getSchoolErrorBookCount($param){
		$count = 0;
		if(empty($param['crid']))
			return $count;
		$sql = 'select count(distinct q.title) count
			from ebh_schquestions q 
			join ebh_schexams ex on (ex.eid in (q.eid)) ';
		$wherearr = array();
		if(!empty($param['classid'])){
			$sql.= '  join ebh_errorbook eb on(q.qid=eb.quesid)';
			$sql.= '  join ebh_classstudents cs on (cs.uid=eb.uid)';
			$wherearr[]= 'cs.classid in('.$param['classid'].')';
		}
		
		$wherearr[]= 'q.falsenum>0';
		$wherearr[]= 'q.ques!=\'\'';
		$wherearr[]= 'q.quetype!=\'H\'';
		$wherearr[]= 'ex.title!=\'\'';
		$wherearr[]= 'q.crid='.$param['crid'];
		if(!empty($param['uid']))
			$wherearr[] = 'q.uid='.$param['uid'];
		if(!empty($param['q']))
			$wherearr[] = '(ex.title like \'%'.$this->db->escape_str($param['q']).'%\' or '.
						'q.title like \'%'.$this->db->escape_str($param['q']).'%\')';
		$sql.= ' where '.implode(' and ',$wherearr);
		$row = $this->db->query($sql)->row_array();
		if(!empty($row))
			$count = $row['count'];
		return $count;
	}

	/*
	班级错题汇总
	*/
	public function getSchErrorBookListByClassid($param){
		if(empty($param['classid']))
			return FALSE;
		$sql = 'SELECT er.exid,er.eid,er.qid,e.title etitle,er.dateline,er.erranswers,e.score,q.ques,q.quetype,u.username,u.realname,q.title title,e.crid from ebh_errorbook er '.
			'left join ebh_schexams e on(er.exid = e.eid) '.
			'left join ebh_schquestions q on(er.quesid=q.qid) '.
			'left join ebh_users u on(er.uid = u.uid) '.
			'left join ebh_classstudents cs on(er.uid=cs.uid) ';
		
		$wherearr = array();
		if (!empty($param['crid'])) {
			$wherearr[] = 'e.crid=' . $param['crid'];
			$wherearr[] = 'q.crid=' . $param['crid'];
		}
		if (!empty($param['uid'])) {
			$where [] = 'er.uid=' . $param ['uid'];
		}
		if(!empty($param['folderid'])){
			$wherearr[] = 'q.folderid='.$param['folderid'];
		}
		$wherearr[] = 'cs.classid in ('.$param['classid'].')';
		if(!empty($param ['q'])){
			$q = $this->db->escape_str($param ['q']);
			$wherearr[] = '(q.title like \'%'.$q.'%\' or u.username like \'%'.$q.'%\' or u.realname like \'%'.$q.'%\')';
		}
		if(!empty($param['tid']))
			$wherearr[] = 'e.uid='.$param['tid'];
		$wherearr[]= 'q.falsenum>0';
		$wherearr[]= 'q.ques!=\'\'';
		$wherearr[]= 'q.quetype!=\'H\'';
		$sql.= ' where '.implode(' and ',$wherearr);
		if(!empty($param['order']))
			$sql .= ' order by '.$param['order'];
		else
			$sql .= ' order by er.eid desc ';
		if(!empty($param['limit'])) {
            $sql .= ' limit '.$param['limit'];
        } else {
			if (empty($param['page']) || $param['page'] < 1)
				$page = 1;
			else
				$page = $param['page'];
			$pagesize = empty($param['pagesize']) ? 10 : $param['pagesize'];
			$start = ($page - 1) * $pagesize;
			$sql .= ' limit ' . $start . ',' . $pagesize;
        }
		$errorlist = $this->db->query($sql)->list_array();
		$tempcount = count($errorlist);
		for($i=0;$i<$tempcount;$i++){
			$errorlist[$i]['ques'] = base64str(unserialize($errorlist[$i]['ques']));
		}
		return $errorlist;
	}
	
	/*
	学校错题数
	*/
	public function getSchErrorBookListCountByClassid($param){
		$count = 0;
		if(empty($param['classid']))
			return FALSE;
		$sql = 'SELECT count(*) count from ebh_errorbook er '.
			'left join ebh_schexams e on(er.exid = e.eid) '.
			'left join ebh_schquestions q on(er.quesid=q.qid) '.
			'left join ebh_users u on(er.uid = u.uid) '.
			'left join ebh_classstudents cs on(er.uid=cs.uid) ';
		
		$wherearr = array();
		if (!empty($param['crid'])) {
			$wherearr[] = 'e.crid=' . $param['crid'];
			$wherearr[] = 'q.crid=' . $param['crid'];
		}
		if (!empty($param['uid'])) {
			$where [] = 'er.uid=' . $param ['uid'];
		}
		if(!empty($param['folderid'])){
			$wherearr[] = 'q.folderid='.$param['folderid'];
		}
		$wherearr[] = 'cs.classid in ('.$param['classid'].')';
		if(!empty($param ['q'])){
			$q = $this->db->escape_str($param ['q']);
			$wherearr[] = '(q.title like \'%'.$q.'%\' or u.username like \'%'.$q.'%\' or u.realname like \'%'.$q.'%\')';
		}
		if(!empty($param['tid']))
			$wherearr[] = 'e.uid='.$param['tid'];
		$wherearr[]= 'q.falsenum>0';
		$wherearr[]= 'q.ques!=\'\'';
		$wherearr[]= 'q.quetype!=\'H\'';
		$sql.= ' where '.implode(' and ',$wherearr);
		$row = $this->db->query($sql)->row_array();
		if(!empty($row))
			$count = $row['count'];
		return $count;
	}

	/**
	*删除错题本
	*/
	public function deletebyExidAndUid($param) {
		if(empty($param['exid']))
			return FALSE;
		$wherearr = array('exid'=>$param['exid']);
		if(!empty($param['uid']))
			$wherearr['uid'] = $param['uid'];
		return $this->db->delete('ebh_errorbook',$wherearr);
	}
	/**
	 *获取一条题目下面的所有错题(在错题集中的错题)
	 */
	public function getTotalErrors($param = array()){
		$sql = 'select e.exid as examid,e.qid,e.erranswers,e.type,u.username,u.realname,e.dateline,e.quesid,sa.aid,sa.tid,sa.status from ebh_errorbook e join ebh_users u on e.uid = u.uid left join ebh_schexamanswers sa on e.exid = sa.eid and e.uid = sa.uid';
		$whereArr = array();
		if(!empty($param['quesid'])){
			$whereArr[] = ' e.quesid = '.$param['quesid'];
		}
		if(!empty($param['uid_in'])){
			$whereArr[] = ' e.uid in ('.implode(',', $param['uid_in']).')';
		}
		if(!empty($param['errtype'])){
			$whereArr[] = ' e.errtype = '.$param['errtype'];
		}
		if(!empty($param['type'])){
			$whereArr[] = ' e.type = '.$param['type'];
		}
		if(!empty($whereArr)){
			$sql.=' WHERE '.implode(' AND ',$whereArr);
		}
		if(!empty($param['order'])){
			$sql.= ' order by '.$param['order'];
		}else{
			$sql.= ' order by e.eid desc';
		}
		if(!empty($param['limit'])) {
            $sql .= ' limit '. $param['limit'];
        } else {
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
}

?>