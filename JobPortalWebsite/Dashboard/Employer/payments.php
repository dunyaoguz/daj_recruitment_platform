<?php
include_once('../../database.php');
//session_start();

//Session Variables for Payments
// $account_id = $_SESSION['account_id'];
$account_id = "1";

$cardInfoStmt = $conn->prepare("SELECT id, payment_method_type, card_number, expiration_year, withdrawal_method, is_active FROM payment_methods WHERE account_id = :account_id");
// need to change $account_id["id"] once we change structure
$cardInfoStmt->bindParam(':account_id', $account_id, PDO::PARAM_INT);

$cardInfoStmt->execute();

//setting Session Variable to be used by payment add/delete
$_SESSION['account_id'] = $account_id;
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Payments</title>
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
      <!-- change account_id below to $account_id["id"] when ready for session vars -->
      <h1><?php echo "Account " . $account_id . "'s Payment Types";?></h1>
      <h2>Your Payment Methods</h2>
      <h6>Here is a quick glance of all your saved payment methods</h6>
      <br>
      <table class="table table-striped">
          <thead>
              <tr>
                  <td>Payment Type</td>
                  <td>Card Number</td>
                  <td>Expiration Year</td>
                  <td>Withdrawl Method</td>
                  <td>Primary Payment Option</td>
              </tr>
          </thead>

          <tbody>
              <?php while ($row = $cardInfoStmt->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) { ?>
                  <tr>
                  <td> <?php echo $row['payment_method_type']; ?> </td>
                  <td> <?php echo $row['card_number']; ?> </td>
                  <td> <?php echo $row['expiration_year']; ?> </td>
                  <td> <?php echo $row['withdrawal_method']; ?> </td>
                  <td> <?php echo $row['is_active']; ?> </td>
                  <td>
                  <a href="./EditPaymentMethod.php?payment_id=<?= $row["id"] ?>">Edit</a><br>    
                    <a href="./DeletePaymentMethod.php?payment_id=<?= $row["id"] ?>">Delete</a>
                  </td>
                  </tr>
              <?php } ?>
          </tbody>
      </table>
      <br>
      <center><a href="./AddPaymentMethod.php" class="btn btn-outline-success">Add a New Payment Method</a></center>
      <br>
      <div class="footer">
        © 2021 Copyright: Dunya Oguz, Azman Akhter, John Purcell
      </div>

    </body>
</html>