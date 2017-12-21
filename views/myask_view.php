<?php 
$this->assign('notop',true);
$this->assign('subtitle',$ask['title']);
$this->display('common/page_header');
?>

<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/css/statch.css" />
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/dayi.css" rel="stylesheet" />
<link type="text/css" href="http://static.ebanhui.com/ebh/css/wavplayer.css" rel="stylesheet" />
<link type="text/css" href="http://static.ebanhui.com/ebh/css/upload.css" rel="stylesheet" />	
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/upload.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/ask.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/course2.js"></script>

<script type="text/javascript">
$(function() {
	try{
		$('.dengtu a').lightBox();
	}catch(err){}
});
</script>
<style type="text/css">
.fenge {
	margin-top:0px;
}
.dengtu {
    border:none;
    height: 195px;
    margin: 10px 0;
    width: 277px;
}
.dengtu li {
    float: left;
    height: 195px;
    margin: 0 17px 40px 0;
    position: relative;
    width: 277px;
    z-index: 2;
}
.photo_photolist_inner {
    position: relative;
}
.photo_photolist_img {
    height: 195px;
    overflow: hidden;
    width: 277px;
}
.photo_photolist_img a {
    height: 195px;
    width: 277px;
}
fieldset, img, a img, iframe {
    border-style: none;
    border-width: 0;
}
.bofang {
	background:url(http://static.ebanhui.com/ebh/tpl/2012/images/download.png) no-repeat scroll ;
	color: #FFFFFF;
    float: left;
    height: 23px;
    line-height: 23px;
    text-align: center;
    width: 105px;
}
em{
	font-style: italic;
	
}
.huide strong em{
	font-weight: bold;
}
.huide em strong{
	font-style: italic;
}
strong{
	font-weight: bold;
}
.sixists .rentuwai {
 background: none; 
}
.rewardbtn{
	background: #F76363;
	width: 105px;
	height: 37px;
	line-height: 37px;
	float: right;
	margin-right: 10px;
	display: block;
	text-align: center;
	color: #fff;
	text-decoration: none;
	font-size: 14px;
	cursor: pointer;
}
.playbtn{
	float:left;
}
a.rewardbtn:hover{
	background: #E73F3F;
	color: #fff;
	text-decoration: none;
}
a.rewardbtn:visited{
	color: #fff;
}
.rewardinfo{
	font-size:26px;
	
	text-align:center;
}
.infospan{
	float:left;
	margin-left:20px;
}
.whoans{
	float:left;
	height:14px;
	width:90px;
	line-height:14px;
	font-size:14px;
	
}
.numinput{
	float:left;
	width:70px;
	height:28px;
	line-height:28px;
	font-size:24px;
	border: 1px solid #72C2F4;
	text-indent:10px;
	background:white;
	margin-top:5px;
}
.upbtn{
	height:14px;
	width:14px;
	border:none;
	background:url(http://static.ebanhui.com/ebh/tpl/2014/images/up.png);
	float:left;
	margin-bottom:2px;
}
.downbtn{
	height:14px;
	width:14px;
	border:none;
	background:url(http://static.ebanhui.com/ebh/tpl/2014/images/down.png);
	float:left;
}
.answererface{
	background: url(http://static.ebanhui.com/ebh/tpl/default/images/rentubg0507.jpg) no-repeat;
	width: 60px;
	height: 60px;
	float: left;
	padding: 4px;
	margin-top: -7px;
margin-left: -6px
}
.aface{
	float:left;
	width:50px;
	height:50px;
	border:solid 1px #dcdcdc;
}
.surebtn {
	float: left;
	background: #18a8f7;
	width: 190px;
	height: 32px;
	display: inline;
	float: left;
	line-height: 32px;
	text-align: center;
	margin-left: 175px;
	color: #fff;
	font-size: 14px;
	text-decoration: none;
	cursor: pointer;
	border: none;
}
.initreward{
	background: #18a8f7;
	width: 58px;
	height: 22px;
	line-height: 22px;
	display: inline-block;
	color: #fff;
	text-decoration: none;
	font-size: 12px;
	cursor: pointer;
	margin-top:8px;
}
.rewarddes{

	float:left;
	margin-left:30px;
	width:500px;
	color:#666;
}
.updown{
	width:14px;
	float:left;
	margin-left:10px;
	margin-top:5px;
}
.disa{
	cursor:default;
	background:grey;
}
.sixists .xianda {
	width:978px;
}
.playbtn{
  background: #18a8f7;
  padding: 6px;
  border: 1px solid #eee;
  -moz-border-radius: 4px;
  -webkit-border-radius: 4px;
  border-radius: 4px;
  color: #fff;
}
.sixists .twoxiang{
	margin-left: 0;
}
.sixists .twoxiang .huirenw{
	background: none;
	padding: 0;
	margin: 0;
}
.quanwen a.xiugaibtn{
	margin-left: 5px;
}
.terks{
	padding-left: 11px;
}
</style>
<div class="lefrig" style="width:998px;">
<div style="height:16px;">
<div id="playercontainer"></div>
</div>

<div style="float:left">
<div class="wenkuang" style="width:998px;">

<div class="quanwen">
<?php 
$defaulturl = $ask['sex'] == 1 ? ($ask['groupid']==5 ? 't_woman.jpg' : 'm_woman.jpg') : ($ask['groupid']==5 ? 't_man.jpg' : 'm_man.jpg');
$defaulturl = 'http://static.ebanhui.com/ebh/tpl/default/images/'.$defaulturl;
$face =  empty($ask['face']) ? $defaulturl:$ask['face'];
$face = getthumb($face,'50_50');
?>
<div class="xiangs" style="margin:0;float:left;width:948px">
<a href="http://sns.ebh.net/<?=$ask['uid']?>/main.html" target="_blank"><img title="<?= empty($ask['realname'])?$ask['username']:$ask['realname'] ?>的个人空间" src="<?= $face ?>" style="width:50px;height:50px;float:left;"/></a>
<span class="wentit" style="float:left;width:880px;"><?= $ask['title'] ?></span>
<span style="float:left;"></span>
<?php
$cwnamestr = '';
if(!empty($ask['cwname']))
	$cwnamestr = shortstr(' -> '.$ask['cwname'],40);

?>
<?php if(!empty($ask['reward'])){?>
	<span style="color:red;font-weight:bold;float:left;margin-left:10px" title="此题悬赏<?=$ask['reward']?>积分">
	悬赏<?=$ask['reward']?>
	<img src="http://static.ebanhui.com/ebh/tpl/2014/images/rewardcoin.png"/>
	</span><span class="fenge">|</span>
<?php }?>
<span class="renwusou"><?= empty($ask['realname']) ? $ask['username'] : $ask['realname'] ?></span>
<?php if($ask['uid'] != $user['uid']){?>
<a class="hrelh" href="javascript:;" tid="<?=$ask['uid']?>" tname="<?= empty($ask['realname'])?$ask['username']:$ask['realname'] ?>" title="给<?=$ask['sex'] == 1 ? '她' : '他'?>发私信"></a>
<?php }?>
<span class="fenge">|</span><span>所属学科：</span><span><?= $ask['foldername'].$cwnamestr ?></span>
<div style="float:left;margin-top:6px;width:880px;padding-left:60px">
<span>人气：</span><span><?= $ask['viewnum'] ?></span><span class="fenge">|</span><span><?= date('Y-m-d H:i:s',$ask['dateline']) ?></span></div></div>
<div class="wenwen" style="width:950px"><?= $ask['message'] ?>&nbsp;</div>

<?php if(!empty($ask['audiosrc'])) { ?>
<div class="waibo" id="waibo_q_<?= $ask['qid'] ?>" status="0" style="float:left;width:950px">
<a id="start_q_<?= $ask['qid'] ?>" class="akaishi start" href="javascript:start('<?= $ask['audiosrc'] ?>','q_<?= $ask['qid'] ?>')"></a>
<a id="pause_q_<?= $ask['qid'] ?>" class="azanting" href="javascript:pause('q_<?= $ask['qid'] ?>')"></a>
<a id="stop_q_<?= $ask['qid'] ?>" class="atingzhi" href="javascript:stop('q_<?= $ask['qid'] ?>')"></a>
<p class="pingtiao">
<span class="bartebg">
<span id="votebars_q_<?= $ask['qid'] ?>" class="votebars" style="width:0%;"></span>
</span>
</p>
</div>
<?php } ?>
<?php if(!empty($ask['imagesrc'])) { ?>
<div class="dengtu" style="float:left;width:950px">
	<ul>
		<li style="width:auto;height:auto;">
			<div class="bg photo_photolist_inner">
			<p class="photo_photolist_img" style="width:auto;height:auto;">
			<a style="display:block;height: 100%;overflow: hidden;" href="<?= $ask['imagesrc'] ?>">
			<img id="img1" src="<?= getthumb($ask['imagesrc'],'277_195')?>"  style="margin-top: 0px; margin-left: 0px;"/>
			</a>
			</p>
			</div>
		</li>
	</ul>
</div>
<?php } ?>

<div class="gaokuz" >
<span class="kanwenti">
    <?php if(empty($ask['aid'])) { ?>
    <a href="javascript:void(0)">关注问题</a>
    <?php } else { ?>
    <a href="javascript:void(0)">取消关注</a>
    <?php } ?>

</span>

    <span class="fenge" style="margin-top:5px;">|</span>
    <span class="terks"><a href="javascript:void(0)">感谢(<span id="qtknum"><?= $ask['thankcount'] ?></span>)</a>
        </span>
    
</div>

<?php
$rewardarray = array();
if (!empty($rewardlist)){
	echo '<div style="width:950px;clear:both;font-size:14px;color:#747474;"><span style="color:red">悬赏得分：</span>';
	foreach ($rewardlist as $value) {
		$rewardstr = empty($value['realname']) ? $value['username'] : $value['realname'];
		$rewardstr .= ' ' . $value['credit'] . '积分';
		$rewardarray[] = $rewardstr;
	}
	echo implode('、', $rewardarray) . '。';
	echo '</div>';
}
?>
</div>
</div>
<div class="tithui">
<span class="heida">回答</span><span>默认排序</span>
</div>

<?php if(!empty($answers)){ ?>
	<div class="sixists" style="width:1000px;">
	<ul>

	<?php foreach ($answers as $f=>$answer) { 
	$defaulturl = $answer['sex'] == 1 ? ($answer['groupid']==5 ? 't_woman.jpg' : 'm_woman.jpg') : ($answer['groupid']==5 ? 't_man.jpg' : 'm_man.jpg');
	$defaulturl = 'http://static.ebanhui.com/ebh/tpl/default/images/'.$defaulturl;
	$face = empty($answer['face']) ? $defaulturl : $answer['face'];
	$face = getthumb($face,'50_50');
	?>

	<?php if($answer['isbest'] == 1) { ?>
	<li class="xianda" id="detail_<?= $answer['aid'] ?>" <?php if($f == ($ask['answercount']-1)) echo 'style="border-bottom:1px solid #cdcdcd;"';?>>
	<img style="position: absolute;bottom:0px;right:0px;width:168px;height:168px;" src="http://static.ebanhui.com/ebh/tpl/default/images/zuijiaico0507.png" />
	<?php } else { ?>
	<li class="xianda" id="detail_<?= $answer['aid'] ?>" <?php if($f == ($ask['answercount']-1)) echo 'style="border-bottom:1px solid #cdcdcd;"';?>>
	<?php } ?>

	<div class="rentuwai">
    	<a href="http://sns.ebh.net/<?=$answer['uid']?>/main.html" target="_blank"><img title="<?= empty($answer['realname'])?$answer['username']:$answer['realname'] ?>的个人空间" src="<?= $face ?>" style="width:50px;height:50px;border:none;"/></a>
	</div>
	<div class="twoxiang">
		<span class="huirenw" <?= $answer['groupid']==5?'style="color:red"':''?>><?= empty($answer['realname']) ? $answer['username'] : $answer['realname'] ?><?= $answer['groupid']==5?'<span style="color:red">(老师)</span>':''?></span>
	<?php if($answer['uid'] != $user['uid']){?>
        <a class="hrelh" href="javascript:;" tid="<?=$answer['uid']?>" tname="<?= empty($answer['realname'])?$answer['username']:$answer['realname'] ?>" title="给<?=$answer['sex'] == 1 ? '她' : '他'?>发私信"></a>
    <?php }?>
    	<span class="huirenw">&nbsp;&nbsp;<?=timetostr($answer['dateline'])?></span>
	</div>
	<?php $floorarr =array('沙发','藤椅','板凳','报纸','地板')?>
	<?php if($f<5)
		$floor = $floorarr[$f];
		else 
		$floor = ($f+1).'楼';
	?>
	<div class="rietitsize" style=" position: relative;">
	<span class="terks" title="感谢"><a title="感谢" href="javascript:javascript:void(0)">(<span><?= $answer['thankcount'] ?></span>)</a></span>
	</div>
	<div class="huide" style="width:850px;">
		<?= $answer['message'] ?>
		<br/>
	</div>

	<?php if(!empty($answer['audiosrc'])) { ?>
	<div class="waibo" id="waibo_q_<?= $answer['aid'] ?>" status="0" style="float:left;">
	<a id="start_q_<?= $answer['aid'] ?>" class="akaishi start" href="javascript:start('<?= $answer['audiosrc'] ?>','q_<?= $answer['aid'] ?>')"></a>
	<a id="pause_q_<?= $answer['aid'] ?>" class="azanting" href="javascript:pause('q_<?= $answer['aid'] ?>')"></a>
	<a id="stop_q_<?= $answer['aid'] ?>" class="atingzhi" href="javascript:stop('q_<?= $answer['aid'] ?>')"></a>
	<p class="pingtiao">
	<span class="bartebg">
	<span id="votebars_q_<?= $answer['aid'] ?>" class="votebars" style="width:0%;"></span>
	</span>
	</p>
	</div><span class="sizeyin" style="margin-top:12px;">点击播放按钮听听他的讲解</span>
	<?php } ?>

	<?php if(!empty($answer['imagesrc'])) { ?>
	<div style="width: 720px;min-height:50px;_height:50px;float:left">
	<div class="dengtu" style="float: left;">
		<ul>
			<li style="width:auto;height:auto;padding:2px">
				<div class="bg photo_photolist_inner">
				<p class="photo_photolist_img" style="width:auto;height:auto;">
				<a style="display:block;width: 100%;height: 100%;overflow: hidden;" href="<?= $answer['imagesrc'] ?>">
				<img id="img1" src="<?= getthumb($answer['imagesrc'],'277_195') ?>"  style="margin-top: 0px; margin-left: 0px;"/>
				</a>
				</p>
				</div>
			</li>
		</ul>
		
	</div>
	<span class="sizeyin" style="margin-top:190px;">单击图片查看清晰大图</span>
	</div>
	<?php } ?>

	<?php if(!empty($answer['cwid']) && !empty($answer['cwsource'])) { ?>
	<div class="bowaid">
		<button class="playbtn" onclick='showplayDialog("<?=$answer['cwsource']?>",<?=$answer['cwid']?>)'>查看附件</button>
	</div>
	<?php } ?>


	<?php if($ask['status'] != 1 && $ask['uid'] == $user['uid']) { ?>
	<a href="javascript:void(0)" class="zuijiabtn">最佳答案</a>
	<?php } ?>

	</li>
	<?php } ?>

	</ul>
	</div>
<?= $pagestr ?>
<?php } ?>
</div>
</div>


<div id="rewarddiv" style="display:none;">
<form id="rewardform">
	<input type="hidden" name="qid" value="<?=$ask['qid']?>"/>
	<div id="revalidate" style="background:#fff;height:450px;width:550px;overflow-y:auto">
	
	<div class="rewardinfo">
	<span class="infospan">总悬赏积分：<span><?=$ask['reward']?></span></span>
	<span class="infospan">未分配积分：<span style="color:red" id="unassign"><?=$ask['reward']?></span></span>
	<span class="initreward infospan">初始化</span>
	</div>
	<span class="rewarddes">* 积分可以分配给多人,积分和不超过总悬赏积分</span>
	<?php 
	if(!empty($answerers)){
	foreach($answerers as $k=>$answerer){
		$defaulturl = $answerer['sex'] == 1 ? ($answerer['groupid']==5 ? 't_woman.jpg' : 'm_woman.jpg') : ($answerer['groupid']==5 ? 't_man.jpg' : 'm_man.jpg');
		$defaulturl = 'http://static.ebanhui.com/ebh/tpl/default/images/'.$defaulturl;
		$face =  empty($answerer['face']) ? $defaulturl:$answerer['face'];
		$face = getthumb($face,'50_50');
	?>
	
	<div style="float:left;width:250px;margin-left:10px;margin-top:15px">
		<div style="float:left;width:80px;margin-left:25px">
			<div class="answererface">
				<img class="aface" src="<?=$face?>" />
			</div>
		</div>
		
		<div style="float:left;width:105px">
			<span class="whoans" ><?=!empty($answerer['realname'])?$answerer['realname']:$answerer['username']?></span>
			
			<input type="text" value="0" name="rewards[]" class="numinput" id="numinput<?=$k?>" maxlength="3"/>
			<div class="updown">
				<input type="button" class="upbtn" id="up<?=$k?>"/>
				<input type="button" class="downbtn" id="down<?=$k?>"/>
			</div>
			<input type="hidden" name="aids[]" value="<?=$answerer['aid']?>"/>
			
		</div>
		
		
	</div>
	<?php }?>
		
	<?php }?>
	</div>
</form>
<div style="float:left;width:550px;text-align:center;background:#C7EBFF">
			<input type="button" class="surebtn" value="确定"/>
		</div>
</div>
<script type="text/javascript">



//接受flash返回的audiosrc
function getURL(url){
	//alert(url);
	var audioname = url.substring(url.lastIndexOf('/')+1);
	$("#audio").attr("value",url);
	$("#showrecorder").hide();
	$("#audio_float").hide();
	
	$("#audio_name").html(audioname);
	$("#audio_show").show();
}
//删除录制上传的音频
function deleteaudio(){

}

$("#startrecord").click(function(){
	  $('#showrecorder').toggle();
	  $(".recoderSwf").remove();
	  $("#showrecorder").html('<object width="500" height="200" class="recoderSwf" data="http://static.ebanhui.com/ebh/flash/recoderSwf.swf" type="application/x-shockwave-flash" ><param value="transparent" name="wmode"><param value="http://static.ebanhui.com/ebh/flash/recoderSwf.swf" name="movie" id="recoder_url"><param value="high" name="quality"><param value="false" name="menu"><param value="always" name="allowScriptAccess"></object>');
 });

function settips(id,tips) {
	if($.trim($("#"+id).val()) == "") {
		$("#"+id).val(tips);
		$("#"+id).addClass("titwentigray");
	}
	$("#"+id).click(function(){
		if($.trim($(this).val()) == tips) {
			$(this).val("");
			$(this).removeClass("titwentigray");
		}
	});
	$("#"+id).blur(function(){
		if($.trim($(this).val()) == "") {
			$(this).val(tips);
			$(this).addClass("titwentigray");
		}
	});
}

function setbest(qid,aid) {
	var tips = "设置最佳答案";
	var url = '<?= geturl('myroom/myask/setbest') ?>';
	$.ajax({
		url:url,
		type:'post',
		data:{'qid':qid,'aid':aid},
		dataType:'text',
		success:function(data){
			if(data=='success'){
				$.showmessage({
					img		 :'success',
					message  :tips+'成功',
					title    :tips,
					callback :    function(){
						
						document.location.href = document.location.href;
					}
				});
				
			}else{
				$.showmessage({
					img		 :'error',
					message  :tips+'失败',
					title    :tips
				});
			}
		}
	});
}

function delask(qid,title) {
    var url = '<?= geturl('myroom/myask/delask') ?>';
    var successurl = '<?= geturl('myroom/myask/all') ?>';
	$.confirm("您确定要删除问题 【" + title + "】 吗？",function(){
		$.ajax({
			url:url,
			type:'post',
			data:{'qid':qid},
			dataType:'text',
			success:function(data){
				if(data=='success'){
					$.showmessage({message:'问题删除成功！'});
					document.location.href = successurl;
				}else{
					$.showmessage({message:'对不起，问题删除失败，请稍后再试！'});
				}
			}
		});
	});
}

//删除答案
function delanswer(qid,aid) {
  
}

function reward(){
	
}
function enternum(){
	$('#unassign').html(1);
}
var curinput ;
function countall(target){
	var leftreward = <?=$ask['reward']?>;
	$.each($('.numinput'),function(k,v){
			if(target == v)
				curinput = $(this);
			else{
				var tr = parseInt($(this).val());
				if(tr<=leftreward){
					$(this).val(tr);
					leftreward -= tr;
				}else{
					$(this).val(leftreward);
					leftreward = 0;
				}
			}
			
		});
	return leftreward;
}
$('.numinput').keyup(function(e){
	
	var leftreward = countall(e.currentTarget);
	var cr = parseInt(curinput.val());
	cr = cr?cr:0;
	if(cr<=leftreward){
		curinput.val(cr);
		leftreward -= cr;
	}else{
		curinput.val(leftreward);
		leftreward = 0;
	}
	$('#unassign').html(leftreward);
	// var version = $.browser.version;
	// if(version=='7.0')
		// $('#revalidate').css('display','inline');
			
});
$('.numinput').keydown(function(e){
	if((e.keyCode>=48 && e.keyCode<=57) || (e.keyCode>=96 && e.keyCode<=105) || e.keyCode==8 || e.keyCode==46)
		;
	else
		e.preventDefault();
});

$('.initreward').click(function(){
	$.each($('.numinput'),function(k,v){
		$(this).val(0);
	});
	$('#unassign').html(<?=$ask['reward']?>);
});
$('.upbtn').click(function(){
	var id = $(this).attr('id');
	id = id.replace('up','');
	var num = parseInt($('#numinput'+id).val())+1;
	var leftreward = countall($('#numinput'+id)[0]);
	if(num<=leftreward){
		$('#numinput'+id).val(num);
		leftreward -= num;
	}else{
		leftreward = 0;
	}
	$('#unassign').html(leftreward);
});
$('.downbtn').click(function(){
	var id = $(this).attr('id');
	id = id.replace('down','');
	var num = parseInt($('#numinput'+id).val())-1;
	var leftreward = countall($('#numinput'+id)[0]);
	if(num>=0){
		$('#numinput'+id).val(num);
		leftreward -= num;
	}else{
		// leftreward = <?=$ask['reward']?>;
	}
	$('#unassign').html(leftreward);
});
$('.surebtn').click(function(){
	if($('#unassign').html()!=0)
	{
		alert('请分配完所有的积分再按确定。');
		return ;
	}
	$.ajax({
		type:'post',
		url:'/myroom/myask/reward.html',
		data:$('#rewardform').serialize(),
		success:function(data){
			var res = eval('('+data+')');
			if(res.status ==1){
				$.showmessage({
					img		 :'success',
					message  :res.msg,
					callback :function(){
						location.reload();
					}
				});
				
			}else{
				$.showmessage({
					img		 :'error',
					message  :res.msg
				});
			}
		}
	})
});

//播放课件或者下载附件
function showplayDialog(source,cwid){
	if(typeof courseObj == "undefined"){
		courseObj = new Course();
	}
	if(!source || !cwid){
		return false;
	}
	courseObj.userplay(source,cwid);return false;
}
</script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xDialog/xloader.auto.js?v=20150731"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/wavplayer.js"></script>
<?php $this->display('common/player'); ?>
