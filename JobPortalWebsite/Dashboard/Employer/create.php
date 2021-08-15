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

    $getExistingUsersStmt = $conn->prepare("SELECT u.id, u.date_registered, u.user_type, u.login_name AS u_login_name, u.password, u.phone AS u_phone, u.email AS u_email, u.status 
                                                FROM users u"); 
    $getExistingUsersStmt->execute();

    while ($row = $getExistingUsersStmt->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)){
        if($row['u_login_name'] == $_POST["login_name"]){
            $doesUserNameAlreadyExist = TRUE;
            break;
        }
        if(($row['_.phone'] == $_POST["phone"]) || ($row['u_email'] == $_POST["email"])){
            $isPhoneNumberAndEmailUnique = TRUE;
            break;
        }
    }


    if (!$doesUserNameAlreadyExist && !$isPhoneNumberAndEmailUnique){ // both are false, then create new user
        $createUserStmt = $conn->prepare("INSERT INTO users user (user.user_type, user.login_name, user.password, user.phone, user.email)
                                        VALUES (:user_user_type, :user_login_name, :user_password, :user_phone, :user_email)");

        $createUserStmt->bindParam(':user_user_type', $_POST["user_type"]);
        $createUserStmt->bindParam(':user_login_name', $_POST["login_name"]);
        $createUserStmt->bindParam(':user_password', $_POST["password"]);
        $createUserStmt->bindParam(':user_phone', $_POST["phone"]);
        $createUserStmt->bindParam(':user_email', $_POST["email"]);

        if($createUserStmt->execute()){ // new user create successfully
            // Fetch data of newly created user
            $getNewlyCreatedUserInfoStmt = $conn->prepare("SELECT us.id AS us_id, us.date_registered, us.user_type, us.login_name, us.password, us.phone, us.email, us.status 
                                                                FROM users us
                                                                WHERE us.user_type = 'Recruiter' and  us.email = :us_existingEmail");
            $getNewlyCreatedUserInfoStmt->bindParam(':us_existingEmail', $_POST["email"]);
            $getNewlyCreatedUserInfoStmt->execute();
            $newlyCreatedUserInfo = $getNewlyCreatedUserInfoStmt->fetch(PDO::FETCH_ASSOC);

            // Now add user to the recruiter table
            $createRecruiterStmt = $conn->prepare("INSERT INTO recruiters r (r.user_id, r.employer_id, r.first_name, r.last_name)
                                                VALUES (:r_user_id, :r_employer_id, :r_first_name, :r_last_name)");
            
            //fetch the employer_id using the user_id
            $getEmployerIdStmt = $conn->prepare("SELECT e.id AS employer_id, e.user_id, e.membership_id, e.name 
                                                    FROM employers e
                                                    WHERE e.user_id = :e_existingUserId");
            $getEmployerIdStmt->bindParam(':e_existingUserId', $user_id);
            $getEmployerIdStmt->execute();
            $employerIdInfo = $getEmployerIdStmt->fetch(PDO::FETCH_ASSOC);

            //bind all the data and execute query
            $createRecruiterStmt->bindParam(':r_user_id', $newlyCreatedUserInfo['us_id'], PDO::PARAM_INT);
            $createRecruiterStmt->bindParam(':r_employer_id', $employerIdInfo['employer_id'], PDO::PARAM_INT);
            $createRecruiterStmt->bindParam(':r_first_name', $_POST["first_name"]);
            $createRecruiterStmt->bindParam(':r_last_name', $_POST["last_name"]);

            if($createRecruiterStmt->execute()){
                header("Location: .");
            }else{
                echo "<h4> INTERNAL ERROR: Failed to Create New Recruiter. Please contact Website Admin </h4> <br>"; 
            }
        }else{
            echo "<h4> INTERNAL ERROR: Failed to Create New User. Please contact Wedsite Admin </h4> <br>"; 
        }

    }else{ //Display Error message
        if($doesUserNameAlreadyExist){
            echo "<h4> Username Already Exists </h4> <br>"; 
        }
        if($isPhoneNumberAndEmailUnique){
            echo "<h4> Phone Number or Email Already Exists </h4> <br>";
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
                <input type="text" class="form-control" name="phone" id="phone" placeholder="1231231111" required>
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
