<?php
/**
 *用户Model类
 */
class UserModel extends CModel {
    /**
     * 用username和password判断登录
     * @param type $username
     * @param type $userpass
     * @param boolean $iscoding 是否加密过密码
     * @return boolean 返回用户信息数组
     */
    public function login($username,$userpass,$iscoding = FALSE) {
        $pwd = $iscoding ? $userpass : md5($userpass);
        $username = $this->db->escape($username);
        $sql = "select u.uid, u.username, u.groupid, u.logincount,u.lastlogintime,u.lastloginip,u.password,u.ppassword,u.status,u.allowip from ebh_users u where u.username=$username";
        $user = $this->db->query($sql)->row_array();
		if(empty($user['ppassword'])){
			if(empty($user) || $user['password'] != $pwd || $user['status'] == 0) {
				return false;
			}
		}else{
			if(empty($user) || $user['ppassword'] != $pwd || $user['status'] == 0) {
				return false;
			}
		}
        return $user;
    }
    /**
     * 用uid和password判断登录
     * @param type $uid
     * @param type $userpass
     * @param boolean $iscoding 是否加密过密码
     * @return boolean 返回用户信息数组
     */
    public function getloginbyuid($uid,$userpass,$iscoding = FALSE) {
        $pwd = $iscoding ? $userpass : md5($userpass);
        $sql = "select u.uid, u.username,u.realname,u.sex,u.email,u.face, u.groupid, u.credit,u.logincount,u.password,u.ppassword,u.balance,u.lastloginip,u.status,u.allowip,u.mysign from ebh_users u where u.uid=$uid";
        $user = $this->db->query($sql)->row_array();
        if(empty($user['ppassword'])){
			if(empty($user) || $user['password'] != $pwd || $user['status'] == 0) {
				return false;
			}
		}else{
			if(empty($user) || $user['ppassword'] != $pwd || $user['status'] == 0) {
				return false;
			}
		}
        return $user;
    }
	/**
	* 根据用户auth信息获取用户信息
	*/
	public function getloginbyauth($auth) {
		@list($password, $uid) = explode("\t", authcode($auth, 'DECODE'));
        $uid = intval($uid);
        if ($uid <= 0) {
            return FALSE;
        }
        $user = $this->getloginbyuid($uid,$password,TRUE);
		return $user;
	}
	/*
	用户名是否存在
	@param string $username
	*/
	public function exists($username){
		$sql = 'select 1 from ebh_users where username = \''.$this->db->escape_str($username).'\' limit 1';
		return $this->db->query($sql)->row_array();
	}
	/*
	邮箱是否存在
	*/
	public function existsEmail($email){
		$sql = 'select 1 from ebh_users where email = \''.$this->db->escape_str($email).'\' limit 1';
		return $this->db->query($sql)->row_array();
	}
        /**
         * 根据uid获取用户基本信息
         * @param int $uid
         * @return array 
         */
        public function getuserbyuid($uid) {
            $sql = 'select u.uid,u.username,u.groupid,u.realname,u.status,u.lastlogintime,u.sex,u.credit from ebh_users u where u.uid = '.$uid;
            return $this->db->query($sql)->row_array();
        }
        /**
         * 修改用户信息
         * @param type $param
         * @param type $uid
         */
        public function update($param,$uid) {
            $afrows = FALSE;    //影响行数
            $userarr = array();
            //修改user表信息
            if(!empty($param['username'])){
                $userarr['username'] = $param['username'];
            }
            if (!empty($param['password']))
                $userarr['password'] = md5($param['password']);
            if (isset($param['status']))
                $userarr['status'] = $param['status'];
			if (isset($param['balance']))
                $userarr['balance'] = $param['balance'];
            if (isset($param['realname']))
                $userarr['realname'] = $param['realname'];
            if (isset($param['nickname']))
                $userarr['nickname'] = $param['nickname'];
            if (isset($param['sex']))
                $userarr['sex'] = $param['sex'];
            if (isset($param['mobile']))
                $userarr['mobile'] = $param['mobile'];
            if (isset($param['email']))
                $userarr['email'] = $param['email'];
            if (isset($param['citycode']))
                $userarr['citycode'] = $param['citycode'];
            if (isset($param['address']))
                $userarr['address'] = $param['address'];
            if (isset($param['face']))
                $userarr['face'] = $param['face'];
			if(!empty($param['qqopid']))
				$userarr['qqopid'] = $param['qqopid'];
			if(!empty($param['sinaopid']))
				$userarr['sinaopid'] = $param['sinaopid'];
			if(!empty($param['lastlogintime']))
				$userarr['lastlogintime'] = $param['lastlogintime'];
			if(!empty($param['lastloginip']))
				$userarr['lastloginip'] = $param['lastloginip'];
			if(isset($param['allowip']))
				$userarr['allowip'] = $param['allowip'];
			$sarr = array();
			if(isset($param['logincount']))
				$sarr['logincount'] = 'logincount+1';
            $wherearr = array('uid' => $uid);
            if (!empty($userarr)) {
                $afrows = $this->db->update('ebh_users', $userarr, $wherearr, $sarr);
            }
            return $afrows;
        }
		
