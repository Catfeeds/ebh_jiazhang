<?php $this->display('common/room_header');?>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/css/statch.css" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen">
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery.cookie.js"></script>
<style>
.qianming .qianmings{
	background: none;
}
.esukang .jzhome{
  background: #fff url(http://static.ebanhui.com/jiazhang/images/jz_shou.jpg?v=1) no-repeat center center;
  color: #777;
}
.esukang .jzxueji{
  background: #fff url(http://static.ebanhui.com/jiazhang/images/jz_xueji.jpg?v=1) no-repeat center center;
  color: #777;
}
.esukang .jzlishizuo{
  background: #fff url(http://static.ebanhui.com/jiazhang/images/jz_lishizuo.jpg?v=1) no-repeat center center;
  color: #777;
}
.esukang .jzdayi{
  background: #fff url(http://static.ebanhui.com/jiazhang/images/jz_dayi.jpg?v=1) no-repeat center center;
  color: #777;
}
.esukang .jzping{
  background: #fff url(http://static.ebanhui.com/jiazhang/images/jz_ping.jpg?v=1) no-repeat center center;
  color: #777;
}
.esukang .jzjilv{
  background: #fff url(http://static.ebanhui.com/jiazhang/images/jz_jilv.jpg?v=1) no-repeat center center;
  color: #777;
}
.esukang .jzshemi{
  background: #fff url(http://static.ebanhui.com/jiazhang/images/jz_shemi.jpg?v=1) no-repeat center center;
  color: #777;
}
.cmain_top_r .esukang a {
	text-shadow: 1px -1px 0 #e3e3e3;
	display: inline-block;
	height: 28px;
	margin-left: 7px;
	margin-right: 7px;
	position: relative; 
	width: 86px;
	font-size:15px;
	text-align:center;
	padding-top:72px;
	font-family:微软雅黑;
	}
.cmain_top_r .esukang a:hover{
	height:27px;
	width:84px;
	padding-top:71px;
}
</style>

