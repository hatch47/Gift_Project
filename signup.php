<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="styles.css">
<script src="script.js"></script>
<title>Sign Up</title>
</head>
<body>
<div class="container">
<br><br>

<?php
include "design.php";
include "logout_navbar.php";
include "DBConnection.php";

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Check if password and confirm password match
  $password = mysqli_real_escape_string($conn, $_POST['password']);
  $con_password = mysqli_real_escape_string($conn, $_POST['con_password']);
  if ($password !== $con_password) {
    echo "Error: Passwords do not match";
    exit();
  }

  // Prepare and bind parameters
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $password = password_hash($password, PASSWORD_DEFAULT);
  $sql = "INSERT INTO user (email, user_pass) VALUES ('$email', '$password')";

  // Execute statement and check for errors
  if ($conn->query($sql) === TRUE) {
    echo "<br>Account Created";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
}

$conn->close();
?>
<br><br>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" onsubmit="return matchPassword();">
  <label class="container">Email:</label>
  <input type="email" name="email" required><br><br>
  <label class="container">Password:</label>
  <input type="password" id="password" name="password" minlength="6" required><br><br>
  <label class="container">Confirm Password:</label>
  <input type="password" id="con_password" name="con_password" minlength="6" required><br><br>
  <input type="submit" value="Sign Up">
</form>


</div>
</body>
</html>