<?php
include_once('../../database.php');
//session_start();

//$user_id = $_SESSION['userId'];
$user_id = "1";


$employeerInfoStmt = $conn->prepare("SELECT e.id AS employer_id, e.name AS employer_name
                                        FROM employers e
                                        WHERE e.user_id = ?");
$employeerInfoStmt->execute([$user_id]);
$result = $employeerInfoStmt->fetch();
$employeerName = $result['employer_name'];
$employeerId = $result['employer_id'];

$jobListingStmt = $conn->prepare("SELECT j.id AS job_id, j.recruiter_id AS job_recruiter_id, j.date_posted AS job_date_posted, j.title AS job_title, j.description AS job_description, j.required_experience AS job_required_experience, j.status AS job_status
                                      FROM jobs j
                                      WHERE j.employer_id = ?");
$jobListingStmt->execute([$employeerId]);


$recruiterListingStmt = $conn->prepare("SELECT r.id AS recruiter_id, r.user_id AS recruiter_user_id, r.employer_id AS recruiter_employer_id, r.first_name AS recruiter_first_name, r.last_name AS recruiter_last_name
                                          FROM recruiters r
                                          WHERE r.employer_id = ?");
$recruiterListingStmt->execute([$employeerId]);

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
        <link rel="icon" href="../../logo.png" type="penguin">
        <html lang="en">
    </head>
    <body>
      <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
        <span class="navbar-brand mb-0 h1">DAJ Recruitment Platform</span>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
          <div class="navbar-nav">
            <a class="nav-item nav-link active" href="#">Dashboard<span class="sr-only">(current)</span></a>
            <a class="nav-item nav-link" href="profile.php">Profile</a>
            <a class="nav-item nav-link" href="contactUs.php">Contact Us</a>
          </div>
        </div>
        <span class="logo-image"><img src="../../logo.png" class="logo"></span>
        </div>
      </nav>
      <h1><?php echo $employeerName . "'s Dashboard";?></h1>
      <h2>Your Jobs</h2>
      <h6>Here is a quick glance of all the jobs you've published with us.</h6>
      <br>
      <table class="table table-striped">
          <thead>
              <tr>
                  <td>Job ID</td>
                  <td>Recruiter ID</td>
                  <td>Date Posted</td>
                  <td>Job Title</td>
                  <td>Description</td>
                  <td>Required Experience (Years)</td>
                  <td>Status</td>
              </tr>
          </thead>

          <tbody>
              <?php while ($row = $jobListingStmt->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) { ?>
                  <tr>
                  <td> <?php echo $row['job_id']; ?> </td>
                  <td> <?php echo $row['job_recruiter_id']; ?> </td>
                  <td> <?php echo $row['job_date_posted']; ?> </td>
                  <td> <?php echo $row['job_title']; ?> </td>
                  <td> <?php echo $row['job_description']; ?> </td>
                  <td> <?php echo $row['job_required_experience']; ?> </td>
                  <td> <?php echo $row['job_status']; ?> </td>
                  </tr>
              <?php } ?>
          </tbody>
      </table>
      <br>
      <br>
      <h2>Your Recruiters</h2>
      <h6>Here are the recruiters eligible to post jobs on your behalf.</h6>
      <br>
      <table class="table table-striped">
          <thead>
              <tr>
                  <td>Recruiter ID</td>
                  <td>First Name</td>
                  <td>Last Name</td>
                  <td>Actions</td>
              </tr>
          </thead>

          <tbody>
              <?php while ($data = $recruiterListingStmt->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) { ?>
                  <tr>
                  <td> <?php echo $data['recruiter_id']; ?> </td>
                  <td> <?php echo $data['recruiter_first_name']; ?> </td>
                  <td> <?php echo $data['recruiter_last_name']; ?> </td>
                  <td>
                    <a href="./edit.php?recruiter_id=<?= $data["recruiter_id"] ?>">Edit</a><br>
                    <a href="./delete.php?recruiter_id=<?= $data["recruiter_id"] ?>">Delete</a>
                  </td>
                  </tr>
              <?php } ?>
          </tbody>
      </table>
      <br>
      <center><a href="./create.php" class="btn btn-outline-success">Add a New Recruiter</a></center>
      <br>
      <br>
      <div class="footer">
        © 2021 Copyright: Dunya Oguz, Azman Akhter, John Purcell
      </div>

    </body>
</html>
