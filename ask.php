<?php
/**
*答疑提问接口
*/
//初始化应用程序
define('IN_EBH', TRUE);
define('S_ROOT', dirname(__FILE__).DIRECTORY_SEPARATOR);
define('IS_DEBUG', FALSE);  //是否开启调试状态
date_default_timezone_set('Asia/Shanghai');
$config = S_ROOT.'config/config.php';
require S_ROOT.'system/core/runtime.php';
Ebh::createIndexApplication($config)->run();

//处理请求
$key = empty($_GET['key'])?'':$_GET['key'];	//值为new时候 表示提交问题，否则为提交解答
$t = empty($_GET['t'])?'':$_GET['t'];		
$life = 43200;	//cookie和密匙有效期为2分钟
if ($t == 'ajax')	//初始化播放请求/主要通过js 调用的情况 如解答问题
{
	init();
}
else 
{
	if($key == 'new')
		addquestion();
	else
		play();
}

/*
 * 初始化答疑权限等，为播放和解答做准备
 */
function init()
{

	//1，验证来源有效性
	//2，验证身份
	//3，验证余额等信息
	//4，生成明码钥匙
	//5，生成加密码
	//6，设置密码并返回钥匙
	//判断用户请求权限
	global $life;
	$auth = Ebh::app()->getInput()->cookie('auth');
	$qid = intval($_GET['qid']);
	if (empty($auth) || $qid <= 0){
		$status = array('status'=>'0');
		echo $_GET['callback'].'('.json_encode($status).')';
		exit();
	}
	$usermodel = Ebh::app()->model('User');
	$user = $usermodel->getloginbyauth($auth);
	if (empty($user)) {
		$status = array('status'=>'0');
		echo $_GET['callback'].'('.json_encode($status).')';
		exit();
	}
	if ($user['groupid'] != 5 && $user['groupid'] != 6) {	//不允许教师和学生之外的用户播放
		$status = array('status'=>'-2');
		echo $_GET['callback'].'('.json_encode($status).')';
		exit();
	}
	//获取答疑信息
	$askmodel = Ebh::app()->model('Askquestion');
	$askdetail = $askmodel->getaskbyqid($qid);
	if(empty($askdetail)) {
		$status = array('status'=>'-1');
		echo $_GET['callback'].'('.json_encode($status).')';
		exit();
	}
	$ktime = SYSTIME;
	$clientip = Ebh::app()->getInput()->getip();
	$skey = $ktime.'\t'.$qid.'\t'.$clientip;

	$key = authcode($skey, 'ENCODE');
	$auth = authcode($auth,'ENCODE',$skey);
	
	Ebh::app()->getCache()->set($key, $auth, $life);
	$status = array('status'=>'1','k'=>$key);
	echo $_GET['callback'].'('.json_encode($status).')';
	exit();
}
/*
 * 流程如下：
	1:判断来源是否会e板会播放器
	2:判断key是否合法
	3:判断用户是否登录，判断是否非法
	4:判断用户身份，会员、代理商、老师等
	5:根据权限处理，扣费等
	6:返回课件文件
 * 
 */
/*
 * 课件播放
 */
