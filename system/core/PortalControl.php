<?php
class PortalControl extends CControl{
	public function __construct(){
        parent::__construct();
        $user = Ebh::app()->user->getloginuser();
        $this->assign('user',$user);
	}
    //数据分发器，统一分发数据
    public function _assignAll(){
        foreach ($this->data as $dkey => $dvalue) {
            $this->assign($dkey,$dvalue);
        }
    }
    /**
     *获取子栏目(包含自身)
     */
    public function getFamilyCates(){
        $catid = $this->uri->uri_attr(0);
        $pcategoriesModel = $this->model('pcategories');
        if($pcategoriesModel->isTopCate($catid)){
            $upid = $catid;
        }else{
            $upid = $pcategoriesModel->getUpidByCatid($catid);
        }
        return $pcategoriesModel->getFamilyCates($upid);
    }

    /**
     *获取子栏目(不包含自身)
     */
    public function getChildrenCates($includeEmptyCaturl = false,$catid=-1){
        if($catid==-1){
            $catid = $this->uri->uri_attr(0);
        }
        $pcategoriesModel = $this->model('pcategories');
        if($pcategoriesModel->isTopCate($catid)){
            $upid = $catid;
        }else{
            $upid = $pcategoriesModel->getUpidByCatid($catid);
        }
        return $pcategoriesModel->getChildrenCates($upid,$includeEmptyCaturl);
    }
    /**
     *获取热门关键词
    */
    public function getHotKeywords(){
        //15:校园在线,22:趣味百科,33成长励志
        $keywords = array('15'=>array('开学','状元','校园','浙江','教师','风景','暑期','经验','2014','理科','中学','杭州','数学','政治','生活','化学'),
              '22'=>array('神奇','千奇百怪','科学','预测','学霸','作业','趣闻','爆笑','故事','小苹果','盘点','2014','真题','排行','测试','盘点'),
              '33'=>array('励志','经典','感悟','秘诀','道理','创业','危机','基因','行动','漫谈','文学','书库','生活','国学','汉学','时代'),
              '8'=>array('新闻','名师','感悟','秘诀','道理','创业','危机','基因','行动','漫谈','文学','书库','生活','国学','汉学','时代')
            );
        $this->data['hotkeywords'] = $keywords[$this->cateInfo['catid']];
    }
}