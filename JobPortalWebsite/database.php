<?php
session_start();
$server = 'ric5531.encs.concordia.ca:3306';
$username ='ric55311';
$password = 'YKWTFGO';
$database = 'ric55311';
// $server = '127.0.0.1';
// $username ='root';
// $password = 'dunya130995';
// $database = 'recruitment_platform';

try{
    // $conn = new PDO ("mysql:host=$server; port=3306; dbname=$database;", $username, $password);
    $conn = new PDO ("mysql:host=$server; dbname=$database;", $username, $password);
}catch (PDOException $e){
    die('Connection Failed: ' . $e->getMessage());
}
?>