function play() 
{
	global $life;
	$key = $_GET['k'];	//获取验证信息
	if(empty($key))
		exit();
	$useragent = strtolower($_SERVER['HTTP_USER_AGENT']);
	$pauth = Ebh::app()->getCache()->get($key);
	//判断来源是否合法
	if ((strpos($useragent, 'www.ebanhui.com') === false && strpos($useragent, 'ebhplayer') === false && strpos($useragent, 'android') === false) || empty($key) || empty($pauth))
	{
	//	error(1);
	}
	$skey = authcode($key,'DECODE');
	if (empty($skey)) {
		log_message('密匙出错，key:'.$key.' skey为空');
		exit();
	}
	list($ktime,$qid,$cip) = explode('\t', $skey);
	
	if (empty($ktime) || empty($qid) || empty($cip) || !is_numeric($ktime) || (intval($ktime) + $life) < time() || !is_numeric($qid) || $cip != Ebh::app()->getInput()->getip()) {
		log_message('密匙不合法或已失效');
		exit();
	}
	//判断用户权限
	$auth = authcode($pauth,'DECODE',$skey);
	$usermodel = Ebh::app()->model('User');
	$user = $usermodel->getloginbyauth($auth);
	if (empty($user)) {
		log_message('会员验证失败');
		exit();
	}
	if ($user['groupid'] != 5 && $user['groupid'] != 6) {
		log_message('非法的用户类型');
		exit();
	}
	//获取答疑信息
	if($qid > 0) {	//提交回答
		$askmodel = Ebh::app()->model('Askquestion');
		$answertype = 1;
		$message = $_POST['txt'];
		if(!empty($message))
			$message = iconv("GB2312","UTF-8//IGNORE",$message) ;
		$imagefileinfo = uploadfile('image','pic','277_195');	//图片上传处理
		$imagesrc = '';
		$imagename = '';
		if($imagefileinfo['state'] == 'SUCCESS') {
			$imagesrc = $imagefileinfo['showurl'];
			$imagename = $imagefileinfo['name'];
		}
		$audiofileinfo = uploadfile('audio');	//音频上传处理
		$audiosrc = '';
		$audioname = '';
		if($audiofileinfo['state'] == 'SUCCESS') {
			$audiosrc = $audiofileinfo['showurl'];
			$audioname = $audiofileinfo['name'];
		}
		$attfileinfo = uploadfile('att');	//相关附件上传处理
		$attsrc = '';
		$attname = '';
		if($attfileinfo['state'] == 'SUCCESS') {
			$attsrc = $attfileinfo['showurl'];
			$attname = $attfileinfo['name'];
		}
		$fromip = $this->input->getip();
		$param = array('qid'=>$qid,'uid'=>$user['uid'],'message'=>$message,'audioname'=>$audioname,'audiosrc'=>$audiosrc,'imagename'=>$imagename,'imagesrc'=>$imagesrc,'attname'=>$attname,'attsrc'=>$attsrc,'fromip'=>$fromip);
		$aid = $askmodel->addanswer($param);
		if($aid > 0) {
			$url = 'http://www.ebanhui.com/question/'.$qid.'.html';
			echo $url;
		}
	}
}

/**
* 上传答疑的相关附件
* @param string $upfield 上传$_FILES的字段名
* @param string $type 附件类型
* @param string $imagesize 当为图片类型时，需要处理的图片缩略图尺寸
*/
function uploadfile($upfield='',$type='',$imagesize='') {
	if(empty($upfield))
		return '';
	$uplib = Ebh::app()->lib('Uploader');
	//上传配置
    $config = array(
        "savePath" => "uploads/" ,             //存储文件夹
        "showPath" => "uploads/" ,              //显示文件夹
        "maxSize" => 5242880 ,                   //允许的文件最大尺寸，单位字节 5M
        "allowFiles" => array( ".ebh" , ".ebhp" , ".wav" , ".jpg" , ".jpeg" )  //允许的文件格式
    );
	$_UP = Ebh::app()->getConfig()->load('upconfig');
	$up_type = 'ask';
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
	$uplib->setFolder(NULL);
	$uplib->setName(NULL);
    $uplib->init($upfield,$config);
    $info = $uplib->getFileInfo();
	//如果是图片，并且需要裁减，则根据尺寸进行裁减
    if($type == 'pic' && $info['state'] == 'SUCCESS' && !empty($imagesize)) { //答疑上传的图片需要裁减
		Ebh::app()->helper('image');
		$imagepath = $info['url'];
		$imagesapath = $savepath.$imagepath;
        thumb($imagesapath,$imagesize);
    }
	return $info;
}

/*
 * 流程如下：
	1:判断来源是否会e板会播放器
	2:判断key是否合法
	3:判断用户是否登录，判断是否非法
	4:判断用户身份，会员、代理商、老师等
	5:根据权限处理，扣费等
	6:返回课件文件
 * 
 */
/*
 * 通过软件提问
 */
