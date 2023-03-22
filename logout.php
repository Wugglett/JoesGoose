<?php
    session_start();
    include("header.php");
    include("token.php");

    Remove_Token($_SESSION["token"]);
    $_SESSION["token"] = null;
    $_SESSION["user_id"] = null;

    header("Location: index.php");
?>