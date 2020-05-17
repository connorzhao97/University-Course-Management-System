<?php
include("../php/db_conn.php");

// echo print_r(filter_input_array($INPUT_POST));

if ($_POST['insertLecture']) {
    //create new lecture
    $details_id = $mysqli->real_escape_string($_POST['details_id']);
    $units_lists_id = $mysqli->real_escape_string($_POST['units_lists_id']);
    $day = $mysqli->real_escape_string($_POST['day']);
    $time = $mysqli->real_escape_string($_POST['time']);
    $location = $mysqli->real_escape_string($_POST['location']);
    $sta_id = $mysqli->real_escape_string($_POST['sta_id']);
    $consulation = $mysqli->real_escape_string($_POST['consulation']);

    $canInsert = false;
    $checkLectureQuery = "SELECT * FROM assignment_lectures WHERE units_lists_id = '$units_lists_id'";
    $checkLectureResult = $mysqli->query($checkLectureQuery);
    if ($checkLectureResult->num_rows > 0) {
        $res->exist = true;
    } else {
        $res->exist = false;
        $canInsert = true;
    }

    if ($canInsert) {
        $checkLecturerQuery = "SELECT * FROM assignment_users WHERE st_id ='$sta_id'";
        $checkLecturerResult = $mysqli->query($checkLecturerQuery);
        if ($checkLecturerResult->num_rows > 0) {
            $rowCheckLecturer = $checkLecturerResult->fetch_assoc();
            if ($rowCheckLecturer['access'] == '3' || $rowCheckLecturer['access'] == '4') {
                $res->lecturer = true;
                $insertLectureQuery = "INSERT INTO assignment_lectures (details_id, units_lists_id, day, time, location, sta_id, consulation) VALUES ('$details_id', '$units_lists_id', '$day', '$time', '$location', '$sta_id','$consulation')";
                // echo $insertLectureQuery;
                $insertLectureResult = $mysqli->query($insertLectureQuery);
                if ($insertLectureResult) {
                    $res->insert = true;
                } else {
                    $res->insert = false;
                }
            } else {
                $res->lecturer = false;
            }
        } else {
            $res->lecturer = false;
        }
    }
} else if ($_POST['insertTutorial']) {
    //create new tutorial
    $details_id = $mysqli->real_escape_string($_POST['details_id']);
    $units_lists_id = $mysqli->real_escape_string($_POST['units_lists_id']);
    $day = $mysqli->real_escape_string($_POST['day']);
    $time = $mysqli->real_escape_string($_POST['time']);
    $location = $mysqli->real_escape_string($_POST['location']);
    $sta_id = $mysqli->real_escape_string($_POST['sta_id']);
    $capacity = $mysqli->real_escape_string($_POST['capacity']);
    $consulation = $mysqli->real_escape_string($_POST['consulation']);

    $checkTutorQuery = "SELECT * FROM assignment_users WHERE st_id ='$sta_id'";
    $checkTutorResult = $mysqli->query($checkTutorQuery);
    // echo print_r($checkTutorResult);
    if ($checkTutorResult->num_rows > 0) {
        $rowCheckTutor = $checkTutorResult->fetch_assoc();
        if ($rowCheckTutor['access'] == '2') {
            $res->tutor = true;
            $insertTutorialQuery = "INSERT INTO assignment_tutorials (details_id, units_lists_id, day, time, location, sta_id, capacity, consulation) VALUES ('$details_id','$units_lists_id','$day','$time','$location','$sta_id','$capacity','$consulation')";
            $insertTutorialResult = $mysqli->query($insertTutorialQuery);
            if ($insertTutorialResult) {
                $res->insert = true;
            } else {
                $res->insert = false;
            }
        } else {
            $res->tutor = false;
        }
    } else {
        $res->tutor = false;
    }
}
$mysqli->close();
echo json_encode($res);
