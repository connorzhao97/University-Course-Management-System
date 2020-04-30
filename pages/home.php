<?php
include('../php/session.php');
include('../php/db_conn.php');
if ($_SESSION['session_user'] != "") {
    // header("Location:../pages/home.php");
} else {
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
    <link rel="stylesheet" href="../CSS/home.css">
    <title>Home - University of DoWell</title>
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
                    <a class="nav-link" href="../pages/unitDetail.html">Unit Detail</a>
                </li>
                <?php
                if ($_SESSION['session_access'] == "0") {
                    echo "
                    <li class='nav-item'>
                    <a class='nav-link' href='../pages/unitEnrolment.html'>Unit Enrolment</a>
                    </li>
                    ";
                }
                ?>
                <?php
                if ($_SESSION['session_access'] == "0") {
                    echo "
                    <li class='nav-item'>
                    <a class='nav-link' href='../pages/individualTimetable.html'>Individual Timetable</a>
                    </li>
                    ";
                }
                ?>
                <?php
                if ($_SESSION['session_access'] == "0") {
                    echo "
                    <li class='nav-item'>
                    <a class='nav-link' href='../pages/tutorialAllocation.html'>Tutorial Allocation</a>
                    </li>
                    ";
                }
                ?>

                <?php
                if ($_SESSION['session_access'] == "4") {
                    echo "
                    <li class='nav-item'>
                    <a class='nav-link' href='../pages/masterList.html'>Master List</a>
                    </li>
                    ";
                }
                ?>

                <?php
                if ($_SESSION['session_access'] == "4" || $_SESSION['session_access'] == "3") {
                    echo "
                    <li class='nav-item'>
                    <a class='nav-link' href='../pages/unitManagement.html'>Unit Management</a>
                    </li>
                    ";
                }
                ?>

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
    <!-- NOTE content -->
    <div class="container">
        <div class="row">
            <!-- NOTE left content -->
            <div class="col-md-6">
                <div class="column shadow-lg p-3 mb-5 bg-white rounded mt-5">
                    <h1 class="h3">My units</h1>
                    <hr class="mb-3">
                    <div class="row row-cols-1 row-cols-lg-2">
                        <div class="col mb-4">
                            <div class="card h-100">
                                <!-- NOTE  img could be differnet because of different units. -->
                                <img src="../imgs/502.jpg" class="card-img-top">
                                <!-- NOTE link to different units e.g. ../pages/unitDetail.html?kit502 -->
                                <a class="unitLink" href="../pages/unitDetail.html"></a>
                                <div class="card-body">
                                    <!-- NOTE different information according to different units -->
                                    <h5 class="card-title">KIT502 Web Development</h5>
                                    <p class="card-text text-muted">2020 Sem1</p>
                                    <p class="card-text text-muted">Ends July 31,2020 at 00:00</p>
                                </div>
                            </div>
                        </div>
                        <div class="col mb-4">
                            <div class="card h-100">
                                <img src="../imgs/503.jpg" class="card-img-top">
                                <a class="unitLink" href="../pages/unitDetail.html"></a>
                                <div class="card-body">
                                    <h5 class="card-title">KIT503 ICT Professional Practices and Project Management</h5>
                                    <p class="card-text text-muted">2020 Sem1</p>
                                    <p class="card-text text-muted">Ends July 31,2020 at 00:00</p>
                                </div>
                            </div>
                        </div>
                        <div class="col mb-4">
                            <div class="card h-100">
                                <img src="../imgs/707.jpg" class="card-img-top">
                                <a class="unitLink" href="../pages/unitDetail.html"></a>
                                <div class="card-body">
                                    <h5 class="card-title">KIT707 Knowledge and Information Management</h5>
                                    <p class="card-text text-muted">2020 Sem1</p>
                                    <p class="card-text text-muted">Ends July 31,2020 at 00:00</p>
                                </div>
                            </div>
                        </div>
                        <div class="col mb-4">
                            <div class="card h-100">
                                <img src="../imgs/710.jpg" class="card-img-top">
                                <a class="unitLink" href="../pages/unitDetail.html"></a>
                                <div class="card-body">
                                    <h5 class="card-title">KIT710 eLogistics</h5>
                                    <p class="card-text text-muted">2020 Sem1</p>
                                    <p class="card-text text-muted">Ends July 31,2020 at 00:00</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- NOTE right content -->
            <div class="col-md-6 mt-5">
                <div class="column">
                    <div class="shadow-lg p-3 mb-5 bg-white rounded">
                        <h1 class="h3">My Timetable</h1>
                        <hr class="mb-3">
                        <div class="d-flex justify-content-center">
                            <a name="" id="" class="btn btn-primary" href="../pages/individualTimetable.html" role="button">View My Timetable</a></div>
                    </div>
                    <div class="shadow-lg p-3 mb-5 bg-white rounded">
                        <h1 class="h3">Unit Enrolment</h1>
                        <hr class="mb-3">
                        <div class="d-flex justify-content-center">
                            <a name="" id="" class="btn btn-primary" href="../pages/unitEnrolment.html" role="button">View My Enrolment</a></div>
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