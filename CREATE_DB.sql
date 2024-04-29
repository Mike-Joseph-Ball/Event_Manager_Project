create database Event_DB;
use Event_DB;

CREATE TABLE Sponsor (
Sponsor_id int auto_increment primary key,
Sponsor_name VARCHAR(100)
);

CREATE TABLE Keynote_speaker(
Speaker_id int auto_increment primary key,
First_name VARCHAR(30),
Last_name VARCHAR(30)
);

CREATE TABLE University(
University_id int auto_increment primary key,
University_name VARCHAR(100)
);

CREATE TABLE Venue(
Venue_name VARCHAR(100),
Max_Capacity int,
Street_address VARCHAR(80),
City VARCHAR(50),
State VARCHAR(20),
Zip VARCHAR(10),
constraint Venue_address primary key (Street_address,City,State,Zip)
);

CREATE TABLE Presenter(
Presenter_id int auto_increment primary key,
First_name  VARCHAR(30),
Last_name VARCHAR(30),
Presenter_title VARCHAR(30)
);

CREATE TABLE _User (
User_email VARCHAR(50) primary key,
Phone_number VARCHAR(10),
Last_name VARCHAR(50),
First_name VARCHAR(50),
Password_hash VARCHAR(100)
);

CREATE TABLE _Event(
Event_id int auto_increment primary key, # AUTO_INCREMENT Makes it so it just automatically makes unique IDs without the need to insert the id field when creating an event4
User_email VARCHAR(50),
FOREIGN KEY (User_email) REFERENCES _User(User_email),
Street_address VARCHAR(80), -- Reference the individual columns of the composite key
City VARCHAR(50),
State VARCHAR(20),
Zip VARCHAR(10),
FOREIGN KEY (Street_address, City, State, Zip) REFERENCES Venue(Street_address, City, State, Zip),
University_id int,
FOREIGN KEY (University_id) REFERENCES University(University_id),
Deadline date,
Event_name VARCHAR(100),
Event_description VARCHAR(255),
Start_date_time DATETIME,
End_date_time DATETIME,
Event_type VARCHAR(30)
);

CREATE TABLE Sponsored_events (
FOREIGN KEY (Sponser_id) REFERENCES Sponsor(Sponsor_id),
FOREIGN KEY (Event_id) REFERENCES _Event(Event_id)
);

CREATE TABLE Speaks_on (
FOREIGN KEY (Speaker_id) REFERENCES Keynote_speaker(Speaker_id),
FOREIGN KEY (Event_id) REFERENCES _Event(Event_id)
);

CREATE TABLE Presents_on (
FOREIGN KEY (Presenter_id) REFERENCES Presenter(Presenter_id),
FOREIGN KEY (Event_id) REFERENCES _Event(Event_id)
);



