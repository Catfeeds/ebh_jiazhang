<?php
class StudyController extends CControl {
    public function __construct() {
        parent::__construct();
		$user = Ebh::app()->user->getloginuser();
		$check = TRUE;
        $dm = $this->input->cookie('dm');
		if(empty($user['uid']) || empty($dm)) {
			$check = Ebh::app()->room->checkstudent(TRUE);
			if (empty($dm)) {
				$url = '/';
				header("Location: $url");
				exit();
			}
		} else {
			Ebh::app()->room->checkstudent();
		}
		$this->assign('check',$check);
    }
	public function index(){
		$roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();
		$classmodel = $this->model('Classes');
		$myclass = $classmodel->getClassByUid($roominfo['crid'],$user['uid']);
		$foldermodel = $this->model('Folder');
		$queryarr = parsequery();
		$queryarr['crid'] = $roominfo['crid'];
		if(!empty($myclass['classid']))
			$queryarr['classid'] = $myclass['classid'];
		else{
			$this->showempty();
			exit;
		}
		if(!empty($myclass['grade']))
			$queryarr['grade'] = $myclass['grade'];
		$queryarr['pagesize'] = 100;
		$queryarr['order'] = '  displayorder asc,folderid desc';
		$folders = $foldermodel->getClassFolder($queryarr);

		if($roominfo['isschool'] == 7) {	//收费分成学校，则未开通或已过期的课程，就显示阴影和开通按钮
			$user = Ebh::app()->user->getloginuser();
			$spmodel = $this->model('PayPackage');
			$thelist = $spmodel->getsplist(array('crid'=>$roominfo['crid'],'status'=>1,'displayorder'=>'displayorder asc,pid desc','limit'=>1000));
			$splist = array();
			$spidlist = '';
			//将结果数组以pid为下标排列,并记录pid合集字符串
			foreach($thelist as $mysp) {
				$splist[$mysp['pid']] = $mysp;
				$splist[$mysp['pid']]['itemlist'] = array();
				if(empty($spidlist)) {
					$spidlist = $mysp['pid'];
				} else {
					$spidlist .= ','.$mysp['pid'];
				}
			}
			///////开通的课程
			$folders = $splist;
			if(!empty($spidlist)) {
				$pitemmodel = $this->model('PayItem');
				$itemparam = array('limit'=>100,'pidlist'=>$spidlist,'displayorder'=>'s.sdisplayorder is null,sdisplayorder,i.pid,f.displayorder','power'=>0);
				$itemlist = $pitemmodel->getItemFolderList($itemparam);
				if(!empty($itemlist)) {
					foreach($itemlist as $myitem) {
						if(isset($folders[$myitem['pid']])) {
							$folders[$myitem['pid']]['itemlist'][] = $myitem;
						}
					}
				}
			}
			$mylist = array();
			if(!empty($user) && $user['groupid'] == 6) {
				$userpermodel = $this->model('Userpermission');
				$myperparam = array('uid'=>$user['uid'],'crid'=>$roominfo['crid'],'filterdate'=>1);
				$myfolderlist = $userpermodel->getUserPayFolderList($myperparam);
				foreach($myfolderlist as $myfolder) {
					$mylist[$myfolder['folderid']] = $myfolder;
				}
			}
			foreach($folders as $k=>$package){
				$showpack = false;
				foreach($package['itemlist'] as $l=>$folder){
					if($folder['fprice']==0 || isset($mylist[$folder['folderid']])){
						$showpack = true;
						if(empty($folderids))
							$folderids = $folder['folderid'];
						else
							$folderids .= ','.$folder['folderid'];
					}
					else
						unset($folders[$k]['itemlist'][$l]);
				}
				if($showpack == false)
					unset($folders[$k]);
			}
			
			
			///////////未开通的课程
			if(!empty($spidlist)) {
				$pitemmodel = $this->model('PayItem');
				$itemparam = array('limit'=>100,'pidlist'=>$spidlist,'displayorder'=>'i.pid,f.displayorder','uid'=>$user['uid'],'crid'=>$roominfo['crid'],'power'=>0);
				$itemlist = $pitemmodel->getItemFolderListNotPaid($itemparam);
				// var_dump($itemlist);
				if(!empty($itemlist)) {
					foreach($itemlist as $myitem) {
						$myitem['payurl'] = 'http://'.$roominfo['domain'].'.'.$this->uri->curdomain.'/ibuy.html?itemid='.$myitem['itemid'].'&sid='.$myitem['sid'];
						if($roominfo['domain'] == 'yxwl') {	//易学网络 专门处理，直接跳转到转账
							$myitem['payurl'] = '/classactive/bank.html';
						}
						if(isset($splist[$myitem['pid']])) {
							$splist[$myitem['pid']]['itemlist'][] = $myitem;
						}
						
					}
				}
			}
			$this->assign('splist',$splist);
		}
		
		$this->assign('roominfo',$roominfo);
		
		
		
		
		if(!empty($folders)){
			if($roominfo['isschool'] != 7){
				$folderids = '';
				foreach($folders as $folder){
					$folderids.= $folder['folderid'].',';
				}
				//folderid集合字符串
				$folderids = rtrim($folderids,',');
			}
			
			
			$pmodel = $this->model('progress');
			$param['folderid'] = $folderids;
			
			//课程集合下的视频课件
			$param['limit'] = 10000;
			$coursewarelist = $pmodel->getCWByFolderid($param);
			// var_dump($coursewarelist);
			$cwids = '';
			
			//cwid=>folderid对应数组
			$cwidfolderidlist =array();
			if(!empty($coursewarelist)){
				$countlist = $pmodel->getFolderProgressCountByFolderid($param);
				foreach($countlist as $f){
					$foldercwcount[$f['folderid']] = $f['count'];
				}
				foreach($coursewarelist as $cw){
					$cwids.= $cw['cwid'].',';
					$cwidfolderidlist[$cw['cwid']] = $cw['folderid'];
				}
				// var_dump($cwidfolderidlist);
				$cwids = rtrim($cwids,',');
				$param['cwid'] = $cwids;
				$param['uid'] = $user['uid'];
				
				//根据cwid获取进度,添加到对应 课程进度 数组中
				$folderprogress = array();
				$progresslist = $pmodel->getFolderProgressByCwid($param);
				// var_dump($progresslist);
				foreach($progresslist as $p){
					$folderid = $cwidfolderidlist[$p['cwid']];
					if($p['percent']*100>=90){
						$folderprogress[$folderid][] = 100;
						// var_dump($p);
						if(empty($foldercredit[$folderid]['study'])){//听课完成的数量
							$foldercredit[$folderid]['study'] = 1;
							
						}
						else
							$foldercredit[$folderid]['study'] += 1;
					}
					else
						$folderprogress[$folderid][] = $p['percent']*100;
				}
				//根据cwid获取听课时长总合,添加到对应 课程时长 数组中
				$foldersumtime = array();
				$sumtimelist = $pmodel->getCourseSumTime($param);
				foreach($sumtimelist as $s){
					$folderid = $cwidfolderidlist[$s['cwid']];
					if(empty($foldersumtime[$folderid]))
						$foldersumtime[$folderid] = $s['sumtime'];
					else
						$foldersumtime[$folderid] += $s['sumtime'];
				}
				// var_dump($foldersumtime);
				// exit;
				
				//作业完成情况
				$examcreditlist = $foldermodel->getUserFolderExamCredit(array('uid'=>$user['uid'],'folderid'=>$folderids));
				foreach($examcreditlist as $examcredit){
					$folderid = $examcredit['folderid'];
					if(empty($foldercredit[$folderid]['exam']))
						$foldercredit[$folderid]['exam'] = $examcredit['examcredit'];
					else
						$foldercredit[$folderid]['exam'] += $examcredit['examcredit'];
				}
				//作业总数
				$countlist = $foldermodel->getFolderExamCount(array('folderid'=>$folderids));
				// var_dump($countlist);
				foreach($countlist as $f){
					$folderexamcount[$f['folderid']] = $f['count'];
				}
				// var_dump($folderprogress);
				// exit;
				
				//课程进度数组计算结果记录到课程列表的进度字段
				if($roominfo['isschool'] != 7){
					foreach($folders as $k=>$folder){
						$folderid = $folder['folderid'];
						if(!empty($folderprogress[$folderid])){
							$folders[$k]['percent'] = floor(array_sum($folderprogress[$folderid])/$foldercwcount[$folderid]);
							if(empty($foldercwcount[$folderid])){
								$folders[$k]['studyfinishpercent'] = 0;
							}else{
								$fscredit = empty($foldercredit[$folderid]['study'])?0:$foldercredit[$folderid]['study'];
								$folders[$k]['studyfinishpercent'] = $fscredit/$foldercwcount[$folderid];
							}
							if(empty($folderexamcount[$folderid])){
								$folders[$k]['examscorepercent'] = 0;
							}else{
								$fecredit = empty($foldercredit[$folderid]['exam'])?0:$foldercredit[$folderid]['exam'];
								$folders[$k]['examscorepercent'] = $fecredit/$folderexamcount[$folderid];
							}
							
							if(empty($folder['creditrule'])){
								$creditrule[0] = 100;
								$creditrule[1] = 0;
							}else{
								$creditrule = explode(':',$folder['creditrule']);
							}
							// var_dump($creditrule);
							$folders[$k]['creditget'] = round($folder['credit']*($creditrule[0]*$folders[$k]['studyfinishpercent']+$creditrule[1]*$folders[$k]['examscorepercent'])/100,2);
							
						}
						else{
							$folders[$k]['percent'] = 0;
							$folders[$k]['creditget'] = 0;
						}
						
						if(!empty($foldersumtime[$folderid])){
							$folders[$k]['sumtime'] = $foldersumtime[$folderid];
						}else{
							$folders[$k]['sumtime'] = 0;
						}
					}
				}else{
					foreach($folders as $k=>$package){
						foreach($package['itemlist'] as $l=>$folder){
							$folderid = $folder['folderid'];
							if(!empty($folderprogress[$folderid])){
								$folders[$k]['itemlist'][$l]['percent'] = floor(array_sum($folderprogress[$folderid])/$foldercwcount[$folderid]);
								if(empty($foldercwcount[$folderid])){
									$folders[$k]['itemlist'][$l]['studyfinishpercent'] = 0;
								}else{
									$fscredit = empty($foldercredit[$folderid]['study'])?0:$foldercredit[$folderid]['study'];
									$folders[$k]['itemlist'][$l]['studyfinishpercent'] = $fscredit/$foldercwcount[$folderid];
								}
								if(empty($folderexamcount[$folderid])){
									$folders[$k]['itemlist'][$l]['examscorepercent'] = 0;
								}else{
									$fecredit = empty($foldercredit[$folderid]['exam'])?0:$foldercredit[$folderid]['exam'];
									$folders[$k]['itemlist'][$l]['examscorepercent'] = $fecredit/$folderexamcount[$folderid];
								}
								
								if(empty($folder['creditrule'])){
									$creditrule[0] = 100;
									$creditrule[1] = 0;
								}else{
									$creditrule = explode(':',$folder['creditrule']);
								}
								// var_dump($creditrule);
								$folders[$k]['itemlist'][$l]['creditget'] = round($folder['credit']*($creditrule[0]*$folders[$k]['itemlist'][$l]['studyfinishpercent']+$creditrule[1]*$folders[$k]['itemlist'][$l]['examscorepercent'])/100,2);
								
							}
							else{
								$folders[$k]['itemlist'][$l]['percent'] = 0;
								$folders[$k]['itemlist'][$l]['creditget'] = 0;
							}
							
							if(!empty($foldersumtime[$folderid])){
								$folders[$k]['itemlist'][$l]['sumtime'] = $foldersumtime[$folderid];
							}else{
								$folders[$k]['itemlist'][$l]['sumtime'] = 0;
							}
						}
					}
				}
				
			}
		}
		if(empty($folderids) || empty($folders)){
			$this->showempty();
			exit;
		}
		$this->assign('roominfo',$roominfo);
		$this->assign('folderids',$folderids);
		$this->assign('folders',$folders);
		$this->display('courselist');
	}
	
