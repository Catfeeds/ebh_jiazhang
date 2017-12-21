<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/base.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/listit.css?v=20151029" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/college/style.css"/>
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
<style>
.studyalert{
	background:white;position:absolute;display:none;border:1px solid;width:130px;text-align:center;z-index:100
}


.dtkywe {
    height: 35px;
    position: absolute;
    right: 14px;
    top: 4px;
    width: 160px;
}
.redbl {
    color: red;
    font-weight: bold;
}
.disbl {
	color:#666;
    font-weight: bold;
}
.kewate {
    background: #eee!important;
    border: 1px solid #dcdcdc;
    display: inline;
    float: left;
    height: 24px;
    position: relative;
    width: 167px!important;
}
.titel {
	color:#777;
}
.kustgd {
	height:184px;
}
.wraps {
	height:184px;
}
.gdydht {
	height:184px;
	width: 167px;
	margin: 10px 0 0 9px;
	padding:10px;
	border:solid 1px #cdcdcd;
	display:inline;
}
</style>

</head>

<body>
<div class="lsitit" >
<div class="lefstr" style="padding-bottom:20px;background:white; width:998px;">
<?php 
$this->assign('selidx',0);
$this->assign('showmodeselection',true);
$itemid = $this->input->get('itemid');
?>
<div class="kstfrt" style="width:998px;">

<p class="stketi" style="margin-top:0;"></p>

</div>
<!--网格模式-->
<div class="gridmode">
<?php 
if(!empty($sectionlist)){
foreach($sectionlist as $k=>$section) {
	$keys = array_keys($section);
	$enabled = true;
	?>
	<div style="font-size:16px;font-weight:bold;padding:10px 6px;float:left;width:986px;padding-bottom:0px;margin-top:5px">
		<a href="javascript:void(0)" style="color:#666;text-decoration:none" onclick="showcws('1c<?=$k?>')"><?=$section[$keys[0]]['sname']?>(<?=count($sectionlist[$k])?>)</a>
	</div>
<div id="tb1c<?=$k?>">
<?php 

$mediatype = array('flv','mp4','avi','mp3','mpeg','mpg','rmvb','rm','mov');
$deflogo = 'http://static.ebanhui.com/ebh/tpl/2014/images/defaultcwimg.jpg';
	// var_dump($section);die();
	foreach($section as $cw){
		$arr = explode('.',$cw['cwurl']);
		$type = $arr[count($arr)-1];
		$logo = !empty($cw['logo'])?$cw['logo']:$deflogo;
		if($enabled && empty($cw['disabled']) || empty($folder['playmode']))
			$enabled = true;
		else
			$enabled = false;
	?>
		<div class="gdydht">
			<div style="overflow: hidden;position:relative;<?=!$enabled?'cursor:default':''?>" class="wraps" <?php if(!$enabled){?> onmouseover="$('#studyalert1c<?=$cw['cwid']?>').show()" onmouseout="$('#studyalert1c<?=$cw['cwid']?>').hide()"<?php }?>>
			<div id="studyalert1c<?=$cw['cwid']?>" class="studyalert">请按课件顺序学习</div>
			<?php if($enabled){
				$cwurl = 'javascript:void(0)';
				?>
				<a class="kustgd"  href="<?=$cwurl?>" title="<?=$cw['title']?>">
			<?php }else{?>
				<div class="kustgd">
			<?php }?>
				<?php if(!empty($cw['cwlength'])){?>
				<img src="http://static.ebanhui.com/ebh/tpl/2014/images/kustgd.png" />
				<span style="left: 0px; position: absolute; background: transparent url(&quot;http://static.ebanhui.com/ebh/tpl/2014/images/toumse.png&quot;) no-repeat scroll 0% 0%; width: 167px; height: 20px; line-height: 20px; top: 80px; text-align: center; color: rgb(255, 255, 255);"><?=$cw['cwlength']?></span>
				<?php }?>
			<?php if($enabled){?>
				</a>
			<?php }else{?>
				</div>
			<?php }?>
			
				<div class="fskpctd">
					<img src="<?=$logo?>"  class="imgst" cwid="<?=$cw['cwid']?>">
				</div>
				<div class="titel">
					<h2 style="color:<?=$enabled?'#666':'#ccc'?>;overflow:hidden;text-align:center;" class="lihett f-thide"><?=shortstr($cw['title'],18,'')?></h2>
				</div>
				<!-- ==== -->
				<div style="color:#777;">
					<p>首次 <?=$cw['firsttime']?></p>
					<p>已学 <span style="color:red;font-weight:bold;"><?=$cw['learnsumtime']?></span> 共计<span style="color:red;font-weight:bold;"><?=$cw['learncount']?></span>次</p>
					<!-- ===<p>时长 <?=$cw['cwlength']?></p>=== -->
				</div>
				<!-- ==== -->
				<!-- ===进度条逻辑开始=== -->
				<div style="margin-top:5px;border:none;height:16px;" class="kewate" >
					<span style="width:167px;background:none;z-index:2;height:16px;line-height:16px;"><?=$cw['percent']?>%</span>
					<span style="height:16px;z-index:1;width:<?=$cw['percent']?>%;"></span>
				</div>
			<!-- ===进度条逻辑结束=== -->
		
		</div>
	</div>
	
<?php 
if($folder['playmode'] == 1 && ($cw['percent'] != 100 || !empty($cw['disabled'])))
	$enabled = false;
}?>
</div>
<?php 
}}else{?>
<div style="width:998px;text-align:center">
<img src="http://static.ebanhui.com/ebh/tpl/2014/images/zanwujilu.png"/>
</div>
<?php }?>
</div>
<!--结束-->
</div>


