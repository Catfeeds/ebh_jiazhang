<?php
if (! defined ( 'IN_EBH' )) {
	exit ( 'Access Denied' );
}
?>
<!DOCTYPE HTML>
<html>
<head>
<meta content="width=1000, user-scalable=yes" name="viewport"/> 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>在线作业</title>
<?php $v=getv();?>


<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/exam/css/base.css<?=$v?>" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/exam/css/global.css<?=$v?>" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/exam/css/layout.css<?=$v?>" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/exam/css/jqtransform.css<?=$v?>" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/exam/css/drtu.css<?=$v?>" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/exam/css/jqtransform.css<?=$v?>" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/exam/css/zujuan.css<?=$v?>"/>
<link rel="stylesheet" href="http://static.ebanhui.com/js/dialog/css/dialog.css"<?=$v?>/>

<script src="http://static.ebanhui.com/exam/js/jquery/jquery-1.11.0.min.js<?=$v?>"></script>
<script src="http://static.ebanhui.com/exam/js/jquery/jquery-migrate-1.2.1.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/examv2/ljs/common.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/examv2/ljs/quebase.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/examv2/ljs/quefix.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/examv2/ljs2/sinchoiceque.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/examv2/ljs2/mulchoice.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/examv2/ljs2/truefalseque.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/examv2/ljs2/textque.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/examv2/ljs/textline.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/examv2/ljs2/fillque.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/examv2/ljs/audio.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/examv2/ljs/subjective.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/examv2/ljs/view.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/examv2/ljs/render.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/swfobject.js" ></script>
<script type="text/javascript" src="http://static.ebanhui.com/exam/newjs/wavplayer.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/exam/newjs/jquery.base64.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/examv2/ljs/wordque.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xDialog/xloader.auto.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/js/dialog/dialog-plus.js"<?=$v?>></script>
<script src="http://static.ebanhui.com/ebh/js/JSON.js<?=$v?>"></script>
<?=ckeditor()?>
<script type="text/javascript">
<?php
if(checkbrowser()){
	$isMobile = 'true';
}else{
	$isMobile = 'false';
}
?>
var isMobile = <?php echo $isMobile; ?>;
<?php global $_SGLOBAL;?>
var browser = '<?php echo $_SGLOBAL["browser"];?>';
var qnumber=1;//【超级全局变量】 题目总数  变量名不可变
var uid = <?php echo $user['uid'];?>;
var qid=1;///【超级全局变量 】题目ID号，    变量名不重复
emark = true;
var isSee = 1;
var isapp = <?php echo $isapp;?>;
var titleNum = 0;
var answerobj = new View();
hashWatcher = function() {
    var timer, last;
    return {
        register: function(fn, thisObj) {
            if(typeof fn !== 'function') return;
            timer = window.setInterval(function() {
                if(location.hash !== last) {
                    last = location.hash;
                    fn.call(thisObj || window, last);
                }
            }, 100);
        },
        stop: function() {
            timer && window.clearInterval(timer);
        },
        set: function(newHash) {
            last = newHash;
            location.hash = newHash;
        }
    };
}();
function classBtn(_this){
	var showType = answerobj.showType;
	if(showType != 0){
		var index = $(_this).html() - 1;
		var id = $(".que").eq(index).attr("qsval");
		var top = $(".right").eq(0).css("top");
		$(".que").hide();
		$(".right").hide();
		$(".partContainer").hide();
		$(".que").eq(index).show();
		$(".right[id=xpanel" + id + "]").show();     //答题卡
		$(".partContainer[qid=" + id + "]").show();  //文本行
		$(".right").css("top",top);
		titleNum = index;
		if($(".que").length == 1){
			return;
		}
		if(index == 0){
			$(".lastOne").addClass("dislast");
			$(".nextOne").removeClass("disnext");
		}else
		if(index == $(".que").length - 1){
			$(".nextOne").addClass("disnext");
			$(".lastOne").removeClass("dislast");
		}else{
			$(".nextOne").removeClass("disnext");
			$(".lastOne").removeClass("dislast");
		}
	}
	
}
function getPosition(e){
	if(e){
		var t=e.offsetTop;  
		var l=e.offsetLeft;  
		while(e=e.offsetParent){  
			t+=e.offsetTop;  
			l+=e.offsetLeft;  
			if(e.offsetParent == undefined || e.offsetParent.className == undefined || e.offsetParent.className=='container'  ){
				break;
			}
		}
		return {x:l, y:t}; 
	}
	return null;
}
$(function(){
	//上一题
	var lastTitle = function(){
		if($(".que").length == 1){
			return;
		}
		if(titleNum - 1 <= 0){
			titleNum = 0;
			$(".lastOne").addClass("dislast");
		}else{
			titleNum -= 1;
		}
		var id = $(".que").eq(titleNum).attr("qsval");
		var top = $(".right").eq(0).css("top");
		$(".nextOne").removeClass("disnext");
		$(".que").hide();
		$(".right").hide();
		$(".partContainer").hide();
		$(".que").eq(titleNum).show();
		$(".right").hide();
		$(".right[id=xpanel" + id + "]").show();     //答题卡
		$(".partContainer[qid=" + id + "]").show();  //文本行
		$(".right").css("top",top);
	}
	//下一题
	var nextTitle = function(){
		if($(".que").length == 1){
			return;
		}
		if(titleNum + 1 >= $(".que").length - 1){
			titleNum = $(".que").length - 1;
			$(".nextOne").addClass("disnext");
		}else{
			titleNum += 1;
		}
		var id = $(".que").eq(titleNum).attr("qsval");
		var top = $(".right").eq(0).css("top");
		$(".lastOne").removeClass("dislast");
		$(".que").hide();
		$(".right").hide();
		$(".partContainer").hide();
		$(".que").eq(titleNum).show();
		$(".right[id=xpanel" + id + "]").show();     //答题卡
		$(".partContainer[qid=" + id + "]").show();  //文本行
		$(".right").css("top",top);
	}
	answerobj.eid = <?=$eid?> ;
	answerobj.init({eid:<?=$eid?>},initFun);
	function initFun(){
		var showType = answerobj.showType;  //显示类型
		if(showType != 0){
			var id = $(".que").eq(0).attr("qsval");
			$(".que").hide();
			$(".right").hide();
			$(".partContainer").hide();
			$(".que").eq(0).show();
			$(".right[id=xpanel" + id + "]").show();     //答题卡
			$(".partContainer[qid=" + id + "]").show();  //文本行
			$(".select_topic").show();
			if($(".que").length == 1){
				$(".nextOne").addClass("disnext");
			}
			$(".que").css("border",'0!important');
		}
	}
	//上/下一题
	$(".lastOne").on("click",function(){
		lastTitle();
	});
	$(".nextOne").on("click",function(){
		nextTitle();
	});
	$(window).scroll(function () {
		if ($(this).scrollTop() > 91) {
			$('#markPane').css({'position':'absolute','right':'0'});
			$('#markPane').stop().animate({top:$(this).scrollTop()},1000);
		}else{
			$('#markPane').css({'position':'absolute','right':'0'});
			$('#markPane').stop().animate({top:91},1000);
		}
	});
	//$(".adderrorbook").live("mouseover", function(){
	//	$(this).addClass("adderrorbookb");
	//});
	//$(".adderrorbook").live("mouseout", function(){
	//	$(this).removeClass("adderrorbookb");
	//});

	//$(".adderrorbookf").live("mouseover", function(){
	//	$(this).addClass("adderrorbookb");
	//});
	//$(".adderrorbookf").live("mouseout", function(){
	//	$(this).removeClass("adderrorbookb");
	//});
});

