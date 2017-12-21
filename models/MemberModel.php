<?php
/*
会员
*/
class MemberModel extends CModel{
	/*
	会员列表
	@param array $param
	@return array
	*/
	public function getmemberlist($param){
		$wherearr = array();
		$sql = 'select u.lastloginip,u.uid,u.realname,u.nickname,m.citycode,u.email,u.sex,u.face,u.credit,u.username,u.dateline,u.logincount,u.status,m.phone,m.mobile,m.qq from ebh_members m join ebh_users u on m.memberid=u.uid ';
		if(!empty($param['showregip'])){
			$sql = 'select (select fromip from ebh_creditlogs where toid=u.uid and ruleid=1) regip,u.lastloginip,u.uid,u.realname,u.nickname,m.citycode,u.email,u.sex,u.face,u.credit,u.username,u.dateline,u.logincount,u.status,m.phone,m.mobile,m.qq from ebh_members m join ebh_users u on m.memberid=u.uid';
		}

		if(!empty($param['q']))
			//如果$param['aq']为真则表示按username精确查询,否则按realname,username模糊查询
			if(!empty($param['aq'])){
				$wherearr[] =  ' u.username = \''.$this->db->escape_str($param['q']).'\'';
			}else{
				$wherearr[] =  ' ( u.realname like \'%'. $this->db->escape_str($param['q']) .'%\' or u.username like \'%' . $this->db->escape_str($param['q']).'%\' or u.nickname like \'%' . $this->db->escape_str($param['q']).'%\')';
			}
			
		if(!empty($wherearr))
			$sql.= ' WHERE '.implode(' AND ',$wherearr);	
		if(!empty($param['displayorder'])) {
            $sql .= ' ORDER BY '.$param['displayorder'];
        } else {
            $sql .= ' ORDER BY uid desc';
        }
		if(!empty($param['limit']))
			$sql.= ' limit ' . $param['limit'];
		return $this->db->query($sql)->list_array();
	}
	/*
	会员总数
	@param array $param
	@return int
	*/
	public function getmembercount($param){
		$wherearr = array();
		$sql = 'select count(*) count from ebh_members m join ebh_users u on m.memberid=u.uid';
		if(!empty($param['q']))
			//如果$param['aq']为真则表示按username精确查询,否则按realname,username模糊查询
			if(!empty($param['aq'])){
				$wherearr[] =  ' u.username = \'' . $this->db->escape_str($param['q']).'\'';
			}else{
				$wherearr[] =  ' ( u.realname like \'%'. $this->db->escape_str($param['q']) .'%\' or u.username like \'%' . $this->db->escape_str($param['q']).'%\' or u.nickname like \'%' . $this->db->escape_str($param['q']).'%\')';
			}
		if(!empty($wherearr))
			$sql.= ' WHERE '.implode(' AND ',$wherearr);
		//var_dump($sql);
		$count = $this->db->query($sql)->row_array();
		return $count['count'];
	}
	/*
	修改会员
	@param array $param
	@return int
	*/
	public function editmember($param){
		$afrows=0;
		//修改user表信息
		if(!empty($param['password']))
			$userarr['password'] = md5($param['password']);
		if(!empty($param['ppassword']))//设置家长密码
			$userarr['ppassword'] = md5($param['ppassword']);
		if(isset($param['status']))
			$userarr['status'] = $param['status'];
		if(isset($param['cnname']))
			$userarr['realname'] = $param['cnname'];
		if(isset($param['nickname']))
			$userarr['nickname'] = $param['nickname'];
		if(isset($param['sex']))
			$userarr['sex'] = $param['sex'];
		if(isset($param['mobile']))
			$userarr['mobile'] = $param['mobile'];
		if(isset($param['email']))
			$userarr['email'] = $param['email'];
		if(isset($param['citycode']))
			$userarr['citycode'] = $param['citycode'];
		if(isset($param['address']))
			$userarr['address'] = $param['address'];
		if(isset($param['face']))
			$userarr['face'] = $param['face'];
		if(isset($param['lastlogintime']))
			$userarr['lastlogintime'] = $param['lastlogintime'];
		$wherearr = array('uid'=>$param['uid']);
		if (!empty($userarr)) {
            $afrows+= $this->db->update('ebh_users', $userarr, $wherearr);
        }
		//修改member表信息
		
		if(isset($param['birthdate']))
			$memberarr['birthdate'] = $param['birthdate'];
		if(isset($param['phone']))
			$memberarr['phone'] = $param['phone'];
		if(isset($param['qq']))
			$memberarr['qq'] = $param['qq'];
		if(isset($param['msn']))
			$memberarr['msn'] = $param['msn'];
		if(isset($param['native']))
			$memberarr['native'] = $param['native'];
		if(isset($param['profile']))
			$memberarr['profile'] = $param['profile'];
		if(isset($param['realname']))
			$memberarr['realname'] = $param['realname'];
		if(isset($param['nickname']))
			$memberarr['nickname'] = $param['nickname'];
		if(isset($param['sex']))
			$memberarr['sex'] = $param['sex'];
		if(isset($param['mobile']))
			$memberarr['mobile'] = $param['mobile'];
		if(isset($param['email']))
			$memberarr['email'] = $param['email'];
		if(isset($param['citycode']))
			$memberarr['citycode'] = $param['citycode'];
		if(isset($param['address']))
			$memberarr['address'] = $param['address'];
		if(isset($param['familyname']))
			$memberarr['familyname'] = $param['familyname'];
		if(isset($param['familyphone']))
			$memberarr['familyphone'] = $param['familyphone'];
		if(isset($param['familyjob']))
			$memberarr['familyjob'] = $param['familyjob'];
		if(isset($param['familyemail']))
			$memberarr['familyemail'] = $param['familyemail'];
		if(isset($param['hobbies']))
			$memberarr['hobbies'] = $param['hobbies'];
		if(isset($param['lovemusic']))
			$memberarr['lovemusic'] = $param['lovemusic'];
		if(isset($param['lovemovies']))
			$memberarr['lovemovies'] = $param['lovemovies'];
		if(isset($param['lovegames']))
			$memberarr['lovegames'] = $param['lovegames'];
		if(isset($param['lovecomics']))
			$memberarr['lovecomics'] = $param['lovecomics'];
		if(isset($param['lovesports']))
			$memberarr['lovesports'] = $param['lovesports'];
		if(isset($param['lovebooks']))
			$memberarr['lovebooks'] = $param['lovebooks'];
			
		$wherearr = array('memberid'=>$param['uid']);
		if (!empty($memberarr)) {
            $afrows+= $this->db->update('ebh_members', $memberarr, $wherearr);
        }
		return $afrows;
	}
	/*
	会员详情
	@param int $uid
	@return array
	*/
	public function getmemberdetail($uid){
		$sql = 'select u.uid,u.username,u.realname,u.nickname,u.face,u.citycode,u.address,u.email,u.sex,m.phone,u.mobile,u.mysign,m.birthdate,m.qq,m.msn,m.native,m.credit,m.profile from ebh_users u join ebh_members m on u.uid = m.memberid where memberid = '.$uid;
		//var_dump($sql);
		return $this->db->query($sql)->row_array();
	}

