<!doctype html>
<html lang="en" class="h-100">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="../CSS/masterList.css">
    <title>Master List - University of DoWell</title>
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
                <li class="nav-item">
                    <a class="nav-link" href="../pages/unitEnrolment.html">Unit Enrolment</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../pages/individualTimetable.html">Individual Timetable</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../pages/tutorialAllocation.html">Tutorial Allocation</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="../pages/masterList.html">Master List</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../pages/unitManagement.html">Unit Management</a>
                </li>
            </ul>
            <form class="form-inline">
                <a class="btn btn-success" href="../pages/login.html" role="button">Login / Register</a>
            </form>
        </div>
    </nav>
    <!-- NOTE jumbotron -->
    <div class="jumbotron jumbotron-fluid img-fluid text-center bg">
        <div class="container h-100">
            <h1 class="display-4 mb-5 text-white">Staff Management</h1>
        </div>
    </div>
    <!-- NOTE content -->
    <div class="container">
        <div class="nav nav-pills flex-column flex-sm-row mb-2 shadow-lg p-3 mb-5 bg-white rounded" id="pills-tab" role="tablist">
            <a class="flex-sm-fill text-sm-center nav-link active" id="pills-first-tab" data-toggle="pill" href="#pills-first" role="tab" aria-controls="pills-first" aria-selected="true">Staff Management</a>
            <a class="flex-sm-fill text-sm-center nav-link" id="pills-second-tab" data-toggle="pill" href="#pills-second" role="tab" aria-controls="pills-second" aria-selected="false">Unit Management</a>
        </div>
        <div class="tab-content shadow-lg p-3 mb-5 bg-white rounded" id="pills-tabContent">
            <!-- NOTE staff management -->
            <div class="tab-pane fade show active" id="pills-first" role="tabpanel" aria-labelledby="pills-first-tab">
                <button type="button" class="btn btn-primary mb-3" id="btnCreate" data-toggle="modal" data-target="#createNewStaff">Create New Staff</button>
                <table class="table table-striped table-bordered table-responsive-lg" id="staManagementTable">
                    <thead>
                        <tr>
                            <th scope="col">Staff ID</th>
                            <th scope="col">Staff Name</th>
                            <th scope="col">Qualification</th>
                            <th scope="col">Expertise</th>
                            <th scope="col">Preferred days of teaching</th>
                            <th scope="col">Consultation hours</th>
                            <!-- <th scope="col">Edit</th>
                            <th scope="col">Remove</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        <!-- NOTE one of staffs -->
                        <tr>
                            <td scope="row" class="align-middle">
                                123456
                            </td>
                            <td class="align-middle">
                                Jack
                            </td>
                            <td class="align-middle">
                                Master
                            </td>
                            <td class="align-middle">
                                Human Computer Interaction
                            </td>
                            <td class="align-middle">
                                Mon. Thu.
                            </td>
                            <td class="align-middle">
                                <p>Mon.</p>9:00 - 10:00
                            </td>
                            <td class="align-middle">
                                <button type="button" name="" id="btnEdit" class="btn btn-primary btn-lg btn-block" data-toggle="modal" data-target="#manageStaff" onclick="editStaff(this);">Edit</button>
                            </td>
                            <td class="align-middle">
                                <button type="button" name="" id="btnRemove" class="btn btn-danger btn-lg btn-block" onclick="removeStaff(this)">Remove</button>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>
            <!-- NOTE unit management -->
            <div class="tab-pane fade" id="pills-second" role="tabpanel" aria-labelledby="pills-second-tab">
                <div class="tab-pane fade show active" id="pills-first" role="tabpanel" aria-labelledby="pills-first-tab">
                    <!-- NOTE method="post" -->
                    <form name="unitManagementForm" id="unitManagementForm" method="" action="" onsubmit="return unitManagementFormSubmit(this)">
                        <!-- <button type="submit" class="btn btn-primary"></button> -->
                        <table class="table table-striped table-bordered table-responsive-md">
                            <thead>
                                <tr>
                                    <th scope="col">Unit Name</th>
                                    <th scope="col">Lecturer</th>
                                    <th scope="col">Campus</th>
                                    <th scope="col">Semester</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td scope="row" class="align-middle">
                                        <p class="mb-0">KIT502 Web Development</p>
                                    </td>
                                    <td class="align-middle">
                                        <div class="form-group mb-0">
                                            <select class="custom-select selLec" name="kit502Lec" id="kit502Lec" disabled required>
                                                <option value="" selected>Select Lecturer</option>
                                                <option value="Ackerley">Ackerley</option>
                                                <option value="Adamaris">Adamaris</option>
                                                <option value="Adney">Adney</option>
                                            </select>
                                        </div>
                                    </td>
                                    <td class="align-middle">
                                        <div class="form-group mb-0">
                                            <select class="custom-select selCam" name="kit502Cam" id="kit502Cam" disabled required>
                                                <option value="" selected>Select Campus</option>
                                                <option value="Pandora">Pandora</option>
                                                <option value="Rivendell">Rivendell</option>
                                                <option value="Neverland">Neverland</option>
                                            </select>
                                        </div>
                                    </td>
                                    <td class="align-middle">
                                        <div class="form-group mb-0">
                                            <select class="custom-select selSem" name="kit502Sem" id="kit502Sem" disabled required>
                                                <option value="" selected>Select Semester</option>
                                                <option value="Semester 1">Semester 1</option>
                                                <option value="Semester 2">Semester 2</option>
                                                <option value="Winter School">Winter School</option>
                                                <option value="Spring School">Spring School</option>
                                            </select>
                                        </div>
                                    </td>
                                    <td class="align-middle">
                                        <button type="button" name="" id="502Edit" class="btn btn-primary btn-lg btn-block" onclick="editUnit(this)">Edit</button>
                                        <button type="button" name="" id="502Confirm" class="btn btn-success btn-lg btn-block d-none" onclick="confirmUnit(this)">Confirm</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td scope="row" class="align-middle">
                                        <p class="mb-0">KIT503 ICT Professional Practices and Project Management</p>
                                    </td>
                                    <td class="align-middle">
                                        <div class="form-group mb-0">
                                            <select class="custom-select selLec" name="kit503Lec" id="kit503Lec" disabled required>
                                                <option value="" selected>Select Lecturer</option>
                                                <option value="Ackerley">Ackerley</option>
                                                <option value="Adamaris">Adamaris</option>
                                                <option value="Adney">Adney</option>
                                            </select>
                                        </div>
                                    </td>
                                    <td class="align-middle">
                                        <div class="form-group mb-0">
                                            <select class="custom-select selCam" name="kit503Cam" id="kit503Cam" disabled required>
                                                <option value="" selected>Select Campus</option>
                                                <option value="Pandora">Pandora</option>
                                                <option value="Rivendell">Rivendell</option>
                                                <option value="Neverland">Neverland</option>
                                            </select>
                                        </div>
                                    </td>
                                    <td class="align-middle">
                                        <div class="form-group mb-0">
                                            <select class="custom-select selSem" name="kit503Sem" id="kit503Sem" disabled required>
                                                <option value="" selected>Select Semester</option>
                                                <option value="Semester 1">Semester 1</option>
                                                <option value="Semester 2">Semester 2</option>
                                                <option value="Winter School">Winter School</option>
                                                <option value="Spring School">Spring School</option>
                                            </select>
                                        </div>
                                    </td>
                                    <td class="align-middle">
                                        <button type="button" name="" id="503Edit" class="btn btn-primary btn-lg btn-block" onclick="editUnit(this)">Edit</button>
                                        <button type="button" name="" id="503Confirm" class="btn btn-success btn-lg btn-block d-none" onclick="confirmUnit(this)">Confirm</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>

            <!-- NOTE crete staff modal -->
            <div class="modal fade" id="createNewStaff" tabindex="-1" role="dialog" aria-labelledby="createNewStaffLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalCenterTitle">Create New Staff</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="fCNSta" name="fCNSta" onsubmit="return createNewStaffForm(this);">
                                <div class="form-group">
                                    <label for="staNewID">Staff ID</label>
                                    <input type="text" class="form-control" name="staNewID" id="staNewID" placeholder="" required>
                                </div>
                                <div class="form-group">
                                    <label for="staNewName">Staff Name</label>
                                    <input type="text" class="form-control" name="staNewName" id="staNewName" placeholder="" required>
                                </div>
                                <div class="form-group">
                                    <label for="staNewQua">Qualification</label>
                                    <select class="custom-select" name="staNewQua" id="staNewQua" required>
                                        <option value="" selected>Select Qualification</option>
                                        <option value="PhD">PhD</option>
                                        <option value="Master">Master</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="staNewExp">Expertise</label>
                                    <select class="custom-select" name="staNewExp" id="staNewExp" required>
                                        <option value="" selected>Select Expertise</option>
                                        <option value="Information Systems">Information Systems</option>
                                        <option value="Human Computer Interaction">Human Computer Interaction</option>
                                        <option value="Network Administration">Network Administration</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <div class="column">
                                        <label for="staPreDyas">Preferred days of teaching</label>
                                        <div class="checkboxGroup" required>
                                            <div class="custom-control custom-checkbox custom-control-inline">
                                                <input type="checkbox" id="staNewPreMon" name="staNewPreMon" class="custom-control-input">
                                                <label class="custom-control-label" for="staNewPreMon">Mon.</label>
                                            </div>
                                            <div class="custom-control custom-checkbox custom-control-inline">
                                                <input type="checkbox" id="staNewPreTue" name="staNewPreTue" class="custom-control-input">
                                                <label class="custom-control-label" for="staNewPreTue">Tue.</label>
                                            </div>
                                            <div class="custom-control custom-checkbox custom-control-inline">
                                                <input type="checkbox" id="staNewPreWed" name="staNewPreWed" class="custom-control-input">
                                                <label class="custom-control-label" for="staNewPreWed">Wed.</label>
                                            </div>
                                            <div class="custom-control custom-checkbox custom-control-inline">
                                                <input type="checkbox" id="staNewPreThu" name="staNewPreThu" class="custom-control-input">
                                                <label class="custom-control-label" for="staNewPreThu">Thu.</label>
                                            </div>
                                            <div class="custom-control custom-checkbox custom-control-inline">
                                                <input type="checkbox" id="staNewPreFri" name="staNewPreFri" class="custom-control-input">
                                                <label class="custom-control-label" for="staNewPreFri">Fri.</label>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback">
                                            Please select one preferred of teaching day at least.
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="staCon">Consultation hours</label>
                                    <input type="text" class="form-control" name="staNewCon" id="staNewCon" placeholder="" required>
                                </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Create</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- NOTE manage staff modal -->
            <div class="modal fade" id="manageStaff" tabindex="-1" role="dialog" aria-labelledby="manageStaffLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalCenterTitle">Manage Staff</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="fMSta" onsubmit="return validate();">
                                <div class="form-group">
                                    <label for="staID">Staff ID</label>
                                    <input type="text" class="form-control" name="" id="" placeholder="" required>
                                </div>
                                <div class="form-group">
                                    <label for="staName">Staff Name</label>
                                    <input type="text" class="form-control" name="" id="" placeholder="" required>
                                </div>
                                <div class="form-group">
                                    <label for="staQua">Qualification</label>
                                    <select class="custom-select" name="" id="" required>
                                        <option value="" selected>Select Qualification</option>
                                        <option value="PhD">PhD</option>
                                        <option value="Master">Master</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="staExp">Expertise</label>
                                    <select class="custom-select" name="" id="" required>
                                        <option value="" selected>Select Expertise</option>
                                        <option value="informationSystems">Information Systems</option>
                                        <option value="humanComputerInteraction">Human Computer Interaction</option>
                                        <option value="networkAdministration">Network Administration</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <div class="column">
                                        <label for="staPreDyas">Preferred days of teaching</label>
                                        <div class="checkboxGroup" required>
                                            <div class="custom-control custom-checkbox custom-control-inline">
                                                <input type="checkbox" id="customCheckboxInlineMon" name="customCheckboxInlineMon" class="custom-control-input">
                                                <label class="custom-control-label" for="customCheckboxInlineMon">Mon.</label>
                                            </div>
                                            <div class="custom-control custom-checkbox custom-control-inline">
                                                <input type="checkbox" id="customCheckboxInlineTue" name="customCheckboxInlineTue" class="custom-control-input">
                                                <label class="custom-control-label" for="customCheckboxInlineTue">Tue.</label>
                                            </div>
                                            <div class="custom-control custom-checkbox custom-control-inline">
                                                <input type="checkbox" id="customCheckboxInlineWed" name="customCheckboxInlineWed" class="custom-control-input">
                                                <label class="custom-control-label" for="customCheckboxInlineWed">Wed.</label>
                                            </div>
                                            <div class="custom-control custom-checkbox custom-control-inline">
                                                <input type="checkbox" id="customCheckboxInlineThu" name="customCheckboxInlineThu" class="custom-control-input">
                                                <label class="custom-control-label" for="customCheckboxInlineThu">Thu.</label>
                                            </div>
                                            <div class="custom-control custom-checkbox custom-control-inline">
                                                <input type="checkbox" id="customCheckboxInlineFri" name="customCheckboxInlineFri" class="custom-control-input">
                                                <label class="custom-control-label" for="customCheckboxInlineFri">Fri.</label>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback">
                                            Please select one preferred of teaching day at least.
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="staCon">Consultation hours</label>
                                    <input type="text" class="form-control" name="" id="" placeholder="" required>
                                </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" onsubmit="manageStaff()">Save
                                changes</button>
                        </div>
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
    <script src="https://code.jquery.com/jquery-3.5.0.min.js" integrity="sha256-xNzN2a4ltkB44Mc/Jz3pT4iU1cmeR0FkXs4pru/JxaQ=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
    </script>
    <!-- Link to use icon-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <script src="../JS/jquery.tabledit.min.js"></script>
    <!-- Optional JavaScript -->
    <script type="text/javascript" src="../JS/masterList.js"></script>
</body>

</html>