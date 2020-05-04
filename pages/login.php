<?php
include('../php/session.php');
if ($session_user != "") {
    // header("Location:../pages/home.php");
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
    <link rel="stylesheet" href="../CSS/login.css">


    <title>Login - University of DoWell</title>
</head>

<body class="d-flex flex-column h-100">
    <nav class="navbar navbar-expand-md navbar-dark bg-dark sticky-top">
        <a class="navbar-brand p-0" href="../pages/home.php">
            <img src="../imgs/logo.png" width="100" height="44">
        </a>
    </nav>
    <div class="container center">
        <!-- NOTE method="post" -->
        <form class="loginForm shadow-lg p-3 bg-white rounded text-nowrap" name="loginForm" id="loginForm" method="post" onsubmit="return loginFormSubmit();">
            <h1 class="h3 mb-3">Course Management System (CMS) </h1>
            <h2 class="h4 mb-3">Login</h2>
            <div class="form-group">
                <input type="text" id="stID" name="stID" class="form-control" placeholder="Your student/staff ID" required>
            </div>
            <div class="form-group">
                <input type="password" id="password" name="password" class="form-control" placeholder="password" pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^]).{6,12}" required>
            </div>

            <div class="form-check mb-3">
                <label class="form-check-label">
                    <input type="checkbox" name="remember" id="remember" class="form-check-input" id="checkbox" value="checked">
                    Remember me
                </label>
            </div>
            <button type="submit" id="btnLogin" class="btn btn-primary btn-lg btn-block mb-2" value="submit">Login</button>
            <a id="btnRegister" class="btn btn-secondary btn-lg btn-block" href="../pages/registration.php" role="button">Register</a>
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

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.0.min.js" integrity="sha256-xNzN2a4ltkB44Mc/Jz3pT4iU1cmeR0FkXs4pru/JxaQ=" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
    </script>
    <script type="text/javascript" src="../JS/login.js"></script>
</body>

</html>