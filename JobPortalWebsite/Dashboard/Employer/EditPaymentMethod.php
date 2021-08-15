<?php
include_once('../../database.php');

$payment_id = $_SESSION['payment_id'];

$cardInfoStmt = $conn->prepare("SELECT id, payment_method_type,
billing_address, postal_code, card_number, security_code, expiration_month, expiration_year,
withdrawal_method, is_active  
                                        FROM payment_methods 
                                        WHERE id = :payment_id");

$cardInfoStmt->bindParam(':payment_id', $_GET["payment_id"], PDO::PARAM_INT);
$cardInfoStmt->execute();
$cardInfo = $cardInfoStmt->fetch(PDO::FETCH_ASSOC);
$payment_id = $cardInfo['id'];
$payment_method_type = $cardInfo['payment_method_type'];
$billing_address = $cardInfo['billing_address'];
$postal_code = $cardInfo['postal_code'];
$card_number = $cardInfo['card_number'];
$security_code = $cardInfo['security_code'];
$expiration_month = $cardInfo['expiration_month'];
$expiration_year = $cardInfo['expiration_year'];
$withdrawal_method = $cardInfo['withdrawal_method'];
$is_active = $cardInfo['is_active'];

$_SESSION['payment_id'] = $_GET["payment_id"];

if ($_POST["payment_method_type"]) {
  $updateStmt = $conn->prepare("UPDATE payment_methods SET payment_method_type = :value WHERE  id= :id");
  $updateStmt->bindParam(':value', $_POST["payment_method_type"]);
  $updateStmt->bindParam(':id', $payment_id, PDO::PARAM_INT);
  $updateStmt->execute();
  Header('Location: '.$_SERVER['PHP_SELF'].'?payment_id='.$_GET["payment_id"]);
}

if ($_POST["billing_address"]) {
  $updateStmt = $conn->prepare("UPDATE payment_methods SET billing_address = :value WHERE  id= :id");
  $updateStmt->bindParam(':value', $_POST["billing_address"]);
  $updateStmt->bindParam(':id', $payment_id, PDO::PARAM_INT);
  $updateStmt->execute();
  Header('Location: '.$_SERVER['PHP_SELF'].'?payment_id='.$_GET["payment_id"]);
}
if ($_POST["card_number"]) {
  $updateStmt = $conn->prepare("UPDATE payment_methods SET card_number = :value WHERE  id= :id");
  $updateStmt->bindParam(':value', $_POST["card_number"], PDO::PARAM_INT);
  $updateStmt->bindParam(':id', $payment_id, PDO::PARAM_INT);
  $updateStmt->execute();
  Header('Location: '.$_SERVER['PHP_SELF'].'?payment_id='.$_GET["payment_id"]);
}
if ($_POST["security_code"]) {
  $updateStmt = $conn->prepare("UPDATE payment_methods SET security_code = :value WHERE  id= :id");
  $updateStmt->bindParam(':value', $_POST["security_code"], PDO::PARAM_INT);
  $updateStmt->bindParam(':id', $payment_id, PDO::PARAM_INT);
  $updateStmt->execute();
  Header('Location: '.$_SERVER['PHP_SELF'].'?payment_id='.$_GET["payment_id"]);
}
if ($_POST["expiration_month"]) {
  $updateStmt = $conn->prepare("UPDATE payment_methods SET expiration_month = :value WHERE  id= :id");
  $updateStmt->bindParam(':value', $_POST["expiration_month"], PDO::PARAM_INT);
  $updateStmt->bindParam(':id', $payment_id, PDO::PARAM_INT);
  $updateStmt->execute();
  Header('Location: '.$_SERVER['PHP_SELF'].'?payment_id='.$_GET["payment_id"]);
}

if ($_POST["expiration_year"]) {
  $updateStmt = $conn->prepare("UPDATE payment_methods SET expiration_year = :value WHERE  id= :id");
  $updateStmt->bindParam(':value', $_POST["expiration_year"], PDO::PARAM_INT);
  $updateStmt->bindParam(':id', $payment_id, PDO::PARAM_INT);
  $updateStmt->execute();
  Header('Location: '.$_SERVER['PHP_SELF'].'?payment_id='.$_GET["payment_id"]);
}
if ($_POST["withdrawal_method"]) {
  $updateStmt = $conn->prepare("UPDATE payment_methods SET withdrawal_method = :value WHERE  id= :id");
  $updateStmt->bindParam(':value', $_POST["withdrawal_method"]);
  $updateStmt->bindParam(':id', $payment_id, PDO::PARAM_INT);
  $updateStmt->execute();
  Header('Location: '.$_SERVER['PHP_SELF'].'?payment_id='.$_GET["payment_id"]);
}
if ($_POST["is_active"]) {
  if($_POST["is_active"]=="Yes") {
    $is_remote_eligible = 1;
  }else{
    $is_remote_eligible = 0;
  }
  $updateStmt = $conn->prepare("UPDATE payment_methods SET is_active = :value WHERE  id= :id");
  $updateStmt->bindParam(':value', $_POST["is_active"], PDO::PARAM_INT);
  $updateStmt->bindParam(':id', $payment_id, PDO::PARAM_INT);
  $updateStmt->execute();
  Header('Location: '.$_SERVER['PHP_SELF'].'?payment_id='.$_GET["payment_id"]);
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

      <!-- <style>
           input[type="radio"] {
              float: left;
            } 
      </style> -->
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
          </div>
        </div>
        <span class="logo-image"><img src="../../logo.png" class="logo"></span>
        </div>
      </nav>
      <h2>Edit Payment Method</h2>
      <h6>Update any attributes of the payment method you'd like to change</h6>
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
                <td>Payment Type (Debit/Credit)</td>
                <td><?php echo $cardInfo['payment_method_type']; ?></td>
                <td>
                  <form action="" method="POST">
                    <div class="jobseeker-profile-form">
                        <div>
                        <input type="text" class="form-control" name="payment_method_type" id="payment_method_type">
                    
                        </div>
                        <button type="submit" class="btn btn-outline-success">Update</button>
                  </form>
                </td>
              </tr>
              <tr>
                <td>Billing Address</td>
                <td><?php echo $cardInfo['billing_address']; ?></td>
                <td>
                  <form action="" method="POST">
                    <div class="jobseeker-profile-form">
                        <div>
                        <input type="text" class="form-control" name="billing_address" id="billing_address">
                        </div>
                        <button type="submit" class="btn btn-outline-success">Update</button>
                  </form>
                </td>
              </tr>
              <tr>
                <td>Postal Code</td>
                <td><?php echo $cardInfo['postal_code']; ?></td>
                <td>
                  <form action="" method="POST">
                    <div class="jobseeker-profile-form">
                        <div>
                        <input type="text" class="form-control" name="postal_code" id="postal_code">
                        </div>
                        <button type="submit" class="btn btn-outline-success">Update</button>
                  </form>
                </td>
              </tr>
              <tr>
                <td>Card Number</td>
                <td><?php echo $cardInfo['card_number']; ?></td>
                <td>
                  <form action="" method="POST">
                    <div class="jobseeker-profile-form">
                        <div>
                        <input type="text" class="form-control" name="card_number" id="card_number">
                        </div>
                        <button type="submit" class="btn btn-outline-success">Update</button>
                  </form>
                </td>
              </tr>
              <tr>
                <td>Security Code</td>
                <td><?php echo $cardInfo['security_code']; ?></td>
                <td>
                  <form action="" method="POST">
                    <div class="jobseeker-profile-form">
                        <div>
                        <input type="text" class="form-control" name="security_code" id="security_code" required>
                        </div>
                        <button type="submit" class="btn btn-outline-success">Update</button>
                  </form>
                </td>
              </tr>
              <tr>
                <td>Expiration Month</td>
                <td><?php echo $cardInfo['expiration_month']; ?></td>
                <td>
                  <form action="" method="POST">
                    <div class="jobseeker-profile-form">
                        <div>
                        <input type="text" class="form-control" name="expiration_month" id="expiration_month" required>
                        </div>
                        <button type="submit" class="btn btn-outline-success">Update</button>
                  </form>
                </td>
              </tr>
              <tr>
                <td>Expiration Year</td>
                <td><?php echo $cardInfo['expiration_year']; ?></td>
                <td>
                  <form action="" method="POST">
                    <div class="jobseeker-profile-form">
                        <div>
                        <input type="text" class="form-control" name="expiration_year" id="expiration_year" required>
                        </div>
                        <button type="submit" class="btn btn-outline-success">Update</button>
                  </form>
                </td>
              </tr>
              <tr>
        
                <td>Withdrawl Method (Manual/Automatic)</td>
                <td><?php echo $cardInfo['withdrawal_method']; ?></td>
                <td>
                  <form action="" method="POST">
                    <div class="jobseeker-profile-form">
                    <div>
                        <input type="text" class="form-control" name="withdrawal_method" id="withdrawal_method">
                        
                    </div>
                        <button type="submit" class="btn btn-outline-success">Update</button>
                  </form>
                </td>
              </tr>
              <tr>
              <td>Is Primary Account? (Yes/No)</td>
                <td><?php echo $cardInfo['is_active']; ?></td>
                <td>
                  <form action="" method="POST">
                    <div class="jobseeker-profile-form">
                        <div>
                        <input type="text" class="form-control" name="is_active" id="is_active">
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
