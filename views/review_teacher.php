<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link type="text/css" rel="stylesheet" href="http://static.ebanhui.com/jiazhang/css/jzxiang.css" />
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/common.js"></script>
<link type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/jquery-ui/css/default/jquery-ui-1.8.1.custom.css" rel="stylesheet" />	
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/jquery-ui/jquery-ui-1.8.1.custom.min.js"></script>

<script type="text/javascript">
<!--
	var searchText = "请输入搜索关键字";

	$(function(){
		initsearch("searchvalue",searchText);
		$(".showimg").parent().hover(function(){
			$(this).siblings().find("img").stop().animate({opacity:'0.3'},1000);
			$(this).addClass("hover");
		},function(){
			$(this).siblings().find("img").stop().animate({opacity:'1'},1000);
			$(this).removeClass("hover");
		});

		$("#searchbutton").click(function(){
			var search = $('#searchvalue').val();
			if($('#searchvalue').val()=='请输入搜索关键字'){
				search='';
			}
			var url = '/review/teacher.html?q='+encodeURIComponent(search);
			location.href=url;
		});
	});
//-->
</script>
<title>学生评论</title>
</head>

<body>

<div class="mainst">
<div class="ter_tit"> 当前位置 > 学生评论 </div>
<div class="lefrig" style="border:solid 1px #cdcdcd;background:#fff;float:left;">
<div class="workol">
	<div class="work_menu">
	<ul>
	<li>
	<a href="<?= geturl('review/student') ?>">
	<span>我的评论</span>
	</a>
	</li>
	<li class="workcurrent">
	<a href="<?= geturl('review/teacher') ?>">
	<span>老师回复</span>
	</a>
	</li>
	</ul>
	</div>
	<div class="diles">
		<?php
			$q= empty($q)?'':$q;
			if(!empty($q)){
				$stylestr = 'style="color:#000"';
			}else{
				$stylestr = "";
			}
		?>
		<input name="title" <?=$stylestr?> class="newsou" id="searchvalue" value="<?= $q?>" type="text" />
		<input type="button" class="soulico" value="" id="searchbutton">
	</div>
	<div class="huisou">
	&nbsp;我的评论<?php if($count>0){ ?>（<?= $count; ?>）<?php } ?>

	</div>
<ul>
<?php if(!empty($reviews)){ ?>
	<?php foreach($reviews as $review){ 
	//$rev = current($review['review']);
	?>
			<li class="ewping">
			<div class="ekewen">
			<?php $arr = explode('.',$review['cwurl']);
				$type = $arr[count($arr)-1]; 
				if($type != 'flv' && $review['ism3u8'] == 1)
					$type = 'flv';
				if($type == 'mp3')
					$type = 'flv';
			?>
			&nbsp;课件名称：<span style="font-weight:bold;"><?= $review['title']?></span> 主讲：<?= !empty($review['realname'])?$review['realname']:$review['nickname'] ?> <span style="float:right; margin-right: 10px;_margin-top:-25px;"><?= date('Y-m-d H:i:s',$review['dateline'])?></span>
			</div>
			<div class="grades">
			总体评分:
			<?= str_repeat('<img src="http://static.ebanhui.com/ebh/tpl/default/images/icon_star_2.gif"/>', $review['score']) ?>
			<?= str_repeat('<img src="http://static.ebanhui.com/ebh/tpl/default/images/icon_star_1.gif"/>', 5 - intval($review['score'])) ?>
			</div>
			<p class="dfoeew"><?php if($review['shield']==1){ ?><span style="color:red;">(该评论已被系统屏蔽)</span><?php }else{ ?><?= $review['subject'] ?><?php } ?></p>
			<?php if(!empty($review['replysubject'])){ ?>
				<div class="restore">
					<div class="restore_arrow">◆</div>
					<div class="restore_cont">
					<h1>老师回复：</h1>
					<?= $review['replysubject'] ?>
					</div>
				</div>
			<?php } ?>
			</li>
	<?php } ?>
<?php }else{ ?>
	<div style="margin-left:20px;">暂无回复</div>
    <?//=nocontent()?>
<?php } ?>
<?= $pagestr ?>
</ul>
</div>
</div>
</div>
<div class="clear"></div>
