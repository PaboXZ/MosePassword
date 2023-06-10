<?php
	session_start();
	if(!(isset($_POST['pass_name']) || !(isset($_SESSION['user_login']))))
	{
		Header('Location: manager.php');
		exit();
	}
	$new_name = $_POST['pass_name'];
	if(!ctype_alnum($new_name))
	{
		$_SESSION['err_manager_insert'] = "Invalid name, you may use only letters and numbers!";
		Header("Location: manager.php");
		exit();
	}
	try
	{
		require_once "dbconnect.php";
		$db_connection = new mysqli($host, $db_user, $db_password, $db_name);
		
		$table_name = "passwords_".$_SESSION['user_login'];
		if($db_result = $db_connection->query("SELECT name FROM $table_name WHERE name = '$new_name'"))
		{
			if($db_result->num_rows > 0)
			{
				$_SESSION['err_manager_insert'] = "Password name already exists";
				Header("Location: manager.php");
				$db_result->close();
				$db_connection->close();
				exit();
			}
			else
			{
				if(!$db_connection->query("INSERT INTO $table_name VALUES(NULL, '$new_name')"))
				{
					$_SESSION['err_manager_insert'] = "Server error";
				}
			}
		}
		$db_result->close();
		$db_connection->close();
		Header("Location: manager.php");
	}
	catch(Exception $err_connection)
	{
		echo $err_connection;
	}
	

?>