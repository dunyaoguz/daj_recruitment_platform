<?php require_once 'database.php';
  $stmt = $conn->prepare("SELECT * FROM users
                          WHERE user_type=:user_type
                          AND login_name=:login_name
                          AND password=:password;");
  $stmt->bindParam(':user_type', $_POST["user_type"]);
  $stmt->bindParam(':login_name', $_POST["login_name"]);
  $stmt->bindParam(':password', $_POST["password"]);

  $stmt->execute();
  $result = $stmt->fetch();

  $_SESSION['user_id'] = $result['id'];

  if($result["status"]=="Deactivated" or $result["status"]=="Frozen"){
    header("Location:Login/Deactivated.php");
  } elseif($result and $_POST["user_type"]=="Employer"){
    header("Location:Dashboard/Employer/index.php");
  } elseif ($result and $_POST["user_type"]=="Administrator") {
    header("Location:Dashboard/Admin/index.php");
  } elseif ($result and $_POST["user_type"]=="Job Seeker") {
    header("Location:Dashboard/JobSeeker/index.php");
  } elseif ($result and $_POST["user_type"]=="Recruiter") {
    header("Location:Dashboard/Recruiter/index.php");
  }
  // to do: redirect to account doesnt exist page
  // if (!$stmt->execute()) {
  //   header("Location:Login/AccountDoesntExist.php");
  // }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>DAJ Recruitment Platform</title>
    <link rel="icon" href="logo.png" type="penguin">
</head>
<body>
  <nav class="navbar navbar-light bg-light">
    <span class="navbar-brand mb-0 h1">DAJ Recruitment Platform</span>
    <span class="logo-image"><img src="logo.png" class="logo"></span>
  </nav>
  <h1>Login</h1>
  <div class="login">
    <form action="" class="login-form" method="POST">
      <div class="login-form-group">
        <label for="user_type">Select your user type:</label>
        <select class="form-control" name="user_type" id="user_type">
          <option>Administrator</option>
          <option>Employer</option>
          <option>Recruiter</option>
          <option>Job Seeker</option>
        </select>
      </div>
      <div class="login-form-group">
        <label for="login_name">Login Name:</label><br>
        <input type="text" class="form-control" name="login_name" id="login_name" required>
      </div>
      <div class="login-form-group">
        <label for="password">Password:</label><br>
        <input type="password" class="form-control" name="password" id="password" minlength="8" required>
      </div>
      <a href='Login/forgotPassword.php' class="forgot-password">Forgot Password?</a>
      <center><p><button type="submit" class="btn btn-outline-success">Log in</button></p></center>
    </form>
  </div>
  <br>
  <a href='./SignUp/' class="register">Are you a new user? Register here</a>
  <div class="footer">
    © 2021 Copyright: Dunya Oguz, Azman Akhter, John Purcell
  </div>
</body>
</html>
