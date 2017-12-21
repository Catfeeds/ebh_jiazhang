<?php  if ( ! defined('IN_EBH')) exit('No direct script access allowed'); ?>

ERROR  -  2015-04-11 11:11:21 --> 
Query error:You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and rc.cstatus = 1' at line 1
 SQL:select c.crid,c.crname,c.domain from ebh_roomusers rc join ebh_classrooms c on (rc.crid = c.crid) where rc.uid =  and rc.cstatus = 1
simple_query() E:\www\jiazhang\system\db\CDb.php:100
query() E:\www\jiazhang\models\ClassroomModel.php:149
getroomlistbyuid() E:\www\jiazhang\lib\Headertop.php:7
getroom() E:\www\jiazhang\views\common\headertop.php:75
include() E:\www\jiazhang\system\core\CControl.php:42
display() E:\www\jiazhang\views\studyrecords.php:10
include() E:\www\jiazhang\system\core\CControl.php:42
display() E:\www\jiazhang\controllers\studyrecords.php:36
index() E:\www\jiazhang\system\core\CWebApplication.php:19
processRequest() E:\www\jiazhang\system\core\CApplication.php:31
run() E:\www\jiazhang\index.php:11
REQUEST_URI /studyrecords.html

