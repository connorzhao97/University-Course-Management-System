<?php

include('../php/db_conn.php');
include('../php/session.php');

$stID = $_POST['stID'];
$password = $_POST['password'];

$query = "SELECT * FROM assignment_users WHERE st_id='$stID'";
$result = $mysqli->query($query);
if ($result->num_rows > 0) {
    $res->exist = true;
    $row = $result->fetch_assoc();
    if ($row['access'] == "0") {
        //select from student table
        $queryStu = "SELECT * FROM assignment_students WHERE st_id='$stID'";
        $resultStu = $mysqli->query($queryStu);
        if ($resultStu->num_rows > 0) {
            $rowStu = $resultStu->fetch_assoc();
            if (hash_equals($rowStu['password'], crypt($password, $rowStu['password']))) {
                $res->login = true;
                $session_user = $row['st_id'];
                $session_access = $row['access'];
                $_SESSION['session_user'] = $session_user;
                $_SESSION['session_access'] = $session_access;
            } else {
                $res->login = false;
            }
        } else {
            $res->login = false;
        }
    } else {
        //select from staff tabledit
        $querySta = "SELECT * FROM assignment_staffs WHERE st_id='$stID'";
        $resultSta = $mysqli->query($querySta);
        if ($resultSta->num_rows > 0) {
            $rowSta = $resultSta->fetch_assoc();
            if (hash_equals($rowSta['password'], crypt($password, $rowSta['password']))) {
                $res->login = true;
                $session_user = $row['st_id'];
                $session_access = $row['access'];
                $_SESSION['session_user'] = $session_user;
                $_SESSION['session_access'] = $session_access;
            } else {
                $res->login = false;
            }
        } else {
            $res->login = false;
        }
    }
} else {
    $res->exist = false;
}
echo json_encode($res);
$mysqli->close();
