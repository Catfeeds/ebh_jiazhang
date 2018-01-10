<?php
/**
 * 教室课程关联模型
 */
class ClasscoursesModel extends CModel{
	//添加班级课程关联记录
	public function add($param){
		if(empty($param['classid']) || empty($param['folderids'])){
			return false;
		}
		$sql = "insert into `ebh_classcourses` (classid,folderid) values ";
		foreach ($param['folderids'] as $key=> $folderid){
			$sql .= '('.$param['classid'].','.$folderid.'),';
		}
		$sql = rtrim($sql,',');
		$result = $this->db->query($sql);
		return $result;
	}
	//删除班级课程关联记录
	public function delete($param){
		if(empty($param['classid'])){
			return -1;
		}
		$where = ' classid = '.$param['classid'];
		if(!empty($param['folderidstr'])){
			$where .= ' and folderid in ('.$param['folderidstr'].')';
		}
		return $this->db->delete('ebh_classcourses',$where);	
	}
	//根据条件获取folderid、foldername
	public function getfolders($param){
		$wharr = array();
		$sql = "select c.folderid,f.foldername,c.classid from `ebh_classcourses` c left join `ebh_folders` f on c.folderid = f.folderid";
		if(!empty($param['classid'])){
			$wharr[] = "c.classid = ".$param['classid'];
		}
		if(!empty($param['crid'])){
			$wharr[] = "f.crid = ".$param['crid'];	
		}
		if(!empty($wharr)){
			$sql .= " where ".implode(" and ", $wharr);
		}
		if(!empty($param['limit'])){
			$sql .= ' limit ' . $param['limit'];
		}
		return $this->db->query($sql)->list_array();
	}
	//根据classid获取已选的folderid
	public function getfolderidsbyclassid($classid){
		if(empty($classid)){
			return array();
		}
		$sql = "select folderid from `ebh_classcourses` where classid in (".$classid.")";
		return $this->db->query($sql)->list_array();
	}
	//清空课程及关联权限
	public function clearAllCourses($param){
		if(empty($param['classid']) || empty($param['folderids']) || empty($param['crid'])){
			return false;
		}
		$sql_1 = "delete from ebh_classcourses where classid = ".$param['classid'];
		$sql_2 = "delete from ebh_userpermisions where folderid in (".implode(',', $param['folderids']).")";
		$sql_2 .= " and crid = ".$param['crid']." and type = ".$param['type']. " and classid = ".$param['classid'];
		$this->db->begin_trans();
		$res_1 = $this->db->query($sql_1,false);
		$res_2 = $this->db->query($sql_2,false);
		if($res_2 && $res_2){
			//提交事务
			$this->db->commit_trans();
		}else{
			//回滚
			$this->db->rollback_trans();
		}
		return $res_1 && $res_2;
	}

    /**
     * 获取部门的课程ID集(包含上级部门的课程)
     * @param $classid
     * @param $crid
     */
    public function getDeptMentFolderIds($classid, $crid) {
        $classid = intval($classid);
        $crid = intval($crid);
        $deptment = $this->db->query(
            'SELECT `lft`,`rgt` FROM `ebh_classes` WHERE `classid`='.$classid.' AND `crid`='.$crid)
            ->row_array();
        if (empty($deptment)) {
            return false;
        }
        return $this->db->query(
            'SELECT DISTINCT `a`.`folderid` FROM `ebh_classcourses` `a`
             LEFT JOIN `ebh_classes` `b` ON `a`.`classid`=`b`.`classid`
             WHERE `b`.`crid`='.$crid.' AND `b`.`lft`>='.$deptment['lft'].' AND `b`.`rgt`<='.$deptment['rgt'])
            ->list_array();
    }
}