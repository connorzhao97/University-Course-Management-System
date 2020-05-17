<?php
include('../php/db_conn.php');
include('../php/session.php');
if ($_SESSION['session_user'] != "") {
    if (!empty($_GET['code'])) {
        $unitDetailQuery = "SELECT * FROM assignment_units_details WHERE unit_code='" . $_GET['code'] . "'";
        $unitDetailResult = $mysqli->query($unitDetailQuery);
        if ($unitDetailResult->num_rows > 0) {
            $_GLOBALS['unit'] = $unitDetailResult->fetch_assoc();
            $unitCoordinatorNameQuery = "SELECT name FROM assignment_staffs WHERE st_id = '" . $_GLOBALS['unit']['unit_coordinator_id'] . "'";
            $unitCoordinatorNameResult = $mysqli->query($unitCoordinatorNameQuery);
            if ($unitCoordinatorNameResult->num_rows > 0) {
                $row = $unitCoordinatorNameResult->fetch_assoc();
                $_GLOBALS['unitCoordinatorName'] = $row['name'];
            }
        } else {
            echo "<script>alert('Do not have record.'); window.location.href='../pages/unitDetail.php'</script>";
        }
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
    <title>Unit Detail - University of DoWell</title>
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
                <li class="nav-item active">
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
            <!-- NOTE different information according to different units -->
            <?php
            if (!empty($_GLOBALS['unit'])) {
                echo '<h1 class="display-4 mb-5 text-white">' . $_GLOBALS['unit']['unit_code'] . '</h1>';
                echo '<p class="display-4  text-white">' . $_GLOBALS['unit']['unit_name'] . '</p>';
            } else {
                echo '<h1 class="display-4 mb-5 text-white">Unit Detail</h1>';
            }

            if ($_SESSION['session_access'] == '0') {
                echo '<a id="enrolment" class="btn btn-danger btn-lg btn-block" href="../pages/unitEnrolment.php" role="button">Enrol units</a>';
            }
            ?>

        </div>
    </div>
    <!-- NOTE  content -->
    <div class="container">

        <?php
        if (!empty($_GLOBALS['unit'])) {
            //unit details
            echo '
            <div>
            <div class="card mb-5 shadow-lg mb-5 bg-white rounded">
                <h5 class="card-header">Description</h5>
                <div class="card-body">
                    <p class="card-text">' . $_GLOBALS['unit']['description'] . '</p>
                </div>
            </div>
            <div class="card mb-5 shadow-lg mb-5 bg-white rounded">
                <h5 class="card-header">Unit coordinator</h5>
                <div class="card-body">
                    <p class="card-text">' . $_GLOBALS['unitCoordinatorName']  . '</p>
                </div>
            </div>
            <div class="card mb-5 shadow-lg mb-5 bg-white rounded">
                <h5 class="card-header">Available campus and semester</h5>
                <div class="card-body">
                    <table class="table table-striped table-bordered">
                        <tbody>
                            <tr>
                                <th scope="col">Semester</th>
                                <td>' . $_GLOBALS['unit']['semester'] . '</td>
                            </tr>
                            <tr>
                                <th scope="col">Campus</th>
                                <td>' . $_GLOBALS['unit']['campus'] . '</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
            ';
        } else {
            //unit lists
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
            $query = "SELECT unit_code, unit_name FROM assignment_units_details ORDER BY unit_code ASC";
            $result = $mysqli->query($query);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    foreach ($row as $key => $value) {
                        echo "<td>$value</td>";
                    }
                    echo '<td class="d-flex justify-content-center"><a name="' . $row['unit_code'] . '" id="' . $row['unit_code'] . '" class="btn btn-primary" href="../pages/unitDetail.php?code=' . $row['unit_code'] . '" role="button">View Details</a></td>';
                    echo "</tr>";
                }
            }
            echo '
            </tbody>
            </table>
        </div>
            ';
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
</body>

</html>