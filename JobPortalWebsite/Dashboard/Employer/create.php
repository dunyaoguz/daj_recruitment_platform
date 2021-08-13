<?php
include_once('../../database.php');

//$user_id = $_SESSION['userId'];
$user_id = "1";

if(isset($_POST["job_title"]) && isset($_POST["job_description"]) && isset($_POST["job_experienceRequired"]) && isset($_POST["job_city"]) && isset($_POST["job_province"]) && isset($_POST["job_country"]) && isset($_POST["job_remoteAvaliable"])){
    $job = $conn->prepare("INSERT INTO jobs (employer_id, recruiter_id, title, description, required_experience, city, province, country, is_remote_eligible)
                            VALUES (:employer_id, :recruiter_id, :title, :description, :required_experience, :city, :province, :country, :is_remote_eligible))");
    
    $job->bindParam(':title', $_POST["job_title"]);
    $job->bindParam(':description', $_POST["job_description"]);
    $job->bindParam(':required_experience', $_POST["job_experienceRequired"]);
    $job->bindParam(':city', $_POST["job_city"]);
    $job->bindParam(':province', $_POST["job_province"]);
    $job->bindParam(':country', $_POST["job_country"]);
    
    if($_POST["job_remoteAvaliable"] == "Yes" || $_POST["job_remoteAvaliable"] == "yes"){
        $job->bindParam(':is_remote_eligible', 1);
    }else{
        $job->bindParam(':is_remote_eligible', 0);
    }


    $getIdStmt = $conn->prepare("SELECT employer_id, id FROM recruiters WHERE user_id = ?");
    $getIdStmt->execute([$user_id]);
    $result = $getIdStmt->fetch();
    $employeerId = $result['employer_id'];
    $recruiterId = $result['id'];

    $job->bindParam(':employer_id', $employeerId);
    $job->bindParam(':employer_id', $recruiterId);

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
        <title>Add A New Job</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="">
    </head>
    
    <body>

        <h1>Add Job</h1>

       <form action="./create.php" method = "post">
    
        <label for="job_title">Job Title</label><br>
        <input type="text" name = "job_title" id = "book_title"><br>

        <label for="job_description">Job Description</label><br>
        <input type="text" name = "job_description" id = "job_description"><br>

        <label for="job_experienceRequired">Job Experience Required (Years)</label><br>
        <input type="number" name = "job_experienceRequired" id = "job_experienceRequired"><br>

        <label for="job_city">City</label><br>
        <input type="text" name = "job_city" id = "job_city"><br>

        <label for="job_province">Province</label><br>
        <input type="text" name = "job_province" id = "job_province"><br>

        <label for="job_country">Country</label><br>
        <input type="text" name = "job_country" id = "job_country"><br>

        <label for="job_remoteAvaliable">Remote Avaliable</label><br>
        <input type="text" name = "job_remoteAvaliable" id = "job_remoteAvaliable"><br>

        <button type = "submit">Add</button>
    
    
        </form>

        <a href="./index.php">Back To Job Listings</a>
    </body>
</html>