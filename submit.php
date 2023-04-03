<?php
    session_start();
    include("header.php");
    include("token.php");

    if ($_SESSION["token"] == null) {
        // Need to be logged in to submit a run
        header("Location: submit_form.php");
    }

    $link = $_POST["runlink"];
    $runtime = $_POST["runtime"];
    $console = $_POST["console"];
    $runtype = $_POST["runtype"];

    // Runtime is checked for correct input formatting with submit.js

    $time_values = explode(":", $runtime);
    $rt_seconds = $time_values[0]*60*60 + $time_values[1]*60 + $time_values[2];

    $stmt = $mysqli->prepare("INSERT INTO Runs(user_id, console, run_time, date_completed, link, run_type) VALUES(?,?,?,?,?,?)");
    $stmt->bind_param("isisss", $_SESSION["user_id"], $console, $rt_seconds, date("Y-m-d H:i:s"), $link, $runtype);
    if (!$stmt->execute()) {
        header("Location: submit_form.php?err=1");
    }

    header("Location: index.php");
?>