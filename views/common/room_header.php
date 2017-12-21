<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?= $room['crname']?></title>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" />
<link href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css?d=20150403" rel="stylesheet" type="text/css" />
<link href="http://static.ebanhui.com/ebh/tpl/default/css/common.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/college/style.css?v=20151015001"/>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery.cookie.js"></script>
<style type="text/css">
a:hover{
	text-decoration: none;
}
</style>
<script type="text/javascript">
$(function(){
	    var myroom =$("#myotherroom");
		var timeout = null;

		
	myroom.mouseover(function(){
		clearTimeout(timeout);
		$(this).addClass("acurrent");
		$(".classroombox").slideDown();
	}).mouseout(function(){
		clearTimeout(timeout);
		var _this = this;
		timeout = setTimeout(function(){
			$(".classroombox").slideUp("slow",function(){
				$(_this).removeClass("acurrent");			
			});
		},500);
	});
	$(".classroombox").mouseover(function(){
		clearTimeout(timeout);
	}).mouseout(function(){		
		clearTimeout(timeout);
		var _this = myroom;
		timeout = setTimeout(function(){
			$(".classroombox").slideUp("slow",function(){
				$(_this).removeClass("acurrent");			
			});
		},500);
	});
});
</script>
</head>
<body style="position:relative;left:0px">
<!--[if lte IE 6]>  
<script type="text/javascript" src="/static/js/DD_belatedPNG_0.0.7a.js"></script>
<script type="text/javascript">
DD_belatedPNG.fix('.bottom,.cservice img,.roomtit,.ui_ico,.kewate span,img,background,.lischool span,');
</script>
<![endif]-->
<?php $curdomain=$this->uri->curdomain;?>
<div class="clay_topfixed">
	<div class="clay_topfixed_inner">
		<div class="ctoolbar">
			<div style="color: #b6b9be;font-size: 16px;font-weight: bold;left: 25%;position: absolute;top: 10px;"></div>
			<div class="chead">
				<div class="csubnav">
				 <?php 
					$user = Ebh::app()->user->getloginuser();
					$roomlib = EBH::app()->lib('Headertop');
					$roomlist = $roomlib -> getroom();
					$path = $this->uri->path;
					if($path!='school'){
				?>
					
				<?php if(count($roomlist) > 1) { ?>
						<a id="myotherroom" class="roomlisticon"  href="#"><?= $roominfo['crname'] ?></a>
				        <?php }?>
						<div class="classroombox" style="display:none;">
							<ul>
                            <?php 
							foreach($roomlist as $roomitem) { 
                                if($roomitem['crid'] != $roominfo['crid']) {
                            ?>
								<li class="classroomitem"><a href="/<?=$roomitem['crid']?>.html"><?= ssubstrch($roomitem['crname'],0,18) ?></a></li>
	                            <?php } ?>                                                                       
	                        <?php } ?>
							</ul>
						</div>
				<?php } ?>
				</div>
				<div class="userinfo">
					<span style="float:left;">您好 ，<?= empty($user['realname'])?$user['username']:$user['username'].'('.$user['realname'].')'?></span>
					<a href="/logout.html" target='_self'>退出</a>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="ctop">
	<div class="cheadpic">
	<img src="http://static.ebanhui.com/ebh/tpl/2012/images/stu_head_pic.jpg" />
	</div>
</div>