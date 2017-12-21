<script type="text/javascript">
//	$(function(){
//		$("a[href*=#]").attr("href",'javascript:void(0)');
//	});

</script>
<div id="footer">
	<?php 
		if(empty($room))
			$room = Ebh::app()->room->getcurroom();
        if($room==false || $room['domain']=='hz'){ 
			if($this->uri->uri_domain() == 'www' || $this->uri->uri_domain() == 'hz') {
				$catlib = Ebh::app()->lib('Category');
				$catlist = $catlib->getCateByPos(2);
	?>
		<p class="flinks">
			<?php foreach($catlist as $key=>$cat) { ?>
			<?= $key != 0 ? ' | ':'' ?>
			<a href="<?php if(empty($cat['caturl'])){?><?= geturl($cat['code'])?><?php }else{ ?><?= $cat['caturl']?><?php }?>" title="<?= $cat['name']?>" target="_blank"><?= $cat['name']?></a>
			<?php } ?>
			<span>|</span><a href="http://weibo.com/ebanhui" target="_blank">关注e板会微博</a> <img src="http://static.ebanhui.com/ebh/tpl/2012/images/sina.png" />	
		</p>
		<?php } ?>
    <?php } ?>
<?php $file = $this->uri->uri_method();?>
    <?php if(($file=='index'&&$room==false) || ($room==true&&$room['domain']=='hz')){?>

		<?php if(($this->uri->uri_domain() == 'www' && ($this->uri->codepath == '' || $this->uri->codepath == 'index')) || ($this->uri->uri_domain() == 'hz')) { 
			$itemlib = Ebh::app()->lib('Items');
			$linklist = $itemlib->getitemslink();
		?>
		<p class="flinks">
			<?php foreach($linklist as $key=>$linkitem) { ?>
			<?= $key != 0 ? ' | ':'' ?>
				<a href="<?= empty($linkitem['itemurl'])?geturl($linkitem['code']):$linkitem['itemurl'] ?>" title="<?= $linkitem['subject'] ?>" target="_blank"><?= $linkitem['subject'] ?></a>
			<?php } ?>
		</p>
		<?php } ?>
    <?php } ?>
    <p class="copyright"><a target="_blank" href="http://www.miibeian.gov.cn/">浙ICP备11027462号</a>&nbsp;&nbsp;Copyright &copy; <?= '2011-'.date('Y') ?> ebh.net All Rights Reserved &nbsp;&nbsp;

        <?php if($file=='index'&&$room==false){?>
			<?php if($this->uri->uri_domain() == 'www' && ($this->uri->codepath == '' || $this->uri->codepath == 'index')) { ?>
			<br />
			<a href="http://122.224.75.236/wzba/login.do?method=hdurl&doamin=http://www.ebanhui.com&id=330105000201409&SHID=1223.0AFF_NAME=com.rouger.
			   gs.main.UserInfoAff&AFF_ACTION=qyhzdetail&PAGE_URL=ShowDetail"
			   target="_blank"> <img src="http://static.ebanhui.com/ebh/tpl/2012/images/gh.jpg" border="0"></a>&nbsp;&nbsp;<a target="_blank" rel="nofollow" href="http://www.pingpinganan.gov.cn" title="杭州网络警察"><img src="http://static.ebanhui.com/ebh/tpl/2012/images/hzjc.gif" alt="杭州网络警察" title="杭州网络警察"></a>&nbsp;&nbsp;<a href="http://www.miibeian.gov.cn" target="_blank" rel="nofollow" title="网站备案">
				<img src="http://static.ebanhui.com/ebh/tpl/2012/images/beian.jpg" alt="网站备案"></a>&nbsp;&nbsp;<a href="http://net.china.com.cn/" target="_blank" title="不良信息举报">
				<img src="http://static.ebanhui.com/ebh/tpl/2012/images/jubao.jpg" alt="不良信息举报"></a>&nbsp;&nbsp;<a href="http://www.wenming.cn/" target="_blank" title="文明网站">
				<img src="http://static.ebanhui.com/ebh/tpl/2012/images/wenming.jpg" alt="文明网站"></a>
			<br /><br />
			<?php } ?>
        <?php } ?>
    </p>
</div>
</div>

<script src="http://static.ebanhui.com/ebh/js/index.js" type="text/javascript"></script>
<!--外网不要-->
<?php
debug_info();
?>

<!-- 统计代码开始 -->
<?php EBH::app()->lib('Analytics')->get('baidu')?>
<!-- 统计代码结束 -->

</body>
</html>