var parseflash = function(url,param){
	var	objhtml ='<!--begin flash-->'
	objhtml +='<!--url:'+url+'-->'
	objhtml +='<!--width:'+param.width+'-->'
	objhtml +='<!--height:'+param.height+'-->'
	objhtml +='<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="'+param.width+'px" height="'+param.height+'px" id="Main">'
	objhtml +='<param name="wmode" value="transparent" />';
	objhtml +='<param name="movie" value="'+url+'" />'
	objhtml +='<param name="quality" value="high" />'
	objhtml +='<param name="bgcolor" value="#869ca7" />'
	objhtml +='<param name="allowScriptAccess" value="sameDomain" />'
	objhtml +='<param name="allowFullScreen" value="true" />'
	objhtml +='<!--[if !IE]>-->'
	objhtml +='<object type="application/x-shockwave-flash" data="'+url+'" width="'+param.width+'px" height="'+param.height+'px">'
	objhtml +='<param name="quality" value="high" />'
	objhtml +='<param name="bgcolor" value="#869ca7" />'
	objhtml +='<param name="allowScriptAccess" value="sameDomain" />'
	objhtml +='<param name="allowFullScreen" value="true" />'
	objhtml +='<!--<![endif]-->'
	objhtml +='<!--[if gte IE 6]>-->'
	objhtml +='<p>' 
	objhtml +='Either scripts and active content are not permitted to run or Adobe Flash Player version'
	objhtml +='10.0.0 or greater is not installed.'
	objhtml +='</p>'
	objhtml +='<!--<![endif]-->'
	objhtml +='<a href="http://www.adobe.com/go/getflashplayer">'
	//objhtml +='<img src="http://static.ebanhui.com/exam/images/get_flash_player.gif" alt="Get Adobe Flash Player" />'
	objhtml +='</a>'
	objhtml +='<!--[if !IE]>-->'
	objhtml +='</object>'
	objhtml +='<!--<![endif]-->'
	objhtml +='</object><!--end flash-->'

	return objhtml;	
}
var parseaudio = function(url){
	var	objhtml ='<!--begin audio-->'
	objhtml +='<!--url:'+url+'-->'
	if(window.isMobile){
		var style = (browser=='iPad' || browser=='iPhone'|| browser=='iPod')?'style="height:40px"':'';
		objhtml +='<audio src="'+url+'" controls="controls" preload="preload" '+style+'>您的浏览器不支持,请您尝试升级到最新版本。</audio>';
	}else{
		objhtml += '<object type="application/x-shockwave-flash" data="http://static.ebanhui.com/examv2/flash/dewplayer-bubble.swf?mp3='+encodeURIComponent(url)+'" width="250" height="65">';
		objhtml +='<param name="wmode" value="transparent" />';
		objhtml +='<param name="movie" value="http://static.ebanhui.com/examv2/flash/dewplayer-bubble.swf?mp3='+encodeURIComponent(url)+'" />';
		objhtml +='</object>';
	}
	objhtml +='<!--end audio-->'
	return objhtml;	
}

