<?php //Find all the venues in the system and display them in a dropdown.
//Find all the universities and display them in the system.

$servername = "localhost";
$username = "root";
$password = "";

$db = mysqli_connect($servername, $username, $password);
$db_selected = mysqli_select_db($db, 'Event_DB');

function redirect_to($location)
{
    header("Location: " . $location);
    exit;
}

session_start();

if (!isset($_GET['event_id'])) {
    exit('no event id');
} elseif (!isset($_SESSION['User_email'])) {
    exit('no session email id');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //retrieve POST variables, then insert into the Sponsored_events
    $sponsor_id = $_POST['sponsor'];

    $sql = 'INSERT INTO Sponsored_events (Sponsor_id,Event_id) VALUES ("' . mysqli_real_escape_string($db, $sponsor_id) . '","' . mysqli_real_escape_string($db, $_GET['event_id']) . '")';
    $query = mysqli_query($db, $sql);

    if (!$query) {
        exit('failed database insert');
    }
    echo '<script>window.close();</script>';
} else {
    exit('not a post method');
}
