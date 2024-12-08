<?php 
session_start();
if(!isset($_SESSION["userid"]) || $_SESSION["userid"] == 0){
    header("Location: LoginPage.php");
    exit();
}
include('include/db-connect.php');
include('include/functions.php');

$travelID = $_GET["id"] ?? 0;
$placesList = getPlacesList($travelID);
$travelDetails = getTravelDetails($travelID);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travel Details</title>
    <link rel="stylesheet" href="Details.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>

<?php getHeader(); ?>

<div class="profile">
    <div class="cover-photo">
        <img src="pics/Back.png" alt="Cover Photo" id="cover-img">
    </div>
    <div class="traveler-info">
        <img src="<?=$travelDetails["photoFileName"]?>" alt="Traveler Photo" class="traveler-photo">
        <div class="traveler-details">
            <h1 class="traveler-name"><?=$travelDetails["firstName"]?> <?=$travelDetails["lastName"]?> Travels</h1>
        </div>
    </div>
</div>

<div class="travel-info">
    <p>Travel to <span class="country"><?=getCountry($travelDetails["countryID"])["country"]?></span>, in <span class="month-year"><?=$travelDetails["month"]?> <?=$travelDetails["year"]?></span></p>
</div>

<?php
$num = 1;
foreach($placesList as $place) {
    $comments = getPlaceComment($place["id"]);
?>
<fieldset class="place-frame">
    <legend class="place-title">Place <?= $num; ?></legend>
    <!-- Like Button with AJAX functionality -->
    <div class="like-btn">
        <button class="like-count" data-place-id="<?= $place["id"] ?>" onclick="likePlace(this)">
            <i class="fas fa-heart"></i> <span class="like-count-number"><?= getPlaceLikes($place["id"]) ?></span>
        </button>
    </div> 

    <div class="place">
        <div class="place-content">
            <img src="<?=$place["photoFileName"]?>" alt="Place Photo" class="place-photo">
            <div class="place-details">
                <h2 class="place-name"><?=$place["name"]?></h2>
                <p class="location">Location: <?=$place["location"]?></p>
                <p class="description"><?=$place["description"]?></p>
            </div>
        </div>

        <div class="comments-section">
            <h3>Comments</h3>
            <div class="comments" id="commentArea-<?= $place["id"] ?>">
                <?php foreach ($comments as $comment) { ?>
                    <p><strong><?= $comment["firstName"] ?>:</strong> <?= $comment["comment"] ?></p>
                <?php } ?>
            </div>
            <form class="add-comment" onsubmit="addComment(event, <?= $place["id"] ?>)">
                <input type="text" name="comment" placeholder="Add a comment" required>
                <button type="submit">Add Comment</button>
            </form>
        </div>
    </div>
</fieldset>
<?php
    $num++;
}
?>

<script>
function likePlace(button) {
    const placeID = $(button).data('place-id');

    $.ajax({
        type: 'POST',
        url: 'likePlace.php', 
        data: { placeID: placeID, userID: <?= $_SESSION["userid"] ?> },
        success: function(response) {
            if (response.success) {
                $(button).find('.like-count-number').text(response.likes);
                $(button).prop('disabled', true); // Disable button after liking
            } else {
                alert('Failed to like the place. Please try again.');
            }
        },
        error: function() {
            alert('Error in request. Please try again.');
        }
    });
}

function addComment(event, placeID) {
    event.preventDefault();
    const commentText = event.target.comment.value;

    $.ajax({
        type: 'POST',
        url: 'add_comment.php',
        data: { comment: commentText, placeID: placeID, userID: <?= $_SESSION["userid"] ?> },
        success: function(response) {
            if (response.success) {
                const commentArea = document.getElementById("commentArea-" + placeID);
                const newComment = document.createElement("p");
                newComment.innerHTML = `<strong>${response.name}:</strong> ${commentText}`;
                commentArea.appendChild(newComment);
                event.target.comment.value = "";
            } else {
                alert("Failed to add comment: " + response.error);
            }
        },
        error: function() {
            alert("Failed to add comment. Please try again.");
        }
    });
}
</script>

</body>
</html>
