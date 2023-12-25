<?php
session_start();


if(!isset($_SESSION['id'])){
  header('Location: signin.php');
}

if($_SESSION['account_type'] == 'Company' || $_SESSION['account_type'] == '0'){
  header('Location: companyHome.php');
}

require_once('classes/city.php');
$city = new city();
$city->getCities();

  // echo '<pre>';
  //   var_dump($city->cities);
  // echo '</pre>';

function displayResults(){
    if(isset($_GET['submit'])){

        if(empty($_GET['from']) || empty($_GET['to']) || ( $_GET['from'] == $_GET['to'] )){
          echo "<p class='error'>Please fill all the fields with valid data</p>";
          return;
        }

        require_once('classes/flight.php');
        $flight = new Flight();
        $flights = $flight->getFlightsFromTo($_SESSION['id']);

        foreach($flights as $flight){
          echo " <a href=passengerFlightDetails.php?flight_id=".$flight['id']."&f_from=".$_GET['from']."&f_to=".$_GET['to']."> <div class='box' id='flight-info'> ";
          foreach($flight as $key => $val){
            echo "<label id='left'>". $key.": ".$val."</label> <br>";
          }
          echo " </div> </a> ";
        }
    }
}


?>


<head>
  <meta charset="UTF-8" />
  <title>EgyptAir - search</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="shortcut icon" type="image/icon" href="assets/logo/favicon.png"/>
  <link rel="stylesheet" type="text/css" href="assets/css/form2.css" />
  <link rel="stylesheet" type="text/css" href="assets/css/passengerHome2.css" />
  <script src="assets/js/updatePhoto.js"></script>
</head>
<body>
  <div class="form-container">
    <h1 class="form-header">Search</h1>
    <form class="form-class" action="passengerSearch.php" method="GET" >
      <div class="form-group">
        <select name="from">
          <option value="" disabled selected hidden>from</option>
          <?php
            foreach($city->cities as $c){
                echo '<option value="'.$c['name'].'">'.$c['name'].'</option>';
            }
          ?>
        </select>
        <select name="to">
          <option value="" disabled selected hidden>to</option>
          <?php
            foreach($city->cities as $c){
                echo '<option value="'.$c['name'].'">'.$c['name'].'</option>';
            }
          ?>
        </select>
      </div>
      <div>
        <?php displayResults() ?>
      </div>
      <input type="submit" name="submit" value="Search">
      <button type="button" onclick="window.location.href='passengerHome.php'">back</button>
    </form>
  </div>
</body>