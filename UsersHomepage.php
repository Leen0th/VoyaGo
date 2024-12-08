<?php 
if(!isset($_SESSION)) 
{ 
    session_start(); 
} 

if(!isset($_SESSION["userid"]) || $_SESSION["userid"] == 0){
    header("Location: LoginPage.php");
    exit();
}
include('include/db-connect.php');
include('include/functions.php');

$allTravles = getAllTravels(); // Retrieve all travel data on initial page load
$countries = getCountries();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User's Homepage</title>
    <link rel="stylesheet" href="UsersHomepage.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- jQuery Library -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<?php getHeader("UserTravelPage.php", "My Travels"); ?>

<div class="background-image">
    <div class="content">
        <div class="text-section">
            <p>Discover, share, and explore endless travel possibilities.</p>
            <h1>Plan Your Next <span class="highlight">Voyago!</span></h1>
        </div>
        
        <?php getCard(); ?>
    </div>
</div>

<div class="container">
    <div class="filter">
        <h3>All Travels</h3>
        <div>
            <select id="countryFilter" onchange="filterTravelsByCountry()">
                <option value="all">All Countries</option>
                <?php
                    foreach($countries as $country){
                        echo '<option value="'.$country["id"].'">'.$country["country"].'</option>';
                    }
                ?>
            </select>
        </div>
    </div>

    <table class="flight-table">
        <thead>
            <tr>
                <th>Photo</th>
                <th>Traveller</th>
                <th>Country</th>
                <th>Travel Time</th>
                <th>Total Likes</th>
            </tr>
        </thead>
        <tbody id="travelTableBody">
            <?php
                foreach($allTravles as $travel)
                { 
                    if (empty($travel["photoFileName"])) {
                        $travel["photoFileName"] = 'pics/profile.jpg';
                    }
                    ?>
                    <tr>
                        <td>
                            <a href="travelerPage.php?id=<?=$travel["travelID"]?>"><img src="<?=$travel["photoFileName"]?>" alt="User Photo" style="width:60px; height:60px; border-radius:50%; vertical-align:middle;"></a>
                        </td>
                        <td><a href="travelerPage.php?id=<?=$travel["travelID"]?>"><?=$travel["firstName"]." ".$travel["lastName"] ?></a></td>
                        <td><?=$travel["country"]?></td>
                        <td><?=$travel["month"]?> <?=$travel["year"]?></td>
                        <td><i class="fas fa-heart"></i><?=getTotalPlaceLikes($travel["travelID"]) ?: 0 ?></td>
                    </tr>
                    <?php
                }
            ?> 
        </tbody>
    </table>
    <div class="pagination">
        <a href="#">1</a>
    </div>
</div>

<script>
// Function to filter travels by selected country
function filterTravelsByCountry() {
    var countryId = $("#countryFilter").val(); // Get the selected country ID

    // Send AJAX request using jQuery
    $.ajax({
        url: "getTravels.php", // URL to the backend PHP file
        type: "GET", // HTTP method
        data: { country: countryId }, // Data to send
        dataType: "json", // Expected data type
        success: function(data) {
            updateTravelsTable(data); // Update the table with received data
        },
        error: function(xhr, status, error) {
            console.error("Error fetching data:", error); // Log errors
        }
    });
}

// Function to update the travel table dynamically
function updateTravelsTable(travels) {
    var tableBody = $("#travelTableBody");
    tableBody.empty(); // Clear current content

    if (travels.length === 0) {
        tableBody.append('<tr><td colspan="5" style="text-align: center;">No travels found.</td></tr>');
        return;
    }

    travels.forEach(function(travel) {
        var likes = travel.totalLikes || 0; // Default to 0 if undefined
        var row = `
            <tr>
                <td><a href="travelerPage.php?id=${travel.travelID}">
                    <img src="${travel.photoFileName || 'pics/profile.jpg'}" alt="User Photo" style="width:60px; height:60px; border-radius:50%; vertical-align:middle;">
                </a></td>
                <td><a href="travelerPage.php?id=${travel.travelID}">${travel.firstName} ${travel.lastName}</a></td>
                <td>${travel.country}</td>
                <td>${travel.month} ${travel.year}</td>
                <td><i class="fas fa-heart"></i>${likes}</td>
            </tr>`;
        tableBody.append(row); // Append new row
    });
}
</script>

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
</body>
</html>