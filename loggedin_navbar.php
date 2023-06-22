<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="container">

<div class="navbar" style="width:1000px">
    <a href="home.php">Home</a>
    <!-- <a href="login.php">Log Out</a> -->
    <a href="newGroup.php">New Group</a>
    <a href="joinGroup.php">Join Group</a>
    <a href="logout.php">Logout</a>    
  </div>
  
  <?php
  if(isset($_SESSION['user_id'])){
    echo "<h3>Logged in</h3>";
  }

  if (isset($_GET['logout'])) {
    // If logout button was pressed, end the session
    session_unset();
    session_destroy();
  }

?>


</div>
</body>
</html>
