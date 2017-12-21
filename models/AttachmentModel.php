<?php

/**
 * 课件附件相关AttachmentModel类 
 */
class AttachmentModel extends CModel {

	/**
	*添加附件记录
	*/
	public function insert($param) {
		$setarr = array();
		if(!empty($param ['uid'])){
			$setarr['uid'] = $param['uid'];
		}
		if(!empty($param ['crid'])){
			$setarr['crid'] = $param['crid'];
		}
		if(!empty($param ['cwid'])){
			$setarr['cwid'] = intval($param['cwid']);
		}
		if(!empty($param ['title'])){
			$setarr['title'] = $param['title'];
		}
		if(!empty($param ['message'])){
			$setarr['message'] = $param['message'];
		}
		if(!empty($param ['source'])){
			$setarr['source'] = $param['source'];
		}
		if(!empty($param ['url'])){
			$setarr['url'] = $param['url'];
		}
		if(!empty($param ['filename'])){
			$setarr['filename'] = $param['filename'];
		}
		if(!empty($param ['suffix'])){
			$setarr['suffix'] = $param['suffix'];
		}
		if(!empty($param ['size'])){
			$setarr['size'] = intval($param['size']);
		}
		if(!empty($param ['status']) || $param ['status']==0){
			$setarr['status'] = $param['status'];
		}
		$setarr['dateline'] = SYSTIME;
		$attid = $this->db->insert('ebh_attachments',$setarr);
		return $attid;
	}
	/**
	*修改附件记录
	*/
	public function update($param) {
		if(empty($param['attid']))
			return FALSE;
		$wherearr = array('attid'=>$param['attid']);
		$setarr = array();
		if(!empty($param ['title'])){
			$setarr['title'] = $param['title'];
		}
		if(!empty($param ['message'])){
			$setarr['message'] = $param['message'];
		}
		$afrows = $this->db->update('ebh_attachments',$setarr,$wherearr);
		return $afrows;
	}
    /**
     * 根据课件编号等信息获取附件列表
     * @param array $queryarr 
     * @return array 附件列表数组
     */
    public function getAttachmentListByCwid($queryarr = array()) {
        $sql = 'SELECT a.attid,a.title,a.filename,a.source,a.url,a.suffix,a.size,a.`status`,a.dateline,a.ispreview from ebh_attachments a';
		$wherearr = array();
		$wherearr[] ='a.cwid=' . $queryarr['cwid'];
		if(isset($queryarr['status']))
			$wherearr[] = 'a.status='.$queryarr['status'];
		$sql.= ' where '.implode(' AND ',$wherearr);
        $sql .= ' ORDER BY  a.attid desc ';
        return $this->db->query($sql)->list_array();
    }

    /**
     * 根据课件编号等信息获取附件总数
     * @param array $queryarr 
     * @return int
     */
    public function getAttachmentCountByCwid($queryarr = array()) {
        $count = 0;
        $sql = 'SELECT count(*) count from ebh_attachments a ';
		$wherearr = array();
		$wherearr[] ='a.cwid=' . $queryarr['cwid'];
		if(isset($queryarr['status']))
			$wherearr[] = 'a.status='.$queryarr['status'];
		$sql.= ' where '.implode(' AND ',$wherearr);
        $countrow = $this->db->query($sql)->row_array();
        if (!empty($countrow))
            $count = $countrow['count'];
        return $count;
    }

    /*
      所有附件列表
      @param array $param
      @return array 列表数组
     */

    public function getattachmentlist($param) {
        $sql = 'select a.title,a.suffix,a.size,a.status,a.dateline,a.attid,a.message from ebh_attachments a ';
        if (!empty($param['q']))
            $wherearr[] = ' ( a.title like \'%' . $this->db->escape_str($param['q']) . '%\' or a.suffix like \'%' . $this->db->escape_str($param['q']) . '%\')';
        if (!empty($wherearr))
            $sql.=' where ' . implode(' AND ', $wherearr);
        $sql.=' order by a.attid';
        if (!empty($param['limit']))
            $sql.= ' limit ' . $param['limit'];
        //var_dump($sql);
        return $this->db->query($sql)->list_array();
    }

    /*
      附件总数量
      @param array $param
      @return int
     */

    public function getattachmentcount($param) {
        $sql = 'select count(*) count from ebh_attachments a ';
        if (!empty($param['q']))
            $wherearr[] = ' ( a.title like \'%' . $this->db->escape_str($param['q']) . '%\' or a.suffix like \'%' . $this->db->escape_str($param['q']) . '%\')';
        if (!empty($wherearr))
            $sql.=' where ' . implode(' AND ', $wherearr);
        //var_dump($sql);
        $count = $this->db->query($sql)->row_array();
        return $count['count'];
    }
    
     /*
      获取所有课件附件列表
      @param array $param
      @return array 列表数组
     */

    public function getlistwithcourse($param) {
        if (empty($param['crid']))
            return FALSE;
        if (empty($param['page']) || $param['page'] < 1)
            $page = 1;
        else
            $page = $param['page'];
        $pagesize = empty($param['pagesize']) ? 10 : $param['pagesize'];
        $start = ($page - 1) * $pagesize;
        $sql = 'select a.attid,a.cwid,a.title,c.title ctitle,a.source,a.suffix,a.size,a.status,a.dateline,a.attid,a.message,c.cwurl from ebh_attachments a '.
            'LEFT JOIN ebh_coursewares c ON a.cwid=c.cwid ';
        if (!empty($param['crid']))
            $wherearr[] = 'a.crid='.$param['crid'];
		if (!empty($param['cwid']))
            $wherearr[] = 'a.cwid='.$param['cwid'];
        if (!empty($wherearr))
            $sql.=' where ' . implode(' AND ', $wherearr);
        $sql.=' order by a.attid';
        if (!empty($param['limit']))
            $sql.= ' limit ' . $param['limit'];
        $sql .= ' limit ' . $start . ',' . $pagesize;
        return $this->db->query($sql)->list_array();
    }

