<?php
    include("classes/connectClasses.php");
    session_start();

    $db = new ConnectDataBase();
    $queryU = "SELECT * FROM users WHERE userid=:userid";
    $paramsU = [':userid'=>$_SESSION['site_userid']];
    $resultU = $db->readPrepared($queryU, $paramsU);
    $current_user =$resultU[0]; 

    // Получаем список пользователей, которые отправили сообщения текущему пользователю
    $queryMessages = "SELECT DISTINCT sender_id FROM messages WHERE receiver_id = :receiver_id AND is_read = 0";
    $paramsMessages = [':receiver_id' => $_SESSION['site_userid']];
    $senders = $db->readPrepared($queryMessages, $paramsMessages);

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $query = "SELECT * FROM users WHERE url_address=:url_address";
        $params = [':url_address'=>$_POST['url_address']];
        $result = $db->readPrepared($query, $params);

        if($result){
            header("Location: chat.php?userid=" . $result[0]['userid']);
            die;
        }
    }

    if(!isset($_SESSION['site_userid'])){
        header("Location: login.php");
        die;
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PROFILE | <?php echo $current_user['first_name']." ".$current_user['last_name'];?></title>
    <link rel="stylesheet" type="text/css" href="style/profile.css">
</head>
<body>
    <div class="top">
        <a style="float: right;" href="logout.php">LOGOUT</a>
        <a href="userProfile.php"><?php echo $current_user['first_name'];?></a>
        <span class="centered">DEMO 0.1 | CORPORATE MESSENGER</span> 
    </div>
    <br>
    <div class="search">
        <form action="" method="POST">
            <input style="padding-left: 20px; font-size:25px;" type="text" name="url_address" placeholder="search people">
            <input style="background-color:gold; color:black; font-weight: 600;" type="submit" value="search">
        </form>
    </div>
    <div style="padding: 120px; font-size: 20px;">
        <h2 style="color: aliceblue;">New Messages</h2>
        <?php if ($senders): ?>
            <ul>
                <?php foreach ($senders as $sender): ?>
                    <?php
                        $querySender = "SELECT * FROM users WHERE userid = :userid";
                        $paramsSender = [':userid' => $sender['sender_id']];
                        $senderInfo = $db->readPrepared($querySender, $paramsSender)[0];
                    ?>
                    <li>
                        <a href="chat.php?userid=<?php echo $senderInfo['userid']; ?>">
                            <?php echo $senderInfo['first_name'] . " " . $senderInfo['last_name']; ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p style="color: limegreen; font-size: 25px;">No new messages.</p>
        <?php endif; ?>
    </div>
</body>
</html>