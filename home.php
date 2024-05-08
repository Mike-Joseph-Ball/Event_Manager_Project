<?php
$servername = "localhost";
$username = "root";
$password = "";

$db = mysqli_connect($servername, $username, $password);
$db_selected = mysqli_select_db($db, 'Event_DB');

session_start();

if (!isset($_SESSION['User_email'])) {
    exit('Invalid session. Log in, or sign up for an account.');
}


//GRAB ALL THE EVENTS THAT DO NOT BELOND TO THE USER CURRENTLY LOGGED IN

$sql = 'SELECT * FROM _Event WHERE User_email <>"' . mysqli_real_escape_string($db, $_SESSION['User_email']) . '" AND Event_published = 1';
$events = mysqli_query($db, $sql);

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Home</title>
</head>

<body>
    <div class="nav">
        <div class="right-links">
            <a href="logout.php"><button class="btn">Log out</button></a>
        </div>

        <div class="right-links">
            <a href="show_user.php?email=<?php echo $_SESSION['User_email'] ?>"><button class="btn">Your Events</button></a>
            <a href="create_event_form.php"><button class="btn">Create Event</button></a>
        </div>
    </div>

    <main>
        <div class="main-box top">
            <div class="top">
                <?php while ($event = mysqli_fetch_assoc($events)) { ?>

                    <script>
                        function redirectToEvent_<?php echo $event['Event_id']; ?>() {
                            window.location.href = "event_details.php?event_id=<?php echo $event['Event_id'] ?>"
                        }
                    </script>

                    <div class="box" onclick="redirectToEvent_<?php echo $event['Event_id']; ?>()">
                        <?php echo $event['Event_name'] ?>
                    </div>

                <?php } ?>

            </div>

        </div>
    </main>

</body>

</html>