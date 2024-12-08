<?php
session_start();
include('include/db-connect.php');
include('include/functions.php');

$showForm = true;
$message = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $photo = uploadFile($_FILES);

    if (empty($photo)) {
        $photo = 'pics/profile.jpg';
    }

    if (isEmailExists($email)) {
        $message = "Email aready exists.";
    } else {
 
    $result = signupUser($first_name, $last_name, $email, $password, $photo);
    if($result == true){
        $showForm = false;

        $result = loginUser($email, $password);
        if($result == true){
            $showForm = false;
            header('Location:index.php');
            exit();
        }
        //$message = "Your account is successfully singed up. <a href='LoginPage.php'>Login now</a>";
    }else{
        $message = "An error happend.";
    } 
}
}

function isEmailExists($email) {
    $query = "select * from  `user` 
		where emailAddress = '$email' ";  
	$result =  executeQuery($query);

    if ($result && mysqli_num_rows($result) > 0)
        return true;
    return false;
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
            <h1>Sign Up</h1>
            <?php
            if($message != ""){
                echo "<h2 style='color:blue'>$message</h2>";
            }

            if($showForm)
            {
                
                ?>
            <form action="SignUpPage.php" id="signup-form" method="post" enctype="multipart/form-data">
                <label for="first-name">First Name</label>
                <input type="text" id="first-name" name="first_name" placeholder="Enter your first name" required>

                <label for="last-name">Last Name</label>
                <input type="text" id="last-name" name="last_name" placeholder="Enter your last name" required>

                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>

                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>

                <label for="photo">Upload Photo (Optional)</label>
                <input type="file" id="photo" name="photo"  >
                <img id="default-photo" src="default-photo.png" alt="Default Photo">

                <button type="submit">Sign Up</button>
            </form>

  
            <?php

if($message != ""){
   // echo "<h2 style='color:blue'>$message</h2>";
}
            }
            ?>
        </div>
    </div>
</body>
</html>