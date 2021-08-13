<!-- <?php require_once '/nfs/groups/r/ri_comp5531_1/COMP5531_final_project/Job_Portal_Website/database.php';
//Update this for the new Database Attributes
//Need to make sure email not in use before Query made

//1.Insert user
if(isset($_POST["user_type"])){
  print("<h2>Test 1</h2>");
};
if (isset($_POST["login_name"])){
  print("<h2>Test 2.</h2>");
};
if ( isset($_POST["password"])){
  print("<h2>Test 3.</h2>");
};
if ( isset($_POST["phone"])){
  print("<h2>Test 4</h2>");
};
if (isset($_POST["email"])){
print("<h2>Test 5</h2>");
};
$user = $conn->prepare("INSERT INTO ric55311.users (user_type, login_name,
password, phone, email) VALUES (:user_type, :login_name, :password , :phone, :email);");
    $user->bindParam(':user_type', $_POST["user_type"]);
    $user->bindParam(':login_name', $_POST["login_name"]);
    $user->bindParam(':password', $_POST["password"]);
    $user->bindParam(':phone', $_POST["phone"]);
    $user->bindParam(':email', $_POST["email"]);

    //checking if email already exists
    $email = $_POST["email"];
    $stmt = $conn->prepare("SELECT * FROM ric55311.users WHERE email=?;");
    $stmt->execute([$email]);
    $check = $stmt->fetch();
    if ($check) {
      //Need to fix the logic with what happens when email in use
        print("<h2>You already have an active account. Please login.</h2>");
        header("Location: /nfs/groups/r/ri_comp5531_1/COMP5531_final_project/Job_Portal_Website/Login");
        exit();
    }
    if($user->execute()){
        print ("<h2>User creation successful</h2>");
    }

// //2.insert employeee (check credentials)
// //need to get the userID and resulting membership_ID so we can enter the Employer
$employer = $conn->prepare("INSERT INTO ric55311.employers (user_id,
name, membership_id) VALUES (:user_id, :name, :membership_id);");

    $query = $conn->prepare("SELECT id FROM ric55311.users WHERE email=?;");
    $query->execute([$email]);
    $user_id = $query->fetch();
    $employer->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $employer->bindParam(':name', $_POST["name"]);
    $employer->bindParam(':membership_id', $_POST["membership_id"], PDO::PARAM_INT);

    if($employer->execute()){
        print("<h2>Employer Creation Successful</h2>");
    }

// //3.create payment method
if(isset($_POST["membership_type"]) && isset($_POST["payment_method_type"])){
print("<h2>Payment checker</h2>");
}
    $payment = $conn->prepare("INSERT INTO ric55311.payment_methods (account_id, payment_method_type,
    billing_address, postal_code, card_number, security_code, expiration_month, expiration_year,
    withdrawal_method)
    VALUES (:account_id, :payment_method_type,
    :billing_address, :postal_code, :card_number, :security_code, :expiration_month, :expiration_year,
    :withdrawal_method);");
    $account_id = $conn->prepare("SELECT id FROM ric55311.accounts WHERE user_id=:user_id;");
    $account_id->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $payment->bindParam(':account_id', $account_id, PDO::PARAM_INT);
    $payment->bindParam(':payment_method_type', $_POST["payment_method_type"]);
    $payment->bindParam(':billing_address', $_POST["billing_address"]);
    $payment->bindParam(':postal_code', $_POST["postal_code"]);
    $payment->bindParam(':card_number', $_POST["card_number"]);
    $payment->bindParam(':security_code', $_POST["security_code"]);
    $payment->bindParam(':expiration_month', $_POST["expiration_month"]);
    $payment->bindParam(':expiration_year', $_POST["expiration_year"]);
    $payment->bindParam(':withdrawal_method', $_POST["withdrawal_method"]);

    if($payment->execute()){
        print("<h2>Your the mayment method for account " . $account_id . " was successfuly added</h2>");
    }


// $statement = $conn->prepare('SELECT * FROM Bookstore.books AS books');
// $statement->execute();
?> -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="/../../../style.css">
    <title>Employer Sign Up</title>
