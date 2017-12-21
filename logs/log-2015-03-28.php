<?php  if ( ! defined('IN_EBH')) exit('No direct script access allowed'); ?>

ERROR  -  2015-03-28 11:02:18 --> 
Query error:You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and cs.uid = 10797' at line 1
 SQL:SELECT cs.classid,c.classname,c.grade,c.district from  ebh_classstudents cs JOIN ebh_classes c on (c.classid = cs.classid) WHERE c.crid= and cs.uid = 10797
simple_query() E:\www\jiazhang\system\db\CDb.php:100
query() E:\www\jiazhang\models\ClassesModel.php:288
getClassByUid() E:\www\jiazhang\controllers\exam.php:69
my() E:\www\jiazhang\system\core\CWebApplication.php:19
processRequest() E:\www\jiazhang\system\core\CApplication.php:31
run() E:\www\jiazhang\index.php:11
REQUEST_URI /exam/my.html?d=xiaoziddd

ERROR  -  2015-03-28 14:49:16 --> 
Query error:Unknown column 'f.sex' in 'field list'
 SQL:select p.logid,p.cwid,p.ctime,p.ltime,p.startdate,p.lastdate,c.title,c.cwurl,c.ism3u8,c.dateline,c.viewnum,c.reviewnum,c.summary,f.folderid,f.foldername,f.img,t.realname,f.sex,f.face from ebh_playlogs p join ebh_coursewares c on (p.cwid = c.cwid) join ebh_roomcourses rc on (rc.cwid = p.cwid) join ebh_folders f on (f.folderid = rc.folderid)join ebh_teachers t on (t.teacherid = f.uid) WHERE p.uid=10797 AND rc.crid=10424 AND p.totalflag in (0) order by p.lastdate desc  limit 0,20
simple_query() E:\www\jiazhang\system\db\CDb.php:100
query() E:\www\jiazhang\models\PlaylogModel.php:57
getList() E:\www\jiazhang\controllers\studyrecords.php:22
index() E:\www\jiazhang\system\core\CWebApplication.php:19
processRequest() E:\www\jiazhang\system\core\CApplication.php:31
run() E:\www\jiazhang\index.php:11
REQUEST_URI /studyrecords.html?d=xiaozi

ERROR  -  2015-03-28 14:49:30 --> 
Query error:Unknown column 'f.sex' in 'field list'
 SQL:select p.logid,p.cwid,p.ctime,p.ltime,p.startdate,p.lastdate,c.title,c.cwurl,c.ism3u8,c.dateline,c.viewnum,c.reviewnum,c.summary,f.folderid,f.foldername,f.img,t.realname,f.sex from ebh_playlogs p join ebh_coursewares c on (p.cwid = c.cwid) join ebh_roomcourses rc on (rc.cwid = p.cwid) join ebh_folders f on (f.folderid = rc.folderid)join ebh_teachers t on (t.teacherid = f.uid) WHERE p.uid=10797 AND rc.crid=10424 AND p.totalflag in (0) order by p.lastdate desc  limit 0,20
simple_query() E:\www\jiazhang\system\db\CDb.php:100
query() E:\www\jiazhang\models\PlaylogModel.php:57
getList() E:\www\jiazhang\controllers\studyrecords.php:22
index() E:\www\jiazhang\system\core\CWebApplication.php:19
processRequest() E:\www\jiazhang\system\core\CApplication.php:31
run() E:\www\jiazhang\index.php:11
REQUEST_URI /studyrecords.html?d=xiaozi

ERROR  -  2015-03-28 14:49:31 --> 
Query error:Unknown column 'f.sex' in 'field list'
 SQL:select p.logid,p.cwid,p.ctime,p.ltime,p.startdate,p.lastdate,c.title,c.cwurl,c.ism3u8,c.dateline,c.viewnum,c.reviewnum,c.summary,f.folderid,f.foldername,f.img,t.realname,f.sex from ebh_playlogs p join ebh_coursewares c on (p.cwid = c.cwid) join ebh_roomcourses rc on (rc.cwid = p.cwid) join ebh_folders f on (f.folderid = rc.folderid)join ebh_teachers t on (t.teacherid = f.uid) WHERE p.uid=10797 AND rc.crid=10424 AND p.totalflag in (0) order by p.lastdate desc  limit 0,20
simple_query() E:\www\jiazhang\system\db\CDb.php:100
query() E:\www\jiazhang\models\PlaylogModel.php:57
getList() E:\www\jiazhang\controllers\studyrecords.php:22
index() E:\www\jiazhang\system\core\CWebApplication.php:19
processRequest() E:\www\jiazhang\system\core\CApplication.php:31
run() E:\www\jiazhang\index.php:11
REQUEST_URI /studyrecords.html?d=xiaozi

ERROR  -  2015-03-28 14:49:31 --> 
Query error:Unknown column 'f.sex' in 'field list'
 SQL:select p.logid,p.cwid,p.ctime,p.ltime,p.startdate,p.lastdate,c.title,c.cwurl,c.ism3u8,c.dateline,c.viewnum,c.reviewnum,c.summary,f.folderid,f.foldername,f.img,t.realname,f.sex from ebh_playlogs p join ebh_coursewares c on (p.cwid = c.cwid) join ebh_roomcourses rc on (rc.cwid = p.cwid) join ebh_folders f on (f.folderid = rc.folderid)join ebh_teachers t on (t.teacherid = f.uid) WHERE p.uid=10797 AND rc.crid=10424 AND p.totalflag in (0) order by p.lastdate desc  limit 0,20