	/*
	课件列表
	*/
	public function study_cwlist_view(){
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		$folderid = $this->uri->itemid;
		$coursemodel = $this->model('Courseware');
        $queryarr = parsequery();
		$q = $this->input->get('q');
        $queryarr['folderid'] = $folderid;
		$pagesize = 100;
		$queryarr['pagesize'] = $pagesize;
		$queryarr['status'] = 1;
		
		$foldermodel = $this->model('folder');
		$folder = $foldermodel->getfolderbyid($folderid);
		$this->assign('folder',$folder);
		
		
		if(empty($folder['playmode']) || empty($queryarr['q'])){
			$cwlist = $coursemodel->getfolderseccourselist($queryarr);
		}
		else{
			$searchedcwlist = $coursemodel->getfolderseccourselist($queryarr);
			unset($queryarr['q']);
			$cwlist = $coursemodel->getfolderseccourselist($queryarr);
		}
	
		
		if(!empty($cwlist)){
		
		$cwids = '';
		foreach($cwlist as $cw){
			$cwids.= $cw['cwid'].',';
		}
		$cwids = rtrim($cwids,',');
		$param['cwid'] = $cwids;
		$param['uid'] = $user['uid'];
		$pmodel = $this->model('progress');
		$progresslist = $pmodel->getFolderProgressByCwid($param);
		
		foreach($progresslist as $k=>$p){
			if($p['percent']*100>=90){
				$cwprogress[$p['cwid']] = 100;
			}
			else{
				$cwprogress[$p['cwid']] = floor($p['percent']*100);
			}
		}
		foreach($cwlist as $k=>$cw){
			if(!empty($cwprogress[$cw['cwid']]))
				$cwlist[$k]['percent'] = $cwprogress[$cw['cwid']];
			else
				$cwlist[$k]['percent'] = 0;
		}
		// var_dump($cwlist);
		}
		
		//收藏信息
		$favoritemodel = $this->model('Favorite');
		$fparam = array('crid'=>$roominfo['crid'],'folderid'=>$folderid,'uid'=>$user['uid']);
		$myfavorites = $favoritemodel->getfolderfavoritelist($fparam);
		$myfavorite = empty($myfavorites) ? '' : $myfavorites[0];
		
		$sectionlist = array();
		$redis = Ebh::app()->getCache('cache_redis');
        foreach($cwlist as $k=>$course) {
            if(empty($course['sid'])) {
                $course['sid'] = 0;
                $course['sname'] = '其他';
            }
			if(($k-1)>=0 && $cwlist[$k-1]['sid'] == $course['sid']){
				if($cwlist[$k-1]['percent'] != 100 || !empty($cwlist[$k-1]['disabled'])){
					$cwlist[$k]['disabled'] = true;
					$course['disabled'] = true;
				}
				
			}
			$viewnum = $redis->hget('coursewareviewnum',$course['cwid']);
			if(!empty($viewnum))
				$course['viewnum'] = $viewnum;
            $sectionlist[$course['sid']][] = $course;
        }
		foreach($sectionlist as $k=>$section){
			$queryarr['sid'] = $k;
			$sectioncount = $coursemodel->getfolderseccoursecount($queryarr);
			$sectionlist[$k][0]['sectioncount'] = $sectioncount;
		}
		
		
		if(!empty($q) && $folder['playmode']){//搜索时按序播放
			// $lastsid = 0;
			$resultSection = array();
			if(!empty($searchedcwlist)){//搜索结果不为空
				foreach($searchedcwlist as $cw){
					if(!empty($cw['sid']))
						$sid = $cw['sid'];
					else
						$sid = 0;
					$resultSection[] = $sid; 
					if(!isset($lastsid))
						$lastsid = $sid;
					if($lastsid != $sid){
						//删除上一个目录末尾多余的数据
						for($i=$sectionj[$lastsid];$i<$nsectioncount[$lastsid];$i++){
							unset($sectionlist[$lastsid][$i]);
						}
						$lastsid = $sid;
					}
					if(empty($nsectioncount[$sid]))
						$nsectioncount[$sid] = count($sectionlist[$sid]);
					// var_dump($nsectioncount);
					if(empty($sectionj[$sid]))
						$sectionj[$sid] = 0;
					
					// var_dump($sectionj[$sid]);
					
					for($i=$sectionj[$sid];$i<$nsectioncount[$sid];$i++){
						//删除与搜索结果不符的内容
						if($cw['cwid'] != $sectionlist[$sid][$i]['cwid']){
							// echo $sectionlist[$sid][$i]['cwid'];
							unset($sectionlist[$sid][$i]);
						}else{
							$sectionj[$sid] = $i+1;
							break;
						}
					}
					
				}
				
				for($i=$sectionj[$sid];$i<$nsectioncount[$sid];$i++){
					unset($sectionlist[$sid][$i]);
				}
				foreach($sectionlist as $k=>$section){
					if(!in_array($k,$resultSection)){
						unset($sectionlist[$k]);
					}
				}
			}else{
				$sectionlist = array();
			}
		}
		$packagelimit = Ebh::app()->getConfig()->load('packagelimit');
		if(in_array($roominfo['crid'],$packagelimit)){
			$pmodel = $this->model('paypackage');
			$limitdate = $pmodel->getFirstLimitDate(array('folderid'=>$folderid,'uid'=>$user['uid']));
			$this->assign('limitdate',$limitdate['firstday']);
		}
		$this->assign('sectionlist',$sectionlist);
		$this->assign('myfavorite',$myfavorite);
		$this->assign('q',$q);
		$this->assign('cwlist',$cwlist);
		$this->display('cwlist');
	}
	