    /*
      获取所有课件附件列表记录数
      @param array $param
      @return int
     */

    public function getlistcountwithcourse($param) {
        $count = 0;
        if (empty($param['crid']))
            return $count;
        $sql = 'select count(*) count from ebh_attachments a ';
        if (!empty($param['crid']))
            $wherearr[] = 'a.crid='.$param['crid'];
		if (!empty($param['cwid']))
            $wherearr[] = 'a.cwid='.$param['cwid'];
        if (!empty($wherearr))
            $sql.=' where ' . implode(' AND ', $wherearr);
        $row = $this->db->query($sql)->row_array();
        if(!empty($row))
            $count = $row['count'];
        return $count;
    }
    /**
	* 根据附件编号获取附件信息
	* @param int $attid附件编号
	* @return array
	*/
	public function getAttachById($attid) {
		$sql = "SELECT a.attid,a.uid,a.crid,a.cwid,a.title,a.message,a.source,a.url,a.filename,a.suffix,a.size,a.ispreview,a.`status`,a.dateline,rc.isfree FROM  ebh_attachments a ".
			"JOIN ebh_roomcourses rc ON rc.cwid = a.cwid ".
			"WHERE a.attid = $attid";
		return $this->db->query($sql)->row_array();
	}
	/**
	* 根据附件编号获取附件简单信息
	* @param int $attid附件编号
	* @return array
	*/
	public function getSimpleAttachById($attid) {
		$sql = "SELECT a.attid,a.uid,a.source from ebh_attachments a where a.attid = $attid";
		return $this->db->query($sql)->row_array();
	}
    /*
      删除附件
      @param int $attid
      @return int
     */

    public function deleteattachment($attid) {
        return $this->db->delete('ebh_attachments', 'attid=' . $attid);
    }

    /*
      编辑
      @param array $param
      @return int 影响行数
     */

    public function editattachment($param) {
        if (isset($param['status']))
            $setarr['status'] = $param['status'];
        if (!empty($param['title']))
            $setarr['title'] = $param['title'];
        if (!empty($param['message']))
            $setarr['message'] = $param['message'];
        $wherearr = array('attid' => $param['attid']);
        $row = $this->db->update('ebh_attachments', $setarr, $wherearr);
        return $row;
    }
	/**
	*更新附件的预览状态，1为可预览
	*/
	public function updateIspreview($attid,$ispreview = 1,$apppreview) {
		$where = 'attid=' . $attid;
        $setarr = array('ispreview' => $ispreview);
		if(isset($apppreview))
			$setarr['apppreview'] = $apppreview;
        return $this->db->update('ebh_attachments', $setarr, $where);
	}
	
	/*
	批量上传附件
	*/
	public function addMultipleAtt($param){
		$attnum = count($param);
		$sql = 'insert into ebh_attachments (uid,crid,cwid,title,message,source,url,filename,suffix,size,status,dateline) values ';
		foreach($param as $att){
			$uid = $att['uid'];
			$crid = $att['crid'];
			$cwid = $att['cwid'];
			$title = $this->db->escape_str($att['title']);
			$message = $this->db->escape_str($att['message']);
			$source = $att['source'];
			$url = $att['url'];
			$filename = $this->db->escape_str($att['filename']);
			$suffix = $att['suffix'];
			$size = $att['size'];
			$status = 1;
			$dateline = SYSTIME;
			$sql.= "($uid,$crid,$cwid,'$title','$message','$source','$url','$filename','$suffix',$size,$status,$dateline),";
		}
		$sql = rtrim($sql,',');
		$this->db->query($sql);
		$fromattid = $this->db->insert_id();
		return array('fromattid'=>$fromattid,'attnum'=>$attnum);
		
	}
	/*
	根据id获取附件,供通知附件用
	*/
	public function getAttachByIdForNotice($attid){
		$sql = "SELECT a.attid,a.uid,a.crid,a.cwid,a.title,a.message,a.source,a.url,a.filename,a.suffix,a.size,a.ispreview,a.`status`,a.dateline FROM  ebh_attachments a ".
			"WHERE a.attid = $attid";
		return $this->db->query($sql)->row_array();
	}

  /**
   *根据cwid删除附件
   */
  public function deletebycwid($cwid){
    $where = array('cwid'=>intval($cwid));
    return $this->db->delete('ebh_attachments',$where);
  }
  
	/*
	课程下的附件列表
	*/
	public function getAttachByFolderid($param){
		$sql = 'select a.attid,a.title atttitle,cw.title cwtitle,cw.cwid,a.filename,a.dateline,a.size,a.source,a.suffix,cw.cwsource,a.ispreview
				from ebh_attachments a 
				join ebh_coursewares cw on a.cwid=cw.cwid
				join ebh_roomcourses rc on rc.cwid= cw.cwid
				';
		if (!empty($param['q']))
            $wherearr[] = ' ( a.title like \'%' . $this->db->escape_str($param['q']) . '%\' or a.suffix like \'%' . $this->db->escape_str($param['q']) . '%\')';
		$wherearr[] = 'rc.folderid='.$param['folderid'];
		$sql .= ' where '.implode(' AND ',$wherearr);
		$sql .= ' order by cw.cwid desc';
		return $this->db->query($sql)->list_array();
	}
}
