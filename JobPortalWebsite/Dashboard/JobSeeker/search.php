<?php
include_once('../../database.php');

$user_id = $_SESSION['user_id'];
// $user_id = "8";

$jobSeekerInfoStmt = $conn->prepare("SELECT id, first_name, last_name FROM job_seekers WHERE user_id = ?");
$jobSeekerInfoStmt->execute([$user_id]);
$result = $jobSeekerInfoStmt->fetch();
$jobSeekerName = $result['first_name'] . ' ' . $result['last_name'];
$jobSeekerId = $result['id'];

$jobsCategories = $conn->prepare("SELECT DISTINCT job_category FROM job_categories");
$jobsCategories->execute();

if($_POST["job_category"] == "View All Jobs") {
  $jobsStmt = $conn->prepare("SELECT j.id,
                                     GROUP_CONCAT(c.job_category separator ', ') AS job_category,
                                     j.date_posted,
                                     e.name AS company,
                                     j.title,
                                     j.description,
                                     j.required_experience,
                                     CONCAT(j.city, ', ', j.province, ', ', j.country) AS location,
                                     CONCAT(r.first_name, ' ', r.last_name) AS recruiter,
                                     j.status,
                                     CASE WHEN is_remote_eligible = 1 THEN 'yes'
                                     ELSE 'no' END AS is_remote_eligible
                              FROM jobs j
                              LEFT JOIN recruiters r
                              ON j.recruiter_id = r.id
                              LEFT JOIN employers e
                              ON j.employer_id = e.id
                              LEFT JOIN job_categories c
                              ON j.id = c.job_id
                              WHERE j.id NOT IN (SELECT job_id FROM applications WHERE job_seeker_id=:job_seeker_id)
                              AND j.status != 'CLOSED'
                              GROUP BY 1, 3, 4, 5, 6, 7, 8, 9, 10, 11");
} else {
  $jobsStmt = $conn->prepare("SELECT j.id,
                                     GROUP_CONCAT(c.job_category separator ', ') AS job_category,
                                     j.date_posted,
                                     e.name AS company,
                                     j.title,
                                     j.description,
                                     j.required_experience,
                                     CONCAT(j.city, ', ', j.province, ', ', j.country) AS location,
                                     CONCAT(r.first_name, ' ', r.last_name) AS recruiter,
                                     j.status,
                                     CASE WHEN is_remote_eligible = 1 THEN 'yes'
                                     ELSE 'no' END AS is_remote_eligible
                              FROM jobs j
                              LEFT JOIN recruiters r
                              ON j.recruiter_id = r.id
                              LEFT JOIN employers e
                              ON j.employer_id = e.id
                              LEFT JOIN job_categories c
                              ON j.id = c.job_id
                              WHERE job_category = :job_category
                              AND j.status != 'CLOSED'
                              AND j.id NOT IN (SELECT job_id FROM applications WHERE job_seeker_id=:job_seeker_id)
                              GROUP BY 1, 3, 4, 5, 6, 7, 8, 9, 10, 11");
    $jobsStmt->bindParam(':job_category', $_POST["job_category"]);
}
$jobsStmt->bindParam(':job_seeker_id', $jobSeekerId);
$jobsStmt->execute();
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Job Search</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="../../style.css">
        <html lang="en">
    </head>
    <body>
      <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
        <span class="navbar-brand mb-0 h1">DAJ Recruitment Platform</span>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
          <div class="navbar-nav">
            <a class="nav-item nav-link" href="/../Dashboard/JobSeeker/">Dashboard</a>
            <a class="nav-item nav-link" href="./profile.php">Profile</a>
            <a class="nav-item nav-link" href="./contactUs.php">Contact Us</a>
            <a class="nav-item nav-link" href="../../">Sign Out</a>
          </div>
        </div>
        <span class="logo-image"><img src="../../logo.png" class="logo"></span>
        </div>
      </nav>
      <h2>Job Search</h2>
      <h6>Search and apply for new jobs.</h6>

      <form action="" class="job-selection-form" method="POST">
        <div class="job-selection-group">
          <label for="user_type">Make your category selection here:</label>
          <select class="form-control" name="job_category" id="job_category">
            <option>-</option>
            <?php while ($row = $jobsCategories->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) { ?>
                <option> <?php echo $row['job_category']; ?> </option>
            <?php } ?>
            <option>View All Jobs</option>
          </select>
        </div>
        <button type="submit" class="btn btn-outline-success">Search</button>
      </form>
      <br>
      <table class="table table-striped">
          <thead>
              <tr>
                  <td>Job ID</td>
                  <td>Job Category</td>
                  <td>Date Posted</td>
                  <td>Company</td>
                  <td>Job Title</td>
                  <td>Job Description</td>
                  <td>Required Experience</td>
                  <td>Location</td>
                  <td>Recruiter Name</td>
                  <td>Job Status</td>
                  <td>Is Remote Eligible?</td>
                  <td>Actions</td>
              </tr>
          </thead>

          <tbody>
              <?php while ($row = $jobsStmt->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) { ?>
                  <tr>
                  <td> <?php echo $row['id']; ?> </td>
                  <td> <?php echo $row['job_category']; ?> </td>
                  <td> <?php echo $row['date_posted']; ?> </td>
                  <td> <?php echo $row['company']; ?> </td>
                  <td> <?php echo $row['title']; ?> </td>
                  <td> <?php echo $row['description']; ?> </td>
                  <td> <?php echo $row['required_experience']; ?> </td>
                  <td> <?php echo $row['location']; ?> </td>
                  <td> <?php echo $row['recruiter']; ?> </td>
                  <td> <?php echo $row['status']; ?> </td>
                  <td> <?php echo $row['is_remote_eligible']; ?> </td>
                  <td>
                    <a href="./apply.php?job_id=<?= $row["id"]?>">Apply</a>
                  </td>
                  </tr>
              <?php } ?>
          </tbody>
      </table>
      <br>
      <br>
      <br>

      <div class="footer">
        © 2021 Copyright: Dunya Oguz, Azman Akhter, John Purcell
      </div>
    </body>
</html>
