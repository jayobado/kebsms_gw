<?php
date_default_timezone_set('Africa/Nairobi');
// Swift Mailer Library
require_once 'lib/swift_required.php';
//require_once ('conn.php');

$query = "SELECT * FROM emails WHERE sent=0 LIMIT 5";
$res=mysql_query($query) or die(mysql_error());

while($row=mysql_fetch_assoc($res) ){

$subject=$row['subject'];
$msg=$row['outgoing_message'];
$recipient=$row['email'];
$id=$row['id'];
// Mail Transport
$transport = Swift_SmtpTransport::newInstance('ssl://smtp.gmail.com', 465)
    ->setUsername('director-alumni@ku.ac.ke') // Your Gmail Username
    ->setPassword('alumni2013'); // Your Gmail Password

// Mailer
$mailer = Swift_Mailer::newInstance($transport);

// Create a message
$message = Swift_Message::newInstance($subject)
    ->setFrom(array('director-alumni@ku.ac.ke' => 'KEBS SMS')) // can be $_POST['email'] etc...
    ->setTo($recipient) // your email / multiple supported.
    ->setBody($msg);
$message->attach(Swift_Attachment::fromPath('/var/www/swift/poster.jpg','image/jpeg'));        

// Send the message
if ($mailer->send($message)) {
    echo 'Mail sent successfully.';
	mysql_query("UPDATE emails SET sent=1 WHERE id=$id") or die(mysql_error());
} else {
    echo 'I am sure, your configuration are not correct. :(';
}
}
?>
