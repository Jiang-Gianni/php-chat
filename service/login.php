<?php

function Login($db){

    $username = $_POST["username"];
    $password = $_POST["password"];
    $invalidCredentials = "invalid credentials";

    // Check if user exists
    include 'countUser.php';
    $count = CountUser($db, $username);
    if ($count == 0) {
        return array("error" => $invalidCredentials);
    }

    // Check user's password
    $query = 'select password from user where username = :username;';
    $stmt = $db->prepare($query);
    $stmt->bindValue(':username', $username, SQLITE3_TEXT);
    $result = $stmt->execute();
    $hashPw = $result->fetchArray()['password'];
    if (!password_verify($password, $hashPw)) {
        return array("error" => $invalidCredentials);
    }
    SetJWT($username);
    header("HX-Redirect: ./index.php");
}
?>