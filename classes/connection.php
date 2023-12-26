<?php

class connection
{
    private $servername = "db";
    private $username = "root";
    private $password = "EGYPTAIR";
    private $dbname = "EGYPTAIR";

    public function getConnection()
    {
        $conn = mysqli_connect($this->servername, $this->username, $this->password, $this->dbname) or die("Connection failed: " . mysqli_connect_error());
        return $conn;
    }
}
