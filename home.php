<?php
require "session.php";
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="styles.css">
<script src="script.js"></script>
<link rel="icon" href="Logo.png" type="image/png">
<title>Home</title>
</head>
<body>
<div class="container">

<br><br>
<?php
include "design.php";
include "loggedin_navbar.php";
?> 

<h3>My Groups</h3>
<?php
include "DBConnection.php"; // include the database connection file

// Get the user ID from the current session
$user_id = $_SESSION['user_id'];

// Select the group names from the giftgroup table
$sql = "SELECT groupname FROM giftgroup WHERE ownerid = $user_id";
$result = mysqli_query($conn, $sql);

// Print the group names
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<h4>";
        echo $row['groupname'] . "</h4><br>";
    }
} else {
    echo "No groups found.";
}

mysqli_close($conn); // close the database connection
?>

<h3>Groups Joined</h3>
<?php
include "DBConnection.php"; // include the database connection file

// Get the user ID from the current session
$user_id = $_SESSION['user_id'];

// Select the group names from the giftgroup table
$sql = "SELECT DISTINCT g.groupname
        FROM giftgroup g
        LEFT JOIN usergroup ug ON g.id = ug.groupid
        LEFT JOIN user u ON ug.userid = u.id
        WHERE u.id = $user_id";
$result = mysqli_query($conn, $sql);

// Print the group names
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<h4>";
        echo $row['groupname'] . "</h4><br>";
    }
} else {
    echo "No groups found.";
}

mysqli_close($conn); // close the database connection
?>

</div>
</body>
</html>