function addquestion() 
{
	$key = empty($_POST['k'])?'':$_POST['k'];	//获取验证信息
	
	//1，判断k是否正确，若正确则模拟教师登录
	if(empty($key))
		exit();
	$user = '';
	if (!empty($key)) {
		$user = Ebh::app()->getCache()->get($key);
		if (empty($user)) {
		//	echoerror('非法操作或过期，请使用软件重新操作!');

			//如果不是通过软件正常进入，则重新登录一次看看
			$skey = authcode($key,'DECODE');
			list($ktime,$uid,$password,$clientip) = explode('\t', $skey);
			$auth = authcode("$password\t$uid", 'ENCODE');
			$userobj = Ebh::app()->model('User');
			$user = $userobj->getloginbyauth($auth);
			if (empty($user)) {
				exit();
			}
		} else {
			$skey = authcode($key,'DECODE');
			list($ktime,$uid,$password,$clientip) = explode('\t', $skey);
		}

		$cip = Ebh::app()->getInput()->getip();
		if ($cip != $clientip) {	//非法参数 非法地址请求
			exit();
		}
		
	}
	$useragent = strtolower($_SERVER['HTTP_USER_AGENT']);
	//判断来源是否合法
	if ((strpos($useragent, 'www.ebanhui.com') === false && strpos($useragent, 'ebhplayer') === false && strpos($useragent, 'android') === false))
	{
		//error(1);
		exit();
	}
	//开始添加
	$folderid = $_POST['cid'];
	$crid = intval($_POST['rid']);
	$title = $_POST['title'];
	if(!empty($title))
		$title = iconv("GB2312","UTF-8//IGNORE",$title) ;
	$message = $_POST['txt'];
	$catpath = $_POST['catpath'];	//已选分类的中文路径
	if(!empty($catpath))
		$catpath = iconv("GB2312","UTF-8//IGNORE",$catpath) ;
	if(!empty($message))
		$message = iconv("GB2312","UTF-8//IGNORE",$message) ;
	$imagefileinfo = uploadfile('image','pic','277_195');	//图片上传处理
	$imagesrc = '';
	$imagename = '';
	if($imagefileinfo['state'] == 'SUCCESS') {
		$imagesrc = $imagefileinfo['showurl'];
		$imagename = $imagefileinfo['name'];
	}
	$audiofileinfo = uploadfile('audio');	//音频上传处理
	$audiosrc = '';
	$audioname = '';
	if($audiofileinfo['state'] == 'SUCCESS') {
		$audiosrc = $audiofileinfo['showurl'];
		$audioname = $audiofileinfo['name'];
	}
	$attfileinfo = uploadfile('att');	//相关附件上传处理
	$attsrc = '';
	$attname = '';
	if($attfileinfo['state'] == 'SUCCESS') {
		$attsrc = $attfileinfo['showurl'];
		$attname = $attfileinfo['name'];
	}
	$fromip = $this->input->getip();
	$param = array('uid'=>$uid,'crid'=>$crid,'title'=>$title,'message'=>$message,'imagename'=>$imagename,'imagesrc'=>$imagesrc,'audioname'=>$audioname,'audiosrc'=>$audiosrc,'attname'=>$attname,'attsrc'=>$attsrc,'fromip'=>$fromip);
	if($crid > 0) {
		$param['folderid'] = intval($folderid);
	} else {
		$catarr = explode('_',$folderid);
		$catid = isset($catarr[1])?intval($catarr[1]):(isset($catarr[0])?intval($catarr[0]):0);
		$grade = isset($catarr[2])?intval($catarr[2]):0;
		$param['catid'] = $catid;
		$param['grade'] = $grade;
		//答疑专区->高中教育_历史与社会_高三
		$strindex = strpos($catpath,'答疑专区->');
		$strstart = $strindex === false ? 0 : ($strindex + strlen('答疑专区->'));
		$catpath = substr($catpath,$strstart);
		$catpath = str_replace('_','/',$catpath);
		$param['catpath'] = $catpath;
	}
	$askmodel = Ebh::app()->model('Askquestion');
	$qid = $askmodel->insert($param);
	if($qid > 0) {
		//积分处理预留
		$url = 'http://www.ebanhui.com/question/'.$qid.'.html';
		echo $url;
	}
}

?>