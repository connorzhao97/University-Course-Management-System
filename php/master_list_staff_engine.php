<?php
include("../php/db_conn.php");


if ($_POST['insertStaff']) {
    $staffID = $mysqli->real_escape_string($_POST['staffID']);
    $staffName = $mysqli->real_escape_string($_POST['staffName']);
    $staffPassword = crypt($mysqli->real_escape_string($_POST['staffPassword']));
    $staffQualification = $mysqli->real_escape_string($_POST['staffQualification']);
    $staffExpertise = $mysqli->real_escape_string($_POST['staffExpertise']);
    $staffRole = $mysqli->real_escape_string($_POST['staffRole']);

    $selectUserQuery = "SELECT * FROM assignment_users WHERE st_id ='$staffID'";
    $selectUserResult = $mysqli->query($selectUserQuery);
    if ($selectUserResult->num_rows > 0) {
        $res->exist = true;
    } else {
        $res->exist = false;
        $insertUserQuery = "INSERT INTO assignment_users (st_id, access) VALUES ('$staffID', '$staffRole')";
        $insertUserResult = $mysqli->query($insertUserQuery);
        if ($insertUserResult) {
            $insertStaffQuery = "INSERT INTO assignment_staffs (st_id, name, email, password, qualification, expertise, phone, unavailability) VALUES ('$staffID', '$staffName','','$staffPassword', '$staffQualification', '$staffExpertise','','')";
            $insertStaffResult = $mysqli->query($insertStaffQuery);
            if ($insertStaffResult) {
                $res->insert = true;
            } else {
                $res->insert = false;
            }
        } else {
            $res->insert = false;
        }
    }
} else {
    $input = filter_input_array(INPUT_POST);
    $staffID = $mysqli->real_escape_string($input['staffID']);
    $name  = $mysqli->real_escape_string($input['name']);
    $qualification = $mysqli->real_escape_string($input['qualification']);
    $expertise = $mysqli->real_escape_string($input['expertise']);
    $role = $mysqli->real_escape_string($input['role']);

    if ($input['action'] == 'edit') {
        $res->action = "edit";
        $updateStaffQuery = "UPDATE assignment_users SET access = '$role' WHERE st_id = '$staffID'";
        $updateStaffResult = $mysqli->query($updateStaffQuery);
        if ($updateStaffResult) {
            $updateQuery = "UPDATE assignment_staffs SET name = '$name', qualification = '$qualification', expertise = '$expertise' WHERE st_id = '$staffID'";
            $updateResult = $mysqli->query($updateQuery);
            if ($updateResult) {
                $res->update = true;
            } else {
                $res->update = false;
            }
        } else {
            $res->update = false;
        }
    } else if ($input['action'] == 'delete') {
        $res->action = 'delete';
        $deleteStaffQuery = "DELETE FROM assignment_staffs WHERE st_id ='$staffID'";
        $deleteStaffResult = $mysqli->query($deleteStaffQuery);
        if ($deleteStaffResult) {
            $deleteUserQuery = "DELETE FROM assignment_users WHERE st_id = '$staffID'";
            $deleteUserResult = $mysqli->query($deleteUserQuery);
            if ($deleteUserResult) {
                $res->delete = true;
                $res->id = $input['staffID'];
            } else {
                $res->delete = false;
            }
        }
    }
}
$mysqli->close();
echo json_encode($res);
