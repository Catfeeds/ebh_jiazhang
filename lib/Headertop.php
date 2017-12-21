<?php
class Headertop{
	//顶部
    public function getroom() {
        $user = Ebh::app()->user->getloginuser();
        $roommodel = Ebh::app()->model('classroom');
        $roomlist = $roommodel->getroomlistbyuid($user['uid']);
        return $roomlist;
    }
   
}
?>
