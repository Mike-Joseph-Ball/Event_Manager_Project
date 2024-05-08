<?php //Find all the venues in the system and display them in a dropdown.
//Find all the universities and display them in the system.

$servername = "localhost";
$username = "root";
$password = "";

$db = mysqli_connect($servername, $username, $password);
$db_selected = mysqli_select_db($db, 'Event_DB');

session_start();

if (!isset($_SESSION['User_email'])) {
    exit('Invalid session. Log in, or sign up for an account.');
} elseif (!isset($_GET['event_id'])) {
    exit('Invalid access based upon GET');
}

$sql = "SELECT * FROM _Event WHERE event_id =" . mysqli_real_escape_string($db, $_GET['event_id']);

$query = mysqli_query($db, $sql);
$event = mysqli_fetch_assoc($query);

list($event_start_date, $event_start_time) = explode(' ', $event['Start_date_time']);

$event_start_date = strtotime($event_start_date); // Convert date string to Unix timestamp
$event_start_time = strtotime($event_start_time); // Convert time string to Unix timestamp

$event_start_date = date("F jS, Y", $event_start_date);
$event_start_time = date("h:i A", $event_start_time);

list($event_end_date, $event_end_time) = explode(' ', $event['End_date_time']);

$event_end_date = strtotime($event_end_date); // Convert date string to Unix timestamp
$event_end_time = strtotime($event_end_time); // Convert time string to Unix timestamp

$event_end_date = date("F jS, Y", $event_end_date);
$event_end_time = date("h:i A", $event_end_time);

if (isset($event['User_email'])) {
    //echo "{$event['User_email']}";
    $sql = "SELECT First_name,Last_name FROM _User WHERE User_email ='" . mysqli_real_escape_string($db, $event['User_email']) . "'";
    $query = mysqli_query($db, $sql);
    $user_info = mysqli_fetch_assoc($query);
}
$sql = "SELECT University_name FROM University WHERE University_id ='" . mysqli_real_escape_string($db, $event['University_id']) . "'";
$query = mysqli_query($db, $sql);
$University_name = mysqli_fetch_assoc($query);

$sql = "SELECT Venue_name,Street_address,City,State,Zip FROM Venue WHERE Street_address ='" . mysqli_real_escape_string($db, $event['Street_address']) . "'
        AND City = '" . mysqli_real_escape_string($db, $event['City']) . "'
        AND State = '" . mysqli_real_escape_string($db, $event['State']) . "'
        AND Zip = '" . mysqli_real_escape_string($db, $event['Zip']) . "'";
$query = mysqli_query($db, $sql);
$Venue = mysqli_fetch_assoc($query);

$sql = 'SELECT User_email FROM Enrolled_in WHERE Event_id =' . mysqli_real_escape_string($db, $_GET['event_id']);
$user_query = mysqli_query($db, $sql);

$sql = 'SELECT User_email FROM _Event WHERE Event_id =' . mysqli_real_escape_string($db, $_GET['event_id']);
$query = mysqli_query($db, $sql);
if ($query) {
    if (mysqli_num_rows($query) != 1) {
        exit('query to retrieve managing user email was malformed.');
    }
} else {
    exit('query to find managing user email failed.');
}
$managing_user_email = mysqli_fetch_assoc($query);

$sql = 'SELECT * FROM _User WHERE User_email="' . mysqli_real_escape_string($db, $managing_user_email['User_email']) . '"';
$query = mysqli_query($db, $sql);

if (!$query) {
    exit('Could not retrieve managing user');
}

$managing_user = mysqli_fetch_assoc($query);

$logged_in_user_email = $_SESSION['User_email'];

$sql = 'SELECT Event_published FROM _Event WHERE Event_id=' . mysqli_real_escape_string($db, $_GET['event_id']);
$query = mysqli_query($db, $sql);
$is_event_published = mysqli_fetch_assoc($query);
$is_event_published = $is_event_published['Event_published'];

$logged_in_user_enrolled = 0;
while ($user = mysqli_fetch_assoc($user_query)) {
    if ($user['User_email'] === $logged_in_user_email) {
        $logged_in_user_enrolled = 1;
    }
}
mysqli_data_seek($user_query, 0);

//Display:
//Event Name
//Event Description
//First and last name of managing user
//State Date and time
//End date and time
//Venue
//University
//Event Type
//Presenter abstract deadline
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Details </title>
    <link rel="stylesheet" href="style/style.css">

</head>

