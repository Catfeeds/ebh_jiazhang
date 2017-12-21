<?php  if ( ! defined('IN_EBH')) exit('No direct script access allowed'); ?>

ERROR  -  2015-03-31 11:12:49 --> 
Query error:You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and cs.uid = 10797' at line 1
 SQL:SELECT cs.classid,c.classname,c.grade,c.district from  ebh_classstudents cs JOIN ebh_classes c on (c.classid = cs.classid) WHERE c.crid= and cs.uid = 10797
simple_query() E:\www\jiazhang\system\db\CDb.php:100
query() E:\www\jiazhang\models\ClassesModel.php:288
getClassByUid() E:\www\jiazhang\controllers\hardwork.php:10
index() E:\www\jiazhang\system\core\CWebApplication.php:19
processRequest() E:\www\jiazhang\system\core\CApplication.php:31
run() E:\www\jiazhang\index.php:11
REQUEST_URI /hardwork.html?d=xiaozi&daystate=0

ERROR  -  2015-03-31 15:01:49 --> 
Query error:You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and cs.uid = 10797' at line 1
 SQL:SELECT cs.classid,c.classname,c.grade,c.district from  ebh_classstudents cs JOIN ebh_classes c on (c.classid = cs.classid) WHERE c.crid= and cs.uid = 10797
simple_query() E:\www\jiazhang\system\db\CDb.php:100
query() E:\www\jiazhang\models\ClassesModel.php:288
getClassByUid() E:\www\jiazhang\controllers\hardwork.php:10
index() E:\www\jiazhang\system\core\CWebApplication.php:19
processRequest() E:\www\jiazhang\system\core\CApplication.php:31
run() E:\www\jiazhang\index.php:11
REQUEST_URI /hardwork.html?d=xiaozi&daystate=0

ERROR  -  2015-03-31 16:01:40 --> 
Query error:You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and cs.uid = 10797' at line 1
 SQL:SELECT cs.classid,c.classname,c.grade,c.district from  ebh_classstudents cs JOIN ebh_classes c on (c.classid = cs.classid) WHERE c.crid= and cs.uid = 10797
simple_query() E:\www\jiazhang\system\db\CDb.php:100
query() E:\www\jiazhang\models\ClassesModel.php:288
getClassByUid() E:\www\jiazhang\controllers\exam.php:10
index() E:\www\jiazhang\system\core\CWebApplication.php:19
processRequest() E:\www\jiazhang\system\core\CApplication.php:31
run() E:\www\jiazhang\index.php:11
REQUEST_URI /exam.html?

ERROR  -  2015-03-31 16:04:25 --> 
Query error:You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and cs.uid = 10797' at line 1
 SQL:SELECT cs.classid,c.classname,c.grade,c.district from  ebh_classstudents cs JOIN ebh_classes c on (c.classid = cs.classid) WHERE c.crid= and cs.uid = 10797
simple_query() E:\www\jiazhang\system\db\CDb.php:100
query() E:\www\jiazhang\models\ClassesModel.php:288
getClassByUid() E:\www\jiazhang\controllers\hardwork.php:10
index() E:\www\jiazhang\system\core\CWebApplication.php:19
processRequest() E:\www\jiazhang\system\core\CApplication.php:31
run() E:\www\jiazhang\index.php:11
REQUEST_URI /hardwork.html?

ERROR  -  2015-03-31 16:04:30 --> 
Query error:You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and cs.uid = 10797' at line 1
 SQL:SELECT cs.classid,c.classname,c.grade,c.district from  ebh_classstudents cs JOIN ebh_classes c on (c.classid = cs.classid) WHERE c.crid= and cs.uid = 10797
simple_query() E:\www\jiazhang\system\db\CDb.php:100
query() E:\www\jiazhang\models\ClassesModel.php:288
getClassByUid() E:\www\jiazhang\controllers\exam.php:10
index() E:\www\jiazhang\system\core\CWebApplication.php:19
processRequest() E:\www\jiazhang\system\core\CApplication.php:31
run() E:\www\jiazhang\index.php:11
REQUEST_URI /exam.html?

