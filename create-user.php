<?php 

	$pass = "1234";

	$option = ["cost"=>10];
	$peber = "vincent";
	$hash = password_hash($pass.$peber, PASSWORD_DEFAULT,$option);

	echo $hash;

	$verify = password_verify($hash.$peber , "$2y$10$5LN/4CjOs18uVoKUT1ddw.7JODU498TP9XabfDmJcfWz1Mkni.qTW");

	echo $verify;

?>