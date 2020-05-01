<?php

include("../php/db_conn.php");
if ($_POST['student']) {
    $name = $_POST['name'];
    $stuID = $_POST['stuID'];
    $email = $_POST['email'];
    $password = crypt($_POST['password']);
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
    $name = $_POST['name'];
    $staID = $_POST['staID'];
    $email = $_POST['email'];
    $password = crypt($_POST['password']);
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
        $quertUser = "INSERT INTO assignment_users (st_id, access) VALUES ('$staID','1')";
        $resultUser = $mysqli->query($quertUser);
        if ($resultUser) {
            $query = "INSERT INTO assignment_staffs (st_id, name, email, password, qualification, expertise, phone) VALUES ('$staID','$name','$email','$password','$qualification','$expertise','$phone')";
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
