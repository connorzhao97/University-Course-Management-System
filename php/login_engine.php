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
    if (hash_equals($row['password'], crypt($password, $row['password']))) {
        $res->login = true;
        $session_user = $row['st_id'];
        $session_access = $row['access'];
        $_SESSION['session_user'] = $session_user;
        $_SESSION['session_access'] = $session_access;
    } else {
        $res->login = false;
    }
} else {
    $res->exist = false;
}
echo json_encode($res);
$mysqli->close();
