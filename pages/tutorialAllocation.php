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
        <div class="nav nav-pills flex-column flex-sm-row mb-2 shadow p-3 mb-5 bg-white rounded" id="pills-tab" role="tablist">
            <a class="flex-sm-fill text-sm-center nav-link active" id="pills-first-tab" data-toggle="pill" href="#pills-first" role="tab" aria-controls="pills-first" aria-selected="true">KIT502</a>
            <a class="flex-sm-fill text-sm-center nav-link" id="pills-second-tab" data-toggle="pill" href="#pills-second" role="tab" aria-controls="pills-second" aria-selected="false">KIT503</a>
            <a class="flex-sm-fill text-sm-center nav-link" id="pills-third-tab" data-toggle="pill" href="#pills-third" role="tab" aria-controls="pills-third" aria-selected="false">KIT707</a>
            <a class="flex-sm-fill text-sm-center nav-link" id="pills-forth-tab" data-toggle="pill" href="#pills-forth" role="tab" aria-controls="pills-forth" aria-selected="false">KIT710</a>
        </div>
        <div class="tab-content shadow p-3 mb-5 bg-white rounded" id="pills-tabContent">
            <!-- NOTE unit panel -->
            <div class="tab-pane fade show active" id="pills-first" role="tabpanel" aria-labelledby="pills-first-tab">
                <h1 class="h3 mb-2 text-center">KIT502 - Web Development</h1>
                <table class="table table-striped table-bordered table-responsive-md text-nowrap">
                    <thead>
                        <tr>
                            <th scope="col">Allocate</th>
                            <th scope="col">Day</th>
                            <th scope="col">Time</th>
                            <th scope="col">Location</th>
                            <th scope="col">Capacity</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td scope="row">
                                <!-- NOTE if user is not logged in, button hidden -->
                                <button type="button" name="" id="" class="btn btn-success btn-block btn-sm">Allocated</button>
                            </td>
                            <td>Monday</td>
                            <td>09:00 - 10:50</td>
                            <td>P.AR15L02278</td>
                            <td>15</td>
                        </tr>
                        <tr>
                            <td scope="row">
                                <!-- NOTE if user is not logged in, button hidden -->
                                <button type="button" name="" id="" class="btn btn-primary btn-block btn-sm">Select</button>
                            </td>
                            <td>Tuesday</td>
                            <td>11:00 - 12:50</td>
                            <td>P.AR15L02278</td>
                            <td>15</td>
                        </tr>
                        <tr>
                            <td scope="row">
                                <!-- NOTE if user is not logged in, button hidden -->
                                <button type="button" name="" id="" class="btn btn-primary btn-block btn-sm">Select</button>
                            </td>
                            <td>Tuesday</td>
                            <td>13:00 - 14:50</td>
                            <td>P.AR15L02278</td>
                            <td>15</td>
                        </tr>
                        <tr>
                            <td scope="row">
                                <!-- NOTE if user is not logged in, button hidden -->
                                <button type="button" name="" id="" class="btn btn-danger btn-block btn-sm" disabled>Full</button>
                            </td>
                            <td>Tuesday</td>
                            <td>09:00 - 10:50</td>
                            <td>P.AR15L02278</td>
                            <td>15</td>
                        </tr>
                        <tr>
                            <td scope="row">
                                <!-- NOTE if user is not logged in, button hidden -->

                                <button type="button" name="" id="" class="btn btn-primary btn-block btn-sm">Select</button>
                            </td>
                            <td>Monday</td>
                            <td>09:00 - 10:50</td>
                            <td>P.AR15L02278</td>
                            <td>20</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- NOTE unit panel -->
            <div class="tab-pane fade" id="pills-second" role="tabpanel" aria-labelledby="pills-second-tab">
                <div class="tab-pane fade show active" id="pills-second" role="tabpanel" aria-labelledby="pills-second-tab">
                    <h1 class="h3 mb-2 text-center">KIT503 - ICT Professional Practices and Project Management</h1>
                    <table class="table table-striped table-bordered table-responsive-md text-nowrap">
                        <thead>
                            <tr>
                                <th scope="col">Allocate</th>
                                <th scope="col">Day</th>
                                <th scope="col">Time</th>
                                <th scope="col">Location</th>
                                <th scope="col">Capacity</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td scope="row">
                                    <button type="button" name="" id="" class="btn btn-primary btn-block btn-sm">Select</button>
                                </td>
                                <td>Monday</td>
                                <td>09:00 - 10:50</td>
                                <td>P.AR15L02272</td>
                                <td>15</td>
                            </tr>
                            <tr>
                                <td scope="row">
                                    <button type="button" name="" id="" class="btn btn-primary btn-block btn-sm">Select</button>
                                </td>
                                <td>Tuesday</td>
                                <td>11:00 - 12:50</td>
                                <td>P.AR15L02272</td>
                                <td>15</td>
                            </tr>
                            <tr>
                                <td scope="row">
                                    <button type="button" name="" id="" class="btn btn-primary btn-block btn-sm">Select</button>
                                </td>
                                <td>Tuesday</td>
                                <td>13:00 - 14:50</td>
                                <td>P.AR15L02272</td>
                                <td>15</td>
                            </tr>
                            <tr>
                                <td scope="row">
                                    <button type="button" name="" id="" class="btn btn-danger btn-block btn-sm" disabled>Full</button>
                                </td>
                                <td>Tuesday</td>
                                <td>09:00 - 10:50</td>
                                <td>P.AR15L02272</td>
                                <td>15</td>
                            </tr>
                            <tr>
                                <td scope="row">
                                    <button type="button" name="" id="" class="btn btn-success btn-block btn-sm">Allocated</button>
                                </td>
                                <td>Monday</td>
                                <td>09:00 - 10:50</td>
                                <td>P.AR15L02272</td>
                                <td>20</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- NOTE unit panel -->
            <div class="tab-pane fade" id="pills-third" role="tabpanel" aria-labelledby="pills-third-tab">
                <div class="tab-pane fade show active" id="pills-third" role="tabpanel" aria-labelledby="pills-third-tab">
                    <h1 class="h3 mb-2 text-center">KIT707 - Knowledge and Information Management</h1>
                    <table class="table table-striped table-bordered table-responsive-md text-nowrap">
                        <thead>
                            <tr>
                                <th scope="col">Allocate</th>
                                <th scope="col">Day</th>
                                <th scope="col">Time</th>
                                <th scope="col">Location</th>
                                <th scope="col">Capacity</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td scope="row">
                                    <button type="button" name="" id="" class="btn btn-primary btn-block btn-sm">Select</button>
                                </td>
                                <td>Monday</td>
                                <td>09:00 - 10:50</td>
                                <td>P.AP16L03304</td>
                                <td>15</td>
                            </tr>
                            <tr>
                                <td scope="row">
                                    <button type="button" name="" id="" class="btn btn-primary btn-block btn-sm">Select</button>
                                </td>
                                <td>Tuesday</td>
                                <td>11:00 - 12:50</td>
                                <td>P.AP16L03304</td>
                                <td>15</td>
                            </tr>
                            <tr>
                                <td scope="row">
                                    <button type="button" name="" id="" class="btn btn-success btn-block btn-sm">Allocated</button>
                                </td>
                                <td>Tuesday</td>
                                <td>13:00 - 14:50</td>
                                <td>P.AP16L03304</td>
                                <td>15</td>
                            </tr>
                            <tr>
                                <td scope="row">
                                    <button type="button" name="" id="" class="btn btn-danger btn-block btn-sm" disabled>Full</button>
                                </td>
                                <td>Tuesday</td>
                                <td>09:00 - 10:50</td>
                                <td>P.AP16L03304</td>
                                <td>15</td>
                            </tr>
                            <tr>
                                <td scope="row">
                                    <button type="button" name="" id="" class="btn btn-primary btn-block btn-sm">Select</button>

                                </td>
                                <td>Monday</td>
                                <td>09:00 - 10:50</td>
                                <td>P.AP16L03304</td>
                                <td>20</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- NOTE unit panel -->
            <div class="tab-pane fade" id="pills-forth" role="tabpanel" aria-labelledby="pills-forth-tab">
                <div class="tab-pane fade show active" id="pills-forth" role="tabpanel" aria-labelledby="pills-forth-tab">
                    <h1 class="h3 mb-2 text-center">KIT710 - eLogistics</h1>
                    <table class="table table-striped table-bordered table-responsive-md text-nowrap">
                        <thead>
                            <tr>
                                <th scope="col">Allocate</th>
                                <th scope="col">Day</th>
                                <th scope="col">Time</th>
                                <th scope="col">Location</th>
                                <th scope="col">Capacity</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td scope="row">
                                    <button type="button" name="" id="" class="btn btn-primary btn-block btn-sm">Select</button>
                                </td>
                                <td>Monday</td>
                                <td>09:00 - 10:50</td>
                                <td>P.AX17L03312</td>
                                <td>15</td>
                            </tr>
                            <tr>
                                <td scope="row">
                                    <button type="button" name="" id="" class="btn btn-success btn-block btn-sm">Allocated</button>
                                </td>
                                <td>Tuesday</td>
                                <td>11:00 - 12:50</td>
                                <td>P.AX17L03312</td>
                                <td>15</td>
                            </tr>
                            <tr>
                                <td scope="row">
                                    <button type="button" name="" id="" class="btn btn-primary btn-block btn-sm">Select</button>
                                </td>
                                <td>Tuesday</td>
                                <td>13:00 - 14:50</td>
                                <td>P.AX17L03312</td>
                                <td>15</td>
                            </tr>
                            <tr>
                                <td scope="row">
                                    <button type="button" name="" id="" class="btn btn-danger btn-block btn-sm" disabled>Full</button>
                                </td>
                                <td>Tuesday</td>
                                <td>09:00 - 10:50</td>
                                <td>P.AX17L03312</td>
                                <td>15</td>
                            </tr>
                            <tr>
                                <td scope="row">
                                    <button type="button" name="" id="" class="btn btn-primary btn-block btn-sm">Select</button>
                                </td>
                                <td>Monday</td>
                                <td>09:00 - 10:50</td>
                                <td>P.AX17L03312</td>
                                <td>20</td>
                            </tr>
                        </tbody>
                    </table>
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
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
    </script>
</body>

</html>