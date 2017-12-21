<?php
/**
 * 课程相关model类 FolderModel
 */
class FolderModel extends CModel{
    /**
     * 添加课程对应的课件数
     * @param int $folderid 课程编号
     * @param int $num 如为正数则添加，负数则为减少
     */
    public function addcoursenum($folderid,$num = 1) {
        $where = 'folderid='.$folderid;
        $setarr = array('coursewarenum'=>'coursewarenum+'.$num);
        $this->db->update('ebh_folders',array(),$where,$setarr);
    }
    /**
     * 根据课程编号获取课程详情信息
     * @param int $folderid 课程编号
     * @return array 课程信息数组 
     */
    public function getfolderbyid($folderid) {
    	if(empty($folderid))return false;
        $sql = 'select f.folderid,f.foldername,f.displayorder,f.img,f.coursewarenum,f.summary,f.grade,f.district,f.upid,f.folderlevel,f.folderpath,f.fprice,f.speaker,f.detail,f.viewnum,f.coursewarelogo,f.power,f.credit,f.creditrule,f.playmode,f.isremind,f.remindmsg,f.remindtime,f.creditmode,f.credittime,f.showmode,f.introduce from ebh_folders f where f.folderid='.$folderid;
		return $this->db->query($sql)->row_array();
    }
	//教室首页大纲导航
	public function byfreecourse(){
//		select c.cwid,c.title,c.summary,c.cwsource,rc.folderid from '.tname('coursewares').' c '
//    					.'join '.tname('roomcourses').' rc on (c.cwid = rc.cwid) '
//    					.'WHERE rc.crid = '.$paramarr ['crid'].' AND  c.status=1 AND rc.isfree = 1 '
//    					.'order by rc.folderid,rc.cdisplayorder';
//		$sql = 'select f.folderid,f.foldername,f.img from ebh_folders';
	}

	/**
	*获取课程列表
	*在cq,hh,fssq大纲导航中可调用到,stores答疑专区
	*/
	public function getfolderlist($param){
		$sql = 'SELECT f.crid,f.foldername,f.img,f.summary,f.folderpath,f.folderid,f.coursewarenum,f.fprice,f.viewnum,f.grade,f.credit FROM ebh_folders f ';
        $wherearr = array();
 
		if(! empty ( $param ['folderid'] )){
			$wherearr [] = 'f.folderid IN (' . $param ['folderid'] . ')';
		}
		if(! empty ( $param ['crid'] )){
			$wherearr [] = ' f.crid = ' . $param ['crid'];
		}
		if(! empty ( $param ['uid'] )){
			$wherearr [] = ' f.uid = ' . $param ['uid'];
		}
		if(! empty ( $param ['status'] )){
			$wherearr [] = ' f.status = ' . $param ['status'];
		}
		if(! empty ( $param ['folderids'] )){	//folderid组合以逗号隔开，如3033,3034
			$wherearr [] = ' f.folderid in (' . $param ['folderids'].')';
		}
		if(! empty ( $param ['folderlevel'] )){
			$wherearr [] = ' f.folderlevel <> ' . $param ['folderlevel'];
		}
		if(isset ( $param ['upid'] )){
			$wherearr [] = ' f.upid <> ' . $param ['upid'];
		}
		if(! empty ( $param ['coursewarenum '] )){	//过滤课程下课件数为0的课程
			$wherearr [] = ' f.coursewarenum  > 0 ';
		}
		if(isset($param['filternum'])){
			$wherearr [] = ' f.coursewarenum > 0';
		}
		if(isset($param['nosubfolder'])){
			$wherearr [] = ' f.folderlevel = 2';
		}
		if(!empty($param['needpower'])){
			$wherearr [] = ' f.power = 0';
		}
		if(!empty($param['q']))
			$wherearr [] = 'f.foldername like \'%'.$this->db->escape_str($param['q']).'%\'';
        $sql .= ' WHERE '.implode(' AND ', $wherearr);
        if(!empty($param['order'])) {
            $sql .= ' ORDER BY '.$param['order'];
        } else {
            $sql .= ' ORDER BY f.displayorder';
        }
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
        return $this->db->query($sql)->list_array();
	}
	/*
	*课程数量（适用大纲导航数量）
	*/
	public function getcount($param){
		$count = 0;
		$sql = 'select count(*) count from ebh_folders f';
		$wherearr = array();
		if(! empty ( $param ['folderid'] )){
			$wherearr [] = 'f.folderid IN (' . $param ['folderid'] . ')';
		}
		if(! empty ( $param ['crid'] )){
			$wherearr [] = ' f.crid = ' . $param ['crid'];
		}
		if(! empty ( $param ['status'] )){
			$wherearr [] = ' f.status = ' . $param ['status'];
		}
		if(! empty ( $param ['folderlevel'] )){
			$wherearr [] = ' f.folderlevel <> ' . $param ['folderlevel'];
		}
		if(! empty ( $param ['folderids'] )){	//folderid组合以逗号隔开，如3033,3034
			$wherearr [] = ' f.folderid in (' . $param ['folderids'].')';
		}
		if(isset ( $param ['upid'] )){
			$wherearr [] = ' f.upid <> ' . $param ['upid'];
		}
		if(! empty ( $param ['coursewarenum '] )){	//过滤课程下课件数为0的课程
			$wherearr [] = ' f.coursewarenum  > 0 ';
		}
		if(isset($param['filternum'])){
			$wherearr [] = ' f.coursewarenum > 0';
		}
		if(isset($param['nosubfolder'])){
			$wherearr [] = ' f.folderlevel = 2';
		}
		if(!empty($param['q']))
			$wherearr [] = 'f.foldername like \'%'.$this->db->escape_str($param['q']).'%\'';
		$sql .= ' WHERE '.implode(' AND ', $wherearr);
		$row = $this->db->query($sql)->row_array();
		if(!empty($row))
			$count = $row['count'];
        return $count;
	}

