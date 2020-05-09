<?php
include("../php/db_conn.php");
include("../php/session.php");

if ($_POST['enrol']) {
    $stID = $_POST['stID'];
    $unitID = $_POST['unitID'];
    $unitListID = $_POST['unitListID'];

    $insertQuery = "INSERT INTO assignment_students_enrolments (stu_id, unit_id, unit_list_id) VALUES ('$stID', '$unitID', '$unitListID')";
    $insertResult = $mysqli->query($insertQuery);

    if ($insertResult) {
        $res->insert = true;
    } else {
        $res->insert = false;
    }
} else if ($_POST['withdraw']) {
    $stID = $_POST['stID'];
    $unitEnrolID = $_POST['unitEnrolID'];

    $withdrawQuery = "DELETE FROM assignment_students_enrolments WHERE id='$unitEnrolID'";
    $withdrawResult = $mysqli->query($withdrawQuery);
    if ($withdrawResult) {
        $res->withdraw = true;
    } else {
        $res->withdraw = false;
    }
}
$mysqli->close();
echo json_encode($res);
