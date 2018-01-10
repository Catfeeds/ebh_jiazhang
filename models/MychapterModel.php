<?php
/**
 *我的知识点模型
 */
class MychapterModel extends CModel{
    public function getList($param= array()){
        $sql = 'SELECT c.*,f.foldername FROM  ebh_schchapters c  JOIN ebh_folders f ON c.folderid = f.folderid';
        $wherearr = array ();
        if (!empty($param['chapterid'] )) {
            $wherearr [] = 'c.chapterid = ' . $param['chapterid'];
        }
        if(!empty($param['crid'])){
            $wherearr[] = 'c.crid = '.$param['crid'];
        }
        if (isset($param['pid'] )) {
            $wherearr [] = 'c.pid = ' . $param['pid'];
        }
        if(! empty ( $param['chapterpath'] )){
            $wherearr [] = ' c.chapterpath like \''.$param['chapterpath'].'%\' ';
        }
        if(! empty ( $param['level'] )){
            $wherearr [] = ' c.level = ' . $param['level'];
        }
        if(! empty ( $param['folderid'] )){
            $wherearr [] = ' c.folderid = ' . $param['folderid'];
        }
        if (!empty( $wherearr )) {
            $sql.= ' WHERE ' . implode ( ' AND ', $wherearr );
        }
        if(!empty($param['order'])){
            $sql.=' order by '.$param['order'];
        }else{
            $sql.=' order by c.pid,c.displayorder,c.chapterid ';
        }
        if (!empty($param['limit'])) {
            $sql .= ' limit ' . $param['limit'];
        } else {
            $sql .= ' limit 0,10';
        }
        $chapterList = $this->db->query($sql)->list_array();
        $newChapterList = array();
        foreach ($chapterList as $chapter) {
            $newChapterList[$chapter['chapterid']] = $chapter;
        }
        $result = array();
        $chapterList = $this->getchaptertrees($newChapterList);
        if(!empty($chapterList)) {
            foreach($chapterList as $chapter) {
                $result[] = $chapter;
            }
        }
        return $result;
    }

	/**
	*以树结构方式获取章节列表
	*/
	function getchaptertrees($chapterlist) {
		$chapterarr = array();
		$chaptertree = array();
		foreach($chapterlist as $chapter) {
			if (empty($chapter['pid']))
				$chaptertree[0][] = $chapter['chapterid'];
			else {
				$chaptertree[$chapter['pid']][] = $chapter['chapterid'];
			}
		}
		$pid = 0;
		$this->getchapterarray($chapterlist,$chaptertree,$chapterarr,$pid);
		return $chapterarr;
	}
	function getchapterarray($chapterlist,$chaptertree,&$chapterarr,$pid) {
		if(isset($chaptertree[$pid])) {
			foreach($chaptertree[$pid] as $childchapter) {
				$chapterarr[$childchapter] = $chapterlist[$childchapter];
				$this->getchapterarray($chapterlist,$chaptertree,$chapterarr,$childchapter);
			}
		}
	}

	/**
	*判断给定章节名称是否存在
	*/
	public function chapter_exists($chaptername,$folderid=0,$pid=0,$chapterid=0) {
		if(empty($chapterid)) {
			$sql = 'select * from ebh_schchapters c where c.folderid='.$folderid.' and c.pid='.$pid." and c.chaptername='".$chaptername."'";
		} else {
			$sql = 'select * from ebh_schchapters c where c.folderid='.$folderid.' and c.pid='.$pid.' and c.chapterid !='.$chapterid." and c.chaptername='".$chaptername."'";
		}
		$item = $this->db->query($sql)->list_array();
		return empty($item)?false:true;
	}

