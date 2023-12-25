<?php

  session_start();

  require_once('classes/user.php');
  $user = new User();
  $user->setAccount();

  if(isset($_POST['submit'])){
    if($user->updatePassenger()){
      header('Location: passengerHome.php');
    }
    echo "<script>alert('Invalid data')</script>";
  }

?>

<head>
  <meta charset="UTF-8" />
  <title>EgyptAir - profile</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="shortcut icon" type="image/icon" href="assets/logo/favicon.png"/>
  <link rel="stylesheet" type="text/css" href="assets/css/form2.css" />
  <script src="assets/js/updatePhoto.js"></script>
</head>
<body>
  <div class="form-container">
    <h1 class="form-header">Profile</h1>
    <img id="pic" src= <?php echo "'".$user->data['photo']."'" ?> >
    <form class="form-class" action="passengerProfile.php" method="POST" >
      <div class="form-group">
        <input type="text" id="name" name="name" placeholder="Name" required <?php echo "value='".$user->data['name']."'" ?> />
      </div>
      <div class="form-group">
        <input type="email" id="email" name="email" placeholder="Email" required <?php echo "value='".$user->data['email']."'" ?> />
      </div>
      <div class="form-group">
        <input type="tel" id="phone" name="phone" placeholder="Phone" required <?php echo "value='".$user->data['tel']."'" ?> />
      </div>
      <div class="form-group">
        <input type="password" id="password" name="password" placeholder="Password" />
      </div>
      <div id="passenger-div" class="form-group">
        <input type="text" id="passenger-photo" name="passenger-photo" placeholder="Link to Passenger Photo" oninput="updatePhoto()" <?php echo "value='".$user->data['photo']."'" ?> />
        <input type="text" id="passnger-passport" name="passenger-passport" placeholder="Link to Passenger Passport" <?php echo "value='".$user->data['passport_img']."'" ?> />
      </div>
      <input type="submit" name="submit" value="Update">
      <button type="button" onclick="window.location.href='passengerHome.php'">back</button>
    </form>
  </div>
</body>