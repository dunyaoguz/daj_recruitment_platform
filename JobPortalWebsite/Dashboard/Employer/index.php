<?php 
include_once('../../database.php');
//session_start();

//$user_id = $_SESSION['userId'];
$user_id = "1";


$employeerInfoStmt = $conn->prepare("SELECT id, name FROM employers WHERE user_id = ?");
$employeerInfoStmt->execute([$user_id]);
$result = $employeerInfoStmt->fetch();
$employeerName = $result['name'];
$employeerId = $result['id'];

$jobListingStmt = $conn->prepare("SELECT id, recruiter_id, date_posted, title, description, required_experience, status FROM jobs WHERE employer_id = ?");
$jobListingStmt->execute([$employeerId]);
?>


<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Employer DashBoard</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="">
    </head>
    <body>

        <h2> <?php echo "Welcome " . $employeerName;?> </h2>

        <br>

        <a href="./create.php">Add a new job</a>
        <h4>List of Jobs</h4>
        <table align = "centre", border = "1px", style = "width:600px; line-height:40px">
            <thead>
                <tr>
                    <td>Job ID</td>    
                    <td>Recruiter ID</td>
                    <td>Date Posted</td>
                    <td>Job Title</td>
                    <td>Description</td>
                    <td>Required Experience (Years)</td>
                    <td>Status</td>
                    <td>Actions</td>
                </tr>
            </thead>
            
            <tbody>
                <?php while ($row = $jobListingStmt->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) { ?>
                    <tr>
                    <td> <?php echo $row['id']; ?> </td>
                    <td> <?php echo $row['recruiter_id']; ?> </td>
                    <td> <?php echo $row['date_posted']; ?> </td>
                    <td> <?php echo $row['title']; ?> </td>
                    <td> <?php echo $row['description']; ?> </td>
                    <td> <?php echo $row['required_experience']; ?> </td>
                    <td> <?php echo $row['status']; ?> </td>
                    <td>
                        <a href="./?job_id="<?= $row["id"] ?>Delete</a>
                        <a href="./?job_id="<?= $row["id"] ?>Edit</a>
                    </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <br>

        <a href="../../index.php">Back To HomePage</a>

    </body>
</html>