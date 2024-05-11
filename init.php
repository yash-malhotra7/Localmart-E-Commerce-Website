<?php

// Database credentials
$host = 'localhost'; // Change this if your database server is hosted elsewhere
$username = 'root'; // Change this to your database username
$password = ''; // Change this to your database password
$database = 'localmart'; // Change this to your database name

// Attempt to connect to the database
$mysqli = new mysqli($host, $username, $password, $database);

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Set charset to UTF-8
$mysqli->set_charset("utf8");

?>