</head>
<body>
  <nav class="navbar navbar-light bg-light">
    <span class="navbar-brand mb-0 h1">DAJ Recruitment Platform</span>
    <span class="logo-image"><img src="/../../../logo.png" class="logo"></span>
  </nav>
  <h2>Sign Up</h2>
  <h6>Fill the form below to sign up for a membership.</h6>
<!-- Update the Form to match the database -->
  <form action="" method="POST">
      <div class="form-group">
        <label for="name">Company</label><br>
        <input type="text" class="form-control" name="name" id="name" required>
      </div>
      <div class="form-group">
        <label for="email">Email</label><br>
        <input type="text" class="form-control" name="email" id="email" required>
      </div>
      <div class="form-group">
        <label for="login_name">Login Name</label><br>
        <input type="text" class="form-control" name="login_name" id="login_name" required>
      </div>
      <div class="form-group">
        <label for="phone">Phone Number</label><br>
        <input type="text" class="form-control" name="phone" id="phone" required>
      </div>
      <div class="form-group">
        <label for="password">Password (minimum 8 characters)</label><br>
        <input type="password" class="form-control" name="password" id="password" minlength="8" required>
      </div>
      <!-- <div class="form-group">
        <label for="membership">Which membership would you like?</label>
        <select class="form-control" id="membership">
          <option id="prime">Prime ($50 a month, comes with 5 monthly postings)</option>
          <option id="gold">Gold ($100 a month, comes with unlimited postings)</option>
       </select>
     </div> -->
     <p>Which membership would you like?</p>
     <div class="form-check form-check-inline">
       <input class="form-check-input" type="radio" name="membership" id="Prime" value="Prime">
       <label class="form-check-label" for="Prime">Prime ($50/month, 5 postings/month)</label>
     </div>
     <div class="form-check form-check-inline">
       <input class="form-check-input" type="radio" name="membership" id="Gold" value="Gold">
       <label class="form-check-label" for="Gold">Gold (100$/month, Unlimited postings)</label>
     </div>

      <h3>Payment information</h3>
      <h6>Let us know how you'd like to pay for your membership.</h6>

      <p>Are you paying with a credit card or a debit card?</p>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="payment" id="Credit" value="Credit">
        <label class="form-check-label" for="Credit">Credit Card</label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="payment" id="Debit" value="Debit">
        <label class="form-check-label" for="Debit">Debit Card</label>
      </div>
      <div class="form-group">
        <label for="card_number">Card Number</label><br>
        <input type="text" class="form-control" card_number="card_number" id="card_number" required>
      </div>
      <div class="form-group">
        <label for="security_code">Security Code</label><br>
        <input type="text" class="form-control" card_number="security_code" id="security_code" required>
      </div>
      <div class="form-group">
        <label for="expiration_month">Expiration Month</label><br>
        <input type="text" class="form-control" expiration_month="expiration_month" id="expiration_month" required>
      </div>
      <div class="form-group">
        <label for="expiration_year">Expiration Year</label><br>
        <input type="text" class="form-control" expiration_month="expiration_year" id="expiration_year" required>
      </div>
      <div class="form-group">
        <label for="billing_address">Billing Address</label><br>
        <input type="text" class="form-control" name="billing_address" id="billing_address" required>
      </div>
      <div class="form-group">
        <label for="postal_code">Postal Code</label><br>
        <input type = "text" class="form-control" name="postal_code" id="postal_code" required>
      </div>
      <p>Would you like your payments made manually or automatically?</p>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="withdrawal_method" value="Automatic" required>
        <label class="form-check-label" for="Automatic">Automatic</label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="withdrawal_method" value="Manual" required>
        <label class="form-check-label" for="Manual">Manual</label>
      </div>

      <p><button type="submit" class="btn btn-outline-success">Submit</button></p>
      <br>
    </form>

    <div class="footer">
      © 2021 Copyright: Dunya Oguz, Azman Akhter, John Purcell
    </div>
</body>
</html>
