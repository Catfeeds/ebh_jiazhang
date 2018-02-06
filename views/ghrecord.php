<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
<link type="text/css" rel="stylesheet" href="http://static.ebanhui.com/jiazhang/css/jzxiang.css" />
<link type="text/css" rel="stylesheet" href="http://static.ebanhui.com/ebh/tpl/default/css/wangind.css?v=0525" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/myind.css?v=0520" />
<link href="http://static.ebanhui.com/ebh/tpl/2014/css/dichrt.css" type="text/css" rel="stylesheet">

<style>
.sktdsw{ width:82px;}
.kesdtgs{ width:998px;}
.rtkege{width:945px;}
.rekyjger{width:945px;}
.rgkerg{width:840px;}
.kszhtg{width:998px;}
.dyghwr{ margin-right:50px;}
.ryhrt{ margin-left:50px;}
.freyhd{ width:998px;}
.oetute{ width:785px;}
.sktdsw{
	border-right: dotted 1px #ddd;
}
</style>
<title>成长记录</title>
</head>
<body>
<script src="http://static.ebanhui.com/ebh/js/Highcharts/js/highcharts.js"></script>
<script src="http://static.ebanhui.com/ebh/js/Highcharts/js/modules/data.js"></script>
<script src="http://static.ebanhui.com/ebh/js/date/WdatePicker.js"></script>
<div class="mainst">
<div class="lsrey" style="width:1000px;">
<span class="kdtgds" style="width:230px;"><?=!empty($user['realname']) ? $user['realname'] : $user['username']?></span>
<div class="hrthd" style="width:998px;">
<ul>
<li class="sktdsw">
<p style="font-size:14px;">积分</p>
<p class="zhonsr"><?=$baseinfo['credit']?></p>
</li>
<li class="sktdsw">
<p style="font-size:14px;">签到</p>
<p class="zhonsr"><?=$baseinfo['signlogcount']?></p>
</li>
<li class="sktdsw">
<p style="font-size:14px;">学习</p>
<p class="zhonsr"><?=$baseinfo['mystudycount']?></p>
</li>
<li class="sktdsw">
<p style="font-size:14px;">作业</p>
<p class="zhonsr"><?=$baseinfo['myexamcount']?>/<?=$baseinfo['myallexamcount']?></p>
</li>
<li class="sktdsw">
<p style="font-size:14px;">提问</p>
<p class="zhonsr"><?=$baseinfo['myaskcount']?></p>
</li>
<li class="sktdsw">
<p style="font-size:14px;">答疑</p>
<p class="zhonsr"><?=$baseinfo['myanscount']?></p>
</li>
<li class="sktdsw">
<p style="font-size:14px;">评论</p>
<p class="zhonsr"><?=$baseinfo['myreviewcount']?></p>
</li>
<li class="sktdsw">
<p style="font-size:14px;">感谢</p>
<p class="zhonsr"><?=$baseinfo['mythankcount']?></p>
</li>
<li class="sktdsw">
<p style="font-size:14px;">新鲜事</p>
<p class="zhonsr"><?=$baseinfo['myfeedscount']?></p>
</li>
<li class="sktdsw">
<p style="font-size:14px;">日志</p>
<p class="zhonsr"><?=$baseinfo['myarticlescount']?></p>
</li>
<li class="sktdsw">
<p style="font-size:14px;">粉丝</p>
<p class="zhonsr"><?=$baseinfo['myfanscount']?></p>
</li>
<li class="sktdsw" style="border:none;">
<p style="font-size:14px;">关注</p>
<p class="zhonsr"><?=$baseinfo['myfavoritcount']?></p>
</li>
</ul>
</div>
</div>
<div class="kesdtgs">
<h2 class="grthb">成长记录</h2>
<div class="rtkege">
	<div class="rekyjger">
		<div class="xiutgt" style="left:<?=630*$clinfo['percent']/100-7?>px"><?=$clinfo['title']?> <?=$user['credit']?></div>
		<span class="kehgd">书童<br />0</span>
		<div class="rgkerg"><span class="gregdf" style="width:<?=$clinfo['percent']?>%;"></span></div>
		<span class="kehgd">文曲星<br />10000</span>
	</div>
	<div class="retykgd">
		<input name="" id="dayfrom" style="cursor:pointer" class="grjrlqt" type="text" readonly="readonly" value="<?=Date('Y-m-d',SYSTIME-86400*30)?>" onclick="WdatePicker({onpicking:getcreditstat,dateFmt:'yyyy-MM-dd',minDate:'<?=Date('Y-m-d',SYSTIME-86400*30)?>',maxDate:'#F{$dp.$D(\'dayto\',{d:-1})||\'<?=Date('Y-m-d',SYSTIME-86400*2)?>\'}'});"/>
		<span class="etgregd">至</span>
		<input name="" id="dayto" style="cursor:pointer" class="grjrlqt" type="text" readonly="readonly" value="<?=Date('Y-m-d',SYSTIME-86400)?>" onclick="WdatePicker({onpicking:getcreditstat,dateFmt:'yyyy-MM-dd',minDate:'#F{$dp.$D(\'dayfrom\',{d:1})||\'<?=Date('Y-m-d',SYSTIME-86400*29)?>\'}',maxDate:'<?=Date('Y-m-d',SYSTIME-86400)?>'});"/>
		<div class="wegkw"><span class="mydes"></span><span class="flost">我的</span>
		<span class="xiaodes"></span><span class="flost">全校平均</span><span class="xiaogao"></span><span class="flost">全校最高</span></div>
	</div>
	<div id="chartcontainer" class="chartcontainer" style="height: 198px;"></div>
	
