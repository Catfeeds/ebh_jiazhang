<!DOCTYPE HTML>
<html>
<head>
<meta content="width=1000, user-scalable=yes" name="viewport"/> 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>在线作业</title>
    <?php $v=getv();?>

<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/exam/css/base.css<?=$v?>" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/exam/css/global.css<?=$v?>">
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/exam/css/layout.css<?=$v?>">
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/exam/css/jqtransform.css<?=$v?>">
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/exam/css/drtu.css<?=$v?>">
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/exam/css/jqtransform.css<?=$v?>" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/exam/css/zujuan.css<?=$v?>"/>
<link rel="stylesheet" href="http://static.ebanhui.com/js/dialog/css/dialog.css<?=$v?>"/>
    <style>
        html{background:#f3f3f3}
    </style>
<script src="http://static.ebanhui.com/exam/js/jquery/jquery-1.11.0.min.js<?=$v?>"></script>
<script src="http://static.ebanhui.com/exam/js/jquery/jquery-migrate-1.2.1.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/examv2/ljs/common.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/examv2/ljs/answer.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/examv2/ljs/quebase.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/examv2/ljs/quefix.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/examv2/ljs/sinchoiceque.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/examv2/ljs/mulchoice.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/examv2/ljs/truefalseque.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/examv2/ljs/textque.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/examv2/ljs/textline.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/examv2/ljs/fillque.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/examv2/ljs/audio.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/examv2/ljs/subjective.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/exam/newjs/formulav2.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/exam/newjs/imgeditorv3.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/examv2/ljs/render.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/swfobject.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/exam/newjs/jquery.base64.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/examv2/ljs/wordque.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xDialog/xloader.auto.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/js/dialog/dialog-plus.js<?=$v?>"></script>
<script src="http://static.ebanhui.com/ebh/js/JSON.js<?=$v?>"></script>
<script src="http://static.ebanhui.com/exam/newjs/json2.js<?=$v?>"></script>
<?=ckeditor()?>
<script type="text/javascript">
<?php
if(checkbrowser()){
	$isMobile = 'true';
}else{
	$isMobile = 'false';
}
$showtaobao = FALSE;
$sflag = empty($_COOKIE['flag'])?'':$_COOKIE['flag'];
if(empty($sflag)) {
	$showtaobao = TRUE;
}
$showtaobao = FALSE;
?>
var isMobile = <?php echo $isMobile; ?>;
<?php global $_SGLOBAL;?>
var browser = '<?php echo $_SGLOBAL["browser"];?>';
var qnumber=1;//【超级全局变量】 题目总数  变量名不可变
var qid=1;///【超级全局变量 】题目ID号，    变量名不重复
var returnurl = "";
var uid = <?php echo $user['uid'];?>;
var answerobj = new Answer();
var isSee = 0;
var isapp = <?php echo $isapp;?>;
var titleNum = 0;
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
function classBtn(){
	hashWatcher.register(function(hash) {
		if(hash){
			hash = hash.replace('#','');
			var showType = answerobj.showType;    //显示类型
			var stIndex = $('.stIndex:contains('+hash+'.)')[0];
			var p = getPosition(stIndex);
			var eqNum = Number(hash) - 1;
			var id = $(".que").eq(eqNum).attr("qsval");
			$(".que").css("border",'');
			// $(".que[qsval='"+hash+"']").css('border','1px solid red');
			if(showType == 0){
				$('.stIndex:contains('+hash+'.)').parents('.singleContainer').css('border','1px solid red');
			}else{
				$(".que").hide();
				$(".right").hide();
				$(".partContainer").hide();
				$(".que").eq(eqNum).show();
				$(".right[id=xpanel" + id + "]").show();  //答题卡
				$(".partContainer[qid=" + id + "]").show();  //文本行
				titleNum = eqNum;
				if($(".que").length == 1){
					return;
				}
				if(eqNum == 0){
					$(".lastOne").addClass("dislast");
					$(".nextOne").removeClass("disnext");
				}else
				if(eqNum == $(".que").length - 1){
					$(".nextOne").addClass("disnext");
					$(".lastOne").removeClass("dislast");
				}else{
					$(".nextOne").removeClass("disnext");
					$(".lastOne").removeClass("dislast");
				}
			}
			if(p!=null){
				$('body,html').stop().animate({ 'scrollTop': p.y },1000);
			}
		}
	});
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
		$(".right[id=xpanel" + id + "]").show();   //答题卡
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
		$(".right[id=xpanel" + id + "]").show();//答题卡
		$(".partContainer[qid=" + id + "]").show();  //文本行
		$(".right").css("top",top);
	}
	answerobj.eid = <?=$eid?> ;
	answerobj.init({eid:<?=$eid?>},initFun);
	function initFun(){
		var showType = answerobj.showType;  //显示类型
		if(showType != 0){
			$(".que").hide();
			$(".right").hide();
			$(".partContainer").hide();
			$(".que").eq(0).show();
			var id = $(".que").eq(0).attr("qsval");
			$(".right[id=xpanel" + id + "]").show();
			$(".partContainer[qid=" + id + "]").show();
			$(".select_topic").show();
			if($(".que").length == 1){
				$(".nextOne").addClass("disnext");
			}
			
		}
	}
	
	//上/下一题
	$(".lastOne").on("click",function(){
		lastTitle();
	});
	$(".nextOne").on("click",function(){
		nextTitle();
	});
	$(".que").hover(function(){
		$(this).addClass("light");
		},function(){
			$(this).removeClass("light");
		});
	$(".que").live("mouseover", function(){
		$(this).addClass("light");
	});
	$(".que").live("mouseout", function(){
		$(this).removeClass("light");
	});
	$(".que .answersubbtn").live("mouseover", function(){
		$(this).addClass("curbg");
	});
	$(".que .answersubbtn").live("mouseout", function(){
		$(this).removeClass("curbg");
	});
	H.create(new P({
		id:'warmtip',
		padding:0,
		title:'温馨提醒',
		width:335,
		height:180,
		content:$('#timeoverdialog')[0],
		modal:true,
		cancel: false,
		cancelDisplay:false
	}),'common');

	$(".gbi").click(function(){
		$(".yichuad").hide("slow");
		setcookie("flag",1,7);
	});
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





//主观题答题---非单例模式改变图片显示的大小
function changesize(img){
	var MaxWidth=720;//设置图片宽度界限
	var MaxHeight=400;//设置图片高度界限
	if(img.height>MaxHeight && img.width>MaxWidth){
		$(img).css({"width":"720px","height":"400px"});
		$(img).parent().css({"width":"720px","height":"400px"});
	}else if(img.height>MaxHeight && img.width<MaxWidth){
		$(img).css({"height":((img.width/9)*5)+"px","width":img.width+"px"});
		$(img).parent().css({"width":img.width+"px","height":((img.width/9)*5)+"px"});
	}else if(img.height<MaxHeight && img.width>MaxWidth){
		$(img).css({"width":((img.height/5)*9)+"px","height":img.height+"px"});
		$(img).parent().css({"width":((img.height/5)*9)+"px","height":img.height+"px"});
	}else{
		$(img).parent().css({"width":img.width+"px","height":img.height+"px"});
	}
}

function getcookie(name){   
    var arr = document.cookie.match(new RegExp("(^| )"+name+"=([^;]*)(;|$)"));    
    if(arr != null){   
        return unescape(arr[2]);   
    }else{   
        return "";   
    }   
}
function setcookie(name,value,days){   
    var exp  = new Date();   
    exp.setTime(exp.getTime() + days*24*60*60*1000);   
    document.cookie = name + "="+ escape (value) + ";expires=" + exp.toGMTString();   
}
function delcookie(name){   
    var exp = new Date();    
    exp.setTime(exp.getTime() - 1);   
    var cval=getCookie(name);   
    if(cval!=null) document.cookie= name + "="+cval+";expires="+exp.toGMTString();   
}   
</script>
<style type="text/css">
body {
	background-color: #E5F5F6;
}
.light {
	border: solid 1px #6EB3EA;
}
.yichuad {
	background: url("http://static.ebanhui.com/exam/images/edo_ad.jpg") no-repeat;
	color: #555555;
	height: 148px;
	position: fixed;
	_position: absolute;
	left: 50%;
	margin-left: 500px;
	top: 250px;
	width: 115px;
	z-index: 9;
}

.yichuad a.gbi {
	width: 16px;
	height: 16px;
	display: block;
	right: 0px;
	top: 0px;
	position: absolute;
}

.yichuad a.xiangoubtn {
	width: 80px;
	height: 27px;
	display: block;
	right: 5px;
	bottom: 5px;
	position: absolute;
}

.retbtn {
	text-decoration: none;
}

#center {
	padding-bottom: 60px;
}

