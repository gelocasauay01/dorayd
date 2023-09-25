<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/data_source/MySqlDataSource.php");

$serverName = "localhost";
$username = "root";
$password = "";
$databaseName = "dorayd";

// Create connection
$mySqlConnection = new mysqli($serverName, $username, $password, $databaseName);

// Check Connection
if ($mySqlConnection->connect_error) {
    die("Connection failed: " . $mySqlConnection->connect_error);
}

$dataSource = new MySqlDataSource($mySqlConnection);
