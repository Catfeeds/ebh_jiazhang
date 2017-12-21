<?php
	/**
	* 学习记录model对应的ebh_playlog表	
	* 学生每次播放课件完成后都会添加学习时间记录
	*/
	class PlaylogModel extends CModel{
		/**
		 * 根据参数获取对应的学习记录列表
		 * @param array $param
		 * @return array
		 */
		public function getList($param=array()){
			$sql = 'select p.logid,p.cwid,p.ctime,p.ltime,p.startdate,p.lastdate,c.title,c.cwurl,c.ism3u8,c.dateline,c.viewnum,c.reviewnum,c.summary,f.folderid,f.foldername,f.img,u.realname,u.sex,u.face from ebh_playlogs p '.
					'join ebh_coursewares c on (p.cwid = c.cwid) '.
					'join ebh_roomcourses rc on (rc.cwid = p.cwid) '.
					'join ebh_folders f on (f.folderid = rc.folderid)'.
					'join ebh_users u on (u.uid = c.uid)';
			$wherearr = array();
			if(!empty($param['uid']))
				$wherearr[] = 'p.uid='.$param['uid'];
			if(!empty($param['crid']))
				$wherearr[] = 'rc.crid='.$param['crid'];
			if(!empty($param['startDate']))
				$wherearr[] = 'p.lastdate>='.$param['startDate'];
			if(!empty($param['endDate']))
				$wherearr[] = 'p.lastdate<'.$param['endDate'];
			if(!empty($param['q'])){
				$wherearr[] = ' c.title like \'%'.$param['q'].'%\'';
			}
//			if(isset($param['totalflag'])){
//				$wherearr[] = 'p.totalflag in ('.$param['totalflag'].')';
//			}else{
				$wherearr[] = 'p.totalflag=1';
//			}
			if(!empty($param['folderid'])){
				$wherearr[] = 'rc.folderid = '.$param['folderid'];
			}
			if(!empty($wherearr)){
				$sql.=' WHERE '.implode(' AND ',$wherearr);
			}
//			$sql.=' group by c.cwid ';
			if(!empty($param['order'])){
				$sql.=' order by '.$param['order'];
			}else{
				$sql.=' order by f.folderid desc ';
			}
			if(!empty($param['limit'])){
				$sql.= ' limit '.$param['limit'];
			}else{
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
		*学习课件的次数
		*/
		public function getCwidCount($param){
			$count = 0;
			$sql = 'select count(1) count from ebh_playlogs p ';
			$wherearr = array();
		
			if(!empty($param['cwid'])){
				$wherearr[] = 'p.cwid = '.$param['cwid'];
			}
			if(isset($param['totalflag'])){
				$wherearr[] = 'p.totalflag in ('.$param['totalflag'].')';
			}else{
				$wherearr[] = 'p.totalflag=1';
			}
			if(!empty($wherearr)){
				$sql.=' WHERE '.implode(' AND ',$wherearr);
			}
			$row = $this->db->query($sql)->row_array();
			if(!empty($row))
				$count = $row['count'];
			return $count;
		}

		/**
		 * 根据参数获取对应的学习记录条数
		 * @param array $param
		 * @return int
		 */
		public function getListCount($param){
			$count = 0;
			$sql = 'select count(*) count from ( select p.logid from ebh_playlogs p '.
					'join ebh_coursewares c on (p.cwid = c.cwid) '.
					'join ebh_roomcourses rc on (rc.cwid = p.cwid) '.
					'join ebh_folders f on (f.folderid = rc.folderid)';
			$wherearr = array();
			if(!empty($param['uid']))
				$wherearr[] = 'p.uid='.$param['uid'];
			if(!empty($param['crid']))
				$wherearr[] = 'rc.crid='.$param['crid'];
			if(!empty($param['startDate']))
				$wherearr[] = 'p.lastdate>='.$param['startDate'];
			if(!empty($param['endDate']))
				$wherearr[] = 'p.lastdate<'.$param['endDate'];
			if(!empty($param['q'])){
				$wherearr[] = ' c.title like \'%'.$param['q'].'%\'';
			}
			if(isset($param['totalflag'])){
				$wherearr[] = 'p.totalflag in ('.$param['totalflag'].')';
			}else{
				$wherearr[] = 'p.totalflag=1';
			}
			if(!empty($param['folderid'])){
				$wherearr[] = 'rc.folderid = '.$param['folderid'];
			}
			if(!empty($wherearr)){
				$sql.=' WHERE '.implode(' AND ',$wherearr);
			}
			$sql.= ' group by c.cwid ) as demo';
			$row = $this->db->query($sql)->row_array();
			if(!empty($row))
				$count = $row['count'];
			return $count;
		}
		/**
		 * 根据教室编号和班级编号获取对应的学生学习记录列表
		 * @param array $param
		 * @return array
		 */
		public function getListByClassid($param=array()){
			$sql = 'select p.logid,p.cwid,p.ctime,p.ltime,p.startdate,p.lastdate,c.title,u.username,u.realname from ebh_playlogs p '.
					'join ebh_users u on (u.uid = p.uid) '.
					'join ebh_coursewares c on (p.cwid = c.cwid) '.
					'join ebh_roomcourses rc on (rc.cwid = p.cwid) '.
					'join ebh_classstudents cs on (cs.uid=p.uid) ';
			$wherearr = array();
			if(!empty($param['uid']))
				$wherearr[] = 'p.uid='.$param['uid'];
			if(!empty($param['classid']))
				$wherearr[] = 'cs.classid in ('.$param['classid'].')';
			if(!empty($param['crid']))
				$wherearr[] = 'rc.crid='.$param['crid'];
			if(!empty($param['startDate']))
				$wherearr[] = 'p.lastdate>='.$param['startDate'];
			if(!empty($param['endDate']))
				$wherearr[] = 'p.lastdate<'.$param['endDate'];
			if(!empty($param['q'])) {	//根据用户名/课件名称搜索
				$q = $this->db->escape_str($param['q']);
				$wherearr[] = '(u.username like \'%'.$q.'%\' OR u.realname like \'%'.$q.'%\' OR c.title like \'%'.$q.'%\')'; 
			}
			if(isset($param['totalflag'])){
				$wherearr[] = 'p.totalflag in ('.$param['totalflag'].')';
			}else{
				$wherearr[] = 'p.totalflag=1';
			}
			if(!empty($wherearr)){
				$sql.=' WHERE '.implode(' AND ',$wherearr);
			}
			if(!empty($param['order'])){
				$sql.=' order by '.$param['order'];
			}else{
				$sql.=' order by p.lastdate desc ';
			}
			if(!empty($param['limit'])){
				$sql.= ' limit '.$param['limit'];
			}else{
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
		 * 根据教室编号和班级编号获取对应的学生学习记录列表记录条数
		 * @param array $param
		 * @return int
		 */
		public function getListCountByClassid($param){
			$count = 0;
			$sql = 'select count(*) count from ebh_playlogs p '.
					'join ebh_users u on (u.uid = p.uid) '.
					'join ebh_coursewares c on (p.cwid = c.cwid) '.
					'join ebh_roomcourses rc on (rc.cwid = p.cwid) '.
					'join ebh_classstudents cs on (cs.uid=p.uid) ';
			$wherearr = array();
			if(!empty($param['uid']))
				$wherearr[] = 'p.uid='.$param['uid'];
			if(!empty($param['classid']))
				$wherearr[] = 'cs.classid in ('.$param['classid'].')';
			if(!empty($param['crid']))
				$wherearr[] = 'rc.crid='.$param['crid'];
			if(!empty($param['startDate']))
				$wherearr[] = 'p.lastdate>='.$param['startDate'];
			if(!empty($param['endDate']))
				$wherearr[] = 'p.lastdate<'.$param['endDate'];
			if(!empty($param['q'])) {	//根据用户名/课件名称搜索
				$q = $this->db->escape_str($param['q']);
				$wherearr[] = '(u.username like \'%'.$q.'%\' OR u.realname like \'%'.$q.'%\' OR c.title like \'%'.$q.'%\')'; 
			}
			if(isset($param['totalflag'])){
				$wherearr[] = 'p.totalflag in ('.$param['totalflag'].')';
			}else{
				$wherearr[] = 'p.totalflag=1';
			}
			if(!empty($wherearr)){
				$sql.=' WHERE '.implode(' AND ',$wherearr);
			}
			$row = $this->db->query($sql)->row_array();
			if(!empty($row))
				$count = $row['count'];
			return $count;
		}
		
		/*
		学校学生学习统计
		*/
		public function getListForClassroom($param){
			$wherearr = array();
			$sql = 'select u.username,u.realname,f.foldername,cl.classname,sum(pl.ltime) stime,count(pl.ltime) scount from ebh_playlogs pl 
			join ebh_roomcourses rc on rc.cwid=pl.cwid
			join ebh_classrooms cr on cr.crid=rc.crid
			join ebh_folders f on f.folderid=rc.folderid
			join ebh_users u on pl.uid=u.uid
			join ebh_classstudents cs on cs.uid=pl.uid
			join ebh_classes cl on cs.classid=cl.classid';
			$wherearr[]= 'cr.crid='.$param['crid'];
			$wherearr[]= 'cl.crid='.$param['crid'];
			$wherearr[]= 'pl.totalflag=0';
			if(!empty($param['starttime'])){
				$wherearr[] = 'pl.startdate >= '.$param['starttime'];
			}
			if(!empty($param['endtime'])){
				$wherearr[] = 'pl.startdate <= '.$param['endtime'];
			}
			if(!empty($param['classid']))
				$wherearr[]= 'cl.classid='.$param['classid'];
			$sql.= ' where '.implode(' AND ',$wherearr);
			$sql.= ' group by username,foldername order by cl.classid,u.uid';
			// echo $sql;
			$studylist = $this->db->query($sql)->list_array();
			return $studylist;
		}

		//获取学生对应课件的播放记录
		public function getStuLog($param = array()){
			if(empty($param)){
				return array();
			}
			$sql='select p.uid,p.cwid,p.totalflag,p.finished from ebh_playlogs p';
			$wherearr = array();
			if(!empty($param['uid'])){
				$wherearr[] = 'p.uid = '.$param['uid'];
			}
			if(!empty($param['cwid'])){
				$wherearr[] = 'p.cwid = '.$param['cwid'];
			}
			if(!empty($param['finished'])){
				$wherearr[] = 'p.finished = '.$param['finished'];	
			}
			if(!empty($param['checkTime'])){
				$wherearr[] = 'p.ctime <= p.ltime';
			}
			if(!empty($param['totalflag'])){
				$wherearr[] = 'p.totalflag = '.$param['totalflag'];
			}
			if(!empty($wherearr)){
				$sql.=' WHERE '.implode(' AND ',$wherearr);
			}
			return $this->db->query($sql)->list_array();
		}
		/**
		*根据课件编号和用户编号组合字符串获取对应的学习日志
		*/
		public function getLogListByUidStr($cwid,$uidstr) {
			if(empty($cwid) || empty($uidstr)) {
				return FALSE;
			}
			$logsql = 'select *from ebh_playlogs pl where pl.cwid='.$cwid.' and pl.uid in ('.$uidstr.') order by pl.uid';
			return $this->db->query($logsql)->list_array();
		}

		/**
		 *获取学生的听课记录 (课程或者课件或者学生从数据库删除了则忽略该记录)
		 */
		public function getListForClassroom2($queryarr = array()){
			//获取班级学生(包括user表里面有的和没的)
			if(!empty($queryarr['classid'])){
				$sql_for_uid = "select cs.uid as uid,cs.classid,classname from ebh_classstudents cs join ebh_classes c on cs.classid = c.classid  where c.classid = ".$queryarr['classid'];
				$wherearr[]= 'cl.classid='.$queryarr['classid'];	
			}else{
				$sql_for_uid = 'select cs.uid as uid,cs.classid,classname from ebh_classstudents cs join ebh_classes c on cs.classid = c.classid  where cs.classid in (select classid from ebh_classes where crid = '.$queryarr['crid'].')';
			}
			
		    $uidArrList = $this->db->query($sql_for_uid)->list_array();
		    if(empty($uidArrList)){
		    	//班级或者学校没有一个学生
		    	return array();
		    }
		   	$uid_classname_map = array();
		    $uid_in = array();
		    foreach ($uidArrList as $uidArr) {
		    	$uid_classname_map['udm_'.$uidArr['uid']] = $uidArr['classname'];
		    	$uid_in[] = $uidArr['uid'];
		    }
		    //获取班级学生(剔除掉user表里面没有的学生)
		    $sql_for_uid_filter = 'select u.uid,u.username,u.realname from ebh_users u where uid in ('.implode(',', $uid_in).')';
		    	
		    if(!empty($queryarr['limit'])) {
		        $sql_for_uid_filter .= ' limit '. $queryarr['limit'];
		        } else {
					if (empty($queryarr['page']) || $queryarr['page'] < 1)
						$page = 1;
					else
						$page = $queryarr['page'];
					$pagesize = empty($queryarr['pagesize']) ? 10 : $queryarr['pagesize'];
					$start = ($page - 1) * $pagesize;
		            $sql_for_uid_filter .= ' limit ' . $start . ',' . $pagesize;
		    }

		    $userList = $this->db->query($sql_for_uid_filter)->list_array();
		    if(empty($userList)){
		    	//虽然班级里面有学生但是用户表里面一个也没有对应的学生,也就是说符合条件的学生在users表里不存在
		    	return array();
		    }
		    $uid_userinfo_map = array();
		    $uid_in = array();
		    foreach ($userList as $user) {
		    	$uid_userinfo_map['uum'.$user['uid']] = $user;
		    	$uid_in[] = $user['uid'];
		    }
		    $wherearr = array();

		    //$sql_for_playlogs = "select pl.uid,pl.ctime,pl.ltime,pl.cwid,f.folderid,f.foldername from ebh_playlogs pl join ebh_roomcourses rc on pl.cwid = rc.cwid join ebh_folders f on rc.folderid = f.folderid join ebh_coursewares cw on pl.cwid = cw.cwid";
		    
		    $sql_for_playlogs = "select pl.uid,pl.ctime,pl.ltime,pl.cwid,rc.folderid from ebh_playlogs pl join ebh_roomcourses rc on pl.cwid = rc.cwid";
			
			if(!empty($uid_in)){
				$wherearr[] = 'pl.uid in ('.implode(',', $uid_in).')';
			}
			if(!empty($queryarr['starttime'])){
				$wherearr[] = 'pl.lastdate >='.$queryarr['starttime'];
			}
			if(!empty($queryarr['endtime'])){
				$wherearr[] = 'pl.lastdate <='.$queryarr['endtime'];
			}
			$wherearr[] = 'pl.totalflag = 0';
			$wherearr[] = 'rc.crid = '.$queryarr['crid'];
			if(!empty($wherearr)){
				$sql_for_playlogs .= ' WHERE '.implode(' AND ', $wherearr);
			}
			$sql_for_playlogs .= ' order by pl.uid,pl.cwid';
			$loglist = $this->db->query($sql_for_playlogs)->list_array();
			if(empty($loglist)){
				return array();
			}

			$folderid_in = $this->_getFieldArr($loglist,'folderid');
			$sql_for_folderinfo = 'select f.folderid,f.foldername from ebh_folders f where f.folderid in ('.implode(',',$folderid_in).')';
			$folderList = $this->db->query($sql_for_folderinfo)->list_array();
			if(empty($folderList)){
				//课程全删了 什么都没有了
				return array();
			}
			$folderid_foldername_map = array();
			foreach ($folderList as $folder) {
				$folderid_foldername_map['ffm_'.$folder['folderid']] = $folder['foldername'];
			}

			$cwid_in = $this->_getFieldArr($loglist,'cwid');
			$sql_for_cwid = 'select cw.cwid from ebh_coursewares cw where cw.cwid in ('.implode(',', $cwid_in).')';
			$cwidList = $this->db->query($sql_for_cwid)->list_array();
			if(empty($cwidList)){
				//课件都没了，什么都没了
				return array();
			}
			$cwid_cwid_map = array();
			foreach ($cwidList as $cwidinfo) {
				$cwid_cwid_map['ccm_'.$cwidinfo['cwid']] = $cwidinfo;
			}

			$reuturnArr = array();

			foreach ($loglist as $log) {
				if(empty($cwid_cwid_map['ccm_'.$log['cwid']])){
					//这一步主要用来剔除掉课件不存在[课件被彻底删除了]的记录
					continue;
				}
				$key = $log['uid'].$log['folderid'];
				if(!array_key_exists($key, $reuturnArr)){
					if(empty($folderid_foldername_map['ffm_'.$log['folderid']])){
						//这一步主要用来剔除掉课程不存在[课程被删除了]的记录
						continue;
					}else{
						$foldername = $folderid_foldername_map['ffm_'.$log['folderid']];
					}
					$userinfo = $uid_userinfo_map['uum'.$log['uid']];
					$reuturnArr[$key] = array(
						'uid'=>$log['uid'],
						'scount'=>1,
						'stime'=>$log['ltime'],
						'ctime'=>$log['ctime'],
						'classname'=>$uid_classname_map['udm_'.$log['uid']],
						'foldername'=>$foldername,
						'folderid'=>$log['folderid'],
						'username'=>$userinfo['username'],
						'realname'=>$userinfo['realname']
					);
				}else{
					$reuturnArr[$key]['scount']++;
					$reuturnArr[$key]['stime'] += $log['ltime'];
				}

			}
			return array_values($reuturnArr);
		}

		public function getListForClassroomCount2($queryarr = array()){
			//获取班级学生(包括user表里面有的和没的)
			if(!empty($queryarr['classid'])){
				$sql_for_uid = "select cs.uid as uid,cs.classid,classname from ebh_classstudents cs join ebh_classes c on cs.classid = c.classid  where c.classid = ".$queryarr['classid'];
				$wherearr[]= 'cl.classid='.$queryarr['classid'];	
			}else{
				$sql_for_uid = 'select cs.uid as uid,cs.classid,classname from ebh_classstudents cs join ebh_classes c on cs.classid = c.classid  where cs.classid in (select classid from ebh_classes where crid = '.$queryarr['crid'].')';
			}
			
		    $uidArrList = $this->db->query($sql_for_uid)->list_array();
		    if(empty($uidArrList)){
		    	//班级或者学校没有一个学生
		    	return 0;
		    }
		   	$uid_classname_map = array();
		    $uid_in = array();
		    foreach ($uidArrList as $uidArr) {
		    	$uid_classname_map['udm_'.$uidArr['uid']] = $uidArr['classname'];
		    	$uid_in[] = $uidArr['uid'];
		    }
		    //获取班级学生(剔除掉user表里面没有的学生)
		    $sql_for_uid_filter = 'select count(uid) as count from ebh_users u where uid in ('.implode(',', $uid_in).')';
		    $ret = $this->db->query($sql_for_uid_filter)->row_array();
		    return $ret['count'];	
		}

		/**
		 *获取二维数组指定的字段集合
		 */
		private function _getFieldArr($param = array(),$filedName=''){
			
			$reuturnArr = array();

			if(empty($filedName)||empty($param)){
				return $reuturnArr;
			}

			foreach ($param as $value) {
				array_push($reuturnArr, $value[$filedName]);
			}

			return array_unique($reuturnArr);
		}

		public function getStudyInfo($uid = 0,$cwid_in = array()){
			$sql = 'select sum(ltime) as learnsumtime,count(cwid) as learncount,min(startdate) as firsttime,cwid from ebh_playlogs where uid = '.$uid.' and totalflag=0 and cwid in('.implode(',',$cwid_in).') group by cwid';
			return $this->db->query($sql)->list_array();
		}
	}