//主观题答题---改变图片显示的大小
function changesize(img){
	var MaxWidth=720;//设置图片宽度界限
	var MaxHeight=400;//设置图片高度界限
	if(img.offsetHeight>MaxHeight && img.offsetWidth>MaxWidth){
		$(img).css({"width":"720px","height":"400px"});
		$(img).parent().css({"width":"720px","height":"400px"});
	}else if(img.offsetHeight>MaxHeight && img.offsetWidth<MaxWidth){
		$(img).css({"height":((img.offsetWidth/9)*5)+"px","width":img.offsetWidth+"px"});
		$(img).parent().css({"width":img.offsetWidth+"px","height":((img.offsetWidth/9)*5)+"px"});
	}else if(img.offsetHeight<MaxHeight && img.offsetWidth>MaxWidth){
		$(img).css({"width":((img.offsetHeight/5)*9)+"px","height":img.offsetHeight+"px"});
		$(img).parent().css({"width":((img.offsetHeight/5)*9)+"px","height":img.offsetHeight+"px"});
	}else{
		$(img).parent().css({"width":img.offsetWidth+"px","height":img.offsetHeight+"px"});
	}
}
</script>
<style type="text/css">
body { background-color:#E5F5F6;}

#recurPane { background:#fff;  /*border-bottom:1px solid #ccc; */color:#333; letter-spacing:1px; cursor:default;width: 100%;}
#markPane { background-color:#DCF0E3;}

.answerBar, .userAnswerBar, .scoreBar, .linkBar, .textPointBar, .textAnswerBar { padding:2px 0 0 30px; vertical-align:baseline}
.refJudgeA { background:url(http://static.ebanhui.com/exam/images/v1_6q.gif) no-repeat center -34px}
.refJudgeB { background:url(http://static.ebanhui.com/exam/images/v1_6q.gif) no-repeat center -18px}
.markFalse { padding-left:15px; background:url(http://static.ebanhui.com/exam/images/v1_6q.gif) no-repeat center -48px;}
.markTrue { padding-left:15px; background:url(http://static.ebanhui.com/exam/images/v1_6q.gif) no-repeat center -82px}
.answerBar, .answerLabel, .scoreLabel { color:#999}
#recurPane .textAnswer { border:1px solid #fff}
#recurPane .textAnswerBar .textAnswer { color:#0020a0}
#recurPane .blankAnswer{ color:#0020c0}
.blankIndex { color:#333}
.sumscore { color:blue; font-weight:bold}

#markLabel { text-align:center; font-weight:bold; font-size:15px; margin:2px}
.totalScore{ color:red; font-weight:bold; font-size:16px}
#markPaneTop { padding:5px 0 5px 5px}
#markPaneTop table { padding:2px 0 2px 2px}
#markPaneTop table tr { height:14px; line-height:14px}
#markPaneClient { border-top:1px solid #ccc; border-bottom:1px solid #ccc; padding:5px 0 5px 5px}
#markPaneClient ul{ overflow:auto; zoom:1; padding-bottom:12px;}
#markPaneClient li{ float:left; width:39px; white-space:nowrap; overflow:hidden;height: 19px;}
#markPaneClient a { color:black; text-decoration:none}
.markError { color:red}
.markCorrect{color:#0acb0a;font-size: 12px;font-weight: bold;}
.scoreError {color:red; font-size:11px}
.scoreCorrect { color:#0acb0a; font-size:11px}
.scoreCorrect { color:#0acb0a; font-size:11px}
.partBar { margin:0 0 3px}
.markerInfo { color:#666}
.markerInfo p { line-height:18px}
.markerInfo textarea { border:1px solid #9c9; margin:0 0 2px 0; height:65px; width:178px; font-size:12px; overflow:auto; color:#000; background:#f1f8f1}

/*.adderrorbook{background:url(http://static.ebanhui.com/exam/images/adderrorbooka.png) no-repeat;width:104px;height:25px;float:right;cursor:pointer;margin-bottom:5px}*/
/*.adderrorbookf{background:url(http://static.ebanhui.com/exam/images/adderrorbookf.jpg) no-repeat;width:104px;height:25px;float:right;cursor:pointer;margin-bottom:5px}*/
/*.adderrorbooka{background:url(http://static.ebanhui.com/exam/images/adderrorbooka.jpg?v=2) no-repeat;width:104px;height:25px;float:right;cursor:pointer;margin-bottom:5px}*/
/*.adderrorbookb{background:url(http://static.ebanhui.com/exam/images/adderrorbookb.png) no-repeat;width:104px;height:25px;float:right;cursor:pointer;margin-bottom:5px}*/
#recurPane img{
	max-width:658px;
}
#godu{
	display: none;
	width: 68px;
    background: url(http://exam.ebanhui.comhttp://static.ebanhui.com/exam/images/godu.png) no-repeat;
    background-position: 0 0;
    float: left;
    border-radius:4px;
    -moz-border-radius: 4px;
    -webkit-border-radius: 4px;
}
.retbtn{
	text-decoration: none;
}
a{
	text-decoration: none;
}
.rtykwr {
}
.ryjwrt{
	width: 310px;
}
#center{
	padding-bottom: 60px;
}
.topscore {
	width: 50%;
	height: 90px;
	float: right;
    font-family: 'Arial Normal', 'Arial';
    font-weight: 400;
    font-size: 72px;
    text-decoration: underline;
    color: #FF0000;
}
.rtykwr{
	width: 960px;
}
a.gausnt {
	float:right;
	margin-left: 0;
}
.tanstys{
	height: auto;
}
.inputBox div{
	display: inline-block;
}
#container .right{
	right: 100px;
}
.paperName {
    padding: 35px 0 20px 0;
    font-size: 24px;
    font-family: 微软雅黑;
}
.ui-dialog2-content{
	text-align: left;
}

.select_topic{
	width:320px;
	margin-left:25px;
	display:none;
	overflow:hidden;
}
.lastOne{
	width:140px;
	height:40px;
	float:left;
	background: #fff;
	color:#007aff;
	border: 1px solid #007aff;
	cursor:pointer;
	outline: none;
	border-radius: 5px;
}
.nextOne{
	width:140px;
	height:40px;
	float:right;
	background: #5e96f5;
	color:#fff;
	border: 1px solid #5e96f5;
	cursor:pointer;
	outline: none;
	border-radius: 5px;
}
.disnext{
	background: #ccc!important;
	border:1px solid #ccc!important;
}
.dislast{
	color:#ccc!important;
	border:1px solid #ccc!important;
}
.sfalse{
	background:#ff4949!important;
}
.strue{
	background:#13ce66!important ;
}
</style>
</head>
<body>
<div id="header">
	<div class="adAuto">
		<div class="magAuto top">
			<p>您好，<?=empty($user['realname'])?$user['username']:$user['realname']?></p>
		</div>
	</div>
	<div class="Ad">
		<div class="magAuto">
			<img src="http://static.ebanhui.com/exam/images/banner/stu_head_pic.jpg" />
		</div>
	</div>
</div>
<div id="container" class="sheet-con">
<div id="desk" class="layoutContainer" style="position:relative;">
    <div id="center">
		<div id="webEditor" class="font12px">
            <div id="infoPane" style="padding:32px 5px 0px">
            	<div  class="paperName"></div>
            	<table width="50%" border="0" cellspacing="0" cellpadding="0" style="float:left;height:90px;">
                  
                  <tr id="showlimitedtimetr">
                    <td>试卷时间：<span class="totalScore"><label id="showlimitedtime"></label></span></td>
                  </tr>
                  <tr>
                    <td>出题时间：<span class="createTime"><label id="datelab"></label></span></td>
                  </tr>
                </table>
                <div class="topscore">
		          <p style="text-align: right;"><span id="sscore" style="text-decoration:underline;">0分</span></p>
		        </div>
        	</div>  
            <div id="viewcontent" class="viewcontent jqtransformdone">
            	<div id="loadimg" style="width:100px;height:100px;margin:0 auto;"><img style="margin:0 auto;" title="加载中..." src="http://static.ebanhui.com/exam/images/loading-2.gif"/></div>
            </div>
            <div class="select_topic">
            	<button class="lastOne dislast">上一题</button>
            	<button class="nextOne">下一题</button>
            </div>
            <div id="editControlPane" class="controlBar">
            </div>
        </div>
    </div>
    <div id="bottomBar">
    </div>
</div>
<div style="height:16px;">
<div id="playercontainer"></div>
</div>
<!--右边!-->
<div id="sorollDiv2" style="background-color: #D7D9D4;border: 1px solid #BCCDD2;margin: auto;min-width: 76px;position: absolute;top: 50px;width: 960px;display:none;z-index:100;" >
	<div class="tanchu">
		<div class="tittopes">
			<ul class="etely">
				<li><a class="tikes" href="javascript:void(0)" source="my">我的题库</a></li>
				<li><a href="javascript:void(0)" source="school">学校题库</a></li>
				<li><a href="javascript:void(0)" source="pub">公共题库</a></li>
				<li><a href="javascript:void(0)" source="fav">题库收藏</a></li>
			</ul>
			<div class="sodivs">
			  <input id="skey" class="txtsoku" style="border:0px;" type="text" value="请输入你要搜索的关键词" />
			  <input id="btnsearch" class="sobtn" type="button" value="搜索" />
			</div>
			<a class="guanbibtn" id="closequestion" href="javascript:;"></a>
		</div>


		<div class="fotmain" id="publayer">
			<div class="solmain">
				<div class="xiaohui">
					<span>年级</span>
					<div class="xuanke selectgrade">
						<a href="javascript:void(0)" class="xuanze">当前选择年级：无</a>
					</div>
					<span>科目</span>
					<div class="xuanke selectsubject">
						<a href="javascript:void(0)" class="xuanze">当前选择科目：无</a>
					</div>
					<!-- <input id="quedbtn" class="quedbtn" type="submit" name="Submit2" value="" /> -->
				</div>
			</div>
			<input type="hidden" id="pubtype" value="0" />
			<div class="xialaku divgrade" style="display:none">
				<ul class="ulgrade">
				</ul>
			</div>
			<div class="xialaku divsubject"  style="left:418px;display:none;">
				<ul class="ulsubject">
				</ul>
			</div>
			<div class="main" name="0">
				<div class="chaptermenu" id="chaptermenu">
					<h2></h2>
					<div class="nochapter">该分类下暂无知识点</div>
				</div>
				<div class="questionmain" name="0">
					<h2>
						<span style="float:left;">全部题型</span>
						<input type="radio" name="quetype" value="0" checked="checked" class="quetype" id="allque"/>
						<label class="spnquetype" for="allque">全部</label>
						<input type="radio" name="quetype" value="A" class="quetype" id="aque"/>
						<label class="spnquetype" for="aque">单选</label>
						<input type="radio" name="quetype" value="B" class="quetype" id="bque" />
						<label class="spnquetype" for="bque">多选</label>
						<input type="radio" name="quetype" value="D" class="quetype" id="dque" />
						<label class="spnquetype" for="dque">判断</label>
						<input type="radio" name="quetype" value="C" class="quetype" id="cque" />
						<label class="spnquetype" for="cque">填空</label>
						<input type="radio" name="quetype" value="E" class="quetype" id="eque" />
						<label class="spnquetype" for="eque">文字</label>
						<!-- <span style="float:right;padding-right: 35px;">
						选择
						</span> -->
					</h2>
					<div class="questionlist" id="questionlist">
						<div id="loadparent"><div id="loadimg" style="width:100px;height:100px;margin:0 auto;margin-top:100px;display:none;"><img style="margin:0 auto;" title="加载中..." src="http://static.ebanhui.com/exam/images/loading.gif"/></div>
						</div>
					</div>
				</div>
			</div>
			<div class="clearing">
			</div>
		</div>

		<div class="fotmain" id="mylayer" style="display:none;">
			<div class="main">
				<div class="chaptermenu" id="mychaptermenu" name="0">
					<h2>
						<select style="width:200px;margin-top:10px;" id="mfolderid" value="0">
							<option value="0">所有试题</option>
						</select>
					</h2>
					<div class="nochapter" id="mynochapter">该分类下暂无知识点</div>
				</div>
				<div class="questionmain" name="0">
					<h2>
						<span style="float:left;">全部题型</span>
						<input type="radio" name="myquetype" value="0" checked="checked" class="myquetype" id="myallque"/>
						<label class="spnquetype" for="myallque">全部</label>
						<input type="radio" name="myquetype" value="A" class="myquetype" id="myaque"/>
						<label class="spnquetype" for="myaque">单选</label>
						<input type="radio" name="myquetype" value="B" class="myquetype" id="mybque" />
						<label class="spnquetype" for="mybque">多选</label>
						<input type="radio" name="myquetype" value="D" class="myquetype" id="mydque" />
						<label class="spnquetype" for="mydque">判断</label>
						<input type="radio" name="myquetype" value="C" class="myquetype" id="mycque" />
						<label class="spnquetype" for="mycque">填空</label>
						<input type="radio" name="myquetype" value="E" class="myquetype" id="myeque" />
						<label class="spnquetype" for="myeque">文字</label>
						<!-- <span style="float:right;padding-right: 35px;">
						选择
						</span> -->
						<a href="http://exam.ebanhui.com/lnew/<?php //$crid?>.html" target="_blank" value="" class="addmyquebtn"></a>
					</h2>
					<div class="questionlist" id="myquestionlist">
						<div id="loadparent"><div id="loadimg" style="width:100px;height:100px;margin:0 auto;margin-top:100px;display:none;"><img style="margin:0 auto;" title="加载中..." src="http://static.ebanhui.com/exam/images/loading.gif"/></div>
						</div>
					</div>
				</div>
			</div>
			<div class="clearing">
			</div>
		</div>

		<div class="fotmain" id="schoollayer" style="display:none;">
			<div class="main">
				<div class="chaptermenu" id="smychaptermenu" name="0">
					<h2>
						<select style="width:200px;margin-top:10px;" id="sfolderid" value="0">
							<option value="0">所有试题</option>
						</select>
					</h2>
					<div class="nochapter" id="smynochapter">该分类下暂无知识点</div>
				</div>
				<div class="questionmain" name="0">
					<h2>
						<span style="float:left;">全部题型</span>
						<input type="radio" name="myquetype" value="0" checked="checked" class="myquetype" id="smyallque"/>
						<label class="spnquetype" for="myallque">全部</label>
						<input type="radio" name="myquetype" value="A" class="myquetype" id="smyaque"/>
						<label class="spnquetype" for="myaque">单选</label>
						<input type="radio" name="myquetype" value="B" class="myquetype" id="smybque" />
						<label class="spnquetype" for="mybque">多选</label>
						<input type="radio" name="myquetype" value="D" class="myquetype" id="smydque" />
						<label class="spnquetype" for="mydque">判断</label>
						<input type="radio" name="myquetype" value="C" class="myquetype" id="smycque" />
						<label class="spnquetype" for="mycque">填空</label>
						<input type="radio" name="myquetype" value="E" class="myquetype" id="smyeque" />
						<label class="spnquetype" for="myeque">文字</label>
						<!-- <span style="float:right;padding-right: 35px;">
						选择
						</span> -->
						<a href="http://exam.ebanhui.com/lnew/<?php //$crid?>.html" target="_blank" value="" class="addmyquebtn"></a>
					</h2>
					<div class="questionlist" id="schoolquestionlist">
						<div id="sloadparent"><div id="sloadimg" style="width:100px;height:100px;margin:0 auto;margin-top:100px;display:none;"><img style="margin:0 auto;" title="加载中..." src="http://static.ebanhui.com/exam/images/loading.gif"/></div>
						</div>
					</div>
				</div>
			</div>
			<div class="clearing">
			</div>
		</div>

		<div class="fotmain" id="favlayer" style="display:none;">
			<div class="main">
				<div class="fav_questionmain">
					<h2>
						<span style="float:left;">全部题型</span>
						<input type="radio" name="favquetype" value="0" checked="checked" class="favquetype" id="favallque"/>
						<label class="spnquetype" for="favallque">全部</label>
						<input type="radio" name="favquetype" value="A" class="favquetype" id="favaque"/>
						<label class="spnquetype" for="favaque">单选</label>
						<input type="radio" name="favquetype" value="B" class="favquetype" id="favbque" />
						<label class="spnquetype" for="favbque">多选</label>
						<input type="radio" name="favquetype" value="D" class="favquetype" id="favdque" />
						<label class="spnquetype" for="favdque">判断</label>
						<input type="radio" name="favquetype" value="C" class="favquetype" id="favcque" />
						<label class="spnquetype" for="favcque">填空</label>
						<input type="radio" name="favquetype" value="E" class="favquetype" id="faveque" />
						<label class="spnquetype" for="faveque">文字</label>
						<!-- <span style="float:right;padding-right: 35px;">
						选择
						</span> -->
					</h2>
					<div class="questionlist" id="favquestionlist">
						<div id="loadparent"><div id="loadimg" style="width:100px;height:100px;margin:0 auto;margin-top:100px;display:none;"><img style="margin:0 auto;" title="加载中..." src="http://static.ebanhui.com/exam/images/loading.gif"/></div>
						</div>
					</div>
				</div>
			</div>
			<div class="clearing">
			</div>
		</div>

	</div>
</div>


</div>
<div id="showfenxiwrap" style="display:none;"></div>
<div id="showshitiliebiaowrap" style="display:none;padding-left: 15px;padding-right: 15px;"></div>
<div class="rykhje" style="z-index:999;">
	<div class="rtykwr">
    	<span class="rkysfg">答题时间：<span id="sdatelinestr">0</span></span>
        <a href="javascript:void(0)" onclick="$('html, body').animate({scrollTop:0}, 'slow');" class="jetytu">返回顶部</a>
        <a href="javascript:void(0)" id="showshitiliebiao" class="ryjsr">试题列表</a>
        <span class="ryjwrt">共<span id="quecount">0</span>题  答对<span id="truenum">0</span>题  答错<span id="falsenum">0</span>题  用时：<span id="showcompletetime">0</span></span>
        <a style="display:none;" href="javascript:fenxi('<?php //$aid?>')" class="ketrys"></a>
        <a href="javascript:closeWindows()" class="gausnt"></a>
    </div>
</div>

 <iframe name="iframe_data" style="display:none;"></iframe>
 <form id="download_form" name="download_form" target="iframe_data" method="POST"></form>
<!--------播放器代码------------>
<script type="text/javascript" defer="defer">

var ver = 10;
$(function(){
	//判断是否在直播间
	if(top.liveExam != undefined){
		$(".gausnt").attr("href","/im/exam/student.html");
	}
	window.flash = HTools.pFlash({
		'uri':"http://static.ebanhui.com/exam/flash/couseEditor.swf",
		'vars':{'showsubmit':0}
	});
	H.create(new P({
		'id':"piceditor",
		'title':'查看答案',
		'flash':flash,
		'easy':true
	}),'common');
	setTimeout(function(){
		answerobj.fixWpos();
	},1000);
	$("#showshitiliebiao").bind('click',function(){
		H.create(new P({
		title:'试题列表',
		id:'showshitiliebiaowrap',
		content:$("#showshitiliebiaowrap")[0],
		easy:true
	})).exec('show');});
});

function checkUpdate() {return true;}
	function pplay(path){
		H.get('piceditor').exec('show');
		loadSource(path);
	}

	function loadSource(path){
		HTools.callFlash(flash.getId(),'loadSource',function(){
			this.loadSource(path);
		});
	}
	function uploadAnswerOver(){
		H.get('piceditor').exec('close');
	}
	
	function uploadAnswerBefore(){
		H.remove('quespanel');
	}

	// 禁止复制粘贴开始
	document.oncontextmenu=function(){
		return false;
	};

	document.onkeydown = function(e){ 
		var theEvent = window.event || e;
		if (theEvent.ctrlKey && (theEvent.keyCode==67 || theEvent.keyCode==86) ){
			return false; 
		} 
	} 
	document.body.oncopy = function (){ 
		return false; 
	}
	document.onselectstart = function(){ 
		return false; 
	} 
	// 禁止复制粘贴结束
</script>
<script type="text/javascript" src="http://static.ebanhui.com/examv2/js/play.js?ver=20150514003318113"></script>
<div id="piceditor"></div>
<style type="text/css">
.nelame {
	width:530px;
	margin:10px;
	margin-top:0px;
	margin-bottom:20px;
	float:left;
	display:inline;
}
.nelame .leficos {
	width:125px;
	height:265px;
	float:left;
	background:url(http://static.ebanhui.com/ebh/tpl/default/images/kaitongico0104.jpg) no-repeat 30px 32px;
}
.nelame .rigsize {
	width:375px;
	float:left;
	margin-top:25px;
}
.rigsize .tishitit {
	font-size:14px;
	color:#d31124;
	font-weight:bold;
	line-height:30px;
}
.rigsize .phuilin {
	line-height:2;
	color:#6f6f6f;
}
.nelame a.kaitongbtn {
	display:block;
	width:147px;
	height:50px;
	line-height:50px;
	background-color:#ff9c00;
	color:#fff;
	text-decoration:none;
	text-align:center;
	font-size:20px;
	float:left;
	font-family:"微软雅黑";
	font-weight:bold;
	margin-top:20px;
	border-radius:5px;
}
.nelame a.guanbibtn {
	float:left;
	color:#939393;
	font-size:14px;
	margin:40px 0 0 12px;
}
</style>
<div class="buydialog nelame" style="width:530px;background:#fff;display:none;">
	<div class="leficos">
	</div>
	<div class="rigsize">
	<h2 class="tishitit">对不起，您还未开通  或服务已到期。</h2>
	<p style="font-weight:bold;">开通后您可以在学习课程和我的作业里进行在线学习和作业。</p>
	<p class="phuilin">在云教学网校，您可以随时随地在线学习、预习新课，复习旧知、记录和向老师提交笔记、在线做作业、在错题集里巩固错题、在线答疑、查看学习表、与老师，同学互动交流等。</p>
	<div class="czxy" style="padding-left:0px;padding-top:10px;">
			<input name="agreement" id="agreement" type="checkbox" value="1" checked="checked">
			<label for="agreement" style="font-weight:bold;">我已阅读并同意《<a href="http://www.ebh.net/agreement/payment.html" target="_blank" style="color:#00AEE7;">e板会用户支付协议</a>》
			</label>
	</div>
	</div>
	<a href="javascript:void(0);" class="kaitongbtn">在线开通</a>
</div>
</body>
</html>
