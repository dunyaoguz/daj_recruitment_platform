<?php
include_once('../../database.php');

//$user_id = $_SESSION['userId'];
$user_id = "4";


if(isset($_POST["new_job_title"]) && isset($_POST["new_job_description"]) && isset($_POST["new_job_experience"]) && isset($_POST["new_job_city"]) && isset($_POST["new_job_province"]) && isset($_POST["new_job_category"]) && isset($_POST["new_job_country"])){
     // create a new job
    $createNewJob = $conn->prepare("INSERT INTO jobs (employer_id, recruiter_id, title, description, required_experience, city, province, country)
                                      VALUES (:employer_id, :recruiter_id, :title, :description, :required_experience, :city, :province, :country)");

    $createNewJob->bindParam(':title', $_POST["new_job_title"]);
    $createNewJob->bindParam(':description', $_POST["new_job_description"]);
    $createNewJob->bindParam(':required_experience', $_POST["new_job_experience"], PDO::PARAM_INT);
    $createNewJob->bindParam(':city', $_POST["new_job_city"]);
    $createNewJob->bindParam(':province', $_POST["new_job_province"]);
    $createNewJob->bindParam(':country', $_POST["new_job_country"]);

    $getemployerIdInfoStmt = $conn->prepare("SELECT r.employer_id AS rec_employer_id, r.id AS rec_id
                                    FROM recruiters r 
                                    WHERE r.user_id = ?");
    $getemployerIdInfoStmt->execute([$user_id]);
    $getemployerIdInfo = $getemployerIdInfoStmt->fetch();

    $createNewJob->bindParam(':employer_id', $getemployerIdInfo['rec_employer_id'], PDO::PARAM_INT);
    $createNewJob->bindParam(':recruiter_id', $getemployerIdInfo['rec_id'], PDO::PARAM_INT);

    if ($createNewJob->execute()){
      //Obtain id of newly created job
      $getNewlyCreatedJobIdInfoStmt = $conn->prepare("SELECT j.id AS j_id
                                                        FROM jobs j
                                                        WHERE j.title = :j_title AND
                                                              j.description = :j_description AND
                                                              j.required_experience = :j_required_experience AND
                                                              j.city = :j_city AND
                                                              j.province = :j_province AND
                                                              j.country = :j_country AND
                                                              j.employer_id = :j_employer_id AND
                                                              j.recruiter_id = :j_recruiter_id");
      $getNewlyCreatedJobIdInfoStmt->bindParam(':j_title', $_POST["new_job_title"]);
      $getNewlyCreatedJobIdInfoStmt->bindParam(':j_description', $_POST["new_job_description"]);
      $getNewlyCreatedJobIdInfoStmt->bindParam(':j_required_experience', $_POST["new_job_experience"], PDO::PARAM_INT);
      $getNewlyCreatedJobIdInfoStmt->bindParam(':j_city', $_POST["new_job_city"]);
      $getNewlyCreatedJobIdInfoStmt->bindParam(':j_province', $_POST["new_job_province"]);
      $getNewlyCreatedJobIdInfoStmt->bindParam(':j_country', $_POST["new_job_country"]);
      $getNewlyCreatedJobIdInfoStmt->bindParam(':j_employer_id', $getemployerIdInfo['rec_employer_id'], PDO::PARAM_INT);
      $getNewlyCreatedJobIdInfoStmt->bindParam(':j_recruiter_id', $getemployerIdInfo['rec_id'], PDO::PARAM_INT);
      $getNewlyCreatedJobIdInfoStmt->execute();
      $getNewlyCreatedJobIdInfo = $getNewlyCreatedJobIdInfoStmt->fetch()['j_id'];
    
    
    
        // Create an array from a CSV
      $jobCategoryArr = explode(",", $_POST["new_job_country"]);

      $createNewCategory = $conn->prepare("INSERT INTO job_categories (job_id, job_category)
                                              VALUES (:job_id, :job_category)");
                                              
      foreach($jobCategoryArr as $newCategory){
        $createNewCategory->bindParam(':job_id', $getNewlyCreatedJobIdInfo, PDO::PARAM_INT);
        $createNewCategory->bindParam(':job_id', trim($newCategory));
        $createNewCategory->execute();
      }

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
            <a class="nav-item nav-link" href="/../Dashboard/Recruiter/">Dashboard</a>
          </div>
        </div>
        <span class="logo-image"><img src="../../logo.png" class="logo"></span>
        </div>
      </nav>
      <h2>Post a New Job</h2>
      <h6>Enter the details of the job you want to post below.</h6>

       <form action="./createJob.php" method = "post">
         <div class="form-group">
           <label for="new_job_title">Job Title</label><br>
           <input type="text" class="form-control" name="new_job_title" id="new_job_title" placeholder="Data Engineer" required>
         </div>
         <div class="form-group">
           <label for="new_job_description">Job Description</label><br>
           <input type="text" class="form-control" name="new_job_description" id="new_job_description" placeholder="We are looking for an engaged and enthusiastic Data Engineer to join our Experience Mission department...." required>
         </div>
         <div class="form-group">
           <label for="new_job_experience">Required Job Experience (Years)</label><br>
           <input type="text" class="form-control" name="new_job_experience" id="new_job_experience" placeholder="5" required>
         </div>
         <div class="form-group">
           <label for="new_job_category">Job Category</label><br>
           <input type="text" class="form-control" name="new_job_category" id="new_job_category" placeholder="National Defence, Strategic Planning, Cyber Security" required>
         </div>
         <div class="form-group">
           <label for="new_job_city">City</label><br>
           <input type="text" class="form-control" name="new_job_city" id="new_job_city" placeholder="Montreal" required>
         </div>
         <div class="form-group">
           <label for="new_job_province">Province</label><br>
           <input type="text" class="form-control" name="new_job_province" id="new_job_province" placeholder="QC" required>
         </div>
         <div class="form-group">
           <label for="new_job_province">Country</label><br>
           <input type="text" class="form-control" name="new_job_country" id="new_job_country" placeholder="Canada" required>
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