.rykhje {
	width: 100%;
}

.ryjwrt {
	margin-left: 42px;
}

a {
	text-decoration: none;
}

.countstr {
	padding: 0px 10px 0 5px;
	background-color: #fff;
	color: #f00;
	font-size: 14px;
	height: 16px;
	line-height: 16px;
	text-align: center;
	position: relative;
	top: 7px;
}

.paperName {
	padding: 35px 0 20px 0;
	font-size: 24px;
	font-family: 微软雅黑;
}

.tanstys {
	height: auto;
}

.retbtn {
	margin: 20px 0 32px 300px;
}
.inputBox div{
	display: inline-block;
}
#container .right{
	right: 100px;
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
<div  id="container" class="sheet-con">
<div id="desk" class="center magAuto layoutContainer" style=" position:relative;">
    <div id="center">
		<div id="webEditor" class="font12px">
            <div id="infoPane" style="padding:8px 5px 0px">
            	<table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td class="paperName" ></td>
                  </tr>
                  <tr>
                    <td class="listere" >试题共<span id="qcountlab">0</span>题，满分<span id="stotalscore">0</span>分   时间：<span id="showlimitedtime"></span></td>
                  </tr> 
                  <tr>
                    <td class="listere">出题时间：<span class="createTime"><label id="datelab"></label></span></td>
                  </tr>
                </table>
  
				<?php if($showtaobao) { ?>
				<div class="yichuad">
				<div style="position: relative;height:148px;width: 115px;">
					<a href="javascript:void(0)" class="gbi"></a>
					<a target="_blank" href="http://shop109884666.taobao.com/" class="xiangoubtn"></a>
				</div>
				</div>
				<?php } ?>
        	</div>  
            <div id="viewcontent" class="viewcontent jqtransformdone">
            	  <div id="loadimg" style="width:100px;height:100px;margin:0 auto;"><img style="margin:0 auto;" title="加载中..." src="http://static.ebanhui.com/exam/images/loading-2.gif"/></div>
            </div>
           	<div class="select_topic">
            	<button class="lastOne dislast">上一题</button>
            	<button class="nextOne">下一题</button>
            </div>
        </div>
    </div>
    <div id="bottomBar">
    </div>
