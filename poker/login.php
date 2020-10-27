<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Login</title>
<link rel="stylesheet" href="css/style.css" />
</head>
<body>
<?php
require('db.php');
session_start();

//ip clienta
$client  = @$_SERVER['HTTP_CLIENT_IP'];
$forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
$remote  = @$_SERVER['REMOTE_ADDR'];
 
if (filter_var($client, FILTER_VALIDATE_IP)) {
    $ip = $client;
} elseif (filter_var($forward, FILTER_VALIDATE_IP)) {
    $ip = $forward;
} else {
    $ip = $remote;
}
//////////////////////////////////////////////

// If form submitted, insert values into the database.
if (isset($_POST['username'])) {
    // removes backslashes
    $username = stripslashes($_REQUEST['username']);
    //escapes special characters in a string
    $username = mysqli_real_escape_string($con, $username);
    $password = stripslashes($_REQUEST['password']);
    $password = mysqli_real_escape_string($con, $password);
    //Checking is user existing in the database or not
    $query = "SELECT * FROM `users` WHERE username='$username'
and password='".md5($password)."'";
    $result = mysqli_query($con, $query) or die(mysql_error());
    $rows = mysqli_num_rows($result);

    $ip_from_db ="";
    if ($rows==1) {
        $_SESSION['username'] = $username;
        while ($row = $result->fetch_assoc()) {
            $_SESSION['ID'] = $row['id'];
        }
        
        $a=$_SESSION['ID'];
        //echo $a;
        $query = "SELECT ip FROM `onlinedb` WHERE id='$a'";
        $r=$con->query($query);

        while ($row = $r->fetch_assoc()) {
            $ip_from_db = $row['ip'];
        }
        $onlinetime = strtotime('now');

        if ($ip_from_db =="") {
            $query = "INSERT INTO onlinedb (id, ip, onlinetime, isonline, u_name) VALUES ('".$_SESSION['ID']."', '$ip', '$onlinetime', '1', '$username')";
            $r=$con->query($query);
        } else {
            $query = "UPDATE onlinedb SET isonline='1',onlinetime='$onlinetime', ip='$ip' WHERE id='$_SESSION[ID]'";
            $r=$con->query($query);
        }

        //$_SESSION['ONLINE'] = strtotime('+30 sec');
        // Redirect user to index.php
        header("Location: index.php");
    } else {
        echo "<div class='form'>
<h3>Username/password is incorrect.</h3>
<br/>Click here to <a href='login.php'>Login</a></div>";
    }
} else {
    ?>
<div class="form">
<h1>Log In</h1>
<form action="" method="post" name="login">
<input type="text" name="username" placeholder="Username" required />
<input type="password" name="password" placeholder="Password" required />
<input name="submit" type="submit" value="Login" />
</form>
<p>Not registered yet? <a href='registration.php'>Register Here</a></p>
</div>
<?php
} ?>
</body>
</html>

