<?php
include('../php/session.php');
include('../php/db_conn.php');
?>
<!doctype html>
<html lang="en" class="h-100">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="../CSS/registration.css">
    <title>Registration - University of DoWell</title>
</head>

<body class="d-flex flex-column h-100">
    <!-- NOTE navbar -->
    <nav class="navbar navbar-expand-md navbar-dark bg-dark sticky-top">
        <a class="navbar-brand p-0" href="../pages/home.php">
            <img src="../imgs/logo.png" width="100" height="44">
        </a>
    </nav>
    <!-- NOTE jumbotron -->
    <div class="jumbotron jumbotron-fluid img-fluid text-center bg">
        <div class="container h-100">
            <h1 class="display-4 mb-5 text-white">Registration</h1>
            <p class="lead text-white">Registrer to use Course Management System</p>
        </div>
    </div>
    <!-- NOTE content -->
     <div class="container">
        <div class="row">
            <div class="col-md">
                <!-- NOTE panel -->
                <ul class="nav nav-pills nav-fill mb-3 shadow p-3 mb-5 bg-white rounded" id="pills-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="pills-student-tab" data-toggle="pill" href="#pills-student" role="tab" aria-controls="pills-student" aria-selected="true">I'm a student</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-staff-tab" data-toggle="pill" href="#pills-staff" role="tab" aria-controls="pills-staff" aria-selected="false">I'm a staff</a>
                    </li>
                </ul>

                <div class="tab-content shadow p-3 mb-5 bg-white rounded" id="pills-tabContent">
                    <!--NOTE student form -->
                    <div class="tab-pane fade show active" id="pills-student" role="tabpanel" aria-labelledby="pills-student-tab">
                        <!-- NOET method="POST" -->
                        <form id="stuForm" name="stuForm" method="post" onsubmit="return stuFormSubmit();">
                            <h4 class="mb-3">Personal Information</h4>
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" id="stuName" name="stuName" class="form-control" placeholder="Your Name" required>
                            </div>
                            <div class="form-group">
                                <label for="ID">Student ID</label>
                                <input type="text" id="stuID" name="stuID" class="form-control" placeholder="Your Student ID" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email Address</label>
                                <input type="email" id="stuEmail" name="stuEmail" class="form-control" placeholder="Your Email Address" pattern="^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$" required>
                            </div>
                            <div class="form-group">
                                <label for="stuPassword">Password</label>
                                <input type="password" id="stuPassword" name="stuPassword" class="form-control" placeholder="Your password" aria-describedby="passwordHelpId" pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^]).{6,12}" required>
                                <small id="passWordHelpId" class="text-muted">Your password must be 6-12 characters
                                    long, contain at least 1 lowercase letter,1 uppercase letter,1 number and one of
                                    following special characters ! @ # $ % ^</small>
                            </div>
                            <div class="form-group">
                                <label for="stuRePassword">Re-enter Password</label>
                                <input type="password" id="stuRePassword" name="stuRePassword" class="form-control" placeholder="Re-enter your password" required>
                                <div class="invalid-feedback">
                                    Password does not match.
                                </div>
                            </div>
                            <hr class="mb-4">
                            <h4 class="mb-3">Optional Information</h4>
                            <div class="form-group">
                                <label for="address">Address<span class="text-muted">(Optional)</span></label>
                                <input type="text" id="stuAddress" name="stuAddress" class="form-control" placeholder="Your address">
                            </div>
                            <div class="form-group">
                                <label for="birth">Date of Birth<span class="text-muted">(Optional)</span></label>
                                <input type="date" id="stuBirth" name="stuBirth" class="form-control" placeholder="DD/MM/YYYY" pattern="^([0-2][0-9]|(3)[0-1])(\/)(((0)[0-9])|((1)[0-2]))(\/)\d{4}$">
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone Number<span class="text-muted">(Optional)</span></label>
                                <input type="tel" id="stuPhoneNumber" name="stuPhoneNumber" class="form-control" placeholder="e.g.(+61)/(0)xxxxxxxxx">
                                <div class="invalid-feedback">
                                    Please match the format requested.
                                </div>
                            </div>
                            <hr class="mb-4">
                            <button type="submit" id="stuSubmitBtn" class="btn btn-primary btn-lg btn-block mb-5 d-flex align-items-center justify-content-center">
                                <span id="stuSpinner" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                Register as a student
                            </button>
                        </form>
                    </div>
                    <!--NOTE staff form -->
                    <div class="tab-pane fade" id="pills-staff" role="tabpanel" aria-labelledby="pills-staff-tab">
                        <!-- NOTE method="post" -->
                        <form id="staForm" name="staForm" method="post" onsubmit="return staFormSubmit();">
                            <h4 class="mb-3">Personal Information</h4>
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" id="staName" name="staName" class="form-control" placeholder="Your Name" required>
                            </div>
                            <div class="form-group">
                                <label for="ID">Staff ID</label>
                                <input type="text" id="staID" name="staID" class="form-control" placeholder="Your Staff ID" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email Address</label>
                                <input type="email" id="staEmail" name="staEmail" class="form-control" placeholder="Your Email Address" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" id="staPassword" name="staPassword" class="form-control" placeholder="Your password" aria-describedby="passwordHelpId" pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^]).{6,12}" required>
                                <small id="passWordHelpId" class="text-muted">Your password must be 6-12 characters
                                    long, contain at least 1 lowercase letter,1 uppercase letter,1 number and one of
                                    following special characters ! @ # $ % ^</small>
                            </div>
                            <div class="form-group">
                                <label for="repassword">Re-enter Password</label>
                                <input type="password" id="staRePassword" name="staRePassword" class="form-control" placeholder="Re-enter your password" required>
                                <div class="invalid-feedback">
                                    Password does not match.
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="qualification">Qualification</label>
                                    <select class="custom-select" id="staQualification" name="staQualification" required>
                                        <option value="" selected>Select Qualification</option>
                                        <option value="Bachelor">Bachelor</option>
                                        <option value="Master">Master</option>
                                        <option value="PhD">PhD</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="staExpertise">Expertise</label>
                                    <input type="text" id="staExpertise" name="staExpertise" class="form-control" placeholder="e.g. Information Systems" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone Number</label>
                                <input type="tel" id="staPhoneNumber" name="staPhoneNumber" class="form-control" placeholder="e.g.(+61)/(0)xxxxxxxxx" pattern="^(?:\+?61|0)4 ?(?:(?:[01] ?[0-9]|2 ?[0-57-9]|3 ?[1-9]|4 ?[7-9]|5 ?[018]) ?[0-9]|3 ?0 ?[0-5])(?: ?[0-9]){5}$" required>
                            </div>
                            <hr class="mb-4">
                            <button type="submit" id="staSubmitBtn" class="btn btn-primary btn-lg btn-block mb-5 d-flex align-items-center justify-content-center">
                                <span id="staSpinner" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                Register as a staff</button>
                        </form>
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
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
    </script>
    <script type="text/javascript" src="../JS/registration.js"></script>
</body>

</html>