	/**
	*添加知识点信息
	*/
	public function insert($param = array(),$returnid = false) {
		$setarr = array ();
		if(empty($param['chaptername']))
			return false;
		if (!empty($param['pid'])) {
			$setarr['pid'] = intval($param['pid']);
			$upitem = $this->getchapterbyid($param['pid']);
			if(!empty($upitem)) {
				$setarr['level'] = $upitem['level'] + 1;
				$setarr['chapterpath'] = $upitem['chapterpath'];
			}
		}
		if (! empty( $param['chaptername'] )) {
			$setarr['chaptername'] =  $param['chaptername'] ;
		}
		if (! empty( $param['folderid'] )) {
			$setarr['folderid'] =  intval($param['folderid']) ;
		}
		if (! empty( $param['uid'] )) {
			$setarr['uid'] =  intval($param['uid']) ;
		}
		if (!empty($param['displayorder'])){
			$setarr['displayorder'] =  intval($param['displayorder']) ;
		}
		$chapterid = $this->db->insert('ebh_schchapters', $setarr);
		
		if($chapterid) {
			$this->fixchapterpath($chapterid);
		}
		return $chapterid;
	}
	/**
	*更新知识点信息
	*/
	function update($param,$chapterid) {
		$setarr = array ();
		if (!empty( $param['chaptername'] )) {
			$setarr['chaptername'] =  $param['chaptername'] ;
		}
		if (!empty($param['folderid'])){
			$setarr['folderid'] =  intval($param['folderid']) ;
		}
		if (isset($param['pid'])){
			$setarr['pid'] =  intval($param['pid']) ;
		}
		if (! empty ( $param['level'] )) {
			$setarr['level'] =  intval($param['level']) ;
		}
		if (!empty ($param['chapterpath'])){
			$setarr['chapterpath'] =  $param['chapterpath'] ;
		}
		if (!empty ($param['displayorder'])){
			$setarr['displayorder'] =  intval($param['displayorder']) ;
		}
		if(empty($setarr) || empty($chapterid))
			return false;
		$wherearr = array('chapterid'=>$chapterid);
		$result = $this->db->update('ebh_schchapters',$setarr,$wherearr);
		$curchapter = $this->getchapterbyid($chapterid);
		if(empty($param['chapterpath'])){
			$chapterpath = $this->fixchapterpath($chapterid);
		}
		if(!empty($curchapter)){
			$this->_updatechildren($curchapter['chapterid'],$curchapter['level'],$curchapter['chapterpath']);
		}
		return $result;
	}

	/**
	*根据章节id获取章节信息
	*/
	public function getchapterbyid($chapterid) {
		if(empty($chapterid))
			return false;
		$sql = 'select c.*,f.foldername from ebh_schchapters c join ebh_folders f on (c.folderid=f.folderid) where c.chapterid='.$chapterid;
		return $this->db->query($sql)->row_array();
	}
	/**
	*根据chapterid删除章节
	*/
	public function delete_byid($chapterid,$uid = 0) {
		$sql = 'select * from ebh_schchapters where pid='.$chapterid;
		$children = $this->db->query($sql)->list_array();
		if(!empty($children)) {	//不能删除有子集的章节
			return -1;
		}
		$where = array('chapterid'=>$chapterid,'uid'=>$uid);
		return $this->db->delete('ebh_schchapters',$where);
	}

    /**
     *获取老师所教课程,用于知识点编辑
     */
    function getfolder($crid,$tid = 0){
        $result = array();
        if(!empty($tid)){
            $sql = 'SELECT f.folderid,f.foldername,tf.tid FROM ebh_folders f left join  ebh_teacherfolders tf on f.folderid = tf.folderid  where tf.crid = '.$crid.' and f.folderlevel = 2 and f.power != 2 and tf.tid = '.$tid;
            $result = array();
            $result = $this->db->query($sql)->list_array();
        }else{
            $sql = 'SELECT f.folderid,f.foldername FROM ebh_folders f where f.crid = '.$crid.' and f.folderlevel = 2 and f.power != 2';
            $result = array();
            $result = $this->db->query($sql)->list_array();
        }
        return $result;
    }

