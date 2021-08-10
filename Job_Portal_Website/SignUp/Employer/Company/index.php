<?php require_once '../database.php';
//Update this for the new Database Attributes
//Need to make sure email not in use before Query made

//1.Insert user
//2.insert employeee (check credentials)
//3.find the account_id associated with a user

//4.create payment method
if(isset($_POST["membership_type"]) && isset($_POST["payment_method_type"])){
    $payment = $conn->prepare("INSERT INTO ric55311.payment_methods (account_id, payment_method_type,
    billing_address, postal_code, card_number, security_code, expiration_month, expiration_year,
    withdrawal_method)
    VALUES (:account_id, :payment_method_type,
    :billing_address, :postal_code, :card_number, :security_code, :expiration_month, :expiration_year,
    :withdrawal_method);");
    $payment->bindParam(':account_id', $_POST["account_id"]);
    $payment->bindParam(':', $_POST[""]);

    if($payment->execute()){
        header("Location: ./Login");
    }
}   

$statement = $conn->prepare('SELECT * FROM Bookstore.books AS books');
$statement->execute();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company Sign Up</title>
</head>
<body>
<h1>Sign Up</h1>
<!-- Update the Form to match the database -->
    <form action="./Login" method="POST">
        <label for="name">Company</label><br>
        <input type = "text" name="name" id="name" required> <br>
        <label for="login_name">Email (to be used as login)</label><br>
        <input type = "text" name="login_name" id="login_name" required> <br>
        <label for="password">Password (minimum 8 characters)</label><br>
        <input type = "password" name="password" id="password" minlength="8" required> <br>
        <br>
        <br>
        <p>What kind of account would you like?</p>
        <input type="radio" id="Prime" name="membership_type" value="Prime">
        <label for="Prime">Prime ($50 a month/5 monthly postings)</label><br>
        <input type="radio" id="Gold" name="membership_type" value="Gold">
        <label for="Gold">Gold ($100 a month/Unlimited postings)</label><br>
        <br>
        <br>
        <p>Next we will ned some payment info</p>
        <p>Are you using a credit card or debit card?</p>
        <input type="radio" id="Credit" name="payment_method_type" value="Credit">
        <label for="Credit">Credit Card</label><br>
        <input type="radio" id="Debit" name="payment_method_type" value="Debit">
        <label for="Debit">Chequing Account</label><br>
        <br>
        <label for="card_number">Card Number</label><br>
        <input type = "text" card_number="card_number" id="card_number" required> <br>
        <label for="security_code">Security Code</label><br>
        <input type = "text" card_number="security_code" id="security_code" required> <br>
        <label for="expiration_month">Expiration Month (ex: 01=January, 02 =February, etc)</label><br>
        <input type = "text" expiration_month="expiration_month" id="expiration_month" required> <br>
        <label for="expiration_year">Expiration Year (ex: 2020, 2023, etc)</label><br>
        <input type = "text" expiration_month="expiration_year" id="expiration_year" required> <br>
        <label for="billing_address">Billing Address</label><br>
        <input type = "text" name="billing_address" id="billing_address" required> <br>
        <label for="postal_code">Postal Code</label><br>
        <input type = "text" name="postal_code" id="postal_code" required> <br>
        <br>
        <br>
        <p>Would you like your payments made manually or automatically?</p>
        <input type="radio" id="Automatic" name="withdrawal_method" value="Automatic" required>
        <label for="Automatic">Automatic</label><br>
        <input type="radio" id="Debit" name="withdrawal_method" value="Manual" required>
        <label for="Manual">Manual</label><br>



        <button type="submit">Submit</button>
    </form>
    <a href='../Employer'>Back</a>
</body>
</html>