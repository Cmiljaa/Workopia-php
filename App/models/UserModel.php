<?php

namespace App\Models;

use Framework\Database;

class UserModel{
    protected $db;

    public function __construct()
    {
        $config = require basePath('config/db.php');

        $this -> db = new Database($config);
    }

    public function getUserByEmail($email){

        $params = [
            'email' => $email
        ];

        return $this -> db -> query("SELECT * FROM users WHERE email = :email", $params);
    }

    public function create($params){
        $this -> db -> query("INSERT INTO users(name, email, city, state, password) VALUES(:name, :email, :city, :state, :password)", $params);
        return $this -> db -> conn -> lastInsertId();
    }
}