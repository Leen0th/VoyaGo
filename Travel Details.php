<?php 
session_start();
if(!isset($_SESSION["userid"]) || $_SESSION["userid"] == 0){
    header("Location: LoginPage.php");
    exit();
}
include('include/db-connect.php');
include('include/functions.php');


$countries = getCountries();

$message = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $month = $_POST["month"];
    $year = $_POST["year"];
    $country = $_POST["country"];
    
    if($month == ""){ 
        $message.= "<li>Month not selected</li>";
    }
    if($year == ""){ 
        $message.= "<li>Year not selected</li>";
    }
    if($country == ""){ 
        $message.= "<li>Coutnry not selected</li>";
    }
    if($message != "")
        return ; 

    $result = addTravel($month, $year, $country, $_SESSION["userid"]);
    if($result == true){
        $travelID = getLastID() ;
        header("Location: Place%20Details.php?travelID=$travelID");
        exit();
    }else{
        $message = "<li>Something goes wrong, please try again later.</li>";
    } 
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Travel</title>
    <link rel="stylesheet" href="Add new Travel.css">
    <!-- FontAwesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>

   <!-- Update -->

   <?php
    getHeader("UserTravelPage.php", "My Travels");
   ?>

<br> <br>


       

<!--End Update -->

<div class="container">
    <h2>Add New Travel</h2>
    <br>
    <br>
    <?php
    if($message != ""){
        echo "<ul>$message</ul>";
    } 
    ?>
    <form action="" method="POST" class="travel-form">
        <div class="form-group">
            <label for="month">Travel Time:</label>
            <select id="month" name="month" required>
                <option value="" disabled selected>Select month</option>
                <option value="January">January</option>
                <option value="February">February</option>
                <option value="March">March</option>
                <option value="April">April</option>
                <option value="May">May</option>
                <option value="June">June</option>
                <option value="July">July</option>
                <option value="August">August</option>
                <option value="September">September</option>
                <option value="October">October</option>
                <option value="November">November</option>
                <option value="December">December</option>
            </select>
            <select id="year" name="year" required>
                <option value="" disabled selected>Select year</option>
                <option value="2021">2021</option>
                <option value="2022">2022</option>
                <option value="2023">2023</option>
                <option value="2024">2024</option>
            </select>
        </div>
        <div class="form-group">
            <label for="country">Country:</label>
            <select id="country" name="country" required>
                <option value="" disabled selected>Select country</option>
                <?php
                    foreach($countries as $country){
                        echo '<option value="'.$country["id"].'">'.$country["country"].'</option>';
                    }
                ?> 
            </select>
        </div>
        <div class="button-center">
            <button type="submit" class="btn btn-disabled" id="nextButton" >Next</button>
        </div>
    </form>
</div>

<script>
    // Function to check if all fields are filled
    function checkFormCompletion() {
        const month = document.getElementById('month').value;
        const year = document.getElementById('year').value;
        const country = document.getElementById('country').value;
        
        const nextButton = document.getElementById('nextButton');

        if (month && year && country) {
            nextButton.disabled = false;
            nextButton.classList.remove('btn-disabled');
            nextButton.classList.add('btn-enabled');
        } else {
            nextButton.disabled = true;
            nextButton.classList.remove('btn-enabled');
            nextButton.classList.add('btn-disabled');
        }
    }

    // Add event listeners to check form fields on change
    document.getElementById('month').addEventListener('change', checkFormCompletion);
    document.getElementById('year').addEventListener('change', checkFormCompletion);
    document.getElementById('country').addEventListener('change', checkFormCompletion);
</script>

</body>
</html>