<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="../../style.css">
    <title>DAJ Recruitment Platform</title>
</head>
<body>
  <nav class="navbar navbar-light bg-light">
    <span class="navbar-brand mb-0 h1">DAJ Recruitment Platform</span>
    <span class="logo-image"><img src="../../logo.png" class="logo"></span>
  </nav>
  <h1>Job Seeker Login</h1>
  <div class="login">
    <form action="" class="login-form" method="POST">
      <input type="hidden" name="user_type" id="user_type" value="Job Seeker">
      <div class="login-form-group">
        <label for="login_name">Login Name:</label><br>
        <input type="text" class="form-control" name="login_name" id="login_name" required>
      </div>
      <div class="login-form-group">
        <label for="password">Password:</label><br>
        <input type="password" class="form-control" name="password" id="password" minlength="8" required>
      </div>
      <a href='#' class="forgot-password">Forgot Password?</a>
      <center><p><button type="submit" class="btn btn-outline-success">Log in</button></p></center>
    </form>
  </div>
  <div class="footer">
    © 2021 Copyright: Dunya Oguz, Azman Akhter, John Purcell
  </div>
</body>
</html>
