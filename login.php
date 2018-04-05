<?php

  // GET user credentials
  $sUserName = $_GET['username'];
  $sPassword = $_GET['password'];

  // Set the peber variable
  $peber = "vincent";
  $sSetPassword;

  // Sanitize user input
  $sUserName = clean($sUserName);
  $sPassword = clean($sPassword);

  // Open connection to database
  $con = new mysqli("localhost", "root", "root", "websec-login");

  // User credentials shouldn't be empty
  if ($sUserName == "" || $sPassword == "") {
    echo "error";
    exit;
  }

  // SELECT all users where the username matches
  $sql = "SELECT * FROM users WHERE username = '$sUserName'";

  // Run the query
  $result = $con->query($sql);
 
  // If a user wasn't found then close the connection
  if (!$result) {
    die("Error: ". $con->error);
  }

  // If there is a result
  if ($result->num_rows == 1) {
    // Loop through the results
    while($row = $result->fetch_assoc()) {
      // Reset attempts
      $sql = "UPDATE users SET attempts = 0 WHERE username = '$sUserName'";
      // Run the query
      $result = $con->query($sql);
      // Save password in variable
      $sSetPassword = $row["userPass"];
      break;
    }
  } else {
    // Add one attempt
    $sql = "UPDATE users SET attempts = attempts + 1 WHERE username = '$sUserName'";
    // Run the query
    $result = $con->query($sql);
    // Log the failed attempt
    $sql = "INSERT INTO failed_login_attempts (user_name, login_time) VALUES ('$sUserName', now())";
    // Run the query
    $result = $con->query($sql);
    echo "error";
    // Close the connection and exit
    $conn->close();
    exit;
  }
  
  // Check if the password is correct
  $verify = password_verify($sPassword.$peber, $sSetPassword);

  // Send feedback to the client
  if($verify)
    echo "success";
  else {
    echo "error";
  }

  // Function to sanitize user input
  function clean($text) {
    // Remove tags and special characters
    $text = strip_tags($text);
    $text = htmlspecialchars($text, ENT_QUOTES);
    // Return clean text
    return ($text);
  }

?>