<div class="wrap">
	<div class="titles fl">
        <span class="spans"><?=$room['crname']?>    (  家长监控平台  )</span>
    </div>
	<div class="cmain">
    	<div class="cmain_top mt10">
        	<div class="cmain_top_l fl">
            	<div class="xiutgt fr mt10"><a class="cla" href="javascript:void(0)" target="mainFrame"><span style="padding-left:15px;color:#fff;"><?=$clinfo['title']?></span></a></div>
                <div class="clear"></div>
				<?php 
					if($user['sex'] == 1)
						$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/m_woman.jpg';
					else
						$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/m_man.jpg';
						$face = empty($user['face']) ? $defaulturl:$user['face'];
						$face = str_replace('.jpg','_78_78.jpg',$face);
				?>
                <div class="gerenxinxi">
                	<div class="touxiang fl"><a href="javascript:void(0)" target="mainFrame"><img src="<?=$face?>" height="78" width="78" /></a></div>
                    <div class="rigpxiang ml10 fl">
                    	<div class="mt5">
                        	<p class="name fl"><?=shortstr($user['realname'],6,'')?></p>
                            <p class="jifen fl"><a href="javascript:void(0)" target="mainFrame"><?=$user['credit']?></a></p>
                        </div>
                        <div class="clear"></div>
                        <div class="ejiants">
                        	<!-- <p class="gerenxx"><a href="javascript:void(0)" target="mainFrame">个人信息</a></p> -->
							<div style="height:26px;">&nbsp;</div>
							<div>
                            	<div class="kewate fl"><span class="jifenico" style="width:<?=$percent?>%"></span></div>
								<div class="fl" ><span style=" line-height:10px; color: #999;font-family: Arial; padding-left:5px;"><?=$percent?>%</span></div>
                            </div>
						</div>
                    </div>
                </div>
                <div class="clear"></div>
                <div class="qianming"><p class="qianmings" style="width:230px; text-align:left;"><span id="mysign_span" style="display:block;width:235px;cursor:text; text-align:left;color:#666;" title="<?=empty($user['mysign']) ? '点击修改签名' : $user['mysign']?>"><?=empty($user['mysign']) ? '暂无签名' : shortstr($user['mysign'])?></span>
                            <input type="text" maxlength="140" id="mysign" style="display:none;width:195px;border:1px solid #9eb7cb;height:20px;line-height:20px;padding:0 5px;margin-top:5px;margin-bottom:1px "></p></div>
                	<div style="width:253px;height:20px;padding-left: 33px;margin-top: 6px;"><span style="font-family: '微软雅黑';font-size:16px;color:#666">学霸排名:<?=$clinfo['title']?></span></div>
            </div>
            <div class="cmain_top_r fr">
            	<div>
                    <div class="titles fl">
                        <span>Hello！<?=$user['realname']?>&nbsp;家长，欢迎使用e板会。</span>
                    </div>
					<?php if(!empty($signed)){
							$showsign[0] = ' style="display:none"';
							$showsign[1] = '';
						}else{
							$showsign[0] = '';
							$showsign[1] = ' style="display:none"';
						}
						$weekarr = array('日','一','二','三','四','五','六');
					?>
                	<div class="grkgee fr">
						<p class="dgrtwe"><span style="font-size:16px; display:block; height:25px;"><?=Date('Y-m-d',SYSTIME)?></span><span class="dates"><?=Date('d',SYSTIME)?></span>&nbsp;星期<?=$weekarr[Date('w',SYSTIME)]?></p>
			<span id="creditplus" style="display:none;position:absolute;color:orange;right:57px;top:-2px;z-index:100">+1积分</span>
			<a href="javascript:void(0)" class="daotqian"  <?=$showsign[0]?>>签到<br><span style="font-size:14px; line-height:5px; *line-height:12px;"><?=$continuous?>天</span></a>
			<p class="daotqian2" <?=$showsign[1]?> title="已经连续签到<?=$continuous?>天" day="<?=$continuous?>">已签到<br><span style="font-size:14px; line-height:5px;*line-height:12px;" class="afsign"><?=$continuous?>天</span></p>
					</div>
                </div>
                <div class="clear"></div>
                <div class="esukang">
                	<a class="jzhome fl frnew" href="/ghrecord/home.html" target="mainFrame">主页</a>
					<a class="jzxueji fl frold" href="/study.html" target="mainFrame" id="course">学习记录</a>
					<a class="jzlishizuo fl frold" href="/myexam/all.html" target="mainFrame" id="course">历史作业</a>
					<a class="jzdayi fl frold" href="/myask/all.html" target="mainFrame" id="course">答疑</a>
					<a class="jzping fl frold" href="/review/student.html" target="mainFrame" id="course">评论</a>
					<a class="jzjilv fl frold" href="/ghrecord.html" target="mainFrame" id="course">成长记录</a>
					<a class="jzshemi fl frold" href="/pass.html" target="mainFrame" id="course">设置密码</a>
				</div>
            </div>
        </div>
        <div class="clear"></div>

		<?php $idefurl = "/ghrecord/home.html";
			if(!empty($url)){
				$idefurl = $url;
			}
		?>
		<iframe onload="resetmain()" id="mainFrame" name="mainFrame" scrolling="no" width="100%" height="1000px" frameborder="0" src="<?=$idefurl?>" style="margin-top:10px;"></iframe>
    </div>
</div>
<script>

var resetmain = function(){
	var mainFrame = document.getElementById("mainFrame");
	var iframeHeight = Math.min(mainFrame.contentWindow.window.document.documentElement.scrollHeight, mainFrame.contentWindow.window.document.body.scrollHeight)+1;
	iframeHeight = iframeHeight<700?700:iframeHeight;
	$(mainFrame).height(iframeHeight);$(mainFrame).width(1002);
}

var Func = function(name,func){
	if(typeof func != "undefined"){
		window[name] = func;
		return Func;
	}else{
		return window[name];
	}
}

