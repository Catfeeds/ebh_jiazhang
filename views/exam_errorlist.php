<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta content="width=1000, user-scalable=no" name="viewport"/>
	<title>题库列表</title>
    <?php $v=getv();?>
	<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/exam/css/base.css<?=$v?>" />
	<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/troomv2/css/wussyu.css<?=$v?>" />
	<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css<?=$v?>">
    <link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/exam/css/done.css<?=$v?>" />
    <link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/exam/css/public.bak.css<?=$v?>" />
    <link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/exam/css/jqtransform.css<?=$v?>" />
    <link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/exam/css/wavplayer.css<?=$v?>" />
    <link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/js/dialog/css/dialog.css<?=$v?>" />
    <link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/exam/css/tikutop.css?v=20160412<?=$v?>" />
    
    <script src="http://static.ebanhui.com/exam/js/jquery/jquery-1.11.0.min.js<?=$v?>"></script>
	<script src="http://static.ebanhui.com/exam/js/jquery/jquery-migrate-1.2.1.js<?=$v?>"></script>
	<script type="text/javascript" src="http://static.ebanhui.com/exam/js/template/template-native-debug.js<?=$v?>"></script>
	<script src="http://static.ebanhui.com/ebh/js/Highcharts/js/highcharts.js<?=$v?>"></script>
	<script type="text/javascript" src="http://static.ebanhui.com/js/dialog/dialog-plus.js<?=$v?>"></script>
	<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/dtree/dtree.js<?=$v?>"></script>
	<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xquestion_for_multic.js<?=$v?>"></script>
	<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/common2.js<?=$v?>"></script>
	<style type="text/css">
	
.delabtn{background:url(http://exam.ebanhui.com/static/images/dela.png) no-repeat;width:79px;height:25px;float:right;cursor:pointer;margin-bottom:5px}
.delahbtn{background:url(http://exam.ebanhui.com/static/images/delah.png) no-repeat;width:79px;height:25px;float:right;cursor:pointer;margin-bottom:5px}

#errlist .que{clear:both;padding:5px 0 25px;height:auto;}
#errlist .que p.desc{font-size:12px;height:40px;line-height: 40px;color:#3a3a3a;display: inline-block;border:1px solid #f3f3f3;background: #f3f3f3;width: 983px; margin:0 5px;padding-left:5px;}
#errlist .que p.desc span{display: inline-block;margin-right: 25px;}
#errlist .que p.desc em{margin-right: 8px;}
.work_search ul li {display:inline-block;float: left;height:55px;line-height: 55px;}
#errlist .que .operateBar{display: none;}
#errlist .que .optionContent img{vertical-align: middle;}

#icategory {
    background:#fff;
    border-top: 1px solid #E1E7F5;
    padding: 6px 20px;
	_margin-bottom:-5px;
}
#icategory dt {
    float: left;
    line-height: 22px;
    padding-right: 5px;
    text-align: left;
	font-size:14px;
	color:#999;
}
#icategory dd {
    float: left;
    width: 885px;
}
.price_cont div a:hover, .price_cont div a.curr {
	background: none repeat scroll 0 0 #FF5400;
	color: #FFFFFF;
	text-decoration: none;
}
.category_cont1 div a.curr,.category_cont1 div a:hover{
	color:#5e96f5;
	color:#fff;
}
.category_cont1 div a {
    color: #333;
    text-decoration: none;
    padding: 2px 5px;
	font-size:14px;
}
.category_cont1 div a.curr , .category_cont1 div a:hover{
    color: #fff;
    text-decoration: none;
    padding: 2px 5px;
	font-size:14px;
	 background: #5e96f5 none repeat scroll 0 0;
}
.category_cont1 div {
    float: left;
    height: 25px;
    line-height: 22px;
    overflow: hidden;
	padding:0 10px;
}
.pbtns {
    background: url(http://static.ebanhui.com/ebh/tpl/2012/images/sunt0518.png) repeat scroll 0 0 transparent;
    border: medium none;
    color: #333333;
    height: 20px;
    vertical-align: middle;
    width: 40px;
	cursor:pointer;
}
html {
    background: none;
    color: #000;
}
.waitite{
	border-bottom:none;
	background:#fff;
}
.subjectPane {
    padding-left: 10px;
}
.lefrig{
}
a.chakan{
	color:#5e96f5;
}
.singleContainerFocused{
	border-top:none;
	margin: 0;
}
.radioPane li{
	width:100% !important;
}
#errlisttitle .que{clear:both;padding:5px 0 25px;height:auto;}
#errlisttitle .que p.desc{font-size:12px;height:40px;line-height: 40px;color:#3a3a3a;display: inline-block;border:1px solid #f3f3f3;background: #f3f3f3;width: 782px;}
#errlisttitle .que p.desc span{display: inline-block;margin-right: 25px;}
#errlisttitle .que p.desc em{margin-right: 8px;}

#errlisttitle .que .optionContent img{vertical-align: middle;}

.dtree {
    background: none repeat scroll 0 0 white;
    display: inline;
    float: left;
    height: 501px;
    overflow: auto;
    padding: 10px;
    width: 378px;
}
.answerBar, .userAnswerBar, .scoreBar, .linkBar, .textScoreBar, .textAnswerBar{
	padding: 2px 0 0 15px;
}
.work_menu{
	margin-top: 0px;
}
.diles{
	top: 12px;
}
.work_menu ul li{
	padding: 11px 0 0 0;
}
.work_menu ul li a{
	border-bottom: none!important;
}
#courseselecttit, #middleselecttitle, #mysecondselecttitle{
	height: 25px;
    width: 120px;
    display: block;
    overflow: hidden;
}
#mythirdselecttitle{
	overflow: hidden;
	display: block;
    height: 100%;
    width: 100%;
}
a:hover{text-decoration: none}

