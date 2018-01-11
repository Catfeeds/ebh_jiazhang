<?php
/*
服务包内项目
*/
class PayitemModel extends CModel{
	/**
	*获取服务包内项目列表
	*/
	public function getItemList($param) {
		$sql = 'select i.itemid,i.pid,i.crid,i.folderid,i.iname,i.isummary,i.iprice,i.imonth,i.iday,i.dateline,i.providercrid,i.comfee,i.roomfee,i.providerfee,i.isyouhui,i.iprice_yh,i.comfee_yh,i.roomfee_yh,i.providerfee_yh,r.crname,r.summary,r.cface,r.domain,r.coursenum,r.examcount,r.ispublic,p.pname,s.sname,i.limitnum,i.islimit from ebh_pay_items i join ebh_classrooms r on (i.crid = r.crid) join ebh_pay_packages p on p.pid=i.pid left join ebh_pay_sorts s on i.sid = s.sid';
        $wherearr = array('i.`status`=0','p.`status`=1');
		if(!empty($param['pid'])) {
			$wherearr[] = 'i.pid='.$param['pid'];
		}
		if(!empty($param['pidlist'])) {	//根据pid的列表获取数据，如 1,2形式
			$wherearr[] = 'i.pid in('.$param['pidlist'].')';
		}
		if(!empty($param['itemidlist'])) {	//根据itemid组合获取详情列表，如1,2形式
			$wherearr[] = 'i.itemid in('.$param['itemidlist'].')';
		}
		if(!empty($param['tid'])){
			$wherearr[] = 'p.tid='.$param['tid'];
		}
		if(!empty($param['crid'])) {
			$wherearr[] = 'i.crid='.$param['crid'];
		}
		if(!empty($param['folderid'])) {
			$wherearr[] = 'i.folderid='.$param['folderid'];
		}
		if(!empty($param['q'])){
			$q = $this->db->escape_str($param['q']);
			$wherearr[] = '(i.iname like \'%'.$q.'%\' or p.pname like \'%'.$q.'%\' )';
		}			
		if(!empty($wherearr)) {
			$sql .= ' WHERE ' . implode(' AND ', $wherearr);
		}
		if(!empty($param['displayorder'])) {
            $sql .= ' ORDER BY '.$param['displayorder'];
        } else {
            $sql .= ' ORDER BY itemid desc';
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
	/**
	*获取服务包内项目列表数量
	*/
	public function getItemListCount($param) {
		$count = 0;
		$sql = 'select count(*) count from ebh_pay_items i join ebh_classrooms r on (i.crid = r.crid) join ebh_pay_packages p on p.pid=i.pid';
		$wherearr = array('i.`status`=0','p.`status`=1');
		if(!empty($param['pid'])) {
			$wherearr[] = 'i.pid='.$param['pid'];
		}
		if(!empty($param['itemidlist'])) {	//根据itemid组合获取详情列表，如1,2形式
			$wherearr[] = 'i.itemid in('.$param['itemidlist'].')';
		}
		if(!empty($param['crid'])) {
			$wherearr[] = 'i.crid='.$param['crid'];
		}
		if(!empty($param['folderid'])) {
			$wherearr[] = 'i.folderid='.$param['folderid'];
		}
		if(!empty($wherearr)) {
			$sql .= ' WHERE ' . implode(' AND ', $wherearr);
		}
		$row = $this->db->query($sql)->row_array();
		if(!empty($row))
			$count = $row['count'];
		return $count;
	}
	/**
	*获取服务包内项目列表(针对课程)
	*/
	public function getItemFolderList($param) {
		$sql = 'select i.itemid,i.pid,i.crid,i.folderid,i.iname,i.isummary,i.iprice,i.imonth,i.iday,i.grade,i.sid,s.sname,f.foldername,f.summary,f.img,f.coursewarenum,f.viewnum,f.ispublic,f.fprice,f.speaker,s.showbysort,s.ishide,s.imgurl simg,s.content,f.credit,i.cannotpay,f.showmode,f.creditmode,f.credittime,s.showaslongblock,i.longblockimg,f.cwcredit,f.cwpercredit from ebh_pay_items i '.
				'join ebh_folders f on (i.folderid = f.folderid) '.
				'left join ebh_pay_sorts s on (s.sid=i.sid)';
		$wherearr = array('i.`status`=0','f.`del`=0');
		if(!empty($param['pid'])) {
			$wherearr[] = 'i.pid='.$param['pid'];
		}
		if(!empty($param['pidlist'])) {	//根据pid的列表获取数据，如 1,2形式
			$wherearr[] = 'i.pid in('.$param['pidlist'].')';
		}
		if(!empty($param['itemidlist'])) {	//根据itemid组合获取详情列表，如1,2形式
			$wherearr[] = 'i.itemid in('.$param['itemidlist'].')';
		}

		if(!empty($param['crid'])) {
			$wherearr[] = 'i.crid='.$param['crid'];
		}
		if(!empty($param['folderid'])) {
			$wherearr[] = 'i.folderid='.$param['folderid'];
		}
		if(!empty($param['needsid'])){
			$wherearr[] = 'i.sid<>0';
		}
		if(isset($param['power']))
			$wherearr[] = 'f.power in ('.$param['power'].')';

        $wherearr[] = "`i`.`status`=0";
		if(!empty($wherearr)) {
			$sql .= ' WHERE ' . implode(' AND ', $wherearr);
		}
		if(!empty($param['displayorder'])) {
            $sql .= ' ORDER BY '.$param['displayorder'];
        } else {
            $sql .= ' ORDER BY pid desc';
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
        }//return $sql;
		return $this->db->query($sql)->list_array();
	}
	/**
	*获取服务包内项目列表数量
	*/
	public function getItemListFolderCount($param) {
		$count = 0;
		$sql = 'select count(*) count from ebh_pay_items i join ebh_folder f on (i.folderid = f.folderid)';
		$wherearr = array('i.`status`=0','f.`del`=0');
		if(!empty($param['pid'])) {
			$wherearr[] = 'i.pid='.$param['pid'];
		}
		if(!empty($param['itemidlist'])) {	//根据itemid组合获取详情列表，如1,2形式
			$wherearr[] = 'i.itemid in('.$param['itemidlist'].')';
		}
		if(!empty($param['crid'])) {
			$wherearr[] = 'i.crid='.$param['crid'];
		}
		if(!empty($param['folderid'])) {
			$wherearr[] = 'i.folderid='.$param['folderid'];
		}
		if(!empty($wherearr)) {
			$sql .= ' WHERE ' . implode(' AND ', $wherearr);
		}
		$row = $this->db->query($sql)->row_array();
		if(!empty($row))
			$count = $row['count'];
		return $count;
	}
	/**
	*根据itemid获取服务明细项详情
	*/
	public function getItemByItemid($itemid) {
		$sql = "select i.itemid,i.pid,i.iname,i.isummary,i.iprice,i.imonth,i.iday,i.folderid,i.sid,i.view_mode,cr.crid,cr.crname,cr.fulldomain,p.pname,p.crid pcrid,f.fprice,cr.domain,f.speaker,f.detail,f.isschoolfree,f.img,f.summary,f.showmode,f.displayorder as fdisplayorder,i.providercrid,i.comfee,i.roomfee,i.providerfee,i.cannotpay ,i.longblockimg,i.isyouhui,i.iprice_yh,i.comfee_yh,i.roomfee_yh,i.providerfee_yh,i.ptype from ebh_pay_items i join ebh_classrooms cr on i.crid=cr.crid join ebh_pay_packages p on p.pid=i.pid join ebh_folders f on i.folderid=f.folderid where i.itemid=$itemid";
		return $this->db->query($sql)->row_array();
	}
	/**
	*根据sid获取服务明细项列表
	*/
	public function getItemBySidOrItemid($param = array()) {
		if(empty($param['sid']) && empty($param['itemid']))
			return FALSE;
		$sql = "select i.itemid,i.pid,i.iname,i.isummary,i.iprice,i.imonth,i.iday,i.folderid,i.sid,i.isyouhui,i.iprice_yh,i.comfee_yh,i.roomfee_yh,i.providerfee_yh,cr.crid,cr.crname,p.pname,p.crid pcrid,f.fprice,cr.domain,f.speaker,f.detail,i.cannotpay,i.limitnum,i.islimit from ebh_pay_items i join ebh_classrooms cr on i.crid=cr.crid join ebh_pay_packages p on p.pid=i.pid join ebh_folders f on i.folderid=f.folderid"; 
		$wherearr = array('i.`status`=0');
		if(!empty($param['sid'])) {
			$wherearr[] = 'i.sid='.$param['sid'];
        }
		if(!empty($param['itemid'])) {
			$wherearr[] = 'i.itemid='.$param['itemid'];
        }
        if (!empty($param['crid'])) {
		    $wherearr[] = 'i.crid='.$param['crid'];
        }
		if(!empty($wherearr)) {
			$sql .= ' WHERE ' . implode(' AND ', $wherearr);
		}
		return $this->db->query($sql)->list_array();
	}
	public function getBestItemBySidOrItemid($param = array()){
		if(empty($param['itemid'])){
			return false;
		}
		$sql = 'select i.itemid,i.iname,i.isummary,i.iprice,i.imonth,i.iday,i.folderid,i.providercrid,i.isyouhui,i.iprice_yh,i.comfee_yh,i.roomfee_yh,i.providerfee_yh,cr.crid,cr.crname,f.fprice,cr.domain,f.speaker,f.detail,i.cannotpay,cr.domain from ebh_best_items i join ebh_classrooms cr on i.providercrid=cr.crid join ebh_folders f on i.folderid=f.folderid';
		$wherearr = array('f.`del`=0');
		if(!empty($param['itemid']))
			$wherearr[] = 'i.itemid='.$param['itemid'];
		if(!empty($wherearr)) {
			$sql .= ' WHERE ' . implode(' AND ', $wherearr);
		}
		return $this->db->query($sql)->list_array();
	}
	
	
	public function add($param){
		$spiarr['iname'] = $param['iname'];
		$spiarr['pid'] = $param['pid'];
		$spiarr['crid'] = $param['crid'];
		$spiarr['iprice'] = $param['iprice'];
		if(!empty($param['isummary']))
			$spiarr['isummary'] = $param['isummary'];
		if(!empty($param['folderid']))
			$spiarr['folderid'] = $param['folderid'];
		if(!empty($param['sid']))
			$spiarr['sid'] = $param['sid'];
		// if(!empty($param['iday']))
			$spiarr['iday'] = empty($param['iday'])?0:$param['iday'];
		// elseif(!empty($param['imonth']))
			$spiarr['imonth'] = empty($param['imonth'])?0:$param['imonth'];
		if(!empty($param['providercrid']))
			$spiarr['providercrid'] = $param['providercrid'];
		if(!empty($param['comfee']))
			$spiarr['comfee'] = $param['comfee'];
		if(!empty($param['roomfee']))
			$spiarr['roomfee'] = $param['roomfee'];
		if(!empty($param['providerfee']))
			$spiarr['providerfee'] = $param['providerfee'];
		if(!empty($param['longblockimg']))
			$spiarr['longblockimg'] = $param['longblockimg'];
		$spiarr['dateline'] = SYSTIME;
		if(!empty($param['isyouhui']))
			$spiarr['isyouhui'] = $param['isyouhui'];
		if(!empty($param['iprice_yh']))
			$spiarr['iprice_yh'] = $param['iprice_yh'];
		if(!empty($param['comfee_yh']))
			$spiarr['comfee_yh'] = $param['comfee_yh'];
		if(!empty($param['roomfee_yh']))
			$spiarr['roomfee_yh'] = $param['roomfee_yh'];
		if(!empty($param['providerfee_yh']))
			$spiarr['providerfee_yh'] = $param['providerfee_yh'];
		if(isset($param['ptype']))
			$spiarr['ptype'] = $param['ptype'];
        if (isset($param['view_mode'])) {
            $spiarr['view_mode'] = $param['view_mode'];
        }
		return $this->db->insert('ebh_pay_items',$spiarr);
	}
	
	public function edit($param){
		if(empty($param['itemid']))
			exit;
		$spiarr['iname'] = $param['iname'];
		$spiarr['pid'] = $param['pid'];
		$spiarr['crid'] = $param['crid'];
		$spiarr['isummary'] = $param['isummary'];
		$spiarr['iprice'] = $param['iprice'];
		$spiarr['folderid'] = $param['folderid'];
		$spiarr['sid'] = $param['sid'];
		if(isset($param['providercrid']))
			$spiarr['providercrid'] = $param['providercrid'];
		if(isset($param['comfee']))
			$spiarr['comfee'] = $param['comfee'];
		if(isset($param['roomfee']))
			$spiarr['roomfee'] = $param['roomfee'];
		if(isset($param['providerfee']))
			$spiarr['providerfee'] = $param['providerfee'];
		if(!empty($param['iday'])){
			$spiarr['iday'] = $param['iday'];
			$spiarr['imonth'] = 0;
		}elseif(!empty($param['imonth'])){
			$spiarr['imonth'] = $param['imonth'];
			$spiarr['iday'] = 0;
		}
		if(isset($param['cannotpay']))
			$spiarr['cannotpay'] = $param['cannotpay'];
		if(isset($param['longblockimg']))
			$spiarr['longblockimg'] = $param['longblockimg'];
		if(isset($param['isyouhui']))
			$spiarr['isyouhui'] = $param['isyouhui'];
		if(isset($param['iprice_yh']))
			$spiarr['iprice_yh'] = $param['iprice_yh'];
		if(isset($param['comfee_yh']))
			$spiarr['comfee_yh'] = $param['comfee_yh'];
		if(isset($param['roomfee_yh']))
			$spiarr['roomfee_yh'] = $param['roomfee_yh'];
		if(isset($param['providerfee_yh']))
			$spiarr['providerfee_yh'] = $param['providerfee_yh'];
		if(isset($param['ptype']))
			$spiarr['ptype'] = $param['ptype'];
        if (isset($param['view_mode'])) {
            $spiarr['view_mode'] = $param['view_mode'];
        }
		return $this->db->update('ebh_pay_items',$spiarr,'itemid='.$param['itemid']);
	}

    /**
     * 删除服务项
     * @param $itemid 服务项ID
     * @param bool $hasCourseware 关联的课程是否包含课件
     * @return bool
     */
	public function deleteitem($itemid, $hasCourseware = false){
        $itemid = (int) $itemid;
		//return $this->db->delete('ebh_pay_items','itemid='.$itemid);
        //return $this->db->update('ebh_pay_items', array('`status`=2'), "`itemid`=$itemid");
        $item = $this->db->query("SELECT `folderid`,`crid` FROM `ebh_pay_items` WHERE `itemid`=$itemid")->row_array();
        if (empty($item['folderid'])) {
            return false;
        }
        $other_items = $this->db->query(
            "SELECT `itemid` FROM `ebh_pay_items` WHERE `folderid`={$item['folderid']} AND `crid`={$item['crid']} AND `status`=0")
            ->list_field();
        if (count($other_items) > 1) {
            //课程对应多个服务项，只需删除服务项
            return $this->db->update('ebh_pay_items', array('status' => 2), "`itemid`=$itemid");
        }
        if ($hasCourseware) {
            return false;
        }
        $this->db->begin_trans();
        $this->db->update('ebh_pay_items', array('status' => 2), "`itemid`=$itemid");
        if ($this->db->trans_status() === false) {
            $this->db->rollback_trans();
            return false;
        }
        $this->db->update('ebh_folders', array('del' => 1), "`folderid`={$item['folderid']} AND `crid`={$item['crid']}");
        if ($this->db->trans_status() === false) {
            $this->db->rollback_trans();
            return false;
        }
        $this->db->delete('ebh_teacherfolders', "`folderid`={$item['folderid']} AND `crid`={$item['crid']}");
        if ($this->db->trans_status() === false) {
            $this->db->rollback_trans();
            return false;
        }
        $this->db->commit_trans();
        return TRUE;
	}
	
	/*
	无权限的服务项
	*/
	public function getItemFolderListNotPaid($param, $filter_free = true) {
		$sql = 'select i.itemid,i.pid,i.crid,i.folderid,i.iname,i.iprice,i.imonth,i.iday,i.ptype,f.foldername,f.img,f.ispublic,f.fprice,f.coursewarenum,i.sid,i.cannotpay,f.isschoolfree from ebh_pay_items i '.
				'join ebh_folders f on (i.folderid = f.folderid) ';
		$wherearr = array('i.`status`=0','f.`del`=0');
		if(!empty($param['pid'])) {
			$wherearr[] = 'i.pid='.$param['pid'];
		}
		if(!empty($param['pidlist'])) {	//根据pid的列表获取数据，如 1,2形式
			$wherearr[] = 'i.pid in('.$param['pidlist'].')';
		}
		if(!empty($param['itemidlist'])) {	//根据itemid组合获取详情列表，如1,2形式
			$wherearr[] = 'i.itemid in('.$param['itemidlist'].')';
		}

		if(!empty($param['crid'])) {
			$wherearr[] = 'i.crid='.$param['crid'];
		}
		if(!empty($param['folderid'])) {
			$wherearr[] = 'i.folderid='.$param['folderid'];
		}
		if(isset($param['power']))
			$wherearr[] = 'f.power in ('.$param['power'].')';
		//不在用户权限表,并且课程不免费
		$wherearr[] = 'i.itemid not in (select itemid from ebh_userpermisions where uid='.$param['uid'].' and crid='.$param['crid'].' and enddate>='.(SYSTIME-86400).')';
        //服务项有效
        $wherearr[] = "`i`.`status`=0";
		if ($filter_free) {
            $wherearr[] = 'f.fprice>0 and i.iprice>0';
        }

		if(!empty($wherearr)) {
			$sql .= ' WHERE ' . implode(' AND ', $wherearr);
		}
		if(!empty($param['displayorder'])) {
            $sql .= ' ORDER BY '.$param['displayorder'];
        } else {
            $sql .= ' ORDER BY pid desc';
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
	/**
	 * [getBestItemList 通过精品课的itemid读取精品课的详细信息]
	 * @param  [type] $itemid [description]
	 * @return [type]         [description]
	 */
	public function getBestItemList($itemid){
		$sql = 'select i.itemid,i.folderid,i.iname,i.isummary,i.iprice,i.imonth,i.iday,i.dateline,i.providercrid,i.comfee,i.roomfee,i.providerfee,i.isyouhui,i.iprice_yh,i.comfee_yh,i.roomfee_yh,i.providerfee_yh from `ebh_best_items` i where i.itemid ='.$itemid;
		return $this->db->query($sql)->list_array();
	}

	/**
	*根据itemid获取服务项简单信息
	*/
	public function geSimpletItemByItemid($itemid) {
		$sql = "select i.itemid,i.cannotpay ,i.ptype,i.folderid,i.iprice,i.sid from ebh_pay_items i where i.itemid=$itemid";
		return $this->db->query($sql)->row_array();
	}
	/**
	*根据crid和folderid获取服务项列表
	*/
	public function getItemListByRid($param) {
		if(empty($param['crid']) || empty($param['folderid']))
			return FALSE;
		$sql = 'select i.itemid,i.cannotpay ,i.ptype,i.folderid from ebh_pay_items i';
        $wherearr = array('i.`status`=0');
		if(!empty($param['crid'])) {
			$wherearr[] = 'i.crid='.$param['crid'];
		}
		if(!empty($param['folderid'])) {
			$wherearr[] = 'i.folderid='.$param['folderid'];
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
	/**
	*根据课程名称组合获取服务项，课程名称以逗号隔开 如 '高一英语','高一数学'
	*/
	public function getItemListByFoldernames($param) {
		if(empty($param['crid']) || empty($param['folders']))
			return FALSE;
		$sql = 'select i.itemid,f.folderid,i.iname,f.foldername from ebh_pay_items i join ebh_folders f on (i.folderid=f.folderid) ';
		$wherearr[] = 'i.crid='.$param['crid'];
        $wherearr[] = 'i.`status`=0';
        $wherearr[] = 'f.`del`=0';
//		$param['folders'] = $this->db->escape($param['folders']);
		$wherearr[] = 'f.foldername in ('.$param['folders'].')';
		if(isset($param['cannotpay']))
			$wherearr[] = 'i.cannotpay='.$param['cannotpay'];
		if(!empty($wherearr)) {
			$sql .= ' WHERE ' . implode(' AND ', $wherearr);
		}
		return $this->db->query($sql)->list_array();
	}

    /**
     * 获取存在服务项的课程ID
     * @param $folderids
     * @return array
     */
	public function getItemListByFolderIds($folderids) {
        if (!is_array($folderids)) {
            $folderid = intval($folderids);
            if ($folderid < 1) {
                return array();
            }
            return $this->db->query("SELECT `folderid` FROM `ebh_pay_items` WHERE `folderid`=$folderid AND `status`=0")->list_field();
        }

        $folderids = array_filter($folderids, function($folderid) {
           return preg_match('/^\d+$/', $folderid);
        });

        if (empty($folderids)) {
            return array();
        }
        $folderids = array_unique($folderids);
        $folderids_str = implode(',', $folderids);
        return $this->db->query(
            "SELECT DISTINCT `folderid` FROM `ebh_pay_items` WHERE `folderid` IN($folderids_str) AND `status`=0")
            ->list_field();
    }

    /**
     * 获取服务项的课程ID集
     * @param $crid
     * @param $pid
     * @param null $sid
     * @param int $page
     * @param int $pagesize
     * @param @sid_range 分类ID有效集
     * @return bool
     */
    public function getFolderidArr($crid, $pid, $sid = null, $page = 1, $pagesize = 20, $sid_range = null) {
        $page = max(1, intval($page));
        $pagesize = max(1, intval($pagesize));
        $offset = ($page - 1) * $pagesize;
        if ($pid == 0) {
            $sql = "SELECT `a`.`folderid` FROM `ebh_pay_items` `a` 
                JOIN `ebh_folders` `b` ON `a`.`folderid`=`b`.`folderid` 
                WHERE `a`.`crid`=$crid AND `b`.`crid`=$crid AND `a`.`status`=0 
                ORDER BY `b`.`displayorder` ASC,`a`.`itemid` DESC LIMIT $offset,$pagesize";
            return $this->db->query($sql)->list_field();
        }
        if ($sid === null) {
            $crid = (int) $crid;
            $pid = (int) $pid;
            if ($crid < 1 || $pid < 1) {
                return false;
            }
            if (!empty($sid_range) && is_array($sid_range)) {
                $sid_range[] = 0;
                $sid_arr = implode(',', $sid_range);
            }
            $where_arr[] = "`a`.`pid`=$pid";
            $where_arr[] = "`a`.`crid`=$crid";
            $where_arr[] = "`b`.`crid`=$crid";
            if (!empty($sid_arr)) {
                $where_arr[] = "`a`.`sid` IN($sid_arr)";
            }
            $where_arr[] = "`a`.`status`=0";
            $where_arr_str = implode(' AND ', $where_arr);
            $sql = "SELECT `a`.`folderid` FROM `ebh_pay_items` `a` 
                    JOIN `ebh_folders` `b` ON `a`.`folderid`=`b`.`folderid` 
                    WHERE $where_arr_str
                    ORDER BY `b`.`displayorder` ASC,`a`.`itemid` LIMIT $offset,$pagesize";
            return $this->db->query($sql)->list_field();
        }
        $crid = (int) $crid;
        $pid = (int) $pid;
        $sid = (int) $sid;
        if ($crid < 1 || $pid < 1 || $sid < 0) {
            return false;
        }
        if ($sid > 0 && !empty($sid_range) && is_array($sid_range) && !in_array($sid, $sid_range)) {
            return false;
        }
        $sql = "SELECT `a`.`folderid` FROM `ebh_pay_items` `a` 
                JOIN `ebh_folders` `b` ON `a`.`folderid`=`b`.`folderid` 
                WHERE `a`.`pid`=$pid AND `a`.`sid`=$sid AND `a`.`crid`=$crid AND `b`.`crid`=$crid AND `a`.`status`=0 
                ORDER BY `b`.`displayorder` ASC,`a`.`itemid` DESC LIMIT $offset,$pagesize";
        return $this->db->query($sql)->list_field();

    }

    /**
     * 获取有未分类服务项的服务包ID集
     * @param $crid
     * @param limit
     * @return bool
     */
    public function getNoSortItemIdArr($crid, $limit = 1000) {
        $crid = (int) $crid;
        if ($crid < 1) {
            return false;
        }
        if (is_array($limit)) {
            $page = !empty($limit['page']) ? intval($limit['page']) : 1;
            $page = max(1, $page);
            $pagesize = !empty($limit['pagesize']) ? intval($limit['pagesize']) : 20;
            $pagesize = max(1, $pagesize);
            $offset = ($page - 1) * $pagesize;
            $sql = "SELECT `a`.`pid`,'未分类' AS `sname`,`a`.`sid`,COUNT(1) AS `itemcount` FROM `ebh_pay_items` `a` 
                    JOIN `ebh_folders` `b` ON `a`.`folderid`=`b`.`folderid`
                    WHERE `a`.`crid`=$crid AND `a`.`sid`=0 AND `a`.`status`=0 GROUP BY `pid` LIMIT $offset,$pagesize";
            return $this->db->query($sql)->list_array();
        }
        $limit = (int) $limit;
        $limit = max(1, $limit);
        $sql = "SELECT `a`.`pid`,'未分类' AS `sname`,`a`.`sid`,COUNT(1) AS `itemcount` FROM `ebh_pay_items` `a` 
                JOIN `ebh_folders` `b` ON `a`.`folderid`=`b`.`folderid`
                WHERE `a`.`crid`=$crid AND `a`.`sid`=0 AND `a`.`status`=0 GROUP BY `pid`,`sid` LIMIT $limit";
        return $this->db->query($sql)->list_array();
    }
	
	/*
	获取本校的课程关联的最后一个服务项信息
	*/
	public function getLastItemByFolderid($folderid,$crid){
		$sql = 'select i.itemid,i.iname,i.iprice,i.pid,i.sid,i.imonth,i.iday,i.isummary,i.view_mode,i.comfee,i.roomfee from ebh_pay_items i join ebh_pay_packages p on i.pid=p.pid left join ebh_pay_sorts s on i.sid=s.sid';
		$wherearr[]= 'i.folderid='.$folderid;
		$wherearr[]= 'i.crid='.$crid;
		$wherearr[]= 'i.status=0';
		$wherearr[]= 'p.status=1';
		$wherearr[] = 'ifnull(s.showbysort,0)=0';
        $wherearr[] = 'ifnull(s.ishide,0)=0';
		$sql.= ' where '.implode(' AND ',$wherearr);
		$sql.= ' order by itemid desc limit 1';
		return $this->db->query($sql)->row_array();
	}

    /**
     * 判断课程是否存在零售的服务项
     * @param $folderid
     * @param $crid
     * @return bool|int
     */
	public function isSingleExists($folderid, $crid) {
        $folderid = (int) $folderid;
        $crid = (int) $crid;
        if ($folderid < 1 || $crid < 1) {
            return false;
        }
        $sql = "SELECT `a`.`itemid` FROM `ebh_pay_items` `a` LEFT JOIN `ebh_pay_sorts` `b` ON `a`.`sid`=`b`.`sid` 
                WHERE `a`.`crid`=$crid AND `a`.`folderid`=$folderid AND `a`.`status`=0 AND IFNULL(`b`.`showbysort`,0)=0";
        $ret = $this->db->query($sql)->row_array();
        if (!empty($ret['itemid'])) {
            return $ret['itemid'];
        }
        return 0;
    }
	
	/**
     * 根据itemid字符串组获取课程信息
     * @param string $itemids
     * @return array 
     */
	public function getFolderListByItemids($itemids,$crid=0){
		if(empty($itemids))
			return array();
		$sql = 'select i.itemid,i.folderid,i.iname,f.img,f.del,i.isummary summary 
				from ebh_folders f 
				join ebh_pay_items i on f.folderid=i.folderid';
		$sql.= ' where itemid in ('.$itemids.') ';
		if(!empty($crid)){
			$sql.= ' and f.crid='.$crid;
		}
		return $this->db->query($sql)->list_array('itemid');
	}

    /**
     * 分类下课程列表
     * @param int $sid 分类ID
     * @param int $crid 网校ID
     * @return mixed
     */
    public function getSortCourseList($sid, $crid = 0) {
        $wheres = array(
            '`a`.`sid`='.$sid,
            '`a`.`status`=0',
            '`b`.`del`=0',
            '`b`.`folderlevel`=2',
            '`b`.`power`=0'
        );
        if ($crid > 0) {
            $wheres[] = '`a`.`crid`='.$crid;
        }
        $sql = 'SELECT `a`.`itemid`,`a`.`iname`,`a`.`iprice`,`a`.`folderid`,`b`.`isschoolfree`,`b`.`img`,`b`.`showmode` 
                FROM `ebh_pay_items` `a` JOIN `ebh_folders` `b` ON `b`.`folderid`=`a`.`folderid` 
                WHERE '.implode(' AND ', $wheres);
        return $this->db->query($sql)->list_array('itemid');
    }
}