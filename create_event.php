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

if (!isset($_SESSION['User_email'])) {
    exit('Invalid session. Log in, or sign up for an account.');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //The following post variables should be sent:
    // eName,eDesc,sdate,stime,edate,etime,venues,universities
    // Event_type,deadline,published

    /*
    if (isset($_POST['published'])) {
        $log_message = $_POST['eName'] . "\n" . $_POST['eDesc'] . "\n" . $_POST['sdate'] . "\n" . $_POST['stime'] . "\n" .  $_POST['edate'] . "\n" . $_POST['etime'] . "\n" . $_POST['venues'] . "\n" . $_POST['universities'] . "\n" . $_POST['Event_type'] . "\n" . $_POST['deadline'] . "\n" . $_POST['published'];
    } else {
        $log_message = $_POST['eName'] . "\n" . $_POST['eDesc'] . "\n" . $_POST['sdate'] . "\n" . $_POST['stime'] . "\n" .  $_POST['edate'] . "\n" . $_POST['etime'] . "\n" . $_POST['venues'] . "\n" . $_POST['universities'] . "\n" . $_POST['Event_type'] . "\n" . $_POST['deadline'];
    }
    $log_file = 'event_log.log';
    file_put_contents($log_file, $log_message . PHP_EOL, FILE_APPEND);
    */

    $event_name = $_POST['eName'];

    $event_description = $_POST['eDesc'];

    $event_start_date = $_POST['sdate'];
    $event_start_time = $_POST['stime'];
    $event_start_date_time = $event_start_date . " " . $event_start_time . ":00";

    $event_end_date = $_POST['edate'];
    $event_end_time = $_POST['etime'];
    $event_end_date_time = $event_end_date . " " . $event_end_time . ":00";

    $event_venue = explode(",", $_POST['venues']);

    $event_university = $_POST['universities'];

    $event_type = $_POST['Event_type'];

    $event_presenter_deadline = $_POST['deadline'];

    if (isset($_POST['published'])) {
        $is_event_published = 1;
    } else {
        $is_event_published = 0;
    }


    $sql = 'INSERT INTO _Event (User_email, Street_address, City, State, Zip, University_id, Deadline, Event_name, Event_description, Start_date_time, End_date_time, Event_type, Event_published) 
    VALUES ("' . mysqli_real_escape_string($db, $_SESSION['User_email']) . '", "'
        . mysqli_real_escape_string($db, $event_venue[0]) . '", "'
        . mysqli_real_escape_string($db, $event_venue[1]) . '", "'
        . mysqli_real_escape_string($db, $event_venue[2]) . '", "'
        . mysqli_real_escape_string($db, $event_venue[3]) . '", "'
        . mysqli_real_escape_string($db, $event_university) . '", "'
        . mysqli_real_escape_string($db, $event_presenter_deadline) . '", "'
        . mysqli_real_escape_string($db, $event_name) . '", "'
        . mysqli_real_escape_string($db, $event_description) . '", "'
        . mysqli_real_escape_string($db, $event_start_date_time) . '", "'
        . mysqli_real_escape_string($db, $event_end_date_time) . '", "'
        . mysqli_real_escape_string($db, $event_type) . '", "'
        . mysqli_real_escape_string($db, $is_event_published) . '")';

    $query = mysqli_query($db, $sql);

    $event_id = mysqli_insert_id($db);

    if ($query) {
        redirect_to('event_details.php?event_id=' . $event_id);
    }
} else {
    exit('Unauthorized request to create event');
}
