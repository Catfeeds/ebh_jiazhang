<?php

/*
  答疑
 */

class AskquestionModel extends CModel {

    /**
     * 添加问题
     * @param type $param
     * @return int
     */
    public function insert($param) {
        if (!empty($param ['crid'])) {
            $setarr['crid'] = $param['crid'];
        }
        if (!empty($param ['folderid'])) {
            $setarr['folderid'] = $param['folderid'];
        }
        if (!empty($param ['catid'])) {
            $setarr['catid'] = $param['catid'];
        }
        if (!empty($param ['grade'])) {
            $setarr['grade'] = $param['grade'];
        }
        if (!empty($param ['uid'])) {
            $setarr['uid'] = $param['uid'];
        }
        if (!empty($param ['title'])) {
            $setarr['title'] = $param['title'];
        }
        if (!empty($param ['message'])) {
            $setarr['message'] = $param['message'];
        }
        if (!empty($param ['catpath'])) {
            $setarr['catpath'] = $param['catpath'];
        }
        if (!empty($param ['audioname'])) {
            $setarr['audioname'] = $param['audioname'];
        }
        if (!empty($param ['audiosrc'])) {
            $setarr['audiosrc'] = $param['audiosrc'];
        }
        if (!empty($param ['imagename'])) {
            $setarr['imagename'] = $param['imagename'];
        }
        if (!empty($param ['imagesrc'])) {
            $setarr['imagesrc'] = $param['imagesrc'];
        }
        if (!empty($param ['attname'])) {
            $setarr['attname'] = $param['attname'];
        }
        if (!empty($param ['attsrc'])) {
            $setarr['attsrc'] = $param['attsrc'];
        }
        if (!empty($param ['catpath'])) {
            $setarr['catpath'] = $param['catpath'];
        }
        $setarr['dateline'] = SYSTIME;
        if (!empty($param ['fromip'])) {
            $setarr['fromip'] = $param['fromip'];
        }
        if (isset($param ['tid'])) {
            $setarr['tid'] = $param['tid'];
        }
		if(!empty($param['cwid']))
			$setarr['cwid'] = $param['cwid'];
		if(!empty($param['cwname']))
			$setarr['cwname'] = $param['cwname'];
		if(!empty($param['reward']))
			$setarr['reward'] = $param['reward'];
        $qid = $this->db->insert('ebh_askquestions', $setarr);
        return $qid;
    }

    /**
     * 更新问题
     * @param type $param
     * @return boolean
     */
    public function update($param) {
        if (empty($param['qid']) && empty($param['uid']))
            return FALSE;
        $wherearr = array('qid' => $param['qid'], 'uid' => $param['uid']);
        if (!empty($param ['folderid'])) {
            $setarr['folderid'] = $param['folderid'];
        }
        if (!empty($param ['catid'])) {
            $setarr['catid'] = $param['catid'];
        }
        if (!empty($param ['grade'])) {
            $setarr['grade'] = $param['grade'];
        }
        if (!empty($param ['title'])) {
            $setarr['title'] = $param['title'];
        }
        if (!empty($param ['message'])) {
            $setarr['message'] = $param['message'];
        }
        if (!empty($param ['catpath'])) {
            $setarr['catpath'] = $param['catpath'];
        }
        if (!empty($param ['audioname'])) {
            $setarr['audioname'] = $param['audioname'];
        }
        if (!empty($param ['audiosrc'])) {
            $setarr['audiosrc'] = $param['audiosrc'];
        }
        if (!empty($param ['imagename'])) {
            $setarr['imagename'] = $param['imagename'];
        }
        if (!empty($param ['imagesrc'])) {
            $setarr['imagesrc'] = $param['imagesrc'];
        }
        if (!empty($param ['attname'])) {
            $setarr['attname'] = $param['attname'];
        }
        if (!empty($param ['attsrc'])) {
            $setarr['attsrc'] = $param['attsrc'];
        }
        if (!empty($param ['catpath'])) {
            $setarr['catpath'] = $param['catpath'];
        }
        if (!empty($param ['fromip'])) {
            $setarr['fromip'] = $param['fromip'];
        }
        if (isset($param ['tid'])) {
            $setarr['tid'] = $param['tid'];
        }
        if (!empty($param['lastansweruid'])){
            $setarr['lastansweruid'] = $param['lastansweruid'];
        }
		if (isset($param['cwid'])){
            $setarr['cwid'] = $param['cwid'];
        }
		if (isset($param['cwname'])){
            $setarr['cwname'] = $param['cwname'];
        }
		if (!empty($param['isrewarded'])){
			$setarr['isrewarded'] = $param['isrewarded'];
		}
		if (isset($param['reward'])){
			$setarr['reward'] = $param['reward'];
		}
        $afrows = $this->db->update('ebh_askquestions', $setarr, $wherearr);
        return $afrows;
    }

    /*
      答疑列表（试用用户未登录）
      @param array $param
      @return array 列表数组
     */

