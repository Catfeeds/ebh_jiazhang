<?php
/*
服务包分类
*/
class PaysortModel extends CModel{
	/*
	分类列表
	*/
	public function getSortList($param){
		$sql = 'select s.sname,s.sid,s.sdisplayorder,s.showbysort,showaslongblock,ishide from ebh_pay_sorts s join ebh_pay_packages p on s.pid=p.pid';
		$wherearr = array();
		if(!empty($param['pid']))
			$wherearr[].='p.pid='.$param['pid'];
		if(!empty($wherearr))
			$sql.= ' where '.implode(' AND ',$wherearr);
		return $this->db->query($sql)->list_array();
	}
	/*
	分类数量
	*/
	public function getSortCount($param){
		$count = 0;
		$sql = 'select count(*) count from ebh_pay_sorts s join ebh_pay_packages p on s.pid=p.pid';
		$wherearr = array();
		if(!empty($param['pid']))
			$wherearr[].='p.pid='.$param['pid'];
		if(!empty($wherearr))
			$sql.= ' where '.implode(' AND ',$wherearr);
		$row = $this->db->query($sql)->row_array();
		if (!empty($row)){
			$count = $row['count'];
		}
		return $count;
	}
	public function add($param){
		if(empty($param['pid']))
			return false;
		$sarr['pid'] = $param['pid'];
		$sarr['sname'] = $param['sname'];
		if(!empty($param['content']))
			$sarr['content'] = $param['content'];
		if(isset($param['sdisplayorder']))
			$sarr['sdisplayorder'] = $param['sdisplayorder'];
		if(isset($param['showbysort']))
			$sarr['showbysort'] = $param['showbysort'];
		if(isset($param['showaslongblock']))
			$sarr['showaslongblock'] = $param['showaslongblock'];
		if(isset($param['image']['upfilepath']))
			$sarr['imgurl'] = $param['image']['upfilepath'];
		if(isset($param['image']['upfilename']))
			$sarr['imgname'] = $param['image']['upfilename'];
		if (isset($param['ishide'])) {
		    $sarr['ishide'] = intval($param['ishide']) == 1 ? 1 : 0;
        }
		return $this->db->insert('ebh_pay_sorts',$sarr);
	}
	
	public function edit($param){
		if(empty($param['pid']) || empty($param['sid']))
			return false;
		$sarr['sname'] = $param['sname'];
		if(isset($param['content']))
			$sarr['content'] = $param['content'];
		if(isset($param['sdisplayorder']))
			$sarr['sdisplayorder'] = $param['sdisplayorder'];
		if(isset($param['showbysort']))
			$sarr['showbysort'] = $param['showbysort'];
		if(isset($param['showaslongblock']))
			$sarr['showaslongblock'] = $param['showaslongblock'];
		if(isset($param['image']['upfilepath']))
			$sarr['imgurl'] = $param['image']['upfilepath'];
		if(isset($param['image']['upfilename']))
			$sarr['imgname'] = $param['image']['upfilename'];
		if (isset($param['ishide'])) {
		    $sarr['ishide'] = intval($param['ishide']) == 1 ? 1 : 0;
        }
		return $this->db->update('ebh_pay_sorts',$sarr,'sid='.$param['sid']);
		
	}
	
	/*
	分类详情
	*/
	public function getSortdetail($sid){
		$sql = 'select s.sname,s.sid,s.content,s.showbysort,s.imgurl,s.imgname,s.pid,s.ishide from ebh_pay_sorts s where sid ='.$sid;
		return $this->db->query($sql)->row_array();
	}
	
	/*
	是否有使用此分类的服务项
	*/
	public function getNotusedBySid($sid){
		$sql = 'select 1 from ebh_pay_items where sid='.$sid;
		$res = $this->db->query($sql)->row_array();
		return empty($res);
	}
	
