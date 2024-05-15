create database IF NOT EXISTS Event_DB;
use Event_DB;

CREATE TABLE IF NOT EXISTS Sponsor (
Sponsor_id int auto_increment primary key,
Sponsor_name VARCHAR(100),
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS Keynote_speaker(
Speaker_id int auto_increment primary key,
First_name VARCHAR(30),
Last_name VARCHAR(30),
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS University(
University_id int auto_increment primary key,
University_name VARCHAR(100),
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS Venue(
Venue_name VARCHAR(100),
Max_capacity int,
Street_address VARCHAR(80),
City VARCHAR(50),
State VARCHAR(20),
Zip VARCHAR(10),
primary key (Street_address,City,State,Zip),
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS Presenter(
Presenter_id int auto_increment primary key,
First_name  VARCHAR(30),
Last_name VARCHAR(30),
Presenter_title VARCHAR(30),
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS _User (
User_email VARCHAR(50) primary key,
Phone_number VARCHAR(10),
Last_name VARCHAR(50),
First_name VARCHAR(50),
Password_hash VARCHAR(100),
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS _Event(
Event_id int auto_increment primary key, # AUTO_INCREMENT Makes it so it just automatically makes unique IDs without the need to insert the id field when creating an event4
User_email VARCHAR(50),
FOREIGN KEY (User_email) REFERENCES _User(User_email),

Street_address VARCHAR(80),
City VARCHAR(50),
State VARCHAR(20),
Zip VARCHAR(10),
FOREIGN KEY (Street_address,City,State,Zip) REFERENCES Venue(Street_address,City,State,Zip),

University_id int,
FOREIGN KEY (University_id) REFERENCES University(University_id),
Deadline date,
Event_name VARCHAR(100),
Event_description VARCHAR(255),
Start_date_time DATETIME,
End_date_time DATETIME,
Event_type VARCHAR(30),
Event_published int,
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS Sponsored_events (
Sponsor_id int,
FOREIGN KEY (Sponsor_id) REFERENCES Sponsor(Sponsor_id),
Event_id int,
FOREIGN KEY (Event_id) REFERENCES _Event(Event_id),
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS Speaks_on (
Speaker_id int,
FOREIGN KEY (Speaker_id) REFERENCES Keynote_speaker(Speaker_id),
Event_id int,
FOREIGN KEY (Event_id) REFERENCES _Event(Event_id),
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS Presents_on (
Presenter_id int,
FOREIGN KEY (Presenter_id) REFERENCES Presenter(Presenter_id),
Event_id int,
FOREIGN KEY (Event_id) REFERENCES _Event(Event_id),
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS Enrolled_in (
User_email VARCHAR(50),
FOREIGN KEY (User_email) REFERENCES _User(User_email),
Event_id int,
FOREIGN KEY (Event_id) REFERENCES _Event(Event_id),
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);