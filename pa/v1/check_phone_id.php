<?php
/**
 * CHECK IF THE PHONE ID MATCHES ANY ID IN THE DATABASE AND IF TRUE RETURN A MESSAGE
 */
require_once '../constants/DbOperation.php';
$db = new DbOperation();
$response = array();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['phone_id'])) {
        $result = $db->phoneExistsCheck($_POST['phone_id']);
        if ($result>=1) {
            $response['error'] =false;
            $response['message'] ='id_exists';

            }elseif ($result==0) {
                $response['error'] = true;
                $response['message'] = 'new_user';
            }
         } else {
        $response['error'] = true;
        $response['message'] = 'error checking your phone id';
    }
} else {
    $response['error'] = true;
    $response['message'] = 'Invalid request method';
}
echo json_encode($response);
