<?php

include 'service/login.php';
include 'service/register.php';
include 'service/room.php';
include 'service/cookie.php';

$db = new SQLite3('store.db');
if (!$db) {
    die("Connection failed: " . $db->lastErrorMsg());
}

$action = $_GET["action"];

function LoginRegisterError($text){
    echo '<strong id="error" class="contrast" hx-swap-oob="true">'.$text.'</strong>';
}

switch ($action) {
    case 'login':
        $res = Login($db);
        if (!empty($res["error"])) {
            LoginRegisterError($res["error"]);
            break;
        }
        break;
    case 'register':
        $res = Register($db);
        if (!empty($res["error"])) {
            LoginRegisterError($res["error"]);
            break;
        }
        break;
    case 'logout':
        UnsetJWT();
        header("HX-Redirect: ./index.php");
        break;
    case 'new-room':
        InsertRoom($db);
        break;
    case 'change-room':
        $roomId = $_GET['roomId'];
        header("HX-Redirect: ./index.php?roomId=".$roomId);
        break;
    default:
        break;
}


?>