<?php $this->display('common/page_header'); ?>
<link href="http://exam.ebanhui.com/static/css/done.css" rel="stylesheet" type="text/css" />
<link href="http://exam.ebanhui.com/static/css/public.bak.css" rel="stylesheet" type="text/css" />
<link href="http://exam.ebanhui.com/static/css/jqtransform.css" rel="stylesheet" type="text/css" />
<link type="text/css" href="http://exam.ebanhui.com/static/css/wavplayer.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="http://exam.ebanhui.com/static/css/tikutop.css" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/date/WdatePicker.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/dtree/dtree.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xquestion_for_jz.js?v=20151016001?>"></script>
<style type="text/css">
.delabtn{background:url(http://exam.ebanhui.com/static/images/dela.png) no-repeat;width:79px;height:25px;float:right;cursor:pointer;margin-bottom:5px}
.delahbtn{background:url(http://exam.ebanhui.com/static/images/delah.png) no-repeat;width:79px;height:25px;float:right;cursor:pointer;margin-bottom:5px}

#errlist .que{clear:both;padding:5px 0 25px;height:auto;}
#errlist .que p.desc{font-size:12px;height:35px;line-height: 35px;color:#3a3a3a;display: inline-block;border:1px solid #f3f3f3;background: #f3f3f3;width: 782px;}
#errlist .que p.desc span{display: inline-block;margin-right: 25px;}
#errlist .que p.desc em{margin-right: 8px;}
.work_search ul li {display:inline-block;float: left;height:55px;line-height: 55px;}

#errlist .que .optionContent img{vertical-align: middle;}
.singleContainerFocused { border-bottom:1px solid #DEDEDE; border-top:none;}
.dtree {
    background: none repeat scroll 0 0 white;
    display: inline;
    float: left;
    height: 501px;
    overflow: auto;
    padding: 10px;
    width: 414px;
}
.ferygur span {
	margin-left: 0;
}
#errlist .que p.desc{
	width: 995px;
}
</style>

<script type="text/javascript">
	var parseimg = function(url){
		return "<img src='"+url+"'/>";
	}
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
			objhtml += '<object type="application/x-shockwave-flash" data="/static/flash/dewplayer-bubble.swf?mp3='+encodeURIComponent(url)+'" width="250" height="65">';
			objhtml +='<param name="wmode" value="transparent" />';
			objhtml +='<param name="movie" value="/static/flash/dewplayer-bubble.swf?mp3='+encodeURIComponent(url)+'" />';
			objhtml +='</object>';
		}
		objhtml +='<!--end audio-->'
		return objhtml;	
	}
</script>

<!-- 主要内容 -->
<div class="lefrig" id="lefrig" style="border:solid 1px #cdcdcd;background:#fff;float:left;margin-top:0px;width:998px;">
	<a id="maodian" style="display:none;" href="#lefrig" ></a>
	<div class="workol" id="errlist">
		<div class="work_menu" style="position:relative;">
    <ul>
    	<li ><a href="<?= geturl('college/examv2') ?>"><span>未做</span></a></li>
		<li><a href="<?= geturl('college/examv2/my') ?>"><span>做过的作业</span></a></li>
		<li><a href="<?= geturl('college/examv2/box') ?>"><span>草稿箱</span></a></li>
		<li class="workcurrent"><a href="<?= geturl('myerrorbook') ?>"><span>错题本</span></a></li>
    </ul>

	<div class="diles">
	<?php
		$q= empty($q)?'':$q;
		if(!empty($q)){
			$stylestr = 'style="color:#000"';
		}else{
			$stylestr = "";
		}
	?>
	<input name="txtname" <?=$stylestr?> class="newsou" id="txtname" value="<?= $q?>" type="text" />
	<input type="button" onclick="page_load(1);return false;" class="soulico" value="">
</div>

</div>
<div id="schoollayerWrap" style="z-index:999;width: 980px;height: 115px;margin:0 auto;">
	<?php $this->display('chapter_fragment')?>
</div>
<div style="clear:both;"></div>
		<div id="fragment_wrap" style="position:relative;min-height:320px;">
			<div id="fragment"></div>
			<div id="lodding" style="text-align: center;position:fixed;top:300px;left:450px;"><img src="http://static.ebanhui.com/ebh/images/loading.gif" /></div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(function(){
		var searchtext = "请输入搜索关键字";
		initsearch("txtname",searchtext);
	});

	Xques.setCallback(function(param){
		page_load(1,param);
	});

	/*
	*课件详情下面的评论分页
	*ajax评论分页 前台处理
	*/
	function page_load(pagetxt,param){
		if(typeof param == "undefined"){
			param = Xques.getParams();
		}
		var url = "/myerrorbook/getajaxpage.html?q="+encodeURIComponent(param.keyword);
		$("#lodding").show();
		var pagetext = pagetxt;//分页按钮txt文本
		var page = 1;
		//检查文本格式 *数字 * 上一页 * 下一页 * 跳转
		if(!isNaN(pagetext)){
			page = pagetext;
		}else if(pagetext=='下一页&gt;&gt;'){
			lastp = parseInt($(".none").html()); 
			page = lastp+1;
		}else if(pagetext=='&lt;&lt;上一页'){
			lastp = parseInt($(".none").html());
			var np = lastp-1;
			page = ((np)<=0)?1:np;
		}else if(pagetext=='跳转'){
			page = $("#gopage").attr("value");
		}
		/**ajax后台读取json数据*/
		$.post(url,{'page':page,folderid:param.folderid,chapterid:param.chapterid,quetype:param.quetype},function(data){
			$("#fragment").html(data.fragment);
			//分页处理
			$(".pages").html(data.pagestr);
			if($.isFunction(top.resetmain)){
				top.resetmain();
			}
			$("#lodding").hide();
			$(".pages a").unbind();
			$(".pages a").each(function(){
				$(this).attr('href','#lefrig');
				$(this).css("cursor",'pointer');
				$(this).bind("click",function(){var pagetxt = $(this).html();page_load(pagetxt);});
				//显示当前页
				var ptxt =$(this).html(); 
				if(!isNaN(ptxt) && ptxt == page){
					$(this).addClass("none");
					$(this).css({'background':'#23a1f2'});
				}else{
					$(this).removeClass("none");
				}
			})

		},'json');
	}
	$(function(){
		Xques.doshow("<?=$crid?>");
	});
var cururl = location.href;
// 全屏播放器注入到父级框架开始
parent.window.Func('playflv_top',function(source,cwid,title,isfree,num,height,width,hasbtn,callback){
	with(parent.window){
		var url = source+"attach.html?examcwid="+cwid;
		url = encodeURIComponent(url);
		if(hasbtn == undefined)
			hasbtn = 0;
		var vars = {
			source: url,
			type: "video",
			streamtype: "file",
			server: "",
			duration: "52",
			poster: "",
			autostart: "false",
			logo: "",
			logoposition: "top left",
			logoalpha: "30",
			logowidth: "130",
			logolink: "http://www.ebanhui.com",
			hardwarescaling: "false",
			darkcolor: "000000",
			brightcolor: "4c4c4c",
			controlcolor: "FFFFFF",
			hovercolor: "67A8C1",
			controltype: 1,
			classover: hasbtn
		};
		H.create(new P({
			title:'视频播放',
			easy:true,
			flash:HTools.pFlash({'id':'playflv','uri':"http://static.ebanhui.com/ebh/flash/videoFlvPlayer.swf",'vars':vars})
		})).exec('show');
	}
	
})('showplayDialog',function(){
	with(parent.window){
		if(typeof courseObj == "undefined"){
			courseObj = new Course();
		}
		if(!source || !cwid){
			return false;
		}
		courseObj.userplay(source,cwid);return false;
	}
})('pclicked',function(e){
	if(cururl == location.href){
		$('body').click();
	}
});
// 全屏播放器注入到父级框架结束
</script>
<?php 
$this->display('common/player');
?>