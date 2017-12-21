<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link type="text/css" rel="stylesheet" href="http://static.ebanhui.com/jiazhang/css/jzxiang.css" />
<title>学习记录</title>
</head>

<body>
<div class="mainst">
<div class="keteds">

<?php $i = 1;$log=null;?>
<?php foreach($playlogs as $k=>$logs){ ?>
<table id="tbother" class="datatab" width="100%">
	
		<thead class="tabhead">

		<tr>
		
	<?php if(empty($log)||($log['folderid']!=$logs['folderid'])) { ?>
		<div class="ewrifd">
		<span style="font-size:14px;color:#18a8f7"><?= $logs['foldername'] ?></span>
		</div>
		<?php $log = $logs; ?>
	<?php } ?>
		</tr>

		</thead>
<tbody>

<tr>
<td>
<div class="etrdim">
<?php 
if($logs['sex'] == 1) {
	$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/t_woman.jpg';
} else {
	$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/t_man.jpg';
}
$face = empty($logs['face']) ? $defaulturl : $logs['face'];
$face = getthumb($face,'50_50');
?>
<img src="<?= $face ?>">
</div>
<div class="ewaitdr">
<h2 style="font-size:14px;font-weight:bold;">
<span style="color:#666;text-decoration:none"><?= $logs['title'] ?></span>
</h2>
<p class="gedfge">
<?=$logs['realname']?> 于：<?=Date('Y-m-d H:i',$logs['dateline'])?> 发布 <?=!empty($logs['viewnum'])?'| 人气:'.$logs['viewnum']:''?> <?=!empty($logs['reviewnum'])?'| 评论:'.$logs['reviewnum']:''?>
</p>
<p class="gedfge"><?= shortstr($logs['summary'],120) ?></p>
<p class="gedfge" style="color:red;">
课件时长：<?= $this->getltimestr($logs['ctime'])?>　持续时间：<?= $this->getltimestr($logs['ltime'])?>　首次时间：<?= date('Y-m-d H:i:s',$logs['startdate']) ?>　末次时间：<?= date('Y-m-d H:i:s',$logs['lastdate']) ?> 
</p>
</div>
</td>
</tr>
</tbody>
</table>
<?php } ?>
</div>
</div>

</div>
<div style=" padding-right: 450px;">
<?= $pagestr ?>
</div>
<div class="clear"></div>