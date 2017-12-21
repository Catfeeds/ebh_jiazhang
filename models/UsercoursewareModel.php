<?php
/**
 * 存放其他类型的课件表，如作业的解析课件等的Model封装类
 */
class UsercoursewareModel extends CModel{
	/**
	* 生成记录
	*/
	function insert($param) {
		$setarr = array ();
		if(!empty($param ['uid'])){
			$setarr['uid'] = $param['uid'];
		}
		if(!empty($param ['sourceid'])){
			$setarr['sourceid'] = $param['sourceid'];
		}
		if(!empty($param ['title'])){
			$setarr['title'] = $param['title'];
		}
		if(!empty($param ['cwname'])){
			$setarr['cwname'] = $param['cwname'];
		}
		if(!empty($param ['cwsource'])){
			$setarr['cwsource'] = $param['cwsource'];
		}
		if(!empty($param ['cwurl'])){
			$setarr['cwurl'] = $param['cwurl'];
		}
		if(!empty($param ['cwlength'])){
			$setarr['cwlength'] = $param['cwlength'];
		}
		if(!empty($param ['cwsize'])){
			$setarr['cwsize'] = $param['cwsize'];
		}
		if(!empty($param ['dateline'])){
			$setarr['dateline'] = $param['dateline'];
		}else{
			$setarr['dateline'] = SYSTIME;
		}
		if(empty($setarr))
			return FALSE;
		return $this->db->insert('ebh_usercoursewares',$setarr);
	}
    /**
     * 获取用户课件详情记录
     * @param int $cwid
     * @return array
     */
    public function getUserCourse($cwid) {
        $sql = 'select c.cwid,c.title,c.cwname,c.cwsource,c.cwurl from ebh_usercoursewares c where c.cwid='.$cwid;
        return $this->db->query($sql)->row_array();
    }
}
