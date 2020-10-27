<?php
$numbers = range(1, 52);
$snumbers ="";
srand((float)microtime() * 1000000);
shuffle($numbers);
while (list(, $number) = each($numbers)) {
   // echo "$number ";
	//echo "<br>";
	$snumbers = "$number-$snumbers";
	//echo $snumbers;
	//echo "<br>";
}
echo $snumbers;
?>