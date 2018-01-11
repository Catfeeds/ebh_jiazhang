<?php
/*
用户权限,用于服务包
*/
class UserpermissionModel extends CModel{
	/**
	*根据订单明细内容生成订单信息
	*/
	public function addPermission($param = array()) {
		if(empty($param))
			return FALSE;
		$setarr = array();
		if(!empty($param['itemid']))
			$setarr['itemid'] = $param['itemid'];
		if(!empty($param['type']))
			$setarr['type'] = $param['type'];
		if(!empty($param['powerid']))
			$setarr['powerid'] = $param['powerid'];
		if(!empty($param['uid']))
			$setarr['uid'] = $param['uid'];
		if(!empty($param['crid']))
			$setarr['crid'] = $param['crid'];
		if(!empty($param['folderid']))
			$setarr['folderid'] = $param['folderid'];
		if(!empty($param['cwid']))
			$setarr['cwid'] = $param['cwid'];
		if(!empty($param['startdate']))
			$setarr['startdate'] = $param['startdate'];
		if(!empty($param['enddate']))
			$setarr['enddate'] = $param['enddate'];
		if(!empty($param['dateline']))
			$setarr['dateline'] = $param['dateline'];
		else 
			$setarr['dateline'] = SYSTIME;
		$pid = $this->db->insert('ebh_userpermisions',$setarr);
		return $pid;
	}

