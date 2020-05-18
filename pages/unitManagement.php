<?php
include('../php/db_conn.php');
include('../php/session.php');
if ($_SESSION['session_user'] != "") {
    if ($_SESSION['session_access'] == "5" || $_SESSION['session_access'] == "4") {
        //TODO check uc units belonging
        if (!empty($_GET['code'])) {
            if ($_SESSION['session_access'] == "4") {
                $checkUnitQuery = "SELECT unit_coordinator_id FROM assignment_units_details WHERE unit_code = '" . $_GET['code'] . "'";
                $checkUnitResult = $mysqli->query($checkUnitQuery);
                $rowCheckUnit = $checkUnitResult->fetch_assoc();
                if ($_SESSION['session_user'] != $rowCheckUnit['unit_coordinator_id']) {
                    echo "<script>alert('You do not have access to this unit'); window.location.href='../pages/unitManagement.php'</script>";
                }
            }
            $selectUnitDetailsQuery = "SELECT id, unit_name FROM assignment_units_details WHERE unit_code = '" . $_GET['code'] . "'";
            $selectUnitDetailsResult = $mysqli->query($selectUnitDetailsQuery);
            if ($selectUnitDetailsResult->num_rows > 0) {
                $_GLOBALS['unitDetails'] = $selectUnitDetailsResult->fetch_assoc();
                // echo print_r($_GLOBALS['unitDetails']);
            }
        }
    } else {
        echo "<script>alert('You do not have access to this page'); window.location.href='../pages/home.php'</script>";
    }
} else {
    echo "<script>alert('Login is required'); window.location.href='../pages/login.php'</script>";
}
?>
<!doctype html>
<html lang="en" class="h-100">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="../CSS/unitdetail.css">
    <title>Unit Management - University of DoWell</title>
</head>

