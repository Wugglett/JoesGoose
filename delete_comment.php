<?php
    include("header.php");

    $stmt = $mysqli->prepare("DELETE FROM Comments WHERE id = ?");
    $stmt->bind_param("i", $_POST["comment_id"]);
    if (!$stmt->execute()) {
        header("Location: run_page.php?r=".$run."&&err=2");
    }

    header("Location: run_page.php?r=".$_POST["run_id"]);
?>