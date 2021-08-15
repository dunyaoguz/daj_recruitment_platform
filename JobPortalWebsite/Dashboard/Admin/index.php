<?php
include_once('../../database.php');
//session_start();

//$user_id = $_SESSION['userId'];
$user_id = "8";


$jobSeekerInfoStmt = $conn->prepare("SELECT id, first_name, last_name FROM job_seekers WHERE user_id = ?");
$jobSeekerInfoStmt->execute([$user_id]);
$result = $jobSeekerInfoStmt->fetch();
$jobSeekerName = $result['first_name'] . ' ' . $result['last_name'];
$jobSeekerId = $result['id'];

$applicationStmt = $conn->prepare("SELECT a.id,
                                         a.date_applied,
                                         a.status AS application_status,
                                         j.title,
                                         j.description,
                                         e.name AS company,
                                         CONCAT(r.first_name, ' ', r.last_name) AS recruiter,
                                         j.status AS job_status,
                                         CONCAT(j.city, ', ', j.province, ', ', j.country) AS location,
                                         CASE WHEN is_remote_eligible = 1 THEN 'yes'
                                         ELSE 'no' END AS is_remote_eligible
                                  FROM applications a
                                  LEFT JOIN jobs j
                                    ON a.job_id = j.id
                                  LEFT JOIN employers e
                                    ON j.employer_id = e.id
                                  LEFT JOIN recruiters r
                                    ON j.recruiter_id = r.id
                                  WHERE job_seeker_id = ?");
$applicationStmt->execute([$jobSeekerId]);
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Job Seeker Dashboard</title>
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
            <a class="nav-item nav-link" href="./profile.php">Profile</a>
            <a class="nav-item nav-link" href="#">Contact Us</a>
          </div>
        </div>
        <span class="logo-image"><img src="../../logo.png" class="logo"></span>
        </div>
      </nav>
      <h1><?php echo $jobSeekerName . "'s Dashboard";?></h1>
      <h2>Your Applications</h2>
      <h6>Here is a quick glance of all of your existing applications.</h6>
      <br>
      <table class="table table-striped">
          <thead>
              <tr>
                  <td>Application ID</td>
                  <td>Date Applied</td>
                  <td>Job Title</td>
                  <td>Company</td>
                  <td>Recruiter</td>
                  <td>Location</td>
                  <td>Is Remote Eligible?</td>
                  <td>Job Status</td>
                  <td>Application Status</td>
                  <td>Actions</td>
              </tr>
          </thead>

          <tbody>
              <?php while ($row = $applicationStmt->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) { ?>
                  <tr>
                  <td> <?php echo $row['id']; ?> </td>
                  <td> <?php echo $row['date_applied']; ?> </td>
                  <td> <?php echo $row['title']; ?> </td>
                  <td> <?php echo $row['company']; ?> </td>
                  <td> <?php echo $row['recruiter']; ?> </td>
                  <td> <?php echo $row['location']; ?> </td>
                  <td> <?php echo $row['is_remote_eligible']; ?> </td>
                  <td> <?php echo $row['job_status']; ?> </td>
                  <td> <?php echo $row['application_status']; ?> </td>
                  <td>
                    <a href="./withdraw.php?application_id=<?= $row["id"]?>">Withdraw</a>
                  </td>
                  </tr>
              <?php } ?>
          </tbody>
      </table>
      <br>
      <br>
      <br>
      <center><a href="./search.php" class="btn btn-outline-success">Search for new jobs</a></center>
      <br>
      <br>
      <div class="footer">
        © 2021 Copyright: Dunya Oguz, Azman Akhter, John Purcell
      </div>

    </body>
</html>
