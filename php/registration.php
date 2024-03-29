<?php

    class RegistrationResponse{
        public string $login_error = "";
        public string $password_error = "";
        public string $email_error = "";
        public string $tos_error = "";
        public string $server_error = "";

        public bool $error_flag = false;
    }

    function sendResponse(){
        global $response;
        echo json_encode($response);
        exit;
    }

    $response = new RegistrationResponse();

	session_start();
    
	if(!(isset($_POST['login']) && isset($_POST['password']) && isset($_POST['password_repeat']) && isset($_POST['email']))){
		$response->server_error = "Access denied";
        $response->error_flag = true;
        sendResponse();
	}



	$login = $_POST['login'];
	$password = $_POST['password'];
	$password_repeat = $_POST['password_repeat'];
	$email = $_POST['email'];


	if(strlen($login) < 4 or strlen($login) > 20){
		$response->login_error .= "Login must be between 4 and 20 characters long. ";
        $response->error_flag = true;
    }
	
	if(ctype_alnum($login) == false){
		$response->login_error .= "Login can contain only letters or numbers. ";
        $response->error_flag = true;
    }
	

	$email_sanitized = filter_var($email, FILTER_SANITIZE_EMAIL);

	if(!filter_var($email_sanitized, FILTER_VALIDATE_EMAIL) or $email_sanitized != $email){
		$response->email_error .= "Invalid email";
        $response->error_flag = true;
    }
	

	if(strlen($password < 8 || strlen($password) > 24)){
		$response->password_error = "Password must be between 8 and 24 characters long";
        $response->error_flag = true;
    }

	if($password !== $password_repeat){
		$response->password_error = "Passwords does not match";
        $response->error_flag = true;
    }
    

	if(!isset($_POST['tos'])){
		$response->tos_error = "Accept ToS";
        $response->error_flag = true;
    }
	 
    if($response->error_flag === true)
        sendResponse();

	try
	{
        require_once "DbConnection.php";

		$db_connection = new DbConnection();

        $db_query = $db_connection->prepare('SELECT user_login FROM user_data WHERE user_login = :login');

        $db_query->execute(["login" => $login]);

		if($db_query->rowCount() > 0){
			$response->login_error .= "Login already exists";
            $response->error_flag = true;
		}

        $db_query = $db_connection->prepare('SELECT user_email FROM user_data WHERE user_email = :email');

        $db_query->execute(["email" => $email]);

        if($db_query->rowCount() > 0){
            $response->login_error .= "Login already exists";
            $response->error_flag = true;
        }
		if($response->error_flag)
		{
			sendResponse();
		}
		else
		{
			$password_hashed = password_hash($password, PASSWORD_DEFAULT);

			$db_query = $db_connection->prepare("INSERT INTO user_data (user_login, user_email, user_password) VALUES (:login, :email, :password)");

            $query_params = ["login" => $login, "email" => $email, "password" => $password_hashed];
            
            $db_query->execute($query_params);
		}
		
	}
    catch(PDOException $e){
        $response->server_error = "Server error";
        $response->error_flag = true;
		sendResponse();
    }
	catch(Exception $e)
	{
        $response->server_error = $e->getMessage();
        $response->error_flag = true;
		sendResponse();
	}

    echo json_encode(["error_flag" => "false"]);

?>