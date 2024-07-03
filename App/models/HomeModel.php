<?php

namespace App\Models;

use Framework\Database;

class HomeModel{
    protected $db;
    
    public function __construct()
    {
        $config = require basePath('config/db.php');

        $this -> db = new Database($config);
    }

    public function index(){
        return $this -> db -> query("SELECT * FROM listings ORDER BY created_at DESC");
    }
}