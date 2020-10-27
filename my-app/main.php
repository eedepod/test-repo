<html>
<head>
<title>Main</title>

<?php
$a =0;
$b =0;
$card_array_x = array();
$card_array_y = array();

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "myDB";


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}else{
echo "Connected successfully";
}

for ($i=1; $i<53; $i++){
	
	$sql = "INSERT INTO cards_pos (id,X,Y)
	VALUES ($i, $a, $b)";
	if ($conn->query($sql) === TRUE) {
		echo "New record created successfully id=$i x=$a y=$b <br>";
	} else {
		echo "Error: " . $sql . "<br>" . $conn->error;
	}
	if ($a - 196 < -2538){
		$a =0;
		$b=$b-286;
	}else{
		$a=$a-196;	
	}

}
$conn->close();
?>

</body>
</html>