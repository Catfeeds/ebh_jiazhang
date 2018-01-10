<?php

/*
 * examv2通用方法
 */

//判断是否是答题卡及其子类
function isX($ttype){
    return ($ttype == "X" || $ttype == "XTL" || $ttype == "XYD" || $ttype == "XWX" || $ttype == "XZH");
}

//处理php序列化和反序列化编码不一致可能出现的无法反序列化的问题
function mb_unserialize($out) {
    $out = preg_replace_callback('/s:(\d+):"(.*?)";/s', function($matches){
        return "s:".strlen($matches[2]).':"'.$matches[2].'";';
    }, $out );
    return unserialize($out);
}

/**
 *学生试卷答案和教师批改答案合并
 */
function insertWordQueScore(&$quevalue,&$ascores){
    if(is_numeric($ascores)){
        return;
    }
    $tpackage = json_decode($quevalue['datapackage']);
    foreach ($tpackage->data as $itemskey=>$items) {
        $type = $items->head->type;
        foreach ($items->detail as $itemkey => $item) {
            $u = $ascores['data'][$itemskey]['detail'][$itemkey]['u'];
            if (!empty($u['r'])) {
                $item->u->idx = $u['idx'];
                $item->u->r = $u['r'];
                $item->u->type = $u['type'];
                $item->u->ascore = $u['ascore'];
            } else {
                $item->u->ascore = $u['ascore'];
            }
            
            if($type == 'xd' || $type == 'xe'){
                $item->u->escore = empty($u['ascore'])?array():$u['ascore'];//答案不唯一的情况下
                $item->u->score = array_sum($u['ascore']);
            }
        }
    }
    //print_r($tpackage);exit;
    $quevalue['datapackage'] = json_encode_ex($tpackage);
}
//base64公式编辑器解包判断结果
function bIsRight($tans = '',$uans = ''){
    if(!empty($uans) && ($tans == $uans)){
        return true;
    }
    $tans_d = json_decode(base64_decode($tans));
    $right_ans = $tans;
    if(!empty($tans_d) && !empty($tans_d->latex)){
        $right_ans = $tans_d->latex;
    }
    $uans_d = json_decode(base64_decode($uans));
    $user_ans = $uans;
    if(!empty($uans_d) && !empty($uans_d->latex)){
        $user_ans = $uans_d->latex;
    }
    if($user_ans == $right_ans){
        return true;
    }else{
        $_right_ans = explode("#",$right_ans);
        $_user_ans = explode("#",$user_ans);
        trim_array($_right_ans);
        trim_array($_user_ans);
        $same = array_intersect($_right_ans,$_user_ans);
        if(!empty($same)){
            return true;
        }
    }
    return false;
}

//学生答题卡核对分数
function checkX($quevalue,&$toans){
	$result = array('score'=>0,'showtype'=>1);
	$tpackage = ($quevalue->datapackage);
	$upackage = json_decode($toans['datapackage']);
	$score = 0;
    $totalscore = 0;
	foreach ($tpackage->data as $itemskey=>$items) {
		$type = $items->head->type;
		foreach ($items->detail as $itemkey => $item) {
			$t = $item->t;
			$u = $upackage->data->$itemskey->detail->$itemkey->u;
            $totalscore += $t->score;
			if($type == 'xa' || $type == 'xb' || $type == 'xc' || $type =='xe'){
				if($t->r == $u->r){
					$u->score = $t->score;
					$score += $t->score;
				}else{
					$u->score = 0;
				}
			}else if($type == 'xd'){//填空题
				$info = array();
				$u->score = 0;
				foreach ($t->r as $ek => $ev) {
					if(bIsRight(trim($ev),trim($u->r[$ek]))){
						$right_score = !empty($t->ascore[$ek])?($t->ascore[$ek]):0;
						$info[$ek] = $right_score;
						$u->score+=$right_score;
					}else{
						$info[$ek] = "0";
					}
				}
				$u->escore = $info;
				$score+=$u->score;
			}
		}
        
	}
    $upackage->totalscore = $totalscore;
	$upackage->uscore = $score;
	$upackage->status = $quevalue->status;
	// $toans['datapackage'] = json_encode($upackage,JSON_UNESCAPED_UNICODE);
	$toans['datapackage'] = json_encode_ex($upackage);
	$result['score'] = $score;
	return $result;
}


