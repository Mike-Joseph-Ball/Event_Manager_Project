<?php

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
} else if (!isset($_SESSION['User_email'])) {
    exit('no session data');
}

//check if the signed in user manages this event

$sql = 'SELECT User_email FROM _Event WHERE Event_id=' . mysqli_real_escape_string($db, $_GET['event_id']);
$query = mysqli_query($db, $sql);
$user_email = mysqli_fetch_assoc($query);
$manager_user_email = $user_email['User_email'];

if ($manager_user_email != $_SESSION['User_email']) {
    exit('Invalid access to delete event');
}
$sql = 'DELETE FROM Enrolled_in WHERE Event_id=' . mysqli_real_escape_string($db, $_GET['event_id']);
$query = mysqli_query($db, $sql);
if (!$query) {
    exit('query to delete failed.');
}

$sql = 'DELETE FROM Presents_on WHERE Event_id=' . mysqli_real_escape_string($db, $_GET['event_id']);
$query = mysqli_query($db, $sql);
if (!$query) {
    exit('query to delete failed.');
}

$sql = 'DELETE FROM Speaks_on WHERE Event_id=' . mysqli_real_escape_string($db, $_GET['event_id']);
$query = mysqli_query($db, $sql);
if (!$query) {
    exit('query to delete failed.');
}

$sql = 'DELETE FROM _Event WHERE Event_id=' . mysqli_real_escape_string($db, $_GET['event_id']);
$query = mysqli_query($db, $sql);
if (!$query) {
    exit('query to delete failed.');
}

redirect_to("home.php");
