<?php
    session_start();

    include("header.php");
    include("token.php");

    $username = $_POST["username"];
    $reusername = $_POST["re-username"];
    $password = $_POST["password"];
    $repassword = $_POST["re-password"];

    // Make sure they correctly reentered both username and password
    if (strcmp($username,$reusername) != 0 || strcmp($password,$repassword) != 0) {
        // Exit with incorrect email/password back to registration page
        header("Location: register.html");
    }

    // Check that the username is not already in use
    $stmt = $mysqli->prepare("SELECT * FROM Users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($res->num_rows > 0) {
        // Exit with username already in use back to registration page
        header("Location: register.html");
    }
    else {
        // Confirmation is done, now time to add to database

        $stmt = $mysqli->prepare("INSERT INTO Users(username, password) VALUES(?,?)");
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();

        // Now create token for Session and return to homepage, logging user in
        $_SESSION["token"] = Create_Token($mysqli->insert_id);
        $_SESSION["user_id"] = $mysqli->insert_id;

        header("Location: index.php");
    }
?>