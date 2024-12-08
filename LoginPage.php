<?php
session_start();

include('include/db-connect.php');
include('include/functions.php');

$showForm = true;
$message = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') { 
    $email = $_POST["email"];
    $password = $_POST["password"]; 
 
    $result = loginUser($email, $password);
    if($result == true){
        $showForm = false;
        header('Location:index.php');
        exit();
        //$message = "You have successfully signed in. <a href='index.php'>Home Page</a>";
    }else{
        $message = "Invalid user";
    } 
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up Page</title>
    <link rel="stylesheet" href="LoginSignupPage.css">
</head>
<body>
    <div class="main-container">
        <div class="signup-box">
            <img src="pics/voyago.png" alt="Logo" class="logo">
            <h1>Login</h1>
            <br>
            <?php
            if($message != ""){
                echo "<h2 style='color:blue'>$message</h2>";
            }

            if($showForm)
            {
                
                ?>
            <form action="LoginPage.php" id="signup-form" method="post">

                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter your email">

                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password">
                <br>

                <button type="submit" >Log in</button>
            </form>
            <?php
            }
            ?>
        </div>
    </div>
</body>
</html>