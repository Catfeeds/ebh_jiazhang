<?php 
/*
网校公共模块
*/
class AppmoduleModel extends CModel{
    /**
     * 所有可选用的模块列表
     * @param array $param 查询参数
     * @param bool $setKey 是否以moduleid为键
     * @return mixed
     */
	public function getmodulelist($param=array(), $setKey = false){
		$sql = 'select moduleid,modulename,modulecode,system,url,classname,isdynamic,isfree,logo,target,isstrict,showmode,tors,modulename_t,url_t,ismore,moduleid as displayorder from ebh_appmodules';
		if(isset($param['system']))
			$wherearr[] = 'system='.$param['system'];
		if(isset($param['tors']))
			$wherearr[] = 'tors in('.$param['tors'].')';
		if(isset($param['showmode']))
			$wherearr[] = 'showmode='.$param['showmode'];
		if(isset($param['ismore']))
			$wherearr[] = 'ismore='.$param['ismore'];
		if(!empty($param['q']))
			$wherearr[] = '(modulename like \'%'.$this->db->escape_str($param['q']).'%\' or modulecode like \'%'.$this->db->escape_str($param['q']).'%\'';
		if(!empty($wherearr))
			$sql.= ' where '.implode(' AND ',$wherearr);
		if(!empty($param['limit'])) {
            $sql .= ' limit '.$param['limit'];
        } else {
			if (empty($param['page']) || $param['page'] < 1)
				$page = 1;
			else
				$page = $param['page'];
			$pagesize = empty($param['pagesize']) ? 10 : $param['pagesize'];
			$start = ($page - 1) * $pagesize;
			$sql .= ' limit ' . $start . ',' . $pagesize;
        }
		return $this->db->query($sql)->list_array($setKey ? 'moduleid' : '');
	}
	
	/*
	所有模块数量
	*/
	public function getmodulecount($param){
		$sql = 'select count(*) count from ebh_appmodules';
		if(isset($param['system']))
			$wherearr[] = 'system='.$param['system'];
		if(!empty($param['q']))
			$wherearr[] = '(modulename like \'%'.$this->db->escape_str($param['q']).'%\' or modulecode like \'%'.$this->db->escape_str($param['q']).'%\'';
		if(!empty($wherearr))
			$sql.= ' where '.implode(' AND ',$wherearr);
		$count = $this->db->query($sql)->row_array();
		return $count['count'];
	}
	/*
	学校选用的模块
	*/
	public function getroommodulelist($param){
		if(empty($param['crid']))
			exit;
		$sql = 'select crid,rm.moduleid,nickname,available,displayorder,rm.ismore,modulecode from ebh_roommodules rm left join ebh_appmodules am on rm.moduleid=am.moduleid';
		$wherearr[] = 'crid='.$param['crid'];
		if (isset($param['tors'])) {
            $wherearr[] = 'rm.tors='.$param['tors'];
        }

		$sql.= ' where '.implode(' AND ',$wherearr);
		if(!empty($param['order']))
			$sql.= ' order by '.$param['order'];
		return $this->db->query($sql)->list_array();
	}
	
	
	/*
	学校后台编辑模块
	*/
	public function savemodule($param){
		if(empty($param['crid']) || empty($param['modulearr']))
			exit;
		$crid = $param['crid'];
		$tors = $param['tors'];
		//是否有数据
		$sql = 'select 1 from ebh_roommodules where crid='.$crid;
		$modulelist = $this->db->query($sql)->row_array();
		
		
		if(empty($modulelist)){//没有则新增
			$insertsql = 'insert into ebh_roommodules (crid,moduleid,nickname,available,displayorder,tors,ismore) values ';
			$sql = 'select moduleid,modulename,modulename_t,ismore from ebh_appmodules where system = 1';
			$modulelist = $this->db->query($sql)->list_array();
			foreach($modulelist as $module){
				$modulearr[$module['moduleid']] = $module;
			}
			foreach($param['modulearr'] as $k=>$module){

				if(!empty($modulearr[$module['moduleid']])){
					$moduleid = $module['moduleid'];
					$nickname = $module['nickname'];
					$available = $module['available'];
					$displayorder = $k;
					$ismore = $module['ismore'];
					$insertsql.= "($crid,$moduleid,'$nickname',$available,$displayorder,$tors,$ismore),";
					$insertsql.= "($crid,$moduleid,'',1,$displayorder,1-$tors,$ismore),";
				}else{
					$illegal = true;
					break;
				}
				unset($modulearr[$module['moduleid']]);
			}
			//系统的全加上
			if(!empty($modulearr)){
				foreach($modulearr as $l=>$module){
					$moduleid = $module['moduleid'];
					$nickname = '';
					$available = 1;
					$ismore = $module['ismore'];
					$displayorder = count($param['modulearr'])+$l;
					$insertsql.= "($crid,$moduleid,'$nickname',$available,$displayorder,0,$ismore),";
					$insertsql.= "($crid,$moduleid,'$nickname',$available,$displayorder,1,$ismore),";
				}
			}
			if(empty($illegal)){
				$insertsql = rtrim($insertsql,',');
				$this->db->query($insertsql);
			}
		}else{
			foreach($param['modulearr'] as $k=>$module){
				$nickname = $module['nickname'];
				$available = $module['available'];
				$displayorder = $k;
				$moduleid = $module['moduleid'];
				$ismore = $module['ismore'];
				$sql = "update ebh_roommodules set nickname='$nickname',available=$available,displayorder=$displayorder,ismore=$ismore where moduleid=$moduleid and crid=$crid and tors=$tors;";
				$this->db->query($sql);
			}
		}
	}
	
