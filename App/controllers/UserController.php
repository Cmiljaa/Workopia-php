<?php

namespace App\Controllers;

use App\Models\UserModel;
use Framework\Database;
use Framework\Validation;
use Framework\Session;

class UserController{
    protected $userModel;

    public function __construct()
    {
        $this -> userModel = new UserModel();
    }

    /**
     * 
     * Show the login page
     * 
     * @return void
     */

    public function login(){
        loadView('users/login');
    }

    /**
     * 
     * Show the register page
     * 
     * @return void
     */

    public function create(){
        loadView('users/create');
    }

    /**
     * 
     * Store user in database
     * 
     * @return void
     */

    public function store(){

        $name = $_POST['name'];
        $email = $_POST['email'];
        $city = $_POST['city'];
        $state = $_POST['state'];
        $password = $_POST['password'];
        $passwordConfirmation = $_POST['password_confirmation'];

        $errors = [];

        //Validation
        if(!Validation::email($email)){
            $errors['email'] = 'Please enter a valid email address'; 
        }

        if(!Validation::string($name, 2, 50)){
            $errors['name'] = 'Name must be between 2 and 50 characters';
        }

        if(!Validation::string($password, 6,50)){
            $errors['password'] = 'Password must be between 6 and 50 characters';
        }

        if(!Validation::match($password, $passwordConfirmation)){
            $errors['password_confirmation'] = 'Passwords do not match';
        }

        $input = [
            'name' => $name,
            'email' => $email,
            'city' => $city,
            'state' => $state,
            'password' => $password,
            'password_confirmation' => $passwordConfirmation
        ];

        if(!empty($errors)){
        loadView('users/create', [
            'errors' => $errors,
            'input' => $input
        ]);
        exit;
        }

        $user = $this -> userModel -> getUserByEmail($email);

        if($user){
            $errors['email'] = 'Email already exists';
            loadView('users/create', [
                'errors' => $errors,
                'input' => $input
            ]);
            exit;
        }

        //Create a user
        
        $params = [
            'name' => $name,
            'email' => $email,
            'city' => $city,
            'state' => $state,
            'password' => $password,
            'password' => password_hash($password, PASSWORD_DEFAULT)
        ];

        //Get the new user id

        $userId = $this->userModel -> create($params);

        Session::set('user', [
            'id' => $userId,
            'name' => $name,
            'email' => $email,
            'city' => $city,
            'state' => $state
        ]);

        Session::setFlashMessage('success_message', 'Registration successfully!');

        redirect('/');
    }

    /**
    * 
    * Logout a user and kill the session
    * 
    * @return void
    */

    public function logout(){
        Session::clearAll();

        $params = session_get_cookie_params();

        setcookie('PHPSESSID', '', time() - 86400, $params['path'], $params['domain']);

        redirect('/');
    }

    /**
    * Authenticate a user with email and password
    * 
    * @return void
    */

    public function authenticate(){
        $email = $_POST['email'];
        $password = $_POST['password'];

        $errors = [];

        if(!Validation::email($email)){
            $errors['email'] = 'Incorrect email';
        }

        if(!Validation::string($password, 6, 50)){
            $errors['password'] = 'Password must be at least 6 characters';
        }

        if(!empty($errors)){
            loadView('users/login', [
                'errors' => $errors,
                'email' => $email,
                'password' => $password
                ]);
            exit();
        }

        $user = $this -> userModel -> getUserByEmail($email);

        if(empty($user)){
            $errors['email'] = 'Incorrect credentials';
            loadView('users/login', [
                'errors' => $errors,
                'email' => $email,
                'password' => $password
                ]);
            exit();
        }

        $user = $user[0];

        //Check if password is correct
        if(!password_verify($password, $user['password'])){
            $errors['password'] = 'Incorrect credentials';
            loadView('users/login', [
                'errors' => $errors,
                'email' => $email,
                'password' => $password
                ]);
            exit();
        }

        //Set a user session
        Session::set('user', [
            'id' => $user['id'],
            'name' => $user['name'],
            'email' => $user['email'],
            'city' => $user['city'],
            'state' => $user['state']
        ]);

        Session::setFlashMessage('success_message', 'Successfully logged in!');
        redirect('/');

    }
}