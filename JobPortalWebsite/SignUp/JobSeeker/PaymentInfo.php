<?php require_once '/www/groups/r/ri_comp5531_1/COMP5531_final_project/JobPortalWebsite/database.php';
 $account_id = $_SESSION['account_id'];
 print $account_id["id"];

if(isset($_POST["withdrawal_method"])){
  print($_POST["withdrawal_method"]);
}
if(isset($_POST["payment_method_type"])){
  print("<h2>Payment test 2</h2>");
} 
if(isset($_POST["billing_address"])){
  print("<h2>Payment test 3</h2>");
}
if(isset($_POST["postal_code"])){
  print("<h2>Payment test 4</h2>");
} 
if(isset($_POST["card_number"])){
  print("<h2>Payment test 5</h2>");
}
if(isset($_POST["security_code"])){
  print("<h2>Payment test 6</h2>");
} 
if(isset($_POST["expiration_month"])){
  print("<h2>Payment test 7</h2>");
}
if(isset($_POST["expiration_year"])){
  print("<h2>Payment test 8</h2>");
} 
 $payment = $conn->prepare("INSERT INTO ric55311.payment_methods (account_id, payment_method_type,
 billing_address, postal_code, card_number, security_code, expiration_month, expiration_year,
 withdrawal_method)
 VALUES (:account_id, :payment_method_type,
 :billing_address, :postal_code, :card_number, :security_code, :expiration_month, :expiration_year,
 :withdrawal_method);");
 $payment->bindParam(':account_id', $account_id["id"], PDO::PARAM_INT);
 $payment->bindParam(':payment_method_type', $_POST["payment_method_type"]);
 $payment->bindParam(':billing_address', $_POST["billing_address"]);
 $payment->bindParam(':postal_code', $_POST["postal_code"]);
 $card_number = intval($_POST["card_number"]);
 $payment->bindParam(':card_number', $card_number, PDO::PARAM_INT);
 $security_code = intval($_POST["security_code"]);
 $payment->bindParam(':security_code', $security_code, PDO::PARAM_INT);
 $expiration_month = intval($_POST["expiration_month"]);
 $payment->bindParam(':expiration_month', $expiration_month, PDO::PARAM_INT);
 $expiration_year = intval($_POST["expiration_year"]);
 $payment->bindParam(':expiration_year', $expiration_year, PDO::PARAM_INT);
 $payment->bindParam(':withdrawal_method', $_POST["withdrawal_method"]);

 if($payment->execute()){
     print("<h2>Your the payment method for account " . $account_id["id"] . " was successfuly added</h2>");
 }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="../../style.css">
    <title>Job Seeker Sign Up</title>
</head>
<body>
  <nav class="navbar navbar-light bg-light">
    <span class="navbar-brand mb-0 h1">DAJ Recruitment Platform</span>
    <span class="logo-image"><img src="../../logo.png" class="logo"></span>
  </nav>

  <h3>Payment information</h3>
      <h6>Let us know how you'd like to pay for your membership.</h6>
      <p>Are you paying with a credit card or a debit card?</p>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="payment_method_type" id="Credit" value="Credit">
        <label class="form-check-label" for="Credit">Credit Card</label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="payment_method_type" id="Debit" value="Debit">
        <label class="form-check-label" for="Debit">Debit Card</label>
      </div>
      <div class="form-group">
        <label for="card_number">Card Number</label><br>
        <input type="text" class="form-control" name="card_number" id="card_number" placeholder="111122223333"required>
      </div>
      <div class="form-group">
        <label for="security_code">Security Code</label><br>
        <input type="text" class="form-control" name="security_code" id="security_code" placeholder="00111"required>
      </div>
      <div class="form-group">
        <label for="expiration_month">Expiration Month</label><br>
        <input type="text" class="form-control" name="expiration_month" id="expiration_month" placeholder="001"required>
      </div>
      <div class="form-group">
        <label for="expiration_year">Expiration Year</label><br>
        <input type="text" class="form-control" name="expiration_year" id="expiration_year" placeholder="2000"required>
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

