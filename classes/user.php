<?php
    require_once('connection.php');
    class user extends connection
    {

        public function signIn($email, $password)
        {
            $conn = $this->getConnection();
            $email = mysqli_real_escape_string($conn, $email);
            $password = mysqli_real_escape_string($conn, $password);

            if($email == '' || $password == '')
                return;

            $query = "SELECT * FROM User WHERE email = '$email'";
            $result = mysqli_query($conn, $query);
            $resultArray = mysqli_fetch_assoc($result);
            $conn->close();
            
            if (mysqli_num_rows($result) == 1 && password_verify($password, $resultArray['password'])) {
                foreach($resultArray as $key => $value)
                {
                    if($key != 'password' && $key != 'id')
                        $_SESSION[$key] = $value;
                }
                if($resultArray['account_type'] == '0'){
                    $this->setAccount($resultArray['id'], 'Company');
                }else{
                    $this->setAccount($resultArray['id'], 'Passenger');
                }

            } else {
                header("Location: ../signin.php");
                echo "<script>alert('Invalid username or password')</script>";
            }
        }


        public function setAccount($id, $account_type)
        {
            $_SESSION['account_type'] = $account_type;
            $conn = $this->getConnection();
            $query = "SELECT * FROM $account_type WHERE id = '$id' ";
            $result = mysqli_query($conn, $query);
            $result = mysqli_fetch_assoc($result);
            $conn->close();
        
            foreach($result as $key => $value)
            {
                $_SESSION[$key] = $value;
            }
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

                if ($_POST['account_type'] == 'passenger'){
                    $this->signupPassenger($id,$conn);
                }
                else{
                    $this->signupCompany($id,$conn);
                }
                $conn->commit();
                header("Location: ../signin.php");
            } catch (mysqli_sql_exception $exception) {
                $conn->rollback();
            }
            $_POST = array();
            $conn->close();
        }


        public function signupPassenger($id, $conn)
        {
            $photo = mysqli_real_escape_string($conn, $_POST['photo']);
            $passport = mysqli_real_escape_string($conn, $_POST['passenger-passport']);
            if($photo != '' && $passport != '')
            {
                $query = "INSERT INTO Passenger (id, photo, passport_img ) VALUES ('$id' , '$photo', '$passport')";
                $result = mysqli_query($conn, $query);
            }
            else
            {
                echo "<script>alert('Please fill all the fields')</script>";
                throw new mysqli_sql_exception("Please fill all the fields");
            }
        }


        public function signupCompany($id , $conn)
        {
            $bio = mysqli_real_escape_string($conn, $_POST['company-bio']);
            $address = mysqli_real_escape_string($conn, $_POST['company-address']);
            $logo = mysqli_real_escape_string($conn, $_POST['company-logo']);
            $location = mysqli_real_escape_string($conn, $_POST['company-location']);
            if($bio != '' && $address != '' && $logo != '')
            {
                $query = "INSERT INTO Company (id, bio, address, location, logo ) VALUES ('$id' , '$bio', '$address', '$location', '$logo')";
                $result = mysqli_query($conn, $query);
            }
            else
            {
                echo "<script>alert('Please fill all the fields')</script>";
                throw new mysqli_sql_exception("Please fill all the fields");
            }
        }
    }
?>