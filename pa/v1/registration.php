<?php

require_once '../constants/DbOperation.php';
$response = array();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['phone_id']) and isset($_POST['phone_number'])) {
        $db = new DbOperation();
        $result = $db->createPAuser($_POST['phone_id'],$_POST['phone_number']);
        if ($result == 1) {
            $response['error'] = false;
            $response['message'] = 'registered';
        } elseif ($result == 2) {
            $response['error'] = true;
            $response['message'] = 'Error creating account';
        }
    } else {
        $response['error'] = true;
        $response['message'] = 'error registering';
    }
} else {
    $response['error'] = true;
    $response['message'] = 'Invalid request method';
}
echo json_encode($response);
