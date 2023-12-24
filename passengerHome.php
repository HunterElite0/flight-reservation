<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Home</title>
    <link rel="stylesheet" href="assets/css/passengerHome.css" />
    <link rel="shortcut icon" type="image/icon" href="assets/logo/favicon.png"/>
  </head>
  <body>

    <div id="top-menue">
      <div class="group-account-info">
        <img src="/assets/images/blog/b1.jpg" id="profile-pic">
        <label id="name">Name</label>
        <label id="email">Email</label>
        <label id="phone">Phone</label>
      </div>

      <div>
        <a href="passengerSearch.php" target="_self" > <img src="/assets/svg/search.svg" id="svg" onclick=""> </a>
        <a href="passengerProfile.php" target="_self"> <img src="/assets/svg/profile-user.svg" id="svg"> </a>
      </div>

    </div>

    <div class="group-flights">

      <div class="flights-info" id="completed">
        <label id="info">Completed Flights</label>
        <div id="flight-info">
          <label>Flight Number</label>
          <label>Flight Date</label>
          <label>Flight Time</label>
          <label>company</label>
          <label>From</label>
          <label>To</label>
        </div>
      </div>

      <div class="flights-info" id="pending">
        <label id="info">Pending Flights</label>
        <div id="flight-info">
          <label>Flight Number</label>
          <label>Flight Date</label>
          <label>Flight Time</label>
          <label>company</label>
          <label>From</label>
          <label>To</label>
        </div>
      </div>

    </div>
  </body>
</html>
