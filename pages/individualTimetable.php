<?php
include('../php/session.php');
include('../php/db_conn.php');
if ($_SESSION['session_user'] != "") {
    if ($_SESSION['session_access'] != '0') {
        //NOTE students cannot access
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
    <link rel="stylesheet" href="../CSS/individualTimetable.css">
    <title>Individual Timetable - University of DoWell</title>
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
                    <li class='nav-item active' >
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
                    echo "<a class='btn btn-warning' href='../php/session_out.php' role='button'>Logout</a>";
                }
                ?>
            </form>
        </div>
    </nav>
    <!-- NOTES jumbotron -->
    <div class="jumbotron jumbotron-fluid img-fluid text-center bg">
        <div class="container h-100">
            <h1 class="display-4 mb-5 text-white">Individual Timetable</h1>
            <div class="row justify-content-around">
                <a id="enrolment" class="btn btn-info btn-lg col-md-4" href="../pages/unitEnrolment.php" role="button">Manage enrolled units</a>
                <a id="allocation" class="btn btn-warning btn-lg col-md-4" href="../pages/tutorialAllocation.php" role="button">Tutorial allocation system</a>
            </div>
        </div>
    </div>
    <!-- NOTE content -->
    <div class="container">
        <?php
        //get enrolled units
        $selectEnrolmentQuery = "SELECT * FROM assignment_students_enrolments WHERE stu_id= '" . $_SESSION['session_user'] . "' ORDER BY details_id";
        $selectEnrolmentResult = $mysqli->query($selectEnrolmentQuery);
        if ($selectEnrolmentResult->num_rows > 0) {
            echo '<table class="table table-striped table-bordered table-responsive-xl shadow p-3 mb-5 bg-white rounded">
            <thead>
                <tr>
                    <th scope="col">Unit Code</th>
                    <th scope="col">Unit Name</th>
                    <th scope="col">Group</th>
                    <th scope="col">Day</th>
                    <th scope="col">Time</th>
                    <th scope="col">Semester</th>
                    <th scope="col">Campus</th>
                    <th scope="col">Location</th>
                    <th scope="col">Duration</th>
                </tr>
            </thead>
            <tbody>';
            while ($rowSelectEnrolment = $selectEnrolmentResult->fetch_assoc()) {
                //get unit details
                $selectDetailsQuery = "SELECT unit_code, unit_name FROM assignment_units_details WHERE id='" . $rowSelectEnrolment['details_id'] . "'";
                $selectDetailsResult = $mysqli->query($selectDetailsQuery);
                $rowSelectDetails = $selectDetailsResult->fetch_assoc();

                //get lecture information
                $selectLectureQuery = "SELECT * FROM assignment_lectures WHERE units_lists_id='" . $rowSelectEnrolment['units_lists_id'] . "'";
                $selectLectureResult = $mysqli->query($selectLectureQuery);
                $rowSelectLecture = $selectLectureResult->fetch_assoc();

                //get semester and campus
                $selectSCQuery = "SELECT semester, campus FROM assignment_units_lists WHERE id='" . $rowSelectEnrolment['units_lists_id'] . "'";
                $selectSCResult = $mysqli->query($selectSCQuery);
                $rowSelectSC = $selectSCResult->fetch_assoc();

                echo '
                    <tr id="lec' . $rowSelectLecture['id'] . '">
                    <td class="align-middle">' . $rowSelectDetails['unit_code'] . '</td>
                    <td class="align-middle">' . $rowSelectDetails['unit_name'] . '</td>
                    <td class="align-middle">Lec</td>
                    <td class="align-middle">' . $rowSelectLecture['day'] . '</td>
                    <td class="align-middle">' . $rowSelectLecture['time'] . '</td>
                    <td class="align-middle">' . $rowSelectSC['semester'] . '
                    <td class="align-middle">' . $rowSelectSC['campus'] . '</td>
                    <td class="align-middle">' . $rowSelectLecture['location'] . '</td>
                    <td class="align-middle">' . $rowSelectLecture['duration'] . ' hour(s)</td>
                    </tr>';
                //get tutorial id
                $selectTutorialIDQuery = "SELECT tutorial_id FROM assignment_students_timetable WHERE stu_id = '" . $_SESSION['session_user'] . "' AND details_id = '" . $rowSelectEnrolment['details_id'] . "'";
                $selectTutorialIDResult = $mysqli->query($selectTutorialIDQuery);
                if ($selectTutorialIDResult->num_rows > 0) {
                    $rowSelectTutorialID = $selectTutorialIDResult->fetch_assoc();
                    //get tutorial information
                    $selectTutorialQuery = "SELECT * FROM assignment_tutorials WHERE id='" . $rowSelectTutorialID['tutorial_id'] . "'";
                    $selectTutorialResult = $mysqli->query($selectTutorialQuery);
                    $rowSelectTutorial = $selectTutorialResult->fetch_assoc();
                    echo '
                      <tr id="lec' . $rowSelectTutorial['id'] . '">
                      <td class="align-middle">' . $rowSelectDetails['unit_code'] . '</td>
                      <td class="align-middle">' . $rowSelectDetails['unit_name'] . '</td>
                      <td class="align-middle">Tut</td>
                      <td class="align-middle">' . $rowSelectTutorial['day'] . '</td>
                      <td class="align-middle">' . $rowSelectTutorial['time'] . '</td>
                      <td class="align-middle">' . $rowSelectSC['semester'] . '
                      <td class="align-middle">' . $rowSelectSC['campus'] . '</td>
                      <td class="align-middle">' . $rowSelectTutorial['location'] . '</td>
                      <td class="align-middle">' . $rowSelectTutorial['duration'] . ' hour(s)</td>
                      </tr>';
                }
            }
            echo ' </tbody>
            </table>';
        } else {
            echo '<div class="card">
                      <div class="card-body">
                        <p class="card-text">You do not have any enrolments yet.</p>
                      </div>
                  </div>';
        }
        ?>
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