<?php

class Database{
    public $conn;
    /**
     * Constructor for Database class
     * 
     * @param array $config
     * 
     * 
     */

     public function __construct($config)
     {
        $dns = "mysql:host={$config['host']};port={$config['port']};dbname={$config['dbname']};";

        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ];

        try{
            $this->conn = new PDO($dns, $config['username'], $config['password'], $options);
        }catch(PDOException $e){
            echo "Database is not connected: " . $e->getMessage();
        }
     }

     /**
     * Query the database
     * 
     * @param string $query
     * 
     * @return PDOstatement
     * @throws PDOException
     */

     public function query($query){
        try{
            $stmt = $this->conn->prepare($query);
            $stmt -> execute();
            return $stmt -> fetchAll();
        }catch(PDOException $e){
            echo "Query failed to execute: " . $e -> getMessage();
        }
     }
}