</div>
</body>
<script>
$(function(){
	
	var showmode = getcookie('ebh_cwsmode');
	if(showmode!=''){
		$('.to'+showmode).click();
	}
	top.$('#mainFrame').width(1000);
	top.$('.rigksts').hide();
});

function showcws(tbid){
	if($('#tb'+tbid).css('display')=='none')
		$('#tb'+tbid).show();
	else
		$('#tb'+tbid).hide();
	top.resetmain();
}

var searchtext = "请输入搜索关键字";
$(function(){
	initsearch("title",searchtext);
});
$("#ser").click(function(){
		var title = $("#title").val();
		if(title == searchtext) 
			title = "";
		var url = '<?= geturl('study/cwlist/'.$folder['folderid']) ?>' + '?q='+title;
		url += '&itemid=<?=!empty($itemid)?$itemid:''?>';
		document.location.href = url;
	});
function setCookie(name, value) {
    var exdate = new Date();
	exdate.setTime(exdate.getTime() + (arguments.length>2?arguments[2]:7)*24*60*60*1000);   
    // exdate.setDate(exdate.getDate()+(arguments.length>2?arguments[2]:7));
    var cookie = name+"="+encodeURIComponent(value)+"; expires="+exdate.toGMTString();
    cookie += ((arguments.length>3?("; path="+arguments[3]):"") + (arguments.length>4?("; domain="+arguments[4]):""));
    document.cookie = cookie;
}

function getcookie(name){   
    var arr = document.cookie.match(new RegExp("(^| )"+name+"=([^;]*)(;|$)"));    
    if(arr != null){   
        return unescape(arr[2]);   
    }else{   
        return "";   
    }   
}

function initsearch(id,value) {
   if($("#"+id).val() == "") {
       $("#"+id).val(value);
       $("#"+id).css("color","#A5A5A5");
   }
   if($("#"+id).val() == value) {
       $("#"+id).css("color","#A5A5A5");
   }
   $("#"+id).click(function(){
       if($("#"+id).val() == value) {
           $("#"+id).val("");
           $("#"+id).css("color","#323232");
       }
   });
   $("#"+id).blur(function(){
       if($("#"+id).val() == "") {
           $("#"+id).val(value);
           $("#"+id).css("color","#A5A5A5");
       }
   });
}
</script>
</html>
