<?php
//database connection
include 'core/db.php';
//end of database connection
$phone_id = $_GET['phone_id'];
$phone_number = date('phone_number');

$sql = "SELECT * FROM PA_user WHERE phone_id='$phone_id'OR phone_number='$phone_number' ";
  $result = $db->query($sql);
  if ($result->num_rows >0) {
      $json = "Already Registered"
      echo "{\"respond\":$json}";
    } else {
      $sql = "INSERT INTO `PA_user` (`phone_id`, `phone_number`) VALUES ('$phone_id','$phone_number') ";
        $result = $db->query($sql);
        $json = "New User"
        echo "{\"respond\":$json}";
    }
?>
