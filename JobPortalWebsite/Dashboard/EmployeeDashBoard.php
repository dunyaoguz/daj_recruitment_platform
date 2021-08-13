
<?php 
include_once('/nfs/groups/r/ri_comp5531_1/COMP5531_final_project/Job_Portal_Website/database.php');
//session_start();

//$user_id = $_SESSION['userID'];
$user_id = "1";


$employeerInfoStmt = $conn->prepare("SELECT id, name FROM employers WHERE user_id = ?");
$employeerInfoStmt->execute([$user_id]);
$result = $employeerInfoStmt->fetch();
$employeerName = $result['name'];
$employeerId = $result['id'];

$jobListingStmt = $conn->prepare("SELECT recruiter_id, date_posted, title, description, required_experience, status FROM jobs WHERE employer_id = ?");
$jobListingStmt->execute([$employeerId]);
$jobListingResult = $jobListingStmt->fetchAll();

?>


<<!DOCTYPE html>
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
        <h1> <?php echo Welcome $employeerName; ?> </h1>

        <br>

        <table align = "centre", border = "1px", style = "width:600px; line-height:40px">
            <tr>
                <th> <<h2>Job Listing</h2> </th>
            </tr>
            <t>
                <th>Recruiter ID</th>
                <th>Date Posted</th>
                <th>Job Title</th>
                <th>Description</th>
                <th>Required Experience</th>
                <th>Status</th>
            </t>
            <?php
            foreach($jobListingResult as $row) {
            ?>
                <tr>
                    <td> <?php echo $row['recruiter_id']; ?> </td>
                    <td> <?php echo $row['date_posted']; ?> </td>
                    <td> <?php echo $row['title']; ?> </td>
                    <td> <?php echo $row['description']; ?> </td>
                    <td> <?php echo $row['required_experience']; ?> </td>
                    <td> <?php echo $row['status']; ?> </td>
                </tr>
            <?php
                }
            ?>
                


        </table>



    </body>
</html>