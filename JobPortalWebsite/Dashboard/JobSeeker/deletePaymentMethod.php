<?php
include_once('../../database.php');

$targetPaymentId = $_GET["payment_id"];

$paymentMethodDeleteStmt = $conn->prepare("DELETE FROM payment_methods
                                           WHERE id = :id");
$paymentMethodDeleteStmt->bindParam(':id', $targetPaymentId, PDO::PARAM_INT);

if($paymentMethodDeleteStmt->execute()){
    header("Location: profile.php");
}

?>
