<?php  if ( ! defined('IN_EBH')) exit('No direct script access allowed'); ?>

ERROR  -  2015-04-01 13:23:13 --> 
Query error:You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and rc.cstatus = 1' at line 1
 SQL:select c.crid,c.crname,c.domain from ebh_roomusers rc join ebh_classrooms c on (rc.crid = c.crid) where rc.uid =  and rc.cstatus = 1
simple_query() E:\www\jiazhang\system\db\CDb.php:100
query() E:\www\jiazhang\models\ClassroomModel.php:149
getroomlistbyuid() E:\www\jiazhang\lib\Headertop.php:7
getroom() E:\www\jiazhang\views\common\headertop.php:51
include() E:\www\jiazhang\system\core\CControl.php:42
display() E:\www\jiazhang\views\pass.php:18
include() E:\www\jiazhang\system\core\CControl.php:42
display() E:\www\jiazhang\controllers\pass.php:5
index() E:\www\jiazhang\system\core\CWebApplication.php:19
processRequest() E:\www\jiazhang\system\core\CApplication.php:31
run() E:\www\jiazhang\index.php:11
REQUEST_URI /pass.html

ERROR  -  2015-04-01 14:22:41 --> 
Query error:You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 3
 SQL:select c.cface,c.domain,c.crname,c.crid,c.summary,r.enddate,c.coursenum,c.isschool,c.coursenum,c.examcount from ebh_roomusers r 
			join ebh_classrooms c on r.crid=c.crid
			where r.uid=
simple_query() E:\www\jiazhang\system\db\CDb.php:100
query() E:\www\jiazhang\models\RoomuserModel.php:131
getroomlist() E:\www\jiazhang\controllers\school.php:18
index() E:\www\jiazhang\system\core\CWebApplication.php:19
processRequest() E:\www\jiazhang\system\core\CApplication.php:31
run() E:\www\jiazhang\index.php:11
REQUEST_URI /school.html

ERROR  -  2015-04-01 14:24:02 --> 
Query error:You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 3
 SQL:select c.cface,c.domain,c.crname,c.crid,c.summary,r.enddate,c.coursenum,c.isschool,c.coursenum,c.examcount from ebh_roomusers r 
			join ebh_classrooms c on r.crid=c.crid
			where r.uid=
simple_query() E:\www\jiazhang\system\db\CDb.php:100
query() E:\www\jiazhang\models\RoomuserModel.php:131
getroomlist() E:\www\jiazhang\controllers\school.php:18
index() E:\www\jiazhang\system\core\CWebApplication.php:19
processRequest() E:\www\jiazhang\system\core\CApplication.php:31
run() E:\www\jiazhang\index.php:11
REQUEST_URI /school.html

ERROR  -  2015-04-01 14:24:37 --> 
Query error:You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 3
 SQL:select c.cface,c.domain,c.crname,c.crid,c.summary,r.enddate,c.coursenum,c.isschool,c.coursenum,c.examcount from ebh_roomusers r 
			join ebh_classrooms c on r.crid=c.crid
			where r.uid=
simple_query() E:\www\jiazhang\system\db\CDb.php:100
query() E:\www\jiazhang\models\RoomuserModel.php:131
getroomlist() E:\www\jiazhang\controllers\school.php:20
index() E:\www\jiazhang\system\core\CWebApplication.php:19
processRequest() E:\www\jiazhang\system\core\CApplication.php:31
run() E:\www\jiazhang\index.php:11
REQUEST_URI /school.html

ERROR  -  2015-04-01 14:24:38 --> 
Query error:You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 3
 SQL:select c.cface,c.domain,c.crname,c.crid,c.summary,r.enddate,c.coursenum,c.isschool,c.coursenum,c.examcount from ebh_roomusers r 
			join ebh_classrooms c on r.crid=c.crid
			where r.uid=
simple_query() E:\www\jiazhang\system\db\CDb.php:100
query() E:\www\jiazhang\models\RoomuserModel.php:131
getroomlist() E:\www\jiazhang\controllers\school.php:20
index() E:\www\jiazhang\system\core\CWebApplication.php:19
processRequest() E:\www\jiazhang\system\core\CApplication.php:31
run() E:\www\jiazhang\index.php:11
REQUEST_URI /school.html

ERROR  -  2015-04-01 14:25:08 --> 
Query error:You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 3
 SQL:select c.cface,c.domain,c.crname,c.crid,c.summary,r.enddate,c.coursenum,c.isschool,c.coursenum,c.examcount from ebh_roomusers r 
			join ebh_classrooms c on r.crid=c.crid
			where r.uid=
simple_query() E:\www\jiazhang\system\db\CDb.php:100
query() E:\www\jiazhang\models\RoomuserModel.php:131
getroomlist() E:\www\jiazhang\controllers\school.php:20
index() E:\www\jiazhang\system\core\CWebApplication.php:19
processRequest() E:\www\jiazhang\system\core\CApplication.php:31
run() E:\www\jiazhang\index.php:11
REQUEST_URI /school.html

ERROR  -  2015-04-01 14:25:09 --> 
Query error:You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 3
 SQL:select c.cface,c.domain,c.crname,c.crid,c.summary,r.enddate,c.coursenum,c.isschool,c.coursenum,c.examcount from ebh_roomusers r 
			join ebh_classrooms c on r.crid=c.crid
			where r.uid=
simple_query() E:\www\jiazhang\system\db\CDb.php:100
query() E:\www\jiazhang\models\RoomuserModel.php:131
getroomlist() E:\www\jiazhang\controllers\school.php:20
index() E:\www\jiazhang\system\core\CWebApplication.php:19
processRequest() E:\www\jiazhang\system\core\CApplication.php:31
run() E:\www\jiazhang\index.php:11
REQUEST_URI /school.html

