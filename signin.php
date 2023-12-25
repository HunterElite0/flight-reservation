<?php

session_start();
require_once('classes/user.php');

  if (isset($_SESSION['id'])) {
    // echo '<pre>';
    //   var_dump($_SESSION);
    // echo '</pre>';
    if($_SESSION['account_type'] == '1')
      header('Location: passengerHome.php');
    else if($_SESSION['account_type'] == '0')
      header('Location: companyHome.php');
  }
  
  else if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = new User();
    if($user->signIn($_POST['email'], $_POST['password']) == true){
      header('Location: signin.php');
    }else{
      echo "<script>alert('Invalid username or password')</script>";
      echo "<script> $('.form-class')[0].reset(); </script>"; 
    }
  }

?>


<html>
  <head>
    <title>EgyptAir - Sign In</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" type="image/icon" href="assets/logo/favicon.png"/>
    <link rel="stylesheet" type="text/css" href="assets/css/form.css" />
  </head>
  <body>
    <div class="form-container">
      <h1 class="form-header">Sign In</h1>
      <form class="form-class" action="signin.php" method="POST">
        <div class="form-group">
          <input type="text" name="email" placeholder="Email" required />
        </div>
        <div class="form-group">
          <input
            type="password"
            name="password"
            placeholder="Password"
            required
          />
        </div>
        <input type="submit" name="submit" value="Submit" />
      </form>
      <p>New user? <a href="signup.php">Create an account</a></p>
    </div>
  </body>
</html>