	/*
	前台会员查看自己信息
	@param int $uid
	
	*/
	public function getfullinfo($uid){
		$sql = 'select m.*,u.realname,c.cityname from ebh_members m
			left join ebh_cities c on m.citycode = c.citycode left join ebh_users u on u.uid = m.memberid
			where memberid='.$uid;
		return $this->db->query($sql)->row_array();
	}
	/*
	前台教师查看自己信息
	@param int $uid
	
	*/
	public function getfullinfoT($uid){
		$sql = 'select u.*,c.cityname from ebh_users u
			left join ebh_cities c on u.citycode = c.citycode where u.uid='.$uid;
		return $this->db->query($sql)->row_array();
	}
	/**
	 *根据年份获取会员数量列表
	 *@author zkq
	 *@return array (一维数组);
	 * 实例: getMemberCOuntGroupByYear(2013);返回 array(11,22,33,44,55,66,77,88,99,111,222,333);格式的数组,共计12个月的
	 */
    public function getMemberCountGroupByYear($year){
        $countArr = array();
        for($i=1;$i<=12;$i++){
            $startTime = strtotime($year.'-'.$i.'-1');
            if($i==12){
                $endTime = strtotime(($year+1).'-1-1');
            }else{
                $endTime = strtotime($year.'-'.($i+1).'-1');
            }
            $sql ='select count(*) count from ebh_members m left join ebh_users u on m.memberid = u.uid where u.dateline>='.$startTime.' AND u.dateline<'.$endTime;
            $res = $this->db->query($sql)->row_array();
            $countArr[] = $res['count'];
        }
       
        return $countArr;
    }
	
	public function addMultipleMembers($uarr){
		$sql='insert into ebh_users (username,password,realname,sex,dateline,status,groupid) values ';
		foreach($uarr as $user){
			$username = $user['username'];
			$password = md5($user['password']);
			$realname = $user['realname'];
			$sex = $user['sex'];
			$dateline = $user['dateline'];
			$status = 1;
			$groupid = 6;
			$sql.= "('$username','$password','$realname',$sex,$dateline,$status,$groupid),";
		}
		$sql = rtrim($sql,',');
		$this->db->query($sql);
		$fromuid = $this->db->insert_id();
		
		$sql = 'insert into ebh_members (memberid,realname,sex) values ';
		for($i=0;$i<count($uarr);$i++){
			$memberid = $fromuid + $i;
			$realname = $uarr[$i]['realname'];
			$sex = $uarr[$i]['sex'];
			$sql.= "($memberid,'$realname',$sex),";
		}
		$sql = rtrim($sql,',');
		$this->db->query($sql);
		return $fromuid;
	}
}
?>