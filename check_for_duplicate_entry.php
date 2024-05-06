<?php
function isDuplicate($table, $primary_key_name, $primary_key_value)
{
    //make connection to db
    //$primary_keys = ['Sponsor_id','Speaker_id','University_id','Venue_id','Presenter_id','User_email','Event_id'];
    $servername = "localhost";
    $username = "root";
    $password = "";

    // Create connection
    $db = mysqli_connect($servername, $username, $password);

    // Check connection
    if (mysqli_connect_errno()) {
        die("Connection failed: " . mysqli_connect_error());
    }


    $sql = 'SELECT * {$table} WHERE {$primary_key_name} = {$primary_key_value}';

    $query = mysqli_query($db, $sql);

    if (mysqli_num_rows($query) > 1) {
        exit('too many entries returned. Query must have not been on primary key.');
    } elseif (mysqli_num_rows($query) === 0) {
        return false;
    } elseif (mysqli_num_rows($query) === 1) {
        return true;
    }
}
