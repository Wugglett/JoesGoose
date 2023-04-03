<?php
    include("header.php");

    $stmt = $mysqli->prepare("UPDATE Users SET description = ? WHERE username = ?");
    $stmt->bind_param("ss", $_POST["content"], $_POST["user"]);
    if (!$stmt->execute()) {
        header("Location: profile_page?u=".$_POST['user']."&&err=2");
    }

    header("Location: profile_page.php?u=".$_POST['user']);
?>