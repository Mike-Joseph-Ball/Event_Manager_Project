<?php
/*
INSERT INTO Sponsor (Sponsor_name) VALUES ("Google");

INSERT INTO Keynote_speaker (First_name,Last_name) VALUES ("Mike","Ball");

INSERT INTO University (University_name) VALUES ("California State University, Fullerton");

INSERT INTO Venue (Venue_name,Max_capacity,Street_address,City,State,Zip) VALUES ("Chicana Vegana","50","113 E Commonwealth Ave","Fullerton","CA","92833");

INSERT INTO Presenter (First_name,Last_name,Presenter_title) VALUES ("Gabriella","Amedu","Marketing Coordinator");

INSERT INTO _User (User_email,Phone_number,Last_name,First_name,Password_hash) VALUES ("michaelball357@gmail.com","714-686-3948","Ball","Mike","123password");
*/

$servername = "localhost";
$username = "root";
$password = "";

$db = mysqli_connect($servername, $username, $password);
$db_selected = mysqli_select_db($db, 'Event_DB');

$sql = 'INSERT INTO Sponsor (Sponsor_name) VALUES ("Google"),("Apple"),("Cisco"),("Willdan"),("WebEx"),("U.S. Navy"),("FBI CyberSecurity Department")';
$query = mysqli_query($db, $sql);
$Sponsor_id = mysqli_insert_id($db);

$sql = 'INSERT INTO Keynote_speaker (First_name,Last_name) VALUES ("Mike","Ball"),("Hokseng","Hun"),("Gabriella","Amedu")';
$query = mysqli_query($db, $sql);
$speaker_id = mysqli_insert_id($db);

$sql = 'INSERT INTO University (University_name) VALUES ("California State University, Fullerton"),("California State University, Long Beach"),("Fullerton College"),("University of California, Irvine")';
$query = mysqli_query($db, $sql);

$sql = 'INSERT INTO Venue (Venue_name,Max_capacity,Street_address,City,State,Zip) VALUES ("Chicana Vegana","500","113 E Commonwealth Ave","Fullerton","CA","92833"),("Nice Burger - Santa Ana","75","1727 17th St","Santa Ana","CA","92705"),("First Christian Church","5","109 E Wilshire Ave","Fullerton","CA","92832")';
$query = mysqli_query($db, $sql);
$venue_id = mysqli_insert_id($db);

$sql = 'INSERT INTO Presenter (First_name,Last_name,Presenter_title) VALUES ("John","Smith","Marketing Coordinator"),("Peter","Parker","Stark Industries Intern"),("Rick","Grimes","King County Sheriff")';
$query = mysqli_query($db, $sql);
$presenter_id = mysqli_insert_id($db);


//Inserting Users is tougher because of password hashing...
$password1 = password_hash('123', PASSWORD_DEFAULT);
$password2 = password_hash('password', PASSWORD_DEFAULT);
$password3 = password_hash('wordpass', PASSWORD_DEFAULT);
$sql = 'INSERT INTO _User (User_email,Phone_number,Last_name,First_name,Password_hash) VALUES ("michaelball357@gmail.com","7146863948","Ball","Mike","' . mysqli_real_escape_string($db, $password1) . '"),("holdbaker2@gmail.com","7147322317","Johnson","Dwayne","' . mysqli_real_escape_string($db, $password2) . '"),("fake-email@gmail.com","80080008999","Fakerton","Faker","' . mysqli_real_escape_string($db, $password3) . '")';
$query = mysqli_query($db, $sql);


//Here is where the real tough part is... It's time to insert some events!

//Need to grab:


//University_id
$sql = 'SELECT University_id FROM University WHERE University_name = "California State University, Fullerton"';
$query = mysqli_query($db, $sql);
$university_id = mysqli_fetch_assoc($query);
$university_id = $university_id['University_id'];

