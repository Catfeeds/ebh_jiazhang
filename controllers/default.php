<?php
/**
 * Description of default
 *
 * @author Administrator
 */
class DefaultController extends CControl{
    private $roominfo = NULL;
    public function __construct(){
        parent::__construct();
        $user = Ebh::app()->user->getloginuser();
        if(empty($user)){
            $this->display('index');
            exit();
        }
    }
	//登录页
    public function index() {
		$user = Ebh::app()->user->getloginuser();
		if(!empty($user)){
			$roomuser = $this->model('roomuser');
			$roomlist = $roomuser->getroomlist($user['uid']);
			$this->assign('roomlist',$roomlist);
		}
		$this->assign('user', $user);
		$this->display('index');
    }

    public function view(){
    	$crid = $this->uri->codepath;
    	$this->roominfo = $roominfo = $this->model('classroom')->getRoomByCrid($crid);
    	if(!empty($roominfo)){
    		$this->input->setcookie("dm",$roominfo['domain']);
    	}else{
            header("location:/");
            exit();
        }
    	$this->init();
        $this->display('jz');
    }

    private function init(){
        $user = Ebh::app()->user->getloginuser();
        $this->assign('user',$user);
        if(empty($this->roominfo)){
            $roominfo = Ebh::app()->room->getcurroom();
        }else{
            $roominfo = $this->roominfo;
        }
        $this->assign('room',$roominfo);
        $percent = $this->getpercent($user);
        $this->assign('percent',$percent);
        $continuous = 0;
        $credit = $this->model('credit');
        $signparam['uid'] = $user['uid'];
        $signlog = $credit->getSignLog($signparam);
        if(!empty($signlog)){
            $lastsign = $signlog[0]['dateline'];
            $today = strtotime('today');
            $todayd = Date('z',SYSTIME);
            if($lastsign>$today){//今天已签到
                $this->assign('signed',1);
                $lastday = $todayd+1;
            }else{//今天未签到
                $lastday = $todayd;
            }
            foreach($signlog as $sign){//按天数倒序计算连续性,2,1,0,364,363...
                $day = Date('z',$sign['dateline']);
                $leap = Date('L',$sign['dateline']);
                
                if($day==$todayd || $lastday-$day==1 || ($leap && $lastday-$day==-365) || (!$leap && $lastday-$day==-364)){
                    $lastday = $day;
                    $continuous ++;
                }else{
                    break;
                }
            }
        }
        
        $this->assign('continuous',$continuous);
        
        
        
        //积分等级
        $clconfig = Ebh::app()->getConfig()->load('creditlevel');
        foreach($clconfig as $clevel){
            if($user['credit']>=$clevel['min'] && $user['credit']<=$clevel['max']){
                $clinfo['title'] = $clevel['title'];
                if($user['credit']<=500){
                    $clinfo['percent'] = 50*intval($user['credit'])/500;
                }elseif($user['credit']<=3000){
                    $clinfo['percent'] = 50+30*(intval($user['credit'])-500)/2500;
                }elseif($user['credit']<=10000){
                    $clinfo['percent'] = 80+20*(intval($user['credit'])-3000)/7000;
                }else{
                    $clinfo['percent'] = 100;
                }
                break;
            }
        }
        $this->assign('clinfo',$clinfo);
        //粉丝
        $snsmodel = $this->model('Snsbase');
        $mybaseinfo = $snsmodel->getbaseinfo($user['uid']);
        $myfanscount = $mybaseinfo['fansnum'];
        //关注
        $myfavoritcount = $mybaseinfo['followsnum'];
        
        $this->assign('myfanscount',$myfanscount);
        $this->assign('myfavoritcount',$myfavoritcount);
        
        // $folderids = $this->_getfolderids();
        // $this->assign('folderids', $folderids);
        
        //我的网校
        $url = $this->input->get('url');
        $this->assign('url',$url);
        $roomuser = $this->model('roomuser');
        $roomlist = $roomuser->getroomlist($user['uid']);
        $roomcount = $roomuser->getroomcount($user['uid']);
        $this->assign('roomcount',$roomcount);
        $this->assign('roomlist',$roomlist);
        $nophoto = $this->input->cookie('nophoto'); //默认弹出修改头像后是否设置了不再显示
        $this->assign('nophoto', $nophoto); 
        $this->assign('roominfo',$roominfo);
    }

    public function getpercent($user){
        $pc = 50;
        if($user['face'])
            $pc+=10;
        $mmodel = $this->model('Member');
        $info = $mmodel->getfullinfo($user['uid']);
        unset($info['memberid'],$info['realname'],$info['face']);
        foreach($info as $value){
            if(!empty($value))
                $pc+=2;
        }
        if($pc>100){$pc=100;}
        return $pc;
    }
}
?>