<?php

function getHeader($link="", $title = ""){
	?>
<header>
    <nav class="nav-bar">
        <div class="nav-left">
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Log-Out</a>
			<?php if ($link !='UserTravelPage.php') { ?>
             <a href="index.php"><i class="fas fa-arrow-left"></i> Back to Homepage</a>
			 <?php } ?>
			<?php
			echo $link == ""? "": '<a href="'.$link.'"><i class="fas fa-arrow-left"></i>'. $title.'</a>'; 
			?>
        </div>
        <!-- Center logo in header -->
        <div class="nav-center">
            <img src="pics/voyago.png" alt="Logo" class="logo"> 
        </div>







        <div class="nav-right">
		 <img src="<?=$_SESSION["photo"] == "" ? "pics/profile.jpg" : $_SESSION["photo"]?>" alt="John Doe Small Profile" class="small-profile">
		 Welcome,      <span> <?=$_SESSION["fname"]?> <?=$_SESSION["lname"]?></span>
        </div>
    </nav>
    
    </header>
	<?php
}
function signupUser($first_name, $last_name, $email, $password, $photo){
    $hash_method = PASSWORD_BCRYPT;
	$options = [
		'cost' => 12,
	];
	$password = password_hash($password,$hash_method, $options );
	$query = "insert into `user`(firstName, lastName, emailAddress, password, photoFileName) values('$first_name', '$last_name', '$email', '$password', '$photo')";
	return executeQuery($query);
}


function addTravel($month, $year, $country, $userid){
	$query = "insert into `travel`(userID, month, year, countryID ) values('$userid', '$month', '$year', '$country')";
	return executeQuery($query);
}

function editTravel($travelID, $month, $year, $country , $userid){
	$query = "update`travel` set  month = '$month', year = '$year', countryID = '$country' 
	where userID = '$userid' and id = '$travelID' ";
	return executeQuery($query);
}

function editPlace($placeID, $place_name, $location, $description, $photo){
	if (empty($photo)) 
		$query = "update `place` set name = '$place_name', location = '$location', description = '$description' where id = '$placeID'";
	else
		$query = "update `place` set name = '$place_name', location = '$location', description = '$description' , photoFileName = '$photo' where id = '$placeID'";

	return executeQuery($query);
}

function addPlace($travelID, $place_name, $location, $description, $photo){
    
	$query = "insert into `place`(travelID , name, location, description, photoFileName ) 
		values('$travelID', '$place_name', '$location', '$description', '$photo')";
	return executeQuery($query); 
}

function deleteTravel($travelID){ 
	$query = "delete from `like` where placeID in (SELECT id FROM `place` where travelID = '$travelID')";
	if( executeQuery($query)){
		$query = "delete from comment where placeID in (SELECT id FROM `place` where travelID = '$travelID')";
		if( executeQuery($query)){
			$query = "delete FROM `place` where travelID = '$travelID'";
			if( executeQuery($query)){
				$query = "delete FROM `travel` where id = '$travelID'";
				if( executeQuery($query)){
					return true;
				}else{
					return false;
				}
			}else{
				return false;
			}
		}else{
			return false;
		}
		
	} else{
		return false;
	}
}

function addComment($userID, $placeID, $comment){
    
	$query = "insert into `comment`(userID, placeID, comment ) 
		values('$userID', '$placeID', '$comment')";
	return executeQuery($query); 
}

function likePlace($userID, $placeID){
    try{
		
		$query = "insert into `like`(userID, placeID ) 
			values('$userID', '$placeID')";
		return executeQuery($query); 
	}catch(Exception $e)
	{
		return false;
	}
}

function loginUser($email, $password){ 
	$query = "select * from  `user` where  emailAddress = '$email'";  
	$result =  executeQuery($query);
	if(gettype($result) == "object")
	{
		while($row = mysqli_fetch_assoc($result)) 
		{
			$password = $_POST['password']; // كلمة المرور المدخلة
			$stored_hash = $row['password']; // الهاش المسترجع من قاعدة البيانات

			if (password_verify($password, $stored_hash)) {
				$_SESSION["userid"] = $row["id"];
				$_SESSION["email"] = $row["emailAddress"];
				$_SESSION["fname"] = $row["firstName"];
				$_SESSION["lname"] = $row["lastName"];
				$_SESSION["photo"] = $row["photoFileName"];
				return true;
			}
		}

	}
	return false; 
}

function getLastID(){ 
	$data =0;
	$query = "SELECT LAST_INSERT_ID() as last_id;";  
	$result =  executeQuery($query); 
	if(gettype($result) == "object")
	{
		while($row = mysqli_fetch_assoc($result)) 
		{ 
			$data  = $row["last_id"]; 
		}

	}
	return $data; 
}
function getCountries(){ 
	$data = [];
	$query = "select * from  `country`";  
	$result =  executeQuery($query);
	$i = 0;
	if(gettype($result) == "object")
	{
		while($row = mysqli_fetch_assoc($result)) 
		{ 
			$data[$i++] = $row; 
		}

	}
	return $data; 
}

