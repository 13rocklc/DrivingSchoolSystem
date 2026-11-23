<?php
session_start();
include_once("connection.php");

try{
    if ($_POST["pupins"]==0){
        $stmt=$conn->prepare("SELECT * FROM tblpupils WHERE email=:email");
    }else{
        $stmt=$conn->prepare("SELECT * FROM tblinstructors WHERE email=:email");
    }
    $stmt->bindParam(":email", $_POST["email"]);
    $stmt->execute();
    
    if ($stmt->rowCount()==0){
        $_SESSION["incorrect"]=1;
        header("location: login.php");
    }else{
        while($row=$stmt->fetch(PDO::FETCH_ASSOC))
        {
            if (password_verify($_POST["password"],$row["password"])){
                unset($_SESSION["incorrect"]);
                $_SESSION["name"]=$row["name"];
                if ($_POST["pupins"]==0){
                    $_SESSION["loggedin"]=$row["pupil_ID"];
                    $_SESSION["usertype"]="pupil";
                    header("location: myprofile.php");
                }else{
                    $_SESSION["loggedin"]=$row["instructor_ID"];
                    $_SESSION["usertype"]="instructor";
                    $_SESSION["role"]=$row["manager"];
                    header("location: instructors.php");
                }
            }else{
                $_SESSION["incorrect"]=1;
                header("location: login.php");
            }

        }

    }

}

catch(PDOException $e)
{
    echo("error: " . $e->getMessage());
}
?>