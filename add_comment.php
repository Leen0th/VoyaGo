<?php
session_start();
include('include/db-connect.php'); 
include('include/functions.php'); 

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["comment"], $_POST["placeID"], $_SESSION["userid"])) {
    $comment = $_POST["comment"];
    $placeID = $_POST["placeID"];
    $userID = $_SESSION["userid"];

    if (empty($comment) || empty($placeID)) {
        echo json_encode(["success" => false, "error" => "Missing data"]);
        exit;
    }

    if (addComment($userID, $placeID, $comment)) {
        $stmt = $conn->prepare("SELECT firstName FROM user WHERE id = ?");
        $stmt->bind_param("i", $userID);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        echo json_encode(["success" => true, "name" => $user["firstName"]]);
    } else {
        echo json_encode(["success" => false, "error" => "Failed to add comment"]);
    }
} else {
    echo json_encode(["success" => false, "error" => "Invalid request method"]);
}
?>
