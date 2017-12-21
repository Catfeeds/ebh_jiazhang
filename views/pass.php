<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>家长密码</title>
</head>

<body>
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
<link type="text/css" rel="stylesheet" href="http://static.ebanhui.com/jiazhang/css/jzxiang.css" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/common.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/date/WdatePicker.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen">
<div class="mainst">
	
	<div class="lefrig" style="background:#fff;border:solid 1px #cdcdcd;">


<div class="center">

<form method="post"  name="changpwd">

<div class="xiuic">
<p style="font-weight:bold;margin-bottom:10px;">修改密码</p>
<p style="color:#817f7f;">定期修改密码，有助于保护您的账号安全及个人隐私<a style="color:#1996e6;font-weight:bold;" href="http://www.ebh.net/forget.html" target="_blank"> 忘记密码？</a></p>
</div>
<div class="etatb">
<div id="oldpwd" class="dantie gai_cuoti">
<span class="redx"><img src="http://static.ebanhui.com/ebh/tpl/default/images/gai_bi.jpg" /> 当前密码：</span>
<input name="oldpassword" id="oldpassword" style="display:none;color:#000" onblur="chkoldpwd(this.value)" class="shutxt" type="password" value="">
<input name="oldpassword" id="oldpassworda" onblur="chkoldpwd(this.value)" class="shutxt" type="text" value="请输入您当前的登录密码">
</div>
<div id="newpwd1" class="dantie gai_cuoti">
<span class="redx"><img src="http://static.ebanhui.com/ebh/tpl/default/images/gai_bi.jpg" /> 新密码：</span>
<input id="password" style="display:none;color:#000" name="password" class="shutxt" onKeyUp=pwStrength(this.value)  onblur="password2(this.value)" type="password" value="" >
<input id="passworda" name="password" class="shutxt" onKeyUp=pwStrength(this.value)  onblur="password2(this.value)" type="text" value="密码长度为6-18位，建议英文和数字组合" >
</div>
<div class="dantie">
<span class="redx">安全级别：</span><div class="entern"><span id="level" style="width:0%;"></span></div><span id="leveltip">弱</span>
</div>
<div id="newpwd2" class="dantie">
<span  class="redx"><img src="http://static.ebanhui.com/ebh/tpl/default/images/gai_bi.jpg" /> 确认新密码：</span>
<input id="passwordtrue" style="display:none;color:#000" name="passwordtrue" class="shutxt" onblur="truepassword(this.value)" type="password" value="" >
<input id="passwordtruea" name="passwordtrue" class="shutxt" onblur="truepassword(this.value)" type="text" value="请再次输入您的新密码" >
</div>
<a href="javascript:void(0)" onclick="chkform()" class="borhuangbtn" style="height:36px;line-height:36px;font-size:14px;font-weight:bold;margin-top:40px;margin-left:120px;margin-bottom:10px;">确认</a>
</div>

</form>
</div>
<div class="clear"></div>
</div>
<script type="text/javascript">

$(function(){
	init("#oldpassword");
	init("#password");
	init("#passwordtrue");
});

function init(inputname){
	$(inputname+"a")
	.focus(function(){
		$(this).hide();
		$(inputname).show().focus();
	})
	.blur(function(){

	});
	$(inputname)
	.blur(function(){
		if($(this).val()==''){
			$(inputname+"a").show();
			$(this).hide();
		}
	})
	.keydown(function(e){
		if(e.which==32){
			return false;
		}
	});
}


