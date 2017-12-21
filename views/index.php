<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/jiazhang/css/jzxiang.css?version=20160405001" />
<link href="http://static.ebanhui.com/portal/css/ebtert.css?version=20160405001" type="text/css" rel="stylesheet">
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery.cookie.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xform.js?v=1"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" />
<style type="text/css">
.errorLayer {font-size: 12px; width: 218px;}
.errorLayer .login_top {
    background: url(http://static.ebanhui.com/ebh/tpl/default/images/errorLayer_03.gif) no-repeat scroll 0 0 transparent;
    height: 2px;
    overflow: hidden;
}
.errorLayer .login_mid {
    background: #fff;
    overflow: hidden;
    padding: 8px 20px;
    position: relative;
	border-left:1px solid #ccc;
	border-right:1px solid #ccc;
}
.errorLayer .login_bot {
    background: url(http://static.ebanhui.com/ebh/tpl/default/images/errorLayer_16.gif) no-repeat scroll 0 0 transparent;
    height: 7px;
    overflow: hidden;
}
.errorLayer .login_mid .conn {
    overflow: hidden;
    width: 187px;
}
.errorLayer .login_mid .conn .bigtxt {
	color: #f16771;
    background: url('http://static.ebanhui.com/ebh/tpl/2016/images/errorts.png') no-repeat left center;
    padding-left: 23px;
    height: 25px;
    line-height: 25px;
}
.errorLayer .login_mid .conn .stxt {
    line-height: 18px;
    padding-left: 20px;
}
.errorLayer .login_mid .conn .stxt2 {
    line-height: 18px;
    padding-left: 2px;
}
.login_mid .tips_close {
    color: #666666;
    cursor: pointer;
    font-family: '黑体';
    font-size: 16px;
    font-weight: bold;
    position: absolute;
    right: 10px;
    top: 0;
}
</style>
<script type="text/javascript">
<!--
$(function(){

    $("#mod_login_close").click(function(){
        $("#mod_login_tip").fadeOut();
    });



    //下次自动登录
    $("#remember").toggle(function(){
    	$(this).removeClass("choose");
    	$("#cookietime").val("0");
    },function(){
    	$(this).addClass("choose");
    	$("#cookietime").val("1");
    });

    $(".jzhanghao").click(function(){
    	$(this).children("input").focus();
    });

	initPlaceholder();
});

//初始化placeholder
function initPlaceholder(){
	var n = "placeholder" in $("<input>")[0];
	if(!n){
		$(".jzhanghao input").each(function(){
			var s = $(this);
			var o = s.prev(".placeholder");
			var i = function() {
				0 == s.val().length ? o.show() : o.hide()
			};
			if (0 == o.length) {
				o = $('<span>');
				o.addClass("placeholder").html(s.attr("placeholder")).attr("unselectable", "on");
				s.before(o).attr("data-placeholder", s.attr("placeholder"));
				s[0].removeAttribute("placeholder");

				s.bind("focus", function(){
			    	$(this).parent().removeClass("errorts").addClass("shuru");
			    	$(this).prev(".placeholder").hide();
			    });
			    s.bind("blur", function(){
					$(this).parent().removeClass("shuru");
					$(this).val().length == 0 ? $(this).prev(".placeholder").show() : $(this).prev(".placeholder").hide();
			    });
			    s.bind("input propertychange", function() {
			    	$(this).prev(".placeholder").hide();
			    });
			}
			var h = 3,
				p = setInterval(function() {
					--h <= 0 && clearInterval(p), i()
				}, 300);
			i()
		});
	}
}

//错误提示
function tipname_message(message,high){
    if ($("#mod_login_tip").is(":visible")){
        $("#mod_login_tip").stop(true, true).animate({"top":high}, " slow", "swing", function(){
            $("#mod_login_tip").fadeOut("fast", function(){
                $("#mod_login_title").text(message);
                $("#mod_login_tip").fadeIn("slow");
            });
        });
    } else{
         $("#mod_login_title").text(message);
         $("#mod_login_tip").css("top",high).fadeIn("slow");
    }
}

	var form_submit = function(returnurl){

	//清空之前错误提示
	$("#mod_login_tip").fadeOut();
    if ($('#username').val() == '' || $('#username').val () == '用户名'){
        tipname_message('用户名不能为空',17);
        $("#username").parent().addClass("errorts");
        return;
    }
    if ($("#password").val () == ''){
        tipname_message('密码不能为空',71);
        $("#password").parent().addClass("errorts");
        return;
    }
	var url = '/login.html?inajax=1&login_from=classroom';
	if(returnurl){
		url+='&returnurl='+returnurl;
	}
	$.ajax({
		url: url,
		data	:$("#form1").serialize(),
		type	:'POST',
		dataType:'json',
		success	:function(json){
			if(json['code']==1){
				if(json['durl'] != undefined && json['durl'] != '') {
					dosso(json['durl'],json["returnurl"]);
				} else {
					location.href = json["returnurl"];
				}
			}else{
                tipname_message(json["message"],17);
        		$("#password").parent().addClass("errorts");
			}
			return false;
		}
	});
}
function dosso(durl,returnurl,callback) {
	var img = new Image();
	img.src = durl+"&" + Math.random();
	$(img).appendTo("body");
	if(img.complete) { // 如果图片已经存在于浏览器缓存，直接调用回调函数
		if(returnurl != undefined && returnurl != "") {
			location.href = returnurl;
		} else if(typeof(callback) == 'function') {
			callback();
		}
		return; // 直接返回，不用再处理onload事件
	}
	img.onload = function () { //图片下载完毕时异步调用callback函数。
		if(returnurl != undefined && returnurl != "") {
			location.href = returnurl;
		} else if(typeof(callback) == 'function') {
			callback();
		}
	};
}

function loadpage(){
	$.cookie('jz_auth', '', { expires: -3600, path: '/',domain: '.<?= $this->uri->curdomain;?>'});
	location.href='/';
}


$(document).ready(function(){
  $('.list').hover(
    function(){
      $(this).find('.canvas').addClass('hover');
    },
    function(){
      $('.canvas.hover').removeClass('hover');
    }
  );
 });

 $(function(){
		xForm.hit($("#search"));
		$(".askter h2").attr({style:"cursor:pointer;"});
		$("#moreapp").bind('click',function(){
			$(".askter:not(:animated)").slideToggle();
		});
		// $("div.askter").bind('mouseleave',function(){
		// 	$(".askter:not(:animated)").slideToggle();
		// });
		$("#search").bind('keypress',function(e){
			if(e.which == 13){
				dosearch();
			}
		});
	});

	function dosearch(){
		var $search = $("#search");
		$search.val($.trim($search.val()));
		var q = $search.val();
		if(q == $search.attr('x_hit')){
			q = "";
		}
		if(q == ""){
			alert("请输入关键字");
			return;
		}
		var url = "/search.html?q="+encodeURIComponent(q);
		xredirect(url);
	}
	function xredirect(url){
		$("#searchhide").attr("action",url);
		$("#searchhide").submit();
	}
	function _login(){
        tologin('http://www.ebh.net/login.html?returnurl=__url__');
    }
	
	var tologin = function(url){
    url = url.replace('__url__',encodeURIComponent(location.href));
    location.href=url;
    }
//-->
</script>


<title>家长登录</title>
</head>

<body style="background:#fff;">
<?php $user = Ebh::app()->user->getloginuser();?>
<div class="ebhcceud">
<div class="pass_e">
<div class="inftur">
<div class="headerleft" style="float:left;">
	<a class="linwen" target="_blank" href="http://www.ebh.net/intro/schooliswhat.html">什么是网络学校？</a>
	<!--<a class="linwen" target="_blank" href="http://www.ebh.net/intro/schoolfunction.html">能做什么？</a>-->
</div>
<ul class="quick-menu">
<?php if(empty($user)){?>

<?php }else{?>
<li class="">
<a class="linwen" href="javascript:void(0)">您好 <?= $user['username']?> 欢迎来到e板会！</a>
</li>
<li class="">
<a class="linwen" href="<?=geturl('logout')?>">安全退出</a>
</li>
<?php }?>
<li class="">
<a class="linwen" id="moreapp" href="http://www.ebh.net/moreapp.html">更多应用</a>
</li>
</ul>
</div>
</div>
</div>
<div class="pass_e2"></div>
<div class="jzwrap">
<div class="jzwraptop">
    <div class="jzwraptopson">
    <div class="jzbanner"><a href="#"></a></div>
<!--内容!-->
<?php if(!empty($user)) { ?>
	<?php 
		$sex = empty($user['sex']) ? 'man' : 'woman';
		$type = $user['groupid'] == 5 ? 't' : 'm';
		$defaulturl = 'http://static.ebanhui.com/ebh/tpl/default/images/'.$type.'_'.$sex.'.jpg';
		$face = empty($user['face']) ? $defaulturl : $user['face'];
		$facethumb = getthumb($face,'78_78');
		$url = geturl('school');
	?>
		<div class="logins" >
			<div class="loginson">
				<div class="title">用户登录</div>
				<div class="mt30" style="height:84px;">
					<div class="touxiangs fl"><img width="78" height="78" src="<?= $facethumb ?>"/></div>
					<div class="xingming ml15 fl">
						<p class="xmson"><?= $user['username'] ?></p>
						<p class="scdlsj mt20">上次登录时间：<br /><?= $user['lastlogintime']?></p>
					</div>
				</div>
				<div class="clear"></div>
				<div class="dlbtn mt45">
				<?php if(count($roomlist)>1){ ?>  
					<a href="<?= $url?>" id="button"><img src="http://static.ebanhui.com/jiazhang/images/jinru.jpg" /></a>
				<?php }elseif(count($roomlist)==1){ ?>
					<a href="/<?=$roomlist[0]['crid']?>.html" id="button"><img src="http://static.ebanhui.com/jiazhang/images/jinru.jpg" /></a>
				<?php }else{ ?>
					<a href="/login/error.html" id="button"><img src="http://static.ebanhui.com/jiazhang/images/jinru.jpg" /></a>
				<?php } ?>
				</div>
				<div class="aqtc mt25"><a href="/logout.html">安全退出</a></div>
			</div>
		</div>
	<?php }else{ ?>
		<div class="logins" style="">
			<div class="loginson">
				<div class="title">用户登录</div>
				<form id="form1" method="post" name="form1" action="http://jiazhang.ebh.net/login.html?inajax=1&login_from=classroom"  onsubmit="form_submit(); return false;">
				<input type="hidden" name="loginsubmit" value="1" />
				<input type="hidden" name="cookietime" id="cookietime" value="1" />
				<div class="jzhanghao"><span class="jzspan1s fl"></span><input class="jzinput fl" value="" name="username" id="username" placeholder="用户名" /></div>
				<div class="clear"></div>
				<div class="jzhanghao"><span class="jzspan2s fl"></span><input class="jzinput fl" id="password" type="password" value="" name="password" id="password" placeholder="密码" /></div>
				<div class="clear"></div>
				<div class="lofo mt10">
					<div class="zhuce">
						<div class="xczddl fl"><a class="choose" href="javascript:;" id="remember">下次自动登录</a></div>
						<div class="wjmm fr"><a href="http://www.ebh.net/forget.html">忘记密码</a></div>
					</div>
				<div class="clear"></div>
				<div class="dlbtn mt20"><input value="登录" class="logbtn" type="submit"></div>
				</form>
				<div class="clear"></div>
				<div class="thirddl mt35">
                    <div class="thirddlson ml35 mt15">
                        <a href="http://www.ebh.net/otherlogin/qq.html?returnurl=http://jiazhang.ebh.net"><img src="http://static.ebanhui.com/pan/images/qq.png" /></a>
                        <a href="http://www.ebh.net/otherlogin/sina.html?returnurl=http://jiazhang.ebh.net"><img src="http://static.ebanhui.com/pan/images/xlwb.png" /></a>
                        <a href="http://www.ebh.net/otherlogin/wx.html?returnurl=http://jiazhang.ebh.net"><img src="http://static.ebanhui.com/pan/images/wx.png" /></a>
                    </div>
                </div>

				<div id="mod_login_tip" class="errorLayer" style="visibility: visible; position: absolute; left: 62px; z-index: 1010; display:none;">
		            <div class="login_top"></div>
		            <div class="login_mid">
		                <div id="mod_login_close" class="tips_close">x</div>
		                <div class="conn">
		                    <p id="mod_login_title" class="bigtxt"></p>
		                </div>
		            </div>
		            <div class="login_bot"></div>
		        </div>
			</div>
		</div>

	<?php } ?>
	</div>
    </div>
	<div class="clear"></div>
    <div class="gongneng">
    	<ul>
        	<li class="fl first"><a href="#"><img src="http://static.ebanhui.com/jiazhang/images/xxjl.jpg?v=20160405001" /></a></li>
            <li class="fl"><a href="#"><img src="http://static.ebanhui.com/jiazhang/images/xxjd.jpg?v=20160405001" /></a></li>
            <li class="fl first"><a href="#"><img src="http://static.ebanhui.com/jiazhang/images/czjl.jpg?v=20160405001" /></a></li>
            <li class="fl"><a href="#"><img src="http://static.ebanhui.com/jiazhang/images/lszy.jpg?v=20160405001" /></a></li>
        </ul>
    </div>
    <div class="clear"></div>
    <!--底部-->
<script type="text/javascript">
	 $(document).keypress(function(e){
	 	if(e.which == 13) {
	 		$("#login_btn").click();
	 	}
	 });
</script>
<?php $this->display('footer'); ?>