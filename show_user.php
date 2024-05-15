<?php
$servername = "localhost";
$username = "root";
$password = "";

// Create connection
$db = mysqli_connect($servername, $username, $password);

//clarify which db is correct
$db_selected = mysqli_select_db($db, 'Event_DB');


// Check connection
if (mysqli_connect_errno()) {
    die("Connection failed: " . mysqli_connect_error());
}

session_start();

if (isset($_SESSION['User_email']) && isset($_GET['email'])) {

    $User_email = $_GET['email'];

    $get_name = "SELECT * FROM _User WHERE User_email = '" . mysqli_real_escape_string($db, $User_email) . "'";

    $result = mysqli_query($db, $get_name);

    if (!$result) {
        exit("Error querying User in question");
    }

    $user_data = mysqli_fetch_assoc($result);

    $sql = 'SELECT * FROM _Event WHERE User_email ="' . mysqli_real_escape_string($db, $_GET['email']) . '"';
    $events = mysqli_query($db, $sql);

    //var_dump($user_data);
} elseif (!isset($_SESSION['User_email']) && !isset($_GET['email'])) {
    exit('Neither GET email or session set.');
} elseif (!isset($_SESSION['User_email'])) {
    exit('Does not have session at all!');
} elseif (!isset($_GET['email'])) {
    exit('Somehow got here without GET');
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Document</title>
</head>

<body>
    <div class="nav">
        <p> <?php if ($_SESSION['User_email'] == $_GET['email']) { ?>Welcome <?php } else { ?> Profile of <?php } ?><b><?php echo $user_data['First_name']; ?> <?php echo $user_data['Last_name']; ?> </b> </p>
        <a href="home.php"><button class="btn">Homepage</button></a>
    </div>



    <main>
        <div class="box">
            <p> Email: <b> <?php echo $user_data['User_email']; ?> </b> </p>
            <p> Phone Number: <b> <?php echo $user_data['Phone_number']; ?> </b> </p>
        </div>

        <div class="events-box">
            <p> <u> <b>Events </b> </u>
            <p>
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

    </main>
</body>

</html>