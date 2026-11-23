<?php
session_start();

?>
<!DOCTYPE HTML>
<html>
<head>
    <h1><u>Login</u></h1>
</head>
<body>
    <form action="processlogin.php" method="post">
        Email address: <input type="email" name="email" required><br>
        Password: <input type="password" name="password" required><br>
        Pupil: <input type="radio" name="pupins" value= "0">
        Instructor: <input type="radio" name="pupins" value= "1">
        <br>
    <input type="submit" value="Login"><br><br>

    </form>

    Don't have an account? Register <a href ="pupils.php" > here</a>.

</body>

<?php
if (isset($_SESSION["incorrect"])){
    echo("Incorrect details. Please try again.");
    unset($_SESSION["incorrect"]);
}
?>
    

