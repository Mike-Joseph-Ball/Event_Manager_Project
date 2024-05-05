<?php
$servername = "localhost";
$username = "root";
$password = "";

$db = mysqli_connect($servername, $username, $password);

session_start();

if (!isset($_SESSION['User_email'])) {
    exit('Invalid session. Log in, or sign up for an account.');
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
        </div>
    </div>

    <main>
        <div class="main-box top">
            <div class="top">
                <div class="box">

                </div>
            </div>

        </div>
    </main>

</body>

</html>