ERROR  -  2015-04-01 14:26:02 --> 
Query error:You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 3
 SQL:select c.cface,c.domain,c.crname,c.crid,c.summary,r.enddate,c.coursenum,c.isschool,c.coursenum,c.examcount from ebh_roomusers r 
			join ebh_classrooms c on r.crid=c.crid
			where r.uid=
simple_query() E:\www\jiazhang\system\db\CDb.php:100
query() E:\www\jiazhang\models\RoomuserModel.php:131
getroomlist() E:\www\jiazhang\controllers\school.php:20
index() E:\www\jiazhang\system\core\CWebApplication.php:19
processRequest() E:\www\jiazhang\system\core\CApplication.php:31
run() E:\www\jiazhang\index.php:11
REQUEST_URI /school.html

ERROR  -  2015-04-01 14:26:02 --> 
Query error:You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 3
 SQL:select c.cface,c.domain,c.crname,c.crid,c.summary,r.enddate,c.coursenum,c.isschool,c.coursenum,c.examcount from ebh_roomusers r 
			join ebh_classrooms c on r.crid=c.crid
			where r.uid=
simple_query() E:\www\jiazhang\system\db\CDb.php:100
query() E:\www\jiazhang\models\RoomuserModel.php:131
getroomlist() E:\www\jiazhang\controllers\school.php:20
index() E:\www\jiazhang\system\core\CWebApplication.php:19
processRequest() E:\www\jiazhang\system\core\CApplication.php:31
run() E:\www\jiazhang\index.php:11
REQUEST_URI /school.html

ERROR  -  2015-04-01 14:26:04 --> 
Query error:You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 3
 SQL:select c.cface,c.domain,c.crname,c.crid,c.summary,r.enddate,c.coursenum,c.isschool,c.coursenum,c.examcount from ebh_roomusers r 
			join ebh_classrooms c on r.crid=c.crid
			where r.uid=
simple_query() E:\www\jiazhang\system\db\CDb.php:100
query() E:\www\jiazhang\models\RoomuserModel.php:131
getroomlist() E:\www\jiazhang\controllers\school.php:20
index() E:\www\jiazhang\system\core\CWebApplication.php:19
processRequest() E:\www\jiazhang\system\core\CApplication.php:31
run() E:\www\jiazhang\index.php:11
REQUEST_URI /school.html

ERROR  -  2015-04-01 14:27:54 --> 
Query error:You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 3
 SQL:select c.cface,c.domain,c.crname,c.crid,c.summary,r.enddate,c.coursenum,c.isschool,c.coursenum,c.examcount from ebh_roomusers r 
			join ebh_classrooms c on r.crid=c.crid
			where r.uid=
simple_query() E:\www\jiazhang\system\db\CDb.php:100
query() E:\www\jiazhang\models\RoomuserModel.php:131
getroomlist() E:\www\jiazhang\controllers\school.php:9
index() E:\www\jiazhang\system\core\CWebApplication.php:19
processRequest() E:\www\jiazhang\system\core\CApplication.php:31
run() E:\www\jiazhang\index.php:11
REQUEST_URI /school.html

ERROR  -  2015-04-01 14:27:55 --> 
Query error:You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 3
 SQL:select c.cface,c.domain,c.crname,c.crid,c.summary,r.enddate,c.coursenum,c.isschool,c.coursenum,c.examcount from ebh_roomusers r 
			join ebh_classrooms c on r.crid=c.crid
			where r.uid=
simple_query() E:\www\jiazhang\system\db\CDb.php:100
query() E:\www\jiazhang\models\RoomuserModel.php:131
getroomlist() E:\www\jiazhang\controllers\school.php:9
index() E:\www\jiazhang\system\core\CWebApplication.php:19
processRequest() E:\www\jiazhang\system\core\CApplication.php:31
run() E:\www\jiazhang\index.php:11
REQUEST_URI /school.html

ERROR  -  2015-04-01 14:31:23 --> 
Query error:You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 3
 SQL:select c.cface,c.domain,c.crname,c.crid,c.summary,r.enddate,c.coursenum,c.isschool,c.coursenum,c.examcount from ebh_roomusers r 
			join ebh_classrooms c on r.crid=c.crid
			where r.uid=
simple_query() E:\www\jiazhang\system\db\CDb.php:100
query() E:\www\jiazhang\models\RoomuserModel.php:131
getroomlist() E:\www\jiazhang\controllers\school.php:19
index() E:\www\jiazhang\system\core\CWebApplication.php:19
processRequest() E:\www\jiazhang\system\core\CApplication.php:31
run() E:\www\jiazhang\index.php:11
REQUEST_URI /school.html

ERROR  -  2015-04-01 14:31:24 --> 
Query error:You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 3
 SQL:select c.cface,c.domain,c.crname,c.crid,c.summary,r.enddate,c.coursenum,c.isschool,c.coursenum,c.examcount from ebh_roomusers r 
			join ebh_classrooms c on r.crid=c.crid
			where r.uid=
simple_query() E:\www\jiazhang\system\db\CDb.php:100
query() E:\www\jiazhang\models\RoomuserModel.php:131
getroomlist() E:\www\jiazhang\controllers\school.php:19
index() E:\www\jiazhang\system\core\CWebApplication.php:19
processRequest() E:\www\jiazhang\system\core\CApplication.php:31
run() E:\www\jiazhang\index.php:11
REQUEST_URI /school.html

ERROR  -  2015-04-01 14:33:37 --> 
Query error:You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 3
 SQL:select c.cface,c.domain,c.crname,c.crid,c.summary,r.enddate,c.coursenum,c.isschool,c.coursenum,c.examcount from ebh_roomusers r 
			join ebh_classrooms c on r.crid=c.crid
			where r.uid=
simple_query() E:\www\jiazhang\system\db\CDb.php:100
query() E:\www\jiazhang\models\RoomuserModel.php:131
getroomlist() E:\www\jiazhang\controllers\school.php:19
index() E:\www\jiazhang\system\core\CWebApplication.php:19
processRequest() E:\www\jiazhang\system\core\CApplication.php:31
run() E:\www\jiazhang\index.php:11
REQUEST_URI /school.html

