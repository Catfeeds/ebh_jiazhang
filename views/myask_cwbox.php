<?php $this->display('common/page_header'); ?>

<div class="lefrig">

<script type="text/javascriptJavaScript">

document.onkeydown=function(event) 
{ 
	e = event ? event :(window.event ? window.event : null); 
	if(e.keyCode==13){ 
		$("#room_search_btn").click();
		e.returnValue = false;
	} 
}
</SCRIPT>

<script type="text/javascript">
var searchtext = "请输入您要搜索的课件名称";
$(function() {
   initsearch("title",searchtext);
		$("#room_search_btn").click(function(){
			var search = $('#title').val();
			if($('#title').val()=='请输入您要搜索的课件名称'){
				search='';
			}
			var url = "<?= geturl('troom/linkcourse/'.$folder['folderid'].'-0-0-0-'.$from)?>?q="+search;
			location.href=url;
		});
	});
</script>
<style type="text/css">
/*.cqliebiao {
	width: 786px;
	margin-top:15px;
	border: 1px solid #cdcdcd;
	background:#fff;
}*/
body{
	background-color: #fff;
}
.liess{
	clear:both;
}
.cqliebiao *:after{display:block;clear:both;content:"";visibility:hidden;height:0;}  
.cqliebiao .cqlite {
	text-align: center;
	font-weight: bold;
	font-size: 12px;
	height: 36px;
	line-height: 36px;
	border-bottom:solid 1px #cdcdcd;
	width:630px;
	font-size:14px;
}
.cqliebiao .cqmain {
	margin-left: 12px;
	padding-left:10px;
	width: 600px;
}
.cqliebiao .cqmain .lanbiaot {
	font-size: 14px;
	color: #0033ff;
	font-weight: bold;
	margin-top: 12px;
	margin-bottom: 12px;
}
.cqliebiao .cqmain ul {
	width: 600px;
	float: left;
	padding-bottom:10px;
}
.cqliebiao .cqmain liess {
	width: 680px;
	overflow: hidden;
	white-space: nowrap;
	line-height: 22px;
	height: 22px;
	display: block;
}