    public function getaskquestionlist($param) {
        $wherearr = array();
        $sql = 'select q.folderid,q.qid,q.catpath,q.dateline,q.crid,q.title,q.message,u.username,q.answercount,q.thankcount,q.hasbest,q.viewnum,q.shield,u.uid,u.sex,u.face,u.realname,u.groupid,q.cwname from ebh_askquestions q left join ebh_users u on q.uid=u.uid ';
        if (isset($param['crid']))
            $wherearr[] = 'q.crid=' . $param['crid'];
        if (!empty($param['uid']))
            $wherearr[] = 'q.uid=' . $param['uid'];
		if (isset($param['has']))
			$wherearr[] = 'q.hasbest=' . $param['has'];
		if (!empty($param['catid']))
            $wherearr[] = 'q.catid =' . $param['catid'];
		if (!empty($param['catidlist']))
            $wherearr[] = 'q.catid in(' . $param['catidlist'].')';
		if (isset($param['folderid']))
            $wherearr[] = 'q.folderid=' . $param['folderid'];
		if (!empty($param['grade']))
            $wherearr[] = 'q.grade =' . $param['grade'];
        if (!empty($param['q']))
            $wherearr[] = '(q.title like \'%' . $this->db->escape_str($param['q']) . '%\' or q.message like \'%' . $this->db->escape_str($param['q']) . '%\' or u.username like \'%' . $this->db->escape_str($param['q']) . '%\')';
		if (!empty($param['startdate']))
			$wherearr[]= 'q.dateline>='.$param['startdate'];
		if (!empty($param['enddate']))
			$wherearr[]= 'q.dateline<='.$param['enddate'];
        if(isset($param['shield'])){
        	$wherearr[] = 'q.shield =' . $param['shield'];
        }
        if (!empty($wherearr))
            $sql.= ' WHERE ' . implode(' AND ', $wherearr);
		if (!empty($param['order'])) {
            $sql .= ' order by ' . $param['order'];
        } else {
            $sql .= ' order by q.qid desc ';
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
   //var_dump($sql);
        return $this->db->query($sql)->list_array();
    }

    /*
      答疑数量
      @param array $param
      @return int
     */

    public function getaskquestioncount($param) {
        $wherearr = array();
        $sql = 'select count(*) count from ebh_askquestions q left join ebh_users u on q.uid=u.uid ';
        if (!empty($param['q']))
            $wherearr[] = ' (q.title like \'%' . $this->db->escape_str($param['q']) . '%\' or q.message like \'%' . $this->db->escape_str($param['q']) . '%\' or u.username like \'%' . $this->db->escape_str($param['q']) . '%\')';
        if (!empty($param['crid']))
            $wherearr[] = ' crid = ' . $param['crid'];
		if (!empty($param['has'])){
			if ($param['has']==1){
				$wherearr[] = 'q.hasbest=' . $param['has'];
			}else if ($param['has']==0){
				$wherearr[] = 'q.hasbest !=' . $param['has'];
			}
		}
        if (!empty($param['catidlist']))
            $wherearr[] = 'q.catid in(' . $param['catidlist'].')';
		if (!empty($param['folderid']))
            $wherearr[] = ' folderid = ' . $param['folderid'];
		if(isset($param['shield'])){
			$wherearr[] = 'q.shield =' . $param['shield'];
		}
		if(isset($param['hasbest'])){
			$wherearr[] = 'q.hasbest =' . $param['hasbest'];
		}
		if (!empty($param['startdate']))
			$wherearr[]= 'q.dateline>='.$param['startdate'];
		if (!empty($param['enddate']))
			$wherearr[]= 'q.dateline<='.$param['enddate'];
        if (!empty($wherearr))
            $sql.= ' WHERE ' . implode(' AND ', $wherearr);
        $count = $this->db->query($sql)->row_array();
        return $count['count'];
    }



    /*
      删除答疑
      @param int $qid
      @return bool
     */

    public function deleteaskquestion($qid) {
        return $this->db->delete('ebh_askquestions','qid='.$qid);
    }
	/*
	批量删除
	*/
	public function delAll($qidarr){
		$this->db->begin_trans();
		foreach($qidarr as $qid){
			if(!empty($qid))
				$this->db->delete('ebh_askquestions','qid='.$qid);
		}
		if ($this->db->trans_status() === FALSE) {
            $this->db->rollback_trans();
            return FALSE;
        } else {
            $this->db->commit_trans();
        }
		return TRUE;
	}
    /**
     * 教师全部问题列表
     * @param type $param
     * @return type
     */
    public function getallasklist($param) {
        if (empty($param['page']) || $param['page'] < 1)
            $page = 1;
        else
            $page = $param['page'];
        $pagesize = empty($param['pagesize']) ? 10 : $param['pagesize'];
        $start = ($page - 1) * $pagesize;
        $sql = 'select q.qid,q.crid,q.uid,q.folderid,q.title,q.answercount,q.hasbest,q.dateline,q.catpath,q.status,u.uid,u.sex,u.face,u.username,u.realname,f.foldername,q.message,q.shield,u.groupid,q.viewnum,q.cwname,q.cwid,q.reward,q.answered from ebh_askquestions q join ebh_users u on (q.uid = u.uid) left join ebh_folders f on (f.folderid = q.folderid)';
        $wherearr = array();
        if (!empty($param['crid']))
            $wherearr[] = 'q.crid=' . $param['crid'];
        if (!empty($param['uid']))
            $wherearr[] = 'q.uid=' . $param['uid'];
		if (isset($param['folderid']))
            $wherearr[] = 'q.folderid=' . $param['folderid'];
        if (!empty($param['q']))
            $wherearr[] = '(q.title like \'%' . $this->db->escape_str($param['q']) . '%\')';
		if (!empty($param['aq']))
            $wherearr[] = '(u.username =\'' . $param['aq'] .'\' or u.realname =\'' . $param['aq']. '\')';
        if(isset($param['shield'])){
        	$wherearr[] = 'q.shield =' . $param['shield'];
        }
		if(isset($param['status'])){
        	$wherearr[] = 'q.status =' . $param['status'];
        }
		if(!empty($param['abegindate'])) {	//提问时间从
			$wherearr[] = 'q.dateline>='.$param['abegindate'];
		}
		if(!empty($param['aenddate'])) {	//提问时间到
			$wherearr[] = 'q.dateline<'.$param['aenddate'];
		}
		if(!empty($param['cwid'])){
			$wherearr[] = 'q.cwid='.$param['cwid'];
		}
		if(!empty($param['tid']))
			$wherearr[] = 'q.tid='.$param['tid'];
		if(isset($param['hasbest'])){
			$wherearr[] = 'q.hasbest='.$param['hasbest'];
		}
        if (!empty($wherearr))
            $sql.= ' WHERE ' . implode(' AND ', $wherearr);
        if (!empty($param['order'])) {
            $sql .= ' order by ' . $param['order'];
        } else {
            $sql .= ' order by q.qid desc ';
        }
        $sql .= ' limit ' . $start . ',' . $pagesize;
        return $this->db->query($sql)->list_array();
    }

	 /**
     * 教师全部问题列表(查询该老师已经回答过)
     * @param type $param
     * @return type
     */
    public function getallasklists($param) {
        if (empty($param['page']) || $param['page'] < 1)
            $page = 1;
        else
            $page = $param['page'];
        $pagesize = empty($param['pagesize']) ? 10 : $param['pagesize'];
        $start = ($page - 1) * $pagesize;
        $sql = 'select q.qid,q.crid,q.uid,q.folderid,q.title,q.answercount,q.hasbest,q.dateline,q.catpath,q.status,u.uid,u.sex,u.face,u.username,u.realname,f.foldername,q.status,q.message,q.shield,u.groupid,q.reward from ebh_askquestions q join ebh_users u on (q.uid = u.uid) left join ebh_folders f on (f.folderid = q.folderid)';
        $wherearr = array();
        if (!empty($param['crid']))
            $wherearr[] = 'q.crid=' . $param['crid'];
        if (!empty($param['uid']))
            $wherearr[] = 'q.uid=' . $param['uid'];
		if (isset($param['folderid']))
            $wherearr[] = 'q.folderid=' . $param['folderid'];
        if (!empty($param['q']))
            $wherearr[] = '(q.title like \'%' . $this->db->escape_str($param['q']) . '%\')';
		if (!empty($param['aq']))
            $wherearr[] = '(u.username =\'' . $param['aq'] .'\' or u.realname =\'' . $param['aq']. '\')';
        if(isset($param['shield'])){
        	$wherearr[] = 'q.shield =' . $param['shield'];
        }
		if(!empty($param['abegindate'])) {	//提问时间从
			$wherearr[] = 'q.dateline>='.$param['abegindate'];
		}
		if(!empty($param['aenddate'])) {	//提问时间到
			$wherearr[] = 'q.dateline<'.$param['aenddate'];
		}
		if(!empty($param['cwid'])){
			$wherearr[] = 'q.cwid='.$param['cwid'];
		}
        if (!empty($wherearr))
            $sql.= ' WHERE ' . implode(' AND ', $wherearr);
        if (!empty($param['order'])) {
            $sql .= ' order by ' . $param['order'];
        } else {
            $sql .= ' order by q.qid desc ';
        }
        $sql .= ' limit ' . $start . ',' . $pagesize;
        return $this->db->query($sql)->list_array();
    }
	
	/**
     * 获取当前uid下的所有问题列表包括已回答的问题
     * @param type $param
     * @return type
     */
    public function getmyasklist($param) {
        if (empty($param['page']) || $param['page'] < 1)
            $page = 1;
        else
            $page = $param['page'];
        $pagesize = empty($param['pagesize']) ? 10 : $param['pagesize'];
        $start = ($page - 1) * $pagesize;
        $sql = 'select distinct q.qid,q.crid,q.uid,q.folderid,q.title,q.answercount,q.hasbest,q.dateline,q.catpath,u.uid,u.sex,u.face,u.username,u.realname,f.foldername,q.status,q.message,q.shield,u.groupid from ebh_askquestions q join ebh_users u on (q.uid = u.uid) left join ebh_folders f on (f.folderid = q.folderid) WHERE 1 AND (';
        $wherearr = array();
        if (!empty($param['crid']))
            $wherearr[] = 'q.crid=' . $param['crid'];
        if (!empty($param['uid']))
            $wherearr[] = 'q.uid=' . $param['uid'];
		if (isset($param['folderid']))
            $wherearr[] = 'q.folderid=' . $param['folderid'];
		if (!empty($param['aq']))
            $wherearr[] = '(u.username =\'' . $param['aq'] .'\' or u.realname =\'' . $param['aq']. '\')';
        if(isset($param['shield'])){
        	$wherearr[] = 'q.shield =' . $param['shield'];
        }
		if(!empty($param['qids'])){
			$orarr[] = ' OR q.qid IN ('.implode(',',$param['qids']).')';	
		}
        if (!empty($wherearr))
            $sql.= ' (' . implode(' AND ', $wherearr).' ) ';
		if(!empty($orarr))
			$sql.= implode(' ', $orarr);
		$sql .= ')';
		if (!empty($param['q']))
        	$sql .= ' AND (q.title like \'%' . $this->db->escape_str($param['q']) . '%\')';
        if (!empty($param['order'])) {
            $sql .= ' order by ' . $param['order'];
        } else {
            $sql .= ' order by q.qid desc ';
        }
        $sql .= ' limit ' . $start . ',' . $pagesize;
        return $this->db->query($sql)->list_array();
    }
	
	/**
     * 获取已回答的问题的qid
     * @param type $param
     * @return type
     */
	public function getaskanswersqids($param){
		$wherearr = array();
		if (!empty($param['uid']))
            $wherearr[] = 'a.uid=' . $param['uid'];
		$sql = 'SELECT a.qid FROM ebh_askanswers a ' .
                'LEFT JOIN ebh_users u ON (u.uid = a.uid) ';
		if(!empty($wherearr)){
			$sql .= ' WHERE ' . implode(' AND ',$wherearr);	
		}
		$qids = $this->db->query($sql)->list_array();
		//去重
		if(count($qids)>0){
			foreach($qids as $k=>$v){
				$qidarr[] = $v['qid'];	
			}		
		}
		$qidarr = !empty($qidarr) ? array_unique($qidarr) : array();
		return $qidarr;
	} 
	
    /**
     * 教师全部问题列表记录数
     * @param type $param
     * @return type
     */
    public function getallaskcount($param) {
        $count = 0;
        $sql = 'select count(*) count from ebh_askquestions q join ebh_users u on (q.uid = u.uid)';
        $wherearr = array();
        if (!empty($param['crid']))
            $wherearr[] = 'q.crid=' . $param['crid'];
        if (!empty($param['uid']))
            $wherearr[] = 'q.uid=' . $param['uid'];
		if (isset($param['folderid']))
            $wherearr[] = 'q.folderid=' . $param['folderid'];
		if(isset($param['shield'])){
			$wherearr[] = 'q.shield =' . $param['shield'];
		}
        if (!empty($param['q']))
            $wherearr[] = '(q.title like \'%' . $this->db->escape_str($param['q']) . '%\' or u.username like \'%' . $this->db->escape_str($param['q']) . '%\')';
		if (!empty($param['aq']))
            $wherearr[] = '(u.username =\'' . $param['aq'] .'\' or u.realname =\'' . $param['aq']. '\')';
		if(!empty($param['abegindate'])) {	//提问时间从
			$wherearr[] = 'q.dateline>='.$param['abegindate'];
		}
		if(!empty($param['aenddate'])) {	//提问时间到
			$wherearr[] = 'q.dateline<'.$param['aenddate'];
		}
		if(!empty($param['cwid'])){
			$wherearr[] = 'q.cwid='.$param['cwid'];
		}
		if(isset($param['status'])){
        	$wherearr[] = 'q.status =' . $param['status'];
        }
		if(!empty($param['tid']))
			$wherearr[] = 'q.tid='.$param['tid'];
		if(isset($param['hasbest'])){
			$wherearr[] = 'q.hasbest='.$param['hasbest'];
		}
        if (!empty($wherearr))
            $sql.= ' WHERE ' . implode(' AND ', $wherearr);
        $countrow = $this->db->query($sql)->row_array();
        if (!empty($countrow) && !empty($countrow['count']))
            $count = $countrow['count'];
        return $count;
    }
	
	/**
     * 我的问题列表记录数
     * @param type $param
     * @return type
     */
    public function getmyaskcount($param) {
        $count = 0;
        $sql = 'select count( distinct q.qid) count from ebh_askquestions q join ebh_users u on (q.uid = u.uid)';
        $orarr = $wherearr = array();
        if (!empty($param['crid']))
            $wherearr[] = 'q.crid=' . $param['crid'];
        if (!empty($param['uid']))
            $wherearr[] = 'q.uid=' . $param['uid'];
		if (isset($param['folderid']))
            $wherearr[] = 'q.folderid=' . $param['folderid'];
		if(isset($param['shield'])){
			$wherearr[] = 'q.shield =' . $param['shield'];
		}
        if (!empty($param['q']))
            $wherearr[] = '(q.title like \'%' . $this->db->escape_str($param['q']) . '%\' or u.username like \'%' . $this->db->escape_str($param['q']) . '%\')';
		if (!empty($param['aq']))
            $wherearr[] = '(u.username =\'' . $param['aq'] .'\' or u.realname =\'' . $param['aq']. '\')';	
		if (!empty($wherearr))
            $sql.= ' WHERE (' . implode(' AND ', $wherearr) . ')';
		if(!empty($param['qids']))
			$orarr[] = ' OR q.qid IN ('.implode(',',$param['qids']).') ';
		if(!empty($orarr))
			$sql.= implode(' ',$orarr);
        $countrow = $this->db->query($sql)->row_array();
        if (!empty($countrow) && !empty($countrow['count']))
            $count = $countrow['count'];
        return $count;
    }

    /**
     * 删除答疑问题表
     * @param int $qid问题编号
     * @return boolean
     */
    public function delask($qid) {
        $this->db->begin_trans();
        //删除课件评论，ebh_logs和ebh_reviews
        $wherearr = array('qid' => $qid);
        //删除回答记录
        $this->db->delete('ebh_askanswers', $wherearr);
        //删除问题表
        $arows = $this->db->delete('ebh_askquestions', $wherearr);
        if ($this->db->trans_status() === FALSE) {
            $this->db->rollback_trans();
            return FALSE;
        } else {
            $this->db->commit_trans();
        }
        if ($arows > 0)
            return TRUE;
        return FALSE;
    }

    /**
     * 根据问题编号获取问题信息
     * @param int $qid
     * @return array
     */
    public function getaskbyqid($qid) {
        $sql = 'select q.qid,q.crid,q.uid,q.title,q.audioname,q.audiosrc,q.imagename,q.imagesrc,q.answercount,q.thankcount,q.hasbest,q.`status`,q.dateline,q.viewnum,q.attname,q.attsrc from ebh_askquestions q where q.qid=' . $qid.' and q.shield = 0 ';
        return $this->db->query($sql)->row_array();
    }
    public function getdetailaskbyqid($qid, $uid = 0) {
        if ($uid > 0) {
            $sql = 'select q.qid,q.shield,q.crid,q.uid,q.title,q.message,q.reqid,u.username,u.realname,q.folderid,f.foldername,q.audioname,q.audiosrc,q.imagename,q.imagesrc,q.answercount,q.thankcount,q.hasbest,q.`status`,q.dateline,q.viewnum,q.attname,q.attsrc,q.catpath,q.tid,af.aid,q.catid,q.grade,q.shield,u.sex,u.face,u.groupid,q.cwid,q.cwname,q.reward,q.isrewarded from ebh_askquestions q ' .
                    'join ebh_users u on (u.uid = q.uid) ' .
                    'left join ebh_folders f on (f.folderid = q.folderid) ' .
                    'left join ebh_askfavorites af on (af.qid = q.qid and af.uid=' . $uid . ') ' .
                    'where q.qid=' . $qid ;
        } else {
            $sql = 'select q.qid,q.shield,q.crid,q.uid,q.title,q.message,q.reqid,u.username,u.realname,u.sex,q.folderid,f.foldername,q.audioname,q.audiosrc,q.imagename,q.imagesrc,q.answercount,q.thankcount,q.hasbest,q.`status`,q.dateline,q.viewnum,q.attname,q.attsrc,q.catpath,q.tid,q.shield,u.groupid,q.cwname,q.reward,q.isrewarded from ebh_askquestions q ' .
                    'join ebh_users u on (u.uid = q.uid) ' .
                    'left join ebh_folders f on (f.folderid = q.folderid) ' .
                    'where q.qid=' . $qid;
        }
        return $this->db->query($sql)->row_array();
    }

    /**
     * 根据问题编号获取答题记录列表
     * @param type $qid
     */
    public function getanswersbyqid($qid) {
        $sql = 'select a.aid,a.qid,a.uid,a.answertype,a.message,a.audioname,a.audiosrc,a.imagename,a.imagesrc,a.coursename,a.coursesrc,a.isbest,a.thankcount,a.dateline,a.attname,a.attsrc,a.cwid,a.cwsource from ebh_askanswers a where a.qid=' . $qid.' and a.shield = 0 ';
        $sql .= ' ORDER BY a.isbest desc,a.aid desc';
        return $this->db->query($sql)->list_array();
    }

    /**
     * 根据问题编号获取详细答题记录列表
     * @param int $qid
     */
    public function getdetailanswersbyqid($param) {
         if (empty($param['page']) || $param['page'] < 1)
            $page = 1;
        else
            $page = $param['page'];
        $pagesize = empty($param['pagesize']) ? 10 : $param['pagesize'];
        $start = ($page - 1) * $pagesize;
        $sql = 'select a.aid,a.qid,a.uid,a.answertype,a.message,a.audioname,a.audiosrc,a.imagename,a.imagesrc,a.coursename,a.coursesrc,a.isbest,a.thankcount,a.dateline,a.attname,a.attsrc,a.cwid,a.cwsource,u.username,u.realname ,u.sex,u.groupid,u.face from ebh_askanswers a '
                . ' join ebh_users u on (u.uid = a.uid) where a.qid=' . $param['qid'] . ' and shield = 0 ';
        $sql .= ' ORDER BY a.isbest desc,a.aid desc';
        $sql .= ' limit ' . $start . ',' . $pagesize;
        return $this->db->query($sql)->list_array();
    }

	 /**
     * 根据问题编号获取详细答题记录列表(被屏蔽的回答也读取出来)
     * @param int $qid
     */
    public function getdetailanswers($param) {
         if (empty($param['page']) || $param['page'] < 1)
            $page = 1;
        else
            $page = $param['page'];
        $pagesize = empty($param['pagesize']) ? 10 : $param['pagesize'];
        $start = ($page - 1) * $pagesize;
        $sql = 'select a.aid,a.qid,a.uid,a.answertype,a.message,a.audioname,a.audiosrc,a.imagename,a.imagesrc,a.coursename,a.coursesrc,a.isbest,a.thankcount,a.dateline,a.attname,a.attsrc,a.cwid,a.cwsource,u.username,u.realname ,u.sex,u.groupid,u.face,a.shield from ebh_askanswers a '
                . ' join ebh_users u on (u.uid = a.uid) where a.qid=' . $param['qid'] ;
        $sql .= ' ORDER BY a.isbest desc,a.aid desc';
        $sql .= ' limit ' . $start . ',' . $pagesize;
        return $this->db->query($sql)->list_array();
    }


    /**
     * 根据问题编号获取详细答题记录数量
     * @param int $qid
     */
    public function getdetailanswerscountbyqid($qid) {
        $count = 0;
        $sql = 'select count(*) count from ebh_askanswers a '
                . ' join ebh_users u on (u.uid = a.uid) where shield = 0 and a.qid=' . $qid;
        $countrow = $this->db->query($sql)->row_array();
        if (!empty($countrow) && !empty($countrow['count']))
            $count = $countrow['count'];
        return $count;
    }
	/**
     * 根据问题编号获取详细答题记录数量(被屏蔽的回答也读取出来)
     * @param int $qid
     */
    public function getdetailanswerscount($qid) {
        $count = 0;
        $sql = 'select count(*) count from ebh_askanswers a '
                . ' join ebh_users u on (u.uid = a.uid) where a.qid=' . $qid;
        $countrow = $this->db->query($sql)->row_array();
        if (!empty($countrow) && !empty($countrow['count']))
            $count = $countrow['count'];
        return $count;
    }

    /**
     * 获取用户回答过的问题列表
     * @param array $param
     * @return list
     */
    public function getasklistbyanswers($param) {
        if (empty($param['page']) || $param['page'] < 1)
            $page = 1;
        else
            $page = $param['page'];
        $pagesize = empty($param['pagesize']) ? 10 : $param['pagesize'];
        $start = ($page - 1) * $pagesize;
        $sql = 'SELECT q.qid,q.title,q.hasbest,q.dateline,q.catpath,q.status,a.dateline as adateline,a.isbest,q.answercount,f.foldername,u.uid,u.sex,u.face,u.username,u.realname,q.shield,u.groupid,q.reward FROM ebh_askquestions q ' .
                'LEFT JOIN ebh_askanswers a ON (q.qid = a.qid) ' .
                'LEFT JOIN ebh_users u ON (u.uid = q.uid) ' .
                'LEFT JOIN ebh_folders f on (q.folderid = f.folderid) ';
        $wherearr = array();
        if (!empty($param['crid']))
            $wherearr[] = 'q.crid=' . $param['crid'];
        if (!empty($param['uid']))
            $wherearr[] = 'a.uid=' . $param['uid'];
		if(!empty($param['startDate']))
			$wherearr[] = 'a.dateline>='.$param['startDate'];
		if(!empty($param['endDate']))
			$wherearr[] = 'a.dateline<'.$param['endDate'];
        if (!empty($param['q']))
            $wherearr[] = '(q.title like \'%' . $this->db->escape_str($param['q']) . '%\' or u.username like \'%' . $this->db->escape_str($param['q']) . '%\')';
		if (isset($param['ashield']))
            $wherearr[] = 'a.shield=' . $param['ashield'];
		if (isset($param['qshield']))
            $wherearr[] = 'q.shield=' . $param['qshield'];
		if (isset($param['folderid']))
            $wherearr[] = 'q.folderid=' . $param['folderid'];
        if (!empty($wherearr))
            $sql.= ' WHERE ' . implode(' AND ', $wherearr);
    //    $sql .= ' AND a.shield =0 AND q.shield =0 ';
		$sql .= ' ORDER BY a.dateline desc ';
        $sql .= ' limit ' . $start . ',' . $pagesize;
        return $this->db->query($sql)->list_array();
    }

	/**
     * 获取用户未回答过的问题列表
     * @param array $param
     * @return list
     */
    public function getasklistbynoanswers($param) {
        if (empty($param['page']) || $param['page'] < 1)
            $page = 1;
        else
            $page = $param['page'];
        $pagesize = empty($param['pagesize']) ? 10 : $param['pagesize'];
        $start = ($page - 1) * $pagesize;
        $sql = 'select q.qid,q.title,q.hasbest,q.dateline,q.catpath,q.status,q.answercount,f.foldername,u.uid,u.sex,u.face,u.username,u.realname,q.shield,u.groupid,q.reward,q.viewnum,q.cwid,q.cwname,f.folderid from ebh_askquestions q ' .
                'LEFT JOIN ebh_users u ON (u.uid = q.uid) ' .
                'LEFT JOIN ebh_folders f on (q.folderid = f.folderid) ';
        $wherearr = array();
        if (!empty($param['crid']))
            $wherearr[] = 'q.crid=' . $param['crid'];
//        if (!empty($param['uid']))
//            $wherearr[] = 'a.uid=' . $param['uid'];
		if (isset($param['folderid']))
            $wherearr[] = 'q.folderid=' . $param['folderid'];
		if(!empty($param['cwid'])){
			$wherearr[] = 'q.cwid='.$param['cwid'];
		}
		if(!empty($param['startDate']))
			$wherearr[] = 'q.dateline>='.$param['startDate'];
		if(!empty($param['endDate']))
			$wherearr[] = 'q.dateline<'.$param['endDate'];
        if (!empty($param['q']))
            $wherearr[] = '(q.title like \'%' . $this->db->escape_str($param['q']) . '%\' or u.username like \'%' . $this->db->escape_str($param['q']) . '%\')';
		if (!empty($param['aq']))
			$wherearr[] = '(u.username = \''. $this->db->escape_str($param['aq']) .'\' or u.realname = \'' . $this->db->escape_str($param['aq']) .'\')';
		if (isset($param['qshield']))
            $wherearr[] = 'q.shield=' . $param['qshield'];
        if (!empty($wherearr))
            $sql.= ' WHERE ' . implode(' AND ', $wherearr);
		$sql .= ' and u.uid!=0 and q.qid not in '.
				'( SELECT q.qid FROM ebh_askquestions q ' .
                'LEFT JOIN ebh_askanswers a ON (q.qid = a.qid) '.
				'where q.crid='.$param['crid'].' AND a.uid='.$param['uid'].' ) ';
		$sql .= ' ORDER BY q.dateline desc ';
        $sql .= ' limit ' . $start . ',' . $pagesize ;
        return $this->db->query($sql)->list_array();
    }

	 /**
     * 获取用户未回答过的问题列表记录数
     * @param array $param
     * @return list
     */
    public function getaskcountbynoanswers($param) {
        $count = 0;
        $sql = 'select count(*) count from ebh_askquestions q ' .
                'LEFT JOIN ebh_users u ON (u.uid = q.uid) ' .
                'LEFT JOIN ebh_folders f on (q.folderid = f.folderid) ';
        $wherearr = array();
        if (!empty($param['crid']))
            $wherearr[] = 'q.crid=' . $param['crid'];
		if (isset($param['folderid']))
            $wherearr[] = 'q.folderid=' . $param['folderid'];
		if(!empty($param['cwid'])){
			$wherearr[] = 'q.cwid='.$param['cwid'];
		}
		if(!empty($param['startDate']))
			$wherearr[] = 'q.dateline>='.$param['startDate'];
		if(!empty($param['endDate']))
			$wherearr[] = 'q.dateline<'.$param['endDate'];
        if (!empty($param['q']))
            $wherearr[] = '(q.title like \'%' . $this->db->escape_str($param['q']) . '%\' or u.username like \'%' . $this->db->escape_str($param['q']) . '%\')';
		if (!empty($param['aq']))
			$wherearr[] = '(u.username = \''. $this->db->escape_str($param['aq']) .'\' or u.realname = \'' . $this->db->escape_str($param['aq']) .'\')';
		if (isset($param['qshield']))
            $wherearr[] = 'q.shield=' . $param['qshield'];
        if (!empty($wherearr))
            $sql.= ' WHERE ' . implode(' AND ', $wherearr);
        $sql .= ' and u.uid!=0 and q.qid not in '.
				'( SELECT q.qid FROM ebh_askquestions q ' .
                'LEFT JOIN ebh_askanswers a ON (q.qid = a.qid) '.
				'where q.crid='.$param['crid'].' AND a.uid='.$param['uid'].' ) ';
        $countrow = $this->db->query($sql)->row_array();
        if (!empty($countrow) && !empty($countrow['count']))
            $count = $countrow['count'];
        return $count;
    }

	 /**
     * 获取用户回答过的问题列表id
     * @param array $param
     * @return list
     */
    public function getasklistbyanswersid($param) {
        $sql = 'SELECT q.qid FROM ebh_askquestions q ' .
                'LEFT JOIN ebh_askanswers a ON (q.qid = a.qid) ' .
                'LEFT JOIN ebh_users u ON (u.uid = q.uid) ' .
                'LEFT JOIN ebh_folders f on (q.folderid = f.folderid) ';
        $wherearr = array();
        if (!empty($param['crid']))
            $wherearr[] = 'q.crid=' . $param['crid'];
        if (!empty($param['uid']))
            $wherearr[] = 'a.uid=' . $param['uid'];
		if(!empty($param['startDate']))
			$wherearr[] = 'a.dateline>='.$param['startDate'];
		if(!empty($param['endDate']))
			$wherearr[] = 'a.dateline<'.$param['endDate'];
        if (!empty($param['q']))
            $wherearr[] = '(q.title like \'%' . $this->db->escape_str($param['q']) . '%\' or u.username like \'%' . $this->db->escape_str($param['q']) . '%\')';
		if (isset($param['ashield']))
            $wherearr[] = 'a.shield=' . $param['ashield'];
		if (isset($param['qshield']))
            $wherearr[] = 'q.shield=' . $param['qshield'];
        if (!empty($wherearr))
            $sql.= ' WHERE ' . implode(' AND ', $wherearr);
		$sql .= ' ORDER BY a.dateline desc ';
        return $this->db->query($sql)->list_array();
    }

    /**
     * 获取用户回答过的问题列表记录数
     * @param array $param
     * @return list
     */
    public function getaskcountbyanswers($param) {
        $count = 0;
        $sql = 'SELECT count(*) count FROM ebh_askquestions q ' .
                'LEFT JOIN ebh_askanswers a ON (q.qid = a.qid) ' .
                'LEFT JOIN ebh_users u ON (u.uid = q.uid) ';
        $wherearr = array();
        if (!empty($param['crid']))
            $wherearr[] = 'q.crid=' . $param['crid'];
        if (!empty($param['uid']))
            $wherearr[] = 'a.uid=' . $param['uid'];
		if(!empty($param['startDate']))
			$wherearr[] = 'a.dateline>='.$param['startDate'];
		if(!empty($param['endDate']))
			$wherearr[] = 'a.dateline<'.$param['endDate'];
        if (!empty($param['q']))
            $wherearr[] = '(q.title like \'%' . $this->db->escape_str($param['q']) . '%\' or u.username like \'%' . $this->db->escape_str($param['q']) . '%\')';
		if (isset($param['ashield']))
            $wherearr[] = 'a.shield=' . $param['ashield'];
		if (isset($param['qshield']))
            $wherearr[] = 'q.shield=' . $param['qshield'];
		if (isset($param['folderid']))
            $wherearr[] = 'q.folderid=' . $param['folderid'];
        if (!empty($wherearr))
            $sql.= ' WHERE ' . implode(' AND ', $wherearr);
    //    $sql .= ' AND a.shield =0 AND q.shield =0 ';
        $countrow = $this->db->query($sql)->row_array();
        if (!empty($countrow) && !empty($countrow['count']))
            $count = $countrow['count'];
        return $count;
    }

    /**
     * 获取用户关注的问题列表
     * @param array $param
     * @return list
     */
    public function getasklistbyfavorit($param) {
        if (empty($param['page']) || $param['page'] < 1)
            $page = 1;
        else
            $page = $param['page'];
        $pagesize = empty($param['pagesize']) ? 10 : $param['pagesize'];
        $start = ($page - 1) * $pagesize;
        $sql = 'SELECT q.uid,q.qid,q.title,q.hasbest,q.dateline,q.catpath,q.answercount,q.status,f.foldername,a.aid,u.uid,u.sex,u.face,u.username,u.realname,q.shield,u.groupid,q.reward FROM ebh_askquestions q ' .
                'LEFT JOIN ebh_askfavorites a ON (q.qid = a.qid) ' .
                'LEFT JOIN ebh_users u ON (u.uid = q.uid) ' .
                'LEFT JOIN ebh_folders f on (q.folderid = f.folderid) ';
        $wherearr = array();
        if (!empty($param['crid']))
            $wherearr[] = 'q.crid=' . $param['crid'];
        if (!empty($param['uid']))
            $wherearr[] = 'a.uid=' . $param['uid'];
        if (!empty($param['q']))
            $wherearr[] = '(q.title like \'%' . $this->db->escape_str($param['q']) . '%\' or u.username like \'%' . $this->db->escape_str($param['q']) . '%\')';
		if (isset($param['folderid']))
            $wherearr[] = 'q.folderid=' . $param['folderid'];
        if (!empty($wherearr))
            $sql.= ' WHERE ' . implode(' AND ', $wherearr);
        $sql .= ' AND  q.shield =0 ';
        $sql .= ' limit ' . $start . ',' . $pagesize;
        //echo $sql;
        return $this->db->query($sql)->list_array();
    }

    /**
     * 获取用户回答过的问题列表记录数
     * @param array $param
     * @return list
     */
    public function getaskcountbyfavorit($param) {
        $count = 0;
        $sql = 'SELECT count(*) count FROM ebh_askquestions q ' .
                'LEFT JOIN ebh_askfavorites a ON (q.qid = a.qid) ' .
                'LEFT JOIN ebh_users u ON (u.uid = q.uid) ';
        $wherearr = array();
        if (!empty($param['crid']))
            $wherearr[] = 'q.crid=' . $param['crid'];
        if (!empty($param['uid']))
            $wherearr[] = 'a.uid=' . $param['uid'];
        if (!empty($param['q']))
            $wherearr[] = '(q.title like \'%' . $this->db->escape_str($param['q']) . '%\' or u.username like \'%' . $this->db->escape_str($param['q']) . '%\')';
        if (!empty($wherearr))
            $sql.= ' WHERE ' . implode(' AND ', $wherearr);
        $sql .= ' AND q.shield =0 ';
        $countrow = $this->db->query($sql)->row_array();
        if (!empty($countrow) && !empty($countrow['count']))
            $count = $countrow['count'];
        return $count;
    }
    
    /**
     * 获取用户的问题感谢记录数
     * @param array $param
     * @return list
     */
    public function getaskcountbythank($param) {
    	$count = 0;
    	$sql = 'SELECT sum(thankcount) as count FROM ebh_askquestions q ';
    	$wherearr = array();
    	if (!empty($param['crid']))
    		$wherearr[] = 'q.crid=' . $param['crid'];
    	if (!empty($param['uid'])){
    		$wherearr[] = 'q.uid = '.$param['uid'];
    	}
    	if (!empty($wherearr))
    		$sql.= ' WHERE ' . implode(' AND ', $wherearr);
    	$sql .= ' AND q.shield =0 ';
    	$countrow = $this->db->query($sql)->row_array();
    	if (!empty($countrow) && !empty($countrow['count']))
    		$count = $countrow['count'];
    	return $count;
    }
    
    /**
     * 获取用户答疑过的问题感谢记录数
     * @param array $param
     * @return list
     */
    public function getanscountbythank($param) {
    	$count = 0;
    	$sql = 'SELECT sum(a.thankcount) as count FROM ebh_askanswers a left join ebh_askquestions q on a.qid = q.qid';
    	$wherearr = array();
    	if (!empty($param['crid']))
    		$wherearr[] = 'q.crid=' . $param['crid'];
    	if (!empty($param['uid'])){
    		$wherearr[] = 'a.uid = '.$param['uid'];
    	}
    	if (!empty($wherearr))
    		$sql.= ' WHERE ' . implode(' AND ', $wherearr);
    	$sql .= ' AND a.shield =0 ';
    	$countrow = $this->db->query($sql)->row_array();
    	if (!empty($countrow) && !empty($countrow['count']))
    		$count = $countrow['count'];
    	return $count;
    }
    
    /**
     *获取用户总的答疑数 
     */
    public function getanscount($param) {
    	$count = 0;
    	$sql = 'SELECT count(*) as count FROM ebh_askanswers a ';
    	$wherearr = array();
    	if (!empty($param['uid'])){
    		$wherearr[] = 'a.uid = '.$param['uid'];
    	}
    	if (!empty($wherearr))
    		$sql.= ' WHERE ' . implode(' AND ', $wherearr);
    	$sql .= ' AND a.shield =0 ';
    	$countrow = $this->db->query($sql)->row_array();
    	if (!empty($countrow) && !empty($countrow['count']))
    		$count = $countrow['count'];
    	return $count;
    }
	
    /**
     * 添加我的关注
     * @param array $param
     * @return int 影响行数
     */
    public function addfavorit($param) {
        $setarr = array('qid' => $param['qid'], 'uid' => $param['uid'], 'dateline' => SYSTIME);
        $afrows = $this->db->insert('ebh_askfavorites', $setarr);
        return $afrows;
    }

    /**
     * 删除我的关注
     * @param array $param
     * @return int 影响行数
     */
    public function delfavorit($param) {
        $wherearr = array();
        if (!empty($param['uid']) && !empty($param['aid'])) {
            $wherearr['uid'] = $param['uid'];
            $wherearr['aid'] = $param['aid'];
        } else if (!empty($param['uid']) && !empty($param['qid'])) {
            $wherearr['uid'] = $param['uid'];
            $wherearr['qid'] = $param['qid'];
        }
        $afrows = $this->db->delete('ebh_askfavorites', $wherearr);
        return $afrows;
    }

    /**
     * 添加感谢
     * @param int $qid
     * @return int
     */
    public function addthank($qid) {
        $wherearr = array('qid' => $qid);
        $setarr = array('thankcount' => 'thankcount+1');
        $afrows = $this->db->update('ebh_askquestions', array(), $wherearr, $setarr);
        return $afrows;
    }

    /**
     * 添加对回答的感谢
     */
    function addthankanswer($param) {
        $setarr = array('thankcount' => 'thankcount+1');
        $wherearr = array('aid' => $param['aid'], 'qid' => $param['qid']);
        $afrows = $this->db->update('ebh_askanswers', array(), $wherearr, $setarr);
        return $afrows;
    }

    /**
     * 添加回答
     */
    function addanswer($param = array()) {
        if (empty($param) || empty($param['qid']) || empty($param['uid']))
            return false;
        //新版为了调动用户积极性,即使已有最佳答案仍然可以回答
		// $sql = 'select status from ebh_askquestions where qid='.$param['qid'];
		// $res = $this->db->query($sql)->row_array();
		// if($res['status'] == 1)
		// 	return false;
        $setarr = array();
        $setarr['qid'] = $param['qid'];
        $setarr['uid'] = $param['uid'];
        if (!empty($param ['message'])) {
            $setarr['message'] = $param['message'];
        }
        if (!empty($param ['audioname'])) {
            $setarr['audioname'] = $param['audioname'];
        }
        if (!empty($param ['audiosrc'])) {
            $setarr['audiosrc'] = $param['audiosrc'];
        }
        if (!empty($param ['imagename'])) {
            $setarr['imagename'] = $param['imagename'];
        }
        if (!empty($param ['imagesrc'])) {
            $setarr['imagesrc'] = $param['imagesrc'];
        }
        if (!empty($param ['attname'])) {
            $setarr['attname'] = $param['attname'];
        }
        if (!empty($param ['attsrc'])) {
            $setarr['attsrc'] = $param['attsrc'];
        }
        if (!empty($param ['fromip'])) {
            $setarr['fromip'] = $param['fromip'];
        }
        if (!empty($param['cwid'])) {
            $setarr['cwid'] = $param['cwid'];
        }        
        if (!empty($param['cwsource'])) {
            $setarr['cwsource'] = $param['cwsource'];
        }
        $setarr['dateline'] = SYSTIME;
        $aid = $this->db->insert('ebh_askanswers', $setarr);
        if ($aid) {
            $this->updateanswercount($param['qid'],2);
            return $aid;
        } else {
            return 0;
        }
    }

    /**
     * 删除答案
     */
    function delanswer($param = array()) {
        if (empty($param) || empty($param['qid']) || empty($param['uid']) || empty($param['aid']))
            return false;
        $wherearr = array('aid' => $param['aid'], 'qid' => $param['qid'], 'uid' => $param['uid']);
        $afrows = $this->db->delete('ebh_askanswers', $wherearr);
        if ($afrows > 0) {
            $this->updateanswercount($param['qid'],2,-1);
        }
        return $afrows;
    }

	 /**
     * 更新问题的回答数
     * @param type $qid
     * @param type $count
     * @return type
     */
    public function updateanswercount($qid,$shield,$count = 1) {
		if($shield==1){//屏蔽回答,回答数更新
			$setarr = array('answercount' => 'answercount - ' . $count);
		}else{
			$setarr = array('answercount' => 'answercount + ' . $count);
		}
        $wherearr = array('qid' => $qid);
        $afrows = $this->db->update('ebh_askquestions', array(), $wherearr, $setarr);
        return $afrows;
    }

    /**
     * 根据时间获取该平台学生最新的问题数
     * @param type $crid
     * @param type $time
     * @return type
     */
    public function getnewaskcountbytime($crid, $time) {
        $count = 0;
        $sql = "SELECT COUNT(*) count FROM ebh_askquestions q  " .
                "WHERE q.crid=$crid AND q.dateline > $time AND q.shield = 0";
        $row = $this->db->query($sql)->row_array();
        if (!empty($row))
            $count = $row['count'];
        return $count;
    }

	/**
	*课件的答疑查询详情
	*/
	//getaskcourse  
	public function getasklistwithfavorite($param){

		$sql = 'SELECT q.qid,q.crid,q.folderid,q.catid,q.grade,q.catpath,q.uid,q.title,q.message,q.imagename,q.imagesrc,q.audioname,q.audiosrc,q.answercount,q.thankcount,q.hasbest,q.status,q.dateline,q.viewnum,q.shield,u.uid,u.sex,u.face,u.username,u.realname,fa.aid,u.groupid FROM ebh_askquestions q '
		.'left join ebh_users u on (q.uid=u.uid) '	
		.'left join ebh_askfavorites fa on (q.qid = fa.qid and fa.uid = '.$param['auid'].')' ;

		$wherearr = array();
		 if (isset($param['crid']))
            $wherearr[] = 'q.crid=' . $param['crid'];
        if (!empty($param['uid']))
            $wherearr[] = 'q.uid=' . $param['uid'];
		if (!empty($param['catid']))
            $wherearr[] = 'q.catid =' . $param['catid'];
		if (!empty($param['catidlist']))
            $wherearr[] = 'q.catid in(' . $param['catidlist'].')';
		if (isset($param['folderid']))
            $wherearr[] = 'q.folderid=' . $param['folderid'];
		if (!empty($param['grade']))
            $wherearr[] = 'q.grade =' . $param['grade'];
        if (!empty($param['q']))
            $wherearr[] = '(q.title like \'%' . $this->db->escape_str($param['q']) . '%\' or u.username like \'%' . $this->db->escape_str($param['q']) . '%\')';
        if (isset($param['shield']))
        	$wherearr[] = 'q.shield =' . $param['shield'];		
		if(!empty($wherearr)) {
		$sql .= ' WHERE '.implode(' AND ', $wherearr);
		}
        if(!empty($param['order'])) {
            $sql .= ' ORDER BY '.$param['order'];
        } else {
            $sql .= ' ORDER BY q.qid desc';
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
//echo $sql;
		return $this->db->query($sql)->list_array();
	}
	/**
	*查询单条答疑详情
	*@qid 答疑id
	*/
	public function getaskcoursebycwid($qid){
		$sql = 'SELECT q.qid,q.crid,q.folderid,q.catid,q.grade,q.catpath,q.uid,q.title,q.message,q.imagename,q.imagesrc,q.audioname,q.audiosrc,q.answercount,q.thankcount,q.hasbest,q.status,q.dateline,q.viewnum,u.username,fa.aid FROM ebh_askquestions q '
		.'left join ebh_users u on (q.uid=u.uid) '
		.'left join ebh_askfavorites fa on (q.qid = fa.qid) where q.qid = '.$qid.' AND q.shield = 0';
		return $this->db->query($sql)->row_array();
	}

	/*
	 * 答疑数量
     * @param type $param
     * @return type
	 */
	public function getaskcount($param){
		$sql = 'SELECT count(1) coun FROM ebh_askquestions q left join ebh_users u on (q.uid=u.uid) ';
		$wherearr = array();
		if(!empty($param['crid'])){
			$wherearr[] = ' q.crid ='.$param['crid'];
		}
		if(!empty($param['folderid'])){
			$wherearr[] = ' q.folderid ='.$param['folderid'];
		}
		if(!empty($param['q'])){
			$wherearr[] = '(q.title like \'%' . $this->db->escape_str($param['q']) . '%\' or u.username like \'%' . $this->db->escape_str($param['q']) . '%\')';
		}
		if (isset($param['shield']))
			$wherearr[] = 'q.shield =' . $param['shield'];
		if(!empty($wherearr)) {
            $sql .= ' WHERE '.implode(' AND ',$wherearr);
        }
		$row = $this->db->query($sql)->row_array();
        if (!empty($row))
            $count = $row['coun'];
        return $count;
	}

    /**
     * 获取平台下最新的问题
     * @param type $param
     * @return type
     */
    public function getnewasklistbycrid($param) {
        $sql = 'SELECT q.qid,q.crid,q.folderid,q.uid,q.title,q.dateline,f.foldername,u.username,u.realname FROM ebh_askquestions q ' .
                'LEFT JOIN ebh_folders f on (q.folderid = f.folderid) ' .
                'JOIN ebh_users u on (q.uid = u.uid) ';
        $wherearr = array();
        if (!empty($param['crid']))
            $wherearr[] = 'q.crid = ' . $param['crid'];
        if (isset($param['shield']))
        	$wherearr[] = 'q.shield =' . $param['shield'];
        if (!empty($wherearr))
            $sql .= ' WHERE ' . implode(' AND ', $wherearr);
        if (!empty($param['order']))
            $sql .= ' ORDER BY ' . $param['order'];
        else
            $sql .= ' ORDER BY q.qid DESC ';
        if (!empty($param['limit']))
            $sql .= ' LIMIT ' . $param['limit'];
        else
            $sql .= ' LIMIT 0,5 ';
        return $this->db->query($sql)->list_array();
    }
	
	/**
	*热门问题查询(回答数排序)
	*/
	public function getquestionhot($param){
		$sql = 'select q.title,q.qid from ebh_askquestions q  where q.shield = 0 ';
        if (!empty($param['order']))
            $sql .= ' ORDER BY ' . $param['order'];
        else
            $sql .= ' ORDER BY q.qid DESC ';
        if (!empty($param['limit']))
            $sql .= ' LIMIT ' . $param['limit'];
        else
            $sql .= ' LIMIT 0,5 ';
		return $this->db->query($sql)->list_array();
	}
	 /**
     * 获取question列表
     * @param array $param 条件参数
     * @return array questionlist
     */
    public function getquestion($param = array()) {
		$sql = 'SELECT q.qid,q.crid,q.folderid,q.catid,q.grade,q.catpath,q.uid,q.title,q.message,q.imagename,q.imagesrc,q.audioname,q.audiosrc,q.answercount,q.thankcount,q.hasbest,q.status,q.dateline,q.viewnum,f.foldername,u.username,fa.aid,cl.crname from ebh_askquestions q '
		.'left join ebh_folders f on (q.folderid = f.folderid) '
		.'left join ebh_users u on (q.uid=u.uid) '
		.'left join ebh_askfavorites fa on (q.qid = fa.qid) '
		.'left join ebh_classrooms cl on (q.crid = cl.crid) ';

        $wherearr = array();
		if(isset($param ['title'])){
			$wherearr[] = ' (q.title like \'%'.$param['title'].'%\' or u.username like \'%'.$param['title'].'%\') ';
		}
		if(isset($param ['folderid'])){
			$wherearr[] = 'q.folderid = '.intval($param['folderid']);
		}
		if (isset($param['shield']))
			$wherearr[] = 'q.shield =' . $param['shield'];
        if(!empty($wherearr)) {
            $sql .= ' WHERE '.implode(' AND ',$wherearr);
        }
        if(!empty($param['order'])) {
            $sql .= ' ORDER BY '.$param['order'];
        } else {
            $sql .= ' ORDER BY q.dateline desc';
        }
        if(!empty($param['limit'])) {
            $sql .= ' limit '. $param['limit'];
        } else {
            $sql .= ' limit 0,10';
        }
        return $this->db->query($sql)->list_array();
	}

//	//答疑数量
//	  public function questioncount($quesarr = array()) {
//        $count = 0;
//        $sql = 'SELECT count(*) count from ebh_askquestions q '.
//                'JOIN ebh_coursewares cw ON r.cwid = cw.cwid ';
//        $sql .= ' WHERE r.folderid='.$quesarr['folderid'];
//        if(!empty($quesarr['q']))
//            $sql .= ' AND cw.title like \'%'.$this->db->escape_str($quesarr['q']).'%\'';
//        $countrow = $this->db->query($sql)->row_array();
//        if(!empty($countrow))
//            $count = $countrow['count'];
//        return $count;
//    }

	
	/**
     * 根据分类获取全部问题列表
     * @param type $param
     * @return type
     */
    public function getasklistbycatid($param) {
        if (empty($param['page']) || $param['page'] < 1)
            $page = 1;
        else
            $page = $param['page'];
        $pagesize = empty($param['pagesize']) ? 10 : $param['pagesize'];
        $start = ($page - 1) * $pagesize;
        $sql = 'select q.qid,q.crid,q.uid,q.catid,q.title,q.answercount,q.hasbest,q.dateline,q.viewnum,q.message,q.thankcount,u.username,u.realname from ebh_askquestions q join ebh_users u on (q.uid = u.uid) ';
        $wherearr = array();
        if (isset($param['crid']))
            $wherearr[] = 'q.crid=' . $param['crid'];
        if (!empty($param['uid']))
            $wherearr[] = 'q.uid=' . $param['uid'];
		if (!empty($param['catid']))
            $wherearr[] = 'q.catid =' . $param['catid'];
		if (!empty($param['catidlist']))
            $wherearr[] = 'q.catid in(' . $param['catidlist'].')';
		if (!empty($param['grade']))
            $wherearr[] = 'q.grade =' . $param['grade'];
		if (isset($param['shield']))
			$wherearr[] = 'q.shield =' . $param['shield'];
        if (!empty($param['q']))
            $wherearr[] = '(q.title like \'%' . $this->db->escape_str($param['q']) . '%\' or u.username like \'%' . $this->db->escape_str($param['q']) . '%\')';
        if (!empty($wherearr))
            $sql.= ' WHERE ' . implode(' AND ', $wherearr);
        if (!empty($param['order'])) {
            $sql .= ' order by ' . $param['order'];
        } else {
            $sql .= ' order by q.qid desc ';
        }
        $sql .= ' limit ' . $start . ',' . $pagesize;
        return $this->db->query($sql)->list_array();
    }
    /**
     * 根据分类获取全部问题列表记录总数
     * @param type $param
     * @return type
     */
    public function getasklistcountbycatid($param) {
        $count = 0;
        $sql = 'select count(*) count from ebh_askquestions q join ebh_users u on (q.uid = u.uid) ';
        $wherearr = array();
        if (!empty($param['crid']))
            $wherearr[] = 'q.crid=' . $param['crid'];
        if (!empty($param['uid']))
            $wherearr[] = 'q.uid=' . $param['uid'];
		if (!empty($param['catid']))
            $wherearr[] = 'q.catid =' . $param['catid'];
		if (!empty($param['catidlist']))
            $wherearr[] = 'q.catid in(' . $param['catidlist'].')';
		if (!empty($param['grade']))
            $wherearr[] = 'q.grade =' . $param['grade'];
		if (isset($param['shield']))
			$wherearr[] = 'q.shield =' . $param['shield'];
        if (!empty($param['q']))
            $wherearr[] = '(q.title like \'%' . $this->db->escape_str($param['q']) . '%\' or u.username like \'%' . $this->db->escape_str($param['q']) . '%\')';
        if (!empty($wherearr))
            $sql.= ' WHERE ' . implode(' AND ', $wherearr);
        $row = $this->db->query($sql)->row_array();
        if (!empty($row))
            $count = $row['count'];
        return $count;
    }
	
	/*
	设为最佳答案
	@param array $param uid,qid,aid
	*/
	public function setBest($param){
		if(empty($param['uid'])||empty($param['qid'])||empty($param['aid']))
			return false;
		$sql = 'select count(*) count 
			from ebh_askquestions q 
			join ebh_askanswers a on q.qid=a.qid';
		$warr = array();
		$warr[]= 'q.uid='.$param['uid'];
		$warr[]= 'q.qid='.$param['qid'];
		$warr[]= 'q.hasbest=0';
		$warr[]= 'a.aid='.$param['aid'];
		$sql.= ' where '.implode(' AND ',$warr);
		$sql.= ' AND q.shield =0 AND a.shield = 0';
		$count = $this->db->query($sql)->row_array();
		if($count['count']>0){
			$qarr['hasbest'] = 1;
			$qarr['status'] = 1;
			$wherearr['qid'] = $param['qid'];
			$afrow = $this->db->update('ebh_askquestions',$qarr,$wherearr);
			$aarr['isbest'] = 1;
			$wherearr2['aid'] = $param['aid'];
			$afrow = $this->db->update('ebh_askanswers',$aarr,$wherearr2);
			return $afrow;
		}else{
			return false;
		}
	}

	/*
	教师设为最佳答案
	@param array $param uid,qid,aid
	*/
	public function setBestT($param){
		if(empty($param['uid'])||empty($param['qid'])||empty($param['aid']))
			return false;
		$sql = 'select count(*) count,aid from ebh_askanswers';
		$warr = array();
		$warr[]= 'qid='.$param['qid'];
		$warr[]= 'isbest=1';
		$sql.= ' where '.implode(' AND ',$warr);
		$sql.= ' AND shield = 0';
		$count = $this->db->query($sql)->row_array();
		if($count['count']>0){
			$aarr['isbest'] = 0;
			$wherearr['aid'] = $count['aid'];
			$afrow = $this->db->update('ebh_askanswers',$aarr,$wherearr);
		}
		$qarr['hasbest'] = 1;
		$qarr['status'] = 1;
		$wherearr1['qid'] = $param['qid'];
		$afrow = $this->db->update('ebh_askquestions',$qarr,$wherearr1);
		$aarr2['isbest'] = 1;
		$wherearr2['aid'] = $param['aid'];
		$afrow = $this->db->update('ebh_askanswers',$aarr2,$wherearr2);
		return $afrow;
	}


	/**
	*求的答疑最新动态
	*/
	public function getaskanswers(){
		$sql = 'SELECT a.aid,a.qid,q.uid,u.username as qr,us.username as wr FROM ebh_askanswers a '
		.'left join ebh_askquestions q on (a.qid = q.qid) '
		.'left join ebh_users u on (q.uid = u.uid) '
		.'left join ebh_users us on (us.uid = a.uid) where u.username is not null and a.shield = 0 and q.shield = 0  order by a.dateline desc LIMIT 0,5';
        return $this->db->query($sql)->list_array();
	}
	/*
	*我的答疑的访问数
	*/
	 public function addviewnum($qid, $num = 1) {
	//	 echo $qid;exit;
        $where = 'qid=' . $qid;
        $setarr = array('viewnum' => 'viewnum+' . $num);
        $this->db->update('ebh_askquestions', array(), $where, $setarr);
    }

    /**
     *获取教师所属课程的问题列表
     *
    */
    public function getcoursequestionslist($folderids = array(),$param = array()){
        if(empty($folderids)){
            return array();
        }
        if (empty($param['page']) || $param['page'] < 1)
            $page = 1;
        else
            $page = $param['page'];
        $pagesize = empty($param['pagesize']) ? 10 : $param['pagesize'];
        $start = ($page - 1) * $pagesize;
        $in = implode(',',$folderids);
        $sql = 'select a.qid,a.dateline,a.title,a.answercount,u.uid,u.username,u.realname,u.face,u.sex,f.foldername,a.shield,a.status,u.groupid,a.reward from ebh_askquestions a  left join ebh_users u on a.uid = u.uid left join ebh_folders f on f.folderid = a.folderid where a.folderid in ('.$in.')';
        if(!empty($param['q'])){
            $sql.= ' AND ( a.title like \'%' . $this->db->escape_str($param['q']) . '%\')';
        }
		if(!empty($param['aq'])){
            $sql.= ' AND ( u.username =\'' . $param['aq'] .'\' or u.realname =\'' . $param['aq'] .'\')';
        }
        $sql.= ' AND a.shield = 0 ';
        if (!empty($param['order'])) {
            $sql .= ' order by ' . $param['order'];
        } else {
            $sql .= ' order by a.qid desc ';
        }
        $sql .= ' limit ' . $start . ',' . $pagesize;
        return $this->db->query($sql)->list_array();
    }

	/**
     *获取教师所属课程的回答的问题数
     *
    */
    public function getcoursequestionedcount($folderids = array(),$param = array()){
        if(empty($folderids)){
            return 0;
        }
        $in = implode(',',$folderids);
        $sql = 'select count(*) count from (select a.qid,a.title,a.answercount,u.face,u.sex,a.shield,an.uid anuid from ebh_askquestions a  left join ebh_users u on a.uid = u.uid left join ebh_folders f on f.folderid = a.folderid left join ebh_askanswers an on an.qid = a.qid where a.folderid in ('.$in.')';
        if(!empty($param['q'])){
            $sql.= ' AND ( a.title like \'%' . $this->db->escape_str($param['q']) . '%\')';
        }
		if(!empty($param['aq'])){
            $sql.= ' AND ( u.username =\'' . $param['aq'] .'\' or u.realname =\'' . $param['aq'] .'\')';
        }
        $sql.= ' AND a.shield = 0 AND an.uid = '.$param['uid'].' group by a.qid ) as answered ';
	//echo $sql;
        $res = $this->db->query($sql)->row_array();
        return $res['count'];
    }

    /**
     *获取教师所属课程的问题个数
     *
    */
    public function getcoursequestionscount($folderids = array(),$param = array()){
        if(empty($folderids)){
            return 0;
        }
        $in = implode(',',$folderids);
        $sql = 'select count(*) count from ebh_askquestions a left join ebh_users u on a.uid = u.uid where a.folderid in ('.$in.')';
        if(!empty($param['q'])){
            $sql.= ' AND a.title like "%'.$param['q'].'%"';
        }
		 if(!empty($param['q'])){
            $sql.= ' AND ( u.username =\'' . $param['aq'] .'\' or u.realname =\'' . $param['aq'] .'\')';
        }
        $sql.= ' AND a.shield = 0 ';
	//echo $sql;
        $res = $this->db->query($sql)->row_array();
        return $res['count'];
    }

    /**
     *获取老师所教班级问题
     *
     */
    public function getClassesAsk($classids,$param=array(),$folderids){
        if(empty($classids)){
            return array();
        }
        if (empty($param['page']) || $param['page'] < 1)
            $page = 1;
        else
            $page = $param['page'];
        $pagesize = empty($param['pagesize']) ? 10 : $param['pagesize'];
        $start = ($page - 1) * $pagesize;
        $in = implode(',',$classids);
        $in2 = implode(',',$folderids);
        $sql = 'select aq.qid,aq.dateline,aq.title,aq.answercount,aq.status,u.sex,u.face,u.username,u.realname,u.uid,f.foldername,u.groupid,aq.reward from ebh_askquestions aq 
                join ebh_users u on u.uid = aq.uid
                join ebh_folders f on f.folderid = aq.folderid
                join ebh_classstudents ct on aq.uid = ct.uid where ct.classid in ('.$in.')';
        if(!empty($folderids)){
            $sql.=' AND f.folderid in('.$in2.') ';
        }
        if(!empty($param['q'])){
            $sql.= ' AND ( aq.title like \'%'.$param['q'].'%\')';
        }
		if(!empty($param['aq'])){
            $sql.= ' AND ( u.realname =\'' . $param['aq'] .'\' or u.username =\'' . $param['aq'] .'\')';
        }
        $sql.= ' AND aq.shield = 0 ';
		$sql.= '  ORDER BY aq.qid DESC ';
        $sql .= ' limit ' . $start . ',' . $pagesize;
        return $this->db->query($sql)->list_array();
    }
    /**
     *获取老师所教班级问题数量
     *
     */
    public function getClassesAskCount($classids,$param=array(),$folderids){
        if(empty($classids)){
            return 0;
        }
      
        $in = implode(',',$classids);
        $in2 = implode(',',$folderids);
        $sql = 'select count(*) count from ebh_askquestions aq 
                join ebh_users u on u.uid = aq.uid
                join ebh_folders f on f.folderid = aq.folderid
                join ebh_classstudents ct on aq.uid = ct.uid where ct.classid in ('.$in.')';
        if(!empty($folderids)){
            $sql.=' AND f.folderid in('.$in2.') ';
        }       
        if(!empty($param['q'])){
            $sql.= ' AND aq.title like "%'.$param['q'].'%"';
        }
		if(!empty($param['aq'])){
            $sql.= ' AND ( u.realname =\'' . $param['aq'] .'\' or u.username =\'' . $param['aq'] .'\')';
        }
        $sql.= ' AND aq.shield = 0 ';
        $res = $this->db->query($sql)->row_array();
        return $res['count'];
    }

	 /**
     * 对回答的屏蔽及取消(教师屏蔽该学校的学生回答)
     */
    function upShield($param) {
        $setarr = array('shield' => $param['shield']);
        $wherearr = array('aid' => $param['aid'], 'qid' => $param['qid']);
        $afrows = $this->db->update('ebh_askanswers', array(), $wherearr, $setarr);
        return $afrows;
		
    }

	 /**
     * 对问题的屏蔽及取消(教师屏蔽答疑的问题)
     */
    function upQshield($param) {
        $setarr = array('shield' => $param['shield']);
        $wherearr = array('qid' => $param['qid'],'crid'=>$param['crid']);
        $afrows = $this->db->update('ebh_askquestions', array(), $wherearr, $setarr);
        return $afrows;
		
    }

    /**
     *根据参数获取答疑回答列表(后台使用)
     */
    public function getAnswersByParam($param = array()) {
        $wherearr = array();
        if(!empty($param['catid'])){
            if(is_scalar($param['catid'])){
                $catidArr = array(intval($param['catid']));
            }else{
                $catidArr = $param['catid'];
            }
            $in = '('.implode(',', $catidArr).')';
            $wherearr[] = ' q.catid in '.$in;
        }
        if(!empty($param['qid'])){
            $wherearr[] = ' a.qid = '.intval($param['qid']);
        }
        if(!empty($param['q'])){
            $q = $this->db->escape_str($param['q']);
            $wherearr[] = 'a.message like "%'.$q.'%"';
        }
        
        $sql = 'select a.aid,a.qid,a.uid,u.username,a.answertype,a.message,a.audioname,a.audiosrc,a.imagename,a.imagesrc,a.coursename,a.coursesrc,a.isbest,a.thankcount,a.dateline,a.attname,a.attsrc from ebh_askanswers a 
                left join ebh_askquestions q on a.qid = q.qid 
                left join ebh_users u on a.uid = u.uid ';
        if(!empty($wherearr)){
            $sql.=' WHERE '.implode(' AND ', $wherearr);
        }
        $sql.=' AND q.shield = 0 AND a.shield = 0';
        $sql .= ' ORDER BY a.isbest desc,a.aid desc';
        if(!empty($param['limit'])){
            $sql.=' limit '.$param['limit'];
        }else{
            $sql.=' limit 10 ';
        }
        return $this->db->query($sql)->list_array();
    }
    /**
     *根据参数获取答疑回答列表数目(后台使用)
     */
    public function getAnswersByParamCount($param = array()) {
        $wherearr = array();
        if(!empty($param['catid'])){
            if(is_scalar($param['catid'])){
                $catidArr = array(intval($param['catid']));
            }else{
                $catidArr = $param['catid'];
            }
            $in = '('.implode(',', $catidArr).')';
            $wherearr[] = ' q.catid in '.$in;
        }
        if(!empty($param['qid'])){
            $wherearr[] = ' a.qid = '.intval($param['qid']);
        }
        if(!empty($param['q'])){
            $q = $this->db->escape_str($param['q']);
            $wherearr[] = 'a.message like "%'.$q.'%"';
        }
        
        $sql = 'select count(*) count from ebh_askanswers a 
                left join ebh_askquestions q on a.qid = q.qid 
                left join ebh_users u on a.uid = u.uid ';
        if(!empty($wherearr)){
            $sql.=' WHERE '.implode(' AND ', $wherearr);
        }
        $sql.=' AND q.shield = 0 AND a.shield = 0';
        $res = $this->db->query($sql)->row_array();
        return  $res['count'];
    }

    public function getQuestionWithBest($num = 10){
        $sql = 'select aq.qid,aq.title from ebh_askquestions aq where aq.hasbest = 1 and aq.shield = 0 order by aq.qid limit '.$num;
        return $this->db->query($sql)->list_array();
    }
    /**
     * 设置老师是否回答问题
     * @param int $qid 问题编号
     */
    public function setAnswered($qid,$status=0) {
        if(empty($qid)){
            return 0;
        }
        $where = array('qid'=>$qid);
        $setarr = array('answered'=>$status);
        return $this->db->update('ebh_askquestions',$setarr,$where);
    }

    /**
     *获取需要指定老师回答的问题列表
     */
    public function getRequiredAnswers($param = array()){
        $sql = 'SELECT q.title,q.qid,q.crid,q.folderid,q.uid,q.message,q.audioname,q.audiosrc,q.imagename,q.imagesrc,q.hasbest,q.answercount,q.viewnum,q.dateline,q.status,q.tid,q.lastansweruid,q.answered,q.reqid,f.folderid,f.foldername,q.reward FROM ebh_askquestions q LEFT JOIN ebh_folders f on (q.folderid = f.folderid) ';
        if(!empty($param['aq'])){
             $sql = 'SELECT q.title,q.qid,q.crid,q.folderid,q.uid,q.message,q.audioname,q.audiosrc,q.imagename,q.imagesrc,q.hasbest,q.answercount,q.viewnum,q.dateline,q.status,q.tid,q.lastansweruid,q.answered,q.reqid,f.folderid,f.foldername FROM ebh_askquestions q LEFT JOIN ebh_folders f on (q.folderid = f.folderid) LEFT JOIN ebh_users u on q.uid = u.uid ';
        }
        $wherearr = array();
        if (!empty($param['crid']))
            $wherearr[] = 'q.crid = ' . $param['crid'];
        if (!empty($param['folderid']))
            $wherearr[] = 'q.folderid = ' . $param['folderid'];
        if (!empty($param['folderid_in']))
            $wherearr[] = 'q.folderid in '.$param['folderid_in'];
        if (isset($param['shield']))
            $wherearr[] = 'q.shield =' . $param['shield'];
        if(!empty($param['tid'])){
            $wherearr[] = 'q.tid = '.$param['tid'];
        }
        if(!empty($param['uid'])){
            $wherearr[] = 'q.uid ='.$param['uid'];
        }
        if(!empty($param['aq'])){
            $aq = $this->db->escape_str($param['aq']);
            $wherearr[] = '( u.username =\'' . $aq .'\' or u.realname =\'' . $aq .'\')';
        }
        if(!empty($param['q'])){
            $q = $this->db->escape_str($param['q']);
            $wherearr[] = 'q.title like "%'.$q.'%"';
        }
		if(!empty($param['cwid'])){
			$wherearr[] = 'q.cwid='.$param['cwid'];
		}
        if (!empty($wherearr))
            $sql .= ' WHERE ' . implode(' AND ', $wherearr);
        if (!empty($param['order']))
            $sql .= ' ORDER BY ' . $param['order'];
        else
            $sql .= ' ORDER BY q.qid DESC ';
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
    // 获取需要指定老师回答的问题列表数量
    public function getRequiredAnswersCount($param = array()){
        $sql = 'SELECT count(q.qid) count from ebh_askquestions q LEFT JOIN ebh_folders f on (q.folderid = f.folderid)';
        if(!empty($param['aq'])){
             $sql = 'SELECT count(q.qid) count FROM ebh_askquestions q LEFT JOIN ebh_folders f on (q.folderid = f.folderid) LEFT JOIN ebh_users u  on q.uid = u.uid ';
        }
        if (!empty($param['crid']))
            $wherearr[] = 'q.crid = ' . $param['crid'];
        if (!empty($param['folderid']))
            $wherearr[] = 'q.folderid = ' . $param['folderid'];
        if (!empty($param['folderid_in']))
            $wherearr[] = 'q.folderid in '.$param['folderid_in'];
        if (isset($param['shield']))
            $wherearr[] = 'q.shield =' . $param['shield'];
        if(!empty($param['tid'])){
            $wherearr[] = 'q.tid = '.$param['tid'];
        }
        if(!empty($param['uid'])){
            $wherearr[] = 'q.uid ='.$param['uid'];
        }
        if(!empty($param['aq'])){
            $aq = $this->db->escape_str($param['aq']);
            $wherearr[] = '( u.username =\'' . $aq .'\' or u.realname =\'' . $aq .'\')';
        }
        if(!empty($param['q'])){
            $q = $this->db->escape_str($param['q']);
            $wherearr[] = 'q.title like "%'.$q.'%"';
        }
		if(!empty($param['answered'])){
            $wherearr[] = 'q.answered != '.$param['answered'];
        }
		if(!empty($param['cwid'])){
			$wherearr[] = 'q.cwid='.$param['cwid'];
		}
        if (!empty($wherearr))
            $sql .= ' WHERE ' . implode(' AND ', $wherearr);
        $res = $this->db->query($sql)->row_array();
        return $res['count'];
    }
    /**
     *问题或者作业推送
     */
    public function relationBind($param = array(),$where = array())
    {
        if(empty($param) || empty($where))
        {
            return 0;
        }
        return $this->db->update('ebh_askquestions',$param,$where);
    }
    /**
     *获取指定的qid问题列表
     */
     public function getReQuestionList($qids){
        if(empty($qids)){
            return;
        }
        if(is_array($qids))
        {
            $sql = 'SELECT aq.qid,aq.title,aq.shield from ebh_askquestions aq WHERE aq.qid in ('.implode(',', $qids).')';
        }else if(is_scalar($qids)){
            $sql = 'SELECT aq.qid,aq.title,aq.shield from ebh_askquestions aq WHERE aq.qid = '.$qids;
        }else{
            return;
        }
        return $this->db->query($sql)->list_array();
     }   
	 
	 /*
	 教师答题统计
	 */
	 public function getTeacherAnsweredList($param){
		$sql = 'select tid,count(tid) asknum,sum(answered) answernum,sum(hasbest) bestnum from ebh_askquestions ';
		$wherearr[]= 'crid='.$param['crid'];
		$wherearr[]= 'tid in ('.$param['tids'].')';
		if(!empty($param['startdate']))
			$wherearr[]= 'dateline>='.$param['startdate'];
		if(!empty($param['enddate']))
			$wherearr[]= 'dateline<='.$param['enddate'];
		$sql.= ' where '.implode(' AND ',$wherearr);
		
		$sql.= ' group by tid';
		return $this->db->query($sql)->list_array();
	}
	
	/*
	答疑的回答人列表
	*/
	public function getanswerer($param){
		$sql = 'select u.uid,u.username,u.realname,u.sex,u.face,u.groupid,a.aid from ebh_askanswers a
			join ebh_users u on u.uid = a.uid
			where a.qid = '.$param['qid'];
		$sql.= ' group by uid';
		return $this->db->query($sql)->list_array();
		
	}
	
	/*
	获取教师回答的所有问题数(多用户)
	*/
	public function getAnswerCountByDistinctQid($param){
		$sql = 'select count(distinct(q.qid)) answernum,a.uid 
				from ebh_askquestions q 
				join ebh_askanswers a on q.qid=a.qid 
		';
		if(!empty($param['crid']))
			$wherearr[] = 'q.crid='.$param['crid'];
		if(!empty($param['uids']))
			$wherearr[] = 'a.uid in ('.$param['uids'].')';
		if(!empty($param['folderid']))
			$wherearr[] = 'q.folderid='.$param['folderid'];
		if (!empty($param['startdate']))
			$wherearr[]= 'a.dateline>='.$param['startdate'];
		if (!empty($param['enddate']))
			$wherearr[]= 'a.dateline<='.$param['enddate'];
		$sql.= ' where '.implode(' AND ',$wherearr);
		$sql.= ' group by a.uid';
		return $this->db->query($sql)->list_array();
		
	}
	
	/*
	获取回答列表,不包含重复的问题
	*/
	public function getAnswerListByDistinctQid($param){
		$sql = 'select distinct(q.qid),q.title,hasbest,foldername,q.dateline,q.answercount,q.shield from ebh_askquestions q
				join ebh_askanswers a on q.qid=a.qid
				join ebh_folders f on f.folderid=q.folderid
				';
		if(!empty($param['crid']))
			$wherearr[] = 'q.crid='.$param['crid'];
		if(!empty($param['uid']))
			$wherearr[] = 'a.uid = '.$param['uid'].'';
		if(!empty($param['folderid']))
			$wherearr[] = 'q.folderid='.$param['folderid'];
		if (!empty($param['startdate']))
			$wherearr[]= 'a.dateline>='.$param['startdate'];
		if (!empty($param['enddate']))
			$wherearr[]= 'a.dateline<='.$param['enddate'];
		$sql.= ' where '.implode(' AND ',$wherearr);
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
		// echo $sql;
		return $this->db->query($sql)->list_array();
		
		
	}
	
	/*
	被设为最佳答案的次数
	*/
	public function getBestCount($param){
		$sql = 'select a.uid,sum(isbest) bestnum from ebh_askanswers a join ebh_askquestions q on q.qid=a.qid';
		if(!empty($param['crid']))
			$wherearr[] = 'q.crid='.$param['crid'];
		if(!empty($param['uids']))
			$wherearr[] = 'a.uid in ( '.$param['uids'].')';
		if (!empty($param['startdate']))
			$wherearr[]= 'a.dateline>='.$param['startdate'];
		if (!empty($param['enddate']))
			$wherearr[]= 'a.dateline<='.$param['enddate'];
		$sql.= ' where '.implode(' AND ',$wherearr);
		$sql.= ' group by a.uid';
		return $this->db->query($sql)->list_array();
	}

	/**
     * 根据问题编号获取提问者UID
     * @param integer $qid 问题编号
     * @return integer 提问者UID
     */
    public function getaskuidbyqid($qid) {
        $sql = 'select uid from ebh_askquestions where qid=' . $qid;
        $row = $this->db->query($sql)->row_array();
        return $row['uid'];
    }

}

?>