	/*
	学生后台显示的模块
	*/
	public function getstudentmodule($param, $setKey = false){
		if(empty($param['crid']))
			exit;
		$sql = 'select rm.moduleid,rm.nickname,rm.available,rm.displayorder,am.modulename,am.url,am.isdynamic,am.classname,am.target,am.isstrict,modulename_t,url_t,rm.ismore,modulecode
			from ebh_roommodules rm join ebh_appmodules am on rm.moduleid=am.moduleid';
		$wherearr[] = 'crid='.$param['crid'];
		if(isset($param['system']))
			$wherearr[] = 'system='.$param['system'];
		if(isset($param['isfree']))
			$wherearr[] = 'isfree='.$param['isfree'];
		if(isset($param['available']))
			$wherearr[] = 'available='.$param['available'];
		if(!empty($param['modulecode']))
			$wherearr[] = "modulecode='".$this->db->escape_str($param['modulecode'])."'";
		if(isset($param['tors']))
			$wherearr[] = 'rm.tors in('.$param['tors'].') and am.tors in ('.$param['tors'].')';
		if(isset($param['showmode']))
			$wherearr[] = 'showmode='.$param['showmode'];
		if(isset($param['ismore']))
			$wherearr[] = 'rm.ismore='.$param['ismore'];
		$sql .= ' where '.implode(' AND ',$wherearr);
		if(!empty($param['order']))
			$sql .= ' order by '.$param['order'];
		if(!empty($param['limit'])) {
            $sql .= ' limit '.$param['limit'];
        } else {
			if (empty($param['page']) || $param['page'] < 1)
				$page = 1;
			else
				$page = $param['page'];
			$pagesize = empty($param['pagesize']) ? 10 : $param['pagesize'];
			$start = ($page - 1) * $pagesize;
			$sql .= ' limit ' . $start . ',' . $pagesize;
        }
		return $this->db->query($sql)->list_array($setKey ? 'moduleid': '');
	}
	
	/*
	旧数据myroomleft
	*/
	public function getroomlefts(){
		$sql = 'select crid, myroomleft from ebh_classrooms where myroomleft<>\'\'';
		return $this->db->query($sql)->list_array();
	}
	
	/*
	新增网校模块权限,旧数据迁移用
	*/
	public function addroommodule($param){
		$modulelist = $this->getmodulelist();
		foreach($modulelist as $module){
			$modulelist[$module['modulecode']] = $module;
		}
		// var_dump($param);
		$sql = 'insert into ebh_roommodules (crid,moduleid,nickname,available,displayorder) values ';
		foreach($param as $modulearr){
			foreach($modulearr['modulelist'] as $k=>$module){
				$valuestr = '('.$modulearr['crid'].',';
				// $tempmodule = $modulelist[$module['code']];
				$moduleid = $modulelist[$module['code']]['moduleid'];
				$nickname = $module['nickname'];
				$available = $module['available'];
				$displayorder = $k;
				$valuestr .= "$moduleid,'$nickname',$available,$displayorder)";
				$sql .= $valuestr.',';
			}
		}
		$sql = rtrim($sql,',');
		$this->db->query($sql);
	}
	
