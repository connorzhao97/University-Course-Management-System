<?php
include("../php/db_conn.php");
include('../php/session.php');

$id = $mysqli->real_escape_string($_POST['id']);
$details_id = $mysqli->real_escape_string($_POST['details_id']);

if ($_POST['allocate']) {
    // check capacity
    $checkTutorialCapacityQuery = "SELECT capacity FROM assignment_tutorials WHERE id='$id'";
    $checkTutorialCapacityResult = $mysqli->query($checkTutorialCapacityQuery);
    if ($checkTutorialCapacityResult->num_rows > 0) {
        $rowCheckTutorialCapacity = $checkTutorialCapacityResult->fetch_assoc();
        $capacity = $rowCheckTutorialCapacity['capacity'];
    }

    //check count allocation 
    $checkCountQuery = "SELECT count(id) FROM assignment_students_timetable WHERE tutorial_id='$id'";
    $checkCountResult = $mysqli->query($checkCountQuery);
    if ($checkCountResult->num_rows > 0) {
        $rowCheckCount = $checkCountResult->fetch_assoc();
        $allocation = $rowCheckCount['count(id)'];
    }
    //check tutorial exist or not
    $checkTutorialQuery = "SELECT * FROM assignment_students_timetable WHERE details_id ='$details_id' AND stu_id = '" . $_SESSION['session_user'] . "'";
    $checkTutorialResult = $mysqli->query($checkTutorialQuery);
    if ($checkTutorialResult->num_rows > 0) {
        //update timetable
        if ($allocation < $capacity) {
            $res->full = false;
            $updateTutorialQuery = "UPDATE assignment_students_timetable SET tutorial_id = '$id' WHERE stu_id = '" . $_SESSION['session_user'] . "' AND details_id = '$details_id'";
            $updateTutorialResult = $mysqli->query($updateTutorialQuery);
            if ($updateTutorialResult) {
                $res->allocate = true;
            } else {
                $res->allocate = false;
            }
        } else {
            $res->full = true;
        }
    } else {
        // insert into timetable
        if ($allocation < $capacity) {
            $res->full = false;
            $selectLectureQuery = "SELECT id FROM assignment_lectures WHERE details_id = '$details_id'";
            $selectLectureResult = $mysqli->query($selectLectureQuery);
            $rowSelectLecture = $selectLectureResult->fetch_assoc();

            $lecture_id = $rowSelectLecture['id'];

            $insertQuery = "INSERT INTO assignment_students_timetable (stu_id, details_id, lecture_id, tutorial_id) VALUES ('" . $_SESSION['session_user'] . "', '$details_id', '$lecture_id', '$id')";
            $insertResult = $mysqli->query($insertQuery);
            if ($insertResult) {
                $res->allocate = true;
            } else {
                $res->allocate = false;
            }
        } else {
            $res->full = true;
        }
    }
} else if ($_POST['withdraw']) {
    $deleteTimetableQuery = "DELETE FROM assignment_students_timetable WHERE stu_id= '" . $_SESSION['session_user'] . "' AND details_id='$details_id' AND tutorial_id = '$id'";
    $deleteTimetableResult = $mysqli->query($deleteTimetableQuery);

    if ($deleteTimetableResult) {
        $res->delete = true;
    } else {
        $res->delete = false;
    }
}


$mysqli->close();
echo json_encode($res);