simple_query() E:\www\jiazhang\system\db\CDb.php:100
query() E:\www\jiazhang\models\PlaylogModel.php:57
getList() E:\www\jiazhang\controllers\studyrecords.php:22
index() E:\www\jiazhang\system\core\CWebApplication.php:19
processRequest() E:\www\jiazhang\system\core\CApplication.php:31
run() E:\www\jiazhang\index.php:11
REQUEST_URI /studyrecords.html?d=xiaozi

ERROR  -  2015-03-28 14:49:31 --> 
Query error:Unknown column 'f.sex' in 'field list'
 SQL:select p.logid,p.cwid,p.ctime,p.ltime,p.startdate,p.lastdate,c.title,c.cwurl,c.ism3u8,c.dateline,c.viewnum,c.reviewnum,c.summary,f.folderid,f.foldername,f.img,t.realname,f.sex from ebh_playlogs p join ebh_coursewares c on (p.cwid = c.cwid) join ebh_roomcourses rc on (rc.cwid = p.cwid) join ebh_folders f on (f.folderid = rc.folderid)join ebh_teachers t on (t.teacherid = f.uid) WHERE p.uid=10797 AND rc.crid=10424 AND p.totalflag in (0) order by p.lastdate desc  limit 0,20
simple_query() E:\www\jiazhang\system\db\CDb.php:100
query() E:\www\jiazhang\models\PlaylogModel.php:57
getList() E:\www\jiazhang\controllers\studyrecords.php:22
index() E:\www\jiazhang\system\core\CWebApplication.php:19
processRequest() E:\www\jiazhang\system\core\CApplication.php:31
run() E:\www\jiazhang\index.php:11
REQUEST_URI /studyrecords.html?d=xiaozi

ERROR  -  2015-03-28 14:49:51 --> 
Query error:Unknown column 'f.sex' in 'field list'
 SQL:select p.logid,p.cwid,p.ctime,p.ltime,p.startdate,p.lastdate,c.title,c.cwurl,c.ism3u8,c.dateline,c.viewnum,c.reviewnum,c.summary,f.folderid,f.foldername,f.img,t.realname,f.sex,f.face from ebh_playlogs p join ebh_coursewares c on (p.cwid = c.cwid) join ebh_roomcourses rc on (rc.cwid = p.cwid) join ebh_folders f on (f.folderid = rc.folderid)join ebh_teachers t on (t.teacherid = f.uid) WHERE p.uid=10797 AND rc.crid=10424 AND p.totalflag in (0) order by p.lastdate desc  limit 0,20
simple_query() E:\www\jiazhang\system\db\CDb.php:100
query() E:\www\jiazhang\models\PlaylogModel.php:57
getList() E:\www\jiazhang\controllers\studyrecords.php:22
index() E:\www\jiazhang\system\core\CWebApplication.php:19
processRequest() E:\www\jiazhang\system\core\CApplication.php:31
run() E:\www\jiazhang\index.php:11
REQUEST_URI /studyrecords.html?d=xiaozi

ERROR  -  2015-03-28 14:49:52 --> 
Query error:Unknown column 'f.sex' in 'field list'
 SQL:select p.logid,p.cwid,p.ctime,p.ltime,p.startdate,p.lastdate,c.title,c.cwurl,c.ism3u8,c.dateline,c.viewnum,c.reviewnum,c.summary,f.folderid,f.foldername,f.img,t.realname,f.sex,f.face from ebh_playlogs p join ebh_coursewares c on (p.cwid = c.cwid) join ebh_roomcourses rc on (rc.cwid = p.cwid) join ebh_folders f on (f.folderid = rc.folderid)join ebh_teachers t on (t.teacherid = f.uid) WHERE p.uid=10797 AND rc.crid=10424 AND p.totalflag in (0) order by p.lastdate desc  limit 0,20
simple_query() E:\www\jiazhang\system\db\CDb.php:100
query() E:\www\jiazhang\models\PlaylogModel.php:57
getList() E:\www\jiazhang\controllers\studyrecords.php:22
index() E:\www\jiazhang\system\core\CWebApplication.php:19
processRequest() E:\www\jiazhang\system\core\CApplication.php:31
run() E:\www\jiazhang\index.php:11
REQUEST_URI /studyrecords.html?d=xiaozi

ERROR  -  2015-03-28 14:49:52 --> 
Query error:Unknown column 'f.sex' in 'field list'
 SQL:select p.logid,p.cwid,p.ctime,p.ltime,p.startdate,p.lastdate,c.title,c.cwurl,c.ism3u8,c.dateline,c.viewnum,c.reviewnum,c.summary,f.folderid,f.foldername,f.img,t.realname,f.sex,f.face from ebh_playlogs p join ebh_coursewares c on (p.cwid = c.cwid) join ebh_roomcourses rc on (rc.cwid = p.cwid) join ebh_folders f on (f.folderid = rc.folderid)join ebh_teachers t on (t.teacherid = f.uid) WHERE p.uid=10797 AND rc.crid=10424 AND p.totalflag in (0) order by p.lastdate desc  limit 0,20
simple_query() E:\www\jiazhang\system\db\CDb.php:100
query() E:\www\jiazhang\models\PlaylogModel.php:57
getList() E:\www\jiazhang\controllers\studyrecords.php:22
index() E:\www\jiazhang\system\core\CWebApplication.php:19
processRequest() E:\www\jiazhang\system\core\CApplication.php:31
run() E:\www\jiazhang\index.php:11
REQUEST_URI /studyrecords.html?d=xiaozi

