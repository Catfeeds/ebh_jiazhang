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

	
}