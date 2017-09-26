<?php

    $sUserName = $_GET['username'];
    $sPassword = $_GET['password'];

    $peber = "vincent";
    $sSetPassword;

    $sUserName = clean($sUserName);
    $sPassword = clean($sPassword);

    $con = new mysqli("localhost", "root", "root", "websec-login");

    if ($sUserName == "" || $sPassword == "" ) {
        echo "error";
        exit;
    }

    $sql = "SELECT * FROM users WHERE username = '$sUserName'";

    $result = $con->query($sql);
    
    if (!$result) {
        die("Error: ". $con->error);
    }

    if($result->num_rows==1) {

        while($row = $result->fetch_assoc()) {
                $sql = "UPDATE users SET attempts = 0 WHERE username = '$sUserName'";
                $result = $con->query($sql);
                $sSetPassword = $row["userPass"];
                break;
                $conn->close();
        }
    } else {
        $sql = "UPDATE users SET attempts = attempts + 1 WHERE username = '$sUserName'";
        $result = $con->query($sql);
        $sql = "INSERT INTO failed_login_attempts (user_name, login_time) VALUES ('$sUserName', now())";
        $result = $con->query($sql);
        echo "error"; 
        $conn->close();
        exit;
    }
    

    $verify = password_verify($sPassword.$peber, $sSetPassword);

    if($verify)
        echo "success";
    else 
        echo "error";

    function clean($text) {
        //Fjerner tags, hvis de er i inputtet
        $text = strip_tags($text);
        $text = htmlspecialchars($text, ENT_QUOTES);
        //Returner ren tekst
        return ($text);
    }
    
?>