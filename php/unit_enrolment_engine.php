<?php
include("../php/db_conn.php");
include("../php/session.php");

if ($_POST['enrol']) {
    $unitID = $mysqli->real_escape_string($_POST['unitID']);
    $unitListID = $mysqli->real_escape_string($_POST['unitListID']);

    $insertQuery = "INSERT INTO assignment_students_enrolments (stu_id, details_id, units_lists_id) VALUES ('" . $_SESSION['session_user'] . "', '$unitID', '$unitListID')";
    $insertResult = $mysqli->query($insertQuery);

    if ($insertResult) {
        $res->insert = true;
    } else {
        $res->insert = false;
    }
} else if ($_POST['withdraw']) {
    $unitEnrolID = $mysqli->real_escape_string($_POST['unitEnrolID']);

    $selectUnitQuery = "SELECT * FROM assignment_students_enrolments WHERE id='$unitEnrolID'";
    $selectUnitResult = $mysqli->query($selectUnitQuery);
    $row = $selectUnitResult->fetch_assoc();

    $withdrawTutorialQuery = "DELETE FROM assignment_students_timetable WHERE details_id = '" . $row['details_id'] . "' AND stu_id = '" . $_SESSION['session_user'] . "'";
    $withdrawTutorialResult = $mysqli->query($withdrawTutorialQuery);
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
