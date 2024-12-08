<?php 
session_start();
if(!isset($_SESSION["userid"]) || $_SESSION["userid"] == 0){
    header("Location: LoginPage.php");
    exit();
}
include('include/db-connect.php');
include('include/functions.php');


$countries = getCountries();
$travelID = $_GET["travelID"];
$travelDetails = getTravelDetails($travelID );

$placesList = getPlacesList($travelID);

$message = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $travelID = $_POST["travelID"];
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

    $result = editTravel($travelID, $month, $year, $country, $_SESSION["userid"]);
    if($result == true){ 

        if (isset($_POST['place-id'])) {
			foreach ($_POST['place-id'] as $idx => $value) {
				$placeID = $_POST['place-id'][$idx];

                $place_name = $_POST["place-name"][$idx];
                $location = $_POST["location"][$idx];
                $description = $_POST["description"][$idx];
                $photo = '';

                if (isset($_FILES['photo']['name'][$idx]) && $_FILES['photo']['tmp_name'][$idx] != '') {
                    $photo = uploadFileAt($_FILES, $idx) ; 
                }

                


/*

				$name = isset($_POST['name'][$key]) ? $_POST['name'][$key] : '';
				$location = isset($_POST['location'][$key]) ? $_POST['location'][$key] : '';
				$description = isset($_POST['description'][$key]) ? $_POST['description'][$key] : '';
				$photo = isset($_FILES['photo']['name'][$key]) && $_FILES['photo']['tmp_name'][$key] != '' ? $_FILES['photo']: '';
				$photo_index = $key;
				*/
				editPlace($placeID, $place_name, $location, $description, $photo);
			}
		}


        header("Location: UserTravelPage.php");
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
    <title>Update Travel Details</title>
    <link rel="stylesheet" href="Edit travel details page.css">
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
    <h2>Update Travel Details</h2>
    <br>
    <br>
    <?php
    if($message != ""){
        echo "<ul>$message</ul>";
    } 
    ?>
    <form action="" method="POST" class="travel-form"  enctype="multipart/form-data">
    <input type="hidden" id="travelID" name="travelID" value="<?= $travelDetails['id']; ?>">
        <div class="form-group">
            <label for="month">Travel Time:</label>
            <select id="month" name="month" required>
                <option value="" disabled selected>Select month</option>
                <option value="January" <?=($travelDetails["month"] == "January")?"selected " : ""?>>January</option>
                <option value="February" <?=($travelDetails["month"] == "February")?"selected " : ""?>>February</option>
                <option value="March" <?=($travelDetails["month"] == "March")?"selected " : ""?>>March</option>
                <option value="April" <?=($travelDetails["month"] == "April")?"selected " : ""?>>April</option>
                <option value="May" <?=($travelDetails["month"] == "May")?"selected " : ""?>>May</option>
                <option value="June" <?=($travelDetails["month"] == "June")?"selected " : ""?>>June</option>
                <option value="July" <?=($travelDetails["month"] == "July")?"selected " : ""?>>July</option>
                <option value="August" <?=($travelDetails["month"] == "August")?"selected " : ""?>>August</option>
                <option value="September" <?=($travelDetails["month"] == "September")?"selected " : ""?>>September</option>
                <option value="October" <?=($travelDetails["month"] == "October")?"selected " : ""?>>October</option>
                <option value="November" <?=($travelDetails["month"] == "November")?"selected " : ""?>>November</option>
                <option value="December" <?=($travelDetails["month"] == "December")?"selected " : ""?>>December</option>
            </select>
            <select id="year" name="year" required>
                <option value="" disabled selected>Select year</option>
                <option value="2021" <?=($travelDetails["year"] == "2021")?"selected " : ""?>>2021</option>
                <option value="2022" <?=($travelDetails["year"] == "2022")?"selected " : ""?>>2022</option>
                <option value="2023" <?=($travelDetails["year"] == "2023")?"selected " : ""?>>2023</option>
                <option value="2024" <?=($travelDetails["year"] == "2024")?"selected " : ""?>>2024</option>
            </select>
        </div>
        <div class="form-group">
            <label for="country">Country:</label>
            <select id="country" name="country" required>
                <option value="" disabled selected>Select country</option>
                <?php
                    foreach($countries as $country){
                        $selected = ($country["id"] == $travelDetails["countryID"]) ? " selected " : "";
                        echo '<option value="'.$country["id"].'" '.$selected.'>'.$country["country"].'</option>';
                    }
                ?> 
            </select>
        </div>


        <?php
$num = 1;
foreach($placesList as $place)
{
    ?>

<fieldset class="place-group">
        <legend class="place-title">Place <?= $num; ?></legend>
        <input type="hidden" id="place-id" name="place-id[]" value="<?= $place['id']; ?>">
        <div class="form-group">
            <label for="place-name">Place Name:</label>
            <input type="text" id="place-name" name="place-name[]" required value="<?=$place["name"]?>">
        </div>
        <div class="form-group">
            <label for="location">Location/City:</label>
            <input type="text" id="location" name="location[]" required value="<?=$place["location"]?>">
        </div>
        <div class="form-group">
            <label for="description">Description:</label>
            <textarea id="description" name="description[]" rows="4" required><?=$place["description"]?></textarea>
        </div>
        <div class="form-group photo-group">
        <div class="form-group">
            <label for="photo">Upload Photo:</label>
            <input type="file" id="photo" name="photo[]">
        </div>
        <div class="current-photo">
                    <p>Current Photo:</p>
                    <img src="<?=$place["photoFileName"]?>" alt="Current Photo of Mount Fuji" style="width: 150px; height: 100px;">
                </div>
</div>
        </fieldset>

        <?php $num++;} ?>

        <div class="button-center">
            <button type="submit" class="btn btn-enabled" id="updateButton" >Update</button>
        </div>
    </form>
</div>

<script>
    // Function to check if all fields are filled
    function checkFormCompletion() {
        const month = document.getElementById('month').value;
        const year = document.getElementById('year').value;
        const country = document.getElementById('country').value;
        
        const updateButton = document.getElementById('updateButton');

        if (month && year && country) {
            updateButton.disabled = false;
            updateButton.classList.remove('btn-disabled');
            updateButton.classList.add('btn-enabled');
        } else {
            updateButton.disabled = true;
            updateButton.classList.remove('btn-enabled');
            updateButton.classList.add('btn-disabled');
        }
    }

    // Add event listeners to check form fields on change
    document.getElementById('month').addEventListener('change', checkFormCompletion);
    document.getElementById('year').addEventListener('change', checkFormCompletion);
    document.getElementById('country').addEventListener('change', checkFormCompletion);
</script>

</body>
</html>