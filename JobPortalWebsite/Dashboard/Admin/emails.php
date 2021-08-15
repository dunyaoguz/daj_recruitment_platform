<?php
include_once('../../database.php');

$user_id = $_SESSION['userId'];

$incoming = $conn->prepare("SELECT * FROM emails
                            WHERE to_email = 'admin@dajrecruitment.com'");
$incoming->execute();

$outgoing = $conn->prepare("SELECT * FROM emails
                            WHERE from_email = 'admin@dajrecruitment.ca'");
$outgoing->execute();

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
            <a class="nav-item nav-link" href="index.php">Users</a>
            <a class="nav-item nav-link" href="systemLogs.php">System Logs</a>
            <a class="nav-item nav-link active" href="#">Emails<span class="sr-only">(current)</span></a>
            <a class="nav-item nav-link" href="../../">Sign Out</a>
          </div>
        </div>
        <span class="logo-image"><img src="../../logo.png" class="logo"></span>
        </div>
      </nav>
      <!-- <h1>Admin Dashboard</h1> -->
      <br>
      <h2>Incoming emails</h2>
      <h6>All emails that have been sent by users to admin@dajrecruitment.com.</h6>
      <table class="table table-striped">
          <thead>
              <tr>
                  <td>Sent Date</td>
                  <td>From Email</td>
                  <td>Subject</td>
                  <td>Body</td>
              </tr>
          </thead>

          <tbody>
              <?php while ($row = $incoming->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) { ?>
                  <tr>
                  <td> <?php echo $row['sent_date']; ?> </td>
                  <td> <?php echo $row['from_email']; ?> </td>
                  <td> <?php echo $row['subject']; ?> </td>
                  <td> <?php echo $row['body']; ?> </td>
                  </tr>
              <?php } ?>
          </tbody>
      </table>
      <br>
      <br>
      <h2>Outgoing emails</h2>
      <h6>All emails that have been sent by admin@dajrecruitment.com to users.</h6>
      <table class="table table-striped">
          <thead>
              <tr>
                  <td>Sent Date</td>
                  <td>To Email</td>
                  <td>Subject</td>
                  <td>Body</td>
              </tr>
          </thead>

          <tbody>
              <?php while ($row = $outgoing->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) { ?>
                  <tr>
                  <td> <?php echo $row['sent_date']; ?> </td>
                  <td> <?php echo $row['to_email']; ?> </td>
                  <td> <?php echo $row['subject']; ?> </td>
                  <td> <?php echo $row['body']; ?> </td>
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