ERROR  -  2015-04-01 14:33:38 --> 
Query error:You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 3
 SQL:select c.cface,c.domain,c.crname,c.crid,c.summary,r.enddate,c.coursenum,c.isschool,c.coursenum,c.examcount from ebh_roomusers r 
			join ebh_classrooms c on r.crid=c.crid
			where r.uid=
simple_query() E:\www\jiazhang\system\db\CDb.php:100
query() E:\www\jiazhang\models\RoomuserModel.php:131
getroomlist() E:\www\jiazhang\controllers\school.php:19
index() E:\www\jiazhang\system\core\CWebApplication.php:19
processRequest() E:\www\jiazhang\system\core\CApplication.php:31
run() E:\www\jiazhang\index.php:11
REQUEST_URI /school.html

ERROR  -  2015-04-01 14:34:16 --> 
Query error:You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 3
 SQL:select c.cface,c.domain,c.crname,c.crid,c.summary,r.enddate,c.coursenum,c.isschool,c.coursenum,c.examcount from ebh_roomusers r 
			join ebh_classrooms c on r.crid=c.crid
			where r.uid=
simple_query() E:\www\jiazhang\system\db\CDb.php:100
query() E:\www\jiazhang\models\RoomuserModel.php:131
getroomlist() E:\www\jiazhang\controllers\school.php:19
index() E:\www\jiazhang\system\core\CWebApplication.php:19
processRequest() E:\www\jiazhang\system\core\CApplication.php:31
run() E:\www\jiazhang\index.php:11
REQUEST_URI /school.html

ERROR  -  2015-04-01 14:41:53 --> 
Query error:You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 3
 SQL:select c.cface,c.domain,c.crname,c.crid,c.summary,r.enddate,c.coursenum,c.isschool,c.coursenum,c.examcount from ebh_roomusers r 
			join ebh_classrooms c on r.crid=c.crid
			where r.uid=
simple_query() E:\www\jiazhang\system\db\CDb.php:100
query() E:\www\jiazhang\models\RoomuserModel.php:131
getroomlist() E:\www\jiazhang\controllers\school.php:19
index() E:\www\jiazhang\system\core\CWebApplication.php:19
processRequest() E:\www\jiazhang\system\core\CApplication.php:31
run() E:\www\jiazhang\index.php:11
REQUEST_URI /school.html

ERROR  -  2015-04-01 14:41:55 --> 
Query error:You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 3
 SQL:select c.cface,c.domain,c.crname,c.crid,c.summary,r.enddate,c.coursenum,c.isschool,c.coursenum,c.examcount from ebh_roomusers r 
			join ebh_classrooms c on r.crid=c.crid
			where r.uid=
simple_query() E:\www\jiazhang\system\db\CDb.php:100
query() E:\www\jiazhang\models\RoomuserModel.php:131
getroomlist() E:\www\jiazhang\controllers\school.php:19
index() E:\www\jiazhang\system\core\CWebApplication.php:19
processRequest() E:\www\jiazhang\system\core\CApplication.php:31
run() E:\www\jiazhang\index.php:11
REQUEST_URI /school.html

ERROR  -  2015-04-01 14:43:12 --> 
Query error:You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 3
 SQL:select c.cface,c.domain,c.crname,c.crid,c.summary,r.enddate,c.coursenum,c.isschool,c.coursenum,c.examcount from ebh_roomusers r 
			join ebh_classrooms c on r.crid=c.crid
			where r.uid=
simple_query() E:\www\jiazhang\system\db\CDb.php:100
query() E:\www\jiazhang\models\RoomuserModel.php:131
getroomlist() E:\www\jiazhang\controllers\school.php:19
index() E:\www\jiazhang\system\core\CWebApplication.php:19
processRequest() E:\www\jiazhang\system\core\CApplication.php:31
run() E:\www\jiazhang\index.php:11
REQUEST_URI /school.html

ERROR  -  2015-04-01 14:45:43 --> 
Query error:You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 3
 SQL:select c.cface,c.domain,c.crname,c.crid,c.summary,r.enddate,c.coursenum,c.isschool,c.coursenum,c.examcount from ebh_roomusers r 
			join ebh_classrooms c on r.crid=c.crid
			where r.uid=
simple_query() E:\www\jiazhang\system\db\CDb.php:100
query() E:\www\jiazhang\models\RoomuserModel.php:131
getroomlist() E:\www\jiazhang\controllers\school.php:8
index() E:\www\jiazhang\system\core\CWebApplication.php:19
processRequest() E:\www\jiazhang\system\core\CApplication.php:31
run() E:\www\jiazhang\index.php:11
REQUEST_URI /school.html

ERROR  -  2015-04-01 14:46:02 --> 
Query error:You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and rc.cstatus = 1' at line 1
 SQL:select c.crid,c.crname,c.domain from ebh_roomusers rc join ebh_classrooms c on (rc.crid = c.crid) where rc.uid =  and rc.cstatus = 1
simple_query() E:\www\jiazhang\system\db\CDb.php:100
query() E:\www\jiazhang\models\ClassroomModel.php:149
getroomlistbyuid() E:\www\jiazhang\lib\Headertop.php:7
getroom() E:\www\jiazhang\views\common\headertop.php:51
include() E:\www\jiazhang\system\core\CControl.php:42
display() E:\www\jiazhang\views\school.php:10
include() E:\www\jiazhang\system\core\CControl.php:42
display() E:\www\jiazhang\controllers\school.php:10
index() E:\www\jiazhang\system\core\CWebApplication.php:19
processRequest() E:\www\jiazhang\system\core\CApplication.php:31
run() E:\www\jiazhang\index.php:11
REQUEST_URI /school.html

