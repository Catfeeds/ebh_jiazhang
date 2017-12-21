<?php

/**
 * CRoom 用于教室平台组件类
 */
class CRoom extends CComponent {

    private $_roominfo = NULL;
	private $_checkstudent = NULL;
	private $_checkteacher = NULL;
	private $_checkadmin = NULL;
    /**
     * 获取当前平台简要信息
     * @return array 平台信息
     */
    public function getcurroom() {
        if (isset($this->_roominfo))
            return $this->_roominfo;
 //     $uri = Ebh::app()->getUri();
	    //$domain = $uri->uri_domain();
//		$do = $uri->uri_query_string();
//		$arr = explode('=',$do);
//		$domain = $arr[count($arr)-1];
		$domain = isset($_COOKIE['jz_dm'])?$_COOKIE['jz_dm']: null;
        if ($domain != '' && $domain != 'www') {
            $roommodel = $this->model('Classroom');
            $roominfo = $roommodel->getroomdetailbydomain($domain);
            $this->_roominfo = $roominfo;
            return $roominfo;
        }
        $this->_roominfo = FALSE;
        return FALSE;
    }

    /**
     * 验证当前用户是否有当前平台学生权限
	 * @param $return boolean 是否直接返回值而不跳转
     * @return boolean
     */
    public function checkstudent($return = FALSE) {
		if(isset($this->_checkstudent))
			return $this->_checkstudent;
        $user = Ebh::app()->user->getloginuser();
        if (empty($user) || $user['groupid'] != 6) {
            $url = '/';
            header("Location: $url");
            exit();
        }
//        $room = $this->getcurroom();
//        if (empty($room)) {
//            $url = geturl('');
//            header("Location: $url");
//            exit();
//        }
//		if($room['ispublic'] == 2) {	//免费试听平台，则学生都能进去
//			return true;
//		}
//        $roommodel = $this->model('Classroom');
//        $charge = ($room['isschool'] == 6 || $room['isschool'] == 7) ? true : false;	//是否为收费平台
//        $check = $roommodel->checkstudent($user['uid'], $room['crid'],$charge);
//		$this->_checkstudent = $check == 1 ? true : $check;
//        if ($check != 1 && !$return) {
//            if ($check == 2) {
//                $url = geturl('over');
//            } else {
//                $url = geturl('member');
//            }
//            header("Location: $url");
//            exit();
//        }
//		if($return && $check != 1) {
//			return $check;
//		}
        return true;
    }
	/**
	*判断用户是否有平台权限
	* @return int 返回验证结果，1表示有权限 2表示已过期 0表示用户已停用 -1表示无权限 -2参数非法
	*/
	public function checkStudentPermission($uid,$param = array()) {
		if(empty($uid))
			return -2;
		$upmodel = $this->model('Userpermission');
		return $upmodel->checkUserPermision($uid,$param);
	}
	/**
	*根据功能点或者平台等信息获取支付服务项
	*@param array $param
	*/
	public function getUserPayItem($param) {
		$upmodel = $this->model('Userpermission');
		return $upmodel->getUserPayItem($param);
	}
    /**
     * 验证当前用户是否对此平台有教师权限
	 * @param $return boolean 是否直接返回值而不跳转
     * @return boolean
     */
    public function checkteacher($return = FALSE) {
		if(isset($this->_checkteacher))
			return $this->_checkteacher;
        $user = Ebh::app()->user->getloginuser();
        if (empty($user) || $user['groupid'] != 5) {
            $url = geturl('login') . '?returnurl=' . geturl('troom');
            header("Location: $url");
            exit();
        }
        $room = $this->getcurroom();
        if (empty($room)) {
            $url = geturl('');
            header("Location: $url");
            exit();
        }
        $roommodel = $this->model('Classroom');
        $check = $roommodel->checkteacher($user['uid'], $room['crid']);
        if ($check != 1 && !$return) {
            $url = geturl('teacher/choose');
            header("Location: $url");
            return true;
        }
        if($return && $check != 1) {
			return $check;
		}
        return true;
    }
	/**
	* 验证当前用户是否对此平台有控制权限，即学校后台aroom权限 
	* 如果有管理权限则返回1，有控制查看权限（即此学校的上级学校管理者等），则返回2
	*/
	public function checkRoomControl() {
		if(isset($this->_checkadmin))
			return $this->_checkadmin;
		$user = Ebh::app()->user->getloginuser();
        if (empty($user) || $user['groupid'] != 5) {
            $url = geturl('login') . '?returnurl=' . geturl('troom');
            header("Location: $url");
            exit();
        }
        $room = $this->getcurroom();
        if (empty($room)) {
            $url = geturl('');
            header("Location: $url");
            exit();
        }
		if($room['uid'] == $user['uid']) {	//当前用户为所有者，则表示有管理权限
			$this->_checkadmin = 1;
			return 1;
		}
		if(!empty($room['upid'])) {	//如果当前用户为平台的父级平台的所有者，则具有查看权限。
			$roommodel = $this->model('Classroom');
			$haspower = $roommodel->checkcontrolteacher($user['uid'],$room['crid']);
			if($haspower) {
				$this->_checkadmin = 2;
				return 2;
			}
		}
		//其他教师，则跳转到教师教室选择页面
		$url = geturl('teacher/choose');
        header("Location: $url");
		return 0;
	}

}