	/**
	*获取学生网校课程列表（加上学生是否已选课）
	*/
	public function getmemberfolderlist($param){
		if(empty($param['uid']))
			return FALSE;
		$sql = 'SELECT f.foldername,f.img,f.summary,f.folderpath,f.folderid,f.coursewarenum,fa.fid FROM ebh_folders f '.
				'LEFT JOIN ebh_favorites fa ON f.crid=fa.crid AND fa.uid='.$param['uid'].' AND f.folderid=fa.folderid AND fa.type=3 ';
        $wherearr = array();
		if(! empty ( $param ['folderid'] )){
			$wherearr [] = 'f.folderid IN (' . $param ['folderid'] . ')';
		}
		if(! empty ( $param ['crid'] )){
			$wherearr [] = ' f.crid = ' . $param ['crid'];
		}
		if(! empty ( $param ['q'] )){	//按课程名称搜索
			$wherearr [] = ' f.foldername like \'%' . $param ['q'] .'%\'';
		}
		if(! empty ( $param ['status'] )){
			$wherearr [] = ' f.status = ' . $param ['status'];
		}
		if(! empty ( $param ['folderlevel'] )){
			$wherearr [] = ' f.folderlevel <> ' . $param ['folderlevel'];
		}
		if(isset ( $param ['upid'] )){
			$wherearr [] = ' f.upid <> ' . $param ['upid'];
		}
		if(! empty ( $param ['coursewarenum '] )){	//过滤课程下课件数为0的课程
			$wherearr [] = ' f.coursewarenum  > 0 ';
		}
		if(isset($param['filternum'])){
			$wherearr [] = ' f.coursewarenum > 0';
		}
		if(isset($param['haschoose'])) {	//是否选课标示
			if($param['haschoose'] == 0) {	//未选课
				$wherearr [] = ' fa.fid IS NULL ';
			} else if($param['haschoose'] == 1) {	//已选课
				$wherearr [] = ' fa.fid IS NOT NULL ';
			}
		}
        $sql .= ' WHERE '.implode(' AND ', $wherearr);
        if(!empty($param['order'])) {
            $sql .= ' ORDER BY '.$param['order'];
        } else {
            $sql .= ' ORDER BY f.displayorder,f.folderid';
        }
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
        return $this->db->query($sql)->list_array();
	}
	//大纲导航数量
	public function getmemberfoldercount($param){
		$count = 0;
		if(!empty($param['uid']))
			return $count;
		$sql = 'SELECT count(*) countFROM ebh_folders f '.
				'LEFT JOIN ebh_favorites fa ON f.crid=fa.crid AND fa.uid='.$param['uid'].' AND f.folderid=fa.folderid AND fa.type=3 ';
        $wherearr = array();
		if(! empty ( $param ['folderid'] )){
			$wherearr [] = 'f.folderid IN (' . $param ['folderid'] . ')';
		}
		if(! empty ( $param ['crid'] )){
			$wherearr [] = ' f.crid = ' . $param ['crid'];
		}
		if(! empty ( $param ['q'] )){	//按课程名称搜索
			$wherearr [] = ' f.foldername like \'%' . $param ['q'] .'%\'';
		}
		if(! empty ( $param ['status'] )){
			$wherearr [] = ' f.status = ' . $param ['status'];
		}
		if(! empty ( $param ['folderlevel'] )){
			$wherearr [] = ' f.folderlevel <> ' . $param ['folderlevel'];
		}
		if(isset ( $param ['upid'] )){
			$wherearr [] = ' f.upid <> ' . $param ['upid'];
		}
		if(! empty ( $param ['coursewarenum '] )){	//过滤课程下课件数为0的课程
			$wherearr [] = ' f.coursewarenum  > 0 ';
		}
		if(isset($param['filternum'])){
			$wherearr [] = ' f.coursewarenum > 0';
		}
		if(isset($param['haschoose'])) {	//是否选课标示
			if($param['haschoose'] == 0) {	//未选课
				$wherearr [] = ' fa.fid IS NULL ';
			} else if($param['haschoose'] == 1) {	//已选课
				$wherearr [] = ' fa.fid IS NOT NULL ';
			}
		}
        $sql .= ' WHERE '.implode(' AND ', $wherearr);
		$row = $this->db->query($sql)->row_array();
		if(!empty($row))
			$count = $row['count'];
        return $count;
	}
	
