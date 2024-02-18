<?php
function ChatPage($db){

    $username = GetJWT();
    $roomId = $_GET['roomId']??"";
    $rooms = GetRooms($db);
    $activeRoom = null;
    $messages = [];
    if ($roomId != "") {
        $messages = GetMessages($db, $roomId);
    }

    ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        Chat
        <?php echo $roomId ?>
    </title>
    <?php CommonImport() ?>
    <style>
        body {
            margin: 0;
            display: flex;
            height: 100vh;
        }

        #side-menu {
            width: 15%;
            background-color: #31a2be;
        }

        #chat-container {
            flex: 1;
            overflow-y: auto;
            padding: 20px;
        }

        .room {
            padding: 0.75rem;
            margin-left: 0.25rem;
            margin-right: 0.25rem;
        }

        .room:hover {
            cursor: pointer;
            background-color: teal;
        }

        .message {
            margin-bottom: 10px;
            border: 1px solid #ddd;
            padding: 10px;
            border-radius: 5px;
        }

        .message .timestamp {
            font-size: 13px;
        }
    </style>
</head>

<body un-cloak>


    <div id="discard"></div>

    <dialog id="new-room">
        <article>
            <hgroup>
                <h1>New Room</h1>
                <h2>Enter a name for the room to chat</h2>
            </hgroup>
            <input type="text" name="room-name" placeholder="Room Name" aria-label="RoomName" required />
            <footer>
                <a href="#cancel" role="button" class="secondary" data-target="new-room"
                    onclick="toggleModal(event)">Cancel</a>
                <a href="#confirm" role="button" data-target="new-room" onclick="toggleModal(event)" hx-post="api.php?action=new-room" hx-target="#new-room-error" hx-include="[name='room-name']"
                    hx-swap="innerHTML">Confirm</a>
            </footer>
        </article>
    </dialog>

    <div id="side-menu" class="text-center">
        <article class="pt-10">
            <strong class="text-yellow">
                <?php echo $username; ?>
            </strong>
        </article>
        <article class="room bg-gray text-black" hx-post="api.php?action=logout">
            Logout
        </article>
        <article class="room bg-white text-black" data-target="new-room" onclick="toggleModal(event)">
            New Room
            <div id="new-room-error"></div>
        </article>
        <?php
        if (count($rooms) > 0) {
            foreach ($rooms as $room) {
                if ($roomId == $room['id']) {
                    $activeRoom = $room;
                    echo '<article class="room bg-blue-900 outline">'.$room['name'].'</article>';
                } else {
                    echo '<article class="room" hx-get="api.php?action=change-room&roomId='.$room['id'].'">'.$room['name'].'
                    </article>';
                }
            }
        }
        ?>
    </div>

    <?php
    if (!empty($activeRoom['id'])&&!empty($activeRoom['name'])) {
        ?>
    <div id="chat-container">
        <h2><?php echo $activeRoom['name'] ?></h2>
        <div id="message-list">
        <?php
        if (!empty($messages) && count($messages) > 0) {
            foreach ($messages as $message) {
                echo MessageDiv($message, $username);
            }
        }
        ?>
            <div id="new-message"></div>
        </div>

        <script>
            document.addEventListener("htmx:wsAfterMessage", function () {
                newMessage = document.getElementById("new-message")
                newMessage.scrollIntoView();
            })
            document.body.addEventListener('htmx:wsAfterMessage', function(evt) {
                document.getElementById("<?php echo $username ?>").reset();
            });
        </script>
        <div hx-ext="ws" ws-connect="ws:localhost:8080/chat">
            <form id="<?php echo $username ?>" ws-send>
                <input name="message" autofocus>
            </input>
            </form>
        </div>
    </div>
        <?php
    }
    ?>


</body>

</html>

    <?php
}


function MessageDiv($message, $username) {
    if ($message['username'] == $username) {
        return '<div class="message justify-start flex items-center bg-cyan-700">
        <span class="timestamp p-1">'.$message['sent_at'].'</span>
    <strong class="username p-1">('.$message['username'].')</strong>'.$message['message'].'</div>';
    }
    else {
        return '<div class="message justify-start flex items-center">
        <span class="timestamp p-1">'.$message['sent_at'].'</span>
    <strong class="username p-1">('.$message['username'].')</strong>'.$message['message'].'</div>';
    }
}

?>