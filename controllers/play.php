<?php

/**
 * 播放请求控制器
 */
class PlayController extends CControl {

    private $life = 43200; //播放点击后的缓存时间，主要用于下载等
    private $course = NULL; //存在课件course数据对象

    public function index() {
        $t = $this->input->get('t');
        $ftype = $this->input->get('ftype'); //如果 $ftype为1表示同步学堂的免费课件
        $c = $this->input->get('c');        //这里是笔记操作
        if ($c != NULL) {    //处理笔记相关操作
            $this->initnote();
        } else if ($t == 'ajax') {  //播放之前的请求操作，主要用于权限判断，返回生成的播放key等
            if ($ftype == '1') {    //免费课件的请求
                $this->initfree();
            } elseif ($ftype == '2') {
                $this->inituserplay(); //作业播放课件
            } else {
                $this->init();
            }
        } else {
            if ($ftype == '2') {
                $this->userplay(); //作业播放课件
            } else {
                $this->play();
            }
        }
    }

    /**
     * 初始化课件权限等，为播放做准备
     */
    private function init() {
        //1，验证来源有效性
        //2，验证身份
        //3，验证余额等信息
        //4，生成明码钥匙
        //5，生成加密码
        //6，设置密码并返回钥匙
        $user = Ebh::app()->user->getloginuser();
        $cwid = $this->input->get('cwid');
        $callback = $this->input->get('callback');
        if (!is_numeric($cwid)) {
            $status = array('status' => '0');
            echo $callback . '(' . json_encode($status) . ')';
            exit();
        }
        $course = $this->getplaycourse($cwid);
        if (empty($course) || $course['status'] == -3) {
            $status = array('status' => '-1');
            echo $callback . '(' . json_encode($status) . ')';
            exit();
        }
		if(empty($user) && $course['ispublic'] != 2) {	//用户未登录，且不是公开的 则需要登录
			$status = array('status' => '0');
            echo $callback . '(' . json_encode($status) . ')';
            exit();
		}
        $clientip = $this->input->getip();
		if(empty($user) && $course['ispublic'] == 2) {	//如果免费公开的学校，则不登录也能播放
			$groupid = 6;
		} else {
			$groupid = $user['groupid'];    //用户所属组ID
		}
        if ($groupid == 5 || $groupid == 6) {
            $roommodel = $this->model('Classroom');
            $studymodel = $this->model('Study');
            $timeout = 86400;
            $fprice = 0;
            if ($groupid == 6 && $course['isschool'] == 4) {  //处理点播类学校如股票的会员课件点播
                $hasjudge = $studymodel->judgeOneDay($user['uid'], $cwid, 1800);   //返回此课件半小时内是否已付费点播
                if (!$hasjudge) {    //如未付费过，则需要判断余额是否够付费，如够则扣费，否则输出错误
                    $fprice = $course['fprice'];    //课件费用
                    //当前用户余额
                    $urbalance = $roommodel->getroomuserbalance($course['crid'], $_SGLOBAL ['userinfo']['uid']);
                    if ($urbalance < $fprice) {  //余额不足
                        $status = array('status' => '-3');
                        echo $callback . '(' . json_encode($status) . ')';
                        exit();
                    }
                }
            } else {   //处理其他类型
                if ($groupid == 6) { //处理学校，网校，收费学校
					if($course['ispublic'] == 2) {
						$result = 1;
					} else {
						$ischarge =($course['isschool'] == 6 || $course['isschool'] == 7) ? TRUE : FALSE;
						$result = $roommodel->checkstudent($user['uid'], $course['crid'], $ischarge);
						if($course['isschool'] == 7) {
							if($course['fprice'] == 0) {	//如果免费课程，则直接播放
								$result = 1;
							} else {
								$perparam = array('crid'=>$course['crid'],'folderid'=>$course['folderid']);
								$result = Ebh::app()->room->checkStudentPermission($user['uid'],$perparam);
							}
						}
					}
                } else {    //验证教师权限
                    $result = $roommodel->checkteacher($user['uid'], $course['crid']);
					if($result != 1 && !empty($course['upid'])) {
						$haspower = $roommodel->checkcontrolteacher($user['uid'], $course['crid']);
						if(!empty($haspower))
							$result = 1;
					}
                }
                if ($result != 1 && $course['isshare']) {    //处理共享平台
                    $result = $roommodel->checkshareuser($course['crid'], $user['uid'], $groupid);
                }
                if ($result != 1) {  //没有播放权限的
                    $status = array('status' => '-2');
                    echo $callback . '(' . json_encode($status) . ')';
                    exit();
                }
            }
            //添加学生学习记录
//            public function pay($crid, $uid, $cwid, $price, $credit = 0, $ip, $timeOut = 86400) {
            if ($groupid == 6 && !empty($user)) {
                $studymodel->pay($course['crid'], $user['uid'], $fprice, 0, $clientip, $timeout);
                //处理积分
            }
        } else {    //除了学生和教师外的账号不允许播放
            $status = array('status' => '-2');
            echo $callback . '(' . json_encode($status) . ')';
            exit();
        }
        $ktime = SYSTIME;

        $skey = $ktime . '\t' . $cwid . '\t' . $clientip;
        $noteid = $this->input->get('nid');    //笔记编号
        if (!empty($noteid) && is_numeric($noteid)) {
            $skey .= '\t' . $noteid;
        }
        $key = authcode($skey, 'ENCODE');
        $auth = $this->input->cookie('auth');
        $auth = authcode($auth, 'ENCODE', $skey);
        $this->cache->set($key, $auth, $this->life);
        $noteparam = array();
        if ($groupid == 5 && !empty($noteid)) {
            $noteparam['noteid'] = $noteid;
        } else {
            $noteparam['uid'] = $user['uid'];
        }
        $notemodel = $this->model('Note');
        $note = $notemodel->getNote($noteparam);
        $hasnote = empty($note) ? 'N' : 'Y';
        $status = array('status' => '1', 'k' => $key, 'n' => $hasnote);
		$serverutil = Ebh::app()->lib('ServerUtil');
		$source = $serverutil->getCourseSource();
		$status['source'] = $source;
        if ($groupid == 5)
            $status['utype'] = 'T';
        echo $callback . '(' . json_encode($status) . ')';
        exit();
    }

