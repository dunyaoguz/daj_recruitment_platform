<?php
include_once('../../database.php');

$user_id = $_SESSION['user_id'];
//$user_id = "8";

$jobCloseStmt = $conn->prepare("UPDATE jobs SET status = 'Closed' WHERE id = :id");
$jobCloseStmt->bindParam(':id', $_GET["job_id"], PDO::PARAM_INT);

if($jobCloseStmt->execute()){
    header("Location: .");
}
?>
