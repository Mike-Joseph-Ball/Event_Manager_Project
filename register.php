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
            <header>Sign Up</header>
            <form action="create_user.php" method="post" onsubmit="return validateForm()">

                <div class="field input">
                    <label for="fname">First name</label>
                    <input type="text" name="fname" id="fname" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="lname">Last name</label>
                    <input type="text" name="lname" id="lname" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="pnumber">Phone Number</label>
                    <input type="text" name="pnumber" id="pnumber" autocomplete="off" required>
                </div>


                <div class="field input">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" autocomplete="off" required>
                    <span id="passwordError" style="color: red;"></span>
                </div>

                <div class="field">
                    <input type="submit" class="btn" name="submit" value="Login" required>
                </div>

                <div class="links">
                    Already have an account? <a href="index.php"> Sign In.</a>
                </div>

            </form>

            <script>
                function validateForm() {
                    let password = document.getElementById('password').value;
                    let regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;

                    if (password.length < 8) {
                        document.getElementById('passwordError').innerText = "Password must be at least 8 characters long.";
                        return false;
                    } else if (!regex.test(password)) {
                        document.getElementById('passwordError').innerText = "Password must have at least eight characters long, one upper case, one lower case, one number, and one special character.";
                        return false;
                    } else {
                        document.getElementById('passwordError').innerText = "";
                        return true;
                    }
                }
            </script>

        </div>
    </div>

</body>

</html>