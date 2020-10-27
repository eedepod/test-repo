<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Welcome Home</title>
<link rel="stylesheet" href="css/style.css" />
</head>
<body>
<script type="text/javascript">


</script>



<?php
//include auth.php file on all secure pages
include("auth.php");
require('db.php');
$strcreateroom="<div class='create_room'>
<form name='registration' action='' method='post'>
<input type='text' name='roomname' placeholder='Roomname' required />
<input name='submit' type='submit' value='Create room' />
</form>
</div>";
$strlogout = "
<div class='login_form'>
<p>Welcome ". $_SESSION['username'] . "!</p>
<a href='logout.php'>Logout</a>
</div>
";

$cards = range(1, 52);
$scards="";
$user=$_SESSION['username'];
$roomnum=0;
$thisusernoroom = false;
$thisuserflag = false;

//proverka na prisutstvie v komnate
$query = "SELECT roomid FROM `users` WHERE username='$user'";
$result = mysqli_query($con,$query) or die(mysql_error());
if (mysqli_num_rows($result) > 0) {
	while($row = mysqli_fetch_assoc($result)) {
	$roomnum = $row["roomid"];
	}
}else{echo "netu";}


echo $strlogout;



if (isset($_REQUEST['roomname'])){
	$roomname = stripslashes($_REQUEST['roomname']);
	//sozdat kolodu
	srand((float)microtime() * 1000000);
	shuffle($cards);
	while (list(, $card) = each($cards)) {
		$scards ="$card-$scards";
	}
	
	//zapisat kolodu
	$query = "INSERT into `carddecks` (carddeck) VALUES ('$scards')";
	if (mysqli_query($con, $query)) {
		$carddeckid = mysqli_insert_id($con);
		//echo "kaloda zapisalas $scards s id: $carddeckid";
		//echo "<br>";
	} else {
		echo "Error: " . $query . "<br>" . mysqli_error($con);
	}
	
	//sozdat komnatu i zapisat s id kolody
	$query = "INSERT into `rooms` (roomname, carddeckid) VALUES ('$roomname', '$carddeckid')";
	if (mysqli_query($con, $query)) {
		$roomid = mysqli_insert_id($con);
        //echo "komnata $roomid zapisalas s id: $roomid";
		//echo "<br>";
    }else {echo "Error: " . $query . "<br>" . mysqli_error($con);}
	
	// dobavit komnatu polzovatelju
	$user=$_SESSION['username'];
	//echo $user;
	$query = "UPDATE users SET roomid=$roomid WHERE username='$user'";
	if (mysqli_query($con, $query)) {
        //echo "v pole $roomid polzovatelja $user zapisalas: $roomid";
		//echo "<br>";
    }else {echo "Error: " . $query . "<br>" . mysqli_error($con);}
	
}else{
	



//echo $roomnum;
if ($roomnum == 0){echo $strcreateroom;}

 }
	//$arr=array();
	$count = 0;
	$query = "SELECT username, roomid FROM `users`";
	$result = $con->query($query);
	if ($result->num_rows > 0) {
    // output data of each row
	$res = [];
		while($row = $result->fetch_assoc()) {
			if ($row["roomid"]>0){
				$res[$row["roomid"]][] = $row["username"];
			}
		}
	} else {
		echo "0 results";
	}
	
	$query = "SELECT username, roomid FROM `users`";
	$result = $con->query($query);
	if ($result->num_rows > 0) {
    // output data of each row
	$res = [];
		while($row = $result->fetch_assoc()) {
			if ($row["roomid"]>0){
				
				$res[$row["roomid"]][] = $row["username"];
			}
		}
	} else {
		echo "0 results";
	}
	
	
	/*START*/

	$query = "SELECT r.id as roomId, u.id as userId, roomname, u.username FROM users as u LEFT JOIN rooms as r ON u.roomid = r.id";
		$result = $con->query($query);
		$newrooms = [];
		$newusers = [];
		$currentUser = "";
		
		while($row = $result->fetch_assoc()) {
			if (isset($row['roomId'])) $newrooms[$row['roomId']] = ['roomname' => $row['roomname'], 'roomId' => $row['roomId']];
			$newusers[$row['userId']] = ['username' => $row['username'], 'roomId' => $row['roomId']];

			if (strtolower($row['username']) == strtolower($user)) {
				
				$currentUser = $newusers[$row['userId']];
			}
		}
		

	foreach ($newrooms as $room) {
		
		echo "<div class='rooms'>";
		
		$userIsFound = false;
		$userNames = "";
		foreach($newusers as $nuser) {
			
			if ($nuser['roomId'] == $room['roomId']) {
				$userNames .= "<h3>".$nuser['username']."</h3>";
			}
			
			
			if (strtolower($nuser['username']) == strtolower($user) && $room['roomId'] == $nuser['roomId']) {
				$userIsFound = true;
			}
		}
		
		echo "<div class='roomgamers'>$userNames</div>";
		
		if ($userIsFound && isset($currentUser['roomId']) && $currentUser['roomId'] == $room['roomId']) {
			echo "<div class='roombuttons'><input name='submit' type='submit' value='Enter'/><br><input name='submit' type='submit' value='Leave'/></div>";
		} elseif ( $currentUser['roomId'] == NULL) {
			echo "<div class='roombuttons'><input name='submit' type='submit' value='Join'/></div>";
		} 
		
		echo "</div></div>";
	}	
		
	/*END*/
	
//var_dump($res);
//var_dump($res[13]);
//echo sizeof($res[2]);
//echo $res[13][0];
//var_dump(count($res));
//var_dump(array_key_exists(2, $res[13]));
//echo max(array_keys($res));
/*
$thisuserflag =false;
echo "<br>";
echo "<h3>Rooms</h3>";
for ($i=0; $i<=max(array_keys($res)); $i++){
	if (array_key_exists($i, $res)){
		$query = "SELECT r.id as roomId, u.id as userId, roomname, u.username FROM rooms as r INNER JOIN users as u ON u.roomid = r.id";
		$result = $con->query($query);
		while($row = $result->fetch_assoc()) {
			if ($row["id"]==$i){
				$imjakomnaty = $row["roomname"];
				//echo $imjakomnaty;
				//echo "<br>";
				
			}
		}		
		for ($j=0; $j<4; $j++){
			if (array_key_exists($j, $res[$i])){
				$name[$j] = $res[$i][$j];
			}else{$name[$j] = "";}				
		}
		//echo "<br>";
		echo $imjakomnaty;
		echo " current user = $user and current roomnumber = $roomnum   ".$name[0]. " or " .$name[1]." or " .$name[2]. " or " .$name[3]. " ";
		
		if ( array_search($user, $name)){
			
			echo "<div class='rooms'><div class='roomgamers'><h3>".$name[0]."<br>".$name[1]."<br>".$name[2]."<br>".$name[3]."</h3></div><div class='roombuttons'><input name='submit' type='submit' value='Enter'/><br><input name='submit' type='submit' value='Leave'/></div></div><br>";
		}elseif((($name[0] or $name[1] or $name[2] or $name[3]) != $user) and $roomnum == 0){
			echo "<div class='rooms'><div class='roomgamers'><h3>".$name[0]."<br>".$name[1]."<br>".$name[2]."<br>".$name[3]."</h3></div><div class='roombuttons'><input name='submit' type='submit' value='Join'/></div></div><br>";
		}else{
			echo "<div class='rooms'><div class='roomgamers'><h3>".$name[0]."<br>".$name[1]."<br>".$name[2]."<br>".$name[3]."</h3></div><div class='roombuttons'></div></div><br>";
		}
	}
} */
 ?>
</body>
</html>