	/*
	配置过模块的网校
	*/
	public function getclassroomlist($param){
		$sql = 'select distinct(cr.crid),crname,domain from ebh_classrooms cr join ebh_roommodules rm on cr.crid=rm.crid';
		
		if(!empty($param['q']))
			$wherearr[] = '(cr.crname like \'%'.$this->db->escape_str($param['q']).'%\' or cr.domain like \'%'.$this->db->escape_str($param['q']).'%\')';
		if(!empty($wherearr))
			$sql.= ' where '.implode(' AND ',$wherearr);
		
		if(!empty($param['limit'])) {
            $sql .= ' limit '.$param['limit'];
        } else {
			if (empty($param['page']) || $param['page'] < 1)
				$page = 1;
			else
				$page = $param['page'];
			$pagesize = empty($param['pagesize']) ? 10 : $param['pagesize'];
			$start = ($page - 1) * $pagesize;
			$sql .= ' limit ' . $start . ',' . $pagesize;
        }
		return $this->db->query($sql)->list_array();
	}
	/*
	配置过模块的网校数量
	*/
	public function getclassroomcount(){
		$sql = 'select count(distinct(cr.crid)) count from ebh_classrooms cr join ebh_roommodules rm on cr.crid=rm.crid';
		if(!empty($param['q']))
			$wherearr[] = '(cr.crname like \'%'.$this->db->escape_str($param['q']).'%\' or cr.domain like \'%'.$this->db->escape_str($param['q']).'%\')';
		if(!empty($wherearr))
			$sql.= ' where '.implode(' AND ',$wherearr);
		$count = $this->db->query($sql)->row_array();
		return $count['count'];
	}
	
	/*
	网校模块权限编辑
	*/
	public function roommoduleedit($param, $useNew = false){
		if ($useNew) {
		    if (empty($param['crid']) || empty($param['modulelist'])) {
		        return false;
            }
		    return $this->roomModule($param['crid'], $param['modulelist']);
        }
		$crid = $param['crid'];
		$sql = 'select moduleid,crid from ebh_roommodules where crid='.$crid.' and tors=0';
		$oldlist = $this->db->query($sql)->list_array();
		// var_dump($oldlist);
		// var_dump($param);
		
		//之前的权限和现在的权限比对
		foreach($oldlist as $j=>$oldmodule){
			foreach($param['modulelist'] as $k=>$module){
				if($oldmodule['moduleid'] == $module){
					unset($oldlist[$j]);
					unset($param['modulelist'][$k]);
				}
			}
		}
		$this->db->begin_trans();
		//不要的删掉
		if(!empty($oldlist)){
			$delmoduleids = '';
			foreach($oldlist as $module){
				$delmoduleids .= $module['moduleid'].',';
			}
			$delmoduleids = rtrim($delmoduleids,',');
			$delsql = 'delete from ebh_roommodules where crid='.$crid.' and moduleid in('.$delmoduleids.')';
			$this->db->query($delsql);
		}
		//新增的加上
		if(!empty($param['modulelist'])){
			$insertsql = 'insert into ebh_roommodules (crid,moduleid,nickname,available,displayorder,tors,ismore) values ';
			$insertsql_t = 'insert into ebh_roommodules (crid,moduleid,nickname,available,displayorder,tors,ismore) values ';
			$valuestr = '';
			$valuestr_t = '';
			
			$infosql = 'select moduleid,ismore from ebh_appmodules where moduleid in ('.implode(',',$param['modulelist']).')';
			$modulelist = $this->db->query($infosql)->list_array();
			
			foreach($modulelist as $k=>$module){
				// var_dump($moduleid);
				$moduleid = $module['moduleid'];
				$ismore = $module['ismore'];
				if(!empty($moduleid)){
					$displayorder = $k+10;
					$valuestr.= "($crid,$moduleid,'',1,$displayorder,0,$ismore),";
					$valuestr_t.= "($crid,$moduleid,'',1,$displayorder,1,$ismore),";
				}
			}
			if(!empty($valuestr)){
				$insertsql .= rtrim($valuestr,',');
				$insertsql_t .= rtrim($valuestr_t,',');
				
				$this->db->query($insertsql);
				$this->db->query($insertsql_t);
			}
		}
		
		if($this->db->trans_status()===FALSE) {
            $this->db->rollback_trans();
            return FALSE;
        } else {
            $this->db->commit_trans();
        }
		return TRUE;
	}