	/*
	删除分类
	*/
	public function del($sid){
		return $this->db->delete('ebh_pay_sorts','sid='.$sid);
	}
	/*
	删除分类之后,将底下服务项的sid设为0
	*/
	public function setItemSidToZero($sid){
		$this->db->update('ebh_pay_items',array('sid'=>0),'sid='.$sid);
	}
    /**
     * 获取分类的打包数据
     * @param $sids
     * @return bool
     */
	public function getSortPackedList($sids) {
        if (!is_array($sids)) {
            return false;
        }
        $sids = array_filter($sids, function($sid) {
            return is_numeric($sid) && $sid > 0;
        });
        if (empty($sids)) {
            return false;
        }
        $sids_str = implode(',', $sids);
        $sql = "SELECT `sid`,`showbysort`,`sname`,`pid`,`sdisplayorder`,`imgurl`,`showaslongblock` FROM `ebh_pay_sorts` WHERE `sid` IN($sids_str)";
        return $this->db->query($sql)->list_array('sid');
    }
    /**
     * 获取打包服务项的总价格
     * @param $sids
     * @return bool
     */
    public function sortsCountPrice($sids) {
        if (empty($sids) || !is_array($sids)) {
            return false;
        }
        $sids = array_filter($sids, function($sid) {
           return is_numeric($sid) && $sid > 0;
        });
        if (empty($sids)) {
            return false;
        }
        $sids_str = implode(',', $sids);
        $sql = "SELECT `a`.`itemid`,`a`.`iprice`,`a`.`cannotpay`,`b`.`isschoolfree`,`a`.`sid`,`c`.`showbysort` FROM `ebh_pay_items` `a` 
                JOIN `ebh_folders` `b` ON `a`.`folderid`=`b`.`folderid` 
                JOIN `ebh_pay_sorts` `c` ON `a`.`sid`=`c`.`sid`
                WHERE `a`.`sid` IN($sids_str)";
        return $this->db->query($sql)->list_array();
    }
	
	/*
	根据服务包id集合获取分类
	*/
	public function getSortsByPids($param){
		if(empty($param['pids']))
			return array();
		$sql = 'select sid,sname,sdisplayorder,imgurl,pid,showbysort,(select count(*) from ebh_pay_items i where i.sid=s.sid) itemcount from ebh_pay_sorts s';
		$wherearr[] = 'pid in ('.$param['pids'].')';
		if(isset($param['showbysort']))
			$wherearr[] = 'showbysort='.$param['showbysort'];
		$sql .= ' where '.implode(' AND ',$wherearr);
		
		if(!empty($param['order']))
			$sql.= ' order by '.$param['order']; 
		return $this->db->query($sql)->list_array();
	}
	
	/*
	删除分类前，查看对应关系是否正确
	*/
	public function hasCheck($param){
		if(empty($param['crid']) || empty($param['pid']) || empty($param['sid']))
			return false;
		$sql = 'select p.pid from ebh_pay_packages p join ebh_pay_sorts s on p.pid=s.pid';
		$wherearr[]= 'p.crid='.$param['crid'];
		$wherearr[]= 'p.pid='.$param['pid'];
		$wherearr[]= 's.sid='.$param['sid'];
		$wherearr[]= 's.showbysort=0';
		$sql.= ' where '.implode(' AND ',$wherearr);
		$hassort = $this->db->query($sql)->row_array();
		return $hassort;
	}

    /**
     * 获取零散销售的分类ID集
     * @param $pid
     * @param int $limit
     * @return bool
     */
	public function getSigleSaleSortIds($pids, $limit = 3000) {
        if (empty($pids)) {
            return false;
        }
        if (!is_array($pids)) {
            $pids = array(intval($pids));
        }
        $pids_arr_str = implode(',', $pids);
        if (is_array($limit)) {
            $page = isset($limit['page']) ? intval($limit['page']) : 1;
            $pagesize = isset($limit['pagesize']) ? intval($limit['page']) : 20;
            $page = max(1, $page);
            $pagesize = max(1, $pagesize);
            $offset = ($page - 1) * $pagesize;
            return $this->db->query(
                "SELECT `sid` FROM `ebh_pay_sorts` WHERE `pid` IN($pids_arr_str) AND `showbysort`=0 ORDER BY `sid` LIMIT $offset,$pagesize")
                ->list_field();
        }
        $limit = (int) $limit;
        $limit = max(1, $limit);
        return $this->db->query(
            "SELECT `sid` FROM `ebh_pay_sorts` WHERE `pid` IN($pids_arr_str) AND `showbysort`=0 ORDER BY `sid` LIMIT $limit")
            ->list_field();
    }
	
