<?php $this->assign('notop',TRUE);$this->display('common/page_header'); ?>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/tzds.css" />
<style type="text/css">
		html {background:#f5f5f5;}
	</style>
	<style type='text/css' media='print'>
		.bottali {display: none;}
		.reviewnoitce {display: none;}
	</style>
	<div class="waimg" style="background:url(http://static.ebanhui.com/ebh/tpl/default/images/tongzhitou0114.jpg) no-repeat;width:960px;padding-top:85px;">
		<div class="mseng" style="width:960px;">
			<h2 class="rlyop"><?= $notice['title'] ?></h2>
			<p class="stimes">发送时间：<?= date('Y-m-d H:i',$notice['dateline']) ?></p>
			<div style="padding:0 30px;font-size:16px;"><p class="twotsne"><?=  h($notice['message']) ?></p>
		
		</div>
		
			<div class="bottali" style="text-align:center;">
				<?php
				if(!empty($attfile)){
				?>
				<span style="float:left;margin-left:8px;margin-right:-150px;">
				附件:
				<a style="color:red" href="<?=$attfile['source'].'attach.html?noticeid='.$notice['noticeid']?>"><?=$attfile['title']?></a>
				</span>
				<?php }?>
				<a href="javascript:;" class="huangbbtn printnotice" style="display:inline;">打 印</a>
				<a href="javascript:;" onclick="closew()" class="lanbbtn">关 闭</a>
			</div>
		</div>
	</div>

	<script type="text/javascript">
		$(".printnotice").click(function(){
			window.document.title="打印通知";
			window.print();
		});
		function closew(){
			var opened=parent.window.open(' ','_self');
			opened.close();
		}
	</script>
