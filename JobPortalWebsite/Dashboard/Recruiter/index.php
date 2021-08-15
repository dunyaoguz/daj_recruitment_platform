<?php
    include_once('../../database.php');
    //session_start();

    //$user_id = $_SESSION['userId'];
    $user_id = 4;

    $canPostJob = FALSE;

    // Obtain Recruiter's Name, Recruiter ID, Recruiter's Employer ID
    $getRecruiterInfoStmt = $conn->prepare("SELECT r.id, r.user_id, r.employer_id, r.first_name, r.last_name
                                                FROM recruiters r 
                                                WHERE r.user_id = :r_user_id");

    $getRecruiterInfoStmt->bindParam(':r_user_id', $user_id, PDO::PARAM_INT);
    $getRecruiterInfoStmt->execute();
    $recruiterInfo = $getRecruiterInfoStmt->fetch();
    $recruiterName = $recruiterInfo['first_name'];
    $recruiterId = $recruiterInfo['r.id'];
    $recruiterEmployerId = $recruiterInfo['r.employer_id'];

    // Obtain Recruiter ID -> Obtain all Jobs for the Recruiter
    $getJobListingStmt = $conn->prepare("SELECT j.id, j.employer_id, j.recruiter_id, j.date_posted, j.title, j.description, j.required_experience, j.status, j.city, j.province, j.country, j.is_remote_eligible 
                                            FROM jobs j
                                            WHERE j.recruiter_id = :j_recruiter_id");
    $getJobListingStmt->bindParam(':j_recruiter_id', $recruiterId, PDO::PARAM_INT);
    $getJobListingStmt->execute();

    // Obtain Membership ID of Employer -> fetch the Employer's membership Type
    $getEmployerMembershipIdStmt = $conn->prepare("SELECT e.id, e.user_id, e.membership_id, e.name 
                                                        FROM employers e 
                                                        WHERE e.user_id = :e_user_id");
    $getEmployerMembershipIdStmt->bindParam(':e_user_id', $recruiterEmployerId, PDO::PARAM_INT);
    $getEmployerMembershipIdStmt->execute();
    $getEmployerMembershipId = $getEmployerMembershipIdStmt->fetch()['e.membership_id'];

    $getEmployerMembershipInfoStmt = $conn->prepare("SELECT m.id, m.user_type, m.membership_type, m.monthly_fee, m.job_posting_limit, m.job_application_limit
                                                        FROM memberships m 
                                                        WHERE m.id = :m_id");
    $getEmployerMembershipInfoStmt->bindParam(':m_id', $getEmployerMembershipId, PDO::PARAM_INT);
    $getEmployerMembershipInfoStmt->execute();
    $getEmployerMembershipInfo = $getEmployerMembershipInfoStmt->fetch()['m.id'];

    // Get Total Number of Jobs For Employer
    $getTotalNumberOfJobsStmt = $conn->prepare("SELECT COUNT(job.id) 
                                                    FROM jobs job
                                                    WHERE job.employer_id = :job_employer_id");
    $getTotalNumberOfJobsStmt->bindParam(':job_employer_id', $recruiterEmployerId, PDO::PARAM_INT);
    $getTotalNumberOfJobsStmt->execute();
    $getTotalNumberOfJobs = $getTotalNumberOfJobsStmt->fetchColumn();

    // Check if the total jobs exceed or not
    if('1' == $getEmployerMembershipInfo && (int)$getTotalNumberOfJobs < 5){
        $canPostJob = TRUE;
    }else if ('2' == $getEmployerMembershipInfo){ 
        $canPostJob = TRUE;
    }else{
        $canPostJob = FALSE;
    }

    // Get Application Data for a Given Recruiter
    $getApplicationInfoStmt = $conn->prepare("SELECT a.id, a.job_seeker_id, a.job_id, a.date_applied, a.status
                                                FROM applications a 
                                                LEFT JOIN jobs jo
                                                ON a.job_id = jo.id
                                                LEFT JOIN recruiters re
                                                ON jo.recruiter_id = re.id
                                                WHERE jo.recruiter_id = :jo_recruiter_id");
    $getApplicationInfoStmt->bindParam(':jo_recruiter_id', $recruiterId, PDO::PARAM_INT);
    $getApplicationInfoStmt->execute();



?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Recruiter Dashboard</title>
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
            <a class="nav-item nav-link active" href="#">Dashboard<span class="sr-only">(current)</span></a>
            <a class="nav-item nav-link" href="#">Membership</a>
            <a class="nav-item nav-link" href="#">Contact Us</a>
          </div>
        </div>
        <span class="logo-image"><img src="../../logo.png" class="logo"></span>
        </div>
      </nav>
      <h1><?php echo $recruiterName . "'s Dashboard";?></h1>
      
      <h2>Your Jobs</h2>
      <h6>Here is a quick glance of all the jobs you've published with us.</h6>
      <br>
      <table class="table table-striped">
          <thead>
              <tr>
                  <td>Job ID</td>
                  <td>Date Posted</td>
                  <td>Job Title</td>
                  <td>Description</td>
                  <td>Required Experience (Years)</td>
                  <td>Status</td>
                  <td>Actions</td>
              </tr>
          </thead>

          <tbody>
              <?php while ($row = $getJobListingStmt->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) { ?>
                  <tr>
                        <td> <?php echo $row['j.id']; ?> </td>
                        <td> <?php echo $row['j.date_posted']; ?> </td>
                        <td> <?php echo $row['j.title']; ?> </td>
                        <td> <?php echo $row['j.description']; ?> </td>
                        <td> <?php echo $row['j.required_experience']; ?> </td>
                        <td> <?php echo $row['j.status']; ?> </td>
                        <td>
                            <a href="./editJob.php?job_id=<?= $row["j.id"] ?>">Edit</a><br>    
                            <a href="./deleteJob.php?job_id=<?= $row["j.id"] ?>">Delete</a>
                        </td>
                  </tr>
              <?php } ?>
          </tbody>
      </table>

      <br>
        <?php 
            if($canPostJob){ ?>
                <center><a href="./createJob.php" class="btn btn-outline-success">Add a New Job</a></center>
            <?php   } else {?>
                <center><a href="./index.php" class="btn btn-outline-success">Limit Reached For Your Employer's Account: Can't Post New Jobs</a></center>
                <?php   }?>
      <br>

      <h2>Your Applications</h2>
      <h6>Here is a quick glance of all the applications.</h6>
      <br>
      <table class="table table-striped">
          <thead>
              <tr>
                  <td>Application ID</td>
                  <td>Job ID</td>
                  <td>Applicant ID</td>
                  <td>Date Applied</td>
                  <td>Status</td>
                  <td>Actions</td>
              </tr>
          </thead>

          <tbody>
             <?php while ($data = $getApplicationInfoStmt->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)){?>
                        <tr>
                            <td> <?php echo $data['a.id']; ?> </td>
                            <td> <?php echo $data['a.job_id']; ?> </td>
                            <td> <?php echo $data['a.job_seeker_id']; ?> </td>
                            <td> <?php echo $data['a.date_applied']; ?> </td>
                            <td> <?php echo $data['a.status']; ?> </td>
                            <td>
                                <a href="./editApplication.php?application_id=<?= $data["a.id"] ?>">Edit</a><br>    
                            </td>
                        </tr>
            <?php  } ?>
          </tbody>
      </table>
      <br>
      <div class="footer">
        © 2021 Copyright: Dunya Oguz, Azman Akhter, John Purcell
      </div>

    </body>
</html>
