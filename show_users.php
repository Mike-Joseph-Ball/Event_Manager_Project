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

    $sql = 'SELECT * FROM _User WHERE User_email <>"' . mysqli_real_escape_string($db, $_GET['email']) . '"';
    $users = mysqli_query($db, $sql);

    //FUNCION TO DETERMINE IF USER MANAGES MORE THAN 10 EVENTS

    function manages_more_than_10($db, $user)
    {
        if (!isset($user['User_email'])) {
            exit('wrong datatype passed to manages_more_than_10');
        }

        $sql = 'SELECT * FROM _Event WHERE User_email="' . $user['User_email'] . '";';
        $query = mysqli_query($db, $sql);
        if (mysqli_num_rows($query) > 10) {
            return true;
        } else {
            return false;
        }
    }

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
        <a href="home.php"><button class="btn">Homepage</button></a>
        <div><input type="checkbox" id="checkbox"> Users with > 10 Events Managed </div>
    </div>



    <main>
        <div class="events-box">
            <p><u><b>Users</b></u></p>
            <?php while ($user = mysqli_fetch_assoc($users)) { ?>
                <script>
                    function redirectToUser(email) {
                        window.location.href = "show_user.php?email=" + email;
                    }
                </script>
                <?php if (manages_more_than_10($db, $user)) { ?>
                    <div class="box" onclick="redirectToUser('<?php echo $user['User_email']; ?>')">
                        <?php echo $user['User_email']; ?>
                    </div>
                <?php } else { ?>
                    <div class="box lessthan10" onclick="redirectToUser('<?php echo $user['User_email']; ?>')">
                        <?php echo $user['User_email']; ?>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>
    </main>
</body>

<script>
    // Get reference to the checkbox and all hidden elements
    const checkbox = document.getElementById('checkbox');
    const hiddenElements = document.querySelectorAll('.lessthan10');

    // Add event listener to the checkbox
    checkbox.addEventListener('change', function() {
        // Check if checkbox is checked
        if (checkbox.checked) {
            // Hide all hidden elements
            hiddenElements.forEach(function(hiddenElement) {
                hiddenElement.style.display = 'none';
            });
        } else {
            // Show all hidden elements
            hiddenElements.forEach(function(hiddenElement) {
                hiddenElement.style.display = 'block';
            });
        }
    });
</script>

</html>