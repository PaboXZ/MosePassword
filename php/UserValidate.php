<?php

declare(strict_types=1);

require 'User.php';
/*
Name validation: length - 4-20, alnum, is taken --OK
Email validation: email pattern, is taken  --OK
Password validation: length - 8-24
Password match validation
Tos check
*/
class UserValidate extends User {

    public function __construct (string $userID, string $userPassword, string $userName, string $userEmail, protected string $repeatedPassword, protected string|null $TOSCheck){
        parent::__construct($userID, $userPassword, $userName, $userEmail);
        return;
    }

    public function validateNameLength(): bool {
        if(strlen($this->userName) < 4 && strlen($this->userName) > 20)
            return false;
        return true;
    }
    
    public function validateNameAlNum(): bool {
        return ctype_alnum($this->userName);
    }

    public function validateNameIsTaken(DbConnection $db): bool {
        $db_query = $db->prepare('SELECT user_login FROM user_data WHERE user_login = :login');

        $db_query->execute(["login" => $this->userName]);

        if($db_query->rowCount() > 0)
			return false;

        return true;
    }

    public function validateEmailPattern(): bool {

        $email_sanitized = filter_var($this->userEmail, FILTER_SANITIZE_EMAIL);

	    if(!filter_var($email_sanitized, FILTER_VALIDATE_EMAIL) || $email_sanitized != $this->userEmail)
            return false;

        return true;
    }

    public function validateEmailIsTaken(DbConnection $db): bool {

        $db_query = $db->prepare('SELECT user_email FROM user_data WHERE user_email = :email');

        $db_query->execute(["email" => $this->userEmail]);

        if($db_query->rowCount() > 0)
            return false;

        return true;
    }

    public function validatePasswordLength(): bool {
        if(strlen($this->userPassword) < 8 && strlen($this->userPassword) > 24)
            return false;
        return true;
    }

    public function validatePasswordMatch(): bool {
        if($this->userPassword === $this->repeatedPassword) 
            return true;
        return false;
    }

    public function validateTOSCheck(): bool {
        if($this->TOSCheck === null)
            return false;
        return true;
    }

    public function validateAll(DbConnection $db, bool $returnBool = false): bool|array {
        $testVals = [
            $this->validateNameLength(),
            $this->validateNameAlNum(),
            $this->validateNameIsTaken($db),
            $this->validateEmailPattern(),
            $this->validateEmailIsTaken($db),
            $this->validatePasswordLength(),
            $this->validatePasswordMatch(),
            $this->validateTOSCheck(),
        ];

        if($returnBool){

            $result = true;

            foreach($testVals as $value){
                if(!($result && $value)){
                    $result = false;
                    break;
                }
                return $result;
            }
        }
        
        return $testVals;
    }
}