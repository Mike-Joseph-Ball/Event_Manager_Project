<?php
//given post request data, check (securely!)
//whether or not the username and password match
//what is in the database
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

    $hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $user['User_password'] = $hashed_password;

    $db = mysqli_connect($servername, $username, $password);

    // Test if connection succeeded (recommended)
    if (mysqli_connect_errno()) {
        $msg = "Database connection failed: ";
        $msg .= mysqli_connect_error();
        $msg .= " (" . mysqli_connect_errno() . ")";
        exit($msg);
    }

    //check post data against database

    $sql = "SELECT Password_hash FROM User WHERE User_email LIMIT 1 = ";

    $query = mysqli_query($db, $sql);

    $hashed_DB_password = mysqli_fetch_assoc($query);

    if (is_null($query)) {
        //Probably because the email is not in the DB yet
        redirect_to("index.php?success=0");
    }

    //Now we at least know the email is in the DB,
    //Because the select statement returned something.
    //Now we have to check whether the password from
    //the POST request is the same as the stored hash.

    if ($user['User_password'] === $hashed_DB_password) {
        //Means both the email and password are valid.
        //Go ahead and start session, and redirect to the home page.
        session_start();
        $_SESSION['User_email'] = $user['User_email'];
    } else {
        //password is not valid. Redirect to login page.
        redirect_to("index.php?success=1");
    }
} else {
    echo "improper access to server files";
}