function getAllTravels(){ 
	$data = [];
	$query = "select *, travel.id as travelID from  `travel`, `user`, `country` 
		where userID = `user`.id 
		and countryID = country.id ";  
	$result =  executeQuery($query);
	$i = 0;
	if(gettype($result) == "object")
	{
		while($row = mysqli_fetch_assoc($result)) 
		{ 
			$data[$i++] = $row; 
		}

	}
	return $data; 
}

function getCountryTravels($countryID){ 
	$data = [];
	$query = "select *, travel.id as travelID from  `travel`, `user`, `country` 
		where userID = `user`.id 
		and countryID = country.id and country.id=$countryID";  
	$result =  executeQuery($query);
	$i = 0;
	if(gettype($result) == "object")
	{
		while($row = mysqli_fetch_assoc($result)) 
		{ 
			$data[$i++] = $row; 
		}

	}
	return $data; 
}

function getMyTravels($userid){ 
	$data = [];
	$query = "select *, travel.id as travelID from  `travel`, `user`, `country` 
		where userID = `user`.id and userID = '$userid'
		and countryID = country.id ";  
	$result =  executeQuery($query);
	$i = 0;
	if(gettype($result) == "object")
	{
		while($row = mysqli_fetch_assoc($result)) 
		{ 
			$data[$i++] = $row; 
		}

	}
	return $data; 
}

function getTravelDetails($travelID){ 
	$data = [];
	$query = "select *, travel.id as travelID from  `travel`, `user` 
		where travel.id = '$travelID' and `user`.id = userID";

	$result =  executeQuery($query); 
	if(gettype($result) == "object")
	{
		while($row = mysqli_fetch_assoc($result)) 
		{ 
			$data = $row;  
		}

	}
	return $data; 
}

function getPlacesList($travelID){ 
	$data = [];
	$query = "select * from  `place` 
		where travelID = '$travelID' ";  
	$result =  executeQuery($query);
	$i = 0;
	if(gettype($result) == "object")
	{
		while($row = mysqli_fetch_assoc($result)) 
		{ 
			$data[$i++] = $row; 
		}

	}
	return $data; 
}
function getPlaceLikes($place_id){ 
	$likes = 0;
	$query = "select count(*) as likes from  `like` 
		where placeID = '$place_id' ";  
	$result =  executeQuery($query);
	$i = 0;
	if(gettype($result) == "object")
	{
		while($row = mysqli_fetch_assoc($result)) 
		{ 
			$likes = $row["likes"]; 
		}

	}
	return $likes; 
}

function getTotalPlaceLikes($travelID){ 
	$likes = 0;
	$query = "select count(*) as likes from `like` where placeID in ( select id from place where travelID = '$travelID');";  
	$result =  executeQuery($query);
	$i = 0;
	if(gettype($result) == "object")
	{
		while($row = mysqli_fetch_assoc($result)) 
		{ 
			$likes = $row["likes"]; 
		}

	}
	return $likes; 
}

function getPlaceComment($place_id){ 
	$data = [];
	$query = "select * from  `comment`, `user` 
		where placeID  = '$place_id'
		and userID = `user`.id ";  
	$result =  executeQuery($query);
	$i = 0;
	if(gettype($result) == "object")
	{
		while($row = mysqli_fetch_assoc($result)) 
		{ 
			$data[$i++] = $row; 
		}

	}
	return $data; 
}

function getCountry($country_id){ 
	$data = [];
	$query = "select * from  `country` where id  = '$country_id' ";  
	$result =  executeQuery($query); 
	if(gettype($result) == "object")
	{
		while($row = mysqli_fetch_assoc($result)) 
		{ 
			$data = $row; 
		}

	}
	return $data; 
}

function uploadFile($files){   
	if($files["photo"]["size"]==0) { 
        return false;       
    }
	//$fileUrl = "images/" . basename($files["photo"]["name"]);
	$filename = uniqid(rand(), true) . '.' . pathinfo($files["photo"]["name"], PATHINFO_EXTENSION);
	$fileUrl = "images/" . $filename;
	move_uploaded_file($files["photo"]["tmp_name"],$fileUrl); 

	return $fileUrl; 
}


function uploadFileAt($files, $index){ 
	print_r($files);
	if($files["photo"]["size"][$index]==0) { 
        return false;       
    }

	$filename = uniqid(rand(), true) . '.' . pathinfo($files["photo"]["name"][$index], PATHINFO_EXTENSION);
	$fileUrl = "images/" . $filename;
	move_uploaded_file($files["photo"]["tmp_name"][$index],$fileUrl); 

	return $fileUrl; 
}


function getCard(){
	?>
	<div class="profile-card">
            <?php
			$photos = ( $_SESSION["photo"] == "")? "pics/profile.jpg" : $_SESSION["photo"] ;
			?>
            <img src="<?=$photos?>" alt="Profile Photo" class="profile-photo">
            <div class="user-info">
                <p><strong>First Name:</strong>  <?=$_SESSION["fname"]?></p>
                <p><strong>Last Name:</strong>  <?=$_SESSION["lname"]?></p>
                <p><strong>Email:</strong> <?=$_SESSION["email"]?></p>
            </div>
        </div>
	<?php
}