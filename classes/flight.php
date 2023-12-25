<?php

require_once('connection.php');

class flight extends connection{

    public $cities = array();

    public function getPassengerFlights($passenger_id){
        $conn = $this->getConnection();
        $query = "SELECT * FROM Flight WHERE id IN (SELECT flight_id FROM Passenger_Flight WHERE passenger_id = $passenger_id)";
        $result = mysqli_query($conn, $query);
        $resultArray = array();
        while($row = mysqli_fetch_assoc($result)){
            $resultArray[] = $row;
        }
        
        $conn->close();
        
        foreach($resultArray as &$row ){
            $row['cities'] = $this->getFlightCities($row['id']);
        }

        return $resultArray;
    }

    public function getCompanyFlights($company_id)
    {
        $conn = $this->getConnection();
        $query = "SELECT * FROM Flight WHERE company_id = $company_id";
        $result = mysqli_query($conn, $query);
        $resultArray = array();
        while($row = mysqli_fetch_assoc($result)){
            $resultArray[] = $row;
        }
        
        $conn->close();
        
        foreach($resultArray as &$row ){
            $row['cities'] = $this->getFlightCities($row['id']);
        }

        return $resultArray;
    }

    public function getFlightsFromTo(){
        $conn = $this->getConnection();
        $from = mysqli_real_escape_string($conn, $_GET['from']);
        $to = mysqli_real_escape_string($conn, $_GET['to']);
        $query = "SELECT * FROM Flight WHERE id IN (SELECT flight_id FROM Flight_City WHERE city_name = '$from') AND id IN (SELECT flight_id FROM Flight_City WHERE city_name = '$to')";
        $result = mysqli_query($conn, $query);
        $resultArray = array();
        while($row = mysqli_fetch_assoc($result)){
            $resultArray[] = $row;
        }
        
        $conn->close();
        
        // foreach($resultArray as &$row ){
        //     $row['cities'] = $this->getFlightCities($row['id']);
        // }

        return $resultArray;
    }

    
    private function getFlightCities($flight_id){
        $conn = $this->getConnection();
        $query = "SELECT * FROM Flight_City WHERE flight_id = $flight_id";
        $result = mysqli_query($conn, $query);
        $resultArray = array();
        while($row = mysqli_fetch_assoc($result)){
            $resultArray[] = $row;
        }
        $conn->close();
        return $resultArray;
    }



}



?>