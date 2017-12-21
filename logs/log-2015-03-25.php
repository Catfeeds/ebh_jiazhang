<?php  if ( ! defined('IN_EBH')) exit('No direct script access allowed'); ?>

ERROR  -  2015-03-25 09:08:04 --> 
Query error:You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ',1,1427245684)' at line 1
 SQL:REPLACE INTO ebh_userstates (crid,userid,typeid,subtime) VALUES(,,1,1427245684)
simple_query() E:\www\jiazhang\system\db\CDb.php:100
query() E:\www\jiazhang\models\UserstateModel.php:16
insert() E:\www\jiazhang\controllers\exam.php:152
_updateuserstate() E:\www\jiazhang\controllers\exam.php:58
index() E:\www\jiazhang\system\core\CWebApplication.php:19
processRequest() E:\www\jiazhang\system\core\CApplication.php:31
run() E:\www\jiazhang\index.php:11
REQUEST_URI /exam.html

