<?php  if ( ! defined('IN_EBH')) exit('No direct script access allowed'); ?>

ERROR  -  2015-03-24 09:11:14 --> 
Query error:You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ',1,1427159474)' at line 1
 SQL:REPLACE INTO ebh_userstates (crid,userid,typeid,subtime) VALUES(,,1,1427159474)
simple_query() E:\www\jiazhang\system\db\CDb.php:100
query() E:\www\jiazhang\models\UserstateModel.php:16
insert() E:\www\jiazhang\controllers\exam.php:152
_updateuserstate() E:\www\jiazhang\controllers\exam.php:58
index() E:\www\jiazhang\system\core\CWebApplication.php:19
processRequest() E:\www\jiazhang\system\core\CApplication.php:31
run() E:\www\jiazhang\index.php:11
REQUEST_URI /exam.html

ERROR  -  2015-03-24 10:45:11 --> 
Query error:You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '10797,1,1427165111)' at line 1
 SQL:REPLACE INTO ebh_userstates (crid,userid,typeid,subtime) VALUES(,10797,1,1427165111)
simple_query() E:\www\jiazhang\system\db\CDb.php:100
query() E:\www\jiazhang\models\UserstateModel.php:16
insert() E:\www\jiazhang\controllers\exam.php:152
_updateuserstate() E:\www\jiazhang\controllers\exam.php:58
index() E:\www\jiazhang\system\core\CWebApplication.php:19
processRequest() E:\www\jiazhang\system\core\CApplication.php:31
run() E:\www\jiazhang\index.php:11
REQUEST_URI /exam.html

ERROR  -  2015-03-24 10:45:28 --> 
Query error:You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '10797,1,1427165128)' at line 1
 SQL:REPLACE INTO ebh_userstates (crid,userid,typeid,subtime) VALUES(,10797,1,1427165128)
simple_query() E:\www\jiazhang\system\db\CDb.php:100
query() E:\www\jiazhang\models\UserstateModel.php:16
insert() E:\www\jiazhang\controllers\exam.php:152
_updateuserstate() E:\www\jiazhang\controllers\exam.php:58
index() E:\www\jiazhang\system\core\CWebApplication.php:19
processRequest() E:\www\jiazhang\system\core\CApplication.php:31
run() E:\www\jiazhang\index.php:11
REQUEST_URI /exam.html

ERROR  -  2015-03-24 10:49:32 --> 
Query error:You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and cs.uid = 10797' at line 1
 SQL:SELECT cs.classid,c.classname,c.grade,c.district from  ebh_classstudents cs JOIN ebh_classes c on (c.classid = cs.classid) WHERE c.crid= and cs.uid = 10797
simple_query() E:\www\jiazhang\system\db\CDb.php:100
query() E:\www\jiazhang\models\ClassesModel.php:288
getClassByUid() E:\www\jiazhang\controllers\active.php:9
index() E:\www\jiazhang\system\core\CWebApplication.php:19
processRequest() E:\www\jiazhang\system\core\CApplication.php:31
run() E:\www\jiazhang\index.php:11
REQUEST_URI /active.html

ERROR  -  2015-03-24 10:49:33 --> 
Query error:You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and cs.uid = 10797' at line 1
 SQL:SELECT cs.classid,c.classname,c.grade,c.district from  ebh_classstudents cs JOIN ebh_classes c on (c.classid = cs.classid) WHERE c.crid= and cs.uid = 10797
simple_query() E:\www\jiazhang\system\db\CDb.php:100
query() E:\www\jiazhang\models\ClassesModel.php:288
getClassByUid() E:\www\jiazhang\controllers\active.php:9
index() E:\www\jiazhang\system\core\CWebApplication.php:19
processRequest() E:\www\jiazhang\system\core\CApplication.php:31
run() E:\www\jiazhang\index.php:11
REQUEST_URI /active.html

ERROR  -  2015-03-24 10:51:56 --> 
Query error:You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '10797,1,1427165516)' at line 1
 SQL:REPLACE INTO ebh_userstates (crid,userid,typeid,subtime) VALUES(,10797,1,1427165516)