</div>
</div>
<div id="timeoverdialog" style="<!--display:none-->">
	<div style="float: left;margin-top: 20px;height:60px"><img src="http://static.ebanhui.com/exam/images/naozhong.gif"></div>
	<div style="float: left;margin-top: 20px;font-size: 14px;line-height: 25px;margin-left: 20px;height:60px;width:240px;"><p>亲爱的同学，考试时间到了！试卷已经自动提交，请点击“确认”查看试卷</p></div>
	<div style="float:left;width: 135px;height: 29px;margin-left: 90px;_margin-left: 45px;cursor: pointer;"><a href="javascript:answerobj.showlevel();"><div style="width:135px;height:29px;line-height:29px;background:url('http://static.ebanhui.com/exam/images/TestImageNoText_135x29.png');display:block;font-size:14px;padding-left: 55px;text-decoration: none;">确认</div></a></div>

</div>
<div id="showfenxiwrap" style="display:none;height:auto;width:100%;"></div>
<div id="showshitiliebiaowrap" style="display:none;padding-left: 15px;padding-right: 15px;"></div>
<div class="rykhje" style="display: none">
	<div class="rtykwr">
    	<span class="rykbact"><span id="limitedhour">0</span>:<span id="limitedminute">0</span>:<span id="limitedsecond">0</span></span>
		<span class="ryercdrt">
			<?php if(empty($_GET['f'])){?>
			<a href="javascript:void(0)" onclick="answerobj.uploadData(0);" class="cuncaog">保存</a>
			<a href="javascript:void(0)" onclick="answerobj.uploadData(1,true);"class="taishant">提交</a>
			 <?php }?>
		</span>
        <a href="javascript:void(0)" onclick="$('html, body').animate({scrollTop:0}, 'slow');" class="jetytu">返回顶部</a>
        <a id="showshitiliebiao" href="javascript:void(0);" class="ryjsr">试题列表</a>
    </div>
