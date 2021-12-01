<?php
include("../php/db_conn.php");
if ($_POST['student']) {
    $name = $mysqli->real_escape_string($_POST['name']);
    $stuID = $mysqli->real_escape_string($_POST['stuID']);
    $email = $mysqli->real_escape_string($_POST['email']);
    if (!empty($_POST['password'])) {
        $password = crypt($mysqli->real_escape_string($_POST['password']));
    }
    $address = $mysqli->real_escape_string($_POST['address']);
    $birth = $mysqli->real_escape_string($_POST['birth']);
    $phone = $mysqli->real_escape_string($_POST['phone']);
    $updateStuQuery = "UPDATE assignment_students SET name ='" . $name . "', email = '" . $email . "'";
    if (!empty($_POST['password'])) {
        $updateStuQuery .= ", password = '" . $password . "'";
    }
    $updateStuQuery .= ", address='" . $address . "', birth = '" . $birth . "', phone = '" . $phone . "' WHERE st_id = '" . $stuID . "'";
    $updateStuResult = $mysqli->query($updateStuQuery);
    // echo $updateStuResult;
    if ($updateStuResult) {
        $res->update = true;
    } else {
        $res->update = false;
    }
} else if ($_POST['staff']) {
    $name = $mysqli->real_escape_string($_POST['name']);
    $staID = $mysqli->real_escape_string($_POST['staID']);
    $email = $mysqli->real_escape_string($_POST['email']);
    if (!empty($_POST['password'])) {
        $password = crypt($mysqli->real_escape_string($_POST['password']));
    }
    $qualification = $mysqli->real_escape_string($_POST['qualification']);
    $expertise = $mysqli->real_escape_string($_POST['expertise']);
    $phone = $mysqli->real_escape_string($_POST['phone']);
    $unavailability = $mysqli->real_escape_string($_POST['unavailability']);

    $updateStaQuery = "UPDATE assignment_staffs SET name='" . $name . "', email='" . $email . "'";
    if (!empty($_POST['password'])) {
        $updateStaQuery .= ", password = '" . $password . "'";
    }
    $updateStaQuery .= ", qualification = '" . $qualification . "', expertise = '" . $expertise . "', phone = '" . $phone . "', unavailability = '" . $unavailability . "' WHERE st_id = '" . $staID . "'";
    $updateStaResult = $mysqli->query($updateStaQuery);
    if ($updateStaResult) {
        $res->update = true;
    } else {
        $res->update = false;
    }
}
echo json_encode($res);
$mysqli->close();