ERROR  -  2015-04-01 15:37:02 --> 
Query error:You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 3
 SQL:select c.cface,c.domain,c.crname,c.crid,c.summary,r.enddate,c.coursenum,c.isschool,c.coursenum,c.examcount from ebh_roomusers r 
			join ebh_classrooms c on r.crid=c.crid
			where r.uid=
simple_query() E:\www\jiazhang\system\db\CDb.php:100
query() E:\www\jiazhang\models\RoomuserModel.php:131
getroomlist() E:\www\jiazhang\controllers\school.php:18
index() E:\www\jiazhang\system\core\CWebApplication.php:19
processRequest() E:\www\jiazhang\system\core\CApplication.php:31
run() E:\www\jiazhang\index.php:11
REQUEST_URI /school.html

ERROR  -  2015-04-01 15:37:41 --> 
Query error:You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 3
 SQL:select c.cface,c.domain,c.crname,c.crid,c.summary,r.enddate,c.coursenum,c.isschool,c.coursenum,c.examcount from ebh_roomusers r 
			join ebh_classrooms c on r.crid=c.crid
			where r.uid=
simple_query() E:\www\jiazhang\system\db\CDb.php:100
query() E:\www\jiazhang\models\RoomuserModel.php:131
getroomlist() E:\www\jiazhang\controllers\school.php:19
index() E:\www\jiazhang\system\core\CWebApplication.php:19
processRequest() E:\www\jiazhang\system\core\CApplication.php:31
run() E:\www\jiazhang\index.php:11
REQUEST_URI /school.html

ERROR  -  2015-04-01 15:37:55 --> 
Query error:You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 3
 SQL:select c.cface,c.domain,c.crname,c.crid,c.summary,r.enddate,c.coursenum,c.isschool,c.coursenum,c.examcount from ebh_roomusers r 
			join ebh_classrooms c on r.crid=c.crid
			where r.uid=
simple_query() E:\www\jiazhang\system\db\CDb.php:100
query() E:\www\jiazhang\models\RoomuserModel.php:131
getroomlist() E:\www\jiazhang\controllers\school.php:19
index() E:\www\jiazhang\system\core\CWebApplication.php:19
processRequest() E:\www\jiazhang\system\core\CApplication.php:31
run() E:\www\jiazhang\index.php:11
REQUEST_URI /school.html

ERROR  -  2015-04-01 15:40:35 --> 
Query error:You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 3
 SQL:select c.cface,c.domain,c.crname,c.crid,c.summary,r.enddate,c.coursenum,c.isschool,c.coursenum,c.examcount from ebh_roomusers r 
			join ebh_classrooms c on r.crid=c.crid
			where r.uid=
simple_query() E:\www\jiazhang\system\db\CDb.php:100
query() E:\www\jiazhang\models\RoomuserModel.php:131
getroomlist() E:\www\jiazhang\controllers\school.php:19
index() E:\www\jiazhang\system\core\CWebApplication.php:19
processRequest() E:\www\jiazhang\system\core\CApplication.php:31
run() E:\www\jiazhang\index.php:11
REQUEST_URI /school.html

ERROR  -  2015-04-01 15:40:56 --> 
Query error:You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 3
 SQL:select c.cface,c.domain,c.crname,c.crid,c.summary,r.enddate,c.coursenum,c.isschool,c.coursenum,c.examcount from ebh_roomusers r 
			join ebh_classrooms c on r.crid=c.crid
			where r.uid=
simple_query() E:\www\jiazhang\system\db\CDb.php:100
query() E:\www\jiazhang\models\RoomuserModel.php:131
getroomlist() E:\www\jiazhang\controllers\school.php:20
index() E:\www\jiazhang\system\core\CWebApplication.php:19
processRequest() E:\www\jiazhang\system\core\CApplication.php:31
run() E:\www\jiazhang\index.php:11
REQUEST_URI /school.html

ERROR  -  2015-04-01 15:41:12 --> 
Query error:You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 3
 SQL:select c.cface,c.domain,c.crname,c.crid,c.summary,r.enddate,c.coursenum,c.isschool,c.coursenum,c.examcount from ebh_roomusers r 
			join ebh_classrooms c on r.crid=c.crid
			where r.uid=
simple_query() E:\www\jiazhang\system\db\CDb.php:100
query() E:\www\jiazhang\models\RoomuserModel.php:131
getroomlist() E:\www\jiazhang\controllers\school.php:20
index() E:\www\jiazhang\system\core\CWebApplication.php:19
processRequest() E:\www\jiazhang\system\core\CApplication.php:31
run() E:\www\jiazhang\index.php:11
REQUEST_URI /school.html

ERROR  -  2015-04-01 15:41:36 --> 
Query error:You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 3
 SQL:select c.cface,c.domain,c.crname,c.crid,c.summary,r.enddate,c.coursenum,c.isschool,c.coursenum,c.examcount from ebh_roomusers r 
			join ebh_classrooms c on r.crid=c.crid
			where r.uid=
simple_query() E:\www\jiazhang\system\db\CDb.php:100
query() E:\www\jiazhang\models\RoomuserModel.php:131
getroomlist() E:\www\jiazhang\controllers\school.php:20
index() E:\www\jiazhang\system\core\CWebApplication.php:19
processRequest() E:\www\jiazhang\system\core\CApplication.php:31
run() E:\www\jiazhang\index.php:11
REQUEST_URI /school.html

ERROR  -  2015-04-01 15:41:57 --> 
Query error:You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 3
 SQL:select c.cface,c.domain,c.crname,c.crid,c.summary,r.enddate,c.coursenum,c.isschool,c.coursenum,c.examcount from ebh_roomusers r 
			join ebh_classrooms c on r.crid=c.crid
			where r.uid=