//Also need to make insertions into Sponsored_events, Speaks_on, Presents_on, and enrolled_in
$sql = 'INSERT INTO _Event (User_email,Street_address,City,State,Zip,University_id,Deadline,Event_name,Event_description,Start_date_time,End_date_time,Event_type,Event_published) VALUES ("michaelball357@gmail.com","109 E Wilshire Ave","Fullerton","CA","92832","' . mysqli_real_escape_string($db, $university_id) . '","2024-05-08 12:00:00","Less Popular Presentation","Presentation on the CPSC 332 Final Project","2024-05-08 19:00:00","2024-05-08 21:45:00","oral presentation",1)';
$query = mysqli_query($db, $sql);

$sql = 'INSERT INTO _Event (User_email,Street_address,City,State,Zip,University_id,Deadline,Event_name,Event_description,Start_date_time,End_date_time,Event_type,Event_published) VALUES ("michaelball357@gmail.com","109 E Wilshire Ave","Fullerton","CA","92832","' . mysqli_real_escape_string($db, $university_id) . '","2024-05-08 12:00:00","Presentation but cool","Presentation on the CPSC 332 Final Project","2024-05-08 19:00:00","2024-05-08 21:45:00","oral presentation",1)';
$query = mysqli_query($db, $sql);

$sql = 'INSERT INTO _Event (User_email,Street_address,City,State,Zip,University_id,Deadline,Event_name,Event_description,Start_date_time,End_date_time,Event_type,Event_published) VALUES ("michaelball357@gmail.com","109 E Wilshire Ave","Fullerton","CA","92832","' . mysqli_real_escape_string($db, $university_id) . '","2024-05-08 12:00:00","Work Meeting","Presentation on the CPSC 332 Final Project","2024-05-08 19:00:00","2024-05-08 21:45:00","oral presentation",1)';
$query = mysqli_query($db, $sql);

$sql = 'INSERT INTO _Event (User_email,Street_address,City,State,Zip,University_id,Deadline,Event_name,Event_description,Start_date_time,End_date_time,Event_type,Event_published) VALUES ("michaelball357@gmail.com","109 E Wilshire Ave","Fullerton","CA","92832","' . mysqli_real_escape_string($db, $university_id) . '","2024-05-08 12:00:00","Party at my place","Presentation on the CPSC 332 Final Project","2024-05-08 19:00:00","2024-05-08 21:45:00","oral presentation",1)';
$query = mysqli_query($db, $sql);


$sql = 'INSERT INTO _Event (User_email,Street_address,City,State,Zip,University_id,Deadline,Event_name,Event_description,Start_date_time,End_date_time,Event_type,Event_published) VALUES ("michaelball357@gmail.com","109 E Wilshire Ave","Fullerton","CA","92832","' . mysqli_real_escape_string($db, $university_id) . '","2024-05-08 12:00:00","Party at my place","Presentation on the CPSC 332 Final Project","2024-05-08 19:00:00","2024-05-08 21:45:00","oral presentation",1)';
$query = mysqli_query($db, $sql);

$sql = 'INSERT INTO _Event (User_email,Street_address,City,State,Zip,University_id,Deadline,Event_name,Event_description,Start_date_time,End_date_time,Event_type,Event_published) VALUES ("michaelball357@gmail.com","109 E Wilshire Ave","Fullerton","CA","92832","' . mysqli_real_escape_string($db, $university_id) . '","2024-05-08 12:00:00","Party at your place","Presentation on the CPSC 332 Final Project","2024-05-08 19:00:00","2024-05-08 21:45:00","oral presentation",1)';
$query = mysqli_query($db, $sql);

$sql = 'INSERT INTO _Event (User_email,Street_address,City,State,Zip,University_id,Deadline,Event_name,Event_description,Start_date_time,End_date_time,Event_type,Event_published) VALUES ("michaelball357@gmail.com","109 E Wilshire Ave","Fullerton","CA","92832","' . mysqli_real_escape_string($db, $university_id) . '","2024-05-08 12:00:00","No Party here","Presentation on the CPSC 332 Final Project","2024-05-08 19:00:00","2024-05-08 21:45:00","oral presentation",1)';
$query = mysqli_query($db, $sql);

