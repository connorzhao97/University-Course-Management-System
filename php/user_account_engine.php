<?php
include("../php/db_conn.php");
if ($_POST['student']) {
    $name = $_POST['name'];
    $stuID = $_POST['stuID'];
    $email = $_POST['email'];
    if (!empty($_POST['password'])) {
        $password = crypt($_POST['password']);
    }
    $address = $_POST['address'];
    $birth = $_POST['birth'];
    $phone = $_POST['phone'];
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
    $name = $_POST['name'];
    $staID = $_POST['staID'];
    $email = $_POST['email'];
    if (!empty($_POST['password'])) {
        $password = crypt($_POST['password']);
    }
    $qualification = $_POST['qualification'];
    $expertise = $_POST['expertise'];
    $phone = $_POST['phone'];
    $unavailability = $_POST['unavailability'];

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
