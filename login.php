<?php

    $sUserName = $_GET['username'];
    $sPassword = $_GET['password'];

    $con = new mysqli("localhost", "root", "root", "websec-login");

    if ($sUserName == "" || $sPassword == "" ) {
        exit;
    }

    $sql = "SELECT * FROM users WHERE username = '$sUserName' AND password = '$sPassword'";

    $result = $con->query($sql);
    
    if (!$result) {
        die("Error: ". $con->error);
    }

    if($result->num_rows==1) {
        while($row = $result->fetch_assoc()) {
            if($row['username'] == $sUserName && $row['password'] == $sPassword && $row['attempts'] < 3) {
                $sql = "UPDATE users SET attempts = 0 WHERE username = '$sUserName'";
                $result = $con->query($sql);
                echo "Den er fin";
            }
        }
    } else {
        $sql = "UPDATE users SET attempts = attempts + 1  WHERE username = '$sUserName'";
        $result = $con->query($sql);
        echo "Det går ikke";
    }
    
?>