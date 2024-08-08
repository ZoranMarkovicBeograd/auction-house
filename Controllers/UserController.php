<?php
require_once '../config/Database.php';
require_once '../Models/User.php';

class UserController {
    private $db;
    private $user;

    public function __construct() {
        $this->db = new Database();
        $this->user = new User($this->db);
    }

    public function register(string $username, string $password): bool {
        $this->user->username = $username;
        $this->user->password = $password;
        return $this->user->register();
    }

    public function login(string $username, string $password): bool {
        $this->user->username = $username;
        $this->user->password = $password;
        return $this->user->login();
    }
}
?>
