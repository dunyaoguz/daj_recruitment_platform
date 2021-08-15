<?php
include_once('../../database.php');

$user_id = $_SESSION['user_id'];
// $user_id = "8";

$jobSeekerInfoStmt = $conn->prepare("SELECT j.*, m.membership_type
                                     FROM job_seekers j
                                     LEFT JOIN memberships m
                                     ON j.membership_id = m.id
                                     WHERE user_id = ?");
$jobSeekerInfoStmt->execute([$user_id]);
$jobSeekerInfoStmt = $jobSeekerInfoStmt->fetch();
$jobSeekerId = $jobSeekerInfoStmt['id'];
$jobSeekerName = $jobSeekerInfoStmt['first_name'];
$membershipType = $jobSeekerInfoStmt['membership_type'];

if ($_POST["first_name"]) {
  $updateStmt = $conn->prepare("UPDATE job_seekers SET first_name = :value WHERE id = :id");
  $updateStmt->bindParam(':value', $_POST["first_name"]);
  $updateStmt->bindParam(':id', $jobSeekerId, PDO::PARAM_INT);
  $updateStmt->execute();
  Header('Location: '.$_SERVER['PHP_SELF']);
}

if ($_POST["last_name"]) {
  $updateStmt = $conn->prepare("UPDATE job_seekers SET last_name = :value WHERE id = :id");
  $updateStmt->bindParam(':value', $_POST["last_name"]);
  $updateStmt->bindParam(':id', $jobSeekerId, PDO::PARAM_INT);
  $updateStmt->execute();
  Header('Location: '.$_SERVER['PHP_SELF']);
}

if ($_POST["current_title"]) {
  $updateStmt = $conn->prepare("UPDATE job_seekers SET current_title = :value WHERE id = :id");
  $updateStmt->bindParam(':value', $_POST["current_title"]);
  $updateStmt->bindParam(':id', $jobSeekerId, PDO::PARAM_INT);
  $updateStmt->execute();
  Header('Location: '.$_SERVER['PHP_SELF']);
}

if ($_POST["years_of_experience"]) {
  $updateStmt = $conn->prepare("UPDATE job_seekers SET years_of_experience = :value WHERE id = :id");
  $updateStmt->bindParam(':value', $_POST["years_of_experience"], PDO::PARAM_INT);
  $updateStmt->bindParam(':id', $jobSeekerId, PDO::PARAM_INT);
  $updateStmt->execute();
  Header('Location: '.$_SERVER['PHP_SELF']);
}

if ($_POST["city"]) {
  $updateStmt = $conn->prepare("UPDATE job_seekers SET city = :value WHERE id = :id");
  $updateStmt->bindParam(':value', $_POST["city"]);
  $updateStmt->bindParam(':id', $jobSeekerId, PDO::PARAM_INT);
  $updateStmt->execute();
  Header('Location: '.$_SERVER['PHP_SELF']);
}

if ($_POST["province"]) {
  $updateStmt = $conn->prepare("UPDATE job_seekers SET province = :value WHERE id = :id");
  $updateStmt->bindParam(':value', $_POST["province"]);
  $updateStmt->bindParam(':id', $jobSeekerId, PDO::PARAM_INT);
  $updateStmt->execute();
  Header('Location: '.$_SERVER['PHP_SELF']);
}

if ($_POST["country"]) {
  $updateStmt = $conn->prepare("UPDATE job_seekers SET country = :value WHERE id = :id");
  $updateStmt->bindParam(':value', $_POST["country"]);
  $updateStmt->bindParam(':id', $jobSeekerId, PDO::PARAM_INT);
  $updateStmt->execute();
  Header('Location: '.$_SERVER['PHP_SELF']);
}

if ($_POST["membership_change"]) {
  $updateStmt = $conn->prepare("UPDATE job_seekers SET membership_id = :value WHERE id = :id");
  $updateStmt->bindParam(':value', $_POST["membership_change"], PDO::PARAM_INT);
  $updateStmt->bindParam(':id', $jobSeekerId, PDO::PARAM_INT);
  $updateStmt->execute();
  Header('Location: '.$_SERVER['PHP_SELF']);
}

$accountStmt = $conn->prepare("SELECT *
                               FROM accounts
                               WHERE user_id = ?");
$accountStmt->execute([$user_id]);
$accountStmt = $accountStmt->fetch();
$accountId = $accountStmt['id'];

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
      <h1><?php echo $jobSeekerName . "'s Profile";?></h1>
      <h2>Your Personal Details</h2>
      <!-- <h6>This is the information you entered about yourself.</h6> -->
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
                <td>First Name</td>
                <td><?php echo $jobSeekerInfoStmt['first_name']; ?></td>
                <td>
                  <form action="" method="POST">
                    <div class="jobseeker-profile-form">
                        <div>
                        <input type="text" class="form-control" name="first_name" id="first_name" required>
                        </div>
                        <button type="submit" class="btn btn-outline-success">Update</button>
                  </form>
                </td>
              </tr>
              <tr>
                <td>Last Name</td>
                <td><?php echo $jobSeekerInfoStmt['last_name']; ?></td>
                <td>
                  <form action="" method="POST">
                    <div class="jobseeker-profile-form">
                        <div>
                        <input type="text" class="form-control" name="last_name" id="last_name" required>
                        </div>
                        <button type="submit" class="btn btn-outline-success">Update</button>
                  </form>
                </td>
              </tr>
              <tr>
                <td>Current Title</td>
                <td><?php echo $jobSeekerInfoStmt['current_title']; ?></td>
                <td>
                  <form action="" method="POST">
                    <div class="jobseeker-profile-form">
                        <div>
                        <input type="text" class="form-control" name="current_title" id="current_title" required>
                        </div>
                        <button type="submit" class="btn btn-outline-success">Update</button>
                  </form>
                </td>
              </tr>
              <tr>
                <td>Years of Experience</td>
                <td><?php echo $jobSeekerInfoStmt['years_of_experience']; ?></td>
                <td>
                  <form action="" method="POST">
                    <div class="jobseeker-profile-form">
                        <div>
                        <input type="text" class="form-control" name="years_of_experience" id="years_of_experience" required>
                        </div>
                        <button type="submit" class="btn btn-outline-success">Update</button>
                  </form>
                </td>
              </tr>
              <tr>
                <td>City</td>
                <td><?php echo $jobSeekerInfoStmt['city']; ?></td>
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
                <td><?php echo $jobSeekerInfoStmt['province']; ?></td>
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
                <td><?php echo $jobSeekerInfoStmt['country']; ?></td>
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
          </tbody>
      </table>

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
      <!-- <h6>Your current plan and other membership options.</h6> -->
      <p>Your current plan is: <b><?php echo $membershipType ?></b>.</p>
      <form action="" method="POST">
        <div class="membership-form-group">
          <label for="membership_change">If you wish to change your membership, you can do so below:</label>
          <select class="form-control" name="membership_change" id="membership_change">
            <option value="3">Basic - 0$, view only</option>
            <option value="4">Prime - 10$/month, 5 applications/month</option>
            <option value="5">Gold - 20$/month, unlimited applications</option>
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

      <center><a href="./delete.php" class="btn btn-danger">Deactivate Profile</a></center>
      <br>
      <br>
      <div class="footer">
        © 2021 Copyright: Dunya Oguz, Azman Akhter, John Purcell
      </div>

    </body>
</html>
