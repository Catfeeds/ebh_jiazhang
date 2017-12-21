<?php
/**
 *sns基础信息类
 */
class SnsbaseModel extends CModel {
	var $snsdb = null;
	public function __construct(){
		parent::__construct();
		$snsdb = Ebh::app()->getOtherDb("snsdb");
		$this->snsdb = $snsdb;
	}
	/**
	 * 获取sns用户基础信息
	 * @param  integer $uid 用户编号
	 * @return array      用户基础信息
	 */
	public function getbaseinfo($uid) {
		if (empty($uid))
			return false;
		$sql = 'SELECT followsnum,fansnum FROM ebh_sns_baseinfos WHERE uid=' . intval($uid);
		$row = $this->snsdb->query($sql)->row_array();
		if (!empty($row))
			return $row;
		else
			return array('followsnum' => 0, 'fansnum' => 0);

	}
	//获取sns用户新鲜事总数
	public function getfeedscount($param){
		$sql = "select count(*) count from `ebh_sns_feeds`";
		if(!empty($param['uid'])){
			$wherearr[] = 'fromuid = '.$param['uid'];
		}
		if(isset($param['status'])){
			$wherearr[] = 'status = '.$param['status'];
		}
		$sql .= ' WHERE '.implode(' AND ',$wherearr);
		$row = $this->snsdb->query($sql)->row_array();
		if(empty($row['count'])){
			$row['count'] = 0;
		}
		return $row['count'];
	}
	//获取sns用户日志总数
	public function getarticlescount($param){
		$sql = "select count(*) count from `ebh_sns_blogs`";
		if(!empty($param['uid'])){
			$wherearr[] = 'uid = '.$param['uid'];
		}
		if(isset($param['status'])){
			$wherearr[] = 'status = '.$param['status'];
		}
		$sql .= ' WHERE '.implode(' AND ',$wherearr);
		$row = $this->snsdb->query($sql)->row_array();
		if(empty($row['count'])){
			$row['count'] = 0;
		}
		return $row['count'];
	}
	//获取sns粉丝数
	public function getfanscount($param){
		$where = array();
		$sql = "select count(*) count from ebh_sns_follows ";
		if(!empty($param['fuid'])){
			$where[] = "fuid = {$param['fuid']}";
		}
		if(!empty($where)){
			$sql.= " WHERE ".implode(" AND ",  $where);
		}
		$row =  $this->snsdb->query($sql)->row_array();
		if(empty($row['count'])){
			$row['count'] = 0;
		}
		return $row['count'];
	}
	//获取sns关注数
	public function getfollowcount($param){
		$where = array();
		$sql = "select count(*) count from ebh_sns_follows ";
		if(!empty($param['uid'])){
			$where[] = "uid = {$param['uid']}";
		}
		if(!empty($where)){
			$sql.= " WHERE ".implode(" AND ",  $where);
		}
		$row =  $this->snsdb->query($sql)->row_array();
		if(empty($row['count'])){
			$row['count'] = 0;
		}
		return $row['count'];
	}
}