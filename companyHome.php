<?php
session_start();

if (!isset($_SESSION['id'])) {
    session_destroy();
    header('Location: signin.php');
} else if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: signin.php');
} else if (!empty($_POST)) {
    require_once('classes/user.php');
    $user = new User();
    $user->setAccount();
    require_once('classes/flight.php');
    $flight = new Flight();
    $flight->addFlight($user->data['id']);
    $_POST = array();
    header('Location: companyHome.php');
}

require_once('classes/user.php');
$user = new User();
$user->setAccount();

function displayFlights($id)
{
    require_once('classes/flight.php');
    $flight = new Flight();
    $flights = $flight->getCompanyFlights($id);
    foreach ($flights as $flight) {
        echo '<a href=companyFlightDetails.php?flight_id=' . $flight['id'] . '>
                    <li>
                        <span>Flight Name: ' . $flight['name'] . '</span>
                        <span>Flight Id: ' . $flight['id'] . '</span>
                    </li>
                  </a>';
    }
}
?>



<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/icon" href="assets/logo/favicon.png" />
    <link rel=stylesheet href="assets/css/companyHome2.css">
    <script src="assets/js/addFlight.js"></script>
    <title>Home</title>
</head>

<body>
    <div id="main">
        <header>
            <h1><?php echo $user->data['name'] ?></h1>
            <img id="company-logo" type="image" src="<?php echo $user->data['logo'] ?>" alt="Company Logo">
            <div class="icon-container">
                <a href="companyProfile.php"><img id="profile-icon" src="assets/svg/profile-user.svg" alt="Profile Icon"></a>
                <a onclick="showForm('1')"><img id="messages-icon" src="assets/svg/messages.svg" alt="Messages Icon"></a>
                <a href="companyHome.php?logout=true" target="_self"> <img id="logout-icon" src="/assets/svg/logout.svg"></a>
            </div>
        </header>
        <div class="wrapper">
            <h2 id="flights-header">Flights:</h2>
            <ul>
                <?php displayFlights($user->data['id']) ?>
            </ul>
        </div>
        <div class="flight-buttons">
            <button class="flight-button" onclick="showForm()">Add Flight</button>
        </div>
    </div>
    <div class="form-popup" id="popup">
        <form class="form-class" action="companyHome.php" method="POST">
            <div class="form-group">
                <input type="text" name="flight-name" placeholder="Flight Name" required />
            </div>
            <div class="form-group">
                <input type="number" name="flight-fees" placeholder="Flight Fees" required />
            </div>
            <div class="form-group">
                <input type="number" name="flight-seats" placeholder="Flight Seats" required />
            </div>
            <div class="form-group-grid">
                <input type="text" name="flight-destination[]" placeholder="Flight Source" required />
                <input onfocus="(this.type='datetime-local')" onblur="(this.type='text')" type="text" name="flight-departure[]" placeholder="Flight Departure Time" required />
                <input onfocus="(this.type='datetime-local')" onblur="(this.type='text')" type="text" name="flight-arrival[]" placeholder="Flight Arrival Time" required />
            </div>
            <div class="form-group-grid" id="destinations">
                <input type="text" name="flight-destination[]" placeholder="Flight Destination" required />
                <input onfocus="(this.type='datetime-local')" onblur="(this.type='text')" type="text" name="flight-departure[]" placeholder="Flight Departure Time" required />
                <input onfocus="(this.type='datetime-local')" onblur="(this.type='text')" type="text" name="flight-arrival[]" placeholder="Flight Arrival Time" required />
            </div>
            <div class="controls">
                <button class="add" type="button" onclick="add()">Add Destination</button>
                <button class="remove" type="button" onclick="remove()">Remove Destination</button>
            </div>
            <input type="submit" name="submit" value="Submit" />
            <button type="button" class="cancel" onclick="closeForm()">Cancel</button>
        </form>
    </div>

    <div class="form-popup" id="popup1">

        <?php
        require_once('classes/message.php');
        $messages = getMessages($user->data['id']);

        foreach ($messages as $message) {
            echo "<div class='box' id='message-info'>";
            foreach ($message as $key => $val) {
                if ($key == 'm_to') continue;
                echo "<label> " . $key . ": " . $val . "</label> <br>";
            }
            echo "</div>";
        }

        ?>
        <button type="button" class="cancel" onclick="closeForm('1')">Cancel</button>

    </div>
</body>

</html>