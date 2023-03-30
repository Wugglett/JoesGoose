<?php
    session_start();

    include("header.php");
    include("token.php");

    $username = $_POST["username"];
    $reusername = $_POST["reusername"];
    $password = $_POST["password"];
    $repassword = $_POST["repassword"];

    // Make sure they correctly reentered both username and password
    if ($username != $reusername) {
        // Exit with incorrect username match back to registration page
        header("Location: register_form.php?err=1");
    }
    if (strcmp($password,$repassword) != 0) {
        // Exit with incorrect password match back to registration page
        header("Location: register_form.php?err=2");
    }

    // Check that the username is not already in use
    $stmt = $mysqli->prepare("SELECT * FROM Users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($res->num_rows > 0) {
        // Exit with username already in use back to registration page
        header("Location: register_form.php?err=3");
    }
    else {
        // Confirmation is done, now time to add to database
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $mysqli->prepare("INSERT INTO Users(username, password) VALUES(?,?)");
        $stmt->bind_param("ss", $username, $hashed_password);
        $stmt->execute();

        // Now create token for Session and return to homepage, logging user in
        $_SESSION["token"] = Create_Token($mysqli->insert_id);
        $_SESSION["user_id"] = $mysqli->insert_id;

        header("Location: index.php");
    }
?>