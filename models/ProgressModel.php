<?php
/*
学习进度
*/
class ProgressModel extends CModel{
	/*
	依据folderid获取课件进度
	*/
	public function getFolderProgressByFolderid($param){
		if(empty($param['folderid']))
			return array();
		$wherearr = array();
		$sql = 'select logid,max(ltime)/ctime percent,title,cw.cwid,cwurl,rc.folderid from ebh_coursewares cw join ebh_roomcourses rc on rc.cwid=cw.cwid left join ebh_playlogs p on p.cwid=cw.cwid ';
		$wherearr[] = 'rc.folderid in('.$param['folderid'].')';
		$wherearr[] = 'cw.status=1';
		// $wherearr[] = '(right(cw.cwurl,4)=\'.flv\' or right(cw.cwurl,5)=\'.ebhp\')';
		$wherearr[] = 'cw.ism3u8=1';
		if(!empty($param['uid']))
			$wherearr[] = 'p.uid='.$param['uid'];
		$sql.= ' where '.implode(' AND ',$wherearr);
		$sql.= ' group by cw.cwid ';
		$sql.= ' order by cw.displayorder ASC,cw.cwid DESC ';
		if(!empty($param['limit'])) {
            $sql .= ' limit '. $param['limit'];
        }
		else {
			if (empty($param['page']) || $param['page'] < 1)
				$page = 1;
			else
				$page = $param['page'];
			$pagesize = empty($param['pagesize']) ? 10 : $param['pagesize'];
			$start = ($page - 1) * $pagesize;
			$sql .= ' limit ' . $start . ',' . $pagesize;
		}
		// echo $sql.'________';
		return $this->db->query($sql)->list_array();

	}
	/*
	依据folderid获取课件进度
	*/
	public function getFolderProgressCountByFolderid($param){
		$sql = 'select count(*) count,folderid from ebh_roomcourses rc join ebh_coursewares cw on(rc.cwid = cw.cwid)';
		$wherearr[] = 'rc.folderid in('.$param['folderid'].')';
		$wherearr[] = 'cw.status=1';
		$wherearr[] = 'cw.ism3u8=1';
		// $wherearr[] = '(right(cw.cwurl,4)=\'.flv\' or right(cw.cwurl,5)=\'.ebhp\')';
		$sql.= ' where '.implode(' AND ',$wherearr);
		$sql.= ' group by rc.folderid';
		// echo $sql.'__________';
		$countlist = $this->db->query($sql)->list_array();
		return $countlist;
	}
	
	/*
	获取课件列表
	*/
	public function getCWByFolderid($param){
		$sql = 'select cw.cwid,rc.folderid,cw.cwurl,cw.title,rc.sid from ebh_coursewares cw join ebh_roomcourses rc on cw.cwid=rc.cwid';
		$wherearr = array();
		$wherearr[] = 'rc.folderid in('.$param['folderid'].')';
		$wherearr[] = 'cw.status=1';
		$wherearr[] = 'cw.ism3u8=1';
		// $wherearr[] = '(right(cw.cwurl,4)=\'.flv\' or right(cw.cwurl,5)=\'.ebhp\')';
		$sql.= ' where '.implode(' AND ',$wherearr);
		if(!empty($param['limit'])) {
            $sql .= ' limit '. $param['limit'];
        }
		else {
			if (empty($param['page']) || $param['page'] < 1)
				$page = 1;
			else
				$page = $param['page'];
			$pagesize = empty($param['pagesize']) ? 10 : $param['pagesize'];
			$start = ($page - 1) * $pagesize;
			$sql .= ' limit ' . $start . ',' . $pagesize;
		}
		// echo $sql.'____________';
		return $this->db->query($sql)->list_array();
	}
	
	/*
	依据cwid获取课件进度
	*/
	public function getFolderProgressByCwid($param){
		$sql = 'select cwid,ltime/ctime percent from ebh_playlogs';
		$wherearr[] = ' cwid in('.$param['cwid'].')';
		if(!empty($param['uid']))
			$wherearr[] = 'uid='.$param['uid'];
		$wherearr[] = ' totalflag=1';
		$sql.= ' where '.implode(' AND ',$wherearr);
		// echo $sql.'___________';
		return $this->db->query($sql)->list_array();
	}
	
	/*
	课程各目录中分别小于某cdisplayorder的课件进度情况
	*/
	public function getProgressBeforeInSection($param){
		$sql = 'select pl.cwid,max(pl.ltime/pl.ctime) p from ebh_playlogs pl';
		$wherearr[] = 'pl.uid='.$param['uid'];
		$wherearr[] = 'pl.cwid in ('.$param['cwids'].')';
		$sql.= ' where '.implode(' AND ',$wherearr);
		// echo $sql;
		return $this->db->query($sql)->list_array();
	}
	
	public function getBeforeInSection($param){
		$sql = 'select rc.cwid,rc.cdisplayorder,c.cwid,rc.sid 
				from ebh_roomcourses rc 
				left join ebh_coursewares c on c.cwid=rc.cwid ';
		$wherearr[] = 'rc.crid='.$param['crid'];
		$wherearr[] = 'rc.folderid='.$param['folderid'];
		$wherearr[] = 'rc.sid='.$param['sid'];
		$wherearr[] = 'c.status=1';
		$wherearr[] = 'rc.cdisplayorder<'.$param['cdisplayorder'];
		
		$sql.= ' where '.implode(' AND ',$wherearr);
		$sql.= ' group by rc.sid,rc.cwid';
		// echo $sql.'___';
		return $this->db->query($sql)->list_array();
	}
	
	/*
	学生课程学习总时间
	*/
	public function getCourseSumTime($param){
		$sql = 'select cwid,sum(ltime) sumtime from ebh_playlogs ';
		$wherearr[] = ' cwid in('.$param['cwid'].')';
		if(!empty($param['uid']))
			$wherearr[] = 'uid='.$param['uid'];
		$wherearr[] = ' totalflag=0';
		$sql.= ' where '.implode(' AND ',$wherearr);
		$sql.= ' group by cwid';
		// echo $sql.'___________';
		return $this->db->query($sql)->list_array();
	}
}
?>