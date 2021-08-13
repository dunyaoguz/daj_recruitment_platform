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
  <h1>Administrator Login</h1>
  <form action="" method="POST">
    <input type="hidden" name="user_type" id="user_type" value="Administrator">
    <div class="form-group">
      <label for="login_name">Login Name:</label><br>
      <input type="text" class="form-control" name="login_name" id="login_name" required>
    </div>
    <div class="form-group">
      <label for="password">Password:</label><br>
      <input type="password" class="form-control" name="password" id="password" minlength="8" required>
    </div>
    <p><button type="submit" class="btn btn-outline-success">Submit</button></p>
  </form>
  <div class="footer">
    © 2021 Copyright: Dunya Oguz, Azman Akhter, John Purcell
  </div>
</body>
</html>
