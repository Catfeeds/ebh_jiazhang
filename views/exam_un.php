<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link type="text/css" rel="stylesheet" href="http://static.ebanhui.com/jiazhang/css/jzxiang.css" />
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/common.js"></script>
<link type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/jquery-ui/css/default/jquery-ui-1.8.1.custom.css" rel="stylesheet" />	
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/jquery-ui/jquery-ui-1.8.1.custom.min.js"></script>

<script type="text/javascript">
var searchtext = "请输入关键字";
$(function() {
   initsearch("title",searchtext);
   $("#ser").click(function(){
       var title = $("#title").val();
       if(title == searchtext) 
           title = "";
       var url = '<?= geturl('askquestion') ?>' + '?q='+title;
       document.location.href = url;
   });
});
</script>
<title>历史作业</title>
</head>

<body>

<div class="mainst">
<div class="ter_tit"> 当前位置 > 历史作业 </div>
<div class="lefrig" style="border:solid 1px #cdcdcd;background:#fff;float:left;">
<div class="workol">
<div class="work_menu">
    <ul>

         <li class="workcurrent"><a href="<?= geturl('exam/un') ?>"><span>待做作业</span></a></li>
		 <li><a href="<?= geturl('exam') ?>"><span>我做过的作业</span></a></li>  
		  <li><a href="<?= geturl('exam/box') ?>"><span>草稿箱</span></a></li> 
    </ul>
</div>
<script type="text/javascript">
	function searchs(strname){
		var sname = $('#'+strname).val();
		if(sname=='请输入搜索关键字'){
			sname = "";
		}
		// var tdate = $('#sdate').val(); 
		// location.href='<?= geturl('myroom/myexam/all')?>?q='+sname+'&d='+tdate;
		location.href='<?= geturl('exam')?>?q='+sname;
	}
</script>
 <div class="workdata">
	    	<table width="100%" class="datatab" style="border:none;">
				 <tbody>
<!--<?php $target = stripos($_SERVER['HTTP_USER_AGENT'],'android') != false ?'_parent':'_blank'; ?>-->
				 <?php if(!empty($exams)) { ?>
					<?php foreach($exams as $exam) { ?>
						<?php 
							if(!empty($exam['face'])){
								$face = getthumb($exam['face'],'50_50');
							}else{
								if($exam['sex']==1){
									if($exam['groupid']==5){
										$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/t_woman.jpg';
									}else{
										$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/m_woman.jpg';
									}
								}else{
									if($exam['groupid']==5){
										$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/t_man.jpg';
									}else{
										$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/m_man.jpg';
									}
								}
							
								$face = getthumb($defaulturl,'50_50');
							} 
						?>  
					  <tr>
					  <td>
	
	<div style="float:left;margin-right:15px;">
		<img title="<?= empty($exam['realname'])?$exam['username']:$exam['realname'] ?>" src="<?=$face?>" /></div>
													<div style="float:left;width:900px;font-family:Microsoft YaHei;">
														<p style="width:580px;word-wrap: break-word;margin-bottom:10px;font-size:14px;;float:left;line-height:2;">
															<?= shortstr($exam['title'],50) ?>
														</p>

			
					<div style="float:left;width:550px;">
						
						
						<span class="huirenw" style="width:auto;float:left;">
							<?= empty($exam['realname']) ? $exam['username'] : $exam['realname'] ?> 于
							<?= date('Y-m-d H:i:s',$exam['dateline']) ?> 出题，总分为：<?= $exam['score'] ?>，答题人数：<?=$exam['answercount']?>，<?php if(empty($exam['limitedtime'])){echo '不计时';}else{echo '计时：'.$exam['limitedtime'].' 分钟';}?>
						</span>
						</div>
						
					</div>

					</td>
					  </tr>

					 <?php } ?>
				 <?php } else { ?>
					<tr>
				 		<td colspan="6" align="center" style="border-top:none;">暂无记录</td>
				 	</tr>
				 <?php } ?>
					</tbody>
				</table>
				<?= $pagestr ?>
	    </div>



	</div>
</div>
<div class="clear"></div>
