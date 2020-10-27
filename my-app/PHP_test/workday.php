<?php
require_once('/util.php');


class Workday {
	
	public $date = NULL;
	
	function __construct($date){
		$this->date = $date;
		//echo $date."\n";
	}
	
	
	function printStartingShiftsForEmployee($id, $strtime){		
		$imja ="";
		$timezone="";
		$count = 0;
		// check if id only contains numbers
		if (!preg_match("/^[0-9]*$/",$id)) {
			$idErr = "Only numbers allowed";
		}

		
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
		
		if ($okflag and !$emptyflag){
		  $strtime = new DateTime($strtime, new DateTimeZone('UTC'));
		  $strtime->setTimezone(new DateTimeZone('UTC'));
		}
		
		$b = new Util();
		$conn = $b->getMysqlConn();
		
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
			if ($count == 0){
				echo "No results";
				echo "<br>";
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
					// change the timezone of the object without changing it's time
					$dts->setTimezone(new DateTimeZone($timezone));
					$dtf->setTimezone(new DateTimeZone($timezone)); 
					if ($okflag and !$emptyflag) {
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
				}		
					
			}
			
		}
		if ($count == 0){
		echo "No results";
		}
	}

}