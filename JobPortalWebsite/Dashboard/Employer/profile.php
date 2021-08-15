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

$accountStmt = $conn->prepare("SELECT *
                               FROM accounts
                               WHERE user_id = ?");
$accountStmt->execute([$user_id]);
$accountStmt = $accountStmt->fetch();
$accountId = $accountStmt['id'];

if ($_POST["membership_change"]) {
  $updateStmt = $conn->prepare("UPDATE employers SET membership_id = :value WHERE id = :id");
  $updateStmt->bindParam(':value', $_POST["membership_change"], PDO::PARAM_INT);
  $updateStmt->bindParam(':id', $employerId, PDO::PARAM_INT);
  $updateStmt->execute();
  Header('Location: '.$_SERVER['PHP_SELF']);
}

if ($_POST["amount"]) {
  $updateStmt = $conn->prepare("INSERT INTO transactions (account_id, transaction_type, amount) VALUES
                               (:account_id, 'Payment', :amount)");
  $updateStmt->bindParam(':account_id', $accountId, PDO::PARAM_INT);
  $updateStmt->bindParam(':amount', $_POST["amount"], PDO::PARAM_INT);
  $updateStmt->execute();
  Header('Location: '.$_SERVER['PHP_SELF']);
}

$cardInfoStmt = $conn->prepare("SELECT id,
                                       payment_method_type,
                                       card_number,
                                       expiration_month,
                                       expiration_year,
                                       withdrawal_method,
                                       billing_address,
                                       postal_code,
                                       CASE WHEN is_active = 1 THEN 'Yes' ELSE 'No'
                                       END AS is_active
                                FROM payment_methods
                                WHERE account_id = :account_id");
$cardInfoStmt->bindParam(':account_id', $accountId, PDO::PARAM_INT);
$cardInfoStmt->execute();
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Employer Profile</title>
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
      <!-- Account -->
      <h2>Your Account</h2>
      <!-- <h6>Your current account statement.</h6> -->
      <p>Your balance is: <b><?php echo $accountStmt['balance'] ?>$</b>.</p>

      <?php if($accountStmt['balance'] > 0){?>
        <p> You have an account surplus. You don't need to make a payment until the surplus is spent.</p>
      <?php } ?>
      <?php if($accountStmt['balance'] < 0){?>
        <p style="color:red"> Your have an account deficit. Please make a payment ASAP.</p>
      <?php } ?>

      <form action="" method="POST">
        <div class="make-payment">
          <div class="form-group">
            <label for="amount">To make a manual payment, enter the amount here:</label><br>
            <input type="text" class="form-control" name="amount" id="amount" required>
            <br>
            <button type="submit" class="btn btn-outline-success">Pay</button>
          </div>
        </div>
      </form>

      <!-- Membership -->
      <h2>Your Membership</h2>
      <!-- <h6>Your current plan and other membership options if you want to change.</h6> -->
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
      <!-- Payment Methods -->
      <h2>Your Payment Methods</h2>
      <br>
      <table class="table table-striped">
          <thead>
              <tr>
                  <td>Payment Type</td>
                  <td>Card Number</td>
                  <td>Expiration Month</td>
                  <td>Expiration Year</td>
                  <td>Withdrawal Method</td>
                  <td>Billing Address</td>
                  <td>Postal Code</td>
                  <td>Is Primary Payment Option?</td>
                  <td>Actions</td>
              </tr>
          </thead>

          <tbody>
              <?php while ($row = $cardInfoStmt->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) { ?>
                  <tr>
                  <td> <?php echo $row['payment_method_type']; ?> </td>
                  <td> <?php echo $row['card_number']; ?> </td>
                  <td> <?php echo $row['expiration_month']; ?> </td>
                  <td> <?php echo $row['expiration_year']; ?> </td>
                  <td> <?php echo $row['withdrawal_method']; ?> </td>
                  <td> <?php echo $row['billing_address']; ?> </td>
                  <td> <?php echo $row['postal_code']; ?> </td>
                  <td> <?php echo $row['is_active']; ?> </td>
                  <td>
                    <a href="./editPaymentMethod.php?payment_id=<?= $row["id"] ?>">Edit</a><br>
                    <a href="./deletePaymentMethod.php?payment_id=<?= $row["id"] ?>">Delete</a>
                  </td>
                  </tr>
              <?php } ?>
          </tbody>
      </table>
      <div class="membership-form-group">
        <a href="addPaymentMethod.php" class="btn btn-outline-success">Add a New Payment Method</a>
      </div>
      <br>
      <br>
      <div class="footer">
        © 2021 Copyright: Dunya Oguz, Azman Akhter, John Purcell
      </div>

    </body>
</html>
