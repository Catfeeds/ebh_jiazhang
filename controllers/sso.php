<?php

/**
 * SSO多域名共享登录控制器
 * 主要用于多域名的登录同步
 */
class SsoController extends CControl {

    public function index() {
        $k = $this->input->get('k');
		if(!empty($k)) {	//进行cookie注入
			$ssoarray = array();
			$ssovalue = base64_decode($k);
			$life = 600;	//此链接只有10分钟有效期
			if(!empty($ssovalue)) {
				@list($auth,$lasttime,$thistime,$lastip,$cookietime,$ctime) = explode('___',$ssovalue);
				if(!empty($ctime) && is_numeric($ctime) && (SYSTIME - $ctime < $life)) {
					header('P3P: CP="CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR"');
					$cookietime = empty($cookietime) ? 0 : intval($cookietime);
					if(empty($auth)) {
						$auth = '0';
						$lasttime = '0';
						$thistime = '0';
						$lastip = '0';
						$cookietime = 360;
					}
					$this->input->setcookie('auth', $auth, $cookietime);
					$this->input->setcookie('lasttime', $lasttime, $cookietime);
					$this->input->setcookie('thistime', $thistime, $cookietime);
					$this->input->setcookie('lastip', $lastip, $cookietime);
					
					$im = imagecreatetruecolor(1, 1);
					$text_color = imagecolorallocate($im, 233, 14, 91);
					//imagestring($im, 1, 5, 5,  'A Simple Text String', $text_color);

					// Set the content type header - in this case image/jpeg
					header('Content-Type: image/jpeg');

					// Output the image
					imagejpeg($im);

					// Free up memory
					imagedestroy($im);
				}
			}
		}
    }
}
