<?php
include_once('../../database.php');

//session_start();

//$user_id = $_SESSION['userId'];
$user_id = "1";


if(isset($_POST["user_type"]) && isset($_POST["first_name"]) && isset($_POST["last_name"]) && isset($_POST["email"]) && isset($_POST["phone"]) && isset($_POST["login_name"]) && isset($_POST["password"])){
    /*check if username not already exits
    check if phone number && email are unique*/

    $doesUserNameAlreadyExist = FALSE;
    $isPhoneNumberAndEmailUnique = FALSE;

    $getExistingUsersStmt = $conn->prepare("SELECT * FROM users");
    $getExistingUsersStmt->exceute();

    while ($row = $getExistingUsersStmt->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)){
        if($row['login_name'] == $_POST["login_name"]){
            $doesUserNameAlreadyExist = TRUE;
            break;
        }
        if(($row['phone'] == $_POST["phone"]) || ($row['email'] == $_POST["email"])){
            $isPhoneNumberAndEmailUnique = TRUE;
            break;
        }
    }


    if (!$doesUserNameAlreadyExist && !$isPhoneNumberAndEmailUnique){ // both are false, then create new user
        $createUserStmt = $conn->prepare("INSERT INTO users (user_type, login_name, password, phone, email)
                                        VALUES (:user_type, :login_name, :password, :phone, :email)");

        $createUserStmt->bindParam(':user_type', $_POST["user_type"]);
        $createUserStmt->bindParam(':login_name', $_POST["login_name"]);
        $createUserStmt->bindParam(':password', $_POST["password"]);
        $createUserStmt->bindParam(':phone', $_POST["phone"]);
        $createUserStmt->bindParam(':email', $_POST["email"]);

        if($createUserStmt->excecute()){ // new user create successfully
            // Fetch data of newly created user
            $getNewlyCreatedUserInfoStmt = $conn->prepare("SELECT * FROM users WHERE user_type = 'Recruiter' and  email = ?");
            $getNewlyCreatedUserInfoStmt->execute($_POST["email"]);
            $newlyCreatedUserInfo = $getNewlyCreatedUserInfoStmt->fetch(PDO::FETCH_ASSOC);

            // Now add user to the recruiter table
            $createRecruiterStmt = $conn->prepare("INSERT INTO recruiters (user_id, employer_id, first_name, last_name)
                                                VALUES (:user_id, :employer_id, :first_name, :last_name)");
            
            //fetch the employer_id using the user_id
            $getEmployerIdStmt = $conn->prepare("SELECT * FROM employers WHERE user_id = ?");
            $getEmployerIdStmt->excecute($user_id);
            $employerIdInfo = $getEmployerIdStmt->fetch(PDO::FETCH_ASSOC);

            //bind all the data and execute query
            $createRecruiterStmt->bindParam(':user_id', $newlyCreatedUserInfo['id'], PDO::PARAM_INT);
            $createRecruiterStmt->bindParam(':employer_id', $employerIdInfo['id'], PDO::PARAM_INT);
            $createRecruiterStmt->bindParam(':first_name', $_POST["first_name"]);
            $createRecruiterStmt->bindParam(':last_name', $_POST["last_name"]);

            if($createRecruiterStmt->exceute()){
                header("Location: .");
            }else{
                echo "<h3> Failed to Create New Recruiter. </h3> <br>"; 
            }
        }else{
            echo "<h3> Failed to Create New User. </h3> <br>"; 
        }

    }else{ //Display Error message
        if($doesUserNameAlreadyExist){
            echo "<h3> Username Already Exists </h3> <br>"; 
        }
        if($isPhoneNumberAndEmailUnique){
            echo "<h3> Phone Number or Email Already Exists </h3> <br>";
        }
    } 
}

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Add a new recruiter</title>
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
      <h2>Add a new Recruiter</h2>
      <h6>Enter the details of the recruiter you want to add.</h6>

       <form action="./create.php" method = "post">
            <input type="hidden" name="user_type" id="user_type" value="Recruiter">
            
            <div class="form-group">
                <label for="first_name">Recruiter's First Name</label><br>
                <input type="text" class="form-control" name="first_name" id="first_name" required>
            </div>

            <div class="form-group">
                <label for="last_name">Recruiter's Last Name</label><br>
                <input type="text" class="form-control" name="last_name" id="last_name" required>
            </div>

            <div class="form-group">
                <label for="email">Recruiter's Email (Unique)</label><br>
                <input type="text" class="form-control" name="email" id="email" placeholder="john_doe@gmail.com" required>
            </div>

            <div class="form-group">
                <label for="phone">Recruiter's Phone Number (Unique)</label><br>
                <input type="text" class="form-control" name="phone" id="phone" placeholder="123-123-1111" required>
            </div>

            <div class="form-group">
                <label for="login_name">Set User Name</label><br>
                <input type="text" class="form-control" name="login_name" id="login_name" required>
            </div>

            <div class="form-group">
                <label for="password">Set Password (minimum 8 characters)</label><br>
                <input type="password" class="form-control" name="password" id="password" minlength="8" required>
            </div>


            <p><button type="submit" class="btn btn-outline-success">Add Recruiter</button></p>
            <br>
        </form>
        <br>
        <div class="footer">
          © 2021 Copyright: Dunya Oguz, Azman Akhter, John Purcell
        </div>
    </body>
</html>
