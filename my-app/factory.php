<html>
<head>
<title>Main</title>
<link rel="stylesheet" type="text/css" href="mystyle.css">
<?php
$a =0;
$b =0;
$card_array_x = array();
$card_array_y = array();

for ($i=1; $i<14; $i++){
	$card_array_x[$i] =$a;
	$a=$a-196;
	echo $card_array_x[$i];
}
$a=0;
//echo "<br>";
for ($i=1; $i<6; $i++){
	$card_array_y[$i] =$a;
	$a=$a-286;
	echo $card_array_y[$i];
}
//echo "<br>";
$x = $card_array_x[2];
$y = $card_array_y[2];

?>

</head>

<body>

</body>
</html>