.typeHque{
	display: inline-block;
	max-width: 500px;
}

	</style>
</head>
<body>
<div class="lefrig">
	<div class="workol" id="errlisttitle" style="margin-top:0">
		<div class="work_menu" style="position:relative;">
			<ul>
				<li ><a href="<?= geturl('college/examv2') ?>"><span>待做的</span></a></li>
				<li><a href="<?= geturl('college/examv2') ?>?action=hasdo"><span>做过的</span></a></li>
				<!--<li><a href="<?= geturl('college/myexam/box') ?>"><span>草稿箱</span></a></li>-->
				<li class="workcurrent"><a style="border-bottom: none;" href="<?= geturl('college/examv2/myerrorbook') ?>"><span>错题本</span></a></li>
			</ul>
		<?php if(empty($folder)){?>
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
				<input type="button" onclick="searchs('txtname');return false;" class="soulico" value="">
			</div>
		<?php }?>

		</div>
		<div id="schoollayerWrap" style="z-index:999;width: 980px;height: 115px;margin:0 auto;">
			<?php $this->display('chapter_fragment')?>
		</div>

	</div>
	<div class="workol" id="errlist">
		
	</div>
	<div id="mpage" style="height:60px;clear:both; background: #fff;"></div>
</div>
<div class="clear"></div>
<script id="t:folder" type="text/html">
	<div>
		<a href="javascript:void(0)" tid="<%=tid%>" onclick="getErrorList($(this).attr('tid'))"><%=foldername%></a>
	</div>
</script>

