<?php
    session_start();
    include("header.php");

    $run = $_POST["run"];

    if (!isset($_SESSION["user_id"])) header("Location: run_page.php?r=".$run."&u=0");

    $stmt = $mysqli->prepare("INSERT INTO Comments(user_id, run_id, content) VALUES(?,?,?)");
    $stmt->bind_param("iis", $_SESSION["user_id"], $run, $_POST["content"]);
    $stmt->execute();

    header("Location: run_page.php?r=".$run);
?>