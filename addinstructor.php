<?php
session_start();
include_once("connection.php");


try{
    $stmt=$conn->prepare("INSERT INTO tblInstructors
    (instructor_ID,name,contactNumber,email,password,manager,monday_start,monday_end,tuesday_start,tuesday_end,wednesday_start,wednesday_end,thursday_start,thursday_end,friday_start,friday_end,saturday_start,saturday_end,sunday_start,sunday_end)
    VALUES
    (NULL,:name,:contactNumber,:email,:password,:manager,:monday_start,:monday_end,:tuesday_start,:tuesday_end,:wednesday_start,:wednesday_end,:thursday_start,:thursday_end,:friday_start,:friday_end,:saturday_start,:saturday_end,:sunday_start,:sunday_end)
    ");
    $stmt->bindParam(":name", $_SESSION["name"]);
    $stmt->bindParam(":contactNumber", $_SESSION["contactNumber"]);
    $stmt->bindParam(":email", $_SESSION["email"]);
    $stmt->bindParam(":password", $_SESSION["password"]);
    $stmt->bindParam(":manager", $_SESSION["manager"]);
    $stmt->bindParam(":monday_start", $_POST["monday_start"]);
    $stmt->bindParam(":monday_end", $_POST["monday_end"]);
    $stmt->bindParam(":tuesday_start", $_POST["tuesday_start"]);
    $stmt->bindParam(":tuesday_end", $_POST["tuesday_end"]);
    $stmt->bindParam(":wednesday_start", $_POST["wednesday_start"]);
    $stmt->bindParam(":wednesday_end", $_POST["wednesday_end"]);
    $stmt->bindParam(":thursday_start", $_POST["thursday_start"]);
    $stmt->bindParam(":thursday_end", $_POST["thursday_end"]);
    $stmt->bindParam(":friday_start", $_POST["friday_start"]);
    $stmt->bindParam(":friday_end", $_POST["friday_end"]);
    $stmt->bindParam(":saturday_start", $_POST["saturday_start"]);
    $stmt->bindParam(":saturday_end", $_POST["saturday_end"]);
    $stmt->bindParam(":sunday_start", $_POST["sunday_start"]);
    $stmt->bindParam(":sunday_end", $_POST["sunday_end"]);
    $stmt->execute();

}
catch(PDOException $e)
{
    echo("error: " . $e->getMessage());
}
$instructor_ID = $conn->lastInsertId();
try{
    $stmt=$conn->prepare("INSERT INTO tblCars
    (instructor_ID,car_reg,automatic_manual)
    VALUES
    (:instructor_ID,:car_reg,:automatic_manual)
    ");
    $stmt->bindParam(":instructor_ID", $instructor_ID);
    $stmt->bindParam(":car_reg", $_SESSION["car_reg"]);
    $stmt->bindParam(":automatic_manual", $_SESSION["automatic_manual"]);
    $stmt->execute();
}
catch(PDOException $e)
{
    echo("error: " . $e->getMessage());
}

?>