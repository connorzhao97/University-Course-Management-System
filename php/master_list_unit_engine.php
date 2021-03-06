<?php
include("../php/db_conn.php");

if ($_POST['insertUnit']) {
    //create new unit
    $unitCode = $mysqli->real_escape_string($_POST['unitCode']);
    $unitName = $mysqli->real_escape_string($_POST['unitName']);
    $unitSemesters = $mysqli->real_escape_string($_POST['unitSemesters']);
    $unitCampuses = $mysqli->real_escape_string($_POST['unitCampuses']);
    $unitCoordinatorID = $mysqli->real_escape_string($_POST['unitCoordinatorID']);
    $unitDescription = $mysqli->real_escape_string($_POST['unitDescription']);


    $selectQuery = "SELECT * FROM assignment_units_details WHERE unit_code = '$unitCode'";
    $selectResult = $mysqli->query($selectQuery);

    if ($selectResult->num_rows > 0) {
        $res->exist = true;
    } else {
        $res->exist = false;
        $canInsert = false;

        $selectStaffQuery = "SELECT * FROM assignment_users WHERE st_id='$unitCoordinatorID'";
        $selectStaffResult = $mysqli->query($selectStaffQuery);
        if ($selectStaffResult->num_rows > 0) {
            $rowSelectStaff = $selectStaffResult->fetch_assoc();
            if ($rowSelectStaff['access'] != '4') {
                $res->UC = false;
            } else {
                $res->UC = true;
                $canInsert = true;
            }
        }
        if ($canInsert) {
            $insertDetailQuery = "INSERT INTO assignment_units_details (unit_code, unit_name, unit_coordinator_id, semester, campus, description) VALUES ('$unitCode', '$unitName','$unitCoordinatorID','$unitSemesters','$unitCampuses', '$unitDescription')";
            $insertDetailResult = $mysqli->query($insertDetailQuery);
            if ($insertDetailResult) {
                $res->insertDetail = true;
                $semesters = explode(',', $unitSemesters);
                $campuses = explode(',', $unitCampuses);
                array_pop($semesters);
                array_pop($campuses);

                $detailsIDQuery = "SELECT id FROM assignment_units_details WHERE unit_code = '$unitCode'";
                $detailsIDResult = $mysqli->query($detailsIDQuery);
                $rowDetails = $detailsIDResult->fetch_array();
                $insertListQuery = "INSERT INTO assignment_units_lists (details_id, semester, campus, availability) VALUES ";
                $semestersTemp = ['Semester 1', 'Semester 2', 'Winter School', 'Spring School'];
                $campusesTemp = ['Pandora', 'Rivendell', 'Neverland'];
                //insert available units into assignment_units_lists
                for ($i = 0; $i < count($semestersTemp); $i++) {
                    for ($j = 0; $j < count($campusesTemp); $j++) {
                        if (in_array($semestersTemp[$i], $semesters)) {
                            if (in_array($campusesTemp[$j], $campuses)) {
                                if ($i == count($semestersTemp) - 1 && $j == count($campusesTemp) - 1) {
                                    $insertListQuery .= "('$rowDetails[0]', '$semestersTemp[$i]', '$campusesTemp[$j]', '1');";
                                } else {
                                    $insertListQuery .= "('$rowDetails[0]', '$semestersTemp[$i]', '$campusesTemp[$j]', '1'),";
                                }
                            } else {
                                if ($i == count($semestersTemp) - 1 && $j == count($campusesTemp) - 1) {
                                    $insertListQuery .= "('$rowDetails[0]', '$semestersTemp[$i]', '$campusesTemp[$j]', '0');";
                                } else {
                                    $insertListQuery .= "('$rowDetails[0]', '$semestersTemp[$i]', '$campusesTemp[$j]', '0'),";
                                }
                            }
                        } else {
                            if ($i == count($semestersTemp) - 1 && $j == count($campusesTemp) - 1) {
                                $insertListQuery .= "('$rowDetails[0]', '$semestersTemp[$i]', '$campusesTemp[$j]', '0');";
                            } else {
                                $insertListQuery .= "('$rowDetails[0]', '$semestersTemp[$i]', '$campusesTemp[$j]', '0'),";
                            }
                        }
                    }
                }
                $insertListResult = $mysqli->query($insertListQuery);
                if ($insertListResult) {
                    $res->insertList = true;
                } else {
                    $res->insertList = false;
                }
            } else {
                $res->insertDetail = false;
                $res->insertList = false;
            }
            $res->exist = false;
        }
    }
    $mysqli->close();
    echo json_encode($res);
} else if ($_POST['editUnit']) {
    // edit unit
    $unitCode = $mysqli->real_escape_string($_POST['unitCode']);
    $unitName = $mysqli->real_escape_string($_POST['unitName']);
    $unitSemesters = $mysqli->real_escape_string($_POST['unitSemesters']);
    $unitCampuses = $mysqli->real_escape_string($_POST['unitCampuses']);
    $unitCoordinatorID = $mysqli->real_escape_string($_POST['unitCoordinatorID']);
    $unitDescription = $mysqli->real_escape_string($_POST['unitDescription']);

    $newSemesters = explode(',', $unitSemesters);
    $newCampuses = explode(',', $unitCampuses);
    array_pop($newSemesters);
    array_pop($newCampuses);
    //get unit details information
    $selectQuery = "SELECT * FROM assignment_units_details WHERE unit_code = '$unitCode'";
    $selectResult = $mysqli->query($selectQuery);
    $selectRow = $selectResult->fetch_assoc();

    $canUpdate = false;
    $checkAccessQuery = "SELECT access FROM assignment_users WHERE st_id = '$unitCoordinatorID'";
    $res->checkAccessQuery = $checkAccessQuery;
    $checkAccessResult = $mysqli->query($checkAccessQuery);
    if ($checkAccessResult->num_rows > 0) {
        $rowCheckAccess = $checkAccessResult->fetch_assoc();
        if ($rowCheckAccess['access'] != 4) {
            $res->UC = false;
        } else {
            $res->UC = true;
            $canUpdate = true;
        }
    }
    if ($canUpdate) {
        //deal with details table
        $updateDetailsQuery = "UPDATE assignment_units_details SET unit_code = '$unitCode', unit_name = '$unitName', unit_coordinator_id = ' $unitCoordinatorID', semester = '$unitSemesters', campus = '$unitCampuses', description = '$unitDescription' WHERE id = '" . $selectRow['id'] . "'";
        $updateDetailsResult = $mysqli->query($updateDetailsQuery);
        if ($updateDetailsResult) {
            $res->updateDetails = true;
            $selectListsQuery = "SELECT * FROM assignment_units_lists WHERE details_id = '" . $selectRow['id'] . "'";
            $selectListsResult = $mysqli->query($selectListsQuery);
            $initListsQuery = "UPDATE assignment_units_lists SET availability ='0' WHERE details_id = '" . $selectRow['id'] . "'";
            $initListsResult = $mysqli->query($initListsQuery);
            // echo var_dump($rowLists);
            while ($rowLists = $selectListsResult->fetch_assoc()) {

                if (in_array($rowLists['semester'], $newSemesters) && in_array($rowLists['campus'], $newCampuses)) {
                    $updateListsQuery = "UPDATE assignment_units_lists set availability = '1' WHERE id='" . $rowLists['id'] . "'";
                    $updateListsResult = $mysqli->query($updateListsQuery);
                }
            }
            $res->updateList = true;
        } else {
            $res->updateDetails = false;
        }
    }
    $mysqli->close();
    echo json_encode($res);
} else if ($_POST['unitRemove']) {
    $unitCode = $_POST['unitCode'];

    $selectQuery = "SELECT id FROM assignment_units_details WHERE unit_code = '$unitCode'";
    $selectQueryResult = $mysqli->query($selectQuery);
    $rowSelect = $selectQueryResult->fetch_array();
    $unitID = $rowSelect[0];
    //delete related tables
    $deleteQuery = "DELETE FROM assignment_lectures WHERE details_id = '$unitID'; DELETE FROM assignment_tutorials WHERE details_id = '$unitID'; DELETE FROM assignment_students_timetable WHERE details_id = '$unitID'; DELETE FROM assignment_units_lists WHERE details_id = '$unitID'; DELETE FROM assignment_students_enrolments WHERE details_id = '$unitID';";
    $deleteQuery_e = explode(';', $deleteQuery);
    foreach ($deleteQuery_e as $key => $value) {
        $deleteResult = $mysqli->query($deleteQuery_e[$key]);
    }
    $deleteDetailsQuery = "DELETE FROM assignment_units_details WHERE id = '$unitID'";
    $deleteDetailResult = $mysqli->query($deleteDetailsQuery);
    if ($deleteDetailResult) {
        $res->deleteDetail = true;
    } else {
        $res->deleteDetail = false;
    }

    $mysqli->close();
    echo json_encode($res);
}
