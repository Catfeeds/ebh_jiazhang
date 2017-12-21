<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" style="background:#fff;">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title><?= $this->get_title() ?></title>
        <meta name="keywords" content="<?= $this->get_keywords() ?>" />
        <meta name="description" content="<?= $this->get_description() ?>" />
        <link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/base.css" />
        <link href="http://static.ebanhui.com/ebh/tpl/default/css/common.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/logmi.css" />
        <script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery.js"></script>
        <link href="http://static.ebanhui.com/ebh/tpl/default/css/home.css" rel="stylesheet" type="text/css" />
        <script language="javascript">
        <!--
        $(function(){
            $("#mod_login_close").click(function(){
                $("#mod_login_tip").fadeOut();
            });
            $(".lefad .toptu .biantu,.lefad .toptu .maitu,.lefad .bottomtu .biantu,.lefad .bottomtu .maitu,.lefad .bottomtu .biantu2,.lefad .toptu,.lefad .bottomtu ").hover(function(){
                 $(this).addClass("hover-trigger");
                 $(this).siblings().stop().animate({opacity:'0.5'}, 1000);
            },
            function(){
                $(this).removeClass("hover-trigger ");
                $(this).siblings().stop().animate({opacity:'1'}, 1000);
            });
        });
        //错误提示
        function tipname_message(message,high){			
            if ($("#mod_login_tip").is(":visible")){
                $("#mod_login_tip").animate({"top":high}, " slow", "swing", function(){
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
		  
        function form_submit(){
			//清空之前错误提示
			$("#mod_login_tip").fadeOut();
            if ($('#username').val() == '' || $('#username').val () == '请输入e板会账号'){
                tipname_message('帐号不能为空',22);
                            //alert('用户名不能为空');
                $('#username').focus(); return;
            }
            if ($("#password").val () == ''){
                tipname_message('密码不能为空',60);
                $('#password').focus(); return;
            }
            var url = '<?= geturl('login').'?inajax=1&returnurl='.(($this->input->get('returnurl') == NULL) ? '' : urlencode($this->input->get('returnurl'))).'&type='.$this->input->get('type') ?>';
            $.ajax({
                url:url,
                data:$("#form1").serialize(),
                type:'POST',
                dataType:'json',
                success	:function(json){
                    if (json['code'] == 1){
						if(json['durl'] != undefined) {
							dosso(json['durl'],json["returnurl"]);
						} else {
							location.href = json["returnurl"];
						}
                    } else{
                        tipname_message(json["message"],22);
                    }
                    return false;
                }
            });
         }
		 function dosso(durl,returnurl,callback) {
			var img = new Image();
			img.src = durl;
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
         function AddFavorite(sURL, sTitle)
         {
            try
            {
                window.external.addFavorite(sURL, sTitle);
            }
            catch (e)
            {
                try
                {
                    window.sidebar.addPanel(sTitle, sURL, "");
                }
                catch (e)
                {
                    alert("加入收藏失败，请使用Ctrl+D进行添加");
                }
             }
        }
        function SetHome(obj, vrl){
        try{
            obj.style.behavior = 'url(#default#homepage)'; obj.setHomePage(vrl);
        }
        catch (e){
            if (window.netscape) {
                try {
                    netscape.security.PrivilegeManager.enablePrivilege("UniversalXPConnect");
                }
                catch (e) {
                    alert("此操作被浏览器拒绝！\n请在浏览器地址栏输入“about:config”并回车\n然后将 [signed.applets.codebase_principal_support]的值设置为'true',双击即可。");
                }
                var prefs = Components.classes['@mozilla.org/preferences-service;1'].getService(Components.interfaces.nsIPrefBranch);
                    prefs.setCharPref('browser.startup.homepage', vrl);
                }
            }
        }
        //-->
        </script>
    </head>

    <body style="background:#fff;">
        <div class="long"><a style="display: block;height:50px;width:325px;margin-top:20px;margin-left: 225px;" href="http://www.ebanhui.com"></a>
            <div class="main">
                <div class="lefad">
                    <div class="toptu">
                        <div class="maitu" style=" width:51px;">
                            <div class="biantu"><img src="http://static.ebanhui.com/ebh/tpl/2012/images/adtu09051.jpg" /></div>
                            <div class="biantu"><img src="http://static.ebanhui.com/ebh/tpl/2012/images/adtu09052.jpg" /></div>
                        </div>
                        <div class="biantu"><img src="http://static.ebanhui.com/ebh/tpl/2012/images/adtu09053.jpg" /></div>
                        <div class="maitu" style=" width:52px;">
                            <div class="biantu"><img src="http://static.ebanhui.com/ebh/tpl/2012/images/adtu09054.jpg" /></div>
                            <div class="biantu"><img src="http://static.ebanhui.com/ebh/tpl/2012/images/adtu09055.jpg" /></div>
                        </div>
                        <div class="biantu"><img src="http://static.ebanhui.com/ebh/tpl/2012/images/adtu09056.jpg" /></div>
                        <div class="biantu"><img src="http://static.ebanhui.com/ebh/tpl/2012/images/adtu09057.jpg" /></div>
                    </div>

                    <div class="bottomtu">
                        <div class="biantu"><img src="http://static.ebanhui.com/ebh/tpl/2012/images/adtu09058.jpg" /></div>
                        <div class="maitu" style="width:208px;">
                            <div class="biantu"><img src="http://static.ebanhui.com/ebh/tpl/2012/images/adtu09059.jpg" /></div>
                            <div class="biantu2" style="width:52px;">
                                <div class="biantu"><img src="http://static.ebanhui.com/ebh/tpl/2012/images/adtu090510.jpg" /></div>
                                <div class="biantu"><img src="http://static.ebanhui.com/ebh/tpl/2012/images/adtu090511.jpg" /></div>
                            </div>
                            <div class="biantu"><img src="http://static.ebanhui.com/ebh/tpl/2012/images/adtu090512.jpg" /></div>
                            <div class="biantu2" style="width:52px;">
                                <div class="biantu"><img src="http://static.ebanhui.com/ebh/tpl/2012/images/adtu090513.jpg" /></div>
                                <div class="biantu"><img src="http://static.ebanhui.com/ebh/tpl/2012/images/adtu090514.jpg" /></div>
                            </div>
                        </div>
                        <div class="maitu" style=" width:208px;">
                            <div class="biantu" style="margin-right:105px;"><img src="http://static.ebanhui.com/ebh/tpl/2012/images/adtu090515.jpg" /></div>
                            <div class="biantu"><img src="http://static.ebanhui.com/ebh/tpl/2012/images/adtu090516.jpg" /></div>
                            <div class="biantu2" style="width:104px;">
                                <div class="biantu"><img src="http://static.ebanhui.com/ebh/tpl/2012/images/adtu090517.jpg" /></div>
                                <div class="biantu"><img src="http://static.ebanhui.com/ebh/tpl/2012/images/adtu090518.jpg" /></div>
                                <div class="biantu"><img src="http://static.ebanhui.com/ebh/tpl/2012/images/adtu090519.jpg" /></div>
                            </div>
                        </div>
                    </div>
                </div>
<?php
$url = geturl('login') . '?inajax=1&returnurl=' . $this->input->get('returnurl');
?>
                <form id="form1" method="post" name="form1" action="<?= $url ?>" onsubmit="form_submit(); return false;">
                    <input type="hidden" name="loginsubmit" value="1" />
					<input type="hidden" name="sharp" value="<?=$sharp?>"/>
                    <div class="riglog" style="position: relative;">
                        <div class="shuse" style="margin-top:76px;">
                            <span>帐号：</span>
                            <input name="username" type="text" class="usbtn" id="username" tabindex="1"  title="请输入e板会账号" value="<?=!empty($un)?$un:'请输入e板会账号'?>" onfocus="if ($('#username').val() == '请输入e板会账号'){$('#username').val('').css('color', '#000000'); }" onblur="if ($('#username').val() == ''){$('#username').val('请输入e板会账号').css('color', '#C3C3C3'); }"/>
                        </div>
                        <div class="shuse">
                            <span>密码：</span>
                            <input name="password" type="password" class="usbtn" id="password" tabindex="2" style="color:#000000;" value="" />
                            <span><a href="<?= geturl('forget')?>">忘记密码？</a></span>
                        </div>
                        <div class="logwar"><input id="loginsubmit" value="" type="submit" class="logbtn"></div>
                        <p class="papre">没有e板会账号？  <a href="<?=geturl('register')?>" style="color:#2b8bd9;">立即注册</a></p>
                        <div class="qtlol" style="width:336px;">
                            <span style="color:#999;height: 20px;line-height: 20px;">用其他账号登录：</span>
                            <a href="<?=geturl('otherlogin/qq')?>" style="width:auto;display: block;line-height: 20px;text-decoration: none;cursor: pointer;">
                                <img src="http://static.ebanhui.com/ebh/tpl/2012/images/qqico0925.jpg" style="float:left;"/>
                                <span style="color:#999;float:left;">QQ登录</span>
                            </a>
                            <a href="<?=geturl('otherlogin/sina')?>" style="width:auto;display: block;line-height: 20px;text-decoration: none;cursor: pointer;">
                                <img src="http://static.ebanhui.com/ebh/tpl/2012/images/sianico0925.jpg" style="float:left;"/>
                                <span style="color:#999;float:left;">新浪微博登录</span>
                            </a>
                        </div>
						<div id="mod_login_tip" class="errorLayer" style="visibility: visible; position: absolute; left: 70px; z-index: 1010; display:none;">
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
        </div>
        <div class="foot">
            <p>
<?php
$count = 1;
foreach ($catlist as $ckey => $cat) {
    $catid = $cat['catid'];
    $count ++;
    $itemurl = empty($cat['caturl']) ? $cat['code'] : $cat['caturl'];
    $curl = geturl($itemurl, FALSE);
    if ($ckey > 0) {
        ?>
                        |
                        <?php
                    }
                    ?>
                    <a href="<?= $curl ?>" title="<?= $cat['name'] ?>"><?= $cat['name'] ?></a> 
                    <?
                    }
                    ?>
                </p>
                <P><a href="http://www.miibeian.gov.cn/" style="color: #B6B6B6;" target="_blank">  浙ICP备11027462号</a> Copyright &copy; 2011-2014 ebh.net All Rights Reserved </P>
    <?php
    debug_info();
    ?>
        </div>
        </div>

    </body>
</html>