simple_query() E:\www\jiazhang\system\db\CDb.php:100
query() E:\www\jiazhang\models\RoomuserModel.php:131
getroomlist() E:\www\jiazhang\controllers\school.php:19
index() E:\www\jiazhang\system\core\CWebApplication.php:19
processRequest() E:\www\jiazhang\system\core\CApplication.php:31
run() E:\www\jiazhang\index.php:11
REQUEST_URI /school.html

ERROR  -  2015-04-01 15:49:19 --> 
Query error:You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 3
 SQL:select c.cface,c.domain,c.crname,c.crid,c.summary,r.enddate,c.coursenum,c.isschool,c.coursenum,c.examcount from ebh_roomusers r 
			join ebh_classrooms c on r.crid=c.crid
			where r.uid=
simple_query() E:\www\jiazhang\system\db\CDb.php:100
query() E:\www\jiazhang\models\RoomuserModel.php:131
getroomlist() E:\www\jiazhang\controllers\school.php:9
index() E:\www\jiazhang\system\core\CWebApplication.php:19
processRequest() E:\www\jiazhang\system\core\CApplication.php:31
run() E:\www\jiazhang\index.php:11
REQUEST_URI /school.html

ERROR  -  2015-04-01 16:21:21 --> 
Query error:You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and cs.uid = 10797' at line 1
 SQL:SELECT cs.classid,c.classname,c.grade,c.district from  ebh_classstudents cs JOIN ebh_classes c on (c.classid = cs.classid) WHERE c.crid= and cs.uid = 10797
simple_query() E:\www\jiazhang\system\db\CDb.php:100
query() E:\www\jiazhang\models\ClassesModel.php:288
getClassByUid() E:\www\jiazhang\controllers\progress.php:19
index() E:\www\jiazhang\system\core\CWebApplication.php:19
processRequest() E:\www\jiazhang\system\core\CApplication.php:31
run() E:\www\jiazhang\index.php:11
REQUEST_URI /progress.html

ERROR  -  2015-04-01 16:21:29 --> 
Query error:You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and cs.uid = 10797' at line 1
 SQL:SELECT cs.classid,c.classname,c.grade,c.district from  ebh_classstudents cs JOIN ebh_classes c on (c.classid = cs.classid) WHERE c.crid= and cs.uid = 10797
simple_query() E:\www\jiazhang\system\db\CDb.php:100
query() E:\www\jiazhang\models\ClassesModel.php:288
getClassByUid() E:\www\jiazhang\controllers\exam.php:10
index() E:\www\jiazhang\system\core\CWebApplication.php:19
processRequest() E:\www\jiazhang\system\core\CApplication.php:31
run() E:\www\jiazhang\index.php:11
REQUEST_URI /exam.html

ERROR  -  2015-04-01 16:22:13 --> 
Query error:You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and cs.uid = 10797' at line 1
 SQL:SELECT cs.classid,c.classname,c.grade,c.district from  ebh_classstudents cs JOIN ebh_classes c on (c.classid = cs.classid) WHERE c.crid= and cs.uid = 10797
simple_query() E:\www\jiazhang\system\db\CDb.php:100
query() E:\www\jiazhang\models\ClassesModel.php:288
getClassByUid() E:\www\jiazhang\controllers\progress.php:19
index() E:\www\jiazhang\system\core\CWebApplication.php:19
processRequest() E:\www\jiazhang\system\core\CApplication.php:31
run() E:\www\jiazhang\index.php:11
REQUEST_URI /progress.html

ERROR  -  2015-04-01 16:24:24 --> 
Query error:You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and cs.uid = 10797' at line 1
 SQL:SELECT cs.classid,c.classname,c.grade,c.district from  ebh_classstudents cs JOIN ebh_classes c on (c.classid = cs.classid) WHERE c.crid= and cs.uid = 10797
simple_query() E:\www\jiazhang\system\db\CDb.php:100
query() E:\www\jiazhang\models\ClassesModel.php:288
getClassByUid() E:\www\jiazhang\controllers\progress.php:8
index() E:\www\jiazhang\system\core\CWebApplication.php:19
processRequest() E:\www\jiazhang\system\core\CApplication.php:31
run() E:\www\jiazhang\index.php:11
REQUEST_URI /progress.html

ERROR  -  2015-04-01 16:27:12 --> 
Query error:You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and cs.uid = 10797' at line 1
 SQL:SELECT cs.classid,c.classname,c.grade,c.district from  ebh_classstudents cs JOIN ebh_classes c on (c.classid = cs.classid) WHERE c.crid= and cs.uid = 10797
simple_query() E:\www\jiazhang\system\db\CDb.php:100
query() E:\www\jiazhang\models\ClassesModel.php:288
getClassByUid() E:\www\jiazhang\controllers\progress.php:8
index() E:\www\jiazhang\system\core\CWebApplication.php:19
processRequest() E:\www\jiazhang\system\core\CApplication.php:31
run() E:\www\jiazhang\index.php:11
REQUEST_URI /progress.html

ERROR  -  2015-04-01 16:27:13 --> 
Query error:You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and cs.uid = 10797' at line 1
 SQL:SELECT cs.classid,c.classname,c.grade,c.district from  ebh_classstudents cs JOIN ebh_classes c on (c.classid = cs.classid) WHERE c.crid= and cs.uid = 10797
simple_query() E:\www\jiazhang\system\db\CDb.php:100
query() E:\www\jiazhang\models\ClassesModel.php:288
getClassByUid() E:\www\jiazhang\controllers\progress.php:8
index() E:\www\jiazhang\system\core\CWebApplication.php:19
processRequest() E:\www\jiazhang\system\core\CApplication.php:31
run() E:\www\jiazhang\index.php:11
REQUEST_URI /progress.html

ERROR  -  2015-04-01 16:36:13 --> 
Query error:You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and cs.uid = 10797' at line 1
 SQL:SELECT cs.classid,c.classname,c.grade,c.district from  ebh_classstudents cs JOIN ebh_classes c on (c.classid = cs.classid) WHERE c.crid= and cs.uid = 10797
