<!DOCTYPE HTML>
<html>
<head>
    <h1>Add instructor</h1>
</head>
<body>
    <form action="addinstructor.php" method="post">
        Monday hours: <input type="time" name="monday_start"> <input type="time" name="monday_end"><br>
        Tuesday hours: <input type="time" name="tuesday_start"> <input type="time" name="tuesday_end"><br>
        Wednesday hours: <input type="time" name="wednesday_start"> <input type="time" name="wednesday_end"><br>
        Thursday hours: <input type="time" name="thursday_start"> <input type="time" name="thursday_end"><br>
        Friday hours: <input type="time" name="friday_start"> <input type="time" name="friday_end"><br>
        Saturday hours: <input type="time" name="saturday_start"> <input type="time" name="saturday_end"><br>
        Sunday hours: <input type="time" name="sunday_start"> <input type="time" name="sunday_end"><br>

    <input type="submit" value="Create Account"><br><br>

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
