<?php 
session_start();
if(!isset($_SESSION["userid"]) || $_SESSION["userid"] == 0){
    header("Location: LoginPage.php");
    exit();
}
include('include/db-connect.php');
include('include/functions.php');

$travelID = $_GET["travelID"] ?? 0;

$message = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $travelID = $_POST["travelID"];   
        $place_name = $_POST["place-name"];
        $location = $_POST["location"];
        $description = $_POST["description"]; 
        $photo = uploadFile($_FILES) ;
    
        $result = addPlace($travelID, $place_name, $location, $description, $photo);
        if($result == true){ 
            $message = "Place Added Successfully";
        }else{
            $message = "Something goes wrong, please try again later.";
        } 

    if( $_POST["isDone"] == "no"){
        header("Location: index.php");
        exit();
    }
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Visited Places</title>
    <link rel="stylesheet" href="Add new Travel.css">
    <!-- FontAwesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>

<!-- Update -->


<?php
    getHeader();
?>

<br> <br>

<div class="container">
    <h2>Add Visited Places in Your Travel</h2>
    <br>
    <br>
    
    <?php
    if($message != ""){
        echo "<h2>$message</h2>";
    } 
    ?>
    <!--id="placeForm"-->
    <form  class="travel-form" action = "?travelID=<?=$travelID?>" method="post" enctype="multipart/form-data">
        <input type="hidden" id="travelID" name="travelID" value="<?= $travelID ?>">
        <div class="form-group">
            <label for="place-name">Place Name:</label>
            <input type="text" id="place-name" name="place-name" required>
        </div>
        <div class="form-group">
            <label for="location">Location/City:</label>
            <input type="text" id="location" name="location" required>
        </div>
        <div class="form-group">
            <label for="description">Description:</label>
            <textarea id="description" name="description" rows="4" required></textarea>
        </div>
        <div class="form-group">
            <label for="photo">Upload Photo:</label>
            <input type="file" id="photo" name="photo" required>
        </div>
        <div class="button-center form-actions">
            <button type="submit" class="btn btn-enabled" id="addAnotherPlace" name="isDone" value="yes">Add Another Place</button>
            <button type="submit" class="btn btn-enabled" id="done" name="isDone" value="no" >Done</button>
        </div>
    </form>
</div>

<script>
    function checkFormCompletion() {
        const placeName = document.getElementById('place-name').value.trim();
        const location = document.getElementById('location').value.trim();
        const description = document.getElementById('description').value.trim();
        const photo = document.getElementById('photo').value;

        const isFormComplete = placeName && location && description && photo;

        const buttons = document.querySelectorAll('.btn');
        buttons.forEach(button => {
            if (isFormComplete) {
                button.disabled = false;
                button.classList.remove('btn-disabled');
                button.classList.add('btn-enabled');
            } else {
                button.disabled = true;
                button.classList.remove('btn-enabled');
                button.classList.add('btn-disabled');
            }
        });
    }

    document.getElementById('placeForm').addEventListener('input', checkFormCompletion);

    document.getElementById('addAnotherPlace').addEventListener('click', function(event) {
        event.preventDefault();
        document.getElementById('placeForm').reset(); // إعادة تعيين النموذج
        checkFormCompletion(); // إعادة التحقق بعد إعادة التعيين
    });

    document.getElementById('done').addEventListener('click', function() {
        // إظهار رسالة نجاح
        alert("The place(s) have been added successfully.");
        // توجيه المستخدم إلى صفحة "4.html"
        window.location.href = "UsersHomepage.php";
    });
</script>

</body>
</html>