<script id="t:que" type="text/html">
	<%if(queType == 'A'){%>
		<div class="que singleContainer singleContainerFocused" qsval="<%=i + 1%>" id="que">
		<p class="desc"><span><em>作业名称:</em><strong title="<%=esubject%>"><%=sesubject%></strong></span><span><em>添加时间:</em><strong><%=dateline%></strong></span><span><em>试题类型:</em><strong>单选</strong></span><span><em>错误数:</em><strong style="color:#f85c72;"><%=errorCount%></strong></span></p>
		<div class="subjectPane">
			<span class="stIndex" style=""><%=i + 1+(page *20)%>. </span>
			<span class="inputBox" style=" width:95%;"><%=#qsubject%><em class="sorceLabel">[<%=quescore%>分]</em></span>
			<span class="clearing"></span>
		</div>
		<div class="radioPane">
			<ul style="overflow: hidden;">
				<%for(var i=0;i<blanks.length;i++){%>
				<li class="radioBox" >
					<p class="radioWrapper" style="display:block; float:left;width:40px;">
					<span class="jqTransformRadioWrapper">
						<a rel="question" class="jqTransformRadio" href="javascript:void(0);"></a>
						<input type="radio" value="" name="question" class="jqTransformHidden"></span>
						<label style="cursor:pointer;" bid='<%=keycode+i%>'></label>
					</p>
					<span class="optionContent" style="display: block;width: 85%; margin-left: 36px; word-break: break-all;"><%=#blanks[i].bsubject%></span>
					<span class="clearing"></span>
				</li>
				<%}%>							
			</ul>
		</div>
		<div class="userAnswerBar">
	                <ul style="overflow:auto;  overflow-y:hidden;zoom:1">
	                <li style="float:left;">我的答案：<span class="userAnsLabel"><%=#mychoicestr%></span></li>
	                <li style="float:left;"><span class="markFalse">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></li>
	                </ul>
	            </div>
        <div class="answerBar">正确答案：<span class="answerLabel"><%=#choicestr%></span></div>
        <%if(extdata == ''){%>
        <%}else{%>
        	<%if(extdata.fenxi == ''){%>
        		
        	<%}else{%>
        		<div class="title answerBar"><span style="float:left;">分析：</span><div class="resolve inputBox" style="width:85%;float:left;"><p><%=#extdata.fenxi%><br></p></div><div class="clearing"></div></div>
        	<%}%>
        	<%if(extdata.jx == ''){%>
        		
        	<%}else{%>
        		<div class="title answerBar"><span style="float:left;">解答：</span><div class="resolve inputBox" style="width:85%;float:left;"><p><%=#extdata.jx%><br></p></div><div class="clearing"></div></div>
        	<%}%>
        	<%if(extdata.dp == ''){%>
        		
        	<%}else{%>
        		<div class="title answerBar"><span style="float:left;">点评：</span><div class="resolve inputBox" style="width:85%;float:left;"><p><%=#extdata.dp%><br></p></div><div class="clearing"></div></div>
        	<%}%>
        <%}%>
		<div class="operateBar"><div class="delabtn delerror" name="84269"></div></div>
	</div>
	<%}else if(queType == 'B'){%>
	<div class="que singleContainer singleContainerFocused " qsval="<%=i + 1%>">
		<p class="desc"><span><em>作业名称:</em><strong title="<%=esubject%>"><%=sesubject%></strong></span><span><em>添加时间:</em><strong><%=dateline%></strong></span><span><em>试题类型:</em><strong>多选</strong></span><span><em>错误数:</em><strong style="color:#f85c72;"><%=errorCount%></strong></span></p>
        <div class="subjectPane">
            <span class="stIndex" style=""><%=i + 1+(page *20)%>. </span>
            <span class="inputBox" style=" width:95%;"><%=#qsubject%>（<span class="userAnsLabel" style="color:blue;font-weight:bold;padding:0 8px;"></span>）<em class="sorceLabel">[<%=quescore%>分]</em></span>
            <span class="clearing"></span>
        </div>
        <div class="radioPane">
            <ul style="overflow: hidden;">
            	<%for(var i=0;i<blanks.length;i++){%>
				<li class="radioBox" style="width: 340px;">
					<span class="radioWrapper" style="display:block; float:left;width: 40px;">
					<span class="jqTransformRadioWrapper">
						<a rel="question" class="jqTransformRadio" href="javascript:void(0);"></a>
						<input type="radio" value="" name="question" class="jqTransformHidden"></span>
						<label style="cursor:pointer;" bid='<%=keycode+i%>'></label>
					</span>
					<span class="optionContent" style="display: block;width: 85%; margin-left: 36px; word-break: break-all;"><%=#blanks[i].bsubject%><br></span>
					<span class="clearing"></span>
				</li>
				<%}%>
			 </ul>
        </div>
		<div class="userAnswerBar">
	                <ul style="overflow:auto;overflow-y:hidden; zoom:1">
	                <li style="float:left;">我的答案：<span class="userAnsLabel"><%=#mychoicestr%></span></li>
	                <li style="float:left;"><span class="markFalse">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></li>
	                </ul>
	            </div>
        <div class="answerBar">正确答案：<span class="answerLabel"><%=#choicestr%></span></div>
        <%if(extdata == ''){%>
        <%}else{%>
        	<%if(extdata.fenxi == ''){%>
        		
        	<%}else{%>
        		<div class="title answerBar"><span style="float:left;">分析：</span><div class="resolve inputBox" style="width:85%;float:left;"><p><%=#extdata.fenxi%><br></p></div><div class="clearing"></div></div>
        	<%}%>
        	<%if(extdata.jx == ''){%>
        		
        	<%}else{%>
        		<div class="title answerBar"><span style="float:left;">解答：</span><div class="resolve inputBox" style="width:85%;float:left;"><p><%=#extdata.jx%><br></p></div><div class="clearing"></div></div>
        	<%}%>
        	<%if(extdata.dp == ''){%>
        		
        	<%}else{%>
        		<div class="title answerBar"><span style="float:left;">点评：</span><div class="resolve inputBox" style="width:85%;float:left;"><p><%=#extdata.dp%><br></p></div><div class="clearing"></div></div>
        	<%}%>
        <%}%>
		<div class="operateBar"><div class="delabtn delerror" name="84270"></div></div>
    </div>	
	<%}else if(queType == 'C'){%>
	<div class="que singleContainer singleContainerFocused" qsval="<%=i + 1%>">
		<p class="desc"><span><em>作业名称:</em><strong title="<%=esubject%>"><%=sesubject%></strong></span><span><em>添加时间:</em><strong><%=dateline%></strong></span><span><em>试题类型:</em><strong>填空</strong></span><span><em>错误数:</em><strong style="color:#f85c72;"><%=errorCount%></strong></span></p>
        <div class="blankSubject subjectPane">
            <span class="stIndex" style=""><%=i + 1+(page *20)%>.</span>
            <span class="inputBox" style=" width:95%;"><%=#qsubject%>
            <span class="pointLabel sorceLabel">[<%=quescore%>分]</span></span>
            <span class="clearing"></span>
        </div>
		<div class="userAnswerBar">
	                <ul style="overflow:auto;overflow-y:hidden; zoom:1">
	                <li style="float:left;">我的答案：<span class="userAnsLabel"><%=#mychoicestr%></span></li>
	                <li style="float:left;"><span class="markFalse">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></li>
	                </ul>
	            </div>
        <div class="answerBar">正确答案：
            <span class="answerLabel"><%=#choicestr%></span>
        </div>
        <%if(extdata == ''){%>
        <%}else{%>
        	<%if(extdata.fenxi == ''){%>
        		
        	<%}else{%>
        		<div class="title answerBar"><span style="float:left;">分析：</span><div class="resolve inputBox" style="width:85%;float:left;"><p><%=#extdata.fenxi%><br></p></div><div class="clearing"></div></div>
        	<%}%>
        	<%if(extdata.jx == ''){%>
        		
        	<%}else{%>
        		<div class="title answerBar"><span style="float:left;">解答：</span><div class="resolve inputBox" style="width:85%;float:left;"><p><%=#extdata.jx%><br></p></div><div class="clearing"></div></div>
        	<%}%>
        	<%if(extdata.dp == ''){%>
        		
        	<%}else{%>
        		<div class="title answerBar"><span style="float:left;">点评：</span><div class="resolve inputBox" style="width:85%;float:left;"><p><%=#extdata.dp%><br></p></div><div class="clearing"></div></div>
        	<%}%>
        <%}%>
	   	<div class="operateBar"><div class="delabtn delerror" name="84271"></div></div>
    </div>
	<%}else if(queType == 'D'){%>
	<div class="que singleContainer singleContainerFocused" qsval="<%=i + 1+(page *20)%>">
		<p class="desc"><span><em>作业名称:</em><strong title="<%=esubject%>"><%=sesubject%></strong></span><span><em>添加时间:</em><strong><%=dateline%></strong></span><span><em>试题类型:</em><strong>判断</strong></span><span><em>错误数:</em><strong style="color:#f85c72;"><%=errorCount%></strong></span></p>
		<div class="questionContainer">
            <div class="subjectPane">
	            <span class="stIndex" style=""><%=i + 1+(page *20)%>. </span>
	            <span class="inputBox" style=" width:95%;">
	            <%=#qsubject%>
	            <em class="sorceLabel">[<%=quescore%>分]</em></span>
	            <span class="clearing"></span>
            </div>

            <div class="userAnswerBar">
	            <div style="float:left;"><span>对错选项：</span></div>
		            <div style="float:left;">
			            <span class="jqTransformRadioWrapper">
			            <a class="jqTransformRadio" href="javascript:void(0);"></a>
			            <input type="radio" value="true" name="" class="jqTransformHidden"></span>
			            <label for="" style="cursor:pointer;float:left;margin-right:10px;">对</label>

			            <span class="jqTransformRadioWrapper">
			            <a class="jqTransformRadio" href="javascript:void(0);"></a>
			            <input type="radio" value="false" name="" class="jqTransformHidden"></span>
			            <label for="" style="cursor:pointer;">错</label>
		        	</div>
		            <div class="clearing"></div>
	            </div>
	        </div>
            <div class="answerBar">正确答案：<span class="answerLabel"><%=choicestr=='10'?'对':'错'%></span></div>
            <%if(extdata == ''){%>
        <%}else{%>
        	<%if(extdata.fenxi == ''){%>
        		
        	<%}else{%>
        		<div class="title answerBar"><span style="float:left;">分析：</span><div class="resolve inputBox" style="width:85%;float:left;"><p><%=#extdata.fenxi%><br></p></div><div class="clearing"></div></div>
        	<%}%>
        	<%if(extdata.jx == ''){%>
        		
        	<%}else{%>
        		<div class="title answerBar"><span style="float:left;">解答：</span><div class="resolve inputBox" style="width:85%;float:left;"><p><%=#extdata.jx%><br></p></div><div class="clearing"></div></div>
        	<%}%>
        	<%if(extdata.dp == ''){%>
        		
        	<%}else{%>
        		<div class="title answerBar"><span style="float:left;">点评：</span><div class="resolve inputBox" style="width:85%;float:left;"><p><%=#extdata.dp%><br></p></div><div class="clearing"></div></div>
        	<%}%>
        <%}%>
        <div class="operateBar"><div class="delabtn delerror" name="84273"></div></div>
	</div>	
	<%}else if(queType == 'E'){%>
	<div class="que singleContainer singleContainerFocused" qsval="<%=i + 1%>"> 
		<p class="desc"><span><em>作业名称:</em><strong title="<%=esubject%>"><%=sesubject%></strong></span><span><em>添加时间:</em><strong><%=dateline%></strong></span><span><em>试题类型:</em><strong>文字</strong></span><span><em>错误数:</em><strong style="color:#f85c72;"><%=errorCount%></strong></span></p>
        <div class="subjectPane">
            <span class="stIndex" style=""><%=i + 1+(page *20)%>. </span>
            <span class="inputBox" style=" width:95%;">
            <%=#qsubject%>	            <em class="sorceLabel">[<%=quescore%>分]</em></span>
            <span class="clearing"></span>
        </div>
        <div class="answerBar" style="width: 805px;display: block;">正确答案：<span class="answerLabel" ><%=#choicestr%></span></div>
		<%if(extdata == ''){%>
        <%}else{%>
        	<%if(extdata.fenxi == ''){%>
        		
        	<%}else{%>
        		<div class="title answerBar"><span style="float:left;">分析：</span><div class="resolve inputBox" style="width:85%;float:left;"><p><%=#extdata.fenxi%><br></p></div><div class="clearing"></div></div>
        	<%}%>
        	<%if(extdata.jx == ''){%>
        		
        	<%}else{%>
        		<div class="title answerBar"><span style="float:left;">解答：</span><div class="resolve inputBox" style="width:85%;float:left;"><p><%=#extdata.jx%><br></p></div><div class="clearing"></div></div>
        	<%}%>
        	<%if(extdata.dp == ''){%>
        		
        	<%}else{%>
        		<div class="title answerBar"><span style="float:left;">点评：</span><div class="resolve inputBox" style="width:85%;float:left;"><p><%=#extdata.dp%><br></p></div><div class="clearing"></div></div>
        	<%}%>
        <%}%>
	</div>	
	
	<%}else if(queType == 'H'){%>
		<div class="que singleContainer singleContainerFocused" qsval="<%=i + 1%>"> 
			<p class="desc">
				<span>
					<em>作业名称:</em>
					<strong title="<%=esubject%>"><%=sesubject%></strong>
				</span>
				<span>
					<em>添加时间:</em>
					<strong><%=datelineH%></strong>
				</span>
				<span>
					<em>试题类型:</em>
					<strong>主观</strong>
				</span>
				<span>
					<em>错误数:</em>
					<strong style="color:#f85c72;"><%=errorCount%></strong>
				</span>
			</p>
			
	        <div class="subjectPane">
	            <span class="stIndex" style=""><%=i + 1+(page *20)%>. </span>
	            <span class="inputBox" style=" width:95%;"><%=#qsubject%>
	            	<em class="sorceLabel">[<%=quescore%>分]</em>
	            </span>
	            <div style="margin-top: 5px;">
	            	<%if(typeH == 1){%>
			        <%}else{%>
			        	<img style="display:block;max-width: 850px;" class="typeHque" src="<%=#cwurlH%>"/>
			        <%}%>
	            </div>
	            <span class="clearing"></span>
	        </div>
	        
	        
	        <div class="answerBar" style="color: #20150B;width: 805px;display: block;">我的答案：
	        	<%if(keyH == ''){%>
	        		<font color="red">未作答</font>
	        	<%}%>	
	        	<div id="answerHimg">
        			<div>
        				<%if(keyH == ''){%>
			        	<%}else{%>
        					<img style="display:block;max-width: 850px;" src="<%=#answerH%>" />
        				<%}%>
        			</div>
	        	</div>
	        </div>
			<%if(extdata != ''){%>
	        	<%if(extdata.fenxi != ''){%>
	        		<div class="title answerBar">
	        			<span style="float:left;">分析：</span>
	        			<div class="resolve inputBox" style="width:85%;float:left;">
	        				<p><%=#extdata.fenxi%><br></p>
	        			</div>
	        			<div class="clearing"></div>
	        		</div>
	        	<%}%>
	        	<%if(extdata.jx != ''){%>
	        		<div class="title answerBar">
	        			<span style="float:left;">解答：</span>
	        			<div class="resolve inputBox" style="width:85%;float:left;">
	        				<p><%=#extdata.jx%><br></p>
	        			</div>
	        			<div class="clearing"></div>
	        		</div>
	        	<%}%>
	        	<%if(extdata.dp != ''){%>
	        		<div class="title answerBar">
	        			<span style="float:left;">点评：</span>
	        			<div class="resolve inputBox" style="width:85%;float:left;">
	        				<p><%=#extdata.dp%><br></p>
        				</div>
        				<div class="clearing"></div>
        			</div>
	        	<%}%>
	        <%}%>
		</div>	
		
	<%}%>
	
