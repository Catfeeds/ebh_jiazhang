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
        $this->_getCwpay($roominfo,$user,true);//单课收费的课件
        //获取modulename
        $mnlib = Ebh::app()->lib('Modulename');
        $mnlib->getmodulename($this,array('modulecode'=>'study','tors'=>0,'crid'=>$roominfo['crid']));
        $foldermodel = $this->model('Folder');
        //全校免费课程
        if($roominfo['isschool'] == 7){
            $schoolfreelist = $foldermodel->getfolderlist(array('crid'=>$roominfo['crid'],'isschoolfree'=>1,'limit'=>1000));
            $rumodel = $this->model('roomuser');
            $userin = $rumodel->getroomuserdetail($roominfo['crid'],$user['uid']);
            //过滤服务项中的课程
            if (!empty($userin) && !empty($schoolfreelist)) {
                $folderid_arr = array_column($schoolfreelist, 'folderid');
                $folderid_arr = $this->model('Payitem')->getItemListByFolderIds($folderid_arr);
                foreach ($schoolfreelist as $k => $item) {
                    if (in_array($item['folderid'], $folderid_arr)) {
                        unset($schoolfreelist[$k]);
                    }
                }
            }
            if(!empty($userin)) {
                $this->assign('userin', $userin);
                $this->assign('schoolfreelist',$schoolfreelist);
            }

            $survey_id = $this->_need_survery($roominfo['crid'], $user);
            $this->assign('survey_id', $survey_id);
        }


        $folderids = '';
        $folders = array();
        if($roominfo['isschool'] != 7){
            //班级-课程关联
            $classmodel = $this->model('Classes');
            $classcoursesmodel = $this->model('Classcourses');
            if($roominfo['domain'] == 'lcyhg'){//绿城育华 一个学生可以多个班级
                $needlist = TRUE;
                $myclass = $classmodel->getClassByUid($roominfo['crid'],$user['uid'],$needlist);

                $myclassidarr = array_column($myclass,'classid');
                $myclassid = implode($myclassidarr,',');
                $classfolders = $classcoursesmodel->getfolderidsbyclassid($myclassid);

            }else{
                $myclass = $classmodel->getClassByUid($roominfo['crid'],$user['uid']);
                $myclassid = empty($myclass['classid']) ? 0 : $myclass['classid'];
                $classfolders = $classcoursesmodel->getfolderidsbyclassid($myclassid);
            }
            if(!empty($classfolders)){//获取课程基础信息
                foreach ($classfolders as $fd){
                    $folderids.= $fd['folderid'].',';
                }
                $folderids = rtrim($folderids,',');
                $folderparam = array('limit'=>1000,'folderid'=>$folderids,'needpower'=>true);
                $folders = $foldermodel->getfolderlist($folderparam);
            }

            //没有关联的，按老策略，老师的课程
            if(empty($folderids)){
                $queryarr = parsequery();
                $queryarr['crid'] = $roominfo['crid'];
                if(!empty($myclassid))
                    $queryarr['classid'] = $myclassid;
                else{
                    // header('Location:'.geturl('myroom/college/allcourse'));
                    // exit;
                }

                if(!empty($queryarr['classid'])){
                    if(!empty($myclass['grade']))
                        $queryarr['grade'] = $myclass['grade'];
                    $queryarr['pagesize'] = 1000;
                    $queryarr['order'] = '  displayorder asc,folderid desc';
                    $folders = $foldermodel->getClassFolder($queryarr);
                }
                $folderids = array_column($folders,'folderid');
                if(!is_array($folderids)){
                    $folderids = array($folderids);
                }
                $folderids = implode(',',$folderids);
            }

            //国土改总分逻辑
            $folders = $this->modifyZjdrSchoolScore($folders,$roominfo,$folderids);
        }

     	//收费分成学校，则未开通或已过期的课程，就显示阴影和开通按钮
            $splist = array();
            $spfolders = $this->notopened($roominfo,$user,$splist,$folderids);

            // 遍历出已购买的课程 ID
            $folderidArrr = array();
            if (!empty($spfolders)) {
                foreach ($spfolders as $key => $val) {
                    if(!empty($val['itemlist'])) {
                        foreach ($val['itemlist'] as $k => $v) {
                            if (!empty($v['folderid'])) {
                                $folderidArrr[] = $v['folderid'];
                            }
                        }
                    }
                    if (!empty($val['folderid'])) {
                        $folderidArrr[] = $val['folderid'];
                    }
                }
            }

            //学生后台，未购买的课程去掉重复的，已购买的隐藏（逻辑：遍历课程，依次将课程 id 放入到一个数组，如果该课程id数组中已存在则是重复的，删除）
            //可见的未购买服务项
            $vis_items = array();
            if (!empty($splist)) {
                foreach ($splist as $key => $val) {
                    if(!empty($val['itemlist'])) {
                        foreach ($val['itemlist'] as $k => $v) {
                            if (in_array($v['folderid'],$folderidArrr)) {
                                /*if ($roominfo['crid'] != 12859) {
                                    unset($splist[$key]['itemlist'][$k]);
                                }*/
                            } else {
                                $folderidArrr[] = $v['folderid'];
                                $vis_items[$v['sid']] = $v['sid'];
                            }
                        }
                    }
                    if (!empty($val['folderid'])) {
                        if (in_array($val['folderid'],$folderidArrr)) {

                            //unset($splist[$key]);
                        } else {
                            $folderidArrr[] = $val['folderid'];
                            $vis_items[$v['sid']] = $v['sid'];
                        }
                    }
                }
            }

            $vis_items = array_filter($vis_items, function($vis_item) {
                return $vis_item > 0;
            });
            $pay_sorts_model = $this->model('Paysort');
            $vis_sorts = $pay_sorts_model->getSortPackedList($vis_items);
            unset($vis_items);
            if (!empty($vis_sorts)) {
                $sid_arr = array_keys($vis_sorts);
                $sort_price_arr = $pay_sorts_model->sortsCountPrice($sid_arr);
                if (!empty($sort_price_arr)) {
                    foreach ($sort_price_arr as $pitem) {
                        if ($pitem['cannotpay'] == 1) {
                            $vis_sorts[$pitem['sid']]['cannotpay'] = 1;
                            continue;
                        }
                        if ($pitem['isschoolfree'] == 0) {
                            if (!isset($vis_sorts[$pitem['sid']]['all_price'])) {
                                $vis_sorts[$pitem['sid']]['all_price'] = 0;
                            }
                            $vis_sorts[$pitem['sid']]['all_price'] += $pitem['iprice'];
                        }
                    }
                }
                $vis_sorts = array_filter($vis_sorts, function($isort) {
                    return isset($isort['all_price']) && $isort['all_price'] > 0 || !empty($isort['cannotpay']);
                });
            }


            $this->assign('vis_sorts', $vis_sorts);
            $this->assign('splist',$splist);
            //dd($splist);//未开通课程


        $other_config = Ebh::app()->getConfig()->load('othersetting');
        $other_config['zjdlr'] = !empty($other_config['zjdlr']) ? $other_config['zjdlr'] : 0;
        $other_config['newzjdlr'] = !empty($other_config['newzjdlr']) ? $other_config['newzjdlr'] : array();
        $is_zjdlr = ($roominfo['crid'] == $other_config['zjdlr']) || (in_array($roominfo['crid'],$other_config['newzjdlr']));
        $is_newzjdlr = in_array($roominfo['crid'],$other_config['newzjdlr']);
        $this->assign('is_zjdlr',$is_zjdlr);
        $this->assign('is_newzjdlr',$is_newzjdlr);

        //学习进度等
        if(!empty($folders) || !empty($spfolders)){
            //课程集合下的视频课件
            if($is_zjdlr && !$is_newzjdlr){
                $pmodel = $this->model('progress');
                $param['folderid'] = $folderids;

                //课程集合下的视频课件
                $param['limit'] = 10000;
                if(!empty($param['folderid']))
                    $coursewarelist = $pmodel->getCWByFolderid($param);
                // var_dump($coursewarelist);

                if(!empty($coursewarelist)){//学习信息加入folders数组中
                    $this->studyinfo_old($folders,$coursewarelist,$param,$roominfo,$user,$folderids,'spfolders',$spfolders);
                }
            } else {
                $this->studyinfo($folders,$roominfo,$user,$folderids,'spfolders',$spfolders);
            }

        }
       //$this->newcourse($roominfo,$user);//最新课程
        $this->assign('roominfo',$roominfo);
       // $this->_updateuserstate(2);
        $this->assign('folderids',empty($folderids)?'':$folderids);
        $this->assign('folders',empty($folders)?array():$folders);
        $this->assign('spfolders',$spfolders);
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
	
		
        $redis = Ebh::app()->getCache('cache_redis');//redis对象
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
	public function cwlist_view()
    {
        $roominfo             = Ebh::app()->room->getcurroom();
        $user                 = Ebh::app()->user->getloginuser();
        $folderid             = $this->uri->itemid;
        $coursemodel          = $this->model('Courseware');
        $queryarr             = parsequery();
        $q                    = $this->input->get('q');
        $page                 = $this->uri->page;//当前页码
        $page                 = intval($page);
        $queryarr['folderid'] = $folderid;
        $pagesize             = 100;
        $queryarr['pagesize'] = $pagesize;

        $queryarr['page'] = $page;

        $queryarr['status'] = 1;

        $foldermodel = $this->model('folder');
        $folder      = $foldermodel->getfolderbyid($folderid);
        $this->assign('folder', $folder);

        if (empty($folder['playmode']) || empty($queryarr['q'])) {
            $cwlist = $coursemodel->getfolderseccourselist($queryarr);
        } else {
            $searchedcwlist = $coursemodel->getfolderseccourselist($queryarr);
            unset($queryarr['q']);
            $cwlist = $coursemodel->getfolderseccourselist($queryarr);
        }

        if (!empty($cwlist)) {

            if (isset($cwlist['page'])) {
                $page     = $cwlist['page'];
                $showPage = show_page($page['total'], $page['listRows']);
                $this->assign('page', $showPage);
                unset($cwlist['page']);
            }
            $redis = Ebh::app()->getCache('cache_redis');//redis对象
            // dd(unserialize($redis->hget(self::courseCacheName,'138818_385098')),1);

            //$cwids = rtrim($cwids,',');

            $cwidArr = array_column($cwlist, 'cwid');
            $cwids   = implode(',', $cwidArr);
            if (!empty($cwids)) {
                $apiServer  = Ebh::app()->getApiServer();//获取apiServer
                $sdata      = array('uid' => $user['uid'], 'cwids' => $cwids);
                $courseList = $apiServer->reSetting()->setService('Study.Log.list')->addParams($sdata)->request();//获取课件列表学习信息
                $cwprogress = [];
                if (!empty($courseList)) {
                    foreach ($courseList as $item) {
                        $cwid = $item['cwid'];
                        if ($item['ltime'] <= 0 || $item['ctime'] <= 0) {
                            $percent = 0;
                        } else {
                            $percent = $item['ltime'] / $item['ctime'] * 100;

                        }
                        if ($percent >= 90) {
                            $cwprogress[$cwid] = 100;
                        } else {
                            $cwprogress[$cwid] = floor($percent);
                        }
                    }
                }

                $this->insertStudyInfo($cwlist, $courseList);
                foreach ($cwlist as $k => $cw) {
                    if (!empty($cwprogress[$cw['cwid']]))
                        $cwlist[$k]['percent'] = $cwprogress[$cw['cwid']];
                    else {
                        $cwlist[$k]['percent'] = 0;
                    }
                }
            }
            $sectionlist = array();
            foreach ($cwlist as $k => $course) {
                if (empty($course['sid'])) {
                    $course['sid']   = 0;
                    $course['sname'] = '其他';
                }
                if (($k - 1) >= 0 && $cwlist[$k - 1]['sid'] == $course['sid']) {
                    if ($cwlist[$k - 1]['percent'] != 100 || !empty($cwlist[$k - 1]['disabled'])) {
                        $cwlist[$k]['disabled'] = true;
                        $course['disabled']     = true;
                    }

                }
                $viewnum = $redis->hget('coursewareviewnum', $course['cwid']);
                if (!empty($viewnum))
                    $course['viewnum'] = $viewnum;
                $sectionlist[$course['sid']][] = $course;
            }
            foreach ($sectionlist as $k => $section) {
                $queryarr['sid']                    = $k;
                $sectioncount                       = $coursemodel->getfolderseccoursecount($queryarr);
                $sectionlist[$k][0]['sectioncount'] = $sectioncount;
            }
            if (!empty($q) && $folder['playmode']) {//搜索时按序播放
                // $lastsid = 0;
                $resultSection = array();
                if (!empty($searchedcwlist)) {//搜索结果不为空
                    foreach ($searchedcwlist as $cw) {
                        if (!empty($cw['sid']))
                            $sid = $cw['sid'];
                        else
                            $sid = 0;
                        $resultSection[] = $sid;
                        if (!isset($lastsid))
                            $lastsid = $sid;
                        if ($lastsid != $sid) {
                            //删除上一个目录末尾多余的数据
                            for ($i = $sectionj[$lastsid]; $i < $nsectioncount[$lastsid]; $i++) {
                                unset($sectionlist[$lastsid][$i]);
                            }
                            $lastsid = $sid;
                        }
                        if (empty($nsectioncount[$sid]))
                            $nsectioncount[$sid] = count($sectionlist[$sid]);
                        // var_dump($nsectioncount);
                        if (empty($sectionj[$sid]))
                            $sectionj[$sid] = 0;

                        // var_dump($sectionj[$sid]);

                        for ($i = $sectionj[$sid]; $i < $nsectioncount[$sid]; $i++) {
                            //删除与搜索结果不符的内容
                            if ($cw['cwid'] != $sectionlist[$sid][$i]['cwid']) {
                                // echo $sectionlist[$sid][$i]['cwid'];
                                unset($sectionlist[$sid][$i]);
                            } else {
                                $sectionj[$sid] = $i + 1;
                                break;
                            }
                        }

                    }

                    for ($i = $sectionj[$sid]; $i < $nsectioncount[$sid]; $i++) {
                        unset($sectionlist[$sid][$i]);
                    }
                    foreach ($sectionlist as $k => $section) {
                        if (!in_array($k, $resultSection)) {
                            unset($sectionlist[$k]);
                        }
                    }
                } else {
                    $sectionlist = array();
                }
                // var_dump($searchedcwlist);
            }
            //服务包限制时间,用于判断往期课件
            $packagelimit = Ebh::app()->getConfig()->load('packagelimit');
            if (in_array($roominfo['crid'], $packagelimit)) {
                $pmodel    = $this->model('paypackage');
                $limitdate = $pmodel->getFirstLimitDate(array('folderid' => $folderid, 'uid' => $user['uid']));
                $this->assign('limitdate', $limitdate['firstday']);
            }
            $this->assign('sectionlist', $sectionlist);
            $this->assign('q', $q);
            $this->assign('cwlist', $cwlist);
            $this->display('cwlist');
        }
    }

	public function showempty(){
		echo '<style>body{padding:0;margin:0;}</style><div style="background:#fff;text-align:center;padding:20px 0;"><img src="http://static.ebanhui.com/ebh/tpl/2014/images/zanwujilu.png"></div>';
	}

    /**
     * @describe:
     * @Author:tzq
     * @Date:2018/01/
     * @param $cwlist
     * @param $cwCacheList 缓存数据
     */
	public function insertStudyInfo(&$cwlist,$courList){
		foreach ($cwlist as &$cw) {
            $cwid               = $cw['cwid'];
            $cw['cwlength']     = isset($cw['cwlength']) ? $cw['cwlength'] : (isset($courList[$cwid]['ctime']) ? $courList[$cwid]['ctime'] : 0);
            $cw['cwlength']     = secondToStr($cw['cwlength']);
            $cw['learnsumtime'] = isset($courList[$cwid]) ? secondToStr($courList[$cwid]['totalltime']) : 0;
            $cw['learncount']   = isset($courList[$cwid]) ? $courList[$cwid]['playcount'] : 0;
            $cw['firsttime']    = isset($courList[$cwid]) ? date('Y-m-d H:i', $courList[$cwid]['startdate']) : '无记录';
		}
	}

    /*
    单课收费的课件,$showmylist=true 表示我开通的，false表示未开通的
    */
    private function _getCwpay($roominfo,$user,$showmylist = false){
        if($roominfo['template'] != 'plate' || $roominfo['isschool'] != 7)
            return false;
        $upmodel = $this->model('userpermission');
        $paidcws = $upmodel->getUserPayCwList(array('crid'=>$roominfo['crid'],
            'uid'=>$user['uid'],
            'filterdate'=>true));

        $cwmodel = $this->model('courseware');
        $param = array('crid'=>$roominfo['crid'],
            'freeorder'=>'f.displayorder,f.folderid,r.cdisplayorder,cw.cwid desc',
            'cwpay'=>1,
            'power'=>0,
            'limit'=>1000);
        $cwlist = $cwmodel->getfolderseccourselist($param);
        if(!empty($paidcws) || $showmylist){
            $paidcwids = array_column($paidcws,'cwid');
            foreach($cwlist as $k=>$cw){
                if(in_array($cw['cwid'],$paidcwids) == !$showmylist){//首页显示开通的，学习页显示未开通的
                    unset($cwlist[$k]);
                    continue;
                }
            }

            $this->assign('paidcws',count($paidcws));
            if($showmylist && !empty($paidcwids)){//首页
                $cwids = implode(',',$paidcwids);
                //学习进度
                $progresslist = $this->model('progress')->getFolderProgressByCwid(array('cwid'=>$cwids,'uid'=>$user['uid']));
                $cwarr = array();
                foreach($cwlist as $k=>$cw){
                    $cwarr[$cw['cwid']] = $cw;
                }
                foreach($progresslist as $progress){
                    $cwarr[$progress['cwid']]['percent'] = $progress['percent'];
                }
                $this->assign('cwlist',$cwarr);
                return ;
            }
        }
        $thelist = !empty($cwarr)?$cwarr:$cwlist;
        $viewnumlib = Ebh::app()->lib('Viewnum');
        foreach($thelist as $k=>$cw){
            $viewnum = $viewnumlib->getViewnum('courseware',$cw['cwid']);
            if(!empty($viewnum))
                $thelist[$k]['viewnum'] = $viewnum;
        }
        $folderidarr = array_column($thelist,'folderid');
        if(!empty($folderidarr)){//查询课程下课件数
            $foldernumarr = $this->getfoldernum($folderidarr,false);
            $this->assign('foldernumarr',$foldernumarr);
        }
        if(!empty($cwlist))
            $this->assign('cwpay',true);
        $this->assign('cwlist',$thelist);
    }
    /**
     * 需要填写问卷ID
     * @param $crid
     * @param $user
     * @return bool
     */
    private function _need_survery($crid, $user) {
        $otherconfig = Ebh::app()->getConfig()->load('othersetting');
        if (!empty($otherconfig['survey_crids']) && is_array($otherconfig['survey_crids']) && in_array($crid, $otherconfig['survey_crids'])) {
            $survey_model = $this->model('Survey');
            $survey_id = $survey_model->getSurveyIdBeforeBuy($crid);
            if (empty($survey_id)) {
                return false;
            }
            if (empty($user)) {
                return $survey_id;
            }
            if ($user['groupid'] == 5) {
                return false;
            }
            $answered = $survey_model->answered($survey_id, $user['uid']);
            if (!$answered) {
                return $survey_id;
            }
        }
        return false;
    }
    /*
	未开通的课程
	*/
    private function notopened($roominfo,$user,&$splist,&$folderids){
        $roomcache = Ebh::app()->lib('Roomcache');
        $spmodel = $this->model('PayPackage');
        $spparam = array('crid'=>$roominfo['crid'],'status'=>1,'displayorder'=>'itype asc,displayorder asc,pid desc','limit'=>1000);
        $thelist = $spmodel->getsplist($spparam);
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
        $spfolders = $splist;
        if(!empty($spidlist)) {
            $pitemmodel = $this->model('PayItem');
            $itemparam = array('limit'=>1000,'pidlist'=>$spidlist,'displayorder'=>'s.sdisplayorder is null,sdisplayorder,i.pid,f.displayorder','power'=>0);
            $itemlist = $pitemmodel->getItemFolderList($itemparam);
            if(!empty($itemlist)) {
                foreach($itemlist as $myitem) {
                    if(isset($spfolders[$myitem['pid']])) {
                        //dd($myitem);
                        $spfolders[$myitem['pid']]['itemlist'][] = $myitem;
                    }
                }
            }
        }
        $mylist = array();
        if(!empty($user) && $user['groupid'] == 6) {
            $userpermodel = $this->model('Userpermission');
            $myperparam = array('uid'=>$user['uid'],'crid'=>$roominfo['crid'],'filterdate'=>1);
            $myfolderlist = $userpermodel->getUserPayFolderList($myperparam);
            $this->openedcourse = $myfolderlist;
            foreach($myfolderlist as $myfolder) {
                $mylist[$myfolder['folderid']] = $myfolder;
            }
        }

        //var_dump($spfolders);
        foreach($spfolders as $k=>$package){
            $showpack = false;
            foreach($package['itemlist'] as $l=>$folder){
                if(/*$folder['fprice']==0 || */isset($mylist[$folder['folderid']])/* || $folder['iprice'] ==0*/){
                    $showpack = true;
                    if(empty($folderids))
                        $folderids = $folder['folderid'];
                    else
                        $folderids .= ','.$folder['folderid'];
                }
                else
                    unset($spfolders[$k]['itemlist'][$l]);
            }
            if($showpack == false)
                unset($spfolders[$k]);
        }
        ///////////未开通的课程
        if(!empty($spidlist)) {
            $pitemmodel = $this->model('PayItem');
            $itemparam = array('limit'=>1000,'pidlist'=>$spidlist,'displayorder'=>'i.pid,f.displayorder','uid'=>$user['uid'],'crid'=>$roominfo['crid'],'power'=>0);
            $itemlist = $pitemmodel->getItemFolderListNotPaid($itemparam, false);
            //print_r($itemlist);exit;
            if(!empty($itemlist)) {
                $sids = array_column($itemlist, 'sid');
                $sorts = $this->model('PaySort')->getSortPackedList($sids);
                foreach($itemlist as &$myitem) {
                    if (empty($myitem['sid']) || $myitem['sid'] == '0') {
                        if (!isset($splist[$myitem['pid']]['sorts'][0])) {
                            $splist[$myitem['pid']]['sorts'][0] = array(
                                'sid' => 0,
                                'sname' => '其他',
                                'pid' => $myitem['pid'],
                                'sdisplayorder' => 2147483648
                            );
                        }
                    } else {
                        if (!isset($splist[$myitem['pid']]['sorts'][$myitem['sid']]) && isset($sorts[$myitem['sid']])) {
                            $splist[$myitem['pid']]['sorts'][$myitem['sid']] = $sorts[$myitem['sid']];
                        }
                        if (!empty($splist[$myitem['pid']]['sorts'][$myitem['sid']]['showbysort']) && $splist[$myitem['pid']]['sorts'][$myitem['sid']]['showbysort'] == '1') {
                            if (isset($splist[$myitem['pid']]['sorts'][$myitem['sid']]['list'])) {
                                $index = $splist[$myitem['pid']]['sorts'][$myitem['sid']]['list'];
                                if (empty($splist[$myitem['pid']][$index]['coursewarenum'])) {
                                    $splist[$myitem['pid']][$index]['coursewarenum'] = 0;
                                }
                                $splist[$myitem['pid']][$index]['coursewarenum'] += $myitem['coursewarenum'];
                                continue;
                            }
                            $splist[$myitem['pid']]['sorts'][$myitem['sid']]['list'] = count($splist[$myitem['pid']]['itemlist']);
                            if (!empty($sorts[$myitem['sid']]['showaslongblock']) && $sorts[$myitem['sid']]['showaslongblock'] == '1') {
                                $myitem['foldername'] = $myitem['iname'] = $sorts[$myitem['sid']]['sname'];
                                $myitem['img'] = $sorts[$myitem['sid']]['imgurl'];
                                $myitem['iprice'] = 1;
                            }
                        }
                    }

                    $myitem['payurl'] = 'http://'.$roominfo['domain'].'.'.$this->uri->curdomain.'/ibuy.html?itemid='.$myitem['itemid'].'&sid='.$myitem['sid'];
                    if($roominfo['domain'] == 'yxwl') {	//易学网络 专门处理，直接跳转到转账
                        $myitem['payurl'] = '/classactive/bank.html';
                    }
                    if(!empty($myitem['ptype'])) {	//服务项权限非0情况下，则可以看课件列表
                        $myitem['payurl'] = '';
                    }
                    if(isset($splist[$myitem['pid']])) {
                        $splist[$myitem['pid']]['itemlist'][] = $myitem;
                    }
                }
            }
        }
        if (!empty($splist)) {
            //二级分类增加全部分类、排序
            array_walk($splist, function(&$spitem) {
                if (empty($spitem['sorts'])) {
                    return;
                }
                if (count($spitem['sorts']) == 1) {
                    $init = reset($spitem['sorts']);
                    $spitem['csid'] = $init['sid'];
                    return;
                }
                $sids = array_column($spitem['itemlist'], 'sid');
                $sids = array_flip($sids);
                foreach ($spitem['sorts'] as $sid => $checkitem) {
                    if (!isset($sids[$sid])) {
                        unset($spitem['sorts'][$sid]);
                    }
                }
                if (count($spitem['sorts']) > 1) {
                    $spitem['sorts'][-1] = array(
                        'sid' => -1,
                        'sname' => '全部',
                        'sdisplayorder' => -1,
                        'pid' => $spitem['pid']
                    );
                }

                $sids = array_column($spitem['sorts'], 'sid');
                $sids = array_map('intval', $sids);
                $sdisplayorders = array_column($spitem['sorts'], 'sdisplayorder');
                $sdisplayorders = array_map('intval', $sdisplayorders);
                array_multisort($sdisplayorders, SORT_ASC, SORT_NUMERIC, $sdisplayorders,
                    $sids, SORT_DESC, SORT_NUMERIC, $spitem['sorts']);
                $tmp = $spitem['sorts'];
                $spitem['sorts'] = array();
                foreach ($tmp as $titem) {
                    $spitem['sorts'][$titem['sid']] = $titem;
                }
                foreach ($spitem['sorts'] as $s) {
                    if ($s['sid'] > -1) {
                        $spitem['csid'] = $s['sid'];
                        break;
                    }
                }
            });
        }//print_r($splist);exit;
        return $spfolders;
    }
    /*
	学习信息加入folders数组中
	*/
    private function studyinfo(&$folders=array(),$roominfo,$user,$folderids,$foldertype = 'folders',&$spfolders=array()){
        $pmodel = $this->model('progress');
        $foldermodel = $this->model('folder');


        //课程集合下的视频课件
        if(!empty($folderids)){
            $coursewarelist = $pmodel->getCWByFolderid(array('folderid'=>$folderids,'limit'=>10000));
            $foldercwlist = array();
            foreach($coursewarelist as $cw){
                $foldercwlist[$cw['folderid']][] = $cw;
            }

        }

        $other_config = Ebh::app()->getConfig()->load('othersetting');
        $other_config['zjdlr'] = !empty($other_config['zjdlr']) ? $other_config['zjdlr'] : 0;
        $other_config['newzjdlr'] = !empty($other_config['newzjdlr']) ? $other_config['newzjdlr'] : array();
        $is_zjdlr = ($roominfo['crid'] == $other_config['zjdlr']) || (in_array($roominfo['crid'],$other_config['newzjdlr']));
        $is_newzjdlr = in_array($roominfo['crid'],$other_config['newzjdlr']);

        //是国土的情况下获取国土的非视频课件得分
        if ($is_newzjdlr||$is_zjdlr) {
            if (!empty($this->zjdlr_word_folderid)) {
                $word_folderids = substr($this->zjdlr_word_folderid, 0,-1);
                $coursemodels = $this->model('Roomcourse');
                $word_folder_scores = $coursemodels->getFoldersScore($word_folderids,$roominfo['crid'],$user['uid']);//获取国土的非视频课总得分
                if (!empty($word_folder_scores)) {//构建非视频课课程id和总学分的映射
                    foreach ($word_folder_scores as $key => $value) {
                        $word_folder_scores_map[$value['folderid']] = $value['score'];
                    }
                }
            }
        }

        $useSum = $is_zjdlr ? TRUE : FALSE;
        $apiServer = Ebh::app()->getApiServer('ebh');
        $sdata = array('crid'=>$roominfo['crid'],'uid'=>$user['uid'],'folderids'=>$folderids);
        $scorelist = $apiServer->reSetting()->setService('Classroom.Score.folderScore')->addParams($sdata)->request();

        //课程进度数组计算结果记录到课程列表的进度字段
        if($roominfo['isschool'] != 7 && !empty($folders)){
            foreach($folders as $k=>$folder){
                // var_dump($folder);exit;
                $folderid = $folder['folderid'];
                $folders[$k]['creditget'] = empty($scorelist[$folderid])?0:$scorelist[$folderid]['sumscore'];
                if (!empty($word_folder_scores_map[$folderid])) {
                    $folders[$k]['creditget'] = $word_folder_scores_map[$folderid];
                }
                // if(empty($folder['credit']) || empty($folder['cwcredit']) || empty($folder['cwpercredit'])
                // || $folder['credit'] == 0 || $folder['cwcredit'] == 0 || $folder['cwpercredit'] == 0 ){//新版学分信息不完整时
                if(!empty($foldercwlist[$folderid])){//课程的视频课件
                    $cwids = array_column($foldercwlist[$folderid],'cwid');
                    $cwids = implode(',',$cwids);
                    // var_dump($cwids);
                    $cwprogress = $this->_getProgress($user['uid'],$cwids,$useSum);
                    // var_dump($cwprogress);
                    $percent = array_sum($cwprogress)/count($cwprogress);
                    $folders[$k]['percent'] = round($percent,2);
                } else {
                    $folders[$k]['percent'] = 0;
                }
                // } else {
                // $folders[$k]['percent'] = empty($scorelist[$folderid]) || empty($folder['credit'])?0:round($scorelist[$folderid]['sumscore']/$folder['credit']*100,2);
                // }
                $folders[$k]['sumtime'] = 0;//累计时长
            }
        }
        $f = $$foldertype;
        $schoolType = call_user_func(array(Ebh::app()->lib('UserUtil'), 'getRoomInfo'), 'type');//获取网校类型
        $param = array();
        $param['crid'] = $roominfo['crid'];//获取网校crid
        $param['uid'] = $user['uid'];//获取用户id
        $param['folderids'] = $folderids;

        $folderList = $apiServer->reSetting()->setService('Study.FolderLog.get')->addParams($param)->request();
        if(($foldertype =='folders' && $roominfo['isschool']==7) || ($foldertype=='spfolders'&&!empty($$foldertype))){
            foreach($f as $k=>$package){
                foreach($package['itemlist'] as $l=>$folder){
                    // var_dump($folder);exit;
                    $folderid = $folder['folderid'];
                    $f[$k]['itemlist'][$l]['creditget'] = empty($scorelist[$folderid])?0:$scorelist[$folderid]['sumscore'];

                    // if(empty($folder['credit']) || empty($folder['cwcredit']) || empty($folder['cwpercredit'])
                    // || $folder['credit'] == 0 || $folder['cwcredit'] == 0 || $folder['cwpercredit'] == 0 ){//新版学分信息不完整时
                    if(!empty($foldercwlist[$folderid]) ){//课程的视频课件
                        $currFolder = isset($folderList[$folderid]) ? $folderList[$folderid] : array();//取当前课程数组
                        if (!empty($currFolder)) {
                            $cwlength = isset($currFolder['cwlength']) ? $currFolder['cwlength'] : 0;
                            if ($schoolType == 2) {
                                //国土处理方式
                                $totalltime = isset($currFolder['totalltime']) ? $currFolder['totalltime'] : 0;
                                $percent    = $totalltime / $cwlength * 100;
                            } else {
                                //非国土的处理方式
                                $ltime   = isset($currFolder['ltime']) ? $currFolder['ltime'] : 0;
                                $percent = $ltime / $cwlength * 100;

                            }

                        } else {
                            $percent = 0;
                        }
                        //$percent = array_sum($cwprogress)/count($cwprogress);
                        $f[$k]['itemlist'][$l]['percent'] = round($percent,2);
                    } else {
                        $f[$k]['itemlist'][$l]['percent'] = 0;
                    }
                    // } else {
                    // $f[$k]['itemlist'][$l]['percent'] = empty($scorelist[$folderid]) || empty($folder['credit'])?0:round($scorelist[$folderid]['sumscore']/$folder['credit']*100,2);
                    // }
                    $f[$k]['itemlist'][$l]['sumtime'] = 0;//累计时长
                }
            }
        }
        if($foldertype == 'folders')
            $folders = $f;
        elseif($foldertype == 'spfolders')
            $spfolders = $f;

    }

}

?>