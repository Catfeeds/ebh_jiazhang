<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>退出</title>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery.js"></script>
<script type="text/javascript">
$(function(){
	var durl = '<?= $durl ?>';
	var returnurl = '<?= $returnurl ?>';
	if(durl != '') {
		dosso(durl,returnurl);
	} else {
		location.href = returnurl;
	}
});
function dosso(durl,returnurl,callback) {
	var img = new Image();
	img.src = durl;
	$(img).appendTo("body");
	if(img.complete) { // 如果图片已经存在于浏览器缓存，直接调用回调函数
		if(returnurl != undefined && returnurl != "") {
			location.href = returnurl;
		} else if(typeof(callback) == 'function') {
			callback();
		}
		return; // 直接返回，不用再处理onload事件
	}
	img.onload = function () { //图片下载完毕时异步调用callback函数。
		if(returnurl != undefined && returnurl != "") {
			location.href = returnurl;
		} else if(typeof(callback) == 'function') {
			callback();
		}
	};
}
</script>
</head>
<body>
	<center><h3>正在退出。。。</h3></center>
</body>
</html>