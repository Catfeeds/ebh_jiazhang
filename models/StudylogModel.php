<?php
	/**
	* 学习记录model对应的ebh_studylog表	
	* 主要记录和查询学生听课时间
	*/
	class StudylogModel extends CModel{
		/**
		*添加听课记录，如果已经存在就更新最大的时间
		*todo:此处可能涉及积分问题，暂留
		*/
		public function addlog($param) {
			if(empty($param['cwid']) || empty($param['uid']) || empty($param['ctime']) || empty($param['ltime']) ) {
				return false;
			}
			$cwid = $param['cwid'];	//课件编号
			$uid = $param['uid'];	//用户编号
			$ctime = $param['ctime'];	//课件时长
			$ltime = $param['ltime'];	//学习持续时间
			$finished = $param['finished']; //是否听完
			
			$cache = Ebh::app()->getCache();
			$keyparam = array('uid'=>$uid,'cwid'=>$cwid);
			$id1 = $cache->getcachekey('playlogs_total',$keyparam);
			$id2 = $cache->getcachekey('playlogs_each',$keyparam);
			if(!empty($param['logid'])){
				$row = $cache->get($id1);
				// log_message('第一次请求之后数据走缓存');
			}else{
				$cache->remove($id1);
				$cache->remove($id2);
				// log_message('第一次清除缓存，数据走数据库');
			}
			if(empty($row)){
				$existssql = 'SELECT p.logid,p.ctime,p.ltime FROM ebh_playlogs p WHERE p.cwid='.$cwid.' and p.uid='.$uid .' and totalflag=1';
				$row = $this->db->query($existssql)->row_array();
			}
			if(!empty($row)) {	//记录存在则更新记录(总记录)
				$logid = $row['logid'];
				$wherearr = array('logid'=>$logid);
				$setarr = array('lastdate'=>SYSTIME);
				if($row['ctime'] != $ctime){
					$setarr['ctime'] = $ctime;
					$row['ctime'] = $ctime;
				}
				if($row['ltime'] < $ltime){
					$setarr['ltime'] = $ltime;
					$row['ltime'] = $ltime;
				}
				if($finished == 1)
					$setarr['finished'] = 1;
				$result = $this->db->update('ebh_playlogs',$setarr,$wherearr);
				$cache->set($id1,$row,86400);

			} else {	//不存在则生成新纪录(总记录)
				$setarr = array('cwid'=>$cwid,'uid'=>$uid,'ctime'=>$ctime,'ltime'=>$ltime,'startdate'=>(SYSTIME-$ltime),'lastdate'=>SYSTIME,'totalflag'=>1);
				if($finished == 1)
					$setarr['finished'] = 1;
				$result = $this->db->insert('ebh_playlogs',$setarr);
			}
			if(empty($param['logid'])){
				$logid = 0;
			}else{
				$logid = $param['logid'];
			}
			if(!empty($logid)){
				$row2 = $cache->get($id2);
				if(empty($row2)){
					$existssql_one = 'SELECT p.logid,p.ctime,p.ltime FROM ebh_playlogs p WHERE p.cwid='.$cwid.' and p.uid='.$uid .' and totalflag=0 and p.logid='.$logid;
					$row2 = $this->db->query($existssql_one)->row_array();
				}
			}
			if(!empty($row2)) {	//记录存在则更新记录(每次听课单条记录)
				$logid = $row2['logid'];
				$wherearr = array('logid'=>$logid);
				$setarr2 = array('lastdate'=>SYSTIME);

				if($row2['ctime'] != $ctime){
					$setarr2['ctime'] = $ctime;
					$row2['ctime'] = $ctime;
				}
				if($row2['ltime'] < $ltime){
					$setarr2['ltime'] = $ltime;
					$row2['ltime'] = $ltime;
				}
				if($finished == 1)
					$setarr2['finished'] = 1;
				$result2 = $this->db->update('ebh_playlogs',$setarr2,$wherearr);
				// if($result2){
					$cache->set($id2,$row2,86400);
				// }
			} else {	//不存在则生成新纪录(每次听课单条记录)
				$setarr2 = array('cwid'=>$cwid,'uid'=>$uid,'ctime'=>$ctime,'ltime'=>$ltime,'startdate'=>(SYSTIME-$ltime),'lastdate'=>SYSTIME,'totalflag'=>0);
				if($finished == 1)
					$setarr2['finished'] = 1;
				$logid = $this->db->insert('ebh_playlogs',$setarr2);

				//同步SNS数据,只在单次听课记录生成时同步
				Ebh::app()->lib('Sns')->do_sync($uid, 2);
			}
			return $logid;
		}
		/**
		 * 根据参数获取对应的学习记录列表
		 * @param array $param
		 * @return array
		 */
		public function getList($param=array()){
			$sql = 'SELECT s.logid,u.username,cw.title,s.price,s.credit,s.fromip,s.dateline FROM ebh_studylogs s left join ebh_coursewares cw on s.cwid = cw.cwid left join ebh_users u on s.uid = u.uid ';
			$whereArr = array();
			if(!empty($param['begintime'])){
				$whereArr[] = ' s.dateline >= '.strtotime($param['begintime']);
			}
			if(!empty($param['endtime'])){
				$whereArr[] = ' s.dateline < '.strtotime($param['endtime']);
			}
			if(!empty($param['searchkey'])){
				$whereArr[] = ' cw.title like "%'.$param['searchkey'].'%" or u.username = '.intval($param['searchkey']);
			}
			if(!empty($whereArr)){
				$sql.=' WHERE '.implode(' AND ',$whereArr);
			}
			if(!empty($param['order'])){
				$sql.=' order by '.$param['order'];
			}else{
				$sql.=' order by s.dateline desc ';
			}
			if(!empty($param['limit'])){
				$sql.= 'limit '.$param['limit'];
			}else{
				$sql.= 'limit 0,20'; 
			}
			return $this->db->query($sql)->list_array();
		}
		/**
		 * 根据参数获取对应的学习记录条数
		 * @param array $param
		 * @return int
		 */
		public function getListCount($param){
			$sql = 'SELECT count(s.logid) count FROM ebh_studylogs s left join ebh_coursewares cw on s.cwid = cw.cwid left join ebh_users u on s.uid = u.uid ';
			$whereArr = array();
			if(!empty($param['begintime'])){
				$whereArr[] = ' s.dateline > '.strtotime($param['begintime']);
			}
			if(!empty($param['endtime'])){
				$whereArr[] = ' s.dateline < '.strtotime($param['endtime']);
			}
			if(!empty($param['searchkey'])){
				$whereArr[] = ' cw.title like "%'.$param['searchkey'].'%" or u.username = '.intval($param['searchkey']);
			}
			if(!empty($whereArr)){
				$sql.=' WHERE '.implode(' AND ',$whereArr);
			}
			$res = $this->db->query($sql)->row_array();
			if($res!=false){
				return $res['count'];
			}else{
				return 0;
			}
		}
		/**
		 * 根据参数获取对应的学习记录条数
		 * @param array $param
		 * @return int
		 */
		public function getStudyCount($param){
			$count = 0;
			$sql = 'select count(*) count from ebh_playlogs p '.
					'join ebh_coursewares c on (p.cwid = c.cwid) '.
					'join ebh_roomcourses rc on (rc.cwid = p.cwid) ';
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
			$row = $this->db->query($sql)->row_array();
			if(!empty($row))
				$count = $row['count'];
			return $count;
		}
		public function getStudents($param){
			$sql = 'select u.uid,schoolname from ebh_users u join ebh_roomusers ru on u.uid = ru.uid';
			$wherearr = array();
			if(!empty($param['crid']))
				$wherearr[] = 'ru.crid='.$param['crid'];
			if(!empty($wherearr))
				$sql .= ' where '.implode(' AND ',$wherearr);
			return $this->db->query($sql)->list_array();
		}
		
		public function getStudentsByschoolname($param){
			$sql = 'select u.uid,schoolname from ebh_users u  join ebh_classstudents cs on cs.uid = u.uid join ebh_classes cl on cl.classid = cs.classid';
			$wherearr = array();
			if(!empty($param['crid']))
				$wherearr[] = 'cl.crid='.$param['crid'];
			if(isset($param['schoolname']))
				$wherearr[] = 'u.schoolname=\''.$param['schoolname'].'\'';
			if(isset($param['grade']))
				$wherearr[] = 'cl.grade='.$param['grade'];
			if(!empty($wherearr))
				$sql .= ' where '.implode(' AND ',$wherearr);
			// echo $sql.'<br/>';
			return $this->db->query($sql)->list_array();
		}
		public function getClass($param){
			$sql = 'select grade,uid from ebh_classes c join ebh_classstudents cs on c.classid=cs.classid';
			$wherearr = array();
			if(!empty($param['crid']))
				$wherearr[] = 'c.crid='.$param['crid'];
			if(!empty($param['uids']))
				$wherearr[] = 'cs.uid in ('.$param['uids'].')';
			if(!empty($wherearr))
				$sql .= ' where '.implode(' AND ',$wherearr);
			return $this->db->query($sql)->list_array();
		}
		
		public function getCW($param){
			$sql = 'select cwid from ebh_roomcourses rc';
			$wherearr = array();
			if(!empty($param['folderids']))
				$wherearr[] = 'rc.folderid in('.$param['folderids'].')';
			if(!empty($wherearr))
				$sql .= ' where '.implode(' AND ',$wherearr);
			// echo $sql;
			return $this->db->query($sql)->list_array();
		}
		
		public function getfolderlist($param){
			$sql = 'SELECT f.crid,f.foldername,f.folderid,f.grade FROM ebh_folders f ';
			$wherearr = array();
			if(!empty($param['crid']))
				$wherearr[] = 'f.crid='.$param['crid'];
			$wherearr[] = 'folderlevel = 2';
			if(!empty($wherearr))
				$sql .= ' where '.implode(' AND ',$wherearr);
			// echo $sql;
			return $this->db->query($sql)->list_array();
		}
		
		public function getStudylog($param){
			$sql = 'select distinct(uid) from ebh_playlogs';
			$wherearr = array();
			if(!empty($param['uids']))
				$wherearr[] = 'uid in ('.$param['uids'].')';
			if(!empty($param['cwids']))
				$wherearr[] = 'cwid in ('.$param['cwids'].')';
			if(!empty($param['datefrom']))
				$wherearr[] = 'lastdate>='.$param['datefrom'];
			if(!empty($param['dateto']))
				$wherearr[] = 'lastdate<='.$param['dateto'];
			// $wherearr[] = 'totalflag = 1';
			if(!empty($wherearr))
				$sql .= ' where '.implode(' AND ',$wherearr);
			// echo $sql.'<br/>';
			// log_message($sql);
			$res = $this->db->query($sql)->list_array();
			return count($res);
		}
		
		public function getSchools($param){
			$sql = 'select distinct(schoolname) from ebh_users u join ebh_roomusers ru on u.uid = ru.uid where crid='.$param['crid'];
			return $this->db->query($sql)->list_array();
		}
	}