<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link type="text/css" rel="stylesheet" href="http://static.ebanhui.com/jiazhang/css/jzxiang.css" />
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/common.js"></script>

<title>学习进度</title>
</head>

<body>

<div class="mainst">
<div class="ter_tit"> 当前位置 > 学习进度 </div>
<div class="lefrig" style="background:#fff;border:solid 1px #cdcdcd;">
<div class="annuato" style="line-height:28px;padding-left:20px;position: relative;border-bottom:dashed 1px #e2e2e2;"><a href="javascript:history.go(-1)" class="fabtns">返 回</a></div>
<div class="rertkss">
<span class="waispan">
<span class="wekrr" style="color:#3d3d3d;"><?=$folder['foldername']?> 总进度：</span>
</span>
<div class="keutsu">
<span class="dengbg" style="width:<?=$percentavg?>%;"></span>
</div>
<span style="float:left;height:23px;line-height:23px;margin-left:10px;font-size:14px;"><?=$percentavg?>%</span>
</div>

<?php 
if(!empty($coursewarelist)){
foreach($sectionlist as $section){
if(count($section)>1){
?>

<h2 style="font-weight:bold;margin-top:20px;margin-left:20px;color:#2696F0"><?=$section['name']?></h2>
<?php }?>
<ul>
<?php 
foreach($section as $k=>$cw){
	if(is_array($cw)){
$arr = explode('.',$cw['cwurl']);
$type = $arr[count($arr)-1]; 
?>

<li class="rertk">
<span class="waispan">
<?=$cw['title']?></span>
<div class="keute">
<span class="lanbg" style="width:<?=$cw['percent']?>%;"></span>
</div>
<span style="float:left;height:23px;line-height:23px;margin-left:10px;font-size:14px;"><?=$cw['percent']?>%</span>
</li>
<?php }}?>
</ul><?php }?>
<?php }?>
</div>
</div>
</div>
</div>
<div class="clear"></div>
