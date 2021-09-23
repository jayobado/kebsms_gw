<?php
//database connection
include 'core/db.php';
//end of database connection
$s_brand = $_GET['std_id'];
$currentdate = date('Y-m-d');

$sql = "SELECT * FROM fortification WHERE product_name='$s_brand' OR product_brand='$s_brand' OR  fortification_id='$s_brand' ";
  $result = $db->query($sql);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $product_id = $row["product_id"];
        $company_name = ", Firm : ".$row["company_name"];
        $product_name = "Product : ".$row["product_name"];
        $product_brand = ", Brand : ".$row["product_brand"];
        $issue_date = ", FM Issue Date : ".$row["issue_date"];
        $region = ", Region : ".$row["region"];
        $expiryD = $row["expiry_date"];
        $expiry_date = ", Expiry Date : ".$row["expiry_date"];
        $status1 = ", Status : Permit is valid ";
        $status2 = ", Status : Permit Not valid ";
        
        if ($expiryD >= $currentdate) {
            $gen_all = $product_name.$product_brand.$region.$company_name.$issue_date.$expiry_date.$status1;
            $messageerror = "[{\"message\":\"$gen_all\"}]";
            echo "{\"items\":$messageerror}";
        } else {
            $gen_all = $product_name.$product_brand.$region.$company_name.$issue_date.$expiry_date.$status2;
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
  } echo "{\"items\":$json}";*/
  $db->close();
?>
