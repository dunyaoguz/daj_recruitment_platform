<?php
include_once('../../database.php');

$user_id = $_SESSION['user_id'];
//$user_id = "8";

$statusUpdateStmt = $conn->prepare("UPDATE users SET status = 'Deactivated' WHERE id = :id");
$statusUpdateStmt->bindParam(':id', $_GET["user_id"], PDO::PARAM_INT);

if($statusUpdateStmt->execute()){
    header("Location: .");
}
?>
