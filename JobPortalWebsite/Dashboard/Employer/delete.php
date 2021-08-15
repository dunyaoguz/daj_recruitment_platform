<?php
include_once('../../database.php');

//$user_id = $_SESSION['userId'];
//$user_id = "1";

$recruiterDeleteStmt = $conn->prepare("DELETE FROM recruiters r
                                            WHERE r.id = :r.id");
$recruiterDeleteStmt->bindParam(':r.id', $_GET["recruiter_id"], PDO::PARAM_INT);

if($recruiterDeleteStmt->execute()){
    header("Location: .");
}

?>