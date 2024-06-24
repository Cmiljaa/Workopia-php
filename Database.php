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
        $dns = "mysql:host={config['host]};port={config['port']};dbname={config['dbname']};";

        $options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

        try{
            $this->conn = new PDO($dns, $config['username'], $config['password']);
        }catch(PDOException $e){
            echo "Database is not connected: " . $e->getMessage();
        }
     }
}