<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="http://static.ebanhui.com/exam/css/base.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/exam/css/global.css">
    	
<!--    <script type="text/javascript" src="http://static.ebanhui.com/js/jquery-migrate-1.2.1.min.js"></script>-->
    <script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
    <script src="http://static.ebanhui.com/exam/js/jquery/jquery-migrate-1.2.1.js"></script>
    <script type="text/javascript" src="http://static.ebanhui.com/exam/js/template/template-native-debug.js"></script>
    <link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/base.css<?=getv()?>" />
    <link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" />
    <link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/exam/css/wussyu.css"/>
    <script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
    <link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen">
    <script src="http://static.ebanhui.com/ebh/js/Highcharts/js/highcharts.js"></script>
    <script src="http://static.ebanhui.com/ebh/js/Highcharts/js/highcharts-3d.js"></script>
    <script src="http://static.ebanhui.com/ebh/js/Highcharts/js/highcharts-more.js"></script>
    <title>统计分析</title>
	<style>
	body{
		min-height: 100%;
		background: #f3f3f3;
		font-family: 微软雅黑!important;
	}
	.imgyuan{
		width:50px;
	}
	.Havepay{
		width: 250px;
		position: relative;
		height: 55px;
		float: left;
		background: url(http://static.ebanhui.com/exam/images/icon/rankf.jpg) no-repeat;
		padding-left: 65px;
		padding-top: 2px;
		margin-left: 75px;
	}
	.Havepay div img{
		margin: 0 4px;
	}
	.Havepay .offR,.Havepay .onR{
		position: absolute;
		top: 0;
		left: 0;
	}
	
	.dsiters{
		margin-top: 90px;
	}
	.Havepay .onR img{
		display: none;
	}
	.averageTime{
		width: 250px;
		height: 55px;
		background: url(http://static.ebanhui.com/exam/images/Alarm.jpg) no-repeat;
		padding-left: 65px;
		padding-top: 2px;
		float: left;
		margin-left: 28px;
	}
	.soulico {
		float:left;
		background:url(http://static.ebanhui.com/ebh/tpl/2014/images/newsolico.jpg) no-repeat;
		height:24px;
		width:26px;
		border:none;
		cursor:pointer;
	}
	.newsou {
	    width: 150px;
	    height: 22px;
	    line-height: 22px;
	    border: solid 1px #d9d9d9;
	    border-right: none;
	    color: #d2d2d2;
	    padding-left: 5px;
	    float: left;
	}
	.diles {
	    display: inline;
	    height: 30px;
	    position: absolute;
	    right: 8px;
	    top: -30px;
	    width: 185px;
	    
	}
	a.revise{
		float: left;
	    background: url(http://static.ebanhui.com/ebh/tpl/troomv2/images/xiugai.png) no-repeat;
	    width: 26px;
	    height: 27px;
	    margin-left: 12px;
	}
	a.shansge{
		margin-left: 25px;
	}
	.lefrig{
		float: none;
		margin: 0 auto;
	}
	a.waskes{ margin-left: 70px;}
	a.remind{margin-left:10px ;color:cornflowerblue;}
	div.work_mes,div.workdata{
		position: relative;
	}
	div.work_mes{
		height: auto;
		float: none!important;
	}
	.extendul{
		height: 42px;
	    border-bottom: solid 1px #e3e3e3;
	}
	.mk_j_num,.mk_y_time{
		color:#ed5468;
		font-size: 22px;
		 font-weight: 500;
		  line-height: 30px;
	}
	.mk_j_rank{
		font-size: 30px;
		font-weight: 500;
	}
	.ui-tabs-hide
		{
		    display: none;
		}
	.coupon-price {
    font-weight: 700;
    transform: scale(1,3);
    -ms-transform: scale(1,3);
    -webkit-transform: scale(1,3);
    -moz-transform: scale(1,3);
    -o-transform: scale(1,3);
}
	.completetimebP i{
		background-position: 0px -8px;
	}
	/*分页*/
	.pages{ height:50px; padding-top:15px; padding-right:20px;}
	.listPage{height: 30px; text-align: center; margin: 0 auto;}
	.listPage a {background:#f9f9f9;border: 1px solid #f9f9f9;display: inline-block;font-weight:bold;height: 26px;line-height:26px;margin: 0 2px;text-align: center;width: 30px;color:#767676!important;text-decoration:none;}
	.listPage a:visited {background:#f9f9f9;border: 1px solid #f9f9f9; display: block;  float: left;  height: 26px;line-height:26px; margin: 0 2px; text-align: center; width: 30px;color:#323232;text-decoration:none;}
	.listPage a:Hover {	border:1px solid #0CA6DF;text-decoration: none;}
	.listPage .none{border:1px solid #23a1f2;background:#23a1f2;color:#FFFFFF!important;font-weight:bold;}
	#next{ width:66px; height:26px; }
	#gopage{ width:26px;padding:3px 2px;  border:1px solid #CCCCCC; font-size:12px; text-align:center; float:left;}
	#page_go{ width:45px; height:20px;}
	.lishnrt1 {
	    padding: 10px 20px;
	    position: relative;
	    height: 35px;
	    width: 1000px;
	    font-size: 13px;
	    float: left;
	}
	table.table {
		font-size:11px;
		color:#333333;
		border-width: 1px;
		border-color: #666666;
		border-collapse: collapse;
		margin-left: 20px;
	}
	table.table tr{
		height: 45px;
	}
	table.table th {
		border-width: 1px;
		border-style: solid;
		border-color: #c2d3f1;
		background-color: #e4ebf5;
		text-align: center;
	}
	table.table td {
		border-width: 1px;
		padding: 8px;
		border-style: solid;
		border-color: #c2d3f1;
		background-color: #ffffff;
		text-align: center;
	}
	.boxF{
		padding-top: 30px;
		padding-bottom: 50px;
	}
	.boxF h1{
		display: block;
		width: 100%;
		height: 18px;
		font-size: 18px;
		line-height: 18px;
		margin-bottom: 10px;
		padding-left: 10px;
	}
	.boxF h1 i{
		display: inline-block;
		width: 3px;
		height: 15px;
		background: #5c96f7;
		margin: 2px 10px 0 10px;
	}
	.workdata1{
		width: 100%;
	}
	.PressT,.PressZ{
		display: block;
		width: 100%;
		height: 18px;
		font-size: 18px;
		line-height: 18px;
		margin-top: 10px;
		padding: 10px;
	}
	.PressT i,.PressZ i{
		display: inline-block;
		width: 3px;
		height: 15px;
		background: #5c96f7;
		margin: 2px 10px 0 10px;
	}
	.onTxt{
		height: 55px;
	}
	.onTxt{
		
	}
	.ksrdgae{
		margin: 0 20px;
		float: none;
	}
	.classlist{
		text-align: center;
		margin-top: 10px;
		line-height: 24px;
	}
	.classlist a{
		padding: 0px 10px;
	    display: inline-block;
	    height: 24px;
	    border-radius: 3px;
	    margin: 2px 3px;
	    cursor: pointer;
	}
	.classlist a.active{
		color: #fff;
		background: #5e96f5;
	}
	.classlist span{
		margin: 2px 3px;
	}
	.jisret{
		height: 45px;
	}		
	</style>
	<script>
	var eid = "<?=$eid?>";
	var k = "<?=$k?>";	  
	</script>
</head>

<body>
<div id="header">
	<div class="adAuto">
		<div class="magAuto top">
			<p>您好,<?=empty($user['realname'])?$user['username']:$user['realname']?></p>
		</div>
	</div>
	<div class="Ad">
		<div class="magAuto">
			<img src="http://static.ebanhui.com/exam/images/banner/stu_head_pic.jpg" />
		</div>
	</div>
</div>
<div id="container">
<div class="lefrig">
    <h2 class="jisret"></h2>
	<div class="fl" style="width: 100%;height: 300px;">
		<div>
			<p class="kishre" style="width: 100%;text-align: center;"><span class="ksrdgae pusTime">完成时间：</span><span class="ksrdgae scorelab">得分：</span><span class="ksrdgae limittime">用时：分钟</span></p>
			<div style="width: 100%;" class='classlist'>
				
			</div>
			<div class="clear"></div>
		</div>
		<div class="fl" style="height: 100%; width: 380px; overflow: hidden;">
			<div id='container1' class="fl" style="height: 250px;width:380px;">
				
			</div>
		</div>
		<div style="width: 620px;height: 100%;background: #fff;" class="fl">
			
			<div class="dsiters">
			    <div class="Havepay">
			
			    	<div class="onTxt ">
			    		我的排名 <br />
			    		<p class="mk_j_num">---</p>
			    	</div>
			    	
			    </div>
			    <div class="averageTime">
			    	<div>
			    		答题时间<br />
			    		<p class="mk_y_time" >---</p>
			    	</div>
			    </div>
			</div>
		</div>
		
	</div>
	<div class="work_mes">
	    <ul class="extendul ui-tabs-nav">
	        <li type="quetype" onclick="getfenxi('quetype',1)" class="workcurrent"><a href="javascript:;">得分情况</a></li>
			<li type="que" onclick="getfenxi('que',1)"><a href="#">每题分析</a></li>
	    </ul>
	    	<div class="fl ui-tabs-panel">
	    		<div class="lishnrt">
					<a href="javascript:void(0);" value='0' class="hietse xhusre"  onclick="getfenxi('quetype',1)">按题型</a>
					<a href="javascript:void(0);" value='1' class="hietse "   onclick="getfenxi('relationship',1)">按知识点</a>
			    </div>
			    <div class="workdata quetype fl" style="margin-top:0;">
			    	
			    </div>
			    
	    	</div>
	    	<div class="fl ui-tabs-panel ui-tabs-hide">
	    		<div class="lishnrt1">
					<a href="javascript:void(0);" value='0' onclick="getfenxi('que',1)" class="hietse xhusre">表格分析</a>
					<a href="javascript:void(0);" value='1' onclick="getfenxi('que',2)" class="hietse ">雷达图分析</a>
			    </div>
			    <div class="workdata que fl" style="margin-top:0;">
			    	
			    </div>
		</div>
	</div>
    
</div>
</div>
<script type="text/html" id="t:answer">
	 <tr class="">
        <td style="word-break: break-all; word-wrap:break-word;">
            <a title="" href="javascript:;" style="float:left;">
                <img class="imgyuan" src="http://static.ebanhui.com/ebh/tpl/default/images/m_man_50_50.jpg">
            </a>
            <p class="ghjut" style="width:160px">
            	<%=realname%>
            	<% if(sex == '0'){ %>
                <img src="http://static.ebanhui.com/ebh/tpl/troomv2/images/man.png">
                <%}else if(sex == '1'){%>
                <img src="http://static.ebanhui.com/ebh/tpl/troomv2/images/women.png">	
                <%}%>
            </p>
            <p class="ghjut" style="width:160px;color:#999;"><%=username%></p>
        </td>
        <td>
            <p><%=ansdateline%></p>
            <p style="color:#999;" title=""></p>
        </td>
        <td style="text-align: center;"><%=usedtime%>分钟</td>
        <td style="text-align: center;"><%=anstotalscore%>分</td>
        <td>
            <a class="waskes" href="/troomv2/examv2/eview/<%=userAnswer%>.html?eid=<%=eid%>" target="_blank">查看</a>
			
        </td>
    </tr>
</script>
<script type="text/html" id="t:que">
	<%if(bolALL == 1){ %>
	<% if(bolA == 1 ){%>
		<div class="boxF">
	    	<h1><i></i>选择题</h1>
	    	<table class="table">
				<tr>
					<th width="102">序号</th>
					<th width="132">题号</th>
					<th width="132">答案</th>
					<th width="130">分值</th>
					<th width="130">平均得分</th>
					<th width="130">我的得分</th>
					<th width="130">我的得分率</th>
				</tr>
		    <%for(var i=0;i<efenxiA.length;i++){%>
			    <% if(efenxiA[i].qtype == 'A' || efenxiA[i].qtype == 'B'){%>		
				<tr>
					<td><%=i +1%></td> 
					<td><%=efenxiA[i].quecount%></td> 
					<td><%=efenxiA[i].rightchoice%></td> 
					<td><%=efenxiA[i].quescore%></td> 
					<td><%=efenxiA[i].avgscore%></td> 
					<td><%=efenxiA[i].myscore%></td> 
					<td><%=subPercentage(efenxiA[i].scorerat)%></td> 
				</tr>
				<%}%>
			<%}%>
				<tr>
					<td></td> 
					<td>选择题小计</td> 
					<td></td> 
					<td><%=BgsorceA%></td> 
					<td><%=BgavgscoreA%></td> 
					<td><%=BgmyscoreA%></td> 
					<td></td>  
				</tr>
			</table>
		</div>
	<%}%>
	<% if(bolD == 1){%>
		<div class="boxF">
	    	<h1><i></i>判断题</h1>
	    	<table class="table">
				<tr >
					<th width="102">序号</th>
					<th width="132">题号</th>
					<th width="132">答案</th>
					<th width="130">分值</th>
					<th width="130">平均得分</th>
					<th width="130">我的得分</th>
					<th width="130">我的得分率</th>
				</tr>
			<%for(var i=0;i<efenxiD.length;i++){%>
			    <% if(efenxiD[i].qtype == 'D'){%>	
			    <tr>
			    	<td><%=i+1%></td>
			    	<td><%=efenxiD[i].quecount%></td>
			    	<%if(efenxiD[i].rightchoice == 'A'){%>
			    		<td>√</td>
			    	<%}else{%>
			    		<td>×</td>
			    	<%}%>	
			    	
			    	<td><%=efenxiD[i].quescore%></td>
			    	<td><%=efenxiD[i].avgscore%></td>
			    	<td><%=efenxiD[i].myscore%></td>
			    	<td><%=subPercentage(efenxiD[i].scorerat)%></td>
			    	
			    </tr>
			    <%}%>
			<%}%>
				<tr>
					<td></td> 
					<td>判断题小计</td> 
					<td></td> 
					<td><%=BgsorceD%></td> 
					<td><%=BgavgscoreD%></td> 
					<td><%=BgmyscoreD%></td> 
					<td></td> 
				</tr>	
			</table>
		</div>
	<%}%>
	<% if(bolH == 1){%>
		<div class="boxF">
	    	<h1><i></i>主观题</h1>
	    	<table class="table">
				<tr>
					<th width="102">序号</th>
					<th width="132">题号</th>
					<th width="132">分值</th>
					<th width="130">平均得分</th>
					<th width="130">我的得分</th>
					<th width="130">我的得分率</th>
				</tr>
			<%for(var i=0;i<efenxiH.length;i++){%>
			    <% if(efenxiH[i].qtype == 'H'){%>	
			    <tr>
			    	<td><%=i+1%></td>
			    	<td><%=efenxiH[i].quecount%></td>
			    	<td><%=efenxiH[i].quescore%></td>
			    	<td><%=efenxiH[i].avgscore%></td>
			    	<td><%=efenxiH[i].myscore%></td>
			    	<td><%=subPercentage(efenxiH[i].scorerat)%></td>
			    </tr>
			    <%}%>
			<%}%>	
				<tr>
			    	<td><%=%></td>
			    	<td>主观题小计</td>
			    	<td><%=BgsorceH%></td> 
			    	<td><%=BgavgscoreH%></td> 
					<td><%=BgmyscoreH%></td> 
			    	<td><%=BgtratH%></td>
			    </tr>
			</table>
		</div>
	<%}%>
	<%}else{%>
		<div class="cmain_bottom " style="width: 100%; min-height: 400px;">
			<div class="study" style="margin: 0 auto; width: 205px;">
				<div class="nodata"></div>
				<p class="zwktrykc" style="text-align: center;"></p>
			</div>
		</div>
	<%}%>
</script>
<script type="text/javascript">
	var classid = [];
   function getfenxi(bytype,type,url){
   		if(typeof url == "undefined") {
			url = '/college/examv2/efenxiAjax.html';
		}
		$.ajax({	
			url:url,
			method:'post',
			dataType:'json',
			data:{
				'eid' : eid,
				'bytype' : bytype,
				'classid':classid
			}
		}).done(function(res){

	        //console.log(res)

			parseT(res,bytype,type)
		}).fail(function(){});
		
   }
   
$(function(){
$('.datatab tr:last td').css('border-bottom','none');
});
function parseT(res,bytype,type){
	if(bytype == 'que'){
		var efenxi = res.datas.efenxi;
			if(type == 1){
				var bolALL = 0;
				var bolA = 0;
				var bolD = 0;
				var bolH = 0;
				var BgsorceA = 0;var BgsorceD = 0;var BgsorceH = 0;
				var BgavgscoreA = 0;var BgavgscoreD = 0;var BgavgscoreH = 0;
				var BgmyscoreA = 0;var BgmyscoreD = 0;var BgmyscoreH = 0;
				var BgtratH = 0;
				var efenxiA = [];var efenxiD = [];var efenxiH = [];
				for(var i=0;i<efenxi.length;i++){
					if(efenxi[i].qtype == 'A' || efenxi[i].qtype == 'B'){
						bolA = 1;
						BgsorceA += efenxi[i].quescore;
						BgavgscoreA += efenxi[i].avgscore;
						BgmyscoreA += efenxi[i].myscore;
						efenxiA.push(efenxi[i])
					}else if(efenxi[i].qtype == 'D'){
						bolD = 1;
						BgsorceD += efenxi[i].quescore;
						BgavgscoreD += efenxi[i].avgscore;
						BgmyscoreD += efenxi[i].myscore;
						efenxiD.push(efenxi[i])
					}else if(efenxi[i].qtype == 'H'){
						bolH = 1;
						BgsorceH += efenxi[i].quescore;
						BgavgscoreH += efenxi[i].avgscore;
						BgmyscoreH += efenxi[i].myscore;
						efenxiH.push(efenxi[i])
						BgtratH =  Math.round((BgmyscoreH/BgsorceH)*100) + '%';
					}
					if(efenxi[i].qtype == 'A' || efenxi[i].qtype == 'B' || efenxi[i].qtype == 'D' ||efenxi[i].qtype == 'H'){
						bolALL = 1;
						
					}
				}
				template.helper("subPercentage", function(a){
					return Math.round(a*100) + '%';
		       });  
				var data = {
					'bolALL' : bolALL,
					'efenxi' : efenxi,
					'bolA': bolA,
					'bolD': bolD,
					'bolH': bolH,
					'efenxiA': efenxiA,
					'efenxiD': efenxiD,
					'efenxiH':efenxiH,
					'BgtratH': BgtratH,
					'BgsorceA':  (Math.round(BgsorceA*10))/10,
					'BgavgscoreA' :(Math.round(BgavgscoreA*10))/10,
					'BgmyscoreA' :(Math.round(BgmyscoreA*10))/10,
					'BgsorceD': (Math.round(BgsorceD*10))/10,
					'BgavgscoreD' :(Math.round(BgavgscoreD*10))/10,
					'BgmyscoreD' :(Math.round(BgmyscoreD*10))/10,
					'BgsorceH': (Math.round(BgsorceH*10))/10,
					'BgavgscoreH' :(Math.round(BgavgscoreH*10))/10,
					'BgmyscoreH' :(Math.round(BgmyscoreH*10))/10
				}
				var $dom = $(template('t:que',data));
				$('.que').empty().append($dom);
			}else if(type == 2){
			var $dom =	'<h1 class="PressT"><i></i>按题号</h1>' +
				'<div id="containerT" style="min-width: 400px; width: 1000px; height: 600px; margin: 0 auto"></div>'+
				'<h1 class="PressZ"><i></i>按知识点</h1>' +
				'<div id="containerZ" style="min-width: 400px; width: 1000px; height: 600px; margin: 0 auto"></div>';
				
				$('.que').empty().append($dom);
				var  categoriesT =[];
				var  categoriesZ =[];
				var  dataF = [];
				var  dataP = [];
				for(var i=0;i<efenxi.length;i++){
					var dataFstr = efenxi[i].myscore;
					var dataPstr = efenxi[i].avgscore;
					if(efenxi[i].qtype == 'A'||efenxi[i].qtype == 'B'){
						var categories = '选择题'+ parseFloat(i+1);
					}else if(efenxi[i].qtype == 'D'){
						var categories = '判断题'+ parseFloat(i+1);
					}else if(efenxi[i].qtype == 'C'){
						var categories = '填空题'+ parseFloat(i+1);
					}else if(efenxi[i].qtype == 'H'){
						var categories = '主观题'+ parseFloat(i+1);
					}else if(efenxi[i].qtype == 'E'){
				   		var categories = '文字题'+ parseFloat(i+1);
				   	}else if(efenxi[i].qtype == 'X'){
	   					var categories = '答题卡'+ parseFloat(i+1);
		   			}else if(efenxi[i].qtype == 'XWX'){
		   				var categories = '完型填空'+ parseFloat(i+1);
		   			}else if(efenxi[i].qtype == 'XTL'){
		   				var categories = '听力题'+ parseFloat(i+1);
		   			}else if(efenxi[i].qtype == 'XYD'){
		   				var categories = '阅读理解'+ parseFloat(i+1);
	   				}else if(efenxi[i].qtype == 'XZH'){
	   					var categories = '组合题'+ parseFloat(i+1);
	   					
					}
					categoriesT.push(categories);
					dataF.push(dataFstr);
				
					dataP.push(dataPstr)
				}
				$('#containerT').highcharts({
			        chart: {
			            polar: true,
			            type: 'line'
			        },
			        credits:{
					     enabled:false // 禁用版权信息
					},
			        title: {
			            text: '',
			            x: -80
			        },
			        pane: {
			            size: '80%'
			        },
			        xAxis: {
			            categories: categoriesT,
			            tickmarkPlacement: 'on',
			            lineWidth: 0
			        },
			        yAxis: {
			            gridLineInterpolation: 'polygon',
			            lineWidth: 0,
			            min: 0
			        },
			        tooltip: {
			            shared: true,
			            pointFormat: '<span style="color:{series.color}">{series.name}: <b>{point.y:,.1f}</b><br/>'
			        },
			        legend: {
			            align: 'right',
			            verticalAlign: 'top',
			            y: 70,
			            layout: 'vertical'
			        },
			        series: [{
			            name: '我的得分',
			            data: dataF,
			            pointPlacement: 'on'
			        }, {
			            name: '平均得分',
			            data: dataP,
			            pointPlacement: 'on'
			        }]
			    });
			    $.ajax({	
					url:'/college/examv2/efenxiAjax.html',
					method:'post',
					dataType:'json',
					data:{
						'eid' : eid,
						'bytype' : 'relationship',
						'classid':classid
					}
				}).done(function(res){
					var efenxi =  (res.datas.efenxi) ? res.datas.efenxi : '';
					if(efenxi.length <=0){
						var cmain_bottom = '<div class="cmain_bottom " style="width: 100%; min-height: 400px;">' +
							'<div class="study" style="margin: 0 auto; width: 205px;">' +
								'<div class="nodata"></div>'+
								'<p class="zwktrykc" style="text-align: center;"></p>'+
							'</div>'+
			        	'</div>';
			        	$('#containerZ').empty().append(cmain_bottom);
					}else{
					var quescore = [];
					var avgscore = [];
					var relationname = [];
					for(var i=0;i<efenxi.length;i++){
						var dataqstr = efenxi[i].myscore;
						var dataastr = efenxi[i].avgscore;
						var relation= efenxi[i].relationname;
						relationname.push(relation);
						quescore.push(dataqstr);
						avgscore.push(dataastr)
					}
					$('#containerZ').highcharts({
			        chart: {
			            polar: true,
			            type: 'line'
			            
			        },
			        title: {
			            text: '',
			            x: -80
			        },
			        pane: {
			            size: '80%'
			        },
			        xAxis: {
			            categories: relationname,
			            tickmarkPlacement: 'on',
			            lineWidth: 0
			        },
			        yAxis: {
			            gridLineInterpolation: 'polygon',
			            lineWidth: 0,
			            min: 0
			        },
			        credits:{
					     enabled:false // 禁用版权信息
					},
			        tooltip: {
			            shared: true,
			            pointFormat: '<span style="color:{series.color}">{series.name}: <b>{point.y:,.1f}</b><br/>'
			        },
			        legend: {
			            align: 'right',
			            verticalAlign: 'top',
			            y: 70,
			            layout: 'vertical'
			        },
			        series: [{
			            name: '我的得分',
			            data: quescore,
			            pointPlacement: 'on'
			        }, {
			            name: '平均得分',
			            data: avgscore,
			            pointPlacement: 'on'
			        }]
			    });
			    }
				}).fail(function(){});
				
				
			  }
			   }else if(bytype == 'quetype'){
			   	var efenxi =  (res.datas.efenxi) ? res.datas.efenxi : '';
			   	var quetypeTx =  '<div id="containerTx" style="min-width: 400px; width: 1000px; height: 300px; margin: 0 auto;  margin-top: 20px;"></div><div class="boxF"><table class="table" style="margin: 0 auto;" width="80%"><tr><td></td><th>分值</th><th>我的分数</th><th>平均分</th><th>我的得分率</th></tr>';
		   		var vallScorce = 0;
		   		var vaverageScore = 0;
		   		var vmyscore = 0;
		   		for(var i=0;i<efenxi.length;i++){  
			   		if(efenxi[i].queType != undefined){
			   			vallScorce += parseFloat(efenxi[i].allScorce);
		   				vaverageScore += parseFloat(efenxi[i].averageScore);
		   				vmyscore +=(Math.round(efenxi[i].myscore*100))/100; 
		   				
			   			quetypeTx +='<tr>' ;
						if(efenxi[i].queType == 'A'){
				   			quetypeTx +='<th>单选题</th>';
				   		}else if(efenxi[i].queType == 'B'){
				   			quetypeTx +='<th>多选题</th>';
				   		}else if(efenxi[i].queType == 'C'){
				   			quetypeTx +='<th>填空题</th>';
				   		}else if(efenxi[i].queType == 'D'){
				   			quetypeTx +='<th>判断题</th>';
				   		}else if(efenxi[i].queType == 'E'){
				   			quetypeTx +='<th>文字题</th>';
				   		}else if(efenxi[i].queType == 'H'){
				   			quetypeTx +='<th>主观题</th>';
				   		}else if(efenxi[i].queType == 'X'){
			   				quetypeTx +='<th>答题卡</th>';
			   			}else if(efenxi[i].queType == 'XWX'){
			   				quetypeTx +='<th>完型填空</th>';
			   			}else if(efenxi[i].queType == 'XTL'){
			   				quetypeTx +='<th>听力题</th>';
			   			}else if(efenxi[i].queType == 'XYD'){
			   				quetypeTx +='<th>阅读理解</th>';
		   				}else if(efenxi[i].queType == 'XZH'){
		   					quetypeTx +='<th>组合题</th>';
				   		};
	    				quetypeTx += '<td>'+(efenxi[i].allScorce || 0) +'</td>'+
	    				'<td>'+((Math.round(efenxi[i].myscore*100))/100 || 0) +'</td>'+
	    				'<td>'+(efenxi[i].averageScore || 0) +'</td>'+
	    				'<td>'+toPoint(efenxi[i].myscore/efenxi[i].allScorce)+'</td>'+
	    			'</tr>';
			   		}
			   	}
			   	
			  	quetypeTx +='<tr>'+
		    				'<th>总分</th>'+
		    				'<td>'+((Math.round(vallScorce*100))/100 || 0)+'</td>'+
		    				'<td>'+((Math.round(vmyscore*100))/100 || 0)+'</td>'+
		    				'<td>'+(vaverageScore.toFixed(1) || 0) +'</td>'+
		    				'<td>'+subPercentage((vmyscore/vallScorce).toPercent(),true) +'</td>'+
		    			'</tr>';
			    quetypeTx +=	'</table></div>';
			   		$('.quetype').empty().append(quetypeTx);
			   		var categories = [];
			   		var data = [];
			   		var dataM = [];
			   		for(var i=0;i<efenxi.length;i++){	
			   			if(efenxi[i].queType == 'A'){
				   			efenxi[i].queType = '单选题';
				   		}else if(efenxi[i].queType == 'B'){
				   			efenxi[i].queType = '多选题';
				   		}else if(efenxi[i].queType == 'C'){
				   			efenxi[i].queType = '填空题';
				   		}else if(efenxi[i].queType == 'D'){
				   			efenxi[i].queType = '判断题';
				   		}else if(efenxi[i].queType == 'E'){
				   			efenxi[i].queType = '文字题';
				   		}else if(efenxi[i].queType == 'H'){
				   			efenxi[i].queType = '主观题';
				   		}else if(efenxi[i].queType == 'X'){
			   				efenxi[i].queType = '答题卡';
			   			}else if(efenxi[i].queType == 'XWX'){
			   				efenxi[i].queType = '完型填空';
			   			}else if(efenxi[i].queType == 'XTL'){
			   				efenxi[i].queType = '听力题';
			   			}else if(efenxi[i].queType == 'XYD'){
			   				efenxi[i].queType = '阅读理解';
		   				}else if(efenxi[i].queType == 'XZH'){
		   					efenxi[i].queType = '组合题';
				   		}else if(efenxi[i].queType == undefined){
				   			efenxi[i].queType = '总分';
				   		}
			   			categories.push(efenxi[i].queType);
			   			data.push(Math.round(efenxi[i].scoreRate*100));
			   			dataM.push(Math.round((efenxi[i].myscore/efenxi[i].allScorce)*100));
					    $('#containerTx').highcharts({
					    	
					        chart: {
					            type: 'column'
					        },
					         title: {
					            text: ''
					        },
					        credits:{
							     enabled:false // 禁用版权信息
							},
					        xAxis: {
					            categories: categories,
					            crosshair: true
					        },
					        yAxis: {
					            min: 0,
					            title: {
					                text: '得<br>分<br>率<br>︵<br>%<br>︶',
					                rotation:0,
					                style:{
					                	fontSize: '15px',
					                	fontFamily:'微软雅黑',
					                	color:'#000'
					                }
					            },
					            tickPositions: [0, 25, 50,75, 100]
					        },
					        tooltip: {
					            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
					            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
					            '<td style="padding:0"><b>{point.y:.1f} %</b></td></tr>',
					            footerFormat: '</table>',
					            shared: true,
					            useHTML: true
					        },
					        plotOptions: {
					            column: {
					                pointPadding: 0.2,
					                borderWidth: 0
					            },
					            series: {
			                        borderWidth: 0,
			                        dataLabels: {
			                            enabled: true,
			                            format: '{point.y}%',
			                            allowOverlap : true
			                        }
			                    }
					        },
					        series: [{
					            name: '班级平均得分率',
					            color: '#999999',
					            data: data
					        }, {
					            name: '我的得分率',
					            color: '#7CB5EC',
					            data: dataM
					        }]
					    });
			   		}
			   }else if(bytype == 'relationship'){
			   	var efenxi =  (res.datas.efenxi) ? res.datas.efenxi : '';
			  	if(efenxi.length <= 0 ){
			  		var cmain_bottom = '<div class="cmain_bottom " style="width: 100%; min-height: 400px;">' +
						'<div class="study" style="margin: 0 auto; width: 205px;">' +
							'<div class="nodata"></div>'+
							'<p class="zwktrykc" style="text-align: center;"></p>'+
						'</div>'+
		        	'</div>';
		        	$('.quetype').empty().append(cmain_bottom);
			  	}else{
				  	var categories = [];
				   	var data = [];
				   	var dataM = [];
		   			var relationship = '';
		   			var totalavgscore = 0;
		   			var totalquescore = 0;
		   			var totalmyscore = 0;
				   	for(var i=0;i<efenxi.length;i++){
				   		categories.push(efenxi[i].relationname);
		   				data.push(subPercentage((efenxi[i].avgscore/efenxi[i].quescore).toPercent(),false));
		   				dataM.push(subPercentage((efenxi[i].myscore/efenxi[i].quescore).toPercent(),false));
		   				totalavgscore +=efenxi[i].avgscore;
		   				totalquescore +=efenxi[i].quescore;
		   				totalmyscore += efenxi[i].myscore;
				   			var excellent =  '<tr>'+
				    				'<th>'+efenxi[i].relationname+'</th>'+
				    				'<td>'+ ((Math.round(efenxi[i].quescore*10))/10) +'</td>'+
				    				'<td>'+((Math.round(efenxi[i].myscore *10))/10) +'</td>'+
				    				'<td>'+  ((Math.round(efenxi[i].avgscore*10))/10) +'</td>'+
				    				'<td>'+  Math.round((efenxi[i].myscore/efenxi[i].quescore)*100) +'%</td>'+
				    			'</tr>';
				    		var totalscore = '<tr>'+
				    				'<th>总分</th>'+
				    				'<td>'+ ((Math.round(totalquescore*10))/10) +'</td>'+
				    				'<td>'+ ((Math.round(totalmyscore*10))/10)+'</td>'+
				    				'<td>'+ ((Math.round(totalavgscore*10))/10) +'</td>'+
				    				'<td>'+  Math.round((totalmyscore/totalquescore)*100) +'%</td>'+
				    			'</tr>';
				    			relationship +=  excellent;
				   	}
				   	if(!relationship){
				   		relationship = '';
				   	}
				   	if(!totalscore){
				   		totalscore = '';
				   	}
			   		var quetypeSd =  '<div id="containerSd" style="min-width: 400px; width: 1000px; height: 250px; margin: 0 auto;  margin-top: 20px;"></div><div class="boxF"><table class="table" style="margin: 0 auto;" width="60%"><tr><td></td><th>分值</th><th>我的分数</th><th>平均分</th><th>我的得分率</th></tr>'+ relationship + totalscore +'</table></div>';
			   		$('.quetype').empty().append(quetypeSd);

				   $('#containerSd').highcharts({
					        chart: {
					            type: 'column'
					        },
					         title: {
					            text: ''
					        },
					        credits:{
							     enabled:false // 禁用版权信息
							},
					        xAxis: {
					            categories: categories,
					            crosshair: true
					        },
					        yAxis: {
					            min: 0,
					            title: {
					                text: '得<br>分<br>率<br>︵<br>%<br>︶',
					                rotation:0,
					                style:{
					                	fontSize: '15px',
					                	fontFamily:'微软雅黑',
					                	color:'#000'
					                }
					            },
					            tickPositions: [0, 25, 50,75, 100]
					        },
					        tooltip: {
					            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
					            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
					            '<td style="padding:0"><b>{point.y:.1f} %</b></td></tr>',
					            footerFormat: '</table>',
					            shared: true,
					            useHTML: true
					        },
					        plotOptions: {
					            column: {
					                pointPadding: 0.2,
					                borderWidth: 0
					            },
					            series: {
			                        borderWidth: 0,
			                        dataLabels: {
			                            enabled: true,
			                            format: '{point.y}%',
			                            allowOverlap : true
			                        }
			                    }
					        },
					        series: [{
					            name: '班级平均得分率',
					            color: '#999999',
					            data: data
					        }, {
					            name: '我的得分率',
					            color: '#7CB5EC',
					            data: dataM
					        }]
					    });
			  	}
			   	
			   }
}
function getElist(order,url){
			if(typeof url == "undefined") {
				url = '/college/examv2/alistAjax.html';
			}
			$.ajax({
				url:url,
				method:'post',
				dataType:'json',
				data : {
					'order' : order,
					'eid' : eid,
					'sstatus': 1,
					'classid':classid
				}
			}).done(function(res){
				var $pagedom = $(res.datas.pagestr);
				
				$pagedom.find('.listPage a').bind('click',function(){
					var url = $(this).attr('data');
					var estype = $('.curr').attr('data');
					if(!!url) {
						getElist(estype,url);
					}
				});
				$('.datatab tr.first').nextAll().remove();
				$("#mpage").empty().append($pagedom);
				for(var i = 0,len = res.datas.userAnswerList.length;i<len;i++) {
					var userAnswer = res.datas.userAnswerList[i];
					var data = {
						eid : eid,
						userAnswer : userAnswer.aid,
						anstotalscore : userAnswer.anstotalscore,
						correctrat : userAnswer.correctrat,
						ansdateline : getLocalTime(userAnswer.ansdateline),
						datelineStr : userAnswer.datelineStr,
						face : userAnswer.face,
						sex : userAnswer.sex,
						realname : userAnswer.realname,
						status : userAnswer.status,
						usedtime : userAnswer.usedtime,
						status : userAnswer.status,
						username: userAnswer.username
					}
		
					var $dom = $(template('t:answer',data));
					//$('.datatab tbody tr.first').nextAll().remove();
					$(".datatab tbody").append($dom);
				}
				
				//renderExamList(res.datas.examList);
				//parent.resetmain();
			}).fail(function(){
				console.log('req err');
			});
		}
	function getclass(url) {
		if(typeof url == "undefined") {
			url = '/college/examv2/stuSummaryAjax.html';
		}
		$.ajax({	
			url:url,
			method:'post',
			dataType:'json',
			data:{
				'eid':eid,
				'k':k,
				'classid':classid
			}
		}).done(function(res){
			var myclassid = res.myclassid;
			var classcheckbut = '';
			if(res.datas.efenxistu.class){
		    	for(var i=0;i<res.datas.efenxistu.class.length;i++){
		    		for(var j=0;j<myclassid.length;j++){
		    			if(res.datas.efenxistu.class[i].classid == myclassid[j]){
		    				classcheckbut+='<a classid="'+res.datas.efenxistu.class[i].classid+'">'+res.datas.efenxistu.class[i].classname+'</a>';
		    			}
		    		}
		    		classid.push(res.datas.efenxistu.class[i].classid)
		    	}
		    }
		    classid = classid.join();
		    classcheckbut = '关联班级:  <a classid="'+classid+'" class="active">全部</a>'+ classcheckbut;
		    $('.classlist').empty().append(classcheckbut);
		    $('.jisret').text(res.datas.efenxistu.esubject);
			var  mk_j_numHtml =  '<span class="mk_j_rank">'+ res.datas.efenxistu.level+'/</span>'+(res.datas.efenxistu.answercounts == 0?res.datas.efenxistu.level:res.datas.efenxistu.answercounts);
			var  mk_j_rankHtml =  '<span class="mk_j_rank">'+Math.ceil(res.datas.efenxistu.userdtime/60)+'/</span>'+res.datas.efenxistu.examlimittime+'分钟';
			$('.mk_j_num').html(mk_j_numHtml)
			$('.mk_y_time').html(mk_j_rankHtml)
			var mk_j_num =  Math.round((res.datas.efenxistu.submitcount/res.datas.alluserscount)*100)+'%';
			var mkNumb = Math.round(((parseFloat(mk_j_num))/10));
			$('.pusTime').text('完成时间：' +res.datas.efenxistu.dateline)
			$('.limittime').text('用时：' + Math.ceil(res.datas.efenxistu.userdtime/60) + '分钟')
			$('.scorelab').text('得分 ：' + res.datas.efenxistu.anstotalscore + '分')
			for(var i=0;i<=(mkNumb -1);i++){
		    	var onR = $('.onR img');
		    	$(onR[i]).show();
		    }
		    var  fenxiA = [];
		    for(var i=0;i<res.datas.efenxistu.fenxi.length;i++){
		    	var fenxi = res.datas.efenxistu.fenxi[i];
		    	switch(fenxi.quetype)
				{
				case 'A':
				  	fenxi.quetype = '单选题';
				break;
				case 'B':
					fenxi.quetype = '多选题';
				break;
				case 'C':
					fenxi.quetype = '填空题';
				break;
				case 'D':
					fenxi.quetype = '判断题';
				break;
				case 'E':
					fenxi.quetype = '文字题';
				break;
				case 'H':
					fenxi.quetype = '主观题';
				break;
				case 'Z':
					fenxi.quetype = '文本行';
				break;
				case 'G':
					fenxi.quetype = '音频';
				break;
				case 'X':
					fenxi.quetype = '答题卡';
				break;
				case 'XTL':
					fenxi.quetype = '听力题';
				break;
				case 'XWX':
					fenxi.quetype = '完形填空';
				break;
				case 'XYD':
					fenxi.quetype = '阅读理解';
				break;
				case 'XZH':
					fenxi.quetype = '组合题';
				break;
				}
				fenxiA.push([fenxi.quetype,fenxi.count]);
		    }
		    $('#container1').highcharts({
		        chart: {
		            type: 'pie',
		            options3d: {
		                enabled: true,
		                alpha: 45,
		                beta: 0
		            },
		            style : {
					    fontFamily:"",
					    fontSize:'12px',
					    fontWeight:'bold',
					    color:'#006cee'
					  }
		        },
		        title: {
		            text: ''
		        },
		        tooltip: {
		            pointFormat: '{point.percentage:.1f}%</b>'
		        },
		        plotOptions: {
		            pie: {
		                allowPointSelect: true,
		                cursor: 'pointer',
		                depth: 18,
		                size : 190,
		                dataLabels: {
		                    enabled: true,
		                    format: '{point.name}',
		                    allowOverlap : true
		                }
		            }
		        },
		        credits:{
				     enabled:false // 禁用版权信息
				},
		        series: [{
		            type: 'pie',
		            name: '',
		            data: fenxiA
		        }]
		    });
		    classlistonclick();
		}).fail(function(){});
	}
	function getstuSummaryAjax(url) {
		if(typeof url == "undefined") {
			url = '/college/examv2/stuSummaryAjax.html';
		}
		$.ajax({	
			url:url,
			method:'post',
			dataType:'json',
			data:{
				
				'eid':eid,
				'k':k,
				'classid':classid
			}
		}).done(function(res){
			$('.jisret').text(res.datas.efenxistu.esubject);
			var  mk_j_numHtml =  '<span class="mk_j_rank">'+ res.datas.efenxistu.level+'/</span>'+(res.datas.efenxistu.answercounts == 0?res.datas.efenxistu.level:res.datas.efenxistu.answercounts);
			var  mk_j_rankHtml =  '<span class="mk_j_rank">'+Math.ceil(res.datas.efenxistu.userdtime/60)+'/</span>'+res.datas.efenxistu.examlimittime+'分钟';
			$('.mk_j_num').html(mk_j_numHtml)
			$('.mk_y_time').html(mk_j_rankHtml)
			var mk_j_num =  Math.round((res.datas.efenxistu.submitcount/res.datas.alluserscount)*100)+'%';
			var mkNumb = Math.round(((parseFloat(mk_j_num))/10));
			$('.pusTime').text('完成时间：' +res.datas.efenxistu.dateline)
			$('.limittime').text('用时：' + Math.ceil(res.datas.efenxistu.userdtime/60) + '分钟')
			$('.scorelab').text('得分 ：' + res.datas.efenxistu.anstotalscore + '分')
			for(var i=0;i<=(mkNumb -1);i++){
		    	var onR = $('.onR img');
		    	$(onR[i]).show();
		    }
		    var  fenxiA = [];
		    for(var i=0;i<res.datas.efenxistu.fenxi.length;i++){
		    	var fenxi = res.datas.efenxistu.fenxi[i];
		    	switch(fenxi.quetype)
				{
				case 'A':
				  	fenxi.quetype = '单选题';
				break;
				case 'B':
					fenxi.quetype = '多选题';
				break;
				case 'C':
					fenxi.quetype = '填空题';
				break;
				case 'D':
					fenxi.quetype = '判断题';
				break;
				case 'E':
					fenxi.quetype = '文字题';
				break;
				case 'H':
					fenxi.quetype = '主观题';
				break;
				case 'Z':
					fenxi.quetype = '文本行';
				break;
				case 'G':
					fenxi.quetype = '音频';
				break;
				case 'X':
					fenxi.quetype = '答题卡';
				break;
				case 'XTL':
					fenxi.quetype = '听力题';
				break;
				case 'XWX':
					fenxi.quetype = '完形填空';
				break;
				case 'XYD':
					fenxi.quetype = '阅读理解';
				break;
				case 'XZH':
					fenxi.quetype = '组合题';
				break;
				}
				fenxiA.push([fenxi.quetype,fenxi.count]);
		    }
		    $('#container1').highcharts({
		        chart: {
		            type: 'pie',
		            options3d: {
		                enabled: true,
		                alpha: 45,
		                beta: 0
		            },
		            style : {
					    fontFamily:"",
					    fontSize:'12px',
					    fontWeight:'bold',
					    color:'#006cee'
					  }
		        },
		        title: {
		            text: ''
		        },
		        tooltip: {
		            pointFormat: '{point.percentage:.1f}%</b>'
		        },
		        plotOptions: {
		            pie: {
		                allowPointSelect: true,
		                cursor: 'pointer',
		                depth: 18,
		                size : 190,
		                dataLabels: {
		                    enabled: true,
		                    format: '{point.name}',
		                    allowOverlap : true
		                }
		            }
		        },
		        credits:{
				     enabled:false // 禁用版权信息
				},
		        series: [{
		            type: 'pie',
		            name: '',
		            data: fenxiA
		        }]
		    });
		}).fail(function(){});
	}
function getDefenxiAjax(){
	var uids = '<?=$user['uid']?>';
     $.ajax({	
		url:'/college/examv2/efenxiAjax.html',
		method:'post',
		dataType:'json',
		data:{
			'eid' : eid,
			'bytype' : 'quetype',
			'uids' :uids,
			'classid':classid
		}
	}).done(function(res){
		
		for(var i=0;i<res.datas.efenxi.length;i++){
			dataM.push(subPercentage(efenxi[i].scoreRate,false));
		}
		return dataM;
	}).fail(function(){});	
}


function getLocalTime(nS) {     
    return new Date(parseInt(nS) * 1000).toLocaleString().replace(/年|月/g, "-").replace(/日/g, " ");      
}
Number.prototype.toPercent = function(){
	return (Math.round(this * 10000)/100).toFixed(0) + '%';
}   
function inpfocus(inp){
	var inpf = $(inp);
	if(inpf.val() == '请输入学生姓名'){
		inpf.attr('value','');
	}
}
function toPoint(percent){
    var str=percent*100;
    str= Math.round(str);
    return str +'%';
}
function tab(tobj,cls){
	$(tobj).each(function(){
	 	$(this).on('click',function(){
	 		$(tobj).removeClass(cls);
			$(this).addClass(cls);
	 	})
	 	
	})
	} 
function subPercentage(Percentage,bol){
	if(!Percentage){
		Percentage = 0;
	}
	var  Percent = parseInt(Percentage);
	if(!Percent){
		Percent = 0;
	}
	if(bol){
		return  Percent + '%';
	}else{
		return  Percent;
	}
}
function changeTwoDecimal_f(x){    
    var f_x = parseFloat(eval(x.value));    
    if (isNaN(f_x))    
    {    
        //alert('function:changeTwoDecimal->parameter error');    
        //return false;    
        return '0.00';//如果不是数字的话返回0.00  
    }    
    var f_x = Math.round(eval(x.value)*100)/100;    
    var s_x = f_x.toString();    
    var pos_decimal = s_x.indexOf('.');    
    if (pos_decimal < 0)    
    {    
        pos_decimal = s_x.length;    
        s_x += '.';    
    }    
    while (s_x.length <= pos_decimal + 2)    
    {    
        s_x += '0';    
    }    
    return s_x;    
}
function inittab(){
	getstuSummaryAjax();
	var type = $('.ui-tabs-nav li.workcurrent').attr('type');
	if(type == 'quetype'){
		var value = $('.lishnrt a.xhusre').attr('value');
		if(value == '0'){
			getfenxi('quetype',1);
		}else if(value == '1'){
			getfenxi('relationship',1);
		}
	}else if(type == 'que'){
		var value = $('.lishnrt1 a.xhusre').attr('value');
		if(value == '0'){
			getfenxi('que',1)
		}else if(value == '1'){
			getfenxi('que',2)
		}
	}
};
function classlistonclick(){
	/*getstuSummaryAjax();*/
	getfenxi('quetype') //que  按题型    level  优秀率   relationship  知识点
	$('.classlist a').each(function(){
		$(this).click(function(){
			$('.classlist a').removeClass('active');
			$(this).addClass('active');
			classid = $(this).attr('classid');
			inittab();
		})
	})
}
 
$(function(){
	getclass();
    tab('.lishnrt a','xhusre');
    tab('.lishnrt1 a','xhusre');
    function tabs(cls,ind,active){
    	$(cls).click(function(){
	        $(cls).eq($(this).index()).addClass(active).siblings().removeClass(active);
			$(ind).hide().eq($(this).index()).show();
			$('.lishnrt a').removeClass('xhusre').eq(0).addClass('xhusre');
			$('.lishnrt1 a').removeClass('xhusre').eq(0).addClass('xhusre');
		})
    }
    tabs(".ui-tabs-nav li",".ui-tabs-panel","workcurrent");
     tabs(".ui-tabs-nav li",".ui-tabs-panel","workcurrent");
	$('.totalscore').on('click',function(){
		$(this).toggleClass('completetimebP');
		if($(this).hasClass('totalscore')){	
			if($(this).hasClass('completetimebP')){
					getElist(4);
			}else{
					getElist(3);
			}
		}
	})
})
</script>
</body>
</html>