    /**
     * 初始化免费课件的播放，如非免费课件，转到init()方法进行初始化
     * @return type
     */
    private function initfree() {
        //1，验证来源有效性
        //2，验证身份
        //3，验证余额等信息
        //4，生成明码钥匙
        //5，生成加密码
        //6，设置密码并返回钥匙
        $cwid = $this->input->get('cwid');
        $callback = $this->input->get('callback');
        if (!is_numeric($cwid)) {
            $status = array('status' => '0');
            echo $callback . '(' . json_encode($status) . ')';
            exit();
        }
        $course = $this->getplaycourse($cwid);
        if (empty($course) || $course['status'] == -3) {
            $status = array('status' => '-1');
            echo $callback . '(' . json_encode($status) . ')';
            exit();
        }
        if ($course['isfree'] != 1) { //如果不是免费课件，就按照非免费课件处理
            $this->course = $course;
            return $this->init();
        }
        $cwurl = $course['cwurl'];
        $filetype = substr($cwurl, strpos($cwurl, '.') + 1); //文件类型
        if ($filetype != 'ebh' && $filetype != 'ebhp') {  //处理课件文件为附件的情况
            $status = array('status' => '1', 'isatt' => '1');
            echo $callback . '(' . json_encode($status) . ')';
        } else {
            $ktime = SYSTIME;
            $clientip = $this->input->getip();
            $skey = $ktime . '\t' . $cwid . '\t' . $clientip;
            $key = authcode($skey, 'ENCODE');
            $status = array('status' => '1', 'k' => $key, 'ftype' => '1', 'n' => 'N');
            echo $callback . '(' . json_encode($status) . ')';
        }
        exit();
    }

    /**
     * 初始化作业播放课件方法
     */
    private function inituserplay() {
		$user = Ebh::app()->user->getloginuser();
        $cwid = $this->input->get('cwid');
        $callback = $this->input->get('callback');
        if (empty($user) || !is_numeric($cwid)) {
            $status = array('status' => '0');
            echo $callback . '(' . json_encode($status) . ')';
            exit();
        }
        $ucoursemodel = $this->model('Usercourseware');
		$course = $ucoursemodel->getUserCourse($cwid);
        if (empty($course)) {
            $status = array('status' => '-1');
            echo $callback . '(' . json_encode($status) . ')';
            exit();
        }
        $filetype = substr(strrchr($course['cwurl'], '.'), 1);
        if($filetype != 'ebh' && $filetype != 'ebhp' && $filetype !='flv'){
        	$status = array('status' => '1','isatt'=> 1);
            echo $callback . '(' . json_encode($status) . ')';
            exit();
        }

        if($filetype == 'flv'){
        	$status = array('status' => '1','isflv'=> 1);
            echo $callback . '(' . json_encode($status) . ')';
            exit();
        }
        $ktime = SYSTIME;
        $clientip = $this->input->getip();
        $skey = $ktime . '\t' . $cwid . '\t' . $clientip;
        $key = authcode($skey, 'ENCODE');
        $status = array('status' => '1', 'k' => $key, 'ftype' => '2', 'n' => 'N');
		$serverutil = Ebh::app()->lib('ServerUtil');
		$source = $serverutil->getCourseSource();
		$status['source'] = $source;
        echo $callback . '(' . json_encode($status) . ')';
        exit();
    }

