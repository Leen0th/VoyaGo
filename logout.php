<?php
session_start();

$_SESSION["userid"] = 0;
$_SESSION["email"] = null;
$_SESSION["name"] =  null;

session_destroy();
$message = "You have logged out successfully";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout Page</title>
    <link rel="stylesheet" href="LoginSignupPage.css">
</head>
<body>
    <div class="main-container">
        <div class="signup-box">
            <img src="pics/voyago.png" alt="Logo" class="logo">
            <h1>Logout</h1>
            <br>
            <?php
            if($message != ""){
                echo "<h2 style='color:blue'>$message</h2>";
            }
            
            ?>
            <br/>
            <a href="index.php">Back to Homepage</a>
        </div>
    </div>
</body>
</html>