    /**
     * admin后台设置网校模块
     * @param $crid
     * @param $modulelist
     * @return bool
     */
	public function roomModule($crid, $modulelist) {
	    $crid = intval($crid);
	    $modulelist = array_map('intval', $modulelist);
	    $modulelist = array_filter($modulelist, function($moduleid) {
	        return $moduleid > 0;
        });
        $sql = 'SELECT `moduleid`,`tors`,`system`,`ismore` FROM `ebh_appmodules`';
        $modules = $this->db->query($sql)->list_array('moduleid');
        //系统模块
        $system_modules = array_filter($modules, function($module) {
           return !empty($module['system']) ;
        });
        //组件模块
        if (!empty($system_modules)) {
            $system_module_keys = array_keys($system_modules);
            $modulelist = array_diff($modulelist, $system_module_keys);

            $modules = array_diff_key($modules, $system_modules);
        }

        if (!empty($modules)) {
            $module_keys = array_keys($modules);
            $modulelist = array_intersect($modulelist, $module_keys);
        }
        //网校模块配置
        $room_modules = $this->db->query('SELECT `moduleid`,`tors` FROM `ebh_roommodules` WHERE `crid`='.$crid)->list_array();
        $room_type_modules = array();
        if (!empty($room_modules)) {
            foreach ($room_modules as $room_module) {
                $room_type_modules[$room_module['moduleid'].'-'.$room_module['tors']] = $room_module;
            }
            unset($room_modules);
        }
        $student_modules = $teacher_modules = array();
        foreach ($system_modules as $system_module) {
            //系统模块设置
            if ($system_module['tors'] == 0 || $system_module['tors'] == 2) {
                if (isset($room_type_modules[$system_module['moduleid'].'-0'])) {
                    unset($room_type_modules[$system_module['moduleid'].'-0']);
                } else {
                    $student_modules[] = $system_module;
                }
            }
            if ($system_module['tors'] == 1 || $system_module['tors'] == 2) {
                if (isset($room_type_modules[$system_module['moduleid'].'-1'])) {
                    unset($room_type_modules[$system_module['moduleid'].'-1']);
                } else {
                    $teacher_modules[] = $system_module;
                }
            }
        }
        if (!empty($modulelist)) {
            //组件模块设置
            foreach ($modulelist as $moduleitem) {
                $module = $modules[$moduleitem];
                if ($module['tors'] == 0 || $module['tors'] == 2) {
                    if (isset($room_type_modules[$module['moduleid'].'-0'])) {
                        unset($room_type_modules[$module['moduleid'].'-0']);
                    } else {
                        $student_modules[] = $module;
                    }
                }
                if ($module['tors'] == 1 || $module['tors'] == 2) {
                    if (isset($room_type_modules[$module['moduleid'].'-1'])) {
                        unset($room_type_modules[$module['moduleid'].'-1']);
                    } else {
                        $teacher_modules[] = $module;
                    }
                }
            }
        }
        $this->db->begin_trans();
        //删除无效配置
        foreach ($room_type_modules as $delete_module) {
            $this->db->delete('ebh_roommodules', array(
                'crid' => $crid,
                'moduleid' => $delete_module['moduleid'],
                'tors' => $delete_module['tors']
            ));
            if ($this->db->trans_status() === false) {
                $this->db->rollback_trans();
                return false;
            }
        }
        //添加学生模块
        foreach ($student_modules as $student_module) {
            $this->db->insert('ebh_roommodules', array(
                'crid' => $crid,
                'moduleid' => $student_module['moduleid'],
                'tors' => 0,
                'available' => 1,
                'displayorder' => $student_module['moduleid'],
                'ismore' => $student_module['ismore']
            ));
            if ($this->db->trans_status() === false) {
                $this->db->rollback_trans();
                return false;
            }
        }
        //添加教师模块
        foreach ($teacher_modules as $teacher_module) {
            $this->db->insert('ebh_roommodules', array(
                'crid' => $crid,
                'moduleid' => $teacher_module['moduleid'],
                'tors' => 1,
                'available' => 1,
                'displayorder' => $teacher_module['moduleid'],
                'ismore' => $teacher_module['ismore']
            ));
            if ($this->db->trans_status() === false) {
                $this->db->rollback_trans();
                return false;
            }
        }
        $this->db->commit_trans();
        return true;
    }
	
	/*
	添加模块
	*/
	public function addappmodule($param){
		if(isset($param['modulename']))
			$setarr['modulename'] = $param['modulename'];
		if(isset($param['modulecode']))
			$setarr['modulecode'] = $param['modulecode'];
		if(isset($param['url']))
			$setarr['url'] = $param['url'];
		if(isset($param['system']))
			$setarr['system'] = $param['system'];
		if(isset($param['classname']))
			$setarr['classname'] = $param['classname'];
		if(isset($param['target']))
			$setarr['target'] = $param['target'];
		if(isset($param['isstrict']))
			$setarr['isstrict'] = $param['isstrict'];
		if(isset($param['tors']))
			$setarr['tors'] = $param['tors'];
		if(isset($param['showmode']))
			$setarr['showmode'] = $param['showmode'];
		if(isset($param['modulename_t']))
			$setarr['modulename_t'] = $param['modulename_t'];
		if(isset($param['url_t']))
			$setarr['url_t'] = $param['url_t'];
		if(isset($param['ismore']))
			$setarr['ismore'] = $param['ismore'];
		if (isset($param['remark'])) {
            $setarr['remark'] = $param['remark'];
        }
        if (isset($param['remark_t'])) {
            $setarr['remark_t'] = $param['remark_t'];
        }
		$this->db->insert('ebh_appmodules',$setarr);
	}
	
