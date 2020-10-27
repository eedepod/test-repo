<?php
$txt1 = "Learn PHP";
$txt2 = "W3Schools.com";
$x = 5;
$y = 4;

echo "<h2>" . $txt1 . "</h2>";
echo "Study PHP at " . $txt2 . "<br>";
echo $x + $y;

print "<h2>" . $txt1 . "</h2>";
print "Study PHP at " . $txt2 . "<br>";
print $x + $y;

$x = 5985;
var_dump($x);

$x = 10.365;
var_dump($x);

$x = true;
var_dump($x);

$cars = array("Volvo","BMW","Toyota");
var_dump($cars);

class Car {
    function Car() {
        $this->model = "VW";
    }
}

// create an object
$herbie = new Car();

// show object properties
echo $herbie->model;
echo "<br>";


echo strlen("Hello world!"); // outputs 12
echo "<br>";

echo str_word_count("Hello world!"); // outputs 2

echo "<br>";
echo strrev("Hello world!"); // outputs !dlrow olleH

echo strpos("Hello world!", "world"); // outputs 6

echo str_replace("world", "Dolly", "Hello world!"); // outputs Hello Dolly!

$x = 5985;
var_dump(is_int($x));

$x = 59.85;
var_dump(is_int($x));

$x = "59.85" + 100;
var_dump(is_numeric($x));
var_dump($x);

// Cast float to int
$x = 23465.768;
$int_cast = (int)$x;
echo $int_cast;

echo "<br>";

// Cast string to int
$x = "23465.768";
$int_cast = (int)$x;
echo $int_cast;

echo "<br>";
define("GREETING", "Welcome to W3Schools.com!", true);
echo greeting;

define("car", [
    "Alfa Romeo",
    "BMW",
    "Toyota"]);
echo car[1];

?>