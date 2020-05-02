<?php
include("../php/db_conn.php");
include("../php/session.php");
// if ($_SESSION['session_user'] != "") {
//     if ($_SESSION['session_access'] != '4') {
//         echo "<script>alert('You do not have access to this page'); window.location.href='../pages/home.php'</script>";
//     }
// } else {
//     echo "<script>alert('Login is required'); window.location.href='../pages/login.php'</script>";
// }
?>
<!doctype html>
<html lang="en" class="h-100">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="../CSS/unitenrolment.css">
    <title>Unit Enrolment - University of DoWell</title>
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
                if ($_SESSION['session_access'] == "4") {
                    echo "
                    <li class='nav-item'>
                    <a class='nav-link' href='../pages/masterList.php'>Master List</a>
                    </li>
                    ";
                }
                ?>

                <?php
                if ($_SESSION['session_access'] == "4" || $_SESSION['session_access'] == "3") {
                    echo "
                    <li class='nav-item'>
                    <a class='nav-link' href='../pages/unitManagement.php'>Unit Management</a>
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
    <!-- NOTE jumbotron -->
    <div>
        <div class="jumbotron jumbotron-fluid img-fluid text-center bg ">
            <div class="container h-100">
                <h1 class="display-4 mb-5 text-white">Unit Enrolment</h1>
            </div>
        </div>
    </div>
    <!-- NOTE  content -->
    <div class="container">
        <!-- NOTE method="POST"  -->
        <form name="enrolForm" id="enrolForm" method="" class="needs-validation shadow-lg p-3 mb-5 bg-white rounded" onsubmit="return enrolFormSubmit(this)" novalidate>
            <div class="card">
                <div class="card-header">
                    Avaliable units
                </div>
                <?php
                $availableUnitsQuery = "SELECT id, unit_code, unit_name FROM assignment_units_details ORDER BY unit_code";
                $availableUnitsResult = $mysqli->query($availableUnitsQuery);

                if ($availableUnitsResult->num_rows > 0) {
                    while ($row = $availableUnitsResult->fetch_assoc()) {
                        // echo print_r($row);
                        $unitListQuery = "SELECT * FROM assignment_units_lists WHERE details_id = '" . $row['id'] . "'";
                        $unitListResult = $mysqli->query($unitListQuery);
                        $rowList = $unitListResult->fetch_all(MYSQLI_ASSOC);
                        // echo print_r($rowList);
                        $output = "
                        <div class='card' id=" . $row["id"] . ">
                            <div class='row'>
                                <div class='col-md-8'>
                                    <div class='card-body'>
                                        <h5 class='card-title'>" . $row['unit_code'] . " - " . $row['unit_name'] . " </h5>
                                        <select name='" . $row['unit_code'] . "EnrolTime' id='" . $row['unit_code'] . "EnrolTime' class='custom-select'>
                                            <option value='' selected>Please select</option>";
                        for ($i = 0; $i < count($rowList); $i++) {
                            $output .= "
                            <option value='" . $rowList[$i]['semester'] . ", " . $rowList[$i]['campus'] . "'>" . $rowList[$i]['semester'] . ", " . $rowList[$i]['campus'] . "</option>
                            ";
                        }
                        $output .= "
                                        </select>
                                    </div>
                                </div>
                                <div class='col-md-4 d-flex justify-content-center align-self-center'>
                                    <div class='form-check'>
                                        <input class='form-check-input' type='checkbox' value='checked' name='" . $row['unit_code'] . "EnrolCheck' id='" . $row['unit_code'] . "EnrolCheck'>
                                        <label class='form-check-label' for='" . $row['unit_code'] . "EnrolCheck'>
                                            Enrol
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>";
                        echo $output;
                    }
                }
                ?>
                <!-- <div class="card">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title">".$row['unit_code']." - Web Development </h5>
                                <select name="".$row['unit_code']."EnrolTime" id="".$row['unit_code']."EnrolTime" class="custom-select">
                                    <option value="" selected>Please select</option>
                                    <option value="Semester1, Pandora">Semester1, Pandora</option>
                                    <option value="Winter School, Rivendell">Winter School, Rivendell</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 d-flex justify-content-center align-self-center">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="checked" name="".$row['unit_code']."EnrolCheck" id="".$row['unit_code']."EnrolCheck">
                                <label class="form-check-label" for="".$row['unit_code']."EnrolCheck">
                                    Enrol
                                </label>
                            </div>
                        </div>
                    </div>
                </div> -->
            </div>
            <hr class="mb-4">
            <button type="submit" class="btn btn-primary btn-lg btn-block mb-5">Enrol checked units</button>
        </form>
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
    <script type="text/javascript" src="../JS/unitEnrolment.js"></script>
</body>

</html>