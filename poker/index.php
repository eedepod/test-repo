<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" http-equiv="refresh" content="10000000">
<!--;url=index.php">-->
<title>Welcome Home</title>
<link rel="stylesheet" href="css/style.css" />
</head>
<body>
<script type="text/javascript">


</script>



<?php

//include auth.php file on all secure pages
include("auth.php");
require_once('db.php');
//global $REMOTE_ADDR;
$user=$_SESSION['username'];
$db = new Database();
$link = $db->getLink();
$time_for_user_remove_from_online = 1800;

//html for creating room
$strcreateroom="<div class='create_room'><form action='/poker/index.php' method='get'>
<input type='text' name='roomname' placeholder='Roomname' required>
<button type='submit' value='create' name='action'>Create room</button>
</form></div>";

$strsay ="<div class='add_message'>
<link type='text/css' rel='stylesheet' href='styles.css' /><form action='/poker/index.php' method='get'>
<input type='text' name='s_message' /><button type='submit' value='say' name='action'>Say</button> </form></div>
";

//html for logout
$strlogout = "
<div class='login_form'>
Welcome ". $_SESSION['username'] . "!<br>
<a href='logout.php'>Logout</a>
</div>
";

/*
if (isset($_POST['roomnameN'])) {
    $_GET['action']='create';
}



$cards = range(1, 52);
$scards="";
    //sozdat kolodu
    srand((float)microtime() * 1000000);
    shuffle($cards);
    while (list(, $card) = each($cards)) {
        $scards ="$card-$scards";
    }

    //zapisat kolodu
    $query = "INSERT into `carddecks` (carddeck) VALUES ('$scards')";
    if (mysqli_query($con, $query)) {
        $carddeckid = mysqli_insert_id($con);
        //echo "kaloda zapisalas $scards s id: $carddeckid";
        //echo "<br>";
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($con);
    }


function clean($value = "")
{
    $value = trim($value);
    $value = stripslashes($value);
    $value = strip_tags($value);
    $value = htmlspecialchars($value);
    return $value;
}

    */



//user - room array fill
$query = "SELECT * FROM rooms";
$r1 = $con->query($query);

if ($r1->num_rows == 0) {
    $user_room_arr = null;
}

while ($row = $r1->fetch_assoc()) {
    $user_room_arr[$row['roomname']][] = $row['username'];
}

/*
if (isset($_GET['wtf'])) {
    echo $_GET['wtf'];
}
*/
if (isset($_GET['action'])) {
    $query = "UPDATE onlinedb SET onlinetime='" .strtotime('now'). "' WHERE u_name='$user'";
    $result = $con->query($query);
    switch ($_GET['action']) {
        case 'join':
            $query = "INSERT INTO rooms (username, roomname) VALUES ('$user', '" .$_GET['roomname']."')";
            $result = $con->query($query);
            if ($result) {
                header("Location:/poker");
            } else {
                echo "fuck you!";
            }
            break;
        case 'leave':
            $query = "DELETE FROM rooms WHERE username='$user'";
            $result = $con->query($query);
            if ($result) {
                header("Location:/poker");
            } else {
                echo "fuck you!";
            }
            break;
        case 'say':
            $query = "INSERT INTO `s_chat_messages` SET `user`='{$user}', `message`='" .$_GET['s_message']."', `when`=UNIX_TIMESTAMP()";
            $result = $con->query($query);
            var_dump($result);
            if ($result) {
                header("Location:/poker");
            } else {
                echo "fuck you!";
            }
            break;
        case 'create':
            if (!array_key_exists($_GET['roomname'], $user_room_arr)) {
                $query = "INSERT INTO rooms (username, roomname) VALUES ('$user', '" .$_GET['roomname']."')";
                $result = $con->query($query);
                if ($result) {
                    header("Location:/poker");
                } else {
                    echo "komnata ne sozdana";
                }
            } else {
                echo "Room already exist";
            }
            break;
        case 'enter':
            header("Location:/poker/inRoom.php");
            break;
        default: break;
    }
}


