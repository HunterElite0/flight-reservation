<?php

  session_start();
  if(!isset($_SESSION["id"]))
  {
    header('Location: signin.php');
  }

  if($_SESSION['account_type'] == 'Company' || $_SESSION['account_type'] == '0')
  {
    header('Location: companyHome.php');
  }

  if(isset($_GET['logout']))
  {
    session_destroy();
    header('Location: signin.php');
  }
  
  require_once('classes/user.php');
  require_once('classes/flight.php');
  $user = new User();
  $user->setAccount();
  $flight = new Flight();
  $flights = $flight->getPassengerFlights($user->data['id']);

  // echo '<pre>';
  //   var_dump($flights);
  // echo '</pre>';

  function displayFlight($target,$flights){
    foreach($flights as $curr){
      if($curr['complete']!=$target) continue;
      echo "<div class='box' id='flight-info'>";

        foreach($curr as $key => $val){
          if($key=="cities") break;
          echo "<label> ". $key.": ". $val ."</label> <br>"; 
        }

        foreach($curr['cities'] as $city){
          echo "<div class='box' id='city-info'>";
          foreach($city as $key => $val){
            if($key=='flight_id' || $key=='flight_order') continue;
            echo "<label> ". $key.": ". $val ."</label> <br>"; 
          }
          echo "</div>";
        }

      echo "</div>";

    };
  }

?>


<head>
  <meta charset="UTF-8">
  <title>Home</title>
  <link rel="stylesheet" href="assets/css/passengerHome2.css" />
  <link rel="shortcut icon" type="image/icon" href="assets/logo/favicon.png"/>
</head>
<body>

  <div id="top-menue">
    <div class="group-account-info">
      <img src=<?php echo $user->data["photo"] ?> id="profile-pic">
      <label id="name"> <?php echo $user->data["name"] ?>  </label>
      <label id="email"> <?php echo $user->data["email"] ?> </label>
      <label id="phone"> <?php echo $user->data["tel"] ?> </label>
    </div>

    <div>
      <a href="passengerHome.php?logout=true" target="_self"> <img src="/assets/svg/logout.svg" id="svg"> </a>
      <a href="passengerSearch.php" target="_self" > <img src="/assets/svg/search.svg" id="svg" onclick=""> </a>
      <a href="passengerProfile.php" target="_self"> <img src="/assets/svg/profile-user.svg" id="svg"> </a>
    </div>

  </div>

  <div class="group-flights">

    <div class="flights-info" id="completed">
      <label id="info">Completed Flights</label>
      <?php
        displayFlight('1',$flights)
      ?>
    </div>

    <div class="flights-info" id="pending">
      <label id="info">Pending Flights</label>
      <?php
        displayFlight('0',$flights)
      ?>
    </div>

  </div>
</body>

