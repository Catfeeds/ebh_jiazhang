<?php
/**
 * logout控制器类
 * 主要用来控制用户的退出登录
 */
class LogoutController extends CControl{
    public function index() {
        $cookietime = -365 * 66400;
		$this->input->setcookie('auth','',$cookietime);
		$this->input->setcookie('dm','',$cookietime);
        $this->input->setcookie('lasttime','',$cookietime);
		$this->input->setcookie('thistime','',$cookietime);
        $this->input->setcookie('lastip','',$cookietime);
        $returnurl = '/';
		$durl = '';
		$ctime = SYSTIME;	//当前时间，主要用于验证此SSO请求是否是已过期的
		if(!empty(Ebh::app()->domains)) {	//处理多域名配置，如果存在多域名，则需要对其他域名cookie注入操作
			$curdomain = $this->uri->curdomain;
			if(!empty($curdomain) && in_array($curdomain,Ebh::app()->domains)) {
				$ctime = SYSTIME;	//当前时间，主要用于验证此SSO请求是否是已过期的
				$ssovalue = '0___0___0___0___0___'.$ctime;
				$ssovalue = base64_encode($ssovalue);
				foreach(Ebh::app()->domains as $mydomain) {
					if($mydomain != $curdomain) {
						$durl = 'http://www.'.$mydomain.'/sso.html?k='.$ssovalue;
						break;
					}
				}
			}
		}
		$this->assign('returnurl',$returnurl);
		$this->assign('durl',$durl);
        $this->display('logout');
    }
}