</div>
</div>
<div class="kszhtg">
<div class="dyghwr">
<div class="gksdteg"><?=!empty($user['realname'])?$user['realname']:$user['username']?>的成长</div>
<div class="dkttrw">
<div class="kstuye"></div>
<?php if(count($mycreditlist) >1){ ?>
<?php for($i=0;$i<count($mycreditlist) -1;$i++){ ?>
<div class="stgydt"></div>
<?php } ?>
<?php } ?>
</div>

<?php foreach($mycreditlist as $kk=>$credit){ ?>
<?php
$description = str_replace('[w]','<span style="color:#da7932">'.shortstr($credit['detail'],40,'...').'</span>',$credit['description']);
$description .= ' '.'<span class="shocolo">'.$credit['action'].$credit['credit'].'</span> 积分';
?>
<div class="kldstg" <? if($kk == 0){ ?> style="margin-top:33px;"<? } ?>>
<span class="thrhr"><?=timetostr($credit['dateline'])?></span>
<p class="stgjudy"><?=$description?></span></p>
</div>
<?php } ?>

</div>
<div class="ryhrt">
<div class="gksdteg">同学们的成长</div>
<?php if(!empty($othercreditlist)){ ?>
<div class="sktgry kstgve">
<?php foreach ($othercreditlist as $othercredit){ ?>
<span class="sktget"><?=timetostr($othercredit['dateline'])?></span>
<?php } ?>
</div>
<?php } ?>

<?php foreach ($othercreditlist as $oo=> $othercredit){ ?>
<?php
$description = str_replace('[w]','<span style="color:#da7932">'.shortstr($othercredit['detail'],40,'...').'</span>',$othercredit['description']);
$description .= ' '.'<span class="shocolo">'.$othercredit['action'].$othercredit['credit'].'</span> 积分';
?>
<div class="kstjet" <?if($oo == 0){?> style="margin-top:23px;"<? } ?>>
<p class="stgjudys">
<span href="javascript:void(0);" target="_blank" class="adtydr"><img class="stgfw" src="<?=getavater($othercredit,'40_40')?>" title="<?= empty($othercredit['realname'])?$othercredit['username']:$othercredit['realname'] ?>"/></span>
<?=!empty($othercredit['realname']) ? $othercredit['realname'] : $othercredit['username']?><?=$description?></p>
</div>
<?php } ?>

