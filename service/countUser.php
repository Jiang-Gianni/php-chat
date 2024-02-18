<?php
function CountUser($db, $username){
    $query = 'select count(*) as count from user where username = :username;';
    $stmt = $db->prepare($query);
    $stmt->bindValue(':username', $username, SQLITE3_TEXT);
    $result = $stmt->execute();
    $count = $result->fetchArray()['count'];
    $stmt->close();
    return $count;
}
?>