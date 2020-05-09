<?php
include("../php/db_conn.php");

if ($_POST['insertUnit']) {
    //create new unit
    $unitCode = $_POST['unitCode'];
    $unitName = $_POST['unitName'];
    $unitSemesters = $_POST['unitSemesters'];
    $unitCampuses = $_POST['unitCampuses'];
    $unitDescription = $_POST['unitDescription'];
    $selectQuery = "SELECT * FROM assignment_units_details WHERE unit_code = '$unitCode'";

    $selectResult = $mysqli->query($selectQuery);
    if ($selectResult->num_rows > 0) {
        $res->exist = true;
    } else {
        $insertDetailQuery = "INSERT INTO assignment_units_details (unit_code, unit_name, unit_coordinator, semester, campus, description) VALUES ('$unitCode', '$unitName','','$unitSemesters','$unitCampuses', '$unitDescription')";
        $res->insertDetailQuery = $insertDetailQuery;
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
    $mysqli->close();
    echo json_encode($res);
} else if ($_POST['editUnit']) {
    // edit unit
    $unitCode = $_POST['unitCode'];
    $unitName = $_POST['unitName'];
    $unitSemesters = $_POST['unitSemesters'];
    $unitCampuses = $_POST['unitCampuses'];
    $unitDescription = $_POST['unitDescription'];

    $newSemesters = explode(',', $unitSemesters);
    $newCampuses = explode(',', $unitCampuses);
    array_pop($newSemesters);
    array_pop($newCampuses);

    $selectQuery = "SELECT * FROM assignment_units_details WHERE unit_code = '$unitCode'";
    $selectResult = $mysqli->query($selectQuery);
    $selectRow = $selectResult->fetch_assoc();
    // echo var_dump($selectRow);
    // $oldSemesters = explode(',', $selectRow['semester']);
    // $oldCampuses = explode(',', $selectRow['campus']);
    // array_pop($oldSemesters);
    // array_pop($oldCampuses);

    //deal with details table
    $updateDetailsQuery = "UPDATE assignment_units_details SET unit_code = '$unitCode', unit_name = '$unitName', semester = '$unitSemesters', campus = '$unitCampuses', description = '$unitDescription' WHERE id = '" . $selectRow['id'] . "'";
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
        // for ($i = 0; $i < count($newSemesters); $i++) {
        //     for ($j = 0; $j < count($newCampuses); $j++) {
        //         if ($i == count($newSemesters) - 1 && $j == count($newCampuses) - 1) {
        //             $updateListQuery .= "('" . $selectRow['id'] . "', '$newSemesters[$i]','$newCampuses[$j]','1');";
        //         } else {
        //             $updateListQuery .= "('" . $selectRow['id'] . "', '$newSemesters[$i]','$newCampuses[$j]','1'), ";
        //         }
        //     }
        // }
        $res->updateList = true;

        //change semesters
        // $addSemester = array_diff($newSemesters, $oldSemesters);
        // $removeSemester = array_diff($oldSemesters, $newSemesters);
        // if (count($addSemester) > 0) {
        //     addsemester * newcampuses
        // }


        // print_r($addSemester);
        // print_r($removeSemester);
    } else {
        $res->updateDetails = false;
    }
    $mysqli->close();
    echo json_encode($res);
} else if ($_POST['unitRemove']) {
    $unitCode = $_POST['unitCode'];

    $selectQuery = "SELECT id FROM assignment_units_details WHERE unit_code = '$unitCode'";
    $selectQueryResult = $mysqli->query($selectQuery);
    $rowSelect = $selectQueryResult->fetch_array();
    $unitID = $rowSelect[0];
    $deleteListQuery = "DELETE FROM assignment_units_lists WHERE details_id = '$unitID'";
    $deleteListResult = $mysqli->query($deleteListQuery);
    if ($deleteListResult) {
        $res->deleteList = true;
        $deleteDetailsQuery = "DELETE FROM assignment_units_details WHERE id = '$unitID'";
        $deleteDetailResult = $mysqli->query($deleteDetailsQuery);
        if ($deleteDetailResult) {
            $res->deleteDetail = true;
        } else {
            $res->deleteDetail = false;
        }
    } else {
        $res->deleteList = false;
    }
    $mysqli->close();
    echo json_encode($res);
}
