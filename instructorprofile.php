<?php
session_start();
include_once("connection.php");
ini_set('display errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION["loggedin"])) {
    header("Location: login.php");
    exit();
}

$id = filter_var($_GET["id"] ?? null, FILTER_VALIDATE_INT);
if ($id === false || $id === null) {
    header("Location: myprofile.php");
    exit();
}

try {
    $stmt = $conn->prepare("SELECT name, contactNumber, email
    FROM tblinstructors 
    WHERE instructor_ID = :iID");
$stmt->bindParam(":iID", $id);
$stmt->execute();
$instructor = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt = $conn->prepare("SELECT car_reg, automatic_manual
    FROM tblcars
    WHERE instructor_ID = :iID");
$stmt->bindParam(":iID", $id);
$stmt->execute();
$cars = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

catch(PDOException $e) {
    echo("error: " . $e->getMessage());

}

if (!$instructor) {
    echo("Instructor not found.");
    exit();
}
?>

<!DOCTYPE HTML>
<html>
<head>
    <title>Instructor profile</title>
</head>
<body>
    <h1><?php echo(htmlspecialchars($instructor["name"])); ?> </h1>

<u>Contact:</u> <br>
Phone number: <?php echo(htmlspecialchars($instructor["contactNumber"])); ?> <br>
Email: <?php echo(htmlspecialchars($instructor["email"])); ?> <br><br>

<u>Cars:</u> <br>
<?php
foreach ($cars as $car) {
    echo(htmlspecialchars($car["car_reg"]) . " - ");
    echo($car["automatic_manual"] ? "Automatic" : "Manual");
    echo("<br>");
}
?>

<br><a href = "myprofile.php">Back to my profile</a>
</body>
</html>
