<?php 
require 'config/constants.php';

//connect to database
$connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

//check for connection error
if (mysqli_error($connection)) {
    die(mysqli_error($connection));
}