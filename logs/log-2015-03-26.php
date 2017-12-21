<?php  if ( ! defined('IN_EBH')) exit('No direct script access allowed'); ?>

ERROR  -  2015-03-26 11:31:15 --> 
Query error:You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and rc.cstatus = 1' at line 1
 SQL:select c.crid,c.crname,c.domain from ebh_roomusers rc join ebh_classrooms c on (rc.crid = c.crid) where rc.uid =  and rc.cstatus = 1
simple_query() E:\www\jiazhang\system\db\CDb.php:100
query() E:\www\jiazhang\models\ClassroomModel.php:179
getroomlistbyuid() E:\www\jiazhang\lib\Headertop.php:7
getroom() E:\www\jiazhang\views\common\headertop.php:50
include() E:\www\jiazhang\system\core\CControl.php:42
display() E:\www\jiazhang\views\exam.php:28
include() E:\www\jiazhang\system\core\CControl.php:42
display() E:\www\jiazhang\controllers\exam.php:57
index() E:\www\jiazhang\system\core\CWebApplication.php:19
processRequest() E:\www\jiazhang\system\core\CApplication.php:31
run() E:\www\jiazhang\index.php:11
REQUEST_URI /exam.html

ERROR  -  2015-03-26 11:31:26 --> 
Query error:You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and rc.cstatus = 1' at line 1
 SQL:select c.crid,c.crname,c.domain from ebh_roomusers rc join ebh_classrooms c on (rc.crid = c.crid) where rc.uid =  and rc.cstatus = 1
simple_query() E:\www\jiazhang\system\db\CDb.php:100
query() E:\www\jiazhang\models\ClassroomModel.php:179
getroomlistbyuid() E:\www\jiazhang\lib\Headertop.php:7
getroom() E:\www\jiazhang\views\common\headertop.php:50
include() E:\www\jiazhang\system\core\CControl.php:42
display() E:\www\jiazhang\views\pass.php:18
include() E:\www\jiazhang\system\core\CControl.php:42
display() E:\www\jiazhang\controllers\pass.php:15
index() E:\www\jiazhang\system\core\CWebApplication.php:19
processRequest() E:\www\jiazhang\system\core\CApplication.php:31
run() E:\www\jiazhang\index.php:11
REQUEST_URI /pass.html

ERROR  -  2015-03-26 13:04:33 --> 
Query error:You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '10797,2,1427346273)' at line 1
 SQL:REPLACE INTO ebh_userstates (crid,userid,typeid,subtime) VALUES(,10797,2,1427346273)
simple_query() E:\www\jiazhang\system\db\CDb.php:100
query() E:\www\jiazhang\models\UserstateModel.php:16
insert() E:\www\jiazhang\controllers\askquestion.php:39
index() E:\www\jiazhang\system\core\CWebApplication.php:19
processRequest() E:\www\jiazhang\system\core\CApplication.php:31
run() E:\www\jiazhang\index.php:11
REQUEST_URI /askquestion.html

ERROR  -  2015-03-26 13:04:33 --> 
Query error:You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '10797,4,1427346273)' at line 1
 SQL:REPLACE INTO ebh_userstates (crid,userid,typeid,subtime) VALUES(,10797,4,1427346273)
simple_query() E:\www\jiazhang\system\db\CDb.php:100
query() E:\www\jiazhang\models\UserstateModel.php:16
insert() E:\www\jiazhang\controllers\askquestion.php:73
_updateuserstate() E:\www\jiazhang\controllers\askquestion.php:49
index() E:\www\jiazhang\system\core\CWebApplication.php:19
processRequest() E:\www\jiazhang\system\core\CApplication.php:31
run() E:\www\jiazhang\index.php:11
REQUEST_URI /askquestion.html

ERROR  -  2015-03-26 13:44:36 --> 
Query error:You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '10797,1,1427348676)' at line 1
 SQL:REPLACE INTO ebh_userstates (crid,userid,typeid,subtime) VALUES(,10797,1,1427348676)