	/*
	添加folder
	@param array $param
	*/
	public function addfolder($param){
	//	print_r($param);exit;
		if(!empty($param['uid']))
			$farr['uid'] = $param['uid'];
		if(!empty($param['crid']))
			$farr['crid'] = $param['crid'];
		if(!empty($param['foldername']))
			$farr['foldername'] = $param['foldername'];
		if(!empty($param['upid']))
			$farr['upid'] = $param['upid'];
		if(!empty($param['folderlevel']))
			$farr['folderlevel'] = $param['folderlevel'];
		if(!empty($param['displayorder']))
			$farr['displayorder'] = $param['displayorder'];
		if(!empty($param['summary']))
			$farr['summary'] = $param['summary'];
		if(!empty($param['img']))
			$farr['img'] = $param['img'];
		if(!empty($param['grade']))
			$farr['grade'] = $param['grade'];
		if(isset($param['fprice']))
			$farr['fprice'] = $param['fprice'];
		if(isset($param['speaker']))
			$farr['speaker'] = $param['speaker'];
		if(isset($param['detail']))
			$farr['detail'] = $param['detail'];
		if(isset($param['coursewarelogo']))
			$setarr['coursewarelogo'] = $param['coursewarelogo'];
		if(isset($param['power']))
			$setarr['power'] = $param['power'];
		if(isset($param['credit']))
			$setarr['credit'] = $param['credit'];
		if(isset($param['creditmode']))
			$setarr['creditmode'] = $param['creditmode'];
		if(isset($param['creditrule']))
			$setarr['creditrule'] = $param['creditrule'];
		if(isset($param['credittime']))
			$setarr['credittime'] = $param['credittime'];
		if(isset($param['playmode']))
			$setarr['playmode'] = $param['playmode'];
		if(isset($param['isremind']))
			$setarr['isremind'] = $param['isremind'];
		if(isset($param['remindmsg']))
			$setarr['remindmsg'] = $param['remindmsg'];
		if(isset($param['remindtime']))
			$setarr['remindtime'] = $param['remindtime'];
		if(isset($param['showmode']))
			$setarr['showmode'] = $param['showmode'];


		$folderid = $this->db->insert('ebh_folders',$farr);
		if(!empty($param['folderpath']))
		$setarr['folderpath'] = $param['folderpath'].$folderid.'/';
		$wherearr['folderid'] = $folderid;
		$this->db->update('ebh_folders',$setarr,$wherearr);
		return $folderid;
	}
	
	/*
	选择课程任课教师
	@param array $param
	*/
	public function chooseteacher($param){
		if(!empty($param['folderid'])){
			$wherearr['folderid'] = $param['folderid'];
			//return $wherearr;
			$this->db->delete('ebh_teacherfolders',$wherearr);
		}
		$idarr = explode(',',$param['teacherids']);
		foreach($idarr as $id){
			$tfarr = array('tid'=>$id,'folderid'=>$param['folderid'],'crid'=>$param['crid']);
			$this->db->insert('ebh_teacherfolders',$tfarr);
		}
	}
	