ERROR  -  2015-03-31 16:25:35 --> 
Query error:Unknown column 'xiaozi' in 'where clause'
 SQL:select p.logid,p.cwid,p.ctime,p.ltime,p.startdate,p.lastdate,c.title,c.cwurl,c.ism3u8,c.dateline,c.viewnum,c.reviewnum,c.summary,f.folderid,f.foldername,f.img,t.realname,u.sex,u.face from ebh_playlogs p join ebh_coursewares c on (p.cwid = c.cwid) join ebh_roomcourses rc on (rc.cwid = p.cwid) join ebh_folders f on (f.folderid = rc.folderid)join ebh_teachers t on (t.teacherid = f.uid)join ebh_users u on (u.uid = t.teacherid) WHERE p.uid=10797 AND rc.crid=xiaozi AND p.totalflag in (0) order by p.lastdate desc  limit 0,20
simple_query() E:\www\jiazhang\system\db\CDb.php:100
query() E:\www\jiazhang\models\PlaylogModel.php:58
getList() E:\www\jiazhang\controllers\studyrecords.php:24
index() E:\www\jiazhang\system\core\CWebApplication.php:19
processRequest() E:\www\jiazhang\system\core\CApplication.php:31
run() E:\www\jiazhang\index.php:11
REQUEST_URI /studyrecords.html

ERROR  -  2015-03-31 16:25:38 --> 
Query error:Unknown column 'xiaozi' in 'where clause'
 SQL:select p.logid,p.cwid,p.ctime,p.ltime,p.startdate,p.lastdate,c.title,c.cwurl,c.ism3u8,c.dateline,c.viewnum,c.reviewnum,c.summary,f.folderid,f.foldername,f.img,t.realname,u.sex,u.face from ebh_playlogs p join ebh_coursewares c on (p.cwid = c.cwid) join ebh_roomcourses rc on (rc.cwid = p.cwid) join ebh_folders f on (f.folderid = rc.folderid)join ebh_teachers t on (t.teacherid = f.uid)join ebh_users u on (u.uid = t.teacherid) WHERE p.uid=10797 AND rc.crid=xiaozi AND p.totalflag in (0) order by p.lastdate desc  limit 0,20
simple_query() E:\www\jiazhang\system\db\CDb.php:100
query() E:\www\jiazhang\models\PlaylogModel.php:58
getList() E:\www\jiazhang\controllers\studyrecords.php:24
index() E:\www\jiazhang\system\core\CWebApplication.php:19
processRequest() E:\www\jiazhang\system\core\CApplication.php:31
run() E:\www\jiazhang\index.php:11
REQUEST_URI /studyrecords.html

ERROR  -  2015-03-31 16:26:46 --> 
Query error:Unknown column 'xiaozi' in 'where clause'
 SQL:select p.logid,p.cwid,p.ctime,p.ltime,p.startdate,p.lastdate,c.title,c.cwurl,c.ism3u8,c.dateline,c.viewnum,c.reviewnum,c.summary,f.folderid,f.foldername,f.img,t.realname,u.sex,u.face from ebh_playlogs p join ebh_coursewares c on (p.cwid = c.cwid) join ebh_roomcourses rc on (rc.cwid = p.cwid) join ebh_folders f on (f.folderid = rc.folderid)join ebh_teachers t on (t.teacherid = f.uid)join ebh_users u on (u.uid = t.teacherid) WHERE p.uid=10797 AND rc.crid=xiaozi AND p.totalflag in (0) order by p.lastdate desc  limit 0,20
simple_query() E:\www\jiazhang\system\db\CDb.php:100
query() E:\www\jiazhang\models\PlaylogModel.php:58
getList() E:\www\jiazhang\controllers\studyrecords.php:22
index() E:\www\jiazhang\system\core\CWebApplication.php:19
processRequest() E:\www\jiazhang\system\core\CApplication.php:31
run() E:\www\jiazhang\index.php:11
REQUEST_URI /studyrecords.html

