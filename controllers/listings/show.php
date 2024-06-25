<?php

$config = require basePath('config/db.php');

$db = new Database($config);

$id = $_GET['id'] ?? '';

$params = [
    'id' => $id
];

$listing = $db -> query('SELECT * FROM listings WHERE id = :id', $params);

loadView('listings/show', ['listing' => $listing[0]]);



