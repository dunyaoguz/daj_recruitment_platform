<?php
include_once('../../database.php');
//session_start();

//$user_id = $_SESSION['userId'];
$user_id = "1";


$employeerInfoStmt = $conn->prepare("SELECT e.id, e.name 
                                        FROM employers e 
                                        WHERE e.user_id = ?");
$employeerInfoStmt->execute([$user_id]);
$result = $employeerInfoStmt->fetch();
$employeerName = $result['e.name'];
$employeerId = $result['e.id'];

$jobListingStmt = $conn->prepare("SELECT j.id, j.recruiter_id, j.date_posted, j.title, j.description, j.required_experience, j.status 
                                      FROM jobs j
                                      WHERE j.employer_id = ?");
$jobListingStmt->execute([$employeerId]);


$recruiterListingStmt = $conn->prepare("SELECT r.id, r.user_id, r.employer_id, r.first_name, r.last_name 
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
            <a class="nav-item nav-link" href="#">Membership</a>
            <a class="nav-item nav-link" href="#">Contact Us</a>
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
                  <td> <?php echo $row['j.id']; ?> </td>
                  <td> <?php echo $row['j.recruiter_id']; ?> </td>
                  <td> <?php echo $row['j.date_posted']; ?> </td>
                  <td> <?php echo $row['j.title']; ?> </td>
                  <td> <?php echo $row['j.description']; ?> </td>
                  <td> <?php echo $row['j.required_experience']; ?> </td>
                  <td> <?php echo $row['j.status']; ?> </td>
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
                  <td> <?php echo $data['r.id']; ?> </td>
                  <td> <?php echo $data['r.first_name']; ?> </td>
                  <td> <?php echo $data['r.last_name']; ?> </td>
                  <td>
                    <a href="./edit.php?recruiter_id=<?= $data["r.id"] ?>">Edit</a><br>    
                    <a href="./delete.php?recruiter_id=<?= $data["r.id"] ?>">Delete</a>
                  </td>
                  </tr>
              <?php } ?>
          </tbody>
      </table>
      <br>
      <center><a href="./create.php" class="btn btn-outline-success">Add a New Recruiter</a></center>
      <br>
      <div class="footer">
        © 2021 Copyright: Dunya Oguz, Azman Akhter, John Purcell
      </div>

    </body>
</html>