.sa:hover {
	color: #ff5500;
	text-decoration: none;
	padding-left: 5px;
	width: 500px;
	white-space: nowrap;
	overflow: hidden;
	line-height: 25px;
	height: 25px;
	background-color: #dfe98f;
	display: block;
}
.sa:visited{
		text-decoration: none;
	padding-left: 5px;
	white-space: nowrap;
	overflow: hidden;
	width: 500px;
	line-height: 25px;
	height: 25px;
	display: block;
	float: left;
	color:#721c73;
}
.sa {
	text-decoration: none;
	padding-left: 5px;
	white-space: nowrap;
	overflow: hidden;
	width: 500px;
	line-height: 25px;
	height: 25px;
	display: block;
	float: left;
	color:#333;
}
.yema {
	position: relative;
	float: left;
	line-height: 25px;
	height: 25px;
	margin-left: 5px;
}
.zuoyeico {
	background: url("http://static.ebanhui.com/ebh/tpl/default/images/exam_ico.jpg") no-repeat;
	height: 16px;
	width: 16px;
}
.fujianico {
	background: url("http://static.ebanhui.com/ebh/tpl/default/images/attachmen_ico.jpg") no-repeat;
	height: 16px;
	width: 16px;
}
.onlineico {
	background: url("http://static.ebanhui.com/ebh/tpl/default/images/online_ico.jpg") no-repeat;
	height: 16px;
	width: 16px;
}
.liess i {
	display: inline;
    float: right;
    margin: 5px 0 0 0;
}
.kejian {
	/*width: 748px;*/
	width: 600px;
	float:left;
	/*border: 1px solid #dcdcdc;*/
}
.kejian .showimg {
	margin-top: 6px;
	margin-left: 8px;
}
.kejian liss {
	width: 748px;
}
.kejian .liss .danke {
	width: 145px;
	float: left;
	margin-left:11px;
	display:inline;
	margin-top: 8px;
	height: 218px;
}
.kejian .liss .danke .spne {
	text-align: center;
	width: 140px;
	height: 36px;
	overflow: hidden;
	word-wrap: break-word;
	display: block;
	color: #0033ff;
	float:left;
}
.kejian .liss .danke .sds {
	height: 184px;
	width: 145px;
	border: 1px solid #cdcdcd;
	background-image: url(http://static.ebanhui.com/ebh/tpl/2012/images/dise.jpg);
	background-repeat: no-repeat;
	background-position: center center;
	margin-bottom: 8px;
}

.showimg { float:left;}
.showimg img {border:1px solid #CDCDCD; padding:4px; position:relative; left:-4px; top:-5px;}
.hover .showimg img { border:1px solid ;}
.showimg .hover{border: 1px solid;}


.noke {
	height: 480px;
	width: 744px;
	float: left;
	border: 1px solid #cdcdcd;
}
.noke p {
	background: url(http://static.ebanhui.com/ebh/tpl/2012/images/nokejianico.jpg) no-repeat;
	height: 120px;
	margin-top: 90px;
	margin-left: 170px;
	padding-left: 140px;
	font-size: 16px;
	padding-top: 30px;
    width: 307px;
}
.noke span {
	color: #e94f29;
}
.fujianweek {
	background: url("http://static.ebanhui.com/ebh/tpl/2014/images/new.png") no-repeat;
	height: 16px;
	width: 16px;
}

</style>
<?php if(!empty($subfolderlist)) { ?>
<div class="kejian">
	<ul class="liss">
        <?php foreach($subfolderlist as $subfolder){ ?>
	<li class="danke" style="list-style: none;">
	<div class="showimg"><a href="<?=geturl('troom/linkcourse/'.$subfolder['folderid'].'-0-0-0-'.$from)?>" title="<?=$subfolder['foldername']?>"><img src="<?= empty($subfolder['img']) ? 'http://static.ebanhui.com/ebh/images/nopic.jpg' : $subfolder['img'] ?>" width="114" height="159" border="0" /></a></div>
	<span class="spne"><a href="<?= geturl('troom/linkcourse/'.$subfolder['folderid'].'-0-0-0-'.$from) ?>" style="text-decoration: none;" title="<?= $subfolder['foldername'] ?>"><?= ssubstrch($subfolder['foldername'],0,20) ?>(<?= $subfolder['coursewarenum'] ?>)</a></span>
	</li>
        <?php } ?>

	</ul>
	</div>
<?php }?>
<?php if(empty($subfolderlist)){?>
<div class="cqliebiao">

<div class="cqlite">
<span><?= $folder['foldername'] ?> (目录)</span>
	
</div>

<div class="cqmain">
<?php if(!empty($sectionlist)) { ?>
<?php $i = 1; ?>
<?php foreach($sectionlist as $section) { ?>
		<h2 class="lanbiaot"><?= $section[0]['sname']?></h2>
		<ul>
	<?php foreach($section as $course) { 
	$color = $course['examnum'] > 0 ? 'style="color:red;"' : '';
	?>
	<li class="liess">
	<span style="float:left;width:50px;">
		<?php if ($course['examnum']>0 && $roominfo['isschool']==2) { ?>
			<i class="zuoyeico" title="此课件包含作业"></i>
		<?php } else { ?>
			<i></i>
		<?php } ?>

		<?php if($course['attachmentnum'] > 0 ) { ?>
			<i class="fujianico" title="此课件包含附件"></i>
		<?php } else { ?>
			<i></i>
		<?php } ?>
		<?php if($course['dateline']>strtotime("-7 days")){ ?>
			<i class="fujianweek" title="此课件为一周内新传课件" ></i>
		<?php } else { ?>
			<i></i>
		<?php } ?>
	</span>
	<?php $arr = explode('.',$course['cwurl']);
		$type = $arr[count($arr)-1]; ?>
	<a class="sa" href="javascript:void(0)" onclick="selcw(<?=$course['cwid']?>,$(this).find('span').html())" <?= $color ?>><span><?= $course['title'] ?></span><span>…………………………………………………………………………………………………………</span></a><em class="yema" <?= $color ?>><?= $i++ ?></em></li>
	<?php } ?>


	</ul>
	<?php } ?>
</div>

</div>
	<?php } else { ?>
	  	<?php if(empty($onlinelist)) {?>
		  	 <div style="padding-top:10px;font-size:14px;text-align:center;">此课程下您还没有课件！</div>
		<?php }?>
	  <?php } ?>
</div>
<?php }?>
<?= $pagestr ?>
<script>
	
	function selcw(cwid,title){
		parent.selectcw(cwid,title);
	}
</script>
<?php $this->display('myroom/page_footer'); ?>