<?php
include_once('../../database.php');

//$user_id = $_SESSION['userId'];
//$user_id = "1";

$targetRecruiterId = $_GET["recruiter_id"];

$userIdInfoStmt = $conn->prepare("SELECT r.user_id AS recruiter_user_id
                                    FROM recruiters r
                                    WHERE r.id = :r_id");
$userIdInfoStmt->bindParam(':r_id', $targetRecruiterId, PDO::PARAM_INT);
$userIdInfoStmt->execute();
$userIdInfo = $userIdInfoStmt->fetch();
                                

$recruiterDeleteStmt = $conn->prepare("DELETE FROM recruiters
                                            WHERE id = :id");
$recruiterDeleteStmt->bindParam(':id', $targetRecruiterId, PDO::PARAM_INT);

$userDeleteStmt = $conn->prepare("DELETE FROM users
                                            WHERE id = :recruiter_user_id");
$userDeleteStmt->bindParam(':recruiter_user_id', $userIdInfo["recruiter_user_id"], PDO::PARAM_INT);

if($recruiterDeleteStmt->execute()){
    if($userDeleteStmt->execute()){
        header("Location: .");
    }
}

?>