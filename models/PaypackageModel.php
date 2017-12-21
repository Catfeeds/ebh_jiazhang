<?php
/*
服务包
*/
class PaypackageModel extends CModel{
	/**
	*获取服务包列表
	*/
	public function getsplist($param){
		$sql = 'select p.pid,p.pname,p.dateline,p.summary,p.displayorder,p.status,cr.crid,cr.crname,cr.profitratio from ebh_pay_packages p join ebh_classrooms cr on cr.crid=p.crid ';
		$wherearr = array();
		if(!empty($param['crid'])) {	//所属crid
			$wherearr[] = 'p.crid='.$param['crid'];
		}
		if(!empty($param['q'])){
			$q = $this->db->escape_str($param['q']);
			$wherearr[] = '(cr.crname like \'%'.$q.'%\' or p.pname like \'%'.$q.'%\' )';
		}
		if(!empty($param['tid'])) {	//所属crid
			$wherearr[] = 'p.tid='.$param['tid'];
		}
		if(isset($param['status'])){
			$wherearr[] = 'p.status='.$param['status'];
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
	*获取服务包count
	*/
	public function getspcount($param){
		$count = 0;
		$sql = 'select count(*) count from ebh_pay_packages p join ebh_classrooms cr on cr.crid=p.crid';
		$wherearr = array();
		if(!empty($param['crid'])) {	//所属crid
			$wherearr[] = 'p.crid='.$param['crid'];
		}
		if(!empty($param['q'])){
			$q = $this->db->escape_str($param['q']);
			$wherearr[] = '(cr.crname like \'%'.$q.'%\' or p.pname like \'%'.$q.'%\' )';
		}
		if(!empty($param['tid'])) {	//所属crid
			$wherearr[] = 'p.tid='.$param['tid'];
		}
		if(!empty($wherearr)) {
			$sql .= ' WHERE ' . implode(' AND ', $wherearr);
		}
		$res = $this->db->query($sql)->row_array();
		if(!empty($res))
			$count = $res['count'];
		return $count;
	}
	
	public function add($param){
		$sparr['pname'] = $param['pname'];
		$sparr['crid'] = $param['crid'];
		$sparr['summary'] = $param['summary'];
		$sparr['tid'] = $param['tid'];
		$sparr['uid'] = $param['uid'];
		$sparr['displayorder'] = $param['displayorder'];
		$sparr['dateline'] = SYSTIME;
		$sparr['limitdate'] = $param['limitdate'];
		return $this->db->insert('ebh_pay_packages',$sparr);
	}
	public function edit($param){
		if(empty($param['pid']))
			exit;
		if(!empty($param['pname']))
			$sparr['pname'] = $param['pname'];
		if(!empty($param['crid']))
			$sparr['crid'] = $param['crid'];
		if(!empty($param['summary']))
			$sparr['summary'] = $param['summary'];
		if(isset($param['tid']))
			$sparr['tid'] = $param['tid'];
		if(!empty($param['displayorder']))
			$sparr['displayorder'] = $param['displayorder'];
		if(isset($param['status']))
			$sparr['status'] = $param['status'];
		if(isset($param['limitdate']))
			$sparr['limitdate'] = $param['limitdate'];
		return $this->db->update('ebh_pay_packages',$sparr,'pid='.$param['pid']);
	}
	/**
	*根据itemid获取服务明细项详情
	*/
	public function getPackByPid($pid) {
		$sql = "select p.pid,p.pname,p.summary,p.crid,cr.crname,p.displayorder,t.tname,t.tid,p.limitdate from ebh_pay_packages p join ebh_classrooms cr on p.crid=cr.crid left join ebh_pay_terms t on t.tid=p.tid where pid=".$pid;
		return $this->db->query($sql)->row_array();
	}
	public function deletepack($pid){
		return $this->db->delete('ebh_pay_packages','pid='.$pid);
	}
	
	/*
	学校的服务项列表,为组成服务包-课程对应关系
	*/
	public function getPackageFolders($param){
		$sql = 'select i.folderid,p.pid,p.pname from ebh_pay_packages p join ebh_pay_items i on p.pid=i.pid';
		$wherearr = array();
		if(!empty($param['crid'])) {
			$wherearr[] = 'i.crid='.$param['crid'];
		}
		if(!empty($wherearr)) {
			$sql .= ' WHERE ' . implode(' AND ', $wherearr);
		}
		$sql.= ' order by p.displayorder asc,p.pid desc';
		return $this->db->query($sql)->list_array();
	}
	
	/*
	最早的
	*/
	public function getFirstLimitDate($param){
		$sql = 'select if(min(limitdate)>0,min(limitdate),0) firstday,i.folderid 
		from ebh_userpermisions u
		join ebh_pay_items i on u.itemid=i.itemid
		join ebh_pay_packages p on i.pid=p.pid
		';
		$wherearr = array();
		if(!empty($param['folderid'])) {
			$wherearr[] = 'i.folderid='.$param['folderid'];
			$arraytype = 'row_array';
		}
		if(!empty($param['crid'])){
			$wherearr[] = 'p.crid='.$param['crid'];
			$arraytype = 'list_array';
		}
		$wherearr[] = 'u.uid='.$param['uid'];
		if(!empty($wherearr)) {
			$sql .= ' WHERE ' . implode(' AND ', $wherearr);
		}
		$sql .= ' group by i.folderid';
		$result = $this->db->query($sql)->$arraytype();
		return $result;
	}
	
	/*
	按folderid获取服务包
	*/
	public function getPackByFolderid($param){
		$sql = 'select p.pid,p.pname,i.folderid,f.folderid,f.foldername,f.coursewarenum,f.img from ebh_pay_items i 
				join ebh_pay_packages p on i.pid = p.pid
				join ebh_folders f on i.folderid = f.folderid
				where i.folderid in ('.$param['folderids'].')
				order by p.displayorder asc ,p.pid desc';
		return $this->db->query($sql)->list_array();
		
	}
}
?>
