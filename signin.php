<?php

  session_start();
  if (isset($_SESSION['id'])) {
    if($_SESSION['account_type'] == 'Passenger')
      header('Location: passengerHome.php');
    else
      header('Location: companyHome.php');
  }
  
  else if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once('classes/user.php');
    $user = new User();
    $user->signIn($_POST['email'], $_POST['password']);
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
        <input type="submit" name="submit" value="submit" />
      </form>
      <p>New user? <a href="signup.php">Create an account</a></p>
    </div>
  </body>
</html>
