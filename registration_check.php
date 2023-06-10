
<?php
	session_start();
	
	//Check if data was sent
	if(!(isset($_POST['login']) && isset($_POST['password']) && isset($_POST['password_repeat']) && isset($_POST['email']))){
		header('Location: register.php');
		exit();
	}
	
	
	$login = $_POST['login'];
	$password = $_POST['password'];
	$password_repeat = $_POST['password_repeat'];
	$email = $_POST['email'];
	$err_flag = false;
	
	
	//Login length check (4-19)
	if(strlen($login) < 4 or strlen($login) > 20){
		$_SESSION['err_login'] = "Login must be between 4 and 20 characters long";
		$err_flag = true;
	}
	
	//Login alphanumeric check
	if(ctype_alnum($login)==false)
	{
		if(isset($_SESSION['err_login'])){
			$_SESSION['err_login'] = $_SESSION['err_login']."<br>Login can contain only letters or numbers";
		}
		else
		{
			$_SESSION['err_login']."Login can contain only letters or numbers";
			$err_flag = true;
		}
	}
	
	//Sanitize and validate email
	$email_sanitized = filter_var($email, FILTER_SANITIZE_EMAIL);
	if(!filter_var($email_sanitized, FILTER_VALIDATE_EMAIL) or $email_sanitized != $email)
	{
		$_SESSION['err_email'] = "Invalid email";
		$err_flag = true;
	}
	
	//check password length (8-24)
	if(strlen($password < 8 or strlen($password) > 24))
	{
		$_SESSION['err_password'] = "Password must be between 8 and 24 characters long";
		$err_flag = true;
	}
	//check if passwords match
	if($password != $password_repeat)
	{
		$_SESSION['err_password_repeat'] = "Passwords does not match";
		$err_flag = true;
	}
	//check ToS accept
	if(!isset($_POST['tos']))
	{
		$_SESSION['err_tos'] = "Accept ToS";
		$err_flag = true;
	}
	//reCaptcha check
	$secret_key = "6LdKg7oiAAAAANspc3sgQhM8A40CRzFomygWQnFy";
	$recaptcha_response = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret_key.'&response='.$_POST['g-recaptcha-response']);
	$recaptcha_response = json_decode($recaptcha_response);
	if(!$recaptcha_response->success)
	{
		$_SESSION['err_recaptcha'] = "Bot validation failed";
		$err_flag = true;
	}
	 
	require_once "dbconnect.php";
	try
	{
		//connecting to database
		$db_connection = new mysqli($host, $db_user, $db_password, $db_name);
		if($db_connection->errno!=0)
		{
			throw new Exception(mysqli_connect_errno);
		}
		//check if used login exists
		if($db_result = $db_connection->query("SELECT login FROM login WHERE login = '$login'"))
		{
			if($db_result->num_rows > 0)
			{
				$_SESSION['err_login'] = "Login already exists";
				$err_flag = true;
			}
		}
		
		//check if used email exists
		if($db_result = $db_connection->query("SELECT email FROM login WHERE email='$email'"))
		{
			if($db_result->num_rows > 0)
			{
				$_SESSION['err_email'] = "Email already registered";
				$err_flag = true;
				$db_result->close();
			}
		}
		
		//check for errors
		if($err_flag)
		{
			$db_connection->close();
			$_SESSION['login_return'] = $login;
			$_SESSION['email_return'] = $email;
			Header('Location: register.php');
			exit();
		}
		else
		{
			$table_name = "passwords_".$login;
			$password = password_hash($password, PASSWORD_DEFAULT);
			$db_connection->query("INSERT INTO login VALUES(NULL, '$login', '$email', '$password')");
			$db_connection->query("CREATE TABLE $table_name (id INT AUTO_INCREMENT PRIMARY KEY, name VARCHAR(255))");
			$db_connection->close();
			Header('Location: registration_complete.php');
		}
		
	}
	catch(Exception $err_catch)
	{
		$_SESSION['err_server'] = /*"Server error, please try again later"*/$err_catch;
		Header('Location: register.php');
	}


	
	
?>