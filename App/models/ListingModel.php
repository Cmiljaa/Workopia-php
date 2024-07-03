<?php

namespace App\Models;
use Framework\Database;

class ListingModel{
    protected $db;

    public function __construct()
    {
        $config = require basePath('config/db.php');

        $this -> db = new Database($config);
    }

    public function index(){
        return $this -> db -> query("SELECT * FROM listings ORDER BY created_at DESC");
    }

    public function getListingById($id){

        $params = [
            'id' => $id
        ];

        return $this -> db -> query('SELECT * FROM listings WHERE id = :id', $params);
    }

    public function deleteListingById($id){

        $params = [
            'id' => $id
        ];

        return $this -> db -> query('DELETE FROM listings WHERE id = :id', $params);

    }

    public function search($keywords, $location){
        $query = "SELECT * FROM listings WHERE (title LIKE :keywords OR description LIKE :keywords
        OR tags LIKE :keywords OR company LIKE :keywords) AND (city LIKE :location OR state LIKE :location)";

        $params = [
            'keywords' => "%{$keywords}%",
            'location' => "%{$location}%"
        ];

        return $this->db->query($query, $params);
    }

    public function update($id, $updateValues){
        $updateFields = [];

        foreach (array_keys($updateValues) as $field) {
            $updateFields[] = "{$field} = :{$field}";
        }

        $updateFields = implode(', ', $updateFields);

        $updateQuery = "UPDATE listings SET $updateFields WHERE id = :id";

        $updateValues['id'] = $id;
        return $this-> db ->query($updateQuery, $updateValues);
    }

    public function store($newListingData){
        $fields = [];

            foreach($newListingData as $field => $value){
                $fields[] = $field;
            }

            $fields = implode(',', $fields);

            $values = [];

            foreach($newListingData as $field => $value){
                if($value === ''){
                    $newListingData[$field] = null;
                }

                $values[] = ':' . $field;
            }

            $values = implode(',', $values);

            $this -> db -> query("INSERT INTO listings({$fields}) VALUES ({$values})", $newListingData);
    }

}