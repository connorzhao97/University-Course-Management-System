<?php

include('session.php');
session_destroy();
header("Location:../pages/home.php");