	/*
	删除课程
	@param array $param
	*/
	public function deletecourse($param){
		$this->db->begin_trans();
		if(!empty($param['folderid']) && !empty($param['crid'])){
			$wherearr['folderid'] = $param['folderid'];
			$wherearr['crid'] = $param['crid'];
			$this->db->delete('ebh_folders',$wherearr);
			$this->db->delete('ebh_teacherfolders',$wherearr);
		}
		
		//var_Dump($wherearr);
		if($this->db->trans_status()===FALSE) {
            $this->db->rollback_trans();
            return FALSE;
        } else {
            $this->db->commit_trans();
        }
		return TRUE;
	}
	/*
	编辑课程
	@param array $param
	*/
	public function editcourse($param){
		if(!empty($param['foldername']))
			$setarr['foldername'] = $param['foldername'];
		if(!empty($param['displayorder']))
			$setarr['displayorder'] = $param['displayorder'];
		if(isset($param['summary']))
			$setarr['summary'] = $param['summary'];
		if(!empty($param['img']))
			$setarr['img'] = $param['img'];
		if(isset($param['fprice']))
			$setarr['fprice'] = $param['fprice'];
		if(isset($param['speaker']))
			$setarr['speaker'] = $param['speaker'];
		if(isset($param['detail']))
			$setarr['detail'] = $param['detail'];
		if(isset($param['grade']))
			$setarr['grade'] = $param['grade'];
		if(isset($param['coursewarelogo']))
			$setarr['coursewarelogo'] = $param['coursewarelogo'];
		if(isset($param['power']))
			$setarr['power'] = $param['power'];
		if(isset($param['credit']))
			$setarr['credit'] = $param['credit'];
		if(isset($param['creditmode']))
			$setarr['creditmode'] = $param['creditmode'];
		if(isset($param['creditrule']))
			$setarr['creditrule'] = $param['creditrule'];
		if(isset($param['credittime']))
			$setarr['credittime'] = $param['credittime'];
		if(isset($param['playmode']))
			$setarr['playmode'] = $param['playmode'];
		if(isset($param['isremind']))
			$setarr['isremind'] = $param['isremind'];
		if(isset($param['remindmsg']))
			$setarr['remindmsg'] = $param['remindmsg'];
		if(isset($param['remindtime']))
			$setarr['remindtime'] = $param['remindtime'];
		if(isset($param['showmode']))
			$setarr['showmode'] = $param['showmode'];
		if(!empty($param['introduce']))
			$setarr['introduce'] = $param['introduce'];
		$wherearr['crid'] = $param['crid'];
		$wherearr['folderid'] = $param['folderid'];
		
		return $this->db->update('ebh_folders',$setarr,$wherearr);
	}
	/**
	* 移动课程的位置
	* @param int $flag 1为上移 0为下移
	*/
	public function move($crid,$folderid,$flag) {
		$sql = "SELECT f.folderid,f.upid,f.displayorder,f.folderlevel FROM ebh_folders f WHERE f.folderid=$folderid AND f.crid=$crid";
		$folder = $this->db->query($sql)->row_array();
		if(empty($folder))
			return FALSE;
		$displayorder = $folder['displayorder'];
		// $upid = $folder['upid'];
		$folderlevel = $folder['folderlevel'];
		if($flag == 1) { //上移
			$upsql = "SELECT f.folderid,f.displayorder FROM ebh_folders f WHERE f.crid=$crid AND f.folderlevel=$folderlevel AND ((f.folderid<$folderid AND f.displayorder=$displayorder) OR f.displayorder<$displayorder) ORDER BY f.displayorder DESC,f.folderid DESC LIMIT 0,1";
			$next = $this->db->query($upsql)->row_array();
		} else {	//下移
			$downsql = "SELECT f.folderid,f.displayorder FROM ebh_folders f WHERE f.crid=$crid AND f.folderlevel=$folderlevel AND ((f.folderid>$folderid AND f.displayorder=$displayorder) OR f.displayorder>$displayorder) ORDER BY f.displayorder,f.folderid LIMIT 0,1";
			$next = $this->db->query($downsql)->row_array();
		}
		if(empty($next))	//已经是最大或最小
			return TRUE;
		if($displayorder != $next['displayorder']) {	//如果排序号没有相同，则只需呼唤两个displayorder即可
			$afrow1 = $this->db->update('ebh_folders',array('displayorder'=>$displayorder),array('folderid'=>$next['folderid']));
			$afrows = $this->db->update('ebh_folders',array('displayorder'=>$next['displayorder']),array('folderid'=>$folderid));
		} else {
			if($flag == 1) {
				$afrows = $this->db->update('ebh_folders',array(),array('folderid'=>$folderid),array('displayorder'=>'displayorder-1'));
			} else {
				$afrows = $this->db->update('ebh_folders',array(),array('folderid'=>$folderid),array('displayorder'=>'displayorder+1'));
			}
		}
		if ($afrows > 0) {
			return true;
		}
		return false;
	}

