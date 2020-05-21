<?php
include("../php/db_conn.php");
include("../php/session.php");

if ($_POST['enrol']) {
    $stID = $mysqli->real_escape_string($_POST['stID']);
    $unitID = $mysqli->real_escape_string($_POST['unitID']);
    $unitListID = $mysqli->real_escape_string($_POST['unitListID']);

    $insertQuery = "INSERT INTO assignment_students_enrolments (stu_id, details_id, units_lists_id) VALUES ('$stID', '$unitID', '$unitListID')";
    $insertResult = $mysqli->query($insertQuery);

    if ($insertResult) {
        $res->insert = true;
    } else {
        $res->insert = false;
    }
} else if ($_POST['withdraw']) {
    $stID = $mysqli->real_escape_string($_POST['stID']);
    $unitEnrolID = $mysqli->real_escape_string($_POST['unitEnrolID']);

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