	/**
    * 根据username获取用户基本信息  场景：学校后台添加教师
    * @param int $uid
    * @return array 
    */
	public function getuserbyusername($username) {
		$sql = 'select u.uid,u.groupid,u.realname,u.sex,u.email from ebh_users u where u.username = \''.$this->db->escape_str($username).'\'';
		return $this->db->query($sql)->row_array();
	}
    /**
     * 新增一条用户记录
     *@author zkq
     *@param array $param
     *@return int uid
     *标注：1.返回0表示插入失败;2.禁止传空数组;3.禁止自定义uid;4.返回值为用户的uid,如果uid为0表示新增失败
     */
    public function _insert($param = array()){
        if(empty($param)||isset($param['uid'])){
            return 0;
        }else{
            return $this->db->insert('ebh_users',$param);
            }
    }
    /**
     *删除一条user记录
     *@author zkq
     *@param int $uid
     *@return bool
     */
    public function deletebyuid($uid=0){
        if($uid==0)return false;
        $where = array('uid'=>intval($uid));
        if($this->db->delete('ebh_users',$where)===false){
            return false;
        }else{
            return true;
        }
    }
	/*
	*原创空间的个人详细资料
	*
	*/
	public function selectedprofile($username){
		$sql = 'select u.username,u.sex,u.citycode,u.groupid,u.face,u.address,u.nickname,u.realname,m.qq,m.spacenum,m.email,m.profile from ebh_users u left join ebh_members m on m.memberid = u.uid left join ebh_cities c on u.citycode = c.citycode ';
		$wherearr = array();
		if(!empty($username))
		{
			$wherearr[] = 'u.username = \''.$username.'\'' ;
		}
		if (!empty ( $wherearr ))
		{
			 $sql .= ' WHERE '.implode(' AND ',$wherearr);
		}
		return $this->db->query($sql)->row_array();
	}
	
	/*
	qq,sina 登录
	*/
	public function openlogin ($opcode,$type,$cookietime=0) {
		if($type=='sina'){
			$sql = "SELECT username,password FROM ebh_users  WHERE sinaopid='$opcode'";	
		}else{
			$sql = "SELECT username,password FROM ebh_users  WHERE qqopid='$opcode'";
		}
		$data = $this->db->query($sql)->row_array();
		//$data = $_SGLOBAL['db']->get_one($sql);
		if($data){
			return $this->login($data['username'], $data['password'] ,true);	
		}else{
			return false;
		}
		
	}
	
	/*
	账号关联信息
	*/
	public function getAssociateInfoByUsername($username){
		$sql = 'select uid,password,qqopid,sinaopid from ebh_users where username=\''.$this->db->escape_str($username).'\'';//echo $sql;
		return $this->db->query($sql)->row_array();
	}
	
	/**
	*根据用户名列表获取用户列表
	*/
	function getuserlistbyusername($usernamelist) {
		$sql = 'select username from ebh_users where username in ('.$usernamelist.')';
		return $this->db->query($sql)->list_array();
		// $result = array();
		// $query = $_SGLOBAL['db']->query($sql);
		// while($row = $_SGLOBAL['db']->fetch_array($query)) {
			// $result[] = $row['username'];
		// }
		// return $result;
	}
	/*
	根据邮箱查询用户
	*/
	public function getUserByEmail($email) {
		$sql = 'select uid,username from ebh_users u where u.email=\'' . $this->db->escape_str($email) . '\'';
		return $this->db->query($sql)->row_array();
	}
    /**
     *根据用户uid查询用户信息(支持数组)
     *
     */
    public function getUserInfoByUid($uid){
        $uidArr = array();
        if(is_scalar($uid)){
            $uidArr = array($uid);
        }
        if(is_array($uid)){
            $uidArr = $uid;
        }
        $in = '('.implode(',',$uidArr).')';
        $sql = 'select uid,username,realname,face,sex,groupid from ebh_users where uid in '.$in;
        return $this->db->query($sql)->list_array();
    }

	/*
	searchableclassrooms表中是否存在
	*/
	public function getUserlistByUsernameOnScb($usernamelist){
		$sql = 'select username from ebh_searchableclassrooms where username in ('.$usernamelist.')';
		return $this->db->query($sql)->list_array();
	}
	
	/*
	添加到可查询用户名表中
	*/
	public function addToScb($uarr){
		$sql = 'insert into ebh_searchableclassrooms (username,realname,sex,crname,upcrid,password) values';
		foreach($uarr as $user){
			$username = str_replace('　','',str_replace(' ','',$user['username']));
			$realname = str_replace('　','',str_replace(' ','',$user['realname']));
			$sex = $user['sex'];
			$crname = $user['crname'];
			$upcrid = $user['crid'];
			$password = $user['password'];
			$sql.= " ('$username','$realname',$sex,'$crname',$upcrid,'$password'),";
		}
		$sql = rtrim($sql,',');
		$this->db->query($sql);
	}

    /**
     *获取有头像的用户列表
     */
    public function getUserListWithFace($param = array()){
        if(!empty($param['uid'])){
             $sql = 'select username,uid,face from ebh_users where face<>"" and uid = '.$param['uid'];
             return $this->db->query($sql)->list_array();
        }
        if(empty($param['limit'])){
            return;
        }
        $sql = 'select username,uid,face from ebh_users where face<>"" order by uid limit '.$param['limit'];
        return $this->db->query($sql)->list_array();
    }

    /**
     * 获取包含多个用户的数组
     * @param  array $uid_array uid数组
     * @return array            用户数组
     */
    public function getUserArray($uid_array) {
        $user_array = array();
        if (!empty($uid_array) && is_array($uid_array))
        {
            $uid_array = array_unique($uid_array);
            $sql = 'SELECT uid,username,realname FROM ebh_users WHERE uid IN(' . implode(',', $uid_array) . ')';
            $row = $this->db->query($sql)->list_array();
            foreach ($row as $v)
            {
                $user_array[$v['uid']] = array('username' => $v['username'], 'realname' => $v['realname']);
            }
        }
        return $user_array;
    }
}
