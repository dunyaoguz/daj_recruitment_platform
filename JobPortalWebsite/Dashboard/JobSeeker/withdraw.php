<?php
include_once('../../database.php');

$user_id = $_SESSION['user_id'];
//$user_id = "8";

$applicationWithdrawStmt = $conn->prepare("UPDATE applications SET status = 'Withdrawn' WHERE id = :id");
$applicationWithdrawStmt->bindParam(':id', $_GET["application_id"], PDO::PARAM_INT);

if($applicationWithdrawStmt->execute()){
    header("Location: .");
}
?>
