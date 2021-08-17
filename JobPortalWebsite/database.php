<?php
session_start();
$server = '127.0.0.1';
$username ='root';
$password = '...';
$database = 'recruitment_platform';

try{
    $conn = new PDO ("mysql:host=$server; port=3306; dbname=$database;", $username, $password);
}catch (PDOException $e){
    die('Connection Failed: ' . $e->getMessage());
}
?>
