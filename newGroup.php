<?php
require "session.php";
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="styles.css">
<script src="script.js"></script>
<link rel="icon" href="Logo.png" type="image/png">
<title>Create Group</title>
</head>
<body>
<div class="container">

<br><br>
<?php
include "design.php";
include "loggedin_navbar.php";
include "DBConnection.php";

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// Getting user id
$user_id = $_SESSION['user_id'];
// echo "user id = $user_id";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Check if password and confirm password match
  $password = mysqli_real_escape_string($conn, $_POST['password']);
  $con_password = mysqli_real_escape_string($conn, $_POST['con_password']);
  if ($password !== $con_password) {
    echo "Error: Passwords do not match";
    exit();
  }

  // Prepare and bind parameters
  $groupName = mysqli_real_escape_string($conn, $_POST['groupName']);
  $nameForGroup = mysqli_real_escape_string($conn, $_POST['nameForGroup']);
  $password = password_hash($password, PASSWORD_DEFAULT);
  // $sql = "INSERT INTO GiftGroup (OwnerID, GroupName, group_pass) VALUES ('$user_id','$groupName', '$password')";
  

  try {

  // Insert data into GiftGroup table
  $sql = "INSERT INTO GiftGroup (OwnerID, GroupName, group_pass) VALUES ('$user_id','$groupName', '$password')";
  $result = mysqli_query($conn, $sql);

  // Get the ID of the newly inserted row in GiftGroup table
  $group_id = mysqli_insert_id($conn);

  // Insert data into usergroup table using the retrieved group_id
  $sql = "INSERT INTO usergroup (UserID, nameForGroup, GroupID) VALUES ('$user_id', '$nameForGroup', '$group_id')";
  $result = mysqli_query($conn, $sql);


  if ($result) {
    echo "<br>Group Created";
  }
} catch (mysqli_sql_exception $e) {
  if ($e->getCode() == 1062) {
    echo "Group Name Taken, Try a Different Group Name";
  } else {
    echo "Error: " . $e->getMessage();
  }
}


}
$conn->close();
?> 


<h3>Create a New Group</h3>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" onsubmit="return matchPassword();">
  <label class="container">Group Name:</label>
  <input type="text" name="groupName" required><br><br>
  <label class="container">Your Name:</label>
  <input type="text" name="nameForGroup" required><br><br>
  <label class="container">Group Password:</label>
  <input type="password" id="password" name="password" minlength="6" required><br><br>
  <label class="container">Confirm Password:</label>
  <input type="password" id="con_password" name="con_password" minlength="6" required><br><br>
  
  </div>
  <div class="centered">
  <br>
    <input type="radio" id="groupOfPeople" name="numOfPeople" value="groupOfPeople">
    <label for="groupOfPeople">Group of People</label><br>
    <input type="radio" id="onePerson" name="numOfPeople" value="onePerson">
  <label for="onePerson">One Person</label><br>
  </div>
  <br><br>
  <div class="container">
    <input type="submit" value="Create Group">
</div>
</form>



<!-- <div id="message" style="display: none">New Group Created</div> -->


<!-- </div> -->
</body>
</html>
