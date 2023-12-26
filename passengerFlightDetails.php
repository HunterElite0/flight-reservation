<?php

session_start();

if (!isset($_SESSION['id'])) {
    session_destroy();
    header('Location: signin.php');
}
//   echo '<pre>';
//     var_dump($_SESSION);
//   echo '</pre>';
// if($_SESSION['account_type'] == '1')
//     header('Location: passengerHome.php');
if ($_SESSION['account_type'] == '0')
    header('Location: companyHome.php');

require_once('classes/flight.php');
$flight = new Flight();

if (isset($_GET['flight_id'])) {
    $_SESSION['flight_id'] = $_GET['flight_id'];
    $_SESSION['f_from'] = $_GET['f_from'];
    $_SESSION['f_to'] = $_GET['f_to'];
}

if (isset($_GET['submit'])) {

    if ($flight->reserveFlight($_SESSION['id']))
        header('Location: passengerHome.php');
    else
        echo "<script>alert('Error booking the flight')</script>";
}

$flight_obj = $flight->getFlight($_SESSION['flight_id']);

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    require_once('classes/message.php');
    sendMessage($_SESSION['id'], $flight_obj['company_id'], $_POST['message']);

    $_SERVER['REQUEST_METHOD'] = "";
}

?>


<head>
    <meta charset="UTF-8" />
    <title>EgyptAir - flight details</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" type="image/icon" href="assets/logo/favicon.png" />
    <link rel="stylesheet" type="text/css" href="assets/css/form.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/passengerHome2.css" />
    <script src="assets/js/addFlight.js"></script>
</head>

<body>
    <div class="form-container" id="main">
        <h1 class="form-header"><?php echo $flight_obj['name'] ?></h1>
        <form class="form-class" action="passengerFlightDetails.php" method="GET">
            <div class="form-group">
                <?php
                foreach ($flight_obj as $key => $val) {
                    if ($key != 'id' && $key != 'name' && $key != 'cities')
                        echo "<label>" . $key . ": " . $val . "</label> <br>";
                }
                ?>
            </div>
            <br>
            <div>
                <input type="radio" name="payment-type" value="cash" />
                <label>cash</label>
                <input type="radio" name="payment-type" value="credit" required />
                <label>credit</label>
            </div>

            <input type="hidden" name="flight_id" value=<?php echo $_SESSION['flight_id'] ?>>
            <input type="hidden" name="f_from" value=<?php echo  $_SESSION['f_from'] ?>>
            <input type="hidden" name="f_to" value=<?php echo $_SESSION['f_to'] ?>>

            <input type="submit" name="submit" value="book">
            <button type="button" onclick="window.location.href='passengerSearch.php'">back</button>
            <button type="button" onclick="showForm()">message</button>
        </form>
    </div>
    <div class="form-popup" id="popup">
        <form class="form-class" action="passengerFlightDetails.php" method="POST">
            <div class="form-group">
                <input type="text" name="message" placeholder="message the company" required />
            </div>
            <input type="hidden" name="m_from" value=<?php echo $_SESSION['id'] ?>>
            <input type="hidden" name="m_to" value=<?php echo $flight_obj['company_id'] ?>>
            <input type="submit" name="submit" value="Submit" />
            <button type="button" class="cancel" onclick="closeForm()">Cancel</button>
        </form>
    </div>
</body>