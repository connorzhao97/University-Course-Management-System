<?php
include("../php/db_conn.php");

if ($_POST['insertLecture']) {
    //create new lecture
    $details_id = $mysqli->real_escape_string($_POST['details_id']);
    $units_lists_id = $mysqli->real_escape_string($_POST['units_lists_id']);
    $day = $mysqli->real_escape_string($_POST['day']);
    $time = $mysqli->real_escape_string($_POST['time']);
    $duration = $mysqli->real_escape_string($_POST['duration']);
    $location = $mysqli->real_escape_string($_POST['location']);
    $sta_id = $mysqli->real_escape_string($_POST['sta_id']);
    $consulation = $mysqli->real_escape_string($_POST['consulation']);

    $canInsert = false;
    //check lecture exist or not
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
                $insertLectureQuery = "INSERT INTO assignment_lectures (details_id, units_lists_id, day, time, duration, location, sta_id, consulation) VALUES ('$details_id', '$units_lists_id', '$day', '$time', '$duration','$location', '$sta_id','$consulation')";
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
    $duration = $mysqli->real_escape_string($_POST['duration']);
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
            $insertTutorialQuery = "INSERT INTO assignment_tutorials (details_id, units_lists_id, day, time, duration, location, sta_id, capacity, consulation) VALUES ('$details_id','$units_lists_id','$day','$time','$duration','$location','$sta_id','$capacity','$consulation')";
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
} else if ($_POST['removeLecture']) {
    $id = $mysqli->real_escape_string($_POST['id']);

    $removeLectureQuery = "DELETE FROM assignment_lectures WHERE id = '$id'";
    $removeLectureResult = $mysqli->query($removeLectureQuery);
    if ($removeLectureResult) {
        $res->removeLecture = true;
    } else {
        $res->removeLecture = false;
    }
} else if ($_POST['removeTutorial']) {
    $id = $mysqli->real_escape_string($_POST['id']);

    $removeFromTimetableQuery = "DELETE FROM assignment_students_timetable WHERE tutorial_id='" . $id . "'";
    $removeFromTimetableResult = $mysqli->query($removeFromTimetableQuery);

    $removeTutorialQuery = "DELETE FROM assignment_tutorials WHERE id = '$id'";
    $removeTutorialResult = $mysqli->query($removeTutorialQuery);
    if ($removeTutorialResult) {
        $res->removeTutorial = true;
    } else {
        $res->removeTutorial = false;
    }
} else if ($_POST['updateLecture']) {
    $id = $mysqli->real_escape_string($_POST['id']);
    $units_lists_id = $mysqli->real_escape_string($_POST['units_lists_id']);
    $day = $mysqli->real_escape_string($_POST['day']);
    $time = $mysqli->real_escape_string($_POST['time']);
    $duration = $mysqli->real_escape_string($_POST['duration']);
    $location = $mysqli->real_escape_string($_POST['location']);
    $sta_id = $mysqli->real_escape_string($_POST['sta_id']);
    $consulation = $mysqli->real_escape_string($_POST['consulation']);

    $checkLecturerQuery = "SELECT * FROM assignment_users WHERE st_id ='$sta_id'";
    $checkLecturerResult = $mysqli->query($checkLecturerQuery);
    if ($checkLecturerResult->num_rows > 0) {
        $rowCheckLecturer = $checkLecturerResult->fetch_assoc();
        if ($rowCheckLecturer['access'] == '3' || $rowCheckLecturer['access'] == '4') {
            $res->lecturer = true;
            $checkSCQuery = "SELECT * FROM assignment_lectures WHERE id !='$id' AND units_lists_id='$units_lists_id'";
            $checkSCResult = $mysqli->query($checkSCQuery);
            if ($checkSCResult->num_rows > 0) {
                $res->scExists = true;
            } else {
                $res->scExists = false;
                $updateLectureQuery = "UPDATE assignment_lectures SET units_lists_id = '$units_lists_id', day = '$day', time = '$time',duration = '$duration', location = '$location', sta_id='$sta_id',consulation='$consulation' WHERE id = '$id'";
                $updateLectureResult = $mysqli->query($updateLectureQuery);
                if ($updateLectureResult) {
                    $res->update = true;
                } else {
                    $res->update = false;
                }
            }
        } else {
            $res->lecturer = false;
        }
    } else {
        $res->lecturer = false;
    }
} else if ($_POST['updateTutorial']) {
    $id = $mysqli->real_escape_string($_POST['id']);
    $units_lists_id = $mysqli->real_escape_string($_POST['units_lists_id']);
    $day = $mysqli->real_escape_string($_POST['day']);
    $time = $mysqli->real_escape_string($_POST['time']);
    $duration = $mysqli->real_escape_string($_POST['duration']);
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
            $updateTutorialQuery = "UPDATE assignment_tutorials SET units_lists_id = '$units_lists_id', day = '$day', time = '$time',duration = '$duration', location = '$location', sta_id='$sta_id', capacity = '$capacity',consulation='$consulation' WHERE id = '$id'";
            $updateTutorialResult = $mysqli->query($updateTutorialQuery);
            if ($updateTutorialResult) {
                $res->update = true;
            } else {
                $res->update = false;
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
