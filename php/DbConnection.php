<?php
	class DbConnection extends PDO{

		private $host="localhost";
		private $db_user="root";
		private $db_password="";
		private $db_name="password_manager";

		function __construct(){
			$dsn = "mysql:host=$this->host;dbname=$this->db_name";
			parent::__construct($dsn, $this->db_user, $this->db_password);
		}
	}
?> 