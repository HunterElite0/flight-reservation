<?php

session_start();

if (!isset($_SESSION['id'])) {
  header('Location: signin.php');
}

if ($_SESSION['account_type'] != '0') {
  header('Location: passengerProfile.php');
}

require_once('classes/user.php');
$user = new User();
$user->setAccount();

if (isset($_POST['submit'])) {
  if ($user->updateCompany()) {
    header('Location: companyHome.php');
  }
  echo "<script>alert('Invalid data')</script>";
}

?>

<head>
  <meta charset="UTF-8" />
  <title>EgyptAir - profile</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="shortcut icon" type="image/icon" href="assets/logo/favicon.png" />
  <link rel="stylesheet" type="text/css" href="assets/css/form2.css" />
  <script src="assets/js/updatePhoto.js"></script>
</head>

<body>
  <div class="form-container">
    <h1 class="form-header">Profile</h1>
    <img id="pic" src=<?php echo "'" . $user->data['logo'] . "'" ?>>
    <form class="form-class" action="passengerProfile.php" method="POST">
      <div class="form-group">
        <input type="text" id="name" name="name" placeholder="Name" required <?php echo "value='" . $user->data['name'] . "'" ?> />
      </div>
      <div class="form-group">
        <input type="email" id="email" name="email" placeholder="Email" required <?php echo "value='" . $user->data['email'] . "'" ?> />
      </div>
      <div class="form-group">
        <input type="tel" id="phone" name="phone" placeholder="Phone" required <?php echo "value='" . $user->data['tel'] . "'" ?> />
      </div>
      <div class="form-group">
        <input type="password" id="password" name="password" placeholder="Password" />
      </div>
      <div id="company-div" class="form-group">
        <textarea id="company-bio" name="company-bio" placeholder="Enter your company's bio" required> <?php echo $user->data['bio'] ?> </textarea>
        <input type="text" id="company-address" name="company-address" placeholder="Company Address" required <?php echo "value='" . $user->data['address'] . "'" ?> />
        <input type="text" id="company-location" name="company-location" placeholder="Company Location" required <?php echo "value='" . $user->data['location'] . "'" ?> />
        <input type="text" id="company-logo" name="company-logo" placeholder="Company Logo" required <?php echo "value='" . $user->data['logo'] . "'" ?> />
      </div>
      <input type="submit" name="submit" value="Update">
      <button type="button" onclick="window.location.href='companyHome.php'">back</button>
    </form>
  </div>
</body>