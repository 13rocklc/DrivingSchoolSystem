<?php
// setting up the database
$servername="localhost";
$username="root";
$password="FellowWithout42*";
$conn= new PDO("mysql:host=$servername",$username,$password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql="CREATE DATABASE IF NOT EXISTS drivingschool";
$conn->exec($sql);
$sql="USE drivingschool";
$conn->exec($sql);
echo("DB created successfully<br>");

// create pupils table
$stmt=$conn->prepare("DROP TABLE IF EXISTS tblPupils;
CREATE TABLE tblPupils
(pupil_ID INT(4) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
name VARCHAR(100) NOT NULL,
balance  DECIMAL(4,2) NOT NULL,
address_line1  VARCHAR(100) NOT NULL,
address_line2  VARCHAR(100) NOT NULL,
town/city  VARCHAR(100) NOT NULL,
county  VARCHAR(100) NOT NULL,
postcode  VARCHAR(10) NOT NULL,
contactNumber  INT(11) NOT NULL,
DOB DATE NOT NULL,
email VARCHAR (500) NOT NULL,
password VARCHAR(100) NOT NULL,
automatic_manual BOOLEAN NOT NULL);
");
$stmt->execute();
echo("tblPupils created<br>");




// create instructors table
$stmt=$conn->prepare("DROP TABLE IF EXISTS tblInstructors;
CREATE TABLE tblInstructors
(instructor_ID INT(4) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
name VARCHAR(100) NOT NULL,
contactNumber INT(11) NOT NULL,
email VARCHAR(500) NOT NULL,
manager BOOLEAN NOT NULL,
password VARCHAR(100) NOT NULL,
monday_start TIME,
monday_end TIME,
tuesday_start TIME,
tuesday_end TIME,
wednesday_start TIME,
wednesday_end TIME,
thursday_start TIME,
thursday_end TIME,
friday_start TIME,
friday_end TIME,
saturday_start TIME,
saturday_end TIME,
sunday_start TIME,
sunday_end TIME);
");
$stmt->execute();
echo("tblInstructors created<br>");

// create pupil-instructor table
$stmt=$conn->prepare("DROP TABLE IF EXISTS tblPupil_Instructor;
CREATE TABLE tblPupil_Instructor
(pupil_ID INT(4) NOT NULL,
instructor_ID INT(4) NOT NULL);
");
$stmt->execute();
echo("tblPupil_Instructor created<br>");

// create cars table
$stmt=$conn->prepare("DROP TABLE IF EXISTS tblCars;
CREATE TABLE tblCars
(car_reg VARCHAR(7) PRIMARY KEY,
instructor_ID INT(4) NOT NULL,
automatic_manual BOOLEAN NOT NULL);
");
$stmt->execute();
echo("tblCars created<br>");

// create lessons table
$stmt=$conn->prepare("DROP TABLE IF EXISTS tblLessons;
CREATE TABLE tblLessons
(pupil_ID INT(4) NOT NULL,
instructor_ID INT(4) NOT NULL,
car_reg VARCHAR(7) NOT NULL,
length DECIMAL(2),
date DATE NOT NULL,
start TIME NOT NULL,
end TIME NOT NULL,
accepted BOOLEAN NOT NULL,
done BOOLEAN NOT NULL,
cancelled BOOLEAN NOT NULL);
");
$stmt->execute();
echo("tblLessons created<br>");
?>

