<?php

namespace App\Controllers;
use App\Models\HomeModel;
use Framework\Database;


class HomeController{
    protected $homeModel;

    public function __construct()
    {
        $this -> homeModel = new HomeModel();
    }

    public function index(){

        $listings = $this -> homeModel -> index();

        loadView('home', ['listings' => $listings]);
    }
}