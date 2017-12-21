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
<div class="lefrig" style="border:solid 1px #cdcdcd;background:#fff;float:left;">
	<div class="kejian">
	<ul class="liss">

	<?php 
	if(!empty($folders)){
	foreach($folders as $folder){?>
	<li class="danke">
	<div style="border: 1px solid #e2e2e2;height: 182px;width: 114px;">
	<a href="<?=geturl('progress/'.$folder['folderid'])?>">
	<img width="114" height="159" border="0" src="<?=empty($folder['img'])?'http://static.ebanhui.com/ebh/images/nopic.jpg':$folder['img']?>" style="opacity: 1;">
	</a>
	</div>
	<a href="<?=geturl('progress/'.$folder['folderid'])?>" class="progressTaga">
	<div class="piaoyin">
	<span style="position:absolute;width:100px;top:138px;left:5px"><?=empty($folder['percent'])?0:$folder['percent']?>%</span>
	<span class="ertie" style="width:<?=empty($folder['percent'])?0:$folder['percent']?>%;color:<?=empty($folder['percent'])?'#000':'#fff'?>;"></span>
	</div></a>
	<span class="spne">
	<a href="<?=geturl('progress/'.$folder['folderid'])?>"><?=$folder['foldername']?>(<?=$folder['coursewarenum']?>)</a>
	</span>
	</li>
	<?php }}?>
	</ul>
	</div>
<div class="clear"></div>
	<?=$pagestr?>
</div>
</div>
<div class="clear"></div>
