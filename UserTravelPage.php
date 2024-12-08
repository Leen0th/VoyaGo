<?php 
session_start();
if(!isset($_SESSION["userid"]) || $_SESSION["userid"] == 0){
    header("Location: LoginPage.php");
}
include('include/db-connect.php');
include('include/functions.php');

$myTravels = getMyTravels($_SESSION["userid"]); 

if(isset($_GET["act"]) && $_GET["act"]=="delete"){ 
    $travelID = $_GET["travelID"];
    if(deleteTravel($travelID)){
        header("Location: index.php");
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="UserTravelPage.css">
    
    <!-- FontAwesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title> <?=$_SESSION["fname"]?> <?=$_SESSION["lname"]?> Profile</title>
</head>

<body>
    <?php
    getHeader();
    ?>

<!-- Update -->

<div class="background-image">
    <div class="content">
        <div class="text-section">
            <p>Discover, share, and explore endless travel possibilities.</p>
            <h1>Plan Your Next <span class="highlight">Voyago!</span></h1>
        </div>
        
        <?php
            getCard();
        ?>
    </div>
</div>


<!-- End update -->
<main>
    <section class="travels">
        <div class="travels-header">
            <h2>All Travels</h2>
            <a href="Travel Details.php" class="add-travel">Add New Travel +</a>
        </div>

        <div class="table-wrapper">
            <table class="flight-table">
                <thead>
                    <tr>
                        <th rowspan="2">No#</th>
                        <th rowspan="2">Travel</th>
                        <th rowspan="2">Travel Time</th>
                        <th rowspan="2">Country</th>
                        <th colspan="6" class="place-header">Place</th>
                    </tr>
                    <tr>
                        <th>Place Name</th>
                        <th>Location</th>
                        <th>Description</th>
                        <th>Photo</th>
                        <th>Likes</th>
                        <th>Comments</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- First Travel with Two Rows for Multiple Places -->
                     <?php
                     $rowSpan = 0;
                     foreach($myTravels as $travel){
                        $placesList = getPlacesList($travel["travelID"]);
                        $rowSpan = sizeof($placesList);
                        echo "uuuuuuuuuuuuuuuuuuuuuu" . $rowSpan;
                        ?>
                    <tr>
                        <td rowspan="<?=$rowSpan?>"><?=$travel["travelID"]?></td> 
                        <td class="action-links" rowspan="<?=$rowSpan?>">
                            <a href="EditTravelDetails.php?travelID=<?=$travel["travelID"]?>"><i class="fas fa-edit"></i> Edit Travel Details</a><br>
                            <a href="javascript:void(0);" class="delete-travel" data-travel-id="<?=$travel["travelID"]?>"><i class="fas fa-trash-alt"></i> Delete Travel</a>

                        </td> 
                        <td rowspan="<?=$rowSpan?>"><?=$travel["month"]?>/<?=$travel["year"]?></td> 
                        <td rowspan="<?=$rowSpan?>"><?=$travel["country"]?></td> 
                        <?php
                        if($rowSpan == 1)
                        {
                            $placeName = $placesList[0]["name"];
                            $location = $placesList[0]["location"];
                            $description = $placesList[0]["description"];
                            $photo = $placesList[0]["photoFileName"];
                            $likes = getPlaceLikes( $placesList[0]["id"] );
                            $commentes = getPlaceComment($placesList[0]["id"]);
                        ?>

                        

                        <td><?=$placeName?></td>                        
                        <td><?=$location?></td> 
                        <td><?=$description?></td> 
                        <td><img src="<?=$photo?>" alt="<?=$placeName?>" class="travel-photo"></td>
                        <td><i class="fas fa-heart"></i> <?=$likes?></td>
                        <td class="comments-cell">
                            <div class="comments-scrollable">
                                <?php
                                foreach($commentes as $comment){
                                    echo "[".$comment["firstName"]."]: ".$comment["comment"]."<br>";
                                }
                                ?>
                                
                            </div>
                        </td>
                        
                    </tr>
                    <?php } ?>
                    <?php
                     
                     if($rowSpan > 1){ 
                        for($i=0; $i<$rowSpan; $i++)
                        {
                            $placeName = $placesList[$i]["name"];
                            $location = $placesList[$i]["location"];
                            $description = $placesList[$i]["description"];
                            $photo = $placesList[$i]["photoFileName"];
                            $likes = getPlaceLikes( $placesList[$i]["id"] );
                            $commentes = getPlaceComment($placesList[$i]["id"]);
                            ?>
                            <?= $i > 0 ? "<tr>" : "" ?>
                                <td><?=$placeName?></td>                        
                                <td><?=$location?></td> 
                                <td><?=$description?></td> 
                                <td><img src="<?=$photo?>" alt="<?=$placeName?>" class="travel-photo"></td>
                                <td><i class="fas fa-heart"></i> <?=$likes?></td>
                                <td class="comments-cell">
                                    <div class="comments-scrollable">
                                        <?php
                                        foreach($commentes as $comment){
                                            echo "[".$comment["firstName"]."]: ".$comment["comment"]."<br>";
                                        }
                                        ?>
                                        
                                    </div>
                                </td>
                                <?= $i > 0 ? "</tr>" : "" ?>

                            <?php
                        }

                     }
                    ?>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </section>
</main>

 <!-- AJAX --> 
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.delete-travel').forEach(function(button) {
            button.addEventListener('click', function() {
                const travelID = this.getAttribute('data-travel-id');
                const row = this.closest('tr');

                // Create an AJAX request
                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'deleteTravel.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        const response = JSON.parse(xhr.responseText);
                        if (response.success) {
                            row.remove(); // Remove the row from the table
                            alert('Travel deleted successfully.');
                        } else {
                            alert('Failed to delete travel. Please try again.');
                        }
                    }
                };

                // Send the request with the travel ID
                xhr.send('travelID=' + encodeURIComponent(travelID));
            });
        });
    });
</script>

    
 <!-- to upload cover photo--> 
<script>
    function previewCoverPhoto(event) {
        var file = event.target.files[0];
        var reader = new FileReader();
        var preview = document.getElementById('cover-preview');
        
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        }
        
        if (file) {
            reader.readAsDataURL(file);
        }
    }
</script>
</body>
    <!-- Footer Section -->
    <footer class="footer">
        <div class="footer-upper">
            <div class="footer-upper-content">
                <p class="footer-text">Discover, Share, and Explore</p>
                <h2>With Voyago!</h2>
            </div>
        </div>
        <div class="footer-container">
            <div class="footer-content">
                <div class="footer-logo">
                    <p class="brand-name">Voyago!</p>
                    <div class="footer-links">
                        <a href="Homepage.php">About Us</a>
                        <a href="Contact.html">Contact Us</a>
                        <a href="Privacy-policy.html">Privacy Policy</a>
                        <a href="Terms-of-service.html">Terms of Service</a>
                        <a href="Faq.html">FAQ</a>
                    </div>
                </div>
                <div class="footer-apps">
                    <p>Get the App</p>
                    <div class="app-buttons">
                        <img src="https://miro.medium.com/v2/resize:fit:1400/0*HsI5uQ_8Ju9suain.png" alt="Google Play">
                        <img src="https://taproot.com/wp-content/uploads/2024/02/itunes-app-store-logo.png" alt="App Store">
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2024 Voyago</p>
            </div>
        </div>
    </footer>
</html>