    private function play() {
        $key = $this->input->get('k');
        $useragent = strtolower($_SERVER['HTTP_USER_AGENT']);
        //判断来源是否合法
		if ((strpos($useragent, 'www.ebanhui.com') === false && strpos($useragent, 'ebhplayer') === false && strpos($useragent, 'android') === false) || empty($key))
		{
	//
		}

        $skey = authcode($key, 'DECODE');
        list($ktime, $cwid, $cip) = explode('\t', $skey);
        $clientip = $this->input->getip();
        if (empty($ktime) || empty($cwid) || empty($cip) || !is_numeric($ktime) || (intval($ktime) + $this->life) < SYSTIME || !is_numeric($cwid) || $cip != $clientip) {
			log_message('2密匙不合法或已失效');
            exit();
	}
        $course = $this->getplaycourse($cwid);

        if (!empty($course)) {
            $cwurl = $course['cwurl'];
            $cwname = $course['title'];
            getfile('course', $cwurl, $cwname);
        } else {
            echo '课件不存在';
        }
    }
	/**
	*作业解析课件播放
	*/
    private function userplay() {
        $key = $this->input->get('k');
        $useragent = strtolower($_SERVER['HTTP_USER_AGENT']);
		//判断来源是否合法
		if ((strpos($useragent, 'www.ebanhui.com') === false && strpos($useragent, 'ebhplayer') === false && strpos($useragent, 'android') === false) || empty($key))
		{
			exit();
		}
		$skey = authcode($key, 'DECODE');
        list($ktime, $cwid, $cip) = explode('\t', $skey);
		$clientip = $this->input->getip();
		if (empty($ktime) || empty($cwid) || empty($cip) || !is_numeric($ktime) || (intval($ktime) + $this->life) < SYSTIME || !is_numeric($cwid) || $cip != $clientip) {
			error(2,'密匙不合法或已失效');
		}
		//判断用户登录,暂不考虑媒体中心用户的判断
		if($cwid > 0) {
			$ucoursemodel = $this->model('Usercourseware');
			$course = $ucoursemodel->getUserCourse($cwid);
			if(!empty($course)) {
				$cwurl = $course['cwurl'];
				$cwname = $course['title'];
				getfile('course',$cwurl,$cwname);
			}
		}
    } 
	/**
	*处理课件笔记相关接口
	*/
    private function initnote() {
		$key = $this->input->get('k');
		$useragent = $_SERVER['HTTP_USER_AGENT'];
		$skey = authcode($key,'DECODE');
		$pauth = $this->cache->get($key);
		if (empty($skey)) {
			log_message("error 1:skey is null");
			exit();
		}
		@list($ktime,$cwid,$cip,$nid) = explode('\t', $skey);
		if (empty($ktime) || empty($cwid) || empty($cip) || !is_numeric($ktime) || (intval($ktime) + $this->life) < SYSTIME || !is_numeric($cwid) || $cip != $this->input->getip()) {
			log_message("error 2:key is out date");
			exit();
		}
		$auth = authcode($pauth,'DECODE',$skey);
		$usermodel = $this->model('User');
		$user = $usermodel->getloginbyauth($auth);
		if(empty($user)) {
			log_message("error 3: user not exists");
			exit();
		}
		$groupid = $user['groupid'];
		if($groupid != 5 && $groupid != 6) {	//只能教师或学生用功能
			log_message("error 4: error user type");
			exit();
		}
		$c = $this->input->get('c');	//比较操作指令
		$notemodel = $this->model('Note');
		if($c == 1) {	//添加或编辑笔记
			$param = array();
			if (!empty($nid) && $groupid == 5) {	//老师查看学生笔记
				$param['noteid'] = $nid; 
			} else {
				$param['uid'] = $user['uid'];
			}
			$param['cwid'] = $cwid;
			$note = $notemodel->getNote($param);
			//上传附件
			$uploader = Ebh::app()->lib('Uploader');
			//上传配置
			$config = array(
				"savePath" => "uploads/" ,             //存储文件夹
				"showPath" => "uploads/" ,              //显示文件夹
				"maxSize" => 2097152 ,                   //允许的文件最大尺寸，单位字节 2M
				"allowFiles" => array( ".ebhn")  //允许的文件格式 笔记格式;
			);
			$_UP = Ebh::app()->getConfig()->load('upconfig');
			$up_type = 'note';
			$savepath = 'uploads/';
			$showpath = 'uploads/';
			if(!empty($_UP[$up_type]['savepath'])){
				$savepath = $_UP[$up_type]['savepath'];
			}
			if(!empty($_UP[$up_type]['showpath'])){
				$showpath = $_UP[$up_type]['showpath'];
			}
			$config['savePath'] = $savepath;
			$config['showPath'] = $showpath;
			$upfield = 'FileName';
			if(!empty($note)) {	//已存在，覆盖笔记
				$url = $note['url'];
				$pos = strrpos($url,'/');
				$folder = substr($url,0,$pos+1);
				$filename = substr($url,$pos + 1);
				$uploader->setFolder($folder);
				$uploader->setName($filename);
			}
			$uploader->init($upfield,$config);
			$info = $uploader->getFileInfo();
			if($info['state'] == 'SUCCESS') {
				if(!empty($note)) {	//更新笔记
					$noteparam = array('size'=>$info['size']);
					$notemodel->update($noteparam,$note['noteid']);
				} else {	//添加笔记
					$course = $this->getplaycourse($cwid);
					if(!empty($course)) {
						$source = 'http://'.$_SERVER['HTTP_HOST'].'/';
						$crid = $course['crid'];
						$noteparam = array('crid'=>$crid,'cwid'=>$cwid,'uid'=>$user['uid'],'source'=>$source,'url'=>$info['url'],'size'=>$info['size']);
						$notemodel->insert($noteparam);
					}
				}
			}
		} else if($c == 2) {	//下载笔记
			$param = array();
			if (!empty($nid) && $groupid == 5) {	//老师查看学生笔记
				$param['noteid'] = $nid; 
			} else {
				$param['uid'] = $user['uid'];
			}
			$param['cwid'] = $cwid;
			$note = $notemodel->getNote($param);
			if(!empty($note)) {
				getfile('note',$note['url']);
			}
		} else if($c == 3) {	//删除笔记
			$param = array('uid'=>$user['uid'],'cwid'=>$cwid);
			$notes = $notemodel->getNoteList($param);
			if(!empty($notes)) {
				foreach($notes as $note) {
					$delparam = array('noteid'=>$note['noteid'],'uid'=>$user['uid']);
					$afrows = $notemodel->delete($delparam);
					if($afrows > 0) {
						delfile('note',$note['url']);
					}
				}
			}
		} else if($c == 6) {	//上传图片
			$uploader = Ebh::app()->lib('Uploader');
			//上传配置
			$config = array(
				"savePath" => "uploads/" ,             //存储文件夹
				"showPath" => "uploads/" ,              //显示文件夹
				"maxSize" => 2097152 ,                   //允许的文件最大尺寸，单位字节 2M
				"allowFiles" => array( ".jpg",".jpeg",".gif")  //允许的文件格式 笔记格式;
			);
			$_UP = Ebh::app()->getConfig()->load('upconfig');
			$up_type = 'noteatta';
			$savepath = 'uploads/';
			$showpath = 'uploads/';
			if(!empty($_UP[$up_type]['savepath'])){
				$savepath = $_UP[$up_type]['savepath'];
			}
			if(!empty($_UP[$up_type]['showpath'])){
				$showpath = $_UP[$up_type]['showpath'];
			}
			$config['savePath'] = $savepath;
			$config['showPath'] = $showpath;
			$upfield = 'FileName';
			$uploader->init($upfield,$config);
			$info = $uploader->getFileInfo();
			if($info['state'] == 'SUCCESS') {
				echo $info['showurl'];
			}
		} else if($c == 4) {	//听课完成
			if($groupid == 6) {	//只有学生才添加听课完成记录
				$ctime = $this->input->get('ctime');
				$ltime = $this->input->get('ltime');
				if(is_numeric($ctime) && $ctime > 0 && is_numeric($ltime) && $ltime > 0) {
					$studymodel = $this->model('Studylog');
					$param = array('uid'=>$user['uid'],'cwid'=>$cwid,'ctime'=>$ctime,'ltime'=>$ltime);
					$afrows = $studymodel->addlog($param);
				}
			}
		}
    }
	/**
	*根据课件ID获取课件播放所需的内容
	*此方法基础上可以考虑加入缓存等因素提高效率
	*/
	function getplaycourse($cwid) {
		if(isset($this->course))
			return $this->course;
		$memlife = 30;	//默认缓存30秒
		$memkey = 'cw_'.$cwid;
		$course = $this->cache->get($memkey);
		if(empty($course)) {
			$coursemodel = $this->model('Courseware');
			$course = $coursemodel->getplaycoursedetail($cwid);
			$this->cache->set($memkey,$course,$memlife);
		}
		$this->course = $course;
		return $course;
	}
}