	/*
	编辑模块
	*/
	public function editappmodule($param){
		if(empty($param['moduleid'])) {
		    return false;
        }
		$wherearr['moduleid'] = $param['moduleid'];
		if(isset($param['modulename']))
			$setarr['modulename'] = $param['modulename'];
		if(isset($param['modulecode']))
			$setarr['modulecode'] = $param['modulecode'];
		if(isset($param['url']))
			$setarr['url'] = $param['url'];
		if(isset($param['system']))
			$setarr['system'] = $param['system'];
		if(isset($param['classname']))
			$setarr['classname'] = $param['classname'];
		if(isset($param['target']))
			$setarr['target'] = $param['target'];
		if(isset($param['isstrict']))
			$setarr['isstrict'] = $param['isstrict'];
		if(isset($param['tors']))
			$setarr['tors'] = $param['tors'];
		if(isset($param['showmode']))
			$setarr['showmode'] = $param['showmode'];
		if(isset($param['modulename_t']))
			$setarr['modulename_t'] = $param['modulename_t'];
		if(isset($param['url_t']))
			$setarr['url_t'] = $param['url_t'];
		if (isset($param['remark'])) {
		    $setarr['remark'] = $param['remark'];
        }
        if (isset($param['remark_t'])) {
            $setarr['remark_t'] = $param['remark_t'];
        }
        if(isset($param['ismore'])) {
            $setarr['ismore'] = $param['ismore'];
        }

        if (!empty($param['tors'])) {
		    $setarr['ismore'] = 0;
        }
		return $this->db->update('ebh_appmodules',$setarr,$wherearr);
	}
	
	/*
	按moduleid获取模块信息
	*/
	public function getmoduleinfo($moduleid){
		$sql = 'select moduleid,modulename,modulecode,system,url,classname,isdynamic,isfree,logo,target,isstrict,tors,showmode,modulename_t,url_t,remark,remark_t,ismore from ebh_appmodules where moduleid='.$moduleid;
		return $this->db->query($sql)->row_array();
	}
	
	/*
	删除应用模块
	*/
	public function del($moduleid){
		if(empty($moduleid) || !is_numeric($moduleid))
			exit;
		$wherearr['moduleid'] = $moduleid;
		return $this->db->delete('ebh_appmodules',$wherearr);
	}

    /**
     * 删除模块，并且删除网校的模块配置
     * @param $moduleid 模块ID
     * @return mixed
     */
	public function remove($moduleid) {
	    $moduleid = (int) $moduleid;
	    if ($moduleid < 1) {
	        return false;
        }
        $this->db->begin_trans();
        $affected_rows = $this->db->delete('ebh_appmodules', array('moduleid' => $moduleid));
        if ($this->db->trans_status() === false) {
            $this->db->rollback_trans();
            return false;
        }
        if ($affected_rows > 0) {
            $this->db->delete('ebh_roommodules', array('moduleid' => $moduleid));
            if ($this->db->trans_status() === false) {
                $this->db->rollback_trans();
                return false;
            }
        }
        $this->db->commit_trans();
        return $affected_rows;
    }
	/*
	给系统应用模块 添加各网校的对应关系
	*/
	public function initsystemmodule($moduleid){
		if(empty($moduleid) || !is_numeric($moduleid))
			exit;
		$msql = 'select moduleid,ismore from ebh_appmodules where moduleid='.$moduleid;
		$moduleinfo = $this->db->query($msql)->row_array();
		if(empty($moduleinfo))
			return false;
		$ismore = $moduleinfo['ismore'];
		$sql = 'select distinct(crid) from ebh_roommodules where crid not in (select distinct(crid) from ebh_roommodules where moduleid ='.$moduleid.')';
		$crids = $this->db->query($sql)->list_array();
		if(!empty($crids)){
			$insertsql = 'insert into ebh_roommodules (crid,moduleid,nickname,available,displayorder,tors,ismore) values ';
			$displayorder = SYSTIME;
			foreach($crids as $v){
				$crid = $v['crid'];
				$insertsql.= "($crid,$moduleid,'',1,$displayorder,0,$ismore),";
				$insertsql.= "($crid,$moduleid,'',1,$displayorder,1,$ismore),";
			}
			$insertsql = rtrim($insertsql,',');
			
			$this->db->query($insertsql);
		}
		return true;
		
	}
	
