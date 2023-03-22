<?php
    session_start();
    include("header.php");
    include("token.php");

    if ($_SESSION["token"] == null) {
        // Need to be logged in to submit a run
        header("Location: submit.html");
    }
?>