<?php
include('../php/db_conn.php');
include('../php/session.php');
if ($_SESSION['session_user'] != "") {
    if ($_SESSION['session_access'] == '0') {
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
    <link rel="stylesheet" href="../CSS/enrolledDetails.css">
    <title>Enrolled Student Details - University of DoWell</title>
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
                    <li class='nav-item'>
                    <a class='nav-link' href='../pages/unitManagement.php'>Unit Management</a>
                    </li>
                    ";
                }
                ?>
                <?php
                if ($_SESSION['session_access'] == "5" || $_SESSION['session_access'] == "4" || $_SESSION['session_access'] == "3" || $_SESSION['session_access'] == "2") {
                    echo "
                    <li class='nav-item active'>
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
            <h1 class="display-4 mb-5 text-white">Enrolled Student Details</h1>
        </div>
    </div>
    <!-- NOTE content -->
    <div class="container">
        <div>
            <?php
            $selectDetailsQuery = "SELECT * FROM assignment_students_timetable ORDER BY stu_id";
            $selectDetailsResult = $mysqli->query($selectDetailsQuery);
            if ($selectDetailsResult->num_rows > 0) {
                echo '
                <table class="table table-striped table-bordered table-responsive-lg shadow p-3 mb-5 bg-white rounded">
                <thead>
                    <tr>
                        <th scope="col">Student ID</th>
                        <th scope="col">Student Name</th>
                        <th scope="col">Unit Code</th>
                        <th scope="col">Unit Name</th>
                        <th scope="col">Day</th>
                        <th scope="col">Time</th>
                        <th scope="col">Semester</th>
                        <th scope="col">Campus</th>
                        <th scope="col">Location</th>
                        <th scope="col">Duration</th>
                    </tr>
                </thead>
                <tbody>';
                while ($rowSelectDetails = $selectDetailsResult->fetch_assoc()) {
                    //get student information
                    $selectStudentDetailsQuery = "SELECT st_id, name FROM assignment_students WHERE st_id = '" . $rowSelectDetails['stu_id'] . "'";
                    $selectStudentDetailsResult = $mysqli->query($selectStudentDetailsQuery);
                    $rowSelectStudentDetails = $selectStudentDetailsResult->fetch_assoc();

                    //get unit information
                    $selectUnitDetailsQuery = "SELECT unit_code, unit_name FROM assignment_units_details WHERE id='" . $rowSelectDetails['details_id'] . "'";
                    $selectUnitDetailsResult = $mysqli->query($selectUnitDetailsQuery);
                    $rowSelectUnitDetails = $selectUnitDetailsResult->fetch_assoc();

                    // get tutorial information
                    $selectTutorialDetailsQuery = "SELECT * FROM assignment_tutorials WHERE id = '" . $rowSelectDetails['tutorial_id'] . "'";
                    $selectTutorialDetailsResult = $mysqli->query($selectTutorialDetailsQuery);
                    $rowSelectTutorialDetails = $selectTutorialDetailsResult->fetch_assoc();

                    //get smester and campus
                    $selectSCQuery = "SELECT semester, campus FROM assignment_units_lists WHERE id='" . $rowSelectTutorialDetails['units_lists_id'] . "'";
                    $selectSCResult = $mysqli->query($selectSCQuery);
                    $rowSelectSC = $selectSCResult->fetch_assoc();

                    echo '
                <tr>
                <td class="align-middle">' . $rowSelectStudentDetails['st_id'] . '</td>
                <td class="align-middle">' . $rowSelectStudentDetails['name'] . '</td>
                <td class="align-middle">' . $rowSelectUnitDetails['unit_code'] . '</td>
                <td class="align-middle">' . $rowSelectUnitDetails['unit_name'] . '</td>
                <td class="align-middle">' . $rowSelectTutorialDetails['day'] . '</td>
                <td class="align-middle">' . $rowSelectTutorialDetails['time'] . '</td>
                <td class="align-middle">' . $rowSelectSC['semester'] . '</td>
                <td class="align-middle">' . $rowSelectSC['campus'] . '</td>
                <td class="align-middle">' . $rowSelectTutorialDetails['location'] . '</td>
                <td class="align-middle">' . $rowSelectTutorialDetails['duration'] . ' hour(s)</td>
                </tr>
                ';
                }
                echo ' </tbody>
            </table>';
            } else {
                echo '<div class="card">
        <div class="card-body">
            <p class="card-text">Do not have any records.</p>
        </div>
     </div>';
            }
            ?>
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
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
    </script>
</body>

</html>