simple_query() E:\www\jiazhang\system\db\CDb.php:100
query() E:\www\jiazhang\models\UserstateModel.php:16
insert() E:\www\jiazhang\controllers\exam.php:152
_updateuserstate() E:\www\jiazhang\controllers\exam.php:58
index() E:\www\jiazhang\system\core\CWebApplication.php:19
processRequest() E:\www\jiazhang\system\core\CApplication.php:31
run() E:\www\jiazhang\index.php:11
REQUEST_URI /exam.html

ERROR  -  2015-03-24 11:01:40 --> 
Query error:You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and cs.uid = 10797' at line 1
 SQL:SELECT cs.classid,c.classname,c.grade,c.district from  ebh_classstudents cs JOIN ebh_classes c on (c.classid = cs.classid) WHERE c.crid= and cs.uid = 10797
simple_query() E:\www\jiazhang\system\db\CDb.php:100
query() E:\www\jiazhang\models\ClassesModel.php:288
getClassByUid() E:\www\jiazhang\controllers\hardwork.php:9
index() E:\www\jiazhang\system\core\CWebApplication.php:19
processRequest() E:\www\jiazhang\system\core\CApplication.php:31
run() E:\www\jiazhang\index.php:11
REQUEST_URI /hardwork.html

ERROR  -  2015-03-24 11:01:41 --> 
Query error:You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and cs.uid = 10797' at line 1
 SQL:SELECT cs.classid,c.classname,c.grade,c.district from  ebh_classstudents cs JOIN ebh_classes c on (c.classid = cs.classid) WHERE c.crid= and cs.uid = 10797
simple_query() E:\www\jiazhang\system\db\CDb.php:100
query() E:\www\jiazhang\models\ClassesModel.php:288
getClassByUid() E:\www\jiazhang\controllers\hardwork.php:9
index() E:\www\jiazhang\system\core\CWebApplication.php:19
processRequest() E:\www\jiazhang\system\core\CApplication.php:31
run() E:\www\jiazhang\index.php:11
REQUEST_URI /hardwork.html

ERROR  -  2015-03-24 11:06:25 --> 
Query error:You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and cs.uid = 10797' at line 1
 SQL:SELECT cs.classid,c.classname,c.grade,c.district from  ebh_classstudents cs JOIN ebh_classes c on (c.classid = cs.classid) WHERE c.crid= and cs.uid = 10797
simple_query() E:\www\jiazhang\system\db\CDb.php:100
query() E:\www\jiazhang\models\ClassesModel.php:288
getClassByUid() E:\www\jiazhang\controllers\hardwork.php:9
index() E:\www\jiazhang\system\core\CWebApplication.php:19
processRequest() E:\www\jiazhang\system\core\CApplication.php:31
run() E:\www\jiazhang\index.php:11
REQUEST_URI /hardwork.html

ERROR  -  2015-03-24 11:14:40 --> 
Query error:You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and cs.uid = 10797' at line 1
 SQL:SELECT cs.classid,c.classname,c.grade,c.district from  ebh_classstudents cs JOIN ebh_classes c on (c.classid = cs.classid) WHERE c.crid= and cs.uid = 10797
simple_query() E:\www\jiazhang\system\db\CDb.php:100
query() E:\www\jiazhang\models\ClassesModel.php:288
getClassByUid() E:\www\jiazhang\controllers\active.php:9
index() E:\www\jiazhang\system\core\CWebApplication.php:19
processRequest() E:\www\jiazhang\system\core\CApplication.php:31
run() E:\www\jiazhang\index.php:11
REQUEST_URI /active.html

ERROR  -  2015-03-24 11:14:59 --> 
Query error:You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and cs.uid = 10797' at line 1
 SQL:SELECT cs.classid,c.classname,c.grade,c.district from  ebh_classstudents cs JOIN ebh_classes c on (c.classid = cs.classid) WHERE c.crid= and cs.uid = 10797
