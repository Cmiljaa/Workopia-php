<?php

namespace App\Controllers;

use Framework\Database;

class ListingController{
    protected $db;

    public function __construct()
    {
        $config = require basePath('config/db.php');
        $this -> db = new Database($config);
    }

    /**
    * Show all listings
    * 
    * @return void
    */

    public function index(){
        $listings = $this -> db -> query("SELECT * FROM listings");

        loadView('listings/index', ['listings' => $listings]);
    }

    /**
    * Show a single listing
    * 
    * @param array $params
    * @return void
    */

    public function show(){
        $id = $_GET['id'] ?? '';

        $params = [
            'id' => $id
        ];

        $listing = $this -> db -> query('SELECT * FROM listings WHERE id = :id', $params);

        loadView('listings/show', ['listing' => $listing[0]]);
    }

    /**
    * Show the create listing form
    * 
    * @return void
    */

    public function create(){
        loadView('listings/create');
    }
}
