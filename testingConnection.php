<?php 

    require_once("classes/connection.php");
    // echo phpinfo();
    $mysql = new connection();
    $conn = $mysql->getConnection();

    $query = "SELECT * FROM User";
    $result = $conn->query($query);
    echo $result->num_rows;

?>