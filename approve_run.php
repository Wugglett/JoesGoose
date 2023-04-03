<?php
    include("header.php");

    $run = $_GET["r"];
    $approved = $_GET["y"];

    if($approved == 0) {
        $stmt = $mysqli->prepare("UPDATE runs SET approved = 'YES' WHERE id = ?");
        $stmt->bind_param("i", $run);
        $result = $stmt->execute();
    }
    else {
        $stmt = $mysqli->prepare("UPDATE runs SET approved = 'NO' WHERE id = ?");
        $stmt->bind_param("i", $run);
        $result = $stmt->execute();
    }

    if (!$result) {
        header("Location: approve.php?err=1");
    }

    header("Location: index.php");
?>