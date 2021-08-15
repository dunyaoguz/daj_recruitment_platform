<?php
include_once('../../database.php');

$user_id = $_SESSION['user_id'];
// $user_id = "8";

if ($_POST["deactivate"]) {
  $deleteStmt = $conn->prepare("UPDATE users SET status = 'Deactivated' WHERE id = ?");
  $deleteStmt->execute([$user_id]);
  header("Location:../../");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="../../style.css">
    <link rel="icon" href="../../logo.png" type="penguin">
    <title>DAJ Recruitment Platform</title>
</head>
<body>
  <nav class="navbar navbar-light bg-light">
    <span class="navbar-brand mb-0 h1">DAJ Recruitment Platform</span>
    <span class="logo-image"><img src="../../logo.png" class="logo"></span>
  </nav>
  <h1>Are you sure?</h1>
  <center><h6>Warning: This action is hard to reverse!</h1></center>
  <p></p>
  <div class="d-flex justify-content-center">
    <div class="button">
      <a href='./profile.php' class="btn btn-outline-success btn-lg">No, take me back to my profile</a>
    </div>
    <form action="" method="POST">
      <input type="submit" href='../../' name="deactivate" value="Yes, deactivate my account" class="btn btn-outline-danger btn-lg"/>
    </form>
  </div>
  <br>
  <div class="footer">
    © 2021 Copyright: Dunya Oguz, Azman Akhter, John Purcell
  </div>
</body>
</html>
