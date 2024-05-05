<?php
$servername = "localhost";
$username = "root";
$password = "";

$db = mysqli_connect($servername, $username, $password);
$db_selected = mysqli_select_db($db, 'Event_DB');

session_start();

$_SESSION = array();

session_destroy();

function redirect_to($location)
{
    header("Location: " . $location);
    exit;
}

redirect_to("index.php");
