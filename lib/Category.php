<?php 
class Category {
	public function getCate(){

		$catemodel = Ebh::app()->model('Category');
		$param = array('upid'=>0,'position'=>4,'visible'=>1);
		$cate = $catemodel->getCategoriesByParam($param);
		return $cate;
	}
	public function getCateByPos($pos) {
		$catemodel = Ebh::app()->model('Category');
		$cate = $catemodel->getCatlistByUpid(0,$pos);
		return $cate;
	}
} 

?>