<?php
require "session.php";
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="styles.css">
<script src="script.js"></script>
<link rel="icon" href="Logo.png" type="image/png">
<title>Join Group</title>
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

if (isset($_POST['submit'])) { // check if submit button was pressed
  $groupname = mysqli_real_escape_string($conn, $_POST['groupName']);
  $nameForGroup = mysqli_real_escape_string($conn, $_POST['nameForGroup']);
  $password = $_POST['password'];

  $sql = "SELECT group_pass FROM giftgroup WHERE groupname='$groupname'";
  $result = mysqli_query($conn, $sql);

  if (mysqli_num_rows($result) == 1) { // if groupname exists
      $row = mysqli_fetch_assoc($result);
      $stored_password = $row['group_pass'];

      if (password_verify($password, $stored_password)) { // if password matches
          // echo "it worked";

          $group_sql = "SELECT ID FROM giftgroup WHERE groupname='$groupname'";
          $group_result = mysqli_query($conn, $group_sql);
          if (mysqli_num_rows($group_result) == 1) {
              $group_row = mysqli_fetch_assoc($group_result);
              $group_id = $group_row['ID'];
              $usergroup_sql = "INSERT INTO usergroup (UserID, GroupID, nameForGroup) VALUES ('$user_id', '$group_id', '$nameForGroup')";
              if (mysqli_query($conn, $usergroup_sql)) {
                  echo "Group Joined Successfully";
              } else {
                  echo "Unable to Join Group" . mysqli_error($conn);
              }
          } else {
              echo "Group not Found";
          }

      } else {
          // password is incorrect
          echo "<br>Incorrect password. Please try again.";
      }
  } else {
      // groupname does not exist in database
      echo "<br>Group Name not Found. Please try again.";
  }
}


$conn->close();
?> 

<h3>Join a Group</h3>

<form action="joinGroup.php" method="post">
  <label class="container">Your Name:</label>
  <input type="text" name="nameForGroup" required><br><br>
  <label class="container">Group Name:</label>
  <input type="text" name="groupName" required><br><br>
  <label class="container">Group Password:</label>
  <input type="password" name="password"><br><br>
  <input type="submit" name="submit" value="Join Group">
</form>

<!-- <div id="message" style="display: none">New Group Created</div> -->

</div>
</body>
</html>




<?php
// if (isset($_POST['groupName'])) {
//   $groupName = $_POST['groupName'];
//   $password = $_POST['password'];

//   // Check if the group exists and the password is correct
//   $query = "SELECT *
//   FROM giftgroup g
//   JOIN usergroup ug ON g.ID = ug.groupID
//   JOIN user u ON ug.userID = u.ID
//   WHERE groupName = '$groupName'";
//   $result = mysqli_query($conn, $query);

//   if (mysqli_num_rows($result) == 1) {
//     // Group exists, check if password is correct
//     $row = mysqli_fetch_assoc($result);
//     $stored_password = $row['group_pass'];
//     if (password_verify($password, $stored_password)) {
//       // Password is correct, add user to the group
//       $group_id = $row['ID'];

//       $query = "INSERT INTO usergroup (userID, groupID) VALUES ('$user_id', '$group_id')";
//       if (mysqli_query($conn, $query)) {
//         echo "You have joined the group successfully.";
//       } else {
//         echo "Error: " . $query . "<br>" . mysqli_error($conn);
//       }
//     } else {
//       // Password is incorrect
//       echo "Invalid password.";
//     }
//   } else {
//     // Group does not exist
//     echo "Invalid group name.";
//   }
// }