	/*
	全校课程
	*/
	public function allcourse(){
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		$foldermodel = $this->model('Folder');
		$queryarr = parsequery();
		$queryarr['crid'] = $roominfo['crid'];
		$queryarr['pagesize'] = 1000;
		$queryarr['nosubfolder'] = 1;
		$queryarr['needpower'] = 1;
		$folders = $foldermodel->getfolderlist($queryarr);
		
		if(!empty($folders)){
			if($roominfo['isschool'] != 7){
				$folderids = '';
				foreach($folders as $folder){
					$folderids.= $folder['folderid'].',';
				}
				//folderid集合字符串
				$folderids = rtrim($folderids,',');
				
				
				
				$pmodel = $this->model('progress');
				$param['folderid'] = $folderids;
				
				//课程集合下的视频课件
				$param['limit'] = 10000;
				$coursewarelist = $pmodel->getCWByFolderid($param);
				// var_dump($coursewarelist);
				$cwids = '';
				
				//cwid=>folderid对应数组
				$cwidfolderidlist =array();
				if(!empty($coursewarelist)){
					$countlist = $pmodel->getFolderProgressCountByFolderid($param);
					foreach($countlist as $f){
						$foldercwcount[$f['folderid']] = $f['count'];
					}
					foreach($coursewarelist as $cw){
						$cwids.= $cw['cwid'].',';
						$cwidfolderidlist[$cw['cwid']] = $cw['folderid'];
					}
					// var_dump($cwidfolderidlist);
					$cwids = rtrim($cwids,',');
					$param['cwid'] = $cwids;
					$param['uid'] = $user['uid'];
					
					//根据cwid获取进度,添加到对应 课程进度 数组中
					$folderprogress = array();
					$progresslist = $pmodel->getFolderProgressByCwid($param);
					// var_dump($progresslist);
					foreach($progresslist as $p){
						$folderid = $cwidfolderidlist[$p['cwid']];
						if($p['percent']*100>=90){
							$folderprogress[$folderid][] = 100;
							// var_dump($p);
							if(empty($foldercredit[$folderid]['study'])){//听课完成的数量
								$foldercredit[$folderid]['study'] = 1;
								
							}
							else
								$foldercredit[$folderid]['study'] += 1;
						}
						else
							$folderprogress[$folderid][] = $p['percent']*100;
					}
					//作业完成情况
					$examcreditlist = $foldermodel->getUserFolderExamCredit(array('uid'=>$user['uid'],'folderid'=>$folderids));
					foreach($examcreditlist as $examcredit){
						$folderid = $examcredit['folderid'];
						if(empty($foldercredit[$folderid]['exam']))
							$foldercredit[$folderid]['exam'] = $examcredit['examcredit'];
						else
							$foldercredit[$folderid]['exam'] += $examcredit['examcredit'];
					}
					//作业总数
					$countlist = $foldermodel->getFolderExamCount(array('folderid'=>$folderids));
					// var_dump($countlist);
					foreach($countlist as $f){
						$folderexamcount[$f['folderid']] = $f['count'];
					}
					// var_dump($folderprogress);
					// exit;
					
					//课程进度数组计算结果记录到课程列表的进度字段
					if($roominfo['isschool'] != 7){
						foreach($folders as $k=>$folder){
							$folderid = $folder['folderid'];
							if(!empty($folderprogress[$folderid])){
								$folders[$k]['percent'] = floor(array_sum($folderprogress[$folderid])/$foldercwcount[$folderid]);
								if(empty($foldercwcount[$folderid])){
									$folders[$k]['studyfinishpercent'] = 0;
								}else{
									$fscredit = empty($foldercredit[$folderid]['study'])?0:$foldercredit[$folderid]['study'];
									$folders[$k]['studyfinishpercent'] = $fscredit/$foldercwcount[$folderid];
								}
								if(empty($folderexamcount[$folderid])){
									$folders[$k]['examscorepercent'] = 0;
								}else{
									$fecredit = empty($foldercredit[$folderid]['exam'])?0:$foldercredit[$folderid]['exam'];
									$folders[$k]['examscorepercent'] = $fecredit/$folderexamcount[$folderid];
								}
								
								if(empty($folder['creditrule'])){
									$creditrule[0] = 100;
									$creditrule[1] = 0;
								}else{
									$creditrule = explode(':',$folder['creditrule']);
								}
								// var_dump($creditrule);
								$folders[$k]['creditget'] = round($folder['credit']*($creditrule[0]*$folders[$k]['studyfinishpercent']+$creditrule[1]*$folders[$k]['examscorepercent'])/100,2);
								
							}
							else{
								$folders[$k]['percent'] = 0;
								$folders[$k]['creditget'] = 0;
							}
						}
					}
					
				}
				
			}else{
				
				$spmodel = $this->model('PayPackage');
				$thelist = $spmodel->getsplist(array('crid'=>$roominfo['crid'],'status'=>1,'displayorder'=>'displayorder asc,pid desc','limit'=>1000));
				$splist = array();
				$spidlist = '';
				//将结果数组以pid为下标排列,并记录pid合集字符串
				foreach($thelist as $mysp) {
					$splist[$mysp['pid']] = $mysp;
					$splist[$mysp['pid']]['itemlist'] = array();
					if(empty($spidlist)) {
						$spidlist = $mysp['pid'];
					} else {
						$spidlist .= ','.$mysp['pid'];
					}
				}
				///////开通的课程
				$folders = $splist;
				if(!empty($spidlist)) {
					$pitemmodel = $this->model('PayItem');
					$itemparam = array('limit'=>100,'pidlist'=>$spidlist,'displayorder'=>'s.sdisplayorder is null,sdisplayorder,i.pid,f.displayorder','power'=>0);
					$itemlist = $pitemmodel->getItemFolderList($itemparam);
					if(!empty($itemlist)) {
						foreach($itemlist as $myitem) {
							if(isset($folders[$myitem['pid']])) {
								$folders[$myitem['pid']]['itemlist'][] = $myitem;
							}
						}
					}
				}
				$mylist = array();
				if(!empty($user) && $user['groupid'] == 6) {
					$userpermodel = $this->model('Userpermission');
					$myperparam = array('uid'=>$user['uid'],'crid'=>$roominfo['crid'],'filterdate'=>1);
					$myfolderlist = $userpermodel->getUserPayFolderList($myperparam);
					foreach($myfolderlist as $myfolder) {
						$mylist[$myfolder['folderid']] = $myfolder;
					}
				}
				foreach($folders as $k=>$package){
					$showpack = false;
					foreach($package['itemlist'] as $l=>$folder){
						if($folder['fprice']==0 || isset($mylist[$folder['folderid']]))
							$showpack = true;
						else
							unset($folders[$k]['itemlist'][$l]);
					}
					if($showpack == false)
						unset($folders[$k]);
				}
				
				
				///////////未开通的课程
				if(!empty($spidlist)) {
					$pitemmodel = $this->model('PayItem');
					$itemparam = array('limit'=>100,'pidlist'=>$spidlist,'displayorder'=>'i.pid,f.displayorder','uid'=>$user['uid'],'crid'=>$roominfo['crid'],'power'=>0);
					$itemlist = $pitemmodel->getItemFolderListNotPaid($itemparam);
					// var_dump($itemlist);
					if(!empty($itemlist)) {
						foreach($itemlist as $myitem) {
							$myitem['payurl'] = 'http://'.$roominfo['domain'].'.'.$this->uri->curdomain.'/ibuy.html?itemid='.$myitem['itemid'].'&sid='.$myitem['sid'];
							if($roominfo['domain'] == 'yxwl') {	//易学网络 专门处理，直接跳转到转账
								$myitem['payurl'] = '/classactive/bank.html';
							}
							if(isset($splist[$myitem['pid']])) {
								$splist[$myitem['pid']]['itemlist'][] = $myitem;
							}
							
						}
					}
				}
				// var_dump($splist);
				$this->assign('splist',$splist);
			}
			
			
			
			
		}
		$this->assign('all',true);
		$this->assign('folders',$folders);
		$this->assign('roominfo',$roominfo);
		$this->display('courselist');
	}


