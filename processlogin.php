<?php
session_start();//to allow session variables
//header("location: index.php");
//print_r($_POST);
array_map("htmlspecialchars", $_POST);//sanitises inputs so no html can be injected
include_once("connection.php");//import equivalent

try{
  if ($_POST["pupins"] == 0){
    $stmt=$conn->prepare("SELECT * from tblpupils WHERE email=:email");
    $stmt->bindParam(":email", $_POST["email"]);
    $stmt->execute(); 
    }

 else if ($_POST["pupins"]  == 1){
    $stmt=$conn->prepare("SELECT * from tblinstructors WHERE email=:email");
    $stmt->bindParam(":email", $_POST["email"]);
    $stmt->execute(); 
    }


    if ($stmt->rowCount() == 0) {
        echo("Invalid email ."); 
    }else{
        #check password ok..
        while($row=$stmt->fetch(PDO::FETCH_ASSOC))
        {
            print_r($row);
            $hashedpassword=$row["password"];
            $attempt=$_POST["password"];

            if (password_verify($attempt,$hashedpassword)){
                echo("password ok");
                $_SESSION["name"]=$row["name"];//session variable - lasts until browser closed
                if ($_POST["pupins"]  == 0){
                    $_SESSION["loggedin"]=$row["pupil_ID"];
                }
                else if ($_POST["pupins"]  == 1){
                    $_SESSION["loggedin"]=$row["instructor_ID"];
                    $_SESSION["role"]=$row["manager"];
                }
            }else{
                $_SESSION["incorrect"] = 1;
                //echo("incorrect password");
            
            session_regenerate_id(true);
            if ($_POST["pupins"] == 0) {
                $_SESSION["loggedin"] = $row["pupil_ID"];
                $_SESSION["usertype"] = "pupil";
            } else {
                $_SESSION["loggedin"] = $row["instructor_ID"];
                $_SESSION["usertype"] = "instructor";
                $_SESSION["role"] = $row["manager"];
            }
                  

            
            }
            header("Location: homepage.php");
        }
    } 
}
catch(PDOException $e)
{
    echo("error: " . $e->getMessage());
}
print_r($_SESSION);


?>