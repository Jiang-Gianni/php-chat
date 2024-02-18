var conn = new WebSocket('ws://localhost:8080/chat');
for (let i = 0; i < 1000; i++) {
    var msg = "Message" + i + " 👋";
    var payload = '{"message":"' + msg + '","HEADERS":{"HX-Request":"true","HX-Trigger":"random user","HX-Trigger-Name":null,"HX-Target":"random user","HX-Current-URL":"http://localhost:8888/index.php?roomId=1"}}';
    conn.send(payload);
}
