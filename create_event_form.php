<?php //Find all the venues in the system and display them in a dropdown.
//Find all the universities and display them in the system.

$servername = "localhost";
$username = "root";
$password = "";

$db = mysqli_connect($servername, $username, $password);
$db_selected = mysqli_select_db($db, 'Event_DB');
//Universities cannot be added to. For now we will assume Venues cannot be added to.

//Grab all universities
$sql = 'SELECT * FROM University';
$university_query = mysqli_query($db, $sql);

//Grab all Venues
$sql = 'SELECT Venue_name,Street_address,City,State,Zip FROM Venue';
$venue_query = mysqli_query($db, $sql);
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
            <form action="create_event.php" method="post">
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
                    <input type="text" name="eDesc" id="eDesc" autocomplete="off" required>
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
                    <label for="venues">Choose a venue:</label>
                    <select name="venues" id="venues">
                        <?php while ($row = mysqli_fetch_assoc($venue_query)) {
                        ?>
                            <option value="<?php echo $row["Street_address"] . ',' . $row["City"] . ',' . $row["State"] . ',' . $row["Zip"] ?>"><?php echo $row['Venue_name'] ?> - <?php echo $row['Street_address'] ?> </option>;
                        <?php } ?>
                    </select>
                </div>

                <div class="field input:">
                    <label for="universities">Choose a university:</label>
                    <select name="universities" id="universities">
                        <?php while ($row = mysqli_fetch_assoc($university_query)) {
                        ?>
                            <option value="<?php echo $row["University_id"] ?>"><?php echo $row['University_name'] ?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="field input">
                    <label for="Event_type">Choose Event Type:</label>
                    <select name="Event_type" id="Event_type">
                        <option value="oral presentation">Oral Presentation</option>
                        <option value="poster">Poster</option>
                        <option value="online">Online</option>
                    </select>
                </div>

                <div class="field input">
                    <label for="deadline">Presenter's abstract submission deadline:</label>
                    <input type="date" name="deadline" id="deadline" autocomplete="off" required>
                </div>

                <input type="checkbox" id="published" name="published" value="published">
                <label for="published"> Publish Upon Creation </label>

                <div class="field">
                    <input type="submit" class="btn" name="submit" value="Create Event" required>
                </div>
            </form>
        </div>
    </div>

</body>

</html>