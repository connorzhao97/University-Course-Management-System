<?php
include("../php/db_conn.php");
include("../php/session.php");
if ($_SESSION['session_user'] != "") {
    if ($_SESSION['session_access'] != '5') {
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
    <link rel="stylesheet" href="../CSS/masterList.css">
    <title>Master List - University of DoWell</title>
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
                    <li class='nav-item active'>
                    <a class='nav-link' href='../pages/masterList.php'>Master List</a>
                    </li>
                    ";
                }
                ?>

                <?php
                if ($_SESSION['session_access'] == "5" || $_SESSION['session_access'] == "4") {
                    echo "
                    <li class='nav-item'>
                    <a class='nav-link' href='../pages/unitManagement.php'>Unit Management</a>
                    </li>
                    ";
                }
                ?>
                <?php
                if ($_SESSION['session_access'] == "5" || $_SESSION['session_access'] == "4" || $_SESSION['session_access'] == "3" || $_SESSION['session_access'] == "2") {
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
            <h1 class="display-4 mb-5 text-white">Staff Management</h1>
        </div>
    </div>
    <!-- NOTE content -->
    <div class="container-fluid px-5">
        <div class="nav nav-pills flex-column flex-sm-row mb-2 shadow p-3 mb-5 bg-white rounded" id="pills-tab" role="tablist">
            <a class="flex-sm-fill text-sm-center nav-link active" id="pills-first-tab" data-toggle="pill" href="#pills-first" role="tab" aria-controls="pills-first" aria-selected="true">Staff Management</a>
            <a class="flex-sm-fill text-sm-center nav-link" id="pills-second-tab" data-toggle="pill" href="#pills-second" role="tab" aria-controls="pills-second" aria-selected="false">Unit Management</a>
        </div>
        <div class="tab-content shadow-lg p-3 mb-5 bg-white rounded" id="pills-tabContent">
            <!-- NOTE staff management -->
            <div class="tab-pane fade show active" id="pills-first" role="tabpanel" aria-labelledby="pills-first-tab">
                <button type="button" class="btn btn-primary mb-3" id="btnCreateStaff" data-toggle="modal" data-target="#createNewStaff">Create New Staff</button>
                <table class="table table-striped table-bordered table-responsive-lg" id="staManagementTable">
                    <thead>
                        <tr>
                            <th scope="col">Staff ID</th>
                            <th scope="col">Staff Name</th>
                            <th scope="col">Qualification</th>
                            <th scope="col">Expertise</th>
                            <th scope="col">Unavailability</th>
                            <th scope="col">Role</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $selectStaffQuery = "SELECT st_id, name, qualification, expertise, unavailability FROM assignment_staffs";
                        $selectStaffResult = $mysqli->query($selectStaffQuery);
                        if ($selectStaffResult->num_rows > 0) {
                            while ($row = $selectStaffResult->fetch_assoc()) {
                                echo "<tr>";
                                foreach ($row as $key => $value) {
                                    echo "<td class='align-middle'>$value</td>";
                                }
                                $selectAccessQuery = "SELECT access FROM assignment_users WHERE st_id ='" . $row['st_id'] . "' ORDER BY st_id ASC";
                                $selctAccessResult = $mysqli->query($selectAccessQuery);
                                $rowAccess = $selctAccessResult->fetch_assoc();
                                switch ($rowAccess['access']) {
                                    case '1':
                                        echo "<td class='align-middle'>Staff</td>";
                                        break;
                                    case '2':
                                        echo "<td class='align-middle'>Tutor</td>";
                                        break;
                                    case '3':
                                        echo "<td class='align-middle'>Lecturer</td>";
                                        break;
                                    case '4':
                                        echo "<td class='align-middle'>Unit Coordinator</td>";
                                        break;
                                    case '5':
                                        echo "<td class='align-middle'>Degree Coordinator</td>";
                                        break;
                                    default:
                                        break;
                                }
                                echo "</tr>";
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <!-- NOTE unit management -->
            <div class="tab-pane fade" id="pills-second" role="tabpanel" aria-labelledby="pills-second-tab">
                <div class="tab-pane fade show active" id="pills-first" role="tabpanel" aria-labelledby="pills-first-tab">
                    <button type="button" class="btn btn-primary mb-3" id="btnCreateUnit" data-toggle="modal" data-target="#createNewUnit">Create New Unit</button>
                    <!-- NOTE method="post" -->
                    <form name="unitManagementForm" id="unitManagementForm" onsubmit="return unitManagementFormSubmit(this)">
                        <table class="table table-striped table-bordered table-responsive-xl">
                            <thead>
                                <tr>
                                    <th scope="col">Unit Code</th>
                                    <th scope="col">Unit Name</th>
                                    <th scope="col">Semester</th>
                                    <th scope="col">Campus</th>
                                    <th scope="col">UC ID</th>
                                    <th scope="col">UC Name</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $quert = "SELECT unit_code, unit_name, semester, campus, unit_coordinator_id, description FROM assignment_units_details ORDER BY unit_code";
                                $result = $mysqli->query($quert);
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>";
                                        foreach ($row as $key => $value) {
                                            if ($key == "unit_coordinator_id") {
                                                if (!empty($value)) {
                                                    $selectNameQuery = "SELECT name FROM assignment_staffs WHERE st_id = '$value'";
                                                    $selectNameResult = $mysqli->query($selectNameQuery);
                                                    if ($selectNameResult->num_rows > 0) {
                                                        $rowName = $selectNameResult->fetch_assoc();
                                                        echo "<td class='align-middle'>" . $value . "</td>";
                                                        echo "<td class='align-middle'>" . $rowName['name'] . "</td>";
                                                    }
                                                } else {
                                                    echo "<td class='align-middle'></td>";
                                                    echo "<td class='align-middle'></td>";
                                                }
                                            } else if ($key == "description") {
                                                echo "<td class='align-middle text-truncate' style='max-width: 400px;'>$value</td>";
                                            } else {
                                                echo "<td class='align-middle'>$value</td>";
                                            }
                                        }
                                        echo "
                                        <td class='action'>
                                        <div class='btn-group btn-group-sm'>
                                        <button type='button' class='btn btn-sm btn-light d-inline' onclick='editUnit(this)'><span class='fas fa-pencil-alt'></span></button>
                                        <button type='button' class='btn btn-sm btn-light d-inline' onclick='showRemove(this)'><span class='fas fa-trash-alt'></span></button>
                                        <button type='button' class='btn btn-danger d-none' onclick='removeUnit(this)'>Confirm</button>
                                        </div>
                                        </td>
                                        ";
                                        echo "</tr>";
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
        <!-- NOTE create staff modal -->
        <div class="modal fade" id="createNewStaff" tabindex="-1" role="dialog" aria-labelledby="createNewStaffLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle">Create New Staff</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="fCNSta" name="fCNSta" onsubmit="return createNewStaffForm(this);">
                            <div class="form-group">
                                <label for="staNewID">Staff ID</label>
                                <input type="text" class="form-control" name="staNewID" id="staNewID" placeholder="Staff ID" required>
                            </div>
                            <div class="form-group">
                                <label for="staNewName">Staff Name</label>
                                <input type="text" class="form-control" name="staNewName" id="staNewName" placeholder="Staff Name" required>
                            </div>
                            <div class="form-group">
                                <label for="staNewPassword">Password</label>
                                <input type="password" id="staNewPassword" name="staNewPassword" class="form-control" placeholder="Set default password" aria-describedby="passwordHelpId" pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^]).{6,12}" required>
                                <small id="passWordHelpId" class="text-muted"> Password must be 6-12 characters
                                    long, contain at least 1 lowercase letter,1 uppercase letter,1 number and one of
                                    following special characters ! @ # $ % ^</small>
                            </div>
                            <div class="form-group">
                                <label for="repassword">Re-enter Password</label>
                                <input type="password" id="staRePassword" name="staRePassword" class="form-control" placeholder="Re-enter default password" required>
                            </div>
                            <div class="form-group">
                                <label for="staNewQua">Qualification</label>
                                <select class="custom-select" name="staNewQua" id="staNewQua" required>
                                    <option value="" selected>Select Qualification</option>
                                    <option value="Bachelor">Bachelor</option>
                                    <option value="Master">Master</option>
                                    <option value="PhD">PhD</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="staNewExp">Expertise</label>
                                <input type="text" id="staNewExp" name="staNewExp" class="form-control" placeholder="e.g. Information Systems" required>
                            </div>
                            <div class="form-group">
                                <label for="staNewRole">Role</label>
                                <select class="custom-select" name="staNewRole" id="staNewRole" required>
                                    <option value="" selected>Select Role</option>
                                    <option value="1">Staff</option>
                                    <option value="2">Tutor</option>
                                    <option value="3">Lecturer</option>
                                    <option value="4">Unit Coordinator</option>
                                    <option value="5">Degree Coordinator</option>
                                </select>
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

        <!-- NOTE manage staff modal -->
        <div class="modal fade" id="manageStaff" tabindex="-1" role="dialog" aria-labelledby="manageStaffLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle">Manage Staff</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="fMSta" onsubmit="return validate();">
                            <div class="form-group">
                                <label for="staID">Staff ID</label>
                                <input type="text" class="form-control" name="" id="" placeholder="" required>
                            </div>
                            <div class="form-group">
                                <label for="staName">Staff Name</label>
                                <input type="text" class="form-control" name="" id="" placeholder="" required>
                            </div>
                            <div class="form-group">
                                <label for="staQua">Qualification</label>
                                <select class="custom-select" name="" id="" required>
                                    <option value="" selected>Select Qualification</option>
                                    <option value="PhD">PhD</option>
                                    <option value="Master">Master</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="staExp">Expertise</label>
                                <select class="custom-select" name="" id="" required>
                                    <option value="" selected>Select Expertise</option>
                                    <option value="informationSystems">Information Systems</option>
                                    <option value="humanComputerInteraction">Human Computer Interaction</option>
                                    <option value="networkAdministration">Network Administration</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <div class="column">
                                    <label for="staPreDyas">Preferred days of teaching</label>
                                    <div class="checkboxGroup" required>
                                        <div class="custom-control custom-checkbox custom-control-inline">
                                            <input type="checkbox" id="customCheckboxInlineMon" name="customCheckboxInlineMon" class="custom-control-input">
                                            <label class="custom-control-label" for="customCheckboxInlineMon">Mon.</label>
                                        </div>
                                        <div class="custom-control custom-checkbox custom-control-inline">
                                            <input type="checkbox" id="customCheckboxInlineTue" name="customCheckboxInlineTue" class="custom-control-input">
                                            <label class="custom-control-label" for="customCheckboxInlineTue">Tue.</label>
                                        </div>
                                        <div class="custom-control custom-checkbox custom-control-inline">
                                            <input type="checkbox" id="customCheckboxInlineWed" name="customCheckboxInlineWed" class="custom-control-input">
                                            <label class="custom-control-label" for="customCheckboxInlineWed">Wed.</label>
                                        </div>
                                        <div class="custom-control custom-checkbox custom-control-inline">
                                            <input type="checkbox" id="customCheckboxInlineThu" name="customCheckboxInlineThu" class="custom-control-input">
                                            <label class="custom-control-label" for="customCheckboxInlineThu">Thu.</label>
                                        </div>
                                        <div class="custom-control custom-checkbox custom-control-inline">
                                            <input type="checkbox" id="customCheckboxInlineFri" name="customCheckboxInlineFri" class="custom-control-input">
                                            <label class="custom-control-label" for="customCheckboxInlineFri">Fri.</label>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback">
                                        Please select one preferred of teaching day at least.
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="staCon">Consultation hours</label>
                                <input type="text" class="form-control" name="" id="" placeholder="" required>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" onsubmit="manageStaff()">Save</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>


        <!-- NOTE create unit modal -->
        <div class="modal fade" id="createNewUnit" tabindex="-1" role="dialog" aria-labelledby="createNewUnitLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle">Create New Unit</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="fCNUnit" name="fCNUnit" onsubmit="return createNewUnitForm(this);">
                            <div class="form-group">
                                <label for="unitCode">Unit Code</label>
                                <input type="text" class="form-control" name="unitCode" id="unitCode" placeholder="Unit Code" required>
                            </div>
                            <div class="form-group">
                                <label for="unitName">Unit Name</label>
                                <input type="text" class="form-control" name="unitName" id="unitName" placeholder="Unit Name" required>
                            </div>
                            <div class="form-group">
                                <label for="unitSemester">Semesters</label>
                                <div id="semesterCheckboxGroup" required>
                                    <div class="custom-control custom-checkbox custom-control-inline">
                                        <input type="checkbox" id="unitSem1" name="unitSem1" class="custom-control-input">
                                        <label class="custom-control-label" for="unitSem1">Semester 1</label>
                                    </div>
                                    <div class="custom-control custom-checkbox custom-control-inline">
                                        <input type="checkbox" id="unitSem2" name="unitSem2" class="custom-control-input">
                                        <label class="custom-control-label" for="unitSem2">Semester 2</label>
                                    </div>
                                    <div class="custom-control custom-checkbox custom-control-inline">
                                        <input type="checkbox" id="unitWinter" name="unitWinter" class="custom-control-input">
                                        <label class="custom-control-label" for="unitWinter">Winter School</label>
                                    </div>
                                    <div class="custom-control custom-checkbox custom-control-inline">
                                        <input type="checkbox" id="unitSpring" name="unitSpring" class="custom-control-input">
                                        <label class="custom-control-label" for="unitSpring">Spring School</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="unitCampus">Campuses</label>
                                <div id="campusCheckboxGroup" required>
                                    <div class="custom-control custom-checkbox custom-control-inline">
                                        <input type="checkbox" id="unitPandora" name="unitPandora" class="custom-control-input">
                                        <label class="custom-control-label" for="unitPandora">Pandora</label>
                                    </div>
                                    <div class="custom-control custom-checkbox custom-control-inline">
                                        <input type="checkbox" id="unitRivendell" name="unitRivendell" class="custom-control-input">
                                        <label class="custom-control-label" for="unitRivendell">Rivendell</label>
                                    </div>
                                    <div class="custom-control custom-checkbox custom-control-inline">
                                        <input type="checkbox" id="unitNeverland" name="unitNeverland" class="custom-control-input">
                                        <label class="custom-control-label" for="unitNeverland">Neverland</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="unitCoordinatorID">Unit Coordinator ID</label>
                                <input type="text" class="form-control" name="unitCoordinatorID" id="unitCoordinatorID" placeholder="Input Staff ID to allocate" required>
                            </div>
                            <div class="form-group">
                                <label for="description">Unit Description</label>
                                <textarea class="form-control" name="unitDescription" id="unitDescription" rows="3" required></textarea>
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

        <!-- NOTE manage unit modal -->
        <div class="modal fade" id="manageUnit" tabindex="-1" role="dialog" aria-labelledby="manageUnitLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle">Manage Unit</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="fMUnit" name="fMUnit" onsubmit="return manageUnitForm(this);">
                            <div class="form-group">
                                <label for="unitCode">Unit Code</label>
                                <input type="text" class="form-control" name="unitCode" id="unitCodeMan" placeholder="Unit Code" required>
                            </div>
                            <div class="form-group">
                                <label for="unitName">Unit Name</label>
                                <input type="text" class="form-control" name="unitName" id="unitNameMan" placeholder="Unit Name" required>
                            </div>
                            <div class="form-group">
                                <label for="unitSemester">Semesters</label>
                                <div id="semesterCheckboxGroupMan" required>
                                    <div class="custom-control custom-checkbox custom-control-inline">
                                        <input type="checkbox" id="unitSem1Man" name="unitSem1" class="custom-control-input">
                                        <label class="custom-control-label" for="unitSem1Man">Semester 1</label>
                                    </div>
                                    <div class="custom-control custom-checkbox custom-control-inline">
                                        <input type="checkbox" id="unitSem2Man" name="unitSem2" class="custom-control-input">
                                        <label class="custom-control-label" for="unitSem2Man">Semester 2</label>
                                    </div>
                                    <div class="custom-control custom-checkbox custom-control-inline">
                                        <input type="checkbox" id="unitWinterMan" name="unitWinter" class="custom-control-input">
                                        <label class="custom-control-label" for="unitWinterMan">Winter School</label>
                                    </div>
                                    <div class="custom-control custom-checkbox custom-control-inline">
                                        <input type="checkbox" id="unitSpringMan" name="unitSpring" class="custom-control-input">
                                        <label class="custom-control-label" for="unitSpringMan">Spring School</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="unitCampusMan">Campuses</label>
                                <div id="campusCheckboxGroupMan" required>
                                    <div class="custom-control custom-checkbox custom-control-inline">
                                        <input type="checkbox" id="unitPandoraMan" name="unitPandora" class="custom-control-input">
                                        <label class="custom-control-label" for="unitPandoraMan">Pandora</label>
                                    </div>
                                    <div class="custom-control custom-checkbox custom-control-inline">
                                        <input type="checkbox" id="unitRivendellMan" name="unitRivendell" class="custom-control-input">
                                        <label class="custom-control-label" for="unitRivendellMan">Rivendell</label>
                                    </div>
                                    <div class="custom-control custom-checkbox custom-control-inline">
                                        <input type="checkbox" id="unitNeverlandMan" name="unitNeverland" class="custom-control-input">
                                        <label class="custom-control-label" for="unitNeverlandMan">Neverland</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="unitCoordinatorIDMan">Unit Coordinator ID</label>
                                <input type="text" class="form-control" name="unitCoordinatorIDMan" id="unitCoordinatorIDMan" placeholder="Input Staff ID to allocate" required>
                            </div>
                            <div class="form-group">
                                <label for="description">Unit Description</label>
                                <textarea class="form-control" name="unitDescription" id="unitDescriptionMan" rows="3" required></textarea>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success">Save</button>
                            </div>
                        </form>
                    </div>
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
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
    </script>
    <!-- Link to use icon-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <script src="../JS/jquery.tabledit.min.js"></script>
    <!-- Optional JavaScript -->
    <script type="text/javascript" src="../JS/masterList.js"></script>
</body>

</html>