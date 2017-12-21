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

         <li><a href="<?= geturl('exam/un') ?>"><span>待做作业</span></a></li>
		 <li><a href="<?= geturl('exam') ?>"><span>我做过的作业</span></a></li>  
		  <li class="workcurrent"><a href="<?= geturl('exam/box') ?>"><span>草稿箱</span></a></li> 
    </ul>
</div>

    <div class="workdata">
         <table width="100%" class="datatab" style="border:none;">
				<thead class="tabhead">
					  <tr>
						<th>作业名称</th>
						<th>出题教师</th>
						<th>出题时间</th>
						<th>总分/得分</th>
						<th>答题时间</th>
                        <th>已答人数</th>
					  </tr>
			  	</thead>
				<tbody>
				<?php if(!empty($exams)) { ?>
					<?php foreach($exams as $exam) { ?>
						  <tr>
							<td style="width:280px;" title="<?= $exam['title']?>"><span style="width:400px;word-wrap: break-word;float:left;"><?= shortstr($exam['title'],50)?></span></td>
							<td style="width:60px;"><?= empty($exam['realname'])?$exam['username']:$exam['realname'] ?></td>
							<td style="width:100px;"><?= date('Y-m-d H:i',$exam['dateline'])?></td>
							<td style="width:60px;"><?= $exam['score'] ?>/<?= round($exam['totalscore'],2)?></td>
							<td style="width:100px;"><?= date('Y-m-d H:i',$exam['adateline'])?></td>
							<td style="width:60px;"><?= $exam['answercount'] ?></td>
						
						  </tr>
					<?php } ?>
				<?php } else { ?>
 					<tr>
						<td colspan="8" align="center">暂无记录</td>
					</tr>
				<?php } ?>
			  	</tbody>
		  </table>
		  <?= $pagestr ?>
    </div>
</div>
<div class="clear"></div>