	/*
	课件列表
	*/
	public function cwlist_view(){
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		$folderid = $this->uri->itemid;
		$coursemodel = $this->model('Courseware');
        $queryarr = parsequery();
		$q = $this->input->get('q');
        $queryarr['folderid'] = $folderid;
		$pagesize = 100;
		$queryarr['pagesize'] = $pagesize;
		$queryarr['status'] = 1;
		
		$foldermodel = $this->model('folder');
		$folder = $foldermodel->getfolderbyid($folderid);
		$this->assign('folder',$folder);
		
		
		if(empty($folder['playmode']) || empty($queryarr['q'])){
			$cwlist = $coursemodel->getfolderseccourselist($queryarr);
		}
		else{
			$searchedcwlist = $coursemodel->getfolderseccourselist($queryarr);
			unset($queryarr['q']);
			$cwlist = $coursemodel->getfolderseccourselist($queryarr);
		}
	
		
		if(!empty($cwlist)){
		
		$cwids = '';
		foreach($cwlist as $cw){
			$cwids.= $cw['cwid'].',';
		}
		$cwids = rtrim($cwids,',');
		$param['cwid'] = $cwids;
		$param['uid'] = $user['uid'];
		$pmodel = $this->model('progress');
		$progresslist = $pmodel->getFolderProgressByCwid($param);
		
		foreach($progresslist as $k=>$p){
			if($p['percent']*100>=90){
				$cwprogress[$p['cwid']] = 100;
			}
			else{
				$cwprogress[$p['cwid']] = floor($p['percent']*100);
			}
		}
		$this->insertStudyInfo($cwlist);
		foreach($cwlist as $k=>$cw){
			if(!empty($cwprogress[$cw['cwid']]))
				$cwlist[$k]['percent'] = $cwprogress[$cw['cwid']];
			else
				$cwlist[$k]['percent'] = 0;
		}
		// var_dump($cwlist);
		}
		
		
		$sectionlist = array();
		$redis = Ebh::app()->getCache('cache_redis');
        foreach($cwlist as $k=>$course) {
            if(empty($course['sid'])) {
                $course['sid'] = 0;
                $course['sname'] = '其他';
            }
			if(($k-1)>=0 && $cwlist[$k-1]['sid'] == $course['sid']){
				if($cwlist[$k-1]['percent'] != 100 || !empty($cwlist[$k-1]['disabled'])){
					$cwlist[$k]['disabled'] = true;
					$course['disabled'] = true;
				}
				
			}
			$viewnum = $redis->hget('coursewareviewnum',$course['cwid']);
			if(!empty($viewnum))
				$course['viewnum'] = $viewnum;
            $sectionlist[$course['sid']][] = $course;
        }
		foreach($sectionlist as $k=>$section){
			$queryarr['sid'] = $k;
			$sectioncount = $coursemodel->getfolderseccoursecount($queryarr);
			$sectionlist[$k][0]['sectioncount'] = $sectioncount;
		}
		
		
		if(!empty($q) && $folder['playmode']){//搜索时按序播放
			// $lastsid = 0;
			$resultSection = array();
			if(!empty($searchedcwlist)){//搜索结果不为空
				foreach($searchedcwlist as $cw){
					if(!empty($cw['sid']))
						$sid = $cw['sid'];
					else
						$sid = 0;
					$resultSection[] = $sid; 
					if(!isset($lastsid))
						$lastsid = $sid;
					if($lastsid != $sid){
						//删除上一个目录末尾多余的数据
						for($i=$sectionj[$lastsid];$i<$nsectioncount[$lastsid];$i++){
							unset($sectionlist[$lastsid][$i]);
						}
						$lastsid = $sid;
					}
					if(empty($nsectioncount[$sid]))
						$nsectioncount[$sid] = count($sectionlist[$sid]);
					// var_dump($nsectioncount);
					if(empty($sectionj[$sid]))
						$sectionj[$sid] = 0;
					
					// var_dump($sectionj[$sid]);
					
					for($i=$sectionj[$sid];$i<$nsectioncount[$sid];$i++){
						//删除与搜索结果不符的内容
						if($cw['cwid'] != $sectionlist[$sid][$i]['cwid']){
							// echo $sectionlist[$sid][$i]['cwid'];
							unset($sectionlist[$sid][$i]);
						}else{
							$sectionj[$sid] = $i+1;
							break;
						}
					}
					
				}
				
				for($i=$sectionj[$sid];$i<$nsectioncount[$sid];$i++){
					unset($sectionlist[$sid][$i]);
				}
				foreach($sectionlist as $k=>$section){
					if(!in_array($k,$resultSection)){
						unset($sectionlist[$k]);
					}
				}
			}else{
				$sectionlist = array();
			}
			// var_dump($searchedcwlist);
		}
		//服务包限制时间,用于判断往期课件
		$packagelimit = Ebh::app()->getConfig()->load('packagelimit');
		if(in_array($roominfo['crid'],$packagelimit)){
			$pmodel = $this->model('paypackage');
			$limitdate = $pmodel->getFirstLimitDate(array('folderid'=>$folderid,'uid'=>$user['uid']));
			$this->assign('limitdate',$limitdate['firstday']);
		}
		$this->assign('sectionlist',$sectionlist);
		$this->assign('q',$q);
		$this->assign('cwlist',$cwlist);
		$this->display('cwlist');
	}

