<?php
include_once('../../database.php');
session_start();

$user_id = $_SESSION['userId'];
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
        <title>Employer Dashboard</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="../../style.css">
        <html lang="en">
    </head>
    <body>
      <nav class="navbar navbar-light bg-light">
        <span class="navbar-brand mb-0 h1">DAJ Recruitment Platform</span>
        <span class="logo-image"><img src="../../logo.png" class="logo"></span>
      </nav>
      <h1><?php echo $employeerName . "'s Dashboard";?></h1>
      <h2>Your Jobs</h2>
      <h6>Here is a quick glance of all the jobs you've published with us.</h6>
      <br>
      <table class="table table-striped table-responsive-lg">
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
                      <!-- <a href="./?job_id="<?= $row["id"] ?>Edit</a> -->
                  </td>
                  </tr>
              <?php } ?>
          </tbody>
      </table>
      <br>
      <center><a href="./create.php" class="btn btn-outline-success">Add a new job</a></center>
      <br>
      <h2>Your Recruiters</h2>
      <h6>Here are the recruiters eligible to post jobs on your behalf.</h6>

      <div class="footer">
        © 2021 Copyright: Dunya Oguz, Azman Akhter, John Purcell
      </div>

    </body>
</html>