	/*
	根据modulecode获取modulename,nickname等
	*/
	public function getmodulenamebycode($param){
		$sql = 'select modulecode,modulename,modulename_t,nickname
				from ebh_appmodules am 
				join ebh_roommodules rm on am.moduleid=rm.moduleid';
		$wherearr[] = 'modulecode=\''.$param['modulecode'].'\'';
		$wherearr[] = 'rm.tors='.$param['tors'];
		$wherearr[] = 'rm.crid='.$param['crid'];
		$sql .= ' where '.implode(' AND ',$wherearr);
		return $this->db->query($sql)->row_array();
	}
	/*
	根据modulecode获取classname等
	*/
    public function getClassnameByCode($param){
        $sql = 'select classname from ebh_appmodules';
        if(!empty($param['modulecode'])){
            $sql.=' where modulecode = \''.$param['modulecode'].'\'';
        }
        return $this->db->query($sql)->row_array();
    }
    /*
    根据moudleid以及搜索内容获取classroom信息
     */
    public function getclassroomlistbymid($param){
    	$sql = 'select distinct(cr.crid),cr.crname,cr.domain from ebh_classrooms cr join ebh_roommodules rm on (cr.crid=rm.crid)';
		
		if(!empty($param['q']))
			$wherearr[] = '(cr.crname like \'%'.$this->db->escape_str($param['q']).'%\' or cr.domain like \'%'.$this->db->escape_str($param['q']).'%\')';
		if(!empty($param['moduleid'])){
			$wherearr[] = 'rm.moduleid = '.$param['moduleid'];
		}
		if(!empty($wherearr))
			$sql.= ' where '.implode(' AND ',$wherearr);
		
		if(!empty($param['limit'])) {
            $sql .= ' limit '.$param['limit'];
        } else {
			if (empty($param['page']) || $param['page'] < 1)
				$page = 1;
			else
				$page = $param['page'];
			$pagesize = empty($param['pagesize']) ? 10 : $param['pagesize'];
			$start = ($page - 1) * $pagesize;
			$sql .= ' limit ' . $start . ',' . $pagesize;
        }
        return $this->db->query($sql)->list_array();
    }
    /*
    根据moudleid和搜索内容获取符合条件教室总数
     */
    public function getclassroomcountbymid($param){
    	$sql = 'select count(distinct(cr.crid)) count from ebh_classrooms cr join ebh_roommodules rm on (cr.crid=rm.crid)';
		if(!empty($param['q']))
			$wherearr[] = '(cr.crname like \'%'.$this->db->escape_str($param['q']).'%\' or cr.domain like \'%'.$this->db->escape_str($param['q']).'%\')';
		if(!empty($param['moduleid'])){
			$wherearr[] = 'rm.moduleid = '.$param['moduleid'];
		}
		if(!empty($wherearr))
			$sql.= ' where '.implode(' AND ',$wherearr);
		$count = $this->db->query($sql)->row_array();
		return $count['count'];
    }
    /**
     * 根据modulecode获取模块的相关信息
     */
    public function getModuleInfoByCode($modulecode){
    	if(empty($modulecode)){
    		return false;
    	}
    	$sql = 'select moduleid,modulename,url,url_t,isdynamic,classname,target,isstrict,modulename_t from `ebh_appmodules` where modulecode ='.$this->db->escape($modulecode);
    	return $this->db->query($sql)->row_array();
    }
	
	/*
	将更多模块移到第7个,旧数据迁移用
	*/
	public function replacemore($moduleid){
		$sql = 'select distinct(crid) crid from ebh_roommodules';
		$crlist = $this->db->query($sql)->list_array();
		$this->db->begin_trans();
		foreach($crlist as $cr){
			$crid = $cr['crid'];
			$sql = 'select displayorder	from ebh_roommodules where crid='.$crid.' and tors = 0 order by displayorder limit 5,1';
			$ordersix = $this->db->query($sql)->row_array();
			// echo $sql;
			$displayorder = $ordersix['displayorder'];
			$upsql = "update ebh_roommodules set displayorder=displayorder+1 where crid=$crid and displayorder>$displayorder";
			$this->db->query($upsql);
			$upsql = "update ebh_roommodules set displayorder=$displayorder+1 where crid=$crid and moduleid=$moduleid";
			$this->db->query($upsql);
		}
		if ($this->db->trans_status() === FALSE) {
            $this->db->rollback_trans();
            return FALSE;
        } else {
            $this->db->commit_trans();
        }
		return TRUE;
	}

	/*
	检测某网校是否有模块的权限
	*/
	public function checkRoomMoudle($crid,$url_t){
		if (empty($crid) OR empty($url_t)) {
			return FALSE;
		}
		$sql = 'select moduleid from ebh_roommodules rm left join ebh_appmodules am using (moduleid) where rm.crid ='.$crid.' and am.url_t=\''.$url_t.'\'';
		return $this->db->query($sql)->list_array();
	}

