<style type="text/css">
	.que{
		overflow:hidden;
	}
	.blankSubject,.subjectPane{
		padding-left: 10px;
	}
</style>
<?php $qtype=array('A'=>'单选','B'=>'多选','C'=>'填空','D'=>'判断','E'=>'文字','H'=>'主观题'); ?>
<?php if(!empty($errors)) { ?>
	<?php foreach($errors as $k=>$error) {
		$error['title'] = str_replace("<br>","",$error['etitle']);
		$page = $this->uri->uri_page();
		if(empty($page) || !is_numeric($page))
			$page = 1;
		$k = $k+1+($page-1)*$pagesize;
		$error['erranswers'] = base64str(unserialize($error['erranswers']));
		if(!empty($error['ques'][0])){
			$error['ques'] = is_array($error['ques'][0])?$error['ques'][0]:$error['ques'];
		}
		if(stripos($error['ques']['subject'],"<object")!==false && stripos($error['ques']['subject'],"http://")===false) {
			$pattern = '/\/static\/flash\/dewplayer-bubble.swf/is';
			$error['ques']['subject'] = preg_replace($pattern, 'http://exam.ebanhui.com/static/flash/dewplayer-bubble.swf', $error['ques']['subject']);
		}
		if(stripos($error['ques']['subject'],"<img")!==false && stripos($error['ques']['subject'],"http://")===false) {
			$error['ques']['subject'] = preg_replace('/\/uploads\//', 'http://exam.ebanhui.com/uploads/', $error['ques']['subject']);
		}
		if(preg_match('/[\)\）]$/s',trim(strip_tags($error['ques']['subject'])))!==false) {
			$error['ques']['subject'] = preg_replace('/）/s', ')', $error['ques']['subject']);
			$error['ques']['subject'] = preg_replace('/（/s', '(', $error['ques']['subject']);
			$error['ques']['subject'] = preg_replace('/\([^\)]+\)$/', '', $error['ques']['subject']);
		}
		$error['ques']['subject'] = trim(str_replace("<br>","",$error['ques']['subject']));
		$error['ques']['resolve'] = trim($error['ques']['resolve'],'&nbsp;');
	?>
	
		<?php if($error['quetype']=='A') { ?>
			<div class="que singleContainer singleContainerFocused" qsval="<?= $k ?>" id="que">
				<p class="desc"><span><em>作业名称:</em><strong title="<?= $error['title'] ?>"><?= shortstr($error['title'],35)?></strong></span><span><em>添加时间:</em><strong><?= date('Y-m-d H:i',$error['dateline'])?></strong></span><span><em>试题类型:</em><strong><?= $qtype[$error['quetype']]?></strong></span></p>
				<div class="subjectPane">
					<span class="stIndex" style="float:left;"><?= $k ?>. </span>
					<span class="inputBox" style="float:left; width:650px;"><?= $error['ques']['subject']?>（<span class="userAnsLabel" id="txtanswer" style="color:blue;font-weight:bold;padding:0 8px;"></span>）<em class="sorceLabel">[<?= $error['score'] ?>分]</em></span>
					<span class="clearing"></span>
				</div>
				<div class="radioPane">
					<ul>
						<?php foreach($error['ques']['options'] as $m=>$n) { 
							$opid = chr(intval($m)+65);
						?>								
						<li class="radioBox">
							<span class="radioWrapper" style="display:block; float:left">
							<span class="jqTransformRadioWrapper">
								<a rel="question" class="jqTransformRadio" href="javascript:void(0);"></a>
								<input type="radio" value="" name="question" class="jqTransformHidden"></span>
								<label style="cursor:pointer;"><?= $opid ?></label>
							</span>
							<span class="optionContent" style="display:block;float:right; width:925px;"><?= $n ?></span>
							<span class="clearing"></span>
						</li>
						<?php } ?>
					</ul>
				</div>
				<div class="userAnswerBar">
	                <ul style="overflow:auto; zoom:1">
	                <li style="float:left;">我的答案：<span class="userAnsLabel"><?= $error['erranswers']?$error['erranswers']:"没填"; ?></span></li>
	                <li style="float:left;"><span class="markFalse">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></li>
	                </ul>
	            </div>
	            <div class="answerBar">正确答案：<span class="answerLabel"><?= $error['ques']['answers'] ?></span></div>
	           
				<?php if(!empty($error['ques']['resolve'])) { ?>
	            	<div class="title answerBar">答案解析：<div class="resolve inputBox" style="width:885px;float:right;"><?= $error['ques']['resolve'] ?></div><div class="clearing"></div></div>
				<?php } ?>
	           
				<?php if(!empty($error['ques']['cwid'])) { ?>
            		<!-- <div class="title answerBar">课件解析：<div class="resolve inputBox" style="float:right; width:890px;"><a onclick="userplay('http://jiazhang.ebh.net/',<?= $error['ques']['cwid'] ?>);return false;" href="javascript:void(0);"><img src="http://exam.ebanhui.com/static/images/playcourseware.jpg"></a></div><div class="clearing"></div></div> -->
				<?php } ?>

				
			</div>
		<?php } elseif($error['quetype']=="B") { ?>
			<div class="que singleContainer singleContainerFocused " qsval="<?= $k ?>">
				<p class="desc"><span><em>作业名称:</em><strong ><?= shortstr($error['title'],35)?></strong></span><span><em>添加时间:</em><strong><?= date('Y-m-d H:i',$error['dateline'])?></strong></span><span><em>试题类型:</em><strong><?= $qtype[$error['quetype']]?></strong></span></p>
	            <div class="subjectPane">
	                <span class="stIndex" style="float:left;"><?= $k ?>. </span>
	                <span class="inputBox" style="float:left; width:640px;"><?= $error['ques']['subject']?>（<span class="userAnsLabel" style="color:blue;font-weight:bold;padding:0 8px;"></span>）<em class="sorceLabel">[<?=  $error['score'] ?>分]</em></span>
	                <span class="clearing"></span>
	            </div>
	            <div class="radioPane">
	                <ul>
						
						<?php foreach($error['ques']['options'] as $m=>$n) { ?>
						<?php $opid = chr(intval($m)+65); ?>
						<li class="radioBox">
							<span class="radioWrapper" style="display:block; float:left">
							<span class="jqTransformRadioWrapper">
								<a rel="question" class="jqTransformRadio" href="javascript:void(0);"></a>
								<input type="radio" value="" name="question" class="jqTransformHidden"></span>
								<label style="cursor:pointer;"><?= $opid ?></label>
							</span>
							<span class="optionContent" style="display:block; width:954px;"><?= $n ?></span>
							<span class="clearing"></span>
						</li>
						<?php } ?>
	                </ul>
	            </div>
	            <div class="userAnswerBar">
	                <ul style="overflow:auto; zoom:1">
	                <li style="float:left;">我的答案：<span class="userAnsLabel"><?= $error['erranswers']?$error['erranswers']:"没填"; ?></span></li>
	                <li style="float:left;"><span class="markFalse">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></li>
	                </ul>
	            </div>
	            <div class="answerBar">正确答案：<span class="answerLabel"><?= $error['ques']['answers']?></span></div>

	            
				<?php if(!empty($error['ques']['resolve'])) { ?>
	            	<div class="title answerBar">答案解析：<div class="resolve inputBox" style="width:885px;float:right;"><?= $error['ques']['resolve'] ?></div><div class="clearing"></div></div>
	            <?php } ?>


				<?php if(!empty($error['ques']['cwid'])) { ?>
            		<!-- <div class="title answerBar">课件解析：<div class="resolve inputBox" style="float:right; width:890px;"><a onclick="userplay('http://jiazhang.ebh.net/',<?= $error['ques']['cwid']?>);return false;" href="javascript:void(0);"><img src="http://exam.ebanhui.com/static/images/playcourseware.jpg"></a></div><div class="clearing"></div></div> -->
				<?php } ?>

	        </div>

		<?php } else if($error['quetype']=='C') { ?>
			<div class="que singleContainer singleContainerFocused" qsval="<?= $k ?>">
				<p class="desc"><span><em>作业名称:</em><strong title="<?= $error['title'] ?>"><?= shortstr($error['title'],35)?></strong></span><span><em>添加时间:</em><strong><?= date('Y-m-d H:i',$error['dateline']) ?></strong></span><span><em>试题类型:</em><strong><?= $qtype[$error['quetype']] ?></strong></span></p>
	            <div class="blankSubject subjectPane">
		            <span class="stIndex" style="float:left;"><?= $k ?>.</span>
		            <span class="inputBox" style="float:left; width:650px;">
		            <?= preg_replace('/(\#input\#)|(\#img\#)/', '<input type="text" readonly="readonly" maxlength="2147483647" size="20" value="">',trim($error['ques']['subject']))?> 
		            <span class="pointLabel sorceLabel">[<?= $error['score']?>分]</span></span>
		            <span class="clearing"></span>
	            </div>
	            <div class="userAnswerBar">
	                <ul style="overflow:auto; zoom:1">
	                <li style="">我的答案：
	                	<span class="userAnsLabel">
							<?php 
								$myanswer = '';
								foreach($error['erranswers'] as $m=>$n) {
									$res = preg_match("/(http:\/\/.*?\.png)/is", $n, $matches);
									if($res==1){
										$n = '<img src="'.$matches[1].'">';
									}
									$myanswer .= empty($n)?"没填,":$n.",";
								}
								echo trim($myanswer,',');
							?>
	                	</span>
	               	</li>
	                </ul>
	            </div>
	            <div class="answerBar">正确答案：
	                <span class="answerLabel">
	                	
						<?php 
								$tanswer = '';
								foreach($error['ques']['options'] as $m=>$n) {
									$res = preg_match("/(http:\/\/.*?\.png)/is", $n, $matches);
									if($res==1){
										$n = '<img src="'.$matches[1].'">';
									}
									$tanswer .= $n.",";
								}
								echo trim($tanswer,',');
							?>
	                </span>
	            </div>
	      
			   <?php if(!empty($error['ques']['resolve'])) { ?>
	            	<div class="title answerBar">答案解析：<div class="resolve inputBox" style="width:885px;float:right;"><?= $error['ques']['resolve'] ?></div><div class="clearing"></div></div>
				<?php } ?>
	            
				<?php if(!empty($error['ques']['cwid'])) {?>
            		<!-- <div class="title answerBar">课件解析：<div class="resolve inputBox" style="float:right; width:890px;"><a onclick="userplay('http://jiazhang.ebh.net/',<?= $error['ques']['cwid'] ?>);return false;" href="javascript:void(0);"><img src="http://exam.ebanhui.com/static/images/playcourseware.jpg"></a></div><div class="clearing"></div></div> -->
				<?php } ?>
	           
	        </div>
		<?php } else if($error['quetype']=='D') {?>
			<div class="que singleContainer singleContainerFocused" qsval="<?= $k ?>">
				<p class="desc"><span><em>作业名称:</em><strong title="<?= $error['title'] ?>"><?= shortstr($error['title'],35) ?></strong></span><span><em>添加时间:</em><strong><?= date('Y-m-d H:i',$error['dateline']) ?></strong></span><span><em>试题类型:</em><strong><?= $qtype[$error['quetype']] ?></strong></span></p>
				<div class="questionContainer">
		            <div class="subjectPane">
			            <span class="stIndex" style="float:left;"><?= $k ?>. </span>
			            <span class="inputBox" style="float:left; width:650px;">
			            <?= $error['ques']['subject'] ?>
			            <em class="sorceLabel" >[<?= $error['score'] ?>分]</em></span>
			            <span class="clearing"></span>
		            </div>

		            <div class="userAnswerBar">
			            <div style="float:left;"><span>对错选项：</span></div>
				            <div style="float:left;">
					            <span class="jqTransformRadioWrapper">
					            <a class="jqTransformRadio" href="javascript:void(0);" ></a>
					            <input type="radio" value="true" name="" class="jqTransformHidden"></span>
					            <label for="" style="cursor:pointer;float:left;margin-right:10px;">对</label>

					            <span class="jqTransformRadioWrapper">
					            <a class="jqTransformRadio" href="javascript:void(0);" ></a>
					            <input type="radio" value="false" name="" class="jqTransformHidden"></span>
					            <label for="" style="cursor:pointer;">错</label>
				        	</div>
				            <div class="clearing"></div>
			            </div>
			        </div>


			        <div class="userAnswerBar">
		                <ul style="overflow:auto; zoom:1">
		                <li style="float:left;">我的答案：<span class="userAnsLabel"><?= $error['erranswers']==2?"没填":($error['erranswers']==1?"对":"错") ?></span></li>
		                <li style="float:left;"><span class="markFalse">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></li>
		                </ul>
		            </div>

		            <div class="answerBar">正确答案：<span class="answerLabel"><?= $error['ques']['answers']==1?"对":"错" ?></span></div>

					<?php if(!empty($error['ques']['resolve'])) {?>
		            	<div class="title answerBar">答案解析：<div class="resolve inputBox" style="width:885px;float:right;"><?= $error['ques']['resolve'] ?></div><div class="clearing"></div></div>
					<?php } ?>

					<?php if(!empty($error['ques']['cwid'])) { ?>
            		<!-- <div class="title answerBar">课件解析：<div class="resolve inputBox" style="float:right; width:890px;"><a onclick="userplay('http://jiazhang.ebh.net/',<?= $error['ques']['cwid']?>);return false;" href="javascript:void(0);"><img src="http://exam.ebanhui.com/static/images/playcourseware.jpg"></a></div><div class="clearing"></div></div> -->
					<?php } ?>

		       
	        </div>
		<?php } else if($error['quetype']=='E') { ?>
			<div class="que singleContainer singleContainerFocused" qsval="<?= $k ?>">
				<p class="desc"><span><em>作业名称:</em><strong title="<?= $error['title'] ?>"><?= shortstr($error['title'],35)?></strong></span><span><em>添加时间:</em><strong><?= date('Y-m-d H:i',$error['dateline']) ?></strong></span><span><em>试题类型:</em><strong><?= $qtype[$error['quetype']] ?></strong></span></p>
	            <div class="subjectPane">
		            <span class="stIndex" style="float:left;"><?= $k ?>. </span>
		            <span class="inputBox" style="float:left; width:650px;">
		            <?= $error['ques']['subject'] ?>
		            <em class="sorceLabel">[<?= $error['score'] ?>分]</em></span>
		            <span class="clearing"></span>
	            </div>
	            <div class="userAnswerBar">
	                <ul style="overflow:auto; zoom:1">
	                <li style="float:left;">我的答案：<span class="userAnsLabel"><?= $error['erranswers']!=""?$error['erranswers']:"没填"; ?></span></li>
	                <li style="float:left;"><span class="markFalse">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></li>
	                </ul>
	            </div>
	            <div class="answerBar">正确答案：<span class="answerLabel"><?= $error['ques']['answers'] ?></span></div>

	         
				<?php if(!empty($error['ques']['resolve'])) {?>
	            	<div class="title answerBar">答案解析：<div class="resolve inputBox" style="width:885px;float:right;"><?= $error['ques']['resolve'] ?></div><div class="clearing"></div></div>
				<?php } ?>

				<?php if(!empty($error['ques']['cwid'])) {?>
            		<!-- <div class="title answerBar">课件解析：<div class="resolve inputBox" style="float:right; width:890px;"><a onclick="userplay('http://jiazhang.ebh.net/',<?= $error['ques']['cwid']?>);return false;" href="javascript:void(0);"><img src="http://exam.ebanhui.com/static/images/playcourseware.jpg"></a></div><div class="clearing"></div></div> -->
				<?php } ?>
	           
	        </div>
		<?php } ?>
	<?php } ?>

	<?= $pagestr ?>
<?php } else { ?>
		 <div style="clear:both;padding-top:10px;text-align:center;"><img src="http://static.ebanhui.com/ebh/tpl/2014/images/zanwujilu.png"></div>
<?php } ?>