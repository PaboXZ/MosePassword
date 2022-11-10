<?php
	session_start();
	
	//check if login credentials are set
	if(!(isset($_POST['login']) and isset($_POST['password'])))
	{
		header('Location: index.php');
		exit();
	}
	
	$login = htmlentities($_POST['login'],ENT_QUOTES,"UTF-8");
	$password = $_POST['password'];
	
	try
	{
		
		require_once "dbconnect.php";
		$db_connection = new mysqli($host, $db_user, $db_password, $db_name);
		if($db_connection->errno!=0)
		{
			throw new Exception($db_connection->mysqli_connect_errno);
		}
		$sql_login = "SELECT * FROM login WHERE login='$login'";
		
		if($sql_result = $db_connection->query($sql_login)){
			
			$db_connection->close();
			
			$user_count = $sql_result->num_rows;
			
			//check if login exists in database
			if($user_count == 1){
				
				$login_data = $sql_result->fetch_assoc();
				$sql_result->close();
				
				//check if password hashes match
				if(password_verify($password, $login_data['password']))
				{
					$_SESSION['user_login'] = $login_data['login'];
					$_SESSION['user_id'] = $login_data['user_id'];
					$_SESSION['user_password'] = $password;
					header('Location: manager.php');
				}
				else
				{
					$_SESSION['error_dsc'] = "Invalid login credentials";
					header('Location: index.php');
				}
			}
			else
			{
				$_SESSION['error_dsc'] = "Invalid login credentials";
				header('Location: index.php');
			}
		}
	}
	catch(Exception $err_server)
	{
		$_SESSION['err_server'] = "Server error, please try again later";
		Header('Location: index.php');
	}
		
?>