	/*
	获取服务包下的分类最大的排序号
	*/
	public function getCurdisplayorder($param){
		$sql = 'select max(sdisplayorder) mdis from ebh_pay_sorts';
		$wherearr[] = 'pid='.$param['pid'];
		$sql.= ' where '.implode(' AND ',$wherearr);
		$res = $this->db->query($sql)->row_array();
		return $res['mdis'];
	}
    /**
     * 更新分类排序，非关键性操作，不启用事务
     * @param $sid
     * @param $pid
     * @param $is_increase 更改方式true:提高优先级，false:降低优先级
     * @return bool
     */
    public function changeOrder($sid, $pid, $is_increase) {
        $sid = (int) $sid;
        $pid = (int) $pid;
        if ($sid < 1 || $pid < 1) {
            return false;
        }
        $sql = "SELECT `sid`,`sdisplayorder` FROM `ebh_pay_sorts` WHERE `pid`=$pid ORDER BY `sdisplayorder` ASC,`sid` DESC";
        $sort_orders = $this->db->query($sql)->list_array();
        if (empty($sort_orders)) {
            return false;
        }
        $orders = array_column($sort_orders, 'sdisplayorder');
        $orders = array_unique($orders);
        //有相同的排序号，需要重置排序号
        $reset = count($sort_orders) > count($orders);
        if ($reset) {
            foreach ($sort_orders as $sk => $sort_order) {
                $sort_orders[$sk]['sdisplayorder'] = $sk + 1;
                if ($sort_order['sid'] == $sid) {
                    $sort_key = $sk;
                }
            }
        }
        if (!isset($sort_key)) {
            foreach ($sort_orders as $k => $sort_v) {
                if ($sort_v['sid'] == $sid) {
                    $sort_key = $k;
                    break;
                }
            }
        }
        if (!isset($sort_key)) {
            return false;
        }
        if ($is_increase && isset($sort_orders[$sort_key - 1])) {
            //提高优先级
            $ex_displayorder = $sort_orders[$sort_key - 1]['sdisplayorder'];
            $sort_orders[$sort_key - 1]['sdisplayorder'] = $sort_orders[$sort_key]['sdisplayorder'];
            $sort_orders[$sort_key]['sdisplayorder'] = $ex_displayorder;
            $change_key = $sort_key - 1;
        }
        if (!$is_increase && isset($sort_orders[$sort_key + 1])) {
            //降低优先级
            $ex_displayorder = $sort_orders[$sort_key + 1]['sdisplayorder'];
            $sort_orders[$sort_key + 1]['sdisplayorder'] = $sort_orders[$sort_key]['sdisplayorder'];
            $sort_orders[$sort_key]['sdisplayorder'] = $ex_displayorder;
            $change_key = $sort_key + 1;
        }
        if ($reset) {
            foreach ($sort_orders as $reset_item) {
                $this->db->update('ebh_pay_sorts', array(
                    'sdisplayorder' => $reset_item['sdisplayorder']
                ), "`sid`={$reset_item['sid']}");
            }
            return true;
        }
        if (isset($change_key)) {
            $this->db->update('ebh_pay_sorts', array(
                'sdisplayorder' => $sort_orders[$sort_key]['sdisplayorder']
            ), "`sid`={$sort_orders[$sort_key]['sid']}");
            $this->db->update('ebh_pay_sorts', array(
                'sdisplayorder' => $sort_orders[$change_key]['sdisplayorder']
            ), "`sid`={$sort_orders[$change_key]['sid']}");
            return true;
        }
        return false;
    }
	
	/*
	获取分类下item数量
	*/
	public function getItemCount($param){
		$sql = 'select count(*) count from ebh_pay_items';
		$wherearr[]= 'sid='.$param['sid'];
		$sql.= ' where '.implode(' AND ',$wherearr);
		$count = $this->db->query($sql)->row_array();
		return $count['count'];
	}
}