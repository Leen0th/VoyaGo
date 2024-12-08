<?php
session_start();
include('include/db-connect.php');
include('include/functions.php');

$response = ['success' => false];
if (isset($_POST['travelID'])) {
    $travelID = $_POST['travelID'];
    if (deleteTravel($travelID)) {
        $response['success'] = true;
    }
}

header('Content-Type: application/json');
echo json_encode($response);
