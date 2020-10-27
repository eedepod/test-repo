<html>
<head>
<title>Poker</title>
<link rel="stylesheet" type="text/css" href="css/style.css">
<?php
include("auth.php");
require_once('db.php');
$db = new Database();
$link = $db->getLink();

$strlogout = "
<div class='login_form'>
<p>Welcome ". $_SESSION['username'] . "!</p>
<a href='logout.php'>Logout</a>
</div>
";

$strleave = "<div class='leave_form'><a href='index.php'><button>Leave Room</button></a></div>";


echo $strlogout;
echo $strleave;


$oponent_1_card_X = -392;
$oponent_1_card_Y = -1144;
$oponent_2_card_X = -392;
$oponent_2_card_Y = -1144;
$oponent_3_card_X = -392;
$oponent_3_card_Y = -1144;

$bank_1_card_X = -392;
$bank_1_card_Y = -1144;
$bank_2_card_X = -392;
$bank_2_card_Y = -1144;
$bank_3_card_X = -392;
$bank_3_card_Y = -1144;
$bank_4_card_X = -392;
$bank_4_card_Y = -1144;
$bank_5_card_X = -392;
$bank_5_card_Y = -1144;

$my_1_card_X = -392;
$my_1_card_Y = -1144;
$my_2_card_X = -392;
$my_2_card_Y = -1144;


?>

<style>

</style>
</head>

<body>

<div style="background-color:red; width:100%; heigh:100%">
<div class="oponent">
<p class="first_card"><img src="/Pic/new.png"   style="top:<?php echo $oponent_1_card_Y; ?>; left:<?php echo $oponent_1_card_X; ?>;" alt="" /></p>
<p class="next_card"><img src="/Pic/new.png"   style="top:<?php echo $oponent_1_card_X; ?>; left:<?php echo $oponent_2_card_X; ?>;" alt="" /></p>
</div>
<div class="oponent">
<p class="first_card"><img src="/Pic/new.png"   style="top:<?php echo $oponent_2_card_Y; ?>; left:<?php echo $oponent_1_card_X; ?>;" alt="" /></p>
<p class="next_card"><img src="/Pic/new.png"   style="top:<?php echo $oponent_2_card_X; ?>; left:<?php echo $oponent_2_card_X; ?>;" alt="" /></p>
</div>
<div class="oponent">
<p class="first_card"><img src="/Pic/new.png"   style="top:<?php echo $oponent_3_card_Y; ?>; left:<?php echo $oponent_1_card_X; ?>;" alt="" /></p>
<p class="next_card"><img src="/Pic/new.png"   style="top:<?php echo $oponent_3_card_X; ?>; left:<?php echo $oponent_2_card_X; ?>;" alt="" /></p>
</div>
</div>
<div style="float: left; width:20%;">
</div>
<div class="clearfix" style="background-color:yellow; width:80%;">
<p class="first_card"><img src="/Pic/new.png"   style="top:<?php echo $bank_1_card_Y; ?>; left:<?php echo $bank_1_card_X; ?>;" alt="" /></p>
<p class="next_card"><img src="/Pic/new.png"   style="top:<?php echo $bank_2_card_Y; ?>; left:<?php echo $bank_2_card_X; ?>;" alt="" /></p>
<p class="next_card"><img src="/Pic/new.png"   style="top:<?php echo $bank_3_card_Y; ?>; left:<?php echo $bank_3_card_X; ?>;" alt="" /></p>
<p class="next_card"><img src="/Pic/new.png"   style="top:<?php echo $bank_4_card_Y; ?>; left:<?php echo $bank_4_card_X; ?>;" alt="" /></p>
<p class="next_card"><img src="/Pic/new.png"   style="top:<?php echo $bank_5_card_Y; ?>; left:<?php echo $bank_5_card_X; ?>;" alt="" /></p>
</div>
<div style="background-color:blue; width:100%; heigh:100%">
<p class="first_card"><img src="/Pic/new.png"   style="top:<?php echo $my_1_card_Y; ?>; left:<?php echo $my_1_card_X; ?>;" alt="" /></p>
<p class="next_card"><img src="/Pic/new.png"   style="top:<?php echo $my_2_card_Y; ?>; left:<?php echo $my_2_card_X; ?>;" alt="" /></p>
</div>




</body>
</html>

