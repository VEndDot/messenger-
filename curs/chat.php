<?php
    include("classes/connectClasses.php");

    session_start();
    if(!isset($_SESSION['site_userid'])){
        header("Location: login.php");
        die;
    }

    if(!isset($_GET['userid'])){
        header("Location: profile.php");
        die;
    }



    $chat_user_id = $_GET['userid'];
    $db = new ConnectDataBase();

    // Получение имени текущего пользователя
    $query = "SELECT first_name FROM users WHERE userid = :userid";
    $params = [':userid' => $_SESSION['site_userid']];
    $current_user_name = $db->readPrepared($query, $params)[0]['first_name'];

    // Получение имени собеседника
    $query = "SELECT first_name FROM users WHERE userid = :userid";
    $params = [':userid' => $chat_user_id];
    $chat_user_name = $db->readPrepared($query, $params)[0]['first_name'];

    // Загрузка сообщений
    $query = "SELECT * FROM messages WHERE (sender_id = :sender_id AND receiver_id = :receiver_id) OR (sender_id = :receiver_id AND receiver_id = :sender_id) ORDER BY created_at ASC";
    $params = [
        ':sender_id' => $_SESSION['site_userid'],
        ':receiver_id' => $chat_user_id
    ];

    $messages = $db->readPrepared($query, $params);

    
    if (isset($_GET['userid'])) {
        $chat_user_id = $_GET['userid'];
    
        // Помечаем сообщения как прочитанные
        $queryMarkAsRead = "UPDATE messages SET is_read = 1 WHERE sender_id = :sender_id AND receiver_id = :receiver_id";
        $paramsMarkAsRead = [
            ':sender_id' => $chat_user_id,
            ':receiver_id' => $_SESSION['site_userid']
        ];
        $db->readPrepared($queryMarkAsRead, $paramsMarkAsRead);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat with <?php echo $chat_user_name; ?></title>
    <link rel="stylesheet" type="text/css" href="./style/chat.css">

</head>
<body>
    <h1 style="text-align: center; color: aliceblue;">Chat with <?php echo $chat_user_name; ?></h1>
    <div id="chat">
        <?php foreach ($messages as $message): ?>
            <?php
                $sender_name = ($message['sender_id'] == $_SESSION['site_userid']) ? $current_user_name : $chat_user_name;
                $messageClass = ($message['sender_id'] == $_SESSION['site_userid']) ? 'sent' : 'received';
            ?>
            <div class="message <?php echo $messageClass; ?>">
                <p><strong><?php echo $sender_name; ?></strong>: <?php echo $message['message']; ?></p>
                <time><?php echo $message['created_at']; ?></time>
            </div>
        <?php endforeach; ?>
    </div>
    <form action="send_message.php" method="POST">
        <input type="hidden" name="receiver_id" value="<?php echo $chat_user_id; ?>">
        <textarea name="message" placeholder="Type your message here" required></textarea>
        <input style="background-color:gold; color: black; font-size: 20px; font-weight: 600;" type="submit" value="Send">
    </form>
    <a href="profile.php">End chat</a>
</body>
</html>
