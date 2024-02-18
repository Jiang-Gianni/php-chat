<?php

// Set the cookie for 1 hour
function SetJWT($username){
    $expiration = time() + 3600;

    // TODO JWT
    setcookie('jwt', $username, $expiration);
}

// Clears the cookie
function UnsetJWT(){
    $expiration = time() - 3600;
    setcookie('jwt', "", $expiration);
}

// Returns the username
function GetJWT(){
    // TODO JWT
    return $_COOKIE['jwt'];
}

?>