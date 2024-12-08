<?php
include 'include/db-connect.php';
include 'include/functions.php';

// Get the selected country ID from the request
$countryID = $_GET['country'];

// Fetch travel data based on the selected country
if ($countryID == 'all') {
    $travels = getAllTravels(); // Fetch all travels
} else {
    $travels = getCountryTravels($countryID); // Fetch travels for a specific country
}

// Ensure totalLikes is included and defaults to 0 if not present
foreach ($travels as &$travel) {
    if (!isset($travel['totalLikes'])) {
        $travel['totalLikes'] = getTotalPlaceLikes($travel['travelID']) ?: 0;
    }
}

// Return the data as a JSON response
header('Content-Type: application/json');
echo json_encode($travels);
?>