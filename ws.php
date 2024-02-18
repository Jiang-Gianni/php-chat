<?php
include 'service/message.php';
include 'views/chat.php';
include 'service/cookie.php';

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

    // Make sure composer dependencies have been installed
    require __DIR__ . '/vendor/autoload.php';

/**
 * chat.php
 * Send any incoming messages to all connected clients (except sender)
 */
class MyChat implements MessageComponentInterface {
    protected $clients;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn) {
        $this->clients->attach($conn);
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        $newMsg = NewMessage($msg);
        $html = '
            <div id="new-message" hx-swap-oob="beforebegin">'.MessageDiv($newMsg, "").'</div>
        ';
        foreach ($this->clients as $client) {
            $client->send($html);
        }
    }

    public function onClose(ConnectionInterface $conn) {
        $this->clients->detach($conn);
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        $conn->close();
    }
}

function NewMessage($msg) {

    $db = new SQLite3('store.db');
    if (!$db) {
        die("Connection failed: " . $db->lastErrorMsg());
    }

    $object = json_decode($msg, true);

    $HEADERS = $object['HEADERS'];
    $URL = $HEADERS['HX-Current-URL'];
    $parsedUrl = parse_url($URL);
    parse_str($parsedUrl['query'], $queryParameters);
    $roomId = $queryParameters['roomId'];

    $username = $HEADERS['HX-Target'];
    $message = $object['message'];

    $message = array(
        "roomId" => $roomId,
        "username" => $username,
        "message" => $message,
        "sent_at" => date("Y-m-d H:i:s",time())
    );
    InsertMessage($db, $message);

    return $message;
}

// Run the server application through the WebSocket protocol on port 8080
$app = new Ratchet\App('localhost', 8080);
$app->route('/chat', new MyChat, array('*'));
$app->run();