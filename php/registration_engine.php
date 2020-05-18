<?php

include("../php/db_conn.php");
if ($_POST['student']) {
    $name = $mysqli->real_escape_string($_POST['name']);
    $stuID = $mysqli->real_escape_string($_POST['stuID']);
    $email = $mysqli->real_escape_string($_POST['email']);
    $password = crypt($mysqli->real_escape_string($_POST['password']));
    $address = $mysqli->real_escape_string($_POST['address']);
    $birth = $mysqli->real_escape_string($_POST['birth']);
    $phone = $mysqli->real_escape_string($_POST['phone']);

    $existQuery = "SELECT * FROM assignment_users WHERE st_id ='$stuID'";
    $existResult = $mysqli->query($existQuery);
    if ($existResult->num_rows > 0) {
        //exist user
        $res->exist = true;
    } else {
        //not exist
        $res->exist = false;
        $quertUser = "INSERT INTO assignment_users (st_id, access) VALUES ('$stuID','0')";
        $resultUser = $mysqli->query($quertUser);
        if ($resultUser) {
            $query = "INSERT INTO assignment_students (st_id, name, email, password, address, birth, phone) VALUES ('$stuID','$name','$email','$password','$address','$birth','$phone')";
            $result = $mysqli->query($query);
            if ($result) {
                $res->insert = true;
            } else {
                $res->insert = false;
            }
        } else {
            $res->insert = false;
        }
    }
    echo json_encode($res);
    $existResult->close();
    $mysqli->close();
} else if ($_POST['staff']) {
    $name = $mysqli->real_escape_string($_POST['name']);
    $staID = $mysqli->real_escape_string($_POST['staID']);
    $email = $mysqli->real_escape_string($_POST['email']);
    $password = crypt($mysqli->real_escape_string($_POST['password']));
    $qualification = $mysqli->real_escape_string($_POST['qualification']);
    $expertise = $mysqli->real_escape_string($_POST['expertise']);
    $phone = $mysqli->real_escape_string($_POST['phone']);
    $existQuery = "SELECT * FROM assignment_users WHERE st_id ='$staID'";
    $existResult = $mysqli->query($existQuery);
    if ($existResult->num_rows > 0) {
        //exist user
        $res->exist = true;
    } else {
        //not exist
        $res->exist = false;
        $queryUser = "INSERT INTO assignment_users (st_id, access) VALUES ('$staID','1')";
        $resultUser = $mysqli->query($queryUser);
        if ($resultUser) {
            $query = "INSERT INTO assignment_staffs (st_id, name, email, password, qualification, expertise, phone, unavailability) VALUES ('$staID','$name','$email','$password','$qualification','$expertise','$phone','')";
            $result = $mysqli->query($query);
            if ($result) {
                $res->insert = true;
            } else {
                $res->insert = false;
            }
        } else {
            $res->insert = false;
        }
    }
    echo json_encode($res);
    $existResult->close();
    $mysqli->close();
}
