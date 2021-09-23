<?php

require_once '../constants/DbOperation.php';
$currentdate = date('Y-m-d');
 $db = new DbOperation();
$response = array();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['phone_id'])) {

        $result = $db->phoneExistsCheck($_POST['phone_id']);
        if ($result>= 1) {
            $response['error'] = false;
            $response['message'] = 'id_exists';
            } elseif ($result == 0) {
                $response['error'] = true;
                $response['message'] = 'new_user';
         }
         }
    elseif(isset($_POST['std_code']) and isset($_POST['phone_id_update'])){
         $db = new DbOperation();
         $result = $db->createStdCode($_POST['std_code'], $_POST['phone_id_update']);
        if ($result == 1) {
            $std_code =strtoupper($_POST['std_code']);
               $product=$db->findFirmByIdSMark($std_code);
               if ($product == 0) {
                     $response['error'] = true;
                     $response['message'] = 'Sorry the query was not found. Kindly send HELP to 20023  or call KEBS toll free line 1545 or send email to qmarks@kebs.org for further assistance.';
               } else {
                    
                    $my_product=addslashes(trim($product['product_name']));
                    $brand=addslashes(trim($product['product_brand']));
                    $firm=addslashes(trim($product['company_name']));
                    $issue_date=$product['issue_date'];
                    $expiry_date=$product['expiry_date'];
                    if($expiry_date > $currentdate) {
                        $validity='Permit is valid';
                    }
                    else{
                      $validity='Permit not valid';
                    }
                    $response['error'] = false;
                    $response['message'] ='Product: '.$my_product.', Brand: '.$brand.', Firm: '.$firm.', SM Issue Date: '.$issue_date.', Expiry Date: '.$expiry_date.', Status: '.$validity.'.';

        }

        }
    }

        elseif(isset($_POST['std_brand']) and isset($_POST['phone_id_update'])){

        $result = $db->createStdBrand($_POST['std_brand'],$_POST['phone_id_update']);
        if ($result == 1) {

               $std_brand =strtoupper($_POST['std_brand']);
               $product=$db->findFirmByIdSMark($std_brand);
               if ($product == 0) {
                     $response['error'] = true;
                     $response['message'] = 'Sorry the query was not found. Kindly send HELP to 20023  or call KEBS toll free line 1545 or send email to qmarks@kebs.org for further assistance.';
               } else {
                    
                    $my_product=addslashes(trim($product['product_name']));
                    $brand=addslashes(trim($product['product_brand']));
                    $firm=addslashes(trim($product['company_name']));
                    $issue_date=$product['issue_date'];
                    $expiry_date=$product['expiry_date'];
                    if($expiry_date >= $currentdate) {
                        $validity='Permit is valid';
                    }
                    else{
                      $validity='Permit not valid';
                    }
                    $response['error'] = false;
                    $response['message'] ='Product: '.$my_product.', Brand: '.$brand.', Firm: '.$firm.', SM Issue Date: '.$issue_date.', Expiry Date: '.$expiry_date.', Status: '.$validity.'.';

                    }
                } elseif ($result == 2) {
                        $response['error'] = true;
                        $response['message'] = 'querry_error';
                    }

        }


        elseif(isset($_POST['d_code']) and isset($_POST['phone_id_update'])){


        $result = $db->createDCode($_POST['d_code'],$_POST['phone_id_update']);
        if ($result == 1) {
            $d_code =strtoupper($_POST['d_code']);
               $product=$db->findFirmByIdDMark($d_code);
               if ($product == 0) {
                     $response['error'] = true;
                     $response['message'] = 'Sorry the query was not found. Kindly send HELP to 20023  or call KEBS toll free line 1545 or send email to qmarks@kebs.org for further assistance.';
               } else {
                    
                $my_product=addslashes(trim($product['product']));
                $firm=addslashes(trim($product['firm_name']));
                $issue_date=$product['issue_date'];
                $expiry_date=$product['expiry_date'];
                                    
                if($expiry_date >= $currentdate) {
                    $validity='Permit is valid';
                }
                else{
                  $validity='Permit not valid';
                }
                    $response['error'] = false;
                    $response['message'] ='Product: '.$my_product.', Firm: '.$firm.', DM Issue Date: '.$issue_date.', Expiry Date: '.$expiry_date.', Status: '.$validity.'.';
                    }
        } elseif ($result == 2) {
            $response['error'] = true;
            $response['message'] = 'querry_error';
        }
        }
        elseif(isset($_POST['d_brand']) and isset($_POST['phone_id_update'])){


        $result = $db->createDBrand($_POST['d_brand'],$_POST['phone_id_update']);
        if ($result == 1) {
            $d_brand =strtoupper($_POST['d_brand']);
               $product=$db->findFirmByIdDMark($d_brand);
               if ($product == 0) {
                     $response['error'] = true;
                     $response['message'] = 'Sorry the query was not found. Kindly send HELP to 20023  or call KEBS toll free line 1545 or send email to qmarks@kebs.org for further assistance.';
               } else {
                    
                $my_product=addslashes(trim($product['product']));
                $firm=addslashes(trim($product['firm_name']));
                $issue_date=$product['issue_date'];
                $expiry_date=$product['expiry_date'];
                                    
                if($expiry_date >= $currentdate) {
                    $validity='Permit is valid';
                }
                else{
                  $validity='Permit not valid';
                }
                    $response['error'] = false;
                    $response['message'] ='Product: '.$my_product.', Firm: '.$firm.', DM Issue Date: '.$issue_date.', Expiry Date: '.$expiry_date.', Status: '.$validity.'.';
                    }
        } elseif ($result == 2) {
            $response['error'] = true;
            $response['message'] = 'querry_error';
        }



        }
        elseif(isset($_POST['f_code'])and isset($_POST['phone_id_update'])){

        $result = $db->createFCode($_POST['f_code'],$_POST['phone_id_update']);
        if ($result == 1) {
            $f_code =strtoupper($_POST['f_code']);
               $product=$db->findFirmByIdFMark($f_code);
               if ($product == 0) {
                     $response['error'] = true;
                     $response['message'] = 'Sorry the query was not found. Kindly send HELP to 20023  or call KEBS toll free line 1545 or send email to qmarks@kebs.org for further assistance.';
               } else {
                    
                $my_product=addslashes(trim($product['product_name']));
                $brand=addslashes(trim($product['product_brand']));
                $firm=addslashes(trim($product['company_name']));
                $region=addslashes(trim($product['region']));
                $issue_date=$product['issue_date'];
                $expiry_date=$product['expiry_date'];

                if($expiry_date >= $currentdate) {
                    $validity='Permit is valid';
                }
                else{
                  $validity='Permit not valid';
                }
                    $response['error'] = false;
                    $response['message'] ='Product: '.$my_product.', Brand: '.$brand.',  Region: '.$region.', Firm: '.$firm.', SM Issue Date: '.$issue_date.', Expiry Date: '.$expiry_date.', Status: '.$validity.'.';
                    }
        } elseif ($result == 2) {
            $response['error'] = true;
            $response['message'] = 'querry_error';
        }


        }
        elseif(isset($_POST['f_brand']) and isset($_POST['phone_id_update'])){

       $result = $db->createFBrand($_POST['f_brand'],$_POST['phone_id_update']);
        if ($result == 1) {
            $f_brand =strtoupper($_POST['f_brand']);
               $product=$db->findFirmByIdFMark($f_brand);
               if ($product == 0) {
                     $response['error'] = true;
                     $response['message'] = 'Sorry the query was not found. Kindly send HELP to 20023  or call KEBS toll free line 1545 or send email to qmarks@kebs.org for further assistance.';
               } else {
                    
                $my_product=addslashes(trim($product['product_name']));
                $brand=addslashes(trim($product['product_brand']));
                $firm=addslashes(trim($product['company_name']));
                $region=addslashes(trim($product['region']));
                $issue_date=$product['issue_date'];
                $expiry_date=$product['expiry_date'];
                
                if($expiry_date >= $currentdate) {
                    $validity='Permit is valid';
                }
                else{
                  $validity='Permit not valid';
                }
                    $response['error'] = false;
                    $response['message'] ='Product: '.$my_product.', Brand: '.$brand.', Region: '.$region.', Firm: '.$firm.', SM Issue Date: '.$issue_date.', Expiry Date: '.$expiry_date.', Status: '.$validity.'.';
                    }
        } elseif ($result == 2) {
            $response['error'] = true;
            $response['message'] = 'querry_error';
        }

        }

        else {
        $response['error'] = true;
        $response['message'] = 'wrong';
    }
} else {
    $response['error'] = true;
    $response['message'] = 'Invalid request method';
}
echo json_encode($response);