$('.xxuexi').click(function(){
	$("#course").children().remove();
});
$('.zzuoye').click(function(){
	$("#exam").children().remove();
});
$('.kkaoshi').click(function(){
	$("#paper").children().remove();
});
$('.ttiwen').click(function(){
	$("#ask").children().remove();
});

var notitleA = true;
</script>

<?php if(empty($nophoto) && ($room['isschool'] == 3 || $room['isschool'] == 6 || $room['isschool'] == 7)) { ?>
	<style type="text/css">
.waigmes {
	width:355px;
	height:190px;
	background-color:gray;
	opacity: .80;
	filter:Alpha(Opacity=80);
	border-radius:10px;
}
.nelames {
	width:335px;
	height:170px;
	background-color:#FFFFFF;
	margin:10px;
	float:left;
	display:inline;
}
.nelames .leficoss {
	width:135px;
	height:128px;
	float:left;
	margin:10px 0 0 10px;
}
.nelames .rigsizes{
	width:170px;
	float:left;
	margin-top:10px;
}
.rigsizes .tishitits {
	font-size:14px;
	color:#212121;
	font-weight:bold;
	line-height:22px;
}
.rigsizes .phuilin {
	line-height:1.8;
	color:#6f6f6f;
}
.czxy input {
    vertical-align: middle;
}
.toptites {
	background:url(http://static.ebanhui.com/ebh/tpl/default/images/titbgt.jpg) repeat-x;
	height:28px;
	line-height:28px;
	font-size:14px;
	font-weight:bold;
	padding-left:5px;
	position:relative;
	width:330px;
	color:#212121;
}
.toptites a.guanbtn {
	background:url(http://static.ebanhui.com/ebh/tpl/default/images/guanbibtn.jpg) no-repeat;
	display:block;
	width:24px;
	height:24px;
	right:2px;
	top:2px;
	position:absolute;
}
.rigsizes a.chuanicobtn {
	display:block;
	width:152px;
	color:#212121;
	height:30px;
	line-height:30px;
	background:url(http://static.ebanhui.com/ebh/tpl/default/images/chuanbtnbg.jpg) repeat-x;
	font-size:14px;
	text-align:center;
	text-decoration:none;
}
</style>

<?php
	if($user['sex'] == 1)
		$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/m_woman.jpg';
	else
		$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/m_man.jpg';

?>
<?php } ?>

<script type="text/javascript">
$(function(){
	var url = '<?= geturl('myroom/userstate')?>';
	var type =[1,2,4,7];

	var folderids = '<?=empty($folderids)?'':$folderids?>';
	$.ajax({
		type:'POST',
		url:url,
		data:{"type":type,'folderids':folderids},
			dataType:"json",
			success:function(data) {
				if(data != undefined && data[1] != undefined && data[1] > 0) {
					var examcount = data[1] > 99 ? 99 : data[1];
					$("#exam").append("<span>" + examcount + "</span>");
				}
				if(data != undefined && data[2] != undefined && data[2] > 0) {
					var askcount = data[2] > 99 ? 99 : data[2];
					$("#course").append("<span>" + askcount + "</span>");
				}
				if(data != undefined && data[4] != undefined && data[4] > 0) {
					var askcount = data[4] > 99 ? 99 : data[4];
					$("#ask").append("<span>" + askcount + "</span>");
				}
				if(data != undefined && data[7] != undefined && data[7] > 0) {
					var examcount = data[7] > 99 ? 99 : data[7];
					$("#paper").append("<span>" + examcount + "</span>");
				}
			}
	});

});
</script>
<div class="foot">
<P style="color: #666666"><a href="http://www.miibeian.gov.cn/" style="color: #666666;" target="_blank">  浙ICP备11027462号</a> Copyright &copy; <?= '2011-'.date('Y') ?> ebh.net All Rights Reserved </P></div>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/table.js"></script>
</body>
</html>
