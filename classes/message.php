<?php

function sendMessage($m_from, $m_to, $message)
{

    require_once('connection.php');
    $conn2 = new connection();
    $conn = $conn2->getConnection();
    $m_from = mysqli_real_escape_string($conn, $m_from);
    $m_to = mysqli_real_escape_string($conn, $m_to);
    $message = mysqli_real_escape_string($conn, $message);

    if ($m_from == "" || $m_to == "" || $message == "") {
        echo "<script>alert('Please fill all the fields')</script>";
        $conn->close();
        return;
    }

    $query = "INSERT INTO `Messages`(`m_from`, `m_to`, `message`) VALUES ('$m_from','$m_to','$message')";
    $result = mysqli_query($conn, $query);
    if ($result) {
        echo "<script>alert('Message sent successfully')</script>";
    } else {
        echo "<script>alert('Error sending the message')</script>";
    }
    $conn->close();
}

function getMessages($m_to)
{
    require_once('connection.php');
    $conn2 = new connection();
    $conn = $conn2->getConnection();
    $m_to = mysqli_real_escape_string($conn, $m_to);

    $query = "SELECT * FROM `Messages` WHERE `m_to`='$m_to'";
    $result = mysqli_query($conn, $query);
    $messages = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $messages[] = $row;
    }
    $conn->close();
    return $messages;
}
