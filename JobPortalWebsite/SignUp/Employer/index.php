<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../../style.css">
    <title>Employer Sign Up</title>
    <script>
        $(document).ready(function(){
          $('[data-toggle="popover"]').popover();
        });
    </script>
</head>
<body>
  <nav class="navbar navbar-light bg-light">
    <span class="navbar-brand mb-0 h1">DAJ Recruitment Platform</span>
    <span class="logo-image"><img src="../../logo.png" class="logo"></span>
  </nav>
  <h1>Tell us a bit more about your situation</h1>
  <div class="d-flex justify-content-center">
    <div class="button">
      <a href='./Company/' class="btn btn-outline-success btn-lg">I want to register a company</a>
    </div>
    <div class="button">
      <a href='./Recruiter/' class="btn btn-outline-success btn-lg" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="Make sure your company is already registered on the platform!">I am a recruiter working for a company</a>
    </div>
  </div>
  <div class="footer">
    © 2021 Copyright: Dunya Oguz, Azman Akhter, John Purcell
  </div>
</body>
</html>
