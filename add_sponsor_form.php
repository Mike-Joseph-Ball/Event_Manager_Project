<?php

$servername = "localhost";
$username = "root";
$password = "";

$db = mysqli_connect($servername, $username, $password);
$db_selected = mysqli_select_db($db, 'Event_DB');

session_start();

if (!isset($_GET['event_id'])) {
    exit('no event id');
}

//Get session user email id to make sure the logged in user has ownership of this event
$sql = 'SELECT User_email FROM _Event WHERE event_id=' . mysqli_real_escape_string($db, $_GET['event_id']);
$query = mysqli_query($db, $sql);
if ($query && mysqli_num_rows($query) > 0) {
    // Fetch the result as an associative array
    $user_email = mysqli_fetch_assoc($query);

    // Make sure $user_email is not null before using it
    if ($user_email) {
        $event_owner_user_email = $user_email['User_email'];
    } else {
        // Handle case where $user_email is null
        echo "No user email found for the given event ID.";
    }
}
if ($_SESSION['User_email'] != $event_owner_user_email) {
    exit('You are not the owner of the event, so you cannot add a sponsor.');
}

$sql = 'SELECT * FROM Sponsor';
$sponsor_query = mysqli_query($db, $sql);
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Login</title>
</head>

<body>
    <div class="container">
        <div class="box form-box">
            <header>Add Sponsor</header>
            <form action="add_sponsor.php?event_id=<?php echo $_GET['event_id'] ?>" method="post">

                <div class="field input:">
                    <label for="sponsor">Choose a Sponsor:</label>
                    <select name="sponsor" id="sponsor">
                        <?php while ($row = mysqli_fetch_assoc($sponsor_query)) {
                        ?>
                            <option value="<?php echo $row["Sponsor_id"] ?>"><?php echo $row['Sponsor_name'] ?> </option>;
                        <?php } ?>
                    </select>
                </div>

                <div class="field">
                    <input type="submit" class="btn" name="submit" value="Add Sponsor" required>
                </div>
            </form>
        </div>
    </div>

</body>