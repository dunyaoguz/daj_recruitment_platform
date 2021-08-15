<?php
include_once('../../database.php');

$user_id = $_SESSION['user_id'];
// $user_id = "8";

$jobSeekerStmt = $conn->prepare("SELECT id FROM job_seekers WHERE user_id = ?");
$jobSeekerStmt->execute([$user_id]);
$result = $jobSeekerStmt->fetch();
$jobSeekerId = $result['id'];

$applyStmt = $conn->prepare("INSERT INTO applications (job_id, job_seeker_id)
                             VALUES (:job_id, :job_seeker_id)");
$applyStmt->bindParam(':job_id', $_GET["job_id"], PDO::PARAM_INT);
$applyStmt->bindParam(':job_seeker_id', $jobSeekerId, PDO::PARAM_INT);

if($applyStmt->execute()){
    header("Location: .");
}
?>
