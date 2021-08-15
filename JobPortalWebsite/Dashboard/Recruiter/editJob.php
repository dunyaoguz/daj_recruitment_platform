<?php
include_once('../../database.php');

$user_id = $_SESSION['user_id'];
// $user_id = "8";
$jobId = $_GET["job_id"];

// Obtain Recruiter's Name, Recruiter ID, Recruiter's Employer ID
$getRecruiterInfoStmt = $conn->prepare("SELECT r.id AS recruiter_id,
                                               r.user_id,
                                               r.employer_id AS recruiter_employer_id,
                                               r.first_name AS recruiter_first_name,
                                               r.last_name
                                        FROM recruiters r
                                        WHERE r.user_id = :user_id");

$getRecruiterInfoStmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$getRecruiterInfoStmt->execute();
$recruiterInfo = $getRecruiterInfoStmt->fetch();
$recruiterName = $recruiterInfo['recruiter_first_name'];

$jobInfoStmt = $conn->prepare("SELECT date_posted,
                                      title,
                                      description,
                                      required_experience,
                                      status,
                                      city,
                                      province,
                                      country,
                                      CASE WHEN is_remote_eligible = 1 THEN 'Yes'
                                      ELSE 'No' END AS is_remote_eligible
                               FROM jobs j
                               WHERE id = :job_id");

$jobInfoStmt->bindParam(':job_id', $jobId, PDO::PARAM_INT);
$jobInfoStmt->execute();
$jobInfo = $jobInfoStmt->fetch();

if ($_POST["date_posted"]) {
  $updateStmt = $conn->prepare("UPDATE jobs SET date_posted = :value WHERE id = :id");
  $updateStmt->bindParam(':value', $_POST["date_posted"]);
  $updateStmt->bindParam(':id', $jobId, PDO::PARAM_INT);
  $updateStmt->execute();
  Header('Location: '.$_SERVER['PHP_SELF'].'?job_id='.$_GET["job_id"]);
}

if ($_POST["title"]) {
  $updateStmt = $conn->prepare("UPDATE jobs SET title = :value WHERE id = :id");
  $updateStmt->bindParam(':value', $_POST["title"]);
  $updateStmt->bindParam(':id', $jobId, PDO::PARAM_INT);
  $updateStmt->execute();
  Header('Location: '.$_SERVER['PHP_SELF'].'?job_id='.$_GET["job_id"]);
}

if ($_POST["description"]) {
  $updateStmt = $conn->prepare("UPDATE jobs SET description = :value WHERE id = :id");
  $updateStmt->bindParam(':value', $_POST["description"]);
  $updateStmt->bindParam(':id', $jobId, PDO::PARAM_INT);
  $updateStmt->execute();
  Header('Location: '.$_SERVER['PHP_SELF'].'?job_id='.$_GET["job_id"]);
}

if ($_POST["required_experience"]) {
  $updateStmt = $conn->prepare("UPDATE jobs SET required_experience = :value WHERE id = :id");
  $updateStmt->bindParam(':value', $_POST["required_experience"], PDO::PARAM_INT);
  $updateStmt->bindParam(':id', $jobId, PDO::PARAM_INT);
  $updateStmt->execute();
  Header('Location: '.$_SERVER['PHP_SELF'].'?job_id='.$_GET["job_id"]);
}

if ($_POST["status"]) {
  $updateStmt = $conn->prepare("UPDATE jobs SET status = :value WHERE id = :id");
  $updateStmt->bindParam(':value', $_POST["status"]);
  $updateStmt->bindParam(':id', $jobId, PDO::PARAM_INT);
  $updateStmt->execute();
  Header('Location: '.$_SERVER['PHP_SELF'].'?job_id='.$_GET["job_id"]);
}

if ($_POST["city"]) {
  $updateStmt = $conn->prepare("UPDATE jobs SET city = :value WHERE id = :id");
  $updateStmt->bindParam(':value', $_POST["city"]);
  $updateStmt->bindParam(':id', $jobId, PDO::PARAM_INT);
  $updateStmt->execute();
  Header('Location: '.$_SERVER['PHP_SELF'].'?job_id='.$_GET["job_id"]);
}

if ($_POST["province"]) {
  $updateStmt = $conn->prepare("UPDATE jobs SET province = :value WHERE id = :id");
  $updateStmt->bindParam(':value', $_POST["province"]);
  $updateStmt->bindParam(':id', $jobId, PDO::PARAM_INT);
  $updateStmt->execute();
  Header('Location: '.$_SERVER['PHP_SELF'].'?job_id='.$_GET["job_id"]);
}

if ($_POST["country"]) {
  $updateStmt = $conn->prepare("UPDATE jobs SET country = :value WHERE id = :id");
  $updateStmt->bindParam(':value', $_POST["country"]);
  $updateStmt->bindParam(':id', $jobId, PDO::PARAM_INT);
  $updateStmt->execute();
  Header('Location: '.$_SERVER['PHP_SELF'].'?job_id='.$_GET["job_id"]);
}

if ($_POST["is_remote_eligible"]) {
  if($_POST["is_remote_eligible"]=="Yes") {
    $is_remote_eligible = 1;
  }else{
    $is_remote_eligible = 0;
  }
  $updateStmt = $conn->prepare("UPDATE jobs SET is_remote_eligible = :value WHERE id = :id");
  $updateStmt->bindParam(':value', $is_remote_eligible, PDO::PARAM_INT);
  $updateStmt->bindParam(':id', $jobId, PDO::PARAM_INT);
  $updateStmt->execute();
  Header('Location: '.$_SERVER['PHP_SELF'].'?job_id='.$_GET["job_id"]);
}

?>

<!DOCTYPE html>
<html>
  <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <title>Recruiter Dashboard</title>
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
          <a class="nav-item nav-link" href="index.php">Dashboard</a>
          <a class="nav-item nav-link" href="contactUs.php">Contact Us</a>
          <a class="nav-item nav-link" href="../../">Sign Out</a>
        </div>
      </div>
      <span class="logo-image"><img src="../../logo.png" class="logo"></span>
      </div>
    </nav>
    <h1><?php echo $recruiterName . "'s Dashboard";?></h1>

      <h2>Edit Job</h2>
      <h6>You can modify the job details here.</h6>
      <br>
      <table class="table table-striped">
          <thead>
              <tr>
                  <td>Attribute</td>
                  <td>Your Input</td>
                  <td>Actions</td>
              </tr>
          </thead>
          <tbody>
              <tr>
                <td>Date Posted</td>
                <td><?php echo $jobInfo['date_posted']; ?></td>
                <td>
                  <form action="" method="POST">
                    <div class="jobseeker-profile-form">
                        <div>
                        <input type="text" class="form-control" name="date_posted" id="date_posted" required>
                        </div>
                        <button type="submit" class="btn btn-outline-success">Update</button>
                  </form>
                </td>
              </tr>
              <tr>
                <td>Job Title</td>
                <td><?php echo $jobInfo['title']; ?></td>
                <td>
                  <form action="" method="POST">
                    <div class="jobseeker-profile-form">
                        <div>
                        <input type="text" class="form-control" name="title" id="title" required>
                        </div>
                        <button type="submit" class="btn btn-outline-success">Update</button>
                  </form>
                </td>
              </tr>
              <tr>
                <td>Job Description</td>
                <td><?php echo $jobInfo['description']; ?></td>
                <td>
                  <form action="" method="POST">
                    <div class="jobseeker-profile-form">
                        <div>
                        <input type="text" class="form-control" name="description" id="description" required>
                        </div>
                        <button type="submit" class="btn btn-outline-success">Update</button>
                  </form>
                </td>
              </tr>
              <tr>
                <td>Required Years of Experience</td>
                <td><?php echo $jobInfo['required_experience']; ?></td>
                <td>
                  <form action="" method="POST">
                    <div class="jobseeker-profile-form">
                        <div>
                        <input type="text" class="form-control" name="required_experience" id="required_experience" required>
                        </div>
                        <button type="submit" class="btn btn-outline-success">Update</button>
                  </form>
                </td>
              </tr>
              <tr>
                <td>Status (Open/Closed)</td>
                <td><?php echo $jobInfo['status']; ?></td>
                <td>
                  <form action="" method="POST">
                    <div class="jobseeker-profile-form">
                        <div>
                        <input type="text" class="form-control" name="status" id="status" required>
                        </div>
                        <button type="submit" class="btn btn-outline-success">Update</button>
                  </form>
                </td>
              </tr>
              <tr>
                <td>City</td>
                <td><?php echo $jobInfo['city']; ?></td>
                <td>
                  <form action="" method="POST">
                    <div class="jobseeker-profile-form">
                        <div>
                        <input type="text" class="form-control" name="city" id="city" required>
                        </div>
                        <button type="submit" class="btn btn-outline-success">Update</button>
                  </form>
                </td>
              </tr>
              <tr>
                <td>Province</td>
                <td><?php echo $jobInfo['province']; ?></td>
                <td>
                  <form action="" method="POST">
                    <div class="jobseeker-profile-form">
                        <div>
                        <input type="text" class="form-control" name="province" id="province" required>
                        </div>
                        <button type="submit" class="btn btn-outline-success">Update</button>
                  </form>
                </td>
              </tr>
              <tr>
                <td>Country</td>
                <td><?php echo $jobInfo['country']; ?></td>
                <td>
                  <form action="" method="POST">
                    <div class="jobseeker-profile-form">
                        <div>
                        <input type="text" class="form-control" name="country" id="country" required>
                        </div>
                        <button type="submit" class="btn btn-outline-success">Update</button>
                  </form>
                </td>
              </tr>
              <tr>
                <td>Is remote eligible? (Yes/No)</td>
                <td><?php echo $jobInfo['is_remote_eligible']; ?></td>
                <td>
                  <form action="" method="POST">
                    <div class="jobseeker-profile-form">
                        <div>
                        <input type="text" class="form-control" name="is_remote_eligible" id="is_remote_eligible" required>
                        </div>
                        <button type="submit" class="btn btn-outline-success">Update</button>
                  </form>
                </td>
              </tr>
          </tbody>
      </table>
      <br>
      <br>
      <div class="footer">
        © 2021 Copyright: Dunya Oguz, Azman Akhter, John Purcell
      </div>

    </body>
</html>
