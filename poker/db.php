<?php
// Enter your Host, username, password, database below.
// I left password empty because i do not set password on localhost.
$con = mysqli_connect("localhost", "root", "root", "poker");
// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}


class Database
{
    private $link = null;
    public function __construct()
    {
        $host = 'localhost';
        $user = 'root';
        $pass = 'root';
        $dbname = 'poker';

        try {
            $this->link = new mysqli($host, $user, $pass, $dbname);
            //echo "It's working just fine";
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    public function getLink()
    {
        return $this->link;
    }
}
