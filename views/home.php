<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" />
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
.hrthd{
	border: none;
}
.lsrey{
	height: 50px;
}
.grthb {
	width: 970px;
	margin:0px auto 8px;
	text-align: left;
	color: #666;
	border-bottom: 1px solid #d3d3d3;
	padding:10px 0 8px 1px;
	line-height: 19px;
	position: relative;
}
.grthb a.luist {
	position: absolute;
	top:12px;
	right:0px;
}
.brftg{
	width:484px;
}
.lanyuan {
  background: url(http://static.ebanhui.com/ebh/tpl/2014/images/yustu.jpg) no-repeat 0 center;
  display: inline;
  font-size: 14px;
  float: left;
  height: 14px;
  line-height: 14px;
  margin: 5px 0px;
  padding-left: 15px;
  color: #666;
}
.luist{
	float:right;
	width: 100px;
}
a:hover{
	text-decoration: none;
}
</style>
<title>成长记录</title>
</head>
<body>
<script src="http://static.ebanhui.com/ebh/js/Highcharts/js/highcharts.js"></script>
<script src="http://static.ebanhui.com/ebh/js/Highcharts/js/modules/data.js"></script>
<script src="http://static.ebanhui.com/ebh/js/date/WdatePicker.js"></script>
<div class="mainst">
	<div class="kesdtgs" style="height:auto;margin-top:0;">
		<h2 class="grthb">通知<a class="luist" href="/notice.html">更多 &gt;&gt;</a></h2>
		<div style="width:1000px;float:left;">
			<div class="timike" style="width:970px;margin:0 auto 10px;">
				<?php if(!empty($notices)) { ?>
					<?php foreach($notices as $k=>$notice) {
							$borderstr = '';
							if($k==count($notices)-1) 
								$borderstr = 'border:none';
					?>
					<div class="brftg" style="margin:0;">
						<span class="lanyuan" style="width:450px;"><a target="_blank" href="/notice/<?= $notice['noticeid'] ?>.html"><?= shortstr($notice['title'],60)?></a></span>
						<span style="margin-left:15px;float:left;color:#888;"><?= date('Y-m-d H:i',$notice['dateline'])?> <?= $notice['type']==1?$notice['realname']:"学校"?></span>
					</div>
					<?php } ?>
				<?php }else{?>
					<div><span>暂无通知</span></div>
				<?} ?>	
			</div>
		</div>
	</div>



<div class="kesdtgs" style="height:420px;">
<h2 class="grthb">成长记录</h2>
<div class="lsrey" style="width:1000px;">
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
<a href="http://sns.ebh.net/<?=$othercredit['uid']?>/main.html" target="_blank" class="adtydr"><img class="stgfw" src="<?=getavater($othercredit,'40_40')?>" title="<?= empty($othercredit['realname'])?$othercredit['username']:$othercredit['realname'] ?>的个人空间"/></a>
<?=!empty($othercredit['realname']) ? $othercredit['realname'] : $othercredit['username']?><?=$description?></p>
</div>
<?php } ?>

</div>
</div>

<script language="javascript">
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
</script>