simple_query() E:\www\jiazhang\system\db\CDb.php:100
query() E:\www\jiazhang\models\ClassesModel.php:288
getClassByUid() E:\www\jiazhang\controllers\progress.php:8
index() E:\www\jiazhang\system\core\CWebApplication.php:19
processRequest() E:\www\jiazhang\system\core\CApplication.php:31
run() E:\www\jiazhang\index.php:11
REQUEST_URI /progress.html

ERROR  -  2015-04-01 16:36:21 --> 
Query error:You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and cs.uid = 10797' at line 1
 SQL:SELECT cs.classid,c.classname,c.grade,c.district from  ebh_classstudents cs JOIN ebh_classes c on (c.classid = cs.classid) WHERE c.crid= and cs.uid = 10797
simple_query() E:\www\jiazhang\system\db\CDb.php:100
query() E:\www\jiazhang\models\ClassesModel.php:288
getClassByUid() E:\www\jiazhang\controllers\progress.php:8
index() E:\www\jiazhang\system\core\CWebApplication.php:19
processRequest() E:\www\jiazhang\system\core\CApplication.php:31
run() E:\www\jiazhang\index.php:11
REQUEST_URI /progress.html

ERROR  -  2015-04-01 16:36:34 --> 
Query error:You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and cs.uid = 10797' at line 1
 SQL:SELECT cs.classid,c.classname,c.grade,c.district from  ebh_classstudents cs JOIN ebh_classes c on (c.classid = cs.classid) WHERE c.crid= and cs.uid = 10797
simple_query() E:\www\jiazhang\system\db\CDb.php:100
query() E:\www\jiazhang\models\ClassesModel.php:288
getClassByUid() E:\www\jiazhang\controllers\progress.php:8
index() E:\www\jiazhang\system\core\CWebApplication.php:19
processRequest() E:\www\jiazhang\system\core\CApplication.php:31
run() E:\www\jiazhang\index.php:11
REQUEST_URI /progress.html

ERROR  -  2015-04-01 16:36:34 --> 
Query error:You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and cs.uid = 10797' at line 1
 SQL:SELECT cs.classid,c.classname,c.grade,c.district from  ebh_classstudents cs JOIN ebh_classes c on (c.classid = cs.classid) WHERE c.crid= and cs.uid = 10797
simple_query() E:\www\jiazhang\system\db\CDb.php:100
query() E:\www\jiazhang\models\ClassesModel.php:288
getClassByUid() E:\www\jiazhang\controllers\progress.php:8
index() E:\www\jiazhang\system\core\CWebApplication.php:19
processRequest() E:\www\jiazhang\system\core\CApplication.php:31
run() E:\www\jiazhang\index.php:11
REQUEST_URI /progress.html

ERROR  -  2015-04-01 16:36:34 --> 
Query error:You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and cs.uid = 10797' at line 1
 SQL:SELECT cs.classid,c.classname,c.grade,c.district from  ebh_classstudents cs JOIN ebh_classes c on (c.classid = cs.classid) WHERE c.crid= and cs.uid = 10797
simple_query() E:\www\jiazhang\system\db\CDb.php:100
query() E:\www\jiazhang\models\ClassesModel.php:288
getClassByUid() E:\www\jiazhang\controllers\progress.php:8
index() E:\www\jiazhang\system\core\CWebApplication.php:19
processRequest() E:\www\jiazhang\system\core\CApplication.php:31
run() E:\www\jiazhang\index.php:11
REQUEST_URI /progress.html

ERROR  -  2015-04-01 16:36:52 --> 
Query error:You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and cs.uid = 10797' at line 1
 SQL:SELECT cs.classid,c.classname,c.grade,c.district from  ebh_classstudents cs JOIN ebh_classes c on (c.classid = cs.classid) WHERE c.crid= and cs.uid = 10797
simple_query() E:\www\jiazhang\system\db\CDb.php:100
query() E:\www\jiazhang\models\ClassesModel.php:288
getClassByUid() E:\www\jiazhang\controllers\progress.php:8
index() E:\www\jiazhang\system\core\CWebApplication.php:19
processRequest() E:\www\jiazhang\system\core\CApplication.php:31
run() E:\www\jiazhang\index.php:11
REQUEST_URI /progress.html

ERROR  -  2015-04-01 16:36:57 --> 
Query error:You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and cs.uid = 10797' at line 1
 SQL:SELECT cs.classid,c.classname,c.grade,c.district from  ebh_classstudents cs JOIN ebh_classes c on (c.classid = cs.classid) WHERE c.crid= and cs.uid = 10797
simple_query() E:\www\jiazhang\system\db\CDb.php:100
query() E:\www\jiazhang\models\ClassesModel.php:288
getClassByUid() E:\www\jiazhang\controllers\progress.php:8
index() E:\www\jiazhang\system\core\CWebApplication.php:19
processRequest() E:\www\jiazhang\system\core\CApplication.php:31
run() E:\www\jiazhang\index.php:11
REQUEST_URI /progress.html

ERROR  -  2015-04-01 16:48:13 --> 
Query error:You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and rc.cstatus = 1' at line 1
 SQL:select c.crid,c.crname,c.domain from ebh_roomusers rc join ebh_classrooms c on (rc.crid = c.crid) where rc.uid =  and rc.cstatus = 1
simple_query() E:\www\jiazhang\system\db\CDb.php:100
query() E:\www\jiazhang\models\ClassroomModel.php:149
getroomlistbyuid() E:\www\jiazhang\lib\Headertop.php:7
getroom() E:\www\jiazhang\views\common\headertop.php:51
include() E:\www\jiazhang\system\core\CControl.php:42
display() E:\www\jiazhang\views\pass.php:20
include() E:\www\jiazhang\system\core\CControl.php:42
display() E:\www\jiazhang\controllers\pass.php:5
index() E:\www\jiazhang\system\core\CWebApplication.php:19
processRequest() E:\www\jiazhang\system\core\CApplication.php:31
run() E:\www\jiazhang\index.php:11
REQUEST_URI /pass.html

