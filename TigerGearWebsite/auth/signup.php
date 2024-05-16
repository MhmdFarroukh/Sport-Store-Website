<?php

    session_start();
    require('../Database/DBController.php');
    // Check if there was a connection error with the database
    if($db->conn->connect_error){
        die("Connection failed: " . $conn->connect_error);
    }
    // Check if the user is already logged in
    if(isset($_SESSION["loggedIN"])){
        exit("success");
    }

    // if (isset($_POST['signup'])) {
        $username = $_POST['username'];
        $pass = $_POST['password'];
        $lname = $_POST['lname'];
        $fname = $_POST['fname'];
       //Hash
        //$hashedPassword = password_hash($pass, PASSWORD_DEFAULT);
        // Escape special characters to prevent SQL injection
        $username = $db->conn->real_escape_string($username);
        $pass = $db->conn->real_escape_string($pass);
        $fname = $db->conn->real_escape_string($fname);
        $lname = $db->conn->real_escape_string($lname);
        
        
        // Check if the username already exists in the database
        $authQuery = "SELECT user_name from user where user_name = '$username'";
        $data = $db->conn->query($authQuery);

        if ($data && $data->num_rows > 0) {
            exit('Username Already Exists');
        }
        // Insert the new user into the database
        $addUserQuery = "INSERT INTO `user` (`user_name`, `first_name`, `last_name`, `password`) VALUES ('$username', '$fname', '$lname', '$pass')";
        $data = $db->conn->query($addUserQuery);
        if($data){
            // Set session variables for the logged-in user
            $_SESSION['loggedIN'] = true;
            $_SESSION['username'] = $username;
            exit("success");
        }
        exit("failed");
    // }
?>
