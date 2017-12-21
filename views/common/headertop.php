
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/css/statch.css" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen">
<style>
a:hover{
	text-decoration:none;
}
a.cla{
	color:#fff;
}
.cla:hover{
	color:#fff;
}
</style>

<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/teacher.js"></script>
<link type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/jquery-ui/css/custom/jquery-ui.min.css" rel="stylesheet" />	
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/jquery-ui/jquery-ui.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/course.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/swfobject.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery.cookie.js"></script>
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
		
	})

function loadpage(){
	$.cookie('jz_auth', '', { expires: -3600, path: '/',domain: '.<?= $this->uri->curdomain;?>'});
	location.href='/';
}
</script>

<?php $curdomain = $this->uri->curdomain;
	$roominfo = Ebh::app()->room->getcurroom(); ?>
<div class="ctoolbar">
<div style="color: #b6b9be;left: 25%;position: absolute;top: 10px;line-height:15px;background:url(http://static.ebanhui.com/jiazhang/images/topzhd.jpg) no-repeat;">
<a style="color:#b6b9be;margin-left:20px;" href="/" onclick="$.cookie('jz_dm', '<?= $roominfo['domain'] ?>',{ expires: 3600, path: '/',domain: '.<?=$curdomain?>'});">家长系统</a>
</div>
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
							<li class="classroomitem"><a href="<?= geturl('progress') ?>" onclick="$.cookie('jz_dm', '<?= $roomitem['domain'] ?>',{ expires: 3600, path: '/',domain: '.<?=$curdomain?>'});"><?= ssubstrch($roomitem['crname'],0,18) ?></a></li>
                                                        <?php } ?>                                                                       
                                                    <?php } ?>
						</ul>
					</div>
<?php } ?>
</div>
<div class="userinfo">
您好 ，<?php if(empty($user)){?>游客<a href="#" target="_self" onclick="jiazhang.ebh.net"> | 登录</a>
<?php }else{ ?><?= $user['username'] ?><a href="/logout.html" target="_self" onclick="loadpage()"> | 退出</a><?php } ?>
　|</div>
</div>
</div>