	/**
	*更新订单信息，如果包含明细，则同时更新明细信息
	*/
	public function updatePermission($param = array()) {
		if(empty($param) || empty($param['pid']))
			return FALSE;
		$setarr = array();
		$wherearr = array('pid'=>$param['pid']);
		if(!empty($param['itemid']))
			$setarr['itemid'] = $param['itemid'];
		if(!empty($param['type']))
			$setarr['type'] = $param['type'];
		if(!empty($param['powerid']))
			$setarr['powerid'] = $param['powerid'];
		if(!empty($param['uid']))
			$setarr['uid'] = $param['uid'];
		if(!empty($param['crid']))
			$setarr['crid'] = $param['crid'];
		if(!empty($param['folderid']) && empty($param['cwid'])){ //课程开通,排除课件的
			$setarr['folderid'] = $param['folderid'];
			$setarr['cwid'] = 0;
		}
		if(!empty($param['cwid']))
			$setarr['cwid'] = $param['cwid'];
		if(!empty($param['startdate']))
			$setarr['startdate'] = $param['startdate'];
		if(!empty($param['enddate']))
			$setarr['enddate'] = $param['enddate'];
		$afrows = $this->db->update('ebh_userpermisions',$setarr,$wherearr);
		return $afrows;
	}
	/**
	*获取权限列表
	*/
	public function getPermissionList($param = array()) {
		if(empty($param))
			return FALSE;
		$sql = 'select p.pid,p.itemid,p.type,p.powerid,p.uid,p.crid,p.folderid,p.cwid,p.startdate,p.enddate,p.dateline from ebh_userpermisions p';
		$wherearr = array();
		if(!empty($param['itemid'])) {
			$wherearr[] = 'p.itemid='.$param['itemid'];
		}
		if(!empty($param['type'])) {
			$wherearr[] = 'p.type='.$param['type'];
		}
		if(!empty($param['powerid'])) {
			$wherearr[] = 'p.powerid='.$param['powerid'];
		}
		if(!empty($param['uid'])) {
			$wherearr[] = 'p.uid='.$param['uid'];
		}
		if(!empty($param['crid'])) {
			$wherearr[] = 'p.crid='.$param['crid'];
		}
		if(!empty($param['folderid'])) {
			$wherearr[] = 'p.folderid='.$param['folderid'];
		}
		if(!empty($param['cwid'])) {
			$wherearr[] = 'p.cwid='.$param['cwid'];
		}
		if(empty($wherearr))
			return FALSE;
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
	*根据用户编号和itemid编号获取权限
	*/
	public function getPermissionByItemId($itemid,$uid) {
		$sql = "select p.pid,p.itemid,p.type,p.powerid,p.uid,p.crid,p.folderid,p.cwid,p.startdate,p.enddate,p.dateline from ebh_userpermisions p where p.itemid=$itemid and p.uid = $uid";
		return $this->db->query($sql)->row_array();
	}
	/**
	*根据用户编号和folderid编号获取权限
	*/
	public function getPermissionByFolderId($folderid,$uid,$crid=0) {
		$sql = "select p.pid,p.itemid,p.type,p.powerid,p.uid,p.crid,p.folderid,p.cwid,p.startdate,p.enddate,p.dateline,c.domain from ebh_userpermisions p left join `ebh_classrooms` c on (p.crid = c.crid ) where p.folderid=$folderid and p.itemid<>0 and p.cwid=0 and p.uid = $uid";
		if(!empty($crid)){
			$sql.= ' and p.crid='.$crid;
		}
		return $this->db->query($sql)->row_array();
	}

	/**
	*根据用户编号和cwid编号获取权限(单课收费)
	*/
	public function getPermissionByCwId($cwid,$uid){
		$sql = "select p.pid,p.itemid,p.type,p.powerid,p.uid,p.crid,p.folderid,p.cwid,p.startdate,p.enddate,p.dateline from ebh_userpermisions p where p.cwid=$cwid and p.uid = $uid";
		return $this->db->query($sql)->row_array();
	}
	public function getPermissionDomainByFolderId($folderid,$uid){
		$sql ='select p.enddate,f.crid from `ebh_userpermisions` p left join `ebh_folders` f on (p.folderid = f.folderid) where p.folderid ='.$folderid.' and p.itemid<>0 and p.cwid=0 and p.uid='.$uid;
		return $this->db->query($sql)->row_array();
	}
	/**
	*判断用户是否有平台权限
	* @return int 返回验证结果，1表示有权限 2表示已过期 0表示用户已停用 -1表示无权限 -2参数非法
	*/
	public function checkUserPermision($uid,$param = array()) {
		if(empty($param['powerid']) && empty($param['crid']) && empty($param['folderid'])) 
			return -2;
		$flag = 0;	//默认平台权限
		if(!empty($param['powerid']))	//powerid功能点权限
			$flag = 1;
		else if(!empty($param['folderid']))	//课程权限
			$flag = 2;
		if($flag == 1) {
			$sql = 'select p.startdate,p.enddate from ebh_userpermisions p where p.uid = '.$uid.' and p.powerid='.$param['powerid']; 
		} else if($flag == 2) {
			$sql = 'select p.startdate,max(p.enddate) enddate from ebh_userpermisions p where p.uid = '.$uid.' and p.crid='.$param['crid'];
			if(!empty($param['cwid']))
				$sql .= ' and (p.folderid='.$param['folderid'].' and p.cwid=0 or p.cwid='.$param['cwid'].')';
			else
				$sql .= ' and p.folderid='.$param['folderid'];
		} else {
			$sql = 'select p.startdate,p.enddate from ebh_userpermisions p where p.uid = '.$uid.' and p.crid='.$param['crid'].' and p.folderid=0'; 
		}
		$peritem = $this->db->query($sql)->row_array();
		if(empty($peritem) || $peritem['enddate'] == NULL) {	//无权限		
			return -1;
		}

		if (!empty($peritem['enddate']) && $peritem['enddate'] < (EBH_BEGIN_TIME - 86400))
            return 2;
		return 1;
	}
	/**
	*根据功能点或者平台等信息获取支付服务项
	*@param array $param
	*/
	public function getUserPayItem($param = array()) {
		if(empty($param['powerid']) && empty($param['crid']) && empty($param['folderid'])) 
			return FALSE;
		$flag = 0;	//默认平台权限
		if(!empty($param['powerid']))	//powerid功能点权限
			$flag = 1;
		else if(!empty($param['folderid']))	//课程权限
			$flag = 2;
		if($flag == 2) {
			$sql = 'select i.itemid,i.pid,i.iname,i.isummary,i.crid,i.folderid,i.iprice,i.imonth,i.iday,i.ptype from ebh_pay_items i join ebh_pay_packages p on i.pid=p.pid left join ebh_pay_sorts s on i.sid=s.sid where i.folderid='.intval($param['folderid']).' and ifnull(s.showbysort,0)=0 and ifnull(s.ishide,0)=0 and p.status=1';
		}  else {
			$sql = 'select i.itemid,i.pid,i.iname,i.isummary,i.crid,i.folderid,i.iprice,i.imonth,i.iday,i.ptype from ebh_pay_items i join ebh_pay_packages p on i.pid=p.pid left join ebh_pay_sorts s on i.sid=s.sid where i.crid='.intval($param['crid']).' and ifnull(s.showbysort,0)=0 and ifnull(s.ishide,0)=0 and p.status=1';
		}
		if(!empty($param['itemid'])) {
			$sql .= ' and i.itemid='.intval($param['itemid']);
		}
		$sql .= ' and i.status=0 order by i.itemid desc';
		$payitem = $this->db->query($sql)->row_array();
		return $payitem;
	}

    /**
     * 获取用户已开通的课程
     * @param array $param 查询参数
     * @param bool $setKey 是否以课程ID做为结果数组的键
     * @return bool
     */
	public function getUserPayFolderList($param = array(), $setKey = false) {
		if(empty($param['uid']))
			return FALSE;
		$sql = "select p.pid,p.itemid,p.crid,p.folderid from ebh_userpermisions p";
		$wherearr = array();
		$wherearr[] = 'p.uid='.$param['uid'];
		if(!empty($param['crid'])) {
			$wherearr[] = 'p.crid='.$param['crid'];
		}
		if(!empty($param['filterdate'])) {	//过滤已过期
			$enddate = SYSTIME - 86400;
			$wherearr[] = 'p.enddate>'.$enddate;
		}
		if(!empty($param['folderid'])){
		    if (!is_array($param['folderid'])) {
                $wherearr[] = 'p.folderid='.$param['folderid'];
            } else {
		        $wherearr[] = 'p.folderid in('.implode(',', $param['folderid']).')';
            }
		}
		$wherearr[] = 'p.cwid=0';
		$wherearr[] = 'p.itemid<>0';
		$sql .= ' WHERE '.implode(' AND ',$wherearr);
		return $this->db->query($sql)->list_array($setKey ? 'folderid' : '');
	}
	/**
	*获取用户已开通的课件
	*/
	public function getUserPayCwList($param){
		if(empty($param['uid']))
			return FALSE;
		$sql = "select p.pid,p.cwid,p.crid,p.folderid from ebh_userpermisions p join ebh_roomcourses rc on p.cwid=rc.cwid";
		$wherearr = array();
		$wherearr[] = 'p.uid='.$param['uid'];
		if(!empty($param['crid'])) {
			$wherearr[] = 'p.crid='.$param['crid'];
		}
		if(!empty($param['filterdate'])) {	//过滤已过期
			$enddate = SYSTIME - 86400;
			$wherearr[] = 'p.enddate>'.$enddate;
		}
		if(!empty($param['folderid'])){
			$wherearr[] = 'p.folderid='.$param['folderid'];
		}
		if(!empty($param['cwids'])){
			$wherearr[] = 'p.cwid in('.$param['cwids'].')';
		}
		$wherearr[] = 'p.cwid<>0';
		$sql .= ' WHERE '.implode(' AND ',$wherearr);
		return $this->db->query($sql)->list_array();
	}
	/**
	*获取学校下所有的服务项
	*/
	public function getPayItemByCrid($crid,$ignorePrice=0) {
		if ($ignorePrice) {
			$sql = "select i.itemid,i.pid,i.crid,i.folderid,i.iname from ebh_pay_items i where i.crid=$crid";
		} else {
			$sql = "select i.itemid,i.pid,i.crid,i.folderid,i.iname from ebh_pay_items i where i.crid=$crid and iprice>0";
		}
		
		return $this->db->query($sql)->list_array();
	}
	/**
	*获取学校下所有的服务项及相关课程
	*/
	public function getPayItemByCridWithFolder($crid) {
		$sql = "select i.itemid,i.pid,i.crid,i.folderid,i.iname,f.fprice,f.foldername,p.pname,f.coursewarenum,f.img from ebh_pay_items i 
		join ebh_pay_packages p on i.pid=p.pid join ebh_folders f on i.folderid=f.folderid
		where i.crid=$crid order by p.displayorder desc";
		return $this->db->query($sql)->list_array();
	}
	/**
	*根据课程编号获取已开通此课程的用户id列表
	*/
	public function getUserIdListByFolder($folderid,$isDistinctUid=FALSE) {
		if(empty($folderid))
			return FALSE;
		if ($isDistinctUid) {
			$uidsql = 'select distinct uid from ebh_userpermisions up where up.folderid='.$folderid;
		} else {
			$uidsql = 'select uid from ebh_userpermisions up where up.folderid='.$folderid;
		}
		$uidsql .= ' and up.cwid=0 ';
		$uidlist = $this->db->query($uidsql)->list_array();
		return $uidlist;
	}
	/**
	*根据课程编号获取已开通此课程的用户id列表
	*/
	public function getUserIdListByFolderarr($folderid) {
		if(empty($folderid))
			return FALSE;
		$uidsql = 'select uid from ebh_userpermisions up where up.folderid in('.$folderid.')';
		$uidsql .= ' and up.cwid=0 and up.itemid<>0';
		$uidlist = $this->db->query($uidsql)->list_array();
		return $uidlist;
	}
	/**
	*根据平台编号和课程编号以及已开通权限的uid组合获取班级用户列表
	*/
	public function getUserAndClassListByUidStr($crid,$folderid,$uidstr,$q) {
		if(empty($crid) || empty($folderid) || empty($uidstr))
			return FALSE;
		//获取用户列表
		$usersql = 'select u.uid,u.username,u.realname,u.sex,u.face,u.groupid from ebh_users u where u.uid in ('.$uidstr.')';
		if(!empty($q)){
			$q = $this->db->escape_str($q);
			$usersql.= ' and (u.realname like \'%'.$q.'%\' or u.username like \'%'.$q.'%\')';
        }
		$userlist = $this->db->query($usersql)->list_array();
		if(empty($userlist))
			return FALSE;
		$myuserlist = array();
		foreach($userlist as $myuser) {
			$myuserlist[$myuser['uid']] = $myuser;
		}

		//获取用户对应班级信息
		$classusersql = 'select cs.uid,c.classid,c.classname,c.grade from ebh_classstudents cs join ebh_classes c on (cs.classid=c.classid) where cs.uid in ('.$uidstr.') and c.crid='.$crid ;

        $classusersql.= ' order by c.classid,cs.uid';
		$classrows = $this->db->query($classusersql)->list_array();
		$mylist = array();
		foreach($classrows as $classrow) {
			if(isset($myuserlist[$classrow['uid']])) {
				$userrow = $myuserlist[$classrow['uid']];
				$userrow['classid'] = $classrow['classid'];
				$userrow['classname'] = $classrow['classname'];
				$userrow['grade'] = $classrow['grade'];
				$mylist[$classrow['uid']] = $userrow;
			}
		}	
		return $mylist;
	}
	/**
	 * [checkStudentBestPermission 通过itemid和uid读取登录用户是否有该精品课的权限]
	 * @param  [type] $itemid [description]
	 * @param  [type] $uid    [description]
	 * @return [type]         [description]
	 */
	public function checkStudentBestPermission($itemid,$uid){
		$sql = 'select itemid,uid,startdate,enddate from `ebh_userpermisions` where itemid='.$itemid.' and uid='.$uid;
		return $this->db->query($sql)->list_array();
	}
	
	/**
	 * 移除学生用户权限
	 */
	public function removeStudentPermission($folderids = array(),$uids,$type = 0,$classid = 0){	
		if(empty($uids)){
			return false;
		}
		$where = " uid in ( ".implode(',',$uids)." )";
		if(!empty($folderids)){
			$where .= " and folderid in (".implode(',',$folderids)." ) and cwid=0";
		}
		if(!empty($type)){
			$where .= " and type = ".$type;
		}
		if(!empty($classid)){
			$where .= " and classid = ".$classid;
		}
		return $this->db->delete('ebh_userpermisions',$where);					
	}
	
	/**
	 * 获取已添加过的课程权限
	 */
	public function permissionAdded($param){
		if(empty($param['uids'])){
			return array();
		}
		$where = array();
		$sql = "select uid, folderid from ebh_userpermisions";
		if(!empty($param['uidstr'])){
			$where[] = " uid in (".$param['uidstr'].")";
		}
		if(!empty($param['fidstr'])){
			$where[] = " folderid in (".$param['fidstr'].")";	
		}
		if(!empty($param['type'])){
			$where[] = " type = ".$param['type'];
		}
		if(!empty($param['classid'])){
			$where[] = " classid = ".$param['classid'];
		}
		$where[] = ' cwid=0';
		$where[] = ' itemid<>0';
		if(!empty($where)){
			$sql .= "  where ".implode(" and  ",$where);
		}
		$list = $this->db->query($sql)->list_array();
		if(!empty($list)){
			foreach ($list as $item){
				$rarr[$item['uid']] = $item['folderid'];	
			}
		}
		return isset($rarr) ? $rarr : array();
	}
	/**
	 * 批量插入到权限表(多个用户)
	 */
	public function mutiAddPermission($param){
		if(empty($param['uids']) || empty($param['folderid']) || empty($param['type']) || empty($param['crid'])){
			return false;
		}
		$sql = "insert into ebh_userpermisions (itemid,uid,type,crid,folderid,dateline,classid) values ";
		foreach ($param['uids'] as $uid){
			$sql .= "(".$param['itemid'].",".$uid.",".$param['type'].",".$param['crid'].",".$param['folderid'].",".$param['dateline'].",".$param['classid']."),";	
		}
		$sql = rtrim($sql,',');
		return $this->db->query($sql,false);
	}
	/**
	 * 批量插入至权限表(多个课程)
	 */
	public function mutifAddPermission($param){
		if(empty($param['uid']) || empty($param['folderids']) || empty($param['type']) || empty($param['crid'])){
			return false;
		}
		if(!empty($param['property']) && $param['property'] == 3){
			$sql_f = 'select max(itemid) itemid,folderid from ebh_pay_items where folderid in('.implode(',',$param['folderids']).') group by folderid';
			$itemlist = $this->db->query($sql_f)->list_array('folderid');
			$startdate = SYSTIME;
			$enddate = 2147483647;
			$sql = "insert into ebh_userpermisions (itemid,uid,type,crid,folderid,dateline,classid,startdate,enddate) values ";
			foreach ($param['folderids'] as $folder){
				$itemid = empty($itemlist[$folder])?0:$itemlist[$folder]['itemid'];
				$sql .= "(".$itemid.",".$param['uid'].",".$param['type'].",".$param['crid'].",".$folder.",".$param['dateline'].",".$param['classid'].",".$startdate.",".$enddate."),";
			}

		} else {
			$sql = "insert into ebh_userpermisions (itemid,uid,type,crid,folderid,dateline,classid) values ";
			foreach ($param['folderids'] as $folder){
				$sql .= "(".$param['itemid'].",".$param['uid'].",".$param['type'].",".$param['crid'].",".$folder.",".$param['dateline'].",".$param['classid']."),";
			}
		}
		$sql = rtrim($sql,',');
		return $this->db->query($sql,false);
	}
	/**
	 * 批量导入权限表(多用户、多课程)
	 */
	public function mutiImportPermission($param){
		if(empty($param['uids']) || empty($param['folderids']) || empty($param['type']) || empty($param['crid'])){
			return false;
		}
		$sql = "insert into ebh_userpermisions (itemid,uid,type,crid,folderid,dateline,classid) values ";
		foreach ($param['folderids'] as $folder){
			foreach ($param['uids'] as $uid){
				$sql .= "(".$param['itemid'].",".$uid.",".$param['type'].",".$param['crid'].",".$folder.",".$param['dateline'].",".$param['classid']."),";
			}
		}
		$sql = rtrim($sql,',');
		return $this->db->query($sql,false);
	}

	/**
	*根据课程id编号，学校id获取已开通此课程的用户数量
	*/
	public function getUserCountByFolder($folderids,$classid=0) {
		if(empty($folderids))
			return FALSE;
		if ($classid) {
			if (is_array($classid)) {
            	$classids = array_map('intval', $classid);
	        } else {
	            $classids = array(intval($classid));
	        }
	        if (empty($classids)) {
	            return array();
	        }
	        $classids = implode(',', $classids);
			$sql = "select u.folderid,count(distinct u.uid) as count from ebh_userpermisions u left join ebh_classstudents c using(uid) where u.folderid in ($folderids) and u.cwid=0 and u.itemid > 0 and c.classid in ($classids) group by u.folderid";
		} else {
			$sql = "select folderid,count(distinct uid) count from ebh_userpermisions where folderid in($folderids) and cwid=0 and itemid > 0 group by 1";
		}
		$row = $this->db->query($sql)->list_array();
		return $row;
	}

	/**
	*根据课程id编号，学校id获取已开通此课程的用户数量
	*/
	public function getUserCountByFolderAndClass($folderids,$classes='') {
		if(empty($folderids) || empty($classes))
			return FALSE;
		$sql = "select c.classid,u.folderid,count(distinct u.uid) as count from ebh_userpermisions u left join ebh_classstudents c using(uid) where u.folderid in ($folderids) and u.cwid=0 and u.itemid > 0 and c.classid in ($classes) group by u.folderid,c.classid";
		$row = $this->db->query($sql)->list_array();
		return $row;
	}

	/**
	 * 根据uid和crid获取未过期权限的folderid
	 */
	public function getfolderListByUid($crid,$uid){
		if(empty($crid) || empty($uid)){
			return false;
		}
		$sql = 'select folderid from ebh_userpermisions where crid='.$crid.' and cwid=0 and uid='.$uid.' and enddate >'.SYSTIME;
		return $this->db->query($sql)->list_array();
	}
	/**
	*根据课程编号获取有课程权限的用户列表
	*/
	public function getFolderUserList($param = array()) {
		if (empty($param['folderid']) && empty($param['folderids'])) {
			return FALSE;
		}
		$sql = 'select up.folderid,up.uid,u.username,u.realname,u.sex,u.face from ebh_userpermisions up '.
			'join ebh_users u on (up.uid=u.uid) ';
		$wherearr = array();
		if (!empty($param['folderid']))	{//根据课程编号查询
			$wherearr[] = 'up.folderid='.$param['folderid'];
		}
		if (!empty($param['folderids'])) {	//根据课程的字符串组合查询如果 folderid1,folderid2 这种方式
			$wherearr[] = 'up.folderid in ('.$param['folderids'].')';
		}
		if (!empty($param['crid'])) {	//网校crid
			$wherearr[] = 'up.crid='.$param['crid'];
		}
		if (!empty($param['filteruser'])) {	//是否过滤uid，filteruser参数 以userid1,userid2,userid3方式组合
			$wherearr[] = 'up.uid not in ('.$param['filteruser'].')';
		}
		if (!empty($param['filterexpire'])) {	//是否对过期的权限进行过滤
			$wherearr[] = 'enddate>='.SYSTIME;
		}
		$wherearr[] = 'cwid=0';
		$wherearr[] = 'itemid<>0';
		$sql .= ' WHERE ' . implode(' AND ', $wherearr);
		$sql .= ' group by uid';
		if (!empty($param['limit'])) {
			$sql .= ' limit ' . $param['limit'];
		}
		return $this->db->query($sql)->list_array();
	}
	/**
	*根据课程编号获取有课程权限的用户列表数
	*/
	public function getFolderUserCount($param = array()) {
		if (empty($param['folderid']) && empty($param['folderids'])) {
			return 0;
		}
		$sql = 'select count(distinct(up.uid)) count from ebh_userpermisions up ';
		$wherearr = array();
		if (!empty($param['folderid']))	{//根据课程编号查询
			$wherearr[] = 'up.folderid='.$param['folderid'];
		}
		if (!empty($param['folderids'])) {	//根据课程的字符串组合查询如果 folderid1,folderid2 这种方式
			$wherearr[] = 'up.folderid in ('.$param['folderids'].')';
		}
		if (!empty($param['crid'])) {	//网校crid
			$wherearr[] = 'up.crid='.$param['crid'];
		}
		if (!empty($param['filteruser'])) {	//是否过滤uid，filteruser参数 以userid1,userid2,userid3方式组合
			$wherearr[] = 'up.uid not in ('.$param['filteruser'].')';
		}
		if (!empty($param['filterexpire'])) {	//是否对过期的权限进行过滤
			$wherearr[] = 'enddate>='.SYSTIME;
		}
		$wherearr[] = 'cwid=0';
		$wherearr[] = 'itemid<>0';
		$sql .= ' WHERE ' . implode(' AND ', $wherearr);
		$row = $this->db->query($sql)->row_array();
		if (empty($row))
			return 0;
		return $row['count'];
	}

    /**
     * 获取用户的有效期内的列表ID列表
     * @param $uid
     * @param $crid
     * @param $base_time
     * @param int $limit
     * @return bool
     */
	public function getUserValidFolderList($uid, $crid, $base_time, $limit = 3000) {
        $uid = (int) $uid;
        $crid = (int) $crid;
        $base_time = (int) $base_time;
        if ($uid < 1 || $crid < 1 || $base_time < 0) {
            return false;
        }
        if (is_array($limit)) {
            $page = isset($limit['page']) ? intval($limit['page']) : 1;
            $pagesize = isset($limit['pagesize']) ? intval($limit['pagesize']) : 20;
            $page = max(1, $page);
            $pagesize = max(1, $pagesize);
            $offset = ($page - 1) * $pagesize;
        } else {
            $pagesize = (int) $limit;
            $pagesize = max(1, $pagesize);
            $offset = 0;
        }
        $sql = "SELECT `itemid`,`folderid` FROM `ebh_userpermisions` WHERE 
                `uid`=$uid AND `crid`=$crid AND `enddate`>$base_time AND cwid=0 AND itemid<>0
                ORDER BY `pid` ASC LIMIT $offset,$pagesize";
        return $this->db->query($sql)->list_array('folderid');
    }
	
	/**
     * 判断用户是否有课件、课程权限
     * @param $uid
     * @param $crid
     * @param $cwid
     * @param $folderid
     * @return bool
     */
    public function isAllowed($uid, $crid, $cwid, $folderid) {
	    $uid = (int) $uid;
	    $crid = (int) $crid;
	    $cwid = (int) $cwid;
	    $folderid = (int) $folderid;
	    if ($uid < 1 || $crid < 1 || $cwid < 0 || $folderid < 0) {
	        return false;
        }
        $now = SYSTIME - 86400;
        if ($cwid > 0 && $folderid > 0) {
	        $sql = "SELECT 1 AS `a` FROM `ebh_userpermisions` 
                    WHERE `uid`=$uid AND `crid`=$crid AND `cwid`=$cwid AND `folderid`=$folderid AND `enddate`>=$now LIMIT 1";
	        $ret = $this->db->query($sql)->row_array();
	        if (!empty($ret)) {
	            return true;
            }
        }
        if ($folderid > 0) {
            $sql = "SELECT 1 AS `a` FROM `ebh_userpermisions` 
                    WHERE `uid`=$uid AND `crid`=$crid AND `cwid`=0 AND `folderid`=$folderid AND `enddate`>=$now LIMIT 1";
            $ret = $this->db->query($sql)->row_array();
            if (!empty($ret)) {
                return true;
            }
            return false;
        }
        return false;
    }
	
	/**
	*根据用户编号和itemid编号获取权限
	*/
	public function getPermissionByItemIds($param) {
		if(empty($param['itemids']) || empty($param['uid']) || empty($param['crid'])){
			return array();
		}
		$sql = 'select pid,itemid,p.uid,p.crid,p.folderid,p.cwid,p.dateline from ebh_userpermisions p';
		
		$enddate = SYSTIME - 86400;
		$wherearr[] = 'p.enddate>'.$enddate;
		$wherearr[] = 'uid='.$param['uid'];
		$wherearr[] = 'crid='.$param['crid'];
		$wherearr[] = 'itemid in('.$param['itemids'].')';
		$sql.= ' where '.implode(' AND ',$wherearr);
		return $this->db->query($sql)->list_array('itemid');
	}

	/**
	*根据用户编号和folderid课程编号获取购买权限、有效期
	*/
	public function getFolderPermission($uid,$crid,$folderid){
		$sql = "select type,crid,startdate,enddate from ebh_userpermisions where uid = $uid and folderid = $folderid and crid = $crid ";
		return $this->db->query($sql)->row_array();
	}
}