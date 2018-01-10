<?php 
/*
 * 学校作业类型
 */
class SchestypeModel extends CModel {

	/*
	 *插入
	 */
	public function insert($param = array()) {
		$setarr = array();
		if (isset($param['crid'])) {
			$setarr['crid'] = $param['crid'];
		}
		if (isset($param['uid'])) {
			$setarr['uid'] = $param['uid'];
		}
		if (isset($param['estype'])) {
			$setarr['estype'] = $param['estype'];
		}
		/*if (isset($param['code'])) {
			$setarr['code'] = strtoupper($param['code']);
		}*/
		if (isset($param['order'])) {
			$setarr['order'] = $param['order'];
		}
		$setarr['add_time'] = SYSTIME;
		return $this->db->insert('ebh_schexam_estype',$setarr);
	}

	/*
	 *多条插入
	 */
	public function insertAll($param = array(), $crid, $uid) {
		$sql= "insert into ebh_schexam_estype (crid,uid,estype,add_time) values";
		foreach ($param as $value) {
			$sql .= sprintf("('%d','%d', '%s', '%d'),", $crid, $uid, $this->db->escape_str($value['estype']), SYSTIME);
		}
		$sql = substr($sql, 0, -1).';';
		return $this->db->query($sql);
	}

	/**
	*删除
	*/
	public function delete($param = array()){
		if(empty($param['id']))
			return FALSE;
		$wherearr = array();
		$wherearr['id'] = $param['id'];
		$setarr['dtag'] = 1;
		return $this->db->update('ebh_schexam_estype',$setarr,$wherearr);
	}

	/**
	*更新
	*/
	public function update($param) {
		if(empty($param['id']))
			return FALSE;
		$wherearr = array();
		$wherearr['id'] = $param['id'];
		$setarr = array();
		if(!empty($param['estype'])) {
			$setarr['estype'] = $param['estype'];
		}
		/*if(!empty($param['code'])) {
			$setarr['code'] = strtoupper($param['code']);
		}*/
		if(!empty($param['order'])) {
			$setarr['order'] = $param['order'];
		}
		if(!empty($param['dtag'])) {
			$setarr['dtag'] = $param['dtag'];
		}
		if(empty($wherearr) || empty($setarr))
			return FALSE;
		return $this->db->update('ebh_schexam_estype',$setarr,$wherearr);
	}

	/**
	*根据所有的id更新
	*/
	/*public function updateAll($param = array()) {
		if(empty($param))
			return FALSE;
		foreach ($param as  $value) {
			$ret = $this->db->update('ebh_schexam_estype',$setarr,$wherearr);
			if ( ! $ret) {
				return FALSE;
			}
		}
		return TRUE;
	}*/

	/**
	*获取列表
	*/
	public function getEstypeList($param) {
		$sql = 'select e.id,e.crid,e.estype,e.order from ebh_schexam_estype e';
		$wherearr = array();
		if(!empty($param['id'])) {
			$wherearr[] = 'e.id ='.$param['id'];
		}
		if(isset($param['crid'])){
			$wherearr[] = 'e.crid = '.$param['crid'];
		}
		if(isset($param['uid'])){
			$wherearr[] = 'e.uid = '.$param['uid'];
		}
		if(isset($param['dtag'])){
			$wherearr[] = 'e.dtag = '.$param['dtag'];
		} else {
			$wherearr[] = 'e.dtag = 0';
		}
		if(!empty($wherearr))
			$sql .= ' where '.implode(' and ',$wherearr);
		if(!empty($param['order']))
			$sql .= ' order by '.$param['order'];
		else
			$sql .= ' order by e.id desc';
		if(!empty($param['limit']))
			$sql .= ' limit '.$param['limit'];
		else
			$sql .= ' limit 0,10';
		return $this->db->query($sql)->list_array();
	}

    /**
     *获取列表
     */
    public function getEstypeByIds($ids) {
        $sql = 'select e.id,e.crid,e.estype,e.order from ebh_schexam_estype e where id in ('.$ids.')';
        return $this->db->query($sql)->list_array();
    }

	/*
	 *特殊方法更数据库，批改更新操作
	 */
	public function updateAll($updates, $ids) {
		$sql = "UPDATE ebh_schexam_estype SET estype = CASE id ";
		foreach ($updates['estype'] as $id => $estype) {
		    $sql .= sprintf("WHEN %d THEN '%s' ", $id, $this->db->escape_str($estype));
		}
		/*$sql .= "END, code = CASE id ";
		foreach ($updates['code'] as $id => $code) {
			$sql .= sprintf("WHEN %d THEN '%s' ", $id, $this->db->escape_str($code));
		}*/
		$sql .= "END WHERE id IN ($ids);";
		return $this->db->query($sql);
	}

	/*
	 *检查是否存在重名
	 */
	public function check($param, $crid) {
		if (empty($param))
			return FALSE;
		$sql = 'select id from ebh_schexam_estype where crid ='.$crid.' and estype in (\''.$param.'\');';
		return $this->db->query($sql)->list_array();
	}
}
