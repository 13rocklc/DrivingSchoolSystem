<?php
session_start();
ini_set('display errors', 1);
error_reporting(E_ALL);

//$_SESSION["loggedin"]=1;
include_once("connection.php");
if (!isset($_SESSION["loggedin"])) {
  header("Location: login.php");
  exit();
}
try {
 $stmt=$conn->prepare("SELECT tblpupils.name, tblpupils.balance, tblpupils.address_line1 as add1, 
 tblpupils.address_line2 as add2, tblpupils.town_city as tc, 
        tblpupils.county, tblpupils.postcode as pstcd, tblpupils.contactNumber as tel, tblpupils.email,
        tblinstructors.name as insName, tblinstructors.instructor_ID as insID 
        FROM tblpupils
        LEFT JOIN tblpupil_instructor ON (tblpupils.pupil_ID = tblpupil_instructor.pupil_ID) 
        LEFT JOIN tblinstructors ON (tblpupil_instructor.instructor_ID = tblinstructors.instructor_ID) 
        WHERE tblpupils.pupil_ID = :pID
        ");
        $stmt->bindParam(":pID", $_SESSION["loggedin"] );
        $stmt->execute();
        $pupil = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $stmt = $conn->prepare("SELECT date, start, end FROM tbllessons
            WHERE pupil_ID = :pID
            AND cancelled = 0
            AND CONCAT(date, ' ', start) >= NOW()
            ORDER BY date, start
            LIMIT 1");
        $stmt->bindParam(":pID", $_SESSION["loggedin"]);
        $stmt->execute();
        $lesson = $stmt->fetch(PDO::FETCH_ASSOC);

}

catch (PDOException $e) {
  echo("error: " . $e->getMessage());

}

?>


<!DOCTYPE html>
<html>
<head>
  <title> My Profile </title>
</head>
<body>
<h1> <?php echo(htmlspecialchars($pupil["name"])); ?> </h1>
<a href='editprofile.php'>Edit profile </a>
<br><br>


Next Lesson:
<?php
if ($lesson) {
  echo(date("l jS F", strtotime($lesson["date"])) . ", ");
  echo(date("H:i", strtotime($lesson["start"])) . " - " . date("H:i", strtotime($lesson["end"])));
} else {
  echo("No upcoming lessons");
}
?>
<br><br>


Instructor:
<?php 
if ($pupil["insName"]) {
  echo(htmlspecialchars($pupil["insName"]));
  echo(" (<a href='instructorprofile.php?id=" . (int)$pupil["insID"] . "'>contact instructor</a>)");
} else {
  echo("Not assigned yet");
}
?><br>

Balance: &pound;<?php echo(number_format($pupil["balance"], 2)); ?> <br>

Address: 
<?php
echo(htmlspecialchars($pupil["add1"]) . ", ");
echo(htmlspecialchars($pupil["add2"]) . ", ");
echo(htmlspecialchars($pupil["tc"]) . ", ");
echo(htmlspecialchars($pupil["county"]) . ", ");
echo(htmlspecialchars($pupil["pstcd"]) . ", ");
?>
<br><br>
<u>Contact me:</u><br>
  Phone number: <?php echo(htmlspecialchars($pupil["tel"])); ?><br>
  Email: <?php echo(htmlspecialchars($pupil["email"])); ?><br>
</body>
</html>