</div>
</div>
<div class="freyhd">
<h2 class="edtkgd">学霸排名</h2>
<div class="oetute">
<?php if(!empty($ranklist)){ ?>
<ul id="ranklist">
<?php foreach ($ranklist as $rank){ ?>
<li class="dtuwrs">
<span  target="_blank" class="destgy">
<span class="egirey"><?=!empty($rank['realname']) ? $rank['realname'] : $rank['username'] ?></span>
<img src="<?=getavater($rank,'50_50')?>" title="<?= empty($rank['realname'])?$rank['username']:$rank['realname'] ?>" />
</span>
<span class="srusdyt"><?=$rank['credit']?></span>
<span class="srusdyt"><?=$rank['ranktit']?></span>
</li>
<?php } ?>
</ul>
<?php }else{ ?>
<ul>
<li style="margin-top:300px;text-align:center">暂无数据</li>
</ul>
<?php } ?>
<div class="dygry">
<?=$pagestr?>
</div>
</div>
<div class="etbhns">
<div class="olreyg">
科举统计
</div>
<div class="lskgrr">
<span>书童</span>
<span class="dytgdt">0-20</span>
<span>书生</span>
<span class="dytgdt">21-50</span>
<span>秀才</span>
<span class="dytgdt">51-100</span>
<span>举人</span>
<span class="dytgdt">101-150</span>
<span>解元</span>
<span class="dytgdt">151-200</span>
<span>贡士</span>
<span class="dytgdt">201-300</span>
<span>会元</span>
<span class="dytgdt">301-400</span>
<span>同进士</span>
<span class="dytgdt">401-500</span>
<span>进士</span>
<span class="dytgdt">501-600</span>
<span>探花</span>
<span class="dytgdt">601-700</span>
<span>榜眼</span>
<span class="dytgdt">701-800</span>
<span>状元</span>
<span class="dytgdt">801-900</span>
<span>编修</span>
<span class="dytgdt">901-1000</span>
<span>府丞</span>
<span class="dytgdt">1001-1500</span>
<span>翰林学士</span>
<span class="dytgdt">1501-2000</span>
<span>御史中丞</span>
<span class="dytgdt">2001-3000</span>
<span>詹士</span>
<span class="dytgdt">3001-4000</span>
<span>侍郎</span>
<span class="dytgdt">4001-5000</span>
<span>大学士</span>
<span class="dytgdt">5001-9999</span>
<span>文曲星</span>
<span class="dytgdt">10000以上</span>
</div>
</div>
</div>
<script language="javascript">
//ajax获取分页数据
$(document).on('click', ".listPage a[class!='none']", function() {
    window.parent.layer.load();
	var tmparr = $(this).attr('data').split('-');
	var page = tmparr[1];
	$.post('/ghrecord/getrankajax.html?r='+Math.random(),{'page':page},function(data){
		$('#ranklist').html(data.rankliststr)
		$('.dygry').html(data.pagestr);
		window.parent.layer.closeAll();
	},'json');
});
getcreditstat();
function getcreditstat(dp){
	if(dp){
		if(dp.srcEl.id=='dayfrom'){
			dayfromobj = dp.cal.newdate;
			var dayfrom = dayfromobj.y+'-'+dayfromobj.M+'-'+dayfromobj.d;
			var dayto = $('#dayto').val();
			if(!dayto)
				return;
		}else{
			daytoobj = dp.cal.newdate;
			var dayfrom = $('#dayfrom').val();
			var dayto = daytoobj.y+'-'+daytoobj.M+'-'+daytoobj.d;
			if(!dayfrom)
				return;
		}
		
	}
	else{
		var dayfrom = $('#dayfrom').val();
		var dayto = $('#dayto').val();
	}
	$.getJSON('/ghrecord/creditStat.html?dayfrom='+dayfrom+'&dayto='+dayto+'&rnd='+Math.random(), function (csv) {
	    $('#chartcontainer').highcharts({
	        data: {
	            csv: csv
	        },

	        credits:{
				enabled:false 
			},
			navigation: {
				buttonOptions: {
					enabled: false
				}
			}
	        ,
			title: {
				text: null
			},
			legend: {
				enabled: false
			},
			yAxis: {
				floor: -1,
				allowDecimals: false,
				
				title: {
					text: null
				}
			},
			xAxis: {
				labels: {
					x:-5,
					step:2,
					formatter: function() {
						return  Highcharts.dateFormat('%m-%d', this.value);
					}
				}
			},
			tooltip: {
				dateTimeLabelFormats:{
					day:"%A, %m-%e"
				}
				
			},
			colors:['#aed1f4','#f5d86a','#87c502'],
			plotOptions: {
	                series: {
	                    marker: {
	                        radius: 2,  
	                        symbol: 'diamond'
	                    }
	                }
	            }
		});
	});
}
//分页样式
    $('.listPage a').css({'cursor':'pointer'})
</script>