$roomnum=0;
$thisusernoroom = false;
$thisuserflag = false;
echo $strlogout;
$roomname="";
//proverka na prisutstvie v komnate
$roomsarr = [];
$query = "SELECT username FROM `rooms` WHERE username='$user'";
$result = $con->query($query);
    while ($row = $result->fetch_assoc()) {
        $roomsarr[] = $row['username'];
    }
    
if (in_array($user, $roomsarr) == false) {
    echo $strcreateroom;
}








//Sozdat komnaty i knopki
$query = "SELECT username FROM `users`";
$result = $con->query($query);

while ($row = $result->fetch_assoc()) {
    $users_arr[] = $row['username'];
}

$userIsFound = false;
echo "<div class='rooms'>";
echo "<h2>Rooms:</h2>";

if ($user_room_arr != null) {
    foreach ($user_room_arr as $roomName => $roommembers) {
        echo "<h4>$roomName</h4>";
        echo "<div class='room'>";
        echo "<div class='roomgamers'>";
        foreach ($roommembers as $username) {
            echo "<h4>$username</h4>";
            if ($user==$username) {
                $userIsFound = true;
            } //else{$userIsFound = false;}
        }
        echo "</div>";
        if (in_array($user, $roomsarr) == true) {
            if ($userIsFound) {
                echo "<div class='roombuttons'><a href='/poker/index.php?action=enter&roomname=$roomName'><button>Enter</button></a><br><a href='/poker/index.php?action=leave&roomname=$roomName'><button>Leave</button></a></div>";
                $userIsFound = false;
            } else {
                echo "<div class='roombuttons'></div>";
            }
        } else {
            echo "<div class='roombuttons'><a href='/poker/index.php?action=join&roomname=$roomName'><button>Join</button></a></div>";
        }
        echo "</div>";
    }
    echo "</div>";
} else {
    echo "<div class='room'>";
    echo "<div class='roomgamers'></div>";
    echo "<div class='roombuttons'></div>";
//    echo "</div>";
    echo "</div>";
    echo "</div>";
}

////////////////////////////////////////////////////////// Online Section /////////////////////////////////////////////////
echo "<div class='who_online'><h2>Users online:</h2>";

// Shows who is online
$query = "SELECT u_name, onlinetime FROM onlinedb WHERE isonline=1 ";
$result = $con->query($query);
while ($row = $result->fetch_assoc()) {
    $online_users[]= ['username' => $row['u_name'], 'lastSeenTime' => $row['onlinetime']];
}

// if some user not active then this user removed from online
for ($i = 0; $i<sizeof($online_users); $i++) {
    if (strtotime('now') - $online_users[$i]['lastSeenTime'] > $time_for_user_remove_from_online) {
        if ($online_users[$i]['username'] == $user) { //if current user then logout
            header("Location: logout.php");
        } else {
            $query = "UPDATE onlinedb SET isonline=0 WHERE u_name='" .$online_users[$i]['username']. "'"; //if other user then set online flag to zero
            $result = $con->query($query);
        }
    } else { //if all ok, then print user name
        echo $online_users[$i]['username'];
        echo " - ",  strtotime('now') - $online_users[$i]['lastSeenTime'], " second";
        echo "<br>";
    }
}


/////////////////////////////////////////////// End Online Section //////////////////////////////////////////////////////

/////////////////////////////////////////////// Functions ///////////////////////////////////////////////////////////
//getting from DB messages
    function getMessages()
    {
        $vLink = mysqli_connect("localhost", "root", "root", "poker");

        //select the database
        mysqli_select_db($vLink, "poker");

        //returning the last 15 messages // ASC LIMIT 15"
        $vRes = mysqli_query($vLink, "SELECT * FROM `s_chat_messages` ORDER BY `id`");
        var_dump($vRes);
        $sMessages = '';

        // collecting list of messages
        if ($vRes) {
            while ($aMessages = mysqli_fetch_array($vRes)) {
                $sWhen = date("H:i:s", $aMessages['when']);
                $sMessages .= '<div class="message">' . $aMessages['user'] . ': ' . $aMessages['message'] . '<span>(' . $sWhen . ')</span></div>';
            }
        } else {
            $sMessages = 'DB error, create SQL table before';
        }

        mysqli_close($vLink);

        ob_start(); ?>
            
            <link type="text/css" rel="stylesheet" href="styles.css" />
            <div class="chat_main">
            <h3>Chat</h3>
        <?php echo $sMessages; ?>
        </div>
        <?php

        return ob_get_clean();
    }
    echo "</div>";
