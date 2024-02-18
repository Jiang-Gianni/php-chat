<?php

include 'views/head.php';
include 'views/login.php';
include 'views/chat.php';
include 'service/cookie.php';
include 'service/room.php';
include 'service/message.php';

$db = new SQLite3('store.db');
if (!$db) {
    die("Connection failed: " . $db->lastErrorMsg());
}

// $rooms =

if (empty(GetJWT())){
    LoginPage();
} else {
    ChatPage($db);
};

?>
