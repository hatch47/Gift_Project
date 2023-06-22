function matchPassword() {
    var password = document.getElementById("password").value;
    var con_password = document.getElementById("con_password").value;
    if (password != con_password) {
      alert("Passwords do not match!");
      return false;
    }
    return true;
  }
  
  function showMessage() {
    // Show the message
    document.getElementById("message").style.display = "block";
    
    // Prevent the form from submitting
    event.preventDefault();
  }



  


