<?php
include_once('../../database.php');

$user_id = $_SESSION['userId'];

$usersStmt = $conn->prepare("SELECT * FROM users");
$usersStmt->execute();
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Admin Dashboard</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="../../style.css">
        <link rel="icon" href="../../logo.png" type="penguin">
        <html lang="en">
    </head>
    <body>
      <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
        <span class="navbar-brand mb-0 h1">DAJ Recruitment Platform</span>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
          <div class="navbar-nav">
            <a class="nav-item nav-link active" href="#">Users<span class="sr-only">(current)</span></a>
            <a class="nav-item nav-link" href="systemLogs.php">System Logs</a>
            <a class="nav-item nav-link" href="emails.php">Emails</a>
            <a class="nav-item nav-link" href="../../">Sign Out</a>
          </div>
        </div>
        <span class="logo-image"><img src="../../logo.png" class="logo"></span>
        </div>
      </nav>
      <!-- <h1>Admin Dashboard</h1> -->
      <br>
      <h2>All Users</h2>
      <h6>All job seekers, recruiters and employers who have an account on DAJ Recruitment.</h6>
      <table class="table table-striped">
          <thead>
              <tr>
                  <td>User ID</td>
                  <td>Date Registered</td>
                  <td>User Type</td>
                  <td>Login Name</td>
                  <td>Phone</td>
                  <td>Email</td>
                  <td>Status</td>
                  <td>Actions</td>
              </tr>
          </thead>

          <tbody>
              <?php while ($row = $usersStmt->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) { ?>
                  <tr>
                  <td> <?php echo $row['id']; ?> </td>
                  <td> <?php echo $row['date_registered']; ?> </td>
                  <td> <?php echo $row['user_type']; ?> </td>
                  <td> <?php echo $row['login_name']; ?> </td>
                  <td> <?php echo $row['phone']; ?> </td>
                  <td> <?php echo $row['email']; ?> </td>
                  <td> <?php echo $row['status']; ?> </td>
                  <td>
                    <a href="./activate.php?user_id=<?= $row["id"]?>">Activate</a><br>
                    <a href="./deactivate.php?user_id=<?= $row["id"]?>">Deactivate</a>
                  </td>
                  </tr>
              <?php } ?>
          </tbody>
      </table>
      <br>
      <br>
      <div class="footer">
        © 2021 Copyright: Dunya Oguz, Azman Akhter, John Purcell
      </div>

    </body>
</html>