</div>
<!--------播放器代码------------>
<script type="text/javascript" defer="defer">

function checkUpdate() {return true;}
setInterval(function(){
	$(".schcwid[value!='']").each(function(){
		var obj = this;
		var schcwid = $(this).val();
		
	});
	
},10000);

</script>

<script type="text/javascript" src="http://static.ebanhui.com/examv2/js/play.js<?=$v?>"></script>
<!--------播放器代码------------>

<script>
	$(function(){
		//判断是否在直播间
		if(top.liveExam != undefined){
			$(".cuncaog").attr("href","/im/exam/student.html");
			$(".taishant").attr("href","/im/exam/student.html");
		}
		window.flash = HTools.pFlash({
			'id':"piceditor",
			'uri':"http://static.ebanhui.com/exam/flash/couseEditor.swf"
		});
		var button = new xButton();
		button.add({
            value: '提交答案',
            callback: function () {
               H.remove('quespanel');
               HTools.getFlash(flash.getId()).swf.uploadAnswer();
               return false;
            },
            autofocus: true
		});
		button.add({
            value: '取消',
            callback: function () {
            	H.remove('quespanel');
              	H.get('piceditor').exec('close');
               	return false;
            }
		});
		H.create(new P({
			'id':"piceditor",
			'title':'在线答题',
			'flash':flash,
			'easy':true,
			'button':button
		},{'onclose':function(){
			H.remove('quespanel');
		}}),'common');
		setTimeout(function(){
			answerobj.fixWpos();
		},1000);
		$("#showshitiliebiao").bind('click',function(){
			H.create(new P({
			title:'试题列表',
			id:'showshitiliebiaowrap',
			content:$("#showshitiliebiaowrap")[0],
			easy:true,
			padding:'5px'
		})).exec('show');
			valChange();
		});
	});
	//判断已/未达题
	function valChange(){
		for(var c in answerobj.obj){
			var type = answerobj.obj[c].type;
			var qid = answerobj.obj[c].qid;
			var que = $(".que[qsval ="+ qid +"]");
			var listIndex = que.index(".que") + 1;
			//选择与判断
			if(type == "A" || type == "B" || type == "D"){
				var val = que.find(".qanswer").val();
				if(val != "" && val != -1){
					$(".kryrtu[href = #"+ listIndex +"]").css("background","#5e96f5");
				}else{
					$(".kryrtu[href = #"+ listIndex +"]").css("background","#888");
				}
			}else
			//填空
			if(type == "C"){
				var isImg = false;
				var isVal = false;
				var nullVal = que.find(".qinput").val();
				if(que.find("img[class=qinput]").length > 0){
					isImg = true;
				}else{
					isImg = false;
				}
				if(nullVal != ""){
					isVal = true;
				}else{
					isVal = false
				}
				if(isImg || isVal){
					$(".kryrtu[href = #"+ listIndex +"]").css("background","#5e96f5");
				}else{
					$(".kryrtu[href = #"+ listIndex +"]").css("background","#888");
				}
			}else
			//文字题
			if(type == "E"){
				var txtVal = que.find(".textAnswer").html().replace("&nbsp;","");
				if(txtVal != ""){
					$(".kryrtu[href = #"+ listIndex +"]").css("background","#5e96f5");
				}else{
					$(".kryrtu[href = #"+ listIndex +"]").css("background","#888");
				}
			}else
			//主观题
			if(type == "H"){
				var hand = false;
				var upload = false;
				var handVal = que.find(".note").val();
				var uploadVal = que.find(".upsanswer").html();
				if(handVal == "1"){
					hand = true;
				}
				if(uploadVal != undefined && uploadVal != ""){
					upload = true;
				}
				if(hand || upload){
					$(".kryrtu[href = #"+ listIndex +"]").css("background","#5e96f5");
				}else{
					$(".kryrtu[href = #"+ listIndex +"]").css("background","#888");
				}
			}else{
				//答题卡
				var isSelect = false;
				var isNull = false;
				var isTxt = false;
				var card = $(".right[id=xpanel"+ qid +"]");
				//单选、多选、判断
				var curLeng = card.find(".cur").length;
				if(curLeng > 0){
					isSelect = true;
				}
				//填空
				var filling = card.find(".filling-lg");
				for(var p = 0;p < filling.length;p ++){
					if(filling.eq(p).val() != ""){
						isNull = true;
					}
				}
				//文字
				var frameLeng = card.find("iframe");
				for(var k = 0;k < frameLeng.length;k++){
					var pVal = frameLeng.contents().find("p").html().replace("<br>","");
					if(pVal != ""){
						isTxt = true;
					}
				}
				if(isSelect || isNull || isTxt){
					$(".kryrtu[href = #"+ listIndex +"]").css("background","#5e96f5");
				}else{
					$(".kryrtu[href = #"+ listIndex +"]").css("background","#888");
				}
			}
		}
	}
	function pplay(path){
		H.get('piceditor').exec('show');
		loadSource(path);
	}

	function loadSource(path){
		HTools.callFlash(flash.getId(),'loadSource',function(){
			this.loadSource(path);
		});
	}
	function uploadAnswerOver(qid,key){
		H.remove('quespanel');
		H.get('piceditor').exec('close');
		var imgsrc = 'http://up.ebh.net/exam/getsubthumb.html?uid='+uid+'&key='+encodeURIComponent(key);
		$('#qid_'+qid).find('img').attr('src',imgsrc);
		$(".que[qsval = "+ qid +"]").find(".note").val("1");
	}

	function uploadAnswerBefore(){
		H.remove('quespanel');
	}
	function numtostr(num,bol) {
		var nums = [];
		var str = 'ABCDEFGHIJKLMNOPQ';
		var sstr = [];
		for(var i=0;i<num.length;i++){
			nums.push(num[i]);
			if(num[i] == '1'){
			  sstr.push(str[i]);
			}
		}
		if(bol){
			var sstr = sstr.join(',');
		}else{
			var sstr = sstr.join('');
		}
		return sstr;
	}
	function renderHtml(html){
		html = '<div style="width:600px;min-height:100px;overflow-y:auto;">'+html+'</div>';
		H.create(new P({
			title:'原题',
			id:'quespanel',
			width:600,
			showcancel:false,
			content:html
		}),'common').exec('show');
	}
	$("#viewcontent").on('click','li.radioBox',function(){
		$(this).siblings('li').find('.optionContent').css({'color':'#000'});
		$(this).find('.optionContent').css({'color':'#f00'});
		$(this).find('.jqTransformRadio').triggerHandler('click');
	});
	$("#viewcontent").on('click','li.checkBox',function(e){
		var target = e.srcElement || e.target;
		if(!$(target).is('a.jqTransformCheckbox')){
			$(this).find('.jqTransformCheckbox').triggerHandler('click');
		}
		$(this).parent('ul').children('li').each(function(){
			if($(this).find('.jqTransformChecked').length > 0){
				$(this).find('.optionContent').css({'color':'#f00'});
			}else{
				$(this).find('.optionContent').css({'color':'#000'});
			}
		});
	});
	
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
	// 禁止复制粘贴结束
</script>

