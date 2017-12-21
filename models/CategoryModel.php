<?php
/**
 * 分类model类
 */
class CategoryModel extends CModel{
    /**
     * 根据父ID等信息获取分类列表
     * @param type $upid
     * @param type $position
     * @param type $system
     * @param type $visible
     * @return type
     */
    public function getCatlistByUpid($upid = 0,$position = 0,$system = 1,$visible = 1,$limit = NULL) {
        $sql = 'SELECT c.catid,c.upid,c.code,c.name,c.keyword,c.caturl,c.system FROM ebh_categories c';
        $wherearr = array();
        if($upid !== NULL) {
            $wherearr[] = 'c.upid='.$upid;
        }
        if($position !== NULL) {
            $wherearr[] = 'c.position='.$position;
        }
        if($system !== NULL) {
            $wherearr[] = 'c.system='.$system;
        }
        if($visible !== NULL) {
            $wherearr[] = 'c.visible='.$visible;
        }
        if(!empty($wherearr)) {
            $sql .= ' WHERE '.implode(' AND ', $wherearr);
        }
        $sql .= ' order by c.displayorder asc';
		if(!empty($limit)) {
			$sql .= ' limit '.$limit;
		}
        return $this->db->query($sql)->list_array();
    }
    /**
     * 根据code获取频道信息
     * @param string $code
     * @return array
     */
    public function getCatByCode($code,$upid = 0) {
        $sql = 'select c.catid,c.upid,c.code,c.name,c.visible,c.system from ebh_categories c where c.code='.$this->db->escape($code) .' AND c.upid = '.$upid;
        return $this->db->query($sql)->row_array();
    }
     /**
     * 根据catid获取频道信息
     * @param string $code
     * @return array
     */
    public function getCatBycatid($catid) {
        $sql = 'select c.* from ebh_categories c where c.catid='.$this->db->escape($catid) .' limit 1';
        return $this->db->query($sql)->row_array();
    }
    public function getSimpleCatBycatid($catid) {
        $sql = 'select c.catid,c.upid,c.name from ebh_categories c where c.catid='.$this->db->escape($catid) .' limit 1';
        return $this->db->query($sql)->row_array();
    }
    /**
     * 根据父catid获取频道信息
     * @param string $pid
     * @return array
     */
   public function getListByPid($pid=null){
        if(is_null($pid))return;
        $sql='select * from ebh_categories where upid='.$pid;
        return $this->db->query($sql)->list_array();
   }
    /**
     * 删除处理函数，删除失败则回滚事件，防止删除系统目录,用于即将被删除分类下面的子分类有系统目录时回滚删除，防止误删
     * 要删除某个分类最好使用此方法，此方法有效地防止了系统目录的误删除;此方法会删除传入的catid对应的分类以及其后代所
     * 有分类
     *@param int $catid分类catid
     * @return bool
     */
   public function deleteHandle($catid=null){
        $this->db->begin_trans();
        if($this->delete($catid)===false){
            $this->db->rollback_trans();
            return false;
        }else{
            $this->db->commit_trans();
        }
        $this->db->commit_trans();
        return true;
   }
    /**
     * 根据catid删除分类,包含下面所有子分类，如果该分类是系统目录怎删除失败;被本控制器的deleteHandle()调用
     * @param string $catid
     * @return bool
     */
   
    private function delete($catid=null){
        $isok = true;
        if(is_null($catid)||!is_int($catid)){
            return false;
        }
        $catid=intval($catid);
        $sql = 'select catid,system from ebh_categories where catid='.$catid.' limit 1';
        $thisCateInfo = $this->db->query($sql)->row_array();
        if($thisCateInfo==false){
            return false;
        }
        $catid = $thisCateInfo['catid'];
        $system = $thisCateInfo['system'];
        if($system==1){
            return false;
        }
        $chlidCate = $this->getListByPid(intval($catid));
        if($chlidCate!=false){
            foreach ($chlidCate as $v) {
                if($this->delete(intval($v['catid']))===false){
                    $isok = false;
                }
            }
        }
        if($this->db->delete('ebh_categories','catid='.$catid)==-1){
            $isok = false;
        }


        return $isok;
    }

