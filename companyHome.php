<?php

    session_start();

    if(!isset($_SESSION['id'])){
        session_destroy();
        header('Location: signin.php');
    }

    else if(isset($_GET['logout'])){
        session_destroy();
        header('Location: signin.php');
    }

    require_once('classes/user.php');
    require_once('classes/flight.php');
    $user = new User();
    $user->setAccount();

    function displayFlights($id){
        $flight = new Flight();
        $flights = $flight->getCompanyFlights($id);
        foreach($flights as $flight){
            echo '<a href=flightDetails.php?flight_id='.$flight['id'].'>
                    <li>
                        <span>Flight Name: '.$flight['name'].'</span>
                        <span>Flight Id: '.$flight['id'].'</span>
                    </li>
                  </a>';
        }
    }
?>



<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel= stylesheet href="assets/css/companyHome.css">
    <script src="assets/js/addFlight.js"></script>
    <title>Home</title>
</head>
<body>
    <div id="main">
        <header>
            <h1><?php echo $user->data['name'] ?></h1>
            <a><img id="company-logo" type="image" src="<?php echo $user->data['logo'] ?>" alt="Company Logo"></a>
            <div class="icon-container">
                <a href="#" ><img id="profile-icon" src="assets/svg/profile-user.svg" alt="Profile Icon"></a>
                <a href="#" ><img id="messages-icon" src="assets/svg/messages.svg" alt="Messages Icon"></a>
                <a href="companyHome.php?logout=true" target="_self"> <img id="logout-icon" src="/assets/svg/logout.svg"></a>
            </div>
        </header>
        <div class="wrapper">
            <h2 id="flights-header" >Flights:</h2>
            <ul>
                <?php displayFlights($user->data['id']) ?>
            </ul>
        </div>
        <div class="flight-buttons">
            <button class="flight-button" onclick="showForm()" >Add Flight</button>
        </div>
    </div>
    <div class="form-popup" id="popup">
            <form class="form-class" action="" method="">
                <div class="form-group">
                    <input type="text" name="flight-name" placeholder="Flight Name" required />
                </div>
                <div class="form-group">
                    <input type="number" name="flight-fees" placeholder="Flight Fees" required />
                </div>
                <div class="form-group">
                    <input type="number" name="flight-seats" placeholder="Flight Seats" required />
                </div>
                <div class="form-group">
                    <input type="text" name="flight-source" placeholder="Flight Source" required />
                </div>
                <div class="form-group" id="destinations">
                    <input type="text" name="flight-destination" placeholder="Flight Destination" required />
                </div>
                <div class="controls">
                    <button class="add" onclick="add()"><i class="fa fa-plus"></i>Add Destination</button>
                    <button class="remove" onclick="remove()"><i class="fa fa-minus"></i>Remove Destination</button>
                </div>
                <input type="submit" name="submit" value="Submit" />
                <button type="button" class="cancel" onclick="closeForm()">Cancel</button>
            </form>
        </div>
</body>
</html>