<?php require_once '../../database.php';
// Update this for the new Database Attributes
// Need to make sure email not in use before Query made

  // 1.Insert user
  $user = $conn->prepare("INSERT INTO ric55311.users (user_type, login_name,
  password, phone, email) VALUES (:user_type, :login_name, :password , :phone, :email)
  ;");
  $user->bindParam(':user_type', $_POST["user_type"]);
  $user->bindParam(':login_name', $_POST["login_name"]);
  $user->bindParam(':password', $_POST["password"]);
  $user->bindParam(':phone', $_POST["phone"]);
  $user->bindParam(':email', $_POST["email"]);

  // checking if email already exists
  $email = $_POST["email"];
  $stmt = $conn->prepare("SELECT * FROM ric55311.users WHERE email=?;");
  $stmt->execute([$email]);
  $check = $stmt->fetch();
  if ($check) {
      header("Location: ../FailureMessage.php");
      exit();
  }
  //checking if phone already exists
  $phone = $_POST["phone"];
  $stmt2 = $conn->prepare("SELECT * FROM users WHERE phone=?;");
  $stmt2->execute([$phone]);
  $check2 = $stmt2->fetch();
  if ($check2) {
    header("Location: ../FailureMessage.php");
      exit();
  }
  //checking if login already exists
  $login_name = $_POST["login_name"];
  $stmt3 = $conn->prepare("SELECT * FROM users WHERE login_name=?;");
  $stmt3->execute([$login_name]);
  $check3 = $stmt3->fetch();
  if ($check3) {
    header("Location: ../FailureMessage.php");
    exit();
  }

  if($user->execute()){
      // print ("<h2>User creation successful</h2>");
  }

  // 2.Insert Job Seeker
  $job_seeker = $conn->prepare("INSERT INTO ric55311.job_seekers (user_id, membership_id,
  first_name, last_name, city, province, country, current_title, years_of_experience) VALUES (:user_id, :membership_id,
  :first_name, :last_name, :city, :province, :country, :current_title, :years_of_experience);");
  $query = $conn->prepare("SELECT id FROM ric55311.users WHERE email=:email;");
  $query->bindParam(":email",$email);
  $query->execute();
  $user_id=$query->fetch();
  $job_seeker->bindParam(':user_id', $user_id["id"], PDO::PARAM_INT);
  $job_seeker->bindParam(':membership_id', $_POST["membership_id"], PDO::PARAM_INT);
  $job_seeker->bindParam(':first_name', $_POST["first_name"]);
  $job_seeker->bindParam(':last_name', $_POST["last_name"]);
  $job_seeker->bindParam(':city', $_POST["city"]);
  $job_seeker->bindParam(':province', $_POST["province"]);
  $job_seeker->bindParam(':country', $_POST["country"]);
  $job_seeker->bindParam(':current_title', $_POST["current_title"]);
  $job_seeker->bindParam(':years_of_experience', $_POST["years_of_experience"], PDO::PARAM_INT);

    if($job_seeker->execute()){
      // print ("<h2>Job Seeker creation successful</h2>");
    }

    //job_seeker ID for Education Page
    $job_id_query = $conn->prepare("SELECT id FROM ric55311.job_seekers WHERE user_id=:user_id;");
    $job_id_query->bindParam(":user_id",$user_id["id"]);
    $job_id_query->execute();
    $job_seeker_id=$job_id_query->fetch();
    //On Education Page
    $_SESSION['job_seeker_id'] = $job_seeker_id;

  //accountId for payment methods Page
  $query2 = $conn->prepare("SELECT id FROM ric55311.accounts WHERE user_id=:user_id;");
  $query2->bindParam(":user_id",$user_id["id"]);
  $query2->execute();
  $account_id=$query2->fetch();
  $_SESSION['account_id'] = $account_id;

  $membership_id =  $_POST["membership_id"];
  //print $membership_id;
  //page redirection    
  if($membership_id > 3){
    //payment page redirect
    header("Location: PaymentInfo.php");
  }
  if($membership_id < 4 && $membership_id != 0){
    //payment page redirect
    header("Location: EducationHistory.php");
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="../../style.css">
    <link rel="icon" href="../../logo.png" type="penguin">
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
        <label for="first_name">First Name</label><br>
        <input type="text" class="form-control" name="first_name" id="first_name" required>
      </div>
      <div class="form-group">
        <label for="last_name">Last Name</label><br>
        <input type="text" class="form-control" name="last_name" id="last_name" required>
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
        <label for="country">Country</label><br>
        <input type="text" class="form-control" name="country" id="country" required>
      </div>
      <div class="form-group">
        <label for="province">Province/State</label><br>
        <input type="text" class="form-control" name="province" id="province" required>
      </div>
      <div class="form-group">
        <label for="city">City</label><br>
        <input type="text" class="form-control" name="city" id="city" required>
      </div>
      <div class="form-group">
        <label for="password">Password (minimum 8 characters)</label><br>
        <input type="password" class="form-control" name="password" id="password" minlength="8" required>
      </div>
      <div class="form-group">
        <label for="current_title">Current Title</label><br>
        <input type="text" class="form-control" name="current_title" id="current_title" required>
      </div>
      <div class="form-group">
        <label for="years_of_experience">Years of Work Experience</label><br>
        <input type="number" class="form-control" name="years_of_experience" id="years_of_experience" required>
      </div>
      
     <p>Which membership would you like?</p>
     <div class="form-check form-check-inline">
       <input class="form-check-input" type="radio" name="membership_id" id="Basic" value="3">
       <label class="form-check-label" for="Prime">Prime (Free, View Only)</label>
     </div>
     <div class="form-check form-check-inline">
       <input class="form-check-input" type="radio" name="membership_id" id="Prime" value="4">
       <label class="form-check-label" for="Prime">Prime ($10/month, 5 applications/month)</label>
     </div>
     <div class="form-check form-check-inline">
       <input class="form-check-input" type="radio" name="membership_id" id="Gold" value="5">
       <label class="form-check-label" for="Gold">Gold (20$/month, unlimited applications)</label>
     </div>

      <p><button type="submit" class="btn btn-outline-success">Submit</button></p>
      <br>
    </form>

  <div class="footer">
    © 2021 Copyright: Dunya Oguz, Azman Akhter, John Purcell
  </div>
</body>
</html>
