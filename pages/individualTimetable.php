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
                    echo "<a class='btn btn-success' href='../php/session_out.php' role='button'>Logout</a>";
                } else {
                    echo "<a class='btn btn-success' href='../pages/login.php' role='button'>Login / Register</a>";
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
                <a id="enrolment" class="btn btn-info btn-lg col-md-4" href="../pages/unitEnrolment.html" role="button">Manage enrolled units</a>
                <a id="allocation" class="btn btn-warning btn-lg col-md-4" href="../pages/tutorialAllocation.html" role="button">Tutorial allocation system</a>
            </div>
        </div>
    </div>
    <!-- NOTE content -->
    <div class="container">
        <nav aria-label="Page navigation timetable">
            <ul class="pagination d-flex justify-content-between">
                <li class="page-item">
                    <a class="page-link" href="#" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                <span class="timeRanges h3">13/04/2020 - 19/04/2020</span>
                <li class="page-item">
                    <a class="page-link" href="#" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
        <table class="table table-striped table-bordered shadow-lg p-3 mb-5 bg-white rounded">
            <thead>
                <tr>
                    <th scope="col">Unit Code</th>
                    <th scope="col">Unit Name</th>
                    <th scope="col">Lecture Time</th>
                    <th scope="col">Tutorial Time</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td scope="row">KIT502</td>
                    <td>Web Development</td>
                    <td>Wednesday 09:00 - 10:50</td>
                    <td>Tuesday 09:00 - 10:50</td>
                </tr>
                <tr>
                    <td scope="row">KIT503</td>
                    <td>ICT Professional Practices and Project Management</td>
                    <td>Wednesday 16:00 - 16:50</td>
                    <td>Tuesday 13:00 - 14:50</td>
                </tr>
                <tr>
                    <td scope="row">KIT707</td>
                    <td>Knowledge and Information Management</td>
                    <td>Friday 13:00 - 14:50</td>
                    <td>Wednesday 15:00 - 16:50</td>
                </tr>
                <tr>
                    <td scope="row">KIT710</td>
                    <td>eLogistics</td>
                    <td>Friday 10:00 - 11:50</td>
                    <td>Tuesday 16:00 - 16:50</td>
                </tr>
            </tbody>
        </table>
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