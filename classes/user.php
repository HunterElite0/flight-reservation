<?php
    require_once('connection.php');
    class user extends connection
    {

        public function signIn($email, $password)
        {
            $conn = $this->getConnection();
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
                    header('Location: companyHome.php');
                }else{
                    $this->setAccount($resultArray['id'], 'Passenger');
                    header('Location: passengerHome.php');
                }

            } else {
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
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            
            $conn->begin_transaction();
            // mysqli_begin_transaction($conn);
            try {
                $query = "INSERT INTO User (email, password, name, tel, account_type) VALUES ('".$_POST['email']."', '$password', '".$_POST['name']."', '".$_POST['phone']."' , '$type')";
                $result = mysqli_query($conn, $query);
                $id = mysqli_insert_id($conn);

                if ($_POST['account_type'] == 'passenger'){
                    $this->signupPassenger($id,$conn);
                }
                else{
                    $this->signupCompany($id,$conn);
                }

                $conn->commit();
                header('Location: ../signin.php');
            } catch (mysqli_sql_exception $exception) {
                echo $exception;
                $conn->rollback();
                header('Location: ../signup.php');
            }
            $conn->close();
        }


        public function signupPassenger($id, $conn)
        {
            $query = "INSERT INTO Passenger (id, photo, passport_img ) VALUES ('$id' , '".$_POST['photo']."', '".$_POST['passenger-passport']."')";
            $result = mysqli_query($conn, $query);

        }


        public function signupCompany($id , $conn)
        {
            $query = "INSERT INTO Company (id, bio, address, location, logo ) VALUES ('$id' , '".$_POST['company-bio']."', '".$_POST['company-address']."', '".$_POST['company-location']."', '".$_POST['company-logo']."')";
            $result = mysqli_query($conn, $query);

        }
        

    }
?>