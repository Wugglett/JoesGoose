<?php

function Create_Token(int $user_id): string {
    include("header.php");
    $token = "";
    $stmt = $mysqli->prepare("SELECT * FROM Tokens WHERE token = ?");
    do {
        $token = substr(bin2hex(random_bytes(250)), 0, 255);
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $res = $stmt->get_result();
    } while($res->num_rows > 0);

    $stmt = $mysqli->prepare("INSERT INTO Tokens(token, user_id) VALUES(?,?)");
    $stmt->bind_param("si", $token, $user_id);
    $stmt->execute();

    return $token;
}

function Remove_Token(string $token) {
    include("header.php");
    $stmt = $mysqli->prepare("DELETE FROM Tokens WHERE token = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
}