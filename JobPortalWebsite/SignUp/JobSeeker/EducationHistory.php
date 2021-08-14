<?php require_once '../../database.php';

//On page 2
$job_seeker_id = $_SESSION['job_seeker_id'];


if(isset($_POST["education_type_1"])&&isset($_POST["school_1"])&&isset($_POST["concentration_1"])
&&isset($_POST["grade_1"])&&isset($_POST["year_graduated_1"]) ){
  $education_history1 = $conn->prepare("INSERT INTO job_seeker_education_history (job_seeker_id, education_type,
  school, concentration, grade, year_graduated ) VALUES (:job_seeker_id, :education_type,
  :school, :concentration, CAST(:grade AS FLOAT), :year_graduated )
  ;");
      $education_history1->bindParam(':job_seeker_id', $job_seeker_id["id"], PDO::PARAM_INT);
      $education_history1->bindParam(':education_type', $_POST["education_type_1"]);
      $education_history1->bindParam(':school', $_POST["school_1"]);
      $education_history1->bindParam(':concentration', $_POST["concentration_1"]);
      $grade = number_format($_POST["grade_1"], 2);
      $education_history1->bindParam(':grade', $grade);
      $education_history1->bindParam(':year_graduated', $_POST["year_graduated_1"], PDO::PARAM_INT);

      if($education_history1->execute()){
          
      }
}

if(isset($_POST["education_type_2"])&&isset($_POST["school_2"])&&isset($_POST["concentration_2"])
&&isset($_POST["grade_2"])&&isset($_POST["year_graduated_2"]) ){
  $education_history2 = $conn->prepare("INSERT INTO job_seeker_education_history (job_seeker_id, education_type,
  school, concentration, grade, year_graduated ) VALUES (:job_seeker_id, :education_type,
  :school, :concentration, CAST(:grade AS FLOAT), :year_graduated )
  ;"); //chnage vars to match form 
      $education_history2->bindParam(':job_seeker_id', $job_seeker_id["id"], PDO::PARAM_INT);
      $education_history2->bindParam(':education_type', $_POST["education_type_2"]);
      $education_history2->bindParam(':school', $_POST["school_2"]);
      $education_history2->bindParam(':concentration', $_POST["concentration_2"]);
      $grade2 = number_format($_POST["grade_2"], 2);
      $education_history2->bindParam(':grade', $grade2);
      $education_history2->bindParam(':year_graduated', $_POST["year_graduated_2"], PDO::PARAM_INT);
     
      if($education_history2->execute()){
        
      }
}

if(isset($_POST["education_type_3"])&&isset($_POST["school_3"])&&isset($_POST["concentration_3"])
&&isset($_POST["grade_3"])&&isset($_POST["year_graduated_3"]) ){
  $education_history3 = $conn->prepare("INSERT INTO job_seeker_education_history (job_seeker_id, education_type,
  school, concentration, grade, year_graduated ) VALUES (:job_seeker_id, :education_type,
  :school, :concentration, CAST(:grade AS FLOAT), :year_graduated )
  ;");
      $education_history3->bindParam(':job_seeker_id', $job_seeker_id["id"], PDO::PARAM_INT);
      $education_history3->bindParam(':education_type', $_POST["education_type_3"]);
      $education_history3->bindParam(':school', $_POST["school_3"]);
      $education_history3->bindParam(':concentration', $_POST["concentration_3"]);
      $grade3 = number_format($_POST["grade_3"], 2);
      $education_history3->bindParam(':grade', $grade3);
      $education_history3->bindParam(':year_graduated', $_POST["year_graduated_3"], PDO::PARAM_INT);

      if($education_history3->execute()){
        
      }
}
if (isset($_POST["submitform"])){
  header("Location: ../Login.php");
};
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
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="education_type_1" value="High School">
        <label class="form-check-label" for="High School">High School</label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="education_type_1" value="Bachelors">
        <label class="form-check-label" for="Bachelors">Bachelors</label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="education_type_1" value="Masters">
        <label class="form-check-label" for="Masters">Masters</label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="education_type_1" value="PhD">
        <label class="form-check-label" for="PhD">PhD</label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="education_type_1" value="Certificate">
        <label class="form-check-label" for="Certificate">Certificate</label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="education_type_1" value="Diploma">
        <label class="form-check-label" for="Diploma">Diploma</label>
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
      <div class="form-check form-check-inline">
      <input class="form-check-input" type="radio" name="education_type_2" value="High School">
        <label class="form-check-label" for="High School">High School</label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="education_type_2" value="Bachelors">
        <label class="form-check-label" for="Bachelors">Bachelors</label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="education_type_2" value="Masters">
        <label class="form-check-label" for="Masters">Masters</label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="education_type_2" value="PhD">
        <label class="form-check-label" for="PhD">PhD</label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="education_type_2" value="Certificate">
        <label class="form-check-label" for="Certificate">Certificate</label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="education_type_2" value="Diploma">
        <label class="form-check-label" for="Diploma">Diploma</label>
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
      <div class="form-check form-check-inline">
      <input class="form-check-input" type="radio" name="education_type_3" value="High School">
        <label class="form-check-label" for="High School">High School</label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="education_type_3" value="Bachelors">
        <label class="form-check-label" for="Bachelors">Bachelors</label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="education_type_3" value="Masters">
        <label class="form-check-label" for="Masters">Masters</label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="education_type_3" value="PhD">
        <label class="form-check-label" for="PhD">PhD</label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="education_type_3" value="Certificate">
        <label class="form-check-label" for="Certificate">Certificate</label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="education_type_3" value="Diploma">
        <label class="form-check-label" for="Diploma">Diploma</label>
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
      <p><button type="submit" name = "submitform" class="btn btn-outline-success">Next</button></p>
      <br>
    </form>

  <div class="footer">
    © 2021 Copyright: Dunya Oguz, Azman Akhter, John Purcell
  </div>
</body>
</html>
