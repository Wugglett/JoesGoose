<?php
    include("header.php");
    
    $delete_comments = $mysqli->prepare("DELETE FROM Comments WHERE run_id = ?");
    $delete_comments->bind_param("i", $_GET['r']);
    $delete_comments->execute();

    $delete_runs = $mysqli->prepare("DELETE FROM Runs WHERE id = ?");
    $delete_runs->bind_param("i", $_GET['r']);
    $delete_runs->execute();

    header("location: profile_page.php?u=".$_GET['u']);
?>