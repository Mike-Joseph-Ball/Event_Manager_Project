<?php
$servername = "localhost";
$username = "root";
$password = "";

function redirect_to($location)
{
    header("Location: " . $location);
    exit;
}

$db = mysqli_connect($servername, $username, $password);
$db_selected = mysqli_select_db($db, 'Event_DB');

session_start();

$sql = 'SELECT User_email FROM _Event WHERE event_id="' . mysqli_real_escape_string($db, $_GET['event_id']) . '"';
$query = mysqli_query($db, $sql);
$User_email = mysqli_fetch_assoc($query);
$Manager_user_email = $User_email['User_email'];

if (isset($_SESSION['User_email']) && isset($_GET['User_email']) && isset($_GET['is_enrolled']) && isset($_GET['event_id'])) {

    //echo $_GET['User_email'];
    //echo $Manager_user_email;
    if ($_GET['User_email'] === $Manager_user_email) {
        exit('event owners cannot register for their own events.');
    }


    //sign up for event
    if ($_GET['is_enrolled'] === '0') {

        $sql = 'INSERT INTO Enrolled_in (User_email,Event_id) VALUES ("' . mysqli_real_escape_string($db, $_GET['User_email']) . '",' . mysqli_real_escape_string($db, $_GET['event_id']) . ')';
        $query = mysqli_query($db, $sql);

        if (!$query) {
            exit("failed insertion into enrolled_in table");
        }
    } else {

        $sql = 'DELETE FROM Enrolled_in WHERE User_email="' . mysqli_real_escape_string($db, $_SESSION['User_email']) . '"';
        $query = mysqli_query($db, $sql);

        if (!$query) {
            exit("failed insertion into enrolled_in table");
        }
    }


    redirect_to('event_details.php?event_id=' . $_GET['event_id']);
} else {
    exit('Malformed access to toggle_register_for_event');
}
