<?php

session_start();

if (!isset($_SESSION["loggedin"])){
  header("location: login.php");
  exit();
}

if ($_SESSION["usertype"]!="pupil"){
  header("location: login.php");
  exit();
}

?>

<!DOCTYPE HTML>
<html>
<head>
  <title>My profile</title>
</head>
<body>

  <?php
    include_once("connection.php");
      $nextlesson="No upcoming lessons";
    try{
      $stmt=$conn->prepare("SELECT date,start,end FROM tbllessons
      WHERE pupil_ID=:pID AND cancelled=0 AND CONCAT(date,' ',start)>=NOW()
      ORDER BY date,start LIMIT 1");
      $stmt->bindParam(":pID", $_SESSION["loggedin"]);
      $stmt->execute();
      while($row=$stmt->fetch(PDO::FETCH_ASSOC))
      {
        $nextlesson=date("l jS F",strtotime($row["date"])).", ".date("H:i",strtotime($row["start"]))." - ".date("H:i",strtotime($row["end"]));
      }
    }
    catch(PDOException $e)
    {
      echo("error: " . $e->getMessage());
    }
    try{
      $stmt=$conn->prepare("SELECT tblpupils.*, tblinstructors.name as insName,
      tblinstructors.contactNumber as insTel, tblinstructors.email as insEmail
      FROM tblpupils
      LEFT JOIN tblpupil_instructor ON tblpupils.pupil_ID=tblpupil_instructor.pupil_ID
      LEFT JOIN tblinstructors ON tblpupil_instructor.instructor_ID=tblinstructors.instructor_ID
      WHERE tblpupils.pupil_ID=:pID");
      $stmt->bindParam(":pID", $_SESSION["loggedin"]);
      $stmt->execute();
      while($row=$stmt->fetch(PDO::FETCH_ASSOC))
      {
        echo("<h1>".htmlspecialchars($row["name"])."</h1>");
        echo("Next Lesson: ".$nextlesson."<br><br>");
        if ($row["insName"]){
          echo("Instructor: ".htmlspecialchars($row["insName"])."<br>");
          echo("Instructor phone: ".htmlspecialchars($row["insTel"])."<br>");
          echo("Instructor email: ".htmlspecialchars($row["insEmail"])."<br>");
        }else{
          echo("Instructor: Not assigned yet<br>");
        }
        echo("Balance: £".number_format($row["balance"],2)."<br>");
        echo("Address: ".htmlspecialchars($row["address_line1"]).", ".htmlspecialchars($row["address_line2"]).", ".htmlspecialchars($row["town_city"]).", ".htmlspecialchars($row["county"]).", ".htmlspecialchars($row["postcode"])."<br><br>");
        echo("Contact me:<br>");
        echo("Phone number: ".htmlspecialchars($row["contactNumber"])."<br>");
        echo("Email: ".htmlspecialchars($row["email"])."<br>");
      }
    }
    catch(PDOException $e)
    {
      echo("error: " . $e->getMessage());
    }
    ?>

</body>
</html>

<?php
session_start();
if (!isset($_SESSION["loggedin"])){
  header("location: login.php");
  exit();
}

if ($_SESSION["usertype"]!="pupil"){
  header("location: login.php");
  exit();
}

?>
<!DOCTYPE HTML>
<html>
<head>
  <title>My profile</title>
</head>
<body>
  <?php
  include_once("connection.php");
  $nextlesson="No upcoming lessons";
  try{
    $stmt=$conn->prepare("SELECT date,start,end FROM tbllessons
    WHERE pupil_ID=:pID AND cancelled=0 AND CONCAT(date,' ',start)>=NOW()
    ORDER BY date,start LIMIT 1");
    $stmt->bindParam(":pID", $_SESSION["loggedin"]);
    $stmt->execute();
    while($row=$stmt->fetch(PDO::FETCH_ASSOC))
    {
      $nextlesson=date("l jS F",strtotime($row["date"])).", ".date("H:i",strtotime($row["start"]))." - ".date("H:i",strtotime($row["end"]));
    }
  }
  catch(PDOException $e)
  {
    echo("error: " . $e->getMessage());
  }

try{
  $stmt=$conn->prepare("SELECT tblpupils.*, tblinstructors.name as insName,
  tblinstructors.contactNumber as insTel, tblinstructors.email as insEmail
  FROM tblpupils
  LEFT JOIN tblpupil_instructor ON tblpupils.pupil_ID=tblpupil_instructor.pupil_ID
  LEFT JOIN tblinstructors ON tblpupil_instructor.instructor_ID=tblinstructors.instructor_ID
  WHERE tblpupils.pupil_ID=:pID");
  $stmt->bindParam(":pID", $_SESSION["loggedin"]);
  $stmt->execute();
  
  while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
    echo("<h1>".htmlspecialchars($row["name"])."</h1>");
    echo("Next Lesson: ".$nextlesson."<br><br>");
    if ($row["insName"]){
      echo("Instructor: ".htmlspecialchars($row["insName"])."<br>");
      echo("Instructor phone: ".htmlspecialchars($row["insTel"])."<br>");
      echo("Instructor email: ".htmlspecialchars($row["insEmail"])."<br>");
    }else{
      echo("Instructor: Not assigned yet<br>");
    }
    echo("Balance: £".number_format($row["balance"],2)."<br>");
    echo("Address: ".htmlspecialchars($row["address_line1"]).", ".htmlspecialchars($row["address_line2"]).", ".htmlspecialchars($row["town_city"]).", ".htmlspecialchars($row["county"]).", ".htmlspecialchars($row["postcode"])."<br><br>");
    echo("Contact me:<br>");
    echo("Phone number: ".htmlspecialchars($row["contactNumber"])."<br>");
    echo("Email: ".htmlspecialchars($row["email"])."<br>");
  }
}
catch(PDOException $e){
  echo("error: " . $e->getMessage());
}

?>

</body>
</html>



