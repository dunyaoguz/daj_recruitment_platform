<?php
include_once('../../database.php');

$user_id = $_SESSION['user_id'];
// $user_id = "8";

if(isset($_POST["email"]) && isset($_POST["subject"]) && isset($_POST["details"])) {
  $contactUsStmt = $conn->prepare("INSERT INTO emails (to_email, from_email, subject, body)
                                   VALUES (:to_email, :from_email, :subject, :body)");
  $toEmail = "admin@dajrecruitment.com";
  $contactUsStmt->bindParam(':to_email', $toEmail);
  $contactUsStmt->bindParam(':from_email', $_POST["email"]);
  $contactUsStmt->bindParam(':subject', $_POST["subject"]);
  $contactUsStmt->bindParam(':body', $_POST["details"]);
  $contactUsStmt->execute();
  $result = $contactUsStmt->fetch();
}

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Job Seeker Profile</title>
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
            <a class="nav-item nav-link" href="profile.php">Profile</a>
            <a class="nav-item nav-link active" href="#">Contact Us<span class="sr-only">(current)</span></a>
          </div>
        </div>
        <span class="logo-image"><img src="../../logo.png" class="logo"></span>
        </div>
      </nav>
      <h1>Contact Us</h1>
      <h6>Have questions or concerns? Fill the form below to contact us!</h6>
      <form action="" method="POST">
        <div class="form-group">
          <label for="email">Your Email</label><br>
          <input type="text" class="form-control" name="email" id="email" required>
        </div>
        <div class="form-group">
          <label for="subject">Subject</label><br>
          <input type="text" class="form-control" name="subject" id="subject" required>
        </div>
        <div class="form-group">
          <label for="details">Details</label><br>
          <input type="text" class="form-control" name="details" id="details" required>
          <br>
          <button type="submit" class="btn btn-outline-success">Submit</button>
        </div>
      </form>
      <br>
      <div class="footer">
        © 2021 Copyright: Dunya Oguz, Azman Akhter, John Purcell
      </div>

    </body>
</html>
