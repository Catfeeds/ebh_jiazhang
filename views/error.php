<!doctype html>
<html lang="en">
 <head>
  <meta charset="UTF-8">
  <meta name="Generator" content="EditPlus®">
  <meta name="Author" content="">
  <meta name="Keywords" content="">
  <meta name="Description" content="">
  <title>无权操作</title>
 </head>
 <script type="text/javascript"> 
function countDown(secs,surl){ 
 //alert(surl); 
 var jumpTo = document.getElementById('jumpTo');
 jumpTo.innerHTML=secs; 
 if(--secs>0){ 
  setTimeout("countDown("+secs+",'"+surl+"')",1000); 
 }
 else
 {  
  location.href=surl; 
 } 
} 
</script>
</head>
 <body align="center">
	<img src="http://static.ebanhui.com/jiazhang/images/error.jpg" alt="" style="float: left;border:0px;" />
	<span id="jumpTo" style="display:none;"></span>
<script type="text/javascript">
countDown(5,'http://jiazhang.ebh.net/');
</script> 
 </body>
</html>