</script>
	
	
	<script type="text/javascript">
		var crid = "<?=$crid?>";
		var searchtext = "请输入关键字";
		function getErrorList(tid,param,url){
			if(typeof url == "undefined") {
				url = '/college/examv2/errlistAjax.html';
			}
			//folderid:param.folderid,chapterid:param.chapterid,quetype:param.quetype,topchapterid:param.topchapterid,secchapterid:param.secchapterid
			
			var chapterpath = '';
			var cur = $('.nodeSel');
			while(cur.length){
				if(cur.attr('id')=='smyd0')
					break;
				var h = cur.attr('href');
				var reg = /([0-9]+)/g; 
				var cid = h.match(reg)[0];
				chapterpath = '/'+cid + chapterpath;
				cur = cur.parent().parent().prev('.dTreeNode').find('.node');
			}
			var path = param.topchapterid!=0?(param.topchapterid+(param.secchapterid!=0?'/'+param.secchapterid+(chapterpath?chapterpath:param.chapterid!=0?'/'+param.chapterid:''):'')):'';
			var ttype = path?'CHAPTER':'FOLDER';
			$.ajax({
				url:url,
				method:'post',
				dataType:'json',
				data : {
					ttype : ttype,
					tid : param.folderid>0?param.folderid:'',
					quetype:param.quetype,
					chapterid:param.chapterid,
					topchapterid:param.topchapterid,
					secchapterid:param.secchapterid,
					path:path,
					q:param.q
				}
			}).done(function(res){
				
				$("#errlist").empty();
				var errList = res.datas.errList;
				if(errList.length <=0){
					$('#mpage').empty();
					var cmain_bottom = '<div class="cmain_bottom " style="width: 100%; min-height: 400px; background:#fff">' +
						'<div class="study" style="margin: 0 auto; width: 205px;">' +
							'<div class="nodata"></div>'+
							'<p class="zwktrykc" style="text-align: center;"></p>'+
						'</div>'+
		        	'</div>';
					$('#errlist').empty().append(cmain_bottom);
				}else{
					for(var i=0;i<errList.length;i++){
						var queType = errList[i].question.queType;
						if(errList[i].question.queType == 'C'){
							var qsubject =	errList[i].question.qsubject.replace(/#input#/g,'<input type="text" readonly="readonly" maxlength="2147483647" size="20" value="">');
							qsubject =	qsubject.replace(/#img#/g,'<input type="text" readonly="readonly" maxlength="2147483647" size="20" value="">');
						}else{
							var qsubject = errList[i].question.qsubject;
						}
						
						if(queType == 'C'){
							var choicestr = [];
							var bidarr = [];
							var answerblankarr = [];
							for(var j=0;j<errList[i].question.blanks.blankList.length;j++){
								if(/ebh_1_data-latexebh_2_/.test(errList[i].question.blanks.blankList[j].bsubject)){
								  var bsubjecthtml = unescape(errList[i].question.blanks.blankList[j].bsubject.replace(/ebh_1_/g,' ').replace(/ebh_2_/g,'='));
								  bsubjecthtml = '<img '+ bsubjecthtml +' />';
								   choicestr.push(bsubjecthtml);
								}else{
									choicestr.push(errList[i].question.blanks.blankList[j].bsubject);
								}
								bidarr.push(errList[i].answerQueDetail.answerBlankDetails[j].bid);
							}
							for(var k=0;k<errList[i].answerQueDetail.answerBlankDetails.length;k++){
								var bid = errList[i].answerQueDetail.answerBlankDetails[k].bid;
								answerblankarr[bid] = errList[i].answerQueDetail.answerBlankDetails[k]
							}
							var  choicestr = choicestr.join(';&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;')
							var extdata =$.parseJSON(errList[i].question.extdata)
							var mychoicestr = '';
							for(key in bidarr){
								if(/ebh_1_data-latexebh_2_/.test(answerblankarr[bidarr[key]].content)){
									var  bsubjecthtml = answerblankarr[bidarr[key]].content.replace(/ebh_1_/g,' ').replace(/ebh_2_/g,'=');
									bsubjecthtml = '<img '+ bsubjecthtml +' />';
									mychoicestr += bsubjecthtml?bsubjecthtml:'<font color="red">未作答</font>';
								}else{
									mychoicestr += answerblankarr[bidarr[key]].content?answerblankarr[bidarr[key]].content:'<font color="red">未作答</font>';
								}
								
								if(key < bidarr.length-1)
									mychoicestr += ';&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
							}
							//var mychoicestr = errList[i].answerQueDetail.data; 
						}else if(queType == 'E'){
							var choicestr = errList[i].question.blanks.blankList[0].bsubject;
						}else if(queType == 'A' || queType == 'B'){
							// alert();
							var trueanswer = '';
							var myanswer = '';
							var aindex = -2;
							var maindex = -2;
							while(aindex != -1){
								if(aindex == -2)
									aindex = errList[i].question.choicestr.indexOf(1)
								else
									aindex = errList[i].question.choicestr.indexOf(1,aindex+1);
								
								if(aindex>=0)
									trueanswer += String.fromCharCode(parseInt(aindex)+65);
							}
							while(maindex != -1){
								if(maindex == -2){
									maindex = errList[i].answerQueDetail.choicestr.indexOf(1)
								}else{
									maindex = errList[i].answerQueDetail.choicestr.indexOf(1,maindex+1);
								};
								if(maindex>=0){
									myanswer += String.fromCharCode(parseInt(maindex)+65);
								}
									
							}
							var choicestr = trueanswer;
							var mychoicestr = myanswer;
						}else if(queType == 'H'){
							//原图
							var cwurlH = 'http://up.ebh.net/exam/getsubthumb.html?orinote=1&uid='+errList[i].uid+'&origin=1&key='+encodeURIComponent(errList[i].question.blanks.key);
							//答题后的图	
							var answerH = 'http://up.ebh.net/exam/getsubthumb.html?uid='+errList[i].uid+'&origin=1&key='+encodeURIComponent(errList[i].question.blanks.key)+'';
							var datelineH = getLocalTime(errList[i].dateline);
							var choicestr = errList[i].question.choicestr;
							if(errList[i].question.blanks.key){
								var keyH = errList[i].question.blanks.key;
							}else{
								var keyH = "";
							}
							var typeH = errList[i].question.blanks.type;
						}else{
							var choicestr = errList[i].question.choicestr;
						}
						
						if(errList[i].question.extdata == ''){
							var extdata = '';
						}else{
							var extdata = $.parseJSON(errList[i].question.extdata);
							extdata.fenxi = extdata.fenxi.replace(/<br>/,'')
							extdata.jx = extdata.jx.replace(/<br>/,'');
							extdata.dp = extdata.dp.replace(/<br>/,'');
						}
						mychoicestr = mychoicestr?mychoicestr:'<font color="red">未作答</font>';
					
						var page = parseInt(res.datas.page)
						if(errList[i].exam.esubject.length>40){
						    var  sesubject = errList[i].exam.esubject.substring(0,40)+"...";
						}else{
							var  sesubject = errList[i].exam.esubject;
						}
						var data = {
							page : page -1,
							i : i,
							keycode : 65,
							queType : errList[i].question.queType,
							sesubject : sesubject,
							esubject : errList[i].exam.esubject,
							dateline : getLocalTime(errList[i].question.dateline),
							blanks : errList[i].question.blanks.blankList || [],
							quescore : errList[i].question.quescore,
							qsubject : qsubject,
							choicestr : choicestr,
							errorCount : errList[i].errorCount,
							extdata :extdata,
							qid :  errList[i].question.qid,
							mychoicestr : mychoicestr,
							cwurlH : cwurlH,
							answerH : answerH,
							datelineH : datelineH,
							keyH : keyH,
							typeH : typeH
						};
						var $dom = $(template('t:que',data));
						$("#errlist").append($dom);
						$('#errlist br').remove();
					}
					$('#mpage').empty().append(res.datas.pagestr);
					$('.radioBox label ').each(function(){
						$(this).text(String.fromCharCode($(this).attr('bid')));
					})
					var ii = setInterval(function(){
						var allready = true;
						$.each($('img'),function(v){
							if($(this)[0].complete == false){
								allready = false;
								return false;
							}
						});
						if(allready == true){
							parent.resetmain();
							window.clearInterval(ii);
						}
					},1000);
					
					parent.resetmain();	
				}
				
				}).fail(function(){
				console.log('req err');
			});
			
		}
		
		$('.pages .listPage a').live('click',function(){
			var url = $(this).attr('data');
			if(!!url) {
				getErrorList('',curparam,url);
				parent.resetmain();
			}
		});
				
		$(function(){
			//getKlist();
			$("#queType,#ttype,#tid").on('change',function(){
				getKlist();
			})
			Xques.doshow("<?=$crid?>");
			initsearch("txtname",searchtext);
			parent.resetmain();
			
		});
		var curparam;
		Xques.setCallback(function(param){
			curparam = param;
			searchs('txtname');
			// getErrorList('',param);
			// $('#txtname').val('请输入关键字');
			// $('#txtname').css("color","#CBCBCB");
		});
		
		function searchs(strname){
			var sname = $('#'+strname).val();
			if(sname=='请输入关键字'){
				sname = "";
			}
			curparam.q = sname;
			getErrorList('',curparam);
		}
		//初始化搜索输入框
		function initsearch(id,value) {
			if($("#"+id).val() == "") {
				$("#"+id).val(value);
				$("#"+id).css("color","#CBCBCB");
			}
			$("#"+id).click(function(){
				if($("#"+id).val() == value) {
					$("#"+id).val("");
					$("#"+id).css("color","#000");
				}
			});
			$("#"+id).blur(function(){
				if($("#"+id).val() == "") {
					$("#"+id).val(value);
					$("#"+id).css("color","#CBCBCB");
				}
			});
		}
		function getLocalTime(nS) {     
		    return new Date(parseInt(nS) * 1000).toLocaleString().replace(/年|月/g, "-").replace(/日/g, " ");      
		}
	</script>
</body>
</html>