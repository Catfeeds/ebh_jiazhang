<?php 
$this->assign('notop',TRUE);
$this->display('troom/page_header'); ?>
<link href="http://static.ebanhui.com/ebh/tpl/default/css/tertion.css" rel="stylesheet" type="text/css" />
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


<div class="waimas">
<h2 class="titxiawen">我的网络学校</h2>

<?php foreach($plist as $proom) { 
$proomurl = 'http://'.$proom['domain'].'.ebh.net/troom.html';
?>

<?php if(count($proom['child']) > 0) { ?>
<div class="neiksd">
<div class="topnei"></div>
<div class="massnei">
<div class="youmass">

<div class="zongwang">
<div class="leftuk">
<a href="<?= $proomurl ?>" title="<?= $proom['crname'] ?>" alt="<?= $proom['crname'] ?>"><img src="<?= empty($proom['cface'])?'http://static.ebanhui.com/ebh/tpl/default/images/elist_tx.jpg':$proom['cface'] ?>" style="width:100px;height:100px"/></a>
</div>
<div class="titlefsi">
<h2 class="secu"><a href="<?= $proomurl ?>"><?= $proom['crname'] ?></a></h2>
<p style="margin:12px 0px;">学习子站：<span><?= count($proom['child']) ?></span>个 </p>
<a href="<?= $proomurl ?>" class="ruzong"></a>
</div>
<div class="rigsil">
<?= shortstr($proom['summary'],380,'……') ?>
</div>
</div>

<ul style="margin-top:15px;">

<?php foreach($proom['child'] as $croom) { 
$cface = empty($croom['cface'])?'http://static.ebanhui.com/ebh/tpl/default/images/elist_tx.jpg':$croom['cface'];
$croomurl = 'http://'.$croom['domain'].'.ebh.net/troom.html';
?>

<li class="lianse" onmouseover="this.className='lianse2'" onmouseout="this.className='lianse'">
<div class="lefzitu">
<a href="<?= $croomurl ?>" title="<?= $croom['crname'] ?>" alt="<?= $croom['crname'] ?>"><img src="<?= $cface ?>" style="width:100px;height:100px"/>
</div>
<div class="rigzise">
<h2 style="font-weight:bold;"><a href="<?= $croomurl ?>" style="color:#667A88"><?= $croom['crname'] ?></a></h2>
<a class="jinwang" href="<?= $croomurl ?>"></a>
<p>课件数量：<span><?= $croom['coursenum'] ?></span>个</p>
<p>学员数量：<span><?= $croom['stunum'] ?></span>个</p>
<p>教师数量：<span><?= $croom['teanum'] ?></span>个</p>
</div>
</li>
<?php } ?>

</ul>

</div>
</div>
<div class="fotnei"></div>
</div>

<?php } else { ?>
<div class="xiaziz">
<div class="lefwert">
<a href="<?= $proomurl ?>" title="<?= $proom['crname'] ?>" alt="<?= $proom['crname'] ?>"><img src="<?= empty($proom['cface'])?'http://static.ebanhui.com/ebh/tpl/default/images/elist_tx.jpg':$proom['cface'] ?>" style="width:100px;height:100px"/></a>
</div>
<div class="rigsui">
<h4><a href="<?= $proomurl ?>" title="<?= $proom['crname'] ?>"><?= $proom['crname'] ?></a><a class="ruwangbtn" href="<?= $proomurl ?>">进入网校</a></h4>
<p class="xiuek"><?= shortstr($proom['summary'],380,'……') ?></p>
</div>
</div>
<?php }
} ?>

<?php foreach($nopchildlist as $croom) { 
$croomurl = 'http://'.$croom['domain'].'.ebh.net/troom.html';
$cface = empty($croom['cface'])?'http://static.ebanhui.com/ebh/tpl/default/images/elist_tx.jpg':$croom['cface'];
?>

<div class="xiaziz">
<div class="lefwert">
<a href="<?= $croomurl ?>" title="<?= $croom['crname'] ?>" alt="<?= $croom['crname'] ?>"><img src="<?= $cface ?>" style="width:100px;height:100px"/></a>
</div>
<div class="rigsui">
<h4><a href="<?= $croomurl ?>" title="<?= $croom['crname'] ?>"><?= $croom['crname'] ?></a><a class="ruwangbtn" href="<?= $croomurl ?>">进入网校</a></h4>
<p class="xiuek"><?= shortstr($croom['summary'],380,'……') ?></p>
</div>
</div>
<?php } ?>
</div>
<div class="clear"></div>
<?php $this->display('troom/page_footer'); ?>
<style>
.waimas{ background:#fff; margin-top:20px; width:998px; border:1px solid #e5e5e5;}
.waimas .xiaziz{ background:none; height:160px;}
.waimas .xiaziz .rigsui h4{border-bottom:none;  }
.waimas .xiaziz .rigsui h4 a{font-weight:bold; font-family:"微软雅黑"; font-size:18px;color:#1293ec;}
.ruwangbtn{ left:637px;}
.xiaziz .lefwert{border:1px solid #efefef;}
.titxiawen{padding:0; border-bottom:1px solid #e5e5e5; margin:0 20px;color:#333;}
.ruwangbtn{display:block; width:132px; height:36px; line-height:36px; background:#18a8f7; text-align:center; color:#fff !important;font-size:14px !important; font-weight:normal !important;}
a.ruwangbtn:hover{ background:#0d9be9;}
</style>