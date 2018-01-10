<?php 
/**
 *学生获取学校课程和章节控制器
 */
class ChapterController extends CControl{
	public function folder(){
		$result = array();
		$crid = $this->input->post('crid');
		if(is_numeric($crid) && ($crid>0)) {
			$result = $this->model('mychapter')->getfolder($crid);
			if(!empty($result)){
				array_unshift($result,array('folderid'=>0,'foldername'=>'所有课程','tid'=>0));
			}
		}
		echo json_encode($result);
	}
	/**
	 *根据folderid获取知识点列表
	 */
	public function chapterlist(){
		$result = array();
		$folderid = $this->input->post('folderid');
		if($folderid>0) {
			$param = array('folderid'=>$folderid,'limit'=>'0,2000');
			$result = $this->model('mychapter')->getList($param);
		}
		echo json_encode($result);
	}
	/**
	 * 获取知识点顶级分类
	 */
	public function topchapter(){
		$chapters = array();
		$crid = intval($this->input->post('crid'));
		if($crid>0){
			$param['crid'] = $crid;
			$param['level'] = 1;
			$mychap = $this->model('mychapter');
			$chapters = $mychap->getChapterList($param);
		}
		echo json_encode($chapters);
	}
	/**
	 * 获取知识点第二级分类 
	 */
	public function secchapter(){
		$chapters = array();
		$crid = intval($this->input->post('crid'));
		$topid = intval($this->input->post('topid'));
		if($crid >0 && $topid>0){
			$param['crid'] = $crid;
			$param['pid'] = $topid;
			$param['level'] = 2;
			$mychap = $this->model('mychapter');
			$chapters = $mychap->getChapterList($param);
		}
		echo json_encode($chapters);
	}
	/**
	 * 获取知识点第三级分类树节点数据 
	 */
	public function lastchapter(){
		$crid = intval($this->input->post('crid'));
		$topchapterid = intval($this->input->post('topchapterid'));
		$secchapterid = intval($this->input->post('secchapterid'));
		$chapters = array();
		if(!empty($crid) && !empty($topchapterid) && !empty($secchapterid)){
			$mychap = $this->model('mychapter');
			$versionid = '/'.$topchapterid.'/'.$secchapterid.'/';
			$param['crid'] = $crid;
			$param['chapterpath'] = $versionid;
			$chapters = $mychap->getChapterList($param);
		}
		echo json_encode($chapters);
	}
}