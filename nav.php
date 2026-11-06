
<a href="index.php">Home</a>
<?php if (isset($_SESSION["loggedin"])) { ?>
    <a href="homepage.php">Dashboard</a>
    <?php if ($_SESSION["usertype"] == "pupil") { ?>
        <a href="booklesson.php">Book a lesson</a>
        <a href="editpupil.php">My profile</a>
    <?php } else { ?>
        <a href="mylessons.php">My lessons</a>
        <a href="profiles.php">Profiles</a>
        <a href="editinstructor.php">My profile</a>
    <?php } ?>
    <a href="logout.php">Log out</a>
    <?php } else { ?>
        <a href="login.php">Login</a>
        <a href="pupils.php">Register</a>
    <?php } ?>
    <hr>
