<div class="sgreyk">
<div class="ertgb">
<?php $codepath=$this->uri->uri_control();
	$domain = $this->uri->uri_query_string();
?>
	<ul>
	<li style="<?= $codepath=='progress'?'border:solid 1px #5a92f2':'' ?>">
	<a href="/progress.html"><!--学习进度-->
	<img src="http://static.ebanhui.com/jiazhang/images/jzhrtd2.jpg">
	</a>
	</li>
	<li style="<?= $codepath=='studyrecords'?'border:solid 1px #5a92f2':'' ?>">
	<a href="/studyrecords.html"><!--学习记录-->
	<img src="http://static.ebanhui.com/jiazhang/images/jzhrtd1.jpg">
	</a>
	</li>
	<li style="<?= $codepath=='exam'?'border:solid 1px #5a92f2':'' ?>">
	<a href="/exam.html"><!--历史作业-->
	<img src="http://static.ebanhui.com/jiazhang/images/jzhrtd3.jpg">
	</a>
	</li>
	<li style="<?= $codepath=='askquestion'?'border:solid 1px #5a92f2':'' ?>">
	<a href="/askquestion.html"><!--学生答疑-->
	<img src="http://static.ebanhui.com/jiazhang/images/jzhrtd4.jpg">
	</a>
	</li>
	<li style="<?= $codepath=='review'?'border:solid 1px #5a92f2':'' ?>">
	<a href="/review/student.html"><!--相关评论-->
	<img src="http://static.ebanhui.com/jiazhang/images/jzhrtd5.jpg">
	</a>
	</li>
	<li style="<?= $codepath=='hardwork'?'border:solid 1px #5a92f2':'' ?>">
	<a href="/hardwork.html"><!--勤奋度表-->
	<img src="http://static.ebanhui.com/jiazhang/images/jzhrtd6.jpg">
	</a>
	</li>
	<li style="<?= $codepath=='active'?'border:solid 1px #5a92f2':'' ?>">
	<a href="/active.html"><!--活跃度表-->
	<img src="http://static.ebanhui.com/jiazhang/images/jzhrtd7.jpg">
	</a>
	</li>
	<li style="<?= $codepath=='notice'?'border:solid 1px #5a92f2':'' ?>">
	<a href="/notice.html"><!--消息通知-->
	<img src="http://static.ebanhui.com/jiazhang/images/jzhrtd8.jpg">
	</a>
	</li>
	<li style="<?= $codepath=='pass'?'border:solid 1px #5a92f2':'' ?>">
	<a href="/pass.html"><!--设置密码-->
	<img src="http://static.ebanhui.com/jiazhang/images/jzhrtd9.jpg">
	</a>
	</li>
	</ul>
</div>