ERROR  -  2015-04-01 16:48:19 --> 
Query error:You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and rc.cstatus = 1' at line 1
 SQL:select c.crid,c.crname,c.domain from ebh_roomusers rc join ebh_classrooms c on (rc.crid = c.crid) where rc.uid =  and rc.cstatus = 1
simple_query() E:\www\jiazhang\system\db\CDb.php:100
query() E:\www\jiazhang\models\ClassroomModel.php:149
getroomlistbyuid() E:\www\jiazhang\lib\Headertop.php:7
getroom() E:\www\jiazhang\views\common\headertop.php:51
include() E:\www\jiazhang\system\core\CControl.php:42
display() E:\www\jiazhang\views\pass.php:20
include() E:\www\jiazhang\system\core\CControl.php:42
display() E:\www\jiazhang\controllers\pass.php:5
index() E:\www\jiazhang\system\core\CWebApplication.php:19
processRequest() E:\www\jiazhang\system\core\CApplication.php:31
run() E:\www\jiazhang\index.php:11
REQUEST_URI /pass.html

ERROR  -  2015-04-01 16:48:32 --> 
Query error:You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and rc.cstatus = 1' at line 1
 SQL:select c.crid,c.crname,c.domain from ebh_roomusers rc join ebh_classrooms c on (rc.crid = c.crid) where rc.uid =  and rc.cstatus = 1
simple_query() E:\www\jiazhang\system\db\CDb.php:100
query() E:\www\jiazhang\models\ClassroomModel.php:149
getroomlistbyuid() E:\www\jiazhang\lib\Headertop.php:7
getroom() E:\www\jiazhang\views\common\headertop.php:51
include() E:\www\jiazhang\system\core\CControl.php:42
display() E:\www\jiazhang\views\pass.php:18
include() E:\www\jiazhang\system\core\CControl.php:42
display() E:\www\jiazhang\controllers\pass.php:5
index() E:\www\jiazhang\system\core\CWebApplication.php:19
processRequest() E:\www\jiazhang\system\core\CApplication.php:31
run() E:\www\jiazhang\index.php:11
REQUEST_URI /pass.html

ERROR  -  2015-04-01 16:49:52 --> 
Query error:You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and rc.cstatus = 1' at line 1
 SQL:select c.crid,c.crname,c.domain from ebh_roomusers rc join ebh_classrooms c on (rc.crid = c.crid) where rc.uid =  and rc.cstatus = 1
simple_query() E:\www\jiazhang\system\db\CDb.php:100
query() E:\www\jiazhang\models\ClassroomModel.php:149
getroomlistbyuid() E:\www\jiazhang\lib\Headertop.php:7
getroom() E:\www\jiazhang\views\common\headertop.php:51
include() E:\www\jiazhang\system\core\CControl.php:42
display() E:\www\jiazhang\views\pass.php:18
include() E:\www\jiazhang\system\core\CControl.php:42
display() E:\www\jiazhang\controllers\pass.php:5
index() E:\www\jiazhang\system\core\CWebApplication.php:19
processRequest() E:\www\jiazhang\system\core\CApplication.php:31
run() E:\www\jiazhang\index.php:11
REQUEST_URI /pass.html

ERROR  -  2015-04-01 17:21:37 --> 
Query error:You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and rc.cstatus = 1' at line 1
 SQL:select c.crid,c.crname,c.domain from ebh_roomusers rc join ebh_classrooms c on (rc.crid = c.crid) where rc.uid =  and rc.cstatus = 1
simple_query() E:\www\jiazhang\system\db\CDb.php:100
query() E:\www\jiazhang\models\ClassroomModel.php:149
getroomlistbyuid() E:\www\jiazhang\lib\Headertop.php:7
getroom() E:\www\jiazhang\views\common\headertop.php:51
include() E:\www\jiazhang\system\core\CControl.php:42
display() E:\www\jiazhang\views\pass.php:20
include() E:\www\jiazhang\system\core\CControl.php:42
display() E:\www\jiazhang\controllers\pass.php:5
index() E:\www\jiazhang\system\core\CWebApplication.php:19
processRequest() E:\www\jiazhang\system\core\CApplication.php:31
run() E:\www\jiazhang\index.php:11
REQUEST_URI /pass.html

ERROR  -  2015-04-01 17:23:33 --> 
Query error:You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and rc.cstatus = 1' at line 1
 SQL:select c.crid,c.crname,c.domain from ebh_roomusers rc join ebh_classrooms c on (rc.crid = c.crid) where rc.uid =  and rc.cstatus = 1
simple_query() E:\www\jiazhang\system\db\CDb.php:100
query() E:\www\jiazhang\models\ClassroomModel.php:149
getroomlistbyuid() E:\www\jiazhang\lib\Headertop.php:7
getroom() E:\www\jiazhang\views\common\headertop.php:51
include() E:\www\jiazhang\system\core\CControl.php:42
display() E:\www\jiazhang\views\pass.php:20
include() E:\www\jiazhang\system\core\CControl.php:42
display() E:\www\jiazhang\controllers\pass.php:5
index() E:\www\jiazhang\system\core\CWebApplication.php:19
processRequest() E:\www\jiazhang\system\core\CApplication.php:31
run() E:\www\jiazhang\index.php:11
REQUEST_URI /pass.html

ERROR  -  2015-04-01 17:26:05 --> 
Query error:You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and rc.cstatus = 1' at line 1
 SQL:select c.crid,c.crname,c.domain from ebh_roomusers rc join ebh_classrooms c on (rc.crid = c.crid) where rc.uid =  and rc.cstatus = 1
