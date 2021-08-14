<?php require_once '../../database.php';

//On page 2
$job_seeker_id = $_SESSION['job_seeker_id'];

if(isset($_POST["education_type_1"])&&isset($_POST["school_1"])&&isset($_POST["concentration_1"])
&&isset($_POST["grade_1"])&&isset($_POST["year_graduated_1"]) ){

}

if(isset($_POST["education_type_2"])&&isset($_POST["school_2"])&&isset($_POST["concentration_2"])
&&isset($_POST["grade_2"])&&isset($_POST["year_graduated_2"]) ){

}

if(isset($_POST["education_type_3"])&&isset($_POST["school_3"])&&isset($_POST["concentration_3"])
&&isset($_POST["grade_3"])&&isset($_POST["year_graduated_3"]) ){

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="../../style.css">
    <title>Job Seeker Sign Up</title>
    <link rel="icon" href="../../logo.png" type="penguin">
</head>
<body>
  <nav class="navbar navbar-light bg-light">
    <span class="navbar-brand mb-0 h1">DAJ Recruitment Platform</span>
    <span class="logo-image"><img src="../../logo.png" class="logo"></span>
  </nav>
  <h2>Education History</h2>
  <h6>Include (up to) three levels of education below.</h6>
  <br>
  <h6>Entry 1</h6>
  <form action="" method="POST">
      <div class="form-group">
        <label for="education_type_1">Level of Education</label><br>
        <input type="text" class="form-control" name="education_type_1" id="education_type_1">
      </div>
      <div class="form-group">
        <label for="school_1">Institution</label><br>
        <input type="text" class="form-control" name="school_1" id="school_1" >
      </div>
      <div class="form-group">
        <label for="concentration_1">Major</label><br>
        <input type="text" class="form-control" name="concentration_1" id="concentration_1" >
      </div>
      <div class="form-group">
        <label for="grade_1">GPA</label><br>
        <input type="text" class="form-control" name="grade_1" id="grade_1">
      </div>
      <div class="form-group">
        <label for="year_graduated_1">Year Graduated</label><br>
        <input type="text" class="form-control" name="year_graduated_1" id="year_graduated_1">
      </div>
      <br>
      <br>
      <h6>Entry 2</h6>
      <div class="form-group">
        <label for="education_type_2">Level of Education</label><br>
        <input type="text" class="form-control" name="education_type_2" id="education_type_2">
      </div>
      <div class="form-group">
        <label for="school_2">Institution</label><br>
        <input type="text" class="form-control" name="school_2" id="school_2" >
      </div>
      <div class="form-group">
        <label for="concentration_2">Major</label><br>
        <input type="text" class="form-control" name="concentration_2" id="concentration_2" >
      </div>
      <div class="form-group">
        <label for="grade_2">GPA</label><br>
        <input type="text" class="form-control" name="grade_2" id="grade_2">
      </div>
      <div class="form-group">
        <label for="year_graduated_2">Year Graduated</label><br>
        <input type="text" class="form-control" name="year_graduated_2" id="year_graduated_2">
      </div>
      <br>
      <br>
      <h6>Entry 3</h6>
      <div class="form-group">
        <label for="education_type_3">Level of Education</label><br>
        <input type="text" class="form-control" name="education_type_3" id="education_type_3">
      </div>
      <div class="form-group">
        <label for="school_3">Institution</label><br>
        <input type="text" class="form-control" name="school_3" id="school_3" >
      </div>
      <div class="form-group">
        <label for="concentration_3">Major</label><br>
        <input type="text" class="form-control" name="concentration_3" id="concentration_3" >
      </div>
      <div class="form-group">
        <label for="grade_3">GPA</label><br>
        <input type="text" class="form-control" name="grade_3" id="grade_3">
      </div>
      <div class="form-group">
        <label for="year_graduated_3">Year Graduated</label><br>
        <input type="text" class="form-control" name="year_graduated_3" id="year_graduated_3">
      </div>
      <p><button type="submit" class="btn btn-outline-success">Submit</button></p>
      <br>
    </form>

  <div class="footer">
    © 2021 Copyright: Dunya Oguz, Azman Akhter, John Purcell
  </div>
</body>
</html>
