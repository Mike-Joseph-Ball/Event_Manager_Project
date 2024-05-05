<?php
function checkForDuplicates($table, $primary_key)
{
    //make connection to db

    $servername = "localhost";
    $username = "root";
    $password = "";

    // Create connection
    $db = mysqli_connect($servername, $username, $password);

    // Check connection
    if (mysqli_connect_errno()) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $primary_keys = ['Sponsor_id','Speaker_id','University_id','Venue_id','Presenter_id','User_email','Event_id'];

    $sql = 'SELECT * {$table} WHERE '
}
