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
require_once '/workday.php';


$workdayTest = new Workday($strtime);
$workdayTest->printStartingShiftsForEmployee($id,$strtime);


?>

</body>
</html>