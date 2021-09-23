<?php
date_default_timezone_set('Africa/Nairobi');
// Swift Mailer Library
require_once 'lib/swift_required.php';

// Mail Transport
$transport = Swift_SmtpTransport::newInstance('ssl://smtp.gmail.com', 465)
    ->setUsername('jayobado@gmail.com') // Your Gmail Username
    ->setPassword('0badNess'); // Your Gmail Password
$path = 'uploads/';
// Mailer
$mailer = Swift_Mailer::newInstance($transport);
////$attachment = Swift_Attachment::fromPath($path);

// Create a message
$message = Swift_Message::newInstance('Wonderful Subject Here')
    ->setFrom(array('jayobado@gmail.com' => 'KU Alumni')) // can be $_POST['email'] etc...
    ->setTo(array('jayobado@hotmail.com' => 'Jeremy Name')) // your email / multiple supported.
    ->setBody('Here is the <strong>message</strong> itself. It can be text or <h1>HTML</h1>.', 'text/html');
	$message->attach(Swift_Attachment::fromPath('/var/www/swift/poster.jpg','image/jpeg'));        
//$message->attach($attachment);   
// Send the messag
if ($mailer->send($message)) {
    echo 'Mail sent successfully.';
} else {
    echo 'I am sure, your configuration are not correct. :(';
}

?>