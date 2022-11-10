<?php

session_start();
//check if user is logged in
if(!isset($_SESSION['user_login']))
{
	Header("Location: index.html");
	exit();
}
//delete operation handle
if(isset($_GET['delete_password']))
{
	$password_name = $_GET['delete_password'];
	try
	{
		require_once "dbconnect.php";
		$db_connection = new mysqli($host, $db_user, $db_password, $db_name);
		
		$table_name = "passwords_".$_SESSION['user_login'];
		$db_connection->query("DELETE FROM $table_name WHERE name = '$password_name'");
	}
	catch(Exception $error_delete)
	{
	}
	Header("Location: manager.php");
}
?>