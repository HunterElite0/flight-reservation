
<head>
  <meta charset="UTF-8" />
  <title>EgyptAir - search</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="shortcut icon" type="image/icon" href="assets/logo/favicon.png"/>
  <link rel="stylesheet" type="text/css" href="assets/css/form2.css" />
  <script src="assets/js/updatePhoto.js"></script>
</head>
<body>
  <div class="form-container">
    <h1 class="form-header">Search</h1>
    <form class="form-class" action="passengerProfile.php" method="GET" >
      <div class="form-group">
        <input type="text" id="from" name="from" placeholder="from" required />
        <input type="text" id="to" name="to" placeholder="to" required />
      </div>
      <input type="submit" name="submit" value="Search">
      <button type="button" onclick="window.location.href='passengerHome.php'">back</button>
    </form>
  </div>
</body>