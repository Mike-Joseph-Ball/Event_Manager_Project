<?php
$servername = "localhost";
$username = "root";
$password = "";

function redirect_to($location)
{
    header("Location: ") . $location;
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = [];
    $user['User_email'] = $_POST['email'];
    $user['Phone_number'] = $_POST['pnumber'];
    $user['Last_name'] = $_POST['lname'];
    $user['First_name'] = $_POST['fname'];

    $hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $user['Password_hash'] = $hashed_password;
    $db = mysqli_connect($servername, $username, $password);

    // Test if connection succeeded (recommended)
    if (mysqli_connect_errno()) {
        $msg = "Database connection failed: ";
        $msg .= mysqli_connect_error();
        $msg .= " (" . mysqli_connect_errno() . ")";
        exit($msg);
    }

    $sql = "INSERT INTO _User (Phone_number,Last_name,First_name,Password_hash) VALUES ";
    $sql .= "(";
    $sql .= "'" . mysqli_real_escape_string($db, $user['User_email']) . "',";
    $sql .= "'" . mysqli_real_escape_string($db, $user['Phone_number']) . "',";
    $sql .= "'" . mysqli_real_escape_string($db, $user['Last_name']) . "',";
    $sql .= "'" . mysqli_real_escape_string($db, $user['First_name']) . "',";
    $sql .= "'" . mysqli_real_escape_string($db, $user['Password_hash']) . "'";
    $sql .= ")";

    $result = mysqli_query($db, $sql);

    if (!$result) {
        exit("User Insert Failed!");
    }

    $new_user_email = $user['User_email'];

    //No need to release returned data as returned data was just a boolean.

    //Close database connection
    mysqli_close($db);

    redirect_to('show_user.php?email=' . $new_user_email);

    //Session data is server-side, while cookies are client-side.
    //The session cookie contains the session identifier,
    //which the server (i.e.: PHP) uses to retrieve 
    //the proper session data.

    session_start();
    $_SESSION['User_email'] = $user['User_email'];
}
