<?php

/**
 * CUser用户组件类
 */
class CUser extends CComponent {

    private $user = NULL;
    
    public function getloginuser() {
        if (isset($this->user))
            return $this->user;
        $input = EBH::app()->getInput();
        $usermodel = $this->model('user');
        $auth = $input->cookie('auth');
        if (!empty($auth)) {
            @list($password, $uid) = explode("\t", authcode($auth, 'DECODE'));
            $uid = intval($uid);
            if ($uid <= 0) {
                return FALSE;
            }
            $user = $usermodel->getloginbyuid($uid,$password,TRUE);
            if(!empty($user)) {
                $lastlogintime = $input->cookie('lasttime');
                $lastloginip = $input->cookie('lastip');
                $user['lastlogintime'] = empty($lastlogintime) ? '' : date('Y-m-d H:i',$lastlogintime);
                $user['lastloginip'] = $lastloginip;
            }
            $this->user = $user;
            return $user;
        }
        return FALSE;
    }

}