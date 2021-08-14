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
  <h2>Sign Up</h2>
  <h6>Fill the form below to sign up for a membership.</h6>
  <form action="" method="POST">
      <input type="hidden" name="user_type" id="user_type" value="Job Seeker">
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
        <input type="text" class="form-control" name="phone" id="phone" placeholder="123-123-1111"required>
      </div>
      <div class="form-group">
        <label for="password">Password (minimum 8 characters)</label><br>
        <input type="password" class="form-control" name="password" id="password" minlength="8" required>
      </div>
     <p>Which membership would you like?</p>
     <div class="form-check form-check-inline">
       <input class="form-check-input" type="radio" name="membership_id" id="Prime" value="1">
       <label class="form-check-label" for="Prime">Prime ($50/month, 5 postings/month)</label>
     </div>
     <div class="form-check form-check-inline">
       <input class="form-check-input" type="radio" name="membership_id" id="Gold" value="2">
       <label class="form-check-label" for="Gold">Gold (100$/month, Unlimited postings)</label>
     </div>

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
