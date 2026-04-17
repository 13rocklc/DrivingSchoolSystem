<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
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
ini_set('display_errors', 1);
error_reporting(E_ALL);
echo("DB created successfully<br>");

// create pupils table
$stmt=$conn->prepare("DROP TABLE IF EXISTS tblPupils;
CREATE TABLE tblPupils
(pupil_ID INT(4) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
name VARCHAR(100) NOT NULL,
balance DECIMAL(5,2) NOT NULL,
address_line1 VARCHAR(100) NOT NULL,
address_line2 VARCHAR(100) NOT NULL,
town_city VARCHAR(100) NOT NULL,
county VARCHAR(100) NOT NULL,
postcode VARCHAR(10) NOT NULL,
contactNumber VARCHAR(11) NOT NULL,
DOB DATE NOT NULL,
email VARCHAR (500) NOT NULL,
password VARCHAR(100) NOT NULL,
automatic_manual BOOLEAN NOT NULL);
");
$stmt->execute();
echo("tblPupils created<br>");


//create hashed password
$hashedpassword=password_hash("password",PASSWORD_DEFAULT);
echo($hashedpassword);

// insert iterative test data
$stmt=$conn->prepare("INSERT INTO tblPupils 
    (pupil_ID,name,balance,address_line1,address_line2,town_city,county,postcode,contactNumber,DOB,email,password,automatic_manual)
    VALUES
    (NULL,'William Joyce',100.00,'27 Cedar Close','Wansford Road','Peterborough','Cambridgeshire','PE8 6S','07123456789','2005-03-27','willj@gmail.com',:password,True),
    (NULL,'Tabitha Gurney',62.50,'5 River Cottages','Station Road','Barnack','Lincolnshire','PE9 3DW','07987654321','2007-10-08','gurney01@gmail.com',:password,False),
    (NULL,'Lila Rock',78.00,'Dryden House','Glapthorn Road','Oundle','Cambridgeshire','PE8 4GH','07112233445','2008-09-01','lilarock@gmail.com',:password,False)
    ");
    
 
$stmt->bindParam(":password", $hashedpassword);
$stmt->execute();

echo("tblPupils ITD inserted<br>");


 // create instructors table
$stmt=$conn->prepare("DROP TABLE IF EXISTS tblInstructors;
CREATE TABLE tblInstructors
(instructor_ID INT(4) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
name VARCHAR(100) NOT NULL,
contactNumber VARCHAR(11) NOT NULL,
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


//create hashed password
$hashedpassword=password_hash("password",PASSWORD_DEFAULT);
echo($hashedpassword);

// insert iterative test data
$stmt=$conn->prepare("INSERT INTO tblInstructors 
    (instructor_ID,name,contactNumber,email,manager,password,monday_start,monday_end,tuesday_start,tuesday_end,wednesday_start,wednesday_end,thursday_start,thursday_end,friday_start,friday_end,saturday_start,saturday_end,sunday_start,sunday_end)
    VALUES
    (NULL,'Jason Leaves','07712345678','jasonL@gmail.com',True,:password,'08:30:00','18:00:00','08:30:00','18:00:00','08:30:00','18:00:00','08:30:00','18:00:00','08:30:00','18:00:00','10:00:00','19:00:00','11:00:00','15:00:00'),
    (NULL,'Peter Smith','07771234567','Smith.peter@gmail.com',False,:password,'09:00:00','20:00:00','09:00:00','20:00:00','09:00:00','20:00:00','09:00:00','20:00:00','09:00:00','20:00:00','09:30:00','18:00:00','10:00:00','15:00:00')
    ");
    

$stmt->bindParam(":password", $hashedpassword);   
$stmt->execute();
echo("tblIntructors ITD inserted<br>");


// create pupil-instructor table
$conn->exec("DROP TABLE IF EXISTS tblPupil_Instructor");
$conn->exec("CREATE TABLE tblPupil_Instructor (
    pupil_ID INT(4) NOT NULL,
    instructor_ID INT(4) NOT NULL)"
);
echo("tblPupil_Instructor created<br>");

// insert iterative test data
$stmt=$conn->prepare("INSERT INTO tblPupil_Instructor
    (pupil_ID,instructor_ID)
    VALUES
    (1,2),
    (2,1),
    (3,1)
    ");
    
    
$stmt->execute();
echo("tblPupil_Intructor ITD inserted<br>");


// create cars table
$stmt=$conn->prepare("DROP TABLE IF EXISTS tblCars;
CREATE TABLE tblCars
(car_reg VARCHAR(7) PRIMARY KEY,
instructor_ID INT(4) NOT NULL,
automatic_manual BOOLEAN NOT NULL);
");
$stmt->execute();
echo("tblCars created<br>");

$stmt=$conn->prepare("INSERT INTO tblCars
    (car_reg,instructor_ID,automatic_manual)
    VALUES
    ('AB12CDE',1,False),
    ('XY45PDO',2,False),
    ('JG67OAS',2,True)
    ");
    
    
$stmt->execute();
echo("tblCars ITD inserted<br>");


// create lessons table
$stmt=$conn->prepare("DROP TABLE IF EXISTS tblLessons;
CREATE TABLE tblLessons
(pupil_ID INT(4) NOT NULL,
instructor_ID INT(4) NOT NULL,
car_reg VARCHAR(7) NOT NULL,
length DECIMAL(3,1),
date DATE NOT NULL,
start TIME NOT NULL,
end TIME NOT NULL,
accepted BOOLEAN DEFAULT False,
done BOOLEAN DEFAULT False,
cancelled BOOLEAN DEFAULT False);
");
$stmt->execute();
echo("tblLessons created<br>");


$stmt=$conn->prepare("INSERT INTO tblLessons
    (pupil_ID,instructor_ID,car_reg,length,date,start,end,accepted,done,cancelled)
    VALUES
    (1,1,'JG67OAS',1,'2026-04-30','09:00:00','10:00:00',DEFAULT,DEFAULT,DEFAULT),
    (2,2,'AB12CDE',2,'2026-04-29','14:30:00','16:30:30',DEFAULT,DEFAULT,DEFAULT),
    (3,2,'AB12CDE',1.5,'2026-05-04','14:00:00','15:30:00',DEFAULT,DEFAULT,DEFAULT)
    ");
    
    
$stmt->execute();
echo("tblLessons ITD inserted<br>");


?>


