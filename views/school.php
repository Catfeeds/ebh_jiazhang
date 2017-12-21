<?php 
$this->assign('notop',TRUE);
$this->display('common/page_header'); ?>

<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery.cookie.js"></script>
<?php $curdomain=$this->uri->curdomain;?>
<link href="http://static.ebanhui.com/ebh/tpl/default/css/tertion.css" rel="stylesheet" type="text/css" />
<style>
.waimas{ background:#fff; margin-top:20px; width:998px; border:1px solid #e5e5e5;}
.waimas .xiaziz{ background:none; height:160px;}
.waimas .xiaziz .rigsui h4{border-bottom:none;  }
.waimas .xiaziz .rigsui h4 a{font-weight:bold; font-family:"微软雅黑"; font-size:18px;color:#1293ec;}
.ruwangbtn{ left:637px;}
.xiaziz .lefwert{border:1px solid #efefef;}
.titxiawen{padding:0; border-bottom:1px solid #e5e5e5; margin:0 20px;color:#333;}
.ruwangbtn{display:block; width:132px; height:36px; line-height:36px; background:#18a8f7; text-align:center; color:#fff !important;font-size:14px !important; font-weight:normal !important;}
a.ruwangbtn:hover{ background:#0d9be9;text-decoration: none;}
</style>
<div class="clay_topfixed">
	<div class="clay_topfixed_inner">
		<div class="ctoolbar">
			<div class="chead">
				<div class="csubnav">
					|<a href="http://www.ebh.net">e板会首页</a>
				</div>
				<div class="userinfo">您好 ，<?= empty($user['realname'])? $user['username'] : $user['realname'] ?>&nbsp;&nbsp;   <a href="/logout.html" target='_self'>退出</a> </div>
			</div>
		</div>
	</div>
</div>
<div class="ctopnew">
	<div class="cheadpicnew"><img src="http://static.ebanhui.com/ebh/tpl/default/images/cheadpic0327.jpg" /></div>
</div>


<div class="waimas" style="overflow: hidden;">
<h2 class="titxiawen">我的网络学校</h2>

<?php foreach($roomlist as $room) { 
$roomurl = 'http://'.$room['domain'].'.ebh.net/troom.html';
$cface = empty($room['cface'])?'http://static.ebanhui.com/ebh/tpl/default/images/elist_tx.jpg':$room['cface'];
?>

<div class="xiaziz" style="background:#fff;">
<div class="lefwert">
<a href="<?=geturl($room['crid'])?>" title="<?= $room['crname'] ?>" alt="<?= $room['crname'] ?>"><img src="<?= $cface ?>" style="width:100px;height:100px"/></a>
</div>
<div class="rigsui">
<h4><a href="<?=geturl($room['crid'])?>" title="<?= $room['crname'] ?>"><?= $room['crname'] ?></a><a class="ruwangbtn"  href="<?=geturl($room['crid'])?>">进入网校</a></h4>
<p class="xiuek"><?= shortstr($room['summary'],380,'……') ?></p>
</div>
</div>
<?php } ?>
</div>
<div class="clear"></div>

