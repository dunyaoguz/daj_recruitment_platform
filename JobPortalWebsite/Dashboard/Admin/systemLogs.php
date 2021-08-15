<?php
include_once('../../database.php');

$user_id = $_SESSION['userId'];

$insertActivities = $conn->prepare("SELECT DISTINCT activity FROM system_logs
                                    WHERE old_value IS NULL");
$insertActivities->execute();

$updateActivities = $conn->prepare("SELECT DISTINCT activity FROM system_logs
                                    WHERE old_value IS NOT NULL
                                    AND new_value IS NOT NULL");
$updateActivities->execute();

if($_POST["insert_filter"] == "view all activities") {
  $inserts = $conn->prepare("SELECT * FROM system_logs WHERE old_value IS NULL");
  $inserts->execute();
} else {
  $inserts = $conn->prepare("SELECT * FROM system_logs
                            WHERE old_value IS NULL
                            AND activity = ?");
  $inserts->execute([$_POST["insert_filter"]]);
}

if($_POST["update_filter"] == "view all activities") {
  $updates = $conn->prepare("SELECT * FROM system_logs
                             WHERE old_value IS NOT NULL
                             AND new_value IS NOT NULL");
  $updates->execute();
} else {
  $updates = $conn->prepare("SELECT * FROM system_logs
                            WHERE old_value IS NOT NULL
                            AND new_value IS NOT NULL
                            AND activity = ?");
  $updates->execute([$_POST["update_filter"]]);
}
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
            <a class="nav-item nav-link" href="index.php">Users<span class="sr-only">(current)</span></a>
            <a class="nav-item nav-link active" href="#">System Logs</a>
            <a class="nav-item nav-link" href="emails.php">Emails</a>
            <a class="nav-item nav-link" href="../../">Sign Out</a>
          </div>
        </div>
        <span class="logo-image"><img src="../../logo.png" class="logo"></span>
        </div>
      </nav>
      <!-- <h1>Admin Dashboard</h1> -->
      <br>
      <h2>New Activity</h2>
      <h6>List of all new users, jobs and applications that have been created.</h6>

      <form action="" class="job-selection-form" method="POST">
        <div class="job-selection-group">
          <label for="user_type">You can filter for a specific activity here:</label>
          <select class="form-control" name="insert_filter" id="insert_filter">
            <option>-</option>
            <?php while ($row = $insertActivities->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) { ?>
                <option> <?php echo $row['activity']; ?> </option>
            <?php } ?>
            <option>view all activities</option>
          </select>
        </div>
        <button type="submit" class="btn btn-outline-success">Search</button>
      </form>

      <table class="table table-striped">
          <thead>
              <tr>
                  <td>Activity Date</td>
                  <td>Activity</td>
                  <td>New Value</td>
              </tr>
          </thead>

          <tbody>
              <?php while ($row = $inserts->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) { ?>
                  <tr>
                  <td> <?php echo $row['activity_date']; ?> </td>
                  <td> <?php echo $row['activity']; ?> </td>
                  <td> <?php echo $row['new_value']; ?> </td>
                  </tr>
              <?php } ?>
          </tbody>
      </table>
      <br>
      <h2>Updates</h2>
      <h6>List of all changes made to users, jobs and applications.</h6>

      <form action="" class="job-selection-form" method="POST">
        <div class="job-selection-group">
          <label for="user_type">You can filter for a specific activity here:</label>
          <select class="form-control" name="update_filter" id="update_filter">
            <option>-</option>
            <?php while ($row = $updateActivities->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) { ?>
                <option> <?php echo $row['activity']; ?> </option>
            <?php } ?>
            <option>view all activities</option>
          </select>
        </div>
        <button type="submit" class="btn btn-outline-success">Search</button>
      </form>

      <table class="table table-striped">
          <thead>
              <tr>
                  <td>Activity Date</td>
                  <td>Activity</td>
                  <td>Old Value</td>
                  <td>New Value</td>
              </tr>
          </thead>

          <tbody>
              <?php while ($row = $updates->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) { ?>
                  <tr>
                  <td> <?php echo $row['activity_date']; ?> </td>
                  <td> <?php echo $row['activity']; ?> </td>
                  <td> <?php echo $row['old_value']; ?> </td>
                  <td> <?php echo $row['new_value']; ?> </td>
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
