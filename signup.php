<?php

  session_start();
  if (isset($_SESSION['id'])) {

    if($_SESSION['account_type'] == '1')
      header('Location: passengerHome.php');
    else if($_SESSION['account_type'] == '0')
      header('Location: companyHome.php');

    session_destroy();
  }
  else if(!empty($_POST)){
    require_once('classes/user.php');
    $user = new User();
    $request = $user->signup();
    if($request){
      header('Location: signin.php');
    }
    else{
      echo '<script>alert("' . $request . '")</script>';
    }
    $_POST = array();
  }
  
?>


<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>EgyptAir - Sign Up</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" type="image/icon" href="assets/logo/favicon.png"/>
    <link rel="stylesheet" type="text/css" href="assets/css/form.css" />
    <script src="assets/js/signup.js"></script>
  </head>
  <body>
    <div class="form-container">
      <h1 class="form-header">Sign Up</h1>
      <form class="form-class" action="signup.php" method="POST" >
        <div class="form-group">
          <input type="text" id="name" name="name" placeholder="Name" required />
        </div>
        <div class="form-group">
          <input type="email" id="email" name="email" placeholder="Email" required />
        </div>
        <div class="form-group">
          <input type="tel" id="phone" name="phone" placeholder="Phone" required />
        </div>
        <div class="form-group">
          <input type="password" id="password" name="password" placeholder="Password" required />
        </div>
        <div>
          <input type="radio" name="account_type" value="company" onclick="showCompany()" />
          <label for="company">Company</label>
          <input type="radio" name="account_type" value="passenger" required onclick="showPassenger()" />
          <label for="passenger">Passenger</label>
        </div>
        <div id="company-div" class="form-group" hidden>
          <input type="text" id="company-name" name="company-name" placeholder="Company Name" />
          <textarea id="company-bio" name="company-bio" placeholder="Enter your company's bio"></textarea>
          <input type="text" id="company-address" name="company-address" placeholder="Company Address" />
          <input type="text" id="company-location" name="company-location" placeholder="Company Location" />
          <input type="text" id="company-logo" name="company-logo" placeholder="Company Logo" />
        </div>
        <div id="passenger-div" class="form-group" hidden>
          <input type="text" id="passenger-photo" name="passenger-photo" placeholder="Link to Passenger Photo" />
          <input type="text" id="passnger-passport" name="passenger-passport" placeholder="Link to Passenger Passport" />
        </div>
        <input type="submit" name="submit" value="Sign Up">
      </form>
      <div class="form-footer">
        <p>Already have an account? <a href="signin.php">Sign In</a></p>
      </div>
    </div>
  </body>
</html>
