<?php
/**
*�Ż���վ��Ӧ�����ݿ�Model��
*/
class CPortalModel extends CModel{
	var $portaldb;
	public function __construct(){
		parent::__construct();
		$this->portaldb = Ebh::app()->getOtherDb('portaldb');
	}
}