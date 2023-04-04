<?php

function Create_Token(int $user_id): string {
    $mysql = new mysqli("localhost", "root", "", "JoesTry");

    $token = "";
    $stmt = $mysql->prepare("SELECT * FROM Tokens WHERE token = ?");
    do {
        $token = substr(bin2hex(random_bytes(250)), 0, 255);
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $res = $stmt->get_result();
    } while($res->num_rows > 0);

    $stmt = $mysql->prepare("INSERT INTO Tokens(token, user_id) VALUES(?,?)");
    $stmt->bind_param("si", $token, $user_id);
    $stmt->execute();

    return $token;
}

function Remove_Token(string $token) {
    $mysql = new mysqli("localhost", "root", "", "JoesTry");

    $stmt = $mysql->prepare("DELETE FROM Tokens WHERE token = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
}

function Validate_Token(string $token): bool {
    $mysql = new mysqli("localhost", "root", "", "JoesTry");

    $stmt = $mysql->prepare("SELECT last_used FROM Tokens WHERE token = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $res = $stmt->get_result();
    $row = $res->fetch_assoc();

    if (!$row) {
        // Token does not exist in database
        return false;
    }

    if (((time() - $row['last_used'])/60) > 60) {
        // Tokens expire after 1 hour and user needs to log back in
        return false;
    }

    return true;
}