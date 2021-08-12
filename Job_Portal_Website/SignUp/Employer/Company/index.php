<?php require_once '/nfs/groups/r/ri_comp5531_1/COMP5531_final_project/Job_Portal_Website/database.php';
//Update this for the new Database Attributes
//Need to make sure email not in use before Query made

//1.Insert user
if(isset($_POST["user_type"]) && isset($_POST["login_name"])&& isset($_POST["password"])&& isset($_POST["phone"])&& isset($_POST["email"]) ){
$user = $conn->prepare("INSERT INTO ric55311.users (user_type, login_name,
password, phone, email) VALUES (:user_type, :login_name, :password , :phone, :email);");
    $user->bindParam(':user_type', $_POST["user_type"]);
    $user->bindParam(':login_name', $_POST["login_name"]);
    $user->bindParam(':password', $_POST["password"]);
    $user->bindParam(':phone', $_POST["phone"]);
    $user->bindParam(':email', $_POST["email"]);

    //checking if email already exists
    $email = ':email';
    $stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
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
}
// //2.insert employeee (check credentials)
// //need to get the userID and resulting membership_ID so we can enter the Employer
$employer = $conn->prepare("INSERT INTO ric55311.employers (user_id,
name, membership_id) VALUES (:user_id, :name, :membership_id);");
    $user_id = $conn->prepare("SELECT id FROM users WHERE email=:email");
    $employer->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $employer->bindParam(':name', $_POST["name"]);
    $employer->bindParam(':membership_id', $_POST["membership_id"], PDO::PARAM_INT);

    if($employer->execute()){
        print("<h2>Employer Creation Successful</h2>");
    }

// //3.create payment method
// if(isset($_POST["membership_type"]) && isset($_POST["payment_method_type"])){
//     $payment = $conn->prepare("INSERT INTO ric55311.payment_methods (account_id, payment_method_type,
//     billing_address, postal_code, card_number, security_code, expiration_month, expiration_year,
//     withdrawal_method)
//     VALUES (:account_id, :payment_method_type,
//     :billing_address, :postal_code, :card_number, :security_code, :expiration_month, :expiration_year,
//     :withdrawal_method);");
//     $account_id = $pdo->prepare("SELECT id FROM accounts WHERE user_id=:user_id");
//     $payment->bindParam(':account_id', $account_id);
//     $payment->bindParam(':payment_method_type', $_POST["payment_method_type"]);
//     $payment->bindParam(':billing_address', $_POST["billing_address"]);
//     $payment->bindParam(':postal_code', $_POST["postal_code"]);
//     $payment->bindParam(':card_number', $_POST["card_number"]);
//     $payment->bindParam(':security_code', $_POST["security_code"]);
//     $payment->bindParam(':expiration_month', $_POST["expiration_month"]);
//     $payment->bindParam(':expiration_year', $_POST["expiration_year"]);
//     $payment->bindParam(':withdrawal_method', $_POST["withdrawal_method"]);
//
//     if($payment->execute()){
//         print("<h2>Your the mayment method for account " . $account_id . " was successfuly added</h2>");
//         header("Location: ./Login");
//     }
// }

// $statement = $conn->prepare('SELECT * FROM Bookstore.books AS books');
// $statement->execute();
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
    <form action="" method="POST">
        <label for="name">Company</label><br>
        <input type = "text" name="name" id="name" required> <br>
        <label for="email">Email</label><br>
        <input type = "text" name="email" id="email" required> <br>
        <label for="login_name">Login Name</label><br>
        <input type = "text" name="login_name" id="login_name" required> <br>
        <label for="phone">Phone Number</label><br>
        <input type = "text" name="phone" id="phone" required> <br>
        <label for="password">Password (minimum 8 characters)</label><br>
        <input type="hidden" name="user_type" id="user_type" value="Employer">
        <input type = "password" name="password" id="password" minlength="8" required> <br>
        <br>
        <br>
        <p>What kind of account would you like?</p>
        <!-- //Update these numeric values to match the table -->
        <input type="radio" id="Prime" name="membership_id" value="1">
        <label for="Prime">Prime ($50 a month/5 monthly postings)</label><br>
        <input type="radio" id="Gold" name="membership_id" value="2">
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
