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
        header("Location: login.html");
    }

    $row = $res->fetch_array();
    if (strcmp($row[0], $password) != 0) {
        // Exit with error for incorrect password back to login page
        header("Location: login.html");
    }
    else {
        // Create token for Session and return to homepage
        $_SESSION["token"] = Create_Token($row[1]);
        $_SESSION["user_id"] = $row[1];

        header("Location: index.php");
    }
?>