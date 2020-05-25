<?php
include('../php/db_conn.php');
include('../php/session.php');
if ($_SESSION['session_user'] != "") {
    $userProfileQuery = "SELECT * FROM assignment_users WHERE st_id = '" . $_SESSION['session_user'] . "'";
    $userProfileResult = $mysqli->query($userProfileQuery);
    $rowUserProfile = $userProfileResult->fetch_assoc();
    if ($rowUserProfile['access'] == "0") {
        $stProfileQuery = "SELECT * FROM assignment_students WHERE st_id='" . $rowUserProfile['st_id'] . "'";
    } else {
        $stProfileQuery = "SELECT * FROM assignment_staffs WHERE st_id='" . $rowUserProfile['st_id'] . "'";
    }
    $stProfileResult = $mysqli->query($stProfileQuery);
    $rowStProfile = $stProfileResult->fetch_assoc();
    $GLOBALS['user'] = $rowStProfile;
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
    <link rel="stylesheet" href="../CSS/userAccount.css">
    <title>User Account - University of DoWell</title>
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
             
                if ($_SESSION['session_access'] == "0") {
                    echo "
                    <li class='nav-item'>
                    <a class='nav-link' href='../pages/individualTimetable.php'>Individual Timetable</a>
                    </li>
                    ";
                }
               
                if ($_SESSION['session_access'] == "0") {
                    echo "
                    <li class='nav-item'>
                    <a class='nav-link' href='../pages/tutorialAllocation.php'>Tutorial Allocation</a>
                    </li>
                    ";
                }
             
                if ($_SESSION['session_access'] == "5") {
                    echo "
                    <li class='nav-item'>
                    <a class='nav-link' href='../pages/masterList.php'>Master List</a>
                    </li>
                    ";
                }
               
                if ($_SESSION['session_access'] == "5" || $_SESSION['session_access'] == "4") {
                    echo "
                    <li class='nav-item'>
                    <a class='nav-link' href='../pages/unitManagement.php'>Unit Management</a>
                    </li>
                    ";
                }
                
                if ($_SESSION['session_access'] == "5" || $_SESSION['session_access'] == "4" || $_SESSION['session_access'] == "3" || $_SESSION['session_access'] == "2") {
                    echo "
                    <li class='nav-item'>
                    <a class='nav-link' href='../pages/enrolledDetails.php'>Enrolled Student Details</a>
                    </li>
                    ";
                }
                ?>
                <li class='nav-item'>
                    <a class='nav-link active' href='../pages/userAccount.php'>User Account</a>
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
    <!-- NOTE jumbotron -->
    <div class="jumbotron jumbotron-fluid img-fluid text-center bg">
        <div class="container h-100">
            <h1 class="display-4 mb-5 text-white">Edit My User Profile</h1>
        </div>
    </div>
    <!-- NOTE content -->
    <div class="container">
        <div class="shadow p-3 mb-5 bg-white rounded">
            <?php
            if ($_SESSION['session_access'] == "0") {
                $output = "
                <form onsubmit='return stuFormSubmit();'>
                <h4 class='mb-3'>Edit Information</h4>
                <div class='form-group'>
                    <label for='stuName'>Name</label>
                    <input type='text' class='form-control' name='stuName' id='stuName' value='" . $GLOBALS['user']['name'] . "' placeholder='Your Name' required>
                </div>
                <div class='form-group'>
                    <label for='stuID'>Student ID</label>
                    <input type='text' class='form-control' name='stuID' id='stuID' value='" . $GLOBALS['user']['st_id'] . "' readonly>
                </div>
                <div class='form-group'>
                    <label for='stuEmail'>Email Address</label>
                    <input type='text' class='form-control' name='stuEmail' id='stuEmail' value='" . $GLOBALS['user']['email'] . "' placeholder='Your Email Address' pattern='^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$' required>
                </div>
                <div class='form-group'>
                    <label for='stuPassword'>Change Password</label>
                    <input type='password' id='stuPassword' name='stuPassword' class='form-control' placeholder='Your password' aria-describedby='passwordHelpId' pattern='(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^]).{6,12}'>
                    <small id='passWordHelpId' class='text-muted'>Your password must be 6-12 characters
                        long, contain at least 1 lowercase letter,1 uppercase letter,1 number and one of
                        following special characters ! @ # $ % ^</small>
                </div>
                <div class='form-group'>
                    <label for='stuRePassword'>Re-enter Password</label>
                    <input type='password' id='stuRePassword' name='stuRePassword' class='form-control' placeholder='Re-enter your password'>
                </div>
                <div class='form-group'>
                    <label for='stuAddress'>Address<span class='text-muted'>(Optional)</span></label>
                    <input type='text' id='stuAddress' name='stuAddress' class='form-control' value='" . $GLOBALS['user']['address'] . "' placeholder='Your address'>
                </div>
                <div class='form-group'>
                    <label for='stuBirth'>Date of Birth<span class='text-muted'>(Optional)</span></label>
                    <input type='date' id='stuBirth' name='stuBirth' class='form-control' value='" . $GLOBALS['user']['birth'] . "' placeholder='DD/MM/YYYY' pattern='^([0-2][0-9]|(3)[0-1])(\/)(((0)[0-9])|((1)[0-2]))(\/)\d{4}$'>
               </div>
               <div class='form-group'>
               <label for='stuPhoneNumber'>Phone Number<span class='text-muted'>(Optional)</span></label>
                    <input type='tel' id='stuPhoneNumber' name='stuPhoneNumber' class='form-control' placeholder='e.g.(+61)/(0)xxxxxxxxx' value='" . $GLOBALS['user']['phone'] . "' pattern='^(?:\+?61|0)4 ?(?:(?:[01] ?[0-9]|2 ?[0-57-9]|3 ?[1-9]|4 ?[7-9]|5 ?[018]) ?[0-9]|3 ?0 ?[0-5])(?: ?[0-9]){5}$'>
                </div>
                ";
            } else {
                $output = "
                <form onsubmit='return staFormSubmit();'>
                <h4 class='mb-3'>Edit Information</h4>
                <div class='form-group'>
                    <label for='staName'>Name</label>
                    <input type='text' class='form-control' name='staName' id='staName' value='" . $GLOBALS['user']['name'] . "' placeholder='Your Name' required>
                </div>
                <div class='form-group'>
                    <label for='staID'>Staff ID</label>
                    <input type='text' class='form-control' name='staID' id='staID' value='" . $GLOBALS['user']['st_id'] . "' readonly>
                </div>
                <div class='form-group'>
                    <label for='staEmail'>Email Address</label>
                    <input type='text' class='form-control' name='staEmail' id='staEmail' value='" . $GLOBALS['user']['email'] . "' placeholder='Your Email Address' pattern='^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$' required>
                </div>
                <div class='form-group'>
                    <label for='staPassword'>Change Password</label>
                    <input type='password' id='staPassword' name='staPassword' class='form-control' placeholder='Your password' aria-describedby='passwordHelpId' pattern='(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^]).{6,12}'>
                    <small id='passWordHelpId' class='text-muted'>Your password must be 6-12 characters
                        long, contain at least 1 lowercase letter,1 uppercase letter,1 number and one of
                        following special characters ! @ # $ % ^</small>
                </div>
                <div class='form-group'>
                    <label for='staRePassword'>Re-enter Password</label>
                    <input type='password' id='staRePassword' name='staRePassword' class='form-control' placeholder='Re-enter your password'>
                </div>
                <div class='row'>
                    <div class='form-group col-md-6'>
                    <label for='qualification'>Qualification</label>
                    <select class='custom-select' id='staQualification' name='staQualification' required>
                        <option value=''>Select Qualification</option>
                ";
                if ($GLOBALS['user']['qualification'] == 'Bachelor') {
                    $output .= "
                        <option value='Bachelor' selected>Bachelor</option>
                        <option value='Master'>Master</option>
                        <option value='PhD'>PhD</option>
                        </select>
                    </div>
                    ";
                } else if ($GLOBALS['user']['qualification'] == 'PhD') {
                    $output .= "
                        <option value='Bachelor'>Bachelor</option>
                        <option value='Master'>Master</option>
                        <option value='PhD' selected>PhD</option>
                        </select>
                    </div>
                        ";
                } else if ($GLOBALS['user']['qualification'] == 'Master') {
                    $output .= "
                        <option value='Bachelor'>Bachelor</option>
                        <option value='Master' selected>Master</option>
                        <option value='PhD'>PhD</option>
                        </select>
                    </div>
                        ";
                }
                $output .= "
                <div class='form-group col-md-6'>
                    <label for='staExpertise'>Expertise</label>
                    <input type='text' id='staExpertise' name='staExpertise' class='form-control' value='" . $GLOBALS['user']['expertise'] . "' placeholder='e.g. Information Systems' required>
                </div>
                </div>
                ";
                $output .= "
                <div class='form-group'>
                 <label for='staPhoneNumber'>Phone Number</label>
                    <input type='tel' id='staPhoneNumber' name='staPhoneNumber' class='form-control' placeholder='e.g.(+61)/(0)xxxxxxxxx' value='" . $GLOBALS['user']['phone'] . "' pattern='^(?:\+?61|0)4 ?(?:(?:[01] ?[0-9]|2 ?[0-57-9]|3 ?[1-9]|4 ?[7-9]|5 ?[018]) ?[0-9]|3 ?0 ?[0-5])(?: ?[0-9]){5}$' required>
                </div>
                <div class='form-group'>
                 <label for='staUnavailability'>Unavailability<span class='text-muted'>(Optional)</span></label>
                    <input type='text' id='staUnavailability' name='staUnavailability' class='form-control' value='" . $GLOBALS['user']['unavailability'] . "' placeholder='Your Unavailability Date or Time'>
                </div>
                ";
            }
            echo $output;
            ?>
            <hr class="mb-4">
            <button type="submit" id="submitBtn" class="btn btn-success btn-lg btn-block mb-5 d-flex align-items-center justify-content-center">
                <span id="stSpinner" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                Save changes</button>
            </form>
        </div>
        <?php
        //student timetable
        if ($_SESSION['session_access'] == "0") {
            $selectEnrolmentQuery = "SELECT * FROM assignment_students_enrolments WHERE stu_id= '" . $_SESSION['session_user'] . "'";
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

                    //get tutorial information
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
            }
        } else {
            //staff timetable
            if ($_SESSION['session_access'] != '5') {
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
            }
            if ($_SESSION['session_access'] == '4' || $_SESSION['session_access'] == '3') {
                $selectLectureQuery = "SELECT * FROM assignment_lectures WHERE sta_id= '" . $_SESSION['session_user'] . "' ORDER BY details_id";
                $selectLectureResult = $mysqli->query($selectLectureQuery);

                if ($selectLectureResult->num_rows > 0) {
                    while ($rowSelectLecture = $selectLectureResult->fetch_assoc()) {
                        //get unit details
                        $selectDetailsQuery = "SELECT unit_code, unit_name FROM assignment_units_details WHERE id='" . $rowSelectLecture['details_id'] . "'";
                        $selectDetailsResult = $mysqli->query($selectDetailsQuery);
                        $rowSelectDetails = $selectDetailsResult->fetch_assoc();
                        //get semester and campus
                        $selectSCQuery = "SELECT semester, campus FROM assignment_units_lists WHERE id='" . $rowSelectLecture['units_lists_id'] . "'";
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
                    }
                }
            }
            $selectTutorialQuery = "SELECT * FROM assignment_tutorials WHERE sta_id= '" . $_SESSION['session_user'] . "' ORDER BY details_id";
            $selectTutorialResult = $mysqli->query($selectTutorialQuery);
            if ($selectTutorialResult->num_rows > 0) {
                while ($rowSelectTutorial = $selectTutorialResult->fetch_assoc()) {
                    //get unit details
                    $selectDetailsQuery = "SELECT unit_code, unit_name FROM assignment_units_details WHERE id='" . $rowSelectTutorial['details_id'] . "'";
                    $selectDetailsResult = $mysqli->query($selectDetailsQuery);
                    $rowSelectDetails = $selectDetailsResult->fetch_assoc();
                    //get semester and campus
                    $selectSCQuery = "SELECT semester, campus FROM assignment_units_lists WHERE id='" . $rowSelectTutorial['units_lists_id'] . "'";
                    $selectSCResult = $mysqli->query($selectSCQuery);
                    $rowSelectSC = $selectSCResult->fetch_assoc();

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
        }
        ?>
    </div>
    <!-- NOTE footer -->
    <footer class=" footer mt-auto py-3 bg-dark">
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
    <script type="text/javascript" src="../JS/userAccount.js"></script>
</body>

</html>