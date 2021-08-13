<?php
session_start();
$server = 'ric5531.encs.concordia.ca:3306';
$username ='ric55311';
$password = 'YKWTFGO';
$database = 'ric55311';

try{
    $conn = new PDO ("mysql:host=$server; dbname=$database;", $username, $password);
}catch (PDOException $e){
    die('Conenction Failed: ' . $e->getMessage());
}
?>