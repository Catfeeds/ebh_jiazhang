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
       var url = '<?= geturl('askquestion/myquestion') ?>' + '?q='+title;
       document.location.href = url;
   });
});
</script>
<title>学生答疑</title>
</head>

<body>

<div class="mainst">
<div class="ter_tit"> 当前位置 > 学生答疑 </div>
<div class="lefrig" style="border:solid 1px #cdcdcd;background:#fff;float:left;">
<div class="workol">
	<div class="work_mes">
		<ul>
			<li><a href="<?= geturl('askquestion') ?>"><span>全部问题</span></a></li>
			<li class="workcurrent"><a href="<?= geturl('askquestion/myquestion') ?>"><span>我的问题</span></a></li>
			<li><a href="<?= geturl('askquestion/myanswer') ?>"><span>我的回答</span></a></li>
			<li><a href="<?= geturl('askquestion/myfavorit') ?>"><span>我的关注</span></a></li>
		</ul>

	</div>
	
<div class="diles">
					<?php
						$q= empty($q)?'':$q;
						if(!empty($q)){
							$stylestr = 'style="color:#000"';
						}else{
							$stylestr = "";
						}
					?>
					<input name="uname" <?=$stylestr?> class="newsou" id="title" value="<?= empty($aq)?$q:$aq ?>"  type="text" />
					<input type="button" id="ser" class="soulico" value="">
				</div>
			<div class="workdata" style="margin-top:0px;float:left;">
				
				<table  width="100%" class="datatab" style="border:none;">
			 	 <thead class="tabhead" >
			  	</thead>
			  	<tbody>			  
                                <?php if(empty($asks)) { ?>
			  		<tr><td colspan="5" align="center" style="border:none;">目前没有我的问题</td></tr>
							<?php } else { ?>
                                        <?php foreach($asks as $akey=>$avalue) { ?>
                         <?php 
						//var_dump($avalue);
							if(!empty($avalue['face']))
								$face = getthumb($avalue['face'],'50_50');
							else{
								if($avalue['sex']==1){
									if($avalue['groupid']==5){
										$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/t_woman.jpg';
									}else{
										$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/m_woman.jpg';
									}
								}else{
									if($avalue['groupid']==5){
										$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/t_man.jpg';
									}else{
										$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/m_man.jpg';
									}
								}
							
								$face = getthumb($defaulturl,'50_50');
							} 
						?>                
				 		<tr>
						<td style="border-top:none;">					
							<div style="float:left;margin-right:15px;"><img title="<?= empty($avalue['realname'])?$avalue['username']:$avalue['realname'] ?>" src="<?=$face?>" /></div>
							<div style="float:left;width:900px;font-family:Microsoft YaHei;">
								<p style="width:580px;word-wrap: break-word;margin-bottom:10px;font-size:14px;;float:left;line-height:2;">
									<?php if($avalue['status']==1){ ?>
										<img src="http://static.ebanhui.com/ebh/tpl/default/images/title.png" style="margin-right:5px;"/>
									<?php } ?>
									<a   href="<?= geturl('askquestion/'.$avalue['qid']) ?>" style="color:#777;font-weight:bold;"> 
									<?= $avalue['title'] ?>
									</a>
								</p>

								<span class="dashu">回答数<br/><?= $avalue['answercount'] ?></span>
							<div style="float:left;width:600px;">
							<span style="width:150px;float:left;"><?= Date('Y-m-d H:i:s',$avalue['dateline']) ?></span>
							<span class="huirenw" style="width:100px;float:left;"><?= empty($avalue['realname'])?$avalue['username']:$avalue['realname'] ?></span>
							<span class="ketek"><?= $avalue['foldername'] ?></span>
							</div>
						</div>
												</td>
				    	</tr>
                                        <?php } ?>

                                <?php } ?>

			  	</tbody>


				</table>
				
			</div>
                        <?= $pagestr ?>
</div>
</div>
</div>
<div class="clear"></div>
