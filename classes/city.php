<?php

require_once('connection.php');

class city extends connection{

    public $cities = array();

    public function getCities(){
        $conn = $this->getConnection();
        $query = "SELECT * FROM City";
        $result = mysqli_query($conn, $query);
        $resultArray = array();
        while($row = mysqli_fetch_assoc($result)){
            $resultArray[] = $row;
        }
        $conn->close();
        $this->cities = $resultArray;
        return true;
    }


}

?>