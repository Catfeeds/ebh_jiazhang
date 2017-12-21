<?php
/**
 * 通知Model类 NoticeModel
 */
class NoticeModel extends CModel{
    /**
     * 获取通知列表
     * @param type $queryarr
     * @return type
     */
    public function getnoticelist($queryarr) {
        $sql = 'SELECT n.noticeid,n.uid,n.crid,n.title,n.message,n.ntype,n.type,n.dateline,n.cids,n.viewnum,u.username,u.realname FROM ebh_notices n '.
                'LEFT JOIN ebh_users u on (u.uid = n.uid) ';
        $wherearr = array();
		$gradestr = '';
		if(!empty($queryarr['needgrade'])){
			$sql2 = 'select grade,district from ebh_classes where classid='.$queryarr['classid'];
			$res = $this->db->query($sql2)->row_array();
			if(!empty($res['grade']))
			$gradestr = 'FIND_IN_SET('.$res['grade'].',n.grades) or ';
		}
		if(!empty($queryarr['needdistrict'])){
			$sql3 = 'select grade,district from ebh_classes where classid='.$queryarr['classid'];
			$res = $this->db->query($sql3)->row_array();
			if(!empty($res))
			$wherearr[] = '(FIND_IN_SET('.$res['district'].',n.districts) or n.districts=\'\')';
		}
        if(!empty($queryarr['crid']))   //所在学校
            $wherearr[] = 'n.crid='.$queryarr['crid'];
		if(!empty($queryarr['uid']))   //发送人编号
            $wherearr[] = 'n.uid='.$queryarr['uid'];
        if(!empty($queryarr['ntype']))  //通知类型,1为全校师生 2为全校教师 3为全校学生 4为班级学生
            $wherearr[] = 'n.ntype in ('.$queryarr['ntype'] .')';
		if(!empty($queryarr['classid']))	//过滤接收通知的班级编号
			$wherearr[] = '('.$gradestr.'FIND_IN_SET('.$queryarr['classid'].',n.cids) or n.ntype in(1,3))';
        if(!empty($queryarr['dateline'])){
        	$wherearr[] = 'n.dateline > '.$queryarr['dateline'];
        }
        if(!empty($wherearr))
            $sql .= ' WHERE '.implode (' AND ', $wherearr);
        if(!empty($queryarr['order']))
            $sql .= ' ORDER BY '.$queryarr['order'];
        else
            $sql .= ' ORDER BY n.noticeid desc ';
        if(!empty($queryarr['limit']))
            $sql .= 'limit '.$queryarr['limit'];
        else {
            if(empty($queryarr['page']) || $queryarr['page'] < 1)
                $page = 1;
            else
                $page = $queryarr['page'];
            $pagesize = empty($queryarr['pagesize']) ? 10 : $queryarr['pagesize'];
            $start = ($page - 1) * $pagesize ;
            $sql .= 'limit '.$start.','.$pagesize;
        }
        return $this->db->query($sql)->list_array();
    }
	/**
     * 获取通知列表记录总数
     * @param type $queryarr
     * @return type
     */
    public function getnoticelistcount($queryarr) {
		$count = 0;
        $sql = 'SELECT count(*) count FROM ebh_notices n '.
                'LEFT JOIN ebh_users u on (u.uid = n.uid) ';
        $wherearr = array();
		$gradestr = '';
		if(!empty($queryarr['needgrade'])){
			$sql2 = 'select grade,district from ebh_classes where classid='.$queryarr['classid'];
			$res = $this->db->query($sql2)->row_array();
			if(!empty($res['grade']))
			$gradestr = 'FIND_IN_SET('.$res['grade'].',n.grades) or ';
		}
		if(!empty($queryarr['needdistrict'])){
			$sql3 = 'select grade,district from ebh_classes where classid='.$queryarr['classid'];
			$res = $this->db->query($sql3)->row_array();
			if(!empty($res))
			$wherearr[] = '(FIND_IN_SET('.$res['district'].',n.districts) or n.districts=\'\')';
		}
        if(!empty($queryarr['crid']))   //所在学校
            $wherearr[] = 'n.crid='.$queryarr['crid'];
		if(!empty($queryarr['uid']))   //发送人编号
            $wherearr[] = 'n.uid='.$queryarr['uid'];
        if(!empty($queryarr['ntype']))  //通知类型,1为全校师生 2为全校教师 3为全校学生 4为班级学生
            $wherearr[] = 'n.ntype in ('.$queryarr['ntype'] .')';
		if(!empty($queryarr['classid']))	//过滤接收通知的班级编号
			$wherearr[] = '('.$gradestr.'FIND_IN_SET('.$queryarr['classid'].',n.cids) or n.ntype in(1,3))';
        if(!empty($queryarr['dateline'])){
        	$wherearr[] = 'n.dateline > '.$queryarr['dateline'];
        }
        if(!empty($wherearr))
            $sql .= ' WHERE '.implode (' AND ', $wherearr);
        $row = $this->db->query($sql)->row_array();
        if(!empty($row))
			$count = $row['count'];
		return $count;
    }
	
	/*
	获取通知详情
	*/
	public function getNoticeDetail($param){
		$wherearr = array();
		$sql = 'select n.noticeid,n.title,n.message,n.ntype,n.cids,n.dateline,n.attid,n.grades,n.districts from ebh_notices n';
		$wherearr[] = 'crid='.$param['crid'];
		$wherearr[] = 'noticeid='.$param['noticeid'];
		$sql.= ' where '.implode(' AND ',$wherearr);
		return $this->db->query($sql)->row_array();
		
	}
	/*
	获取通知详情
	*/
	public function getNoticeByNoticeid($noticeid){
		$wherearr = array();
		$sql = 'select n.noticeid,n.crid,n.title,n.message,n.ntype,n.cids,n.dateline,n.attid from ebh_notices n where noticeid='.$noticeid;
		return $this->db->query($sql)->row_array();
		
	}
	public function deleteNotice($param){
		$wherearr['crid'] = $param['crid'];
		$wherearr['noticeid'] = $param['noticeid'];
		return $this->db->delete('ebh_notices',$wherearr);
	}
	/**
	*添加通知的浏览数
	*/
	public function addviewnum($noticeid) {
		$wherearr = array('noticeid'=>$noticeid);
		$setarr = array('viewnum'=>'viewnum+1');
		return $this->db->update('ebh_notices',array(),$wherearr,$setarr);
	}

	/**
	 *根据时间和教室获取通知
	 */
	public function getNewNoticeCountByTime($crid,$dateline){
		$param = array(
			'crid'=>$crid,
			'dateline'=>$dateline
			);
		return $this->getnoticelistcount($param);
	}
}
