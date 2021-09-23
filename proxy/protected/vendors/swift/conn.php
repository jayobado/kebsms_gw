<?php
mysql_connect("localhost","root","j1bu@sms123") or die('Cannot find server');
$db="alumni_cards";
mysql_select_db($db) or die('could not select database' . mysql_error());

?>