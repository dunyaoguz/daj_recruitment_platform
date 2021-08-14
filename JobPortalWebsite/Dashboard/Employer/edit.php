<?php
include_once('../../database.php');

//$user_id = $_SESSION['userId'];
//$user_id = "1";

$recruiterInfoStmt = $conn->prepare("SELECT * FROM recruiters WHERE id = :id");
$recruiterInfoStmt->bindParam(':id', $_GET["recruiter_id"], PDO::PARAM_INT);
$recruiterInfoStmt->execute();
$recruiterInfo = $recruiterInfoStmt->fetch(PDO::FETCH_ASSOC);


if(isset($_POST["recruiter_first_name"]) && isset($_POST["recruiter_last_name"]) && isset($_POST["recruiter_id"])){
    $recruiterUpdateStmt = $conn->prepare("UPDATE recruiters SET
                                            first_name = :first_name,
                                            last_name = :last_name
                                            WHERE id = :id");

    $recruiterUpdateStmt->bindParam(':first_name', $_POST["recruiter_first_name"]);
    $recruiterUpdateStmt->bindParam(':last_name', $_POST["recruiter_last_name"]);
    $recruiterUpdateStmt->bindParam(':id', $_POST["recruiter_id"], PDO::PARAM_INT);

    if($recruiterUpdateStmt->execute()){
        header("Location: .");
    }else{
        header("Location: ./edit.php?recruiter_id=".$_POST["recruiter_id"]);
    }
}

?>


<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Edit Recruiter Info</title>
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
      <h2>Edit Recruiter Info</h2>
      <h6>Please update the recruiter information below.</h6>

       <form action="./edit.php" method = "post">
         <div class="form-group">
           <label for="recruiter_first_name">First Name</label><br>
           <input type="text" class="form-control" name="recruiter_first_name" id="recruiter_first_name" value="<?= $recruiterInfo["first_name"]?>">
         </div>
         <div class="form-group">
           <label for="recruiter_last_name">Last Name</label><br>
           <input type="text" class="form-control" name="recruiter_last_name" id="recruiter_last_name" value="<?= $recruiterInfo["last_name"]?>">
         </div>
         <div class="form-group">
           <input type="hidden" class="form-control" name="recruiter_id" id="recruiter_id" value= "<?= $recruiterInfo["id"]?>">
         </div>
         <p><button type="submit" class="btn btn-outline-success">Update Info</button></p>
         <br>
        </form>
        <br>
        <div class="footer">
          © 2021 Copyright: Dunya Oguz, Azman Akhter, John Purcell
        </div>
    </body>
</html>