$sql = 'INSERT INTO _Event (User_email,Street_address,City,State,Zip,University_id,Deadline,Event_name,Event_description,Start_date_time,End_date_time,Event_type,Event_published) VALUES ("michaelball357@gmail.com","109 E Wilshire Ave","Fullerton","CA","92832","' . mysqli_real_escape_string($db, $university_id) . '","2024-05-08 12:00:00","Everyone watch me juggle","Presentation on the CPSC 332 Final Project","2024-05-08 19:00:00","2024-05-08 21:45:00","oral presentation",1)';
$query = mysqli_query($db, $sql);

$sql = 'INSERT INTO _Event (User_email,Street_address,City,State,Zip,University_id,Deadline,Event_name,Event_description,Start_date_time,End_date_time,Event_type,Event_published) VALUES ("michaelball357@gmail.com","109 E Wilshire Ave","Fullerton","CA","92832","' . mysqli_real_escape_string($db, $university_id) . '","2024-05-08 12:00:00","Basketball meetup","Presentation on the CPSC 332 Final Project","2024-05-08 19:00:00","2024-05-08 21:45:00","oral presentation",1)';
$query = mysqli_query($db, $sql);

$sql = 'INSERT INTO _Event (User_email,Street_address,City,State,Zip,University_id,Deadline,Event_name,Event_description,Start_date_time,End_date_time,Event_type,Event_published) VALUES ("michaelball357@gmail.com","109 E Wilshire Ave","Fullerton","CA","92832","' . mysqli_real_escape_string($db, $university_id) . '","2024-05-08 12:00:00","Classy Pool Get Together","Presentation on the CPSC 332 Final Project","2024-05-08 19:00:00","2024-05-08 21:45:00","oral presentation",1)';
$query = mysqli_query($db, $sql);

$sql = 'INSERT INTO _Event (User_email,Street_address,City,State,Zip,University_id,Deadline,Event_name,Event_description,Start_date_time,End_date_time,Event_type,Event_published) VALUES ("michaelball357@gmail.com","113 E Commonwealth Ave","Fullerton","CA","92833","' . mysqli_real_escape_string($db, $university_id) . '","2024-05-08 12:00:00","AEM Presentation","Presentation on the CPSC 332 Final Project","2024-05-08 19:00:00","2024-05-08 21:45:00","oral presentation",1)';
$query = mysqli_query($db, $sql);



if ($query) {
    $event_id = mysqli_insert_id($db);

    //Insert into Sponsored_events
    $sql = 'INSERT INTO Sponsored_events (Sponsor_id,Event_id) VALUES ("' . mysqli_real_escape_string($db, $Sponsor_id) . '","' . mysqli_real_escape_string($db, $event_id) . '")';
    $query = mysqli_query($db, $sql);

    //Insert into Speaks_on
    $sql = 'INSERT INTO Speaks_on (Speaker_id,Event_id) VALUES ("' . mysqli_real_escape_string($db, $speaker_id) . '","' . mysqli_real_escape_string($db, $event_id) . '")';
    $query = mysqli_query($db, $sql);

    //Insert into Presents_on
    $sql = 'INSERT INTO Presents_on (Presenter_id,Event_id) VALUES ("' . mysqli_real_escape_string($db, $presenter_id) . '","' . mysqli_real_escape_string($db, $event_id) . '")';
    $query = mysqli_query($db, $sql);

    //Insert into Enrolled_in
    $sql = 'INSERT INTO Enrolled_in (User_email,Event_id) VALUES ("holdbaker2@gmail.com","' . mysqli_real_escape_string($db, $event_id) . '")';
    $query = mysqli_query($db, $sql);
}

for ($i = 0; $i < 105; $i++) {

    $sql = 'INSERT INTO _User (User_email, Phone_number, Last_name, First_name, Password_hash) VALUES ("' . $i . '@gmail.com", "7146863948", "Ball", "Mike", "' . mysqli_real_escape_string($db, $password1) . '")';
    $query = mysqli_query($db, $sql);

    $sql = 'INSERT INTO Enrolled_in (User_email,Event_id) VALUES ("' . $i . '@gmail.com","' . mysqli_real_escape_string($db, $event_id) . '")';
    $query = mysqli_query($db, $sql);
}



if (!$query) {
    exit('query not executed, some sort of error.');
}

echo "dummy data successfully added";
