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
            $insertListQuery = "INSERT INTO assignment_units_lists (unit_code, semester, campus, availability) VALUES ";
            for ($i = 0; $i < count($semesters) - 1; $i++) {
                for ($j = 0; $j < count($campuses) - 1; $j++) {
                    if ($i == count($semesters) - 2 && $j == count($campuses) - 2) {
                        $insertListQuery .= "('$unitCode', '$semesters[$i]','$campuses[$j]','1');";
                    } else {
                        $insertListQuery .= "('$unitCode', '$semesters[$i]','$campuses[$j]','1'), ";
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

    echo json_encode($res);
}
