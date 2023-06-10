<?php
	session_start();
	
	if(!(isset($_POST['login']) and isset($_POST['password'])) or isset($_SESSION['user_id']))
	{
		exit("Access denied");
	}
	
	$login = htmlentities($_POST['login'],ENT_QUOTES,"UTF-8");
	$password = $_POST['password'];

    class ajax_response {
        public $err_no = 10;
        public $err_message = "Server Error";
    }
	
    $response = new ajax_response();
	try
	{
		
		require_once "db_connect.php";

		$db_connection = new mysqli($host, $db_user, $db_password, $db_name);

		if($db_connection->errno!=0)
			throw new Exception("Server internal error", 10);
		
		if(!$sql_result = $db_connection->query("SELECT * FROM user_data WHERE user_login='$login'"))
            throw new Exception("Server internal error", 11);
			
		$db_connection->close();
			
        $user_count = $sql_result->num_rows;
        
        if($user_count == 0)
            throw new Exception("Invalid login credentials", 21);

        if($user_count != 1)
                throw new Exception("Server internal error", 12);
            
        $login_data = $sql_result->fetch_assoc();
        $sql_result->close();
        
        if(!password_verify($password, $login_data['user_password']))
            throw new Exception("Invalid login credentials", 22);

        $_SESSION['user_login'] = $login_data['user_login'];
        $_SESSION['user_id'] = $login_data['user_id'];
        $_SESSION['user_password'] = $password;

        $response->err_no = 0;
        $response->err_message = "Success";
	}
	catch(Exception $err)
	{
        $response->err_no = $err->getCode();
        $response->err_message = $err->getMessage();
	}

    $response_JSON = json_encode($response);

    echo $response_JSON;
?>