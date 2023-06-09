<?php
    session_start();
    include("header.php");
    include("token.php");

    $username = $_POST["username"];
    $password = $_POST["password"];

    // Check SQL database for username and matching password

    $stmt = $mysqli->prepare("SELECT password, id FROM Users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($res->num_rows == 0) {
        // Exit with error for username incorrect back to login page
        header("Location: login_form.php?err=1");
    }

    $row = $res->fetch_assoc();
    if (!password_verify($password, $row['password'])) {
        // Exit with error for incorrect password back to login page
        header("Location: login_form.php?err=1");
    }
    else {
        // Create token for Session and return to homepage
        $_SESSION["token"] = Create_Token($row['id']);
        $_SESSION["user_id"] = $row['id'];

        header("Location: index.php");
    }
?>