simple_query() E:\www\jiazhang\system\db\CDb.php:100
query() E:\www\jiazhang\models\ClassroomModel.php:149
getroomlistbyuid() E:\www\jiazhang\lib\Headertop.php:7
getroom() E:\www\jiazhang\views\common\headertop.php:51
include() E:\www\jiazhang\system\core\CControl.php:42
display() E:\www\jiazhang\views\pass.php:20
include() E:\www\jiazhang\system\core\CControl.php:42
display() E:\www\jiazhang\controllers\pass.php:5
index() E:\www\jiazhang\system\core\CWebApplication.php:19
processRequest() E:\www\jiazhang\system\core\CApplication.php:31
run() E:\www\jiazhang\index.php:11
REQUEST_URI /pass.html

ERROR  -  2015-04-01 17:26:06 --> 
Query error:You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and rc.cstatus = 1' at line 1
 SQL:select c.crid,c.crname,c.domain from ebh_roomusers rc join ebh_classrooms c on (rc.crid = c.crid) where rc.uid =  and rc.cstatus = 1
simple_query() E:\www\jiazhang\system\db\CDb.php:100
query() E:\www\jiazhang\models\ClassroomModel.php:149
getroomlistbyuid() E:\www\jiazhang\lib\Headertop.php:7
getroom() E:\www\jiazhang\views\common\headertop.php:51
include() E:\www\jiazhang\system\core\CControl.php:42
display() E:\www\jiazhang\views\pass.php:20
include() E:\www\jiazhang\system\core\CControl.php:42
display() E:\www\jiazhang\controllers\pass.php:5
index() E:\www\jiazhang\system\core\CWebApplication.php:19
processRequest() E:\www\jiazhang\system\core\CApplication.php:31
run() E:\www\jiazhang\index.php:11
REQUEST_URI /pass.html

ERROR  -  2015-04-01 17:26:06 --> 
Query error:You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and rc.cstatus = 1' at line 1
 SQL:select c.crid,c.crname,c.domain from ebh_roomusers rc join ebh_classrooms c on (rc.crid = c.crid) where rc.uid =  and rc.cstatus = 1
simple_query() E:\www\jiazhang\system\db\CDb.php:100
query() E:\www\jiazhang\models\ClassroomModel.php:149
getroomlistbyuid() E:\www\jiazhang\lib\Headertop.php:7
getroom() E:\www\jiazhang\views\common\headertop.php:51
include() E:\www\jiazhang\system\core\CControl.php:42
display() E:\www\jiazhang\views\pass.php:20
include() E:\www\jiazhang\system\core\CControl.php:42
display() E:\www\jiazhang\controllers\pass.php:5
index() E:\www\jiazhang\system\core\CWebApplication.php:19
processRequest() E:\www\jiazhang\system\core\CApplication.php:31
run() E:\www\jiazhang\index.php:11
REQUEST_URI /pass.html

ERROR  -  2015-04-01 17:35:13 --> 
Query error:You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and rc.cstatus = 1' at line 1
 SQL:select c.crid,c.crname,c.domain from ebh_roomusers rc join ebh_classrooms c on (rc.crid = c.crid) where rc.uid =  and rc.cstatus = 1
simple_query() E:\www\jiazhang\system\db\CDb.php:100
query() E:\www\jiazhang\models\ClassroomModel.php:149
getroomlistbyuid() E:\www\jiazhang\lib\Headertop.php:7
getroom() E:\www\jiazhang\views\common\headertop.php:51
include() E:\www\jiazhang\system\core\CControl.php:42
display() E:\www\jiazhang\views\pass.php:9
include() E:\www\jiazhang\system\core\CControl.php:42
display() E:\www\jiazhang\controllers\pass.php:5
index() E:\www\jiazhang\system\core\CWebApplication.php:19
processRequest() E:\www\jiazhang\system\core\CApplication.php:31
run() E:\www\jiazhang\index.php:11
REQUEST_URI /pass.html

ERROR  -  2015-04-01 21:11:40 --> 
Query error:You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and rc.cstatus = 1' at line 1
 SQL:select c.crid,c.crname,c.domain from ebh_roomusers rc join ebh_classrooms c on (rc.crid = c.crid) where rc.uid =  and rc.cstatus = 1
simple_query() E:\www\jiazhang\system\db\CDb.php:100
query() E:\www\jiazhang\models\ClassroomModel.php:149
getroomlistbyuid() E:\www\jiazhang\lib\Headertop.php:7
getroom() E:\www\jiazhang\views\common\headertop.php:51
include() E:\www\jiazhang\system\core\CControl.php:42
display() E:\www\jiazhang\views\pass.php:9
include() E:\www\jiazhang\system\core\CControl.php:42
display() E:\www\jiazhang\controllers\pass.php:5
index() E:\www\jiazhang\system\core\CWebApplication.php:19
processRequest() E:\www\jiazhang\system\core\CApplication.php:31
run() E:\www\jiazhang\index.php:11
REQUEST_URI /pass.html

ERROR  -  2015-04-01 21:12:42 --> 
Query error:You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and rc.cstatus = 1' at line 1
 SQL:select c.crid,c.crname,c.domain from ebh_roomusers rc join ebh_classrooms c on (rc.crid = c.crid) where rc.uid =  and rc.cstatus = 1
simple_query() E:\www\jiazhang\system\db\CDb.php:100
query() E:\www\jiazhang\models\ClassroomModel.php:149
getroomlistbyuid() E:\www\jiazhang\lib\Headertop.php:7
getroom() E:\www\jiazhang\views\common\headertop.php:51
include() E:\www\jiazhang\system\core\CControl.php:42
display() E:\www\jiazhang\views\pass.php:9
include() E:\www\jiazhang\system\core\CControl.php:42
display() E:\www\jiazhang\controllers\pass.php:5
index() E:\www\jiazhang\system\core\CWebApplication.php:19
processRequest() E:\www\jiazhang\system\core\CApplication.php:31
run() E:\www\jiazhang\index.php:11
REQUEST_URI /pass.html

