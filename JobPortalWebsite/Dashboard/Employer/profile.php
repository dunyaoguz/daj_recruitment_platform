<?php
include_once('../../database.php');

$user_id = $_SESSION['user_id'];
// $user_id = "2";

$employerInfoStmt = $conn->prepare("SELECT e.*, m.membership_type
                                     FROM employers e
                                     LEFT JOIN memberships m
                                     ON e.membership_id = m.id
                                     WHERE user_id = ?");
$employerInfoStmt->execute([$user_id]);
$employerInfoStmt = $employerInfoStmt->fetch();
$employerId = $employerInfoStmt['id'];
$employeerName = $employerInfoStmt['name'];
$membershipType = $employerInfoStmt['membership_type'];

if ($_POST["membership_change"]) {
  $updateStmt = $conn->prepare("UPDATE employers SET membership_id = :value WHERE id = :id");
  $updateStmt->bindParam(':value', $_POST["membership_change"], PDO::PARAM_INT);
  $updateStmt->bindParam(':id', $employerId, PDO::PARAM_INT);
  $updateStmt->execute();
  Header('Location: '.$_SERVER['PHP_SELF']);
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
            <a class="nav-item nav-link active" href="#">Profile<span class="sr-only">(current)</span></a>
            <a class="nav-item nav-link" href="contactUs.php">Contact Us</a>
            <a class="nav-item nav-link" href="../../">Sign Out</a>
          </div>
        </div>
        <span class="logo-image"><img src="../../logo.png" class="logo"></span>
        </div>
      </nav>
      <h1><?php echo $employeerName . "'s Profile";?></h1>
      <h2>Your Membership</h2>
      <h6>Your current plan and other membership options.</h6>
      <p>Your current plan is: <b><?php echo $membershipType ?></b>.</p>
      <form action="" method="POST">
        <div class="membership-form-group">
          <label for="membership_change">If you wish to change your membership, you can do so below:</label>
          <select class="form-control" name="membership_change" id="membership_change">
            <option value="1">Prime - 50$/month, 5 applications/month</option>
            <option value="2">Gold - 100$/month, unlimited applications</option>
          </select>
          <br>
          <button type="submit" class="btn btn-outline-success">Change Membership</button>
        </div>
      </form>
      <br>
      <h2>Your Payment Methods</h2>
      <!-- <h6>Your current plan and other membership options.</h6> -->
      <br>
      <div class="footer">
        © 2021 Copyright: Dunya Oguz, Azman Akhter, John Purcell
      </div>

    </body>
</html>