	/*
	创建网校，默认模块
	*/
	public function defaultmodule($param){
		$tlist = $param['tlist'];
		$slist = $param['slist'];
		$crid = $param['crid'];
		$insertsql = 'insert into ebh_roommodules (crid,moduleid,nickname,available,displayorder,tors,ismore) values ';
		$insertsql_t = 'insert into ebh_roommodules (crid,moduleid,nickname,available,displayorder,tors,ismore) values ';
		$infosql = 'select moduleid,ismore from ebh_appmodules where moduleid in ('.implode(',',$param['modulelist']).')';
		$modulelist = $this->db->query($infosql)->list_array();
		$valuestr = $valuestr_t = '';
		foreach($modulelist as $k=>$module){
				// var_dump($moduleid);
			$moduleid = $module['moduleid'];
			$ismore = $module['ismore'];
			if(!empty($moduleid)){
				$sdisplayorder = array_search($moduleid,$slist);
				$tdisplayorder = array_search($moduleid,$tlist);
				if($sdisplayorder === FALSE || $sdisplayorder === NULL)
					$sdisplayorder = 99;
				if($tdisplayorder === FALSE || $tdisplayorder === NULL)
					$tdisplayorder = 99;
				$valuestr.= "($crid,$moduleid,'',1,$sdisplayorder,0,$ismore),";
				$valuestr_t.= "($crid,$moduleid,'',1,$tdisplayorder,1,$ismore),";
			}
		}
		$insertsql .= rtrim($valuestr,',');
		$insertsql_t .= rtrim($valuestr_t,',');
		
		$this->db->begin_trans();
		
		$this->db->query($insertsql);
		$this->db->query($insertsql_t);
		
		if($this->db->trans_status()===FALSE) {
            $this->db->rollback_trans();
            return FALSE;
        } else {
            $this->db->commit_trans();
        }
		return TRUE;
		
	}

    /**
     * 删除
     * @param $moduleid
     * @return bool
     */
	public function recycleModule($moduleid) {
	    $moduleid = (int) $moduleid;
	    if ($moduleid < 1) {
	        return false;
        }
        return $this->db->delete('ebh_roommodules', array('moduleid' => $moduleid));
    }

    /**
     * 修改模块类型后同步网校模块配置数据
     * @param $moduleid 模块ID
     * @return bool
     */
    public function syncRoomModule($moduleid) {
	    $moduleid = (int) $moduleid;
	    $module = $this->db->query(
	        'SELECT `tors`,`system`,`ismore` FROM `ebh_appmodules` WHERE `moduleid`='.$moduleid)
            ->row_array();
	    if (empty($module)) {
	        return false;
        }
        if ($module['tors'] == 0) {
            //将教师模块配置复制为学生模块配置
            $sql = 'INSERT INTO `ebh_roommodules`(`crid`,`moduleid`,`available`,`tors`,`ismore`,`displayorder`) 
                  SELECT `crid`,'.$moduleid.',`available`,0,'.$module['ismore'].','.$moduleid.' from `ebh_roommodules` 
                  WHERE `moduleid`='.$moduleid.' AND `tors`=1
                  AND NOT EXISTS(SELECT 1 FROM `ebh_roommodules` `b` WHERE `b`.`moduleid`='.$moduleid.' AND `b`.`tors`=0 AND `b`.`crid`=`crid`)';
            $this->db->query($sql);
            //学生模块，删除教师模块自定义设置
            $this->db->delete('ebh_roommodules', array(
                'moduleid' => $moduleid,
                'tors' => 1
            ));
            return true;
        } else if ($module['tors'] == 1) {
            //将学生模块配置复制为教师模块配置
            $sql = 'INSERT INTO `ebh_roommodules`(`crid`,`moduleid`,`available`,`tors`,`ismore`,`displayorder`) 
                  SELECT `crid`,'.$moduleid.',`available`,1,'.$module['ismore'].','.$moduleid.' from `ebh_roommodules` 
                  WHERE `moduleid`='.$moduleid.' AND `tors`=0
                  AND NOT EXISTS(SELECT 1 FROM `ebh_roommodules` `b` WHERE `b`.`moduleid`='.$moduleid.' AND `b`.`tors`=1 AND `b`.`crid`=`crid`)';
            $this->db->query($sql);
            //教师模块，删除学生模块自定义设置
            $this->db->delete('ebh_roommodules', array(
                'moduleid' => $moduleid,
                'tors' => 0
            ));
            return true;
        }
        if ($module['tors'] == 2) {
	        //教师学生模块，同步双份设置
            //将教师模块配置复制为学生模块配置
            $sql = 'INSERT INTO `ebh_roommodules`(`crid`,`moduleid`,`available`,`tors`,`ismore`,`displayorder`) 
                  SELECT `crid`,'.$moduleid.',`available`,0,'.$module['ismore'].','.$moduleid.' from `ebh_roommodules` 
                  WHERE `moduleid`='.$moduleid.' AND `tors`=1
                  AND NOT EXISTS(SELECT 1 FROM `ebh_roommodules` `b` WHERE `b`.`moduleid`='.$moduleid.' AND `b`.`tors`=0 AND `b`.`crid`=`crid`)';
            $this->db->query($sql);
            //将学生模块配置复制为教师模块配置
            $sql = 'INSERT INTO `ebh_roommodules`(`crid`,`moduleid`,`available`,`tors`,`ismore`,`displayorder`) 
                  SELECT `crid`,'.$moduleid.',`available`,1,'.$module['ismore'].','.$moduleid.' from `ebh_roommodules` 
                  WHERE `moduleid`='.$moduleid.' AND `tors`=0
                  AND NOT EXISTS(SELECT 1 FROM `ebh_roommodules` `b` WHERE `b`.`moduleid`='.$moduleid.' AND `b`.`tors`=1 AND `b`.`crid`=`crid`)';
            $this->db->query($sql);
        }
        return true;
    }

