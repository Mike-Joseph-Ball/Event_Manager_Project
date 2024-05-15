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

//FUNCTION FOR CHECKING IF EVENT HAS > 100 USERS REGISTERED

function is_event_greater_than_100($db, $event)
{
    if (!isset($event['User_email'])) {
        exit('is_event_greater_than_100 function wrong data');
    }

    //Get all entries from enrolled_in table for the event

    $sql = 'SELECT * FROM Enrolled_in where Event_id = ' . mysqli_real_escape_string($db, $event['Event_id']) . ';';
    $query = mysqli_query($db, $sql);
    $num_rows = mysqli_num_rows($query);

    if ($num_rows > 100) {
        return true;
    } else {
        return false;
    }
}


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
            <input type="checkbox" id="checkbox"> Events > 100 attendees
            <input type="text" id="searchBox" placeholder="Search...">
        </div>

        <div class="right-links">
            <a href="show_users.php?email=<?php echo $_SESSION['User_email'] ?>"><button class="btn">List of Users</button></a>
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

                    <?php if (is_event_greater_than_100($db, $event)) { ?>

                        <div class="box <?php echo ($event['Event_name']); ?>" onclick="redirectToEvent_<?php echo $event['Event_id']; ?>()">
                            <?php echo $event['Event_name'] ?>
                        </div>


                    <?php } else { ?>

                        <div class="box lessthan100 <?php echo ($event['Event_name']); ?>" data-eventName="<?php echo ($event['Event_name']); ?>" onclick="redirectToEvent_<?php echo $event['Event_id']; ?>()">
                            <?php echo $event['Event_name'] ?>
                        </div>

                    <?php } ?>

                <?php } ?>

            </div>

        </div>
    </main>

</body>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const checkbox = document.getElementById('checkbox');
        const eventBoxes = document.querySelectorAll('.box');

        checkbox.addEventListener('change', function() {
            // Check if checkbox is checked
            const isChecked = checkbox.checked;

            // Loop through the event boxes
            eventBoxes.forEach(function(box) {
                // Check if the box has the 'lessthan100' class
                const hasLessthan100Class = box.classList.contains('lessthan100');

                // Show or hide the event box based on checkbox state
                if (isChecked && hasLessthan100Class) {
                    // Hide the event box if checkbox is unchecked and box has 'lessthan100' class
                    box.style.display = 'none';
                } else if (!isChecked && hasLessthan100Class) {
                    // Show the event box if checkbox is checked and box has 'lessthan100' class
                    box.style.display = 'block';
                } else {
                    // Always show the event box if it doesn't have 'lessthan100' class
                    box.style.display = 'block';
                }
            });
        });
    });
</script>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchBox = document.getElementById('searchBox');
        const eventBoxes = document.querySelectorAll('.box');

        searchBox.addEventListener('input', function() {
            const query = searchBox.value.trim().toLowerCase();

            eventBoxes.forEach(function(box) {
                // Get the class of the event box
                const boxClass = box.className.toLowerCase();

                // Check if the class matches the search query
                if (boxClass.includes(query)) {
                    // Show the event box if it matches the search query
                    box.style.display = 'block';
                } else {
                    // Hide the event box if it doesn't match the search query
                    box.style.display = 'none';
                }
            });
        });
    });
</script>

</html>