	/**
	*获取班级对应的教师课程
	*/
	public function getClassFolder($param) {
		$sql = 'select ct.uid from ebh_classteachers ct where ct.classid='.$param['classid'];
		$tidlist = $this->db->query($sql)->list_array();
		$tids = '';
		if(!empty($tidlist)) {
			foreach($tidlist as $tid) {
				if(empty($tids))
					$tids = $tid['uid'];
				else
					$tids .= ','.$tid['uid'];
			}
		}
		if(!empty($param['grade'])){
			$gradestr = ' or f.grade = '.$param['grade'];
		}else{
			$gradestr = '';
		}
		if(!empty($tids) || !empty($param['grade'])) {
			if(empty($tids))
				$tids = '""';
			$fsql = 'select f.folderid,f.foldername,f.coursewarenum,f.img,f.credit,f.creditrule,f.playmode,f.showmode,f.creditmode,f.credittime from ebh_folders f '.
					'where (f.folderid in(select tf.folderid from ebh_teacherfolders tf  '.
					'where tf.tid in ('.$tids.')) '.$gradestr.')and f.crid='.$param['crid'].' and f.power=0';
			if(!empty($param['order']))
				$fsql.= ' order by '.$param['order'];
			if(!empty($param['limit']))
				$fsql .= ' limit '.$param['limit'];
			else {
				if (empty($param['page']) || $param['page'] < 1)
					$page = 1;
				else
					$page = $param['page'];
				$pagesize = empty($param['pagesize']) ? 10 : $param['pagesize'];
				$start = ($page - 1) * $pagesize;
				$fsql .= ' limit ' . $start . ',' . $pagesize;
			}
			return $this->db->query($fsql)->list_array();
		}
		return FALSE;
	}
	
	/*
	isschool!=7 ,只按年级获取课程
	*/
	public function getClassFolderWithoutTeacher($param){
		$sql = 'select f.folderid,f.foldername,f.coursewarenum,f.img from ebh_folders f '.
					'where f.grade = '.$param['grade'].' and f.crid='.$param['crid'].' and f.power=0';
		return $this->db->query($sql)->list_array();
	}
	/**
	*获取班级对应的教师课程记录数
	*/
	public function getClassFolderCount($param) {
		$count = 0;
		$sql = 'select ct.uid from ebh_classteachers ct where ct.classid='.$param['classid'];
		$tidlist = $this->db->query($sql)->list_array();
		$tids = '';
		if(!empty($tidlist)) {
			foreach($tidlist as $tid) {
				if(empty($tids))
					$tids = $tid['uid'];
				else
					$tids .= ','.$tid['uid'];
			}
		}
		if(!empty($param['grade'])){
			$gradestr = ' or f.grade = '.$param['grade'];
		}else{
			$gradestr = '';
		}
		if(!empty($tids) || !empty($param['grade'])) {
			if(empty($tids))
				$tids = '""';
			$fsql = 'select count(*) count from ebh_folders f '.
					'where (f.folderid in(select tf.folderid from ebh_teacherfolders tf  '.
					'where tf.tid in ('.$tids.')) '.$gradestr.') and f.crid='.$param['crid'].' and f.power=0';
			$countrow = $this->db->query($fsql)->row_array();
			if(!empty($countrow))
				$count = $countrow['count'];
		}
		return $count;
	}
	/**
	*获取学校教师对应的课程列表
	*/
	public function getTeacherFolderList($param) {
		if(empty($param['uid']) && empty($param['crid']))
			return FALSE;
		$sql = 'SELECT u.uid,u.username,u.realname,u.face,u.sex FROM ebh_roomteachers rt '.
				'JOIN ebh_users u on (u.uid = rt.tid)';
		$wherearr = array();
		if(!empty($param['crid']))
			$wherearr[] = 'rt.crid='.$param['crid'];
		if(!empty($param['uid']))
			$wherearr[] = 'rt.tid='.$param['uid'];
		$sql .= ' WHERE '.implode(' AND ',$wherearr);
		$list = $this->db->query($sql)->list_array();
		$ids = '';
		$teacherlist = array();
		foreach($list as $teacher) {
			$teacherlist[$teacher['uid']] = $teacher;
			$teacherlist[$teacher['uid']]['folder'] = array();
			if(empty($ids))
				$ids = $teacher['uid'];
			else
				$ids .= ','.$teacher['uid'];
		}
		if(!empty($ids)) {
			$fsql = 'SELECT f.folderid,f.foldername,tf.tid from ebh_folders f '.
					'join ebh_teacherfolders tf on (tf.folderid=f.folderid) '.
					'WHERE tf.crid='.$param['crid'].' and tf.tid in ('.$ids.')';
				if(isset($param['power']))
					$fsql.= ' and f.power in ('.$param['power'].')';
			$folders = $this->db->query($fsql)->list_array();
			foreach($folders as $folder) {
				$teacherlist[$folder['tid']]['folder'][] = $folder;
			}
		}
		return $teacherlist;
	}
	/*
	教师的课程数
	*/
	public function getTeacherFolderCount($param){
		$sql = 'select count(*) count from ebh_folders f
			join ebh_teacherfolders tf on f.folderid = tf.folderid';
			$wherearr[]= 'f.crid='.$param['crid'];
			$wherearr[]= 'tf.tid='.$param['uid'];
		$sql.= ' where '.implode(' AND ',$wherearr);
		$count = $this->db->query($sql)->row_array();
		return $count['count'];
	}
	/*
	教师课程列表
	*/
	public function getTeacherFolderList1($param){
		$wherearr = array();
		$sql = 'SELECT f.uid,f.foldername,f.img,f.summary,f.folderpath,f.folderid,f.coursewarenum,f.viewnum 
		FROM ebh_folders f 
		join ebh_teacherfolders tf on f.folderid = tf.folderid';
		$wherearr[]= 'f.crid='.$param['crid'];
		$wherearr[]= 'tf.tid='.$param['uid'];
		if(isset($param['power']))
			$wherearr[]= 'f.power in ('.$param['power'].')';
		$sql.= ' where '.implode(' AND ',$wherearr);
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
		return $this->db->query($sql)->list_array();
	}
	
