<?php
include('../php/session.php');
include('../php/db_conn.php');
if ($_SESSION['session_user'] != "") {
    if ($_SESSION['session_access'] != '0') {
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
    <link rel="stylesheet" href="../CSS/tutorialAllocation.css">
    <title>Tutorial Allocation - University of DoWell</title>
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
                    <li class='nav-item active'>
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
            <h1 class="display-4 mb-5 text-white">Tutorial Allocation System</h1>
        </div>
    </div>
    <!-- NOTE content -->
    <div class="container">
        <?php
        $selectEnrolmentQuery = "SELECT * FROM assignment_students_enrolments WHERE stu_id = '" . $_SESSION['session_user'] . "'";
        $selectEnrolmentResult = $mysqli->query($selectEnrolmentQuery);
        if ($selectEnrolmentResult->num_rows > 0) {
            //NOTE header
            echo '<div class="nav nav-pills flex-column flex-sm-row mb-2 shadow p-3 mb-5 bg-white rounded" id="pills-tab" role="tablist">';
            $selectEnrolmentRow = $selectEnrolmentResult->fetch_all(MYSQLI_ASSOC);
            for ($i = 0; $i < count($selectEnrolmentRow); $i++) {
                $selectUnitDetailsQuery = "SELECT unit_code, unit_name FROM assignment_units_details WHERE id='" . $selectEnrolmentRow[$i]['details_id'] . "'";
                $selectUnitDetailsResult = $mysqli->query($selectUnitDetailsQuery);
                $selectUnitDetailsRow = $selectUnitDetailsResult->fetch_assoc();

                $outputHeader = '<a class="flex-sm-fill text-sm-center nav-link';
                if ($i == 0) {
                    $outputHeader .= ' active';
                }
                $outputHeader .= '" id="pills-' . $selectUnitDetailsRow['unit_code'] . '-tab" data-toggle="pill" href="#pills-' . $selectUnitDetailsRow['unit_code'] . '" role="tab" aria-controls="pills-' . $selectUnitDetailsRow['unit_code'] . '" aria-selected="true">' . $selectUnitDetailsRow['unit_code'] . '</a>';
                echo $outputHeader;
            }
            echo '</div>';

            //NOTE content
            echo '<div class="tab-content shadow p-3 mb-5 bg-white rounded" id="pills-tabContent">';
            for ($i = 0; $i < count($selectEnrolmentRow); $i++) {
                $selectUnitDetailsQuery = "SELECT unit_code, unit_name FROM assignment_units_details WHERE id='" . $selectEnrolmentRow[$i]['details_id'] . "'";
                $selectUnitDetailsResult = $mysqli->query($selectUnitDetailsQuery);
                $selectUnitDetailsRow = $selectUnitDetailsResult->fetch_assoc();

                $outputContent = '<div class="tab-pane fade';
                if ($i == 0) {
                    $outputContent .= ' show active';
                }
                $outputContent .= '" id="pills-' . $selectUnitDetailsRow['unit_code'] . '" role="tabpanel" aria-labelledby="pills-' . $selectUnitDetailsRow['unit_code'] . '-tab">';


                $selectTutorialsQuery = "SELECT * FROM assignment_tutorials WHERE units_lists_id = '" . $selectEnrolmentRow[$i]['units_lists_id'] . "'";
                $selectTutorialsResult = $mysqli->query($selectTutorialsQuery);
                if ($selectTutorialsResult->num_rows > 0) {
                    $outputContent .= '<h1 class="h3 mb-2 text-center">' . $selectUnitDetailsRow['unit_code'] . ' - ' . $selectUnitDetailsRow['unit_name'] . '</h1>
                    <table class="table table-striped table-bordered table-responsive-md text-nowrap">
                    <thead>
                        <tr>
                            <th scope="col">Allocate</th>
                            <th scope="col">Day</th>
                            <th scope="col">Time</th>
                            <th scope="col">Duration</th>
                            <th scope="col">Location</th>
                            <th scope="col">Capacity</th>
                        </tr>
                    </thead>
                    <tbody>';
                    while ($row = $selectTutorialsResult->fetch_assoc()) {
                        $selectTutorialsCapacityQuery = "SELECT count(id) FROM assignment_students_timetable WHERE tutorial_id='" . $row['id'] . "'";
                        $selectTutorialsCapacityResult = $mysqli->query($selectTutorialsCapacityQuery);
                        $rowCapacity = $selectTutorialsCapacityResult->fetch_array(MYSQLI_NUM);

                        $outputContent .= '<tr id="' . $row['id'] . '">
                        <td scope="row">';
                        //check time table
                        $selectAllocatedQuery = "SELECT * FROM assignment_students_timetable WHERE details_id = '" . $selectEnrolmentRow[$i]['details_id'] . "' AND stu_id = '" . $_SESSION['session_user'] . "' AND tutorial_id = '" . $row['id'] . "'";
                        $selectAllocatedResult = $mysqli->query($selectAllocatedQuery);
                        if ($selectAllocatedResult->num_rows > 0) {
                            $outputContent .= '<button type="button" name="btn' . $row['id'] . '" id="btn' . $row['id'] . '" class="btn btn-success btn-block btn-sm" onclick="withdraw(this, ' . $selectEnrolmentRow[$i]['details_id'] . ')">Allocated</button>';
                        } else {
                            if ((int) $rowCapacity[0] < (int) $row['capacity']) {
                                $outputContent .= '<button type="button" name="btn' . $row['id'] . '" id="btn' . $row['id'] . '" class="btn btn-primary btn-block btn-sm" onclick="allocateTutorial(this,' . $selectEnrolmentRow[$i]['details_id'] . ');">Select</button>';
                            } else if ((int) $rowCapacity[0] = (int) $row['capacity']) {
                                $outputContent .= '<button type="button" name="btn' . $row['id'] . '" id="btn' . $row['id'] . '" class="btn btn-danger btn-block btn-sm" disabled>Full</button>';
                            }
                        }
                        $outputContent .= '</td>
                            <td>' . $row['day'] . '</td>
                            <td>' . $row['time'] . '</td>
                            <td>' . $row['duration'] . ' hr(s)</td>
                            <td>' . $row['location'] . '</td>
                            ';
                        $outputContent .= '<td>' . $rowCapacity[0] . ' / ' . $row['capacity'] . '</td><tr>';
                    }
                    $outputContent .= '</tbody>
                    </table>';
                } else {
                    $outputContent .= '<div class="card">
                    <div class="card-body">
                        <p class="card-text">Do not have record.</p>
                    </div>
                 </div>';
                }
                $outputContent .= '</div>';
                echo $outputContent;
            }
            echo '</div>';
        } else {
            echo ' <div class="card">
            <div class="card-body">
                <h4 class="card-title">You do not have any enrolments yet.</h4>
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
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
    </script>
    <script type="text/javascript" src="../JS/tutorialAllocation.js"></script>
</body>

</html>