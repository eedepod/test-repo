<?php
require('db.php');
session_start();
//remove user from online
$query = "UPDATE onlinedb SET isonline='0' WHERE id='$_SESSION[ID]'";
$r=$con->query($query);


// Destroying All Sessions
if (session_destroy()) {
    // Redirecting To Home Page
    header("Location: login.php");
}
