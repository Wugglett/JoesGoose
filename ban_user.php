<?php
    include("header.php");
    $username = $_GET['u'];

    $stmt->prepare("UPDATE Users SET banned = 'BANNED' WHERE username = ?");
    $stmt->bind_param("s", $username);
    if (!$stmt->execute()) header("Location: admin_page.php?err=3");

    header("Location: admin_page.php");
?>