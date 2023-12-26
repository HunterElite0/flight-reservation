<?php

session_start();

require_once('classes/flight.php');
$flight = new Flight();

if (!isset($_SESSION['id']))
    header('Location: login.php');

if (isset($_GET['flight_id']))
    $_SESSION['flight_id'] = $_GET['flight_id'];

$flight_obj = $flight->getFlight($_SESSION['flight_id']);


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['cancel'])) {
    $request = $flight->removeFlight($_SESSION['flight_id']);
    if ($request == true)
        header('Location: companyHome.php');
}

?>


<head>
    <meta charset="UTF-8" />
    <title>EgyptAir - flight details</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" type="image/icon" href="assets/logo/favicon.png" />
    <link rel="stylesheet" type="text/css" href="assets/css/form.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/companyHome2.css" />
    <script src="assets/js/addFlight.js"></script>
</head>

<body>
    <div class="form-container">
        <h1 class="form-header"><?php echo $flight_obj['name'] ?></h1>
        <form class="form-class" action="companyFlightDetails.php" method="POST">
            <div class="form-group">
                <?php
                foreach ($flight_obj as $key => $val) {
                    if ($key != 'id' && $key != 'name' && $key != 'cities')
                        echo "<label>" . $key . ": " . $val . "</label> <br>";
                }
                ?>
            </div>
            <br>
            <br>
            <input type="hidden" name="cancel" value="cancel" />
            <button type="button" class="submit" name="back" onclick="window.location.href='companyHome.php'">Go back</button>
            <input type="submit" class="cancel" value="Cancel flight" />
        </form>
    </div>
</body>