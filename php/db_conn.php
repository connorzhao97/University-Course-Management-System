<?php
//connect to mysql
$mysqli = new mysqli('localhost', 'yucongz', '518264', 'yucongz');

if (mysqli_connect_errno()) {
	    printf("Connect failed: %s\n", mysqli_connect_error());
	    exit();
	}