    /**
     * 网校模块启用配置
     * @param $crid
     * @param bool $setKey
     * @return mixed
     */
    public function getRoomModuleSet($crid, $setKey = false) {
        $crid = (int) $crid;
        $sql = 'SELECT `a`.`moduleid`,`a`.`available` FROM `ebh_roommodules` `a`
              LEFT JOIN `ebh_appmodules` `b` ON `a`.`moduleid`=`b`.`moduleid`
               WHERE `a`.`crid`='.$crid;
        return $this->db->query($sql)->list_array($setKey ? 'moduleid':'');
    }


    /*
	学生后台显示的模块
	*/
    public function getRoomSet($param, $setKey = false){
        if(empty($param['crid']))
            exit;
        $sql = 'select rm.moduleid,rm.nickname,rm.available,rm.displayorder,am.modulename,am.url,am.isdynamic,am.classname,am.target,am.isstrict,modulename_t,url_t,rm.ismore,modulecode
			from ebh_roommodules rm left join ebh_appmodules am on rm.moduleid=am.moduleid';
        $wherearr[] = 'crid='.$param['crid'];
        if(isset($param['system']))
            $wherearr[] = 'system='.$param['system'];
        if(isset($param['isfree']))
            $wherearr[] = 'isfree='.$param['isfree'];
        if(isset($param['available']))
            $wherearr[] = 'available='.$param['available'];
        if(!empty($param['modulecode']))
            $wherearr[] = "modulecode='".$this->db->escape_str($param['modulecode'])."'";
        if(isset($param['tors']))
            $wherearr[] = 'rm.tors in('.$param['tors'].') and am.tors in ('.$param['tors'].')';
        if(isset($param['showmode']))
            $wherearr[] = 'showmode='.$param['showmode'];
        if(isset($param['ismore']))
            $wherearr[] = 'rm.ismore='.$param['ismore'];
        $sql .= ' where '.implode(' AND ',$wherearr);
        if(!empty($param['order']))
            $sql .= ' order by '.$param['order'];
        if(!empty($param['limit'])) {
            $sql .= ' limit '.$param['limit'];
        } else {
            if (empty($param['page']) || $param['page'] < 1)
                $page = 1;
            else
                $page = $param['page'];
            $pagesize = empty($param['pagesize']) ? 10 : $param['pagesize'];
            $start = ($page - 1) * $pagesize;
            $sql .= ' limit ' . $start . ',' . $pagesize;
        }
        return $this->db->query($sql)->list_array($setKey ? 'moduleid': '');
    }

    /**
     * 判断是否启用空间模块
     * @param $crid 网校ID
     * @param $tor 模块类型
     * @return bool
     */
    public function checkSns($crid, $tor) {
        $sns = $this->db->query(
            'SELECT `moduleid` FROM `ebh_appmodules` WHERE `modulecode`=\'sns\'')
            ->row_array();
        if (empty($sns)) {
            return false;
        }
        $sql = 'SELECT `available` FROM `ebh_roommodules` WHERE `crid`='.
            intval($crid).' AND `tors`='.intval($tor).' AND `moduleid`='.intval($sns['moduleid']);
        $available = $this->db->query($sql)->row_array();
        if (empty($available)) {
            return true;
        }
        if (empty($available['available'])) {
            return false;
        }
        return true;
    }
}