var old = true;
var newpassword = true;
var newpasswordtrue = true;
function chkoldpwd(oldpassword,nochecktrue){
	if(oldpassword == ""){
		// $("#oldpassword1").html("<font color=red>请输入原密码！</font>");
		$("#oldpwd").attr('class','dantie gai_cuoti');
		old = false;
		return;
	}
	if(nochecktrue)
		return;
	$.ajax({
		url:"<?=geturl('pass/checkoldpassword')?>",
		type:'post',
		data:{'oldpassword':oldpassword},
		success:function(data){
			if (data==0) {
				// $("#oldpassword1").html("<font color=red>原密码输入有误，请重新输入!</font>");
				$("#oldpwd").attr('class','dantie gai_cuoti');
				old = false;
				return;
			}else{
				old = true;
				// $("#oldpassword1").html("");
				$("#oldpwd").attr('class','dantie gai_duiti');
			}
		}
	});
}
function password2(password){
	newpassword = true;
	if(password == ""){
		// $("#password1").html("<font color='red'>请输入新密码！</font>");
		$("#newpwd1").attr('class','dantie gai_cuoti');
		newpassword = false;
		return false;
	}
	if(password.length < 6 || password.length >18){
		// $("#password1").html("<font color='red'>密码不能低于6位！</font>");
		$("#newpwd1").attr('class','dantie gai_cuoti');
		newpassword = false;
		return false;
	}
	// $("#password1").html("");
	$("#newpwd1").attr('class','dantie gai_duiti');
}
function truepassword(passwordtrue){
	newpasswordtrue = true;
	if(passwordtrue == ""){
		// $("#truepassword1").html("<font color=red>请输入确认密码！</font>");
		$("#newpwd2").attr('class','dantie gai_cuoti');
		newpasswordtrue = false;
		return;
	}
	if(passwordtrue.length < 6 ){
		// $("#truepassword1").html("<font color=red>密码不能低于6位！</font>");
		$("#newpwd2").attr('class','dantie gai_cuoti');
		newpasswordtrue = false;
		return;
	}
	 if(document.getElementById('password').value  != passwordtrue){
		// $("#truepassword1").html("<font color=red>两次密码输入不一致！</font>");
		$("#newpwd2").attr('class','dantie gai_cuoti');
		newpasswordtrue = false;
		return;
	}	
	// $("#truepassword1").html("");
	$("#newpwd2").attr('class','dantie gai_duiti');
}
function chkform(){

	var oldpassword = $("#oldpassword").val();
	var password = $("#password").val();
	var passwordtrue = $("#passwordtrue").val();
	chkoldpwd(oldpassword,true);
	password2(password);
	truepassword(passwordtrue);
	// alert(old+":"+newpassword+":"+newpasswordtrue);
	if(!(old && newpassword && newpasswordtrue)){
		return false;
	}
	pwdchagne(oldpassword,password);
	return false;
}

function pwdchagne(oldpassword,password){
	$.post("<?=geturl('pass/updatepassAjax')?>",{oldpassword:oldpassword,password:password},
	function(result){
		if(result>0){
			$.showmessage({
				message:'密码修改成功！',
				callback :function(){
	             	var url = '/';
					//$.loginDialog(url);
					location.href=url;
            	}
        	});
		}else{
			$.showmessage({
				message:'密码修改失败！',
				callback :function(){
	               // location.reload(true);
            	}
        	});
		}
	});
}

// ========密码强弱检测=======
function CharMode(ch){
   if (ch>=48 && ch <=57) //数字   
    return 1;   
   if (ch>=65 && ch <=90) //大写字母   
    return 2;   
   if (ch>=97 && ch <=122) //小写   
    return 4;   
   else   
    return 8; //特殊字符 
}
function bitTotal(num){
   var modes=0;   
   for (i=0;i<4;i++){ 
    if (num & 1) modes++;   
    num>>>=1;   
   }   
   return modes;
}
function checkStrong(pwd){ //返回密码的强度级别 
   if(pwd.length < 6)
    return 0;
   var Modes=0;   
   for (i=0;i<pwd.length;i++){   
    //测试每一个字符的类别并统计一共有多少种模式. 
    Modes |= CharMode(pwd.charCodeAt(i)); 
   }   
   return bitTotal(Modes); 
}

function pwStrength(pwd){
	var level = 0;
	var color = '';
	var leveltip = '弱';
	switch(checkStrong(pwd)){
		case 0:level=25;leveltip='弱';color='#f0e54b';break;
		case 1:level=50;leveltip='一般';color='#1e91ce';break;
		case 2:level=75;leveltip='很好';color='#0000FF';break;
		case 3:level=100;leveltip='极好';color='#ff0000';break;
	}
	$("#level").css({width:level+'%',background:color}); 
	$("#leveltip").html(leveltip);
}
// ============
</script>
</div>
</div>
<div class="clear"></div>
