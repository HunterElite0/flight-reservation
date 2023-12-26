<?php

require_once('connection.php');

class flight extends connection
{

    public function getPassengerFlights($passenger_id)
    {
        $conn = $this->getConnection();
        $query = "SELECT * FROM Flight WHERE id IN (SELECT flight_id FROM Passenger_Flight WHERE passenger_id = $passenger_id)";
        $result = mysqli_query($conn, $query);
        $resultArray = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $resultArray[] = $row;
        }

        $conn->close();

        foreach ($resultArray as &$row) {
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
        while ($row = mysqli_fetch_assoc($result)) {
            $resultArray[] = $row;
        }

        $conn->close();

        foreach ($resultArray as &$row) {
            $row['cities'] = $this->getFlightCities($row['id']);
        }

        return $resultArray;
    }

    public function getFlightsFromTo($passenger_id)
    {
        $conn = $this->getConnection();
        $from = mysqli_real_escape_string($conn, $_GET['from']);
        $to = mysqli_real_escape_string($conn, $_GET['to']);
        $query = "SELECT * FROM Flight WHERE id IN (SELECT flight_id FROM Flight_City WHERE city_name = '$from') AND id IN (SELECT flight_id FROM Flight_City WHERE city_name = '$to') AND complete = 0 and pending_passengers > 0";
        $result = mysqli_query($conn, $query);
        $resultArray = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $resultArray[] = $row;
        }

        $conn->close();

        // foreach($resultArray as &$row ){
        //     $row['cities'] = $this->getFlightCities($row['id']);
        // }

        return $resultArray;
    }


    private function getFlightCities($flight_id)
    {
        $conn = $this->getConnection();
        $query = "SELECT * FROM Flight_City WHERE flight_id = $flight_id";
        $result = mysqli_query($conn, $query);
        $resultArray = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $resultArray[] = $row;
        }
        $conn->close();
        return $resultArray;
    }


    public function getFlight($flight_id)
    {
        $conn = $this->getConnection();
        $query = "SELECT * FROM Flight WHERE id = $flight_id";
        $result = mysqli_query($conn, $query);
        $resultArray = mysqli_fetch_assoc($result);
        $conn->close();

        $resultArray['cities'] = $this->getFlightCities($flight_id);

        return $resultArray;
    }


    public function reserveFlight($passenger_id)
    {
        $flight_id = $_GET['flight_id'];
        $f_from = $_GET['f_from'];
        $f_to = $_GET['f_to'];

        if (!$this->checkSeats($flight_id)) {
            return false;
        }

        $conn = $this->getConnection();
        $conn->begin_transaction();
        try {
            $query = "INSERT INTO Passenger_Flight (passenger_id, flight_id,f_from,f_to) VALUES ($passenger_id, $flight_id, '$f_from', '$f_to')";
            $result = mysqli_query($conn, $query);

            if (!$result) {
                $conn->rollback();
                return false;
            }

            $query = "UPDATE Flight SET pending_passengers = pending_passengers - 1, registered_passengers=registered_passengers+1 WHERE id = $flight_id";
            $result = mysqli_query($conn, $query);

            if (!$result) {
                $conn->rollback();
                return false;
            }

            if ($_GET['payment-type'] == 'credit') {
                $query = "UPDATE Passenger SET balance = balance - (SELECT fees FROM Flight WHERE id = $flight_id) WHERE id = $passenger_id";
                $result = mysqli_query($conn, $query);
                if (!$result) {
                    $conn->rollback();
                    return false;
                }
            }
        } catch (Exception $e) {
            $conn->rollback();
            return false;
        }
        // $query = 
        $conn->commit();
        $conn->close();
        return true;
    }


    private function checkSeats($flight_id)
    {
        $conn = $this->getConnection();
        $query = "SELECT pending_passengers FROM Flight WHERE id = $flight_id";
        $result = mysqli_query($conn, $query);
        $resultArray = mysqli_fetch_assoc($result);
        $conn->close();
        return (int)$resultArray['pending_passengers'] > 0;
    }


    public function addFlight($id)
    {
        $conn = $this->getConnection();

        $flight_name = mysqli_real_escape_string($conn, $_POST['flight-name']);
        $flight_fees = mysqli_real_escape_string($conn, $_POST['flight-fees']);
        $flight_seats = mysqli_real_escape_string($conn, $_POST['flight-seats']);
        $flight_departures = $_POST['flight-departure'];
        $flight_arrivals = $_POST['flight-arrival'];
        $flight_destinations = $_POST['flight-destination'];

        $query = "INSERT INTO Flight (name, fees, complete, pending_passengers, registered_passengers, company_id) VALUES ('$flight_name', $flight_fees, 0,$flight_seats, 0, $id)";
        $result = mysqli_query($conn, $query);
        $flight_id = mysqli_insert_id($conn);

        for ($i = 0; $i < count($flight_destinations); $i++) {
            $flight_destination = mysqli_real_escape_string($conn, $flight_destinations[$i]);

            try {
                $query = "INSERT INTO City (name) VALUES ('$flight_destination')";
                $result = mysqli_query($conn, $query);
            } catch (\Throwable $th) {
            }

            $query = "INSERT INTO Flight_City (flight_id, city_name, flight_order, start_time, end_time) VALUES ('$flight_id', '$flight_destination', '$i' + 1, '$flight_departures[$i]', '$flight_arrivals[$i]')";
            $result = mysqli_query($conn, $query);
        }

        $conn->close();
    }

    public function removeFlight($flight_id)
    {
        $conn = $this->getConnection();

        try {
            $conn->begin_transaction();


            $query  = "UPDATE Passenger
            JOIN Passenger_Flight ON Passenger.id = Passenger_Flight.passenger_id
            JOIN Flight ON Flight.id = Passenger_Flight.flight_id
            SET Passenger.balance = Passenger.balance + Flight.fees
            WHERE Flight.id = $flight_id";
            mysqli_query($conn, $query);

            $query = "DELETE FROM Passenger_Flight WHERE flight_id = $flight_id";
            mysqli_query($conn, $query);

            $query = "DELETE FROM Flight WHERE id = $flight_id";
            mysqli_query($conn, $query);

            $conn->commit();
            return true;
        } catch (mysqli_sql_exception $e) {
            echo "<script>alert('Error: " . $e->getMessage() . "')</script>";
            $conn->rollback();
            return false;
        }



        $conn->close();
        return true;
    }
}
