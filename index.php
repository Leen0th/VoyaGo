<?php
session_start();

if(isset($_SESSION["userid"]) && $_SESSION["userid"] > 0){
include("UsersHomepage.php");
}else{
    
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <link rel="stylesheet" href="Homepage.css">
    <!-- FontAwesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Google Font: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap" rel="stylesheet">
</head>

<!-- Header Section -->
<header>
    <nav class="nav-bar">
        <!-- Left-aligned logo in header -->
        <div class="nav-left">
            <img src="pics/voyago.png" alt="Logo" class="logo">
        </div>

        <!-- Right-aligned buttons in header -->
        
    </nav>
</header>


<body>
    <!-- Main content starts here -->
    <div class="holiday-container">
        <div class="holiday-text-wrapper">
            <div class="holiday-text-section">
                <h1>Find Your Next <span class="holiday-highlight">Holiday</span></h1>
                <p>Share Experiences, Find Tips, and Plan Your Dream Trip.</p>
                <br> <br>
                <?php
                    if(isset($_SESSION["userid"]) && $_SESSION["userid"] > 0){
                        echo "<h2> Welcome ".$_SESSION["name"]." (".$_SESSION["email"].")</a>";
                    }else{
                        
                        
                ?>
                <div class="holiday-buttons">
                    <button class="holiday-btn holiday-login-btn" onclick="window.location.href='LoginPage.php'">Log in</button>
                    <button class="holiday-btn holiday-signup-btn" onclick="window.location.href='SignUpPage.php';">Sign up</button>
                </div>
                <?php
                    }
                ?>
            </div>
        </div>
        <div class="holiday-image-wrapper">
            <img src="pics/Image.png" alt="Holiday Hot Air Balloons" class="holiday-image">
        </div>
    </div>
    
    <br> <br> <br>

    <section class="about-us-team">
        <!-- Vision Section -->
        <section class="vision-section">
            <div class="vision-image-wrapper">
                <img src="https://www.format.com/wp-content/uploads/vw-travel-photography-guide.jpg" alt="Vision Image" class="vision-image">
            </div>
            <div class="vision-text-wrapper">
                <h2>About <span class="vision-highlight">US</span></h2>
                <p>Welcome to Voyago, your go-to platform for sharing and discovering travel information. Launched in 2024, Voyago offers a community-driven space for travelers to explore destinations, share experiences, and access travel tips from around the world. Users can post reviews, upload photos, and connect with fellow travelers. Whether planning a trip or exploring from home, Voyago has something for everyone. We're excited to grow with you and welcome your feedback. Reach out anytime for support!

            <p><strong>Sincerely,<br>The Voyago Team</strong></p>
            </div>
        </section>
        
       
        
        <!-- Our Team Section -->
        <section class="team-section">
            <div class="container">
                <h2>Meet Our <span class="vision-highlight">Team</span></h2>
                <div class="team-members">
                    <div class="member">
                        <img src="pics/image0.png" alt="Leen Profile" class="profile-photo">
                        <h3>Leen</h3>
                        <p>Developer</p>
                    </div>
                    <div class="member">
                        <img src="pics/IMG_7682.PNG" alt="Ghaida Profile" class="profile-photo">
                        <h3>Ghaida</h3>
                        <p>Developer</p>
                    </div>
                    <div class="member">
                        <img src="pics/1.png" alt="Aishah Profile" class="profile-photo">
                        <h3>Aeshah</h3>
                        <p>Developer</p>
                    </div>
                    <div class="member">
                        <img src="pics/IMG_2720.jpeg" alt="Luluah Profile" class="profile-photo">
                        <h3>Luluh</h3>
                        <p>Developer</p>
                    </div>
                </div>
            </div>
        </section>
    </section>
    

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

</body>
</html>
<?php

}
?>