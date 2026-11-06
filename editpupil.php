<?php
session_start();
include_once("connection.php");

if (!isset($_SESSION["loggedin"])) {
    header("Location:login.php");
    exit();
}

if ($_SESSION["usertype"] == "pupil") {
    $id = $_SESSION["loggedin"];
} else {
    $id = $_GET["id"] ?? 0;
    if ($_SESSION["role"] == 0) {
        $stmt = $conn->prepare("SELECT * FROM tblpupil_instructor WHERE pupil_ID = :pID AND instructor_ID = :iID");
        $stmt->bindParam(":pID", $id);
        $stmt->bindParam(":iID", $_SESSION["loggedin"]);
        $stmt->execute();
        if ($stmt->rowCount() == 0) {
            header("Location: profiles.php");
            exit();
        }
    }
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $stmt = $conn->prepare("UPDATE tblpupils SET name=:name, address_line1=:add1, address_line2=:add2,
                town_city=:tc, county=:county, postcode=:pstcd, contactNumber=:tel, email=:email
                WHERE pupil_ID=:id");
        $stmt->execute([":name" => $_POST["name"], ":add1" => $_POST["address_line1"], ":add2" => $_POST["address_line2"],
                ":tc" => $_POST["town_city"], ":county" => $_POST["county"], ":pstcd" => $_POST["postcode"],
                ":tel" => $_POST["contactNumber"], ":email" => $_POST["email"], ":id" => $id]);

        if ($_SESSION["usertype"] == "instructor") {
            $stmt = $conn->prepare("UPDATE tblpupils SET balance=:balance WHERE pupil_ID=:id");
            $stmt->execute([":balance" => $_POST["balance"], ":id" => $id]);
        }

        if ($_SESSION["usertype"] == "instructor" && $_SESSION["role"] == 1) {
            $stmt = $conn->prepare("UPDATE tblpupil_instructor SET instructor_ID=:iID WHERE pupil_ID=:id");
            $stmt->execute([":iID" => $_POST["instructor_ID"], ":id" => $id]);
        }
        $message = "Changes saved.";
}

$stmt = $conn->prepare("SELECT tblpupil.*, tblpupil_instructor.instructor_ID, tblinstructors.name AS insName
        FROM tblpupils
        LEFT JOIN tblpupil_instructor ON (tblpupils.pupil_ID = tblpupil_instructor.pupil_ID)
        LEFT JOIN tblinstructors ON (tblpupil_instructor.instructorID = tblinstructors.instructor_ID)
        WHERE tblpupils.pupil_ID = :id");
$stmt->bindParam(":id", $id);
$stmt->execute();
$p = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$p) {
    echo("Pupil not found.");
    exit();
}
?>

<!DOCTYPE HTML>
<html>
<head>
    <title>Edit pupil</title>
</head>
<body>
    <?php include("nav.php"); ?>
    <h1><?php echo(htmlspecialchars($p["name"])); ?></h1>
    <?php echo($message); ?>

    <form action="editpupil.php?id=<?php echo((int)$id); ?>" method="post">
        Name: 
        <input type="text" name="name" value="<php echo(htmlspecialchars($p["name"])); ?>" required><br>
        
        Instructor:
        <?php if ($_SESSION["usertype"] == "instructor" && $_SESSION["role"] == 1) { ?>
            <input type="number" name="instructor_ID" value="<?php echo((int)$p["instructor_ID"]); ?>"> (instructor ID)
        <?php } else { echo(htmlspecialchars($p["insName"] ?? "Not assigned")); } ?>
        <br>
        
        Balance:
        <?php if ($_SESSION["usertype"] == "instructor") { ?>
            <input type="number" name="balance" step="0.01" value="<?php echo(htmlspecialchars($p["balance"])); ?>">
        <?php } else { echo("&pound;" . number_format($p["balance"], 2)); } ?>
        <br>

        Address line 1: 
        <input type="text" name="address_line1" value="<?php echo(htmlspecialchars($p["address_line1"])); ?>" required> <br>
        Address line 2: 
        <input type="text" name="address_line2" value="<?php echo(htmlspecialchars($p["address_line2"])); ?>" required> <br>
        Town/city:
        <input type="text" name="town_city" value="<?php echo(htmlspecialchars($p["postcode"])); ?>" required> <br>
        County:
        <input type="text" name="county" value="<?php echo(htmlspecialchars($p["county"])); ?>" required> <br>
        Phone number:
        <input type="text" name="postcode" maxlength="11" value="<?php echo(htmlspecialchars($p["postcode"])); ?>" required> <br>
        Email:
        <input type="email" name="email" value="<?php echo(htmlspecialchars($p["email"])); ?>" required <br>

        </form>
        </body>
        </html>