<body>


    <div class="nav">
        <a href="home.php"><button class="btn">Homepage</button></a>
        <h1><?php echo $event['Event_name']; ?></h1>
        <?php if ($logged_in_user_email != $managing_user_email['User_email']) { ?>
            <a href="toggle_register_for_event.php?User_email=<?php echo $logged_in_user_email; ?>&is_enrolled=<?php echo $logged_in_user_enrolled ?>&event_id=<?php echo $_GET['event_id'] ?>"><?php if ($logged_in_user_enrolled) { ?>Unregister <?php } else { ?><button class="btn"> Register</button> <?php } ?></a>
        <?php } ?>

    </div>


    <table border="1">
        <thead>
            <tr>
                <th>Event Type </th>
                <th>Event Description </th>
                <th>Start Time </th>
                <th>End Time </th>
                <th>Venue</th>
                <th>University</th>
                <th>Managing User </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?php echo $event['Event_type'] ?></td>
                <td><?php echo $event['Event_description']; ?></td>
                <td><?php echo $event_start_date ?>, <?php echo $event_start_time ?></td>
                <td><?php echo $event_end_date ?>, <?php echo $event_end_time ?></td>
                <td><?php echo $Venue['Venue_name'] ?> - <?php echo $Venue['Street_address'] ?>, <?php echo $Venue['City'] ?>,<?php echo $Venue['State'] ?> <?php echo $Venue['Zip'] ?> </td>
                <td><?php echo $University_name['University_name'] ?></td>
                <td><?php echo $user_info['First_name']; ?> <?php echo $user_info['Last_name']; ?></td>
            </tr>
        </tbody>
    </table>

    <div class="event_lists">
        <div class="regu">
            <h2> Registered Users </h2>
            <p><?php //Below code creates a new anchor item for every user signed up for the event.
                ?>
                <?php while ($row = mysqli_fetch_assoc($user_query)) { ?>
                    <a href=" show_user.php?email=<?php echo $row['User_email']; ?>"><?php echo $row['User_email']; ?> </a>
                <?php } ?>
            </p>

            <h2>Sponsors</h2>
            <?php $sql = 'SELECT Sponsor_id FROM Sponsored_events WHERE Event_id=' . mysqli_real_escape_string($db, $_GET['event_id']);
            $sponsor_id_query = mysqli_query($db, $sql); ?>

            <?php
            while ($sponsor_id = mysqli_fetch_assoc($sponsor_id_query)) {
                $sql = 'SELECT Sponsor_name FROM Sponsor WHERE Sponsor_id=' . $sponsor_id['Sponsor_id'];
                $query = mysqli_query($db, $sql);
                $sponsor = mysqli_fetch_assoc($query);
            ?>
                <p><?php echo $sponsor['Sponsor_name'] ?></p>
            <?php } ?>

            <h2>Keynote Speakers</h2>
            <?php $sql = 'SELECT Speaker_id FROM Speaks_on WHERE Event_id=' . mysqli_real_escape_string($db, $_GET['event_id']);
            $speaker_id_query = mysqli_query($db, $sql); ?>

            <?php
            while ($speaker_id = mysqli_fetch_assoc($speaker_id_query)) {
                $sql = 'SELECT First_name,Last_name FROM Keynote_speaker WHERE Speaker_id=' . $speaker_id['Speaker_id'];
                $query = mysqli_query($db, $sql);
                $speaker = mysqli_fetch_assoc($query);
            ?>
                <p><?php echo $speaker['First_name'] ?> <?php echo $speaker['Last_name'] ?></p>
            <?php } ?>

            <h2>Presenters</h2>
            <?php $sql = 'SELECT Presenter_id FROM Presents_on WHERE Event_id=' . mysqli_real_escape_string($db, $_GET['event_id']);
            $presenter_id_query = mysqli_query($db, $sql); ?>

            <?php
            while ($presenter_id = mysqli_fetch_assoc($presenter_id_query)) {
                $sql = 'SELECT First_name,Last_name FROM Presenter WHERE Presenter_id=' . $presenter_id['Presenter_id'];
                $query = mysqli_query($db, $sql);
                $presenter = mysqli_fetch_assoc($query);
            ?>
                <p><?php echo $presenter['First_name'] ?> <?php echo $presenter['Last_name'] ?></p>
            <?php } ?>
        </div>

    </div>


    <?php if ($logged_in_user_email === $managing_user_email['User_email']) { ?>
        <div class="box3">
            <a href="delete_event.php?event_id=<?php echo $_GET['event_id'] ?>"><button class="btn">Delete Event</button></a>
            <a href="toggle_publish_event.php?is_event_published=<?php echo $is_event_published; ?>&event_id=<?php echo $_GET['event_id'] ?>"><button class="btn"><?php if ($is_event_published) { ?>Unpublish Event <?php } else { ?>Publish Event <?php } ?></button></a>
        </div>

        <script>
            function openPopup(url) {
                // Open a popup window with the specified URL
                let popup = window.open(url, "_blank", "width=600,height=400");
                // Focus on the popup window
                if (popup) {
                    popup.focus();
                } else {
                    alert('Please allow popups for this site');
                }
            }
        </script>

        <div class="box3">
            <button class="btn" onclick="openPopup('add_sponsor_form.php?event_id=<?php echo $_GET['event_id'] ?>')">Add Sponsor</button>
            <button class="btn" onclick="openPopup('add_keynote_speaker_form.php?event_id=<?php echo $_GET['event_id'] ?>')">Add Keynote Speaker</button>
            <button class="btn" onclick="openPopup('add_presenter_form.php?event_id=<?php echo $_GET['event_id'] ?>')">Add Presenter</button>
        </div>

    <?php } ?>
</body>

</html>