	/*
	按课程名(和crid)获取课程信息
	*/
	public function getFolderByFoldername($param){
		if(empty($param['crid']) || empty($param['foldername']))
			return false;
		$sql = 'select folderid from ebh_folders where crid='.$param['crid'].' and foldername=\''.$this->db->escape_str($param['foldername']).'\'';
		return $this->db->query($sql)->row_array();
	}
	
	/*
	添加一个教师到课程
	*/
	public function addTeacherToFolder($foldertarr,$crid){
		// if(empty($param['tid']) || empty($param['crid']) || empty($param['folderid']))
			// return false;
		// $tfarr = array('tid'=>$param['tid'],'folderid'=>$param['folderid'],'crid'=>$param['crid']);
		// $this->db->insert('ebh_teacherfolders',$tfarr);
		
		
		$sql = 'insert into ebh_teacherfolders (tid,folderid,crid) values ';
		$oldersql = $sql;
		foreach($foldertarr as $teacher){
			if(!empty($teacher['folderidarr'])){
				foreach($teacher['folderidarr'] as $folderid){
					// $folderid = $teacher['folderid'];
					$tid = $teacher['uid'];
					$sql.= "($tid,$folderid,$crid),";
				}
			}
		}
		if($sql == $oldersql){
			return;
		}
		$sql = rtrim($sql,',');
		$this->db->query($sql);
	}
	/*
	获取子目录
	*/
	public function getSubFolder($crid,$folderid) {
        $sql = 'select f.folderid,f.foldername,f.img,f.coursewarenum from ebh_folders f where f.crid='.$crid.' and f.upid ='.$folderid;
        return $this->db->query($sql)->list_array();
    }
	
	/*
	增加课程人气
	*/
	public function addviewnum($folderid,$num = 1) {
        $where = 'folderid='.$folderid;
        $setarr = array('viewnum'=>'viewnum+'.$num);
        $this->db->update('ebh_folders',array(),$where,$setarr);
    }

	/*
	更新课程人气
	*/
	public function updateviewnum($folderid,$viewnum){
		$where = 'folderid='.$folderid;
        $setarr = array('viewnum'=>$viewnum);
        $this->db->update('ebh_folders',array(),$where,$setarr);
	}
	