    //栏目上移,$upordown=0表示移动到，$upordown=1表示上移,$upordown=-1表示下移
    public function move($catid=null,$upordown=0,$displayorder=-1){
        if(is_null($catid)||!is_int($catid)){
            return false;
        }
        $sql = 'select catid,upid,position,displayorder from ebh_categories where catid='.$catid.' limit 1';
        $thisCateInfo = $this->db->query($sql)->row_array();
        if($thisCateInfo==false){
            die('分类不存在!1');
        }
        $catid = $thisCateInfo['catid'];
        $upid = $thisCateInfo['upid'];
        $position = $thisCateInfo['position'];
        $displayorder = intval($thisCateInfo['displayorder']);
        if($upordown==1||$upordown==-1){
            return $this->moveupordown($catid,$upid,$displayorder,$upordown,$position);
            exit();
        }else{
            return false;
        }
        
        return false;
    }
    //栏目上移或者下移,不单用，由本控制器的move方法调用
    private function moveupordown($catid,$upid,$displayorder,$tag,$position){
        $isok = true;
        if($tag==1){
            $sql = 'select c.catid,c.displayorder from ebh_categories c where c.displayorder<'.$displayorder.' and c.upid='.$upid.' and position='.intval($position).' order by displayorder desc limit 0,1';
        }else{
            $sql = 'select c.catid,c.displayorder from ebh_categories c where c.displayorder>'.$displayorder.' and c.upid='.$upid.' and position='.intval($position).' order by displayorder asc limit 0,1';
        }
        $targetInfo = $this->db->query($sql)->row_array();
        if($targetInfo==false){
            return false;
        }
        $targetDisplayorder = intval($targetInfo['displayorder']);
        $targetCatid = intval($targetInfo['catid']);
        if($this->db->update('ebh_categories',array('displayorder'=>$displayorder),array('catid'=>$targetCatid))===false){
            $isok = false;
        }
        if($this->db->update('ebh_categories',array('displayorder'=>$targetDisplayorder),array('catid'=>$catid))===false){
            $isok = false;
        }
        return $isok;
    }



    /**
     * 编辑栏目
     * @param $paramarr 参数数组
     *$paramarr['op'] = 'insert'表示新增一条记录,否则为修改一条记录;如果修改记录必须$paramarr['catid']*必须必须存在且为int类型
     * @return bool
     */
    public function op($paramarr) {
        if (!empty ( $paramarr )) {
            $setarray = array (
            "upid" => empty ( $paramarr ["upid"] ) ? 0 : intval ( $paramarr ["upid"] ),
             "code" => empty ( $paramarr ["code"] ) ? "" : $paramarr ["code"],
             "name" => empty ( $paramarr ["name"] ) ? "" : $paramarr ["name"],
             "type" => empty ( $paramarr ["type"] ) ? "" : $paramarr ["type"],
             "ischannel" => empty ( $paramarr ["ischannel"] ) ? 0 : intval ( $paramarr ["ischannel"] ),
             "keyword" => empty ( $paramarr ["keyword"] ) ? "" : $paramarr ["keyword"],
             "description" => empty ( $paramarr ["description"] ) ? "" : $paramarr ["description"],
             "displayorder" => empty ( $paramarr ["displayorder"] ) ? 0 : intval ( $paramarr ["displayorder"] ),
             "tpl" => empty ( $paramarr ["tpl"] ) ? "" : $paramarr ["tpl"],
             "viewtpl" => empty ( $paramarr ["viewtpl"] ) ? "" : $paramarr ["viewtpl"],
             "thumb" => empty ( $paramarr ["thumb"] ) ? "" : $paramarr ["thumb"]['upfilepath'],
             "image" => empty ( $paramarr ["image"] ) ? "" : $paramarr ["image"]['upfilepath'],
             "caturl" => empty ( $paramarr ["caturl"] ) ? "" : $paramarr ["caturl"],
             "target" => empty ( $paramarr ["target"] ) ? "" : $paramarr ["target"],
             "position" => empty ( $paramarr ["position"] ) ? 0 : intval ( $paramarr ["position"] ),
             "visible" => empty ( $paramarr ["visible"] ) ? 0 : intval ( $paramarr ["visible"] ),
             "system"=>empty($paramarr['system'])? 0: intval ( $paramarr ["system"] ),
             "domain"=>empty($paramarr['domain'])? "": $paramarr ["domain"]
            );
            if (isset ( $paramarr ['opvalue'] )) {
                $setarray ['opvalue'] = $paramarr ['opvalue'];
            }
            if(trim($paramarr['op'])=='insert'){
                return $this->db->insert('ebh_categories',$setarray);
            }else{
                
                $sql = 'select position from ebh_categories c where c.catid ='.$paramarr['catid'];
                $childInfo = $this->db->query($sql)->row_array();
                if($childInfo['position']!=$paramarr['position']){
                    $setarray['upid'] = 0;
                }
                $res =$this->setChlidrenPosition($paramarr['catid'],$paramarr['position']);
                $res&= $this->db->update('ebh_categories',$setarray,array('catid'=>$paramarr['catid']));
                
                return $res;
            }
            
            
            
        } else {
            return false;
        }
    }