<body class="d-flex flex-column h-100">
    <!-- NOTE navbar -->
    <nav class="navbar navbar-expand-md navbar-dark bg-dark sticky-top">
        <a class="navbar-brand p-0" href="../pages/home.php">
            <img src="../imgs/logo.png" width="100" height="44">
        </a>
        <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#collapsibleNavId" aria-controls="collapsibleNavId" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="collapsibleNavId">
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="../pages/unitDetail.php">Unit Detail</a>
                </li>
                <?php
                if ($_SESSION['session_access'] == "0") {
                    echo "
                    <li class='nav-item'>
                    <a class='nav-link' href='../pages/unitEnrolment.php'>Unit Enrolment</a>
                    </li>
                    ";
                }
                ?>
                <?php
                if ($_SESSION['session_access'] == "0") {
                    echo "
                    <li class='nav-item'>
                    <a class='nav-link' href='../pages/individualTimetable.php'>Individual Timetable</a>
                    </li>
                    ";
                }
                ?>
                <?php
                if ($_SESSION['session_access'] == "0") {
                    echo "
                    <li class='nav-item'>
                    <a class='nav-link' href='../pages/tutorialAllocation.php'>Tutorial Allocation</a>
                    </li>
                    ";
                }
                ?>

                <?php
                if ($_SESSION['session_access'] == "5") {
                    echo "
                    <li class='nav-item'>
                    <a class='nav-link' href='../pages/masterList.php'>Master List</a>
                    </li>
                    ";
                }
                ?>

                <?php
                if ($_SESSION['session_access'] == "5" || $_SESSION['session_access'] == "4") {
                    echo "
                    <li class='nav-item active'>
                    <a class='nav-link' href='../pages/unitManagement.php'>Unit Management</a>
                    </li>
                    ";
                }
                ?>
                <?php
                if ($_SESSION['session_access'] == "5" || $_SESSION['session_access'] == "4" || $_SESSION['session_access'] == "3" || $_SESSION['session_access'] == "3") {
                    echo "
                    <li class='nav-item'>
                    <a class='nav-link' href='../pages/enrolledDetails.php'>Enrolled Student Details</a>
                    </li>
                    ";
                }
                ?>
                <li class='nav-item'>
                    <a class='nav-link' href='../pages/userAccount.php'>User Account</a>
                </li>
            </ul>
            <form class="form-inline mb-0">
                <?php
                if ($session_user != "") {
                    echo "<a class='btn btn-success' href='../php/session_out.php' role='button'>Logout</a>";
                } else {
                    echo "<a class='btn btn-success' href='../pages/login.php' role='button'>Login / Register</a>";
                }
                ?>
            </form>
        </div>
    </nav>
    <!-- NOTE jumbotron -->
    <div class="jumbotron jumbotron-fluid img-fluid text-center bg">
        <div class="container h-100">
            <h1 class="display-4 mb-5 text-white">Unit Management</h1>
            <?php
            if (!empty($_GLOBALS['unitDetails'])) {
                echo '<p class="display-4  text-white">' . $_GET['code'] . ' - ' . $_GLOBALS['unitDetails']['unit_name'] . '</p>';
            }
            ?>
        </div>
    </div>
    <!-- NOTE content -->
    <div class="container">
        <?php
        if (!empty($_GET['code'])) {
            echo ' <div class="row">
            <div class="col-2">
                <div class="list-group" id="list-tab" role="tablist">
                    <a class="list-group-item list-group-item-action active" id="list-lecture-list" data-toggle="list" href="#list-lecture" role="tab" aria-controls="lecture">Lecture</a>
                    <a class="list-group-item list-group-item-action" id="list-tutorial-list" data-toggle="list" href="#list-tutorial" role="tab" aria-controls="tutorial">Tutorial</a>
                </div>
            </div>
            <div class="col-10">
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="list-lecture" role="tabpanel" aria-labelledby="list-lecture-list">
                        <div class="card">
                            <div class="card-body">
                                <button type="button" class="btn btn-primary mb-3" id="btnCreateLecture" data-toggle="modal" data-target="#createLecture">Create New Lecture</button>
                                <form id="lectureManagementForm" name="lectureManagementForm" onsubmit="lectureManagementFormSubmit(this)">
                                    <table class="table table-striped table-bordered table-responsive-xl">
                                        <!-- NOTE if no unit alert -->
                                        <thead>
                                            <tr>
                                                <th scope="col">Day</th>
                                                <th scope="col">Start Time</th>
                                                <th scope="col">Duration</th>
                                                <th scope="col">Location</th>
                                                <th scope="col">Semester and Campus</th>
                                                <th scope="col">Lecturer ID</th>
                                                <th scope="col">Consulation</th>
                                                <th scope="col"></th>
                                            </tr>
                                        </thead>
                                        <tbody>';
            $lecQuery = "SELECT * FROM assignment_lectures WHERE details_id='" . $_GLOBALS['unitDetails']['id'] . "'";
            $lecResult = $mysqli->query($lecQuery);
            if ($lecResult->num_rows > 0) {
                while ($row = $lecResult->fetch_assoc()) {
                    echo "<tr id='" . $row['id'] . "'>
                    <td class='align-middle'>" . $row['day'] . "</td>
                    <td class='align-middle'>" . $row['time'] . "</td>
                    <td class='align-middle'>" . $row['duration'] . "</td>
                    <td class='align-middle'>" . $row['location'] . "</td>";

                    $selectSCQuery = "SELECT semester, campus FROM assignment_units_lists WHERE id='" . $row['units_lists_id'] . "'";
                    $selectSCResult = $mysqli->query($selectSCQuery);
                    $rowSC = $selectSCResult->fetch_assoc();
                    echo "<td data-lists-id='" . $row['units_lists_id'] . "' class='align-middle'>" . $rowSC['semester'] . ", " . $rowSC['campus'] . "</td>";

                    echo "<td class='align-middle'>" . $row['sta_id'] . "</td>
                    <td class='align-middle'>" . $row['consulation'] . "</td>
                    <td class='align-middle'>
                    <div class='btn-group btn-group-sm'>
                    <button type='button' class='btn btn-sm btn-light d-inline' onclick='editLecture(this)'><span class='fas fa-pencil-alt'></span></button>
                    <button type='button' class='btn btn-sm btn-light d-inline' onclick='showRemove(this)'><span class='fas fa-trash-alt'></span></button>
                    <button type='button' class='btn btn-danger d-none' onclick='removeLecture(this)'>Confirm</button>
                    </div>
                    </td>
                    </tr>";
                }
            }
            echo '</tbody>
                                    </table>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="list-tutorial" role="tabpanel" aria-labelledby="list-tutorial-list">
                    <div class="card">
                    <div class="card-body">
                        <button type="button" class="btn btn-primary mb-3" id="btnCreateTutorial" data-toggle="modal" data-target="#createTutorial">Create New Tutorial</button>
                        <form id="tutorialManagementForm" name="tutorialManagementForm" onsubmit="tutorialManagementFormSubmit(this)">
                            <table class="table table-striped table-bordered table-responsive-xl">
                                <!-- NOTE if no unit alert -->
                                <thead>
                                    <tr>
                                        <th scope="col">Day</th>
                                        <th scope="col">Start Time</th>
                                        <th scope="col">Duration</th>
                                        <th scope="col">Location</th>
                                        <th scope="col">Semester and Campus</th>
                                        <th scope="col">Tutor ID</th>
                                        <th scope="col">Capacity</th>
                                        <th scope="col">Consulation</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>';
            $tutoQuery = "SELECT * FROM assignment_tutorials WHERE details_id='" . $_GLOBALS['unitDetails']['id'] . "'";
            $tutoResult = $mysqli->query($tutoQuery);
            if ($tutoResult->num_rows > 0) {
                while ($row = $tutoResult->fetch_assoc()) {
                    echo "<tr id='" . $row['id'] . "'>
                    <td class='align-middle'>" . $row['day'] . "</td>
                    <td class='align-middle'>" . $row['time'] . "</td>
                    <td class='align-middle'>" . $row['duration'] . "</td>
                    <td class='align-middle'>" . $row['location'] . "</td>";
                    $selectSCQuery = "SELECT semester, campus FROM assignment_units_lists WHERE id='" . $row['units_lists_id'] . "'";
                    $selectSCResult = $mysqli->query($selectSCQuery);
                    $rowSC = $selectSCResult->fetch_assoc();
                    echo "<td data-lists-id='" . $row['units_lists_id'] . "' class='align-middle'>" . $rowSC['semester'] . ", " . $rowSC['campus'] . "</td>";

                    echo "<td class='align-middle'>" . $row['sta_id'] . "</td>
                    <td class='align-middle'>" . $row['capacity'] . "</td>
                    <td class='align-middle'>" . $row['consulation'] . "</td>
                    <td class='align-middle'>
                    <div class='btn-group btn-group-sm'>
                    <button type='button' class='btn btn-sm btn-light d-inline' onclick='editTutorial(this)'><span class='fas fa-pencil-alt'></span></button>
                    <button type='button' class='btn btn-sm btn-light d-inline' onclick='showRemove(this)'><span class='fas fa-trash-alt'></span></button>
                    <button type='button' class='btn btn-danger d-none' onclick='removeTutorial(this)'>Confirm</button>
                    </div>
                    </td>
                    </tr>";
                }
            }
            echo '</tbody>
                         </table>
                            </form>
                        </div>
                     </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>';
        } else {
            $selectUnitResult = '';
            if ($_SESSION['session_access'] == "5") {
                //NOTE DC can manage every unit.
                $selectUnitQuery = "SELECT unit_code, unit_name FROM assignment_units_details ORDER BY unit_code ASC";
                $selectUnitResult = $mysqli->query($selectUnitQuery);
            } else if ($_SESSION['session_access'] == "4") {
                //NOTE UC can manage their uints.
                $selectUnitQuery = "SELECT unit_code, unit_name FROM assignment_units_details WHERE unit_coordinator_id = '" . $_SESSION['session_user'] . "'";
                $selectUnitResult = $mysqli->query($selectUnitQuery);
            }
            if ($selectUnitResult->num_rows > 0) {
                echo '
                <div>
                <table class="table table-striped table-bordered table-responsive-md shadow">
                    <thead>
                        <tr>
                            <th scope="col">Unit Code</th>
                            <th scope="col">Unit Name</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>';
                while ($row = $selectUnitResult->fetch_assoc()) {
                    echo "<tr>";
                    foreach ($row as $key => $value) {
                        echo "<td>$value</td>";
                    }
                    echo '<td class="d-flex justify-content-center"><a name="' . $row['unit_code'] . '" id="' . $row['unit_code'] . '" class="btn btn-primary" href="../pages/unitManagement.php?code=' . $row['unit_code'] . '" role="button">Manage Unit</a></td>';
                    echo "</tr>";
                }
                echo '
                 </tbody>
                  </table>
               </div>';
            }
        }
        ?>
        <!--NOTE Create Lecture Modal -->
        <div class="modal fade" id="createLecture" tabindex="-1" role="dialog" aria-labelledby="createLectureLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Create New Lecture</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="createLectureForm" name="createLectureForm" onsubmit="return createNewLectureForm(this, '<?php echo $_GET['code']; ?>', <?php echo $_GLOBALS['unitDetails']['id']; ?>);">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="lecDay">Day</label>
                                <select class="custom-select" name="lecDay" id="lecDay" required>
                                    <option value="" selected>Select a Day</option>
                                    <option value="Monday">Monday</option>
                                    <option value="Tuesday">Tuesday</option>
                                    <option value="Wednesday">Wednesday</option>
                                    <option value="Thursday">Thursday</option>
                                    <option value="Friday">Friday</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="lecHour">Start Time</label>
                                <div class="row d-flex justify-content-around">
                                    <select class="custom-select col-5" name="lecHour" id="lecHour" required>
                                        <option value="" selected>Select a Start Hour</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                        <option value="11">11</option>
                                        <option value="12">12</option>
                                        <option value="13">13</option>
                                        <option value="14">14</option>
                                        <option value="15">15</option>
                                        <option value="16">16</option>
                                    </select>
                                    <span class="d-flex align-items-center">:</span>
                                    <select class="custom-select col-5" name="lecMinute" id="lecMinute" required>
                                        <option value="" selected>Select a Start Minute</option>
                                        <option value="00">00</option>
                                        <option value="30">30</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="lecDuration">Duration</label>
                                <input type="number" class="form-control" name="lecDuration" id="lecDuration" placeholder="Input the number of duration hour(s)" min="1" max="10" required>
                            </div>
                            <div class="form-group">
                                <label for="lecLocation">Location</label>
                                <input type="text" class="form-control" name="lecLocation" id="lecLocation" placeholder="Location" required>
                            </div>
                            <div class="form-group">
                                <label for="lecSC">Available semester and campus</label>
                                <select class="custom-select" name="lecSC" id="lecSC" required>
                                    <?php
                                    $initSCQuery = "SELECT * FROM assignment_units_lists WHERE details_id = '" . $_GLOBALS['unitDetails']['id'] . "' AND availability = '1'";
                                    $initSCResult = $mysqli->query($initSCQuery);
                                    if ($initSCResult->num_rows > 0) {
                                        echo '<option value="" selected>Select a semester and campus</option>';
                                        while ($row = $initSCResult->fetch_assoc()) {
                                            echo '<option value="' . $row['id'] . '">' . $row['semester'] . ', ' . $row['campus'] . '</option>';
                                        }
                                    } else {
                                        echo '<option value="" selected>No available semester and campus</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="lecLecturerID">Lecturer ID</label>
                                <input type="text" class="form-control" name="lecLecturerID" id="lecLecturerID" placeholder="Lecturer ID" required>
                            </div>
                            <div class="form-group">
                                <label for="lecConsulation">Consulation Time</label>
                                <input type="text" class="form-control" name="lecConsulation" id="lecConsulation" placeholder="Lecturer Consulation Time" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- NOTE Manage Lecture Modal -->
        <div class="modal fade" id="manageLecture" tabindex="-1" role="dialog" aria-labelledby="manageLectureLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Manage Lecture</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="manageLectureForm" name="manageLectureForm" onsubmit="return manageNewLectureForm(this,'<?php echo $_GET['code']; ?>');">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="lecDayMan">Day</label>
                                <select class="custom-select" name="lecDayMan" id="lecDayMan" required>
                                    <option value="">Select a Day</option>
                                    <option id="lecDayManMonday" value="Monday">Monday</option>
                                    <option id="lecDayManTuesday" value="Tuesday">Tuesday</option>
                                    <option id="lecDayManWednesday" value="Wednesday">Wednesday</option>
                                    <option id="lecDayManThursday" value="Thursday">Thursday</option>
                                    <option id="lecDayManFriday" value="Friday">Friday</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="lecHourMan">Start Time</label>
                                <div class="row d-flex justify-content-around">
                                    <select class="custom-select col-5" name="lecHourMan" id="lecHourMan" required>
                                        <option value="">Select a Start Hour</option>
                                        <option id="lecHourMan9" value="9">9</option>
                                        <option id="lecHourMan10" value="10">10</option>
                                        <option id="lecHourMan11" value="11">11</option>
                                        <option id="lecHourMan12" value="12">12</option>
                                        <option id="lecHourMan13" value="13">13</option>
                                        <option id="lecHourMan14" value="14">14</option>
                                        <option id="lecHourMan15" value="15">15</option>
                                        <option id="lecHourMan16" value="16">16</option>
                                    </select>
                                    <span class="d-flex align-items-center">:</span>
                                    <select class="custom-select col-5" name="lecMinuteMan" id="lecMinuteMan" required>
                                        <option value="">Select a Start Minute</option>
                                        <option id="lecMinuteMan00" value="00">00</option>
                                        <option id="lecMinuteMan30" value="30">30</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="lecDurationMan">Duration</label>
                                <input type="number" class="form-control" name="lecDurationMan" id="lecDurationMan" placeholder="Input the number of duration hour(s)" min="1" max="10" required>
                            </div>
                            <div class="form-group">
                                <label for="lecLocationMan">Location</label>
                                <input type="text" class="form-control" name="lecLocationMan" id="lecLocationMan" placeholder="Location" required>
                            </div>
                            <div class="form-group">
                                <label for="lecSCMan">Available semester and campus</label>
                                <select class="custom-select" name="lecSCMan" id="lecSCMan" required>
                                    <?php
                                    $initSCQuery = "SELECT * FROM assignment_units_lists WHERE details_id = '" . $_GLOBALS['unitDetails']['id'] . "' AND availability = '1'";
                                    $initSCResult = $mysqli->query($initSCQuery);
                                    if ($initSCResult->num_rows > 0) {
                                        echo '<option value="">Select a semester and campus</option>';
                                        while ($row = $initSCResult->fetch_assoc()) {
                                            echo '<option id="lecSCMan' . $row['id'] . '" value="' . $row['id'] . '">' . $row['semester'] . ', ' . $row['campus'] . '</option>';
                                        }
                                    } else {
                                        echo '<option value="" selected>No available semester and campus</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="lecLecturerIDMan">Lecturer ID</label>
                                <input type="text" class="form-control" name="lecLecturerIDMan" id="lecLecturerIDMan" placeholder="Lecturer ID" required>
                            </div>
                            <div class="form-group">
                                <label for="lecConsulationMan">Consulation Time</label>
                                <input type="text" class="form-control" name="lecConsulationMan" id="lecConsulationMan" placeholder="Lecturer Consulation Time" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- NOTE Create Tutorial Modal -->
        <div class="modal fade" id="createTutorial" tabindex="-1" role="dialog" aria-labelledby="createTutorialLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Create New Tutorial</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="createTutorialForm" name="createTutorialForm" onsubmit="return createNewTutorialForm(this, '<?php echo $_GET['code']; ?>', <?php echo $_GLOBALS['unitDetails']['id']; ?>);">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="tutoDay">Day</label>
                                <select class="custom-select" name="tutoDay" id="tutoDay" required>
                                    <option value="" selected>Select a Day</option>
                                    <option value="Monday">Monday</option>
                                    <option value="Tuesday">Tuesday</option>
                                    <option value="Wednesday">Wednesday</option>
                                    <option value="Thursday">Thursday</option>
                                    <option value="Friday">Friday</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="tutoHour">Start Time</label>
                                <div class="row d-flex justify-content-around">
                                    <select class="custom-select col-5" name="tutoHour" id="tutoHour" required>
                                        <option value="" selected>Select a Start Hour</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                        <option value="11">11</option>
                                        <option value="12">12</option>
                                        <option value="13">13</option>
                                        <option value="14">14</option>
                                        <option value="15">15</option>
                                        <option value="16">16</option>
                                    </select>
                                    <span class="d-flex align-items-center">:</span>
                                    <select class="custom-select col-5" name="tutoMinute" id="tutoMinute" required>
                                        <option value="" selected>Select a Start Minute</option>
                                        <option value="00">00</option>
                                        <option value="30">30</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="tutoDuration">Duration</label>
                                <input type="number" class="form-control" name="tutoDuration" id="tutoDuration" placeholder="Input the number of duration hour(s)" min="1" max="10" required>
                            </div>
                            <div class="form-group">
                                <label for="tutoLocation">Location</label>
                                <input type="text" class="form-control" name="tutoLocation" id="tutoLocation" placeholder="Location" required>
                            </div>
                            <div class="form-group">
                                <label for="tutoSC">Available semester and campus</label>
                                <select class="custom-select" name="tutoSC" id="tutoSC" required>
                                    <?php
                                    $initSCQuery = "SELECT * FROM assignment_units_lists WHERE details_id = '" . $_GLOBALS['unitDetails']['id'] . "' AND availability = '1'";
                                    $initSCResult = $mysqli->query($initSCQuery);
                                    if ($initSCResult->num_rows > 0) {
                                        echo '<option value="" selected>Select a semester and campus</option>';
                                        while ($row = $initSCResult->fetch_assoc()) {
                                            echo '<option value="' . $row['id'] . '">' . $row['semester'] . ', ' . $row['campus'] . '</option>';
                                        }
                                    } else {
                                        echo '<option value="" selected>No available semester and campus</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="tutoTutorID">Tutor ID</label>
                                <input type="text" class="form-control" name="tutoTutorID" id="tutoTutorID" placeholder="Tutor ID" required>
                            </div>
                            <div class="form-group">
                                <label for="tutoCapacity">Capacity</label>
                                <select class="custom-select" name="tutoCapacity" id="tutoCapacity" required>
                                    <option value="" selected>Select a Capacity</option>
                                    <option value="15">15</option>
                                    <option value="30">30</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="tutoConsulation">Consulation Time</label>
                                <input type="text" class="form-control" name="tutoConsulation" id="tutoConsulation" placeholder="Tutorial Consulation Time" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- NOTE Manage Tutorial Modal -->
        <div class="modal fade" id="manageTutorial" tabindex="-1" role="dialog" aria-labelledby="manageTutorialLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Manage Tutorial</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="manageTutorialForm" name="manageTutorialForm" onsubmit="return manageNewTutorialForm(this,'<?php echo $_GET['code']; ?>');">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="tutoDayMan">Day</label>
                                <select class="custom-select" name="tutoDayMan" id="tutoDayMan" required>
                                    <option value="">Select a Day</option>
                                    <option id="tutoDayManMonday" value="Monday">Monday</option>
                                    <option id="tutoDayManTuesday" value="Tuesday">Tuesday</option>
                                    <option id="tutoDayManWednesday" value="Wednesday">Wednesday</option>
                                    <option id="tutoDayManThursday" value="Thursday">Thursday</option>
                                    <option id="tutoDayManFriday" value="Friday">Friday</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="tutoHourMan">Start Time</label>
                                <div class="row d-flex justify-content-around">
                                    <select class="custom-select col-5" name="tutoHourMan" id="tutoHourMan" required>
                                        <option value="">Select a Start Hour</option>
                                        <option id="tutoHourMan9" value="9">9</option>
                                        <option id="tutoHourMan10" value="10">10</option>
                                        <option id="tutoHourMan11" value="11">11</option>
                                        <option id="tutoHourMan12" value="12">12</option>
                                        <option id="tutoHourMan13" value="13">13</option>
                                        <option id="tutoHourMan14" value="14">14</option>
                                        <option id="tutoHourMan15" value="15">15</option>
                                        <option id="tutoHourMan16" value="16">16</option>
                                    </select>
                                    <span class="d-flex align-items-center">:</span>
                                    <select class="custom-select col-5" name="tutoMinuteMan" id="tutoMinuteMan" required>
                                        <option value="" selected>Select a Start Minute</option>
                                        <option id="tutoMinuteMan00" value="00">00</option>
                                        <option id="tutoMinuteMan30" value="30">30</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="tutoDurationMan">Duration</label>
                                <input type="number" class="form-control" name="tutoDurationMan" id="tutoDurationMan" placeholder="Input the number of duration hour(s)" min="1" max="10" required>
                            </div>
                            <div class="form-group">
                                <label for="tutoLocationMan">Location</label>
                                <input type="text" class="form-control" name="tutoLocationMan" id="tutoLocationMan" placeholder="Location" required>
                            </div>
                            <div class="form-group">
                                <label for="tutoSCMan">Available semester and campus</label>
                                <select class="custom-select" name="tutoSCMan" id="tutoSCMan" required>
                                    <?php
                                    $initSCQuery = "SELECT * FROM assignment_units_lists WHERE details_id = '" . $_GLOBALS['unitDetails']['id'] . "' AND availability = '1'";
                                    $initSCResult = $mysqli->query($initSCQuery);
                                    if ($initSCResult->num_rows > 0) {
                                        echo '<option value="">Select a semester and campus</option>';
                                        while ($row = $initSCResult->fetch_assoc()) {
                                            echo '<option id="tutoSCMan' . $row['id'] . '" value="' . $row['id'] . '">' . $row['semester'] . ', ' . $row['campus'] . '</option>';
                                        }
                                    } else {
                                        echo '<option value="" selected>No available semester and campus</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="tutoTutorIDMan">Tutor ID</label>
                                <input type="text" class="form-control" name="tutoTutorIDMan" id="tutoTutorIDMan" placeholder="Tutor ID" required>
                            </div>
                            <div class="form-group">
                                <label for="tutoCapacityMan">Capacity</label>
                                <select class="custom-select" name="tutoCapacityMan" id="tutoCapacityMan" required>
                                    <option value="">Select a Capacity</option>
                                    <option id="tutoCapacityMan15" value="15">15</option>
                                    <option id="tutoCapacityMan30" value="30">30</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="tutoConsulationMan">Consulation Time</label>
                                <input type="text" class="form-control" name="tutoConsulationMan" id="tutoConsulationMan" placeholder="Tutorial Consulation Time" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- NOTE footer -->
    <footer class="footer mt-auto py-3 bg-dark">
        <div class="container-fluid text-white d-flex align-center justify-content-center">
            <div class="column">
                <div class="d-flex justify-content-center">
                    <img class="py-6" src="../imgs/logo.png">
                </div>
                <div class="mt-2">
                    <p class="text-muted">The University of DoWell in Wonderland (UDW) has started to build a Course
                        Management System including a new tutorial allocation system.</p>
                </div>
            </div>
        </div>
    </footer>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <script type="text/javascript" src="../JS/unitManagement.js"></script>
</body>

</html>