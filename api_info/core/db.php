<?php
$HostName = "localhost";
//Define your database username here.
$HostUser = "kebs";
//Define your database password here.
$HostPass = "kebs12";
//Define your database name here.
$DatabaseName = "sms";
// Create connection
$db = new mysqli($HostName, $HostUser, $HostPass, $DatabaseName);
if ($db->connect_error) {
 die("Connection failed: " . $db->connect_error);
}
?>
