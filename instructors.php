

<?php
session_start(); 
$hashedpassword=password_hash($_POST["password"],PASSWORD_DEFAULT);
echo($hashedpassword);
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $_SESSION["name"] = $_POST["name"];
    $_SESSION["contactNumber"] = $_POST["contactNumber"];
    $_SESSION["email"] = $_POST["email"];
    $_SESSION["password"] = $hashedpassword;
    $_SESSION["car_reg"] = $_POST["car_reg"];
    $_SESSION["automatic_manual"] = $_POST["automatic_manual"];
    $_SESSION["manager"] = $_POST["manager"];

    header("Location: instructors2.php");
    exit();
}
?>

<!DOCTYPE HTML>
<html>
<head>
    <h1>Add instructor</h1>
</head>
<body>
    <form action="instructors.php" method="post">
        Full name: <input type="text" name="name"><br>
        Phone number: <input type="text" name="contactNumber"><br>
        Email: <input type="email" name="email"><br>
        Password: <input type="password" name="password"><br>
        Car number plate: <input type="text" name="car_reg"><br>
        Automatic: <input type="radio" name="automatic_manual" value= "1"><br>
        Manual: <input type="radio" name="automatic_manual" value= "0" required><br>
        Manager: <input type="radio" name="manager" value= "1"><br>
        Not manager: <input type="radio" name="manager" value= "0"><br>
    <input type="submit" value="Next"><br><br>

    </form>
    <?php
        include_once("connection.php");    
        $stmt=$conn->prepare("SELECT* FROM tblInstructors");
        $stmt->execute();
        while($row=$stmt->fetch(PDO::FETCH_ASSOC))
        {
            //print_r($row);
            echo($row["name"]);
            echo("<br>");
        }
    ?>

</body>
</html>




