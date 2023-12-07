<?php
    
	class LoginResponse {

        protected int|bool $err_no = 0;
        protected string $err_message = "Access denied";

        public function setErrorNumber(int|bool $code): void {
            $this->err_no = $code;
        }

        public function setErrorMessage(string $message): void {
            $this->err_message = $message;
        }

        public function getData(){
            return ["err_no" => $this->err_no, "err_message" => $this->err_message];
        }
    }

	session_start();
	$response = new LoginResponse();

	if(!(isset($_POST['login']) and isset($_POST['password'])) or isset($_SESSION['user_id']))
	{
		echo json_encode($response->getData());
        exit;
	}

	$login = $_POST['login'];
	$password = $_POST['password'];


	try
	{
		
		require_once "db_connect.php";

		$db_connection = db_connect();

		if($db_connection === false)
			throw new Exception("Server connection error", 10);
		
		if(!($db_query = $db_connection->prepare('SELECT * FROM user_data WHERE user_login = :login OR user_email = :login')))
            throw new Exception("Server connection error", 11);
			
        $query_params = array("login" => $login);
        
        if(!($db_query->execute($query_params)))
            throw new Exception("Server connection error", 12);

        if($db_query->rowCount() > 1)
            throw new Exception("Server connection error", 13);

        if($db_query->rowCount() === 0)
            throw new Exception("Invalid login credentials", 21);

        $login_data = $db_query->fetch(PDO::FETCH_ASSOC);
        
        if(!password_verify($password, $login_data['user_password']))
            throw new Exception("Invalid login credentials", 22);

        $_SESSION['user_login'] = $login_data['user_login'];
        $_SESSION['user_id'] = $login_data['id'];
        $_SESSION['user_password'] = $password;

        $response->setErrorNumber(false);
        $response->setErrorMessage("");
	}
	catch(Exception $err)
	{
        $response->setErrorNumber($err->getCode());
        $response->setErrorMessage($err->getMessage());
	}

    echo json_encode($response->getData());

    ?>