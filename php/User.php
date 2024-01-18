<?php

declare(strict_types=1);

class User{

    public function __construct (protected string $userID, protected string $userPassword, protected string $userName, protected string $userEmail){
        return;
    }

    static function getSessionUser(): bool|User {

        if(!isset($_SESSION['user_id']))
            return false;

        return new self($_SESSION['user_id'], $_SESSION['user_password'], $_SESSION['user_login'], $_SESSION['user_email']);
    }

    public function getName(): string {
        return $this->userName;
    }
    public function getPassword(): string {
        return $this->userPassword;
    }
    public function getID(): string {
        return $this->userID;
    }
    public function getEmail(): string {
        return $this->userEmail;
    }
}