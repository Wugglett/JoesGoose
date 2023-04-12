<?php
    include("header.php");
    
    $delete_comments = $mysqli->prepare("DELETE FROM Comments WHERE run_id = ?");
    $delete_comments->bind_param("i", $_GET['r']);
    $result_1 = $delete_comments->execute();

    $delete_runs = $mysqli->prepare("DELETE FROM Runs WHERE id = ?");
    $delete_runs->bind_param("i", $_GET['r']);
    $result_2 = $delete_runs->execute();

    if (!$result_1 || !$result_2) {
        if ($_GET['l'] == 'a') header("location: admin_page.php?err=2");
        header("Location: profile_page?u=".$_POST['user']."&&err=4");
    }

    if ($_GET['l'] == 'a') header("location: admin_page.php");

    header("location: profile_page.php?u=".$_GET['u']);
?>