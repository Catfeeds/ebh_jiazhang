<?php
/*
 * 文件上传相关配置文件
 */
 //课件服务器配置路径
$upconfig['course']['server'][0] = 'http://c1.ebanhui.com/upload.html';
$upconfig['course']['savepath'] = 'F:/uploads/course/';
$upconfig['course']['showpath'] = '/uploads/course/';
//$upconfig['course']['servers'][1] = 'http://file2.ebanhui.com/sitecp.php?action=upload';		

//图片服务器配置路径
$upconfig['pic']['server'][0] = 'http://c1.ebanhui.com/uploadimage.html';		
$upconfig['pic']['savepath'] = 'E:/web/img/ebh/';
$upconfig['pic']['showpath'] = 'http://img.ebanhui.com/ebh/';

//添加用户头像的图片配置路径
$upconfig['avatar']['server'][0] = 'http://c1.ebanhui.com/uploadimage.html';		
$upconfig['avatar']['savepath'] = 'E:/web/img/avatar/';
$upconfig['avatar']['showpath'] = 'http://img.ebanhui.com/avatar';

//答疑相关附件(图片/音频等)服务器配置路径
$upconfig['ask']['server'][0] = 'http://c1.ebanhui.com/uploadimage.html';		
$upconfig['ask']['savepath'] = 'E:/web/img/ask/';
$upconfig['ask']['showpath'] = 'http://img.ebanhui.com/ask/';

//电子教室附件配置
$upconfig['attachment']['server'][0] = 'http://c1.ebanhui.com/upload.html';
$upconfig['attachment']['savepath'] = 'F:/uploads/docs/';
$upconfig['attachment']['showpath'] = '/uploads/docs/';

//资源文件配置
$upconfig['rfile']['server'][0] = '/sitecp.php?action=upfile';
$upconfig['rfile']['savepath'] = 'F:/uploads/rfile/';
$upconfig['rfile']['showpath'] = '/uploads/rfile/';

//笔记文件配置
$upconfig['note']['savepath'] = 'F:/uploads/notes/';
$upconfig['note']['showpath'] = '/uploads/notes/';
//笔记附件文件配置
$upconfig['noteatta']['savepath'] = 'E:/ebh/notes/';
//笔记附件文件显示配置
$upconfig['noteatta']['showpath'] = 'http://c1.ebanhui.com/notes/';

//课程附件上传配置
$upconfig['courseatta']['data']['savepath'] = 'D:/file/cuploads/';
//课程附件上传配置
$upconfig['courseatta']['data']['showpath'] = 'http://file.ebanhui.com/cuploads/';

//上传作业配置
$upconfig['stuexam']['server'][0] = '/sitecp.php?action=upatt&type=stuexam';
$upconfig['stuexam']['savepath'] = 'F:/uploads/stuexam/';
$upconfig['stuexam']['path'] = '/exam/';
$upconfig['stuexam']['showpath'] = '/uploads/stuexam/';

//原创空间
//原创作品文件配置
$upconfig['space']['savepath'] = 'F:/uploads/space/';
$upconfig['space']['showpath'] = '/uploads/space/';
$upconfig['space']['imagepath'] = 'http://img.ebanhui.com/space/';

 //作业课件(主观题)上传位置配置
$upconfig['examcourse']['server'][0] = '/sitecp.php?action=examcourse';
$upconfig['examcourse']['savepath'] = 'F:/uploads/examcourse/';
$upconfig['examcourse']['showpath'] = '/uploads/examcourse/';

 //作业课件(主观题)相关图片路径配置
$upconfig['examcoursepic']['server'][0] = '/sitecp.php?action=examcourse';
$upconfig['examcoursepic']['savepath'] = 'E:/web/img/examcourse/';
$upconfig['examcoursepic']['showpath'] = 'http://img.ebanhui.com/examcourse/';


//音频服务器配置路径
$upconfig['audio']['server'][0] = 'http://www.ebanhui.com/uploadaudio.html';		
$upconfig['audio']['savepath'] = 'E:/web/img/ask/';
$upconfig['audio']['showpath'] = 'http://img.ebanhui.com/ask/';

 //临时文件上传目录，如导入学生等xls的临时目录等
$upconfig['temp']['savepath'] = 'F:/uploads/temp/';
$upconfig['temp']['showpath'] = '/uploads/temp/';

//swf
$upconfig['reslibs']['savepath'] = 'F:/uploads/swf/';
$upconfig['reslibs']['showpath'] = '/uploads/swf/';

//电子教案附件配置
$upconfig['tplanatt']['savepath'] = 'F:/uploads/tplanatt1/';
$upconfig['tplanatt']['showpath'] = '/uploads/tplanatt1/';

//im群文件共享保存目录
$upconfig['qunfile']['savepath'] = 'F:/uploads/qun/';
$upconfig['qunfile']['saveserver'] = 'http://www.ebanhui.com/';
$upconfig['qunfile']['showpath'] = '/uploads/qun/';

$upconfig['formula']['savepath'] = 'E:/web/img/formula/';
$upconfig['formula']['showpath'] = 'http://img.ebanhui.com/formula/';
$upconfig['formula']['posturl'] = 'http://up.ebh.net/formulav2.html';

$upconfig['fnote']['savepath'] = 'E:/web/img/fnote/';
$upconfig['fnote']['showpath'] = 'http://img.ebanhui.com/fnote/';

$upconfig['preview']['url'] = 'http://192.168.0.11:887/index.aspx';


//课件图片上传配置
$upconfig['xk']['server'][0] = 'http://www.ebanhui.com/imghandler.html';
$upconfig['xk']['savepath'] = '/data0/htdocs/img/ebh/xk/';
$upconfig['xk']['showpath'] = 'http://img.ebanhui.com/ebh/xk/';
//社区图片上传配置
$upconfig['forum']['server'][0] = 'http://up.ebh.net/forum.html';
$upconfig['forum']['savepath'] = '/mnt/hgfs/site/ebh_package/img/forum/';
$upconfig['forum']['showpath'] = 'http://img.ebanhui.com/forum/';

//社区图片配置
$upconfig['forum']['server'][0] = 'http://up.ebh.net/forum.html';
$upconfig['forum']['savepath'] = '/mnt/hgfs/site/ebh_package/img/forum/';
$upconfig['forum']['showpath'] = 'http://img.ebanhui.com/forum/';

?>