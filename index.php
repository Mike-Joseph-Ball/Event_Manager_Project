<?php
$servername = "localhost";
$username = "root";
$password = "";

// Create connection
$db = mysqli_connect($servername, $username, $password);

// Check connection
if (mysqli_connect_errno()) {
    die("Connection failed: " . mysqli_connect_error());
}

function redirect_to($location)
{
    header("Location: " . $location);
    exit;
}

session_start();

if (isset($_SESSION['User_email'])) {
    redirect_to("home.php");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Login</title>
</head>

<body>
    <div class="container">
        <div class="box form-box">
            <header>Login</header>
            <form action="login.php" method="post">

                <div class="field input">
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email" required>
                </div>

                <div class="field input">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" required>
                </div>

                <div class="field">
                    <input type="submit" class="btn" name="submit" value="Login" required>
                </div>

                <?php if (isset($_GET['error'])) {
                    if ($_GET['error'] === '0') {
                        echo 'Incorrect Email. Please try again.';
                    } elseif ($_GET['error'] === '1') {
                        echo 'Incorrect Password. Please try again.';
                    } elseif ($_GET['error'] === '2') {
                        echo 'fatal Internal DB error';
                    }
                }
                ?>

                <div class="links">
                    Don't have an account? <a href="register.php"> Sign up here.</a>
                </div>

            </form>
        </div>
    </div>

</body>

</html>