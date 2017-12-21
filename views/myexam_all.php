<?php $this->display('common/page_header'); ?>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/date/WdatePicker.js"></script>

<div class="lefrig" style="border:solid 1px #cdcdcd;background:#fff;float:left;width:998px;">
<div class="workol">
<div class="work_menu" style="position:relative;">
    <ul>

		<li class="workcurrent"><a href="<?= geturl('myexam/all') ?>"><span>做作业</span></a></li>
		<li><a href="<?= geturl('myexam/my') ?>"><span>我做过的作业</span></a></li>
		<li><a href="<?= geturl('myexam/box') ?>"><span>草稿箱</span></a></li>
		<li><a href="<?= geturl('myerrorbook') ?>"><span>错题本</span></a></li>
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
		<input name="txtname" <?=$stylestr?> class="newsou" id="title" value="<?= $q?>" type="text" />
		<input type="button" onclick="searchs('title');return false;" class="soulico" value="">
	</div>
	<?php }?>
</div>
<script type="text/javascript">
	function searchs(strname){
		var sname = $('#'+strname).val();
		if(sname=='请输入搜索关键字'){
			sname = "";
		}
		location.href='<?= geturl('myexam/all')?>?q='+sname;
	}
</script>
 <div class="workdata" style="width:998px;">
	    	<table width="100%" class="datatab" style="border:none;">
				 <tbody>
<?php $target = stripos($_SERVER['HTTP_USER_AGENT'],'android') != false ?'_parent':'_blank'; ?>
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
					  <td style="border-top:none;">
	
	<div style="float:left;margin-right:15px;">
		<?php
			if(!empty($exam['itemid'])){
				$key = 'f_'.$exam['folderid'];
				$iname = array_key_exists($key, $iteminfo)?$iteminfo[$key]['iname']:"课程";
			}
		?>
		<a href="/myexam/all-1-0-0-<?= $exam['uid'] ?>.html"><img title="<?= empty($exam['realname'])?$exam['username']:$exam['realname'] ?>" src="<?=$face?>" /></a></div>
													<div style="float:left;width:900px;font-family:simsun;">
														<p style="width:760px;word-wrap: break-word;font-size:16px;;float:left;line-height:2;">
															<?php if(!empty($exam['itemid'])){?>
																<a  href="javascript:void(0)" onclick="showBuyDialog('<?=$iname?>',<?=$exam['itemid']?>)" style="color:#666;font-weight:bold;">
																	<?= $exam['title'] ?>
																</a>
															<?php }else{?>
																<a  href="http://exam.ebanhui.com/edo/<?= $exam['eid'] ?>.html?f=jz" target="<?= $target?>" style="color:#666;font-weight:bold;">
																	<?= $exam['title'] ?>
																</a>
															<?php }?>
														</p>

					<span style="float:right;width:70px;">
						
			
							<?php if($exam['astatus'] == 1) { ?>
							<a class="lviewbtn" href="http://exam.ebanhui.com/emark/<?= $exam['eid'] ?>.html" target="<?= $target?>">查看结果</a>
							<?php } else { ?>
							<?php 
								if(empty($exam['itemid'])){
									$dourl = 'http://exam.ebanhui.com/edo/'.$exam['eid'].'.html?f=jz';
								?>
									<a class="previewBtn" style="font-family: 宋体;" href="<?=$dourl?>" target="<?= $target?>">查看</a>
								<?php }?>
							<?php } ?>
					</span>
					<div style="float:left;width:790px;">
						
						
						<span class="huirenw" style="width:auto;float:left;color:#999;padding-left:0;background:none;">
							<a href="/myexam/all-1-0-0-<?= $exam['uid'] ?>.html" style="float:left;"><?= empty($exam['realname']) ? $exam['username'] : $exam['realname'] ?></a>
							<a class="hrelh" href="javascript:;" tid="<?=$exam['uid']?>" tname="<?= empty($exam['realname'])?$exam['username']:$exam['realname'] ?>" title="给<?=$exam['sex'] == 1 ? '她' : '他'?>发私信"></a> 于
							<?= date('Y-m-d H:i:s',$exam['dateline']) ?> 出题，总分为：<?= $exam['score'] ?>，答题人数：<?=$exam['answercount']?>，<?php if(empty($exam['limitedtime'])){echo '不计时';}else{echo '计时：'.$exam['limitedtime'].' 分钟';}?>
						</span>
						</div>
						
					</div>

					</td>
					  </tr>

					 <?php } ?>
				 <?php } else { ?>
					<tr>
				 		<td colspan="6" align="center" style="border-top:none;"><img  src="http://static.ebanhui.com/ebh/tpl/2014/images/zanwujilu.png"/></td>
				 	</tr>
				 <?php } ?>
					</tbody>
				</table>
				<?= $pagestr ?>
	    </div>



	</div>
</div>
<script type="text/javascript">

<?php if (($roominfo['isschool'] == 6 || $roominfo['isschool'] == 7) && $check != 1) { ?>
$(function(){
	if(window.parent != undefined) {
		<?php if(!empty($payitem)) { ?>
			if(window.parent.setiinfo != undefined) {
				window.parent.setiinfo("<?= $payitem['iname'] ?>","<?= empty($checkurl) ? '' : $checkurl ?>");
			}
		<? } ?>
		window.parent.showDivModel(".nelame");
	}
});

<?php } ?>
function showBuyDialog(iname,itemid){
	alert("没有购买课程");
}
$(function(){
	var searchtext = "请输入搜索关键字";
	initsearch("title",searchtext);
	$("#ser").click(function(){
		var title = $("#title").val();
		if(title == searchtext) 
		title = "";
		var url = '<?= geturl('myexam/all') ?>' + '?q='+title;
		<?php if(!empty($folder)){
			$itemid = $this->input->get('itemid');?>
		url += '&folderid=<?=$folder['folderid']?>';
		url += '&itemid=<?=!empty($itemid)?$itemid:''?>';
		<?php }?>
		document.location.href = url;
	});
	<?php if(!empty($folder)){?>
		$.each($('.work_menu li a'),function(k,v){
			$(this).attr('href',$(this).attr('href')+'?folderid=<?=$folder['folderid']?>&itemid=<?=$itemid?>');
		});
	<?php }?>
});
</script>
