<?php

include("db_conn.php");
if ($_POST['student']) {
    $firstName = $_POST['firstName'];
    $middleName = $_POST['middleName'];
    $lastName = $_POST['lastName'];
    $stuID = $_POST['stuID'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $address = $_POST['address'];
    $birth = $_POST['birth'];
    $phone = $_POST['phone'];

    $existQuery = "SELECT * FROM assignment_users WHERE st_id ='$stuID'";
    $existResult = $mysqli->query($existQuery);
    if ($existResult->num_rows > 0) {
        //exist user
        $res->exist = true;
    } else {
        //not exist
        $res->exist = false;
        $query = "INSERT INTO assignment_users (first_name, middle_name, last_name, st_id, email, password, qualification, expertise, address, birth, phone, access) VALUES ('$firstName','$middleName','$lastName','$stuID','$email','$password','','','$address','$birth','$phone','0')";
        $result = $mysqli->query($query);
        if ($result) {
            $res->insert = true;
        } else {
            $res->insert = false;
        }
    }
    echo json_encode($res);
    $existResult->close();
    $mysqli->close();
} else if ($_POST['staff']) {
    $firstName = $_POST['firstName'];
    $middleName = $_POST['middleName'];
    $lastName = $_POST['lastName'];
    $staID = $_POST['staID'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $qualification = $_POST['qualification'];
    $expertise = $_POST['expertise'];
    $phone = $_POST['phone'];
    $existQuery = "SELECT * FROM assignment_users WHERE st_id ='$staID'";
    $existResult = $mysqli->query($existQuery);
    if ($existResult->num_rows > 0) {
        //exist user
        $res->exist = true;
    } else {
        //not exist
        $res->exist = false;
        $query = "INSERT INTO assignment_users (first_name, middle_name, last_name, st_id, email, password, qualification, expertise, address, birth, phone, access) VALUES ('$firstName','$middleName','$lastName','$staID','$email','$password','$qualification','$expertise','','','$phone','1')";
        $result = $mysqli->query($query);
        if ($result) {
            $res->insert = true;
        } else {
            $res->insert = false;
        }
    }
    echo json_encode($res);
    $existResult->close();
    $mysqli->close();
}
