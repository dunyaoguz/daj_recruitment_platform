<?php
include_once('../../database.php');

//$user_id = $_SESSION['userId'];
$user_id = "4";


if(isset($_POST["job_title"]) && isset($_POST["job_description"]) && isset($_POST["job_experience"]) && isset($_POST["job_city"]) && isset($_POST["job_province"]) && isset($_POST["job_country"])){
    $job = $conn->prepare("INSERT INTO jobs (employer_id, recruiter_id, title, description, required_experience, city, province, country)
                            VALUES (:employer_id, :recruiter_id, :title, :description, :required_experience, :city, :province, :country)");

    $job->bindParam(':title', $_POST["job_title"]);
    $job->bindParam(':description', $_POST["job_description"]);
    $job->bindParam(':required_experience', $_POST["job_experience"], PDO::PARAM_INT);
    $job->bindParam(':city', $_POST["job_city"]);
    $job->bindParam(':province', $_POST["job_province"]);
    $job->bindParam(':country', $_POST["job_country"]);

    $getIdStmt = $conn->prepare("SELECT employer_id, id FROM recruiters WHERE user_id = ?");
    $getIdStmt->execute([$user_id]);
    $result = $getIdStmt->fetch();

    $job->bindParam(':employer_id', $result['employer_id'], PDO::PARAM_INT);
    $job->bindParam(':recruiter_id', $result['id'], PDO::PARAM_INT);

    if ($job->execute()){
        header("Location: .");
    }
}


?>


<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Post a new job</title>
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
            <a class="nav-item nav-link" href="/../Dashboard/Employer/">Dashboard</a>
          </div>
        </div>
        <span class="logo-image"><img src="../../logo.png" class="logo"></span>
        </div>
      </nav>
      <h2>Post a New Job</h2>
      <h6>Enter the details of the job you want to post below.</h6>

       <form action="./create.php" method = "post">
         <div class="form-group">
           <label for="job_title">Job Title</label><br>
           <input type="text" class="form-control" name="job_title" id="job_title" placeholder="Data Engineer" required>
         </div>
         <div class="form-group">
           <label for="job_description">Job Description</label><br>
           <input type="text" class="form-control" name="job_description" id="job_description" placeholder="We are looking for an engaged and enthusiastic Data Engineer to join our Experience Mission department...." required>
         </div>
         <div class="form-group">
           <label for="job_experience">Required Job Experience (Years)</label><br>
           <input type="text" class="form-control" name="job_experience" id="job_experience" placeholder="5" required>
         </div>
         <div class="form-group">
           <label for="job_city">City</label><br>
           <input type="text" class="form-control" name="job_city" id="job_city" placeholder="Montreal" required>
         </div>
         <div class="form-group">
           <label for="job_province">Province</label><br>
           <input type="text" class="form-control" name="job_province" id="job_province" placeholder="QC" required>
         </div>
         <div class="form-group">
           <label for="job_province">Country</label><br>
           <input type="text" class="form-control" name="job_country" id="job_country" placeholder="Canada" required>
         </div>
         <p><button type="submit" class="btn btn-outline-success">Post Job</button></p>
         <br>
        </form>
        <br>
        <div class="footer">
          © 2021 Copyright: Dunya Oguz, Azman Akhter, John Purcell
        </div>
    </body>
</html>