/**
* 对变量进行 JSON 编码
* @param mixed value 待编码的 value ，除了resource 类型之外，可以为任何数据类型，该函数只能接受 UTF-8 编码的数据
* @return string 返回 value 值的 JSON 形式
*/
function json_encode_ex($value)
{
    if (version_compare(PHP_VERSION,'5.4.0','<'))
    {
        $str = json_encode($value);
        $str = preg_replace_callback(
                                    "#\\\u([0-9a-f]{4})#i",
                                    function($matchs)
                                    {
                                         return iconv('UCS-2BE', 'UTF-8', pack('H4', $matchs[1]));
                                    },
                                     $str
                                    );
        return $str;
    }
    else
    {
        return json_encode($value, JSON_UNESCAPED_UNICODE);
    }
}

function trim_array(&$arr){
    if (empty($arr)) {
        return '';
    }
    array_walk($atrim,$arr);
}


function ckeditor(){
    global $v;
    $str = '';
    if(strpos($_SERVER["HTTP_USER_AGENT"],"MSIE 7.0") || strpos($_SERVER["HTTP_USER_AGENT"],"MSIE 6.0")){
        $str .= '<script type="text/javascript" src="http://static.ebanhui.com/exam/js/ckeditorfix/ckeditor.js'.$v.'"></script>';
        $str .= '<script type="text/javascript" src="http://static.ebanhui.com/exam/js/ckeditorfix/adapters/jquery.js'.$v.'"></script>';
    }else{
        $str .= '<script type="text/javascript" src="http://static.ebanhui.com/exam/js/ckeditor/ckeditor.js'.$v.'"></script>';
        $str .= '<script type="text/javascript" src="http://static.ebanhui.com/exam/js/ckeditor/adapters/jquery.js'.$v.'"></script>';
    }
    return $str;
}
function checkbrowser(){
    global $_SGLOBAL;
    $agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : "";
//  if( stripos($agent,'Chrome') !== false ) {//测试使用
//      return true;
//  }
    /**
     * Determine if the user is using a BlackBerry (last updated 1.7)
     * @return boolean True if the browser is the BlackBerry browser otherwise false
     */
    if( stripos($agent,'blackberry') !== false ) {
        $_SGLOBAL['browser']='blackberry';
        return true;
    }
    /**
     * Determine if the browser is Pocket IE or not (last updated 1.7)
     * @return boolean True if the browser is Internet Explorer otherwise false
     */
    if( stripos($agent,'mspie') !== false || stripos($agent,'pocket') !== false ) {
        $_SGLOBAL['browser']='mspie';
        return true;
    }
    /**
     * Determine if the browser is Opera or not (last updated 1.7)
     * @return boolean True if the browser is Opera otherwise false
     */
    if( stripos($agent,'opera mini') !== false ) {
        $_SGLOBAL['browser']='opera mini';
        return true;
    }
    /**
     * Determine if the browser is Nokia or not (last updated 1.7)
     * @return boolean True if the browser is Nokia otherwise false
     */
    if( preg_match("/Nokia([^\/]+)\/([^ SP]+)/i",$agent,$matches) ) {
        $_SGLOBAL['browser']='Nokia';
        return true;
    }
    /**
     * Determine if the browser is iPhone or not (last updated 1.7)
     * @return boolean True if the browser is iPhone otherwise false
     */
    if( stripos($agent,'iPhone') !== false ) {
        $_SGLOBAL['browser']='iPhone';
        return true;
    }
    /**
     * Determine if the browser is iPod or not (last updated 1.7)
     * @return boolean True if the browser is iPod otherwise false
     */
    if( stripos($agent,'iPad') !== false ) {
        $_SGLOBAL['browser']='iPad';
        return true;
    }
    /**
     * Determine if the browser is iPod or not (last updated 1.7)
     * @return boolean True if the browser is iPod otherwise false
     */
    if( stripos($agent,'iPod') !== false ) {
        $_SGLOBAL['browser']='iPod';
        return true;
    }
    /**
     * Determine if the browser is Android or not (last updated 1.7)
     * @return boolean True if the browser is Android otherwise false
     */
    if( stripos($agent,'Android') !== false ) {
        $_SGLOBAL['browser']='Android';
        return true;
    }
    $_SGLOBAL['browser']='';
    return false;
}
function getplayobj()
{
    $obj = '';
    $obj.="<script type=\"text/javascript\" src=\"http://static.ebanhui.com/exam/newjs/play.js\"></script>";
    return $obj;
}
