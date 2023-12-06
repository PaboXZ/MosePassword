<?php

function db_connect(){

	$host="localhost";
	$db_user="root";
	$db_password="";
	$db_name="password_manager";

	$dsn = "mysql:host=$host;dbname=$db_name";

	try{
		return new PDO($dsn, $db_user, $db_password);
	}
	catch(Exception $e){
		return false;
	}
}
?> 