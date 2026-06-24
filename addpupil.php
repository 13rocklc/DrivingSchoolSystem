<?php
include_once("connection.php");

$hashedpassword=password_hash($_POST["password"],PASSWORD_DEFAULT);
echo($hashedpassword);
try{
    $stmt=$conn->prepare("INSERT INTO tblpupils 
    (pupil_ID,name,balance,address_line1,address_line2,town_city,county,postcode,contactNumber,DOB,email,password,automatic_manual)
    VALUES
    (NULL,:name,:balance,:address_line1,:address_line2,:town_city,:county,:postcode,:contactNumber,:DOB,:email,:password,:automatic_manual)
    ");
    $stmt->bindParam(":name", $_POST["name"]);
    $stmt->bindParam(":balance", $_POST["balance"]); // default value?
    $stmt->bindParam(":address_line1", $_POST["address_line1"]);
    $stmt->bindParam(":address_line2", $_POST["address_line2"]);
    $stmt->bindParam(":town_city", $_POST["town_city"]);
    $stmt->bindParam(":county", $_POST["county"]);
    $stmt->bindParam(":postcode", $_POST["postcode"]);
    $stmt->bindParam(":contactNumber", $_POST["contactNumber"]);
    $stmt->bindParam(":DOB", $_POST["DOB"]);
    $stmt->bindParam(":email", $_POST["email"]);
    $stmt->bindParam(":password", $hashedpassword);
    $stmt->bindParam(":automatic_manual", $_POST["automatic_manual"]);
    $stmt->execute();
}
catch(PDOException $e)
{
    echo("error: " . $e->getMessage());
}

?>



