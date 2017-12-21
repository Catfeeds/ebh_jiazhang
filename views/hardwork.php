<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link type="text/css" rel="stylesheet" href="http://static.ebanhui.com/jiazhang/css/jzxiang.css" />
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/common.js"></script>
<link type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/jquery-ui/css/default/jquery-ui-1.8.1.custom.css" rel="stylesheet" />	
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/jquery-ui/jquery-ui-1.8.1.custom.min.js"></script>
<script language="JavaScript" src="http://static.ebanhui.com/ebh/js/AnalysisCharts/JSClass/FusionCharts.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/date/WdatePicker.js"></script>

<script>
function changeday(daystate){
	var dayparam = '';
	if(daystate==5){
		var dayfrom = $('#dfrom').val();
		var dayto = $('#dto').val();
		dayparam = '&dayfrom='+dayfrom+'&dayto='+dayto;
	}
	var url = '/hardwork.html?daystate='+daystate+dayparam;
	location.href = url;
}
function showother(index){
	if($('#subchart'+index).css('display') == 'none'){
		$('#subchart'+index).css('display','block');
		$('#expand'+index).removeClass('lightlanbtn');
		$('#expand'+index).addClass('darklanbtn');
		var showindex = Math.min(($('.subchart').height()-50)/355,index);
		parent.$('body,html').animate({scrollTop: 663+50+355*(showindex-1)}, 500);
	}else{
		$('#subchart'+index).css('display','none');
		$('#expand'+index).removeClass('darklanbtn');
		$('#expand'+index).addClass('lightlanbtn');
	}
//	parent.resetmain();
}
</script>
<title>勤奋度表</title>
</head>

<body>

<div class="mainst">
<div class="ter_tit"> 当前位置 > 勤奋度表 </div>
<div class="lefrig" style="background:#fff;border:solid 1px #cdcdcd;">
<div class="annotate" style="height:30px;">
<span class="lemare">日期：</span>
<a style="cursor:pointer" onclick="changeday(1)" class="<?=$daystate==1?'darklanbtn':'lightlanbtn'?>">今 天</a>
<a style="cursor:pointer" onclick="changeday(2)" class="<?=$daystate==2?'darklanbtn':'lightlanbtn'?>">昨 天</a>
<a style="cursor:pointer" onclick="changeday(3)" class="<?=$daystate==3?'darklanbtn':'lightlanbtn'?>">本 周</a>
<a style="cursor:pointer" onclick="changeday(4)" class="<?=$daystate==4?'darklanbtn':'lightlanbtn'?>">本 月</a>
<a style="cursor:pointer" onclick="changeday(0)" class="<?=$daystate==0?'darklanbtn':'lightlanbtn'?>">全 部</a>
<span class="lemare">从&nbsp;</span>
<input class="calendar" id="dfrom" type="text" value="<?=empty($dayfrom)?'':$dayfrom?>" onclick="WdatePicker()" readonly="readonly"/>
<span class="lemare">&nbsp;至&nbsp;</span>
<input class="calendar" id="dto" type="text" value="<?=empty($dayto)?'':$dayto?>" onclick="WdatePicker()" readonly="readonly"/>
<a style="cursor:pointer;margin-left:10px;margin-right:0px;" onclick="changeday(5)" class="lightlanbtn">确 定</a>
</div>
<div class="analysis">
<div class="biaoxian">
<img class="futu" src="http://static.ebanhui.com/ebh/tpl/default/images/dalefico.jpg" />
<?php if(!empty($myclass)){?>
<span class="tongping">这段时间里，你的勤奋度情况</span><img style="float:left;margin-top:5px;" src="http://static.ebanhui.com/ebh/tpl/default/images/<?=$judgement['img']?>.jpg" />
<?php }?>
</div>
<?php $daydescription = array('从所有数据来看','今天1天内','昨天1天内','本周内','本月内','所选的这段时间内');?>
<?php if(!empty($myclass)){?>
<div class="lefping">
<p class="tixiang"><?=$daydescription[$daystate]?>，您的勤奋度表现<?=$judgement['des']?></p>
<p class="tixiang">与同班同学比，位于 <?=$judgement['level']?> 水平</p>
<p class="tixiang"></p>
</div>
<?php }?>
<div class="rigping">
<p class="tixiang"><?=$daydescription[$daystate].','?>您总共完成了 <?=$myexamcount?>  次作业,听课<?=$mystudycount?>次.</p>
<?php if(!empty($myclass)){?>
<p class="tixiang">同班同学总共完成了 <?=$classexamcount?> 次作业,听课<?=$classstudycount?>次.</p>
<?php }?>
<p class="tixiang">全校同学总共完成了 <?=$allexamcount?> 次作业,听课<?=$allstudycount?>次.</p>
</div>
</div>
<?php
if(!empty($dataarr['datas']['我的'])){
?>
<div class="fenxitu" style="position:relative;">
<h2 class="tittu">(以下图表中,全校同学与同班同学的数值为平均值)</h2>
<div style="position:absolute;top:150px;left:18px;font-size:14px;width:15px;font-weight:bold;">勤奋指数</div>

<div class="charts">
<?php
$chart->chart($dataarr,'Pie2D');?>
	
	<div style="width:740px;height:50px;">
		<a id="expand1" style="cursor:pointer;width:70px" class="lightlanbtn" onclick="showother(1)">作业分析图</a>
		<a id="expand2" style="cursor:pointer;width:70px" class="lightlanbtn" onclick="showother(2)">听课分析图</a>
	</div>
	
	<div class="subchart">
		<div id="subchart1" style="display:none">
		<?php $chart->chart($dataarrexam,'Column3D','chartask');?>
		</div>
		
		<div id="subchart2" style="display:none">
		<?php $chart->chart($dataarrstudy,'Column3D','chartanswer');?>
		</div>

	</div>
</div>
<?php
}else{
?>
<center>数据不足,不提供图表.</center>
<?php
}
?>
</div>
</div>
</div>
<div class="clear"></div>
