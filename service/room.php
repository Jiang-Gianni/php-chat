<?php
function GetRooms($db){
    $query = 'select id, name from room;';
    $stmt = $db->prepare($query);
    $result = $stmt->execute();
    if (!$result) {
        return array("error" => "get room failed: " . $db->lastErrorMsg());
    }
    $rooms = array();
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $rooms[] = $row;
    }
    $stmt->close();
    return $rooms;
}

function InsertRoom($db){
    $roomName = $_POST['room-name'];
    $query = 'INSERT INTO room(name) VALUES (:roomName) returning id;';
    $stmt = $db->prepare($query);
    $stmt->bindValue(':roomName', $roomName, SQLITE3_TEXT);
    $result = $stmt->execute();
    if (!$result) {
        return array("error" => "Insert room failed: " . $db->lastErrorMsg());
    }
    $id = $db->lastInsertRowID();
    $stmt->close();
    header("HX-Redirect: ./index.php?roomId=".$id);
}
?>