simple_query() E:\www\jiazhang\system\db\CDb.php:100
query() E:\www\jiazhang\models\ClassesModel.php:288
getClassByUid() E:\www\jiazhang\controllers\hardwork.php:9
index() E:\www\jiazhang\system\core\CWebApplication.php:19
processRequest() E:\www\jiazhang\system\core\CApplication.php:31
run() E:\www\jiazhang\index.php:11
REQUEST_URI /hardwork.html

ERROR  -  2015-03-24 11:15:03 --> 
Query error:You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and cs.uid = 10797' at line 1
 SQL:SELECT cs.classid,c.classname,c.grade,c.district from  ebh_classstudents cs JOIN ebh_classes c on (c.classid = cs.classid) WHERE c.crid= and cs.uid = 10797
simple_query() E:\www\jiazhang\system\db\CDb.php:100
query() E:\www\jiazhang\models\ClassesModel.php:288
getClassByUid() E:\www\jiazhang\controllers\hardwork.php:9
index() E:\www\jiazhang\system\core\CWebApplication.php:19
processRequest() E:\www\jiazhang\system\core\CApplication.php:31
run() E:\www\jiazhang\index.php:11
REQUEST_URI /hardwork.html

ERROR  -  2015-03-24 16:44:03 --> 
Query error:You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1
 SQL:SELECT cs.classid,c.classname,c.grade,c.district from  ebh_classstudents cs JOIN ebh_classes c on (c.classid = cs.classid) WHERE c.crid=10424 and cs.uid = 
simple_query() E:\www\jiazhang\system\db\CDb.php:100
query() E:\www\jiazhang\models\ClassesModel.php:288
getClassByUid() E:\www\jiazhang\controllers\progress.php:20
index() E:\www\jiazhang\system\core\CWebApplication.php:19
processRequest() E:\www\jiazhang\system\core\CApplication.php:31
run() E:\www\jiazhang\index.php:11
REQUEST_URI /progress.html

ERROR  -  2015-03-24 16:44:07 --> 
Query error:You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ',1,1427186646)' at line 1
 SQL:REPLACE INTO ebh_userstates (crid,userid,typeid,subtime) VALUES(,,1,1427186646)
simple_query() E:\www\jiazhang\system\db\CDb.php:100
query() E:\www\jiazhang\models\UserstateModel.php:16
insert() E:\www\jiazhang\controllers\exam.php:152
_updateuserstate() E:\www\jiazhang\controllers\exam.php:58
index() E:\www\jiazhang\system\core\CWebApplication.php:19
processRequest() E:\www\jiazhang\system\core\CApplication.php:31
run() E:\www\jiazhang\index.php:11
REQUEST_URI /exam.html

ERROR  -  2015-03-24 16:44:08 --> 
Query error:You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ',2,1427186648)' at line 1
 SQL:REPLACE INTO ebh_userstates (crid,userid,typeid,subtime) VALUES(,,2,1427186648)
simple_query() E:\www\jiazhang\system\db\CDb.php:100
query() E:\www\jiazhang\models\UserstateModel.php:16
insert() E:\www\jiazhang\controllers\askquestion.php:39
index() E:\www\jiazhang\system\core\CWebApplication.php:19
processRequest() E:\www\jiazhang\system\core\CApplication.php:31
run() E:\www\jiazhang\index.php:11
REQUEST_URI /askquestion.html

ERROR  -  2015-03-24 16:44:08 --> 
Query error:You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ',4,1427186648)' at line 1
 SQL:REPLACE INTO ebh_userstates (crid,userid,typeid,subtime) VALUES(,,4,1427186648)
simple_query() E:\www\jiazhang\system\db\CDb.php:100
query() E:\www\jiazhang\models\UserstateModel.php:16
insert() E:\www\jiazhang\controllers\askquestion.php:73
_updateuserstate() E:\www\jiazhang\controllers\askquestion.php:49
index() E:\www\jiazhang\system\core\CWebApplication.php:19
processRequest() E:\www\jiazhang\system\core\CApplication.php:31
run() E:\www\jiazhang\index.php:11
REQUEST_URI /askquestion.html

