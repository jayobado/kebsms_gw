<?php
//database connection
include 'core/db.php';
//end of database connection
$d_brand = $_GET['std_id'];
$currentdate = date('Y-m-d');

$sql = "SELECT * FROM dmark WHERE product='$d_brand'OR product_id='$d_brand' ";
  $result = $db->query($sql);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $product_id = $row["product_id"];
        $firm_name = "Product : ".$row["product"];
        $product = ", Firm : ".$row["firm_name"];
        $issue_date = ", DM Issue Date : ".$row["issue_date"];
        $expiryD = $row["expiry_date"];
        $expiry_date = ", Expiry Date : ".$row["expiry_date"];
        $status1 = ", Status : Permit is valid ";
        $status2 = ", Status : Permit Not valid ";
        
        if ($expiryD >= $currentdate) {
            $gen_all = $firm_name.$product.$issue_date.$expiry_date.$status1;
            $messageerror = "[{\"message\":\"$gen_all\"}]";
            echo "{\"items\":$messageerror}";
        } else {
            $gen_all = $firm_name.$product.$issue_date.$expiry_date.$status2;
            $messageerror = "[{\"message\":\"$gen_all\"}]";
            echo "{\"items\":$messageerror}";
        }
    } else {
        $messageerror = "[{\"message\":\"Sorry the query was not found. Kindly send HELP to 20023  or call KEBS toll free line 1545 or send email to qmarks@kebs.org for further assistance\"}]";
        echo "{\"items\":$messageerror}";
    }

  /*if ($result->num_rows >0) {
   while($row[] = $result->fetch_assoc()) {
   $tem = $row;
   $json = json_encode($tem);
   //json_encode($tem);
   }
  } else {
   echo "No Results Found.";
  }
  echo "{\"items\":$json}";*/
  $db->close();
?>
