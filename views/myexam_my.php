<?php $this->display('common/page_header'); ?>

<div class="lefrig" style="border:solid 1px #cdcdcd;background:#fff;float:left;width:998px;">

<div class="workol">
<div class="work_menu" style="position:relative;">
    <ul>
		<li><a href="<?= geturl('college/examv2') ?>"><span>未做</span></a></li>
		<li class="workcurrent"><a href="<?= geturl('college/examv2/my')?>"><span>做过的作业</span></a></li>
		<li><a href="<?= geturl('college/examv2/box')?>"><span>草稿箱</span></a></li>
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
    <div class="workdata" style="width:998px;">
         <table width="100%" class="datatab" style="border:none;">
				<thead class="tabhead">
					  <tr>
						<th>作业名称</th>
						<th>出题教师</th>
						<th>出题时间</th>
						<th>答题时间</th>
						<th>用时</th>
						<th>总分/得分</th>
                        <th>已答人数</th>
						<th>操作</th>
					  </tr>
			  	</thead>
				<tbody>
					
				
				<?php if(!empty($exams)) { ?>
					<?php foreach($exams as $exam) {?>
						  <tr>
							<td style="width:200px;" title="<?= $exam['title'] ?>"><?= shortstr($exam['title'],30) ?></td>
							<td style="width:70px;"><?= empty($exam['realname'])?$exam['username']:$exam['realname'] ?></td>
							<td style="width:70px;"><?= date('Y-m-d H:i',$exam['dateline']) ?></td>
							<td style="width:70px;"><?= date('Y-m-d H:i',$exam['adateline'])?></td>
							<td style="width:70px;"><?= ceil($exam['completetime']/60)?>分钟</td>
							<td style="width:70px;"><?= $exam['score']?>/<?= round($exam['totalscore'],2) ?></td>
							<td style="width:60px;"><?= $exam['answercount'] ?></td>
							<td style="width:76px;">
							<?php $target = stripos($_SERVER['HTTP_USER_AGENT'],'android') != false ?'_parent':'_blank'; ?>
							<?php if($exam['astatus'] == 1) { ?>
								<a class="lviewbtn" href="http://exam.ebanhui.com/emark/<?= $exam['eid'] ?>.html" target="<?= $target?>">查看结果</a>
							<?php } else { ?>
								<a class="previewBtn" href="http://exam.ebanhui.com/edo/<?= $exam['eid'] ?>.html?f=jz" target="<?= $target?>">查看</a>
							<?php } ?>

							</td>
						  </tr>
					<?php } ?>

				<?php } else { ?>
 					<tr>
						<td colspan="8" align="center"><img  src="http://static.ebanhui.com/ebh/tpl/2014/images/zanwujilu.png"/></td>
					</tr>
                    <?//=nocontent()?>
                <?php } ?>
			  	</tbody>
		  </table>

		  <?= $pagestr ?>
    </div>
</div>
</div>
<script type="text/javascript">
<?php if (($roominfo['isschool'] == 6 || $roominfo['isschool'] == 7) && $check != 1) { 
					?>
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
$(function(){
	var searchtext = "请输入搜索关键字";
	initsearch("title",searchtext);
	$("#ser").click(function(){
		var title = $("#title").val();
		if(title == searchtext) 
		title = "";
		var url = '<?= geturl('college/examv2/my') ?>' + '?q='+title;
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
function searchs(strname){
	var sname = $('#'+strname).val();
	if(sname=='请输入搜索关键字'){
		sname = "";
	}
	
	location.href='<?= geturl('college/examv2/my')?>?q='+sname;
}
</script>