simple_query() E:\www\jiazhang\system\db\CDb.php:100
query() E:\www\jiazhang\models\UserstateModel.php:16
insert() E:\www\jiazhang\controllers\exam.php:152
_updateuserstate() E:\www\jiazhang\controllers\exam.php:58
index() E:\www\jiazhang\system\core\CWebApplication.php:19
processRequest() E:\www\jiazhang\system\core\CApplication.php:31
run() E:\www\jiazhang\index.php:11
REQUEST_URI /exam.html

ERROR  -  2015-03-26 13:44:42 --> 
Query error:You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '10797,2,1427348682)' at line 1
 SQL:REPLACE INTO ebh_userstates (crid,userid,typeid,subtime) VALUES(,10797,2,1427348682)
simple_query() E:\www\jiazhang\system\db\CDb.php:100
query() E:\www\jiazhang\models\UserstateModel.php:16
insert() E:\www\jiazhang\controllers\askquestion.php:39
index() E:\www\jiazhang\system\core\CWebApplication.php:19
processRequest() E:\www\jiazhang\system\core\CApplication.php:31
run() E:\www\jiazhang\index.php:11
REQUEST_URI /askquestion.html

ERROR  -  2015-03-26 13:44:42 --> 
Query error:You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '10797,4,1427348682)' at line 1
 SQL:REPLACE INTO ebh_userstates (crid,userid,typeid,subtime) VALUES(,10797,4,1427348682)
simple_query() E:\www\jiazhang\system\db\CDb.php:100
query() E:\www\jiazhang\models\UserstateModel.php:16
insert() E:\www\jiazhang\controllers\askquestion.php:73
_updateuserstate() E:\www\jiazhang\controllers\askquestion.php:49
index() E:\www\jiazhang\system\core\CWebApplication.php:19
processRequest() E:\www\jiazhang\system\core\CApplication.php:31
run() E:\www\jiazhang\index.php:11
REQUEST_URI /askquestion.html

ERROR  -  2015-03-26 13:45:00 --> 
Query error:You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '10797,2,1427348700)' at line 1
 SQL:REPLACE INTO ebh_userstates (crid,userid,typeid,subtime) VALUES(,10797,2,1427348700)
simple_query() E:\www\jiazhang\system\db\CDb.php:100
query() E:\www\jiazhang\models\UserstateModel.php:16
insert() E:\www\jiazhang\controllers\askquestion.php:39
index() E:\www\jiazhang\system\core\CWebApplication.php:19
processRequest() E:\www\jiazhang\system\core\CApplication.php:31
run() E:\www\jiazhang\index.php:11
REQUEST_URI /askquestion.html

ERROR  -  2015-03-26 13:45:00 --> 
Query error:You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '10797,4,1427348700)' at line 1
 SQL:REPLACE INTO ebh_userstates (crid,userid,typeid,subtime) VALUES(,10797,4,1427348700)
simple_query() E:\www\jiazhang\system\db\CDb.php:100
query() E:\www\jiazhang\models\UserstateModel.php:16
insert() E:\www\jiazhang\controllers\askquestion.php:73
_updateuserstate() E:\www\jiazhang\controllers\askquestion.php:49
index() E:\www\jiazhang\system\core\CWebApplication.php:19
processRequest() E:\www\jiazhang\system\core\CApplication.php:31
run() E:\www\jiazhang\index.php:11
REQUEST_URI /askquestion.html

ERROR  -  2015-03-26 17:34:51 --> 
Query error:You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and rc.cstatus = 1' at line 1
 SQL:select c.crid,c.crname,c.domain from ebh_roomusers rc join ebh_classrooms c on (rc.crid = c.crid) where rc.uid =  and rc.cstatus = 1
simple_query() E:\www\jiazhang\system\db\CDb.php:100
query() E:\www\jiazhang\models\ClassroomModel.php:149
getroomlistbyuid() E:\www\jiazhang\lib\Headertop.php:7
getroom() E:\www\jiazhang\views\common\headertop.php:56
include() E:\www\jiazhang\system\core\CControl.php:42
display() E:\www\jiazhang\views\pass.php:18
include() E:\www\jiazhang\system\core\CControl.php:42
display() E:\www\jiazhang\controllers\pass.php:5
index() E:\www\jiazhang\system\core\CWebApplication.php:19
processRequest() E:\www\jiazhang\system\core\CApplication.php:31
run() E:\www\jiazhang\index.php:11
REQUEST_URI /pass.html

