<?php  if ( ! defined('IN_EBH')) exit('No direct script access allowed'); ?>

ERROR  -  2018-01-10 09:12:38 --> 
Query error:You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and cs.uid = 385098' at line 1
 SQL:SELECT cs.classid,c.classname,c.grade,c.district from  ebh_classstudents cs JOIN ebh_classes c on (c.classid = cs.classid) WHERE c.crid= and cs.uid = 385098
simple_query() /data0/htdocs/jiazhang/system/db/CDb.php:100
query() /data0/htdocs/jiazhang/models/ClassesModel.php:28
getClassByUid() /data0/htdocs/jiazhang/controllers/college/examv2.php:1595
getfolderids() /data0/htdocs/jiazhang/controllers/college/examv2.php:127
elistAjax() /data0/htdocs/jiazhang/system/core/CWebApplication.php:19
processRequest() /data0/htdocs/jiazhang/system/core/CApplication.php:31
run() /data0/htdocs/jiazhang/index.php:12
REQUEST_URI /college/examv2/elistAjax.html