	public function showempty(){
		echo '<style>body{padding:0;margin:0;}</style><div style="background:#fff;text-align:center;padding:20px 0;"><img src="http://static.ebanhui.com/ebh/tpl/2014/images/zanwujilu.png"></div>';
	}

	public function insertStudyInfo(&$cwlist){
		$user = Ebh::app()->user->getloginuser();
		$cwid_in = array();
		foreach ($cwlist as &$cw) {
			$cwid_in[] = $cw['cwid'];
		}
		$playlogs = $this->model('playlog')->getStudyInfo($user['uid'],$cwid_in);
		$playlogs_with_key = array();
		foreach ($playlogs as $playlog) {
			$key = 'cw_'.$playlog['cwid'];
			$playlogs_with_key[$key] = $playlog;
		}
		foreach ($cwlist as &$cw) {
			$key = 'cw_'.$cw['cwid'];
			$cw['cwlength'] = secondToStr($cw['cwlength']);
			if(array_key_exists($key,$playlogs_with_key)){
				$cw['learnsumtime'] = secondToStr($playlogs_with_key[$key]['learnsumtime']);
				$cw['learncount'] = $playlogs_with_key[$key]['learncount'];
				$cw['firsttime'] = date('Y-m-d H:i',$playlogs_with_key[$key]['firsttime']);
			}else{
				$cw['learnsumtime'] = 0;
				$cw['learncount'] = 0;
				$cw['firsttime'] = '无记录';
			}
			$cwid_in[] = $cw['cwid'];
		}
	}
}
?>