	function multimove($param){
		$setarr = array();
		if (!empty($param['folderid'])){
			$setarr['folderid'] =  intval($param['folderid']) ;
		}
		if (isset($param['pid'])){
			$setarr['pid'] =  intval($param['pid']) ;
		}
	}
	//根据章节id批量将其排序加1
	function incorder($chapteridArr,$displayorder = 0){
		//获取displayorder最小的知识点
		$sql = 'select min(displayorder) as morder from ebh_schchapters where chapterid in ('.implode(',', $chapteridArr).')';
		$res = $this->db->query($sql)->row_array();
		$morder = $res['morder'];
		$step = $displayorder-$morder+2;
		$wherearr = ' chapterid in ('.implode(',', $chapteridArr).')';
        $setarr = array('displayorder' => 'displayorder+'.$step);
        $afrows = $this->db->update('ebh_schchapters', array(), $wherearr, $setarr);
        return $afrows;
	}

	/**
	 *递归升级子知识点的level和chapterpath
	 *$pid 父级id
	 *$level 父级level
	 *$chapterpath 父级chapterpath
	 */
	private function _updatechildren($pid = 0,$level = 0,$chapterpath = ''){
		$sql = 'select chapterid from ebh_schchapters where pid = '.$pid;
		$children = $this->db->query($sql)->list_array();
		if(empty($children)){
			return;
		}
		$ch_chapterids = array();
		foreach ($children as $child) {
			$this->_updatechildren($child['chapterid'],$level,$chapterpath.'/'.$child['chapterid']);
			$ch_chapterids[] = $child['chapterid'];
		}
		$wherearr = ' chapterid in ('.implode(',', $ch_chapterids).')';
		$setarr = array('level'=>$level+1,'chapterpath'=>'CONCAT("'.$chapterpath.'/",chapterid)');
		$this->db->update('ebh_schchapters', array(), $wherearr, $setarr);
	}

	//根据chapterid递归获取正确的chapterpath
	private function _fixchapterpath($chapterid = 0){
		$path = '';
		$curchapter = $this->getchapterbyid($chapterid);
		//获取父节点
		$pchapter = $this->getchapterbyid($curchapter['pid']);
		if(!empty($pchapter)){
			$path = $this->_fixchapterpath($pchapter['chapterid']).$path;
		}
		if(empty($chapterid)){
			$chapterid = '';
		}
		return $path.'/'.$chapterid;
	}
	//根据chapterip修正chapterpath
	public function fixchapterpath($chapterid = 0){
		if(empty($chapterid)){
			return;
		}
		$chapterpath = $this->_fixchapterpath($chapterid);
		$level = substr_count($chapterpath,'/');
		$setarr = array(
			'chapterpath'=>$chapterpath,
			'level'=>$level
		);
		$wherearr = array(
			'chapterid'=>$chapterid
		);
		return $this->db->update('ebh_schchapters',$setarr,$wherearr);
	}

    //获取知识点列表，与getList的区别是知识点不再左连接后再查询提高效率
    public function getChapterList($param= array()){
        $sql = 'SELECT c.chapterid, c.pid, c.chaptername FROM  ebh_schchapters c ';
        $wherearr = array ();
        if (!empty($param['chapterid'] )) {
            $wherearr [] = 'c.chapterid = ' . $param['chapterid'];
        }
        if(!empty($param['crid'])){
            $wherearr[] = 'c.crid = '.$param['crid'];
        }
        if (isset($param['pid'] )) {
            $wherearr [] = 'c.pid = ' . $param['pid'];
        }
        if(! empty ( $param['chapterpath'] )){
            $wherearr [] = ' c.chapterpath like \''.$param['chapterpath'].'%\' ';
        }
        if(! empty ( $param['level'] )){
            $wherearr [] = ' c.level = ' . $param['level'];
        }
        if (!empty( $wherearr )) {
            $sql.= ' WHERE ' . implode ( ' AND ', $wherearr );
        }
        if(!empty($param['order'])){
            $sql.=' order by '.$param['order'];
        }else{
            $sql.=' order by c.pid,c.displayorder,c.chapterid ';
        }
        if (!empty($param['limit'])) {
            $sql .= ' limit ' . $param['limit'];
        }
        $chapterList = $this->db->query($sql)->list_array();
        return $chapterList;
    }

}