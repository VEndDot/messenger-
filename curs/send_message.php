<?php
    include("classes/connectClasses.php");

    session_start();

    print_r($_SESSION['site_userid']);
    if(!isset($_SESSION['site_userid'])){
        header("Location: login.php");
        die;
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $sender_id = $_SESSION['site_userid'];
        $receiver_id = $_POST['receiver_id'];
        $message = $_POST['message'];
        
        $db = new ConnectDataBase();
        $query = "INSERT INTO messages (sender_id, receiver_id, message) VALUES (:sender_id, :receiver_id, :message)";
        $params = [
            ':sender_id' => $sender_id,
            ':receiver_id' => $receiver_id,
            ':message' => $message
        ];

        $db->savePrepared($query, $params);
        // После отправки сообщения перенаправляем обратно в чат
        header("Location: chat.php?userid=" . $receiver_id);
        die;
    }
?>