	/*
	设置人气数
	*/
	public function setviewnum($folderid, $num = 1) {
		$where = 'folderid=' . $folderid;
        $setarr = array('viewnum' => $num);
        $this->db->update('ebh_folders', array(), $where, $setarr);
	}
	/**
	 *获取学校下面的所有的课程
	 */
	public function getSchoolFolder($crid = 0){
		$sql = 'SELECT f.folderid,f.foldername from ebh_folders f where crid = '.$crid;
		return $this->db->query($sql)->list_array($sql);
	}
	/*
	* 获取有反馈的课程及课件
	*/
	public function getSubFolders($crid){
		$sql = 'select s.sid,s.folderid,s.sname,s.coursewarecount,fo.foldername,c.cwid,c.title,c.examnum ,c.cwurl,c.attachmentnum,f.fid,f.feedback,f.dateline 
		from ebh_feedbacks f 
		left join ebh_coursewares c on (c.cwid = f.cwid ) 
		left join ebh_roomcourses rc on (rc.cwid = c.cwid) 
		left join ebh_folders fo on (fo.folderid = rc.folderid) 
		left join ebh_sections s on (s.folderid = fo.folderid) 
		where s.crid = '.$crid.' group by f.fid order by s.folderid desc ';
		return $this->db->query($sql)->list_array();
	}
	
	/*
	一次设置多个viewnum
	*/
	public function setMultiViewnum($viewnumlist){
		$sql = 'update ebh_folders set viewnum= CASE folderid';
		$wtArr = array();
		$inArr = array();
		foreach($viewnumlist as $folderid=>$viewnum){
			if(!empty($folderid)){
				$wtArr[] = ' WHEN '.$folderid.' THEN '.$viewnum;
				$inArr[] = $folderid;
			}
		}
		$sql.= implode(' ', $wtArr).' END WHERE folderid IN ('.implode(',', $inArr).')';
		$this->db->query($sql);
		return $this->db->affected_rows();
	}
	
	public function getViewnumWithCW(){
		$sql = 'select f.folderid,sum(cw.viewnum) cwviewnum,f.viewnum from ebh_coursewares cw 
				join ebh_roomcourses rc on cw.cwid=rc.cwid 
				join ebh_folders f on f.folderid=rc.folderid 
				group by f.folderid
				having sum(cw.viewnum)>f.viewnum
				';
		$viewnumlist = $this->db->query($sql)->list_array();
		return $viewnumlist;
	}

	/**
	 *获取学校的收费课程
	 */
	public function getNotFreeFolderList($crid = 0){
		$sql = 'SELECT f.folderid,f.fprice FROM ebh_folders f where f.fprice >0 AND f.crid = '.$crid;
		return $this->db->query($sql)->list_array();
	}

	/**
	 *获取课程下的教师
	 */
	public function getFolderTeacher($folderid = 0){
		$sql = 'SELECT t.tid from ebh_teacherfolders t WHERE t.folderid = '.$folderid;
		return $this->db->query($sql)->list_array();
	}
	
	/*
	多个老师的所教课程
	*/
	public function getTeachersFolderList($param){
		$wherearr = array();
		$sql = 'SELECT tf.tid,f.foldername,f.img,f.folderid,f.grade,u.realname,u.uid 
		FROM ebh_folders f 
		join ebh_teacherfolders tf on f.folderid = tf.folderid
		join ebh_users u on tf.tid=u.uid
		';
		if(!empty($param['tids']))
			$wherearr[]= 'tf.tid in ('.$param['tids'].')';
		$wherearr[]= 'tf.crid='.$param['crid'];
		$sql.= ' where '.implode(' AND ',$wherearr);
		$sql.= ' order by f.grade desc,uid';
		// echo $sql;exit;
		return $this->db->query($sql)->list_array();
	}
	/*
	 *学校课程评论数
	*/
	public function getAllReviewnum($param){
		$sql = 'select sum(cw.reviewnum) from ebh_coursewares cw left join ebh_roomcourses rc on(rc.cwid = cw.cwid) left join ebh_folders fl on (fl.folderid = rc.folderid) where fl.crid = '.$param['crid'];
		$count = $this->db->query($sql)->row_array();
		return $count['sum(cw.reviewnum)'];
	}
	
	/*
	多个老师的所教课程数
	*/
	public function getTeachersFolderCount($param){
		$sql = 'select count(*) foldernum,tid from ebh_folders f 
		join ebh_teacherfolders tf on f.folderid=tf.folderid ';
		if(!empty($param['crid']))
			$wherearr[] = 'f.crid='.$param['crid'];
		if(!empty($param['uids']))
			$wherearr[] = 'tf.tid in ('.$param['uids'].')';
		$sql.= ' where '.implode(' AND ',$wherearr);
		$sql.= ' group by tf.tid';
		return $this->db->query($sql)->list_array();
	}
	
