<!DOCTYPE HTML>
<html>
<head>
    <h1>Register</h1>
</head>
<body>
    <form action="addpupil.php" method="post">
        Full name: <input type="text" name="name"><br>
        Balance: <input type="number" name="balance"><br>
        Address line 1: <input type="text" name="address_line1"><br>
        Address line 2: <input type="text" name="address_line2"><br>
        Town/city: <input type="text" name="town_city"><br>
        County: <input type="text" name="county"><br>
        Postcode: <input type="text" name="postcode"><br>
        Phone number: <input type="text" name="contactNumber"><br>
        Date of birth: <input type="date" name="DOB"><br>
        Email: <input type="email" name="email"><br>
        Password: <input type="password" name="password"><br>
        Automatic: <input type="radio" name="automatic_manual" value= "1"><br>
        Manual: <input type="radio" name="automatic_manual" value= "0" required><br>
    <input type="submit" value="Create Account"><br><br>

    </form>
    <?php
        include_once("connection.php");    
        $stmt=$conn->prepare("SELECT* FROM tblpupils");
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




