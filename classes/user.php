<?php
require_once('connection.php');
class user extends connection
{
    public $data = array();

    public function signIn($email, $password)
    {
        $conn = $this->getConnection();
        $email = mysqli_real_escape_string($conn, $email);
        $password = mysqli_real_escape_string($conn, $password);

        if ($email == '' || $password == '')
            return false;

        $query = "SELECT id,password,account_type FROM User WHERE email = '$email'";
        $result = mysqli_query($conn, $query);
        $resultArray = mysqli_fetch_assoc($result);
        $conn->close();

        if (mysqli_num_rows($result) == 1 && password_verify($password, $resultArray['password'])) {
            $_SESSION['id'] = $resultArray['id'];
            $_SESSION['account_type'] = $resultArray['account_type'];
            // foreach($resultArray as $key => $value)
            // {
            //     if($key != 'password')
            //         $_SESSION[$key] = $value;
            // }
            // if($resultArray['account_type'] == '0'){
            //     $this->setAccount($resultArray['id'], 'Company');
            // }else{
            //     $this->setAccount($resultArray['id'], 'Passenger');
            // }
            return true;
        } else {
            return false;
            // header("Location: ../signin.php");
            // echo "<script>alert('Invalid username or password')</script>";
        }
    }


    public function setAccount()
    {
        $id = $_SESSION['id'];
        $account_type = $_SESSION['account_type'] == '0' ? 'Company' : 'Passenger';
        $conn = $this->getConnection();
        $query = "SELECT * FROM $account_type where id = $id ";
        $result = mysqli_query($conn, $query);
        $result1 = mysqli_fetch_assoc($result);

        foreach ($result1 as $key => $value) {
            $this->data[$key] = $value;
        }

        $query = "SELECT * FROM User where id = $id ";
        $result = mysqli_query($conn, $query);
        $result1 = mysqli_fetch_assoc($result);

        foreach ($result1 as $key => $value) {
            if ($key != 'password')
                $this->data[$key] = $value;
        }

        $conn->close();
    }


    public function signup()
    {
        $type = $_POST['account_type'] == 'passenger' ? 1 : 0;
        $conn = $this->getConnection();
        $password = password_hash(mysqli_real_escape_string($conn, $_POST['password']), PASSWORD_DEFAULT);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $phone = mysqli_real_escape_string($conn, $_POST['phone']);
        $conn->begin_transaction();
        // mysqli_begin_transaction($conn);
        try {
            $query = "INSERT INTO User (email, password, name, tel, account_type) VALUES ('$email', '$password', '$name', '$phone' , '$type')";
            $result = mysqli_query($conn, $query);
            $id = mysqli_insert_id($conn);

            if ($_POST['account_type'] == 'passenger') {
                $this->signupPassenger($id, $conn);
            } else {
                $this->signupCompany($id, $conn);
            }
            $conn->commit();
            $conn->close();
            return true;
        } catch (mysqli_sql_exception $exception) {
            $conn->rollback();
            $conn->close();
            if ($exception->getCode() == 1062)
                return "Error signing up, please try a different email.";
            else
                return "Please fill all the fields.";
        }
    }


    public function signupPassenger($id, $conn)
    {
        $photo = mysqli_real_escape_string($conn, $_POST['passenger-photo']);
        $passport = mysqli_real_escape_string($conn, $_POST['passenger-passport']);
        if ($photo != '' && $passport != '') {
            $query = "INSERT INTO Passenger (id, photo, passport_img ) VALUES ('$id' , '$photo', '$passport')";
            $result = mysqli_query($conn, $query);
        } else {
            throw new mysqli_sql_exception;
        }
    }


    public function signupCompany($id, $conn)
    {
        $bio = mysqli_real_escape_string($conn, $_POST['company-bio']);
        $address = mysqli_real_escape_string($conn, $_POST['company-address']);
        $logo = mysqli_real_escape_string($conn, $_POST['company-logo']);
        $location = mysqli_real_escape_string($conn, $_POST['company-location']);
        if ($bio != '' && $address != '' && $logo != '') {
            $query = "INSERT INTO Company (id, bio, address, location, logo ) VALUES ('$id' , '$bio', '$address', '$location', '$logo')";
            $result = mysqli_query($conn, $query);
        } else {
            throw new mysqli_sql_exception;
        }
    }

    public function updatePassenger()
    {
        $conn = $this->getConnection();

        $id = $_SESSION['id'];
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $phone = mysqli_real_escape_string($conn, $_POST['phone']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        $photo = mysqli_real_escape_string($conn, $_POST['passenger-photo']);
        $passport = mysqli_real_escape_string($conn, $_POST['passenger-passport']);

        if ($name != '' && $email != '' && $phone != '' && $photo != '' && $passport != '') {
            if ($password != '') {
                $password = password_hash($password, PASSWORD_DEFAULT);
                $query = "UPDATE User SET name = '$name', email = '$email', tel = '$phone', password = '$password' WHERE id = '$id'";
            } else {
                $query = "UPDATE User SET name = '$name', email = '$email', tel = '$phone' WHERE id = " . $_SESSION['id'];
            }
            $query1 = "UPDATE Passenger SET photo = '$photo', passport_img = '$passport' WHERE id = '$id'";
            $result = mysqli_query($conn, $query);
            if ($result) {
                $result1 = mysqli_query($conn, $query1);

                $conn->close();
                if ($result1) {
                    return true;
                } else {
                    return false;
                }
            } else {
                $conn->close();
                return false;
            }
        } else {
            $conn->close();
            throw new mysqli_sql_exception;
        }
    }


    public function updateCompany()
    {
        $conn = $this->getConnection();

        $id = $_SESSION['id'];
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $phone = mysqli_real_escape_string($conn, $_POST['phone']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        $bio = mysqli_real_escape_string($conn, $_POST['company-bio']);
        $address = mysqli_real_escape_string($conn, $_POST['company-address']);
        $logo = mysqli_real_escape_string($conn, $_POST['company-logo']);
        $location = mysqli_real_escape_string($conn, $_POST['company-location']);

        if ($name != '' && $email != '' && $phone != '' && $bio != '' && $address != '' && $logo != '' && $location != '') {
            if ($password != '') {
                $password = password_hash($password, PASSWORD_DEFAULT);
                $query = "UPDATE User SET name = '$name', email = '$email', tel = '$phone', password = '$password' WHERE id = '$id'";
            } else {
                $query = "UPDATE User SET name = '$name', email = '$email', tel = '$phone' WHERE id = " . $_SESSION['id'];
            }
            $query1 = "UPDATE Company SET bio = '$bio', address = '$address', location = '$location', logo = '$logo' WHERE id = '$id'";
            $result = mysqli_query($conn, $query);
            if ($result) {
                $result1 = mysqli_query($conn, $query1);

                $conn->close();
                if ($result1) {
                    return true;
                } else {
                    return false;
                }
            } else {
                $conn->close();
                return false;
            }
        } else {
            $conn->close();
            throw new mysqli_sql_exception;
        }
    }
}