	/*
	获取同级课程最小排序号
	*/
	public function getCurdisplayorder($param){
		$sql = 'select min(displayorder) mdis from ebh_folders';
		$wherearr[] = 'crid='.$param['crid'];
		$wherearr[] = 'folderlevel='.$param['folderlevel'];
		$sql.= ' where '.implode(' AND ',$wherearr);
		$res = $this->db->query($sql)->row_array();
		return $res['mdis'];
	}
	
	/*
	学习新后台课程移动
	*/
	public function moveit($param){
		if(empty($param['folderid']))
			return false;
		$sql = "SELECT f.folderid,f.upid,f.displayorder,f.folderlevel FROM ebh_folders f WHERE f.folderid=".$param['folderid']." and f.crid=".$param['crid'];
		$thisfolder = $this->db->query($sql)->row_array();
		$sqlsameorder = "SELECT f.folderid,f.displayorder FROM ebh_folders f WHERE f.folderlevel=".$thisfolder['folderlevel']." and f.crid=".$param['crid']." and displayorder=".$thisfolder['displayorder']." and f.folderid<>".$thisfolder['folderid'];
		$sameorder = $this->db->query($sqlsameorder)->row_array();
		if(!empty($sameorder)){
			if($param['compare'] == '<')
				$op = '-';
			else
				$op = '+';
			$sqlAllforone = 'update ebh_folders set displayorder=displayorder'.$op.'1 where crid='.$param['crid'].' and displayorder'.$param['compare'].'='.$thisfolder['displayorder'].' and folderlevel='.$thisfolder['folderlevel'].' and folderid<>'.$thisfolder['folderid'];
			$this->db->query($sqlAllforone);
		}
		
		$sql2 = 'select f.folderid,f.upid,f.displayorder,f.folderlevel from ebh_folders f ';
		$wherearr[] = 'crid='.$param['crid'];
		$wherearr[] = 'displayorder'.$param['compare'].$thisfolder['displayorder'];
		$wherearr[] = 'folderlevel='.$thisfolder['folderlevel'];
		$sql2 .= ' where '.implode(' AND ',$wherearr);
		$sql2 .= ' order by '.$param['order'];
		$sql2 .= ' limit 1';
		$desfolder = $this->db->query($sql2)->row_array();
		if(empty($desfolder))
			return false;
		$this->db->update('ebh_folders',array('displayorder'=>$desfolder['displayorder']),array('folderid'=>$thisfolder['folderid']));
        $this->db->update('ebh_folders',array('displayorder'=>$thisfolder['displayorder']),array('folderid'=>$desfolder['folderid']));
        return true;
	}
	
	/*
	学生作业答题情况
	*/
	public function getUserFolderExamCredit($param){
		$sql = 'select f.folderid,sum(a.totalscore/e.score) examcredit 
		from ebh_schexamanswers a 
		join ebh_schexams e on a.eid=e.eid 
		join ebh_folders f on f.folderid = e.folderid
		';
		$wherearr[] = 'a.uid='.$param['uid'];
		$wherearr[] = 'f.folderid in ('.$param['folderid'].')';
		$sql .= ' where '.implode(' AND ',$wherearr);
		$sql .= ' group by f.folderid';
		// echo $sql;
		return $this->db->query($sql)->list_array();
		
	}
	
	/*
	课程的作业总数
	*/
	public function getFolderExamCount($param){
		$sql = 'select count(*) count,folderid from ebh_schexams e';
		$wherearr[] = ' e.folderid in ('.$param['folderid'].')';
		$sql .= ' where '.implode(' AND ',$wherearr);
		$sql.= ' group by e.folderid';
		return $this->db->query($sql)->list_array();
		
	}
	
	/*
	课程下的新课件
	*/
	public function getnewcourselistcount($param){
		$sql = 'select count(*) count ,folderid from ebh_roomcourses r 
			join ebh_coursewares c on r.cwid=c.cwid';
		$wherearr[] = ' r.crid='.$param['crid'];
		$wherearr[] = ' c.status=1';
		if(!empty($param['subtimes'])){
			$orstr = '';
			foreach($param['subtimes'] as $folderid=>$subtime){
				if(empty($orstr))
					$orstr = '(folderid ='.$folderid .' and c.truedateline>'.$subtime.')';
				else
					$orstr .= ' or (folderid ='.$folderid .' and c.truedateline>'.$subtime.')';
			}
			$wherearr[] = '(' . $orstr . ')';
		}
		$sql.= ' where '.implode(' AND ',$wherearr);
		
		$sql.= ' group by folderid';
		// echo $sql;
		return $this->db->query($sql)->list_array();
	}
}
