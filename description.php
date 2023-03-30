<?php
    include("header.php");

    $stmt = $mysqli->prepare("UPDATE Users SET description = ? WHERE username = ?");
    $stmt->bind_param("ss", $_POST["content"], $_POST["user"]);
    $stmt->execute();

    header("Location: profile_page.php?u=".$_POST["user"]);
?>