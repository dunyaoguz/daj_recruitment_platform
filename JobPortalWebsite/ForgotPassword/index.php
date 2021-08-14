<?php require_once '../database.php';
  // checking if email exists
  $email = $_POST["email"];
  $stmt = $conn->prepare("SELECT password FROM users WHERE email=?;");
  $stmt->execute([$email]);
  $password = $stmt->fetch();
  $headers = 'From: admin@dajrecruitment.com';

  if($password["password"]){
      mail($email,"Your Password to DAJ Recruitment Platform",$password["password"]);
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="../style.css">
    <title>DAJ Recruitment Platform</title>
</head>
<body>
  <nav class="navbar navbar-light bg-light">
    <span class="navbar-brand mb-0 h1">DAJ Recruitment Platform</span>
    <span class="logo-image"><img src="../logo.png" class="logo"></span>
  </nav>
  <h1>Forgot Password?</h1>
  <div class="login">
    <br>
    <form action="" class="login-form" method="POST">
      <div class="login-form-group">
        <label for="email">We'll email you your password if your email exists in our system:</label><br>
        <input type="text" class="form-control" name="email" id="email" required>
      </div>
      <center><p><button type="submit" class="btn btn-outline-success">Send me my password</button></p></center>
    </form>
  </div>

  <br>
  <a href='../' class="register">Home Page</a>
  <div class="footer">
    © 2021 Copyright: Dunya Oguz, Azman Akhter, John Purcell
  </div>
</body>
</html>
