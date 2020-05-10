<?php
include('../php/db_conn.php');
include('../php/session.php');
if ($_SESSION['session_user'] != "") {
    //   header("Location:../pages/home.php");
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
                    <a class='nav-link active' href='../pages/userAccount.php'>User Account</a>
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
                        <option value='PhD'>PhD</option>
                        <option value='Master'>Master</option>
                        </select>
                    </div>
                    ";
                } else if ($GLOBALS['user']['qualification'] == 'PhD') {
                    $output .= "
                        <option value='Bachelor'>Bachelor</option>
                        <option value='PhD' selected>PhD</option>
                        <option value='Master'>Master</option>
                        </select>
                    </div>
                        ";
                } else if ($GLOBALS['user']['qualification'] == 'Master') {
                    $output .= "
                        <option value='Bachelor'>Bachelor</option>
                        <option value='PhD'>PhD</option>
                        <option value='Master' selected>Master</option>
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
                    <input type='text' id='staUnavailability' name='staUnavailability' class='form-control' value='".$GLOBALS['user']['unavailability']."' placeholder='Your Unavailability Date or Time'>
                </div>
                ";
            }
            echo $output;
            ?>
            <hr class="mb-4">
            <button type="submit" id="submitBtn" class="btn btn-primary btn-lg btn-block mb-5 d-flex align-items-center justify-content-center">
                <span id="stSpinner" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                Save changes</button>
            </form>
        </div>
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
    <script src="https://code.jquery.com/jquery-3.5.0.min.js" integrity="sha256-xNzN2a4ltkB44Mc/Jz3pT4iU1cmeR0FkXs4pru/JxaQ=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
    </script>
    <script type="text/javascript" src="../JS/userAccount.js"></script>
</body>

</html>