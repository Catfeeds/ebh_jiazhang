<?php
/*
积分
*/
class CreditModel extends CModel{
	/*
	会员积分明细列表
	@param int $uid
	@param array $param
	@return array 
	*/
	public function getCreditList($param){
		$sql = 'select u.username,u.realname,c.credit,c.dateline,i.rulename,i.action,i.description,c.detail,c.type
		from ebh_creditlogs c
		left join ebh_users u on c.uid = u.uid
		left join ebh_creditrules i on c.ruleid = i.ruleid 
		where (c.toid='.$param['toid'].' or (c.type=1 and '.$param['toid'].'<=382685))';
		$sql.= ' order by c.logid desc';
		if(!empty($param['limit']))
			$sql.= ' limit '.$param['limit'];
		else{
			if(empty($param['page']) || $param['page'] < 1)
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
	 * 根据uids批量获取会员积分
	 */
	public function getCreditByUids($param){
		if(empty($param['uids'])){
			return false;
		}
		
		$sql = 'select u.uid,u.username,u.realname,u.face,u.sex,u.groupid,c.credit,c.dateline,i.rulename,i.action,i.description,c.detail
		from ebh_creditlogs c
		left join ebh_users u on c.toid = u.uid
		left join ebh_creditrules i on c.ruleid = i.ruleid
		where c.dateline=((select max(dateline) from `ebh_creditlogs` where toid = c.toid)) and c.toid in ('.implode(',',$param['uids']).')';
		$sql.= ' group by c.toid order by c.dateline desc, c.logid desc';
		return $this->db->query($sql)->list_array();
	}
	
	/**
	 * 根据crid获取同个网校下的会员积分 
	 */
	public function getCreditByCrid($param){
		if(empty($param['crid'])){
			return false;
		}
		$where = "1";
		if(!empty($param['nuids'])){
			$where = " c.toid not in (".implode(',',$param['nuids']).")";
		}
		//取最大时间

		$sql = 'select u.uid,u.username,u.realname,u.face,u.sex,u.groupid,c.credit,max(c.dateline) dateline,i.rulename,i.action,i.description,c.detail
		from ebh_creditlogs c
		left join ebh_users u on c.toid = u.uid
		left join ebh_roomusers ru on ru.uid = u.uid 
		left join ebh_creditrules i on c.ruleid = i.ruleid
		where ru.crid = '.$param['crid'].' and '.$where;
		$sql.= ' group by c.toid order by dateline desc, c.logid desc';
		//where c.dateline=((select max(dateline) from `ebh_creditlogs` where toid = c.toid)) and ru.crid = '.$param['crid'].' and '.$where;
		if(!empty($param['limit'])){
			$sql.= ' limit '.$param['limit'];
		}else{
			if(empty($param['page']) || $param['page'] < 1)
				$page = 1;
			else
				$page = $param['page'];
				
			$pagesize = empty($param['pagesize']) ? 5 : $param['pagesize'];
			$start = ($page - 1) * $pagesize;
			$sql .= ' limit ' . $start . ',' . $pagesize;
		}
		return $this->db->query($sql)->list_array();
	}
	
	/*
	积分记录数量
	@param int $uid
	*/
	public function getUserCreditCount($param){
		$wherearr = array();
		$sql = 'select count(*) count from ebh_creditlogs';
		if(!empty($param['uid']))
			$wherearr[]= 'uid='.$param['uid'];
		if(!empty($param['toid']))
			$wherearr[]= 'toid='.$param['toid'];
		if(!empty($param['ruleid']))
			$wherearr[]= 'ruleid='.$param['ruleid'];
		if(!empty($param['credit']))
			$wherearr[]= 'credit='.$param['credit'];
		if(!empty($param['dateline']))//特殊条件
			$wherearr[]= $param['dateline'];
		if(!empty($param['type']))
			$wherearr[]= 'type='.$param['type'];
		$sql.= ' where '.implode(' AND ',$wherearr);
		//log_message($sql);
		$count = $this->db->query($sql)->row_array();
		return $count['count'];
	}
	/*
	积分兑换记录
	@param array $param
	*/
	public function getOrderList($param){
		$sql = 'SELECT o.*,p.productname,p.image,p.credit FROM ebh_orders o left join ebh_products p ON o.pid=p.productid WHERE o.uid = '.$param['uid'].' ORDER BY o.oid desc ';
		if(!empty($param['limit']))
			$sql.= ' limit '.$param['limit'];
		else{
			if(empty($param['page']) || $param['page'] < 1)
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
	积分兑换数量
	*/
	public function getOrderCount($param){
		$sql = 'select count(*) count from ebh_orders where uid='.$param['uid'];
		if(!empty($param['limit']))
			$sql.= ' limit '.$param['limit'];
		else{
			if(empty($param['page']) || $param['page'] < 1)
				$page = 1;
			else
				$page = $param['page'];
			
			$pagesize = empty($param['pagesize']) ? 10 : $param['pagesize'];
			$start = ($page - 1) * $pagesize;
			$sql .= ' limit ' . $start . ',' . $pagesize;
		}
		$count = $this->db->query($sql)->row_array();
		return $count['count'];
	}
	/*
	根据ruleid查看积分规则信息
	@param int $ruleid
	*/
	public function getCreditRuleInfo($ruleid){
		$sql = 'select r.rulename,r.action,r.credit,r.actiontype,r.maxaction
			from ebh_creditrules r where r.ruleid='.$ruleid;
		return $this->db->query($sql)->row_array();
	}
	/*
	添加积分日志,并修改积分
	@param array $param ruleid, toid/aid..
	*/
	public function addCreditlog($param){
		if(is_numeric($param))
			$logarr['ruleid'] = $param;
		else
			$logarr['ruleid'] = $param['ruleid'];
		$user = Ebh::app()->user->getloginuser();
		if(!empty($param['uid']))
			$logarr['uid'] = $param['uid'];
		else
			$logarr['uid'] = $user['uid'];
		
		$flag = 0;
		if(!empty($param['uid'])){//指定了受分对象的
			$logarr['toid'] = $param['uid'];
		}else if(!empty($param['aid'])){//指定了答疑号的,被采纳为最佳答案
			$sql = 'select q.uid,a.uid toid,q.title from ebh_askanswers a 
				join ebh_askquestions q on (q.qid=a.qid)';
			$warr[] = 'a.aid='.$param['aid'];
			$warr[] = 'q.uid='.$logarr['uid'];
			$sql.= ' where '.implode(' AND ',$warr);
			$temp = $this->db->query($sql)->row_array();
			$logarr['uid'] = empty($param['qid']) ? $temp['uid'] : $param['qid'];//记录qid
			$logarr['toid'] = $temp['toid'];
			$logarr['type'] = 3;
			$logarr['detail'] = $temp['title'];
		}else if(!empty($param['qid'])){//指定了qid的,回答问题
			$sql = 'select q.title,q.qid from ebh_askquestions q';
			$warr[] = 'q.qid='.$param['qid'];
			$sql.= ' where '.implode(' AND ',$warr);
			$temp = $this->db->query($sql)->row_array();
			$logarr['toid'] = $logarr['uid'];
			$logarr['uid'] = $temp['qid'];
			$logarr['detail'] = $temp['title'];
			$logarr['type'] = 3;
		}else if(!empty($param['eid'])){//指定了eid的,完成作业
			$logarr['toid'] = $logarr['uid'];
			$logarr['detail'] = $param['detail'];
			$logarr['type'] = 4;
		}elseif(!empty($param['cwid']) && $param['ruleid'] != 5){
			$sql = 'select cw.title,cw.cwid,cw.uid from ebh_coursewares cw';
			$warr[] = 'cw.cwid='.$param['cwid'];
			$sql.= ' where '.implode(' AND ',$warr);
			$temp = $this->db->query($sql)->row_array();
			$logarr['uid'] = $param['cwid'];
			$logarr['detail'] = $temp['title'];
			$logarr['toid'] = $temp['uid'];
			// $logarr['type'] = 0;
		}else{//没有指定，则为自己
			$logarr['toid'] = $logarr['uid'];
		}
		$ruleinfo = $this->getCreditRuleInfo($logarr['ruleid']);
		//每次都增加
		if($ruleinfo['actiontype'] == 0){
			$flag = 1;
		}
		//只一次
		elseif($ruleinfo['actiontype'] == -1){
			$wherearr['toid'] = $logarr['toid'];
			$wherearr['ruleid'] = $logarr['ruleid'];
			$logcount = $this->getUserCreditCount($wherearr);
			if($logcount>0)
				return ;
			else{
				$flag=1;
			}
		}
		//每天增加有限次数
		elseif($ruleinfo['actiontype'] == -2){
			$today = strtotime(Date('Y-m-d'));
			$wherearr['toid'] = $logarr['toid'];
			$wherearr['ruleid'] = $logarr['ruleid'];
			$wherearr['dateline'] = ' dateline>'.$today.' and dateline<'.($today+86400);
			$logcount = $this->getUserCreditCount($wherearr);
			if($logcount>=$ruleinfo['maxaction']){
				if(!empty($param['nocheck'])&&($param['nocheck']==true)){//抽奖再来一次不需要检测最大次数;权限由控制器给出
					$flag=1;
				}else{
					return ;
				}
				
			}else{
				$uniqueconfirm = 0;
				if(!empty($param['cwid'])){
					$wherearr['uid'] = $param['cwid'];
					$wherearr['type'] = 2;
					$uniqueconfirm = 1;
				}elseif(!empty($param['qid'])){
					$wherearr['uid'] = $param['qid'];
					$wherearr['type'] = 3;
					$uniqueconfirm = 1;
				}
				if($uniqueconfirm){
					$logcount = $this->getUserCreditCount($wherearr);
					if($logcount>0)
						return;
					else{
						$logarr['type'] = $wherearr['type'];
						$logarr['uid'] = $wherearr['uid'];
					}
				}
				$flag=1;
			}
		}
		//按时间段增加
		else{
			return;
		}
		
		//添加记录并增加toid的积分
		if($flag){
			if($logarr['ruleid'] == 16 && isset($param['productid']) && isset($param['credit'])){//积分兑换
				$logarr['credit'] = $param['credit'];
				$logarr['productid'] = $param['productid'];
			}
			elseif(isset($param['credit']))
				$logarr['credit'] = $param['credit'];
			else
				$logarr['credit'] = $ruleinfo['credit'];
			$logarr['dateline'] = SYSTIME;
			$logarr['fromip'] = getip();
			if(!empty($param['detail']))
				$logarr['detail'] = $param['detail'];
			$res = $this->db->insert('ebh_creditlogs',$logarr);
			$sparam = array('credit'=>'credit'.$ruleinfo['action'].$logarr['credit']);
			$this->db->update('ebh_users',array(),'uid='.$logarr['toid'],$sparam);
			if($ruleinfo['action'] == '+' && $logarr['ruleid'] != 29){log_message(111);
				$redis = $redis = Ebh::app()->getCache('cache_redis');
				$roominfo = Ebh::app()->room->getcurroom();
				$crcache = $redis->hget('credit',$roominfo['crid']);
				$crcache = unserialize($crcache);
				$day = Date('Y/m/d',SYSTIME);
				if(isset($crcache[$day]))
					$crcache[$day] += $logarr['credit'];
				else
					$crcache[$day] = $logarr['credit'];
				$redis->hset('credit',$roominfo['crid'],$crcache);
			}
			return $res;
		}
	}
	/*
	积分规则列表
	*/
	public function getCreditRuleList($param=null){
		$sql = 'select ruleid,rulename,action,credit,actiontype,maxaction,description from ebh_creditrules';
		if(!empty($param['action']))
			$wherearr[] = 'action=\''.$param['action'].'\'';
		if(!empty($wherearr))
			$sql.= ' where '.implode(' AND ',$wherearr);
		return $this->db->query($sql)->list_array();
	}
	/*
	修改积分规则
	*/
	public function update($param){
		if(empty($param['ruleid']))
			return false;
		$setarr['rulename'] = $param['rulename'];
		$setarr['action'] = $param['action'];
		$setarr['credit'] = $param['credit'];
		$setarr['actiontype'] = $param['actiontype'];
		$setarr['maxaction'] = $param['maxaction'];
		$setarr['description'] = $param['description'];
		$this->db->update('ebh_creditrules',$setarr,'ruleid='.$param['ruleid']);
	}
	/*
	添加积分规则
	*/
	public function insert($param){
		$setarr['rulename'] = $param['rulename'];
		$setarr['action'] = $param['action'];
		$setarr['credit'] = $param['credit'];
		$setarr['actiontype'] = $param['actiontype'];
		$setarr['maxaction'] = $param['maxaction'];
		$setarr['description'] = $param['description'];
		$this->db->insert('ebh_creditrules',$setarr);
		
	}
	/*
	删除积分规则
	*/
	public function delete($ruleid){
		if(!empty($ruleid))
			return $this->db->delete('ebh_creditrules','ruleid='.$ruleid);
	}
	
	public function addRegLogs($fromuid,$stunum){
		$sql = 'select credit from ebh_creditrules where ruleid = 1';
		$res = $this->db->query($sql)->row_array();
		$credit = $res['credit'];
		
		$sql = 'insert into ebh_creditlogs (ruleid,uid,toid,credit,dateline,fromip) values ';
		$ip = getip();
		$dateline = SYSTIME;
		for($i=0;$i<$stunum;$i++){
			$uid = $fromuid + $i;
			$sql.= "(1,$uid,$uid,$credit,$dateline,'$ip'),";
		}
		$sql = rtrim($sql,',');
		$this->db->query($sql);
	}

	/**
	 *获取用户抽奖记录(用于抽奖页面滚动显示)
	 *
	 */
	public function getLotteryLogs($param = array()){
		$sql = 'select c.productid,u.username,u.realname from ebh_creditlogs c left join ebh_users u on c.uid = u.uid where c.productid in(1,2,3,4,5,6,7,8) order by c.logid desc limit 32';
		return $this->db->query($sql)->list_array();
	}
	/**
	 *获取用户当天抽奖的次数(除了再来一次)(用于判断用户是否有权限再抽一次奖)
	 */
	public function getTodayLogsCount($uid = 0){
		$today = strtotime(Date('Y-m-d'));
		$wherearr['dateline'] = ' dateline>'.$today.' and dateline<'.($today+86400);
		$sql = 'select count(logid) count from ebh_creditlogs c where c.uid = '.$uid .' and ruleid = 16 and dateline>'.$today.' and dateline<'.($today+86400).' and productid !=-2';
		$res = $this->db->query($sql)->row_array();
		return $res['count'];
	}
	
	/*
	签到记录
	*/
	public function getSignLog($param){
		$sql = 'select dateline from ebh_creditlogs';
		$wherearr[] = 'ruleid=22';
		$wherearr[] = 'toid='.$param['uid'];
		$sql.= ' where '.implode(' AND ',$wherearr);
		$sql.= ' order by logid desc';
		if(!empty($param['limit']))
			$sql.= ' limit '.$param['limit'];
		return $this->db->query($sql)->list_array();
	}
	
	/**
	 * 获取签到次数
	 */
	public function getSignLogCount($param){
		$sql = 'select count(*) count from ebh_creditlogs';
		$wherearr[] = 'ruleid=22';
		$wherearr[] = 'toid='.$param['uid'];
		$sql.= ' where '.implode(' AND ',$wherearr);
		$row = $this->db->query($sql)->row_array();
		if(empty($row['count'])){
			$count = 0;
		}else{
			$count = $row['count'];
		}
		return $count;
	}
	
	/*
	积分进账
	*/
	public function getCreditComingList($param){
		$sql = 'select toid,sum(credit) sumcredit,sum(ruleid=22) sumsign,dateline,from_unixtime(dateline,\'%Y-%m-%d\') d from ebh_creditlogs';
		if(!empty($param['uids']))
			$wherearr[] = 'toid in ('.$param['uids'].')';
		if(!empty($param['ruleids']))
			$wherearr[] = '(ruleid in ('.$param['ruleids'].') or type = 1)';
		if(!empty($param['datefrom']))
			$wherearr[] = 'dateline>='.$param['datefrom'];
		if(!empty($param['dateto']))
			$wherearr[] = 'dateline<='.$param['dateto'];
		if(!empty($param['startdate']))
			$wherearr[] = 'dateline>='.$param['startdate'];
		if(!empty($param['enddate']))
			$wherearr[] = 'dateline<='.($param['enddate']+86400);
		if(!empty($wherearr))
			$sql.= ' where '.implode(' AND ',$wherearr);
		if(!empty($param['group']))
			$sql.= ' group by '.$param['group'];
		if(!empty($param['order']))
			$sql.= ' order by '.$param['order'];
		else
			$sql.= ' order by d asc';
		return $this->db->query($sql)->list_array();
		
	}
	
	/*
	学生首页积分排名列表
	*/
	public function getRankList($param){
		$sql = 'select u.uid,u.username,u.realname,u.face,u.credit,u.sex,u.groupid 
				from ebh_users u 
				join ebh_roomusers ru on u.uid=ru.uid';
		if(!empty($param['crid']))
			$wherearr[] = 'ru.crid='.$param['crid'];
		if(!empty($wherearr))
			$sql.= ' where '.implode(' AND ',$wherearr);
		
		if(!empty($param['order']))
			$sql.= ' order by '.$param['order'];
		else
			$sql.= ' order by credit desc';
		
		if(!empty($param['limit']))
			$sql.= ' limit '.$param['limit'];
		else
			$sql.= ' limit 3';
		return $this->db->query($sql)->list_array();
	}
	
	/*
	 学生首页积分排名列表
	*/
	public function getRankListCount($param){
		$sql = 'select count(*) count from ebh_users u join ebh_roomusers ru on u.uid=ru.uid';
		if(!empty($param['crid']))
			$wherearr[] = 'ru.crid='.$param['crid'];
		if(!empty($wherearr))
			$sql.= ' where '.implode(' AND ',$wherearr);
		$row = $this->db->query($sql)->row_array();
		if(empty($row['count'])){
			$count = 0;
		}else{
			$count = $row['count'];
		}
		return $count;
	}
	
	/**
	 * 根据问题编号获得悬赏奖励者名单
	 * @param  int $qid 问题标号
	 * @return array      奖励者列表
	 */
	public function getRewardList($qid){
		$wherearr = array();
		$sql = 'SELECT u.username,u.realname,c.credit FROM ebh_creditlogs c LEFT JOIN ebh_users u ON c.toid=u.uid';
		$wherearr[] = 'c.ruleid=27';
		if (!empty($qid))
		{
			$wherearr[] = 'c.uid=' .intval($qid);
		}
		if (!empty($wherearr))
			$sql .= ' WHERE ' . implode(' AND ', $wherearr);
		return $this->db->query($sql)->list_array();
	}
}
?>