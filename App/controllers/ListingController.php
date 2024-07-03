<?php

namespace App\Controllers;

use Framework\Autorization;
use Framework\Database;
use Framework\Session;
use Framework\Validation;
use App\Models;
use App\Models\ListingModel;

class ListingController{
    protected $listingModel;

    public function __construct()
    {
        $this -> listingModel = new ListingModel();
    }

    /**
    * Show all listings
    * 
    * @return void
    */

    public function index(){
        $listings = $this -> listingModel -> index();

        loadView('listings/index', ['listings' => $listings]);
    }

    /**
    * Show a single listing
    * 
    * @param array $params
    * @return void
    */

    public function show($params){
        
        $id = $params['id'] ?? '';

        $listing = $this -> listingModel -> getListingById($id);

        //Check if listing exists

        if(!$listing){
            ErrorController::notFound('Listing not found');
            return;
        }

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

    /**
    * Show the edit listing form
    * 
    * @return void
    */

    public function edit($params){
        $id = $params['id'] ?? '';

        $listing = $this -> listingModel -> getListingById($id);

        //Check if listing exists

        if(!$listing){
            ErrorController::notFound('Listing not found');
            return;
        }

        //Authorization

        if(!Autorization::isOwner($listing[0]['user_id'])){
            Session::setFlashMessage('error_message', 'You are not authorized to edit this listing');
            return redirect('/');
        }

        loadView('listings/edit', ['listing' => $listing[0]]);
    }

    /**
     * 
     * Store data in database
     * 
     * @return void 
     */

     public function store(){
        $allowedFields = ['title', 'description', 'salary', 'tags', 'company', 'address', 'city', 'state', 'phone', 'email', 'requirements', 'benefits'];
        $newListingData = array_intersect_key($_POST, array_flip($allowedFields));

        $newListingData['user_id'] = Session::get('user')['id'];

        $newListingData = array_map('sanitize', $newListingData);

        $requiredFields = ['title', 'description', 'email', 'city', 'state', 'salary'];

        $errors = [];

        foreach($requiredFields as $field){
            if(empty($newListingData[$field]) || !Validation::string($newListingData[$field])){
                $errors[$field] = ucfirst($field) . ' is required';
            } 
        }

        if(!empty($errors)){
            loadView('listings/create', ['errors' => $errors, 'listing' => $newListingData]);
        }else{

            $this -> listingModel -> store($newListingData);

            Session::setFlashMessage('success_message', 'Successfully added listing!');

            redirect('/listings');
        }
     }

    /**
    * Delete a single listing
    * 
    * @param array $params
    * @return void
    */

    public function delete($params){
        $id = $params['id'] ?? '';

        $listing = $this -> listingModel -> getListingById($id);

        //Authorization

        if(!Autorization::isOwner($listing[0]['user_id'])){
            Session::setFlashMessage('error_message', 'You are not authorized to delete this listing');
            return redirect('/');
        }

        $result = $this -> listingModel -> deleteListingById($id);

        //Set flash message

        Session::setFlashMessage('success_message', 'Listing deleted successfully!');

        redirect('/listings');
    }

    /**
    * 
    * Update a listing
    * 
    * @param array $params
    * @return void
    */
    
    public function update($params)
    {
        $id = $params['id'] ?? '';

        $listing = $this -> listingModel -> getListingById($id);

        // Check if listing exists
        if (!$listing) {
        ErrorController::notFound('Listing not found');
        return;
        }

        $allowedFields = ['title', 'description', 'salary', 'tags', 'company', 'address', 'city', 'state', 'phone', 'email', 'requirements', 'benefits'];

        $updateValues = [];

        $updateValues = array_intersect_key($_POST, array_flip($allowedFields));

        $updateValues = array_map('sanitize', $updateValues);

        $requiredFields = ['title', 'description', 'salary', 'email', 'city', 'state'];

        $errors = [];

        foreach ($requiredFields as $field){
            if (empty($updateValues[$field]) || !Validation::string($updateValues[$field])){
                $errors[$field] = ucfirst($field) . ' is required';
            }
        }

        if (!empty($errors)) {
        loadView('listings/edit', [
            'listing' => $listing[0],
            'errors' => $errors
        ]);
        exit;
        } else {

        // Submit to database
        $this -> listingModel -> update($id, $updateValues);

        // Set flash message
        Session::setFlashMessage('success_message', 'Listing updated');

        redirect('/listings/' . $id);
        }
    }

    /**
    * 
    * Search listings by keywords/location 
    * 
    * @return void 
    */

    public function search(){
        $keywords = isset($_GET['keywords']) ? trim($_GET['keywords']) : '';
        $location = isset($_GET['location']) ? trim($_GET['location']) : '';

        $listings = $this -> listingModel -> search($keywords, $location);

        inspectAndDie($listings);

        loadView('listings/index', [
            'listings' => $listings,
            'keywords' => $keywords,
            'location' => $location
        ]);
    }
}