<?php
function GetMessages($db, $roomId){
    $query = 'select a.id, a.room_id, a.username, a.message, a.sent_at from (
        select id, room_id, username, message, sent_at from message where room_id = :roomId order by id desc limit 10
    ) A order by A.id asc;';
    $stmt = $db->prepare($query);
    $stmt->bindValue(':roomId', $roomId, SQLITE3_TEXT);
    $result = $stmt->execute();
    if (!$result) {
        return array("error" => "get messages failed: " . $db->lastErrorMsg());
    }
    $mesages = array();
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $messages[] = $row;
    }
    $stmt->close();
    return $messages ?? [];
}

function InsertMessage($db, $message){
    $query = 'insert into message(room_id, username, message, sent_at) values (:roomId, :username, :message, :sent_at);';
    $stmt = $db->prepare($query);
    $stmt->bindValue(':roomId', $message['roomId'], SQLITE3_TEXT);
    $stmt->bindValue(':username', $message['username'], SQLITE3_TEXT);
    $stmt->bindValue(':message', $message['message'], SQLITE3_TEXT);
    $stmt->bindValue(':sent_at', $message['sent_at'], SQLITE3_TEXT);
    $result = $stmt->execute();
    if (!$result) {
        return array("error" => "insert message failed: " . $db->lastErrorMsg());
    }
}
?>