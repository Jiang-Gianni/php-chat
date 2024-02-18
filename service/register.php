<?php

function Register($db){

    $username = $_POST["username"];
    $password = $_POST["password"];
    $usernameTaken = "username already taken";

    // Check if user exists
    include 'countUser.php';
    $count = CountUser($db, $username);
    if ($count != 0) {
        return array("error" => $usernameTaken);
    }

    // Insert user
    $hash = password_hash($password, PASSWORD_BCRYPT);
    $query = 'insert into user(username, password) values (:username, :password)';
    $stmt = $db->prepare($query);
    $stmt->bindValue(':username', $username, SQLITE3_TEXT);
    $stmt->bindValue(':password', $hash, SQLITE3_TEXT);
    $result = $stmt->execute();
    if (!$result) {
        return array("error" => "insert into failed: " . $db->lastErrorMsg());
    }
    $stmt->close();
    SetJWT($username);
    header("HX-Redirect: ./index.php");
}
?>