    /**
     * 根据相关条件查询相关分类信息;
     * @param arary $where
     * @return array
     */
    public function getCategoriesByParam($where=array()){
        $sql='select catid,upid,name,type,code,position,visible,displayorder,system from ebh_categories c';
        $sql.=$this->parseWhere($where);
        $sql.=' order by position asc , displayorder asc';
        return $this->db->query($sql)->list_array();
       
    }


    /*
        简单的where条件处理;
        用法:传入 array(cid=>1,name="a");返回 where cid=1 and name='a';
        主要用于生成简单的sql语句的where条件
    */
    private function parseWhere($where=array()){
        if(isset($where[0])&&!is_array($where[0])){
            return ' where '.$where[0];
        }
        $where = $this->db->escape_str($where);
        if(count($where)==0){
            return;
        }
        $newwhere=' where ';
        foreach ($where as $key => $value) {
            if($value==''){continue;}
            $value=trim($value);
            if(preg_match("/^[0-9]+$/",$value)){
                $newwhere.=$key.'='.$value.' and ';
            }else{
                $newwhere.=$key.'='."'$value' and ";
            }
           
        }
        if(trim($newwhere)=='where')return '';
        return rtrim($newwhere,'and ');

    }
    /**
     * 排序处理;
     * @param arary $param
     * @return bool
     *$param=array(
     *   array($catid1,$displayorder1),
     *   array($catid2,$displayorder2)
     *   )格式
     */
    public function sortopAll($param=array()){
        $isOk=true;
        if(is_array($param)&&count($param)>0){
            foreach ($param as $value) {
                if($this->db->update('ebh_categories',array('displayorder'=>$value[1]),array('catid'=>$value[0]))===false){
                      $isOk=false;
                }
            }
        }
        return $isOk;
    }
    /**
     * 批量移动处理;
     * @param arary $paramarr
     * @param int $category
     * @param string $tag
     * @return bool
      *  其中$paramarr为catid的集合如$paramarr = array(3,4,5);$category为upid的值;$tag为inside(移动到里面),before(移动到前面),after(移动到后面)其中的一个
     */
    public function moveopAll($paramarr=array(),$category='',$tag=''){
        $isok = true;
        $this->db->begin_trans();
        $sql = 'select c.catid , c.position from ebh_categories  c where catid='.intval($category);
        $targetInfo = $this->db->query($sql)->row_array();
        //catid相关信息不存在!
        if($targetInfo==false){
            $isok = false;
        }
        if($tag=='inside'){
            $isok = $this->moveopAllInside($paramarr,$category,$targetInfo['position']);
        }elseif($tag=='before'){
            $isok = $this->moveopAllBefore($paramarr,$category,$targetInfo['position']);
        }elseif($tag=='after'){
            $isok = $this->moveopAllAfter($paramarr,$category,$targetInfo['position']);
        }else{
            $isok = false;
        }
        if($isok===true){
            $this->db->commit_trans();
        }else{
            $this->db->rollback_trans();
        }
        return $isok;
    }
    /**
     * 批量移动处理;由本控制器的moveopAll调用，不单用
     * @param arary $paramarr
     * @param int $category 
     * @return bool
     */
    private function moveopAllInside($paramarr,$category,$position){
        $isOk=true;
        foreach ($paramarr as $value) {
            if(intval($position)===0){
                if(!$this->db->update('ebh_categories',array('upid'=>$category),array('catid'=>$value))){
                 $isOk=false;
                }
            }else{
                if(!$this->db->update('ebh_categories',array('upid'=>$category,'position'=>intval($position)),array('catid'=>$value))){
                     $isOk=false;
                }
            }

            if($this->setChlidrenPosition($value,$position)===false){
                return false;
            }
        }
       
        return $isOk;
    }
    /**
     *由本控制器的move函数调用，不单用
     */
    private function moveopAllBefore($paramarr,$category,$position){
        $isOk=true;
        $sql = 'select upid,displayorder from ebh_categories where catid = '.$category.' limit 1';
        $cateinfo = $this->db->query($sql)->row_array();
        $cateinfo['displayorder'] = max(intval($cateinfo['displayorder'])-5,0);
        foreach ($paramarr as $value) {
            if(intval($position)===0){
                if(!$this->db->update('ebh_categories',array('upid'=>$cateinfo['upid'],'displayorder'=>$cateinfo['displayorder']),array('catid'=>$value))){
                     $isOk=false;
                }
            }else{
                if(!$this->db->update('ebh_categories',array('upid'=>$cateinfo['upid'],'position'=>intval($position),'displayorder'=>$cateinfo['displayorder']),array('catid'=>$value))){
                     $isOk=false;
                }                
            }

            if($this->setChlidrenPosition($value,$position)===false){
                return false;
            }
        }
        
        return $isOk;
    }
    /**
     *由本控制器的move函数调用，不单用
     */
    private function moveopAllAfter($paramarr,$category,$position){
        $isOk=true;
        $sql = 'select upid,displayorder from ebh_categories where catid = '.$category.' limit 1';
        $cateinfo = $this->db->query($sql)->row_array();
        $cateinfo['displayorder'] = intval($cateinfo['displayorder'])+5;
        foreach ($paramarr as $value) {
            if(intval($position)===0){
                if(!$this->db->update('ebh_categories',array('upid'=>$cateinfo['upid'],'displayorder'=>$cateinfo['displayorder']),array('catid'=>$value))){
                     $isOk=false;
                }                
            }else{
                if(!$this->db->update('ebh_categories',array('upid'=>$cateinfo['upid'],'position'=>intval($position),'displayorder'=>$cateinfo['displayorder']),array('catid'=>$value))){
                 $isOk=false;
                }
            }

            if($this->setChlidrenPosition($value,$position)===false){
                return false;
            }
        }
       
        return $isOk;
    }
    /**
     *循环设置后代分类的position,用于分类移动到某个分类里面时的辅助方法，不单用
     *@author zkq 
     *@modify by zkq in 2014-04-24
     *该方法将对应的catid的position修改为传入的$position
     */
    private function setChlidrenPosition($catid,$position){
        //$isok = true;
        //获取所有的后代分类的catid
        // $sql = 'select c.catid,c.upid from ebh_categories c where c.upid ='.intval($catid);
        // $res = $this->db->query($sql)->list_array();
        // if(count($res)>0){
        //     foreach ($res as $v) {
        //         if($this->db->update('ebh_categories',array('position'=>intval($position)),array('catid'=>intval($v['catid'])))===false){
        //             $isok = false;
        //             break;
        //         }
        //         $isok = $this->setChlidrenPosition(intval($v['catid']),$position);
        //         if($isok===false){
        //             break;
        //         }
        //     }
        // }
        // return $isok;
        $catidsArr = $this->getOffspringCatid($catid);
        if(empty($catidsArr))return true;
        $param = array('position'=>intval($position));
        $where = 'catid in ('.implode(',',$catidsArr).')';
        if($this->db->update('ebh_categories',$param,$where)!==false){
            return true;
        }else{
            return false;
        }
    }
	/*
	只包含id和name的分类列表,供教室->所属分类使用
	@return array
	*/
	public function getsimplecatlist(){
		$sql = 'select c.catid,c.upid,c.name from ebh_categories c where type="courseware" and position=1';
		return $this->db->query($sql)->list_array();
	}
    //获取广告分类列表
    public function getsimplecatlistad(){
        $sql = 'select c.catid,c.upid,c.name from ebh_categories c where ischannel= 1';
        return $this->db->query($sql)->list_array();
    }
    /**
     *@param String $type
     *@return array
     *获取资源分类列表用于搜索
     *传入$type = 'news' ,'ad'等，返回对应分类数组
     */
    public function getsimplelist($type){
        $sql = 'select c.catid,c.upid from ebh_categories c where type= '."'$type'";
        return $this->db->query($sql)->list_array();
    }
    /**
     *@param int $catid
     *@return bool
     *判断分类是否存在，一般用于用于安全方面，防止用户篡改catid而造成不必要的麻烦;
     *存在返回true,失败返回false
     */
    public function existCat($catid=null){
        if(is_null($catid)){
            return false;
        }
        $sql = 'select count(c.catid) count from ebh_categories c  where c.catid = '.intval($catid).' limit 1';
        $res = $this->db->query($sql)->row_array();
        if($res['count']==1){
            return true;
        }else{
            return false;
        }

    }
    /**
     *根据catid获取其所有的后代分类的catid
     *@author zkq
     *@date 2014-04-24
     *@param int catid
     *@return array
     */
    public function getOffspringCatid($catid){
        $offspring = array();
        $sql='select c.catid as catid from ebh_categories c where c.upid='.$catid;
        $catids = $this->db->query($sql)->list_array();
        if(!empty($catids)){
            foreach ($catids as $rv) {
                $offspring[]=intval($rv['catid']);
                $offspring = array_merge($offspring,$this->getOffspringCatid($rv['catid']));
            }
        }
        return $offspring;
    }
    /**
     *根据catid获取该分类的最顶层的父级信息
     *@author zkq
     *@param int $catid
     *@return array (一维数组)
     */
    public function getParentInfo($catid){
        $parentInfo = array();
        $sql = 'select catid,upid,code from ebh_categories where catid='.intval($catid).' limit 1 ';
        $parentInfo = $this->db->query($sql)->row_array();
        if(!empty($parentInfo)){
            $parentPre = $this->getParentInfo($parentInfo['upid']);
            if($parentPre===false){
                return $parentInfo;
            }else{
                return $parentPre;
            }
        }else{
            return false;
        }
    }
	
	/*
	答疑提问处的选择分类
	*/
	public function getCategoriesForAskquestion(){
		$sql = 'select catid,upid,code,name,keyword from ebh_categories c where c.position=5 and c.visible=1 order by c.upid asc,c.displayorder asc';
		$resarr = $this->db->query($sql)->list_array();
		$catlist = array();
		foreach($resarr as $cat){
			if($cat['upid'] == 0) {
				$cat['subcat'] = array();
				$catlist[$cat['catid']] = $cat;
			} else {
				if(isset($catlist[$cat['upid']])) {
					$catlist[$cat['upid']]['subcat'][] = $cat;
				}
			}
		}
		return $catlist;
	}
	/**
	 *根据code获取catid
	 *@param String $code
	*/
	public function getCatidByCode($code=''){
		$sql ='select catid from ebh_categories where code="'.$this->db->escape_str($code).'"';
		$res = $this->db->query($sql)->row_array();
		return $res['catid'];
	}

}
