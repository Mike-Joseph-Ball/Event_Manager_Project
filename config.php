<?php
$servername = "localhost";
$username = "root";
$password = "";

// Create connection
$db = mysqli_connect($servername, $username, $password);

// Check connection
if (mysqli_connect_errno()) {
    die("Connection failed: " . mysqli_connect_error());
}
echo "Connected successfully";

$query = file_get_contents('sql/CREATE_DB.sql');
$result - mysqli_query($db, $query);

if (!$result) {
    exit("Failed database set up");
}

function redirect_to($location)
{
    header("Location: ") . $location;
    exit;
}

redirect_to('index.html');
