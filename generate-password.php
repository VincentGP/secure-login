<?php 

  // Set the password
	$pass = "1234";

  // Generate hash
	$option = ["cost" => 10];
	$peber = "vincent";
	$hash = password_hash($pass.$peber, PASSWORD_DEFAULT, $option);

  // Return the hashed password
  // This should be inserted in the database
	echo $hash;

?>