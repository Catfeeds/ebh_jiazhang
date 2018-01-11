<?php
/*
人气+1处理
*/
class Viewnum{
	function addViewnum($type,$id){
		// $stime = microtime(true);
		$redis = Ebh::app()->getCache('cache_redis');
		$viewnum = $redis->hget($type.'viewnum',$id);
		$themodel = Ebh::app()->model($type);
        if(empty($viewnum)) {
			if($type == 'courseware'){
				$result = $themodel->getSimplecourseByCwid($id);
			}elseif($type == 'folder'){
				$result = $themodel->getfolderbyid($id);
			}elseif($type == 'pads'){
				$result = $themodel->getOneByaid($id);
			}elseif($type == 'pitems'){
				$result = $themodel->getOneByItemid($id);
			}elseif($type == 'resource'){
				$result = $themodel->getOneByResid($id);
			}
			$viewnum = $result['viewnum'];
			$redis->hset($type.'viewnum',$id,$viewnum);
        }
		$viewnum++;
		$redis->hIncrBy($type.'viewnum',$id);
		
		if($viewnum%500 == 0){
			$themodel->setviewnum($id,$viewnum);
		}
		// $etime = microtime(true);
		// echo $etime - $stime;
	}

    /**
     * 从缓存中读取值，如果空值就返回缺省值(数据库中值)
     * @param $type
     * @param $id
     * @param null $default 缺省值
     * @return null
     */
	function getViewnum($type,$id, $default = null){
		$redis = Ebh::app()->getCache('cache_redis');
		$viewnum = $redis->hget($type.'viewnum',$id);
		if (empty($viewnum)) {
		    return intval($default);
        }
		return intval($viewnum);
	}
	//判断该用户对该课程是否允许人气加1
	function isAllowedAddViewnum($cwid, $uid){
		$limittime = 3600;//一个小时内不允许加1
		$redis = Ebh::app()->getCache('cache_redis');
		$lastviewtime = $redis->get('vt_'.$cwid.$uid);
		$lastviewtime = empty($lastviewtime) ? 0 : intval($lastviewtime);
		return (SYSTIME - $lastviewtime) > $limittime ? 1 : 0; 
	}
	//设置用户人气加1的时间
	function setAddViewnumTime($cwid, $uid){
		$redis = Ebh::app()->getCache('cache_redis');
		$redis->set('vt_'.$cwid.$uid,intval(SYSTIME));
	}
}
?>