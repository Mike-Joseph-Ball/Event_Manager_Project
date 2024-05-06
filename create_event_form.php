<?php //Find all the venues in the system and display them in a dropdown.
//Find all the universities and display them in the system.

//Universities cannot be added to. Venues CAN be added to.


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Register</title>
</head>

<body>
    <div class="container">
        <div class="box form-box">
            <header>Create Event</header>
            <form action="create_user.php" method="post">
                <?php //Events need Venue_id, University_id, Deadline date, 
                //Event_name, Event_description, State_date_time, End_date_time, Event_type

                //Do we let them add new universities and venues?
                ?>
                <div class="field input">
                    <label for="eName">Event Name</label>
                    <input type="text" name="eName" id="eName" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="eDesc">Event Description</label>
                    <input type="text" name="Edesc" id="eDesc" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="date">Start Date</label>
                    <input type="date" name="sdate" id="date" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="time">State Time</label>
                    <input type="time" name="stime" id="time" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="date">End Date</label>
                    <input type="date" name="edate" id="date" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="time">End Time</label>
                    <input type="time" name="etime" id="time" autocomplete="off" required>
                </div>

                <div class="field input:">
                    <label for="cars">Choose a venue:</label>
                    <select name="venues" id="venues">

                    </select>
                </div>

                <div class="field">
                    <input type="submit" class="btn" name="submit" value="Create Event" required>
                </div>
            </form>
        </div>
    </div>

</body>

</html>