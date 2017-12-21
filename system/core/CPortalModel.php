<?php
/**
*门户网站对应的数据库Model类
*/
class CPortalModel extends CModel{
	var $portaldb;
	public function __construct(){
		parent::__construct();
		$this->portaldb = Ebh::app()->getOtherDb('portaldb');
	}
}