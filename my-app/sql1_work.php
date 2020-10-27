<!DOCTYPE html>
<html>

<?php
$idErr = "";
$id = "";
$imja ="";
$count = 0;
$timezone="";
$dts="";
$dtf="";
$strtime="";
$strtimeErr = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["ID"])) {
    $idErr = "Id is required";
  } else {
    $id = test_input($_POST["ID"]);
    // check if id only contains numbers
    if (!preg_match("/^[0-9]*$/",$id)) {
      $idErr = "Only numbers allowed";
    }
  }
  $strtime = test_input($_POST["strtime"]);
  if (!preg_match("/^(([0-9]{4})-([0-9]{2})-[0-9]{2})$/",$strtime)){
	  if ($strtime >0){
		$strtimeErr = "<p style='color:Tomato;'>Data format invalid, data should be in format yyyy-mm-dd or field EMPTY for all shifts</p>";
		$okflag = false;
		$emptyflag = false;
	  }else{
		$okflag = true;
		$emptyflag = true;
		}
  } else {
	//echo "OK";
	$okflag = true;
	$emptyflag = false;
	}
	//echo $okflag;
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>
<body>
<h2>Insert employees ID</h2>
<p><span class="error">* required field</span></p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
  <h3>&emsp;&emsp;&emsp;&ensp;Id: <input type="text" name="ID" value="<?php echo $id;?>">
  <span class="error">* <?php echo $idErr;?></span></h3>

  <h3>Start time: <input type="text" name="strtime" value="<?php echo $strtime;?>"></h3>
  <span class="error"> <?php echo $strtimeErr;?></span>
<br>
  &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<input type="submit" name="submit" value="Submit">
</form>

<?php

//$strtime = new DateTime($strtime, new DateTimeZone('UTC'));

if ($okflag and !$emptyflag){
	  $strtime = new DateTime($strtime, new DateTimeZone('UTC'));
	  $strtime->setTimezone(new DateTimeZone('UTC'));
	  //echo "zashlo";
}

//echo $strtime->format('Y-m-d');

echo "<br>";
echo "<br>";

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "myDB";


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
/*echo "Connected successfully";
echo "<br>";
echo "<br>";
*/


$sql = "SELECT id, name, timezone FROM employees";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
		if ($id == $row["id"]){
			$imja = $row["name"];
			$timezone = $row["timezone"];
		}
    }
} else {
    echo "0 results";
}
if ($imja == ""){
	echo "<h2>User with Id $id not present! Try another ID </h2><br>";
} else {
	echo "<h2>Result for user Id $id with User name: $imja and timezone $timezone</h2><br>";
}

$sql2 = "SELECT * FROM shifts";
$result2 = $conn->query($sql2);

if ($result2->num_rows > 0) {
	echo "UTC time: <br>";
	while($row = $result2->fetch_assoc()) {
		if ($id == $row["user_id"]){
			$count++;
			$dts=$row["from"];
			$dtf=$row["to"];
			$dts = new DateTime($dts, new DateTimeZone('UTC'));
			$dtf = new DateTime($dtf, new DateTimeZone('UTC'));
			echo "From: ";
			echo $dts->format('Y-m-d H:i:s T');
			echo "	To: ";
			echo $dtf->format('Y-m-d H:i:s T');
			echo "<br>";
		}
	}
} else {
    echo "0 results";
}

$sql2 = "SELECT * FROM shifts";
$result2 = $conn->query($sql2);
echo "<br>";
if ($result2->num_rows > 0) {
	if ($timezone != ""){
		echo "$timezone time: <br>";
	}
	while($row = $result2->fetch_assoc()) {		
		if ($id == $row["user_id"]){
			$dts=$row["from"];
			$dtf=$row["to"];
			// create a $utc object with the UTC timezone
			$dts = new DateTime($dts, new DateTimeZone('UTC'));
			$dtf = new DateTime($dtf, new DateTimeZone('UTC'));
			//$strtime = new DateTime($strtime, new DateTimeZone('UTC'));
			// change the timezone of the object without changing it's time
			$dts->setTimezone(new DateTimeZone($timezone));
			$dtf->setTimezone(new DateTimeZone($timezone)); 
			// format the datetime
			//echo $strtime->format('Y-m-d');
			//echo $dts->format('Y-m-d');
			//echo $okflag;
			//echo $emptyflag;
			if ($okflag and !$emptyflag) {
				//echo "zashel";
				if ($dts->format('Y-m-d') == $strtime->format('Y-m-d')){			
					echo "From: ";
					echo $dts->format('Y-m-d H:i:s T');
					echo "	To: ";
					echo $dtf->format('Y-m-d H:i:s T');
					echo "<br>";
				}
			}elseif($okflag and $emptyflag){
					echo "From: ";
					echo $dts->format('Y-m-d H:i:s T');
					echo "	To: ";
					echo $dtf->format('Y-m-d H:i:s T');
					echo "<br>";
			}
			
			/*
			if ((preg_match("/^(([0-9]{4})-([0-9]{2})-[0-9]{2})$/",$strtime)) or $strtime == "") {
				echo "From: ";
				echo $dts->format('Y-m-d H:i:s T');
				echo "	To: ";
				echo $dtf->format('Y-m-d H:i:s T');
				echo "<br>";
			}else{
				echo "HUJNJU PISHESH";
			}
			*/
		}		
			
	}
	
}


if ($count == 0){
	echo "No results";
}

$conn->close();
?>

</body>
</body>
</html>
