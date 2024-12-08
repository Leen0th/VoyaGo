<?php
session_start();
include('include/db-connect.php');
include('include/functions.php');

header('Content-Type: application/json');

$response = ['success' => false, 'likes' => 0];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['placeID']) && isset($_SESSION['userid'])) {
    $placeID = $_POST['placeID'];
    $userID = $_SESSION['userid'];

    if (likePlace($userID, $placeID)) {
        $response['likes'] = getPlaceLikes($placeID);
        $response['success'] = true;
    } else {
        $response['error'] = "Failed to add like.";
    }
} else {
    $response['error'] = "Invalid request.";
}

echo json_encode($response);
?>