//////////////////////////////////////////////// chat ////////////////////////////////////////////////////////////////
/*
<div><?php include 'messages.php';?></div>
*/
//echo "<div class='vasja'>";
//$oSimpleChat = new SimpleChat();
//echo $oSimpleChat->getMessages();
//require_once("chat.php");
echo "<div class='whole_chat'>";
echo getMessages();
//echo "</div>";
/////////////////////////////////////////////////////

/*<div><?php include 'main.php';?></div>*/
/*
if (version_compare(phpversion(), "5.3.0", ">=") == 1) {
    error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
} else {
    error_reporting(E_ALL & ~E_NOTICE);
}
*/

echo $strsay;
echo "</div>";
//require_once("chat.php");
//echo acceptMessages();


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/*

<frameset rows="65%,35%" framespacing="1" frameborder="yes" border="1" bordercolor="#FF0000">
    <frame src="messages.php" name="main_frame">
    <frame src="main.php" name="login_frame" scrolling="no" noresize target="middle">
</frameset>


$onlinetime = strtotime('+1 min');
$query = "UPDATE onlinedb SET isonline='1',onlinetime='$onlinetime' WHERE id='$_SESSION[ID]'";
$result = $con->query($query);

echo " IP = $ip";
echo "<br>";
echo $_SESSION['ID'];
echo "<br>";
echo $_SESSION['ONLINE'];
echo "<br>";
echo strtotime('now');
echo "<br>";
echo strtotime('+1 min');
echo "</div>";

*/
   /*
//proverka polzovatelej online
if ($_SESSION['ID'] != "") {
    if ($_SESSION['ONLINE'] >= strtotime('now')) {
        $onlinetime = strtotime('+1 min');
        $query = "UPDATE onlineDB SET 'online'='1',onlinetime='$onlinetime', ip='$ip' WHERE id='$_SESSION[ID]'";
        $result = $con->query($query);
    }
    $query = "SELECT id FROM onlineDB WHERE onlinetime<'" . strtotime('now') . "'";
    $result = $con->query($query);
    var_dump($result);
}

    $row = fetch_assoc($result);
    do {
        $con->query("UPDATE `onlineDB` SET `online`='0' WHERE `id`='$row[id]'");
    } while ($row = fetch_assoc($result));
*/
////////////////////////////////////////////////


    


    /*START*/
/*
    $query = "SELECT r.id as roomId, u.id as userId, roomname, u.username FROM users as u LEFT JOIN rooms as r ON u.roomid = r.id";
        $result = $con->query($query);
        $newrooms = [];
        $newusers = [];
        $currentUser = "";

        while($row = $result->fetch_assoc()) {
            if (isset($row['roomId'])) $newrooms[$row['roomId']] = ['roomname' => $row['roomname'], 'roomId' => $row['roomId']];
            $newusers[$row['userId']] = ['username' => $row['username'], 'roomId' => $row['roomId']];

            if (strtolower($row['username']) == strtolower($user)) {

                $currentUser = $newusers[$row['userId']];
            }
        }


    foreach ($newrooms as $room) {

        echo "<div class='rooms'>";

        $userIsFound = false;
        $userNames = "";
        foreach($newusers as $nuser) {

            if ($nuser['roomId'] == $room['roomId']) {
                $userNames .= "<h3>".$nuser['username']."</h3>";
            }


            if (strtolower($nuser['username']) == strtolower($user) && $room['roomId'] == $nuser['roomId']) {
                $userIsFound = true;
            }
        }

        echo "<div class='roomgamers'>$userNames</div>";

        if ($userIsFound && isset($currentUser['roomId']) && $currentUser['roomId'] == $room['roomId']) {
            echo "<div class='roombuttons'><input name='submit' type='submit' value='Enter'/><br><input name='submit' type='submit' value='Leave'/></div>";
        } elseif ( $currentUser['roomId'] == NULL) {
            echo "<div class='roombuttons'><input name='submit' type='submit' value='Join'/></div>";
        }

        echo "</div></div>";
    }
*/
    /*END*/
    
    ?>
</body>
</html>