

<?php

define("cars", [
    "Alfa Romeo",
    "BMW",
    "Toyota"]);
echo cars[1];

echo "<br>";
define("GREETING", "Welcome to W3Schools.com!");

function myTest() {
    echo GREETING;
}
 
myTest();

$favcolor = "red";

switch ($favcolor) {
    case "red":
        echo "Your favorite color is red!";
        break;
    case "blue":
        echo "Your favorite color is blue!";
        break;
    case "green":
        echo "Your favorite color is green!";
        break;
    default:
        echo "Your favorite color is neither red, blue, nor green!";
}

$x = 1;

while($x <= 5) {
    echo "The number is: $x <br>";
    $x++;
}

$x = 1;

do {
    echo "The number is: $x <br>";
    $x++;
} while ($x <= 5);


function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}


?>


