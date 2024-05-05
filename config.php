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
$queries = explode(';', $query);

foreach ($queries as $sql) {
    if (trim($sql) != '') {
        $result = mysqli_query($db, $sql);

        if (!$result) {
            die("Error executing query: " . mysqli_error($db));
        }
    }
}
echo "\nMade it through the execution of each SQL statement";

if (!$result) {
    exit("Failed database set up");
}



/*
function redirect_to($location)
{
    header("Location: ") . $location;
    exit;
}

redirect_to('index.php');
*/
