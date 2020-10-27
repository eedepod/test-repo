<?php

class Util {
	
	public static $connection = NULL;
	
	public static function init(){
		$servername = "localhost";
		$username = "root";
		$password = "root";
		$db = 'mydb';
		
		// Create connection
		self::$connection = new mysqli($servername, $username, $password, $db);
		
		// Check connection
		if (self::$connection->connect_error) {
			die("Connection failed: \n" . self::$connection->connect_error);
		}
		
		//echo "Connected successfully \n";
	}
	
	
	public static function getMysqlConn(){
		if(is_null(self::$connection)){
			self::init();
		}
		
		return self::$connection;
	}
	
	
	
	
	
}