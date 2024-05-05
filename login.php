<?php
//given post request data, check (securely!)
//whether or not the username and password match
//what is in the database
$servername = "localhost";
$username = "root";
$password = "";

function redirect_to($location)
{
    header("Location: " . $location);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = [];
    $user['User_email'] = $_POST['email'];


    $user['User_password'] = $_POST['password'];

    $db = mysqli_connect($servername, $username, $password);
    $db_selected = mysqli_select_db($db, 'Event_DB');

    // Test if connection succeeded (recommended)
    if (mysqli_connect_errno()) {
        $msg = "Database connection failed: ";
        $msg .= mysqli_connect_error();
        $msg .= " (" . mysqli_connect_errno() . ")";
        exit($msg);
    }

    //check post data against database

    $sql = "SELECT Password_hash FROM _User WHERE User_email = '" . mysqli_real_escape_string($db, $user['User_email']) . "'";

    $query = mysqli_query($db, $sql);

    if (is_null($query)) {
        //Probably because the email is not in the DB yet
        redirect_to("index.php?error=0");
    } elseif (!$query) {
        redirect_to("index.php?error=2");
    }

    $row = mysqli_fetch_assoc($query);

    if ($row) {
        $hashed_DB_password = $row['Password_hash'];

        //Now we at least know the email is in the DB,
        //Because the select statement returned something.
        //Now we have to check whether the password from
        //the POST request is the same as the stored hash.

        //file_put_contents('password_debug.log', "Hashed DB Password: " . $hashed_DB_password['Password_hash'] . "\n", FILE_APPEND);
        //file_put_contents('password_debug.log', "Hashed Inputted Password: " . $hashed_password . "\n", FILE_APPEND);

        if (password_verify($user['User_password'], $hashed_DB_password)) {
            //Means both the email and password are valid.
            //Go ahead and start session, and redirect to the home page.
            session_start();
            $_SESSION['User_email'] = $user['User_email'];
            redirect_to("home.php");
        } else {
            //password is not valid. Redirect to login page.
            redirect_to("index.php?error=1");
        }
    } else {
        redirect_to("index.php?error=0");
    }
} else {
    echo "improper access to server files";
}
