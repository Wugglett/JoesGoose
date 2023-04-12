<?php
    include("header.php");

    $mod_status = $_POST['mod_status'];
    $username = $_POST['username'];

    $stmt = $mysqli->prepare("UPDATE Users SET mod_status = ? WHERE username = ?");
    $stmt->bind_param("ss", $mod_status, $username);
    if (!$stmt->execute()) {
        header("Location: admin_page.php?err=1");
    }

    header("Location: admin_page.php");
?>